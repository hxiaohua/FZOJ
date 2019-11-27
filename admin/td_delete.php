<?php
require_once( "admin-header.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) || isset( $_SESSION[ 'problem_editor' ] ) ) ) {
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit( 1 );
}
require_once( "../include/db_info.inc.php" );
//题单数据删除功能
if ( isset( $_GET[ 'tid' ] )and $_GET[ 'tid' ] != '' ) {
	$flag = true; //标记是否删除成功，后面使用js跳转
	
	$tid = $_GET[ 'tid' ];
	$sql = " DELETE from problem_list WHERE id=$tid";
	$result = mysqli_query( $mysqli, $sql );
	if ( !$result )$flag = false;
	
	$sql = " DELETE from problem_list_items WHERE tid=$tid";
	$result = mysqli_query( $mysqli, $sql );
	if ( !$result )$flag = false;
	
	if ( $flag )
		echo "<<script>alert('删除成功！');history.go(-1);</script>";
}
?>