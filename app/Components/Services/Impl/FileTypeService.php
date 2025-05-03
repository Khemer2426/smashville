<?php


namespace App\Components\Services\Impl;

use App\Constants\ProcessExceptionCode;
use App\Constants\ProcessExceptionMessage;
use App\Exceptions\ProcessException;
use App\Components\Services\IFileTypeService;
use App\Components\Repositories\IFileTypeRepository;

class FileTypeService implements IFileTypeService {

    public $_fileTypeRepository;

    public function __construct(
      IFileTypeRepository $fileTypeRepository
    )
    {
      $this->_fileTypeRepository = $fileTypeRepository;
    }

    public function getByName($name)
    {
        $file_type = $this->_fileTypeRepository->getByName($name);
        
        if (empty($file_type)) {
          
            throw new ProcessException(
              ProcessExceptionMessage::FILE_TYPE_DOES_NOT_EXIST,
              ProcessExceptionCode::FILE_TYPE_DOES_NOT_EXIST
            );
        }

        return $file_type;
    }
}
