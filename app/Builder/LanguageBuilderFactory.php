<?php

namespace App\Builder;
use Log;

class LanguageBuilderFactory {

	public static function getLanguageBuilder($language) {

		$className = __NAMESPACE__ . '\\LanguageBuilders\\' . ucfirst($language) . 'Builder';
		if (class_exists($className)) {
			$languageBuilder = new $className();
			return $languageBuilder;
		} else {
			Log::info('You must create a ' . ucfirst($language) . 'Builder.php file / class on /app/Builder/LanguageBuilders/ folder');
			die();
		}

	}

}