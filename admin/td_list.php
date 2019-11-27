<?php require_once("../include/db_info.inc.php");?>
<?php
require_once( "admin-header.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) || isset( $_SESSION[ 'problem_editor' ] ) ) ) {
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit( 1 );
}
$sql = 'SELECT * from problem_list';
if ( isset( $_GET[ 'tdtitle' ] )and $_GET[ 'tdtitle' ] != '' ) {
	$tdtitle = $_GET[ 'tdtitle' ];
	$sql = $sql . " where title like '%$tdtitle%'";
}
$result = mysqli_query( $mysqli, $sql );
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>题单列表</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="plus/bootstrap.min.css">
	<script src="plus/jquery.min.js"></script>
	<script src="plus/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
		<br>

		<form class="form-inline">
			<div class="form-group">
				<label for="tdtitle">查找题单</label>
				<input type="text" class="form-control" id="tdtitle" name="tdtitle" placeholder="输入题单名">
			</div>
			<button type="submit" class="btn btn-default">查找</button>
		</form>
		<?php
		$k = 0;
		echo "<div class='table-responsive'>\n";
		echo "<table class='table table-striped'>\n";
		echo "<thead>\n<tr class='toprow'>\n";
		echo '<th width="10%">ID</th>
		<th width="50%">题单名</th><th width="10%">权限</th><th width="10%">复制</th><th width="10%">编辑</th><th width="10%">删除</th>';
		echo "\n</tr>\n</thead>\n<tbody>";
		while ( $row = mysqli_fetch_assoc( $result ) ) {
			if ( $k % 2 )echo "<tr class='evenrow'>\n";
			else echo "<tr class='oddrow'>\n";
			echo '<td>' . $row[ 'id' ] . '</td>';
			echo '<td><a href = "../td.php?id=' . $row[ 'id' ] . '">'.$row[ 'title' ].'</a></td>';
			echo '<td>' . $row[ 'Create_user' ] . '</td>';
			echo '<td><a href = "td_copy.php?tid=' . $row[ 'id' ] . '">复制</a></td>';
			echo '<td><a href = "td_edit.php?tid=' . $row[ 'id' ] . '">编辑</a></td>';
			echo '<td><a href = "td_delete.php?tid=' . $row[ 'id' ] . '">删除</a></td>';
			echo "</tr>\n";
		}
		echo "</tbody>\n</table>";
		echo "</div>";
		?>
	</div>
</body>

</html>