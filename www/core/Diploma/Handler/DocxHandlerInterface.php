<?php

namespace Core\Diploma\Handler;

interface DocxHandlerInterface {
    public function getFilePath(): string;
    public function close(): void;
    public function extractXml(string $path): string;
}
