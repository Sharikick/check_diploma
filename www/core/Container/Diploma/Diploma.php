<?php

namespace Core\Container\Diploma;

use Core\Diploma\Docx;
use Core\Diploma\DocxInterface;
use Core\Diploma\Handler\DocxHandler;
use Core\Diploma\Handler\DocxHandlerInterface;
use Core\Diploma\Parser\Styles\StylesParser;
use Core\Diploma\Parser\Styles\StylesParserInterface;

trait Diploma
{
    private ?DocxInterface $docx = null;
    private ?DocxHandlerInterface $docxHandler = null;

    public function getDocx(): DocxInterface
    {
        if ($this->docx === null) {
            $this->docx = new Docx($this);
        }
        return $this->docx;
    }

    public function getDocxHandler(string $name): DocxHandlerInterface
    {
        $request = $this->getRequest();
        return new DocxHandler($request->getFile($name));
    }

    public function getStylesParser(): StylesParserInterface
    {
        return new StylesParser();
    }
}
