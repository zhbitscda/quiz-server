<?php 
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
use \Workerman\Worker;
use \GatewayWorker\Register;

// 自动加载类
require_once __DIR__ . '/../../Workerman/Autoloader.php';


// 自动加载composer 类
require_once __DIR__ . '/vendor/autoload.php';


// 定义app路径
define("BASE_DIR", __DIR__ . '/');


// 加载日志类
require_once __DIR__ . '/Lib/LogConfigurator.php';

require_once BASE_DIR . "Helper/LogHelper.php";
require_once __DIR__ . '/Config/ErrorCode.php';

//
//$configuration = array(
//    'foo' => 1,
//    'bar' => 2
//);
//
//Logger::configure($configuration, new LogConfigurator());



$register = new Register('text://0.0.0.0:1238');

// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START')) {
    Worker::runAll();
}

