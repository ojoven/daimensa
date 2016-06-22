<?php

use Aws\S3\S3Client;

class AmazonS3 {

	protected $client;

	public function __construct() {

		$this->client = S3Client::factory(array(
			'credentials' => array(
				'key'    => config('amazon.access_key_id'),
				'secret'    => config('amazon.secret_access_key'),
			)
		));

	}

	/** UPLOAD **/
	public function uploadToBucket($bucket, $name, $data) {

		$result = $this->client->putObject(array(
			'Bucket' => $bucket,
			'Key'    => $name,
			'Body'   => $data
		));

		return $result;

	}

	/** FILE EXISTS **/
	public function fileExists($bucket, $name) {


		$info = $this->client->getObjectInfo($bucket, $name);
		return $info ? true : false;;
	}

}