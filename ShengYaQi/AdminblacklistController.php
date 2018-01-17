<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use app\common\model\Tbdesk;
use think\Request;
class AdminblacklistController extends Controller { //之后汇总的时候在继承IndexController
	
	public function blacklist(){
		$lists = Db::query("select ID,Name from Tbuser where blacklist = 'yes'");
		//var_dump($lists);
		$this->assign('lists',$lists);
		$users = Db::query("select * from Tbuser ");
		$this->assign('users',$users);
		return $this->fetch();
	}

	public function history(){
		$users = Db::query("select u.Name,t.* from TborderHistory t left join tbuser u on t.UserID = u.ID ");
		$this->assign('users',$users);

		$agaistusers = Db::query("select u.Name,t.* from TbagainstHistory t left join tbuser u on t.UserID = u.ID ");
		$this->assign('agaistusers',$agaistusers);
		return $this->fetch();
	}
	
	public function dooption(Request $request){
		
		$select  = $request->get()['select'];
		$UserID  = $request->get()['UserID'];
		if($select == "删除"){
			//删除用户黑名单
				$result1 = Db::table('Tbuser')
							->where('ID',	$UserID)
							->update(['BlackList'	=>	'no']);
				$result2 = Db::execute("delete from TbagainstHistory where UserID=:userid",['userid'=>2]);
				if( $result1 && $result2){
					return $this->success('删除成功',url('Adminblacklist/blacklist'));
				} else{
					return $this->error('删除失败，请重新删除',url('Adminblacklist/blacklist'));
				}
				
		}else if($select == "添加"){
			
		//将用户插入黑名单
			$deskID  = $request->get()['deskID'];
			$Detail  = $request->get()['Detail'];
			$Score  = $request->get()['Score'];
			$time1 = date('Y-m-d H:i:s');
			$result1 = Db::table('Tbuser')
							->where('ID',	$UserID)
							->update(['BlackList'	=>	'yes']);
			$result2 = Db::name('Tbagainsthistory')
						->insert(['UserID'	=>	$UserID,	'DeskID'	=>	$deskID,'Detail' => $Detail,'Score' => $Score,'Time'=>$time1]);
				if( $result1 && $result2){
					return $this->success('添加成功',url('Adminblacklist/blacklist'));
				} else{
					return $this->error('添加失败，请重新删除',url('Adminblacklist/blacklist'));
				}
		}
	}
	
}