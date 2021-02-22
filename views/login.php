<div class="text-center w-100">
    <form class="form-signin" method="POST">
        <img class="mb-4" src="https://snf.piorecky.cz/assets/img/icons/192.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">SNF Bot</h1>
        <?php
        if (count($loginForm->errors) > 0) {
            echo '<div class="text-danger mb-2">';
            foreach ($loginForm->errors as $field) {
                foreach ($field as $message) {
                    echo "$message<br>";
                }
            }
            echo '</div>';
        }
        ?>
        <div class="form-input-grouped">
            <label for="inputEmail" class="sr-only">Emailová adresa</label>
            <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Emailová adresa" required
                   autofocus>
            <label for="inputPassword" class="sr-only">Heslo</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Heslo" required>
        </div>
        <input class="btn btn-lg btn-primary btn-block" type="submit" value="Přihlásit">
        <hr>
        <a href="<?php echo \core\Application::$app->router->generateUrl('registration') ?>">Nový účet</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2021 Jenda Válec</p>
    </form>
</div>
