<?php
require("admin-header.php");
require_once("../include/set_get_key.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
//检测用户登录，全局文件
require_once("../include/db_info.inc.php");
echo "<center><h2>真实姓名修改</h2></center>";
?>
<!doctype html>
<html>
<head>
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
<link rel="stylesheet" href="../template/bs3/local.css">
  </head>
</head>
<body>
	用于实现用户名的修改
</body>
</html>