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

	/** UNCOMPRESS FILES **/
	// Serves for .gz
	public static function uncompressFile($pathCompressed, $pathUncompressed) {

		$file_name = $pathCompressed;

		// Raising this value may increase performance
		$buffer_size = 4096; // read 4kb at a time
		$out_file_name = $pathUncompressed;

		// Open our files (in binary mode)
		$file = gzopen($file_name, 'rb');
		$out_file = fopen($out_file_name, 'wb');

		// Keep repeating until the end of the input file
		while (!gzeof($file)) {
			// Read buffer-size bytes
			// Both fwrite and gzread and binary-safe
			fwrite($out_file, gzread($file, $buffer_size));
		}

		// Files are done, close files
		fclose($out_file);
		gzclose($file);

	}

}