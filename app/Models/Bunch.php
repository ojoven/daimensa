<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Word;
use App\Models\Card;

class Bunch extends Model {

    // Build cards for a word
    public function getBunchCards($params) {

        // TODO: Retrieve cards if user logged / depending on list, etc.
        // If user logged, we'll get previous cards to avoid duplication and optimize randomness
        $wordModel = new Word();
        $words = $wordModel->getBunchWords($params);
        $cardModel = new Card();
        $cards = $cardModel->generateCardsWords($words, $params);

        return $cards;


    }

}
