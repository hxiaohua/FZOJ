<?php
require_once( "admin-header.php" );
require_once( "../include/check_post_key.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) || isset( $_SESSION[ 'problem_editor' ] ) ) ) {
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit( 1 );
}
require_once( "../include/db_info.inc.php" );
//接收到题单数据，进行写入数据库操作
//var_dump( $_POST );
//可能中文乱码的解决方案

//第一步，插入题单页面
$Create_time = date( "Y-m-d H:i:s" );
$tidan = $_POST[ 'tidan' ];
$num_str = $_POST[ 'num_str' ];
$Create_user = $_SESSION[ 'user_id' ];
$sql = "INSERT INTO `problem_list`(`title`, `pri`,`Create_time`,`Create_user`) 
VALUES ('$tidan', '$Create_user','$Create_time','$Create_user')";


$result = mysqli_query( $mysqli, $sql );
$tid = mysqli_insert_id( $mysqli );
//取得题单id，将剩下的题目类别和数据添加入题单数据表

echo "<br>添加的题单ID为： $tid<br>";

$title = $_POST[ 'title' ]; //题目类别
$num_str = $_POST[ 'num' ]; //题目编号

for ( $i = 0; $i < count( $title ); $i++ ) {
	$tit=$title[$i];
	$str=$num_str[$i];
	$str=mysqli_real_escape_string($mysqli,$str);
	$sql = "INSERT INTO `problem_list_items`(`title`, `num_str`,`tid`,`Create_time`,`Create_user`) 
	VALUES ('$tit', '$str',$tid,'$Create_time','$Create_user')";
    $result=mysqli_query($mysqli,$sql);
}
echo "添加成功";
?>