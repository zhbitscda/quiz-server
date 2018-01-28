<?php

namespace Protocols;
// <!--
// - 首部4字节网络字节序unsigned int，标记整个包的长度
// - 数据部分为Json字符串

// 1、开闸请求
// {"cmd”:1,“deviceId”: xxx}

// 2、关闸请求
// {"cmd”:2,“deviceId”: xxx}

// 3、播放语音请求
// {"cmd”:3,“deviceId”: xxx, “content”: xxx}

// 4、显示字幕请求
// {"cmd”:4,“deviceId”: xxx, “content”: xxx}


// 此协议对应的是短连接，接收请求
// -->

class CoreProtocol
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
        var_dump($recv_buffer);
        $jsonData = json_decode(trim($recv_buffer), true);

        // 指定一下type，区分来源。
        $jsonData["type"] = "core"; // 表明是中央处理器过来的请求
        var_dump($jsonData);
        return $jsonData;
    }

    public static function encode($data)
    {
        // // Json编码得到包体
        // $body_json_str = json_encode($data);
        // // 计算整个包的长度，首部4字节+包体字节数
        // $total_length = strlen($body_json_str) + 1;
        // // 返回打包的数据
        // return $body_json_str + "\n";
        return $data;
    }
}
?>
