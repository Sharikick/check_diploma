<?php

namespace Core\Diploma\Parser\Document;

interface DocumentParserInterface
{
    public function parse(string $xmlContent): void;
}
