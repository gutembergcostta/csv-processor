<?php

namespace Validators;


use InvalidArgumentException;
use RuntimeException;

class CsvValidator extends FileValidator
{

    public function validateDelimiter(string $delimiter): bool
    {
        if (!in_array($delimiter, [',', ';'])) {
            throw new InvalidArgumentException("Delimitador inválido, use ',' ou ';'.");
        }

        return true;
    }

    public function detectDelimiter(string $path, string $delimiter): bool
    {
        $this->validateEmptyFile($path);
        $this->validateDelimiter($delimiter);

        $handle = fopen($path, 'r');
        $firstLine = fgets($handle);

        if (!(strpos($firstLine, $delimiter) !== false)) {
            throw new \InvalidArgumentException("O separador indicado não condiz com o arquivo, tente o outro separador");
        }

        fclose($handle);
        return true;
    }

    public function validateColumns(array $columns): bool
    {
        $requiredColumns = ["nome", "codigo", "preco"];

        foreach ($requiredColumns as $column) {
            if (!isset($columns[$column])) {
                throw new RuntimeException("Arquivo CSV não contém a coluna '{$column}' necessária.");
            }
        }

        return true;
    }
}
