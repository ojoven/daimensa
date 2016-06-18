<?php

namespace App\Models\Forvo;

class Forvo {

    public function getPronunciationsWord($word, $language) {

        $pronunciations = array();

        $url = "http://apifree.forvo.com/key/" . FORVO_API . "/format/json/action/word-pronunciations/word/" . $word . "/language/" . $language . "/order/rate-desc";
        $json = file_get_contents($url);
        $response = json_decode($json, true);

        if (isset($response['items'])) {
            $pronunciations = $response['items'];
        }

        return $pronunciations;

    }


}