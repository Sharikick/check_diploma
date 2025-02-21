<?php

namespace Core\Diploma\Parser\Document;

use XMLReader;

class DocumentParser implements DocumentParserInterface
{
    private array $document;

    private function initialize(): void
    {
        $this->document = [];
    }

    public function parse(string $xmlContent): void
    {
        $this->initialize();
        $reader = new XMLReader();
        $reader->XML($xmlContent);

        while ($reader->read()) {
            if ($reader->nodeType === XMLReader::ELEMENT) {
                switch ($reader->name) {
                    case "w:p":
                        $this->parseParagraph($reader);
                        break;
                }
            }
        }
    }

    private function parseParagraph(XMLReader $reader): void
    {
        while ($reader->read()) {
            if ($reader->nodeType === XMLReader::END_ELEMENT && $reader->name === "w:p") {
                break;
            }

            if ($reader->nodeType === XMLReader::ELEMENT) {
                switch ($reader->name) {
                    case "w:pPr":

                        break;
                    case "w:r":
                        break;
                }
            }
        }
    }

    /**
     * Парсит тег `<w:pPr>` (свойства абзацев).
     *
     * @param XMLReader $reader Экземпляр XMLReader, позиционированный на начало тега `<w:pPr>`.
     *
     * @return array Массив, содержащий свойства абзацев:
     *      - 'alignment': Выравнивание текста.
     *      - 'lineSpacing': Межстрочный интервал (значение атрибута `w:line`).
     */
    private function parseParagraphProperties(XMLReader $reader): array
    {
        $properties = [];

        while ($reader->read()) {
            if ($reader->nodeType === XMLReader::END_ELEMENT && $reader->name === "w:pPr") {
                break;
            }

            if ($reader->nodeType === XMLReader::ELEMENT) {
                switch ($reader->name) {
                    case "w:jc":
                        $properties['alignment'] = $reader->getAttribute("w:val");
                        break;

                    case "w:spacing":
                        $properties['lineSpacing'] = $this->parseSpacing($reader);
                        break;
                }
            }
        }

        return $properties;
    }

    /**
     * Парсит тег `<w:spacing>`
     *
     * @param XMLReader $reader Экземпляр XMLReader, позиционированный на начало тега `<w:spacing>`
     *
     * @return array Массив, содержащий интервалы:
     *      - 'line': Межстрочный интервал.
     *      - 'lineRule': Правило, которое говорит, как хранится значение в w:line.
     *      - 'before': Интервал перед абзацем.
     *      - 'after': Интервал после абзаца.
     */
    private function parseSpacing(XMLReader $reader): array
    {
        $result = [
            "line" => null,
            "lineRule" => null,
            "before" => null,
            "after" => null
        ];

        $line = $reader->getAttribute("w:line");
        $lineRule = $reader->getAttribute("w:lineRule");
        $before = $reader->getAttribute("w:before");
        $after = $reader->getAttribute("w:after");

        if ($line !== null) {
            switch ($lineRule) {
                case "auto":
                    $result["line"] = $line / 240;
                    $result["lineRule"] = "auto";
                    break;
                case "exact":
                    $result["line"] = $line / 20;
                    $result["lineRule"] = "exact";
                    break;
                case "atLeast":
                    $result["line"] = $line / 20;
                    $result["lineRule"] = "atLeast";
                    break;
            }
        }

        if ($before !== null) {
            $result["before"] = $before / 20;
        }

        if ($after !== null) {
            $result["after"] = $after / 20;
        }

        return $result;
    }


}
