<?php

namespace App\Models;

use App\Http\Controllers\OAuthClient;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Operator;
use App\Models\Box;
use OAuth2;

class Login extends Model
{
    public function login($userName, $password, $ip)
    {
      // IP地址判断
      $boxId = null;

      if( Box::where('ip', '=', $ip)->count() == 0){
        return array( "ret" => OPERATOR_IP_ERROR_CODE, "errMsg" => OPERATOR_IP_ERROR_WORD);
      }else{
        $boxObject = Box::where('ip', '=', $ip)->get()[0];
        $boxId = $boxObject['id'];
      }

      //$boxId = 21;

      if(!$userName){
        //返回错误
        //return $this->retError(OPERATOR_USERNAME_IS_EMPTY_CODE, OPERATOR_USERNAME_IS_EMPTY_WORD);
        return array( "ret" => OPERATOR_USERNAME_IS_EMPTY_CODE, "errMsg" => OPERATOR_USERNAME_IS_EMPTY_WORD);
      }

      if(!$password){
        //返回错误
        //return $this->retError(OPERATOR_PASSWORD_IS_EMPTY_CODE, OPERATOR_PASSWORD_IS_EMPTY_WORD);
        return array( "ret" => OPERATOR_PASSWORD_IS_EMPTY_CODE, "errMsg" => OPERATOR_PASSWORD_IS_EMPTY_WORD);
      }

      $operatorObject = Operator::where('name', $userName)->where('password', $password)->first();

      if(!$operatorObject)
      {
        //返回错误
        return array( "ret" => OPERATOR_USERNAME_OR_PASSWORD_IS_ERROR_CODE, "errMsg" => OPERATOR_USERNAME_OR_PASSWORD_IS_ERROR_WORD);
      }

      $data = array(
        "boxId"        => $boxId,
        "operatorId"   => $operatorObject['id'],
        "operatorName" => $operatorObject['name'],
        "roleId"       => $operatorObject['roleId'],
        "time"         => time()
      );

      //返回操作信息
      return array( "ret" => 0, "data" => $data);
    }

    public function verifyToken() {
	    $outhServer = OAuthClient::get_outh_server();
        $response = new OAuth2\Response();
	    $ret = $outhServer->verifyResourceRequest(OAuth2\Request::createFromGlobals(), $response);

        return $ret;
    }

}
