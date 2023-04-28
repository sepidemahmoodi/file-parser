<?php
namespace App\Classes\Storage;

class StorageHandler
{
    private $storage;

    /**
     * StorageHandler constructor.
     * @param StorageHandler $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param array $data
     */
    public function handle(array $data)
    {
        $this->storage->store($data);
    }
}