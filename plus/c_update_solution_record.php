<?php 
	require_once("../include/db_info.inc.php");

	$title = isset($_POST['title']) ? $_POST['title'] : null;
	$isfzoj = isset($_POST['isfzoj']) ? $_POST['isfzoj'] : null;
	$url = isset($_POST['url']) ? $_POST['url'] : null;
	$source = isset($_POST['source']) ? $_POST['source'] : null;
	$problem_id = isset($_POST['problem_id']) ? $_POST['problem_id'] : null;
	$description = isset($_POST['description']) ? $_POST['description'] : null;
	$solution = isset($_POST['solution']) ? $_POST['solution'] : null;
	$status = isset($_POST['status']) ? $_POST['status'] : null;
	$tags = isset($_POST['tags']) ? $_POST['tags'] : null;
	$notes = isset($_POST['notes']) ? $_POST['notes'] : null;
	$id = isset($_POST['id']) ? $_POST['id'] : null;
	if (get_magic_quotes_gpc ()) {
		$title = stripslashes ( $title);
		$isfzoj = stripslashes ( $isfzoj);
		$url = stripslashes ( $url);
		$description = stripslashes ( $description);
		$problem_id = stripslashes ( $problem_id);
		$solution = stripslashes ( $solution);
		$status = stripslashes ( $status);
		$tags = stripslashes ( $tags);
		$notes = stripslashes ( $notes);
		$source = stripslashes ( $source);
		$id = stripslashes ( $id);
	}

	$now=strftime("%Y-%m-%d %H:%M",time());
	$user_id=$_SESSION['user_id'];



	$sql = "update solution_record(title,isfzoj,url,description,problem_id,solution,status,notes,source,update_time,user_id,tags) "
						."value('$title','$isfzoj','$url','$description','$problem_id','$solution','$status','$notes','$source','$now','$user_id','$tags')"
						."where id='$id'";
	/*
	$sql = "update solution_record set"
		."title = '$title'"
		.",isfzoj = '$isfzoj'"
		.",url = '$url'"
		.",description = '$description'"
		.",problem_id = '$problem_id'"
		.",solution = '$solution'"
		.",status = '$status'"
		.",notes = '$notes'"
		.",source = '$source'"
		.",update_time = '$now'"
		.",user_id = '$user_id'"
		.",tags = '$tags'"
		."where id='$id'";
*/
		$sql = "update solution_record set title='$title',isfzoj = '$isfzoj',url = '$url',description = '$description',problem_id = '$problem_id',solution = '$solution',status = '$status',notes = '$notes',source = '$source',update_time = '$now',user_id = '$user_id',tags = '$tags' where id='$id'";
	echo $sql;

	mysqli_query($mysqli,$sql);
	
	echo '<script>alert("update success!");</script>';
	echo '<script>history.back();</script>';
		/*//redirect('/','refresh');*/
?>