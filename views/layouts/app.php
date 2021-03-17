<!DOCTYPE html>
<html lang="cs">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
            crossorigin="anonymous"></script>
    <link rel="icon" type="image/ico"
          href="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/img/icon.jfif">
    <link rel="stylesheet" href="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/style.css">
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
</head>
<body>
<nav class="navbar navbar-expand navbar-light navbar-bg shadow bg-white">
    <a href="#" class="navbar-brand">
        <img class="mb-1 mr-1" src="https://snf.piorecky.cz/assets/img/icons/192.png" alt="" width="48" height="48">
        SNF Bot
    </a>

    <ul class="navbar-nav align-items-center ml-auto">
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><span
                        class="text-dark"><?php echo $user->email ?></span></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="pages-profile.html"><i class="far fa-user mr-2"></i>Účet</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo \core\Application::$app->router->generateUrl('logout') ?>"><i
                            class="fas fa-sign-out-alt mr-2"></i>Odhlásit</a>
            </div>
        </li>
    </ul>
</nav>
{{content}}
</body>
<script src="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/params.js"></script>
<script src="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/api.js"></script>
<script src="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/router/compiledRoutes.js"></script>
<script src="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/router/route.js"></script>
<script src="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/router/router.js"></script>
<script src="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/pause.js"></script>
</html>
