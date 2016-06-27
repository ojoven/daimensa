<?php

namespace App\Models;

class WordList {

    /** Load all words **/
    public function getAllWords() {

        $path = base_path() . "/data/" . LANGUAGE . "/categories";
        $words = array();
        $dir = new \DirectoryIterator($path);
        foreach ($dir as $fileInfo) {
            if (!$fileInfo->isDot()) {
                $fileName = $fileInfo->getFilename();
                $category = str_replace(".json","",$fileName); // We remove the extension
                $words[$category] = json_decode(file_get_contents($path . "/" . $fileName));
            }
        }

        return $words;
    }

    /** Category **/
    public function wordBelongsToInvalidCategory($word, $words, $invalidCategories) {

        foreach ($invalidCategories as $category) {
            if (in_array($word, $words[$category])) {
                Functions::log($word . " is not valid word");
                return true;
            }
        }

        return false;

    }

    public function getAllFrequentWords() {

        $words = $this->getAllWords();
        $words = $this->mergeJustFrequentCategoryWords($words);
        return $words;

    }

    /** Mergers **/
    public function mergeJustFrequentCategoryWords($words) {

        $frequent = getFrequentCategories();
        $merged = array();
        foreach ($words as $category=>$categoryWords) {
            if (in_array($category, $frequent)) {
                $merged = array_merge($merged, $categoryWords);
            }
        }

        return $merged;

    }

    public function mergeAllCategoryWords($words) {

        $merged = array();
        foreach ($words as $category=>$categoryWords) {
            $merged = array_merge($merged, $categoryWords);
        }

        return $merged;

    }

    /** Auxiliar **/
    public function renderWordsSummary($words) {
        $count = 0;
        foreach ($words as $category=>$categoryWords) {
            Functions::log($category . " -> " . count($categoryWords) . " words");
            $count += count($categoryWords);
        }

        Functions::log($count . " total words and expressions");
    }

}