<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

    protected $defaultLanguage = 'en';

    // BASE LANGUAGES
    public function getBaseLanguages() {

        $languages = array('en', 'es', 'fr', 'it', 'de');
        return $languages;
    }

    // DEFAULT
    public function getDefaultLanguage() {

        return $this->defaultLanguage;

    }

}