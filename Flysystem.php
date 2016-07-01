<?php

namespace JeremyKendall\Upload\Storage;

use League\Flysystem\FilesystemInterface;
use Upload\Exception as UploadException;
use Upload\FileInfoInterface;
use Upload\StorageInterface;

class Flysystem implements StorageInterface
{
    private $filesystem;

    /**
     * Public constructor.
     *
     * @param FilesystemInterface $filesystem
     * @param string              $directory  Relative or absolute path to upload directory
     */
    public function __construct(FilesystemInterface $filesystem, $directory = '')
    {
        $this->filesystem = $filesystem;
        $this->directory = rtrim($directory, '/') . DIRECTORY_SEPARATOR;
    }

    /**
     * Upload file.
     *
     * @param FileInfoInterface $file The file object to upload
     *
     * @throws UploadException
     */
    public function upload(FileInfoInterface $fileInfo)
    {
        try {
            $destinationFile = $this->directory . $fileInfo->getNameWithExtension();
            $putResult = $this->filesystem->put(
                $destinationFile,
                $this->fileGetContents($fileInfo->getPathname())
            );
            // TODO: Would this ever throw an Exception? Can't find any in
            // Flysystem (but perhaps they're in adapters).
        } catch (\Exception $e) {
            throw new UploadException($e->getMessage(), $fileInfo);
        }
    }

    /**
     * Reads entire file into a string.
     *
     * This method allows us to stub `file_get_contents()` in tests.
     *
     * @param string $filename
     *
     * @return string|bool the read data or FALSE on failure
     */
    protected function fileGetContents($fileName)
    {
        return file_get_contents($fileName);
    }
}
