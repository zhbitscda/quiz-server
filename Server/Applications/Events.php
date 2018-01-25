<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
require_once 'Controllers/CoreIncomingController.php';
require_once 'Controllers/HardwareIncomingController.php';
require_once 'Controllers/MonitorIncomingController.php';

require_once 'Config/ProtocolConstant.php';


/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id) {
        // // 向当前client_id发送数据 
        // Gateway::sendToClient($client_id, "Hello $client_id");
        // // 向所有人发送
        // Gateway::sendToAll("$client_id login");
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message) {
        //根据type 转发协议做不同的处理
        // type=core 是从中央处理器过来的请求
        // type=monitor 是从监控页面过来的websocket请求
        // type=hardware 是从硬件过来的请求
        var_dump($message);
       $type = ProtocolConstant::PROTOCOL_TYPE_MONITOR;
       if(!isset($message["type"])) { // websocket
           $message = json_decode($message, true);
           $message["type"] = ProtocolConstant::PROTOCOL_TYPE_MONITOR;
       } else {
           $type = $message["type"];
       }
        

        if($type == ProtocolConstant::PROTOCOL_TYPE_HARDWARE) {
            $hardwareController = new HardwareIncomingController();
            $hardwareController->handleRequest($client_id, $message);
        } else if($type == ProtocolConstant::PROTOCOL_TYPE_MONITOR) {
            $monitorController = new MonitorIncomingController();
            $monitorController->handleRequest($client_id, $message);
        } else if($type == ProtocolConstant::PROTOCOL_TYPE_CORE) {
          $coreController = new CoreIncomingController();
          $coreController->handleRequest($message);

        }
        // if($type == "hardware") {
        //     if($cmd == 100) {
        //       $buffer = pack('CnCCCCn', 0xFE, 1, 0, intval($device_addr), $frame_seq, 101, 0);

        //       $crc =  self::crc16($buffer);
        //       $buffer = $buffer . bin2hex($crc);
        //       self::hex_dump($buffer);
        //       Gateway::sendToCurrentClient($buffer);


        //     }
        // } 
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id) {
       // 向所有人发送 
       GateWay::sendToAll("$client_id logout");
   }


 private static function hexToStr($hex)//十六进制转字符串
{   
$string=""; 
for($i=0;$i<strlen($hex)-1;$i+=2)
$string.=chr(hexdec($hex[$i].$hex[$i+1]));
return  $string;
}

private static function hex_dump($data, $newline="n") 
{ 
  static $from = ''; 
  static $to = ''; 
  
  static $width = 16; # number of bytes per line 
  
  static $pad = '.'; # padding for non-visible characters 
  
  if ($from==='') 
  { 
    for ($i=0; $i<=0xFF; $i++) 
    { 
      $from .= chr($i); 
      $to .= ($i >= 0x20 && $i <= 0x7E) ? chr($i) : $pad; 
    } 
  } 
  
  $hex = str_split(bin2hex($data), $width*2); 
  $chars = str_split(strtr($data, $from, $to), $width); 
  
  $offset = 0; 
  foreach ($hex as $i => $line) 
  { 
    echo sprintf('%6X',$offset).' : '.implode(' ', str_split($line,2)) . ' [' . $chars[$i] . ']' . $newline; 
    $offset += $width; 
  } 
} 
}

