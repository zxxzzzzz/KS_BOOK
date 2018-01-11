<?php
namespace app\index\Controller;
use think\Controller;
use think\Db;
use think\Request;
class InformationController extends Controller{
	public function floor(Request $request){
		//连接微信楼层规则
		$floorid = $request->get()['floorid'];//$_GET['floorid']; //利用获取到的floorid查询楼层信息
		$result = Db::query("select Name,ID,OpenDay,OrderDay,LeaveLength from tbfloor where id =:id" ,[ 'id' => $floorid]);
		//$result = Db::query("select Name,OpenDay,OrderDay,OrderEndTime from tbfloor where id =1" );
		//上面这样查询得到的结果是一个数组
		/*$result = Db::table('tbfloor')
					->where('ID',$floorid)
					->select(); //这种方法得到的也是数组*/
		//var_dump($result[0]['Name']);
		//$result2 = json_encode(array('Name'=>$result[0]['Name']));
		//$result2 = json_encode($result);
		//var_dump($result);
		//var_dump($result[0]['Name'] );
		//$a = $result[0]['Name'] ." ".$result[0]['OpenDay'] ." ". $result[0]['OrderDay'] ." ". $result[0]['OrderEndTime'];
		//var_dump(json(['Name'=>$result[0]['Name']]));
		//return json(['Name'=>$result[0]['Name'],'OpenDay'=>$result[0]['OpenDay'],'OrderDay'=>$result[0]['OrderDay'], 'OrderEndTime'=>$result[0]['OrderEndTime'] ]);
		return json($result);
	}
	
	public function room(){
		//连接微信教室规则
		$roomid = $_GET['roomid']; //利用获取到的floorid查询楼层信息
		$result = Db::query("select * from tbroom where id =:id" ,[ 'id' => $roomid]);
		return json($result);
	}
	
	public function desk(){
		//连接微信座位规则
		$deskid = $_GET['deskid']; //利用获取到的floorid查询楼层信息
		$result = Db::query("select * from tbdesk where ID =:id" ,[ 'id' => $deskid]);
		return json($result);
	}
	
	/*public function rule(){
		//连接微信管理信息
		$judge = $_GET['judge'];
		if($judge =="1"){
			//按阅览室规则查询
			$result = DB::query("select * from tbroom order by id asc");
		} else{
			$result = DB::query("select * from tbfloor order by id asc");
		}
		var_dump($result);
	}*/
}