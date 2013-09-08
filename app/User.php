<?php

/**
 * This class handles user authentication. Upon login it checks for valid
 * credentials stored inside data/passwd.json. If the login was successful a
 * session cookie is created.
 */
class User {
    private $app;
    private $user;

    public function __construct($app) {
        $this->app = $app;
        $this->user = $app['session']->get('user', false);
    }

    public function is_loggedin() {
        return $this->user !== false;
    }

    public function get_user() {
        return $this->user;
    }

    public function login($user, $pass) {
        // get users
        $users = __DIR__.'/../data/passwd.json';
        $users = json_decode(file_get_contents($users), true);

        // check username
        if (!array_key_exists($user, $users))
            return false;

        // check password
        require_once __DIR__.'/helper.php';
        $hash = generate_hash($pass, $users[$user]['salt']);
        if ($hash !== $users[$user]['hash'])
            return false;

        // set user
        $this->user = array_merge(
            array("user" => $user),
            $users[$user]
        );

        // set cookie
        $this->app['session']->set('user', $this->user);

        return true;
    }

    public function logout() {
        $this->user = false;
        $this->app['session']->remove('user');
    }

    public static function controller($app) {
        $c = $app['controllers_factory'];

        $c->get('/login', function() use ($app) {
            return $app['twig']->render('login.html.twig');
        });

        $c->post('/login', function() use ($app) {
            if ($app['user']->login($_POST['user'], $_POST['pass']))
                return $app->redirect($app['url']);
            else
                return $app->redirect('login');
        });

        $c->get('/logout', function() use ($app) {
            $app['user']->logout();
            return $app->redirect($app['url']);
        });

        return $c;
    }
}
