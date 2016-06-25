<?php
/** ===========================================
 * STEP 5: SAVE N GRAMS Google
 * ============================================**/
// We'll save all the n-grams (1) from Google
// http://storage.googleapis.com/books/ngrams/books/datasetsv2.html
// We need to copy manually first the HTML into data/[lang]/n-grams/htmls/1gram.html

namespace App\Builder\Steps;

use Log;
use Illuminate\Database\Eloquent\Model;
use App\Builder\Google\NGram;

class SaveNGram extends Model {

	/** SAVE NGRAM (1) **/
	public function saveNGram() {

		$nGram = new NGram();
		//$nGram->saveNGrams(1); // 1-grams
		$nGram->ngramsToJSONFiles(1);

	}

}