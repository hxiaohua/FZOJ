<?php
	$OJ_CACHE_SHARE=!isset($_GET['cid']);
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/my_func.inc.php');
	require_once('./include/const.inc.php');
	require_once('./include/setlang.php');
	
	header("Content-type: text/html; charset=utf-8"); 
	$view_title= $MSG_CONTEST;
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

	if (isset($_GET['cid'])){
			$cid=intval($_GET['cid']);
			$view_cid=$cid;
		//	print $cid;
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
					{
						$realname=mysqli_real_escape_string($mysqli,htmlentities ($realname,ENT_QUOTES,"UTF-8"));
						$uid=$_SESSION['user_id'];
						$sql="UPDATE `users` SET `name`='$realname' WHERE (`user_id`='$uid')";
						mysqli_query($mysqli,$sql);
					}
			}
			/*
			//用户点击一次就将用户加入在比赛中，注销就在管理界面加入用户名字
			$uid=$_SESSION['user_id'];
			$sql="INSERT INTO `privilege` (`user_id`, `rightstr`)  VALUES ('$uid','c$cid')";
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
								 $view_errors=  "<h2>请输入您的真实姓名来加入作业\t\t<a href=contestrank.php?cid=$cid>只看排名</a></h2>";
            					 $view_errors.=  "<form method=post action='contest.php?cid=$cid'>
								 <h4>你的真实姓名</h4>
								 <input class=input-mini type=text name=realname><br />
								 <input class=btn type=submit value=\"确认进入\"></form>
								 <br />输入错误将无法修改，请核对无误后确认进入！";
								require("template/".$OJ_TEMPLATE."/error.php");
								exit(0);
					}
				}
			//上面是我新建的检测用户真实姓名
			// check contest valid
			$sql="SELECT * FROM `contest` WHERE `contest_id`='$cid' ";
			$result=mysqli_query($mysqli,$sql);
			$rows_cnt=mysqli_num_rows($result);
			$contest_ok=true;
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
				if($password!=""&&$password==$row->password) $_SESSION['c'.$cid]=true;
				if ($row->private && !isset($_SESSION['c'.$cid])) $contest_ok=false;
				if ($row->defunct=='Y') $contest_ok=false;
				if (isset($_SESSION['administrator'])) 
				$contest_ok=true;		
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
			if (!$contest_ok){
            			 $view_errors=  "<h2>$MSG_PRIVATE_WARNING <br><a href=contestrank.php?cid=$cid>$MSG_WATCH_RANK</a></h2>";
            			 $view_errors.=  "<form method=post action='contest.php?cid=$cid'>$MSG_CONTEST $MSG_PASSWORD:<input class=input-mini type=password name=password><input class=btn type=submit></form>";
				require("template/".$OJ_TEMPLATE."/error.php");
				exit(0);
			}
			$sql="select * from (SELECT `problem`.`title` as `title`,`problem`.`problem_id` as `pid`,source as source,contest_problem.num as pnum

		FROM `contest_problem`,`problem`

		WHERE `contest_problem`.`problem_id`=`problem`.`problem_id` 

		AND `contest_problem`.`contest_id`=$cid ORDER BY `contest_problem`.`num` 
                ) problem
                left join (select problem_id pid1,count(distinct(user_id)) accepted from solution where result=4 and contest_id=$cid group by pid1) p1 on problem.pid=p1.pid1
                left join (select problem_id pid2,count(1) submit from solution where contest_id=$cid  group by pid2) p2 on problem.pid=p2.pid2
		order by pnum
                
                ";//AND `problem`.`defunct`='N'

		
			$result=mysqli_query($mysqli,$sql);
			$view_problemset=Array();
			
			$cnt=0;
			while ($row=mysqli_fetch_object($result)){
				
				$view_problemset[$cnt][0]="";
				if (isset($_SESSION['user_id'])) 
					$view_problemset[$cnt][0]=check_ac($cid,$cnt);
				$view_problemset[$cnt][1]= "$row->pid Problem &nbsp;".$PID[$cnt];
				$view_problemset[$cnt][2]= "<a href='problem.php?cid=$cid&pid=$cnt'>$row->title</a>";
				$view_problemset[$cnt][3]=$row->source ;
				$view_problemset[$cnt][4]=$row->accepted ;
				$view_problemset[$cnt][5]=$row->submit ;
				$cnt++;
			}
		
			mysqli_free_result($result);

}else{
  $keyword="";
  if(isset($_POST['keyword'])){
      $keyword=mysqli_real_escape_string($mysqli,$_POST['keyword']);
  }
  //echo "$keyword";
  $mycontests="";
  foreach($_SESSION as $key => $value){
      if(($key[0]=='m'||$key[0]=='c')&&intval(substr($key,1))>0){
//      echo substr($key,1)."<br>";
         $mycontests.=",".intval(substr($key,1));
      }
  }
  if(strlen($mycontests)>0) $mycontests=substr($mycontests,1);
//  echo "$mycontests";
  $wheremy="";
  if(isset($_GET['my'])) $wheremy=" and contest_id in ($mycontests)";


  $sql="SELECT * FROM `contest` WHERE `defunct`='N' ORDER BY `contest_id` DESC limit 1000";
  $sql="select *  from contest left join (select * from privilege where rightstr like 'm%') p on concat('m',contest_id)=rightstr where contest.defunct='N' and contest.title like '%$keyword%' $wheremy  order by contest_id desc limit 1000;";
			$result=mysqli_query($mysqli,$sql);
			
			$view_contest=Array();
			$i=0;
			while ($row=mysqli_fetch_object($result)){
				
				$view_contest[$i][0]= $row->contest_id;
				$view_contest[$i][1]= "<a href='contest.php?cid=$row->contest_id'>$row->title</a>";
				$start_time=strtotime($row->start_time);
				$end_time=strtotime($row->end_time);
				$now=time();
                                
                                
        $length=$end_time-$start_time;
        $left=$end_time-$now;
	// past

  if ($now>$end_time) {
  	$view_contest[$i][2]= "<span class=green>$MSG_Ended@$row->end_time</span>";
	
	// pending

  }else if ($now<$start_time){
  	$view_contest[$i][2]= "<span class=blue>$MSG_Start@$row->start_time</span>&nbsp;";
    $view_contest[$i][2].= "<span class=green>$MSG_TotalTime".formatTimeLength($length)."</span>";
	// running

  }else{
  	$view_contest[$i][2]= "<span class=red> $MSG_Running</font>&nbsp;";
    $view_contest[$i][2].= "<span class=green> $MSG_LeftTime ".formatTimeLength($left)." </span>";
  }
                                
                                
                                
                                
				
				$private=intval($row->private);
				if ($private==0)
					$view_contest[$i][4]= "<span class=blue>$MSG_Public</span>";
                else
					$view_contest[$i][5]= "<span class=red>$MSG_Private</span>";
				$view_contest[$i][6]=$row->user_id;
				$i++;
			}
			
			mysqli_free_result($result);

}

//根据是否测试的id，选用不同的前台界面
/////////////////////////Template
if(isset($_GET['cid']))
	require("template/".$OJ_TEMPLATE."/contest.php");
else					
	require("template/".$OJ_TEMPLATE."/contestset.php");//不含测试id，显示各个测试
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>
