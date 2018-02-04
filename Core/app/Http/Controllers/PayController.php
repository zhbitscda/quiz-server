<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ParkCardType;
use App\Models\PayConfigure;
use Log;

class PayController extends Controller
{
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

  /* 获取单个 */
  public function getInfo($id)
  {
    // 查找该ID的对象是否存在
    if(!$payConfigureObject = PayConfigure::find($id)){
      return $this->retError(PAYCONFIGURE_ID_IS_NOT_EXIST_CODE, PAYCONFIGURE_ID_IS_NOT_EXIST_WORD);
    }else{
      $cardTypeId = $payConfigureObject['cardTypeId'];
      $parkCardTypeObject = ParkCardType::find($cardTypeId);
      $cardSubType = $parkCardTypeObject['name'];
      switch ($parkCardTypeObject['type']) {
        case 0:
          $cardType = "月租卡";
          break;

        case 1:
          $cardType = "储值卡";
          break;

        case 2:
          $cardType = "临时卡";
          break;

        case 3:
          $cardType = "贵宾卡";
          break;

        case 4:
          $cardType = "次卡";
          break;

        default:
          $cardType = null;
          break;
      }
      // 组装数据
      $data = array(
        'payconfigsId' => $payConfigureObject['id'],
        'name'         => $payConfigureObject['name'],
        'payRule'      => $payConfigureObject['payRule'],
        'cardTypeId'   => $payConfigureObject['cardTypeId'],
        'cardType'     => $cardType,
        'cardSubType'  => $cardSubType,
        'created_at'   => date("Y-m-d H:i:s",strtotime($payConfigureObject['created_at'])),
        'updated_at'   => date("Y-m-d H:i:s",strtotime($payConfigureObject['updated_at']))
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取列表 */
  public function getList($page, $perPage)
  {
    if($page){
      $payConfigureList = PayConfigure::paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => PayConfigure::all()->count(),
        'perPage'     => $payConfigureList->perPage(),
        'currentPage' => $payConfigureList->currentPage(),
        'lastPage'    => $payConfigureList->lastPage(),
        'nextPageUrl' => $payConfigureList->nextPageUrl() == null ? null : $payConfigureList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $payConfigureList->previousPageUrl() == null ? null : $payConfigureList->previousPageUrl() . $perPagePan,
      );
    }else{
      $payConfigureList = PayConfigure::all();
    }
    $data = array();
    foreach ($payConfigureList as $payConfigureObject) {
      // 组装数据
      $cardTypeId = $payConfigureObject['cardTypeId'];
      $parkCardTypeObject = ParkCardType::find($cardTypeId);
      $cardSubType = $parkCardTypeObject['name'];
      switch ($parkCardTypeObject['type']) {
        case 0:
          $cardType = "月租卡";
          break;

        case 1:
          $cardType = "储值卡";
          break;

        case 2:
          $cardType = "临时卡";
          break;

        case 3:
          $cardType = "贵宾卡";
          break;

        case 4:
          $cardType = "次卡";
          break;

        default:
          $cardType = null;
          break;
      }
      // 组装数据
      $data[] = array(
        'payconfigId'  => $payConfigureObject['id'],
        'name'         => $payConfigureObject['name'],
        'payRule'      => json_decode($payConfigureObject['payRule']),
        'payRuleId'    => $payConfigureObject['payRuleId'],
        'cardTypeId'   => $payConfigureObject['cardTypeId'],
        'cardType'     => $cardType,
        'cardSubType'  => $cardSubType,
        'created_at'   => date("Y-m-d H:i:s",strtotime($payConfigureObject['created_at'])),
        'updated_at'   => date("Y-m-d H:i:s",strtotime($payConfigureObject['updated_at']))
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
      return $this->retError(PAYCONFIGURE_NAME_IS_EMPTY_CODE, PAYCONFIGURE_NAME_IS_EMPTY_WORD);
    }else if(PayConfigure::where('name', $request->input('name'))->count() != 0){
      return $this->retError(PAYCONFIGURE_NAME_IS_EXIST_CODE, PAYCONFIGURE_NAME_IS_EXIST_WORD);
    }else{
      $name = $request->input('name');
    }

    if(!$request->has('payRuleId')){
      //返回错误
      return $this->retError(PAYRULEID_IS_EMPTY_CODE, PAYRULEID_IS_EMPTY_WORD);
    }else if(!preg_match("/^([0-4])$/",$request->input("payRuleId"))){
      return $this->retError(PAYRULEID_IS_ERROR_CODE, PAYRULEID_IS_ERROR_WORD);
    }else{
      $payRuleId = $request->input('payRuleId');
    }

    if(!$request->has('cardTypeId')){
      //返回错误
      return $this->retError(PARK_CARD_TYPE_ID_IS_EMPTY_CODE, PARK_CARD_TYPE_ID_IS_EMPTY_WORD);
    }else if(!ParkCardType::find($request->input('cardTypeId'))){
      return $this->retError(PARK_CARD_TYPE_ID_IS_NOT_EXIST_CODE, PARK_CARD_TYPE_ID_IS_NOT_EXIST_WORD);
    }else{
      $cardTypeId = $request->input('cardTypeId');
    }

    // 录入操作者表
    $payConfigureObject = new PayConfigure;
    $payConfigureObject->name       = $name;
    $payConfigureObject->payRuleId  = $payRuleId;
    $payConfigureObject->cardTypeId = $cardTypeId;

    if($ret = $payConfigureObject->save()){
      $data = array(
        'payconfigId' => $payConfigureObject['id']
      );
      return $this->retSuccess($data);
    }else{
      return $this->retError(ERR_DB_EXEC_CODE, ERR_DB_EXEC_WORD);
    }
  }

  //------------------- UPDATE ---------------------------

  /* 添加岗亭 */
  public function update(Request $request)
  {
    //TODO:accessToken

    if(!$request->input('payconfigId')){
      return $this->retError(PAYCONFIGURE_ID_IS_NOT_EXIST_CODE, PAYCONFIGURE_ID_IS_NOT_EXIST_WORD);
    }else{
      $payconfigId = $request->input('payconfigId');
      $payConfigureObject = PayConfigure::find($payconfigId);
    }

    if(!$request->has('name')){

    }else if((PayConfigure::where('name', $request->input('name'))->count() != 0) && $payConfigureObject['name'] != $request->input('name')){
      return $this->retError(PAYCONFIGURE_NAME_IS_EXIST_CODE, PAYCONFIGURE_NAME_IS_EXIST_WORD);
    }else{
      $name = $request->input('name');
      $payConfigureObject->name       = $name;
    }

    if(!$request->has('payRule')){

    }else{
      $payRule = $request->input('payRule');
      $payConfigureObject->payRule = json_encode($payRule);
    }

    if(!$request->has('payRuleId')){

    }else if(!preg_match("/^([0-2])$/",$request->input("payRuleId"))){
      return $this->retError(PAYRULEID_IS_ERROR_CODE, PAYRULEID_IS_ERROR_WORD);
    }else{
      $payRuleId = $request->input('payRuleId');
      $payConfigureObject->payRuleId  = $payRuleId;
    }

    if(!$request->has('cardTypeId')){

    }else if(!ParkCardType::find($request->input('cardTypeId'))){
      return $this->retError(PARK_CARD_TYPE_ID_IS_NOT_EXIST_CODE, PARK_CARD_TYPE_ID_IS_NOT_EXIST_WORD);
    }else{
      $cardTypeId = $request->input('cardTypeId');
      $payConfigureObject->cardTypeId = $cardTypeId;
    }

    if($ret = $payConfigureObject->save()){
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
    if(!$request->has('payconfigId')){
      //返回错误
      return $this->retError(PAYCONFIGURE_ID_IS_EMPTY_CODE, PAYCONFIGURE_ID_IS_EMPTY_WORD);
    }else if(!$payConfigureObject = PayConfigure::find($request->input('payconfigId'))){
      return $this->retError(PAYCONFIGURE_ID_IS_NOT_EXIST_CODE, PAYCONFIGURE_ID_IS_NOT_EXIST_WORD);
    }else{
      $payconfigId = $request->input('payconfigId');
      $payConfigureObject = PayConfigure::find($payconfigId);
    }

    $payConfigureObject->delete();

    return $this->retSuccess();
  }

  //------------------- payData ---------------------------

  public function payData(Request $request)
  {
    $ruleType = array(
      array(
        'value' => 0,
        'name'  => '按小时收费',
      ),
      array(
        'value' => 1,
        'name'  => '按单位时间收费(24H)',
      ),
      array(
        'value' => 2,
        'name'  => '按次收费',
      )
    );

    // 组合数据
    $data = array(
      'ruleType' => $ruleType,
    );

    return $this->retSuccess($data);
  }

}
