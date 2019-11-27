<?php
require_once( "include/db_info.inc.php" );
require_once( './include/cache_start.php' );
require_once( './include/db_info.inc.php' );
require_once( './include/my_func.inc.php' );
require_once( './include/td_function.php' );

//require_once('./include/const.inc.php');
require_once( './include/setlang.php' );
if ( isset( $_GET[ 'id' ] ) ) {
	//展示某一个具体的题单，以及用户的ac情况。
	$tid = $_GET[ 'id' ];
	$sql = "SELECT * from problem_list where id=$tid";
	$result = mysqli_query( $mysqli, $sql );
	$row = mysqli_fetch_object( $result );
	$tdtie = $row->title; //获得题单数据
	$user = $_SESSION[ 'user_id' ];//默认登录用户，管理员可以修改用户
	
	if ( isset( $_GET[ 'user' ] )and $_GET[ 'user' ] != '' ) {
		$user = $_GET[ 'user' ];
	}

	$sql = "SELECT * from problem_list_items where tid=$tid";
	$result = mysqli_query( $mysqli, $sql );

	$cnt = 0;
	$view_td = Array();

	while ( $row = mysqli_fetch_object( $result ) ) {
		$title = $row->title;
		$view_td[ $cnt ][ 0 ] = $row->title;
		$num_str = $row->num_str;
		$num_str = trim( $num_str );
		$num_str = explode( ",", $num_str );
		for ( $i = 0; $i < count( $num_str ); $i++ ) {
			$num = $num_str[ $i ];
			$view_td[ $cnt ][ $i + 1 ] = td_check_ac( $user, $num_str[ $i ] );
		}
		$cnt = $cnt + 1;
	}
	mysqli_free_result( $result );
} else {
	$sql = 'SELECT * from problem_list';
	$result = mysqli_query( $mysqli, $sql );
	$view_tdset = Array();
	$cnt = 0;
	while ( $row = mysqli_fetch_object( $result ) ) {
		$tid = $row->id;
		$view_tdset[ $cnt ][ 0 ] = $tid;
		$view_tdset[ $cnt ][ 1 ] = "<a href='td.php?id=$tid'>$row->title</a>";
		$view_tdset[ $cnt ][ 2 ] = $row->Create_time;
		$view_tdset[ $cnt ][ 3 ] = $row->pri;
		$view_tdset[ $cnt ][ 4 ] = $row->Create_user;
		$cnt++;
	}
	mysqli_free_result( $result );
}
//根据是否测试的id，选用不同的前台界面
/////////////////////////Template
if ( isset( $_GET[ 'id' ] ) )
	require( "template/" . $OJ_TEMPLATE . "/td.php" );
else
	require( "template/" . $OJ_TEMPLATE . "/tdset.php" ); //不含测试id，显示各个测试
/////////////////////////Common foot
if ( file_exists( './include/cache_end.php' ) )
	require_once( './include/cache_end.php' );

?>