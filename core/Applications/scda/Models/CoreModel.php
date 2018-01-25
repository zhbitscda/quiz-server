<?php
use \GatewayWorker\Lib\Gateway;

class CoreModel {

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
	public function successResponse() {
        $ret = array("ret" => 0, "errMsg" => "");
        Gateway::sendToCurrentClient(json_encode($ret));
        Gateway::closeCurrentClient();
		
	}

    public function errorResponse($error) {
        $ret = array("ret" => $error[0], "errMsg" => $error[1]);
        Gateway::sendToCurrentClient(json_encode($ret));
        Gateway::closeCurrentClient();
	}


}
?>