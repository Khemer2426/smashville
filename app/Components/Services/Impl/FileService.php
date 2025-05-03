<?php 

namespace App\Components\Services\Impl;

use App\Constants\Http\StatusCode;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ProcessException;
use App\Constants\Components\FileTypes;
use App\Constants\Exception\ProcessExceptionMessage;

use App\Components\Services\IFileService;
use App\Components\Services\IFileTypeService;
use App\Components\Services\IEncryptionService;

use App\Components\Repositories\IFileStorageRepository;

class FileService implements IFileService 
{
    private $_fileStorageRepository;
    private $_encryptionService;
    private $_fileTypeService;

    public function __construct(
        IFileStorageRepository $fileStorageRepository,
        IEncryptionService $encryptionService,
        IFileTypeService $fileTypeService
    )
    {
        $this->_fileStorageRepository = $fileStorageRepository;
        $this->_encryptionService = $encryptionService;
        $this->_fileTypeService = $fileTypeService;
    }

    public function getFile($id)
    {
        $file = $this->_fileStorageRepository->getFile($id);
        if (empty($file)) {
            throw new ProcessException(
                ProcessExceptionMessage::FILE_DOES_NOT_EXIST,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        return $file;
    }

    public function uploadFile($file, $file_type_id, $disk = null)
    { 
        return DB::transaction(function() use (
            $file, 
            $file_type_id, 
            $disk
        ) {
            $encryptedContent = $this->_encryptionService->encryptString(file_get_contents($file));

            $hash_name = md5($file->getClientOriginalName() . uniqid());

            $path = $this->_fileStorageRepository->uploadFileToStorage($encryptedContent, $hash_name, $disk);

            $attachment = $this->_fileStorageRepository->createFile(
                $file->getClientOriginalName(), 
                $file->getClientMimeType(), 
                $path, 
                $file_type_id
            );
            
            return $attachment;
        });
    }

    public function deleteFile($id, $disk = null)
    { 
        DB::transaction(function() use ($id, $disk) {
            $file = $this->getFile($id);
            $path = $file->path;
            $file->delete();
            $this->_fileStorageRepository->deleteFileFromStorage($path, $disk);
        });
    }

    public function downloadFile($id, $disk = null)
    {
        $file = $this->getFile($id);

        $binary =  $this->_fileStorageRepository->getFileFromStorage($file->path, $disk);
        
        $decryptedContent = $this->_encryptionService->decryptString($binary);
        
        return [
            'binary' => $decryptedContent,
            'file' => $file
        ];
    }
}