<?php
/** ===========================================
 * STEP: SAVE CONJUGATIONS HTMLS
 * ============================================**/
// We'll save the verbs' conjugations' HTMLs

namespace App\Builder\Steps;

use App\Builder\Wiktionary\WiktionaryWordVerb;
use App\Builder\Words\Verb;
use App\Lib\WordFunctions;
use Log;
use Illuminate\Database\Eloquent\Model;

class saveConjugationsHTML extends Model {

	public function saveConjugationsHTML() {

		if (CONJUGATE_VERBS) {

			// Get the word list from previous step
			$verb = new Verb();
			$verbs = $verb->getVerbs();

			// Define path Cache / Data files
			$params['cache'] = base_path() . "/data/" . LANGUAGE . "/htmls/";

			$wiktionaryVerb = new WiktionaryWordVerb();
			$numVerbs = count($verbs);
			foreach ($verbs as $index=>$verb) {
				Log::info($index . '/' . $numVerbs . ': ' . $verb);
				if (WordFunctions::isValidWord($verb)) {
					$wiktionaryVerb->generateConjugationHtml($verb); // stores the html for conjugation
				}
			}

		} else {
			Log::info('No conjugations for ' . LANGUAGE);
		}

	}

}