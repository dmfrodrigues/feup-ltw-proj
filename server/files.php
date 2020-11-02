<?php
/**
 * Check things about image file.
 *
 * @param array $file       File
 * @param integer $size     Maximum file size, in bytes
 * @return string           File extension
 */
function checkImageFile(array $file, int $size) : string {
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($file['error']) ||
        is_array($file['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $file['error'] value.
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here.
    if ($file['size'] > $size) {
        throw new RuntimeException('Exceeded filesize limit 1MB.');
    }

    // DO NOT TRUST $file['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($file['tmp_name']),
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
            $path = $dir.'/'.$name;
            rmdir_recursive($path);
        }
        rmdir($dir);
    } else throw new RuntimeException("Can't delete unknown file type");
}
