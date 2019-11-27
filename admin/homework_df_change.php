<?php require_once("admin-header.php");
require_once("../include/check_get_key.php");
$hid=intval($_GET['hid']);
	if(!(isset($_SESSION["m$hid"])||isset($_SESSION['administrator']))) exit();
$sql="select `defunct` FROM `homework` WHERE `homework_id`=$hid";
$result=mysqli_query($mysqli,$sql);
$num=mysqli_num_rows($result);
if ($num<1){
	mysqli_free_result($result);
	echo "No Such homework!";
	require_once("../oj-footer.php");
	exit(0);
}
$row=mysqli_fetch_row($result);
if ($row[0]=='N') $sql="UPDATE `homework` SET `defunct`='Y' WHERE `homework_id`=$hid";
else $sql="UPDATE `homework` SET `defunct`='N' WHERE `homework_id`=$hid";
mysqli_free_result($result);
mysqli_query($mysqli,$sql);
?>
<script language=javascript>
	history.go(-1);
</script>

