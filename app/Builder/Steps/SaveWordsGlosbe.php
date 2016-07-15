<?php
/** ===========================================
 * STEP: SAVE WORDS GLOSBE
 * ============================================**/
// We'll save the translations and examples from Glosbe

namespace App\Builder\Steps;

use App\Builder\Glosbe;
use App\Builder\WordList;
use Log;

use Illuminate\Database\Eloquent\Model;

class SaveWordsGlosbe extends Model {

	/** 1st step, get word list **/
	public function SaveWordsGlosbe() {

		// We'll get first the base words
		$wordList = new WordList();
		$baseWords = $wordList->getBaseWordList();

		//$baseWords = array('gigantesque', 'dépasser', 'longueur'); // Test words

		$languages = array('en', 'es', 'fr');
		$glosbe = new Glosbe();

		$counter = 0;
		$numWords = count($baseWords);
		foreach ($baseWords as $word) {

			foreach ($languages as $language) {

				if ($language != LANGUAGE) {
					Log::info($counter . '/' . $numWords . ': translations and examples of ' . $word . ' to ' . $language);
					$glosbe->getTranslations($word, LANGUAGE, $language);
					$glosbe->getExamples($word, LANGUAGE, $language);
				}

			}

		}

	}

}