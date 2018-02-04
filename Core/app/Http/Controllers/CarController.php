<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Operator;
use App\Models\Card;
use App\Models\ParkCard;
use App\Models\ParkCardType;
use App\Models\Box;
use App\Models\Car;
use App\Models\CarLocation;
use App\Models\CarPhoto;
use App\Models\CarType;

class CarController extends Controller
{

//------------------- READ ---------------------------

  /* 读操作 */
  public function read(Request $request)
  {
    if($request->has('id')){
      /* 带参数时,获取单个数据 */
      // 获取参数
      $id = $request->get("id");
      return $this->getInfo($id);
    }else{
      /* 带参数时,获取列表 */
      $page    = $request->input('page');
      $perPage = $request->input('perPage');
      return $this->getList($page, $perPage);
    }
  }

  /* 获取单个操作者通过ID   TODO delete location*/
  // public function getInfoByCarNum($carLocId, $carNum)
  // {
  //   // 查找该ID的对象是否存在
  //   if(!$carObject = Car::where('locationId', $carLocId)->where('number', $carNum)->first()){
  //     return $this->retSuccess();
  //   }else{
  //     // 组装数据
  //     $data = array(
  //       'carId'        => $carObject['id'],
  //       'carLocId'     => $carObject['locationId'],
  //       'carLocName'   => $carObject->location['name'],
  //       'carNum'       => $carObject['number'],
  //       'carType'      => $carObject['type'],
  //       'parkingPlace' => $carObject['parkingPlace'],
  //       'carColor'     => $carObject['color'],
  //       'carPhotoId'   => $carObject['photoId'],
  //       'carPhotoUrl'  => $carObject->photo['url'],
  //       'created_at'   => date("Y-m-d H:i:s",strtotime($carObject['created_at'])),
  //       'updated_at'   => date("Y-m-d H:i:s",strtotime($carObject['updated_at']))
  //     );
  //     return $this->retSuccess($data);
  //   }
  // }

  /* 获取单个操作者通过ID   TODO delete location*/
  public function getInfoByCarNum($carNum)
  {
    // 查找该ID的对象是否存在
    if(!$carObject = Car::where('number', $carNum)->first()){
      return $this->retSuccess();
    }else{
      // 组装数据
      $data = array(
        'carId'        => $carObject['id'],
        'carNum'       => $carObject['number'],
        'carType'      => $carObject['type'],
        'parkingPlace' => $carObject['parkingPlace'],
        'carColor'     => $carObject['color'],
        'carPhotoId'   => $carObject['photoId'],
        'carPhotoUrl'  => $carObject->photo['url'],
        'created_at'   => date("Y-m-d H:i:s",strtotime($carObject['created_at'])),
        'updated_at'   => date("Y-m-d H:i:s",strtotime($carObject['updated_at']))
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取单个操作者通过ID */
  public function getInfo($id)
  {
    // 查找该ID的对象是否存在
    if(!$carObject = Car::find($id)){
      return $this->retError(CAR_ID_IS_NOT_EXIST_CODE, CAR_ID_IS_NOT_EXIST_WORD);
    }else{
      // 组装数据
      $data = array(
        'carId'        => $carObject['id'],
        // TODO delete locationInfo
        // 'carLocId'     => $carObject[''],
        // 'carLocName'   => $carObject->location['name'],
        'carNum'       => $carObject['number'],
        'carType'      => $carObject['type'],
        'parkingPlace' => $carObject['parkingPlace'],
        'carColor'     => $carObject['color'],
        'carPhotoId'   => $carObject['photoId'],
        'carPhotoUrl'  => $carObject->photo['url'],
        'created_at'   => date("Y-m-d H:i:s",strtotime($carObject['created_at'])),
        'updated_at'   => date("Y-m-d H:i:s",strtotime($carObject['updated_at']))
      );
      return $this->retSuccess($data);
    }
  }

  /* 获取权限列表 */
  public function getList($page, $perPage)
  {
    if($page){
      $carList = Car::where('id', '>', 0)->paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => Car::all()->count()-1,
        'perPage'     => $carList->perPage(),
        'currentPage' => $carList->currentPage(),
        'lastPage'    => $carList->lastPage(),
        'nextPageUrl' => $carList->nextPageUrl() == null ? null : $carList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $carList->previousPageUrl() == null ? null : $carList->previousPageUrl() . $perPagePan,
      );
    }else{
      $carList = Car::where('id', '>', 0)->get();
    }
    $data = array();
    foreach ($carList as $carObject) {
      // 组装数据
      $data[] = array(
        'carId'        => $carObject['id'],
        // TODO delete locationInfo
        // 'carLocId'     => $carObject['locationId'],
        // 'carLocName'   => $carObject->location['name'],
        'carNum'       => $carObject['number'],
        'carType'      => $carObject['type'],
        'parkingPlace' => $carObject['parkingPlace'],
        'carColor'     => $carObject['color'],
        'carPhotoId'   => $carObject['photoId'],
        'carPhotoUrl'  => $carObject->photo['url'],
        'created_at'   => date("Y-m-d H:i:s",strtotime($carObject['created_at'])),
        'updated_at'   => date("Y-m-d H:i:s",strtotime($carObject['updated_at']))
      );
    }
    return $this->retSuccess($data, $page);
  }


  //------------------- search ---------------------------
  public function search(Request $request){

    $carList = Car::where('id', '>', 0);

    // TODO delete locationId

    // $carList = Car::leftJoin('carLocations', 'cars.locationId', '=', 'carLocations.id');

    // if($request->has('carLocId')){
    //   $carLocId = $request->input('carLocId');
    //   $carList = $carList->where('locationId', 'like', "%$carLocId%");
    // }else{
    //   $carLocId = null;
    // }

    if($request->has('carNum')){
      $carNum = $request->input('carNum');
      $carList = $carList->where('number', 'like', "%$carNum%");
    }else{
      $carNum = null;
    }

    $page    = $request->input('page');
    $perPage = $request->input('perPage');

    if($page){
      // 生成对象
      $count = $carList->count();
      $carList = $carList->paginate($perPage);
      if($perPage){
        $perPagePan = "&perPage=" . $perPage;
      }else{
        $perPagePan = "";
      }
      // 分页信息
      $page = array(
        'total'       => $count,
        'perPage'     => $carList->perPage(),
        'currentPage' => $carList->currentPage(),
        'lastPage'    => $carList->lastPage(),
        'nextPageUrl' => $carList->nextPageUrl() == null ? null : $carList->nextPageUrl() . $perPagePan,
        'prevPageUrl' => $carList->previousPageUrl() == null ? null : $carList->previousPageUrl() . $perPagePan,
      );
    }else{
      $carList = $carList->get();
    }

    $data = array();
    foreach ($carList as $carObject) {
      // 组装数据
      $data[] = array(
        'carId'        => $carObject['id'],
        // TODO delete locatinInfo
        // 'carLocId'     => $carObject['locationId'],
        // 'carLocName'   => $carObject->location['name'],
        'carNum'       => $carObject['number'],
        'carType'      => $carObject['type'],
        'parkingPlace' => $carObject['parkingPlace'],
        'carColor'     => $carObject['color'],
        'carPhotoId'   => $carObject['photoId'],
        'carPhotoUrl'  => $carObject->photo['url'],
        'created_at'   => date("Y-m-d H:i:s",strtotime($carObject['created_at'])),
        'updated_at'   => date("Y-m-d H:i:s",strtotime($carObject['updated_at']))
      );
    }
    return $this->retSuccess($data, $page);
  }

}
