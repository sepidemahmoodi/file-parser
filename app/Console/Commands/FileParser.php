<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use App\Classes\Parsers\UserFileParser;

class FileParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->filePath = $this->askForFilePath();
         $logParser = new UserFileParser();
         $logParser->parse($this->filePath);
    }

    private function askForFilePath(): string
    {
        $filePath = $this->ask('Please enter the path to the log file:');

        $validator = Validator::make(
            ['filePath' => $filePath],
            [
                'filePath' => ['required', function ($attribute, $value, $fail) {
                    if (!file_exists($value)) {
                        $fail('The '.$attribute.' is not exist.');
                    }}]
            ]
        );

        if ($validator->fails()) {
            $this->error($validator->errors());

            return $this->askForFilePath();
        }

        return $filePath;
    }
}
