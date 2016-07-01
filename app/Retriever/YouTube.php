<?php

namespace App\Retriever;

class YouTube {

	protected $client;
	protected $maxResults = 50;
	protected $caption = 'closedCaption';

	public function __construct() {

		require_once base_path('vendor/google/apiclient/src/Google/autoload.php');

		$this->client = new \Google_Client();
		$this->client->setApplicationName(config('google.app_name'));
		$this->client->setDeveloperKey(config('google.api_key'));

	}

	public function retrieveYouTubeVideos() {

		$youtube= new \Google_Service_YouTube($this->client);
		$videos = $youtube->search->listSearch('id, snippet', array(
			'q' => 'maison',
			'maxResults' => $this->maxResults,
			'videoCaption' => $this->caption,
			'relevanceLanguage' => LANGUAGE,
			'type' => 'video'
		));

		print_r($videos);

	}

}