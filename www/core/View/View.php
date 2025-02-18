<?php

namespace Core\View;

use Core\Container\ContainerInterface;

class View implements ViewInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function render(string $template, array $data = []): void
    {
        $templatePath = APP_PATH . "/view/page/$template.php";

        if (!file_exists($templatePath)) {
            throw new \RuntimeException("По пути '$templatePath' не найден шаблон");
        }

        extract(array_merge($data, ["view" => $this, "session" => $this->container->getSession()]));

        include_once $templatePath;
    }

    public function component(string $component, bool $repeat): void
    {
        $componentPath = APP_PATH . "/view/component/$component.php";

        if (!file_exists($componentPath)) {
            throw new \Exception("По пути '$componentPath' не найден компонент");
        }

        extract(["view" => $this, "auth" => $this->container->getAuthService()]);

        if ($repeat) {
            include $componentPath;
        } else {
            include_once $componentPath;
        }
    }
}
