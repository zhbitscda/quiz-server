<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Device;
use App\Models\Box;
use App\Models\BoxDoor;
use App\Models\Admission;
use App\Models\ParkCard;
use App\Models\Car;
use App\Models\Configure;
use App\Models\Flow;
use Log;

/*
 * 错误码
 * 0-请求多次忽略  1-_无_
 */

class AdmissionController extends Controller
{

//------------------- READ ---------------------------

  /* 读进出场记录 */
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
    if(!$admissionObject = Admission::find($id)){
      return $this->retError(ADMISSION_ID_IS_NOT_EXIT_CODE, ADMISSION_ID_IS_NOT_EXIT_WORD);
    }else{
      // 获取停车卡类型
      if($admissionObject['cardId'] != null){
        $cardOriType = $admissionObject->parkCard->cardType->type;
        switch ($cardOriType) {
          case 0:
            $cardOriType = "月租卡";
            break;

          case 1:
            $cardOriType = "储值卡";
            break;

          case 2:
            $cardOriType = "临时卡";
            break;

          case 3:
            $cardOriType = "贵宾卡";
            break;

          case 4:
            $cardOriType = "次卡";
            break;

          default:
            $cardOriType = "";
            break;
        }
        $cardType = $cardOriType . $admissionObject->parkCard->cardType->name;

        // 获取用户名
        $userName = $admissionObject->parkCard->card->user->name;

        // 获取卡信息
        $cardAmount = $admissionObject->parkCard->amount;
        $cardTimes = $admissionObject->parkCard->times;
        $cardBeginDate = date("Y-m-d H:i:s",$admissionObject->parkCard->beginDate);
        $cardEndDate = date("Y-m-d H:i:s",$admissionObject->parkCard->endDate);

        // 获取车辆信息
        $carType = $admissionObject->parkCard->car->type;
        $carRegNum = $admissionObject->parkCard->car->number;

      }else{
        $cardType = null;
        $userName = null;
        $cardAmount = null;
        $cardTimes = null;
        $cardBeginDate= null;
        $cardEndDate = null;
        $carType = null;
        $carRegNum = null;
      }

      // 组装数据
      $data = array(
        'admissionId'           => $admissionObject['id'],
        'cardId'                => $admissionObject['cardId'],
        'userName'              => $userName,
        'cardType'              => $cardType,
        'cardAmount'            => $cardAmount,
        'cardTimes'             => $cardTimes,
        'cardBeginDate'         => $cardBeginDate,
        'cardEndDate'           => $cardEndDate,
        'carNum'                => $admissionObject['carNum'],
        'carRegNum'             => $carRegNum,
        'carType'               => $carType,
        'carColor'              => $admissionObject['carColor'],
        'enterBoxDoorId'        => $admissionObject['enterBoxDoorId'],
        'exitBoxDoorId'         => $admissionObject['exitBoxDoorId'],
        'enterImagePath'        => $admissionObject['enterImagePath'],
        'exitImagePath'         => $admissionObject['exitImagePath'],
        'enterTime'             => date("Y-m-d H:i:s",$admissionObject['enterTime']),
        'exitTime'              => date("Y-m-d H:i:s",$admissionObject['exitTime']),
        'free'                  => $admissionObject['free'],
        'charge'                => $admissionObject['charge'],
        'enterExceptionCode'    => json_decode($admissionObject['enterExceptionCode']),
        'exitExceptionCode'     => json_decode($admissionObject['exitExceptionCode']),
        'enterExceptionCodeStr' => $this->exceptionCodeTranfer(json_decode($admissionObject['enterExceptionCode'])),
        'exitExceptionCodeStr'  => $this->exceptionCodeTranfer(json_decode($admissionObject['exitExceptionCode'])),
        'enterExceptionCodeArr' => $this->exceptionCodeTranfer(json_decode($admissionObject['enterExceptionCode']))['arr'],
        'exitExceptionCodeArr'  => $this->exceptionCodeTranfer(json_decode($admissionObject['exitExceptionCode']))['arr'],
        'status'                => $admissionObject['status'],
        'isGuest'               => $admissionObject['isGuest'],
        'created_at'            => date("Y-m-d H:i:s",strtotime($admissionObject['created_at'])),
        'updated_at'            => date("Y-m-d H:i:s",strtotime($admissionObject['updated_at']))
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取岗亭列表 */
  public function getList($page, $perPage)
  {
    if($page){
      $admissionList = Admission::paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => Admission::all()->count(),
        'perPage'     => $admissionList->perPage(),
        'currentPage' => $admissionList->currentPage(),
        'lastPage'    => $admissionList->lastPage(),
        'nextPageUrl' => $admissionList->nextPageUrl() == null ? null : $admissionList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $admissionList->previousPageUrl() == null ? null : $admissionList->previousPageUrl() . $perPagePan,
      );
    }else{
      $admissionList = Admission::all();
    }
    $data = array();
    foreach ($admissionList as $admissionObject) {

      // 获取停车卡类型
      if($admissionObject['cardId'] != null){
        $cardOriType = $admissionObject->parkCard->cardType->type;
        switch ($cardOriType) {
          case 0:
            $cardOriType = "月租卡";
            break;

          case 1:
            $cardOriType = "储值卡";
            break;

          case 2:
            $cardOriType = "临时卡";
            break;

          case 3:
            $cardOriType = "贵宾卡";
            break;

          case 4:
            $cardOriType = "次卡";
            break;

          default:
            $cardOriType = "";
            break;
        }

        // 获取用户名
        $userName = $admissionObject->parkCard->card->user->name;

        // 获取卡信息
        $cardAmount = $admissionObject->parkCard->amount;
        $cardTimes = $admissionObject->parkCard->times;
        $cardBeginDate = date("Y-m-d H:i:s",$admissionObject->parkCard->beginDate);
        $cardEndDate = date("Y-m-d H:i:s",$admissionObject->parkCard->endDate);
        $cardType = $cardOriType . $admissionObject->parkCard->cardType->name;

        // 获取车辆信息
        $carType = $admissionObject->parkCard->car->type;
        $carRegNum = $admissionObject->parkCard->car->number;

      }else{
        $cardType = "临时卡";
        $userName = "临时卡用户";
        $cardAmount = null;
        $cardTimes = null;
        $cardBeginDate= null;
        $cardEndDate = null;
        $carType = null;
        $carRegNum = null;
      }

      // 组装数据
      $data[] = array(
        'admissionId'           => $admissionObject['id'],
        'cardId'                => $admissionObject['cardId'],
        'userName'              => $userName,
        'cardType'              => $cardType,
        'cardAmount'            => $cardAmount,
        'cardTimes'             => $cardTimes,
        'cardBeginDate'         => $cardBeginDate,
        'cardEndDate'           => $cardEndDate,
        'carNum'                => $admissionObject['carNum'],
        'carRegNum'             => $carRegNum,
        'carType'               => $carType,
        'carColor'              => $admissionObject['carColor'],
        'enterBoxDoorId'        => $admissionObject['enterBoxDoorId'],
        'exitBoxDoorId'         => $admissionObject['exitBoxDoorId'],
        'enterImagePath'        => $admissionObject['enterImagePath'],
        'exitImagePath'         => $admissionObject['exitImagePath'],
        'enterTime'             => date("Y-m-d H:i:s",$admissionObject['enterTime']),
        'exitTime'              => date("Y-m-d H:i:s",$admissionObject['exitTime']),
        'free'                  => $admissionObject['free'],
        'charge'                => $admissionObject['charge'],
        'enterExceptionCode'    => json_decode($admissionObject['enterExceptionCode']),
        'exitExceptionCode'     => json_decode($admissionObject['exitExceptionCode']),
        'enterExceptionCodeStr' => $this->exceptionCodeTranfer(json_decode($admissionObject['enterExceptionCode'])),
        'exitExceptionCodeStr'  => $this->exceptionCodeTranfer(json_decode($admissionObject['exitExceptionCode'])),
        'enterExceptionCodeArr' => $this->exceptionCodeTranfer(json_decode($admissionObject['enterExceptionCode']))['arr'],
        'exitExceptionCodeArr'  => $this->exceptionCodeTranfer(json_decode($admissionObject['exitExceptionCode']))['arr'],
        'status'                => $admissionObject['status'],
        'isGuest'               => $admissionObject['isGuest'],
        'created_at'            => date("Y-m-d H:i:s",strtotime($admissionObject['created_at'])),
        'updated_at'            => date("Y-m-d H:i:s",strtotime($admissionObject['updated_at']))
      );
    }
    return $this->retSuccess($data,$page);
  }

//------------------- CREATE ---------------------------

  /* 添加出入场 */
  public function add(Request $request)
  {
    //TODO:accessToken

    if(!$request->has('isGuest')){
      //返回错误
      $isGuest = 1;
    }else{
      $isGuest = $request->input('isGuest');
    }

    if(!$request->has('cardId')){
      //返回错误
      if($isGuest == 0){
        return $this->retError(CARD_ID_IS_EMPTY_CODE, CARD_ID_IS_EMPTY_WORD);
      }
      $cardId = NULL;
    }else if(ParkCard::where('cardId', $request->input('cardId'))->count() != 0){
      return $this->retError(CARD_ID_IS_NOT_EXIST_CODE, CARD_ID_IS_NOT_EXIST_WORD);
    }else{
      $cardId = $request->input('cardId');
    }

    if(!$request->has('status')){
      //返回错误
      return $this->retError(ADMISSION_STATUS_IS_EMPTY_CODE, ADMISSION_STATUS_IS_EMPTY_WORD);
    }else{
      $status = $request->input('status');
    }

    if(!$request->has('carColor')){
      //返回错误
      $carColor = "";
    }else{
      $carColor = $request->input('carColor');
    }

    if(!$request->has('carNum')){
      //返回错误
      return $this->retError(ADMISSION_CAR_NUM_IS_EMPTY_CODE, ADMISSION_CAR_NUM_IS_EMPTY_WORD);
    }else{
      $carNum = $request->input('carNum');
    }

    if(!$request->has('enterBoxDoorId')){
      //返回错误
      $enterBoxDoorId = NULL;
    }else if(!BoxDoor::find($request->input('enterBoxDoorId'))){
      return $this->retError(CARD_ID_IS_NOT_EXIST_CODE, CARD_ID_IS_NOT_EXIST_WORD);
    }else{
      $enterBoxDoorId = $request->input('enterBoxDoorId');
    }

    if(!$request->has('exitBoxDoorId')){
      //返回错误
      $exitBoxDoorId = NULL;
    }else if(!BoxDoor::find($request->input('exitBoxDoorId'))){
      return $this->retError(CARD_ID_IS_NOT_EXIST_CODE, CARD_ID_IS_NOT_EXIST_WORD);
    }else{
      $exitBoxDoorId = $request->input('exitBoxDoorId');
    }

    if(!$request->has('enterImagePath')){
      //返回错误
      $enterImagePath = NULL;
    }else{
      $enterImagePath = $request->input('enterImagePath');
    }

    if(!$request->has('exitImagePath')){
      //返回错误
      $exitImagePath = NULL;
    }else{
      $exitImagePath = $request->input('exitImagePath');
    }

    if(!$request->has('enterTime')){
      //返回错误
      return $this->retError(ADMISSION_ENTER_TIME_IS_EMPTY_CODE, ADMISSION_ENTER_TIME_IS_EMPTY_WORD);
    }else{
      $enterTime = strtotime($request->input('enterTime'));
    }

    if(!$request->has('exitTime')){
      //返回错误
      if($status == 2 || $status == 3){
        return $this->retError(ADMISSION_EXIT_TIME_IS_EMPTY_CODE, ADMISSION_EXIT_TIME_IS_EMPTY_WORD);
      }
      $exitTime = NULL;
    }else{
      $exitTime = strtotime($request->input('exitTime'));
    }

    if(!$request->has('free')){
      //返回错误
      $free = 0;
    }else{
      $free = $request->input('free');
    }

    if(!$request->has('charge')){
      //返回错误
      $charge = 0;
    }else{
      $charge = $request->input('charge');
    }

    // 录入操作者表
    $admissionObject = new Admission;
    $admissionObject->cardNum        = $cardNum;
    $admissionObject->cardId         = $cardId;
    $admissionObject->carColor       = $carColor;
    $admissionObject->enterBoxDoorId = $enterBoxDoorId;
    $admissionObject->exitBoxDoorId  = $exitBoxDoorId;
    $admissionObject->enterImagePath = $enterImagePath;
    $admissionObject->exitImagePath  = $exitImagePath;
    $admissionObject->enterTime      = $enterTime;
    $admissionObject->exitTime       = $exitTime;
    $admissionObject->free           = $free;
    $admissionObject->charge         = $charge;
    $admissionObject->status         = $status;
    $admissionObject->isGuest        = $isGuest;

    if($ret = $admissionObject->save()){
      $data = array(
        'admissionId' => $admissionObject['id']
      );
      return $this->retSuccess($data);
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

//------------------- UPDATE ---------------------------

  /* 更新出入场 */
  public function update(Request $request)
  {
    //TODO:accessToken

    /* admissionId */
    if(!$request->has('admissionId')){
      return $this->retError(ADMISSION_ID_IS_EMPTY_CODE, ADMISSION_ID_IS_EMPTY_WORD);
    }else if(!$admissionObject = Admission::find($request->input('admissionId'))){
      return $this->retError(ADMISSION_ID_IS_NOT_EXIST_CODE, ADMISSION_ID_IS_NOT_EXIST_WORD);
    }else{
      $admissionId = $request->input('admissionId');
    }

    if(!$request->has('carNum')){
      //返回错误
      $carNum = NULL;
    }else{
      $carNum = $request->input('carNum');
      $admissionObject->carNum = $carNum;
    }

    if(!$request->has('isGuest')){
      $isGuest = $admissionObject['isGuest'];
    }else{
      $isGuest = $request->input('isGuest');
      $admissionObject->isGuest = $isGuest;
    }

    if(!$request->has('cardId')){
      $cardId = $admissionObject['cardId'];
      if($isGuest == 0 && !$cardId){
        return $this->retError(CARD_ID_IS_EMPTY_CODE, CARD_ID_IS_EMPTY_WORD);
      }
    }else if(ParkCard::where('cardId', $request->input('cardId'))->count() != 0){
      return $this->retError(CARD_ID_IS_NOT_EXIST_CODE, CARD_ID_IS_NOT_EXIST_WORD);
    }else{
      $cardId = $request->input('cardId');
      $admissionObject->cardId = $cardId;
    }

    if(!$request->has('status')){
      $status = $admissionObject['status'];
    }else{
      $status = $request->input('status');
      $admissionObject->status = $status;
    }

    if(!$request->has('carColor')){

    }else{
      $carColor = $request->input('carColor');
      $admissionObject->carColor = $carColor;
    }

    if(!$request->has('enterBoxDoorId')){

    }else if(!BoxDoor::find($request->input('enterBoxDoorId'))){
      return $this->retError(CARD_ID_IS_NOT_EXIST_CODE, CARD_ID_IS_NOT_EXIST_WORD);
    }else{
      $enterBoxDoorId = $request->input('enterBoxDoorId');
      $admissionObject->enterBoxDoorId = $enterBoxDoorId;
    }

    if(!$request->has('exitBoxDoorId')){

    }else if(!BoxDoor::find($request->input('exitBoxDoorId'))){
      return $this->retError(CARD_ID_IS_NOT_EXIST_CODE, CARD_ID_IS_NOT_EXIST_WORD);
    }else{
      $exitBoxDoorId = $request->input('exitBoxDoorId');
      $admissionObject->exitBoxDoorId = $exitBoxDoorId;
    }

    if(!$request->has('enterImagePath')){

    }else{
      $enterImagePath = $request->input('enterImagePath');
      $admissionObject->enterImagePath = $enterImagePath;
    }

    if(!$request->has('exitImagePath')){

    }else{
      $exitImagePath = $request->input('exitImagePath');
      $admissionObject->exitImagePath = $exitImagePath;
    }

    if(!$request->has('enterTime')){

    }else{
      $enterTime = $request->input('enterTime');
      $admissionObject->enterTime = strtotime($enterTime);
    }

    if(!$request->has('exitTime')){

      $exitTime = $admissionObject['exitTime'];
      if(($status == 2 || $status == 3) && !$exitTime){
        return $this->retError(ADMISSION_EXIT_TIME_IS_EMPTY_CODE, ADMISSION_EXIT_TIME_IS_EMPTY_WORD);
      }
    }else{
      $exitTime = $request->input('exitTime');
      $admissionObject->exitTime = strtotime($exitTime);
    }

    if(!$request->has('free')){

    }else{
      $free = $request->input('free');
      $admissionObject->free = $free;
    }

    if(!$request->has('charge')){

    }else{
      $charge = $request->input('charge');
      $admissionObject->free = $free;
    }

    if($ret = $admissionObject->save()){
      $data = array(
        'admissionId' => $admissionObject['id']
      );
      return $this->retSuccess($data);
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

//------------------- DELETE ---------------------------

  /* 删除出入场 */
  public function delete(Request $request)
  {
    //TODO:accessToken

    /* admissionId */
    if(!$request->has('admissionId')){
      //返回错误
      return $this->retError(ADMISSION_ID_IS_EMPTY_CODE, ADMISSION_ID_IS_EMPTY_WORD);
    }else if(!$admissionObject = Admission::find($request->input('admissionId'))){
      return $this->retError(ADMISSION_ID_IS_NOT_EXIST_CODE, ADMISSION_ID_IS_NOT_EXIST_WORD);
    }else{
      $admissionId = $request->input('admissionId');
    }

    $admissionId->delete();

    return $this->retSuccess();
  }

//------------------- Search ---------------------------

  /* 查询 */
  public function search(Request $request){

    $admissionList = admission::leftJoin('cards', 'admission.cardId', '=', 'cards.id')
                            ->leftJoin('users', 'cards.userId', '=', 'users.id');

    if($request->has('carNum')){
      $carNum = $request->input('carNum');
      $admissionList = $admissionList->where('admission.carNum', 'like', "%$carNum%");
    }else{
      $carNum = null;
    }

    if($request->has('userName')){
      $userName = $request->input('userName');
      $admissionList = $admissionList->where('users.name', 'like', "%$userName%");
    }else{
      $userName = null;
    }

    if($request->has('enterTimeBegin')){
      $enterTimeBegin = strtotime($request->input('enterTimeBegin'));
      $admissionList = $admissionList->where('enterTime', '>=', $enterTimeBegin);
    }else{
      $enterTimeBegin = null;
    }

    if($request->has('enterTimeEnd')){
      $enterTimeEnd = strtotime($request->input('enterTimeEnd'));
      $admissionList = $admissionList->where('enterTime', '<=', $enterTimeEnd);
    }else{
      $enterTimeEnd = null;
    }

    $page    = $request->input('page');
    $perPage = $request->input('perPage');

    if($page){
      // 生成对象
      $count = $admissionList->count();
      $admissionList = $admissionList->paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => $count,
        'perPage'     => $admissionList->perPage(),
        'currentPage' => $admissionList->currentPage(),
        'lastPage'    => $admissionList->lastPage(),
        'nextPageUrl' => $admissionList->nextPageUrl() == null ? null : $admissionList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $admissionList->previousPageUrl() == null ? null : $admissionList->previousPageUrl() . $perPagePan,
      );
    }else{
      $admissionList = $admissionList->get();
    }

    $data = array();
    foreach ($admissionList as $admissionObject) {
      // 获取停车卡类型
      if($admissionObject['cardId'] != null){
        $cardOriType = $admissionObject->parkCard->cardType->type;
        switch ($cardOriType) {
          case 0:
            $cardOriType = "月租卡";
            break;

          case 1:
            $cardOriType = "储值卡";
            break;

          case 2:
            $cardOriType = "临时卡";
            break;

          case 3:
            $cardOriType = "贵宾卡";
            break;

          case 4:
            $cardOriType = "次卡";
            break;

          default:
            $cardOriType = "";
            break;
        }

        // 获取用户名
        $userName = $admissionObject->parkCard->card->user->name;

        // 获取卡信息
        $cardAmount = $admissionObject->parkCard->amount;
        $cardTimes = $admissionObject->parkCard->times;
        $cardBeginDate = date("Y-m-d H:i:s",$admissionObject->parkCard->beginDate);
        $cardEndDate = date("Y-m-d H:i:s",$admissionObject->parkCard->endDate);
        $cardType = $cardOriType . $admissionObject->parkCard->cardType->name;

        // 获取车辆信息
        $carType = $admissionObject->parkCard->car->type;
        $carRegNum = $admissionObject->parkCard->car->number;

      }else{
        $cardType = "临时卡";
        $userName = "临时卡用户";
        $cardAmount = null;
        $cardTimes = null;
        $cardBeginDate= null;
        $cardEndDate = null;
        $carType = null;
        $carRegNum = null;
      }

      // 组装数据
      $data[] = array(
        'admissionId'           => $admissionObject['id'],
        'cardId'                => $admissionObject['cardId'],
        'userName'              => $userName,
        'cardType'              => $cardType,
        'cardAmount'            => $cardAmount,
        'cardTimes'             => $cardTimes,
        'cardBeginDate'         => $cardBeginDate,
        'cardEndDate'           => $cardEndDate,
        'carNum'                => $admissionObject['carNum'],
        'carRegNum'             => $carRegNum,
        'carType'               => $carType,
        'carColor'              => $admissionObject['carColor'],
        'enterBoxDoorId'        => $admissionObject['enterBoxDoorId'],
        'exitBoxDoorId'         => $admissionObject['exitBoxDoorId'],
        'enterImagePath'        => $admissionObject['enterImagePath'],
        'exitImagePath'         => $admissionObject['exitImagePath'],
        'enterTime'             => date("Y-m-d H:i:s",$admissionObject['enterTime']),
        'exitTime'              => date("Y-m-d H:i:s",$admissionObject['exitTime']),
        'free'                  => $admissionObject['free'],
        'charge'                => $admissionObject['charge'],
        'enterExceptionCode'    => json_decode($admissionObject['enterExceptionCode']),
        'exitExceptionCode'     => json_decode($admissionObject['exitExceptionCode']),
        'enterExceptionCodeStr' => $this->exceptionCodeTranfer(json_decode($admissionObject['enterExceptionCode'])),
        'exitExceptionCodeStr'  => $this->exceptionCodeTranfer(json_decode($admissionObject['exitExceptionCode'])),
        'enterExceptionCodeArr' => $this->exceptionCodeTranfer(json_decode($admissionObject['enterExceptionCode']))['arr'],
        'exitExceptionCodeArr'  => $this->exceptionCodeTranfer(json_decode($admissionObject['exitExceptionCode']))['arr'],
        'status'                => $admissionObject['status'],
        'isGuest'               => $admissionObject['isGuest'],
        'created_at'            => date("Y-m-d H:i:s",strtotime($admissionObject['created_at'])),
        'updated_at'            => date("Y-m-d H:i:s",strtotime($admissionObject['updated_at']))
      );
    }
    return $this->retSuccess($data,$page);
  }

  //----------  批量授权 -------------
  public function permission(Request $request){

    // 获取参数
    if($request->has('cards')){
      $cards = $request->input('cards');
      foreach ($cards as $cardId) {
        if(!ParkCard::find($cardId)){
          return $this->retError(CARD_ID_IS_NOT_EXIST_CODE,CARD_ID_IS_NOT_EXIST_WORD);
        }
      }
    }else{
      return $this->retError(CARD_ID_IS_EMPTY_CODE, CARD_ID_IS_EMPTY_WORD);
    }

    if($request->has('boxDoors')){
      $boxDoors = $request->input('boxDoors');
      foreach ($boxDoors as $boxDoorId) {
        if(!BoxDoor::find($boxDoorId)){
          return $this->retError(BOX_DOOR_ID_IS_NOT_EXIST_CODE, BOX_DOOR_ID_IS_NOT_EXIST_WORD);
        }
      }
    }else{
      return $this->retError(BOX_DOOR_ID_IS_EMPTY_CODE, BOX_DOOR_ID_IS_EMPTY_WORD);
    }

    if($request->has('type')){
      $type = (int)$request->input('type');
      if(!preg_match("/^([0-1])$/",$type)){
        return $this->retError(PARK_CARD_PERMISSION_TYPE_IS_ERROR_CODE, PARK_CARD_PERMISSION_TYPE_IS_ERROR_WORD);
      }
    }else{
      return $this->retError(PARK_CARD_PERMISSION_TYPE_IS_EMPTY_CODE, PARK_CARD_PERMISSION_TYPE_IS_EMPTY_WORD);
    }

    foreach ($cards as $cardId) {
      $cardObject = Card::find($cardId);
      $boxIdArray = array();
      // 旧的权限
      foreach ($cardObject->boxdoors as $booxdoorEach) {
        $boxIdArray[] = $booxdoorEach['id'];
      }
      if($type == 0){
        // 新增权限
        foreach ($boxDoors as $newBoxDoorId){
          $flag = true;
          foreach ($boxIdArray as $oldBoxDoorId) {
            if((int)$newBoxDoorId == (int)$oldBoxDoorId){
              $flag = false;
              break;
            }
          }
          if($flag){
            $boxIdArray[] = (int)$newBoxDoorId;
          }
        }
      }else{
        // 删除权限
        $data = array();
        foreach ($boxIdArray as $oldBoxDoorId){
          $flag = true;
          foreach ($boxDoors as $newBoxDoorId){
            if((int)$newBoxDoorId == (int)$oldBoxDoorId){
              $flag = false;
              break;
            }
          }
          if($flag){
            $data[] = (int)$oldBoxDoorId;
          }
        }
        $boxIdArray = $data;
      }
      // 删除中间关系(权限与角色)
      $cardObject->boxdoors()->detach();
      /* 更新岗亭口权限表*/
      foreach ($boxIdArray as $boxDoorId) {
        $cardObject->boxdoors()->attach($boxDoorId);
      }
    }
    return $this->retSuccess();
  }

//------------------- Action ---------------------------

  /* 获取摄像头数据 */
  public function admitRequest(Request $request)
  {
    // 捕获摄像头数据
    $data = json_decode(file_get_contents("php://input"),true);

    // init
    $admission = array();
    $admission['isGuest'] = false;
    $admission['exceptionCode'] = array();

    // 获取车牌号码
    $admission['carNum'] = $data['AlarmInfoPlate']['result']['PlateResult']['license'];
    $admission['voiceCarNum'] = $this->tranferCn($admission['carNum']);
    if(!$admission['carNum']){
      return $this->retError(ADMISSION_CAR_NO_IS_EMPTY_CODE, ADMISSION_CAR_NO_IS_EMPTY_WORD);
    }else{
      // 去掉空格
      $admission['carNum'] = str_replace(' ','',$admission['carNum']);
      if($admission['carNum'] == '_无_'){
        $admission['isGuest'] = true;
        // 添加错误码
        array_push($admission['exceptionCode'], 1);
      }
    }

    // // 车辆是否已
    // if(Admission::where('carNum', '=', $admission['carNum'])->where('enterTime', '>=', time()-10)->first()){
    //   // 存在摄像头请求多次，则忽略
    //   // 添加错误码
    //   array_push($admission['exceptionCode'], 0);
    //   return false;
    // }else{
    //   // 车辆存在异常
    //   $adminssionOldObject = Admission::where('carNum', '=', $admission['carNum'])->where('status', '<>', 3)->get();
    //   if(COUNT($adminssionOldObject) > 0){
    //     // 添加错误码
    //     array_push($admission['exceptionCode'], 2);
    //     // TODO 把异常通知前端
    //     // return $this->retSuccess($adminssionOldObject);
    //   }
    // }

    // 获取车颜色
    $admission['carColor'] = (string)$data['AlarmInfoPlate']['result']['PlateResult']['colorType'];
    if(!$admission['carColor']){
      $admission['carColor'] = 0;
      // 添加错误码
      array_push($admission['exceptionCode'], 3);
      //return $this->retError(ADMISSION_CAR_COLOR_IS_EMPTY_CODE, ADMISSION_CAR_COLOR_IS_EMPTY_WORD);
    }else{
      // TODO 颜色转换
    }

    // 转换为纯车牌卡号
    $admission['cardId'] = SIMPLE_CARD_PREFIX . $admission['carNum'];
    if($parkCardObject = ParkCard::where('cardId', '=', $admission['cardId'])->first()){
      // TODO 判断是否为纯车牌
    }else if($carObject = Car::where('number', '=', $admission['carNum'])->first()){
      if(COUNT($carObject->parkcards) == 0){
        // TODO 车辆未办卡，通知前端
        // 添加错误码
        array_push($admission['exceptionCode'], 4);
        $admission['isGuest'] = true;
        $admission['cardId']  = NULL;
        //return $this->retError(ADMISSION_CAR_PARKCARD_IS_NOT_EXIT_CODE, ADMISSION_CAR_PARKCARD_IS_NOT_EXIT_WORD);
      }else{
        // TODO 一车多卡的情况,现默认取第一个(等待配置模块)
        $admission['cardId'] = $carObject->parkcards[0]['cardId'];
      }
    }else{
      // TODO 车辆信息不存在,通知前端
      // return $this->retError(CAR_ID_IS_NOT_EXIST_CODE, CAR_ID_IS_NOT_EXIST_WORD);
      // 添加错误码
      array_push($admission['exceptionCode'], 5);
      $admission['isGuest'] = true;
      $admission['cardId']  = NULL;
    }

    // 获取IP地址
    $admission['ip'] = $data['AlarmInfoPlate']['ipaddr'];
    if(!$admission['ip']){
      return $this->retError(ADMISSION_IP_IS_EMPTY_CODE, ADMISSION_IP_IS_EMPTY_WORD);
    }else{
      // 配置里面没该IP
      if(!Device::where('ip', '=', $admission['ip'])->first()){
        // TODO 通知前端,找不到对应设备,设置出错
        return $this->retError(DEVICE_ID_IS_NOT_EXIST_CODE, DEVICE_ID_IS_NOT_EXIST_WORD);
      }
    }

    // 获取通道ID
    $admission['boxDoorId'] = Device::where('ip', '=', $admission['ip'])->where('type', '=', '0')->first()['boxDoorId'];
    if(!$admission['boxDoorId']){
      // TODO 通知前端,IP对应的通道不存在,设置出错
      return $this->retError(BOX_DOOR_ID_IS_NOT_EXIST_CODE, BOX_DOOR_ID_IS_NOT_EXIST_WORD);
    }

    // 获取岗亭ID
    $admission['boxId'] = BoxDoor::find($admission['boxDoorId'])['boxId'];

    // 获取图片地址
    $admission['imagePath'] = $data['AlarmInfoPlate']['result']['PlateResult']['imagePath'];
    if(!$admission['imagePath']){
      // return $this->retError(ADMISSION_CAR_COLOR_IS_EMPTY_CODE, ADMISSION_CAR_COLOR_IS_EMPTY_WORD);
      $admission['imagePath'] = NULL;
    }else{
      // TODO 抓取图片
      //$admission['imagePath'] = $this->('http://' . $admission['ip'] . '/' . $admission['imagePath']);
    }

    // 获取当前时间戳
    $admission['time'] = time();

    // 获取对应通道的出口还是入口
    $boxDoorObject = BoxDoor::find($admission['boxDoorId']);
    $function = $boxDoorObject['function'];
    $admission['deviceId'] = $boxDoorObject['mainControlMachine'];
    if($function == 0){
      // 入场
      //return $this->entering($admission);
      return $this->jinqu($admission);
    }else{
      // 出场
      return $this->chuqu($admission);
    }
  }

//---------------------------- 进场 ----------------------------------

  public function jinqu($admission){

    echo "请求进场接口";
    $this->logger('请求进场接口');

    if(!isset($admission['cardId']) || $admission['cardId'] == NULL){
      $admission['cardId'] = SIMPLE_CARD_PREFIX . $admission['carNum'];
    }

    // 是否已记录
    if($admission['carNum'] == "_无_"){
      //TODO 没扫描到车牌号
      echo "没扫描到车牌号<br>";
      $this->logger("没扫描到车牌号");
      echo $admission['carNum'];die;
      $this->logger($admission['carNum']);
    }
    // 已经记录
    else if( $admissionObject = Admission::where('carNum', '=', $admission['carNum'])->first() ){
      echo "车辆已经进场(含有已经进场的记录)<br>";
      $this->logger("车辆已经进场(含有已经进场的记录)");
      /* 判断车辆是否连续进场 - 开始 */
      if( $admissionObject['enterBoxDoorId'] == $admission['boxDoorId']){
        // 相同通道相同车牌
        echo "经过相同通道(相同车牌)<br>";
        $this->logger("经过相同通道(相同车牌)");
        if( $configureObject = Configure::where('name', '=', 'SAME_BOX_DOOR_SAME_CAR_NUMBER_FILTER_TIME')->first() ){
          $delayTime = (int)$configureObject['value'];
        }else{
          $delayTime = 0;
        }
      }else{
        if( $configureObject = Configure::where('name', '=', 'DIFFERENt_BOX_DOOR_SAME_CAR_NUMBER_FILTER_TIME')->first() ){
          echo "经过不同通道(相同车牌)<br>";
          $this->logger("经过不同通道(相同车牌)");
          $delayTime = (int)$configureObject['value'];
        }else{
          $delayTime = 0;
        }
      }

      if( (time() - $admissionObject['enterTime']) < $delayTime){
        echo "忽略请求<br>";die;
        $this->logger("忽略请求");
        return $this->retSuccess();
      }else{
        echo "不忽略请求<br>";
        $this->logger("不忽略请求");
      }
      /* 判断车辆是否连续进场 - 结束*/

      /* 判断是否无人值守 - 开始 */
      if(!$this->isNoPeople($admission)){
        echo "有人值守<br>";
        $this->logger("有人值守");
        // // 为有人值守
        // //TODO 请求前端
        // $success = false;
        // while(!$success)
        // {
        //   $ret = $this->askWebToHandleException();
        //   $ret = json_decode($ret);
        //   if($ret['ret'] == 0){
        //     $success = true;
        //   }
        // }
        // return 0;
        $admissionObject->delete();
      }else{
        echo "无人值守<br>";
        $this->logger("无人值守");
        echo "删除过去记录<br>";
        $this->logger("删除过去记录");
        // 为无人值守

        /* 删除旧的 */
        $admissionObject->delete();
      }
      /* 判断是否无人值守 - 结束 */

    }
    // 没记录也不为无，正常状态
    else{
      // $admissionObject
    }

    return $this->inJudgeCardStep($admission);

  }

  /* 入场判断卡的步骤 */
  public function inJudgeCardStep($admission){
    $guest = true;
    if($this->isSimpleCard($admission['cardId'])){
      $guest = false;
      echo "纯车牌车辆<br>";
      $this->logger("纯车牌车辆");

      /* 获取停车卡对象 */
      $parkCardObject = ParkCard::where('cardId', '=', $admission['cardId'])->first();

      /* 获取卡类型－－－－月租、VIP、储值等 */
      $type = $parkCardObject->cardType['type'];

      $isValid = true;
      $data    = array();
      $msg     = '';

      switch ($type) {
        case 0:

          echo "月租卡车";
          $this->logger('月租卡车');

          // 月租卡
          if($admission['time'] > $parkCardObject['endDate']){
            $msg .= '月租卡过期 ';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 6);
          }

          if($admission['time'] < $parkCardObject['beginDate']){
            $msg .= '卡没有在规定时间内使用 ';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 7);
          }

          if($parkCardObject['amount'] <= 0){
            $msg .= '发行金额不足 ';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 8);
          }

          break;

        case 1:
          // 储值卡

          echo "储值卡车";
          $this->logger('储值卡车');

          if($parkCardObject['balance'] <= 0){
            $msg .= '卡余额不足 ';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 9);
          }

          break;

        case 2:
          // 临时卡

          echo "临时卡车";
          $this->logger('临时卡车');

          break;

        case 3:
          // 贵宾卡

          echo "贵宾卡车";
          $this->logger('贵宾卡车');

          if($admission['time'] > $parkCardObject['endDate']){
            $msg .= '月租卡过期 ';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 6);
          }

          if($admission['time'] < $parkCardObject['beginDate']){
            $msg .= '卡没有在规定时间内使用 ';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 7);
          }

          if($admission['amount'] <= 0){
            $msg .= '发行金额不足 ';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 8);
          }
          break;

        case 4:
          // 次卡

          echo "次卡";
          $this->logger('次卡');

          if($parkCardObject['time'] <= 0){
            $msg .= '卡次数不足 ';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 10);
          }

          break;

        default:
          $msg .= '未知类型';
          $isValid = false;
          break;
      }

      $admission['imagePath'] = $this->downloadPic('http://' . $admission['ip'] . '/' . $admission['imagePath']);

      $admissionObject = new Admission;
      $admissionObject->cardId             = $admission['cardId'];
      $admissionObject->carNum             = $admission['carNum'];
      $admissionObject->carColor           = $admission['carColor'];
      $admissionObject->enterImagePath     = $admission['imagePath'];
      $admissionObject->enterBoxDoorId     = $admission['boxDoorId'];
      $admissionObject->enterTime          = $admission['time'];
      $admissionObject->enterExceptionCode = json_encode($admission['exceptionCode']);
      $admissionObject->status             = 0;
      $admissionObject->isGuest            = $admission['isGuest'];
      if($admissionObject->save()){
        echo "记录保存到库中<br>";
        $this->logger("记录保存到库中");
        $admission['admissionId'] = $admissionObject['id'];
      }else{
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
      }

      if(!$isValid){

        echo "没验证通过 ------- 原因：$msg<br>";
        $this->logger("没验证通过 ------- 原因：$msg");

        /* TODO 无人值守 进入二次确认 */
        if(!$this->isNoPeople($admission) && $this->isErrorHanle()){
          echo "需要二次确认<br>";
          $this->logger("需要二次确认");
          $this->inSecondConfirm($admission);
        }else{
          echo "不需要二次确认<br>";
          $this->logger("不需要二次确认");
        }
      }else{
        echo "验证通过,无异常<br>";
        $this->logger("验证通过,无异常");
      }
      return $this->allowEnterStep($admission);
    }else{
      echo "非纯车牌(全部当游客处理)<br>";
      $this->logger("非纯车牌(全部当游客处理)");
      // 清空cardId

      $admission['cardId'] = null;

      /* TODO 非临时卡先当作游客来操作 */
      /* TODO 是否允许临时车进场*/

      $admission['imagePath'] = $this->downloadPic('http://' . $admission['ip'] . '/' . $admission['imagePath']);

      $admissionObject = new Admission;
      $admissionObject->cardId             = $admission['cardId'];
      $admissionObject->carNum             = $admission['carNum'];
      $admissionObject->carColor           = $admission['carColor'];
      $admissionObject->enterImagePath     = $admission['imagePath'];
      $admissionObject->enterBoxDoorId     = $admission['boxDoorId'];
      $admissionObject->enterTime          = $admission['time'];
      $admissionObject->enterExceptionCode = json_encode($admission['exceptionCode']);
      $admissionObject->status             = 0;
      $admissionObject->isGuest            = $admission['isGuest'];
      if($admissionObject->save()){
        $admission['admissionId'] = $admissionObject['id'];
      }else{
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
      }

      /* 判断是否无人值守 - 开始 */
      if(!$this->isNoPeople($admission)){
        echo "为有人值守<br>";
        $this->logger("为有人值守");
        // 为有人值守
        //TODO 请求前端
        $this->inSecondConfirm($admission);
        return 0;
      }else{
        echo "为无人值守<br>";
        $this->logger("为无人值守");
        return $this->allowEnterStep($admission);
      }
    }
  }

  /* 允许进场步骤 */
  public function allowEnterStep($admission){
    if($this->isBarrierGate()){
      //echo "地感返回<br>";
      $this->logger("地感返回");
      $status = 0;
    }else{
      $status = 1;
      //echo "不需地感返回<br>";
      $this->logger("不需地感返回");
    }
    $boxObject = Box::find($admission['boxId']);
    $deviceObject = Device::where('type', '=', '1')->where('boxDoorId', '=', $admission['boxDoorId'])->first();
    $ledIpAddr = $deviceObject['ip'];
    $admissionObject = Admission::find($admission['admissionId']);
    $admissionObject->status = $status;
    if($admissionObject->save()){
      //echo "请求进场<br>";
      $this->logger("请求进场");
      $ret = $this->sendTcpSvrInRequest($admission['deviceId'], $boxObject['ip'], $ledIpAddr , "欢迎光临" . $admission['voiceCarNum'] , "欢迎" . $admission['carNum'] . "用户光临", $admissionObject['id']);
      //p($ret);die;
      if($ret['ret'] == 0){
        //echo "成功进场<br>";
        $this->logger("请求进场成功");

        // 记录出场流水
        $flowObject = new Flow;
        $flowObject->boxId = $admission['boxId'];
        $flowObject->carNum = $admissionObject->carNum;
        $flowObject->enterBoxDoorName = BoxDoor::find($admissionObject->enterBoxDoorId)['name'];
        if($admissionObject['cardId'] != null){
          $cardOriType = $admissionObject->parkCard->cardType->type;
          switch ($cardOriType) {
            case 0:
              $cardOriType = "月租卡";
              break;

            case 1:
              $cardOriType = "储值卡";
              break;

            case 2:
              $cardOriType = "临时卡";
              break;

            case 3:
              $cardOriType = "贵宾卡";
              break;

            case 4:
              $cardOriType = "次卡";
              break;

            default:
              $cardOriType = "";
              break;
          }
          $cardType = $cardOriType . $admissionObject->parkCard->cardType->name;
        }else{
          $cardType = null;
        }

        $flowObject->cardType = $cardType;
        $flowObject->enterTime = date("Y-m-d H:i:s",$admissionObject->enterTime);
        $flowObject->imagePath = $admissionObject->enterImagePath;

        $flowObject->save();

        if($status == 1){
          //echo "出场成功<br>";
          $this->logger("进场成功");
        }else{
          //echo "结束，需要地感返回才能完成出场";
          $this->logger("结束，需要地感返回才能完成进场");
        }

      }else{
        //echo "进场失败，原因如下<br>";
        $this->logger("进场失败，原因如下");
        //echo 'errorCode: ' . $ret['ret'] . "<br>" . 'errMsg: ' . $ret['errMsg'];
        $this->logger('errorCode: ' . $ret['ret'] . "<br>" . 'errMsg: ' . $ret['errMsg']);
      }
      return $this->retSuccess();
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

  /* 进场二次确认 */
  public function inSecondConfirm($admission){
    //TODO 请求前端
    echo "请求二次确认进场<br>";
    $this->logger("请求二次确认进场");
    $boxObject = Box::find($admission['boxId']);
    $ret = $this->sendTcpSvrInSecondConfirmRequest($boxObject['ip'], $admission['admissionId'], 1);
    if($ret['ret'] == 0){
      echo "入场二次确认请求成功<br>";
      $this->logger("入场二次确认请求成功");
    }else{
      echo "入场二次确认请求失败，原因如下<br>";
      $this->logger("入场二次确认请求失败，原因如下");
      echo 'errorCode: ' . $ret['ret'] . "<br>" . 'errMsg: ' . $ret['errMsg'];
      $this->logger('errorCode: ' . $ret['ret'] . "<br>" . 'errMsg: ' . $ret['errMsg']);
    }
    die;
  }

  /* 取消进场 */
  public function cancelEnter(Request $request){
    $this->logger("取消进场");
    $admissionId = $request->input('admissionId');
    if(!$admissionObject = Admission::find($admissionId)){
      $this->logger('admissionId 不存在');
      //echo 'admissionId 不存在';die;
      return $this->retError(ERR_DB_EXEC_CODE, 'admissionId 不存在');
      // TODO return
    }
    if($admissionObject->delete()){
      return $this->retSuccess();
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

//---------------------------- 出场 ----------------------------------

  /* 出场处理 */
  public function chuqu($admission){

    echo "出场请求<br>";
    $this->logger("出场请求");

    if(!isset($admission['cardId']) || $admission['cardId'] == NULL){
      $admission['cardId'] = SIMPLE_CARD_PREFIX . $admission['carNum'];
    }

    // 是否为_无_
    if($admission['carNum'] == "_无_"){
      //TODO 没扫描到车牌号
      echo "没扫描到车牌号<br>";
      $this->logger("没扫描到车牌号");
      echo $admission['carNum'];die;
      $this->logger($admission['carNum']);
    }

    // 记录是否存在
    if($admissionObject = Admission::where('carNum', '=', $admission['carNum'])->first()){
      /* 存在 */

      // 获取忽略请求的时间
      if( $admissionObject['enterBoxDoorId'] == $admission['boxDoorId']){
        // 相同通道相同车牌
        echo "经过相同通道(相同车牌)<br>";
        $this->logger("经过相同通道(相同车牌)");
        if( $configureObject = Configure::where('name', '=', 'SAME_BOX_DOOR_SAME_CAR_NUMBER_FILTER_TIME')->first() ){
          $delayTime = (int)$configureObject['value'];
        }else{
          $delayTime = 0;
        }
      }else{
        if( $configureObject = Configure::where('name', '=', 'DIFFERENt_BOX_DOOR_SAME_CAR_NUMBER_FILTER_TIME')->first() ){
          echo "经过不同通道(相同车牌)<br>";
          $this->logger("经过不同通道(相同车牌)");
          $delayTime = (int)$configureObject['value'];
        }else{
          $delayTime = 0;
        }
      }

      // 查看是否需要过滤
      if( (time() - $admissionObject['enterTime']) < $delayTime){
        $this->logger("进出场时间过短");
        echo "进出场时间过短<br>";die;
        return $this->retSuccess();
      }else if( isset($admissionObject['exitTime']) && time() - $admissionObject['exitTime'] < $delayTime){
        $this->logger("连续出场，忽略请求");
        echo "连续出场，忽略请求<br>";die;
        return $this->retSuccess();
      }else{
        $this->logger("不忽略请求");
        echo "不忽略请求<br>";
      }

      $admission['imagePath'] = $this->downloadPic('http://' . $admission['ip'] . '/' . $admission['imagePath']);

      // 标记为出场中
      $admissionObject['exitImagePath'] = $admission['imagePath'];
      $admissionObject['exitTime'] = $admission['time'];
      $admissionObject['exitBoxDoorId'] = $admission['boxDoorId'];
      $admissionObject['status'] = 2;
      if($admissionObject->save()){
        $admission['admissionId'] = $admissionObject['id'];
      }else{
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
      }

    }else{
      // 不存在
      $this->logger("该车不存在进场记录");
      echo "该车不存在进场记录<br>";die;
    }

    return $this->outJudgeCardStep($admission);
  }

  /* 出场卡操作步骤 */
  public function outJudgeCardStep($admission){
    // init
    $guest = true;
    $charge = 0;

    $admissionObject = Admission::find($admission['admissionId']);

    if($this->isSimpleCard($admission['cardId'])){
      $guest = false;
      echo "纯车牌车辆<br>";
      $this->logger("纯车牌车辆");

      /* 获取停车卡对象 */
      $parkCardObject = ParkCard::where('cardId', '=', $admission['cardId'])->first();

      /* 获取卡类型－－－－月租、VIP、储值等 */
      $type = $parkCardObject->cardType['type'];

      $isValid = true;
      $data    = array();
      $msg     = '';

      switch ($type) {
        case 0:
          // 月租卡
          echo "月卡车<br>";
          $this->logger("月卡车");

          if($admission['time'] > $parkCardObject['endDate']){
            $msg .= '月租卡过期 ';
            // 添加错误码
            array_push($admission['exceptionCode'], 6);
            $isValid = false;
          }

          if($admission['time'] < $parkCardObject['beginDate']){
            $msg .= '卡没有在规定时间内使用 ';
            // 添加错误码
            array_push($admission['exceptionCode'], 7);
            $isValid = false;
          }

          break;

        case 1:
          // 储值卡
          echo "储值卡车<br>";
          $this->logger("储值卡车");

          /* TODO 计算储值卡收费 */
          // 默认10分钟1块
          $unit = 10 * 60;
          $chargeUnit = 1;

          // 获取出入场时间
          $enterTime = $admissionObject->enterTime;
          $exitTime  = $admissionObject->exitTime;

          $charge = (($exitTime - $enterTime) / $unit) * $chargeUnit;

          if($parkCardObject['balance'] - $charge <= 0){
            $msg .= '卡余额不足 ';
            // 添加错误码
            array_push($admission['exceptionCode'], 9);
            $isValid = false;
          }

          break;

        case 2:
          // 临时卡
          echo "临时卡车<br>";
          $this->logger("临时卡车");

          /* TODO 计算储值卡收费 */
          // 默认5分钟1块
          $unit = 5 * 60;
          $chargeUnit = 1;

          // 获取出入场时间
          $enterTime = $admissionObject->enterTime;
          $exitTime  = $admissionObject->exitTime;

          $charge = (($exitTime - $enterTime) / $unit) * $chargeUnit;

          break;

        case 3:
          // 贵宾卡
          echo "贵宾卡车<br>";
          $this->logger("贵宾卡车");

          if($admission['time'] > $parkCardObject['endDate']){
            $msg .= '贵宾卡过期 ';
            // 添加错误码
            array_push($admission['exceptionCode'], 6);
            $isValid = false;
          }

          if($admission['time'] < $parkCardObject['beginDate']){
            $msg .= '卡没有在规定时间内使用 ';
            // 添加错误码
            array_push($admission['exceptionCode'], 7);
            $isValid = false;
          }
          break;

        case 4:
          // 次卡
          echo "次卡车<br>";
          $this->logger("次卡车");

          // TODO 次卡收费标准
          // 默认扣除一次
          $parkCardObject['time'] -= 1;

          if($parkCardObject['time'] <= 0){
            $msg .= '卡次数不足 ';
            // 添加错误码
            array_push($admission['exceptionCode'], 10);
            $isValid = false;
          }else{
            // 卡次数足够
            echo "卡次数足够<br>";
            $this->logger("卡次数足够");
            if($parkCardObject->save()){
              echo "卡次数更新<br>";
              $this->logger("卡次数更新");
            }else{
              return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
            }
          }

          break;

        default:

          break;
      }

      // 获取出入场时间
      $enterTime = $admissionObject->enterTime;
      $exitTime  = $admissionObject->exitTime;

      $minNum = (int)(($exitTime - $enterTime) / 60);

      echo "一共停：$minNum 分钟，产生费用为：$charge<br>";
      $this->logger("一共停：$minNum 分钟，产生费用为：$charge");

      $admissionObject->charge = $charge;
      $admissionObject->free   = 0;
      if($admissionObject->save()){
        echo "出入场表更新<br>";
        $this->logger("出入场表更新");
      }else{
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
      }

      if(!$isValid){
        echo "没验证通过 ------- 原因：$msg<br>";
        $this->logger("没验证通过 ------- 原因：$msg");
        echo "需要二次确认<br>";
        $this->logger("需要二次确认");
        $this->outSecondConfirm($admission);
      }else{
        echo "验证通过<br>";
        $this->logger("验证通过");
      }

    }else{
      echo "非纯车牌(全部当游客处理)<br>";
      $this->logger("非纯车牌(全部当游客处理)");
      // 清空cardId

      $admission['cardId'] = null;

      /* TODO 非临时卡先当作游客来操作 */
      /* TODO 是否允许临时车出场*/

      /* TODO 计算储值卡收费 */
      // 默认5分钟1块
      $unit = 5 * 60;
      $chargeUnit = 2;

      // 获取出入场时间
      $enterTime = $admissionObject->enterTime;
      $exitTime  = $admissionObject->exitTime;

      $minNum = (int)(($exitTime - $enterTime) / 60);
      $charge = (int)(($exitTime - $enterTime) / $unit) * $chargeUnit;

      echo "一共停：$minNum 分钟，产生费用为：$charge<br>";
      $this->logger("一共停：$minNum 分钟，产生费用为：$charge<br>");

      $admissionObject->charge = $charge;
      $admissionObject->free   = 0;
      if($admissionObject->save()){
        echo "出入场表更新<br>";
        $this->logger("出入场表更新");
      }else{
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
      }
      $this->outSecondConfirm($admission);
    }
    $this->allowExitStep($admission);
  }

  /* 允许出场步骤 */
  public function allowExitStep($admission){
    if($this->isBarrierGate()){
      //echo "地感返回<br>";
      $this->logger("地感返回");
      $status = 3;
    }else{
      $status = 4;
      //echo "不需地感返回<br>";
      $this->logger("不需地感返回");
    }
    $boxObject = Box::find($admission['boxId']);
    $deviceObject = Device::where('type', '=', '1')->where('boxDoorId', '=', $admission['boxDoorId'])->first();
    $ledIpAddr = $deviceObject['ip'];
    $admissionObject = Admission::find($admission['admissionId']);
    $admissionObject->status = $status;
    if($admissionObject->save()){
      //echo "请求出场<br>";
      $this->logger("请求出场");
      $ret = $this->sendTcpSvrOutRequest($admission['deviceId'], $boxObject['ip'], $ledIpAddr ,"用户" . $admission['voiceCarNum'] . "一路顺风", "用户" . $admission['carNum'] . "一路顺风", $admissionObject['id']);
      //p($ret);die;
      if($ret['ret'] == 0){

        //echo "出场请求成功<br>";
        $this->logger("出场请求成功");

        // 记录出场流水
        $flowObject = new Flow;
        $flowObject->boxId = $admission['boxId'];
        $flowObject->carNum = $admissionObject->carNum;
        $flowObject->enterBoxDoorName = BoxDoor::find($admissionObject->enterBoxDoorId)['name'];
        $flowObject->exitBoxDoorName = BoxDoor::find($admissionObject->exitBoxDoorId)['name'];
        if($admissionObject['cardId'] != null){
          $cardOriType = $admissionObject->parkCard->cardType->type;
          switch ($cardOriType) {
            case 0:
              $cardOriType = "月租卡";
              break;

            case 1:
              $cardOriType = "储值卡";
              break;

            case 2:
              $cardOriType = "临时卡";
              break;

            case 3:
              $cardOriType = "贵宾卡";
              break;

            case 4:
              $cardOriType = "次卡";
              break;

            default:
              $cardOriType = "";
              break;
          }
          $cardType = $cardOriType . $admissionObject->parkCard->cardType->name;
        }else{
          $cardType = null;
        }

        $flowObject->cardType = $cardType;
        $flowObject->enterTime = date("Y-m-d H:i:s",$admissionObject->enterTime);
        $flowObject->exitTime = date("Y-m-d H:i:s",$admissionObject->exitTime);
        $flowObject->charge = $admissionObject->charge;
        $flowObject->free = $admissionObject->free;
        $flowObject->imagePath = $admissionObject->exitImagePath;

        $flowObject->save();

        if($status == 4){
          //echo "出场成功<br>";
          $this->logger("出场成功");
          $admissionObject->delete();
        }else{
          //echo "结束，需要地感返回才能完成出场";
          $this->logger("结束，需要地感返回才能完成出场");
        }

      }else{
        //echo "出场请求失败，原因如下<br>";
        $this->logger("出场请求失败，原因如下");
        //echo 'errorCode: ' . $ret['ret'] . "<br>" . 'errMsg: ' . $ret['errMsg'];
        $this->logger('errorCode: ' . $ret['ret'] . "<br>" . 'errMsg: ' . $ret['errMsg']);
      }
      return $this->retSuccess();
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

  /* 二次确认 */
  public function outSecondConfirm($admission){
    //TODO 请求前端
    echo "请求二次确认出场<br>";
    $this->logger("请求二次确认出场");
    $boxObject = Box::find($admission['boxId']);
    $ret = $this->sendTcpSvrOutSecondConfirmRequest($boxObject['ip'], $admission['admissionId'], 2);
    if($ret['ret'] == 0){
      echo "出场二次确认请求成功<br>";
      $this->logger("出场二次确认请求成功");
    }else{
      echo "出场二次确认请求失败，原因如下<br>";
      $this->logger("出场二次确认请求失败，原因如下");
      echo 'errorCode: ' . $ret['ret'] . "<br>" . 'errMsg: ' . $ret['errMsg'];
      $this->logger('errorCode: ' . $ret['ret'] . "<br>" . 'errMsg: ' . $ret['errMsg']);
    }
    die;
  }

  /* 取消出场 */
  public function cancelExit(Request $request){
    $this->logger("取消出场");
    $admissionId = $request->input('admissionId');
    if(!$admissionObject = Admission::find($admissionId)){
      $this->logger('admissionId 不存在');
      //echo 'admissionId 不存在';die;
      return $this->retError(ERR_DB_EXEC_CODE, 'admissionId 不存在');
      // TODO return
    }
    $admissionObject->status = 1;
    if($admissionObject->save()){
      return $this->retSuccess();
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

//---------------------------- 公共 ----------------------------------

  /* 事件分发 */
  public function eventDistribution(Request $request){
    // 获取请求参数
    $event = (int)$request->input('event');
    $admissionId = $request->input('admissionId');
    if(!Admission::find($admissionId)){
      $this->logger('admissionId 不存在');
      //echo 'admissionId 不存在';die;
      return $this->retError(ERR_DB_EXEC_CODE, 'admissionId 不存在');
      // TODO return
    }
    // 事件分发处理
    switch ($event) {
      // 入场确认
      case 1:
        // 封装参数
        $admissionObject = Admission::find($admissionId);
        $admission['isGuest'] = $admissionObject->isGuest;
        $admission['exceptionCode'] = json_decode($admissionObject->enterExceptionCode);
        $admission['carNum'] = $admissionObject->carNum;
        $admission['cardId'] = $admissionObject->cardId;
        $admission['boxDoorId'] = $admissionObject->enterBoxDoorId;
        $admission['imagePath'] = $admissionObject->enterImagePath;
        $admission['admissionId'] = $admissionId;
        $boxDoorObject = BoxDoor::find($admission['boxDoorId']);
        $admission['boxId'] = $boxDoorObject['boxId'];
        $admission['deviceId'] = $boxDoorObject['mainControlMachine'];
        $admission['voiceCarNum'] = $this->tranferCn($admission['carNum']);
        // 请求入场
        return $this->allowEnterStep($admission);
        break;

      // 出场确认
      case 2:
        // 封装参数
        $admissionObject = Admission::find($admissionId);
        $admission['isGuest'] = $admissionObject->isGuest;
        $admission['exceptionCode'] = json_decode($admissionObject->exitExceptionCode);
        $admission['carNum'] = $admissionObject->carNum;
        $admission['cardId'] = $admissionObject->cardId;
        $admission['boxDoorId'] = $admissionObject->exitBoxDoorId;
        $admission['imagePath'] = $admissionObject->exitImagePath;
        $admission['admissionId'] = $admissionId;
        $boxDoorObject = BoxDoor::find($admission['boxDoorId']);
        $admission['boxId'] = $boxDoorObject['boxId'];
        $admission['deviceId'] = $boxDoorObject['mainControlMachine'];
        $admission['voiceCarNum'] = $this->tranferCn($admission['carNum']);
        // 请求出场
        return $this->allowExitStep($admission);
        break;

      // 省略
      default:
        $this->logger('参数有误，省略分发请求');
        echo "参数有误，省略分发请求<br>";die;
        return $this->retSuccess();
        break;
    }
  }

  /* 请求语音 */
  public function sendVoice(Request $request){
    $ret = $this->sendTcpSvrVoiceRequest(1,"开门吧");
    p($ret);die;
  }

  /* 请求Led */
  public function sendLed(Request $request){
    $ret = $this->sendTcpSvrLedRequest("192.168.1.160","开门吧");
    p($ret);die;
  }

  /* 请求开闸 */
  public function sendOpenGate(Request $request){
    $ret = $this->sendTcpSvrOpenGateRequest(1);
    p($ret);die;
  }

  /* 请求下载 */
  public function requestDownloadPic($remoteDir){
      $url = DOWNLOAD_PICTURE_INTERFACE;
      $post_data = array ("url" => $remoteDir);
      curl_post_muti_handle($url, $post_data);
      return time() . '.' . get_extension($remoteDir);;
  }

  /* 异步下载图片 */
  public function downloadPic($url){
      //$url = $request->input('url');
      $save_dir = '';
      $filename = time() . '.' . get_extension($url);
      $type = 0;
      if(trim($url)==''){
        return false;
      }
      if(trim($save_dir)==''){
       $save_dir='uploadfiles';
      }
      if(0!==strrpos($save_dir,'/')){
       $save_dir.='/';
      }
      //创建保存目录
      if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
       return false;
      }
     //获取远程文件所采用的方法
     if($type){
        $ch=curl_init();
        $timeout=60;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $content=curl_exec($ch);
        curl_close($ch);
     }else{
        ob_start();
        readfile($url);
        $content=ob_get_contents();
        ob_end_clean();
     }
     $size=strlen($content);
     //文件大小
     $fp2=@fopen($save_dir.$filename,'a');
     fwrite($fp2,$content);
     fclose($fp2);
     unset($content,$url);
     return $save_dir.$filename;
     //return array('file_name'=>$filename,'save_path'=>$save_dir.$filename);
  }

  /* 错误码中文转换 */
  public function exceptionCodeTranfer($exceptionCodes){
    // init
    $str = "";
    $arr = array();
    $tranferArray = array(
      0  => '请求多次',
      1  => '_无_，无车牌车辆或者无法识别车牌',
      2  => '车辆存在状态异常，车标示为还在场内或已出场',
      3  => '车辆颜色不存在',
      4  => '车辆未办卡',
      5  => '车辆信息不存在',
      6  => '卡过期',
      7  => '卡还没到规定使用的时间',
      8  => '发行金额不足',
      9  => '余额不足',
      10 => '次数不足',
      11 => '不存在入场记录',
    );

    if(!$exceptionCodes) return array('str'=>$str, 'arr'=>$arr);

    foreach ($exceptionCodes as $exceptionCode) {
      $str .= $tranferArray[$exceptionCode] ."\n";
      $arr[] = $tranferArray[$exceptionCode];
    }
    return array('str'=>$str, 'arr'=>$arr);
  }

  /* 地压确认接口 */
  public function barrierGateConfirmFlow(Request $request){
    $admissionId = $request['admissionId'];
    $admissionObject = Admission::find($admissionId);
    $status = $admissionObject->status + 1;
    if($status >= 3){
      echo "地感返回成功，完成出场<br>";
      $this->logger('地感返回成功，完成出场');
      $admissionObject->delete();
    }else{
      echo "地感返回成功，完成入场<br>";
      $this->logger('地感返回成功，完成入场');
      if($admissionObject->save()){
        return $this->retSuccess();
      }else{
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
      }
    }
  }

  /* 是否纯车牌 */
  public function isSimpleCard($cardId){
    if(ParkCard::where('cardId', '=', $cardId)->first()){
      return true;
    }else{
      return false;
    }
  }

  /* 是否地压返回 */
  public function isBarrierGate(){
    $isBarrierGate = Configure::where('name', '=', 'IS_BARRIER_GATE')->first()['value'];
    if($isBarrierGate == 0){
      return false;
    }else{
      return true;
    }
  }

  /* 是否需要异常处理 */
  public function isErrorHanle(){
    $monitorDialogType = Configure::where('name', '=', 'MONITOR_DIALOG_TYPE')->first()['value'];
    $isErrorHanle = json_decode($monitorDialogType,true);
    if(in_array('4', $isErrorHanle)){
      return true;
    }else{
      return false;
    }
  }

  /* 是否无人值守 */
  public function isNoPeople($admission){
    $boxId = BoxDoor::find($admission['boxDoorId'])['boxId'];
    $isNoPeople = Configure::where('name', '=', 'IS_ENTER_NO_PEOPLE')->where('boxId', '=', $boxId)->first()['value'];
    if($isNoPeople == 0){
      return false;
    }else{
      return true;
    }
  }

  function tranferCn($str=""){
    if($str=="") return;
    $cnArray = array(
      '0' => '零',
      '1' => '一',
      '2' => '二',
      '3' => '三',
      '4' => '四',
      '5' => '五',
      '6' => '六',
      '7' => '七',
      '8' => '八',
      '9' => '九'
    );
    $ret = "";
    for($i=0;$i<strlen($str);$i++)
    {
      $middle = $str[$i]; //将单个字符存到数组当中
      if($middle >= 0 && $middle <= 9 )
      {
        if(isset($cnArray[$middle])) {
          $ret .= $cnArray[$middle];
        } else {
          $ret .= $middle;
        }
      }
    }
    return $ret;
  }

  //------------------- READ FLOW ---------------------------

    /* 读岗亭 */
    public function readFlow(Request $request)
    {
      if($request->has('boxId')){
        /* 带参数时,获取列表 */
        $page    = $request->input('page');
        $perPage = $request->input('perPage');
        $boxId   = $request->input('boxId');
        return $this->getFlowListByBoxId($boxId, $page, $perPage);
      }else{
        $page    = $request->input('page');
        $perPage = $request->input('perPage');
        return $this->getFlowList($page, $perPage);
      }
    }

    /* 获取单个岗亭 */
    public function getFlowListByBoxId($boxId, $page, $perPage)
    {
      if($page){
        $flowList = Flow::where('boxId', $boxId)->orderBy('updated_at', 'desc')->paginate($perPage);
        if($perPage){
          $perPagePan = "&perPage=" . $perPage;
        }else{
          $perPagePan = "";
        }
        // 分页信息
        $page = array(
          'total'       => Flow::where('boxId', $boxId)->orderBy('updated_at', 'desc')->count(),
          'perPage'     => $flowList->perPage(),
          'currentPage' => $flowList->currentPage(),
          'lastPage'    => $flowList->lastPage(),
          'nextPageUrl' => $flowList->nextPageUrl() == null ? null : $flowList->nextPageUrl() . $perPagePan,
          'prevPageUrl' => $flowList->previousPageUrl() == null ? null : $flowList->previousPageUrl() . $perPagePan,
        );
      }else{
        $flowList = Flow::where('boxId', $boxId)->orderBy('updated_at', 'desc')->get();
      }
      $data = array();
      foreach ($flowList as $flowObject) {
        // 组装数据
        if( $flowObject['cardType'] == null ){
          $flowObject['cardType'] = '临时卡';
        }
        $data[] = $flowObject;
      }
      return $this->retSuccess($data,$page);
    }

    /* 获取岗亭列表 */
    public function getFlowList($page, $perPage)
    {
      if($page){
        $flowList = Flow::orderBy('updated_at', 'desc')->paginate($perPage);
        if($perPage){
          $perPagePan = "&perPage=" . $perPage;
        }else{
          $perPagePan = "";
        }
        // 分页信息
        $page = array(
          'total'       => Flow::orderBy('updated_at', 'desc')->count(),
          'perPage'     => $flowList->perPage(),
          'currentPage' => $flowList->currentPage(),
          'lastPage'    => $flowList->lastPage(),
          'nextPageUrl' => $flowList->nextPageUrl() == null ? null : $flowList->nextPageUrl() . $perPagePan,
          'prevPageUrl' => $flowList->previousPageUrl() == null ? null : $flowList->previousPageUrl() . $perPagePan,
        );
      }else{
        $flowList = Flow::orderBy('updated_at', 'desc')->get();
      }
      $data = array();
      foreach ($flowList as $flowObject) {
        // 组装数据
        if( $flowObject['cardType'] == null ){
          $flowObject['cardType'] = '临时卡';
        }
        $data[] = $flowObject;
      }
      return $this->retSuccess($data,$page);
    }

}
