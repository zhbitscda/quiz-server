<?php
/**
 * Created by PhpStorm.
 * User: shanks-tmt
 * Date: 16/7/30
 * Time: 下午8:11
 */

class LogHelper {
    public static function info($method, $data) {

        $configuration = array(
            'foo' => 1,
            'bar' => 2
        );
        Logger::configure($configuration, new InfoLogConfigurator());

        $logger = Logger::getLogger("sinihi_info");

        $logInfo = "[method=$method]";
        foreach($data as $key => $value) {
            $logInfo .= "[$key=$value]";
        }
        $logger->info($logInfo);
    }

    public static function err($error, $method, $data) {
        $configuration = array(
            'foo' => 1,
            'bar' => 2
        );
        Logger::configure($configuration, new ErrLogConfigurator());
        $logger = Logger::getLogger("sinihi_err");

        $logInfo = "[method=$method]";
        $logInfo .= "[errCode=$error[0]][errMsg=$error[1]]";
        foreach($data as $key => $value) {
            $logInfo .= "[$key=$value]";
        }
        $logger->info($logInfo);

    }

    public static function getIp() {
        $onlineip = '';
        var_dump($_SERVER);
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $onlineip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        return $onlineip;
}
}