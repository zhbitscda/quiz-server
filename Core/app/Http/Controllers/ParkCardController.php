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
use App\Models\DelayRecord;

class ParkCardController extends Controller
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

    /* 获取单个操作者 */
    public function getInfo($id)
    {
      // 查找该ID的对象是否存在
      if(!$parkCardObject = ParkCard::find($id)){
        return $this->retError(CARD_ID_IS_NOT_EXIST_CODE, CARD_ID_IS_NOT_EXIST_WORD);
      }else{
        // 岗亭权限
        $boxDoorsRight = array();
        foreach ($parkCardObject->card->boxdoors as $value) {
          $boxDoorsRight[] = $value['id'];
      }
      // 组装数据
      $data = array(
        'cardId'        => $parkCardObject['cardId'],
        'userId'        => $parkCardObject->card['userId'],
        'userName'      => $parkCardObject->card->user['name'],
        'property'      => $parkCardObject->card['property'],
        'deposit'       => $parkCardObject->card['deposit'],
        'printNo'       => $parkCardObject['printNo'],
        'cardTypeId'    => $parkCardObject['typeId'],
        'cardTypeName'  => $parkCardObject->cardType['name'],
        'times'         => $parkCardObject['times'],
        'balance'       => $parkCardObject['balance'],
        'amount'        => $parkCardObject['amount'],
        'boxDoorsRight' => $boxDoorsRight,
        'isNote'        => $parkCardObject['isNote'],
        'isBlack'       => $parkCardObject['isBlack'],
        'remark'        => $parkCardObject['remark'],
        // TODO delete locationInfo
        // 'carLocId'      => $parkCardObject->car['locationId'],
        // 'carLocName'    => $parkCardObject->car->location['name'],
        'carNum'        => $parkCardObject->car['number'],
        'carId'         => $parkCardObject->car['id'],
        'carType'       => $parkCardObject->car['type'],
        'parkingPlace'  => $parkCardObject->car['parkingPlace'],
        'carColor'      => $parkCardObject->car['color'],
        'carPhotoId'    => $parkCardObject->car['photoId'],
        'carPhotoUrl'   => $parkCardObject->car->photo['url'],
        'beginDate'     => date("Y-m-d", $parkCardObject['beginDate']),
        'endDate'       => date("Y-m-d", $parkCardObject['endDate']),
        'status'        => $parkCardObject->card['status']
      );
      return $this->retSuccess($data);
    }
  }

    /* 获取操作者列表 */
    public function getList($page, $perPage)
    {
      //return $this->retSuccess(Card::all());
      if($page){
        $parkCardList = ParkCard::paginate($perPage);
        if($perPage){
          $perPagePan = "&perPage=" . $perPage;
        }else{
          $perPagePan = "";
        }
        // 分页信息
        $page = array(
          'total'       => ParkCard::count(),
          'perPage'     => $parkCardList->perPage(),
          'currentPage' => $parkCardList->currentPage(),
          'lastPage'    => $parkCardList->lastPage(),
          'nextPageUrl' => $parkCardList->nextPageUrl() == null ? null : $parkCardList->nextPageUrl() . $perPagePan,
          'prevPageUrl' => $parkCardList->previousPageUrl() == null ? null : $parkCardList->previousPageUrl() . $perPagePan,
        );
      }else{
        $parkCardList = ParkCard::all();
      }
      $data = array();
      foreach ($parkCardList as $parkCardObject) {
        // 岗亭权限
        $boxDoorsRight = array();
        foreach ($parkCardObject->card->boxdoors as $value) {
          $boxDoorsRight[] = $value['id'];
        }
        // 组装数据
        $data[] = array(
          'cardId'        => $parkCardObject['cardId'],
          'userId'        => $parkCardObject->card['userId'],
          'userName'      => $parkCardObject->card->user['name'],
          'property'      => $parkCardObject->card['property'],
          'deposit'       => $parkCardObject->card['deposit'],
          'printNo'       => $parkCardObject['printNo'],
          'cardTypeId'    => $parkCardObject['typeId'],
          'cardTypeName'  => $parkCardObject->cardType['name'],
          'times'         => $parkCardObject['times'],
          'balance'       => $parkCardObject['balance'],
          'amount'        => $parkCardObject['amount'],
          'boxDoorsRight' => $boxDoorsRight,
          'isNote'        => $parkCardObject['isNote'],
          'isBlack'       => $parkCardObject['isBlack'],
          'remark'        => $parkCardObject['remark'],
          // TODO delete locationInfo
          //'carLocId'      => $parkCardObject->car['locationId'],
          //'carLocName'    => $parkCardObject->car->location['name'],
          'carNum'        => $parkCardObject->car['number'],
          'carId'         => $parkCardObject->car['id'],
          'carType'       => $parkCardObject->car['type'],
          'parkingPlace'  => $parkCardObject->car['parkingPlace'],
          'carColor'      => $parkCardObject->car['color'],
          'carPhotoId'    => $parkCardObject->car['photoId'],
          'carPhotoUrl'   => $parkCardObject->car->photo['url'],
          'beginDate'     => date("Y-m-d", $parkCardObject['beginDate']),
          'endDate'       => date("Y-m-d", $parkCardObject['endDate']),
          'status'        => $parkCardObject->card['status']
        );
      }
      return $this->retSuccess($data, $page);
    }

    //------------------- CREATE ---------------------------

    /* 添加操作者 */
    public function add(Request $request)
    {
      /* init */
      $cardId       = 0;
      $userId       = 0;
      $property     = 0;
      $deposit      = 0;
      $printNo      = "";
      $cardTypeId   = 0;
      $times        = 0;
      $balance      = 0;
      $boxDoorsRight = array();
      $isNote       = 0;
      $remark       = "";
      // TODO delete locationId
      //$carLocId     = NULL;
      $carNum       = "";
      $carType      = "";
      $parkingPlace = "";
      $carColor     = "#000";
      $carPhotoId   = 0;
      $carId        = 0;
      $beginDate    = 0;
      $endDate      = 0;
      $isTempCard   = false;

      /* 参数检测 */
      // cardId
      if(!$request->has('cardId')){
        // 判断是否为空
        if($request->input('property') != 2){
           return $this->retError(CARD_ID_IS_EMPTY_CODE, CARD_ID_IS_EMPTY_WORD);
        }else{
          // 纯车牌
           $cardId = SIMPLE_CARD_PREFIX . $request->input('carNum');
        }
      }else if(ParkCard::find($request->input("cardId"))){
        // 监测该cardID是否已经存在
        return $this->retError(CARD_ID_IS_IN_USED_CODE, CARD_ID_IS_IN_USED_WORD);
      }else{
        // 成功赋值
        $cardId = $request->input("cardId");
        $cardObject = Card::find($request->input("cardId"));
      }

      // userId
      if(!$request->has('userId')){
        // 判断是否为空
        //return $this->retError(USER_ID_IS_EMPTY_CODE, USER_ID_IS_EMPTY_WORD);
        $userId = 0;
      }else if(User::where('id', $request->input("userId"))->count() == 0){
        // 监测该userId是否已经存在
        return $this->retError(USER_ID_IS_NOT_EXIST_CODE, USER_ID_IS_NOT_EXIST_WORD);
      }else{
        // 成功赋值
        $userId = $request->input("userId");
      }

      // property
      if(!$request->has('property')){
        // 判断是否为空
        //return $this->retError(CARD_PROPERTY_IS_EMPTY_CODE, CARD_PROPERTY_IS_EMPTY_WORD);
        $property = 0;
      }else if(!preg_match("/^([0-2])$/",$request->input("property"))){
        // 判断属性是否服从规则
        return $this->retError(CARD_PROPERTY_IS_ERROR_CODE, CARD_PROPERTY_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $property = $request->input("property");
      }

      // deposit
      if(!$request->has('deposit')){
        // 判断是否为空
        //return $this->retError(CARD_DEPOSITE_IS_EMPTY_CODE, CARD_DEPOSITE_IS_EMPTY_WORD);
        $deposit = 0;
      }else if(!preg_match("/^0|[1-9][0-9]{0,3}|99999$/",$request->input("deposit"))){
        // 判断属性是否服从规则
        return $this->retError(CARD_DEPOSITE_IS_ERROR_CODE, CARD_DEPOSITE_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $deposit = $request->input("deposit");
      }

      // printNo
      if(!$request->has('printNo')){
        // 判断是否为空
        //return $this->retError(CARD_PRINT_NO_IS_EMPTY_CODE, CARD_PRINT_NO_IS_EMPTY_WORD);
        $printNo = "";
      }else{
        // 成功赋值
        $printNo = $request->input("printNo");
      }

      // cardTypeId
      if(!$request->has('cardTypeId')){
        // 判断是否为空
        return $this->retError(PARK_CARD_TYPE_ID_IS_EMPTY_CODE, PARK_CARD_TYPE_ID_IS_EMPTY_WORD);
      }else if(ParkCardType::where('id', $request->input("cardTypeId"))->count() == 0){
        // 监测该cardTypeId是否已经存在
        return $this->retError(PARK_CARD_TYPE_ID_IS_NOT_EXIST_CODE, PARK_CARD_TYPE_ID_IS_NOT_EXIST_WORD);
      }else{
        // 成功赋值
        $cardTypeId = $request->input("cardTypeId");
        $parkCardType = ParkCardType::find($cardTypeId);
        if($parkCardType['type'] == 2){
          $isTempCard = true;
        }
      }

      // times
      if(!$request->has('times')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_TIMES_IS_EMPTY_CODE, PARK_CARD_TIMES_IS_EMPTY_WORD);
        $times = 0;
      }else if(!preg_match("/^\d+$/",$request->input("times"))){
        // 判断属性是否服从规则
        return $this->retError(PARK_CARD_TIMES_IS_ERROR_CODE, PARK_CARD_TIMES_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $times = $request->input("times");
      }

      // balance
      if(!$request->has('balance')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_BALANCE_IS_EMPTY_CODE, PARK_CARD_BALANCE_IS_EMPTY_WORD);
        $balance = 0;
      }else if(!preg_match("/^\d+(?:\.\d{2}|)$/",$request->input("balance"))){
        // 判断属性是否服从规则
        return $this->retError(PARK_CARD_BALANCE_IS_ERROR_CODE, PARK_CARD_BALANCE_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $balance = $request->input("balance");
      }

      // amount
      if(!$request->has('amount')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_BALANCE_IS_EMPTY_CODE, PARK_CARD_BALANCE_IS_EMPTY_WORD);
        $amount = 0;
      }else if(!preg_match("/^\d+(?:\.\d{2}|)$/",$request->input("amount"))){
        // 判断属性是否服从规则
        return $this->retError(PARK_CARD_AMOUNT_IS_ERROR_CODE, PARK_CARD_AMOUNT_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $amount = $request->input("amount");
      }

      // boxRight
      if(!$request->has('boxDoorsRight')){
        // 判断是否为空
        //return $this->retError(BOX_DOOR_RIGHT_IS_EMPTY_CODE, BOX_DOOR_RIGHT_IS_EMPTY_WORD);
        $boxDoorsRight = array();
      }else{
        $boxDoorsRight = $request->input("boxDoorsRight");
        // 检查权限是否存在
        foreach ($boxDoorsRight as $key => $value) {
          if(!BoxDoor::find($value)){
            return $this->retError(BOX_DOOR_RIGHT_IS_ERROR_CODE, BOX_DOOR_RIGHT_IS_ERROR_WORD);
          }
        }
      }

      // isNote
      if(!$request->has('isNote')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_ISNOTE_IS_EMPTY_CODE, PARK_CARD_ISNOTE_IS_EMPTY_WORD);
        $isNote = 0;
      }else if(!preg_match("/^([0-1])$/",$request->input("isNote"))){
        // 判断属性是否服从规则
        return $this->retError(PARK_CARD_ISNOTE_IS_ERROR_CODE, PARK_CARD_ISNOTE_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $isNote = $request->input("isNote");
      }

      //remark
      if(!$request->has('remark')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_REMARK_IS_EMPTY_CODE, PARK_CARD_REMARK_IS_EMPTY_WORD);
        $remark = "";
      }else{
        // 成功赋值
        $remark = $request->input("remark");
      }

      if($isTempCard == false){
        // carLocId
        // if(!$request->has('carLocId')){
        //   // 判断是否为空
        //   return $this->retError(CAR_LOC_ID_IS_EMPTY_CODE, CAR_LOC_ID_IS_EMPTY_WORD);
        // }else if(CarLocation::where('id', $request->input("carLocId"))->count() == 0){
        //   // 监测该carLocId是否已经存在
        //   return $this->retError(CAR_LOC_ID_IS_NOT_EXIST_CODE, CAR_LOC_ID_IS_NOT_EXIST_WORD);
        // }else{
        //   // 成功赋值
        //   $carLocId = $request->input("carLocId");
        // }

        // carNum
        if(!$request->has('carNum')){
          // 判断是否为空
          //return $this->retError(CAR_NUM_IS_EMPTY_CODE, CAR_NUM_IS_EMPTY_WORD);
          $carNum = "";
        }else{
          // 成功赋值
          $carNum = $request->input("carNum");
          $carObject = Car::where('number', '=', $carNum)->first();
        }

        // carTypeId
        if(!$request->has('carType')){
          // 判断是否为空
          return $this->retError(CAR_TYPE_ID_IS_EMPTY_CODE, CAR_TYPE_ID_IS_EMPTY_WORD);
        }else{
          // 成功赋值
          $carType = $request->input("carType");
        }

        // parkingPlace
        if(!$request->has('parkingPlace')){
          // 判断是否为空
          //return $this->retError(CAR_PARKING_PLACE_IS_EMPTY_CODE, CAR_PARKING_PLACE_IS_EMPTY_WORD);
          $parkingPlace = "";
        }else{
          // 成功赋值
          $parkingPlace = $request->input("parkingPlace");
        }

        // carColor
        if(!$request->has('carColor')){
          // 判断是否为空
          //return $this->retError(CAR_COLOR_IS_EMPTY_CODE, CAR_COLOR_IS_EMPTY_WORD);
          $carColor = "#000";
        }else{
          // 成功赋值
          $carColor = $request->input("carColor");
        }

        // carPhotoId
        // if(!$request->has('carPhotoId')){
        //   // 判断是否为空
        //   return $this->retError(CAR_PHOTO_ID_IS_EMPTY_CODE, CAR_PHOTO_ID_IS_EMPTY_WORD);
        // }else if(CarPhoto::where('id', $request->input("carPhotoId"))->count() == 0){
        //   // 监测该carPhotoId是否已经存在
        //   return $this->retError(CAR_PHOTO_ID_IS_NOT_EXIST_CODE, CAR_PHOTO_ID_IS_NOT_EXIST_WORD);
        // }else{
        //   // 成功赋值
        //   $carPhotoId = $request->input("carPhotoId");
        // }
        if(!$request->has('carPhotoId')){
          // 判断是否为空
          //return $this->retError(CAR_PHOTO_ID_IS_EMPTY_CODE, CAR_PHOTO_ID_IS_EMPTY_WORD);
          // 默认值
          $carPhotoId = 1;
        }else{
          // 成功赋值
          $carPhotoId = $request->input("carPhotoId");
        }

        // // carId
        // if(!$request->has('carId')){
        //   // 判断是否为空
        //   //return $this->retError(CAR_ID_IS_EMPTY_CODE, CAR_ID_IS_EMPTY_WORD);
        //   $carId = NULL;
        // }else if(Car::where('id', $request->input("carId"))->count() == 0){
        //   // 监测该carId是否已经存在
        //   return $this->retError(CAR_ID_IS_NOT_EXIST_CODE, CAR_ID_IS_NOT_EXIST_WORD);
        // }else{
        //   // 成功赋值
        //   $carId = $request->input("carId");
        // }
      }

      // beginDate
      if(!$request->has('beginDate')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_BEGIN_DATE_IS_EMPTY_CODE, PARK_CARD_BEGIN_DATE_IS_EMPTY_WORD);
        $beginDate = time();
      }else{
        // 成功赋值
        $beginDate = strtotime($request->input("beginDate"));
      }

      // endDate
      if(!$request->has('endDate')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_END_DATE_IS_EMPTY_CODE, PARK_CARD_END_DATE_IS_EMPTY_WORD);
        $endDate = time();
      }else{
        // 成功赋值
        $endDate = strtotime($request->input("endDate"));
      }

      // // 检测车牌是否已经存在
      // if(!$carId){
      //   // TODO delete locationInfo
      //   // if(Car::where('locationId', $carLocId)->where('number', $carNum)->count() != 0){
      //   //   return $this->retError(CAR_NUM_IS_EXIST_CODE, CAR_NUM_IS_EXIST_WORD);
      //   // }
      //   if(Car::where('number', $carNum)->count() != 0){
      //     return $this->retError(CAR_NUM_IS_EXIST_CODE, CAR_NUM_IS_EXIST_WORD);
      //   }
      // }

      /* 录入操作者表 */

      /* card */
      if($cardObject){
        // 如果存在，更新
      }else{
        // 如果不存在，就添加一条
        $cardObject = new Card;
        $cardObject->id = $cardId;
        $cardObject->isUsedDoor = 0;
        $cardObject->isUsedCharge = 0;
        $cardObject->deposit = $deposit;
        $cardObject->property = $property;
        $cardObject->status = 0;
        $cardObject->userId = $userId;
      }
      $cardObject->isUsedPark = 1;
      if($ret = $cardObject->save()){
        $data = array(
          'cardId' => $cardObject['id']
        );
      }else{
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
      }

      if($isTempCard == false){
        /* car */
        if($carObject){

        }else{
          // 如果不含有carId参数，则添加一条car信息
          $carObject = new Car;
        }
        $carObject->userId = $userId;
        // TODO delete locationId
        //$carObject->locationId = $carLocId;
        $carObject->number = $carNum;
        $carObject->type   = $carType;
        $carObject->parkingPlace = $parkingPlace;
        $carObject->color = $carColor;
        $carObject->photoId = $carPhotoId;
        if($ret = $carObject->save()){
          $carId = $carObject['id'];
          $data['carId'] = $carId;
        }else{
          return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
        }
      }

      /* parkCard */
      $parkCardObject = new ParkCard;
      $parkCardObject->cardId = $cardId;
      $parkCardObject->carId = $carId;
      $parkCardObject->printNo = $printNo;
      $parkCardObject->typeId = $cardTypeId;
      $parkCardObject->times = $times;
      $parkCardObject->balance = $balance;
      $parkCardObject->amount  = $amount;
      $parkCardObject->isNote = $isNote;
      $parkCardObject->remark = $remark;
      $parkCardObject->beginTime = 0;
      $parkCardObject->endTime = 0;
      $parkCardObject->beginDate = $beginDate;
      $parkCardObject->endDate = $endDate;
      if(!$ret = $parkCardObject->save()){
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
      }

      /* boxDoors_cards */
      // 添加中间关系(权限与角色)
      foreach ($boxDoorsRight as $boxDoorId) {
        $cardObject->boxdoors()->attach($boxDoorId);
      }

      // 返回
      return $this->retSuccess($data);
    }

    //------------------- PUT ---------------------------

    /* 更新操作者 */
    public function update(Request $request)
    {
      //TODO:accessToken

      // before
      $beforeBeginDate = NULL;
      $beforeEndDate   = NULL;
      $beforeAmount    = NULL;
      // 标记是否延期
      $delayFlag = false;

      /* 参数检测 */
      // cardId
      if(!$request->has('cardId')){
        // 判断是否为空
        if($request->input('property') != 2){
           return $this->retError(CARD_ID_IS_EMPTY_CODE, CARD_ID_IS_EMPTY_WORD);
        }else{
          // 纯车牌
           $cardId = SIMPLE_CARD_PREFIX . $request->input('carNum');
        }
      }else if(!$parkCardObject = ParkCard::find($request->input('cardId'))){
        // 监测该cardID是否已经存在
        return $this->retError(CARD_ID_IS_NOT_EXIST_CODE, CARD_ID_IS_NOT_EXIST_WORD);
      }else{
        // 成功赋值
        $cardId = $request->input("cardId");
        $cardObject = Card::find($cardId);
      }

      // userId
      if(!$request->has('userId')){
        // 判断是否为空
        //return $this->retError(USER_ID_IS_EMPTY_CODE, USER_ID_IS_EMPTY_WORD);
      }else if(User::where('id', $request->input("userId"))->count() == 0){
        // 监测该userId是否已经存在
        return $this->retError(USER_ID_IS_NOT_EXIST_CODE, USER_ID_IS_NOT_EXIST_WORD);
      }else{
        // 成功赋值
        $userId = $request->input("userId");
        $cardObject->userId = $userId;
      }

      // property
      if(!$request->has('property')){
        // 判断是否为空
        return $this->retError(CARD_PROPERTY_IS_EMPTY_CODE, CARD_PROPERTY_IS_EMPTY_WORD);
      }else if(!preg_match("/^([0-2])$/",$request->input("property"))){
        // 判断属性是否服从规则
        return $this->retError(CARD_PROPERTY_IS_ERROR_CODE, CARD_PROPERTY_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $property = $request->input("property");
        $cardObject->property = $property;
      }

      // deposit
      if(!$request->has('deposit')){
        // 判断是否为空
        //return $this->retError(CARD_DEPOSITE_IS_EMPTY_CODE, CARD_DEPOSITE_IS_EMPTY_WORD);
      }else if(!preg_match("/^0|[1-9][0-9]{0,3}|99999$/",$request->input("deposit"))){
        // 判断属性是否服从规则
        return $this->retError(CARD_DEPOSITE_IS_ERROR_CODE, CARD_DEPOSITE_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $deposit = $request->input("deposit");
        $cardObject->deposit = $deposit;
      }

      // status
      if(!$request->has('status')){
        //判断是否为空
        //return $this->retError(CARD_STATUS_IS_EMPTY_CODE, CARD_STATUS_IS_EMPTY_WORD);
      }else{
        $status = $request->input("status");
        $cardObject->status = $status;
      }

      // printNo
      if(!$request->has('printNo')){
        // 判断是否为空
        //return $this->retError(CARD_PRINT_NO_IS_EMPTY_CODE, CARD_PRINT_NO_IS_EMPTY_WORD);
      }else{
        // 成功赋值
        $printNo = $request->input("printNo");
        $parkCardObject->printNo = $printNo;
      }

      // cardTypeId
      if(!$request->has('cardTypeId')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_TYPE_ID_IS_EMPTY_CODE, PARK_CARD_TYPE_ID_IS_EMPTY_WORD);
        $cardTypeId = $parkCardObject['typeId'];
      }else if(ParkCardType::where('id', $request->input("cardTypeId"))->count() == 0){
        // 监测该cardTypeId是否已经存在
        return $this->retError(PARK_CARD_TYPE_ID_IS_NOT_EXIST_CODE, PARK_CARD_TYPE_ID_IS_NOT_EXIST_WORD);
      }else{
        // 成功赋值
        $cardTypeId = $request->input("cardTypeId");
        $parkCardObject->typeId = $cardTypeId;
      }

      // times
      if(!$request->has('times')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_TIMES_IS_EMPTY_CODE, PARK_CARD_TIMES_IS_EMPTY_WORD);
      }else if(!preg_match("/^\d+$/",$request->input("times"))){
        // 判断属性是否服从规则
        return $this->retError(PARK_CARD_TIMES_IS_ERROR_CODE, PARK_CARD_TIMES_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $times = $request->input("times");
        $parkCardObject->times = $times;
      }

      // balance
      if(!$request->has('balance')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_BALANCE_IS_EMPTY_CODE, PARK_CARD_BALANCE_IS_EMPTY_WORD);
      }else if(!preg_match("/^\d+(?:\.\d{2}|)$/",$request->input("balance"))){
        // 判断属性是否服从规则
        return $this->retError(PARK_CARD_BALANCE_IS_ERROR_CODE, PARK_CARD_BALANCE_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $balance = $request->input("balance");
        $parkCardObject->balance = $balance;
      }

      // amount
      if(!$request->has('amount')){
        // 判断是否为空
      }else if(!preg_match("/^\d+(?:\.\d{2}|)$/",$request->input("amount"))){
        // 判断属性是否服从规则
        return $this->retError(PARK_CARD_AMOUNT_IS_ERROR_CODE, PARK_CARD_AMOUNT_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $amount = $request->input("amount");
        $beforeAmount = $amount;
        if($parkCardObject['amount'] != $amount){
          $delayFlag = true;
          $beforeAmount = $parkCardObject['amount'];
          $parkCardObject->amount = $amount;
        }
      }

      // boxRight
      if(!$request->has('boxDoorsRight')){
        // 判断是否为空
        //return $this->retError(BOX_RIGHT_IS_EMPTY_CODE, BOX_RIGHT_IS_EMPTY_WORD);
        $boxDoorsRight = NULL;
      }else{
        $boxDoorsRight = $request->input("boxDoorsRight");

        // 检查权限是否存在
        foreach ($boxDoorsRight as $key => $value) {
          if(!BoxDoor::find($value)){
            return $this->retError(BOX_DOOR_RIGHT_IS_ERROR_CODE, BOX_DOOR_RIGHT_IS_ERROR_WORD);
          }
        }
      }

      // isNote
      if(!$request->has('isNote')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_ISNOTE_IS_EMPTY_CODE, PARK_CARD_ISNOTE_IS_EMPTY_WORD);
      }else if(!preg_match("/^([0-1])$/",$request->input("isNote"))){
        // 判断属性是否服从规则
        return $this->retError(PARK_CARD_ISNOTE_IS_ERROR_CODE, PARK_CARD_ISNOTE_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $isNote = $request->input("isNote");
        $parkCardObject->isNote = $isNote;
      }

      // isNote
      if(!$request->has('isBlack')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_ISNOTE_IS_EMPTY_CODE, PARK_CARD_ISNOTE_IS_EMPTY_WORD);
      }else if(!preg_match("/^([0-1])$/",$request->input("isBlack"))){
        // 判断属性是否服从规则
        return $this->retError(PARK_CARD_ISBLACK_IS_ERROR_CODE, PARK_CARD_ISBLACK_IS_ERROR_WORD);
      }else{
        // 成功赋值
        $isBlack = $request->input("isBlack");
        $parkCardObject->isBlack = $isBlack;
      }

      //remark
      if(!$request->has('remark')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_REMARK_IS_EMPTY_CODE, PARK_CARD_REMARK_IS_EMPTY_WORD);
      }else{
        // 成功赋值
        $remark = $request->input("remark");
        $parkCardObject->remark = $remark;
      }

      //operatorId
      if(!$request->has('operatorId')){
        // 判断是否为空
        return $this->retError(OPERATOR_ID_IS_EMPTY_CODE, OPERATOR_ID_IS_EMPTY_WORD);
      }else{
        // 成功赋值
        $operatorId = $request->input("operatorId");
      }

      // beginDate
      if(!$request->has('beginDate')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_BEGIN_DATE_IS_EMPTY_CODE, PARK_CARD_BEGIN_DATE_IS_EMPTY_WORD);
        //$beginDate = 0;
        $beforeBeginDate = $parkCardObject['beginDate'];
      }else{
        // 成功赋值
        $beginDate = strtotime($request->input("beginDate"));
        $beforeBeginDate = $beginDate;
        if($parkCardObject['beginDate'] != $beginDate){
          $delayFlag = true;
          $beforeBeginDate = $parkCardObject['beginDate'];
          $parkCardObject->beginDate = $beginDate;
        }
      }

      // endDate
      if(!$request->has('endDate')){
        // 判断是否为空
        //return $this->retError(PARK_CARD_END_DATE_IS_EMPTY_CODE, PARK_CARD_END_DATE_IS_EMPTY_WORD);
        //$endDate = 0;
        $beforeEndDate = $parkCardObject['endDate'];
      }else{
        // 成功赋值
        $endDate = strtotime($request->input("endDate"));
        $beforeEndDate = $endDate;
        if($parkCardObject['endDate'] != $endDate){
          $delayFlag = true;
          $beforeEndDate = $parkCardObject['endDate'];
          $parkCardObject->endDate = $endDate;
        }
      }

      // carId
      if(!$request->has('carId')){
        // 判断是否为空
        //return $this->retError(CAR_ID_IS_EMPTY_CODE, CAR_ID_IS_EMPTY_WORD);
        //$carId = NULL;
        $carObject = Car::find($parkCardObject['carId']);
        $carNum = $carObject['number'];
      }else if(!$carObject = Car::find($request->input("carId"))){
        // 监测该carId是否已经存在
        return $this->retError(CAR_ID_IS_NOT_EXIST_CODE, CAR_ID_IS_NOT_EXIST_WORD);
      }else{
        // 成功赋值
        $carId = $request->input("carId");
        $carObject->userId = $userId;

        // carLocId TODO delete locationId
        // if(!$request->has('carLocId')){
        //   // 判断是否为空
        //   return $this->retError(CAR_LOC_ID_IS_EMPTY_CODE, CAR_LOC_ID_IS_EMPTY_WORD);
        // }else if(CarLocation::where('id', $request->input("carLocId"))->count() == 0){
        //   // 监测该carLocId是否已经存在
        //   return $this->retError(CAR_LOC_ID_IS_NOT_EXIST_CODE, CAR_LOC_ID_IS_NOT_EXIST_WORD);
        // }else{
        //   // 成功赋值
        //   $carLocId = $request->input("carLocId");
        //   $carObject->locationId = $carLocId;
        // }

        // carNum
        if(!$request->has('carNum')){
          // 判断是否为空
          //return $this->retError(CAR_NUM_IS_EMPTY_CODE, CAR_NUM_IS_EMPTY_WORD);
          //$carNum = "";
        }else{
          // 成功赋值
          $carNum = $request->input("carNum");
          $carObject->number = $carNum;
        }

        // carTypeId
        if(!$request->has('carType')){
          // 判断是否为空
          //return $this->retError(CAR_TYPE_ID_IS_EMPTY_CODE, CAR_TYPE_ID_IS_EMPTY_WORD);
        }else{
          // 成功赋值
          $carType = $request->input("carType");
          $carObject->type = $carType;
        }

        // parkingPlace
        if(!$request->has('parkingPlace')){
          // 判断是否为空
          //return $this->retError(CAR_PARKING_PLACE_IS_EMPTY_CODE, CAR_PARKING_PLACE_IS_EMPTY_WORD);
          //$parkingPlace = "";
        }else{
          // 成功赋值
          $parkingPlace = $request->input("parkingPlace");
          $carObject->parkingPlace = $parkingPlace;
        }

        // carColor
        if(!$request->has('carColor')){
          // 判断是否为空
          //return $this->retError(CAR_COLOR_IS_EMPTY_CODE, CAR_COLOR_IS_EMPTY_WORD);
          //$carColor = "#000";
        }else{
          // 成功赋值
          $carColor = $request->input("carColor");
          $carObject->color = $carColor;
        }

        // carPhotoId
        if(!$request->has('carPhotoId')){
          // 判断是否为空
          //return $this->retError(CAR_PHOTO_ID_IS_EMPTY_CODE, CAR_PHOTO_ID_IS_EMPTY_WORD);
        }else if(CarPhoto::where('id', $request->input("carPhotoId"))->count() == 0){
          // 监测该carPhotoId是否已经存在
          return $this->retError(CAR_PHOTO_ID_IS_NOT_EXIST_CODE, CAR_PHOTO_ID_IS_NOT_EXIST_WORD);
        }else{
          // 成功赋值
          $carPhotoId = $request->input("carPhotoId");
          $carObject->photoId = $carPhotoId;
        }

        if(!$carObject->save()){
          return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD . " car");
        }

      }

      // 延期纪录
      if($delayFlag){
        $cardType = ParkCardType::find($cardTypeId);
        if($cardType['type'] == 0 || $cardType['type'] == 3){
          $delayRecordObject = new DelayRecord;
          $delayRecordObject->beforeBeginDate = $beforeBeginDate;
          $delayRecordObject->beforeEndDate   = $beforeEndDate;
          $delayRecordObject->afterBeginDate  = $parkCardObject['beginDate'];
          $delayRecordObject->afterEndDate    = $parkCardObject['endDate'];
          $delayRecordObject->amount          = $amount;
          $delayRecordObject->carNum          = $carNum;
          $delayRecordObject->cardType        = $cardTypeId;
          $delayRecordObject->cardOriType     = $cardType['type'];
          $delayRecordObject->operatorId      = $operatorId;
          if(!$delayRecordObject->save()){
            return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD . " car");
          }
        }
      }else{
        $parkCardObject->amount = $beforeAmount;
      }

      // 保存数据库
      if(!$cardObject->save()){
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD . " card");
      }

      if(!$parkCardObject->save()){
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD . " parkCard");
      }

      // 如果 boxRight 不存在就不更新
      if($boxDoorsRight){
        // 删除中间关系(权限与角色)
    	  $cardObject->boxdoors()->detach();

    	  foreach ($boxDoorsRight as $boxDoorId) {
    	    $cardObject->boxdoors()->attach($boxDoorId);
    	  }
      }

      return $this->retSuccess();

    }

  //------------------- DELETE ---------------------------

    /* 删除操作者 */
    public function delete(Request $request)
    {
      //TODO:accessToken

      // 获取请求参数
      if(!$request->has('cardId')){
        return $this->retError(CARD_ID_IS_EMPTY_CODE, CARD_ID_IS_EMPTY_WORD);
      }else{
        $cardId = $request->input("cardId");
      }

      // 查找该ID的对象
      if(!$cardObject = Card::find($cardId)){
        // 卡完全不存在
        return $this->retError(CARD_ID_IS_NOT_EXIST_CODE, CARD_ID_IS_NOT_EXIST_WORD);
      }else if(!$parkCardObject = ParkCard::find($cardId)){
        // 停车卡功能未开通
        return $this->retError(PARK_CARD_FUNCTION_IS_NOT_EXIST_CODE, PARK_CARD_FUNCTION_IS_NOT_EXIST_WORD);
      }else{
        $isUsedDoor = FALSE;
        // 停车卡功能已经开通, 查看门禁功能是否已经开通
        if($cardObject['isUsedDoor'] != 0){
          $isUsedDoor = TRUE;
        }
      }

      // 删除关联表
      $cardObject->boxdoors()->detach();

      // 删除停车卡数据
      $parkCardObject->delete();

      // 判断门禁功能是否已经开通
      if($isUsedDoor){
        // 已开通
        $cardObject->isUsedPark = 0;
        $cardObject->save();
      }else{
        // 未开通
        $cardObject->delete();
      }

      // 返回
      return $this->retSuccess();
    }

    //------------------- issueParkCardData ---------------------------

    public function issueParkCardData(Request $request){
        $cardTypeData    = array();
        $carLocationData = array();
        $carTypeData     = array();
        $carPhotoData    = array();
        $storedCardData  = array();
        $tempCardData    = array();
        $vipCardData     = array();
        $timeCardData    = array();
        /* 卡类型 */
        $cardTypeList = ParkCardType::where([])->orderBy('id','asc')->get();
        foreach ($cardTypeList as $cardType) {
          switch ($cardType['type']) {
            case 0:
              $cardTypeHead = "月租卡";
              break;

            case 1:
              $cardTypeHead = "储值卡";
              break;

            case 2:
              $cardTypeHead = "临时卡";
              break;

            case 3:
              $cardTypeHead = "贵宾卡";
              break;

            case 4:
              $cardTypeHead = "";
              break;

            default:
              $cardTypeHead = null;
              break;
          }
          $cardTypeData[] = array(
            'value'   => $cardType['id'],
            'name' => $cardType['name'],
            'fullName' => $cardTypeHead . $cardType['name']
          );
        }
        /* 所有月卡类型 */
        $monthCardList = ParkCardType::where('type', '0')->orderBy('id','asc')->get();
        foreach ($monthCardList as $monthCard) {
          $monthCardData[] = array(
            'value' => $monthCard['id'],
            'name'  => $monthCard['name']
          );
        }
        /* 所有储值卡类型 */
        $storedCardList = ParkCardType::where('type', '1')->orderBy('id','asc')->get();
        foreach ($storedCardList as $storedCard) {
          $storedCardData[] = array(
            'value' => $storedCard['id'],
            'name'  => $storedCard['name']
          );
        }
        /* 所有临时卡类型 */
        $tempCardList = ParkCardType::where('type', '2')->orderBy('id','asc')->get();
        foreach ($tempCardList as $tempCard) {
          $tempCardData[] = array(
            'value' => $tempCard['id'],
            'name'  => $tempCard['name']
          );
        }
        /* 所有贵宾卡类型 */
        $vipCardList = ParkCardType::where('type', '3')->orderBy('id','asc')->get();
        foreach ($vipCardList as $vipCard) {
          $vipCardData[] = array(
            'value' => $vipCard['id'],
            'name'  => $vipCard['name']
          );
        }
        /* 所有次卡类型 */
        $timeCardList = ParkCardType::where('type', '4')->orderBy('id','asc')->get();
        foreach ($timeCardList as $timeCard) {
          $timeCardData[] = array(
            'value' => $timeCard['id'],
            'name'  => $timeCard['name']
          );
        }
        /* 车牌所属地 */
        $carLocationList = CarLocation::where([])->orderBy('id','asc')->get();
        foreach ($carLocationList as $carLocation) {
          $carLocationData[] = array(
            'value'   => $carLocation['id'],
            'name' => $carLocation['name']
          );
        }
        /* 车型 */
        $carTypeList = CarType::where([])->orderBy('id','asc')->get();
        foreach ($carTypeList as $carType) {
          $carTypeData[] = array(
            'value' => $carType['id'],
            'name'  => $carType['name']
          );
        }
        /* 车图片 */
        $carPhotoList = CarPhoto::where([])->orderBy('id','asc')->get();
        foreach ($carPhotoList as $carPhoto) {
          $carPhotoData[] = array(
            'value'  => $carPhoto['id'],
            'name' => $carPhoto['url'],
          );
        }
        /* 车状态 */
        $cardStatus = array(
          array(
            'value'  => 0,
            'name' => '正常',
          ),
          array(
            'value'  => 1,
            'name' => '挂失',
          ),
          array(
            'value'  => 3,
            'name' => '停用',
          )
        );
        /* 卡原始类型 */
        $cardOriTypeList = array(
          array(
            'value'  => 0,
            'name' => '月租卡',
            'subType' => $monthCardList
          ),
          array(
            'value'  => 1,
            'name' => '储值卡',
            'subType' => $storedCardList
          ),
          array(
            'value'  => 2,
            'name' => '临时卡',
            'subType' => $tempCardList
          ),
          array(
            'value'  => 3,
            'name' => '贵宾卡',
            'subType' => $vipCardList
          ),
          array(
            'value'  => 4,
            'name' => '次卡',
            'subType' => $timeCardList
          )
        );
        /* 卡的属性 */
        $cardPropetyList = array(
          array(
            'value'  => 0,
            'name' => 'ID卡',
          ),
          array(
            'value'  => 1,
            'name' => 'IC卡',
          ),
          array(
            'value'  => 2,
            'name' => '纯车牌',
          )
        );
        // 组装数据
        $data = array(
          'cardType'   => $cardTypeData,
          'cardOriType'=> $cardOriTypeList,
          'monthCard'  => $monthCardData,
          'storedCard' => $storedCardData,
          'tempCard'   => $tempCardData,
          'vipCard'    => $vipCardData,
          'timeCard'   => $timeCardData,
          'property'   => $cardPropetyList,
          'cardStatus' => $cardStatus,
          'carLoc'     => $carLocationData,
          'carType'    => $carTypeData,
          'carPhoto'   => $carPhotoData
        );
        // 返回
        return $this->retSuccess($data);
    }

    //------------------- change ---------------------------

    public function change(Request $request){

      //TODO:accessToken

      /* 参数检测 */
      // cardId
      if(!$request->has('oldCardId')){
        // 判断是否为空
        return $this->retError(OLD_CAR_ID_IS_EMPTY_CODE, OLD_CAR_ID_IS_EMPTY_WORD);
      }else if(!$parkCardObject = ParkCard::find($request->input('oldCardId'))){
        // 监测该cardID是否已经存在
        return $this->retError(OLD_CAR_ID_IS_NOT_EXIST_CODE, OLD_CAR_ID_IS_NOT_EXIST_WORD);
      }else{
        // 成功赋值
        $oldCardId = $request->input("oldCardId");
        $cardObject = Card::find($oldCardId);
      }

      if(!$request->has('newCardId')){
        // 判断是否为空
        return $this->retError(NEW_CAR_ID_IS_EMPTY_CODE, NEW_CAR_ID_IS_EMPTY_WORD);
      }else if(ParkCard::find($request->input('newCardId'))){
        // 监测该cardID是否已经存在
        return $this->retError(NEW_CAR_ID_IS_EXIST_CODE, NEW_CAR_ID_IS_EXIST_WORD);
      }else{
        // 成功赋值
        $newCardId = $request->input("newCardId");
      }

      // 修改主键

      /* 获取旧的岗亭权限 */
      $boxDoorsRight = array();
      foreach ($parkCardObject->card->boxdoors as $value) {
        $boxDoorsRight[] = $value['id'];
      }
      // 删除中间关系(权限与角色)
      $cardObject->boxdoors()->detach();

      /* parkCard表 */
      $parkCardObject->cardId = $newCardId;
      // 保存数据库
      if(!$parkCardObject->save()){
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD . " card");
      }
      /* card表 */
      $cardObject->id = $newCardId;
      // 保存数据库
      if(!$cardObject->save()){
        return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD . " card");
      }

      /* 更新岗亭口权限表*/
      foreach ($boxDoorsRight as $boxDoorId) {
        $cardObject->boxdoors()->attach($boxDoorId);
      }

      return $this->retSuccess();

    }

    //------------------- search ---------------------------
    public function search(Request $request){

      $parkCardList = parkCard::leftJoin('cards', 'parkCards.cardId', '=', 'cards.id')
                              ->leftJoin('users', 'cards.userId', '=', 'users.id')
                              ->leftJoin('cars', 'parkCards.carId', '=', 'cars.id');

      if($request->has('boxDoorId')){
        $boxDoorId = $request->input('boxDoorId');
        $parkCardList = $parkCardList->leftJoin('boxDoors_cards', 'parkCards.cardId', '=', 'boxDoors_cards.cardId');
        if($request->has('isIssued')){
          $isIssued = $request->input('isIssued');
        }else{
          $isIssued = 0;
        }
        if($isIssued == 0){
          $parkCardList = $parkCardList->where('boxDoorId', '=', $boxDoorId);
          //return $this->retSuccess($parkCardList->get());
        }else{
          $parkCardList = $parkCardList->where('boxDoorId', '<>', $boxDoorId)->groupBy('boxDoorId');
          //return $this->retSuccess($parkCardList->get());
        }
      }

      if($request->has('carNum')){
        $carNum = $request->input('carNum');
        $parkCardList = $parkCardList->where('cars.number', 'like', "%$carNum%");
      }else{
        $carNum = null;
      }

      if($request->has('cardId')){
        $cardId = $request->input('cardId');
        $parkCardList = $parkCardList->where('parkCards.cardId', 'like', "%$cardId%");
      }else{
        $cardId = null;
      }

      if($request->has('printNo')){
        $printNo = $request->input('printNo');
        $parkCardList = $parkCardList->where('printNo', 'like', "%$printNo%");
      }else{
        $printNo = null;
      }

      if($request->has('userId')){
        $userId = $request->input('userId');
        $parkCardList = $parkCardList->where('userId', 'like', "%$userId%");
      }else{
        $userId = null;
      }

      if($request->has('userName')){
        $userName = $request->input('userName');
        $parkCardList = $parkCardList->where('users.name', 'like', "%$userName%");
      }else{
        $userName = null;
      }

      if($request->has('cardOriType')){
        $cardOriType  = $request->input('cardOriType');
        $parkCardList = $parkCardList->leftJoin('parkCardTypes', 'parkCards.typeId', '=', 'parkCardTypes.id');
        $parkCardList = $parkCardList->where('parkCardTypes.type', '=', $cardOriType);
      }else{
        $cardOriType = null;
      }

      if($request->has('cardTypeId')){
        $cardTypeId  = $request->input('cardTypeId');
        $parkCardList = $parkCardList->where('typeId', '=', $cardTypeId);
      }else{
        $cardTypeId = null;
      }

      if($request->has('status')){
        $status = $request->input('status');
        $parkCardList = $parkCardList->where('cards.status', '=', "$status");
      }else{
        $status = null;
      }

      if($request->has('isBlack')){
        $isBlack = $request->input('isBlack');
        $parkCardList = $parkCardList->where('isBlack', '=', "$isBlack");
      }else{
        $isBlack = null;
      }

      $page    = $request->input('page');
      $perPage = $request->input('perPage');

      if($page){
        // 生成对象
        $count = $parkCardList->count();
        $parkCardList = $parkCardList->paginate($perPage);
        if($perPage){
          $perPagePan = "&perPage=" . $perPage;
        }else{
          $perPagePan = "";
        }
        // 分页信息
        $page = array(
          'total'       => $count,
          'perPage'     => $parkCardList->perPage(),
          'currentPage' => $parkCardList->currentPage(),
          'lastPage'    => $parkCardList->lastPage(),
          'nextPageUrl' => $parkCardList->nextPageUrl() == null ? null : $parkCardList->nextPageUrl() . $perPagePan,
          'prevPageUrl' => $parkCardList->previousPageUrl() == null ? null : $parkCardList->previousPageUrl() . $perPagePan,
        );
      }else{
        $parkCardList = $parkCardList->get();
      }

      $data = array();
      foreach ($parkCardList as $parkCardObject) {
        // 岗亭权限
        $boxDoorsRight = array();
        foreach ($parkCardObject->card->boxdoors as $value) {
          $boxDoorsRight[] = $value['id'];
        }
        // 组装数据
        $data[] = array(
          'cardId'        => $parkCardObject['cardId'],
          'userId'        => $parkCardObject->card['userId'],
          'userName'      => $parkCardObject->card->user['name'],
          'property'      => $parkCardObject->card['property'],
          'deposit'       => $parkCardObject->card['deposit'],
          'printNo'       => $parkCardObject['printNo'],
          'cardTypeId'    => $parkCardObject['typeId'],
          'cardTypeName'  => $parkCardObject->cardType['name'],
          'times'         => $parkCardObject['times'],
          'balance'       => $parkCardObject['balance'],
          'boxDoorsRight' => $boxDoorsRight,
          'isNote'        => $parkCardObject['isNote'],
          'remark'        => $parkCardObject['remark'],
          // TODO delete locationInfo
          // 'carLocId'      => $parkCardObject->car['locationId'],
          // 'carLocName'    => $parkCardObject->car->location['name'],
          'carNum'        => $parkCardObject->car['number'],
          'carId'         => $parkCardObject->car['id'],
          'carType'       => $parkCardObject->car['type'],
          'parkingPlace'  => $parkCardObject->car['parkingPlace'],
          'carColor'      => $parkCardObject->car['color'],
          'carPhotoId'    => $parkCardObject->car['photoId'],
          'carPhotoUrl'   => $parkCardObject->car->photo['url'],
          'beginDate'     => date("Y-m-d", $parkCardObject['beginDate']),
          'endDate'       => date("Y-m-d", $parkCardObject['endDate']),
          'status'        => $parkCardObject->card['status']
        );
      }
      return $this->retSuccess($data, $page);
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

}
