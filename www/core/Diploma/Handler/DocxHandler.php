<?php

namespace Core\Diploma\Handler;

use ZipArchive;

class DocxHandler implements DocxHandlerInterface
{
    private readonly \ZipArchive $zip;
    private readonly string $mime;
    private readonly string $ext;
    private ?string $filePath = null;

    public function __construct(array $file)
    {
        $this->ext = "docx";
        $this->mime = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
        $this->validateDocx($file);
        $this->saveFile($file);
        $this->zip = new ZipArchive();
        if ($this->zip->open($this->getFilePath()) !== true) {
            throw new \Exception("Ошибка при откытии docx файла");
        }
    }

    private function validateDocx(array $file): void
    {
        if ($file["error"] !== UPLOAD_ERR_OK) {
            throw new \Exception("Error");
        }

        if ($file["type"] !== $this->mime) {
            # Нужно расписать ошибку для MIME-TYPE
            throw new \Exception("Error");
        }

        if (pathinfo($file["name"], PATHINFO_EXTENSION) !== $this->ext) {
            # Нужно расписать ошибку расширения для DOCX
            throw new \Exception("Error");
        }
    }

    private function saveFile(array $file): void
    {
        $uploadDir = APP_PATH . '/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $this->filePath = $uploadDir . uniqid() . '.docx';

        if (!move_uploaded_file($file["tmp_name"], $this->filePath)) {
            throw new \Exception("Не удалось сохранить файл.");
        }
    }

    public function extractXml(string $path): string
    {
        $index = $this->zip->locateName($path);

        if ($index === false) {
            $this->zip->close();
            throw new \Exception("Не найден файл в архиве по пути $path");
        }
        return $this->zip->getFromIndex($index);
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function close(): void
    {
        if ($this->zip) {
            $this->zip->close();
        }
    }
}
