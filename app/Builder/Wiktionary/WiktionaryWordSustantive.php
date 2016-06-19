<?php

namespace App\Builder\Wiktionary;
use App\Lib\DomFunctions;

class WiktionaryWordSustantive extends WiktionaryWord {

    /** GET INFO SUSTANTIVE **/
    public function getInfoSustantive($word) {

        $wordHtml = new WiktionaryWordHtml();
        $html = $wordHtml->getHtmlWordWiktionary($word);

        // GENERE
        $info['genere'] = $this->getGenere($html);

        // MEANINGS
        $info['meanings'] = $this->getMeaningsAndExamples($html, WIKTIONARY_ID_COMMON_NAME);

        // RELATED WORDS
        $info['related'] = $this->getRelatedWords($html);

        // FORMS
        $info['forms'] = $this->getFormsSustantive($html);

        // Synonyms
        $info['synonyms'] = $this->getSynonyms($html);

        return $info;
    }

    public function getFormsSustantive($html) {

        $forms = array();

        $h3 = $html->find("#" . WIKTIONARY_ID_COMMON_NAME,0)->parent();
        if ($h3->next_sibling() && $h3->next_sibling()->tag=="table") {
            $table = $h3->next_sibling();
            foreach ($table->find('td') as $index=>$form) {

                // Singular & Plural
                if ($index==0) {
                    $forms['singular'] = $form->plaintext;
                } elseif ($index==1) {
                    $forms['plural'] = $form->plaintext;
                }
            }
        }

        return $forms;

    }


    public function getRelatedWords($html) {

        $relatedWords = array();

        $h4Child = $html->find("span[id=" . WIKTIONARY_RELATED_WORDS . "]", 0);
        if (!$h4Child) { return $relatedWords; }
        $h4 = $h4Child->parent();


        // First we have to find the UL where the related words are stored
        while ($h4->next_sibling() && $h4->next_sibling()->tag!="ul") {
            $h4 = $h4->next_sibling();
        }

        if ($h4->next_sibling() && $h4->next_sibling()->tag=="ul") { // we found it!
            $ul = $h4->next_sibling();

            foreach ($ul->find("a") as $relatedLink) {

                $relatedWord = DomFunctions::getAttributeDom($relatedLink, 'plaintext');
                if ($relatedWord) {
                    array_push($relatedWords, $relatedWord);
                }

            }
        }

        return $relatedWords;

    }


}