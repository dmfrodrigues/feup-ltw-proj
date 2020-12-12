<?php

class NoFileSentException extends RuntimeException{}

/**
 * Check things about image file.
 *
 * @param string $filePath  File path
 * @param integer $size     Maximum file size, in bytes
 * @return string           File extension
 */
function checkImageFile(?string $filePath, int $maxFileSize) : string {
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    
    if($filePath == null)
        throw new NoFileSentException("No file sent.");

    // Check file size
    $fileSize = filesize($filePath);
    if ($fileSize > $maxFileSize) {
        throw new RuntimeException("Exceeded filesize limit {$maxFileSize}B.");
    }

    // DO NOT TRUST $file['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($filePath);
    if (false === $ext = array_search(
        $mime,
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException("Invalid file format (mime={$mime}).");
    }

    return $ext;
}

/**
 * Check things about image file added or edited in edit page.
 *
 * @param array $file       File
 * @param integer $size     Maximum file size, in bytes
 * @return string           File extension
 */
function checkEditImageFile(array $file, int $size) : string {
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    
    // DO NOT TRUST $file['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($file['new']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }

    return $ext;
}

/**
 * Recursively remove directory and all content.
 *
 * @param string $dir   Path to directory
 * @return void
 */
function rmdir_recursive(string $dir){
    if(is_file($dir)) unlink($dir);
    else if(is_dir($dir)) {
        $lst = scandir($dir);
        foreach($lst as $name){
            if($name === '.' || $name === '..') continue;
            $path = $dir.'/'.$name;
            rmdir_recursive($path);
        }
        rmdir($dir);
    } else throw new RuntimeException('Can\'t delete unknown file type');
}

/**
 * Convert between any type of image.
 * 
 * From https://stackoverflow.com/a/14549647/12283316.
 *
 * @param string $originalImage     Path of original image
 * @param string $outputImage       Path of output image
 * @param integer $quality          Value from 0 (worst) to 100 (best)
 * @return void
 */
function convertImage(string $originalImage, string $ext, string $outputImage, int $quality){
    // jpg, png, gif or bmp?
    
    if (preg_match('/jpg|jpeg/i',$ext))
        $imageTmp=imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i',$ext))
        $imageTmp=imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i',$ext))
        $imageTmp=imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i',$ext))
        $imageTmp=imagecreatefrombmp($originalImage);
    else
        throw new RuntimeException("Unknown image type");

    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);
}
