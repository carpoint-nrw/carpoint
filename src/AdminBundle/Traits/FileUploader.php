<?php

namespace AdminBundle\Traits;

use AdminBundle\Entity\References\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Trait FileUploader
 *
 * @package AdminBundle\Traits
 */
trait FileUploader
{
    /**
     * File uploader.
     *
     * @param mixed $entity
     *
     * @return void
     */
    public function upload($entity): void
    {
        /** @var UploadedFile $file */
        $file = $entity->getFile();
        $path = $this->getPath($entity);
        if ($file !== null && $path !== null) {
            $extension = $file->getClientOriginalExtension();
            $originalFileName = $file->getClientOriginalName();
            $fileName =  date('U') . '.' . $extension;

            if ($entity->getFileName() !== null) {
                $deleteFile = $path . '/' . $entity->getFileName();

                if (file_exists($deleteFile)) {
                    unlink($deleteFile);
                }
            }

            $file->move($path . '/', $fileName);
            $entity->setFileName($fileName);
            $entity->setOriginalFileName($originalFileName);
        }
    }

    /**
     * @param mixed $entity
     *
     * @return string|null
     */
    private function getPath($entity):? string
    {
        switch (\get_class($entity)) {
            case Model::class:
                return $this->modelAbsolutePath;
            default:
                return null;
        }
    }
}