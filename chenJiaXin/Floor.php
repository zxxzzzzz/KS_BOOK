<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
class Floor extends Controller{
    public function floor(Request $request){
		$data = $request->get();
		if(!array_key_exists('userid',$data)){
			return 'url没userid';
		}
		if(!array_key_exists('floorid',$data)){
			return 'url没floorid';
		}
		if(array_key_exists('mode',$data)){
			if($data['mode'] == 'get'){
				$dbdata = Db::table('tbroom')
				->where([
					'FloorID' => ['=',$data['floorid']],
				])
				->select();
				return json($dbdata);
			}
		}
		$userid = $data['userid'];
		$floorid = $data['floorid'];
		return $this->fetch('floor/floor');
		
    }
	public function getfloor(Request $request){
		$data = Db::table('tbroom')
		->where([
			'FloorID' => ['=',$request->get()['floorid']],
		])
		->select();
		return json($data);
	}
	public function doLogin(Request $request){
		$data = $request->post()['data'];
		$count = Db::table('tbuser')
        ->where([
		    'Name' => ['=',$data['Name']],
			'Password' => ['=', $data['Password']]
		])->count();
		if($count == 1){ //用户存在,且密码正确
			return json(['state'=>'ok','jump'=>'http://localhost//tp5/public/index/login/login']);
		}
		else{
			$count = Db::table('tbuser')
            ->where([ //仅用户存在
		        'Name' => ['=',$data['Name']] 
		    ])->count();
			if($count == 1){
				return json(['state'=>'error','message'=>'wrong password']);
			}
			else{
				return json(['state'=>'error','message'=>'no this user']);
			}
			
		}
	}
}
