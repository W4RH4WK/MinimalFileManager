<?php

/**
 * Blog will display blog entries ordered by date.
 * You can use markdown for your entries, just make sure the file extension 
 * is .md.
 */
class Blog {

    public static function index($app, $blog) {
        $path = __DIR__.'/../data/blog';

        $list = self::blog_list($path);

        if ($blog == '') {
            // get first entry
            $blog = $list;
            $blog = current($blog);
            $blog = current($blog);
            $blog = $blog['file'];
        }

        $ext = pathinfo($blog, PATHINFO_EXTENSION);
        if ($ext == 'md') {
            require_once __DIR__.'/helper.php';
            $blog = md_to_html(file_get_contents("$path/$blog"));
        } else {
            $blog = file_get_contents("$path/$blog");
        }

        return $app['twig']->render(
            'blog.html.twig',
            array(
                'blog' => $blog,
                'list' => $list
            )
        );
    }

    private static function blog_list($path) {
        $list = array();
        foreach (scandir($path, true) as $f) {
            if ($f == '.' || $f == '..' || is_dir("$path/$f"))
                continue;

            $year = substr($f, 0, 4);

            $entry = array(
                'name' => str_replace("-", " ", pathinfo(substr($f, 11), PATHINFO_FILENAME)),
                'date' => substr($f, 0, 10),
                'file' => $f,
                'link' => "blog/$f"
            );

            if (isset($list[$year]))
                $list[$year][] = $entry;
            else
                $list[$year] = array($entry);
        }

        return $list;
    }
}
