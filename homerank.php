<?php
	require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
	require_once('./include/my_func.inc.php');
	header("Content-type: text/html; charset=utf-8"); 
	$title="作业完成情况";
	//显示某个作业的完成情况，完全重写，有点乱，没关系不过
	if (isset($_GET['hid'])) 
	{
		$hid=intval($_GET['hid']);
		$TabInfo=Array();//存贮整个表格数据
		$Qnum=Array();//存贮问题编号
		$recheck='N';
		//新增，检测当前作业是重判情况
		$sql="SELECT * FROM `homework` WHERE `homework_id`='$hid' and `recheck`='Y'";
		$result=mysqli_query($mysqli,$sql);
		$r_cnt=mysqli_num_rows($result);
		if($r_cnt)
			$recheck='Y';
		//重判检查结束
		//第一步，当前作业的id
		$sql="select privilege.user_id,users.name 
		from privilege,users
		where privilege.user_id=users.user_id and privilege.rightstr='h$hid'";
		$result = mysqli_query($mysqli,$sql);
		//$rows_cnt=mysqli_num_rows($result);
		$cnt=0;
		while($row=mysqli_fetch_array($result)){
		//返回根据从结果集取得的行生成的数组，如果没有更多行则返回 FALSE。 
		$TabInfo[$cnt][0]=$row['user_id'];
		//echo $TabInfo[$cnt][0];
		$TabInfo[$cnt][1]=$row['name'];
		//echo $TabInfo[$cnt][1];//输出lisks字段
		//echo "<br />";
		$cnt++;
		}
		//前两列数据为id和用户名字
		//查找所有题目
		$sql="SELECT problem_id FROM `homework_problem` where homework_id='$hid'";
		$result = mysqli_query($mysqli,$sql);
		$rows_cnt=mysqli_num_rows($result);
		$cnt=0;
		while($row=mysqli_fetch_array($result)){
		//返回根据从结果集取得的行生成的数组，如果没有更多行则返回 FALSE。 
		$Qnum[$cnt]=$row[0];
		//echo $Qnum[$cnt];
		//echo "<br />";
		$cnt++;
		}
		//echo count($Qnum);
		//接下来看是否ac即可
		$hang=count($TabInfo);
		$lie=count($Qnum);
		for($hh=0;$hh<$hang;$hh++)
		{
			for($ll=0;$ll<$lie;$ll++)
					{
						$TabInfo[$hh][$ll+2]=check_ok($TabInfo[$hh][0],$Qnum[$ll],$hid,$recheck);
						//echo $TabInfo[$hh][$ll+2];
					}
					//echo "<br />";
			//注意检查是否ac，没有就设置颜色
		}
		//表格数据已经生成，直接将其显示即可将其进行显示即可	
		require("template/".$OJ_TEMPLATE."/homerank.php");		
	}
	else//没有获取到id
	echo "请回退上一级";
	exit(0);
	?>