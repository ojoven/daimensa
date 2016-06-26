<?php

class YouTube {

	protected $client;

	public function __construct() {

		$this->client = new Google_Client();
		$this->client->setApplicationName(config('google.app_name'));
		$this->client->setDeveloperKey(config('google.api_key'));

	}

	public function retrieveYouTubeVideos() {

		$service = new Google_Service_YouTube($this->client);
		$service->search();


	}

}