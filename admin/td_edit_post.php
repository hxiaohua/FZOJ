<?php


require_once( "admin-header.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) || isset( $_SESSION[ 'problem_editor' ] ) ) ) {
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit( 1 );
}
require_once( "../include/db_info.inc.php" );

var_dump( $_POST );

if ( isset( $_POST[ 'tidan' ] ) ) {

	$tid = $_SESSION[ 'tid' ];
	$tidan = $_POST[ 'tidan' ];
	$sql = "UPDATE `jol`.`problem_list` SET `title` = '$tidan' WHERE `id` = $tid";
	$result = mysqli_query( $mysqli, $sql );
	if ( $result )
		echo "题单标题——>修改成功！<br>";

	$sql = "SELECT * from problem_list_items where tid=$tid";
	//echo $sql;
	$result = mysqli_query( $mysqli, $sql );
	$view_td = Array();
	$cnt = 0;

	while ( $row = mysqli_fetch_object( $result ) ) {
		$view_td[ $cnt ] = $row->id;
		//$view_td[ $cnt ][ 1 ] = $row->num_str;
		//$view_td[ $cnt ][ 2 ] = $row->id;
		$cnt++;
	}
	//var_dump( $view_td );
	mysqli_free_result( $result );
	$now_time = date( "Y-m-d H:i:s" );
	$user = $_SESSION[ 'user_id' ];

	//var_dump($_SESSION);

	for ( $i = 0; $i < count( $view_td ); $i++ ) {
		if ( isset( $_POST[ $view_td[ $i ] . "title" ] )and $_POST[ $view_td[ $i ] . "title" ] != '' ) {

			$id = $view_td[ $i ];
			$num_title = $_POST[ $view_td[ $i ] . "title" ];
			$num_str = $_POST[ $view_td[ $i ] . "num" ];
			$sql = "UPDATE `jol`.`problem_list_items` SET `title` = '$num_title', `num_str` = '$num_str',`Update_time` = '$now_time',`Update_user` = '$user' WHERE `id` = $id";
		} else {
			$sql = "DELETE FROM `jol`.`problem_list_items` WHERE `id` = $id";
		}
		$result = mysqli_query( $mysqli, $sql );
		if ( $result )
			echo "修改一条数据——>成功！<br>";
	}
	//新增的数据如下操作
	$title = $_POST[ 'title' ]; //题目类别
	$num_str = $_POST[ 'num' ]; //题目编号

	for ( $i = 0; $i < count( $title ); $i++ ) {
		$tit = $title[ $i ];
		$str = $num_str[ $i ];
		$str = mysqli_real_escape_string( $mysqli, $str );
		$sql = "INSERT INTO `problem_list_items`(`title`, `num_str`,`tid`,`Create_time`,`Create_user`) 
	VALUES ('$tit', '$str',$tid,'$now_time','$user')";
		$result = mysqli_query( $mysqli, $sql );
		if ( $result )
			echo "修改一条数据——>成功！！<br>";
	}
	echo "修改更新成功！<br>";
}
?>