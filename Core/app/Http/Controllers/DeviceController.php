<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\BoxDoor;
use App\Models\Device;


class DeviceController extends Controller
{

//------------------- READ ---------------------------

  /* 读设备 */
  public function read(Request $request)
  {
    if($request->has('id')){
      /* 带参数时,获取单个数据 */
      // 获取参数
      $id = $request->get("id");
      return $this->getInfo($id);
    }else if($request->has('boxDoorId')){
      /* 带参数时,获取列表 */
      $page      = $request->input('page');
      $perPage   = $request->input('perPage');
      $boxDoorId = $request->input("boxDoorId");
      return $this->getListByBoxDoorId($boxDoorId, $page, $perPage);
    }else{
      /* 带参数时,获取列表 */
      $page    = $request->input('page');
      $perPage = $request->input('perPage');
      return $this->getList($page, $perPage);
    }
  }

  /* 获取单个设备 */
  public function getInfo($id)
  {
    // 查找该ID的对象是否存在
    if(!$deviceObject = Device::find($id)){
      return $this->retError(DEVICE_ID_IS_NOT_EXIST_CODE, DEVICE_ID_IS_NOT_EXIST_WORD);
    }else{
      // 组装数据
      $data = array(
        'deviceId'      => $deviceObject['id'],
        'type'          => $deviceObject['type'],
        'ip'            => $deviceObject['ip'],
        'port'          => $deviceObject['port'],
        'mac'           => $deviceObject['mac'],
        'rtsp'          => $deviceObject['rtsp'],
        'userName'      => $deviceObject['userName'],
        'password'      => $deviceObject['password'],
        'ledWidth'      => $deviceObject['ledWidth'],
        'ledHeight'     => $deviceObject['ledHeight'],
        'controlCardNo' => $deviceObject['controlCardNo'],
        'boxDoorId'     => $deviceObject['boxDoorId'],
        'status'        => $deviceObject['status'],
        'created_at' => date("Y-m-d H:i:s",strtotime($deviceObject['created_at'])),
        'updated_at' => date("Y-m-d H:i:s",strtotime($deviceObject['updated_at']))
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取设备列表 */
  public function getList($page, $perPage)
  {
    if($page){
      $deviceList = Device::paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => Device::all()->count(),
        'perPage'     => $deviceList->perPage(),
        'currentPage' => $deviceList->currentPage(),
        'lastPage'    => $deviceList->lastPage(),
        'nextPageUrl' => $deviceList->nextPageUrl() == null ? null : $deviceList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $deviceList->previousPageUrl() == null ? null : $deviceList->previousPageUrl() . $perPagePan,
      );
    }else{
      $deviceList = Device::all();
    }
    $data = array();
    foreach ($deviceList as $deviceObject) {
      // 组装数据
      $data[] = array(
        'deviceId'      => $deviceObject['id'],
        'type'          => $deviceObject['type'],
        'ip'            => $deviceObject['ip'],
        'port'          => $deviceObject['port'],
        'mac'           => $deviceObject['mac'],
        'rtsp'          => $deviceObject['rtsp'],
        'userName'      => $deviceObject['userName'],
        'password'      => $deviceObject['password'],
        'ledWidth'      => $deviceObject['ledWidth'],
        'ledHeight'     => $deviceObject['ledHeight'],
        'controlCardNo' => $deviceObject['controlCardNo'],
        'boxDoorId'     => $deviceObject['boxDoorId'],
        'status'        => $deviceObject['status'],
        'created_at' => date("Y-m-d H:i:s",strtotime($deviceObject['created_at'])),
        'updated_at' => date("Y-m-d H:i:s",strtotime($deviceObject['updated_at']))
      );
    }
    return $this->retSuccess($data,$page);
  }

  /* 获取设备列表 */
  public function getListByBoxDoorId($boxDoorId, $page, $perPage)
  {
    if($page){
      $deviceList = Device::where('boxDoorId', '=', $boxDoorId)->paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => Device::all()->count(),
        'perPage'     => $deviceList->perPage(),
        'currentPage' => $deviceList->currentPage(),
        'lastPage'    => $deviceList->lastPage(),
        'nextPageUrl' => $deviceList->nextPageUrl() == null ? null : $deviceList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $deviceList->previousPageUrl() == null ? null : $deviceList->previousPageUrl() . $perPagePan,
      );
    }else{
      $deviceList = Device::where('boxDoorId', '=', $boxDoorId)->get();
    }
    $data = array();
    foreach ($deviceList as $deviceObject) {
      // 组装数据
      $data[] = array(
        'deviceId'      => $deviceObject['id'],
        'type'          => $deviceObject['type'],
        'ip'            => $deviceObject['ip'],
        'port'          => $deviceObject['port'],
        'mac'           => $deviceObject['mac'],
        'rtsp'          => $deviceObject['rtsp'],
        'userName'      => $deviceObject['userName'],
        'password'      => $deviceObject['password'],
        'ledWidth'      => $deviceObject['ledWidth'],
        'ledHeight'     => $deviceObject['ledHeight'],
        'controlCardNo' => $deviceObject['controlCardNo'],
        'boxDoorId'     => $deviceObject['boxDoorId'],
        'status'        => $deviceObject['status'],
        'created_at' => date("Y-m-d H:i:s",strtotime($deviceObject['created_at'])),
        'updated_at' => date("Y-m-d H:i:s",strtotime($deviceObject['updated_at']))
      );
    }
    return $this->retSuccess($data,$page);
  }

  //------------------- CREATE ---------------------------

  /* 添加岗亭 */
  public function add(Request $request)
  {
    //TODO:accessToken

    if(!$request->has('type')){
      //返回错误
      return $this->retError(DEVICE_TYPE_IS_EMPTY_CODE, DEVICE_TYPE_IS_EMPTY_WORD);
    }else if(!preg_match("/^([0-1])$/",$request->input("type"))){
      return $this->retError(DEVICE_TYPE_IS_ERROR_CODE, DEVICE_TYPE_IS_ERROR_WORD);
    }else{
      $type = $request->input('type');
    }

    if(!$request->has('ip')){
      //返回错误
      return $this->retError(DEVICE_IP_IS_EMPTY_CODE, DEVICE_IP_IS_EMPTY_WORD);
    }else if(!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/",$request->input("ip"))){
      return $this->retError(DEVICE_IP_IS_ERROR_CODE, DEVICE_IP_IS_ERROR_WORD);
    }else if(Device::where('ip', '=', $request->input("ip"))->count() != 0 || Box::where('ip', '=', $request->input("ip"))->count() != 0){
      return $this->retError(DEVICE_IP_IS_EXIT_CODE, DEVICE_IP_IS_EXIT_WORD);
    }else{
      $ip = $request->input('ip');
    }

    if(!$request->has('port')){
      $port = NULL;
    }else{
      $port = $request->input('port');
    }

    if(!$request->has('mac')){
      $mac = NULL;
    }else if(!preg_match("/^[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}$/",$request->input("mac"))){
      return $this->retError(DEVICE_MAC_IS_ERROR_CODE, DEVICE_MAC_IS_ERROR_WORD);
    }else{
      $mac = $request->input('mac');
    }

    if(!$request->has('rtsp')){
      $rtsp = NULL;
    }else{
      $rtsp = $request->input('rtsp');
    }

    if(!$request->has('userName')){
      $userName = NULL;
    }else{
      $userName = $request->input('userName');
    }

    if(!$request->has('password')){
      $password = NULL;
    }else{
      $password = $request->input('password');
    }

    if(!$request->has('ledWidth')){
      $ledWidth = NULL;
    }else{
      $ledWidth = $request->input('ledWidth');
    }

    if(!$request->has('ledHeight')){
      $ledHeight = NULL;
    }else{
      $ledHeight = $request->input('ledHeight');
    }

    if(!$request->has('controlCardNo')){
      $controlCardNo = NULL;
    }else{
      $controlCardNo = $request->input('controlCardNo');
    }

    if(!$request->has('boxDoorId')){
      //返回错误
      return $this->retError(BOX_DOOR_ID_IS_EMPTY_CODE, BOX_DOOR_ID_IS_EMPTY_WORD);
    }else if(!BoxDoor::find($request->input('boxDoorId'))){
      return $this->retError(BOX_DOOR_ID_IS_NOT_EXIST_CODE, BOX_DOOR_ID_IS_NOT_EXIST_WORD);
    }else{
      $boxDoorId = $request->input('boxDoorId');
    }

    // if(!$request->has('type')){
    //   //返回错误
    //   return $this->retError(DEVICE_TYPE_IS_EMPTY_CODE, DEVICE_TYPE_IS_EMPTY_WORD);
    // }else if(!preg_match("/^([0-5])$/",$request->input("type"))){
    //   return $this->retError(DEVICE_TYPE_IS_ERROR_CODE, DEVICE_TYPE_IS_ERROR_WORD);
    // }else{
    //   $type = $request->input('type');
    //   // 判断是否为托管主机
    //   if($type == 0){
    //     $boxDoorId = NULL;
    //   }else{
    //     // 获取 boxDoorId
    //     if(!$request->has('boxDoorId')){
    //       //返回错误
    //       return $this->retError(BOX_DOOR_ID_IS_EMPTY_CODE, BOX_DOOR_ID_IS_EMPTY_WORD);
    //     }else if(!BoxDoor::find($request->input('boxDoorId'))){
    //       return $this->retError(BOX_DOOR_ID_IS_NOT_EXIST_CODE, BOX_DOOR_ID_IS_NOT_EXIST_WORD);
    //     }else{
    //       $boxDoorId = $request->input('boxDoorId');
    //     }
    //   }
    // }

    // 录入操作者表
    $deviceObject = new Device;
    $deviceObject->type          = $type;
    $deviceObject->ip            = $ip;
    $deviceObject->port          = $port;
    $deviceObject->mac           = $mac;
    $deviceObject->rtsp          = $rtsp;
    $deviceObject->userName      = $userName;
    $deviceObject->password      = $password;
    $deviceObject->ledWidth      = $ledWidth;
    $deviceObject->ledHeight     = $ledHeight;
    $deviceObject->controlCardNo = $controlCardNo;
    $deviceObject->boxDoorId     = $boxDoorId;
    $deviceObject->status        = 0;

    if($ret = $deviceObject->save()){
      $data = array(
        'deviceId' => $deviceObject['id']
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
    if(!$request->has('deviceId')){
      //返回错误
      return $this->retError(DEVICE_ID_IS_EMPTY_CODE, DEVICE_ID_IS_EMPTY_WORD);
    }else if(!$deviceObject = Device::find($request->input('deviceId'))){
      return $this->retError(DEVICE_ID_IS_NOT_EXIST_CODE, DEVICE_ID_IS_NOT_EXIST_WORD);
    }else{
      $deviceId = $request->input('deviceId');
    }

    if(!$request->has('ip')){
      // 不做修改
    }else if(!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/",$request->input("ip"))){
      return $this->retError(DEVICE_IP_IS_ERROR_CODE, DEVICE_IP_IS_ERROR_WORD);
    }else if((Device::where('ip', '=', $request->input("ip"))->count() != 0 || Box::where('ip', '=', $request->input("ip"))->count() != 0) && $request->input('ip') != $deviceObject['ip']){
      return $this->retError(DEVICE_IP_IS_EXIT_CODE, DEVICE_IP_IS_EXIT_WORD);
    }else{
      $ip = $request->input('ip');
      $deviceObject->ip = $ip;
    }

    if(!$request->has('port')){

    }else{
      $port = $request->input('port');
      $deviceObject->port = $port;
    }

    if(!$request->has('mac')){
      // 不做修改
    }else if(!preg_match("/^[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}$/",$request->input("mac"))){
      return $this->retError(DEVICE_MAC_IS_ERROR_CODE, DEVICE_MAC_IS_ERROR_WORD);
    }else{
      $mac = $request->input('mac');
      $deviceObject->mac = $mac;
    }

    if(!$request->has('rtsp')){

    }else{
      $rtsp = $request->input('rtsp');
      $deviceObject->rtsp = $rtsp;
    }

    if(!$request->has('userName')){

    }else{
      $userName = $request->input('userName');
      $deviceObject->userName = $userName;
    }

    if(!$request->has('password')){

    }else{
      $password = $request->input('password');
      $deviceObject->password = $password;
    }

    if(!$request->has('ledWidth')){

    }else{
      $ledWidth = $request->input('ledWidth');
      $deviceObject->ledWidth = $ledWidth;
    }

    if(!$request->has('ledHeight')){

    }else{
      $ledHeight = $request->input('ledHeight');
      $deviceObject->ledHeight = $ledHeight;
    }

    if(!$request->has('controlCardNo')){

    }else{
      $controlCardNo = $request->input('controlCardNo');
      $deviceObject->controlCardNo = $controlCardNo;
    }

    if(!$request->has('boxDoorId')){
      //返回错误
      //return $this->retError(BOX_DOOR_ID_IS_EMPTY_CODE, BOX_DOOR_ID_IS_EMPTY_WORD);
    }else if(!BoxDoor::find($request->input('boxDoorId'))){
      return $this->retError(BOX_DOOR_ID_IS_NOT_EXIST_CODE, BOX_DOOR_ID_IS_NOT_EXIST_WORD);
    }else{
      $boxDoorId = $request->input('boxDoorId');
      $deviceObject->boxDoorId = $boxDoorId;
    }

    // if(!$request->has('type')){
    //   // 不做修改
    // }else if(!preg_match("/^([0-5])$/",$request->input("type"))){
    //   return $this->retError(DEVICE_TYPE_IS_ERROR_CODE, DEVICE_TYPE_IS_ERROR_WORD);
    // }else{
    //   $type = $request->input('type');
    //   $boxDoorId = NULL;
    //   // 判断是否为托管主机
    //   if($type != 0){
    //     // 获取 boxDoorId
    //     if(!$request->has('boxDoorId')){
    //       //返回错误
    //       return $this->retError(BOX_DOOR_ID_IS_EMPTY_CODE, BOX_DOOR_ID_IS_EMPTY_WORD);
    //     }else if(!BoxDoor::find($request->input('boxDoorId'))){
    //       return $this->retError(BOX_DOOR_ID_IS_NOT_EXIST_CODE, BOX_DOOR_ID_IS_NOT_EXIST_WORD);
    //     }else{
    //       $boxDoorId = $request->input('boxDoorId');
    //     }
    //   }
    //   $deviceObject->type      = $type;
    //   $deviceObject->boxDoorId = $boxDoorId;
    // }

    if($deviceObject->save()){
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
    if(!$request->has('deviceId')){
      //返回错误
      return $this->retError(DEVICE_ID_IS_EMPTY_CODE, DEVICE_ID_IS_EMPTY_WORD);
    }else if(!$deviceObject = Device::find($request->input('deviceId'))){
      return $this->retError(DEVICE_ID_IS_NOT_EXIST_CODE, DEVICE_ID_IS_NOT_EXIST_WORD);
    }else{
      $deviceId = $request->input('deviceId');
    }

    // // 查找该ID的对象
    // if(Box::where('compId',$deviceId)->count() != 0){
    //   //返回错误
    //   return $this->retError(DEVICE_ID_IS_IN_USED_CODE, DEVICE_ID_IS_IN_USED_WORD);
    // }

    $deviceObject->delete();

    return $this->retSuccess();
  }

  public function getCameraListByBoxId(Request $request)
  {
    /* boxId */
    if(!$request->has('boxId')){
      //返回错误
      return $this->retError(BOX_ID_IS_EMPTY_CODE, BOX_ID_IS_EMPTY_WORD);
    }else if(!$boxObject = Box::find($request->input('boxId'))){
      return $this->retError(BOX_ID_IS_NOT_EXIST_CODE, BOX_ID_IS_NOT_EXIST_WORD);
    }else{
      $boxId = $request->input('boxId');
      $boxName = $boxObject->name;
    }

    $deviceList = Box::leftJoin('boxDoors', 'boxes.id', '=', 'boxDoors.boxId')
                      ->leftJoin('devices', 'boxDoors.id', '=', 'devices.boxDoorId')
                      ->where('devices.type', '=', 0)
                      ->where('boxes.id', '=', $boxId)
                      ->get();

    foreach ($deviceList as $deviceObject) {
      // 组装数据
      $data[] = array(
        'deviceId'      => $deviceObject['id'],
        'type'          => $deviceObject['type'],
        'ip'            => $deviceObject['ip'],
        'port'          => $deviceObject['port'],
        'mac'           => $deviceObject['mac'],
        'rtsp'          => $deviceObject['rtsp'],
        'userName'      => $deviceObject['userName'],
        'password'      => $deviceObject['password'],
        'ledWidth'      => $deviceObject['ledWidth'],
        'ledHeight'     => $deviceObject['ledHeight'],
        'controlCardNo' => $deviceObject['controlCardNo'],
        'boxDoorId'     => $deviceObject['boxDoorId'],
        'status'        => $deviceObject['status'],
        'boxId'         => $boxId,
        'boxName'       => $boxName,
        'boxDoorName'   => $deviceObject['name'],
        'function'      => $deviceObject['function'] == 0 ? '入口' : '出口',
        'created_at' => date("Y-m-d H:i:s",strtotime($deviceObject['created_at'])),
        'updated_at' => date("Y-m-d H:i:s",strtotime($deviceObject['updated_at']))
      );
    }
    return $this->retSuccess($data);
  }

}
