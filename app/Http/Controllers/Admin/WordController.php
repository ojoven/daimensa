<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WordController extends Controller {

	public function index() {

		if (!$this->isValidAdminAccess()) return view('admin/lock');

		return view('admin/words');

	}

}