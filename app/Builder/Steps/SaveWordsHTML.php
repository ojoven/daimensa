<?php
/** ===========================================
 * STEP 2: SAVE WORDS
 * ============================================**/
// We'll save the words' HTML

namespace App\Builder\Steps;

use App\Builder\Wiktionary\WiktionaryWordHtml;
use Log;
use App\Builder\Wiktionary\WiktionaryLanguageSection;
use Illuminate\Database\Eloquent\Model;
use App\Builder\WordList;

class SaveWordsHTML extends Model {

	public function saveWordsHTML() {

		// Get the word list from previous step
		$wordList = new WordList();
		$words = $wordList->getWordList();

		// Define path Cache / Data files
		$params['cache'] = base_path() . "/data/" . LANGUAGE . "/htmls/";

		// Save the words
		$wiktionaryWordHTML = new WiktionaryWordHtml();
		$wiktionaryWordHTML->saveWordHtmls($words, $params);

	}

	public function saveWordsMultiHTML() {

		// Get the word list from previous step
		$wordList = new WordList();
		$words = $wordList->getWordList();

		$validWords = [];
		foreach ($words as $word) {
			if (strpos($word, ' ') !== false) { // If the word has an space in it (multi) we'll save it
				$validWords[] = $word;
			}
		}

		// Define path Cache / Data files
		$params['cache'] = base_path() . "/data/" . LANGUAGE . "/htmls/";
		$params['overwrite'] = true;

		// Save the words
		$wiktionaryWordHTML = new WiktionaryWordHtml();
		$wiktionaryWordHTML->saveWordHtmls($validWords, $params);

	}

}