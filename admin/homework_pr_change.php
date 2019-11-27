<?php require_once("admin-header.php");
require_once("../include/check_get_key.php");
$hid=intval($_GET['hid']);
	if(!(isset($_SESSION["m$hid"])||isset($_SESSION['administrator']))) exit();
$sql="select `private` FROM `homework` WHERE `homework_id`=$hid";
$result=mysqli_query($mysqli,$sql);
$num=mysqli_num_rows($result);
if ($num<1){
	mysqli_free_result($result);
	echo "No Such Problem!";
	require_once("../oj-footer.php");
	exit(0);
}
$row=mysqli_fetch_row($result);
if (intval($row[0])==0) $sql="UPDATE `homework` SET `private`='1' WHERE `homework_id`=$hid";
else $sql="UPDATE `homework` SET `private`='0' WHERE `homework_id`=$hid";
mysqli_free_result($result);
mysqli_query($mysqli,$sql);
?>
<script language=javascript>
	history.go(-1);
</script>

