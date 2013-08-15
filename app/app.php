<?php
require_once __DIR__.'/../vendor/autoload.php';

// -------------------------------------------------- SETUP
$app = new Silex\Application();

// session
$app->register(new Silex\Provider\SessionServiceProvider());

// url
$app['url'] = 'http://w4rh4wk.dyndns.org/ptpl/';

// -------------------------------------------------- DEBUG
// $app['debug'] = true;
// error_reporting(E_ALL);
// ini_set('display_errors', True);

// -------------------------------------------------- TWIG
$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => array(
            __DIR__.'/../tpl',
            __DIR__.'/../data'
        )
    )
);

// -------------------------------------------------- USER
require_once __DIR__.'/User.php';
$app['user'] = new User($app);
$app->mount('/user', User::controller($app));

// -------------------------------------------------- FILEMANAGER
if ($app['user']->isLoggedin()) {
    require_once __DIR__.'/FileManager.php';
    $app->mount('/data', FileManager::controller($app));
}

// -------------------------------------------------- ROUTES
$app->get('/page/{page}', function($page) use ($app) {
    require_once __DIR__.'/Page.php';
    return Page::index($app, $page);
})->assert('page', '.*');

$app->get('/file/{file}', function($file) use ($app) {
    require_once __DIR__.'/File.php';
    return File::index($app, $file);
})->assert('file', '.*');

$app->get('/blog/{blog}', function($blog) use ($app) {
    require_once __DIR__.'/Blog.php';
    return Blog::index($app, $blog);
})->assert('blog', '.*');

$app->get('/gallery/{path}', function($path) use ($app) {
    require_once __DIR__.'/Gallery.php';
    return Gallery::index($app, $path);
})->assert('path', '.*');

// -------------------------------------------------- DEFAULT ROUTE
$app->match('/', function() use ($app) {
    return $app->redirect('page/about.html');
});
