<?php

namespace App\Builder\LanguageBuilders;
use App\Builder\Builder;
use Log;

class EnBuilder extends Builder {

	// Wiktionary category urls to retrieve the words from, we'll base on grammar supra category, from where we'll retrieve
	// adjectives, adverbs, names, verbes, etc.
	// we leave out common names, etc.
	public function getCategories() {

		// Note, we'll later add WIKTIONARY_CATEGORY_BASE to each URL
		$categories = array(

			// MAIN
			'English_nouns', // common names
			'English_adjectives', // adjectives
			'English_adverbs', // adverbes
			'English_verbs', // verbes

			// ARTICLES
			'English_articles',

			// ARTICLES
			'English_adjective_comparative_forms', // comparative
			'English_adjective_superlative_forms', // possessive

			// CONJUNCTIONS / INTERJECTIONS
			'English_conjunctions', // conjunctions
			'English_determiners', // determiners
			'English_interjections', // interjections

			// EXPRESSIONS / LOCUTIONS
			'English_idioms', // idioms
			'English_informal_terms', // informal terms
			'English_phrases', // phrases

			// PREPOSITIONS
			'English_prepositions', // prepositions

			// OTHERS
			'English_contractions', // contractions
			'English_dialectal_terms', // dialectal terms

		);

		return $categories;
	}

	// We'll save, too, the words from categories that we don't want to
	// be saved on more general categories. Example, gentilics on names
	public function getInvalidCategories() {

		$categories = array(

		);

		return $categories;
	}

	public function getFrequentCategories() {

		$categories = array(

			// MAIN
			'English_nouns', // common names
			'English_adjectives', // adjectives
			'English_adverbs', // adverbes
			'English_verbs', // verbes

		);

		return $categories;
	}


}