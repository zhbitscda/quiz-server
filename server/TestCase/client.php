<?php  
error_reporting(E_ALL);  
//端口111  
$service_port = 8282;  
//本地  
//$address = '172.16.192.232';  
$address = '127.0.0.1';  
//创建 TCP/IP socket  
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);  
var_dump($socket);
if ($socket < 0) {  
        echo "socket创建失败原因: " . socket_strerror($socket) . "\n";  
} else {  
        echo "OK，HE HE.\n";  
}  
$result = socket_connect($socket, $address, $service_port);
if ($result < 0) {  
        echo "SOCKET连接失败原因: ($result) " . socket_strerror($result) . "\n";  
} else {  
        echo "OK.\n";  
}  
//发送开闸命令  
$msg = "{'cmd': 1, 'deviceId': 240}\n";
$msg = "{'cmd': 2, 'deviceId': 3, 'content': \"此次收费10元,欢迎光临\"}\n";


// led
$msg = "{'cmd': 3, 'deviceId': 3, 'ledIpAddr': \"192.168.1.160\", 'content': \"此次收费  10元粤BG9673\"}\n";


// 车牌用汉字, 收费用数字

//$msg = array(
//    'cmd' => 5,
//    'deviceId' => 1,
//    'ipAddr' => "192.168.0.1",
//    'voiceMessage' => "test",
//    'ledMessage' => "test",
//    'admissionId' => 1
//);

//$msg = json_encode($msg) . "\n";

socket_write($socket, $msg, strlen($msg));  

echo "返回：\n";  
while ($out = socket_read($socket, 2048)) {  
        echo $out;  
}  
echo "关闭连接\n";  
socket_close($socket);  
 
?>  