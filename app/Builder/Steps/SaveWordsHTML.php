<?php
/** ===========================================
 * STEP 2: SAVE WORDS
 * ============================================**/
// We'll save the words' HTML

namespace App\Builder\Steps;

use Log;
use App\Builder\Wiktionary\WiktionaryLanguageSection;
use Illuminate\Database\Eloquent\Model;
use App\Builder\WordList;

class SaveWordsHTML extends Model {

	/** 1st step, get words **/
	public function saveWordsHTML() {

		// Get the word list from previous step
		$wordList = new WordList();
		$words = $wordList->getWordList();

		// Define path Cache / Data files
		$params['cache'] = base_path() . "/data/" . LANGUAGE . "/htmls/";

		// Save the words
		$wiktionaryLanguageSection = new WiktionaryLanguageSection();
		$wiktionaryLanguageSection->saveWordHtmlJustLanguage($words, $params);

	}

}