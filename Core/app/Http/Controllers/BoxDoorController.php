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

class BoxDoorController extends Controller
{

//------------------- READ ---------------------------

  /* 读操作 */
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

  /* 获取单个岗亭口 */
  public function getInfo($id)
  {
    // 查找该ID的对象是否存在
    if(!$boxDoorObject = BoxDoor::find($id)){
      return $this->retError(BOX_DOOR_ID_IS_NOT_EXIST_CODE, BOX_ID_IS_NOT_EXIST_WORD);
    }else{
      // 组装数据
      $data = array(
        'boxDoorId'  => $boxDoorObject['id'],
        'boxId'      => (int)$boxDoorObject['boxId'],
        'boxName'    => $boxDoorObject->box['name'],
        'name'       => $boxDoorObject['name'],
        'type'       => $boxDoorObject['type'],
        'isCheck'    => $boxDoorObject['isCheck'],
        'isTempIn'   => $boxDoorObject['isTempIn'],
        'isTempOut'  => $boxDoorObject['isTempOut'],
        'cardRights' => json_decode($boxDoorObject['cardRights']),
        'function'   => $boxDoorObject['function'],
        'mainControlMachine' => $boxDoorObject['mainControlMachine'],
        'barrierGateControlMachine' => $boxDoorObject['barrierGateControlMachine'],
        'status'     => $boxDoorObject['status'],
        'devices'    => $boxDoorObject->devices,
        'created_at' => date("Y-m-d H:i:s",strtotime($boxDoorObject['created_at'])),
        'updated_at' => date("Y-m-d H:i:s",strtotime($boxDoorObject['updated_at']))
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取岗亭口列表 */
  public function getList($page, $perPage)
  {
    if($page){
      $boxDoorList = BoxDoor::paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => BoxDoor::all()->count(),
        'perPage'     => $boxDoorList->perPage(),
        'currentPage' => $boxDoorList->currentPage(),
        'lastPage'    => $boxDoorList->lastPage(),
        'nextPageUrl' => $boxDoorList->nextPageUrl() == null ? null : $boxDoorList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $boxDoorList->previousPageUrl() == null ? null : $boxDoorList->previousPageUrl() . $perPagePan,
      );
    }else{
      $boxDoorList = BoxDoor::all();
    }
    $data = array();
    foreach ($boxDoorList as $boxDoorObject) {
      // 组装数据
      $data[] = array(
        'boxDoorId' => $boxDoorObject['id'],
        'boxId' => (int)$boxDoorObject['boxId'],
        'boxName' => $boxDoorObject->box['name'],
        'name' => $boxDoorObject['name'],
        'type' => $boxDoorObject['type'],
        'isCheck' => $boxDoorObject['isCheck'],
        'isTempIn' => $boxDoorObject['isTempIn'],
        'isTempOut' => $boxDoorObject['isTempOut'],
        'cardRights' => json_decode($boxDoorObject['cardRights']),
        'function' => $boxDoorObject['function'],
        'mainControlMachine' => $boxDoorObject['mainControlMachine'],
        'barrierGateControlMachine' => $boxDoorObject['barrierGateControlMachine'],
        'status' => $boxDoorObject['status'],
        'devices' => $boxDoorObject->devices,
        'created_at' => date("Y-m-d H:i:s",strtotime($boxDoorObject['created_at'])),
        'updated_at' => date("Y-m-d H:i:s",strtotime($boxDoorObject['updated_at']))
      );
    }
    return $this->retSuccess($data,$page);
  }

  //------------------- CREATE ---------------------------

  /* 添加岗亭口 */
  public function add(Request $request)
  {
    //TODO:accessToken

    /* boxId */
    if(!$request->has('boxId')){
      //返回错误
      //return $this->retError(BOX_ID_IS_EMPTY_CODE, BOX_ID_IS_EMPTY_WORD);
      // 如果boxId不存在则默认为NULL
      $boxId = NULL;
    }else if(!Box::find($request->input('boxId'))){
      return $this->retError(BOX_ID_IS_NOT_EXIST_CODE, BOX_ID_IS_NOT_EXIST_WORD);
    }else{
      $boxId = $request->input('boxId');
    }

    if(!$request->has('name')){
      //返回错误
      return $this->retError(BOX_DOOR_NAME_IS_EMPTY_CODE, BOX_DOOR_NAME_IS_EMPTY_WORD);
    }else if(BoxDoor::where('name', $request->input('name'))->count() != 0){
      return $this->retError(BOX_DOOR_NAME_IS_ERROR_CODE, BOX_DOOR_NAME_IS_ERROR_WORD);
    }else{
      $name = $request->input('name');
    }

    if(!$request->has('function')){
      //返回错误
      return $this->retError(BOX_DOOR_FUNCTION_IS_EMPTY_CODE, BOX_DOOR_FUNCTION_IS_EMPTY_WORD);
    }else if(!preg_match("/^([0-1])$/",$request->input("function"))){
      return $this->retError(BOX_DOOR_TYPE_IS_ERROR_CODE, BOX_DOOR_TYPE_IS_ERROR_WORD);
    }else{
      $function = $request->input('function');
    }

    if(!$request->has('mainControlMachine')){
      //返回错误
      return $this->retError(BOX_MAIN_CONTROL_MACHINE_IS_EMPTY_CODE, BOX_MAIN_CONTROL_MACHINE_IS_EMPTY_WORD);
    }else{
      $mainControlMachine = $request->input('mainControlMachine');
    }

    if(!$request->has('barrierGateControlMachine')){
      //返回错误
      return $this->retError(BOX_BARRIER_GATE_CONTROL_MACHINE_IS_EMPTY_CODE, BOX_BARRIER_GATE_CONTROL_MACHINE_IS_EMPTY_WORD);
    }else{
      $barrierGateControlMachine = $request->input('barrierGateControlMachine');
    }

    if(!$request->has('type')){
      //返回错误
      return $this->retError(BOX_DOOR_TYPE_IS_EMPTY_CODE, BOX_DOOR_TYPE_IS_EMPTY_WORD);
    }else if(!preg_match("/^([0-1])$/",$request->input("type"))){
      return $this->retError(BOX_DOOR_TYPE_IS_ERROR_CODE, BOX_DOOR_TYPE_IS_ERROR_WORD);
    }else{
      $type = $request->input('type');
    }

    if(!$request->has('isCheck')){
      //返回错误
      //return $this->retError(BOX_DOOR_TYPE_IS_EMPTY_CODE, BOX_DOOR_TYPE_IS_EMPTY_WORD);
      $isCheck = 0;
    }else if(!preg_match("/^([0-1])$/",$request->input("isCheck"))){
      return $this->retError(BOX_DOOR_IS_CHECK_IS_ERROR_CODE, BOX_DOOR_IS_CHECK_IS_ERROR_WORD);
    }else{
      $isCheck = $request->input('isCheck');
    }

    if(!$request->has('isTempIn')){
      //返回错误
      //return $this->retError(BOX_DOOR_TYPE_IS_EMPTY_CODE, BOX_DOOR_TYPE_IS_EMPTY_WORD);
      $isTempIn = 0;
    }else if(!preg_match("/^([0-1])$/",$request->input("isTempIn"))){
      return $this->retError(BOX_DOOR_IS_TEMP_IN_IS_ERROR_CODE, BOX_DOOR_IS_TEMP_IN_IS_ERROR_WORD);
    }else{
      $isTempIn = $request->input('isTempIn');
    }

    if(!$request->has('isTempOut')){
      //返回错误
      //return $this->retError(BOX_DOOR_TYPE_IS_EMPTY_CODE, BOX_DOOR_TYPE_IS_EMPTY_WORD);
      $isTempOut = 0;
    }else if(!preg_match("/^([0-1])$/",$request->input("isTempOut"))){
      return $this->retError(BOX_DOOR_IS_TEMP_OUT_IS_ERROR_CODE, BOX_DOOR_IS_TEMP_OUT_IS_ERROR_WORD);
    }else{
      $isTempOut = $request->input('isTempOut');
    }

    if(!$request->has('cardRights')){
      //返回错误
      //return $this->retError(BOX_DOOR_TYPE_IS_EMPTY_CODE, BOX_DOOR_TYPE_IS_EMPTY_WORD);
      $cardRights = array(0,1,2,3,4);
    }else{
      $cardRights = $request->input('cardRights');
      $middle = array();
      foreach ($cardRights as $eachCardRight) {
        if(!preg_match("/^([0-4])$/", $eachCardRight)){
          return $this->retError(BOX_DOOR_CAR_RIGHT_IS_ERROR_CODE, BOX_DOOR_CAR_RIGHT_IS_ERROR_WORD);
        }else{
          $middle[] = $eachCardRight;
        }
      }
      $cardRights = $middle;
    }

    if(!$request->has('status')){
      //返回错误
      //return $this->retError(BOX_STATUS_IS_EMPTY_CODE, BOX_STATUS_IS_EMPTY_WORD);
      $status = 0;
    }else if(!preg_match("/^([0-2])$/",$request->input("status"))){
      return $this->retError(BOX_DOOR_STATUS_IS_ERROR_CODE, BOX_DOOR_STATUS_IS_ERROR_WORD);
    }else{
      $status = $request->input('status');
    }

    // 录入操作者表
    $boxDoorObject = new BoxDoor;
    $boxDoorObject->boxId = $boxId;
    $boxDoorObject->name = $name;
    $boxDoorObject->function = $function;
    $boxDoorObject->isCheck = $isCheck;
    $boxDoorObject->isTempIn = $isTempIn;
    $boxDoorObject->isTempOut = $isTempOut;
    $boxDoorObject->cardRights = json_encode($cardRights);
    $boxDoorObject->type = $type;
    $boxDoorObject->mainControlMachine = $mainControlMachine;
    $boxDoorObject->barrierGateControlMachine = $barrierGateControlMachine;
    $boxDoorObject->status = $status;

    if($ret = $boxDoorObject->save()){
      $data = array(
        'boxDoorId' => $boxDoorObject['id']
      );
      return $this->retSuccess($data);
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

  //------------------- PUT ---------------------------

  /* 更新岗亭口 */
  public function update(Request $request)
  {
    //TODO:accessToken

    /* boxId */
    if(!$request->has('boxDoorId')){
      //返回错误
      return $this->retError(BOX_DOOR_ID_IS_EMPTY_CODE, BOX_DOOR_ID_IS_EMPTY_WORD);
    }else if(!$boxDoorObject = BoxDoor::find($request->input('boxDoorId'))){
      return $this->retError(BOX_DOOR_ID_IS_NOT_EXIST_CODE, BOX_DOOR_ID_IS_NOT_EXIST_WORD);
    }else{
      $boxDoorId = $request->input('boxDoorId');
    }

    /* boxId */
    if(!$request->has('boxId')){
      //返回错误
      //return $this->retError(BOX_ID_IS_EMPTY_CODE, BOX_ID_IS_EMPTY_WORD);
    }else if(!Box::find($request->input('boxId'))){
      return $this->retError(BOX_ID_IS_NOT_EXIST_CODE, BOX_ID_IS_NOT_EXIST_WORD);
    }else{
      $boxId = $request->input('boxId');
      $boxDoorObject->boxId = $boxId;
    }

    if(!$request->has('name')){
      //返回错误
      //return $this->retError(BOX_DOOR_NAME_IS_EMPTY_CODE, BOX_DOOR_NAME_IS_EMPTY_WORD);
    }else if((BoxDoor::where('name', $request->input('name'))->count() != 0) && $boxDoorObject['name'] != $request->input('name')){
      return $this->retError(BOX_DOOR_NAME_IS_ERROR_CODE, BOX_DOOR_NAME_IS_ERROR_WORD);
    }else{
      $name = $request->input('name');
      $boxDoorObject->name = $name;
    }

    if(!$request->has('function')){
      //返回错误
      //return $this->retError(BOX_DOOR_FUNCTION_IS_EMPTY_CODE, BOX_DOOR_FUNCTION_IS_EMPTY_WORD);
    }else if(!preg_match("/^([0-1])$/",$request->input("function"))){
      return $this->retError(BOX_DOOR_TYPE_IS_ERROR_CODE, BOX_DOOR_TYPE_IS_ERROR_WORD);
    }else{
      $function = $request->input('function');
      $boxDoorObject->function = $function;
    }

    if(!$request->has('isCheck')){

    }else if(!preg_match("/^([0-1])$/",$request->input("isCheck"))){
      return $this->retError(BOX_DOOR_IS_CHECK_IS_ERROR_CODE, BOX_DOOR_IS_CHECK_IS_ERROR_WORD);
    }else{
      $isCheck = $request->input('isCheck');
      $boxDoorObject->isCheck = $isCheck;
    }

    if(!$request->has('isTempIn')){

    }else if(!preg_match("/^([0-1])$/",$request->input("isTempIn"))){
      return $this->retError(BOX_DOOR_IS_TEMP_IN_IS_ERROR_CODE, BOX_DOOR_IS_TEMP_IN_IS_ERROR_WORD);
    }else{
      $isTempIn = $request->input('isTempIn');
      $boxDoorObject->isTempIn = $isTempIn;
    }

    if(!$request->has('isTempOut')){
      //返回错误
      $isTempOut = 0;
    }else if(!preg_match("/^([0-1])$/",$request->input("isTempOut"))){
      return $this->retError(BOX_DOOR_IS_TEMP_OUT_IS_ERROR_CODE, BOX_DOOR_IS_TEMP_OUT_IS_ERROR_WORD);
    }else{
      $isTempOut = $request->input('isTempOut');
      $boxDoorObject->isTempOut = $isTempOut;
    }

    if(!$request->has('cardRights')){
      //返回错误
    }else{
      $cardRights = $request->input('cardRights');
      $middle = array();
      foreach ($cardRights as $eachCardRight) {
        if(!preg_match("/^([0-4])$/", $eachCardRight)){
          return $this->retError(BOX_DOOR_CAR_RIGHT_IS_ERROR_CODE, BOX_DOOR_CAR_RIGHT_IS_ERROR_WORD);
        }else{
          $middle[] = $eachCardRight;
        }
      }
      $cardRights = $middle;
      $boxDoorObject->cardRights = json_encode($cardRights);
    }

    if(!$request->has('type')){
      //返回错误
      //return $this->retError(BOX_DOOR_TYPE_IS_EMPTY_CODE, BOX_DOOR_TYPE_IS_EMPTY_WORD);
    }else if(!preg_match("/^([0-2])$/",$request->input("type"))){
      return $this->retError(BOX_DOOR_TYPE_IS_ERROR_CODE, BOX_DOOR_TYPE_IS_ERROR_WORD);
    }else{
      $type = $request->input('type');
      $boxDoorObject->type = $type;
    }

    if(!$request->has('mainControlMachine')){
      //返回错误
      return $this->retError(BOX_MAIN_CONTROL_MACHINE_IS_EMPTY_CODE, BOX_MAIN_CONTROL_MACHINE_IS_EMPTY_WORD);
    }else{
      $mainControlMachine = $request->input('mainControlMachine');
      $boxDoorObject->mainControlMachine = $mainControlMachine;
    }

    if(!$request->has('barrierGateControlMachine')){
      //返回错误
      return $this->retError(BOX_BARRIER_GATE_CONTROL_MACHINE_IS_EMPTY_CODE, BOX_BARRIER_GATE_CONTROL_MACHINE_IS_EMPTY_WORD);
    }else{
      $barrierGateControlMachine = $request->input('barrierGateControlMachine');
      $boxDoorObject->barrierGateControlMachine = $barrierGateControlMachine;
    }

    if(!$request->has('status')){
      //返回错误
      //return $this->retError(BOX_STATUS_IS_EMPTY_CODE, BOX_STATUS_IS_EMPTY_WORD);
    }else if(!preg_match("/^([0-2])$/",$request->input("status"))){
      return $this->retError(BOX_DOOR_STATUS_IS_ERROR_CODE, BOX_DOOR_STATUS_IS_ERROR_WORD);
    }else{
      $status = $request->input('status');
      $boxDoorObject->status = $status;
    }

    if($boxDoorObject->save()){
      return $this->retSuccess();
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

  //------------------- DELETE ---------------------------

  /* 删除岗亭口 */
  public function delete(Request $request)
  {
    //TODO:accessToken

    /* boxId */
    if(!$request->has('boxDoorId')){
      //返回错误
      return $this->retError(BOX_DOOR_ID_IS_EMPTY_CODE, BOX_DOOR_ID_IS_EMPTY_WORD);
    }else if(!$boxDoorObject = BoxDoor::find($request->input('boxDoorId'))){
      return $this->retError(BOX_DOOR_ID_IS_NOT_EXIST_CODE, BOX_DOOR_ID_IS_NOT_EXIST_WORD);
    }else{
      $boxDoorId = $request->input('boxId');
    }

    // // 查找该ID的对象
    // if($boxDoorObject->parkcards->count() != 0){
    //   //返回错误
    //   return $this->retError(BOX_DOOR_IS_IN_USED_CODE, BOX_DOOR_IS_IN_USED_WORD);
    // }

    // 删除关联表
    $boxDoorObject->parkcards()->detach();

    // 删除数据
    $boxDoorObject->delete();

    return $this->retSuccess();
  }

}
