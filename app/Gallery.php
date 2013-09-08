<?php

/**
 * This class provides a gallery which uses the files stored in data/gallery.
 * Thumbnails will be created automatically if needed, you only need to place
 * the pictures.
 */
class Gallery {
    public static function index($app, $path) {
        $path = __DIR__.'/../data/gallery/'.$path;
        $path = rtrim($path, '/');

        if (!is_dir($path))
            return $app->sendFile($path);

        require_once __DIR__.'/helper.php';

        // get files
        $files = array();
        $folders = array();
        list_dir($path, $files, $folders);

        // add link
        foreach ($folders as $k => $f)
            $folders[$k]['link'] = str_replace(__DIR__.'/../data/', '', $f['path']);

        // get pictures
        $pics = array();
        foreach ($files as $k => $f) {
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $isThumb = substr(pathinfo($f['name'], PATHINFO_FILENAME), -6) == '_thumb';
            if (!$isThumb && ($ext == 'jpg' || $ext == 'png')) {
                $f['link'] = str_replace(__DIR__.'/../data/', '', $f['path']);
                $pics[] = $f;
            }
        }

        // check for thumbnail
        foreach ($pics as $k => $f) {
            $name = pathinfo($f['name'], PATHINFO_FILENAME);
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $path_thumb = $path.'/'.$name.'_thumb.'.$ext;
            if (!file_exists($path_thumb))
                create_thumbnail($f['path'], $path_thumb, 150);

            $pics[$k]['path_thumb'] = str_replace(__DIR__.'/../data/', '', $path_thumb);
        }

        return $app['twig']->render(
            'gallery.html.twig',
            array(
                'breadcrumb' => breadcrumb(str_replace(__DIR__.'/../data/', '', $path)),
                'folders' => $folders,
                'pics' => $pics
            )
        );
    }
}
