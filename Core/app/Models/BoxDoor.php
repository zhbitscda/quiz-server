<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxDoor extends Model
{
  protected $table = 'boxDoors';

  public function parkcards()
  {
    return $this->belongsToMany('App\Models\ParkCard', 'boxDoors_cards', 'boxDoorId', 'cardId');
  }

  public function devices()
  {
    return $this->hasMany('App\Models\Device', 'boxDoorId', 'id');
  }

  public function box()
  {
    return $this->belongsTo('App\Models\Box', 'boxId', 'id');
  }

}
