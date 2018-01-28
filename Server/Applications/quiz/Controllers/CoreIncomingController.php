<?php

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
        
    }

    private function enterConfirm() {
        $this->method = __METHOD__;
        $this->sendToWebSocket();
    }

    private function doParking() {
    
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

	}

}
?>