<?php

namespace AdminBundle\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImportExcelDTO
 *
 * @package AdminBundle\DTO
 */
class ImportExcelDTO
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @return UploadedFile|null
     */
    public function getFile():? UploadedFile
    {
        return $this->file;
    }
}