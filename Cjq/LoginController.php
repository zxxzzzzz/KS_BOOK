<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use app\common\model\Tbuser; //教师模型
use think\Db;
class LoginController extends Controller{
	//用户登录表单
	public function index(){
		return $this->fetch();
	}
	
	//处理用户提交的登录数据
	public function login(){
		$postData = Request::instance()->post();
		//直接调用M层方法，进行登录
		
		//重复登录查询 和黑名单查询 后加
   // $servername = "localhost";
     //   $Name = "username";
      //  $Password = "password";
        //$dbname = "myDB";
		/*Tbuser::login($postData['Name'],$postData['Password']);
		$sql = "select Online from Tbuser where Name = '$Name' and password = '$Password'";
		$bla = "select BlackList from Tbuser where Name = '$Name' and password = '$Password' ";
		if(sql<>‘no’|bla <>‘no’)
		        return $this->error('Please use another account,You are in the blacklist or you are already online',url('login/index'));
		
		*/
		//
		
		if(Tbuser::login($postData['Name'],$postData['Password'])){
			//跳转的网址不对，之后再进行修
			$sql='no';
			$bla='no';
		
			$name = $postData['Name'];
			$password = $postData['Password'];
			$result = Db::query("select COUNT(1) judge from tbuser where Name =:name and Password =:password and BlackList = 'no' and Online = 'no'",['name'=>$name,'password' =>$password]);
			if($result[0]['judge'] > 0){
				$result1 = Db::table('tbuser ')
							->where('Name',	$name)
							->update(['Online'	=>	"yes"]);
							return $this->success('login success',url('Index/index'));
				
			
			}else{
				return $this->error('Please use another account,You are in the blacklist or you are already online',url('login/index'));
				
			
			}
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