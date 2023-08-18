<?php
/**
 * Created by PhpStorm.
 * User: Partho
 * Date: 8/17/2023
 * Time: 3:59 PM
 */

namespace App\Http\Controllers\Processor;

use App\Http\Controllers\Contents\FacebookPagePostingHelper;

class ImageProcessor{

    function addTextToImage($inputImagePath, $outputImagePath, $text, $fontPath, $fontSize) {
        try{
            // Load the image
            $image = imagecreatefrompng($inputImagePath);

            // Define the text color (black in this case)
            $textColor = imagecolorallocate($image, 0, 0, 255);

            // Get the image dimensions
            $imageWidth = imagesx($image);
            $imageHeight = imagesy($image);

            // Calculate text position for centering
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth = $bbox[2] - $bbox[0];
            $textHeight = $bbox[1] - $bbox[7];
            $x = ($imageWidth - $textWidth) / 2;
            $y = ($imageHeight + $textHeight) * 0.4 ; //40% from top

            // Add the text to the image using TrueType font
            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $text);

            // Save the modified image to the specified output path
            imagepng($image, $outputImagePath);

            // Free up memory
            imagedestroy($image);
            return true;
        }catch (\Exception $e){
            return false;
        }
    }//addTextToImage()


    public function writeWordOnImage($word){
        $basePath = storage_path()."/app/pagePost/jovoc";
        $inputImagePath = $basePath."/images/word_bg.png";
        $fontPath = $basePath."/fonts/RobotoSlab-VariableFont_wght.ttf"; // Replace with the actual path to your TrueType font file
        $outputImagePath = (new FacebookPagePostingHelper())->getWordWrittenOnBgPath();
        $text = $word;
        $fontSize = 70;

        $result = $this->addTextToImage($inputImagePath, $outputImagePath, $text, $fontPath, $fontSize);

        if($result){
            return $outputImagePath;
        }
        return null;
    }


} //ImageProcessor{ }