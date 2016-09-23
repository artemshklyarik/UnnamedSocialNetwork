<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;

class Photos extends Model
{
    public static function createAllPhotos($fileName)
    {
        $OriginalFilePath  = 'uploads/original/' . $fileName;
        $smallFilePath     = 'uploads/small/'    . $fileName;
        $mediumFilePath    = 'uploads/medium/'   . $fileName;

        $smallWidth        = 200;
        $mediumWidth       = 600;

        $originalWidth     = Image::make($OriginalFilePath)->width();
        $originalHeight    = Image::make($OriginalFilePath)->height();

        $coefficientSmall  = $originalWidth / $smallWidth;
        $coefficientMedium = $originalWidth / $mediumWidth;

        $smallHeight       = $originalHeight / $coefficientSmall;
        $mediumHeight      = $originalHeight / $coefficientMedium;

        Image::make($OriginalFilePath)->resize($smallWidth, $smallHeight)->save($smallFilePath);
        Image::make($OriginalFilePath)->resize($mediumWidth, $mediumHeight)->save($mediumFilePath);

        return true;
    }
}
