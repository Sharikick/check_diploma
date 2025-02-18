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
        <link rel="stylesheet" href="/assets/css/check.css" />
    </head>

    <body class="app">
        <?php $view->component("header", false) ?>
        <main class="main">
            <form class="form" action="/check" method="post" enctype="multipart/form-data">
                <input class="file" type="file" name="docx" accept=".docx" required/>
                <button class="btn" type="submit">Отправить</button>
            </form>
        </main>
    </body>
</html>
