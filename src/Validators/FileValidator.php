<?php

namespace Validators;


use InvalidArgumentException;
use RuntimeException;

class FileValidator
{

    public function validateExtensionFile(string $fileName, string $filePath, array $allowedExtensions): bool
    {
        $this->validateFile($filePath);

        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        if (!in_array(strtolower($extension), $allowedExtensions)) {
            throw new InvalidArgumentException("Extensão do arquivo não permitida");
        }

        return true;
    }

    public function validateFile(string $path): bool
    {

        if (!file_exists($path)) {
            throw new InvalidArgumentException("Arquivo não encontrado.");
        }

        if (!is_readable($path)) {
            throw new InvalidArgumentException("Arquivo não pode ser lido.");
        }

        return true;
    }

    public function validateEmptyFile(string $path): bool
    {
        $this->validateFile($path);

        $handle = fopen($path, 'r');
        $firstLine = fgets($handle);

        if (!$firstLine) {
            throw new InvalidArgumentException("O arquivo está vazio.");
        }

        fclose($handle);

        return true;
    }

    public function validateOnlyHeaderFile(string $path): bool
    {
        $this->validateEmptyFile($path);

        $rowCount = 0;

        $handle = fopen($path, 'r');
        while (($line = fgets($handle)) !== false) {
            $rowCount++;
            if ($rowCount >= 2) {
                fclose($handle);
                return true;
            }
        }

        if ($rowCount <= 1) {
            throw new InvalidArgumentException("Só existe o cabeçalho neste arquivo");
        }
        fclose($handle);

        return true;
    }
}
