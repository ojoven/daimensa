<?php

namespace App\Retriever;

use App\Lib\Functions;
use App\Models\Lesson;
use App\Models\LessonWord;
use App\Models\YoutubeVideo;
use App\Models\YoutubeVideoCaption;
use Log;
use DB;

class YouTube {

	protected $client;
	protected $youtube;
	protected $caption = 'closedCaption';

	protected $maxResults = 30;
	protected $maxPages = 5;
	protected $minLengthValidCaption = 600;

	protected $captionUrlBase = 'https://www.youtube.com/api/timedtext';
	protected $videoUrlBase = 'https://www.youtube.com/watch';

	public function __construct() {

		require_once base_path('vendor/google/apiclient/src/Google/autoload.php');

		$this->client = new \Google_Client();
		$this->client->setApplicationName(config('google.app_name'));
		$this->client->setDeveloperKey(config('google.api_key'));

	}

	/** MAIN: GET VIDEOS YOUTUBE **/
	public function retrieveYouTubeVideos() {

		$this->youtube = new \Google_Service_YouTube($this->client);

		$word = $this->_getYoutubeSearchQueryWord();

		for ($i = 0; $i < $this->maxPages; $i++) {

			Log::info('Getting page ' . ($i + 1) . ' for word ' . $word);

			$options = array(
				'q' => $word,
				'maxResults' => $this->maxResults,
				'videoCaption' => $this->caption,
				'relevanceLanguage' => LANGUAGE,
				'type' => 'video',
				'videoEmbeddable' => 'true'
			);

			if (isset($nextPageToken) && $nextPageToken) {
				$options['pageToken'] = $nextPageToken;
			}

			// Get the result from API
			$result = $this->youtube->search->listSearch('id, snippet', $options);
			$videos = $result['items'];

			// If no more videos retrieved, return
			if (empty($videos)) break;

			// We get the token for the next page's call
			$nextPageToken = (isset($result['nextPageToken'])) ? $result['nextPageToken'] : null;

			// Parse videos (just the info we want)
			$videos = $this->_parseVideos($videos);

			// Add video statistics to videos
			Log::info('Add video statistics to videos');
			$videos = $this->_addVideoListStatistics($videos);

			// Add the captions
			Log::info('Add captions to videos');
			$videos = $this->_addVideoCaptions($videos);

			// We save the videos
			Log::info('Save videos');
			$this->_saveVideos($videos);

		}

	}

	/** GET "RANDOM" QUERY WORD **/
	private function _getYoutubeSearchQueryWord() {

		// We get a random word from frequency 100 to 10.000
		return 'marché';
	}

	/** PARSE VIDEOS **/
	private function _parseVideos($videosNotParsed) {

		$videos = array(); // We'll save just the info that's interesting for us

		foreach ($videosNotParsed as $videoNotParsed) {

			$video['id'] = $videoNotParsed['id']['videoId'];
			$video['date'] = $videoNotParsed['snippet']['publishedAt'];
			$video['channelId'] = $videoNotParsed['snippet']['channelId'];
			$video['title'] = $videoNotParsed['snippet']['title'];
			$video['description'] = $videoNotParsed['snippet']['description'];

			$videos[] = $video;
		}

		return $videos;
	}

	/** ADD VIDEO ADDITIONAL INFO **/
	// Video Statistics
	private function _addVideoListStatistics($videos) {

		if (empty($videos)) return $videos;

		// First, we retrieve the video ids
		$videoIds = array();
		foreach ($videos as $video) {
			$videoIds[] = $video['id'];
		}

		// Now we make a new call to the YouTube API
		$options = array(
			'id' => implode(',', $videoIds)
		);

		$result = $this->youtube->videos->listVideos('statistics,contentDetails', $options);

		if ($result && isset($result['items'])) {

			$videoStatistics = array();

			// First we'll save the data we want in an array
			foreach ($result['items'] as $item) {

				$videoStatistics[$item['id']] = array(
					'duration' => Functions::ISO8601ToUnixTime($item['contentDetails']['duration']),
					'definition' => $item['contentDetails']['definition'],
					'viewCount' => $item['statistics']['viewCount'],
					'likeCount' => $item['statistics']['likeCount'],
					'dislikeCount' => $item['statistics']['dislikeCount'],
					'favoriteCount' => $item['statistics']['favoriteCount'],
					'commentCount' => $item['statistics']['commentCount'],
				);

			}

			// Now, we add that information to the main $videos array
			foreach ($videos as &$video) {
				$video = array_merge($video, $videoStatistics[$video['id']]);
			}

		}

		return $videos;

	}

	// Video Captions
	private function _addVideoCaptions($videos) {

		foreach ($videos as &$video) {

			Log::info('Retrieving captions for ' . $video['id'] . ' -> ' . $video['title']);

			$urlCaptions = $this->captionUrlBase . '?v=' . $video['id'] . '&lang=' . LANGUAGE;
			$xml = file_get_contents($urlCaptions);

			$video['caption']['text'] = $this->_extractTextFromCaptions($xml);
			$video['caption']['words'] = $this->_extractWordsFromCaptionText($video['caption']['text']);
			$video['caption']['captions'] = $this->_extractCaptionsFromXML($xml);
			$video['proportion_words'] = strlen($video['caption']['text'] / $video['duration']);

		}

		return $videos;
	}

	private function _extractTextFromCaptions($xml) {

		$xml = str_replace('<text',' <text', $xml); // we add spaces for the next strip tags
		$text = strip_tags($xml); // we remove the tags
		$text = str_replace(PHP_EOL, ' ', $text); // we remove the break lines
		$text = $this->decodeHtmlEnt($text);
		$arrayStopWords = array(',', '.', ':', ';', '(', ')', '!', '¡', '?', '¿', '*', '|', '@', '#', '/', '[', ']', '{', '}', '\\', '<', '>', '_', '+', '~', '%', '=');
		$text = str_replace($arrayStopWords, ' ', $text); // we remove special characters
		$text = preg_replace('/\s+/', ' ', $text); // remove extra whitespaces

		return $text;
	}

	private function decodeHtmlEnt($str) {
		$ret = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
		$p2 = -1;
		for(;;) {
			$p = strpos($ret, '&#', $p2+1);
			if ($p === FALSE)
				break;
			$p2 = strpos($ret, ';', $p);
			if ($p2 === FALSE)
				break;

			if (substr($ret, $p+2, 1) == 'x')
				$char = hexdec(substr($ret, $p+3, $p2-$p-3));
			else
				$char = intval(substr($ret, $p+2, $p2-$p-2));

			//echo "$char\n";
			$newchar = iconv(
				'UCS-4', 'UTF-8',
				chr(($char>>24)&0xFF).chr(($char>>16)&0xFF).chr(($char>>8)&0xFF).chr($char&0xFF)
			);
			//echo "$newchar<$p<$p2<<\n";
			$ret = substr_replace($ret, $newchar, $p, 1+$p2-$p);
			$p2 = $p + strlen($newchar);
		}
		return $ret;
	}


	private function _extractWordsFromCaptionText($text) {

		// Some more parsing and filters to extract the words
		$text = strtolower($text); // we lower the cases

		// COMMON
		$text = preg_replace('/[0-9]+/', ' ', $text);

		// FRENCH CUSTOM
		$arrayLiaisons = array('s\'', 'm\'', 't\'', 'd\'', 's\'', 'n\'', 'l\'', ' qu\'');
		$text = str_replace($arrayLiaisons, ' ', $text); // we remove liaisons

		$text = preg_replace('/\s+/', ' ', $text); // remove extra whitespaces

		$wordsAndFrequency = array();

		$words = explode(' ', $text);
		foreach ($words as $word) {

			$word = trim($word);

			if ($word != "") {

				if (isset($wordsAndFrequency[$word])) {
					$wordsAndFrequency[$word] = $wordsAndFrequency[$word] + 1;
				} else {
					$wordsAndFrequency[$word] = 1;
				}

				// Custom case, the word is composed and uses dashes
				// We save the words both composed and splitted
				if (strpos($word, '-')!==false) {
					$wordLemmas = explode('-', $word);
					foreach ($wordLemmas as $wordLemma) {

						if (isset($wordsAndFrequency[$wordLemma])) {
							$wordsAndFrequency[$wordLemma] = $wordsAndFrequency[$wordLemma] + 1;
						} else {
							$wordsAndFrequency[$wordLemma] = 1;
						}

					}
				}

			}

		}

		// We sort the words from more frequent to less
		arsort($wordsAndFrequency);

		return $wordsAndFrequency;

	}

	private function _extractCaptionsFromXML($xmlString) {

		$finalCaptions = array();
		$xml = simplexml_load_string($xmlString);

		if (isset($xml->text)) { // Valid XML?

			foreach ($xml->text as $caption) {

				$finalCaption['caption'] = (string) $caption[0];
				foreach ($caption->attributes() as $attribute=>$value) {
					$finalCaption[$attribute] = (string) $value;
				}
				$finalCaption['end'] = (isset($finalCaption['start']) && isset($finalCaption['dur'])) ? $finalCaption['start'] + $finalCaption['dur'] : 0;
				$finalCaption['dur'] = (isset($finalCaption['dur'])) ? $finalCaption['dur'] : 0;
				$finalCaptions[] = $finalCaption;

			}

		}

		return $finalCaptions;

	}

	/** SAVE VIDEOS TO DB **/
	private function _saveVideos($videos) {

		foreach ($videos as $video) {


			if (!$this->_isValidYoutubeVideo($video)) continue; // We won't save existing / invalid videos

			DB::transaction(function($video) use ($video) {

				// SAVE THE LESSON
				$lessonDb = array(
					'lang' => LANGUAGE,
					'title' => $video['title'],
					'description' => $video['description'],
					'text' => $video['caption']['text'],
					'url' => $this->videoUrlBase . '?v=' . $video['id'],
					'type' => Lesson::LESSON_TYPE_YOUTUBE
				);

				$lesson = Lesson::create($lessonDb);

				$lessonId = $lesson->id;

				// SAVE THE CUSTOM YOUTUBE VIDEO PARAMS

				$youtubeVideoDb = array(
					'lesson_id' => $lessonId,
					'youtube_id' => $video['id'],
					'channel_id' => $video['channelId'],
					'duration' => $video['duration'],
					'proportion_words' => $video['proportion_words'],
					'definition' => $video['definition'],
					'view_count' => $video['viewCount'],
					'like_count' => $video['likeCount'],
					'dislike_count' => $video['dislikeCount'],
					'favorite_count' => $video['favoriteCount'],
					'comment_count' => $video['commentCount'],
					'published_date' => $video['date'],
				);

				YoutubeVideo::create($youtubeVideoDb);

				// SAVE THE WORDS
				foreach ($video['caption']['words'] as $word => $frequency) {

					$lessonWordDb = array(
						'lesson_id' => $lessonId,
						'word' => $word,
						'frequency' => $frequency,
					);

					LessonWord::create($lessonWordDb);
				}

				// SAVE THE VIDEO CAPTIONS

				foreach ($video['caption']['captions'] as $caption) {

					$captionDb = array(
						'lesson_id' => $lessonId,
						'caption' => $caption['caption'],
						'start' => $caption['start'],
						'end' => $caption['end'],
						'duration' => $caption['dur'],
					);

					YoutubeVideoCaption::create($captionDb);
				}

			});



		}

	}

	private function _isValidYoutubeVideo($video) {

		// Check if it already exists
		$existingVideo = YoutubeVideo::where('youtube_id', '=', $video['id'])->first();
		if ($existingVideo) {
			Log::info('The video ' . $video['id'] . ' is already stored');
			return false;
		}

		// Check if the captions XML are valid (for the language)
		if (empty($video['caption']['captions'])) {
			Log::info('The video ' . $video['id'] . ' has not valid captions');
			return false;
		}

		// Let's check if the caption is long enough
		$lengthCaption = strlen($video['caption']['text']);
		if ($lengthCaption < $this->minLengthValidCaption) {
			Log::info('The caption for video ' . $video['id'] . ' is not long enough');
			return false;
		}

		return true;

	}

}