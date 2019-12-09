<?php
require( "admin-header.php" );
require_once( "../include/set_get_key.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) ) ) {
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit( 1 );
}
//检测是否post数据，修改用户信息
if ( isset( $_POST['uid']) ) {
  require_once( '../include/db_info.inc.php' );
  require_once( "../include/my_func.inc.php" );
  //var_dump( $_POST );
  $user_id = trim( $_POST[ 'uid' ] );
  $email = trim( $_POST[ 'email' ] );
  $school = trim( $_POST[ 'school' ] );
  $name = trim( $_POST[ 'name' ] );
  $nick = trim( $_POST[ 'nick' ] );
  $beizhu = trim( $_POST[ 'beizhu' ] );
  $pwd = trim( $_POST[ 'pwd' ] );
  //转化为html实体
  $nick = mysqli_real_escape_string( $mysqli, htmlentities( $nick, ENT_QUOTES, "UTF-8" ) );
  $school = mysqli_real_escape_string( $mysqli, htmlentities( $school, ENT_QUOTES, "UTF-8" ) );
  $email = mysqli_real_escape_string( $mysqli, htmlentities( $email, ENT_QUOTES, "UTF-8" ) );
  $sql = "UPDATE `users` SET"
    . "`nick`='" . ( $nick ) . "',"
  . "`name`='" . ( $name ) . "',"
  . "`note`='" . ( $beizhu ) . "',"
  . "`school`='" . ( $school ) . "',"
  . "`email`='" . ( $email ) . "' "
  . "WHERE `user_id`='" . mysqli_real_escape_string( $mysqli, $user_id ) . "'";
  //echo $sql;
  mysqli_query( $mysqli, $sql );
  //检测用户密码是否需要修改
  if ( $pwd ) {
    $password = pwGen( $pwd );
    $sql = "UPDATE `users` SET"
      . "`password`='" . ( $password ) . "'"
    . "WHERE `user_id`='" . mysqli_real_escape_string( $mysqli, $user_id ) . "'";
	  mysqli_query( $mysqli, $sql );
  }
  echo "用户资料更新成功！";
  exit( 1 );
}

//用户已经登录的情况下
if ( !isset( $_GET[ 'uid' ] )or $_GET[ 'uid' ] == null ) {
  echo "<script>alert('无法访问');</script>";
  echo "<script language=javascript>history.go(-1);</script>";
  exit( 1 );
}
require_once( "../include/db_info.inc.php" );
//读取用户信息和权限并进行显示
$user_id = $_GET[ 'uid' ];
$sql = "select * from users where user_id='$user_id'";
$result = mysqli_query( $mysqli, $sql );
$row = mysqli_fetch_array( $result );
?>
<!--用户界面与实际功能的分离-->
<!DOCTYPE html>
<html lang="en">
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
  <h3>用户资料编辑</h3>
  <nav class="navbar navbar-default">
    <div class="navbar-header"> <a href="user_list.php" class="navbar-brand">用户列表</a> <a href="user_name.php" class="navbar-brand">名字修改</a> <a href="user_add.php" class="navbar-brand">批量添加</a> </div>
  </nav>
  <p class="lead">用户名：<?php echo $row[0];?></p>
  <!--上面页码导航条-->
  <form method="post">
	 <input type="hidden" name="uid" value="<?php echo $row['user_id'];?>">
    <div class="form-group">
      <label>姓名</label>
      <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>">
    </div>
    <div class="form-group">
      <label>Nick name</label>
      <input type="text" class="form-control" name="nick" value="<?php echo $row['nick'];?>">
    </div>
    <div class="form-group">
      <label>School</label>
      <input type="text" class="form-control" name="school" value="<?php echo $row['school'];?>">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $row['email'];?>">
    </div>
    <div class="form-group">
      <label>备注</label>
      <input type="text" class="form-control" name="beizhu" placeholder="" value="<?php echo $row['note'];?>">
    </div>
    <div class="form-group">
      <label>密码</label>
      <input type="password" class="form-control" name="pwd" placeholder="不更新请留空">
      <p class="help-block"></p>
    </div>
    
    <!--    <div class="checkbox">
      <label>
        <input type="checkbox">是否禁用</label></div>-->
    <button type="submit" class="btn btn-default">确认修改</button>
  </form>
  <!--显示用户--> 
  <!-- Bootstrap core JavaScript
    ================================================== --> 
  <!-- Placed at the end of the document so the pages load faster --> 
  <script type="text/javascript" src="../include/jquery.tablesorter.js"></script> 
  <script type="text/javascript">
$(document).ready(function()
{
$("#problemset").tablesorter();
}
);
</script> 
</div>
</body>
</html>
