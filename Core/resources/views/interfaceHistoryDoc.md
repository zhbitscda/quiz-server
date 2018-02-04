接口更新说明文档
----

日期           | 具体说明
------------- | -------------
2016-07-10    | 修改用户查询接口(新增部门查询)； <br> 新增用户模块获取部门数据接口。 
2016-06-24    | 完善岗亭模块接口 加入 `isCheck`, `isTempIn` , `isTempOut`, `cardRights` 字段。 
2016-06-20    | 初定岗亭模块接口和设备接口。 
2016-06-18    | 1. 车卡添加搜索功能; <br> 2. 新增换卡接口。 
2016-06-13    | 1. 车卡模块中所有的 `boxRight` 改为 `boxDoorsRight` 因为卡是对应岗亭口不是岗亭；<br>2. 新增获取岗亭口(在岗亭模块中可查看)接口；<br> 3. 获取发行需要的数据接口改为 `value` 和 `name` 的形式，并增加了 `所有月卡的类型` 和 `停车卡的状态`；<br> 4. 查看车辆信息接口新增通告车牌获取车辆信息；<br> 5. 完善 `岗亭口` 接口。
2016-06-10    | 添加分页功能，如果单单带有page参数默认获取15条数据, 如果还带有perPage参数可以规定获取的条数。
2016-06-06    | 1. 车卡模块中去掉所有接口的 `cardNo` 参数(不需要做IC卡了); <br> 2. 车卡模块中 `parkCardTypeName` 改为 `cardTypeId`; <br> 3. 车卡模块 `POST` 请求参数，改为如果车牌存在则传 `carId` ,不存在则不用传; <br> 4. 车卡模块 `carType` 改为 `carTypeId`; <br> 5. 车卡模块新增接口 添加 `carLocId`(车牌所属地Id); <br> 6. 车卡模块新增接口 的`carType` 改为 `carTypeId`; <br> 7. 新增 `获取发行需要的数据` 接口; <br> 8. 暂时删除总卡的接口。
2016-06-03    | 用户模块查看未派发车卡用户接口。
2016-06-02    | 初步完成车卡模块接口,车辆模块查看接口。
2016-05-29    | 统一接口字段 `createdData` 改为 `createdDate`, 统一接口字段 `updatedData` 改为 `updatedDate`, 并且由时间戳统一改为 `Y-m-d H:i:s` 格式(即2016-01-01 10:00:00)。
2016-05-28    | 1. 权限相关接口(查看角色接口、权限查看接口、操作者登录接口)新增 `parentId` 接口；<br> 2. 新增角色接口响应新增返回roleId；<br> 3. 新增操作者接口响应新增返回operatorId。
2016-05-27    | 初步完成角色模块、操作者模块、权限模块接口。


