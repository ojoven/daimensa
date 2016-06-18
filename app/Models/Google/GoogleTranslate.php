<?php

namespace App\Models\Google;

class GoogleTranslate {

    public function getMultipleTranslations($fromLanguage, $word) {

        $translations = array();
        $toLanguages = explode(",", TRANSLATE_LANGUAGES);
        foreach ($toLanguages as $toLanguage) {
            $translations[$toLanguage] = $this->getTranslation($fromLanguage, $toLanguage, $word);
        }

        return $translations;

    }

    public function getTranslation($from, $to, $word) {

        $urlBase = "https://www.googleapis.com/language/translate/v2?key=" . GOOGLE_TRANSLATE_API; // API key must be defined in settings.php
        $url = $urlBase . "&q=" . urlencode($word) . "&source=" . $from . "&target=" . $to;
        $json = file_get_contents($url);

        $response = json_decode($json, true);
        return (isset($response['data']['translations'][0]['translatedText'])) ? $response['data']['translations'][0]['translatedText'] : false;

    }


}