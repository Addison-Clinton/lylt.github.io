<?php
namespace user{
require_once 'fdb.php';
require_once 'test.php';
require_once 'tool.php';
	function userdb(){
		return new \fdb\fdb('user');
	}
	function login($username,$password){
		$loginset=userdb()->getset('login');
		$truepassword=$loginset->getdat($username,'password');
		if($truepassword==$password){
			$loginstatus=\tool\randomstring(64);
			$loginset->setdat($username,'logintime',\date('y-m-d h:i:sa'));
			$loginset->setdat($username,'loginstatus',$loginstatus);
			return $loginsyatus;
		}else{return false;}
	}
	function uid($username,$password){
		$login=userdb()->getset('login');
		if($login->getdat($username,'password')==$password){
			return $login->getdat($username,'uid');
		}
	}
	function logon($username,$password){
		$userdb=userdb();
		$uid=\tool\randomstring(64);
		$login=$userdb->getset('login');
		if($login->getdat($username,'uid')){
			return false;
		}
		while($login->getdat($username,'uid')){
			$uid=\tool\randomstring(64);
		}
		$login->setdat($username,'uid',$uid);
		$login->setdat($username,'password',$password);
		$userdb->setdat('uid',$uid,'username',$username);
	}
	function check($username,$loginstatus){
		return $loginstatus==userdb()->getdat('login',$username,'loginstatus');
	}
	function is_user($username,$uid){
		return $username==userdb()-getdat('uid',$uid,'username');
	}
}
?>