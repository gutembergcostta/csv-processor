<?php

namespace Models;

class Product
{
    public string $nome;
    public string $codigo;
    public string $preco;
    public bool $negativePrice = false;
    public bool $showCopyButton = false;

    public function __construct(string $nome, string $codigo, string $preco)
    {
        $priceFloat = $preco != '' ? $this->convertToFloatPrice($preco) : 0;

        $this->nome = !empty($nome) ? $nome : 'Produto sem descrição';
        $this->codigo = !empty($codigo) ? $codigo : 'Produto sem código';
        $this->preco = $this->convertToBrazilianReal($priceFloat);
        $this->negativePrice = $priceFloat < 0;
        $this->showCopyButton = $this->showCopyButton($codigo);
    }

    private function convertToBrazilianReal($price)
    {
        return "R$ " . number_format((float)$price, 2, ',', '');
    }
    private function convertToFloatPrice($price)
    {
        return trim(str_replace('R$', '', str_replace(',', '.', $price)));
    }

    private function showCopyButton(string $codigo): bool
    {
        return preg_match('/[02468]/', $codigo);
    }
}
