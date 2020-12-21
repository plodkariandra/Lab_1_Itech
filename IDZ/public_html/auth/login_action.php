<?php
if (isset($_POST) && isset($_POST['email']) && isset($_POST['password'])) {
    session_start();
    $users = json_decode(file_get_contents('users.json'), true);
    $found_user = false;
    foreach ($users as $id => $info) {
        if (key($info) == $_POST['email']) {
            if ($info[key($info)] == md5($_POST['password'])) {
                $secret = md5($_POST['email'] . 'easyblogsecret' . time());
                setcookie('easyblog', $secret);
                $secrets = json_decode(file_get_contents('user_secrets.json'), true);
                $found_secret = false;
                foreach ($secrets as $secret_id => &$secret_info) {
                    if (key($secret_info) == $_POST['email']) {
                        $secret_info = [$_POST['email'] => $secret];
                        $found_secret = true;
                    }
                }
                if (!$found_secret) {
                    $secrets[] = [$_POST['email'] => $secret];
                }

                file_put_contents('user_secrets.json', json_encode($secrets));

                header('Location: ' . 'home');
                return;
            } else {
                $_SESSION['message'] = "<script>alert('Incorrect Password!');</script>";
                header('Location: ' . 'login');
                return;
            }
        }
    }
    $_SESSION['message'] = "<script>alert('User is not registered!');</script>";
    header('Location: ' . 'login');
    return;
}