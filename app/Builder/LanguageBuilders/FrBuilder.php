<?php

namespace App\Builder\LanguageBuilders;
use Log;

class FrBuilder {

	protected $lang = 'fr';

	public function loadSettings() {

		$path = base_path('config/builder/' . $this->lang . "_settings.php");
		if (file_exists($path)) {
			require_once $path;
		} else {
			Log::info('You must create a ' . $this->lang . '_settings.php file on /config/builder/ folder');
			die();
		}

	}

}