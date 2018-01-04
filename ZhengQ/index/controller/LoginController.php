<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use app\common\model\Tbuser; //教师模型
class LoginController extends Controller{
	//用户登录表单
	public function index(){
		return $this->fetch();
	}
	
	//处理用户提交的登录数据
	public function login(){
		$postData = Request::instance()->post();
		//直接调用M层方法，进行登录
		if(Tbuser::login($postData['Name'],$postData['Password'])){
			//跳转的网址不对，之后再进行修改
			return $this->success('login success',url('Index/index'));
		}else{
			return $this->error('Name or password incorrent',url('login/index'));
		}
	}
	
	//注销
	public function logOut(){
		if(Tbuser::logOut()){
			return $this->success('logout success',url('index'));
		} else{
			return $this->error('logout error',url('index'));
		}
	}
}