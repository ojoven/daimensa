<?php

namespace App\Lib;

use App\Models\Word;

class WordFunctions {

    /** FILTERS **/
    // Remove words that are just 1 char long
    public static function filterWordsByLength($words) {

        $validWords = array();

        foreach ($words as $word) {
            if (strlen($word)>1) {
                array_push($validWords, $word);
            }
        }

        return $validWords;

    }

    // Remove words that have an uppercase (names, abbreviations, etc.)
    public static function filterWordsByUppercase($words) {

        $validWords = array();

        foreach ($words as $word) {
            if (strtolower($word)===$word) {
                array_push($validWords, $word);
            }
        }

        return $validWords;

    }

    public static function isValidWord($word) {

        // Super simple validator, if / included in name, we won't save it
        if (strpos($word, "/")!==FALSE) {
            return false;
        } else {
            return true;
        }

    }

    /** PARSERS **/
    // Remove first part before quote word
    public static function parseWordsRemoveQuote($words) {

        $validWords = array();

        foreach ($words as $word) {
            if (strpos($word,"'")!==FALSE) {
                $word = end(explode("'", $word));
            }
            array_push($validWords, $word);
        }

        return $validWords;

    }

    /** AUXILIAR **/
    public static function getFirstCharacter($word) {
        $firstCharacter = mb_substr($word, 0, 1, 'utf-8');
        return $firstCharacter;
    }

    public static function isCharacter($char) {

        if (preg_match("/^[a-zA-Z]$/", $char)) {
            return true;
        } else {
            return false;
        }
    }

    public static function specialtrim($string) {

        $string = str_replace("&#160;", " ", $string);
        $string = str_replace(" /", "/", $string);
        $string = str_replace("/ ", "/", $string);
        $string = trim($string);
        return $string;

    }

    /** LOGGER **/
    public static function printWords($words) {

        // Super simple logger
        foreach ($words as $word) {
            Functions::log($word);
        }

        Functions::log(count($words) . " total words");
    }

    /** ONTOLOGY **/
    public static function isValidWordOntology($word) {

        if (strpos($word,'&')!==FALSE) return false;
        if (preg_match('/[0-9]+/', $word)) return false;
        if (trim($word)=="") return false;
        if (strlen($word)<=1) return false;
        return true;

    }

    public static function getValidWordOntology($word) {

        $word = strtolower($word);
        $word = self::utf8_ansi($word);
        $word = (strpos($word,"'")!==FALSE) ? end(explode("'",$word)) : $word;
        $word = (strpos($word,"’")!==FALSE) ? end(explode("’",$word)) : $word;
        $word = (strpos($word,"-")!==FALSE) ? end(explode("-",$word)) : $word;
        return $word;

    }

    public static function utf8_ansi($valor='') {

        $utf8_ansi2 = array(
            "\u00c0" =>"À",
            "\u00c1" =>"Á",
            "\u00c2" =>"Â",
            "\u00c3" =>"Ã",
            "\u00c4" =>"Ä",
            "\u00c5" =>"Å",
            "\u00c6" =>"Æ",
            "\u00c7" =>"Ç",
            "\u00c8" =>"È",
            "\u00c9" =>"É",
            "\u00ca" =>"Ê",
            "\u00cb" =>"Ë",
            "\u00cc" =>"Ì",
            "\u00cd" =>"Í",
            "\u00ce" =>"Î",
            "\u00cf" =>"Ï",
            "\u00d1" =>"Ñ",
            "\u00d2" =>"Ò",
            "\u00d3" =>"Ó",
            "\u00d4" =>"Ô",
            "\u00d5" =>"Õ",
            "\u00d6" =>"Ö",
            "\u00d8" =>"Ø",
            "\u00d9" =>"Ù",
            "\u00da" =>"Ú",
            "\u00db" =>"Û",
            "\u00dc" =>"Ü",
            "\u00dd" =>"Ý",
            "\u00df" =>"ß",
            "\u00e0" =>"à",
            "\u00e1" =>"á",
            "\u00e2" =>"â",
            "\u00e3" =>"ã",
            "\u00e4" =>"ä",
            "\u00e5" =>"å",
            "\u00e6" =>"æ",
            "\u00e7" =>"ç",
            "\u00e8" =>"è",
            "\u00e9" =>"é",
            "\u00ea" =>"ê",
            "\u00eb" =>"ë",
            "\u00ec" =>"ì",
            "\u00ed" =>"í",
            "\u00ee" =>"î",
            "\u00ef" =>"ï",
            "\u00f0" =>"ð",
            "\u00f1" =>"ñ",
            "\u00f2" =>"ò",
            "\u00f3" =>"ó",
            "\u00f4" =>"ô",
            "\u00f5" =>"õ",
            "\u00f6" =>"ö",
            "\u00f8" =>"ø",
            "\u00f9" =>"ù",
            "\u00fa" =>"ú",
            "\u00fb" =>"û",
            "\u00fc" =>"ü",
            "\u00fd" =>"ý",
            "\u00ff" =>"ÿ");

        return strtr($valor, $utf8_ansi2);

    }

    /** LANGUAGES **/
    public static function get3CodeLanguageFrom2Code($code2) {

        // TODO: Lots to be added yet
        $arrayLanguages = array(
            'es' => 'spa',
            'en' => 'eng',
            'fr' => 'fra',
            'it' => 'ita'
        );

        return (isset($arrayLanguages[$code2])) ? $arrayLanguages[$code2] : false;
    }

    /** HIGHLIGHT **/
    public static function highlightWordAndFormsInText($text, $word) {

        $wordModel = new Word();
        $forms = $wordModel->getWordForms($word);

        foreach ($forms as $form) {

            // To avoid double highlighting
            $text = str_replace('<span class="highlight">' . $form . '</span>', $form, $text);
            $text = str_replace('<span class="highlight">' . ucfirst($form) . '</span>', ucfirst($form), $text);

            // Highlight
            $text = str_replace($form, '<span class="highlight">' . $form . '</span>', $text);
            $text = str_replace(ucfirst($form), '<span class="highlight">' . ucfirst($form) . '</span>', $text);

        }

        $text .= "<span hidden>" . json_encode($forms) . "</span>";

        return $text;

    }

    public static function highlightWordInText($text, $word) {

        $text = str_replace($word, '<span class="highlight">' . $word . '</span>', $text);
        return $text;

    }


}