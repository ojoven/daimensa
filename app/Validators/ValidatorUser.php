<?php

namespace App\Validators;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ValidatorUser extends Model {

    // LOGIN FACEBOOK
    public static function validateLoginFacebookUser($params) {

        $validator = Validator::make($params, [
            'name' => 'required',
            'email' => 'required|email|max:255',
            'facebook_id' => 'required|min:12',
        ]);

        return self::buildValidateResponse($validator);
    }

    // Auxiliar
    public static function buildValidateResponse($validator) {

        $validatorFails = $validator->fails();
        $validate['valid'] = !$validatorFails;

        if ($validatorFails) {
            $validate['errors'] = $validator->errors()->all();
        }

        return $validate;

    }

}