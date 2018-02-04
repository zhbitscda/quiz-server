<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NavigationController extends Controller
{
    public function getNavi(){
      return $this->retSuccess(json_decode($this->naviJson()));
    }

    public function naviJson(){
      $str = '
            [
              {
                "name" : "操作员管理",
                "subMenu" : [
                  {
                    "name" : "操作员用户",
                    "url"  : "Operator/operator_users.html"
                  },
                  {
                    "name" : "操作员权限",
                    "url"  : "Operator/operator_permissions.html"
                  }
                ]
              },
              {
                "name" : "卡片管理",
                "subMenu" : [
                  {
                    "name" : "卡片发行",
                    "url"  : "Card/card_issuance.html"
                  },
                  {
                    "name" : "卡片维护",
                    "url"  : "Card/card_maintenance.html"
                  }
                ]
              },
              {
                "name" : "车牌发行管理",
                "subMenu" : [
                  {
                    "name" : "车牌发行",
                    "url"  : "Car/car_issuance.html"
                  },
                  {
                    "name" : "车牌发行维护",
                    "url"  : "Car/car_maintenance.html"
                  }
                ]
              },
              {
                "name" : "车主用户管理",
                "subMenu" : [
                  {
                    "name" : "车主用户维护",
                    "url"  : "User/user_maintenance.html"
                  },
                  {
                    "name" : "批量导入导出",
                    "url"  : "User/operator_import_export.html"
                  }
                ]
              },
              {
                "name" : "设备管理",
                "subMenu" : [
                  {
                    "name" : "设备资料维护",
                    "url"  : "Device/device_maintenance.html"
                  }
                ]
              },
              {
                "name" : "岗亭管理",
                "subMenu" : [
                  {
                    "name" : "岗亭配置",
                    "url"  : "Dox/box_configuration.html"
                  },
                  {
                    "name" : "岗亭参数列表",
                    "url"  : "Dox/box_parameters.html"
                  }
                ]
              },
              {
                "name" : "车场管理",
                "subMenu" : [
                  {
                    "name" : "车场参数设置",
                    "url"  : "Park/park_configuration.html"
                  }
                ]
              },
              {
                "name" : "升级维护",
                "subMenu" : [
                  {
                    "name" : "升级维护",
                    "url"  : "UpgradeMaintenance/upgrade_maintenance.html"
                  }
                ]
              },
              {
                "name" : "数据维护",
                "subMenu" : [
                  {
                    "name" : "数据维护",
                    "url"  : "DataMaintenance/data_maintenance.html"
                  }
                ]
              },
              {
                "name" : "云平台设置",
                "subMenu" : [
                  {
                    "name" : "云平台设置",
                    "url"  : "Cloud/cloud_configuration.html"
                  }
                ]
              },
              {
                "name" : "报表管理",
                "subMenu" : [
                  {
                    "name" : "用户报表",
                    "url"  : "Report/report_users.html"
                  },
                  {
                    "name" : "卡片发行报表",
                    "url"  : "Report/report_card_maintenance.html"
                  },
                  {
                    "name" : "卡片维护报表",
                    "url"  : "Report/report_card_maintenance.html"
                  },
                  {
                    "name" : "车牌发行报表",
                    "url"  : "Report/report_car_maintenance.html"
                  },
                  {
                    "name" : "车牌维护报表",
                    "url"  : "Report/report_car_maintenance.html"
                  },
                  {
                    "name" : "进出报表",
                    "url"  : "Report/report_in_out.html"
                  },
                  {
                    "name" : "收费报表",
                    "url"  : "Report/report_charge.html"
                  },
                  {
                    "name" : "车流量报表",
                    "url"  : "Report/report_flow.html"
                  },
                  {
                    "name" : "设备运行日志报表",
                    "url"  : "Report/report_device_log.html"
                  },
                  {
                    "name" : "操作日志报表",
                    "url"  : "Report/report_operation_log.html"
                  }
                ]
              }
            ]
      ';
      return $str;
    }

}
