<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model {

    protected $fillable = array('lang', 'title', 'description', 'text', 'url', 'type');
    const LESSON_TYPE_YOUTUBE = 'youtube';

    /** GET LAST LESSONS **/
    public function getLastLessons() {

        $lessons = self::orderBy('created_at', 'desc')->limit(10)->get()->toArray();
        return $lessons;

    }

    /** GET LESSON FOR USER **/
    public function getLessonForUser() {

        $lessons = $this->getLastLessons();
        return (!empty($lessons)) ? array_shift($lessons) : false;

    }


}
