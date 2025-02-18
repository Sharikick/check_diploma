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
        <link rel="stylesheet" href="/assets/css/register.css" />
    </head>

    <body class="app">
        <?php $view->component("header", false) ?>
        <main class="main">
            <h1 class="title">Регистрация</h1>
            <form class="form" action="/register" method="post" enctype="application/x-www-form-urlencoded">
                <div class="field">
                    <label class="label" for="email">Email:</label>
                    <input class="input" type="email" id="email" name="email"/>
                </div>
                <div class="field">
                    <label class="label" for="password">Пароль:</label>
                    <input class="input" type="password" id="password" name="password"/>
                </div>
                <div class="radio_group">
                    <input checked class="radio" type="radio" id="student" name='role' value="student"/>
                    <label class="radio_block radio_left" for="student">Студент</label>

                    <input class="radio" type="radio" id="teacher" name='role' value="teacher"/>
                    <label class="radio_block radio_right" for="teacher">Учитель</label>
                </div>
                <div class="field">
                    <button class="btn">Зарегистрироваться</button>
                </div>

                <?php if ($session->has("errors")) { ?>
                    <div class="errors">
                        <?php foreach ($session->getFlash("errors") as $error) { ?>
                            <div class="error"><?=$error ?></div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </form>
        </main>

    </body>
</html>
