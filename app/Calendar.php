<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'meet_calendar';
    protected $fillable = ['title','start','end','user_id','status','color', 'description'];
}
