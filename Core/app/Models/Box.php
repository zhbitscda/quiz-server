<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
  protected $table = 'boxes';

  public function boxdoors()
  {
    return $this->hasMany('App\Models\BoxDoor', 'boxId', 'id');
  }

}
