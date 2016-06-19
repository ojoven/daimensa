<?php

namespace App\Models\Twitter;

use App\Lib\WordFunctions;
use Codebird\Codebird;
require_once app_path() . '/Lib/Vendor/codebird-php/src/codebird.php';

class Twitter {

    public function getTweetsForWord($word) {

        $tweets = array();

        $pathBaseTo = base_path() . "/data/" . LANGUAGE . "/tweets/";
        $pathBaseFirstChar = $pathBaseTo . "/" . WordFunctions::getFirstCharacter($word);
        $path = $pathBaseFirstChar . "/" . $word . ".json";

        if (file_exists($path)) {

            $tweets = json_decode(file_get_contents($path), true);

        } else {

            $codebird = $this->_initCodeBird();
            $reply = (array) $codebird->search_tweets('q=' . strtolower($word) . '-filter:retweets&count=10&result_type=mixed&lang=' . LANGUAGE, true);

            if (isset($reply['httpstatus']) && $reply['httpstatus']==200) {

                if (!is_dir($pathBaseFirstChar)) { mkdir($pathBaseFirstChar); }
                $tweets = json_decode(json_encode($reply['statuses']),true);

                // Just valid tweets
                $validTweets = array();
                foreach ($tweets as $tweet) {
                    if (strpos(strtolower($tweet['text']), strtolower($word))!==FALSE) {
                        array_push($validTweets, $tweet);
                    }
                }

                file_put_contents($path, json_encode($validTweets));

            }

        }

        return $tweets;

    }

    private function _initCodeBird() {

        // First time, to retrieve the bearer token
        //Codebird::setConsumerKey(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);
        //$codebird = Codebird::getInstance();
        //$reply = $codebird->oauth2_token();
        //$bearer_token = $reply->access_token;
        //echo $bearer_token;

        // Now that we have it
        Codebird::setBearerToken(TWITTER_BEARER);
        $codebird = Codebird::getInstance();

        return $codebird;
    }


}