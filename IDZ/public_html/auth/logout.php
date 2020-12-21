<?php
session_start();
unset($_COOKIE['easyblog']);
setcookie('easyblog', null, -1, '/');
header('Location: ' . 'login');
return;