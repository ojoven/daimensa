<?php
/** ===========================================
 * STEP: SAVE WORD FORMS
 * ============================================**/
// We'll save the forms for all the base words
// This means: the femenine and masculine, singular and plural of names, adjectives
// + all the verb conjugations (if available)

namespace App\Builder\Steps;

use App\Builder\Wiktionary\WiktionaryForm;
use App\Builder\WordList;
use Log;

use App\Builder\Wiktionary\WiktionaryCategory;
use Illuminate\Database\Eloquent\Model;
use App\Builder\FileManager;

class SaveWordForms extends Model {

	/** 1st step, get word list **/
	public function saveWordForms() {

		// We'll get first the base words
		$wordList = new WordList();
		$baseWords = $wordList->getBaseWordList();

		//$baseWords = array('gigantesque', 'dépasser', 'longueur'); // Test words

		$wordsAndForms = array();
		foreach ($baseWords as $baseWord) {
			$wiktionaryWordForm = new WiktionaryForm();
			$forms = $wiktionaryWordForm->getWordForms($baseWords);
		}

	}

}