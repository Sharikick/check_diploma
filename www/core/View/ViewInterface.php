<?php

namespace Core\View;

interface ViewInterface
{
    public function render(string $template, array $data = []): void;
    public function component(string $component, bool $repeat): void;
}
