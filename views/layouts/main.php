<!DOCTYPE html>
<html lang="cs">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&display=swap" rel="stylesheet">
    <link rel="icon" type="image/ico"
          href="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/img/icon.jfif">
    <link rel="stylesheet" href="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/style.css">
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
</head>
<body class="content">
<div class="container">
    <?php foreach (\core\Application::$app->session->getFlashMessages(\core\Session::FLASH_SUCCESS) as $message): ?>
        <div class="alert alert-success">
            <?php echo $message ?>
        </div>
    <?php endforeach; ?>
</div>
{{content}}
</body>
</html>
