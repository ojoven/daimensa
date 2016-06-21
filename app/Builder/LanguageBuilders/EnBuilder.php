<?php

namespace App\Builder\LanguageBuilders;
use App\Builder\Builder;
use Log;

class EnBuilder extends Builder {

	protected $lang = 'en';

	// LOAD SETTINGS
	public function loadSettings() {

		$path = base_path('config/builder/' . $this->lang . "_settings.php");
		if (file_exists($path)) {
			require_once $path;
		} else {
			Log::info('You must create a ' . $this->lang . '_settings.php file on /config/builder/ folder');
			die();
		}

	}

	// Wiktionary category urls to retrieve the words from, we'll base on grammar supra category, from where we'll retrieve
	// adjectives, adverbs, names, verbes, etc.
	// we leave out common names, etc.
	public function getCategories() {

		// Note, we'll later add WIKTIONARY_CATEGORY_BASE to each URL

		$categories = array(

			// MAIN
			'Noms_communs_en_fran%C3%A7ais', // common names
			'Adjectifs_en_fran%C3%A7ais', // adjectives
			'Adverbes_en_fran%C3%A7ais', // adverbes
			'Verbes_en_fran%C3%A7ais', // verbes

			// ARTICLES
			'Articles_d%C3%A9finis_en_fran%C3%A7ais', // defined articles
			'Articles_ind%C3%A9finis_en_fran%C3%A7ais', // undefined articles
			'Articles_partitifs_en_fran%C3%A7ais', // articles partitifs

			// ADJECTIVES
			'Adjectifs_d%C3%A9monstratifs_en_fran%C3%A7ais', // demostrative adjectives
			'Adjectifs_exclamatifs_en_fran%C3%A7ais', // exclamative adjectives
			'Adjectifs_ind%C3%A9finis_en_fran%C3%A7ais', // undefined adjectives
			'Adjectifs_interrogatifs_en_fran%C3%A7ais', // interrogative adjectives
			'Adjectifs_num%C3%A9raux_en_fran%C3%A7ais', // numeral adjectives
			'Adjectifs_possessifs_en_fran%C3%A7ais', // possessive adjectives

			// CONJUNCTIONS / INTERJECTIONS
			'Conjonctions_en_fran%C3%A7ais', // conjunctions
			'Interjections_en_fran%C3%A7ais', // interjections

			// INTERROGATIVES
			'Adverbes_interrogatifs_en_fran%C3%A7ais', // adverbes interrogatives
			'Interrogatifs_en_fran%C3%A7ais', // interrogatives
			'Pronoms_interrogatifs_en_fran%C3%A7ais', // pronouns interrogatives

			// EXPRESSIONS / LOCUTIONS
			'Locutions_adjectivales_en_fran%C3%A7ais', // adjective locutions
			'Locutions_adverbiales_en_fran%C3%A7ais', // adverbial locutions
			'Locutions_conjonctives_en_fran%C3%A7ais', // conjunction locutions
			'Locutions_interjectives_en_fran%C3%A7ais', // interjection locutions
			'Locutions_nominales_en_fran%C3%A7ais', // name locutions
			'Locutions_pr%C3%A9positives_en_fran%C3%A7ais', // preposition locutions
			'Locutions_verbales_en_fran%C3%A7ais', // verb locutions
			'Locutions-phrases_en_fran%C3%A7ais', // locution phrases
			'Proverbes_en_fran%C3%A7ais', // proverbes
			'Expressions_en_fran%C3%A7ais', // expressions

			// CIRCUMLOCUTIONS
			'P%C3%A9riphrases_en_fran%C3%A7ais', // circumlocutions
			'P%C3%A9riphrases_d%C3%A9signant_des_pays_en_fran%C3%A7ais', // circumlocutions countries
			'P%C3%A9riphrases_d%C3%A9signant_des_villes_en_fran%C3%A7ais', // circumlocutions french cities

			// NEGATIONS
			'N%C3%A9gations_en_fran%C3%A7ais', // negations

			// PARTICULES
			'Particules_en_fran%C3%A7ais', // particules

			// PREPOSITIONS
			'Pr%C3%A9positions_en_fran%C3%A7ais' // prepositions

		);

		return $categories;
	}

	// We'll save, too, the words from categories that we don't want to
	// be saved on more general categories. Example, gentilics on names
	public function getInvalidCategories() {

		$categories = array(

			// MAIN
			'Gentilés_en_français', // Gentilics
			'Noms_indénombrables_en_français'

		);

		return $categories;
	}

	public function getFrequentCategories() {

		$categories = array(

			// MAIN
			'Noms_communs_en_fran%C3%A7ais', // common names
			'Adjectifs_en_fran%C3%A7ais', // adjectives
			'Adverbes_en_fran%C3%A7ais', // adverbes
			'Verbes_en_fran%C3%A7ais' // verbes

		);

		return $categories;
	}


}