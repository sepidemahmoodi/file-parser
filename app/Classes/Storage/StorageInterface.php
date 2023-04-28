<?php
namespace App\Classes\Storage;

interface StorageInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);
}