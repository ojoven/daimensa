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

        $wordFrequencies = json_decode(file_get_contents(base_path() . '/data/fr/jsons/wordFrequencies.json'), true);
        $candidateWords = array();

        foreach ($words as $word) {
            if (array_key_exists($word['word'], $wordFrequencies)) {
                array_push($candidateWords, $word);
            }
        }

        asort($candidateWords);

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
