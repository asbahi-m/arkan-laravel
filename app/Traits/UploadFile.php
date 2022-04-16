<?php

namespace App\Traits;

Trait UploadFile
{
    function saveFile($source, $path) {
        $file = $source;
        $file_ext = $file->extension();
        $file_name = time() . '.' . $file_ext;
        $full_path = $path . '/' . $file_name;

        $file->storePubliclyAs($path, $file_name, 'public');

        return $full_path;
    }
}
