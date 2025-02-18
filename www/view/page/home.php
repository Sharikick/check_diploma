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
        <link rel="stylesheet" href="/assets/css/home.css" />
        <link rel="stylesheet" href="/assets/css/component/header.css" />
    </head>
    <body class="app">
        <?php $view->component("header", false) ?>
        <main class="main">
            <h1 class="title">Приложение для проверки дипломных работ</h1>
        </main>
    </body>
</html>
