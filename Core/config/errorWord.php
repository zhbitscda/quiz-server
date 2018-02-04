<?php
// 公共
define('ERR_DB_EXEC_WORD', '数据库执行失败'); //数据库执行失败

// AccessToken
define('ACCESSTOKEN_IS_EMPTY_WORD', 'accessToken不能为空'); // accesstoken为空
define('ACCESSTOKEN_IS_ERROR_WORD', 'accessToken错误'); // accesstoken错误

// 操作者
define('OPERATOR_ID_IS_EMPTY_WORD',       '操作员ID不能为空'); //operatorId为空
define('OPERATOR_ID_IS_NOT_EXIST_WORD',   '该操作员ID不存在'); //operatorId不存在
define('OPERATOR_USERNAME_IS_EMPTY_WORD', '用户名不能为空');
define('OPERATOR_USERNAME_IS_EXIST_WORD', '用户名已经存在');
define('OPERATOR_PASSWORD_IS_EMPTY_WORD', '密码不能为空');
define('OPERATOR_USERNAME_OR_PASSWORD_IS_ERROR_WORD', '账号或密码错误');
define('OPERATOR_IP_ERROR_WORD',           '岗亭IP有误'); //IP有误

// 角色
define('ROLE_ID_IS_EMPTY_WORD',     '角色ID不能为空'); //roleId为空
define('ROLE_ID_IS_NOT_EXIST_WORD', '该角色ID不存在'); //roleId不存在
define('ROLE_ID_IS_IN_USED_WORD',   '该角色ID正在被使用,无法删除'); //roleId已被使用
define('ROLE_NAME_IS_EMPTY_WORD',   '角色名不能为空'); //roleName为空
define('ROLE_NAME_IS_EXIST_WORD',   '角色名已经存在'); //roleName已存在

// 权限
define('PERMISSION_ID_IS_EMPTY_WORD',     '权限ID不能为空'); //permissionId为空
define('PERMISSION_ID_IS_NOT_EXIST_WORD', '该权限ID不存在'); //permissionId不存在
define('PERMISSIONS_IS_EMPTY_WORD',       '权限不能为空');
define('PERMISSIONS_IS_ERROR_WORD',       '权限输入有误,不存在该权限');

// 总卡
define('CARD_ID_IS_EMPTY_WORD',       '卡ID不能为空'); //cardId为空
define('CARD_ID_IS_NOT_EXIST_WORD',   '该卡ID不存在'); //cardId不存在
define('CARD_ID_IS_IN_USED_WORD',     '该卡ID已经存在,无法添加'); //cardId已被使用
define('CARD_PROPERTY_IS_EMPTY_WORD', '卡的属性不能为空'); //property为空
define('CARD_PROPERTY_IS_ERROR_WORD', '卡的属性规则有误'); //property规则有误
define('CARD_DEPOSITE_IS_EMPTY_WORD', '卡的押金不能为空'); //deposit为空
define('CARD_DEPOSITE_IS_ERROR_WORD', '卡的押金规则有误'); //deposit规则有误
define('CARD_PRINT_NO_IS_EMPTY_WORD', '卡的印刷号不能为空'); //printNo为空
define('CARD_STATUS_IS_EMPTY_WORD',   '卡的状态不能为空'); //status为空
define('CARD_STATUS_IS_ERROR_WORD',   '卡的状态规则有误'); //status规则有误

// 停车卡(停车卡类型)
define('PARK_CARD_FUNCTION_IS_NOT_EXIST_WORD',    '该卡未开通车停卡功能'); //未开通车停卡功能
define('PARK_CARD_TYPE_ID_IS_EMPTY_WORD',         '停车卡类型ID不能为空'); //cardTypeId为空
define('PARK_CARD_TYPE_ID_IS_NOT_EXIST_WORD',     '该停车卡类型ID不存在'); //cardTypeId不存在
define('PARK_CARD_TIMES_IS_EMPTY_WORD',           '停车卡次数不能为空'); //times为空
define('PARK_CARD_TIMES_IS_ERROR_WORD',           '停车卡次数规则有误'); //times规则有误
define('PARK_CARD_BALANCE_IS_EMPTY_WORD',         '停车卡余额不能为空'); //balance为空
define('PARK_CARD_BALANCE_IS_ERROR_WORD',         '停车卡余额规则有误'); //balance规则有误
define('PARK_CARD_AMOUNT_IS_EMPTY_WORD',          '停车卡发行金额不能为空'); //amount为空
define('PARK_CARD_AMOUNT_IS_ERROR_WORD',          '停车卡发行金额有误'); //amount规则有误
define('PARK_CARD_ISNOTE_IS_EMPTY_WORD',          '短信功能不能为空'); //isNote为空
define('PARK_CARD_ISNOTE_IS_ERROR_WORD',          '短信功能规则有误'); //isNote规则有误
define('PARK_CARD_REMARK_IS_EMPTY_WORD',          '备注不能为空'); //remark为空
define('PARK_CARD_BEGIN_DATE_IS_EMPTY_WORD',      '停车卡开始使用日期不能为空'); //beginDate为空
define('PARK_CARD_END_DATE_IS_EMPTY_WORD',        '停车卡结束使用日期不能为空'); //endDate为空
define('PARK_CARD_ISBLACK_IS_ERROR_WORD',         '黑名单规则有误'); //isBlack规则有误
define('PARK_CARD_PERMISSION_TYPE_IS_EMPTY_WORD', '授权类型为空'); //授权类型为空
define('PARK_CARD_PERMISSION_TYPE_IS_ERROR_WORD', '授权类型数值有误'); //授权类型有误

// 车(车类型和车图片、车牌所属地)
define('CAR_ID_IS_EMPTY_WORD',            '车ID不能为空'); //cardId为空
define('CAR_ID_IS_NOT_EXIST_WORD',        '该车ID不存在'); //cardId不存在
define('CAR_TYPE_ID_IS_EMPTY_WORD',       '车类型ID不能为空'); //carTypeId为空
define('CAR_TYPE_ID_IS_NOT_EXIST_WORD',   '该车类型ID不存在'); //carTypeId不存在
define('CAR_LOC_ID_IS_EMPTY_WORD',        '车所属地ID不能为空'); //carLocId为空
define('CAR_LOC_ID_IS_NOT_EXIST_WORD',    '该车所属地ID不存在'); //carLocId不存在
define('CAR_PHOTO_ID_IS_EMPTY_WORD',      '车图片ID不能为空'); //carPhotoId为空
define('CAR_PHOTO_ID_IS_NOT_EXIST_WORD',  '该车图片ID不存在'); //carPhotoId为空
define('CAR_NUM_IS_EMPTY_WORD',           '车牌号码不能为空'); //carNum为空
define('CAR_NUM_IS_EXIST_WORD',           '车牌已经存在,请输入车ID或输入其他车牌'); //车牌已经存在
define('CAR_COLOR_IS_EMPTY_WORD',         '车颜色不能为空'); //carColor为空
define('CAR_PARKING_PLACE_IS_EMPTY_WORD', '车位不能为空'); //parkingPlace为空
define('OLD_CAR_ID_IS_EMPTY_WORD',        '旧卡ID不能为空'); //oldCardId为空
define('OLD_CAR_ID_IS_NOT_EXIST_WORD',    '旧卡ID不存在'); //oldCardId不存在
define('NEW_CAR_ID_IS_EMPTY_WORD',        '新卡ID不能为空'); //newCardId为空
define('NEW_CAR_ID_IS_EXIST_WORD',        '新卡已被使用'); //newCardId已存在

// 用户
define('USER_ID_IS_EMPTY_WORD',        '用户ID不能为空'); //userId为空
define('USER_ID_IS_NOT_EXIST_WORD',    '该用户ID不存在'); //userId不存在
define('USER_NAME_IS_EXIST_WORD',      '用户名已存在'); //用户名已存在
define('USER_TELEPHONE_IS_EMPTY_WORD', '手机号码不能为空'); //telephone为空
define('USER_IDCARD_IS_EMPTY_WORD',    '身份证号码不能为空'); //idCard为空

// 岗亭
define('BOX_ID_IS_EMPTY_WORD',               '岗亭ID不能为空'); //boxId为空
define('BOX_ID_IS_NOT_EXIST_WORD',           '该岗亭ID不存在'); //boxId不存在
define('BOX_IP_IS_EMPTY_WORD',               '岗亭IP不能为空'); //box IP不存在
define('BOX_IP_IS_ERROR_WORD',               '岗亭IP格式有误'); //box IP不存在
define('BOX_IP_IS_EXIT_WORD',                'IP地址已存在'); //box IP不存在
define('BOX_DOOR_RIGHT_IS_EMPTY_WORD',       '通道权限不能为空'); //boxDoorRight
define('BOX_DOOR_RIGHT_IS_ERROR_WORD',       '通道权限输入有误,通道ID不存在'); //boxDoorRight
define('BOX_NAME_IS_EMPTY_WORD',             '岗亭名称不能为空'); //boxName为空
define('BOX_NAME_IS_ERROR_WORD',             '岗亭名称重复'); //boxName重复
define('BOX_LOCATION_IS_EMPTY_WORD',         '岗亭位置不能为空'); //boxLocation为空
define('BOX_STATUS_IS_EMPTY_WORD',           '岗亭状态不能为空'); //status为空
define('BOX_STATUS_IS_ERROR_WORD',           '岗亭状态格式有误'); //status格式有误
define('BOX_BOX_DOOR_IS_IN_USED_WORD',       '该岗亭下岗通道正在被使用,无法删除'); //boxDoor被使用
define('BOX_DOOR_ID_IS_EMPTY_WORD',          '通道ID不能为空'); //boxDoorId为空
define('BOX_DOOR_ID_IS_NOT_EXIST_WORD',      '该通道ID不存在'); //boxDoorId不存在
define('BOX_DOOR_NAME_IS_EMPTY_WORD',        '通道名称不能为空'); //boxDoorName为空
define('BOX_DOOR_NAME_IS_ERROR_WORD',        '通道名称重复'); //boxDoorName重复
define('BOX_DOOR_FUNCTION_IS_EMPTY_WORD',    '通道作用不能为空'); //function为空
define('BOX_DOOR_FUNCTION_IS_ERROR_WORD',    '通道作用格式有误'); //function格式有误
define('BOX_DOOR_TYPE_IS_EMPTY_WORD',        '通道类型不能为空'); //type为空
define('BOX_DOOR_TYPE_IS_ERROR_WORD',        '通道类型格式有误'); //type格式有误
define('BOX_DOOR_STATUS_IS_EMPTY_WORD',      '通道状态不能为空'); //status为空
define('BOX_DOOR_STATUS_IS_ERROR_WORD',      '通道状态格式有误'); //status格式有误
define('BOX_DOOR_IS_IN_USED_WORD',           '该通道正在被使用,无法删除'); //boxDoor被使用
define('BOX_COMP_ID_IS_ERROR_WORD',          '岗亭托管主机选择有误'); //boxCompId有误
define('BOX_DOOR_IS_CHECK_IS_ERROR_WORD',    '通道是否为检测口格式有误'); //isCheck格式有误
define('BOX_DOOR_IS_TEMP_IN_IS_ERROR_WORD',  '通道是否为临时入口格式有误'); //isTempIn格式有误
define('BOX_DOOR_IS_TEMP_OUT_IS_ERROR_WORD', '通道是否为临时出口格式有误'); //isTempOut格式有误
define('BOX_DOOR_CAR_RIGHT_IS_ERROR_WORD',   '通道卡权限输入有误'); //cardRights格式有误
define('BOX_MAIN_CONTROL_MACHINE_IS_EMPTY_WORD', '通道主控制器机号不能为空'); //cardRights格式有误
define('BOX_BARRIER_GATE_CONTROL_MACHINE_IS_EMPTY_WORD', '通道道闸控制器机号不能为空'); //cardRights格式有误

/* 设备模块 */
define('DEVICE_ID_IS_EMPTY_WORD',          '设备ID不能为空'); //deviceId为空
define('DEVICE_ID_IS_NOT_EXIST_WORD',      '设备ID不能为空'); //deviceId不存在
define('DEVICE_ID_IS_IN_USED_WORD',        '该设备正在被使用,无法删除'); //deviceId正在使用中
define('DEVICE_NAME_IS_EMPTY_WORD',        '设备名称不能为空'); //deviceName为空
define('DEVICE_NAME_IS_ERROR_WORD',        '设备名称重复'); //deviceName重复
define('DEVICE_IP_IS_EMPTY_WORD',          '设备IP地址不能为空'); //deviceIP为空
define('DEVICE_IP_IS_ERROR_WORD',          '设备IP地址格式有误' ); //deviceIP有误
define('DEVICE_IP_IS_EXIT_WORD',           'IP地址已存在'); //deviceIP格式有误
define('DEVICE_MAC_IS_EMPTY_WORD',         '设备MAC地址不能为空'); //deviceMac为空
define('DEVICE_MAC_IS_ERROR_WORD',         '设备MAC地址格式有误'); //deviceMac格式有误
define('DEVICE_TYPE_IS_EMPTY_WORD',        '设备类型不能为空'); //deviceType为空
define('DEVICE_TYPE_IS_ERROR_WORD',        '设备类型格式有误'); //deviceType格式有误

/* 出入场模块 */
define('ADMISSION_ID_IS_EMPTY_WORD',               '出入场ID为空'); //admissionId为空
define('ADMISSION_ID_IS_NOT_EXIT_WORD',            '该出入场ID不存在'); //admissionId不存在
define('ADMISSION_CAR_NO_IS_EMPTY_WORD',           '出入场车牌为空');   //carNo为空
define('ADMISSION_CAR_COLOR_IS_EMPTY_WORD',        '出入场车颜色为空'); //carColor为空
define('ADMISSION_CAR_PARKCARD_IS_NOT_EXIT_WORD',  '出入场车辆未办法'); //parkcard不存在
define('ADMISSION_IP_IS_EMPTY_WORD',               '出入场IP为空'); //IP为空
define('ADMISSION_STATUS_IS_EMPTY_WORD',           '出入场状态不能为空'); //status为空
define('ADMISSION_ENTER_TIME_IS_EMPTY_WORD',       '入场时间不能为空'); //enterTime为空
define('ADMISSION_EXIT_TIME_IS_EMPTY_WORD',        '出场时间不能为空'); //exitTime为空
define('ADMISSION_CAR_NUM_IS_EMPTY_WORD',          '出入场车牌号码不能为空'); //carNum为空

/* 配置模块 */
define('CONFIGURE_DATA_IS_EMPTY_WORD',             '配置数据为空'); //configureDATA为空
define('CONFIGURE_ID_IS_EMPTY_WORD',               '配置ID为空'); //configureId为空
define('CONFIGURE_ID_IS_NOT_EXIT_WORD',            '配置ID不存在'); //configureId不存在
define('CONFIGURE_NAME_IS_EMPTY_WORD',             '配置名称为空'); //configureName为空
define('CONFIGURE_VALUE_IS_EMPTY_WORD',            '配置值为空'); //configureEmpty不存在
define('CONFIGURE_VALUE_IS_ERROR_WORD',            '配置值规则有误'); //configureName不存在

/* 收费模块 */
define('PAYCONFIGURE_ID_IS_NOT_EXIST_WORD',        '收费配置ID不存在');
define('PAYCONFIGURE_ID_IS_EMPTY_WORD',            '收费配置ID为空');
define('PAYCONFIGURE_NAME_IS_EMPTY_WORD',          '收费配置名称为空');
define('PAYCONFIGURE_NAME_IS_EXIST_WORD',          '收费配置名称已存在');
define('PAYRULEID_IS_EMPTY_WORD',                  '收费规则ID为空');
define('PAYRULEID_IS_ERROR_WORD',                  '收费规则ID有误');

?>
