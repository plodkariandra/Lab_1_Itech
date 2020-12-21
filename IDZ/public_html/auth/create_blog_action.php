<?php
session_start();
require_once 'Blog.php';

$user = get_user_by_secret($_COOKIE['easyblog']);

if (!$user) {
    header('Location: ' . 'login');
    return;
}

$blog_controller = new Blog();
$blog_controller->create($_POST['blog_name'], $_POST['blog_text'], $user);
header('Location: ' . 'home');
return;

function get_user_by_secret($secret)
{
    $secrets = json_decode(file_get_contents('user_secrets.json'), true);
    foreach ($secrets as $secret_id => $secret_info) {
        if ($secret_info[key($secret_info)] == $secret)
            return key($secret_info);
    }
    return null;
}

?>