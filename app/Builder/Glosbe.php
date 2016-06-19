<?php

namespace App\Models\Others;
use App\Lib\WordFunctions;

// This is a dictionary API from https://glosbe.com/a-api
// Codes used for $from and $to params -> ISO 693-3 https://en.wikipedia.org/wiki/List_of_ISO_639-3_codes

class Glosbe {

    /** TRANSLATIONS **/
    public function getTranslations($word, $from, $to) {

        $pathBaseTo = base_path() . "/data/" . $from . "/glosbe/translations/" . $to;
        $pathBaseFirstChar = $pathBaseTo . "/" . WordFunctions::getFirstCharacter($word);
        $path = $pathBaseFirstChar . "/" . $word . ".json";

        if (file_exists($path)) {

            $translations = json_decode(file_get_contents($path), true);

        } else {

            $baseUrl = "https://glosbe.com/gapi";

            // We have to parse "en" to "eng", "es" to "spa", etc
            $from3 = WordFunctions::get3CodeLanguageFrom2Code($from);
            $to3 = WordFunctions::get3CodeLanguageFrom2Code($to);

            $url = $baseUrl . "/translate?from=" . $from3 . "&dest=" . $to3 . "&phrase=" . $word . "&format=json";
            $jsonResponse = file_get_contents($url);
            $response = json_decode($jsonResponse, true);

            $translations = array();

            if ($response['result'] == "ok" && isset($response['tuc'])) {
                $translationsResponse = $response['tuc'];
                foreach ($translationsResponse as $translation) {

                    if (isset($translation['phrase']['text'])) {
                        $parsedTranslation['translation'] = $translation['phrase']['text'];
                    }
                    $parsedTranslation['meanings'] = $this->_getMeaningsByCode($translation);

                    array_push($translations, $parsedTranslation);

                }
            }

            // Save to cache (and create directories if needed)
            if (!is_dir($pathBaseTo)) { mkdir($pathBaseTo); }
            if (!is_dir($pathBaseFirstChar)) { mkdir($pathBaseFirstChar); }
            file_put_contents($path, json_encode($translations));

        }


        return $translations;

    }

    /** EXAMPLES **/
    public function getExamples($word, $from, $to) {

        $pathBaseTo = base_path() . "/data/" . $from . "/glosbe/examples/" . $to;
        $pathBaseFirstChar = $pathBaseTo . "/" . WordFunctions::getFirstCharacter($word);
        $path = $pathBaseFirstChar . "/" . $word . ".json";

        if (file_exists($path)) {

            $examples = json_decode(file_get_contents($path), true);

        } else {

            $baseUrl = "https://glosbe.com/gapi";

            // We have to parse "en" to "eng", "es" to "spa", etc
            $from3 = WordFunctions::get3CodeLanguageFrom2Code($from);
            $to3 = WordFunctions::get3CodeLanguageFrom2Code($to);

            $url = $baseUrl . "/tm?from=" . $from3 . "&dest=" . $to3 . "&phrase=" . $word . "&format=json";

            $jsonResponse = file_get_contents($url);
            $response = json_decode($jsonResponse, true);

            $examples = array();

            if ($response['result'] == "ok" && isset($response['examples'])) {

                foreach ($response['examples'] as $example) {

                    $parsedExample = array(
                        'from' => $example['first'],
                        'to' => $example['second'],
                    );
                    array_push($examples, $parsedExample);

                }

                // Save to cache (and create directories if needed)
                if (!is_dir($pathBaseTo)) { mkdir($pathBaseTo); }
                if (!is_dir($pathBaseFirstChar)) { mkdir($pathBaseFirstChar); }
                file_put_contents($path, json_encode($examples));

            }

        }

        return $examples;

    }

    /** AUXILIAR **/
    private function _getMeaningsByCode($meanings) {

        $meaningsByCode = array();

        if (!isset($meanings['meanings'])) return $meaningsByCode;

        foreach ($meanings['meanings'] as $meaning) {

            if (!isset($meaningsByCode[$meaning['language']])) {
                $meaningsByCode[$meaning['language']] = array();
            }

            array_push($meaningsByCode[$meaning['language']], $meaning['text']);

        }

        return $meaningsByCode;

    }

}