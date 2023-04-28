<?php
namespace App\Classes\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreUsersLogInDb implements StorageInterface
{
    /**
     * @param array $data
     */
    public function store(array $data)
    {
        try{
            DB::table('users_log')->insert($data);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}