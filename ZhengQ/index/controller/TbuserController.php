<?php
namespace app\index\controller;
use think\Db;
use app\common\model\Tbuser;
class TbuserController{
	
	public function index(){
		$Tbuser = new Tbuser;
        $tbusers = $Tbuser->select();
		
		//获取第0个数据
		$tbuser = tbusers[0];
		var_dump($tbuser->getData());
	}
}