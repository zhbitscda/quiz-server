<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $table = 'roles';

  public function operators()
  {
    return $this->hasMany('App\Models\Operator', 'roleId', 'id');
  }

  public function permissions()
  {
    return $this->belongsToMany('App\Models\Permission', 'rolepermissions', 'roleId', 'permissionId');
  }

}
