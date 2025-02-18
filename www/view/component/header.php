<?php
/**
* @var Core\View\ViewInterface $view
* @var Core\Session\SessionInterface $session
* @var App\Service\Auth\AuthServiceInterface $auth
*/
?>


<header class="header">
    <nav class="nav">
        <a href="/" class="link">Главная страница</a>
        <?php if($auth->check()) { ?>
            <a href="/check" class="link">Проверка диплома</a>
            <a href="/report" class="link">Отчеты</a>
            <a href="/profile" class="link">Профиль</a>
        <?php } else { ?>
            <a href="/login" class="link">Авторизация</a>
            <a href="/register" class="link">Регистрация</a>
        <?php } ?>
    </nav>
</header>
