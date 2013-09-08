<?php

/**
 * The File class will be used to create a dynamic file listing based upon
 * files inside the data/files folder.
 */
class File {
    public static function index($app, $file) {
        $path = __DIR__.'/../data/file/'.$file;
        $path = rtrim($path, '/');

        if (is_dir($path)) {
            require_once __DIR__.'/helper.php';

            // get dir content
            $files = array();
            $folders = array();
            list_dir($path, $files, $folders);
            $files = array_merge($folders, $files);

            // add link
            foreach ($files as $k => $v)
                $files[$k]['link'] = str_replace(__DIR__.'/../data/', '', $v['path']);

            // render
            return $app['twig']->render(
                'file.html.twig',
                array(
                    'files' => $files,
                    'path' => str_replace(__DIR__.'/../data/', '', $path),
                    'breadcrumb' => breadcrumb(str_replace(__DIR__.'/../data/', '', $path))
                )
            );
        } else {
            return $app->sendFile($path);
        }
    }
}
