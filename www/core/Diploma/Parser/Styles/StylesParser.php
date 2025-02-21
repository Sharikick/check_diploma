<?php

namespace Core\Diploma\Parser\Styles;

use XMLReader;

class StylesParser implements StylesParserInterface
{
    private array $docDefaults;
    private array $styles;
    private array $latentStyles;

    private function initialize(): void
    {
        $this->docDefaults = [];
        $this->styles = [];
        $this->latentStyles = [];
    }

    /**
     * Парсит XML-контент файла styles.xml и извлекает структурированные данные о стилях.
     *
     * @param string $xmlContent Содержимое файла styles.xml в виде строки.
     *
     * @return void Метод не возвращает значения, но заполняет внутренние свойства класса:
     *      - $this->docDefaults: Глобальные настройки по умолчанию.
     *      - $this->latentStyles: Латентные стили.
     *      - $this->styles: Массив стилей с их свойствами.
     */
    public function parse(string $xmlContent): void
    {
        $this->initialize();
        $reader = new XMLReader();
        $reader->XML($xmlContent);

        while ($reader->read()) {
            if ($reader->nodeType === XMLReader::ELEMENT) {
                switch ($reader->name) {
                    case "w:docDefaults":
                        $this->parseDocDefaults($reader);
                        break;

                    case "w:latentStyles":
                        $this->parseLatentStyles($reader);
                        break;

                    case "w:style":
                        $this->styles[$reader->getAttribute("w:styleId")] = $this->parseStyle($reader);
                        break;
                }
            }
        }

        $reader->close();
    }

    /**
     * Парсит секцию `<w:docDefaults>` файла styles.xml.
     *
     * Секция `<w:docDefaults>` содержит глобальные настройки по умолчанию для всего документа.
     *
     * @param XMLReader $reader Экземпляр XMLReader, позиционированный на начало тега `<w:docDefaults>`.
     *
     * @return void Метод не возвращает значения, но заполняет свойство `$this->docDefaults`:
     *      - $this->docDefaults['rPr']: Настройки пробегов текста.
     *      - $this->docDefaults['pPr']: Настройки абзацев.
     */
    private function parseDocDefaults(XMLReader $reader): void
    {
        while ($reader->read()) {
            if ($reader->nodeType === XMLReader::END_ELEMENT && $reader->name === "w:docDefaults") {
                break;
            }

            if ($reader->nodeType === XMLReader::ELEMENT) {
                switch ($reader->name) {
                    case "w:rPr":
                        $this->docDefaults["rPr"] = $this->parseRunProperties($reader);
                        break;

                    case "w:pPr":
                        $this->docDefaults["pPr"] = $this->parseParagraphProperties($reader);
                        break;
                }
            }
        }
    }


    /**
     * Парсит секцию `<w:latentStyles>` файла styles.xml.
     *
     * Секция `<w:latentStyles>` содержит информацию о латентных стилях документа,
     * которые могут быть скрытыми или активными. Метод извлекает атрибуты секции
     * и список исключений `<w:lsdException>`, описывающих конкретные латентные стили.
     *
     * @param XMLReader $reader Экземпляр XMLReader, позиционированный на начало тега `<w:latentStyles>`.
     *
     * @return void Метод не возвращает значения, но заполняет свойство `$this->latentStyles`:
     *      - $this->latentStyles['attributes']: Атрибуты секции `<w:latentStyles>`.
     *      - $this->latentStyles['exceptions']: Массив исключений `<w:lsdException>`, где каждый элемент представляет собой массив атрибутов конкретного стиля.
     */
    private function parseLatentStyles(XMLReader $reader): void
    {
        $attributes = $this->getAttributes($reader);
        $this->latentStyles["attributes"] = $attributes;

        while ($reader->read()) {
            if ($reader->nodeType === XMLReader::END_ELEMENT && $reader->name === "w:latentStyles") {
                break;
            }

            if ($reader->nodeType === XMLReader::ELEMENT && $reader->name === "w:lsdException") {
                $this->latentStyles["exceptions"][] = $this->getAttributes($reader);
            }
        }
    }

    /**
     * Парсит тег `<w:style>` файла styles.xml.
     *
     * Тег `<w:style>` описывает конкретный стиль документа.
     *
     * @param XMLReader $reader Экземпляр XMLReader, позиционированный на начало тега `<w:style>`.
     *
     * @return array Массив, содержащий данные о стиле:
     *      - 'attributes': Атрибуты тега `<w:style>`.
     *      - 'basedOn': Идентификатор родительского стиля.
     *      - 'pPr': Свойства абзацев.
     *      - 'rPr': Свойства пробегов текста.
     */
    private function parseStyle(XMLReader $reader): array
    {
        $style = [];
        $style["attributes"] = $this->getAttributes($reader);

        while ($reader->read()) {
            if ($reader->nodeType === XMLReader::END_ELEMENT && $reader->name === "w:style") {
                break;
            }

            if ($reader->nodeType === XMLReader::ELEMENT) {
                switch ($reader->name) {
                    case "w:name":
                        $style["name"] = $reader->getAttribute("w:val");
                        break;
                    case "w:basedOn":
                        $style["basedOn"] = $reader->getAttribute("w:val");
                        break;
                    case "w:qFormat":
                        $style["qFormat"] = true;
                        break;
                    case "w:uiPriority":
                        $style["uiPriority"] = $reader->getAttribute("w:val");
                        break;
                    case "w:next":
                        $style["next"] = $reader->getAttribute("w:val");
                    case "w:pPr":
                        $style["pPr"] = $this->parseParagraphProperties($reader);
                        break;
                    case "w:rPr":
                        $style["rPr"] = $this->parseRunProperties($reader);
                        break;
                }
            }
        }

        return $style;
    }

    /**
     * Парсит тег `<w:rPr>` (свойства пробегов текста).
     *
     * @param XMLReader $reader Экземпляр XMLReader, позиционированный на начало тега `<w:rPr>`.
     *
     * @return array Массив, содержащий свойства пробегов текста:
     *      - 'font': Название шрифта.
     *      - 'italic': Булево значение, указывающее, является ли текст курсивным.
     *      - 'bold': Булево значение, указывающее, является ли текст жирным.
     *      - 'fontSize': Размер шрифта в пунктах (значение атрибута `w:sz` делится на 2).
     */
    private function parseRunProperties(XmlReader $reader): array
    {
        $properties = [];

        while ($reader->read()) {
            if ($reader->nodeType === XMLReader::END_ELEMENT && $reader->name === "w:rPr") {
                break;
            }

            if ($reader->nodeType === XMLReader::ELEMENT) {
                switch ($reader->name) {
                    case "w:rFonts":
                        $properties["font"] = $reader->getAttribute("w:ascii");
                        break;

                    case "w:i":
                        $properties["italic"] = true;
                        break;

                    case "w:b":
                        $properties["bold"] = true;
                        break;

                    case "w:sz":
                        $properties["fontSize"] = $reader->getAttribute("w:val") / 2;
                        break;
                }
            }
        }

        return $properties;
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

    /**
     * Извлекает все атрибуты текущего XML-элемента.
     *
     * Метод перемещается по всем атрибутам текущего элемента, извлекает их имена и значения,
     * а затем сохраняет их в ассоциативный массив. После завершения обработки атрибутов,
     * курсор XMLReader возвращается к исходному элементу.
     *
     * @param XMLReader $reader Экземпляр XMLReader, позиционированный на элементе с атрибутами.
     *
     * @return array Ассоциативный массив атрибутов, где:
     *      - Ключ: Имя атрибута.
     *      - Значение: Значение атрибута.
     */
    private function getAttributes(XMLReader $reader): array
    {
        $attributes = [];

        if ($reader->hasAttributes) {
            while ($reader->moveToNextAttribute()) {
                $attributes[$reader->name] = $reader->value;
            }
            $reader->moveToElement();
        }

        return $attributes;
    }

    public function getDocDefaults(): array
    {
        return $this->docDefaults;
    }

    public function getStyles(): array
    {
        return $this->styles;
    }

    public function getLatentStyles(): array
    {
        return $this->latentStyles;
    }
}
