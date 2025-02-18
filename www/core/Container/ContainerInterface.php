<?php

namespace Core\Container;

use Core\Config\ConfigInterface;

interface ContainerInterface {
    public function getConfig(): ConfigInterface;
}
