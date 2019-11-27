<?php require("admin-header.php");
require_once("../include/set_get_key.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
//用户已经登录的情况下
if(!isset($_GET['uid'])){
	echo "非法访问";
	exit(1);
}
require_once("../include/db_info.inc.php");
echo "<title>用户资料管理</title>"; 
echo "<center><h2>用户资料管理</h2></center>";
//存贮表头信息，一个数组
$HeadInfo=array("user_id","email","nick","name");
//读取用户信息和权限并进行显示
$user_id=$_GET['uid'];
echo "<h4>用户资料编辑，用户id：".$user_id."</h4>";
$sql="select * from users where user_id='$user_id'";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_object($result);
$cnt=count($HeadInfo);
$View=array();
for($i=0;$i<$cnt;$i++){
	$View[$i][0]=$HeadInfo[$i];
	$Str=$row->$HeadInfo[$i];
	if($i==0)
		$View[$i][1]="<input type=\"text\" value=\"$Str\" readonly=\"true\"></input><br />";
	else
		$View[$i][1]="<input type=\"text\" value=\"$Str\"></input><br />";
}
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
<link rel="stylesheet" href="../template/bs3/local.css">
  </head>
  <body>
  <center> 
<!--上面页码导航条-->
<form method="post">
<table id='problemset' width='90%'class='table table-striped'>
<thead>
<tr class='toprow' align="left">
<th width='50'  class='hidden-xs' >项目</th>
<th width='50'>内容</th>
</tr>
</thead>
<tbody>
<?php
//echo "<form method=\"post\">";
$cnt=0;
foreach($View as $row){
if ($cnt)
echo "<tr class='oddrow'>";
else
echo "<tr class='evenrow'>";
foreach($row as $table_cell){
	echo "<td>";
	echo $table_cell;
	echo "</td>";
}
echo "</tr>";
$cnt=1-$cnt;
}
if ($cnt)
echo "<tr class='oddrow'>";
else
echo "<tr class='evenrow'>";
echo "<td> </td>";
echo "<td><input type=\"submit\" value=\"更新资料\"></input></td>";
?>
</tbody>
</table>
</form>
</center>
<h4>用户权限编辑与管理</h4>
<center> 
<!--用户权限表单第二个编辑-->
<form method="post">
<table id='problemset' width='90%'class='table table-striped'>
<thead>
<tr class='toprow' align="left">
<th width='50'  class='hidden-xs' >项目</th>
<th width='50'>内容</th>
</tr>
</thead>
<tbody>
<?php
$cnt=0;
foreach($View as $row){
if ($cnt)
echo "<tr class='oddrow'>";
else
echo "<tr class='evenrow'>";
foreach($row as $table_cell){
	echo "<td>";
	echo $table_cell;
	echo "</td>";
}
echo "</tr>";
$cnt=1-$cnt;
}
if ($cnt)
echo "<tr class='oddrow'>";
else
echo "<tr class='evenrow'>";
echo "<td> </td>";
echo "<td><input type=\"submit\" value=\"更新权限\"></input></td>";
?>
</tbody>
</table>
</form>
</center>
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
</body>
</html>

