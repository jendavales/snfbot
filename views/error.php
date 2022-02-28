<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $GLOBALS['params']['server_subdirectory'] ?>/assets/style.css">
    <title><?= $code === 404 ? 'Stránka nenalezena' : 'Došlo k chybě' ?></title>
    <meta charset="utf-8">
</head>
<body class="error">
<h1><?= $code === 404 ? 'Stránka nenalezena' : 'Došlo k chybě' ?></h1>
<h2><?= $code ?></h2>
<?php if($code === 404): ?>
    <p>Stránka nebyla nalezena. Pokračovat <a href="<?php echo $GLOBALS['params']['server_host'].$GLOBALS['params']['server_subdirectory'] ?>">domů</a></p>
<?php else: ?>
    <p>Něco se pokazilo.</p>
    <p>Zkuste to prosím znovu, nebo nás kontaktujte.</p>
    <p>Pokračovat <a href="<?php echo $GLOBALS['params']['server_host'].$GLOBALS['params']['server_subdirectory'] ?>">domů</a></p>
<?php endif; ?>
</body>
</html>