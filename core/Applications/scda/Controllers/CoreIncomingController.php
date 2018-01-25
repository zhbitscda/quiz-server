<?php

require_once BASE_DIR . "Models/HardwareModel.php";
require_once BASE_DIR . "Models/CoreModel.php";


// 接到来自中央处理器的请求，处理逻辑
class CoreIncomingController {

	// 开闸请求
	private $message;
    private $method;
    private $device_addr;
    private $ip_addr;
    private $admission_id;
    private $content;
    private $cmd;

    private function operateHardware() {

        $hardwareObject = HardwareModel::getInstance();
        $ret = 0;

        switch ($this->cmd) {
            case ProtocolConstant::CORE_CMD_OPEN_GATE: //开闸请求
                $ret = $hardwareObject->sendOpenGate($this->device_addr);
                break;
            case ProtocolConstant::CORE_CMD_PLAY_VOICE: //播放语音请求
                $ret = $hardwareObject->sendPlayVoice($this->device_addr, $this->content);
                break;
            case ProtocolConstant::CORE_CMD_SHOW_LED: //显示字幕请求
                $led_ip_addr = $this->message["ledIpAddr"];
                $msg = iconv('utf-8', 'gbk', $this->content);
                $ret = $hardwareObject->showLEDText($led_ip_addr, $msg);
                break;
        }

        $coreObject = CoreModel::getInstance();
        if($ret != 0)  {

            $coreObject->errorResponse(ErrorCode::$HardwareConnectionNotFound);
            LogHelper::err(ErrorCode::$HardwareConnectionNotFound, $this->method, $this->message);
            return;
        }

        $coreObject->successResponse();
        LogHelper::info($this->method, $this->message);
    }
	private function openGate() {
	    $this->method = __METHOD__;
        $this->operateHardware();
    }


	// 播放语音
	private function playVoice() {
        $this->method = __METHOD__;
        $this->operateHardware();
    }

	// 显示LED 欢迎消息
	private function showLED() {
        $this->method = __METHOD__;
        $this->operateHardware();
    }


    private function sendToWebSocket() {
        // 发给websocket消息

        $coreObject = CoreModel::getInstance();
        $monitorObj = MonitorModel::getInstance();

        if($this->cmd == ProtocolConstant::CORE_CMD_ENTER_PARK) {
            $this->message["cmd"] = ProtocolConstant::MONITOR_CMD_ENTER_MSG;
        } else if($this->cmd == ProtocolConstant::CORE_CMD_ENTER_CONFIRM) {
            $this->message["cmd"] = ProtocolConstant::MONITOR_CMD_ENTERED;
        } else if($this->cmd == ProtocolConstant::CORE_CMD_LEAVE_PARK) {
            $this->message["cmd"] = ProtocolConstant::MONITOR_CMD_LEAVE_MSG;
        } else if($this->cmd == ProtocolConstant::CORE_CMD_LEAVE_CONFIRM) {
            $this->message["cmd"] = ProtocolConstant::MONITOR_CMD_LEAVED;
        }

        $ret = $monitorObj->sendMessage($this->message);

        if($ret != 0)  {
            $coreObject->errorResponse(ErrorCode::$WebsocketConnectionNotFound);
            LogHelper::err(ErrorCode::$WebsocketConnectionNotFound, $this->method, $this->message);
            return;
        }

        $coreObject->successResponse();
        LogHelper::info($this->method, $this->message);
    }

    private function enterConfirm() {
        $this->method = __METHOD__;
        $this->sendToWebSocket();
    }


    private function doParking() {
        LogHelper::info($this->method, $this->message);
        $hardwareObject = HardwareModel::getInstance();
        // 开闸,播放语音, 播放led
        $this->admission_id = $this->message["admissionId"];
        $this->ip_addr = $this->message["ipAddr"];

        $ret = 0;
        $hardwareObject = HardwareModel::getInstance();
        $ret = $hardwareObject->sendOpenGate($this->device_addr);

        $coreObject = CoreModel::getInstance();
        if($ret != 0) {
            $coreObject->errorResponse(ErrorCode::$HardwareOpenDoorFailed);
            LogHelper::err(ErrorCode::$HardwareOpenDoorFailed, $this->method, $this->message);
            return;
        }

        $this->content = $this->message["voiceMessage"];
        $ret = $hardwareObject->sendPlayVoice($this->device_addr, $this->content);

        $this->content = $this->message["ledMessage"];
        $led_ip_addr = $this->message["ledIpAddr"];
        $ret = $hardwareObject->showLEDText($led_ip_addr, $this->content);

        $coreObject->successResponse();

        // 需要保存中间状态,硬件返回已入场时候透传。
        $hardwareObject->setSession($this->message);

        $this->sendToWebSocket();
    }

	private function enterPark() {
        $this->method = __METHOD__;
        $this->doParking();
    }

	private function leaveConfirm() {
        $this->method = __METHOD__;
        $this->sendToWebSocket();
	}

    private function leavePark() {
        $this->method = __METHOD__;
        $this->doParking();
    }

	public function handleRequest($message) {
		$this->message = $message;
		$this->cmd = $message["cmd"];
		$this->device_addr = $message["deviceId"];
        $this->content = isset($message["content"]) ? $message["content"] : "";

		switch($this->cmd) {
			 case ProtocolConstant::CORE_CMD_OPEN_GATE: //开闸请求
			 	$this->openGate();
			 	break;
			 case ProtocolConstant::CORE_CMD_PLAY_VOICE: //播放语音请求
			 	$this->playVoice();
			 	break;
			 case ProtocolConstant::CORE_CMD_SHOW_LED: //显示字幕请求
			 	$this->showLED();
			 	break;
            case ProtocolConstant::CORE_CMD_ENTER_CONFIRM: // 入场确认请求
                $this->enterConfirm();
                break;
            case ProtocolConstant::CORE_CMD_ENTER_PARK: //入场请求
				$this->enterPark();
				break;
            case ProtocolConstant::CORE_CMD_LEAVE_CONFIRM: // 出场确认请求
                $this->leaveConfirm();
                break;
            case ProtocolConstant::CORE_CMD_LEAVE_PARK: //出场请求
				$this->leavePark();
				break;

		}
	}



}
?>