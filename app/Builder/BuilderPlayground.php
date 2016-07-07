<?php

namespace App\Builder;

use App\Builder\Google\NGram;
use App\Builder\Wiktionary\WiktionaryWordHtml;
use Log;
use Illuminate\Database\Eloquent\Model;

// Steps
use App\Builder\Steps\SaveWordsHTML;

class BuilderPlayground extends Model {

	// Build cards for a word
	public function playground($task, $language, $additional = '') {

		// TASKS / STEPS
		switch ($task) {

			case 'test':
				echo Log::info('Woks OK: ' . $additional);
				break;

			case 'word_in_freq':
				$words = json_decode(file_get_contents(base_path() . '/data/fr/jsons/wordFrequencies.json'), true);
				echo (array_key_exists($additional, $words)) ? "YES" : "NO"; echo PHP_EOL;
				break;

			case 'word_in_ngram':
				$words = json_decode(file_get_contents(base_path() . '/data/fr/jsons/1grams.json'), true);
				echo (array_key_exists($additional, $words)) ? "YES" : "NO"; echo PHP_EOL;
				break;

			case 'base_for_form':
				$words = json_decode(file_get_contents(base_path() . '/data/fr/jsons/wordForms.json'), true);
				echo (array_key_exists($additional, $words)) ? $words[$additional] : "NO"; echo PHP_EOL;
				break;

			case 'save_single_word_html':
				echo Log::info('Save: ' . $additional);
				$step = new WiktionaryWordHtml();
				$step->saveWordHTML($additional, array('cache' => base_path() . '/data/' . LANGUAGE . '/htmls/'));
				break;

			case 'revert_ngram': // TMP
				$ngram = new NGram();
				$words = $ngram->getWordsNgram(1);
				arsort($words);
				$path = base_path() . '/data/en/jsons/1grams_2.json';
				FileManager::saveFile($path, json_encode($words));
				break;

			case 'show_generated_ngram':
				$ngram = new NGram();
				$words = $ngram->getWordsNgram(1);
				$counter = 0;
				$numWords = count($words);
				foreach ($words as $word => $frequency) {
					if ($counter>500) break;
					$counter++;
					echo $counter . '/' . $numWords . ': ' . $word . '(' . $frequency . ')' . PHP_EOL;
				}
				break;

			// Temporary
			case 'recreate_htmls_multiwords':
				$step = new SaveWordsHTML();
				$step->saveWordsMultiHTML();
				break;
		}

	}


}
