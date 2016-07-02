<?php

namespace App\Retriever;

use App\Lib\Functions;
use Log;
use App\Builder\LanguageBuilderFactory;
use Illuminate\Database\Eloquent\Model;

class Retriever extends Model {

	// Build cards for a word
	public function retrieve($task, $language, $additional = '') {

		// Get Language Builder
		$languageBuilder = LanguageBuilderFactory::getLanguageBuilder($language);

		// Load Settings
		$languageBuilder->loadSettings();

		// TASKS / STEPS
		switch ($task) {

			case 'youtube':
				$youtubeModel = new YouTube();
				$youtubeModel->retrieveYouTubeVideos();
				break;

			case 'test':
				Log::info(Functions::ISO8601ToUnixTime('PT6M17S'));
				break;
		}

	}

	/** AUXILIAR FUNCTIONS **/
	// LOAD SETTINGS
	public function loadSettings() {

		// Common settings to all languages
		$pathCommonSettings = app_path('Builder/config/common_settings.php');
		require_once $pathCommonSettings;

		// Language custom settings
		$path = app_path('Builder/config/' . $this->language . '_settings.php');
		if (file_exists($path)) {
			require_once $path;
		} else {
			Log::info('You must create a ' . $this->language . '_settings.php file on /config/builder/ folder');
			die();
		}

	}

	// GET LANGUAGE
	public function getLanguage() {
		return $this->language;
	}

}
