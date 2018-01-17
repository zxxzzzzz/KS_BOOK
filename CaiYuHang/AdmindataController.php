<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class AdmindataController extends Controller	
{
public function MostReServedRoom()
{
	$ret=Db::table('tbroom')->field('count(tbdesk.RoomID),tbroom.Name,tbdesk.RoomID,tborderhistory.DeskID')->join('tbdesk','tbdesk.RoomID=tbroom.ID')->join('tborderhistory','tborderhistory.DeskID=tbdesk.ID')->group('tbdesk.RoomID')->order('count(tbdesk.RoomID) desc')->limit('5')->select();
		$this->assign('tbitems',$ret);
	return $this->fetch();
}
public function StudentAppointMost()
{
	$ret=Db::table('tborderhistory')->field('tborderhistory.UserID,tbuser.Name,count(tborderhistory.UserID)')->group('tborderhistory.UserID')->join('tbuser','tbuser.ID=tborderhistory.UserID')->order('count(tborderhistory.UserID) desc')->limit('5')->select();
	$this->assign('tbitems',$ret);
	return $this->fetch();
}
public function StudentDefaultMost()
{
	$ret=Db::table('tbagainsthistory')->field('tbagainsthistory.UserID,tbuser.Name,count(tbagainsthistory.UserID)')->group('tbagainsthistory.UserID')->join('tbuser','tbuser.ID=tbagainsthistory.UserID')->order('count(tbagainsthistory.UserID) desc')->limit('5')->select();
	$this->assign('tbitems',$ret);
	return $this->fetch();
}
public function MostBeachedSeat(){
	$ret=Db::table('tbagainsthistory')->field('RoomID,tbroom.Name,count(tbagainsthistory.DeskID),tbdesk.ID')->group('tbagainsthistory.DeskID')->join('tbdesk','tbdesk.ID=tbagainsthistory.DeskID')->join('tbroom','tbdesk.RoomID=tbroom.ID')->order('count(tbagainsthistory.DeskID) desc')->limit('5')->select();
	$this->assign('tbitems',$ret);
	return $this->fetch();
}
public function MostPopularSeat(){
	$ret=Db::table('tborderhistory')->field('RoomID,tbroom.Name,count(tborderhistory.DeskID),tbdesk.ID')->group('tborderhistory.DeskID')->join('tbdesk','tbdesk.ID=tborderhistory.DeskID')->join('tbroom','tbdesk.RoomID=tbroom.ID')->order('count(tborderhistory.DeskID) desc')->limit('5')->select();
	$this->assign('tbitems',$ret);
	return $this->fetch();
}


}