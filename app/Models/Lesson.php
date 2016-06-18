<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model {

    /** GET LAST CONTENTS **/
    public function getLastLessons() {

        $lessons = self::orderBy('created_at', 'desc')->limit(10)->toArray();
        return $lessons;

    }


}
