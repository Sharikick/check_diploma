<?php
/**
* @var Core\View\ViewInterface $view
*/
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title><?=$title?></title>
        <link rel="stylesheet" href="/assets/css/global.css" />
        <link rel="stylesheet" href="/assets/css/component/header.css" />
    </head>

    <body>
        <?php $view->component("header", false) ?>
        <main>Main</main>
    </body>

</html>
