<?php
/**
* @var Core\View\ViewInterface $view
* @var Core\Session\SessionInterface $session
*/
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title><?=$title?></title>
        <link rel="stylesheet" href="/assets/css/global.css" />
        <link rel="stylesheet" href="/assets/css/component/header.css" />
        <link rel="stylesheet" href="/assets/css/login.css" />
    </head>

    <body class="app">
        <?php $view->component("header", false) ?>
        <main class="main">
            <?php if($session->has("unauthorized")) { ?>
                <div class="error"><?=$session->getFlash("unauthorized") ?></div>
            <?php } ?>
            <h1 class="title">Авторизация</h1>
            <form class="form" action="/login" method="post" enctype="application/x-www-form-urlencoded">
                <div class="field">
                    <label class="label" for="email">Email:</label>
                    <input class="input" type="email" id="email" name="email"/>
                </div>
                <div class="field">
                    <label class="label" for="password">Пароль:</label>
                    <input class="input" type="password" id="password" name="password"/>
                </div>
                <div class="field">
                    <button class="btn">Войти</button>
                </div>

                <?php if($session->has("errors")) { ?>
                    <div class="errors">
                        <?php foreach($session->getFlash("errors") as $error) { ?>
                            <div class="error"><?=$error ?></div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </form>
        </main>
    </body>

</html>
