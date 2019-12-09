<?php
require( "admin-header.php" );
require_once( "../include/set_get_key.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) ) ) {
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit( 1 );
}
//已经校验用户已经登录了
var_dump( $_GET );
//准备进行锁定和解锁操作
if ( isset( $_GET[ 'uid' ] )and $_GET[ 'uid' ] != null ) {
  //取得参数
  $uid = $_GET[ 'uid' ];
  $defunct = $_GET[ 'defunct' ];
  //进行更新操作
  require_once( "../include/db_info.inc.php" );
  $sql = "UPDATE `users` SET `defunct` = '$defunct' WHERE `user_id` = '$uid'";
  $result = mysqli_query( $mysqli, $sql );
  if ( $result ) {
    echo "<script>alert('操作成功！');</script>";
    echo "<script language=javascript>history.go(-1);</script>";
    exit( 1 );
  }
}
?>