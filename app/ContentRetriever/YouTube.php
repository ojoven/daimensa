<?php

class YouTube {

	protected $client;

	public function __construct() {

		$this->client = new Google_Client();
		$client = new Google_Client();
		$client->setApplicationName("My Application");
		$client->setDeveloperKey("MY_SIMPLE_API_KEY");


	}

	public function retrieveYouTubeVideos() {



	}

}