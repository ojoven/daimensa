<?php

namespace App\Builder;

use Log;

class FileManager {

	/** GET **/
	public static function getFile($path) {

		if (!file_exists($path)) {
			return false;
		}

		$file = file_get_contents($path);
		return $file;

	}


	/** SAVE **/
	public static function saveFile($path, $data) {

		// We check if the parent directory exists and if not, we create it
		$parentDirectory = dirname($path);
		if (!file_exists($parentDirectory)) {
			mkdir($parentDirectory, 0755, true);
		}

		// We now save the file
		file_put_contents($path, $data);

	}

}