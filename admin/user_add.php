<?php
require( "admin-header.php" );
//require_once( "../include/set_get_key.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) ) ) {
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit( 1 );
}
//POST了数据则，加入数据库
if ( isset( $_POST[ 'uname' ] )and $_POST[ 'uname' ] != null ) {
  //上面一行and判断，去除输入为空的BUG
  require_once( "../include/check_post_key.php" );
  //验证post数据
  require_once( "../include/db_info.inc.php" );
  require_once( "../include/my_func.inc.php" );
  //加入函数和数据库，验证用户名等
  //var_dump( $_POST );
  $username = explode( "\n", trim( $_POST[ 'uname' ] ) );
  $password = explode( "\n", trim( $_POST[ 'upass' ] ) );
  //逐行更新数据
  //echo count( $username );
  //exit();
  $ok_num = 0;
  $fail_num = 0;
  for ( $i = 0; $i < count( $username ); $i++ ) {
    //检测用户名是否可用
    $uid = trim( $username[ $i ] );
    if ( !is_valid_user_name( $uid ) ) {
      //echo "不符合要求的用户名：$uid<br>";
      $fail_num++;
      continue;
    }
    //查询id是否已经存在
    $sql = "SELECT `user_id` FROM `users` WHERE `users`.`user_id` = '" . $uid . "'";
    $result = mysqli_query( $mysqli, $sql );
    $rows_cnt = mysqli_num_rows( $result );
    mysqli_free_result( $result );
    if ( $rows_cnt == 1 ) {
      //echo "已经存在的用户名：$uid<br>";
      $fail_num++;
      continue;
    }
    //以上都没问题，可以添加进入数据库
    $nick = "Hello World";
    $school = "西大附中";
    $email = "xdfz@swu.edu.cn";
    $ip = $_SERVER[ 'REMOTE_ADDR' ];
    $pass = pwGen( trim( $password[ $i ] ) );
    $sql = "INSERT INTO `users`("
      . "`user_id`,`email`,`ip`,`accesstime`,`password`,`reg_time`,`nick`,`school`)"
    . "VALUES('" . $uid . "','" . $email . "','" . $_SERVER[ 'REMOTE_ADDR' ] . "',NOW(),'" . $pass . "',NOW(),'" . $nick . "','" . $school . "')";
    mysqli_query( $mysqli, $sql ); // or die("Insert Error!\n");
    if ( mysqli_affected_rows( $mysqli ) > 0 ) {
      echo "添加成功的用户名:$uid<br>";
      $ok_num++;
    }
  }
  echo "<br>添加账号结束。<br>";
  echo "添加成功：$ok_num<br>";
  echo "添加失败，$fail_num<br>";
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
    <div class="navbar-header"> <a href="user_list.php" class="navbar-brand">用户列表</a> <a href="user_name.php" class="navbar-brand">名字修改</a> <a href="user_add.php" class="navbar-brand">批量添加</a> </div>
  </nav>
  <p class='lead'>左边一列，输入用户名。右边一列，对应密码</p>
  <form method="post">
    <?php require_once("../include/set_post_key.php");?>
    用户名:
    <textarea name="uname" rows="20" cols="20"></textarea>
    对应密码:
    <textarea name="upass" rows="20" cols="20"></textarea>
    <br />
    <button type="submit" class="btn btn-primary">确认添加</button>
  </form>
  <p class='lead'>提示：先用表格生成好，然后对应列复制到对应左右两边，务必保持行列对应</p>
  <div id="footer" class="center">GPLv2 licensed by <a href="https://github.com/hxiaohua/FZOJ" target="_blank">FZOJ</a> 2019 </div>
</div>
</body>
</html>