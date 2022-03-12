<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class StorageService{

    protected $aws_s3;

    public function __construct()
    {
        $this->aws_s3 = App::make('aws')->createClient('s3');
    }

    public function saveAwsFile($file_path, UploadedFile $file) : void {
        $this->aws_s3->putObject(array(
            'Bucket'     => env('AWS_BUCKET'),
                'Key'        => $file_path.$file->getClientOriginalName(),
                //'Key'        => $file_path.$file->hashName(),
                'SourceFile' => $file,
            ));
    }

    public function deleteAwsFile($file_path, $filename) : void {
        $result = Storage::disk('s3')->delete($file_path.$filename);
        if(!$result){
            throw new Exception('deleteAwsFile endpoint: Cannot be delete, path: '.$file_path.$filename);
        }
    }

    public function getAwsFile($file_path, $filename) : string {
        return Storage::disk('s3')->temporaryUrl(
                                        $file_path.$filename,
                                        now()->addHour(),
                                        ['ResponseContentDisposition' => 'attachment']
                                    );
    }
}

