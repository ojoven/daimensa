<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model {

    protected $fillable = array('lang', 'title', 'description', 'text', 'url', 'type');
    const LESSON_TYPE_YOUTUBE = 'youtube';

    /** GET LAST LESSONS **/
    public function getLastLessons() {

        $lessons = self::orderBy('created_at', 'desc')->limit(10)->get()->toArray();
        $lessons = $this->buildLessonThumbnails($lessons);
        return $lessons;

    }

    /** GET LESSON FOR USER **/
    public function getLessonForUser() {

        $lessons = $this->getLastLessons();
        return (!empty($lessons)) ? array_shift($lessons) : false;

    }

    private function buildLessonThumbnails($lessons) {

        // We first get the IDs, as we'll be making single multiID calls to the related DB tables (optimization)
        $lessonIds = array();
        foreach ($lessons as $lesson) {
            $lessonIds[] = $lesson['id'];
        }

        /** LESSON WORDS **/
        // Let's retrieve all the words for each $lesson
        $lessonWords = LessonWord::whereIn('lesson_id', $lessonIds)->get()->toArray();
        $lessonWordAuxiliar = array();
        foreach ($lessonWords as $lessonWord) {
            $lessonId = $lessonWord['lesson_id'];
            unset($lessonWord['lesson_id']); // We don't need this info anymore
            $lessonWordAuxiliar[$lessonId][] = $lessonWord;
        }

        foreach ($lessons as &$lesson) {
            $lessonId = $lesson['id'];
            $lesson['words'] = (array_key_exists($lessonId, $lessonWordAuxiliar)) ? $lessonWordAuxiliar[$lessonId] : array();
        }

        /** LESSON CANDIDATE WORDS **/
        $lessonWordModel = new LessonWord();
        foreach ($lessons as &$lesson) {
            $lesson['candidates'] = $lessonWordModel->getCandidateWords($lesson);
        }

        /** YOUTUBE VIDEO INFO **/
        // Let's retrieve the youtube video for each $lesson
        $youtubeVideos = YoutubeVideo::whereIn('lesson_id', $lessonIds)->get()->toArray();
        $youtubeVideosAuxiliar = array();
        foreach ($youtubeVideos as $youtubeVideo) {
            $youtubeVideosAuxiliar[$youtubeVideo['lesson_id']] = $youtubeVideo;
        }

        foreach ($lessons as &$lesson) {
            $lessonId = $lesson['id'];
            if (array_key_exists($lessonId, $youtubeVideosAuxiliar)) {
                $lesson['youtube'] = $youtubeVideosAuxiliar[$lessonId];
            }
        }

        return $lessons;

    }


}
