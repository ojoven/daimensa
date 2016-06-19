<?php
define('ROOT_PATH', __DIR__ . "/");

// Settings
require_once 'loader.php';
require_once 'language.settings.php';
require_once 'settings.php';

// Here we'll set the values for the language we're building
require_once 'lib/vendor/simple_html_dom.php';

$start = 41; // starting point
for ($i=$start;$i<=100;$i++) {
    //generateOntology($i);
}

function generateOntology($i) {

    $numWords = 100000;
    $baseUrl = "https://fr.wikipedia.org/wiki/Wikip%C3%A9dia:Accueil_principal";

    $words = array();
    $urls = array();
    $usedUrls = array();

    array_push($urls, $baseUrl);
    while (count($words)<$numWords) {

        // We shuffle randomly the array of urls
        shuffle($urls);

        // We extract the first URL from it
        $url = array_shift($urls);

        // If not valid URL, continue on next loop
        if (!is_valid_url($url, $usedUrls)) continue;

        echo $url . PHP_EOL;
        array_push($usedUrls, $url);

        // We get the HTML
        try {
            $html = file_get_html($url);
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            continue; // and continue
        }

        if (!$html) continue;

        // We print to a variable the plaintext
        $text = $html->plaintext;

        // We explode and parse the words from the text
        $text = str_replace(array(',','.','?','!',';',':','"','\t','(',')','&#160;','%','[',']','<','>'),"", $text);
        $text = preg_replace('/\t|\r|\n/', '', $text);
        $pageWords = explode(" ", $text);

        foreach ($pageWords as $pageWord) {
            if (!is_valid_word($pageWord)) continue;
            $pageWord = get_valid_word($pageWord);
            if (!isset($words[$pageWord])) {
                $words[$pageWord] = 1;
            } else {
                $words[$pageWord] = $words[$pageWord] + 1;
            }
        }

        // We extract the links, too
        $pageUrlObjects = $html->find('a');
        $pageUrls = get_hrefs_from_link_objects($pageUrlObjects);

        echo count($pageUrls) . " new URLs added" . PHP_EOL;

        // And add them to the URLs array
        $urls = array_merge($urls, $pageUrls);

        echo count($words) . " words registered" . PHP_EOL;

    }

    arsort($words);
    //$words = array_reverse($words);

    file_put_contents("data/fr/ontology/words_" . $i .".json", utf8_ansi(json_encode($words)));

}

function get_valid_word($word) {
    $word = strtolower($word);
    $word = utf8_ansi($word);
    $word = (strpos($word,"'")!==FALSE) ? end(explode("'",$word)) : $word;
    $word = (strpos($word,"’")!==FALSE) ? end(explode("’",$word)) : $word;
    $word = (strpos($word,"-")!==FALSE) ? end(explode("-",$word)) : $word;
    return $word;
}

function is_valid_word($word) {

    if (strpos($word,'&')!==FALSE) return false;
    if (preg_match('/[0-9]+/', $word)) return false;
    if (trim($word)=="") return false;
    if (strlen($word)<=1) return false;
    return true;

}

function is_valid_url($url, $usedUrls) {

    if (strpos($url,'https://fr.wikipedia.org/')!==FALSE
        && strpos($url,'#')===FALSE
        && !in_array($url, $usedUrls)) {
        return true;
    } else {
        echo $url . " not valid URL" . PHP_EOL;
        return false;
    }

}

function get_hrefs_from_link_objects($linkObjects) {

    $hrefs = array();
    foreach ($linkObjects as $linkObject) {

        if (isset($linkObject->href)) {
            if (strpos($linkObject->href,"//")===FALSE) { // Internal link, let's add the base
                $linkObject->href = "https://fr.wikipedia.org" . $linkObject->href;
            }
            array_push($hrefs, $linkObject->href);
        }

    }

    return $hrefs;

}

function utf8_ansi($valor='') {

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