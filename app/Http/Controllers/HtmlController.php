<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Requests;

class HtmlController extends Controller {

    public function getLoadlesson() {

        $lessonModel = new Lesson();
        $lesson = $lessonModel->getLessonForUser();
        if ($lesson['type'] == $lessonModel::LESSON_TYPE_YOUTUBE) {
            return view('partials/lesson_youtube', array('lesson' => $lesson));
        }
    }

}
