<?php

namespace Services;

use Validators\CsvValidator;
use Models\Product;
use Interfaces\FileServiceInterface;

class CsvService implements FileServiceInterface
{
    private $tmp_path;
    private $file_name;
    private $delimiter;
    private $handle;
    private $validator;
    private $data = array();

    public function __construct(string $tmp_path, string $file_name, string $delimiter)
    {
        $this->tmp_path = $tmp_path;
        $this->file_name = $file_name;
        $this->delimiter = $delimiter;

        $this->validator = new CsvValidator();
    }

    public function sortData(): array
    {
        usort($this->data, fn(Product $a, Product $b) => strcmp($a->nome, $b->nome));

        return array_map(fn(Product $p) => (array) $p, $this->data);
    }

    public function processFile(): array
    {
        $this->validator->validateExtensionFile($this->file_name, $this->tmp_path, array('csv'));
        $this->validator->validateDelimiter($this->delimiter);
        $this->validator->detectDelimiter($this->tmp_path, $this->delimiter);

        $this->handle   = fopen($this->tmp_path, 'r');
        $header         = fgetcsv($this->handle, 1000, $this->delimiter);
        $columns        = array_flip($header);
        $this->validator->validateColumns($columns);

        while ($row = fgetcsv($this->handle, 1000, $this->delimiter)) {
            $this->data[] = new Product($row[$columns['nome']], $row[$columns['codigo']], $row[$columns['preco']]);
        }

        fclose($this->handle);

        return $this->sortData();
    }
}
