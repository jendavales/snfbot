<div class="text-center">
<form class="form-signin" method="POST">
    <img class="mb-4" src="https://snf.piorecky.cz/assets/img/icons/192.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Registrace</h1>

    <?php
        if (count($registrationForm->errors) > 0) {
            echo '<div class="text-danger mb-2">';
           foreach ($registrationForm->errors as $field) {
               foreach ($field as $message) {
                   echo "$message<br>";
               }
           }
           echo '</div>';
        }
    ?>
    <div class="form-input-grouped">
        <label for="inputEmail" class="sr-only">Emailová adresa</label>
        <input value="<?php echo $registrationForm->email ?>" type="email" name="email" id="inputEmail" class="form-control <?php if(isset($registrationForm->errors['email'])) echo 'is-invalid'?>" placeholder="Emailová adresa" required autofocus>
        <label for="inputPassword" class="sr-only">Heslo</label>
        <input type="password" name="password" id="inputPassword" class="form-control <?php if(isset($registrationForm->errors['passwordConfirm'])) echo 'is-invalid'?>" placeholder="Heslo" required>
        <label for="inputPasswordConfirm" class="sr-only">Potvrdit heslo</label>
        <input type="password" name="passwordConfirm" id="inputPasswordConfirm" class="form-control <?php if(isset($registrationForm->errors['passwordConfirm'])) echo 'is-invalid'?>" placeholder="Heslo znovu" required>
    </div>
    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Registrovat">
    <hr>
    <a href="<?php echo \core\Application::$app->router->generateUrl('login') ?>">Přihlášení</a>
    <p class="mt-5 mb-3 text-muted">&copy; 2021 Jenda Válec</p>
</form>
</div>
