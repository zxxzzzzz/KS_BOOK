<?php
namespace app\index\Controller;
use app\common\model\Tbuser; 
use app\common\model\Tbdesk;
use think\Request;
use think\Db;

class BuildingController extends IndexController{

	/* public function student(){ //显示学生个人信息
		$id = Request::instance()->param('id/d');
		// 判断是否存在当前记录
        if (is_null($Tbuser = Tbuser::get($id))) {
            return $this->error('未找到ID为' . $id . '的记录');
        }
		$break = Db::query('select count(1) break from tbagainstHistory where 	userID=:id',	['id'	=>	$id] ); //查询该学生的违规次数
        $this->assign('Tbuser', $Tbuser);
		$this->assign('break',count($break));
		$UserID = $Tbuser->getData('ID');
		//未失效的预约记录
		$tborders = Db::query('select *  from Tborder where 	userID=:id', ['id' => $UserID]);
		$this->assign('tborders',$tborders);
		//$tborderhistorys  = Tborderhistory::where('UserID)->find(); //使用这种查询方法只能查询到一条数据
		//$tborderhistorys = Tborderhistory::get(['UserID' => $UserID]);
		$tborderhistorys = Db::query('select *  from Tborderhistory where 	userID=:id', ['id' => $UserID]); //已失效的预约历史记录
		$this->assign('tborderhistorys',$tborderhistorys);
		return $this->fetch();
	} */
	
	/* public function choose(){ //学生快速选座界面
	
		//$tbdesks  = Tbdesk::paginate(5);
		// 按条件查询数据并调用分页
		$id = input('get.id');
		$pageSize = 5; // 每页显示5条数据
		$Tbdesk = new Tbdesk;
		if(!empty($id)){
				$Tbdesk->where('ID','like','%'.$id.'%') ;
		}
        $tbdesks = $Tbdesk->paginate($pageSize, false, [
                'query'=>[
                    'id' => $id,
                    ],
        ]);
		
		$this->assign('tbdesks',$tbdesks);
		return $this->fetch();
	}
	 */
	public function building(){ //学生快速选座界面
	
		//$tbdesks  = Tbdesk::paginate(5);
		// 按条件查询数据并调用分页
		$id = input('get.id');
		//var_dump($id);
		
		 $sql = Db::query("SELECT  count(1) test FROM Tbdesk,Tbroom WHERE Tbroom.FloorID = :floorid and Tbdesk.RoomID = Tbroom.ID  and Tbdesk.State = 'empty' ",	['floorid'	=>	$id] );
		
		 $floor = Db::query('select * from Tbfloor where 	ID=:id',	['id'	=>	$id] );
		 $this->assign('floors',$floor);
			$this->assign('count',$sql[0]['test']);
	
		return $this->fetch();
	}
	
}
