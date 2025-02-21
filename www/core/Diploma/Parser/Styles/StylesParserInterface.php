<?php

namespace Core\Diploma\Parser\Styles;

interface StylesParserInterface
{
    public function parse(string $xmlContent): void;
    public function getDocDefaults(): array;
    public function getStyles(): array;
    public function getLatentStyles(): array;
}
