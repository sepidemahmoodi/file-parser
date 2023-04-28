<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Classes\Storage\StorageHandler;
use App\Classes\Storage\StoreUsersLogInDb;

class StoreJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $storage;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $storage)
    {
        $this->data = $data; 
        $this->storage = $storage;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       $handler = new StorageHandler($this->storage);
       $handler->handle($this->data);
    }
}
