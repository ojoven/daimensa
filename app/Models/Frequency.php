<?php

class Frequency {

    public function getFrequentWords() {

        $path = base_path() . "/data/" . LANGUAGE . "/jsons/frequentwords.json";
        if (file_exists($path)) {
            return json_decode(file_get_contents($path),true);
        }

        echo "Retrieving words Wikipedia" . PHP_EOL;
        $wikipediaOntology = new WikipediaOntology();
        //$wordsToCompare = $wikipediaOntology->getWordsWikipedia();

        echo "Retrieving words NGrams" . PHP_EOL;
        $ngram = new NGram();
        $wordsToCompare = $ngram->getWordsNgram(1);

        echo "Retrieving words and forms" . PHP_EOL;
        $wordList = new WordList();
        $frequent = true;
        $wordsAndForms = $wordList->getWordsAndForms($frequent);

        echo "Generating auxiliar array" . PHP_EOL;
        $wordsAndFormsKeys = array_keys($wordsAndForms);

        $final = array();

        //$wordsToCompare = array_slice($wordsToCompare, 0, 1000);

        $count = 1;
        $total = count($wordsToCompare);

        foreach ($wordsToCompare as $word=>$frequency) {

            echo $count . "/" . $total . ": " . $word . PHP_EOL;
            if (in_array($word, $wordsAndFormsKeys)) {
                $belong = $wordsAndForms[$word];
                if (isset($final[$belong])) {
                    $final[$belong] += $frequency;
                } else {
                    $final[$belong] = $frequency;
                }

                echo $belong . ": " . $final[$belong] . PHP_EOL;
            }

            $count++;
        }

        arsort($final);
        file_put_contents($path, json_encode($final));

    }

}