<?php

namespace Interfaces;

interface FileServiceInterface
{
    public function processFile(): array;

    public function sortData(): array;
}
