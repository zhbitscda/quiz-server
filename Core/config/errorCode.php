<?php
//系统和公共错误
define("ERR_PARAMETER",             -1001); //参数错误
define("ERR_DB_EXEC_CODE",          -1002); //数据库执行失败
define('ACCESSTOKEN_IS_EMPTY_CODE', -1003); //accesstoken为空
define("ACCESSTOKEN_IS_ERROR_CODE", -1004); //服务器验证accesstoken失败
define("ERR_CONFIG_WRONG",          -1005); //配置不一致错误
define("SERVER_MAINTENANCE",        -1006); //服务器维护中

// 操作者
define('OPERATOR_ID_IS_EMPTY_CODE',       -1101); //operatorId为空
define('OPERATOR_ID_IS_NOT_EXIST_CODE',   -1102); //operatorId不存在
define('OPERATOR_USERNAME_IS_EMPTY_CODE', -1111); //用户名为空
define('OPERATOR_USERNAME_IS_EXIST_CODE', -1112); //用户名已经存在
define('OPERATOR_PASSWORD_IS_EMPTY_CODE', -1113); //密码为空
define('OPERATOR_USERNAME_OR_PASSWORD_IS_ERROR_CODE', -1114); //账号或密码错误
define('OPERATOR_IP_ERROR_CODE',          -1115); //IP有误

// 角色
define('ROLE_ID_IS_EMPTY_CODE',     -1201); //roleId为空
define('ROLE_ID_IS_NOT_EXIST_CODE', -1202); //roleId不存在
define('ROLE_ID_IS_IN_USED_CODE',   -1203); //roleId已被使用
define('ROLE_NAME_IS_EMPTY_CODE',   -1211); //roleName为空
define('ROLE_NAME_IS_EXIST_CODE',   -1212); //roleName已存在

// 权限
define('PERMISSION_ID_IS_EMPTY_CODE',     -1301); //permissionId为空
define('PERMISSION_ID_IS_NOT_EXIST_CODE', -1302); //permissionId不存在
define('PERMISSIONS_IS_EMPTY_CODE',       -1311); //权限不存在
define('PERMISSIONS_IS_ERROR_CODE',       -1312); //权限有误

// 总卡
define('CARD_ID_IS_EMPTY_CODE',       -1401); //cardId为空
define('CARD_ID_IS_NOT_EXIST_CODE',   -1402); //cardId不存在
define('CARD_ID_IS_IN_USED_CODE',     -1403); //cardId已被使用
define('CARD_PROPERTY_IS_EMPTY_CODE', -1411); //property为空
define('CARD_PROPERTY_IS_ERROR_CODE', -1412); //property规则有误
define('CARD_DEPOSITE_IS_EMPTY_CODE', -1413); //deposit为空
define('CARD_DEPOSITE_IS_ERROR_CODE', -1414); //deposit规则有误
define('CARD_PRINT_NO_IS_EMPTY_CODE', -1415); //printNo为空
define('CARD_STATUS_IS_EMPTY_CODE',   -1416); //status为空
define('CARD_STATUS_IS_ERROR_CODE',   -1417); //status规则有误

// 停车卡(停车卡类型)
define('PARK_CARD_FUNCTION_IS_NOT_EXIST_CODE',    -1420); //未开通车停卡功能
define('PARK_CARD_TYPE_ID_IS_EMPTY_CODE',         -1421); //cardTypeId为空
define('PARK_CARD_TYPE_ID_IS_NOT_EXIST_CODE',     -1422); //cardTypeId不存在
define('PARK_CARD_TIMES_IS_EMPTY_CODE',           -1431); //times为空
define('PARK_CARD_TIMES_IS_ERROR_CODE',           -1432); //times规则有误
define('PARK_CARD_BALANCE_IS_EMPTY_CODE',         -1433); //balance为空
define('PARK_CARD_BALANCE_IS_ERROR_CODE',         -1434); //balance规则有误
define('PARK_CARD_AMOUNT_IS_EMPTY_CODE',          -1435); //balance为空
define('PARK_CARD_AMOUNT_IS_ERROR_CODE',          -1436); //balance规则有误
define('PARK_CARD_BOX_RIGHT_IS_EMPTY_CODE',       -1437); //boxRight为空
define('PARK_CARD_ISNOTE_IS_EMPTY_CODE',          -1438); //isNote为空
define('PARK_CARD_ISNOTE_IS_ERROR_CODE',          -1439); //isNote规则有误
define('PARK_CARD_REMARK_IS_EMPTY_CODE',          -1440); //remark为空
define('PARK_CARD_BEGIN_DATE_IS_EMPTY_CODE',      -1441); //beginDate为空
define('PARK_CARD_END_DATE_IS_EMPTY_CODE',        -1442); //endDate为空
define('PARK_CARD_PERMISSION_TYPE_IS_EMPTY_CODE', -1443); //授权类型为空
define('PARK_CARD_PERMISSION_TYPE_IS_ERROR_CODE', -1444); //授权类型有误
define('PARK_CARD_ISBLACK_IS_ERROR_CODE',         -1445); //isBlack规则有误

// 车(车类型和车图片、车牌所属地)
define('CAR_ID_IS_EMPTY_CODE',            -1501); //cardId为空
define('CAR_ID_IS_NOT_EXIST_CODE',        -1502); //cardId不存在
define('CAR_TYPE_ID_IS_EMPTY_CODE',       -1511); //carTypeId为空
define('CAR_TYPE_ID_IS_NOT_EXIST_CODE',   -1512); //carTypeId不存在
define('CAR_LOC_ID_IS_EMPTY_CODE',        -1521); //carLocId为空
define('CAR_LOC_ID_IS_NOT_EXIST_CODE',    -1522); //carLocId不存在
define('CAR_PHOTO_ID_IS_EMPTY_CODE',      -1531); //carPhotoId为空
define('CAR_PHOTO_ID_IS_NOT_EXIST_CODE',  -1532); //carPhotoId为空
define('CAR_NUM_IS_EMPTY_CODE',           -1541); //carNum为空
define('CAR_NUM_IS_EXIST_CODE',           -1542); //车牌已经存在
define('CAR_COLOR_IS_EMPTY_CODE',         -1543); //carColor为空
define('CAR_PARKING_PLACE_IS_EMPTY_CODE', -1544); //parkingPlace为空
define('OLD_CAR_ID_IS_EMPTY_CODE',        -1551); //oldCardId为空
define('OLD_CAR_ID_IS_NOT_EXIST_CODE',    -1552); //oldCardId不存在
define('NEW_CAR_ID_IS_EMPTY_CODE',        -1553); //newCardId为空
define('NEW_CAR_ID_IS_EXIST_CODE',        -1554); //newCardId已存在

// 用户
define('USER_ID_IS_EMPTY_CODE',         -1601); //userId为空
define('USER_ID_IS_NOT_EXIST_CODE',     -1602); //userId不存在
define('USER_NAME_IS_EXIST_CODE',       -1603); //userId已存在
define('USER_TELEPHONE_IS_EMPTY_CODE',  -1604); //telephone为空
define('USER_IDCARD_IS_EMPTY_CODE',     -1605); //idCard为空

// 岗亭
define('BOX_ID_IS_EMPTY_CODE',               -1701); //boxId为空
define('BOX_ID_IS_NOT_EXIST_CODE',           -1702); //boxId不存在
define('BOX_IP_IS_EMPTY_CODE',               -1703); //box IP不存在
define('BOX_IP_IS_ERROR_CODE',               -1704); //box IP不存在
define('BOX_IP_IS_EXIT_CODE',                -1705); //box IP不存在
define('BOX_DOOR_RIGHT_IS_EMPTY_CODE',       -1711); //boxDoorRight
define('BOX_DOOR_RIGHT_IS_ERROR_CODE',       -1712); //boxDoorRight
define('BOX_NAME_IS_EMPTY_CODE',             -1713); //boxName为空
define('BOX_NAME_IS_ERROR_CODE',             -1714); //boxName重复
define('BOX_LOCATION_IS_EMPTY_CODE',         -1715); //boxLocation为空
define('BOX_STATUS_IS_EMPTY_CODE',           -1716); //status为空
define('BOX_STATUS_IS_ERROR_CODE',           -1717); //status格式有误
define('BOX_BOX_DOOR_IS_IN_USED_CODE',       -1718); //boxDoor被使用
define('BOX_DOOR_ID_IS_EMPTY_CODE',          -1721); //boxDoorId为空
define('BOX_DOOR_ID_IS_NOT_EXIST_CODE',      -1722); //boxDoorId不存在
define('BOX_DOOR_NAME_IS_EMPTY_CODE',        -1723); //boxDoorName为空
define('BOX_DOOR_NAME_IS_ERROR_CODE',        -1724); //boxDoorName重复
define('BOX_DOOR_FUNCTION_IS_EMPTY_CODE',    -1725); //function为空
define('BOX_DOOR_FUNCTION_IS_ERROR_CODE',    -1726); //function为空
define('BOX_DOOR_TYPE_IS_EMPTY_CODE',        -1727); //type为空
define('BOX_DOOR_TYPE_IS_ERROR_CODE',        -1728); //type格式有误
define('BOX_DOOR_STATUS_IS_EMPTY_CODE',      -1729); //status为空
define('BOX_DOOR_STATUS_IS_ERROR_CODE',      -1730); //status格式有误
define('BOX_DOOR_IS_IN_USED_CODE',           -1731); //boxDoor被使用
define('BOX_COMP_ID_IS_ERROR_CODE',          -1732); //boxCompId有误
define('BOX_DOOR_IS_CHECK_IS_ERROR_CODE',    -1733); //isCheck格式有误
define('BOX_DOOR_IS_TEMP_IN_IS_ERROR_CODE',  -1734); //isTempIn格式有误
define('BOX_DOOR_IS_TEMP_OUT_IS_ERROR_CODE', -1735); //isTempOut格式有误
define('BOX_DOOR_CAR_RIGHT_IS_ERROR_CODE',   -1736); //cardRights格式有误
define('BOX_MAIN_CONTROL_MACHINE_IS_EMPTY_CODE', -1737); //cardRights格式有误
define('BOX_BARRIER_GATE_CONTROL_MACHINE_IS_EMPTY_CODE', -1738); //cardRights格式有误

/* 设备模块 */
define('DEVICE_ID_IS_EMPTY_CODE',            -1801); //deviceId为空
define('DEVICE_ID_IS_NOT_EXIST_CODE',        -1802); //deviceId不存在
define('DEVICE_ID_IS_IN_USED_CODE',          -1803); //deviceId正在使用中
define('DEVICE_NAME_IS_EMPTY_CODE',          -1804); //deviceName为空
define('DEVICE_NAME_IS_ERROR_CODE',          -1805); //deviceName重复
define('DEVICE_IP_IS_EMPTY_CODE',            -1806); //deviceIP为空
define('DEVICE_IP_IS_ERROR_CODE',            -1807); //deviceIP格式有误
define('DEVICE_IP_IS_EXIT_CODE',             -1808); //deviceIP格式有误
define('DEVICE_MAC_IS_EMPTY_CODE',           -1809); //deviceMac为空
define('DEVICE_MAC_IS_ERROR_CODE',           -1810); //deviceMac格式有误
define('DEVICE_TYPE_IS_EMPTY_CODE',          -1811); //deviceType为空
define('DEVICE_TYPE_IS_ERROR_CODE',          -1812); //deviceType格式有误

/* 出入场模块 */
define('ADMISSION_ID_IS_EMPTY_CODE',               -1901); //admissionId为空
define('ADMISSION_ID_IS_NOT_EXIT_CODE',            -1902); //admissionId不存在
define('ADMISSION_CAR_NO_IS_EMPTY_CODE',           -1903); //carNo为空
define('ADMISSION_CAR_COLOR_IS_EMPTY_CODE',        -1904); //carColor为空
define('ADMISSION_CAR_PARKCARD_IS_NOT_EXIT_CODE',  -1905); //parkcard不存在
define('ADMISSION_IP_IS_EMPTY_CODE',               -1906); //IP为空
define('ADMISSION_STATUS_IS_EMPTY_CODE',           -1907); //status为空
define('ADMISSION_ENTER_TIME_IS_EMPTY_CODE',       -1908); //enterTime为空
define('ADMISSION_EXIT_TIME_IS_EMPTY_CODE',        -1909); //exitTime为空
define('ADMISSION_CAR_NUM_IS_EMPTY_CODE',          -1910); //carNum为空

/* 配置模块 */
define('CONFIGURE_DATA_IS_EMPTY_CODE',             -2000); //configureDATA为空
define('CONFIGURE_ID_IS_EMPTY_CODE',               -2001); //configureId为空
define('CONFIGURE_ID_IS_NOT_EXIT_CODE',            -2002); //configureId不存在
define('CONFIGURE_NAME_IS_EMPTY_CODE',             -2003); //configureName为空
define('CONFIGURE_NAME_IS_NOT_EXIT_CODE',          -2004); //configureName不存在
define('CONFIGURE_VALUE_IS_EMPTY_CODE',            -2005); //configureEmpty为空
define('CONFIGURE_VALUE_IS_ERROR_CODE',            -2006); //configureError为空

/* 收费模块 */
define('PAYCONFIGURE_ID_IS_NOT_EXIST_CODE',        -2100); 
define('PAYCONFIGURE_ID_IS_EMPTY_CODE',            -2101);
define('PAYCONFIGURE_NAME_IS_EMPTY_CODE',          -2102);
define('PAYCONFIGURE_NAME_IS_EXIST_CODE',          -2103);
define('PAYRULEID_IS_EMPTY_CODE',                  -2104);
define('PAYRULEID_IS_ERROR_CODE',                  -2105);

?>
