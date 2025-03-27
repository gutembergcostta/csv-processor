<?php

namespace Services;

use Validators\CsvValidator;
use Models\Product;
use Interfaces\FileServiceInterface;

class CsvService implements FileServiceInterface
{
    private $csv_file;
    private $delimiter;
    private $handle;
    private $validator;
    private $data = array();

    public function __construct(string $csv_file, string $delimiter)
    {
        $this->csv_file = $csv_file;
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
        $this->validator->validateDelimiter($this->delimiter);
        $this->validator->detectDelimiter($this->csv_file, $this->delimiter);

        $this->handle   = fopen($this->csv_file, 'r');
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
