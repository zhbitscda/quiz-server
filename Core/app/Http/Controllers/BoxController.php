<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Operator;
use App\Models\Card;
use App\Models\ParkCard;
use App\Models\ParkCardType;
use App\Models\Box;
use App\Models\BoxDoor;
use App\Models\Car;
use App\Models\CarLocation;
use App\Models\CarPhoto;
use App\Models\CarType;
use App\Models\Device;
use App\Models\Configure;

class BoxController extends Controller
{

//------------------- READ ---------------------------

  /* 读岗亭 */
  public function read(Request $request)
  {
    if($request->has('id')){
      /* 带参数时,获取单个数据 */
      // 获取参数
      $id = $request->get("id");
      return $this->getInfo($id);
    }else{
      /* 带参数时,获取列表 */
      $page    = $request->input('page');
      $perPage = $request->input('perPage');
      return $this->getList($page, $perPage);
    }
  }

  /* 获取单个岗亭 */
  public function getInfo($id)
  {
    // 查找该ID的对象是否存在
    if(!$boxObject = Box::find($id)){
      return $this->retError(BOX_ID_IS_NOT_EXIST_CODE, BOX_ID_IS_NOT_EXIST_WORD);
    }else{
      // 组装数据
      $data = array(
        'boxId'      => $boxObject['id'],
        'name'       => $boxObject['name'],
        'ip'         => $boxObject['ip'],
        'status'     => $boxObject['status'],
        'boxDoors'   => $boxObject->boxdoors,
        'created_at' => date("Y-m-d H:i:s",strtotime($boxObject['created_at'])),
        'updated_at' => date("Y-m-d H:i:s",strtotime($boxObject['updated_at']))
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取岗亭列表 */
  public function getList($page, $perPage)
  {
    if($page){
      $boxList = Box::paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => Box::all()->count(),
        'perPage'     => $boxList->perPage(),
        'currentPage' => $boxList->currentPage(),
        'lastPage'    => $boxList->lastPage(),
        'nextPageUrl' => $boxList->nextPageUrl() == null ? null : $boxList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $boxList->previousPageUrl() == null ? null : $boxList->previousPageUrl() . $perPagePan,
      );
    }else{
      $boxList = Box::all();
    }
    $data = array();
    foreach ($boxList as $boxObject) {
      // 组装数据
      $data[] = array(
        'boxId'      => $boxObject['id'],
        'name'       => $boxObject['name'],
        'ip'         => $boxObject['ip'],
        'status'     => $boxObject['status'],
        'boxDoors'   => $boxObject->boxdoors,
        'created_at' => date("Y-m-d H:i:s",strtotime($boxObject['created_at'])),
        'updated_at' => date("Y-m-d H:i:s",strtotime($boxObject['updated_at']))
      );
    }
    return $this->retSuccess($data,$page);
  }

  //------------------- CREATE ---------------------------

  /* 添加岗亭 */
  public function add(Request $request)
  {
    //TODO:accessToken

    if(!$request->has('name')){
      //返回错误
      return $this->retError(BOX_NAME_IS_EMPTY_CODE, BOX_NAME_IS_EMPTY_WORD);
    }else if(Box::where('name', $request->input('name'))->count() != 0){
      return $this->retError(BOX_NAME_IS_ERROR_CODE, BOX_NAME_IS_ERROR_WORD);
    }else{
      $name = $request->input('name');
    }

    if(!$request->has('ip')){
      //返回错误
      return $this->retError(BOX_IP_IS_EMPTY_CODE, BOX_IP_IS_EMPTY_WORD);
    }else if(!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/",$request->input("ip"))){
      return $this->retError(BOX_IP_IS_ERROR_CODE, BOX_IP_IS_ERROR_WORD);
    }else if(Device::where('ip', '=', $request->input("ip"))->count() != 0 || Box::where('ip', '=', $request->input("ip"))->count() != 0){
      return $this->retError(BOX_IP_IS_EXIT_CODE, BOX_IP_IS_EXIT_WORD);
    }else{
      $ip = $request->input('ip');
    }

    if(!$request->has('status')){
      //返回错误
      //return $this->retError(BOX_STATUS_IS_EMPTY_CODE, BOX_STATUS_IS_EMPTY_WORD);
      $status = 0;
    }else if(!preg_match("/^([0-1])$/",$request->input("status"))){
      return $this->retError(BOX_STATUS_IS_ERROR_CODE, BOX_STATUS_IS_ERROR_WORD);
    }else{
      $status = $request->input('status');
    }

    // 录入操作者表
    $boxObject = new Box;
    $boxObject->name   = $name;
    $boxObject->ip     = $ip;
    $boxObject->status = $status;

    if(!$boxObject->save()){
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }

    /* 生成配置 */
    // LED显示屏
    $configureObject = new Configure;
    $configureObject->name = "HAS_LED_SCREEN";
    $configureObject->value = "0";
    $configureObject->type = 1;
    $configureObject->boxId = $boxObject['id'];
    if(!$configureObject->save()){
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
    // 显示剩余车辆
    $configureObject = new Configure;
    $configureObject->name = "IS_DISPLAY_REST_NUMBER";
    $configureObject->value = "0";
    $configureObject->type = 1;
    $configureObject->boxId = $boxObject['id'];
    if(!$configureObject->save()){
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
    // 入口无人职守
    $configureObject = new Configure;
    $configureObject->name = "IS_ENTER_NO_PEOPLE";
    $configureObject->value = "0";
    $configureObject->type = 1;
    $configureObject->boxId = $boxObject['id'];
    if(!$configureObject->save()){
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
    // 临时车允许进出
    $configureObject = new Configure;
    $configureObject->name = "IS_ALLOW_TEMP_CAR_IN_OUT";
    $configureObject->value = "0";
    $configureObject->type = 1;
    $configureObject->boxId = $boxObject['id'];
    if(!$configureObject->save()){
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
    // 入场确认开闸
    $configureObject = new Configure;
    $configureObject->name = "ENTER_CONFIRM_OPEN_TYPE";
    $configureObject->value = '["0","1","2","3","4"]';
    $configureObject->type = 1;
    $configureObject->boxId = $boxObject['id'];
    if(!$configureObject->save()){
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
    // 出场确认开闸
    $configureObject = new Configure;
    $configureObject->name = "EXIT_CONFIRM_OPEN_TYPE";
    $configureObject->value = '["0","1","2","3","4"]';
    $configureObject->type = 1;
    $configureObject->boxId = $boxObject['id'];
    if(!$configureObject->save()){
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }

    if($ret = $boxObject->save()){
      $data = array(
        'boxId' => $boxObject['id']
      );
      return $this->retSuccess($data);
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

  //------------------- PUT ---------------------------

  /* 更新岗亭 */
  public function update(Request $request)
  {
    //TODO:accessToken

    /* boxId */
    if(!$request->has('boxId')){
      //返回错误
      return $this->retError(BOX_ID_IS_EMPTY_CODE, BOX_ID_IS_EMPTY_WORD);
    }else if(!$boxObject = Box::find($request->input('boxId'))){
      return $this->retError(BOX_ID_IS_NOT_EXIST_CODE, BOX_ID_IS_NOT_EXIST_WORD);
    }else{
      $boxId = $request->input('boxId');
    }

    /* name */
    if(!$request->has('name')){

    }else if(Box::where('name', $request->input('name'))->count() != 0 && $request->input('name') != $boxObject['name']){
      return $this->retError(BOX_NAME_IS_ERROR_CODE, BOX_NAME_IS_ERROR_WORD);
    }else{
      $name = $request->input('name');
      $boxObject->name = $name;
    }

    if(!$request->has('ip')){

    }else if(!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/",$request->input("ip"))){
      return $this->retError(BOX_IP_IS_ERROR_CODE, BOX_IP_IS_ERROR_WORD);
    }else if((Device::where('ip', '=', $request->input("ip"))->count() != 0 || Box::where('ip', '=', $request->input("ip"))->count() != 0) && $request->input('ip') != $boxObject['ip']){
      return $this->retError(BOX_IP_IS_EXIT_CODE, BOX_IP_IS_EXIT_WORD);
    }else{
      $ip = $request->input('ip');
      $boxObject->ip = $ip;
    }

    /* status */
    if(!$request->has('status')){
      //返回错误
      //return $this->retError(BOX_STATUS_IS_EMPTY_CODE, BOX_STATUS_IS_EMPTY_WORD);
    }else if(!preg_match("/^([0-1])$/",$request->input("status"))){
      return $this->retError(BOX_STATUS_IS_ERROR_CODE, BOX_STATUS_IS_ERROR_WORD);
    }else{
      $status = $request->input('status');
      $boxObject->status = $status;
    }

    if($boxObject->save()){
      return $this->retSuccess();
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

  //------------------- DELETE ---------------------------

  /* 删除岗亭 */
  public function delete(Request $request)
  {
    //TODO:accessToken

    /* boxId */
    if(!$request->has('boxId')){
      //返回错误
      return $this->retError(BOX_ID_IS_EMPTY_CODE, BOX_ID_IS_EMPTY_WORD);
    }else if(!$boxObject = Box::find($request->input('boxId'))){
      return $this->retError(BOX_ID_IS_NOT_EXIST_CODE, BOX_ID_IS_NOT_EXIST_WORD);
    }else{
      $boxId = $request->input('boxId');
    }

    // 查找该ID的对象
    if(BoxDoor::where('boxId',$boxId)->count() != 0){
      //返回错误
      return $this->retError(BOX_BOX_DOOR_IS_IN_USED_CODE, BOX_BOX_DOOR_IS_IN_USED_WORD);
    }

    if($configureList = Configure::where('boxId', '=', $boxId)->get()){
      foreach ($configureList as $configureObject) {
        $configureObject->delete();
      }
    }

    $boxObject->delete();

    return $this->retSuccess();
  }

}
