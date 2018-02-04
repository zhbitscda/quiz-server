/* 进场 */
public function entering($admission){
    if(!$admission['isGuest']){
      $parkCardObject = ParkCard::where('cardId', '=', $admission['cardId'])->first();

      $type = $parkCardObject->cardType['type'];

      $isValid = false;
      $data    = array();
      $msg     = '';

      switch ($type) {
        case 0:
          // 月租卡
          if($admission['time'] > $parkCardObject['endDate']){
            $msg = '月租卡过期';
            // 添加错误码
            array_push($admission['exceptionCode'], 6);
          }

          if($admission['time'] < $parkCardObject['beginDate']){
            $msg = '卡没有在规定时间内使用';
            // 添加错误码
            array_push($admission['exceptionCode'], 7);
          }

          if($admission['amount'] <= 0){
            $msg = '发行金额不足';
            // 添加错误码
            array_push($admission['exceptionCode'], 8);
          }

          break;

        case 1:
          // 储值卡
          if($parkCardObject['balance'] <= 0){
            $msg = '卡余额不足';
            // 添加错误码
            array_push($admission['exceptionCode'], 9);
          }

          break;

        case 2:
          // 临时卡

          break;

        case 3:
          // 月租卡
          if($admission['time'] > $parkCardObject['endDate']){
            $msg = '月租卡过期';
            // 添加错误码
            array_push($admission['exceptionCode'], 6);
          }

          if($admission['time'] < $parkCardObject['beginDate']){
            $msg = '卡没有在规定时间内使用';
            // 添加错误码
            array_push($admission['exceptionCode'], 7);
          }

          if($admission['amount'] <= 0){
            $msg = '发行金额不足';
            // 添加错误码
            array_push($admission['exceptionCode'], 8);
          }
          break;

        case 4:
          // 次卡
          if($parkCardObject['time'] <= 0){
            $msg = '卡次数不足';
            // 添加错误码
            array_push($admission['exceptionCode'], 10);
          }

          break;

        default:

          break;
      }

      if(!$isValid){
        // TODO 通知显示器
        //return $this->retError(-1, $msg);
      }
    }else{

    }

    // TODO 查看配置，是否需要二次确认开闸
    if(true && !$admission['isGuest']){
      $admission['status'] = 1;
    }else{
      $admission['status'] = 0;
    }

    // TODO 通知TCP SVR，发送开闸请求等
    // $tcpSvrData = array();

    // 数据库插入
    $admissionObject = new Admission;
    $admissionObject->cardId             = $admission['cardId'];
    $admissionObject->carNum             = $admission['carNum'];
    $admissionObject->carColor           = $admission['carColor'];
    $admissionObject->enterImagePath     = $admission['imagePath'];
    $admissionObject->enterBoxDoorId     = $admission['boxDoorId'];
    $admissionObject->enterTime          = $admission['time'];
    $admissionObject->enterExceptionCode = json_encode($admission['exceptionCode']);
    $admissionObject->status             = $admission['status'];
    $admissionObject->isGuest            = $admission['isGuest'];

    if($ret = $admissionObject->save()){
      $data = array(
        'admissionId' => $admissionObject['id'],
        'function'    => 0
      );
      $this->sendTcpSvr($admission['deviceId'], $admission['ip'], '欢迎光临', '欢迎光临', $admissionObject['id']);
      //return $data;
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
}

/* 出场 */
public function exiting($admission){
  // init
  $admission['charge'] = 0;

  $admissionList = Admission::where('carNum', '=', $admission['carNum'])->where('status', '<>', 3)->orderBy('enterTime', 'desc')->get();

  if(COUNT($admissionList) == 0){
    // TODO 不存在该入场记录，通知前端
    // 添加错误码
    array_push($admission['exceptionCode'], 11);
    $admission['isGuest'] = 1;
    $admission['status']  = 2;
    $admissionObject = new Admission;
    $admissionObject->cardId             = $admission['cardId'];
    $admissionObject->carNum             = $admission['carNum'];
    $admissionObject->carColor           = $admission['carColor'];
    $admissionObject->exitImagePath      = $admission['imagePath'];
    $admissionObject->exitBoxDoorId      = $admission['boxDoorId'];
    $admissionObject->enterTime          = $admission['time'];
    $admissionObject->enterExceptionCode = json_encode($admission['exceptionCode']);
    $admissionObject->status             = $admission['status'];
    $admissionObject->isGuest            = $admission['isGuest'];

    if($ret = $admissionObject->save()){
      $data = array(
        'admissionId' => $admissionObject['id'],
        'function'    => 1
      );
      return $data;
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }

  }else{
    // 默认取最后一个
    $admissionObject = $admissionList[0];
    $admission['isGuest'] = $admissionObject['isGuest'];
    if(!$admission['isGuest']){
      $parkCardObject = ParkCard::where('cardId', '=', $admission['cardId'])->first();

      $type = $parkCardObject->cardType['type'];

      $isValid = true;
      $data    = array();
      $msg     = '';

      switch ($type) {
        case 0:
          // 月租卡
          if($admission['time'] > $parkCardObject['endDate']){
            $msg = '月租卡过期';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 6);
          }

          if($admission['time'] < $parkCardObject['beginDate']){
            $msg = '卡没有在规定时间内使用';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 7);
          }

          if($admission['amount'] <= 0){
            $msg = '发行金额不足';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 8);
          }

          break;

        case 1:
          // 储值卡
          if($parkCardObject['balance'] <= 0){
            $msg = '卡余额不足';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 9);
          }

          if($isValid){
            // 默认一秒扣2毛
            $parkCardObject['balance'] -= ($admission['time'] - $admissionObject['enterTime'])*0.2;
            $parkCardObject->save();
          }

          break;

        case 2:
          // 临时卡
          $isValid = false;
          $admission['charge'] = ($admission['time'] - $admissionObject['enterTime'])*0.2;
          break;

        case 3:
          // 月租卡
          if($admission['time'] > $parkCardObject['endDate']){
            $msg = '月租卡过期';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 6);
          }

          if($admission['time'] < $parkCardObject['beginDate']){
            $msg = '卡没有在规定时间内使用';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 7);
          }

          if($admission['amount'] <= 0){
            $msg = '发行金额不足';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 8);
          }
          break;

        case 4:
          // 次卡
          if($parkCardObject['time'] <= 0){
            $msg = '卡次数不足';
            $isValid = false;
            // 添加错误码
            array_push($admission['exceptionCode'], 10);
          }

          if($isValid){
            // 默认一秒扣2毛
            $parkCardObject['time'] -= 1;
            $parkCardObject->save();
          }

          break;

        default:

          break;
      }

      if(!$isValid){
        // TODO 通知显示器
        //return $this->retError(-1, $msg);
        $admission['status'] = 2;
      }else{
        $admission['status'] = 3;
      }
    }else{
      // 游客要给钱
      $admission['status'] = 2;
      $admission['charge'] = ($admission['time'] - $admissionObject['enterTime'])*0.2;
    }

    if($admission['status'] == 3){
      // TODO 发送开闸请求
    }else{
      // TODO 发送二次确认给前端
    }

    $admissionObject->free               = 0;
    $admissionObject->charge             = $admission['charge'];
    $admissionObject->exitImagePath      = $admission['imagePath'];
    $admissionObject->exitBoxDoorId      = $admission['boxDoorId'];
    $admissionObject->exitTime           = $admission['time'];
    $admissionObject->exitExceptionCode  = json_encode($admission['exceptionCode']);
    $admissionObject->status             = $admission['status'];

    if($ret = $admissionObject->save()){
      $data = array(
        'admissionId' => $admissionObject['id'],
        'function'    => 1
      );
      return $data;
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }
}

/* 出场二次确认 */
public function exitReconfirm(Request $request){
  if(!$request->has('admissionId')){
    $this->retError(ADMISSION_ID_IS_EMPTY_CODE, ADMISSION_ID_IS_EMPTY_WORD);
  }else{
    $admissionId = $request->input('admissionId');
    $admissionObject = Admission::find($admissionId);
  }

  if(!$request->has('free')){
    $free = 0;
  }else{
    $free = $request->input('free');
  }

  if(!$request->has('charge')){
    $charge = 0;
  }else{
    $charge = $request->input('charge');
  }

  // TODO 发送开闸请求给TCP SVR

  $admissionObject->free     = $free;
  $admissionObject->charge   = $charge;
  $admissionObject->exitTime = time();
  $admissionObject->status   = 4;

  if($ret = $admissionObject->save()){
    $data = array(
      'admissionId' => $admissionObject['id'],
      'function'    => 1
    );
    return $data;
  }else{
    return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
  }
}

/* 入场二次确认 */
public function enterReconfirm(Request $request){
  if(!$request->has('admissionId')){
    $this->retError(ADMISSION_ID_IS_EMPTY_CODE, ADMISSION_ID_IS_EMPTY_WORD);
  }else{
    $admissionId = $request->input('admissionId');
    $admissionObject = Admission::find($admissionId);
  }

  // TODO 根据配置模块确认是否需要地感确认
  if(true){
    /* 默认不需要 */
    $admissionObject->status    = 1;
    $admissionObject->enterTime = time();
  }else{
    $admissionObject->status = 0;
  }

  // TODO 发送入场消息给TCP SVR，转到前端显示

  if($ret = $admissionObject->save()){
    $data = array(
      'admissionId' => $admissionObject['id'],
      'function'    => 1
    );
    return $data;
  }else{
    return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
  }

}

/* 完成出场 */
public function finishedExit(Request $request){

}

/* 完成入场 */
public function finishedEnter(Request $request){

}

/* 月卡 */
public function mothCardHanle(){

}

/* 贵宾卡 */
public function vipCardHanle(){

}

/* 临时卡 */
public function tempCardHanle(){

}

/* 储值卡 */
public function storedCardHanle(){

}

/* 次卡 */
public function timeCardHanle(){

}

/* 获取摄像头消息 */
public function camera(){

  // 捕获摄像头数据
  $data = json_decode(file_get_contents("php://input"),true);

  // init
  $admission = array();
  $admission['carId'] = NULL;

  // 获取车牌号码
  $admission['carNum'] = $data['AlarmInfoPlate']['result']['PlateResult']['license'];
  if(!$admission['carNum']){
    return $this->retError(ADMISSION_CAR_NO_IS_EMPTY_CODE, ADMISSION_CAR_NO_IS_EMPTY_WORD);
  }else{
    // 去掉空格
    $admission['carNum'] = str_replace(' ','',$admission['carNum']);
  }

  // 获取车颜色
  $admission['carColor'] = (string)$data['AlarmInfoPlate']['result']['PlateResult']['colorType'];
  if(!$admission['carColor']){
    $admission['carColor'] = 0;
    //return $this->retError(ADMISSION_CAR_COLOR_IS_EMPTY_CODE, ADMISSION_CAR_COLOR_IS_EMPTY_WORD);
  }else{
    // TODO 颜色转换
  }

  // 获取图片地址
  $admission['imagePath'] = $data['AlarmInfoPlate']['result']['PlateResult']['imagePath'];
  if(!$admission['imagePath']){
    // return $this->retError(ADMISSION_CAR_COLOR_IS_EMPTY_CODE, ADMISSION_CAR_COLOR_IS_EMPTY_WORD);
    $admission['imagePath'] = NULL;
  }

  // 获取IP地址
  $admission['ip'] = $data['AlarmInfoPlate']['ipaddr'];
  if(!$admission['ip']){
    return $this->retError(ADMISSION_IP_IS_EMPTY_CODE, ADMISSION_IP_IS_EMPTY_WORD);
  }

  // 获取通道ID
  $admission['boxDoorId'] = Device::where('ip', '=', $admission['ip'])->where('type', '=', '0')->first()['boxDoorId'];
  if(!$admission['boxDoorId']){
    // TODO 通知前端,IP对应的通道不存在,设置出错
    return $this->retError(BOX_DOOR_ID_IS_NOT_EXIST_CODE, BOX_DOOR_ID_IS_NOT_EXIST_WORD);
  }

  // 获取对应通道的出口还是入口
  $boxDoorObject = BoxDoor::find($admission['boxDoorId']);
  $function = $boxDoorObject['function'];
  $admission['deviceId'] = $boxDoorObject['mainControlMachine'];
  if($function == 0){
    // 入场
    return $this->jinqu($admission);
  }else{
    // 出场
    return $this->chuqu($admission);
  }
}
