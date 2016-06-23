<?php

namespace App\Builder\Wiktionary;
use App\Builder\SimpleHtmlDom;
use App\Lib\WordFunctions;
use App\Builder\FileManager;

class WiktionaryCategory {

    /** GET WORDS CATEGORY **/
    public function getWordsCategory($params) {

        //$params['cache_path'] = base_path() . "/data/wiktionary/expressions.json";
        //$params['url_base'] = "http://fr.wiktionary.org";
        //$params['url_first_page'] = "http://fr.wiktionary.org/w/index.php?title=Cat%C3%A9gorie:Expressions_en_fran%C3%A7ais";
        //$params['next_page'] = "page suivante";

        if (!file_exists($params['cache_path'])) {

            // Initialize
            $words = array();
            $page = 1;

            // Get first page
            $urlFirstPage = $params['url_first_page'];
            $html = SimpleHtmlDom::file_get_html($urlFirstPage);

            // Get words first page
            $pageWords = $this->_getWordsCategoryPage($html);
            echo $params['category'] . " words - page " . $page . PHP_EOL;

            // Merge words
            $words = array_merge($words, $pageWords);

            // While next page
            while (true) {

                // Log
                $page++;

                // Let's get the url of the new category page
                $url = $this->_getNextPageUrlCategoryPage($html, $params);

                // If $url false, we've reached the end, let's escape the loop
                if (!$url) {
                    break;
                }

                // Get words of the new html and add them
                $html = SimpleHtmlDom::file_get_html($url);
                $pageWords = $this->_getWordsCategoryPage($html);
                echo $params['category'] . " words - page " . $page . PHP_EOL;

                $words = array_merge($words, $pageWords);
            }

            // Let's save into the cache
            if (count($words)>0) {
                FileManager::saveFile($params['cache_path'], json_encode($words));
            }

        } else {

            // We already have the cache, let's retrieve the words from there
            $words = json_decode(file_get_contents($params['cache_path']), true);

        }

        return $words;

    }

    /** NEXT PAGE URL **/
    private function _getNextPageUrlCategoryPage($html, $params) {

        // Let's go to where the pagination is
        if (!$html) { return false; }
        $pagination = $html->find("div[id=mw-pages]", 0);

        // If no pagination, the page is not built as expected
        if (!$pagination) {
            return false;
        }

        $nextPage1 = $pagination->find('a', 1);
        $nextPage0 = $pagination->find('a', 0);

        if ($nextPage1 && $nextPage1->plaintext == $params['next_page']) {

            // Link to next page is the inner 2nd link, higher than first page
            $url = $params['url_base'] . $pagination->find('a', 1)->href;

        } else if ($nextPage0 && $nextPage0->plaintext == $params['next_page']) {

            // Link to next page is the first link, that happens on the first page of the category
            $url = $params['url_base'] . $pagination->find('a', 0)->href;

        } else {

            // No link to next page, we've reached the end
            return false;
        }

        // We have to make a little fix to the href URL
        $url = str_replace("&amp;","&",$url);

        return $url;

    }

    /** GET WORDS FOR EACH PAGE **/
    private function _getWordsCategoryPage($html) {

        // Initialize
        $words = array();

        if ($html) {

            // Let's find from where it belongs
            $content = $html->find('.mw-content-ltr', 0);
            $categoryGroups = $content->find('.mw-category-group');

            // Fallback for no category groups
            if (!$categoryGroups) {
                $categoryGroups = $categoryGroups = $content->find('ul');
            }

            foreach ($categoryGroups as $categoryGroup) {

                // Let's not retrieve from special category groups (just alphanum category groups)
                $h3 = $categoryGroup->find('h3',0);
                if (($h3 && WordFunctions::isCharacter($h3->plaintext)) || !$h3) {

                    // Let's add all links to the array
                    foreach ($categoryGroup->find('a') as $link) {
                        if ($link->class==null) {
                            array_push($words, $link->plaintext);
                        }
                    }
                }
            }

        }

        return $words;

    }

}