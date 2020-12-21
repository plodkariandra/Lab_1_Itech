<?php
if (isset($_POST) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repeat_password'])) {
    session_start();
    if ($_POST['password'] != $_POST['repeat_password']) {
        $_SESSION['message'] = "<script>alert('Repeat password incorrect');</script>";
        header('Location: ' . 'register');
        return;
    } else {
        $users = json_decode(file_get_contents('users.json'), true);
        foreach ($users as $id => $info) {
            if (key($info) == $_POST['email']) {
                $_SESSION['message'] = "<script>alert('User is already registered!');</script>";
                header('Location: ' . 'register');
                return;
            }
        }
        $users[] = [$_POST['email'] => md5($_POST['password'])];
        $json_new = json_encode($users);
        file_put_contents('users.json', $json_new);
        $_SESSION['message'] = "<script>alert('Successfully registered! Please, login');</script>";
        header('Location: ' . 'login');
        return;
    }
}