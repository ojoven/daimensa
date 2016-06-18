<?php

namespace App\Models\Wiktionary;
use App\Lib\DomFunctions;

class WiktionaryWordAdjective extends WiktionaryWord {

    /** GET INFO SUSTANTIVE **/
    public function getInfoAdjective($word) {

        $wordHtml = new WiktionaryWordHtml();
        $html = $wordHtml->getHtmlWordWiktionary($word);

        // GENERE
        $info['genere'] = $this->getGenere($html);

        // MEANINGS
        $info['meanings'] = $this->getMeaningsAndExamples($html, WIKTIONARY_ADJECTIVE);

        // RELATED WORDS
        //$info['related'] = $this->getRelatedWords($html);

        // FORMS
        $info['forms'] = $this->getFormsAdjective($html);

        // Synonyms
        $info['synonyms'] = $this->getSynonyms($html);

        // Antonyms
        $info['antonyms'] = $this->getAntonyms($html);

        // Derived
        $info['derived'] = $this->getDerived($html);


        return $info;
    }

    public function getFormsAdjective($html) {

        $forms = array();

        $h3 = $html->find("#" . WIKTIONARY_ADJECTIVE,0)->parent();
        if ($h3->next_sibling() && $h3->next_sibling()->tag=="table") {
            $table = $h3->next_sibling();
            foreach ($table->find('tr') as $indexTr=>$row) {

                // Masculine
                if ($indexTr==1) {

                    // Singular
                    $td = $row->find('td',0);
                    if ($td) {
                        if ($td->find('strong', 0)) {
                            $forms['masculine']['singular'] = $td->find('strong', 0)->plaintext;
                        }
                    }

                    // Plural
                    $td = $row->find('td',1);
                    if ($td) {
                        if ($td->find('a', 0)) {
                            $forms['masculine']['plural'] = $td->find('a', 0)->plaintext;
                        }
                    }

                }

                if ($indexTr==2) {

                    // Singular
                    $td = $row->find('td',0);
                    if ($td) {
                        if ($td->find('a', 0)) {
                            $forms['femenine']['singular'] = $td->find('a', 0)->plaintext;
                        }
                    }

                    // Plural
                    $td = $row->find('td',1);
                    if ($td) {
                        if ($td->find('a', 0)) {
                            $forms['femenine']['plural'] = $td->find('a', 0)->plaintext;
                        }
                    }

                }
            }
        }

        return $forms;

    }

    public function getDerived($html) {

        $derived = array();

        $table = DomFunctions::getNextFromParent($html, 'div', 'h4', WIKTIONARY_DERIVED);
        if ($table) {
            foreach ($table->find('li') as $li) {
                $a = $li->find('a', 0);
                if ($a && $a->class!="new") {
                    array_push($derived, DomFunctions::getAttributeDom($a,'plaintext'));
                }
            }
        }

        return $derived;

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