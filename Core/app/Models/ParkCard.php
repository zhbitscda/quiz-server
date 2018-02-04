<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkCard extends Model
{
  public $incrementing = false;

  protected $primaryKey = 'cardId';

  protected $table = 'parkCards';

  public function card()
  {
    return $this->belongsTo('App\Models\Card', 'cardId', 'id');
  }

  public function car()
  {
    return $this->belongsTo('App\Models\Car', 'carId', 'id');
  }

  public function cardType()
  {
    return $this->belongsTo('App\Models\ParkCardType', 'typeId', 'id');
  }

}
