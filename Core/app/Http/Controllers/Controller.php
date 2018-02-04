<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Log;

class Controller extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set("Asia/Shanghai");
    }

    /**
     * error response.
     *
     * @param  return code  $retCode
     * @param  return message  $errMsg
     * @return response
     */
    public function retError($retCode=-1, $errMsg="error"){
    	$response = array(
    		'ret'    => $retCode,
    		'errMsg' => $errMsg
    	);
    	//return response()->json($response);
        return response()->json($response);
    }

    /**
     * success response.
     *
     * @param  return code  $retCode
     * @param  return message  $errMsg
     * @return response
     */
    public function retSuccess($data="", $page=null, $retCode=0, $errMsg=""){
      if($page == null){
        $response = array(
      		'ret'    => $retCode,
      		'data'   => $data,
      		'errMsg' => $errMsg
      	);
      }else{
        $response = array(
      		'ret'         => $retCode,
          'total'       => (int)$page['total'],
          'perPage'     => (int)$page['perPage'],
          'currentPage' => (int)$page['currentPage'],
          'lastPage'    => (int)$page['lastPage'],
          'nextPageUrl' => $page['nextPageUrl'],
          'prevPageUrl' => $page['prevPageUrl'],
      		'data'        => $data,
      		'errMsg'      => $errMsg
      	);
      }
      return response()->json($response);
    }

    /**
     * TCP Request
     *
     * @param  return code  $retCode
     * @param  return message  $errMsg
     * @return response
     */
    public function sendTcpSvr($msg){
      //echo "请求数据：$msg<br>";
      $this->logger("请求数据：$msg");
      error_reporting(E_ALL);
      //端口111
      $service_port = 8282;
      //本地
      $address = '127.0.0.1';
      //$address = '172.16.192.232';
      //$address = '127.0.0.1';
      //创建 TCP/IP socket
      $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
      //var_dump($socket);
      if ($socket < 0) {
              //echo "socket创建失败原因: " . socket_strerror($socket) . "\n";
              $this->logger("socket创建失败原因: " . socket_strerror($socket));
      } else {
              //echo "OK，HE HE.\n";
      }
      $result = socket_connect($socket, $address, $service_port);

      if ($result < 0) {
              //echo "SOCKET连接失败原因: ($result) " . socket_strerror($result) . "\n";
              $this->logger("SOCKET连接失败原因: ($result) " . socket_strerror($result));
      } else {
              //echo "OK.\n";
      }

      socket_write($socket, $msg, strlen($msg));

      //echo "返回：\n";
      $str = "";
      while ($out = socket_read($socket, 2048)) {
              //echo $out;
              $str .= $out;
      }


      //echo "\n";
      //echo "关闭连接\n";
      socket_close($socket);
      return json_decode($str, true);

    }

    /**
     * 入场请求
     *
     * @param  return code  $retCode
     * @param  return message  $errMsg
     * @return response
     */
    public function sendTcpSvrInRequest($deviceId, $ipAddr, $ledIpAddr, $voiceMessage, $ledMessage, $admissionId){
      $msg = array(
        'cmd'          => 5,
        'deviceId'     => $deviceId,
        'ipAddr'       => $ipAddr,
        'ledIpAddr'    => $ledIpAddr,
        'voiceMessage' => $voiceMessage,
        'ledMessage'   => $ledMessage,
        'admissionId'  => $admissionId
      );
      $msg = json_encode($msg) . "\n";
      return $this->sendTcpSvr($msg);
    }

    /**
     * 出场请求
     *
     * @param  return code  $retCode
     * @param  return message  $errMsg
     * @return response
     */
    public function sendTcpSvrOutRequest($deviceId, $ipAddr, $ledIpAddr, $voiceMessage, $ledMessage, $admissionId){
      $msg = array(
        'cmd'          => 7,
        'deviceId'     => $deviceId,
        'ipAddr'       => $ipAddr,
        'ledIpAddr'    => $ledIpAddr,
        'voiceMessage' => $voiceMessage,
        'ledMessage'   => $ledMessage,
        'admissionId'  => $admissionId
      );
      $msg = json_encode($msg) . "\n";
      return $this->sendTcpSvr($msg);
    }

    /**
     * 入场二次确认请求
     *
     * @param  return code  $retCode
     * @param  return message  $errMsg
     * @return response
     */
    public function sendTcpSvrInSecondConfirmRequest($ipAddr, $admissionId, $event){
      $msg = array(
        'cmd'         => 4,
        'ipAddr'      => $ipAddr,
        'admissionId' => $admissionId,
        'event'       => $event
      );
      $msg = json_encode($msg) . "\n";
      return $this->sendTcpSvr($msg);
    }

    /**
     * 出场二次确认请求
     *
     * @param  return code  $retCode
     * @param  return message  $errMsg
     * @return response
     */
    public function sendTcpSvrOutSecondConfirmRequest($ipAddr, $admissionId, $event){
      $msg = array(
        'cmd'         => 6,
        'ipAddr'      => $ipAddr,
        'admissionId' => $admissionId,
        'event'       => $event
      );
      $msg = json_encode($msg) . "\n";
      return $this->sendTcpSvr($msg);
    }

    /**
     * 播放语音请求
     *
     * @param  return code  $retCode
     * @param  return message  $errMsg
     * @return response
     */
    public function sendTcpSvrVoiceRequest($deviceId, $content){
      $msg = array(
        'cmd'      => 2,
        'deviceId' => $deviceId,
        'content'  => $content
      );
      $msg = json_encode($msg) . "\n";
      return $this->sendTcpSvr($msg);
    }

    /**
     * 播放LED请求
     *
     * @param  return code  $retCode
     * @param  return message  $errMsg
     * @return response
     */
    public function sendTcpSvrLedRequest($ledIpAddr, $content){
      $msg = array(
        'cmd'       => 3,
        'ledIpAddr' => $ledIpAddr,
        'content'   => $content
      );
      $msg = json_encode($msg) . "\n";
      return $this->sendTcpSvr($msg);
    }

    /**
     * 开闸请求
     *
     * @param  return code  $retCode
     * @param  return message  $errMsg
     * @return response
     */
    public function sendTcpSvrOpenGateRequest($deviceId){
      $msg = array(
        'cmd'      => 1,
        'deviceId' => $deviceId
      );
      $msg = json_encode($msg) . "\n";
      return $this->sendTcpSvr($msg);
    }

    public function logger($str=""){
      Log::info($str);
		}

}
