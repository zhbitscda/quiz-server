<?php

use \GatewayWorker\Lib\Gateway;

class MonitorModel {

    private static $_instance;

    //private标记的构造方法
	private function __construct(){
		echo 'This is a Constructed method;';
	}
 
	//创建__clone方法防止对象被复制克隆
	public function __clone(){
		trigger_error('Clone is not allow!',E_USER_ERROR);
	}
 
	//单例方法,用于访问实例的公共的静态方法
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	//向web前端发起入场消息
	function sendMessage($message) {
        $ip_addr = $message["ipAddr"];
        // 使用ip地址作为uid
        if(Gateway::isUidOnline($ip_addr) == 0) {
            // 记录异常
            return -1;
        }

        Gateway::sendToUid($ip_addr, json_encode($message));

        return 0;
        // 记录日志
	}
	
	// 回应心跳包
	public function responseHeartBeat() {
		$ret = array("ret" => 0, "errMsg" => "");
		
		Gateway::sendToCurrentClient(json_encode($ret));
		return 0;
	}

}
?>