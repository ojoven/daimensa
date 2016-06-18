<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller {

    public function settings() {

        // If the user is not logged, we redirect him to home page
        $user = Auth::user();
        if (!$user) {
            return redirect('/');
        }

        // Else, view settings page
        return view('settings');

    }

}
