<?php

namespace Protocols;
// <!--
// 入场消息
// {"type":1, "carNo": xxx, "carColor": xxx, "carType": xxx, "deviceId": xxx, "openDoorType": xxx}

// 出场消息
// {"type":2, "carNo": xxx, "carColor": xxx, "carType": xxx, "deviceId": xxx, "openDoorType": xxx} -->

class MonitorProtocol
{
	public static function input($recv_buffer)
    {
         // 使用文本协议
        $recv_len = strlen($recv_buffer);
        if($recv_buffer[$recv_len-1] !== "\n")
        {
            return 0;
        }
        return strlen($recv_buffer);
    }

    public static function decode($recv_buffer)
    {
        $jsonData = json_decode(trim($recv_buffer), true);
        $jsonData["type"] = "monitor"; // 表明是中央处理器过来的请求
        return $jsonData;
    }

    public static function encode($data)
    {
        return $data;
    }
}

?>
