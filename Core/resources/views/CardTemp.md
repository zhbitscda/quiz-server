### 总卡

### 查看总卡

地址：`GET` http://120.76.155.35:8080/card?id=123

#### 不带 id 参数时,获取列表

返回结果：

```
{
  "ret": 0,
  "data": [
    {
      "cardId": 卡序列号(物理号),
      "userId": 用户ID,
      "property": 属性(0-ID,1-蓝牙,2-微波,3-纯车牌),
      "deposit": 押金,
      "isUsedPark": 车场是否使用(0-未开通,1-开通), 
  	  "isUsedDoor": 门禁是否使用(0-未开通,1-开通),
  	  "isUsedCharge": 收费是否使用(0-未开通,1-开通),
      "status": 状态(0-正常,1-挂失,2-停用),
      "parkCard":{
      	  "printNo": 印刷号(通常是指印刷在卡上的信息),
	      "cardTypeId": 停车卡类型Id,
	      "cardTypeName": 停车卡类型名,
	      "times": 次数,
	      "balance": 余额,
	      "carRight": [1,2,3],
	      "isNote": 短信功能(0-关闭,1-开启),
	      "remark": 备注,
	      "carLocId": 车牌所属地Id,
	      "carLocName": 车牌所属地名称,
	      "carNum": 车牌号码,
	      "carId": 车ID,
	      "carTypeId": 车型Id,
	      "carTypeName": 车型名称,
	      "parkingPlace": 车位,
	      "carColor": 车颜色,
	      "carPhotoId": 车相片Id,
	      "carPhotoUrl": 车相片URL,
	      "beginDate": 开始使用日期,
	      "endDate": 结束使用日期
      },
      "doorCard":{} 门禁
    },
    {
      "cardId": 卡序列号(物理号),
      "userId": 用户ID,
      "property": 属性(0-ID,1-蓝牙,2-微波,3-纯车牌),
      "deposit": 押金,
      "isUsedPark": 车场是否使用(0-未开通,1-开通), 
  	  "isUsedDoor": 门禁是否使用(0-未开通,1-开通),
  	  "isUsedCharge": 收费是否使用(0-未开通,1-开通),
      "status": 状态(0-正常,1-挂失,2-停用),
      "parkCard":{
      	  "printNo": 印刷号(通常是指印刷在卡上的信息),
	      "cardTypeId": 停车卡类型Id,
	      "cardTypeName": 停车卡类型名,
	      "times": 次数,
	      "balance": 余额,
	      "carRight": [1,2,3],
	      "isNote": 短信功能(0-关闭,1-开启),
	      "remark": 备注,
	      "carLocId": 车牌所属地Id,
	      "carLocName": 车牌所属地名称,
	      "carNum": 车牌号码,
	      "carId": 车ID,
	      "carTypeId": 车型Id,
	      "carTypeName": 车型名称,
	      "parkingPlace": 车位,
	      "carColor": 车颜色,
	      "carPhotoId": 车相片Id,
	      "carPhotoUrl": 车相片URL,
	      "beginDate": 开始使用日期,
	      "endDate": 结束使用日期
      },
      "doorCard":{} 门禁
    },
    ...
  ],
  "errMsg": ""
}
```

#### 带 id 参数时,获取对应卡

返回结果：

```
{
  "ret": 0,
  "data": {
      "cardId": 卡序列号(物理号),
      "cardNo": 卡的逻辑号(仅在IC卡中出现，其他为null),
      "userId": 用户ID,
      "property": 属性(0-IC,1-ID,2-蓝牙,3-微波,4-纯车牌),
      "deposit": 押金,
      "isUsedPark": 车场是否使用(0-未开通,1-开通), 
  	  "isUsedDoor": 门禁是否使用(0-未开通,1-开通),
  	  "isUsedCharge": 收费是否使用(0-未开通,1-开通),
      "status": 状态(0-正常,1-挂失,2-停用),
      "parkCard":{
	      "printNo": 印刷号(通常是指印刷在卡上的信息),
	      "cardTypeId": 停车卡类型Id,
	      "cardTypeName": 停车卡类型名,
	      "times": 次数,
	      "balance": 余额,
	      "carRight": [1,2,3],
	      "isNote": 短信功能(0-关闭,1-开启),
	      "remark": 备注,
	      "carLocId": 车牌所属地Id,
	      "carLocName": 车牌所属地名称,
	      "carNum": 车牌号码,
	      "carId": 车ID,
	      "carTypeId": 车型Id,
	      "carTypeName": 车型名称,
	      "parkingPlace": 车位,
	      "carColor": 车颜色,
	      "carPhotoId": 车相片Id,
	      "carPhotoUrl": 车相片URL,
	      "beginDate": 开始使用日期,
	      "endDate": 结束使用日期
      }
  },
  "errMsg": ""
}
```