<?php
// 简单的原理重复记： namespace说明了该文件位于application\common\model 文件夹中
namespace app\common\model;
use think\Model;    //  导入think\Model类

  
// 我的类名叫做Tbuser，对应的文件名为Tbuser.php，该类继承了Model类，Model我们在文件头中，提前使用use进行了导入。
class Tbuser extends Model
{
	/**
     * 用户登录
     * @param  string $Name 用户名
     * @param  string $Password 密码
     * @return bool  成功返回true，失败返回false。
     */
    static public function login($username, $Password)
    {
        //验证用户是否存在
		$map = array('Name'=>$username);
		$Tbuser = self::get($map);
		if(!is_null($Tbuser)){
			if($Tbuser->checkPassword($Password)){
				//登录
				session('TbuserId',$Tbuser->getData('ID'));
				return true;
			}
		}
		
		return false;
    }
	
	 /**
     * 验证密码是否正确
     * @param  string $Password 密码
     * @return bool           
     */
    public function checkPassword($Password)
    {
		if($this->getData('Password') == $Password){
			 return true;
		 } else{
			 return false;
		 }
    }
	
	
	static public function logOut(){
		//销毁session中的数据
		session('TbuserId',null);
		return true;
	}
	
	
	/*
	* 判断用户是否已经登录
	*/
	static public function isLogin(){
		$TbuserId = session('TbuserId');
		if(isset($TbuserId)){
			return true;
		} else{
			return false;
		}
	}
}