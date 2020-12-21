<?php
session_start();
require_once 'Blog.php';
$user = get_user_by_secret($_COOKIE['easyblog']);

if (!$user) {
    header('Location: ' . 'login');
    return;
}
$blog_controller = new Blog();
$blogs = $blog_controller->get_user_blog($user);

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

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Easyblog</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" href="../img/circled-e.png" type="image/x-icon">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../index">
                Easyblog
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <? echo $user ?>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="logout">
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="text-center">
                    <a href="create_blog" class="btn btn-outline-info"
                       style="margin-bottom: 15px;">Create new blog</a>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Blog</li>
                        </ol>

                        <div class="card-body">
                            <div class="row">
                                <? $id = 0; ?>
                                <? foreach ($blogs as $id => $blog): ?>
                                    <div class="card" style="width: 18rem; margin: 5px">
                                        <div class="card-body">
                                            <h5 class="card-title"><? echo htmlspecialchars(key($blog), ENT_QUOTES, 'UTF-8'); ?></h5>
                                            <p class="card-text"><? echo substr(htmlspecialchars($blog[key($blog)], ENT_QUOTES, 'UTF-8'), 0, 150) . '...'; ?></p>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#blogContent_<? echo $id ?>">
                                                Open full
                                            </button>
                                        </div>
                                    </div>


                                    <!-- Modal -->
                                    <div class="modal fade" id="blogContent_<? echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle"><? echo htmlspecialchars(key($blog), ENT_QUOTES, 'UTF-8'); ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <? echo htmlspecialchars($blog[key($blog)], ENT_QUOTES, 'UTF-8') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? $id++; ?>
                                <? endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>

