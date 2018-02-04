<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
  protected $table = 'operators';

  public function role()
  {
    return $this->belongsTo('App\Models\Role', 'roleId');
  }
}
