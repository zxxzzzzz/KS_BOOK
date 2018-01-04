<?php
namespace app\index\controller;
use app\common\model\Login;
class Login{
	public function index(){
		$Login = new Login;
		dump($Login);
	}
}