<?php
/**
 * Created by PhpStorm.
 * User: shanks-tmt
 * Date: 16/7/31
 * Time: 上午7:35
 */

class ErrorCode {

    // 硬件错误 1xxx
    public static $HardwareConnectionNotFound = array(1001, "总线控制器连接丢失!"); //  发送给总线控制器时候,没有找到连接
    public static $HardwareOpenDoorFailed     = array(1002, "开闸失败!");         //  开闸失败

    // websocket 错误 2xxx
    public static $WebsocketConnectionNotFound = array(2001, "岗亭电脑连接丢失!"); //  发送给总线控制器时候,没有找到连接

}