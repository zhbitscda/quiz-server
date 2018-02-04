<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
  protected $table = 'cars';

  public function location()
  {
    return $this->belongsTo('App\Models\CarLocation', 'locationId', 'id');
  }

  public function type()
  {
    return $this->belongsTo('App\Models\CarType', 'typeId', 'id');
  }

  public function photo()
  {
    return $this->belongsTo('App\Models\CarPhoto', 'photoId', 'id');
  }

  public function parkcards()
  {
    return $this->hasMany('App\Models\ParkCard', 'carId', 'id');
  }

}
