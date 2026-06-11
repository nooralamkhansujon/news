<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsPaperPage extends Model
{
    public function newsPaper(){
        return $this->belongsTo('App\NewsPaper');
    }
    
    public function newsPaperPageFrames(){
        return $this->hasMany('App\NewsPaperPageFrame');
    }
}
