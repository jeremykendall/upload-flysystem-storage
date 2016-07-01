# Flysystem Storage for Upload

This project adds Flysytem storage to the excellent
[Upload](https://github.com/brandonsavage/Upload) project.

## Usage

``` php
<?php


use JeremyKendall\Upload\Storage\Flysystem;
use Upload\File;

// $fileSystem is an instance of League\Flysystem\FilesystemInterface
// $pathToUpload is the relative or absolute path to the upload directory

$storage = new Flysystem($fileSystem, $pathToUpload);
$file = new File($fileKey, $storage);
$file->upload();
```
