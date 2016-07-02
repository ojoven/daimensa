<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YoutubeVideoCaption extends Model {

    protected $fillable = array('lesson_id', 'caption','start', 'end', 'duration');
    public $timestamps = false;

}
