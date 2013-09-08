<?php

/**
 * Page is used to output static pages. It looks at the file extension to
 * determine how the page should be rendered. If the given location is a
 * folder, a file listing will be printed.
 * Markdown available, file extension has to be .md therefore.
 */
class Page {
    public static function index($app, $page) {
        $path = __DIR__.'/../data/page/'.$page;
        $path = rtrim($path, '/');

        if (!file_exists($path))
            return $app->abort(404, 'File not found');

        if (is_dir($path)) {
            return self::list_files($app, $path);
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'html') {
                return self::show_page($app, file_get_contents($path));
            } else if ($ext == 'md') {
                require_once __DIR__.'/helper.php';
                return self::show_page($app, md_to_html(file_get_contents($path)));
            } else {
                return $app->sendFile($path);
            }
        }
    }

    private static function show_page($app, $page) {
        return $app['twig']->render(
            'page.html.twig',
            array(
                'page' => $page
            )
        );
    }

    private static function list_files($app, $path) {
        require_once __DIR__.'/helper.php';

        // get dir content
        $files = array();
        $folders = array();
        list_dir($path, $files, $folders);
        $files = array_merge($folders, $files);

        // add link
        foreach ($files as $k => $f)
            $files[$k]['link'] = str_replace(__DIR__.'/../data/', '', $f['path']);

        // render
        return $app['twig']->render(
            'page_filelist.html.twig',
            array(
                'files' => $files,
                'breadcrumb' => breadcrumb(str_replace(__DIR__.'/../data/', '', $path))
            )
        );
    }
}
