<?php
namespace app\index\Controller;
use app\common\model\Tbuser; 
use app\common\model\Tbdesk;
use think\Request;
use think\Db;
use think\Response;
use think\Controller;
class Student1Controller extends Controller{
	//接收从微信断传过来的数据：签离
	public function getOver(){  //数据出错校验之后添加
		
		
		$time = $_GET['key'];
		$deadline = $_GET['deadline'];
		
		/*$result = Db::table('Tbuser')
		->insert(['Time'=>$time,'Deadline' =>$deadline,'Online'  => 'no' ]);*/
		
		$result1 = Db::name('Tbuser')
		->where ('id',11)
		->update(['Online'  => 'no' ]);//人下线
		
		$result2 = Db::name('Tbdesk')
		->where ('id',2)
		->update (['State' => 'empty']);//桌子状态设置为空
		
		//删除当前表的内容，插入数据到历史表
		$result3	=	Db::table('TBOrderHistory')
							->insert(['Deadline'=>$deadline,'Time' =>$time]); //还需要插入用户id
							
		$result4	=	Db::table('TBOrder')
							->where('UserID',	11)
							->delete();
		
		/*var_dump($result1); //事物回滚测试失败，之后再进行测试
		var_dump($result2);
		var_dump($result3);
		var_dump($result4);
		console.log($resul1t);*/
	}
	
	public function getOut(Request $request){//接收微信小程序传递过来的数据，暂离
		$DeskID = $request->get()['deskid'];
		$Time = $request->get()['time'];
		$ID = $request->get()['userid'];
		$Deadline = $request->get()['deadline'];
		
		//这句话之后要传入用户id
		$result = Db::query("select COUNT(1) judge from tbuser where  Online = 'yes' and ID=:id ",['id' =>$ID]);
		if($result[0]['judge'] > 0){
				$result1 = Db::table('tbuser ')
							->where('ID',	$ID)
							->update(['Online'	=>	"no"]);
				$result2 = Db::execute("update tbdesk set State = 'leaving' where ID=:id",['id'=> $DeskID]);
				$result3 = Db::execute("update tborder set deadline =:deadline where ID=:id and deskID=:deskid",['id'=> $DeskID,'deadline' => $Deadline,'deskid'=>$DeskID]);
				var_dump($result1);
				var_dump($result2);
				var_dump($result3);
				return json(['result' => 'success']);
		}
		
		return json(['result' => 'fail']);
	}
	
	public function getin(Request $request){//接收微信小程序传递过来的数据，登录
		$Name = $request->get()['Name'];
		$DeskID = $request->get()['DeskID'];
		$Password = $request->get()['Password'];
		$ID = $request->get()['ID'];
		
		//更新用户表的在线状态
		//更新课桌表的使用状态
		$result = Db::query("select COUNT(1) judge from tbuser where Name =:name and Password =:password and BlackList = 'no' and Online = 'no'",['name'=>$Name,'password' =>$Password]);
		if($result[0]['judge'] > 0){
				$result1 = Db::table('tbuser ')
							->where('Name',	$Name)
							->update(['Online'	=>	"yes"]);
				$result2 = Db::execute("update tbdesk set State = 'using' where ID=:id",['id'=> $DeskID]);
				var_dump($result1);
				var_dump($result2);
				return json(['result' => 'success']);
		}
		
		return json(['result' => 'fail']);
	}
	
	public function sendover(Request $request){ //向微信小程序端传递信息 ,需引入think\Response
		//先获取签到的时间传递到前台
		$id= $request->get()['id'];
		$result = Db::query('select Time from tborder where 	userID=:id',	['id'	=>	$id] );
		return json($result);
	}
}