<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller {

	public function dashboard() {

		if (!$this->isValidAdminAccess()) return view('admin/lock');

		return view('admin/dashboard');
	}

	public function getLogout() {

		if (!$this->isValidAdminAccess()) return view('admin/lock');

		unset($_SESSION['password']); // We remove the session credentials

		return view('admin/lock');
	}

}