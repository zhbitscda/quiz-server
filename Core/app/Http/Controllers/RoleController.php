<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{

//------------------- READ ---------------------------

  /* 读操作 */
  public function read(Request $request)
  {
    if($request->has('id')){
      /* 带参数时,获取单个数据 */
      // 获取参数
      $roleId = $request->get("id");
      return $this->getInfo($roleId);
    }else{
      /* 带参数时,获取列表 */
      $page    = $request->input('page');
      $perPage = $request->input('perPage');
      return $this->getList($page, $perPage);
    }
  }

  /* 获取单个角色 */
  public function getInfo($id)
  {
    // 查找该ID的对象
    if(!$roleObject = Role::find($id)){
      //返回错误
      return $this->retError(ROLE_ID_IS_NOT_EXIST_CODE, ROLE_ID_IS_NOT_EXIST_WORD);
    }
    $permissionData = array();
    // 获取权限数据
    $permissionData = unlimitedForLayer($roleObject->permissions);
    // // 获取权限数据
    // foreach ($roleObject->permissions as $permission) {
    //   if($permission['description'] == NULL ){
    //     $permission['description'] = "";
    //   }
    //   if($permission['parentId'] == NULL || $permission['parentId'] == "0" || $permission['parentId'] == ""){
    //     $permission['parentId'] = NULL;
    //   }
    //   $permissionData[] = array(
    //     "permissionId" => $permission['id'],
    //     "name" => $permission['name'],
    //     "desc" => $permission['description'],
    //     "parentId" => $permission['parentId']
    //   );
    // }
    // 组装数据
    $data = array(
      "roleId" => $roleObject['id'],
      "name" => $roleObject['name'],
      "desc" => $roleObject['description'],
      "permissions" => $permissionData,
      "createdDate" => date("Y-m-d H:i:s",strtotime($roleObject['created_at'])),
      "updatedDate" => date("Y-m-d H:i:s",strtotime($roleObject['updated_at']))
    );
    return $this->retSuccess($data);
  }

  /* 获取操作者列表 */
  public function getList($page, $perPage)
  {
    if($page){
      $roleList = Role::paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => Role::all()->count(),
        'perPage'     => $roleList->perPage(),
        'currentPage' => $roleList->currentPage(),
        'lastPage'    => $roleList->lastPage(),
        'nextPageUrl' => $roleList->nextPageUrl() == null ? null : $roleList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $roleList->previousPageUrl() == null ? null : $roleList->previousPageUrl() . $perPagePan,
      );
    }else{
      $roleList = Role::all();
    }
    $data = array();
    foreach ($roleList as $roleObject) {

        // 获取权限数据
        $permissionData = unlimitedForLayer($roleObject->permissions);

        // // 获取权限数据
        // foreach ($roleObject->permissions as $permission) {
        //   if($permission['description'] == NULL ){
        //     $permission['description'] = "";
        //   }
        //   if($permission['parentId'] == NULL || $permission['parentId'] == "0" || $permission['parentId'] == ""){
        //     $permission['parentId'] = NULL;
        //   }
        //   $permissionData[] = array(
        //     "permissionId" => $permission['id'],
        //     "name" => $permission['name'],
        //     "desc" => $permission['description'],
        //     "parentId" => $permission['parentId']
        //   );
        // }
        // 组装数据
        $data[] = array(
          "roleId" => $roleObject['id'],
          "name" => $roleObject['name'],
          "desc" => $roleObject['description'],
          "permissions" => $permissionData,
          "createdDate" => date("Y-m-d H:i:s",strtotime($roleObject['created_at'])),
          "updatedDate" => date("Y-m-d H:i:s",strtotime($roleObject['updated_at']))
        );
    }
    return $this->retSuccess($data, $page);
  }

//------------------- CREATE ---------------------------

  /* 添加角色 */
  public function add(Request $request)
  {

  	//TODO:accessToken

  	if(!$request->has('roleName')){
      //返回错误
      return $this->retError(ROLE_NAME_IS_EMPTY_CODE, ROLE_NAME_IS_EMPTY_WORD);
  	}

  	// if(!$request->has('desc')){
  	//   //返回错误
   //    return $this->retError(-1005, "desc is empty");
  	// }

  	if(!$request->has('permissions')){
      return $this->retError(PERMISSIONS_IS_EMPTY_CODE, PERMISSIONS_IS_EMPTY_WORD);
  	}

  	// 获取请求参数
    $roleName = $request->input("roleName");
    $description = $request->input("desc");
    $permissions = $request->input("permissions");

    // 查看权限是否存在
    foreach ($permissions as $permissionId) {
      if(!Permission::find($permissionId)){
        return $this->retError(PERMISSIONS_IS_ERROR_CODE, PERMISSIONS_IS_ERROR_WORD);
      }
    }

    // 判断是否已经存在
    $count = Role::where('name', $roleName)->count();
    if($count != 0)
    {
      //返回错误
      return $this->retError(ROLE_NAME_IS_EXIST_CODE, ROLE_NAME_IS_EXIST_WORD);
    }

    // 录入角色表
    $roleObject = new Role;
    $roleObject->name = $roleName;
    $roleObject->description = $description;
    $ret = $roleObject->save();

    // 保存进数据库
    if($ret = $roleObject->save()){
      $data = array(
        'roleId' => $roleObject['id']
      );
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }

    // 添加中间关系(权限与角色)
    foreach ($permissions as $permissionId) {
      $roleObject->permissions()->attach($permissionId);
    }

    return $this->retSuccess($data);

  }

//------------------- PUT ---------------------------

  /* 修改角色 */
  public function update(Request $request)
  {

  	//TODO:accessToken

  	// roleId 不存在,返回错误
  	if(!$request->has('roleId')){
  	  //返回错误
      return $this->retError(ROLE_ID_IS_EMPTY_CODE, ROLE_ID_IS_EMPTY_WORD);
  	}

  	// 获取请求参数
    $roleId = $request->input("roleId");
    $roleName = $request->input("roleName");
    $description = $request->input("desc");
    $permissions = $request->input("permissions");

    // 查看权限是否存在
    foreach ($permissions as $permissionId) {
      if(!Permission::find($permissionId)){
        return $this->retError(PERMISSIONS_IS_ERROR_CODE, PERMISSIONS_IS_ERROR_WORD);
      }
    }

    // 查找该ID的对象
    if(!$roleObject = Role::find($roleId)){
      //返回错误
      return $this->retError(ROLE_ID_IS_NOT_EXIST_CODE, ROLE_ID_IS_NOT_EXIST_WORD);
    }

    // 判断是否已经存在
    $foundObject = Role::where('name', $roleName)->first();
    if($foundObject && $foundObject['id'] != $roleId)
    {
      //返回错误
      return $this->retError(ROLE_NAME_IS_EXIST_CODE, ROLE_NAME_IS_EXIST_WORD);
    }

    // 如果 roleName 不存在就不更新
    if($request->has('roleName')){
      $roleObject->name = $roleName;
  	}

  	// 如果 desc 不存在就不更新
  	if($request->has('desc')){
  	  $roleObject->description = $description;
  	}

    if(!$roleObject->save()){
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }

    // 如果 permissions 不存在就不更新
    if($request->has('permissions')){
  	  // 删除中间关系(权限与角色)
  	  $roleObject->permissions()->detach();

  	  foreach ($permissions as $permissionId) {
  	    $roleObject->permissions()->attach($permissionId);
  	  }
  	}

    return $this->retSuccess();

  }

//------------------- DELETE ---------------------------

  /* 删除角色 */
  public function delete(Request $request)
  {
    //TODO:accessToken

  	// roleId 不存在,返回错误
  	if(!$request->has('roleId')){
  	  //返回错误
      return $this->retError(ROLE_ID_IS_EMPTY_CODE, ROLE_ID_IS_EMPTY_WORD);
  	}

  	// 获取请求参数
    $roleId = $request->input("roleId");

    // 查找该ID的对象
    if(!$roleObject = Role::find($roleId)){
      return $this->retError(ROLE_ID_IS_NOT_EXIST_CODE, ROLE_ID_IS_NOT_EXIST_WORD);
    }

    // 判断是否有用户分配了这个角色，有的话报错
    if($roleObject->operators->count() != 0)
    {
      return $this->retError(ROLE_ID_IS_IN_USED_CODE, ROLE_ID_IS_IN_USED_WORD);
    }

    // 删除关联表
    $roleObject->permissions()->detach();

    // 删除主表
    $roleObject->delete();

    return $this->retSuccess();
  }

}
