<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests;

class ApiController extends Controller {

	public function postLoginfacebook() {

		$params = $_POST;
		$userModel = new User();
		$response = $userModel->loginUserFacebook($params);
		return response()->json($response);
	}

}
