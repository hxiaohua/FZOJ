<?php 
	require_once("../include/db_info.inc.php");

	if ( isset($_GET['user_id']) ){
		$user_id = $_GET['user_id'];
		$sql="SELECT id  FROM 'solution_record' where 'user_id' = '$user_id' ";
		$sql="SELECT *  FROM `solution_record` where `user_id` = '$user_id'  ";
		//$sql="SELECT max(`problem_id`) as upid FROM `problem`";
		//echo $sql;	
		$result=mysqli_query($mysqli,$sql);
	//	var_dump($result);

		/*end select*/


		/*trun to array begin*/
		$i=0;
		$solution_array = array();
//
		/*
		while ($row=mysqli_fetch_object($result)){
			$solution_array[$i] = array();
			$solution_array[$i][1] = $row ->title;


			$i++;

		}
		*/
		require("show_solution_record.php");

		mysqli_free_result($result);

		/*trun to array end*/

		//var_dump($solution_array);
	}


?>