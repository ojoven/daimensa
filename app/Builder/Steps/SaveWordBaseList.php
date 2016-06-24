<?php
/** ===========================================
 * STEP4: SAVE WORD BASE LIST
 * ============================================**/
// We'll save just the words that belong to Name / Verb / Adjective / Adverbe, Preposition or Pronoun

namespace App\Builder\Steps;

use App\Builder\Wiktionary\WiktionaryForm;
use App\Builder\Wiktionary\WiktionaryWordHtml;
use App\Builder\WordList;
use Log;

use Illuminate\Database\Eloquent\Model;
use App\Builder\FileManager;

class SaveWordBaseList extends Model {

	/** 1st step, get word list **/
	public function saveWordBaseList() {

		$baseWordsPath = base_path() . '/data/' . LANGUAGE . '/jsons/basewords.json';
		$baseWordsJson = FileManager::getFile($baseWordsPath);
		if (!$baseWordsJson) {

			// INITIALIZE BASE WORDS
			$baseWords = array();

			// GET ALL WORDS
			$wordList = new WordList();
			$words = $wordList->getWordList();

			$wiktionaryWordHTML = new WiktionaryWordHtml();
			$wiktionaryForm = new WiktionaryForm();

			// LET'S GET IF THE WORD IS BASE WORD
			$countWords = count($words);
			foreach ($words as $index => $word) {

				$wordHTML = $wiktionaryWordHTML->getHtmlWordWiktionary($word);

				if ($wiktionaryForm->isBaseWord($wordHTML)) {

					Log::info($index . '/' . $countWords . ': ' . $word . ' is base word');
					array_push($baseWords, $word);
				}
			}

			FileManager::saveFile($baseWordsPath, json_encode($baseWords));

		} else {

			$baseWords = json_decode($baseWordsJson, true);

		}

		Log::info(count($baseWords) . ' total base words');
		return $baseWords;

	}

}