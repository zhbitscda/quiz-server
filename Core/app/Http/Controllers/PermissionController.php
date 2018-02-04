<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class PermissionController extends Controller
{

//------------------- READ ---------------------------

  /* 读操作 */
  public function read(Request $request)
  {
    if($request->has('id')){
      /* 带参数时,获取单个数据 */
      // 获取参数
      $permissionId = $request->get("id");
      return $this->getInfo($permissionId);
    }else{
      return $this->getList();
    }
  }

  /* 获取单个操作者 */
  public function getInfo($id)
  {
    // 查找该ID的对象是否存在
    if(!$permissionObject = Permission::find($id)){
      return $this->retError(PERMISSION_ID_IS_NOT_EXIST_CODE, PERMISSION_ID_IS_NOT_EXIST_WORD);
    }else{
      if($permissionObject['description'] == NULL){
        $permissionObject['description'] = "";
      }
      if($permissionObject['parentId'] == NULL || $permissionObject['parentId'] == "0" || $permissionObject['parentId'] == ""){
        $permissionObject['parentId'] = NULL;
      }
      // 组装数据
      $data = array(
        'permissionId' => $permissionObject['id'],
        'name' => $permissionObject['name'],
        'desc' => $permissionObject['description'],
        'parentId' => $permissionObject['parentId']
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取权限列表 */
  public function getList()
  {
    $permissionList = Permission::all();
    $data = array();

    $ret = unlimitedForLayer($permissionList);

    return $this->retSuccess($ret);

    foreach ($permissionList as $permission) {
        if($permission['description'] == NULL ){
          $permission['description'] = "";
        }
        if($permission['parentId'] == NULL || $permission['parentId'] == "0" || $permission['parentId'] == ""){
          $permission['parentId'] = NULL;
        }
        if($permission['parentId'] = NULL){
            $retData[] = $permission;
            $this->findChild($permission['id'], $permissionList, $retData);
        }
        $data = array(
          'permissionId' => $permission['id'],
          'name' => $permission['name'],
          'desc' => $permission['description'],
          'parentId' => $permission['parentId']
        );
    }
    return $this->retSuccess($data);
  }

}
