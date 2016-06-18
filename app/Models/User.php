<?php

namespace App\Models;

use App\Models\Image;
use App\Validators\ValidatorUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class User extends Model {

    protected $fillable = ['name', 'email', 'image', 'facebook_id', 'mother_tongue', 'languages'];

    /** GET USER **/
    public function getCurrentUser() {

        $user = Auth::user();
        if (!$user) return false;

        $user->image = $this->getImageUser($user);

        return $user;
    }

    // Facebook
    public function loginUserFacebook($params) {

        $data['success'] = true;

        // Validate that we're getting the correct params
        $validate = ValidatorUser::validateLoginFacebookUser($params);
        if (!$validate['valid']) {

            $data['success'] = false;
            $data['errors'] = $validate['errors'];
            return $data;
        }

        // Let's check if the user is logged in
        if (Auth::check()) {
            $data['success'] = false;
            $data['errors'][] = "The user is already logged in";
            return $data;
        }

        // Check if already signed up user with that facebook id
        $userByFacebookId = self::where('facebook_id', '=', $params['facebook_id'])->first();

        // If signed up, we login
        if ($userByFacebookId) {

            Auth::loginUsingId($userByFacebookId->id);
            $data['user'] = $this->getCurrentUser();

        } else {

            // If no previous user, we create a new one
            $user = self::create([
                'name' => $params['name'],
                'email' => $params['email'],
                'facebook_id' => $params['facebook_id'],
                'mother_tongue' => $this->getUserLanguageBasedOnBrowser()
            ]);

            // Handle possible error when saving the user
            if (!$user) {
                $data['success'] = false;
                $data['errors'][] = "There was a problem when creating the user";
            }

            // We also save the FB image
            $this->_saveImageFacebook($user);

            // We login
            Auth::loginUsingId($user->id);
            $data['user'] = $this->getCurrentUser();

        }

        return $data;

    }

    // Save Image Facebook
    private function _saveImageFacebook($user) {

        $facebookId = $user->facebook_id;
        $typeImage = "large";
        $url = "http://graph.facebook.com/" . $facebookId . "/picture?type=" . $typeImage;
        $image = file_get_contents($url);
        $extension = Image::getImageExtension($url);
        $fileName = $user->id . "_facebook_" . $facebookId . $extension;

        $imageModel = new Image();
        $response = $imageModel->saveImageUserFromFile($image, $fileName);

        // If image correctly saved, we save it to the database
        if ($response) {

            // We save the image reference into the database
            $user->image = $fileName;
            $user->save();
        }

        return $response;
    }

    /** LOGOUT **/
    public function logoutUser() {

        // If the user is logged, we log her out
        if ($user = Auth::user()) {

            Auth::logout();
            $data['success'] = true;
            $data['message'] = "The user was successfully logged out";

        } else {

            $data['success'] = false;
            $data['message'] = "The user wasn't logged in";
        }

        return $data;

    }

    /** IMAGES **/
    public function getImageUser($user) {

        // Return false if no image
        if (!$user->image) return false;

        $path = config('api.url') . '/img/users/';
        $image = $path . $user->image;

        return $image;
    }

    /** LANGUAGE **/
    public function getUserLanguageBasedOnBrowser() {

        $languageModel = new Language();
        $languages = $languageModel->getBaseLanguages();

        $header = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach ($header as $lang) {

            if (in_array($lang, $languages)) {
                return $lang;
                break;
            }
        }

        // If the users browser not in the base languages, we return the default (EN)
        return $languageModel->getDefaultLanguage();

    }

}