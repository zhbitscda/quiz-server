<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
  public $incrementing = false;
  protected $table = 'cards';

  public function parkcard()
  {
    return $this->hasOne('App\Models\ParkCard', 'cardId', 'id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'userId', 'id');
  }

  public function boxdoors()
  {
    return $this->belongsToMany('App\Models\BoxDoor', 'boxDoors_cards', 'cardId', 'boxDoorId');
  }

}
