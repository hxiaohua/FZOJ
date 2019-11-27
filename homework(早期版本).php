<?php
	$OJ_CACHE_SHARE=!isset($_GET['hid']);
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/my_func.inc.php');
	require_once('./include/const.inc.php');
	require_once('./include/setlang.php');
	
	header("Content-type: text/html; charset=utf-8"); 
	$view_title= "作业系统";
	$view_title="作业系统";
  function formatTimeLength($length)
{
	$hour = 0;
	$minute = 0;
	$second = 0;
	$result = '';
	
	if ($length >= 60)
	{
		$second = $length % 60;
		if ($second > 0)
		{
			$result = $second . '秒';
		}
		$length = floor($length / 60);
		if ($length >= 60)
		{
			$minute = $length % 60;
			if ($minute == 0)
			{
				if ($result != '')
				{
					$result = '0分' . $result;
				}
			}
			else
			{
				$result = $minute . '分' . $result;
			}
			$length = floor($length / 60);
			if ($length >= 24)
			{
				$hour = $length % 24;
				if ($hour == 0)
				{
					if ($result != '')
					{
						$result = '0小时' . $result;
					}
				}
				else
				{
					$result = $hour . '小时' . $result;
				}
				$length = floor($length / 24);
				$result = $length . '天' . $result;
			}
			else
			{
				$result = $length . '小时' . $result;
			}
		}
		else
		{
			$result = $length . '分' . $result;
		}
	}
	else
	{
		$result = $length . '秒';
	}
	return $result;
}

	if (isset($_GET['hid'])){
			$hid=intval($_GET['hid']);
			$view_hid=$hid;
		//	echo $hid;
		//提前让用户登录，避免未登录加入比赛或者作业
		 if (!isset($_SESSION['user_id'])){
			 $view_errors= "<a href=loginpage.php>$MSG_Login</a>";
			 require("template/".$OJ_TEMPLATE."/error.php");
			 exit(0);
			 } 
				//新增，用户加入某一测试中，真实姓名，存入数据库
			if(isset($_POST['realname'])) {
					$realname=$_POST['realname'];
					//检测是否是中文名字，不是的话，继续输入
					if(!preg_match("/^[\x{4e00}-\x{9fa5}]{2,4}$/u",$realname)) 
					//UTF-8汉字字母数字下划线正则表达式
					 { 
								echo "<script language=\"javascript\"> //
								alert(\"请输入2-4位中文名，谢谢！\");
								history.go(-1);
								</script>"; 
								exit(0); 
					}
					else//名字正确将用户加入，将用户加入排名与权限的数据库 
					{//编码与处理
						$realname=mysqli_real_escape_string($mysqli,htmlentities ($realname,ENT_QUOTES,"UTF-8"));
						//UPDATE `users` SET `name`='黄小琥' WHERE (`user_id`='hxh')
						$uid=$_SESSION['user_id'];
						$sql="UPDATE `users` SET `name`='$realname' WHERE (`user_id`='$uid')";
						//$sql="UPDATE INTO `users` (`user_id`, `name`) VALUES ('$uid','$realname')";
						mysqli_query($mysqli,$sql);
					}
			}
			/*
			//用户点击一次就将用户加入在比赛中，注销就在管理界面加入用户名字
			$uid=$_SESSION['user_id'];
			$sql="INSERT INTO `privilege` (`user_id`, `rightstr`)  VALUES ('$uid','c$hid')";
			mysqli_query($mysqli,$sql);
			*/
				//新增结束
				//检测到用户不允许进入作业，可能的原因有很多，设置密码或者真实姓名不存在
				//首先，检测用户真实姓名是否存在
				if(!isset($_SESSION['administrator'])){//管理免密码登录
					$uid=$_SESSION['user_id'];
					$sql="SELECT name FROM `users` WHERE `user_id`='$uid'";
					$result=mysqli_query($mysqli,$sql);
					$row=mysqli_fetch_array($result);
					if ($row[0]==null){
								 $view_errors=  "<h2>请输入您的真实姓名来加入作业\t\t<a href=homerank.php?hid=$hid>完成状态</a></h2>";
            					 $view_errors.=  "<form method=post action='homework.php?hid=$hid'>
								 <h4>你的真实姓名</h4>
								 <input class=input-mini type=text name=realname><br />
								 <input class=btn type=submit value=\"确认进入\"></form>
								 <br />输入错误将无法修改，请核对无误后确认进入！";
								require("template/".$OJ_TEMPLATE."/error.php");
								exit(0);
					}
				}
			//上面是我新建的检测用户真实姓名
			// check homework valid
			$sql="SELECT * FROM `homework` WHERE `homework_id`='$hid'";
			$result=mysqli_query($mysqli,$sql);
				//获取重判新增
			$myre=mysqli_query($mysqli,$sql);
			$myrow=mysqli_fetch_assoc($myre);
			$recheck=$myrow['recheck'];
			$rows_cnt=mysqli_num_rows($result);
			$homework_ok=true;
		    $password="";	
		    if(isset($_POST['password'])) 
				$password=$_POST['password'];
			
			if (get_magic_quotes_gpc ()) {
			        $password = stripslashes ( $password);
			}
			if ($rows_cnt==0){
				mysqli_free_result($result);
				$view_title= "比赛已经关闭!";
			}else{
				$row=mysqli_fetch_object($result);
				$view_private=$row->private;
				if($password!=""&&$password==$row->password) $_SESSION['h'.$hid]=true;
				if ($row->private && !isset($_SESSION['h'.$hid])) $homework_ok=false;
				if ($row->defunct=='Y') $homework_ok=false;
				if (isset($_SESSION['administrator'])) 
				$homework_ok=true;		
				$now=time();
				$start_time=strtotime($row->start_time);
				$end_time=strtotime($row->end_time);
				$view_description=$row->description;
				$view_title= $row->title;
				$view_start_time=$row->start_time;
				$view_end_time=$row->end_time;

				if (!isset($_SESSION['administrator']) && $now<$start_time){
					$view_errors=  "<h2>$MSG_PRIVATE_WARNING</h2>";
					require("template/".$OJ_TEMPLATE."/error.php");
					exit(0);
				}
			}
			if (!$homework_ok){
            			 $view_errors=  "<h2>$MSG_PRIVATE_WARNING <br><a href=homeworkrank.php?hid=$hid>$MSG_WATCH_RANK</a></h2>";
            			 $view_errors.=  "<form method=post action='homework.php?hid=$hid'>$MSG_homework $MSG_PASSWORD:<input class=input-mini type=password name=password><input class=btn type=submit></form>";
				require("template/".$OJ_TEMPLATE."/error.php");
				exit(0);
			}
			//抽取题目，进行显示出来，但是有问题
			$sql="select * from (SELECT `problem`.`title` as `title`,`problem`.`problem_id` as `pid`,source as source,homework_problem.num as pnum

		FROM `homework_problem`,`problem`

		WHERE `homework_problem`.`problem_id`=`problem`.`problem_id` 

		AND `homework_problem`.`homework_id`=$hid ORDER BY `homework_problem`.`num` 
                ) problem
                left join (select problem_id pid1,count(distinct(user_id)) accepted from solution where result=4 group by pid1) p1 on problem.pid=p1.pid1
                left join (select problem_id pid2,count(1) submit from solution group by pid2) p2 on problem.pid=p2.pid2
		order by pnum
                
                ";//AND `problem`.`defunct`='N'
				//上面的数据库，可以先尝试执行sql语句，不断调整优化
			$result=mysqli_query($mysqli,$sql);
			$view_problemset=Array();
			$cnt=0;
			while ($row=mysqli_fetch_object($result)){	
				$view_problemset[$cnt][0]="";
				if (isset($_SESSION['user_id'])) 
					$view_problemset[$cnt][0]=check_isac($hid,$cnt);
					//检查作业是否Ac，还需要判断是否重新判题目
				$view_problemset[$cnt][1]= "$row->pid Problem &nbsp;".$PID[$cnt];
				//只需要获取题目id，即可接着显示就行了
				$sql_ans="select problem_id from homework_problem where homework_id='$hid' and num='$cnt'";
				$ans=mysqli_query($mysqli,$sql_ans);
				$ansrow=mysqli_fetch_row($ans);
				//problem.php?id=$ansrow[0]
				$view_problemset[$cnt][2]= "<a href='problem.php?id=$ansrow[0]'>$row->title</a>";
				//重判就在后面加上作业的id，否则不需要加入hid在后面get即可
				if($recheck=='Y')	
					$view_problemset[$cnt][2]= "<a href='problem.php?id=$ansrow[0]&hid=$hid'>$row->title</a>";
				$view_problemset[$cnt][3]=$row->source ;
				$view_problemset[$cnt][4]=$row->accepted ;
				$view_problemset[$cnt][5]=$row->submit ;
				$cnt++;
			}
			mysqli_free_result($result);
}
//没有获取到hid的处理手段
else{
  $keyword="";
  if(isset($_POST['keyword'])){
      $keyword=mysqli_real_escape_string($mysqli,$_POST['keyword']);
  }
  //echo "$keyword";
  $myhomeworks="";
  foreach($_SESSION as $key => $value){
      if(($key[0]=='k'||$key[0]=='h')&&intval(substr($key,1))>0){
//      echo substr($key,1)."<br>";
         $myhomeworks.=",".intval(substr($key,1));
      }
  }
  if(strlen($myhomeworks)>0)
	  $myhomeworks=substr($myhomeworks,1);
//  echo "$myhomeworks";
  $wheremy="";
  if(isset($_GET['my'])) 
	  $wheremy=" and homework_id in ($myhomeworks)";
  $sql="SELECT * FROM `homework` WHERE `defunct`='N' ORDER BY `homework_id` DESC";//此处删除limit 0,1000
  $sql="select *  from homework left join (select * from privilege where rightstr like 'k%') p on concat('k',homework_id)=rightstr where homework.defunct='N' and homework.title like '%$keyword%' $wheremy  order by homework_id desc;";//删除限制limit 0,1000
			$result=mysqli_query($mysqli,$sql);
			$view_homework=Array();
			$i=0;
			while ($row=mysqli_fetch_object($result)){			
				$view_homework[$i][0]= $row->homework_id;
				$view_homework[$i][1]= "<a href='homework.php?hid=$row->homework_id'>$row->title</a>";
				$start_time=strtotime($row->start_time);
				$end_time=strtotime($row->end_time);
				$now=time();                               
        $length=$end_time-$start_time;
        $left=$end_time-$now;
	// past

  if ($now>$end_time) {
  	$view_homework[$i][2]= "<span class=green>$MSG_Ended@$row->end_time</span>";
	
	// pending

  }else if ($now<$start_time){
  	$view_homework[$i][2]= "<span class=blue>$MSG_Start@$row->start_time</span>&nbsp;";
    $view_homework[$i][2].= "<span class=green>$MSG_TotalTime".formatTimeLength($length)."</span>";
	// running

  }else{
  	$view_homework[$i][2]= "<span class=red> $MSG_Running</font>&nbsp;";
    $view_homework[$i][2].= "<span class=green> $MSG_LeftTime ".formatTimeLength($left)." </span>";
  }
				$private=intval($row->private);
				if ($private==0)
                        $view_homework[$i][4]= "<span class=blue>$MSG_Public</span>";
                    else
                        $view_homework[$i][5]= "<span class=red>$MSG_Private</span>";
				$view_homework[$i][6]=$row->user_id;//作业创建者，没有显示
				$i++;
			}
			mysqli_free_result($result);
}
//根据是否测试的id，选用不同的前台界面
/////////////////////////Template
if(isset($_GET['hid']))
	require("template/".$OJ_TEMPLATE."/homework.php");
else					
	require("template/".$OJ_TEMPLATE."/homeworkset.php");//不含测试id，显示各个测试
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>
