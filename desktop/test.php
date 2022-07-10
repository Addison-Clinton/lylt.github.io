<?php
function echoArray($arr){
	foreach($arr as $key =>$val){
		echo'['.$key.']'.'=>';
		if(is_array($val)){
			echo '{';
			echoArray($val);
			echo '}';
		}else{
			echo $val.' ';
		}
	}
}
?>