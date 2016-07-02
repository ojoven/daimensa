<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonWord extends Model {

    protected $fillable = array('lesson_id', 'word', 'frequency');
    public $timestamps = false;

}
