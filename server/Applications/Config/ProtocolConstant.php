<?php


class ProtocolConstant {
	const PROTOCOL_TYPE_HARDWARE = "hardware"; // 硬件协议标识
	const PROTOCOL_TYPE_MONITOR  = "monitor"; // 硬件协议标识
	const PROTOCOL_TYPE_CORE = "core"; // 硬件协议标识


// 中央处理器发送过来的命令类型
	const CORE_CMD_OPEN_GATE	    = 1; 	// 开闸请求
	const CORE_CMD_PLAY_VOICE	    = 2;	// 播放语音
	const CORE_CMD_SHOW_LED	        = 3;	// 显示LED
	const CORE_CMD_ENTER_CONFIRM	= 4;	// 入场确认
    const CORE_CMD_ENTER_PARK	    = 5;	// 入场请求
    const CORE_CMD_LEAVE_CONFIRM	= 6;	// 出场确认
    const CORE_CMD_LEAVE_PARK	    = 7;	// 出场请求

	// // 总线控制器向中转svr发送的命令

	const DEVICE_CMD_HEARTBEAT_RECV     = 100;  // 接收到心跳包，总线->中央
	const DEVICE_CMD_HEARTBEAT_SEND     = 101;  // 响应心跳包，中央->总线
	const DEVICE_CMD_OPEN_GATE          = 1;    // 发起开闸请求，中央->总线
	const DEVICE_CMD_OPEN_GATE_RECV     = 2; 	// 返回开闸请求，总线->中央
	const DEVICE_CMD_CLOSE_GATE_RECV    = 3; 	// 接收到关闸消息，总线->中央
	const DEVICE_CMD_CLOSE_GATE_RESP    = 4; 	// 返回关闸消息已接收，中央->总线
    const DEVICE_CMD_GATE_STATUS_RECV   = 5;    // 道闸状态, 总线->中央
    const DEVICE_CMD_GATE_STATUS_RESP   = 6;    // 返回道闸状态, 中央->总线

    const DEVICE_CMD_PLAY_VOICE 	    = 1; 	// 发送播放请求，中央->总线
	const DEVICE_CMD_PLAY_VOICE_RECV    = 2; 	// 返回播放请求，总线->中央
	const DEVICE_CMD_DETECTOR_RECV		= 1;    // 接收到地感消息，总线->中央
	const DEVICE_CMD_DETECTOR_RESP	    = 2;    // 返回地感消息已接收？？，中央->总线


	const DEVICE_TYPE_CONTROLLER        = 0;    // 总线控制器
	const DEVICE_TYPE_GATE              = 1;	// 道闸
	const DEVICE_TYPE_VOICE_PLAYER      = 2;    // 语音播放器
	const DEVICE_TYPE_DETECTOR          = 3;	// 地感
	const DEVICE_TYPE_LED               = 4;	// LED


	// 中央处理器向web socket发送消息
    const MONITOR_CMD_HEART_BEAT	    = 1;	//	1、心跳包
    const MONITOR_CMD_ENTER_MSG   	    = 2;	// 	2、入场消息
    const MONITOR_CMD_LEAVE_MSG   	    = 3;	// 	3、出场消息
    const MONITOR_CMD_ENTERED 		    = 4;	// 	4、已入场确认消息
    const MONITOR_CMD_LEAVED 		    = 5;	// 	5、已出场确认消息
    const MONITOR_CMD_PLAYED_VOICE 	    = 6;	// 	6、已播放语音消息
    const MONITOR_CMD_SHOWED_LED 	    = 7;	// 	7、已显示led消息
    const MONITOR_CMD_GATE_RUN   	    = 8;	// 	8、道闸运行中
    const MONITOR_CMD_GATE_OPENED 	    = 9;	// 	9、道闸完全打开
    const MONITOR_CMD_GATE_CLOSED 	    = 10;	// 	10、道闸完全关闭
    const MONITOR_CMD_GATE_LOST 	    = 11;	// 	11、道闸连接丢失
    const MONITOR_CMD_GATE_CONNECT 	    = 12;	// 	12、道闸重连

    // 语言消息配置
    public static $VOICE_MESSAGE_CONFIG = array(

    );


    const BOX_ID_NAME = "boxId";
    const BOX_ID_PREFIX = "boxid_";


    // led 协议
    const LED_PROTOCOL_FORMAT = "!#001%C1{CONTENT}$$";
    const LED_PORT  = 5005;

    // 道闸状态
    const DEVICE_GATE_STATUS_RUN            = 0;    // 运行中
    const DEVICE_CMD_GATE_STATUS_OPENED     = 1;    // 完全打开
    const DEVICE_CMD_GATE_STATUS_CLOSED     = 2;    // 完全关闭
    const DEVICE_CMD_GATE_STATUS_LOST       = 100;    // 连接丢失
    const DEVICE_CMD_GATE_STATUS_CONNECT    = 101;    // 重连


}





?>