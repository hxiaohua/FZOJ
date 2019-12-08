<?php
require( "admin-header.php" );
//require_once( "../include/set_get_key.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) ) ) {
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit( 1 );
}
//检测用户登录，全局文件
require_once( "../include/db_info.inc.php" );
if ( isset( $_POST[ 'uname' ]) and  $_POST[ 'uname' ]!=null) {
	//上面一行and判断，去除输入为空的BUG
  require_once( "../include/check_post_key.php" );
  //var_dump( $_POST );
  $stuname = explode( "\n", trim( $_POST[ 'uname' ] ) );
  $username = explode( "\n", trim( $_POST[ 'ulist' ] ) );
	//逐行更新数据
	//echo count( $username );
  for ( $i = 0; $i < count( $username ); $i++ ) {
    $stuname[ $i ] = mysqli_real_escape_string( $mysqli, htmlentities( $stuname[ $i ], ENT_QUOTES, "UTF-8" ) );
    $sql = "select * from users where user_id='" . trim( $username[ $i ] ) . "'";
    if ( mysqli_query( $mysqli, $sql ) ) //找到该用户，更新姓名操作
    {
      $sql = "UPDATE `users` SET `name`='" . trim( $stuname[ $i ] ) . "' WHERE (`user_id`='" . trim( $username[ $i ] ) . "')";
      mysqli_query( $mysqli, $sql );
    }
  }
  //var_dump( $stuname );
  //var_dump( $username );
  echo "<br>成功更新学生姓名！<br>";
  exit();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">
<!-- 新 Bootstrap 核心 CSS 文件 -->
 <link rel="stylesheet" href="../template/bs3/bootstrap.min.css">
<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="../template/bs3/bootstrap-theme.min.css">
<link rel="stylesheet" href="../template/bs3/white.css">

</head>
<body>
<div class="container">
	  <h3>批量添加用户</h3>
	  <nav class="navbar navbar-default">
    <div class="navbar-header">               
		<a href="user_list.php" class="navbar-brand">用户列表</a> 
		<a href="user_name.php" class="navbar-brand">名字修改</a> 
	  	<a href="user_add.php" class="navbar-brand">批量添加</a> 
	</div>
  </nav>
<p class='lead'>左边一列，输入用户名。右边一列，对应密码</p>
  <form method="post">
    <?php require_once("../include/set_post_key.php");?>
    用户名:
    <textarea name="ulist" rows="20" cols="20"></textarea>
    对应密码:
    <textarea name="upass" rows="20" cols="20"></textarea>
    <br />
    <button type="submit" class="btn btn-primary">确认添加</button>
  </form>
  <p class='lead'>提示：先用表格生成好，学生名单表格统计好，然后将列复制到对应左右两边</p>
	  <div id="footer" class="center">GPLv2 licensed by <a href="https://github.com/hxiaohua/FZOJ" target="_blank">FZOJ</a> 2019 </div>
</div>
</body>
</html>