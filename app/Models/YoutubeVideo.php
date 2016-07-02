<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YoutubeVideo extends Model {

    protected $fillable = array('lesson_id','youtube_id', 'channel_id', 'duration', 'proportion_words','definition', 'view_count', 'like_count', 'dislike_count', 'favorite_count', 'comment_count', 'published_date');
    public $timestamps = false;

}
