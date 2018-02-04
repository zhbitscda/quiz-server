<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Operator;
use App\Models\Box;
use App\Models\Login;
use OAuth2;



class OperatorController extends Controller
{

//------------------- LOGIN ---------------------------


  /* 登出 */
  public function logout(Request $request)
  {
    if($request->has('access_token')){
      $accessToken = $request->input("access_token");
      //返回操作信息
      return $this->retSuccess();
    }else{
      //返回错误
      return $this->retError(ACCESSTOKEN_IS_EMPTY_CODE, ACCESSTOKEN_IS_EMPTY_WORD);
    }
  }

//------------------- READ ---------------------------

  /* 读操作 */
  public function read(Request $request)
  {
    if($request->has('id')){
      /* 带参数时,获取单个数据 */
      // 获取参数
      $operatorId = $request->get("id");
      return $this->getInfo($operatorId);
    }else{
      /* 带参数时,获取列表 */
      $page    = $request->input('page');
      $perPage = $request->input('perPage');
      return $this->getList($page, $perPage);
    }
  }

  /* 获取单个操作者 */
  public function getInfo($id)
  {
    // 查找该ID的对象是否存在
    if(!$operatorObject = Operator::find($id)){
      return $this->retError(OPERATOR_ID_IS_NOT_EXIST_CODE, OPERATOR_ID_IS_NOT_EXIST_WORD);
    }else{
      // 组装数据
      $data = array(
        'operatorId' => $operatorObject['id'],
        'name' => $operatorObject['name'],
        'roleId' => $operatorObject['roleId'],
        'roleName' => $operatorObject->role['name'],
        //'role'  => $this->getRoleInfo($operatorObject['roleId']),
        'createdDate' => date("Y-m-d H:i:s",strtotime($operatorObject['created_at'])),
        'updatedDate' => date("Y-m-d H:i:s",strtotime($operatorObject['updated_at'])),
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取操作者列表 */
  public function getList($page, $perPage)
  {
    if($page){
      $operatorList = Operator::paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => Operator::all()->count(),
        'perPage'     => $operatorList->perPage(),
        'currentPage' => $operatorList->currentPage(),
        'lastPage'    => $operatorList->lastPage(),
        'nextPageUrl' => $operatorList->nextPageUrl() == null ? null : $operatorList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $operatorList->previousPageUrl() == null ? null : $operatorList->previousPageUrl() . $perPagePan,
      );
    }else{
      $operatorList = Operator::all();
    }
    $data = array();
    foreach ($operatorList as $operatorObject) {
        $data[] = array(
          'operatorId'   => $operatorObject['id'],
          'name' => $operatorObject['name'],
          'roleId' => $operatorObject['roleId'],
          'roleName' => $operatorObject->role['name'],
          //'role'  => $this->getRoleInfo($operator['roleId']),
          'createdDate' => date("Y-m-d H:i:s",strtotime($operatorObject['created_at'])),
          'updatedDate' => date("Y-m-d H:i:s",strtotime($operatorObject['updated_at'])),
        );
    }
    return $this->retSuccess($data, $page);
  }

//------------------- CREATE ---------------------------

  /* 添加操作者 */
  public function add(Request $request)
  {
    //TODO:accessToken

    if(!$request->has('name')){
      //返回错误
      return $this->retError(OPERATOR_USERNAME_IS_EMPTY_CODE, OPERATOR_USERNAME_IS_EMPTY_WORD);
    }

    if(!$request->has('password')){
      //返回错误
      return $this->retError(OPERATOR_PASSWORD_IS_EMPTY_CODE, OPERATOR_PASSWORD_IS_EMPTY_WORD);
    }

    if(!$request->has('roleId')){
      //返回错误
      return $this->retError(ROLE_ID_IS_EMPTY_CODE, ROLE_ID_IS_EMPTY_WORD);
    }

    // 获取请求参数
    $operatorName = $request->input("name");
    $password = $request->input("password");
    $roleId = $request->input("roleId");

    if(Role::where('id', $roleId)->count() == 0){
      return $this->retError(ROLE_ID_IS_NOT_EXIST_CODE, ROLE_ID_IS_NOT_EXIST_WORD);
    }

    // 判断是否已经存在
    $count = Operator::where('name', $operatorName)->count();
    if($count != 0)
    {
      //返回错误
      return $this->retError(OPERATOR_USERNAME_IS_EXIST_CODE, OPERATOR_USERNAME_IS_EXIST_WORD);
    }

    // 录入操作者表
    $operatorObject = new Operator;
    $operatorObject->name = $operatorName;
    $operatorObject->password = $password;
    $operatorObject->roleId = $roleId;

    if($ret = $operatorObject->save()){
      $data = array(
        'operatorId' => $operatorObject['id']
      );
      return $this->retSuccess($data);
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }

  }

//------------------- PUT ---------------------------

  /* 更新操作者 */
  public function update(Request $request)
  {
    //TODO:accessToken

    // operatorId 不存在,返回错误
    if(!$request->has('operatorId')){
      //返回错误
      return $this->retError(OPERATOR_ID_IS_EMPTY_CODE, OPERATOR_ID_IS_EMPTY_WORD);
    }

    // 获取请求参数
    $operatorId = $request->input("operatorId");
    $operatorName = $request->input("name");
    $password = $request->input("password");
    $roleId = $request->input("roleId");

    // 判断roleId是否存在
    if(Role::where('id', $roleId)->count() == 0){
      return $this->retError(ROLE_ID_IS_NOT_EXIST_CODE, ROLE_ID_IS_NOT_EXIST_WORD);
    }

    // 查找该ID的对象
    if(!$operatorObject = Operator::find($operatorId)){
      //返回错误
      return $this->retError(OPERATOR_ID_IS_NOT_EXIST_CODE, OPERATOR_ID_IS_NOT_EXIST_WORD);
    }

    // 判断是否已经存在
    $foundObject = Operator::where('name', $operatorName)->first();
    if($foundObject && $foundObject['id'] != $operatorId)
    {
      //返回错误
      return $this->retError(OPERATOR_USERNAME_IS_EXIST_CODE, OPERATOR_USERNAME_IS_EXIST_WORD);
    }

    // 如果 operatorName 不存在就不更新
    if($request->has('name')){
      $operatorObject->name = $operatorName;
    }

    // 如果 password 不存在就不更新
    if($request->has('password')){
      $operatorObject->password = $password;
    }

    // 如果 roleId 不存在就不更新
    if($request->has('roleId')){
      $operatorObject->roleId = $roleId;
    }

    if($operatorObject->save()){
      return $this->retSuccess();
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }

  }

//------------------- DELETE ---------------------------

  /* 删除操作者 */
  public function delete(Request $request)
  {
    //TODO:accessToken

    // 获取请求参数
    $operatorId = $request->input("operatorId");

    // 查找该ID的对象
    if(!$operatorObject = Operator::find($operatorId)){
      //返回错误
      return $this->retError(OPERATOR_ID_IS_NOT_EXIST_CODE, OPERATOR_ID_IS_NOT_EXIST_WORD);
    }

    $operatorObject->delete();

    return $this->retSuccess();
  }

//----------------------
//       公共区域
//----------------------

  /* 获取角色 */
  public function getRoleInfo($roleId)
  {

    // 查找该ID的对象
    if(!$roleObject = Role::find($roleId)){
      //返回错误
      return "";
    }
    $permissionData = array();
    // 获取权限数据
    $permissionData = unlimitedForLayer($roleObject->permissions);

    // foreach ($roleObject->permissions as $permission) {
    //   if($permission['description'] == NULL ){
    //     $permission['description'] = "";
    //   }
    //   if($permission['parentId'] == NULL || $permission['parentId'] == "0" || $permission['parentId'] == ""){
    //     $permission['parentId'] = NULL;
    //   }
    //   $permissionData[] = array(
    //     "id"   => $permission['id'],
    //     "name" => $permission['name'],
    //     "desc" => $permission['description'],
    //     "parentId" => $permission['parentId']
    //   );
    // }

    $data = array(
      "id"   => $roleObject['id'],
      "name" => $roleObject['name'],
      "desc" => $roleObject['description'],
      "permissions" => $permissionData,
    );
    return $data;

  }

  public function token() {
        $outhServer = $this->get_outh_server();
        // var_dump($outhServer);
        $response = $outhServer->handleTokenRequest(OAuth2\Request::createFromGlobals());
        //var_dump($response);
        $ret = array();
        $params = $response->getParameters();
        if($response->isSuccessful()) {
            $ret = BaseError::return_success_with_data($params);
        }
        else
        {
            $ret = BaseError::return_error($params["error"], $params["error_description"]);
        }

        return $this->json_parse($ret);
  }

  public function login(Request $request) {
        $_POST["userName"] = $request->input("userName");
        $_POST["password"] = $request->input("password");
        $_POST["ipAddr"] = $request->ip();

        $outhServer = OAuthClient::get_outh_server();
        // var_dump($outhServer);
        $response = $outhServer->handleTokenRequest(OAuth2\Request::createFromGlobals());
        $ret = array();
        $params = $response->getParameters();
        if(!$response->isSuccessful()) {
            return $this->retError(OPERATOR_USERNAME_OR_PASSWORD_IS_ERROR_CODE, OPERATOR_USERNAME_OR_PASSWORD_IS_ERROR_WORD);
        }

        $data = $params;
        $data["role"] = $this->getRoleInfo($data['roleId']);
        $data["ipAddr"] = $_POST["ipAddr"];

        return $this->retSuccess($data);
    }

    public function login1(Request $request) {
        $loginObject = new \App\Models\Login();
        $ret = $loginObject->verifyToken();
        var_dump($ret);
    }

}
