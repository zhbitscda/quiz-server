<?php

use \GatewayWorker\Lib\Gateway;
require_once BASE_DIR. "Models/MonitorModel.php";


// 接到来自websocket的请求
class MonitorIncomingController {
	private $client_id;
	private $message;

	// 处理websocket的请求，目前只有心跳包
	public function handleRequest($client_id, $message) {
		$this->client_id = $client_id;
        var_dump($message);
		$this->message = $message;

		$command = $this->message["cmd"];

        switch($command) {
            case ProtocolConstant::MONITOR_CMD_HEART_BEAT: // 心跳
                $this->receivedHeartBeat();
                break;
        }

		
		

	}


	// 接收到心跳包
	// 处理逻辑：记录websocket在线链接状态，返回心跳包响应,
	private function receivedHeartBeat() {
		// 添加缓存中设备号和客户端连接号的关系，如果有，就不更新
        $ip_addr = $this->message["ipAddr"];//LogHelper::getIp();//$_SERVER['REMOTE_ADDR'];
        var_dump($ip_addr);

        // 使用ip地址作为uid
		if(Gateway::isUidOnline($ip_addr) == 0) {
			Gateway::bindUid($this->client_id, $ip_addr);
		}

        $monitorObj = MonitorModel::getInstance();
        $monitorObj->responseHeartBeat();
	}


}
?>