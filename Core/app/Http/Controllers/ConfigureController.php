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
use App\Models\Configure;

class ConfigureController extends Controller
{

//------------------- READ ---------------------------

  /* 读取 */
  public function read(Request $request)
  {
    if($request->has('name')){
      /* 带参数时,获取单个数据 */
      // 获取参数
      $id = $request->get("name");
      return $this->getInfo($id);
    }else if($request->has('boxId')){
      $boxId = $request->get("boxId");
      return $this->getInfoByBoxId($boxId);
    }else{
      /* 带参数时,获取列表 */
      $page    = $request->input('page');
      $perPage = $request->input('perPage');
      return $this->getList($page, $perPage);
    }
  }

  /* 获取单个 */
  public function getInfo($name)
  {
    // 查找该ID的对象是否存在
    if(!$configureObject = Configure::where('name', '=', $name)->first()){
      return $this->retError(CONFIGURE_NAME_IS_NOT_EXIT_CODE, CONFIGURE_NAME_IS_NOT_EXIT_WORD);
    }else{
      if($configureObject['value'][0] == '['){
        $configureObject['value'] = json_decode($configureObject['value']);
      }
      // 组装数据
      $data = array(
        'configureId'           => $configureObject['id'],
        'name'                  => $configureObject['name'],
        'value'                 => $configureObject['value'],
        'type'                  => $configureObject['type'],
        'boxId'                 => $configureObject['boxId'],
        'created_at'            => date("Y-m-d H:i:s",strtotime($configureObject['created_at'])),
        'updated_at'            => date("Y-m-d H:i:s",strtotime($configureObject['updated_at']))
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取 */
  public function getInfoByBoxId($boxId)
  {
    // 查找该ID的对象是否存在
    $configureList = Configure::where('boxId', '=', $boxId)->get();
    if(COUNT($configureList) == 0){
      return $this->retError(BOX_ID_IS_NOT_EXIST_CODE, BOX_ID_IS_NOT_EXIST_WORD);
    }else{
      foreach ($configureList as $configureObject) {
        if($configureObject['value'][0] == '['){
          $configureObject['value'] = json_decode($configureObject['value']);
        }
        // 组装数据
        $data[] = array(
          'configureId'           => $configureObject['id'],
          'name'                  => $configureObject['name'],
          'value'                 => $configureObject['value'],
          'type'                  => $configureObject['type'],
          'boxId'                 => $configureObject['boxId'],
          'created_at'            => date("Y-m-d H:i:s",strtotime($configureObject['created_at'])),
          'updated_at'            => date("Y-m-d H:i:s",strtotime($configureObject['updated_at']))
        );
      }
      return $this->retSuccess($data);
    }
  }

  /* 获取列表 */
  public function getList($page, $perPage)
  {
    $configureList = Configure::all();
    $data = array();
    foreach ($configureList as $configureObject) {
      if($configureObject['value'][0] == '['){
        $configureObject['value'] = json_decode($configureObject['value']);
      }
      // 组装数据
      $data[] = array(
        'configureId'           => $configureObject['id'],
        'name'                  => $configureObject['name'],
        'value'                 => $configureObject['value'],
        'type'                  => $configureObject['type'],
        'boxId'                 => $configureObject['boxId'],
        'created_at'            => date("Y-m-d H:i:s",strtotime($configureObject['created_at'])),
        'updated_at'            => date("Y-m-d H:i:s",strtotime($configureObject['updated_at']))
      );
    }
    return $this->retSuccess($data,$page);
  }

//------------------- UPDATE ---------------------------

  /* 更新 */
  public function updatePark(Request $request)
  {
    //TODO:accessToken

    if(!$request->has('data')){
      return $this->retError(CONFIGURE_DATA_IS_EMPTY_CODE, CONFIGURE_DATA_IS_EMPTY_WORD);
    }else{
      $data = $request->input('data');
      foreach ($data as $eachData) {
        /* name */
        if(!$eachData['name']){
          return $this->retError(CONFIGURE_ID_IS_EMPTY_CODE, CONFIGURE_ID_IS_EMPTY_WORD);
        }else if(!$configureObject = Configure::where('name', '=', $eachData['name'])->first()){
          return $this->retError(CONFIGURE_ID_IS_NOT_EXIT_CODE, CONFIGURE_ID_IS_NOT_EXIT_WORD);
        }else{
          $name = $eachData['name'];
        }

        if(!isset($eachData['value'])){
          return $this->retError(CONFIGURE_VALUE_IS_EMPTY_CODE, CONFIGURE_VALUE_IS_EMPTY_WORD);
        }else{
          $value = $eachData['value'];
        }

        $flag = false;
        switch ($name) {
          case 'REST_LARGE_PARK_NUMBER':
            if(!preg_match("/^0|[1-9][0-9]{0,3}|99999$/",$value)){
              $flag = true;
            }
            break;

          case 'REST_SMAILL_PARK_NUMBER':
            if(!preg_match("/^0|[1-9][0-9]{0,3}|99999$/",$value)){
              $flag = true;
            }
            break;

          case 'IS_EXIST_SMALL_PARK':
            if(!preg_match("/^([0-1])$/",$value)){
              $flag = true;
            }
            break;

          case 'VOLUME_DAY_BEGINTIME':
            if(!preg_match("/^(?:[01]\d|2[0-3])(?::[0-5]\d)$/",$value)){
              $flag = true;
            }
            break;

          case 'VOLUME_DAY_LEVEL':
            if(!preg_match("/^([0-8])$/",$value)){
              $flag = true;
            }
            break;

          case 'VOLUME_NIGHT_BEGINTIME':
            if(!preg_match("/^(?:[01]\d|2[0-3])(?::[0-5]\d)$/",$value)){
              $flag = true;
            }
            break;

          case 'VOLUME_NIGHT_LEVEL':
            if(!preg_match("/^([0-8])$/",$value)){
              $flag = true;
            }
            break;

          case 'MONITOR_DIALOG_TIME':
            if(!preg_match("/^0|[1-9][0-9]{0,3}|999$/",$value)){
              $flag = true;
            }
            break;

          case 'MONITOR_DIALOG_TYPE':
            foreach ($value as $eachType) {
              if(!preg_match("/^([0-5])$/",$eachType)){
                $flag = true;
                break;
              }
            }
            $value = json_encode($value);
            break;

          case 'IS_HAS_WATERMARK':
            if(!preg_match("/^([0-1])$/",$value)){
              $flag = true;
            }
            break;

          case 'PICTURE_SAVE_DAYS':
            if(!preg_match("/^0|[1-9][0-9]{0,3}|9999$/",$value)){
              $flag = true;
            }
            break;

          case 'IS_BARRIER_GATE':
            if(!preg_match("/^([0-1])$/",$value)){
              $flag = true;
            }
            break;

          case 'OFFLINE_TEMP_CAR_ENTER_SETTING':
            if(!preg_match("/^([0-1])$/",$value)){
              $flag = true;
            }
            break;

          case 'OFFLINE_TEMP_CAR_EXIT_SETTING':
            if(!preg_match("/^([0-2])$/",$value)){
              $flag = true;
            }
            break;

          case 'FUll_SETTING_TYPE':
            foreach ($value as $eachType) {
              if(!preg_match("/^([0-4])$/",$eachType)){
                $flag = true;
                break;
              }
            }
            $value = json_encode($value);
            break;

          case 'COMMON_CAR_LOCATION_NAME':
            $allCarLocationName = 'ALL_CAR_LOCATION_NAME';
            $configureList = (array)json_decode(Configure::where('name', '=', $allCarLocationName)->first()['value']);
            foreach ($value as $eachNewValue) {
              $flagExit = false;
              foreach ($configureList as $eachLoc) {
                if($eachNewValue == $eachLoc){
                  $flagExit = true;
                }
              }
              if(!$flagExit){
                $flag = true;
                break;
              }
            }
            $value = json_encode($value);
            break;

          case 'CAR_NUMBER_FAULT_TOLERANCE_BIT':
            if(!preg_match("/^([0-2])$/",$value)){
              $flag = true;
            }
            break;

          case 'SAME_BOX_DOOR_SAME_CAR_NUMBER_FILTER_TIME':
            if(!preg_match("/^0|[1-9][0-9]{0,3}|9999$/",$value)){
              $flag = true;
            }
            break;

          case 'DIFFERENt_BOX_DOOR_SAME_CAR_NUMBER_FILTER_TIME':
            if(!preg_match("/^0|[1-9][0-9]{0,3}|9999$/",$value)){
              $flag = true;
            }
            break;


          default:
            $flag = true;
            break;
        }

        if($flag){
          return $this->retError(CONFIGURE_VALUE_IS_ERROR_CODE, CONFIGURE_VALUE_IS_ERROR_WORD);
        }else{
          $configureObject->value = $value;
        }

        if($configureObject->save()){

        }else{
          return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
        }
      }
      return $this->retSuccess();
    }
  }

  /* 更新 */
  public function updateBox(Request $request)
  {
    //TODO:accessToken

    $isAll = false;

    if(!$request->has('data')){
      return $this->retError(CONFIGURE_DATA_IS_EMPTY_CODE, CONFIGURE_DATA_IS_EMPTY_WORD);
    }else{
      $data = $request->input('data');
      foreach ($data as $eachData) {

        /* boxId */
        if(!array_key_exists('boxId', $eachData) || !$eachData['boxId']){
          $boxList = Box::all();
        }else{
          $boxList[0]['id'] = $eachData['boxId'];
        }

        foreach ($boxList as $eachBox) {
          $boxId = $eachBox['id'];

          /* name */
          if(!$eachData['name']){
            return $this->retError(CONFIGURE_ID_IS_EMPTY_CODE, CONFIGURE_ID_IS_EMPTY_WORD);
          }else if(!$configureObject = Configure::where('name', '=', $eachData['name'])->where('boxId', '=', $boxId)->first()){
            return $this->retError(CONFIGURE_ID_IS_NOT_EXIT_CODE, CONFIGURE_ID_IS_NOT_EXIT_WORD);
          }else{
            $name = $eachData['name'];
          }

          /* value */
          if(!isset($eachData['value'])){
            return $this->retError(CONFIGURE_VALUE_IS_EMPTY_CODE, CONFIGURE_VALUE_IS_EMPTY_WORD);
          }else{
            $value = $eachData['value'];
          }

          $flag = false;
          switch ($name) {
            case 'HAS_LED_SCREEN':
              if(!preg_match("/^([0-1])$/",$value)){
                $flag = true;
              }
              break;

            case 'IS_DISPLAY_REST_NUMBER':
                if(!preg_match("/^([0-1])$/",$value)){
                  $flag = true;
                }
                break;

            case 'IS_ENTER_NO_PEOPLE':
                if(!preg_match("/^([0-1])$/",$value)){
                  $flag = true;
                }
                break;

            case 'IS_ALLOW_TEMP_CAR_IN_OUT':
                if(!preg_match("/^([0-1])$/",$value)){
                  $flag = true;
                }
                break;

            case 'ENTER_CONFIRM_OPEN_TYPE':
                foreach ($value as $eachType) {
                  if(!preg_match("/^([0-4])$/",$eachType)){
                    $flag = true;
                    break;
                  }
                }
                $value = json_encode($value);
                break;

            case 'EXIT_CONFIRM_OPEN_TYPE':
                foreach ($value as $eachType) {
                  if(!preg_match("/^([0-4])$/",$eachType)){
                    $flag = true;
                    break;
                  }
                }
                $value = json_encode($value);
                break;

            default:
              $flag = true;
              break;
          }
          if($flag){
            return $this->retError(CONFIGURE_VALUE_IS_ERROR_CODE, CONFIGURE_VALUE_IS_ERROR_WORD);
          }else{
            $configureObject->value = $value;
          }

          if($configureObject->save()){

          }else{
            return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
          }
        }
      }
      return $this->retSuccess();
    }
  }

}
