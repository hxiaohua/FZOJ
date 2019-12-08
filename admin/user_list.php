<?php
require( "admin-header.php" );
require_once( "../include/set_get_key.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) ) ) {
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit( 1 );
}
//检测用户登录，全局文件
require_once( "../include/db_info.inc.php" );
if ( isset( $_GET[ 'page' ] ) )
  $page = $_GET[ 'page' ];
//设置分页等
$page_cnt = 50; //每页显示50个用户

$sql = "SELECT count(*) from users;";
$result = mysqli_query( $mysqli, $sql );
echo mysqli_error( $mysqli );
$row = mysqli_fetch_array( $result ); //Array与object不一样
//echo "总条数".$row[0];
$cnt = intval( $row[ 0 ] );
$num = $cnt;
$cnt = $cnt / $page_cnt;
$cnt = ceil( $cnt );
//echo "---->分页数量".$cnt."<br />";
//生成导航条，分页显示的实现
//注意下面就是html页面了
?>
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
<link href="../css/bootstrap-3.4.1.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../template/bs3/white.css">
</head>
<body>
<div class="container"> 
  <!--导航条功能：https://learnku.com/articles/18764-->
  <h3>用户列表管理</h3>
  <nav class="navbar navbar-default">
    <div class="navbar-header"> <a href="user_list.php" class="navbar-brand">用户列表</a> <a href="user_name.php" class="navbar-brand">名字修改</a> <a href="user_add.php" class="navbar-brand">批量添加</a> </div>
  </nav>
  <!--顶部一个导航链接条-->
  <center>
    <nav class="center">
      <ul class="pagination">
        <li class="page-item"> <a href="user_list.php?page=1">&lt;&lt;</a></li>
        <?php
        //导航条目标生成
        if ( !isset( $page ) )
          $page = 1;
        $page = intval( $page );
        for ( $i = 1; $i <= $cnt; $i++ ) {
          echo "<li class='" . ( $page == $i ? "active " : "" ) . "page-item'>
        <a href='user_list.php?page=" . $i . "'>" . $i . "</a></li>";
        }
        ?>
        <li class="page-item"><a href="user_list.php?page=<?php echo $cnt?>">&gt;&gt;</a></li>
      </ul>
    </nav>
    <!--上面页码导航条-->
    <table>
      <tr align='center' class='evenrow'>
        <td width='5'></td>
        <td  colspan='1'><form class=form-inline>
            <input class="form-control search-query" type='text' name='id'  placeholder="user id">
            <button class="form-control" type='submit' >Go</button>
          </form></td>
        <td  colspan='1'><form class="form-search form-inline">
            <input type="text" name="search" class="form-control search-query" placeholder="Keywords">
            <button type="submit" class="form-control">查找</button>
          </form></td>
      </tr>
    </table>
    <!--增加用户查找功能，下面显示用户信息-->
    </table>
    <table id='problemset' width='90%'class='table table-striped'>
      <thead>
        <tr class='toprow' align="left">
          <th width='10%'  class='hidden-xs' >编号</th>
          <th width='15%'>用户id</th>
          <th width='15%'>呢称</th>
          <th width='10%'>姓名</th>
          <th width='15%'>学校</th>
          <th width='10%'>备注</th>
          <th style="cursor:hand" width='10%' >权限</th>
          <th style="cursor:hand" width='10%'>禁用</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //表格中每行数据的生成
        if ( isset( $_GET[ 'page' ] ) ) {
          $pageval = $_GET[ 'page' ];
        } else $pageval = 1;
        $page = ( $pageval - 1 ) * $page_cnt;
        $sql = "select * from users limit $page,$page_cnt";
        $query = mysqli_query( $mysqli, $sql );
        $cnt = 0;
        while ( $row = mysqli_fetch_array( $query ) ) {
          if ( $cnt % 2 )
            echo "<tr class='oddrow'>";
          else
            echo "<tr class='evenrow'>";
          //每一行的数据，一行记录
          $cnt++;
          $nums = $cnt + $page;
          echo "<td>$nums</td>\t";
          echo "<td><a href=\"../userinfo.php?user=$row[0]\" target='_blank'>$row[0]</a></td>\t";
          echo "<td>$row[11]</td>\t";
          echo "<td>$row[13]</td>\t";
          echo "<td>$row[12]</td>\t";
          echo "<td>$row[14]</td>\t";
          echo "<td><a href=\"user_edit.php?uid=$row[0]\">编辑</a></td>\t";
          echo "<td><a href=\"user_delete.php?uid=$row[0]\">禁用</a></td>\t";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </center>
  <!--显示用户--> 
  
  <!-- Bootstrap core JavaScript
    ================================================== --> 
  <!-- Placed at the end of the document so the pages load faster -->
  <?php
  // include("../template/$OJ_TEMPLATE/js.php");尾部的著作权显示，注释不显示
  ?>
  <script type="text/javascript" src="../include/jquery.tablesorter.js"></script> 
  <script src="../js/jquery-1.12.4.min.js"></script> 
  <script src="../js/bootstrap-3.4.1.js"></script> 
  <script type="text/javascript">
$(document).ready(function()
{
$("#problemset").tablesorter();
}
);
</script>
  <div id="footer" class="center">GPLv2 licensed by <a href="https://github.com/hxiaohua/FZOJ" target="_blank">FZOJ</a> 2019 </div>
</div>
</body>
</html>
