<?php
//题单功能相关函数，add by hxh 201909

//部分代码参考my_func.inc.php

function td_check_ac( $user, $pid ) {
	//传入参数为用户和题目id
	$mysqli = $GLOBALS[ 'mysqli' ];
	$sql = "SELECT count(*) FROM `solution` WHERE `problem_id`='$pid' AND `result`='4' AND `user_id`='$user'";
	$result = mysqli_query( $mysqli, $sql );
	$row = mysqli_fetch_array( $result );
	$ac = intval( $row[ 0 ] );
	
	$sql = "SELECT * FROM `problem` WHERE `problem_id`='$pid'";
	$result = mysqli_query( $mysqli, $sql );
	$row = mysqli_fetch_array( $result );
	$tit =  $row[ 1 ] ;
	
	mysqli_free_result( $result );
	$color="";
	if ($ac>0) 
		$color="btn btn-success";
	return "<a href='problem.php?id=$pid' class='$color'>$pid<br>$tit</a>";
}
?>