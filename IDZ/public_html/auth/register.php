<?php
session_start();
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Register Page</title>

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
    <link href="../css/signin.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/circled-e.png" type="image/x-icon">
</head>

<body class="text-center">
<form class="form-signin" method="post" action="register_action">
    <img class="mb-4" src="../img/profile.png" alt="" width="128" height="128">
    <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required
           autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    <label for="repeatPassword" class="sr-only">Repeat Password</label>
    <input type="password" style="margin-bottom: 10px" id="repeatPassword" name="repeat_password"
           class="form-control" placeholder="Repeat Password"
           required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
    <br><br>
    <a class="btn btn btn-secondary tn-block" href="login">Sign in</a>
    <p class="mt-5 mb-3 text-muted">&copy; Easy Blog</p>
</form>
</body>
</html>
