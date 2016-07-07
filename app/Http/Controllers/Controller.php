<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /** IS VALID ADMIN ACCESS **/
    // We're using this access control temporarily, building a full ACL system will take us some more time
    // and this will serve for the moment (we haven't even launched)
    public function isValidAdminAccess() {

        session_start();

        // The password is not defined as GET param, nor we have it on session
        if (!isset($_GET['password']) && !isset($_SESSION['password'])) {
            return false;
        }

        // We'll get the password from GET parameter or Session variable
        $password = isset($_GET['password']) ? $_GET['password'] : $_SESSION['password'];
        if ($password !== config('admin.password')) {
            return false;
        }

        // At this point, the password exists and is correct
        $_SESSION['password'] = $password; // We save the password in session so we don't have to add it to every admin call
        return true;

    }
}
