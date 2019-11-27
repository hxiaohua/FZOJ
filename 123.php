<?php
	require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
	header("Content-type: text/html; charset=utf-8"); 

$in = "1186,1187,1188,1189,1384";

$in = "1000,1001,1002,1003,1186,1187,1188,1189,1384,1996,1992";
//原来该做而未做的题目列表1205,1423,1579,1581,1071,1632,1072,1618,1407,1410,1239,1428,1581,1572,1594,1606,1667
//$in = file_get_contents('___problems.txt');
$pid = explode(",",$in);//打散功能
$pnum = 0;
while($pid[$pnum]>0) 
	$pnum++;

$users = "张瑞潇 yx20180301,李蕤 yx20180401,熊洪毅 yx20180501,刘思言 yx20190101,杨瀚惟 yx20190102,张垒 yx20190103,潘雪岩 yx20190104,刘锦鑫 yx20190301,任俊 yx20190401,何东辰 yx20190402,秦朗 yx20190403,冯思豪 yx20190501,向芷嫣 yx20190601,杨黄紫蓝 yx20190602,王佳佶 yx20191001,邹钰 yx20191002,邓言曦 yx20191003,徐振宇 yx20191101";



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
