<?php

namespace Core\Diploma;

use Core\Container\ContainerInterface;

class Docx implements DocxInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {

    }

    public function validate(): void
    {
        $stylesParser = $this->container->getStylesParser();
        $docxHandler = $this->container->getDocxHandler("docx");

        $xmls = [
            "document" => $docxHandler->extractXml("word/document.xml"),
            "styles" => $docxHandler->extractXml("word/styles.xml"),
            "settings" =>$docxHandler->extractXml("word/settings.xml")
        ];

        $docxHandler->close();

        $stylesParser->parse($xmls["styles"]);

        dd(array(
            "default" => $stylesParser->getDocDefaults(),
            "styles" => $stylesParser->getStyles(),
            "latentStyles" => $stylesParser->getLatentStyles()
        ));
    }
}
