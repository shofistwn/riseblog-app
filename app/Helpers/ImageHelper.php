<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function saveImage($image, string $destinationPath, string $fileName)
    {
        if ($image) {
            $fileName = $fileName . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/' . $destinationPath, $fileName);
            return $fileName;
        }

        return null;
    }

    public static function deleteImage(string $folderName, string $imagePath)
    {
        if ($imagePath) {
            Storage::delete('public/' . $folderName . '/' . $imagePath);
        }
    }
}
