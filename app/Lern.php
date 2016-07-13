<?php

namespace App;

use Tylercd100\LERN\Models\ExceptionModel;

class Lern extends ExceptionModel
{
   	public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
