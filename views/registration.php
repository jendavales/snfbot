<body class="text-center">
<form class="form-signin" method="POST">
    <img class="mb-4" src="https://snf.piorecky.cz/assets/img/icons/192.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Registrace</h1>
    <label for="inputEmail" class="sr-only">Emailová adresa</label>
    <input value="<?php echo $registerModel->email ?>" type="email" name="email" id="inputEmail" class="form-control" placeholder="Emailová adresa" required autofocus>
    <label for="inputPassword" class="sr-only">Heslo</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Heslo" required>
    <label for="inputPasswordConfirm" class="sr-only">Potvrdit heslo</label>
    <input type="password" name="passwordConfirm" id="inputPasswordConfirm" class="form-control" placeholder="Heslo znovu" required>
    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Registrovat">
    <hr>
    <a href="<?php echo \core\Application::$app->router->generateUrl('registration') ?>">Přihlášení</a>
    <p class="mt-5 mb-3 text-muted">&copy; 2021 Jenda Válec</p>
</form>
</body>
