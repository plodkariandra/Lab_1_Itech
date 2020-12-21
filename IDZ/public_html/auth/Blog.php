<?php


class Blog
{
    public function create($title, $text, $author)
    {
        $filename = 'blog/' . $author . '.json';
        if (!file_exists($filename)) {
            file_put_contents($filename, '{}');
        }
        $blogs = json_decode(file_get_contents($filename), true);
        $blogs[] = [$title => $text];
        file_put_contents($filename, json_encode($blogs));
    }

    public function get_user_blog($author) {
        $filename = 'blog/' . $author . '.json';
        if (!file_exists($filename)) {
            file_put_contents($filename, '{}');
        }
        return json_decode(file_get_contents($filename), true);
    }
}