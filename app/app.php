<?php
require_once __DIR__.'/../vendor/autoload.php';

// -------------------------------------------------- SETUP
$app = new Silex\Application();

// session
$app->register(new Silex\Provider\SessionServiceProvider());

// url
$app['url'] = 'http://w4rh4wk.dyndns.org/fm/';

// -------------------------------------------------- DEBUG
$app['debug'] = true;
error_reporting(E_ALL);
ini_set('display_errors', True);

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

// -------------------------------------------------- FILEMANAGER
require_once __DIR__.'/FileManager.php';
$app->mount('/data', FileManager::controller($app));


// -------------------------------------------------- DEFAULT ROUTE
$app->match('/', function() use ($app) {
    return $app->redirect('data/browse');
});
