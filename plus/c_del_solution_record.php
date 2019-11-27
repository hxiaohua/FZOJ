<?php 
	require_once("../include/db_info.inc.php");

	if ( isset($_GET['id']) ){
		$id = $_GET['id'];
		$sql = "delete from solution_record where id = ".$id;
		
		mysqli_query($mysqli,$sql);
		
		echo '<script>alert("delete '.$id.' success!");</script>';
	}
	
	
	echo '<script>history.back();</script>';
		/*//redirect('/','refresh');*/
?>