<?php
define('ROOT_PATH', __DIR__ . "/");

// Settings
require_once 'loader.php';
require_once 'settings.php';

// Here we'll set the values for the language we're building
require_once 'language.settings.php';
require_once 'wiktionary.settings.php';
require_once 'lib/vendor/simple_html_dom.php';

//initializer();
playground();

// INIT
function initializer() {

    // Let's try to abstract all the process for any language, so we can easily scale it later

    // We'll have 3 steps

    // 1st step, retrieve words from the different sources we define
    // We'll retrieve them from the urls defined in wiktionary.settings.php
    //$builder = new Builder();
    //$words = $builder->getAllWordsFromCategories();

    // 2nd step, we save all the words parsed
    //$builder->saveWords($words);

    // TODO: define a good process of generating the data (for next languages)

}

function playground() {

    // Sustantive
    /**
    $word = "maison";
    $sustantive = new Sustantive();
    $info = $sustantive->getInfoSustantive($word);
    print_r($info);
    **/

    /**
    // Verb
    $word = "à-plat-ventrer";
    $verb = new Verb();
    $info = $verb->getInfoVerb($word);
    print_r($info);
    **/

    // Adjective
    /**
    $word = "abrupt";
    $adjective = new Adjective();
    $info = $adjective->getInfoAdjective($word);
    print_r($info);
    **/

    // Glosbe API
    /**
    $word = "abrupt";
    $glosbe = new Glosbe();
    $examples = $glosbe->getExamples($word, "fra", "spa");
    $translations = $glosbe->getTranslations($word, "fra", "spa");
    **/

    // Get info word
    $frequentWords = json_decode(file_get_contents(ROOT_PATH . "data/fr/jsons/frequentwords.json"), true);
    $keys = array_keys($frequentWords);
    $word = $keys[rand(0,count($keys))];
    echo $word . " " . $frequentWords[$word]. PHP_EOL;

    // Now we have the word, let's get all the info about it


}



/** **************************************************** **/

function getWordsRemovedNonBaseWords($wordForms) {

    $pathAllWordsJson = ROOT_PATH . "data/wiktionary/wordsbase.json";
    if (!file_exists($pathAllWordsJson)) {

        $baseWords = array();

        foreach ($wordForms as $wordForm) {

            if ((isset($wordForm['name']) && $wordForm['name'])
                || (isset($wordForm['verb']) && $wordForm['verb'])
                || (isset($wordForm['adjective']) && $wordForm['adjective'])
                || (isset($wordForm['adverb']) && $wordForm['adverb'])
                || (isset($wordForm['preposition']) && $wordForm['preposition'])) {

                array_push($baseWords, $wordForm['word']);
                echo $wordForm['word'] . PHP_EOL;
            }

        }

        file_put_contents($pathAllWordsJson, json_encode($baseWords));

    } else {

        $baseWords = json_decode(file_get_contents($pathAllWordsJson), true);
    }
    echo count($baseWords) . " total base words" . PHP_EOL;

    return $baseWords;

}


function getBaseWord($idDom,$html) {

    $form = $html->find("span[id=" . $idDom . "]", 0);
    if ($form) {
        $h3 = $form->parent();
        while ($h3->next_sibling() && $h3->next_sibling()->tag!="ol") {
            $h3 = $h3->next_sibling();
        }
        if ($h3->next_sibling() && $h3->next_sibling()->tag=="ol") { // Found
            $li = $h3->next_sibling()->find('li', 0);
            if ($li) {
                $a = $li->find('a', 0);
                if ($a) {
                    return $a->plaintext;
                }
            }
        }
    }

    // didn't find
    return false;

}