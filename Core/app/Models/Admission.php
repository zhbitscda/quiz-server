<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $table = 'admission';

    public function parkcard()
    {
      return $this->belongsTo('App\Models\ParkCard', 'cardId', 'cardId');
    }

}
