<?php

class CsvProcessor
{
    private $csv_file;
    private $delimiter;

    public function __construct(string $csv_file, string $delimiter)
    {
        $this->csv_file = $csv_file;
        $this->delimiter = $delimiter;
    }

    public function processFile(): array
    {
        $data = [];
        $file = fopen($this->csv_file, 'r');

        $header     = fgetcsv($file, 1000, $this->delimiter);
        $columns    = array_flip($header);

        while ($row = fgetcsv($file, 1000, $this->delimiter)) {
            $name   = $row[$columns['nome']] ? $row[$columns['nome']] : 'Produto sem descrição';
            $codeProduct = $row[$columns['codigo']] ? $row[$columns['codigo']] : 'Sem código';
            $price  = $row[$columns['preco']] ? $row[$columns['preco']] : 'R$ 0,00';

            $priceFloat     = trim(str_replace('R$', '', str_replace(',', '.', $price)));

            $negativePrice  = $priceFloat < 0;
            $showCopyButton = preg_match('/[02468]/', $codeProduct);

            $data[] = [
                'nome' => $name,
                'codigo' => $codeProduct,
                'preco' => $price,
                'negativePrice' => $negativePrice,
                'showCopyButton' => $showCopyButton,
            ];

            $negativePrice = false;
            $showCopyButton = false;
        }
        fclose($file);
        return $data;
    }
}
