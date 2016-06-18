<?php

namespace App\Models;

use App\Lib\WordFunctions;
use App\Models\Twitter\Twitter;
use Illuminate\Database\Eloquent\Model;

class Card extends Model {

    const MAX_NUM_EXAMPLE_CARDS = 5;

    // First word / card
    public function generateFirstCard($params) {

        $card = '<li id="welcome-card"><div class="center-vertical"><div>Welcome to<br><h2>Words.cat</h2><hr>Swipe right for new words, swipe down for new cards</div></div>';
        return $card;

    }

    // Build cards for a word
    public function generateCardsWords($words, $params) {

        $cards = ""; // We'll render HTML now

        foreach ($words as $word) {

            $card = $this->_generateCardsWord($word, $params);
            //$card .= '<div hidden>' . json_encode($word) . '</div>';
            $cards .= $card;

        }

        $cards .= $this->_getLoaderCard();

        return $cards;

    }

    private function _generateCardsWord($word, $params) {

        // Wanna check what we have to play with
        file_put_contents(base_path() . "/data/" . LANGUAGE . "/tmp/" . $word['word'] . ".json", json_encode($word));

        $cards = "";

        // If params search = true -> first card = translation
        $cardsTranslation = $this->_generateTranslationCards($word);
        $cards = $this->_addCards($cards, $cardsTranslation);

        $cardsPronunciation = $this->_generatePronunciationCards($word);
        $cards = $this->_addCards($cards, $cardsPronunciation);

        // Form bases
        $cardsFormBase = $this->_generateFormBaseCards($word);
        $cards = $this->_addCards($cards, $cardsFormBase);

        // Meanings
        $cardMeanings = $this->_generateMeaningsCards($word);
        $cards = $this->_addCards($cards, $cardMeanings);

        // Tweets
        $cardTweets = $this->_generateTweetsCards($word);
        $cards = $this->_addCards($cards, $cardTweets);

        // Examples
        $cardExamples = $this->_generateExampleCards($word);
        $cards = $this->_addCards($cards, $cardExamples);

        // Wrapper
        $cardWrapper = $this->_generateCardWrapperWord($word);
        $cards = $cardWrapper['prepend'] . $cards . $cardWrapper['append'];
        return $cards;

    }

    private function _addCards($cards, $cardsToAdd) {

        foreach ($cardsToAdd as $card) {
            $cards .= $card;
        }

        return $cards;

    }

    /** WRAPPER **/
    private function _generateCardWrapperWord($word) {

        $cardWrapper['prepend'] = '<li><div class="title"><span>' . $word['word'] . '</span></div><div class="word-slide-wrapper"><ul>';
        $cardWrapper['append'] = "</ul></div></li>";
        return $cardWrapper;

    }

    private function _generateTranslationCards($word) {

        $cards = array();

        //$supraInfo = $this->_generateSupraInformationWord($word);
        $supraCard = $this->_generateSupraInfoCard("Translation of '" . $word['word'] . "' to spanish");

        foreach ($word['general']['translations']['glosbe'] as $translation) {

            if (isset($translation['translation'])) {

                $translationText = $translation['translation'];
                $card = '<li class="card active">' . $supraCard . '<div><div class="center-vertical"><div class="translation">' . $translationText . '</div></div></div></li>';

                array_push($cards, $card);

            }

        }


        return $cards;

    }

    private function _generateExampleCards($word) {

        $cards = array();
        $supraCard = $this->_generateSupraInfoCard("Examples with translations of '" . $word['word'] . "'");

        if (!empty($word['general']['examples']['glosbe'])) {

            $examples = $this->_filterAndSortExamples($word['general']['examples']['glosbe']);

            foreach ($examples as $example) {

                $card = '<li class="card">' . $supraCard . '<div class="center-vertical"><div><span class="example example_from">' . WordFunctions::highlightWordAndFormsInText($example['from'], $word['word']) . '</span>' .
                '<i class="example_arrow fa fa-arrow-down"></i>' . '<span class="example example_to">' . $example['to'] . '</span></div></div></li>';

                array_push($cards, $card);

            }

        }

        return $cards;

    }

    /** PRONUNCIATIONS **/
    private function _generatePronunciationCards($word) {

        $cards = array();

        $supraCard = $this->_generateSupraInfoCard("Pronunciation of '" . $word['word'] . "'");

        if (count($word['general']['pronunciation']['audios'])>0) {

            $pronunciationAudio = $word['general']['pronunciation']['audios'][0];
            $pronunciationText = $word['general']['pronunciation']['text'];
            $audioId = $word['word'] . '_' . uniqid();

            $audio = '<audio id="' . $audioId . '"><source src="' . $pronunciationAudio['pathmp3'] . '" type="audio/mpeg"><source src="' . $pronunciationAudio['pathogg'] . '" type="audio/ogg"></audio>';
            $audioControls = '<div class="audio-play"><a href="#" class="fa fa-play" onclick="document.getElementById(\'' . $audioId . '\').play()"></a></div>';

            $card = '<li class="card">' . $supraCard . '<div class="center-vertical"><div><span class="audio-controls">' . $audio . $audioControls . '</span>';
            $card .= '<span class="audio-text">' . $pronunciationText . '</span>';
            $card .= '</div></div></li>';

            array_push($cards, $card);

        }

        return $cards;

    }

    /** FORMS BASE **/
    private function _generateFormBaseCards($word) {

        $cards = array();

        $supraCard = $this->_generateSupraInfoCard("Form of '" . $word['word'] . "'");

        foreach ($word['forms'] as $form) {

            switch ($form) {

                case 'form_verb':
                    $text = "Form of the verb";
                    $base = $word[$form]['verb'];
                    break;
                default:
                    $base = false;
            }

            if ($base) {

                $card = '<li class="card">' . $supraCard . '<div class="center-vertical"><div><span class="formbase-text">' . $text . '</span>';
                $card .= '<span class="formbase-base">' . $base . '</span>';
                $card .= '</div></div></li>';

                array_push($cards, $card);

            }

        }

        return $cards;

    }

    /** MEANINGS **/
    private function _generateMeaningsCards($word) {

        $cards = array();

        foreach ($word['forms'] as $form) {

            if (isset($word[$form]['meanings'])) {

                foreach ($word[$form]['meanings'] as $meaning) {

                    $meaningText = $meaning['text'];
                    $features = $meaning['features'];
                    $examples = array_slice($meaning['examples'], 0, 2);
                    $hasExamples = count($examples)>0;

                    if ($hasExamples) {
                        $supraCard = $this->_generateSupraInfoCard("Meaning of '" . $word['word'] . "' and examples");
                    } else {
                        $supraCard = $this->_generateSupraInfoCard("Meaning of '" . $word['word'] . "'");
                    }

                    $additionalMeaningClass = ($hasExamples) ? " has-examples" : "";
                    $card = '<li class="card">' . $supraCard . '<div class="center-vertical"><div><span class="meaning-text' . $additionalMeaningClass . '">' . $meaningText . '</span>';
                    foreach ($examples as $example) {
                        $card .=  '<span class="meaning-example">' . WordFunctions::highlightWordInText($example['text'], $example['highlighted']) . '</span>';
                    }
                    $card .= '</div></div></li>';

                    array_push($cards, $card);

                }


            }

        }

        return $cards;

    }

    /** TWEETS **/
    private function _generateTweetsCards($word) {

        $cards = array();
        $twitterModel = new Twitter();

        $tweets = $twitterModel->getTweetsForWord($word['word']);

        foreach ($tweets as $tweet) {

            $text = $tweet['text'];
            $text = WordFunctions::highlightWordAndFormsInText($text, $word['word']);

            $supraCard = $this->_generateSupraInfoCard("Real tweet using '" . $word['word'] . "'");

            $card = '<li class="card">' . $supraCard . '<div class="center-vertical"><div>'
            . '<img class="tweet-image" src="' . str_replace('_normal.','.',$tweet['user']['profile_image_url']) . '"/>'
            . '<span class="tweet-user">' . '@' . $tweet['user']['screen_name'] . '</span>'
            . '<span class="tweet-text">' . $text . '</span>'
            . '<i class="tweet-icon fa fa-twitter"></i>'
            . '</div></div></li>';

            array_push($cards, $card);

        }

        return $cards;

    }

    private function _generateSupraInformationWord($word) {

        $supraInfo = "";
        foreach ($word['forms'] as $form) {

            $supraInfo .= '<span class="word-form-container"><span>'. ucfirst($form) . '</span>';
            if (isset($word[$form]['genere'])) {
                $supraInfo .= '<span>' . ucfirst($word[$form]['genere']) . '</span>';
            }
            $supraInfo .= '</span>';

        }
        return $supraInfo;
    }

    private function _filterAndSortExamples($examples) {

        $examplesAuxiliar = array();
        $examplesSorted = array();

        foreach ($examples as $example) {
            array_push($examplesAuxiliar, $example['from']);
        }

        usort($examplesAuxiliar, array($this, 'stringSort'));
        $examplesAuxiliar = array_reverse($examplesAuxiliar);
        $examplesAuxiliar = array_slice($examplesAuxiliar, 0, self::MAX_NUM_EXAMPLE_CARDS);
        shuffle($examplesAuxiliar);

        foreach ($examplesAuxiliar as $exampleAuxiliar) {
            foreach ($examples as $example) {
                if ($example['from']==$exampleAuxiliar) {
                    array_push($examplesSorted, $example);
                }
            }
        }

        return $examplesSorted;

    }

    private function _generateSupraInfoCard($message) {

        return '<span class="supra-card">' . $message . '</span>';

    }

    private function _generateCardsVerbWiktionary($word) {

        $cardsVerb = array();
        if (isset($word['verb'])) {

            $verb = $word['verb'];

            // Verb meanings

        }

        return $cardsVerb;

    }


    private function _getLoaderCard() {

        return '<li class="loader"><div class="center-vertical"><div><div class="loading-gif"></div></div></div></li>';

    }

    public function stringSort($a,$b) {
        return strlen($b)-strlen($a);
    }


}
