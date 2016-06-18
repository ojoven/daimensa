<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests;

class ApiController extends Controller {

	// LOGIN FACEBOOK
	public function postLoginfacebook() {

		$params = $_POST;
		$userModel = new User();
		$response = $userModel->loginUserFacebook($params);
		return response()->json($response);
	}

	// SAVE SETTINGS
	public function postSavesettings() {

		$params = $_POST;
		$userModel = new User();
		$response = $userModel->saveSettings($params);
		return response()->json($response);

	}

}
