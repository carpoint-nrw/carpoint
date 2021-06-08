<?php

namespace AdminBundle\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Trait UploadFileTrait
 *
 * @package AdminBundle\Traits
 */
trait UploadFileTrait
{
    /**
     * @var UploadedFile|null
     */
    protected $file;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $fileName;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $originalFileName;

    /**
     * @return UploadedFile|null
     */
    public function getFile():? UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile|null $file
     *
     * @return UploadFileTrait
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileName():? string
    {
        return $this->fileName;
    }

    /**
     * @param string|null $fileName
     *
     * @return static
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginalFileName():? string
    {
        return $this->originalFileName;
    }

    /**
     * @param string|null $originalFileName
     *
     * @return static
     */
    public function setOriginalFileName($originalFileName)
    {
        $this->originalFileName = $originalFileName;

        return $this;
    }
}