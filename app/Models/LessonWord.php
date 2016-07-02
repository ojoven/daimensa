<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonWord extends Model {

    protected $fillable = array('lesson_id', 'word', 'frequency');
    public $timestamps = false;

    protected $numWords = 10;

    public function getCandidateWords($lesson) {

        $words = $lesson['words'];

        $candidates = array();

        // To be optimized with the algorithm
        while (count($candidates) < $this->numWords && count($candidates) < count($words)) {

            $key = array_rand($words);
            $candidate = $words[$key]['word'];
            if (!in_array($candidate, $candidates)) {
                array_push($candidates, $candidate);
            }

        }

        return $candidates;
    }

}
