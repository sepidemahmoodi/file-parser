<?php
namespace App\Classes\Parsers;
use App\Jobs\StoreJob;
use Illuminate\Support\Facades\Validator;
use App\Classes\Storage\StoreUsersLogInDb;
use App\Classes\Storage\StoreUsersLogInFile;
use App\Classes\QueueHandler\PublishMessage;
use PhpAmqpLib\Message\AMQPMessage;

class UserFileParser implements ParserInterface
{
	public function parse(string $logFilePath)
	{
        try {
            if($this->checkFileIsExist($logFilePath) && is_readable($logFilePath)) {
                $fileHandle = fopen($logFilePath, 'r');
                while (!feof($fileHandle)) {
                    while (($line = fgets($fileHandle)) !== false) {
                    	$data = $this->prepareData(trim($line));
						$validator = $this->prepareValidator($data);
				        if ($validator->fails()){
							StoreJob::dispatch($data, new StoreUsersLogInFile);
				        }
				        else {
				        	StoreJob::dispatch($data, new StoreUsersLogInDb);
				        }
                    }
                }
                fclose($fileHandle);
                return 'Parsing log file is complete';
            }
            throw new \Exception('Log file is not exist.', 404);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
	}
	 /**
     * @param $logFilePath
     * @return bool
     */
    private function checkFileIsExist($logFilePath)
    {
        return file_exists($logFilePath);
    }

    private function prepareValidator($data)
    {
    	return Validator::make($data, [
            'national_code' => 'required|string|unique:users_log|max:10',
            'mobile' => 'required|string|unique:users_log|max:11',
        ]);
    }

        /**
     * @param $logContent
     * @return array
     */
    private function prepareData($logContent)
    {
        $data = explode("\t", $logContent);
        return [
            'national_code' => $data[0] ?? '',
            'mobile' => $data[1] ?? '',
        ];
    }
}