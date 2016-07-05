<?php
/** ===========================================
 * STEP: SAVE WORD FORMS
 * ============================================**/
// We'll save the forms for all the base words
// This means: the femenine and masculine, singular and plural of names, adjectives
// + all the verb conjugations (if available)

namespace App\Builder\Steps;

use App\Builder\FileManager;
use Log;
use Illuminate\Database\Eloquent\Model;
use App\Lib\Functions;

class SaveWordFrequencies extends Model {

	/** 1st step, get word list **/
	public function saveWordFrequencies() {

		$wordFrequencies = array();

		Log::info('Getting forms');
		$forms = json_decode(file_get_contents(base_path() . '/data/' . LANGUAGE . '/jsons/wordForms.json'), true);
		Log::info('Getting ngrams');
		$ngrams = json_decode(file_get_contents(base_path() . '/data/' . LANGUAGE . '/jsons/1grams.json'), true);
		Log::info('Getting keys for ngrams');
		$wordGrams = array_keys($ngrams);

		// Vars that will serve to check the progress of the script
		$totalForms = count($forms);
		$count = 0;

		$forms = array_slice($forms, 0, 500);

		foreach ($forms as $form => $baseWord) {
			if (in_array($form, $wordGrams)) {

				// If the key exists, we add the frequency
				if (array_key_exists($baseWord, $wordFrequencies)) {

					$wordFrequencies[$baseWord] = $wordFrequencies[$baseWord] + $ngrams[$form];

				} else {

					// If not, we populate with the form's frequency
					$wordFrequencies[$baseWord] = $ngrams[$form];

				}

				echo $count . '/' . $totalForms . ': ' . $baseWord . ' -> ' . $wordFrequencies[$baseWord] .  PHP_EOL;

			} else {

				// If the form is not in the ngrams

				if (array_key_exists($baseWord, $wordFrequencies)) {

					// Do nothing

				} else {

					// If not, we initiate it to zero
					$wordFrequencies[$baseWord] = 0;

				}

			}

			$count++;
		}

		// Let's save the JSON file
		FileManager::saveFile(base_path() . '/data/' . LANGUAGE . '/jsons/wordFrequencies_tmp.json', json_encode($wordFrequencies));

		// We'll sort the array and save it (with different number, in case it gives a memory error)
		arsort($wordFrequencies);
		FileManager::saveFile(base_path() . '/data/' . LANGUAGE . '/jsons/wordFrequencies.json', json_encode($wordFrequencies));
	}

}