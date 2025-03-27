<?php

namespace Controllers;

use Interfaces\FileServiceInterface;

class ApiController
{
    private FileServiceInterface $service;

    public function __construct(FileServiceInterface $csvService)
    {
        $this->service = $csvService;
    }

    public function handleRequest()
    {
        try {
            $returnProducts = $this->service->processFile();

            return json_encode(['success' => true, 'products' => $returnProducts], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $th) {
            return json_encode(['success' => false, 'message' => $th->getMessage(), 'typeException' => get_class($th)]);
        }
    }
}
