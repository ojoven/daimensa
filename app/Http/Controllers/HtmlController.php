<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Bunch;
use App\Models\Card;
require_once app_path() . '/Lib/Vendor/simple_html_dom.php';
require_once base_path() . '/config/settings.php';

class HtmlController extends Controller {

    public function getNonLoggedHome() {

        $_SESSION['fromLanguage'] = "fr";
        $_SESSION['toLanguage'] = "es";

        $bunchModel = new Bunch();
        $cardModel = new Card();

        $params['numWords'] = 2;
        $params['numCards'] = 2;
        $cards = $bunchModel->getBunchCards($params);
        $firstCard = $cardModel->generateFirstCard($params);
        $cards = $firstCard . $cards;
        return $cards;
    }

    public function test() {
        echo "eee";
    }

    public function getLoadcards() {

        $_SESSION['fromLanguage'] = "fr";
        $_SESSION['toLanguage'] = "es";

        $bunchModel = new Bunch();
        $params['numWords'] = 6;
        $params['numCards'] = 2;
        $cards = $bunchModel->getBunchCards($params);
        return $cards;
    }

}
