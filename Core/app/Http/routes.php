<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/* 版本模块 */
$app->get('/', function () use ($app) {
    return $app->version();
});

/* 测试模块 */
$app->get('/test', function () use ($app) {
    return "goodluck";
});

/* oauth2 认证测试*/
$app->post('oauth2/token', 'OauthController@token');

/* 操作员模块 */
$app->post('operator/login', 'OperatorController@login');
$app->post('operator/login1', 'OperatorController@login1');
$app->post('operator/logout', 'OperatorController@logout');
$app->get    ('operator', 'OperatorController@read');
$app->post   ('operator', 'OperatorController@add');
$app->put    ('operator', 'OperatorController@update');
$app->delete ('operator', 'OperatorController@delete');

/* 角色模块 */
$app->get    ('role', 'RoleController@read');
$app->post   ('role', 'RoleController@add');
$app->put    ('role', 'RoleController@update');
$app->delete ('role', 'RoleController@delete');

/* 权限模块 */
$app->get    ('permission', 'PermissionController@read');

/* 卡片模块 */
// 总卡
$app->get    ('card', 'CardController@read');
// 车卡
$app->get    ('card/parkCard', 'ParkCardController@read');
$app->post   ('card/parkCard', 'ParkCardController@add');
$app->put    ('card/parkCard', 'ParkCardController@update');
$app->delete ('card/parkCard', 'ParkCardController@delete');
$app->get    ('card/parkCard/search', 'ParkCardController@search');
$app->post   ('card/parkCard/permission', 'ParkCardController@permission');

$app->get    ('card/issueParkCardData', 'ParkCardController@issueParkCardData');
$app->post   ('card/change', 'ParkCardController@change');

/* 车模块 */
$app->get    ('car', 'CarController@read');
$app->get    ('car/search', 'CarController@search');

/* 岗亭模块 */
$app->get    ('box', 'BoxController@read');
$app->post   ('box', 'BoxController@add');
$app->put    ('box', 'BoxController@update');
$app->delete ('box', 'BoxController@delete');
$app->get    ('box/boxDoor', 'BoxDoorController@read');
$app->post   ('box/boxDoor', 'BoxDoorController@add');
$app->put    ('box/boxDoor', 'BoxDoorController@update');
$app->delete ('box/boxDoor', 'BoxDoorController@delete');

/* 用户模块 */
$app->get    ('user', 'UserController@read');
$app->post   ('user', 'UserController@add');
$app->put    ('user', 'UserController@update');
$app->delete ('user', 'UserController@delete');
$app->get    ('user/search', 'UserController@search');
$app->get    ('user/notIssueParkCard', 'UserController@getNotIssueParkCard');
$app->get    ('user/department', 'UserController@getDepartment');

/* 设备模块 */
$app->get    ('device', 'DeviceController@read');
$app->post   ('device', 'DeviceController@add');
$app->put    ('device', 'DeviceController@update');
$app->delete ('device', 'DeviceController@delete');
$app->get    ('device/camera', 'DeviceController@getCameraListByBoxId');

/* 出入场模块 */
$app->get    ('admission', 'AdmissionController@read');
$app->post   ('admission', 'AdmissionController@add');
$app->put    ('admission', 'AdmissionController@update');
$app->delete ('admission', 'AdmissionController@delete');
$app->get    ('admission/search', 'AdmissionController@search');
// 捕获摄像头
$app->post   ('admission/camera', 'AdmissionController@admitRequest');
// 事件分发
$app->post   ('admission/eventDistribution', 'AdmissionController@eventDistribution');
// 下载图片
$app->post   ('admission/downloadPic', 'AdmissionController@downloadPic');
// 语音
$app->post   ('admission/sendVoice', 'AdmissionController@sendVoice');
// Led
$app->post   ('admission/sendLed', 'AdmissionController@sendLed');
// 开闸
$app->post   ('admission/sendOpenGate', 'AdmissionController@sendOpenGate');
// 取消出场
$app->post   ('admission/cancelExit', 'AdmissionController@cancelExit');
// 取消入场
$app->post   ('admission/cancelEnter', 'AdmissionController@cancelEnter');
// 获取流水
$app->get    ('admission/flow', 'AdmissionController@readFlow');

/* 配置模块 */
$app->get    ('configure', 'ConfigureController@read');
$app->put    ('configure/park', 'ConfigureController@updatePark');
$app->put    ('configure/box', 'ConfigureController@updateBox');

$app->get    ('endTcp', 'AdmissionController@sendTcpSvr');

/* 收费模块 */
$app->get    ('pay/data',   'PayController@payData');
$app->get    ('pay/config', 'PayController@read');
$app->post   ('pay/config', 'PayController@add');
$app->put    ('pay/config', 'PayController@update');
$app->delete ('pay/config', 'PayController@delete');

/* 导航栏模块 */
$app->get    ('navigation', 'NavigationController@getNavi');

/* 文档模块 */
$app->get('doc', function() {
    return view('doc');
});

/* 错误码文档模块 */
$app->get('errorCodeDoc', function() {
    return view('errorCodeDoc');
});

/* 接口更新说明文档模块 */
$app->get('interfaceHistoryDoc', function() {
    return view('interfaceHistoryDoc');
});
