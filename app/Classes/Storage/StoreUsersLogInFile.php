<?php
namespace App\Classes\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreUsersLogInFile implements StorageInterface
{
    /**
     * @param array $data
     */
    public function store(array $data)
    {
        Log::build([
          'driver' => 'single',
          'path' => storage_path('logs/users_log.log'),
        ])->info(json_encode([
            'data' => $data
        ]));
    }
}