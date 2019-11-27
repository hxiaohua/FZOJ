<?php
require( "admin-header.php" );
require_once( "../include/set_get_key.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) ) ) {
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit( 1 );
}
//检测用户登录，全局文件
require_once( "../include/db_info.inc.php" );
echo "<center><h2>真实姓名修改</h2></center>";
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
<!-- <link rel="stylesheet" href="../template/bs3/bootstrap.min.css"> -->
<link href="../css/bootstrap-3.4.1.css" rel="stylesheet" type="text/css">
<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="../template/bs3/bootstrap-theme.min.css">
<link rel="stylesheet" href="../template/bs3/local.css">
</head>
<body>
<div class="container"></div>
<p class='lead'>用于实现用户名的修改</p>
<p class='lead'>左边一列输入用户名</p>
<p class='lead'>右边一列对应一列姓名</p>
<form method="post">
  <?php require_once("../include/set_post_key.php");?>
  用户名:
  <textarea name="ulist" rows="20" cols="20"></textarea>
  <!--添加用户姓名--> 
  学生名字:
  <textarea name="uname" rows="20" cols="20"></textarea>
  <br />  <br />

  <button type="submit" class="btn btn-default">确认修改</button>
</form>
	<p class='lead'>提示：先将学生名单表格统计好，然后将列复制到左右两边</p>
</body>
</html>