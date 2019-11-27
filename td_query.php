<?php
require_once("include/db_info.inc.php");

$sql = "SELECT * FROM problem_list_items";
$result=mysqli_query($mysqli,$sql);




	
?>
<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="plus/template/bs3/bootstrap.min.css">
<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="plus/template/bs3/bootstrap-theme.min.css">
<link rel="stylesheet" href="plus/template/bs3/white.css">
<ul class="nav navbar-nav">
  <li ><a href="td_query.php">查看题单</a></li>
  <li ><a href="td_add.php">添加类题</a></li>
  <li ><a href="contest.php">添加题单</a></li>
</ul>

<br><br>
<form class="form-inline">
	<div class="form-group">
		<label for="username">查找用户</label>
		<input type="text" class="form-control" id="username" name="username" placeholder="输入用户名">
	</div>
	<button type="submit" class="btn btn-default">查找</button>
</form>



<?php


		$k=0;
		echo '<div class="table-responsive">';
		echo '<table class="table">';
		echo "<th>标题</th><th>题号</th><th>创建时间</th><th>创建人</th><th>ID</th><th>复制</th><th>编辑</th><th>删除</th>";
		while ( $row = mysqli_fetch_assoc( $result ) ) {
			if($k%2) echo "<tr class='evenrow'>\n"; else echo "<tr class='oddrow'>\n";
			echo '<td>' . $row[ 'title' ] . '</td>';
			echo '<td>' . $row[ 'num_str' ] . '</td>';
			echo '<td>' . $row[ 'Create_time' ] . '</td>';
			echo '<td>' . $row[ 'Create_user' ] . '</td>';
			echo '<td>' . $row[ 'id' ] . '</td>';
			echo '<td><a href = "admin.php?did=' . $row[ 'id' ] . '">复制</a></td>';
			echo '<td><a href = "admin.php?did=' . $row[ 'id' ] . '">编辑</a></td>';
			echo '<td><a href = "admin.php?did=' . $row[ 'id' ] . '">删除</a></td>';
			echo "</tr>\n";
			$k=$k+1;
		}
		echo "</table>";
		echo "</div>";


?>



