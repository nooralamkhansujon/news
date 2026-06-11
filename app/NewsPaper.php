<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsPaper extends Model
{
    public function newsPaperPages()
    {
        return $this->hasMany('App\NewsPaperPage');
    }
}
