<?php

require_once( "admin-header.php" );
if ( !( isset( $_SESSION[ 'administrator' ] ) || isset( $_SESSION[ 'problem_editor' ] ) ) ) {
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit( 1 );
}
require_once( "../include/db_info.inc.php" );

//如何修改用户数据

if ( isset( $_GET[ 'tid' ] )and $_GET[ 'tid' ] != '' ) {

	$tid = $_GET[ 'tid' ];

	$_SESSION[ 'tid' ] = $tid;

	$sql = "SELECT * from problem_list where id=$tid";
	$result = mysqli_query( $mysqli, $sql );
	$row = mysqli_fetch_object( $result );
	$tdtie = $row->title; //获得题单数据

	$sql = "SELECT * from problem_list_items where tid=$tid";
	$result = mysqli_query( $mysqli, $sql );
	$view_td = Array();
	$cnt = 0;

	while ( $row = mysqli_fetch_object( $result ) ) {
		$view_td[ $cnt ][ 0 ] = $row->title;
		$view_td[ $cnt ][ 1 ] = $row->num_str;
		$view_td[ $cnt ][ 2 ] = $row->id;

		$cnt++;
	}
}
?>


<html>

<head>
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Content-Language" content="zh-cn">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>编辑题单</title>
	<!-- 新 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="plus/bootstrap.min.css">
	<!-- 可选的Bootstrap主题文件（一般不用引入） -->
	<link rel="stylesheet" href="plus/bootstrap-theme.min.css">
	<link rel="stylesheet" href="plus/white.css">

	<script type="text/javascript" src="plus/jquery-1.7.2.min.js"></script>
	<script type="text/javascript">
		$( function () {
			$( '.tianjia' ).click( function ( e ) {
				var $html = $( "<tr><td><input type='text' class='input_140'   placeholder='请输入姓名'/></td><td><input type='text' class='input_140'   placeholder='请输入姓名'/></td><td><input type='text' class='input_140'   placeholder='请输入姓名'/></td><td><input type='text' class='input_140'   placeholder='请输入姓名'/></td><td><a class='shanchu' onclick=\'sc()\'>删除</a></td></tr>" );
				var $html = $( "<tr><td><input type='text' class='form-control' name='title[]' placeholder='题目类别名称'></td><td><input type='text' class='form-control' name='num[]' placeholder='输入编号'></td><td><a class='shanchu' onclick=\'sc()\'>删除</a></td></tr>" );
				$( '.box table ' ).append( $html );
			} );

		} )

		function sc() {
			$( " .box table tr" ).eq( $( this ).index() ).remove();
		}
	</script>
</head>

<body leftmargin="30">

	<?php require_once("../include/db_info.inc.php");?>
	<?php require_once("admin-header.php");
if (!(isset($_SESSION['administrator'])||isset($_SESSION['problem_editor']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
	//表单提交多个元素，数组内容
	// https://blog.csdn.net/wanghongbiao1993/article/details/70229006
	//动态添加删除表单元素 https://blog.csdn.net/ting119/article/details/79844779
}
?>
	<h2>编辑题单数据</h2>
	<form method="post" action="td_edit_post.php">
		<div class="form-group">
			<label>题单标题</label>
			<input type="text" class="form-control" name="tidan" placeholder="题单标题" value="<?php echo $tdtie?>">
		</div>

		<div class="box">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<th width="20%">题目类别名称</th>
					<th width="70%">题目编号</th>
					<th width="10%">增减</th>
				</tr>
				<?php
				foreach ( $view_td as $row ) {
					echo "<tr>
					<td><input type='text' class='form-control' name='$row[2]title' placeholder='题目类别名称' value='$row[0]'>
					</td>
					<td><input type='text' class='form-control' name='$row[2]num' placeholder='输入编号' value='$row[1]'>
					</td>
					<td><a class='shanchu' onclick='sc()'>删除</a></td>
				</tr>";
				}
				?>
				</tbody>
			</table>

			<div class="tianjia"><a class="btn btn-link">添加一行</a>
			</div>
		删除和增加只对最后一行有效
		</div>
		<br>

		<?php require_once("../include/set_post_key.php");?>
		<button type="submit" class="btn btn-success">修改题单数据</button>
	</form>

	<?php require_once("../oj-footer.php");?>
</body>

</html>