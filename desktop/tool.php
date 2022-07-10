<?php
namespace tool;
function randomstring($length){
	$allchars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$rel='';
	for($i=0;$i<$length;++$i){
		$a=\rand(0,61);
		$rel.=$allchars[$a];
	}
	return $rel;
}
?>