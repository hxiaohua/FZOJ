<?php
require_once("include/db_info.inc.php");


//var_dump($_SESSION);
if(isset($_POST['num_str']))
{
	
	var_dump($_POST);

	
	$Create_time=date("Y-m-d H:i:s");
	echo $Create_time;
	$title=$_POST['title'];
	$num_str=$_POST['num_str'];
	$Create_user=$_SESSION['user_id'];
	$sql = "INSERT INTO `problem_list_items`(`title`, `num_str`,`Create_time`,`Create_user`) 
	VALUES ('$title', '$num_str','$Create_time','$Create_user')";
    $result=mysqli_query($mysqli,$sql);
	
	if($result)
		echo "Success";
	
}


?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>FZOJ</title>  
<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="plus/template/bs3/bootstrap.min.css">
<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="plus/template/bs3/bootstrap-theme.min.css">
<link rel="stylesheet" href="plus/template/bs3/white.css">

<body>
    <div class="container">
          <!-- Static navbar -->
      <nav class="navbar navbar-default" role="navigation" >
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">FZOJ</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
	                    <li ><a href="../bbs.php">讨论版</a></li>
	      <li ><a href="faqs.php">常见问答</a></li>
              <li ><a href="problemset.php">问题</a></li>
              <li ><a href="status.php">状态</a></li>
              <li ><a href="ranklist.php">排名</a></li>
              <!--新增一个li，作业入口 add by hxh-->
              <li ><a href="td_add.php">题单</a></li>
               <li ><a href="homework.php">作业</a></li>
              <li ><a href="contest.php">竞赛</a></li>
              <li ><a href="recent-contest.php">名校联赛</a></li>
              <!--<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
	-->
            </ul>
	    <ul class="nav navbar-nav navbar-right">
	    <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span id="profile">Login</span><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
<script src="plus/template/bs3/profile.php?26611" ></script>
              <!--<li><a href="../navbar-fixed-top/">Fixed top</a></li>-->
	    </ul>
	    </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
	  <!--
	  add by hxh  
	  添加题单页面
	  -->
            <ul class="nav navbar-nav">
              <li ><a href="td_query.php">查看题单</a></li>
              <li ><a href="td_add.php">添加类题</a></li>
			  <li ><a href="td_add_type.php">添加题单</a></li>
            </ul>
			<br><br>
	  <h2 align="center">添加题单</h2>
	  <form method="post">
  <div class="form-group">
    <label>某类题单标题</label>
    <input type="text" class="form-control" name="title" placeholder="题单标题">
  </div>
  
  <div class="form-group">
    <label>题目类别</label>
    <input type="text" class="form-control" name="num_str" placeholder="题目类别标题或者id？">
  </div>
  
  
  
  
  
    <div class="form-group">
    <label>添加题目类别</label>
        <input type="text" class="form-control" name="ti[]" placeholder="题目类别">
	</div>
	
	<div class="form-group">
    <label>添加题目类别</label>
        <input type="text" class="form-control" name="ti[]" placeholder="题目类别">
	</div>
  
  
  <button type="submit" class="btn btn-default">添加题单</button>
</form>
	  
	  
	  
	  
	  
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="plus/template/bs3/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="plus/template/bs3/bootstrap.min.js"></script>

<!--<script type="text/javascript"
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
-->
<script>
$(document).ready(function(){
  var msg="<marquee  id=broadcast scrollamount=1 scrolldelay=50 onMouseOver='this.stop()'"+
      " onMouseOut='this.start()' class=toprow>"+""+"</marquee>";
  $(".jumbotron").prepend(msg);
  $("form").append("<div id='csrf' />");
  $("#csrf").load("csrf.php");
  $("body").append("<div id=footer class=center >GPLv2 licensed by <a href='https://github.com/zhblue/hustoj' >HUSTOJ</a> "+(new Date()).getFullYear()+" </div>");
});

</script>

	    
</body>
</html>