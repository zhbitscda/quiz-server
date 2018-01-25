<?php

use \GatewayWorker\Lib\Gateway;
require_once BASE_DIR. "Helper/BinaryHelper.php";


// 接到来自硬件的请求，以后的处理
class HardwareIncomingController {
	private $client_id;
	private $message;
    private $cmd;
    private $device_type;
    private $device_addr;
    private $frame_seq;
    private $hardwareObject;
    private $monitorObject;


    // 处理硬件发过来的请求，主要是地感和关闸消息，未来会有卡片的消息
	public function handleRequest($client_id, $message) {
		$this->client_id = $client_id;
		$this->message = $message;

		$this->cmd = $message["cmd"];
		$this->device_type = $message["device_type"];
        $this->device_addr = trim($this->message['device_addr']);
        $this->frame_seq = trim($this->message['frame_seq']);

        $this->hardwareObject = HardwareModel::getInstance();
        $this->monitorObject = MonitorModel::getInstance();

        if($this->device_type == 0 && $this->cmd == ProtocolConstant::DEVICE_CMD_HEARTBEAT_RECV) { // 接收到心跳包
			$this->receivedHeartBeat();
		} else if($this->device_type == ProtocolConstant::DEVICE_TYPE_GATE && $this->cmd == ProtocolConstant::DEVICE_CMD_OPEN_GATE_RECV) { // 接收到已经开闸的请求，向websocket发送消息
			$this->receivedOpendDoor();
		} else if($this->device_type == ProtocolConstant::DEVICE_TYPE_VOICE_PLAYER && $this->cmd == ProtocolConstant::DEVICE_CMD_PLAY_VOICE_RECV) { // 播放语音返回，通知websocket
			$this->receivedPlayedVoice();
		} else if($this->device_type == ProtocolConstant::DEVICE_TYPE_DETECTOR && $this->cmd == ProtocolConstant::DEVICE_CMD_DETECTOR_RECV) { // 地感信息
			$this->receivedDetectorMessage();
		} else if($this->device_type == ProtocolConstant::DEVICE_TYPE_GATE && $this->cmd == ProtocolConstant::DEVICE_CMD_GATE_STATUS_RECV) {
		    // 道闸状态
            $this->sendGateStatus();
        }

	}


	// 接收到地感消息
	// 处理逻辑，1-表示正在通过，0-表示变化为没有压地感。1->0表示，车辆已经入场。调用core svr的入场接口，完成入场。同时发送消息给websocket，标明已经入场。
	private function receivedDetectorMessage() {
		//需要解析数据字段，保存中间状态，用于发送出场确认消息
		$data_len = $this->message["data_len"];
		var_dump("数据长度:" . $data_len);
		$data = $this->message["data"];
		$unpack_data = unpack('Cdetector1/Cdetector2', $data);
		
		$currentDetectorStatus1 = $unpack_data["detector1"];
		$currentDetectorStatus2 = $unpack_data["detector2"];

		$previousDetectorStatus1 = $_SESSION["detector1"];
		$previousDetectorStatus2 = $_SESSION["detector2"];
		var_dump("地感1:" . $currentDetectorStatus1);
		var_dump("地感2:" . $currentDetectorStatus2);

		if($currentDetectorStatus2 == 0 && $previousDetectorStatus2 == 1) {
            $this->sendToWebSocket(__METHOD__, ProtocolConstant::MONITOR_CMD_PASSED);
        }
		// 记录当前状态
		$_SESSION["detector1"] = $currentDetectorStatus1;
		$_SESSION["detector2"] = $currentDetectorStatus2;


		// 回应地感消息已经收到
        $this->hardwareObject->responseDetector($this->device_addr, $this->frame_seq);
	}


	// 接收到已开闸命令，处理逻辑
	// 处理逻辑：记录日志，发送消息给websocket展示（如果有）

	private function receivedOpendDoor() {
        LogHelper::info(__METHOD__, $this->message);

	}

	// 接收到播放语音返回命令，处理逻辑
	// 处理逻辑：记录日志，发送消息给websocket展示（如果有）
	private function receivedPlayedVoice() {
        $this->sendToWebSocket(__METHOD__, ProtocolConstant::MONITOR_CMD_PLAYED_VOICE);
    }

	
	// 接收到心跳包
	// 处理逻辑：记录总线控制器在线链接状态，返回心跳包响应, 向websocket发送连接状态（如果有）
	private function receivedHeartBeat() {
		// 添加缓存中设备号和客户端连接号的关系，如果有，就不更新
		if(Gateway::isUidOnline($this->device_addr) == 0) {
			Gateway::bindUid($this->client_id, $this->device_addr);
		}

		$hardwareObject = HardwareModel::getInstance();
		$ret = $hardwareObject->responseHeartBeat($this->device_addr, $this->frame_seq);

        //LogHelper::info(__METHOD__, $this->message);
    }


    private function sendToWebSocket($method, $cmd) {
        //$parkData = $this->hardwareObject->getSession($this->device_addr);
        $parkData["cmd"] = $cmd;
        var_dump($parkData);
        //$this->monitorObject->sendessage($parkData);
        LogHelper::info($method, $this->message);
    }

    private function sendGateStatus() {
        $status = $this->message["data"];
        $cmd = ProtocolConstant::MONITOR_CMD_GATE_RUN;

        if($status == ProtocolConstant::DEVICE_CMD_GATE_STATUS_OPENED) {
            $cmd = ProtocolConstant::MONITOR_CMD_GATE_OPENED;
        } else if($status == ProtocolConstant::DEVICE_CMD_GATE_STATUS_CLOSED) {
            $cmd = ProtocolConstant::MONITOR_CMD_GATE_CLOSED;
        } else if($status == ProtocolConstant::DEVICE_CMD_GATE_STATUS_LOST) {
            $cmd = ProtocolConstant::MONITOR_CMD_GATE_LOST;
        }else if($status == ProtocolConstant::DEVICE_CMD_GATE_STATUS_CONNECT) {
            $cmd = ProtocolConstant::MONITOR_CMD_GATE_CONNECT;
        }

        $this->sendToWebSocket(__METHOD__, $cmd);

        $this->hardwareObject->responseGate($this->device_addr, $this->frame_seq);


    }

}
?>