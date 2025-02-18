<?php

namespace Core\Http\Redirect;

class Redirect {
    public static function to(string $uri): void
    {
        header("Location: $uri");
        exit;
    }
}
