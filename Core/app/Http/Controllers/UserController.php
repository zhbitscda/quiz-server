<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Operator;
use App\Models\Card;
use App\Models\ParkCard;
use App\Models\ParkCardType;
use App\Models\Box;
use App\Models\Car;
use App\Models\CarLocation;
use App\Models\CarPhoto;
use App\Models\CarType;

class UserController extends Controller
{

//------------------- READ ---------------------------

  /* 读操作 */
  public function read(Request $request)
  {
    if($request->has('id')){
      /* 带参数时,获取单个数据 */
      // 获取参数
      $id = $request->get("id");
      return $this->getInfoById($id);
    }else{
      /* 带参数时,获取列表 */
      $page    = $request->input('page');
      $perPage = $request->input('perPage');
      return $this->getList($page, $perPage);
    }
  }

  /* 获取单个用户 */
  public function getInfo($id)
  {
    // 查找该ID的对象是否存在
    if(!$userObject = User::find($id)){
      return $this->retError(USER_ID_IS_NOT_EXIST_CODE, USER_ID_IS_NOT_EXIST_WORD);
    }else{
      // 组装数据
      $data = array(
        'userId'     => $userObject['id'],
        'name'       => $userObject['name'],
        'telephone'  => $userObject['telephone'],
        'homephone'  => $userObject['homephone'],
        'idCard'     => $userObject['idCard'],
        'birthday'   => $userObject['birthday'],
        'address'    => $userObject['address'],
        'department' => $userObject['department'],
        'photoUrl'   => $userObject['photoUrl'],
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取权限列表 */
  public function getList($page, $perPage)
  {
    if($page){
      $userList = User::where('id', '>', 0)->paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => User::all()->count(),
        'perPage'     => $userList->perPage(),
        'currentPage' => $userList->currentPage(),
        'lastPage'    => $userList->lastPage(),
        'nextPageUrl' => $userList->nextPageUrl() == null ? null : $userList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $userList->previousPageUrl() == null ? null : $userList->previousPageUrl() . $perPagePan,
      );
    }else{
      $userList = User::where('id', '>', 0)->get();
    }
    $data = array();
    foreach ($userList as $userObject) {
      // 组装数据
      $data[] = array(
        'userId'     => $userObject['id'],
        'name'       => $userObject['name'],
        'telephone'  => $userObject['telephone'],
        'homephone'  => $userObject['homephone'],
        'idCard'     => $userObject['idCard'],
        'birthday'   => $userObject['birthday'],
        'address'    => $userObject['address'],
        'department' => $userObject['department'],
        'photoUrl'   => $userObject['photoUrl'],
      );
    }
    return $this->retSuccess($data, $page);
  }

  /* 添加 */
  public function add(Request $request)
  {
    //TODO:accessToken

    if(!$request->has('name')){
      //返回错误
      return $this->retError(USER_ID_IS_EMPTY_CODE, USER_ID_IS_EMPTY_WORD);
    }else if(User::where('name', $request->input('name'))->count() != 0){
      return $this->retError(USER_NAME_IS_EXIST_CODE, USER_NAME_IS_EXIST_WORD);
    }else{
      $name = $request->input('name');
    }

    if(!$request->has('telephone')){
      //返回错误
      return $this->retError(USER_TELEPHONE_IS_EMPTY_CODE, USER_TELEPHONE_IS_EMPTY_WORD);
    }else{
      $telephone = $request->input('telephone');
    }

    if(!$request->has('homephone')){
      //返回错误
      $homephone = "";
    }else{
      $homephone = $request->input('homephone');
    }

    if(!$request->has('idCard')){
      //返回错误
      return $this->retError(USER_IDCARD_IS_EMPTY_CODE, USER_IDCARD_IS_EMPTY_WORD);
    }else{
      $idCard = $request->input('idCard');
    }

    if(!$request->has('birthday')){
      //返回错误
      $birthday = null;
    }else{
      $birthday = $request->input('birthday');
    }

    if(!$request->has('address')){
      //返回错误
      $address = "";
    }else{
      $address = $request->input('address');
    }

    if(!$request->has('department')){
      //返回错误
      $department = "";
    }else{
      $department = $request->input('department');
    }

    if(!$request->has('photoUrl')){
      //返回错误
      $photoUrl = "";
    }else{
      $photoUrl = $request->input('photoUrl');
    }

    // 录入操作者表
    $userObject = new User;
    $userObject->name       = $name;
    $userObject->telephone  = $telephone;
    $userObject->homephone  = $homephone;
    $userObject->idCard     = $idCard;
    $userObject->birthday   = $birthday;
    $userObject->address    = $address;
    $userObject->department = $department;
    $userObject->photoUrl   = $photoUrl;
    $userObject->isUsed     = 1;

    if($userObject->save()){
      $data = array(
        'userId' => $userObject['id']
      );
      return $this->retSuccess($data);
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

  /* 更新 */
  public function update(Request $request)
  {
    //TODO:accessToken

    /* userId */
    if(!$request->has('userId')){
      return $this->retError(USER_ID_IS_EMPTY_CODE, USER_ID_IS_EMPTY_WORD);
    }else if(!$userObject = User::find($request->input('userId'))){
      return $this->retError(USER_ID_IS_NOT_EXIST_CODE, USER_ID_IS_NOT_EXIST_WORD);
    }else{
      $userId = $request->input('userId');
    }

    if(!$request->has('name')){

    }else if( ( User::where('name', $request->input('name'))->count() != 0 ) && $userObject['name'] != $request->input('name')){
      return $this->retError(USER_NAME_IS_EXIST_CODE, USER_NAME_IS_EXIST_WORD);
    }else{
      $name = $request->input('name');
      $userObject->name = $name;
    }

    if(!$request->has('telephone')){

    }else{
      $telephone = $request->input('telephone');
      $userObject->telephone = $telephone;
    }

    if(!$request->has('homephone')){

    }else{
      $homephone = $request->input('homephone');
      $userObject->homephone = $homephone;
    }

    if(!$request->has('idCard')){

    }else{
      $idCard = $request->input('idCard');
      $userObject->idCard = $idCard;
    }

    if(!$request->has('birthday')){

    }else{
      $birthday = $request->input('birthday');
      $userObject->birthday = $birthday;
    }

    if(!$request->has('address')){

    }else{
      $address = $request->input('address');
      $userObject->address = $address;
    }

    if(!$request->has('department')){

    }else{
      $department = $request->input('department');
      $userObject->department = $department;
    }

    if(!$request->has('photoUrl')){

    }else{
      $photoUrl = $request->input('photoUrl');
      $userObject->photoUrl = $photoUrl;
    }

    if($userObject->save()){
      return $this->retSuccess();
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

  /* 删除岗亭口 */
  public function delete(Request $request)
  {
    //TODO:accessToken

    /* userId */
    if(!$request->has('userId')){
      return $this->retError(USER_ID_IS_EMPTY_CODE, USER_ID_IS_EMPTY_WORD);
    }else if(!$userObject = User::find($request->input('userId'))){
      return $this->retError(USER_ID_IS_NOT_EXIST_CODE, USER_ID_IS_NOT_EXIST_WORD);
    }else{
      $userId = $request->input('userId');
    }

    // 删除车
    $carList = Car::where('userId', '=', $userId)->get();
    foreach ($carList as $carObject) {
      $carObject->delete();
    }

    // 删除数据
    $userObject->delete();

    return $this->retSuccess();
  }

  // notIssueParkCard
  public function getNotIssueParkCard(Request $request)
  {
     $name = null;
     if($request->has('search')){
       $name = $request->get("search");
     }
     $page    = $request->input('page');
     $perPage = $request->input('perPage');
     if($page){
       if($name){
         $userList = User::has('card','=', 0)->where('id', '>', 0)->where('name','like','%'.$name.'%')->paginate($perPage);
       }else{
         $userList = User::has('card','=', 0)->where('id', '>', 0)->paginate($perPage);
       }
       if($perPage){
         $perPagePan = "&perPage=" . $perPage;
       }else{
         $perPagePan = "";
       }
       // 分页信息
       $page = array(
         'total'       => User::all()->count(),
         'perPage'     => $userList->perPage(),
         'currentPage' => $userList->currentPage(),
         'lastPage'    => $userList->lastPage(),
         'nextPageUrl' => $userList->nextPageUrl() == null ? null : $userList->nextPageUrl() . $perPagePan,
         'prevPageUrl' => $userList->previousPageUrl() == null ? null : $userList->previousPageUrl() . $perPagePan,
       );
     }else{
       if($name){
         $userList = User::has('card','=', 0)->where('id', '>', 0)->where('name','like','%'.$name.'%')->get();
       }else{
         $userList = User::has('card','=', 0)->where('id', '>', 0)->get();
       }
     }
     $data = array();
     foreach ($userList as $userObject) {
       // 组装数据
       $data[] = array(
         'userId'     => $userObject['id'],
         'name'       => $userObject['name'],
         'telephone'  => $userObject['telephone'],
         'homephone'  => $userObject['homephone'],
         'idCard'     => $userObject['idCard'],
         'birthday'   => $userObject['birthday'],
         'address'    => $userObject['address'],
         'department' => $userObject['department'],
         'photoUrl'   => $userObject['photoUrl'],
       );
     }
     return $this->retSuccess($data, $page);
  }

  //------------------- search ---------------------------
  public function search(Request $request){

    $userList = User::where('users.id','>', 0);

    if($request->has('userName')){
      $userName = $request->input('userName');
      $userList = $userList->where('name', 'like', "%$userName%");
    }else{
      $userName = null;
    }

    if($request->has('isNotIssue')){
      if($request->input('isNotIssue') == 1 || $request->input('isNotIssue') == '1'){
        $userList = $userList->has('card','=', 0);
      }
    }

    if($request->has('telephone')){
      $telephone = $request->input('telephone');
      $userList = $userList->where('telephone', 'like', "%$telephone%");
    }else{
      $telephone = null;
    }

    if($request->has('id')){
      $id = $request->input('id');
      $userList = $userList->where('id', 'like', "%$id%");
    }else{
      $id = null;
    }

    if($request->has('department')){
      $department = $request->input('department');
      $userList = $userList->where('department', 'like', "%$department%");
    }else{
      $department = null;
    }

    if($request->has('carNo')){
      $carNo = $request->input('carNo');
      $userList = $userList->join('cars', 'users.id', '=', 'cars.userId');
      $userList = $userList->where('cars.number', 'like', "%$carNo%");
    }else{
      $carNo = null;
    }

    $page    = $request->input('page');
    $perPage = $request->input('perPage');

    if($page){
      // 生成对象
      $count = $userList->count();
      $userList = $userList->paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => $count,
        'perPage'     => $userList->perPage(),
        'currentPage' => $userList->currentPage(),
        'lastPage'    => $userList->lastPage(),
        'nextPageUrl' => $userList->nextPageUrl() == null ? null : $userList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $userList->previousPageUrl() == null ? null : $userList->previousPageUrl() . $perPagePan,
      );
    }else{
      $userList = $userList->get();
    }

    $data = array();
    foreach ($userList as $userObject) {
      // 组装数据
      $data[] = array(
        'userId'     => $userObject['id'],
        'name'       => $userObject['name'],
        'telephone'  => $userObject['telephone'],
        'homephone'  => $userObject['homephone'],
        'idCard'     => $userObject['idCard'],
        'birthday'   => $userObject['birthday'],
        'address'    => $userObject['address'],
        'department' => $userObject['department'],
        'photoUrl'   => $userObject['photoUrl']
      );
    }
    return $this->retSuccess($data, $page);
  }

  public function getDepartment(Request $request)
  {
    // 获取用户数据
    $userList = User::where('id','>', 0)->get();
    // 遍历所有部门数据
    $keyArray = array();
    foreach ($userList as $user) {
      if(!$user['department'] || $user['department'] == '')
        continue;
      if(!isset($keyArray[$user['department']]) || $keyArray[$user['department']])
      {
        $keyArray[$user['department']] = true;
      }else{
        continue;
      }
    }

    $retArray = array();
    foreach (array_keys($keyArray) as $value) {
      $retArray[] = array(
        'value' => $value,
        'name'  => $value
      );
    }

    // 返回
    return $this->retSuccess($retArray);
  }

}
