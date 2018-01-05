<?php
namespace app\index\Controller;
use app\common\model\Tbuser; 
use app\common\model\Tbdesk;
use think\Request;
use think\Db;

class StudentController extends IndexController{

	public function student(){ //显示学生个人信息
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
	}
	
	public function choose(){ //学生快速选座界面
	
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
	
	public function chooseseat(){
		$id = Request::instance()->param('id/d'); //获取学生id
		 if (is_null($Tbuser = Tbuser::get($id))) {
            return $this->error('未找到ID为' . $id . '的记录');
        }
		$UserID = $Tbuser->getData('ID');
		//找出选座历史里面该学生的选座信息，选他最常去的座位
		//如果他没有选座的经历，就随便选一个座给他就好了
		$num = Db::query("SELECT 
					m.deskID,l.State
				FROM
					(SELECT 
						s.deskID
					FROM
						Tborderhistory s
					WHERE
						s.UserID = :id
					GROUP BY s.DeskID
					ORDER BY COUNT(s.deskID) DESC) m left join tbdesk l  on m.DeskID = l.ID 
					 where l.State = 'empty' and l.UserID = 0 limit 0,1" , ['id'	=>	$UserID]);
		if(empty($num)){
			//随便选一个座
			$num = Db::query("select ID deskID,State from tbdesk where state ='empty' order by id desc limit 0,1");
		}
		if( !empty($num)){
			$deskID = $num[0]['deskID'];
		
			//将选择的座位设置为ordering，并向预约表当中插入数据
			
			$result1 = Db::table('tbdesk')
							->where('ID',	$deskID)
							->update(['State'	=>	"ordering",'UserID'	=>	$UserID]);
			$time1 = date('Y-m-d H:i:s');
			$result2	=	Db::table('tborder')->insert(['UserID'	=>	$UserID,'DeskID' => $deskID,'Time' => $time1 ]);
			return $this->success('选座成功！',url('student/student'));
		} else{
			return $this->error('选座失败，请重新选择',url('student/choose'));
		}
		
	}
	
	
	public function save(){ //用户直接选择座位
		$id = session('TbuserId'); //当前用户的id存储在了session当中
		if (is_null($Tbuser = Tbuser::get($id))) {
            return $this->error('未找到ID为' . $id . '的记录');
        }
		$deskID = Request::instance()->param('deskid/d'); //座位id
		$RoomID = Request::instance()->param('RoomID/d'); //楼层id
		$State = Request::instance()->param('State'); //状态
		if($State != "empty"){
			return $this->error("该座位已有人选择，请重新预订",url('student/choose'));
		}
		
		$result1 = Db::table('tbdesk')
							->where('ID',	$deskID)
							->update(['State'	=>	"ordering",'UserID'	=>	$id]);
		$time1 = date('Y-m-d H:i:s');
		$result2	=	Db::table('tborder')->insert(['UserID'	=>	$id,'DeskID' => $deskID,'Time' => $time1 ]);
		$result3	=	Db::table('TBOrderHistory')->insert(['UserID'	=>	$id,'DeskID' => $deskID,'Time' => $time1 ]);
		if( $result1 && $result2 && $result3){
			return $this->success('选座成功！',url('student/student'));
		} else{
			return $this->error('选座失败，请重新选择',url('student/choose'));
		}
	}
	
	public function unchoose(){ //学生取消选座
		$id = session('TbuserId'); //当前用户的id存储在了session当中
		if (is_null($Tbuser = Tbuser::get($id))) {
            return $this->error('未找到ID为' . $id . '的记录');
        }
		$deskID = Request::instance()->param('deskid/d'); //座位id
		$UserID = Request::instance()->param('userid/d'); //用户id
		if($UserID != $id){
			$this->error("该座位不是你选择的座位，无法取消！",url('student/choose'));
		}
		
		$result1 = Db::table('tbdesk')
							->where('ID',	$deskID)
							->update(['State'	=>	"empty",'UserID'	=>	0]);
		$time1 = date('Y-m-d H:i:s');
		$result2 = Db::table('tborder')
							->where('UserID',	$id)
							->update(['Deadline'	=>$time1]);
		//插入数据到历史 表
		$result3	=	Db::table('TBOrderHistory')
							->where('UserID',	$id)
							->update(['Deadline'	=>$time1]);
		if( $result1 && $result2 && $result3){
			return $this->success('取消成功',url('student/student'));
		} else{
			return $this->error('取消失败，请稍后重试！',url('student/choose'));
		}
	}
}
