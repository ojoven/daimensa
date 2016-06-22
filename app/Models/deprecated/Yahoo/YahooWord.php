<?php

namespace App\Models\Yahoo;

require_once app_path() . '/Lib/Vendor/OAuthConsumer.php';

class YahooWord {

    /** SINGLE WORD INFO **/
    public function getInfoWordYahoo($word) {

        $cc_key  = CC_KEY; // defined in settings.php
        $cc_secret = CC_SECRET; // defined in settings.php
        $url = "https://yboss.yahooapis.com/ysearch/news,web,images";
        $args = array();
        $args["news.q"] = $word;
        $args["web.q"] = $word;
        $args["images.q"] = $word;
        $args["format"] = "json";
        $args["count"] = "2";

        define('LANGUAGE_MARKET_YAHOO', 'fr-fr');
        $args["market"] = LANGUAGE_MARKET_YAHOO;

        // Make the call to Yahoo endpoint via CURL
        $consumer = new \OAuthConsumer($cc_key, $cc_secret);
        $request = \OAuthRequest::from_consumer_and_token($consumer, NULL,"GET", $url, $args);
        $request->sign_request(new \OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
        $url = sprintf("%s?%s", $url, \OAuthUtil::build_http_query($args));
        $ch = curl_init();
        $headers = array($request->to_header());
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $rsp = curl_exec($ch);
        $info = json_decode($rsp);

        return $info;

    }

}