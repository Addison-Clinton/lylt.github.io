<?php
require_once 'user.php';
require_once 'fdb.php';
$uid='';
$deskid=$_POST['deskid'];
$desktopdb= new \fdb\fdb('desktop');
$return=array();
switch($_POST['type']){
	case 'login':
	$uid=\user\uid($_POST['username'],$_POST['password']);
	$return['uid']=$uid;
	break;
	case 'get':
	$uid=$_POST['uid'];
}
$iconlist=$desktopdb->getdat('iconlist',$uid,$deskid);
if(!$iconlist){
	$iconlist='[{"name":"file","pageName":"Directory","url":"http://127.0.0.1:81/file.html","type":"image","iconUrl":"icon/folder.png"}]';
	$desktopdb->setdat('iconlist',$uid,$deskid,$iconlist);
}
$return['iconList']=json_decode($iconlist);
echo json_encode($return);
?>