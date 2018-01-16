<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
class Desk extends Controller{
    public function Desk(){
		
        return $this->fetch('desk/desk');
    }
	public function getDesk(Request $request){
		$data = $request->get()['data'];
		$count = Db::table('tbdesk')
                ->where([
		    'ID' => ['=',$data['deskid']],
		])->select();
		$count2 = Db::table('tbroom')
                ->where([
		    'ID' => ['=',$count[0]['RoomID']],
		])->select();
		$count3 = Db::table('tborder')
                ->where([
		    'DeskID' => ['=',$data['deskid']],
		])->select();
		
		$returnme = $count[0];
		$returnme['RoomName'] = $count2[0]['Name'];
		$returnme['Deadline'] = '永久';
		if(count($count3) > 0){
			$returnme['Deadline'] = $count3[0]['Deadline'];
		}
		return json($returnme);
	}
	public function qiandao(Request $request){
		$data = $request->get()['data'];
		$count = Db::table('tbdesk')
                ->where([
		    'ID' => ['=',$data['deskid']],
		])->select();
		if($count[0]['State'] != 'empty'){
			return json(['state'=>'error','message'=>'该桌子已被使用']);
		}
		else{
			Db::table('tbdesk')
				->where([
					'ID' => ['=',$count[0]['ID']],
			])->update(['State'=>'using','UserID'=>$data['userid']]);
			return json(['state'=>'ok','message'=>'可以开始使用','deadline'=>'永久']);
		}
	}
	public function yuyue(Request $request){
		$data = $request->get()['data'];
		$count = Db::table('tbdesk')
                ->where([
		    'ID' => ['=',$data['deskid']],
		])->select();
		if($count[0]['State'] != 'empty'){
			return json(['state'=>'error','message'=>'该桌子已被使用']);
		}
		else{
			Db::table('tbdesk')
				->where([
					'ID' => ['=',$count[0]['ID']],
			])->update(['State'=>'ordering','UserID'=>$data['userid']]);
			Db::table('tborder')	
			->insert(['UserID'=>$data['userid'],'Time'=>$data['time'],'Deadline'=>$data['deadline'],'DeskID'=>$data['deskid']]);
			return json(['state'=>'ok','message'=>'已预约','deadline'=>$data['deadline']]);
		}
	}
	public function qiantui(Request $request){
		$data = $request->get()['data'];
		$count = Db::table('tbdesk')
                ->where([
		    'ID' => ['=',$data['deskid']],
		])->select();
		if($count[0]['State'] == 'empty'){
			return json(['state'=>'error','message'=>'该桌子无人使用']);
		}
		if($count[0]['UserID'] != $data['userid']){
			return json(['state'=>'error','message'=>'你不是该桌子的所有者，无法签退']);
		}
		else{
			Db::table('tbdesk')
				->where([
					'ID' => ['=',$count[0]['ID']],
			])->update(['State'=>'empty','UserID'=>$data['userid']]);
			$dborder = Db::table('tborder')
				->where([
					'UserID' => ['=',$data['userid']],
			])->select();
			Db::table('tborder')
				->where([
					'UserID' => ['=',$data['userid']],
			])->delete();
			if(count($dborder)>0){
				Db::table('tborderhistory')
				->insert($dborder[0]);
			}
			
			return json(['state'=>'ok','message'=>'已签退','deadline'=>'无']);
		}
	}
	public function zanli(Request $request){
		$data = $request->get()['data'];
		$count = Db::table('tbdesk')
                ->where([
		    'ID' => ['=',$data['deskid']],
		])->select();
		if($count[0]['State'] != 'using'){
			return json(['state'=>'error','message'=>'该桌子的没有在使用，无法暂离']);
		}
		if($count[0]['UserID'] != $data['userid']){
			return json(['state'=>'error','message'=>'你不是该桌子的所有者，无法暂离']);
		}
		else{
			Db::table('tbdesk')
				->where([
					'ID' => ['=',$data['deskid']],
			])->update(['State'=>'leaving','UserID'=>$data['userid']]);
			Db::table('tborder')
				->insert(['UserID'=>$data['userid'],'Time'=>$data['time'],'Deadline'=>$data['deadline'],'DeskID'=>$data['deskid']]);
			return json(['state'=>'ok','message'=>'已暂离','deadline'=>$data['deadline']]);
		}
	}
	
}
