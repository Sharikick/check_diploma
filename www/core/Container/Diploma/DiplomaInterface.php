<?php

namespace Core\Container\Diploma;

use Core\Diploma\DocxInterface;
use Core\Diploma\Handler\DocxHandlerInterface;
use Core\Diploma\Parser\Styles\StylesParserInterface;

interface DiplomaInterface
{
    public function getDocx(): DocxInterface;
    public function getDocxHandler(string $name): DocxHandlerInterface;
    public function getStylesParser(): StylesParserInterface;
}
