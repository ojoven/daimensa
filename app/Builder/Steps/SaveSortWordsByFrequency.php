<?php
/** ===========================================
 * STEP: SAVE WORDS BY FREQUENCY
 * ============================================**/

namespace App\Builder\Steps;

use App\Builder\Google\NGram;
use Log;
use Illuminate\Database\Eloquent\Model;

class SaveSortWordsByFrequency extends Model {

	public function saveSortWordsByFrequency() {

		// We get the ngrams (sorted by frequency)
		$nGramModel = new NGram();
		$ngrams = $nGramModel->getWordsNgram(1);

		// We retrieve the list of forms

		// For each ngram, we compare it to word forms to check it really exists
		foreach ($ngrams as $ngram) {

		}


	}

	private function renderExampleNGrams($ngrams) {

		$count = 0;
		foreach ($ngrams as $ngram => $frequency) {

			echo $ngram . ': ' . $frequency . PHP_EOL;
			if ($count > 500) die();

			$count++;

		}

	}

}