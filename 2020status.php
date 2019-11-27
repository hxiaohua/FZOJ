<?php
require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
header("Content-type: text/html; charset=utf-8"); 
$in = "1381,1910,1382,1254,1926,1927,1928,1389,1383,1929,1930,1931,1391,1932,1933,1934,1935,1936,1937,1938,1939,1063,1118,1450,1338,1064,1431,1442,1957,1019,1049,1062,1064,1067,1070,1071,1088,1100,1101,1102,1110,1219,1785,1886";
$pid = explode(",",$in);
$pnum = 0;
while($pid[$pnum]>0) $pnum++;

$users = "张成玺 G20201234,苏新宇 c20170821,莫安柯 c20170415,郭延西 c20170804,彭希月 c20170817";
$encode = mb_detect_encoding($users, 'UTF-8', true);
if(!$encode){
	$temp = iconv("gbk","utf-8", $users);
	if($temp) $users = $temp;
}

$user = explode(",",$users);

echo '<table border="1">';
echo "<tr><th></th><th></th>";
for($i=0; $i<$pnum; $i++){
	echo '<th><a href=problem.php?id='.$pid[$i].' target=_blank>'.$pid[$i]."</a></th>";
}
echo "</tr>";
$i = 0;
while(strlen($user[$i])>8){
	$name = substr($user[$i], 0, strpos($user[$i], ' '));
	$id = substr($user[$i], strpos($user[$i], ' ')+1);

	//echo $user[$i]."<br>";
	//echo $name."<br>";
	//$id = intval($user[$i]);
	//echo $id."<br>";
	//$sql = "update crx_users set nick = '$name' where user_id like '%$id%'";
	//mysql_query($sql);
	$sql = "select DISTINCT `problem_id` from solution where `result` = 4 and `user_id` like '%$id%'";
	if($in) $sql = $sql . "and problem_id in($in)";
	$result = mysqli_query($mysqli,$sql);
	$pids = '';
	while ($row=mysqli_fetch_array($result)){
		$pids = $pids . ' {' . $row[0] . '} ';
	}
	echo "<tr><td>$name</td><td><a href= userinfo.php?user=$id>$id</a></td>";
	for($j=0; $j<$pnum; $j++){
		$temp = '{' . $pid[$j] . '}';
		if(strpos($pids, $temp)) echo "<td>1</td>";
		else echo "<td bgcolor = 'red'>0</td>";
	}
	echo "</tr>";
	$i++;
}
echo "</table>";
	//die($pid[5].$pnum);

?>