<?php
namespace app\index\controller;
use think\Db;
use app\common\model\Tbdesk;
class TbdeskController extends IndexController{
	
	public function index(){
		$roomid = input('get.roomid');
		$pageSize = 5; // 每页显示5条数据
		$Tbdesk = new Tbdesk;
		if(!empty($roomid)){
				$Tbdesk->where('RoomID','like','%'.$roomid.'%') ;
		}
        $tbdesks = $Tbdesk->paginate($pageSize, false, [
                'query'=>[
                    'RoomID' => $roomid,
                    ],
        ]);
		//$tbdesks  = Tbdesk::paginate(5);
		$this->assign('tbdesks',$tbdesks);
		return $this->fetch();
	}
}