<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

// Models
use App\Models\Card;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {

    public function index() {

        // If user logged in
        if (Auth::check()) {
            return view('home');
        } else {

            // Not logged home
            return view('index');
        }

    }

}
