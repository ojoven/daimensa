<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Image extends Model {

    // Save Image from form
    public function saveImageUserFromForm($fileTmpName, $fileName) {

        $pathToUserImages = $this->_getUserImagesPath();
        $target = $pathToUserImages . $fileName;

        // Save image
        $result = move_uploaded_file($fileTmpName, $target);

        // Change permissions
        chmod($target, 0755);

        return $result;
    }

    // Save Image from file (used for Facebook and Google)
    public function saveImageUserFromFile($file, $fileName) {

        $pathToUserImages = $this->_getUserImagesPath();
        $target = $pathToUserImages . $fileName;

        // Save image
        $result = file_put_contents($target, $file);

        // Change permissions
        chmod($target, 0755);

        return $result;
    }

    // Auxiliars
    public static function getImageExtension($image) {
        $info = getimagesize($image);
        $extension = image_type_to_extension($info[2]);
        return $extension;
    }

    // Get User Images Path
    private function _getUserImagesPath() {
        return base_path() . '/public/img/users/';
    }

}