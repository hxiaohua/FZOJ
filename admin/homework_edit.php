<?php require("admin-header.php");
include_once("kindeditor.php") ;
include_once("../lang/en.php");
include_once("../include/const.inc.php");
$recheck='N';//全局变量，默认不重判
if (isset($_POST['syear']))
{
	require_once("../include/check_post_key.php");
	
	$starttime=intval($_POST['syear'])."-".intval($_POST['smonth'])."-".intval($_POST['sday'])." ".intval($_POST['shour']).":".intval($_POST['sminute']).":00";
	$endtime=intval($_POST['eyear'])."-".intval($_POST['emonth'])."-".intval($_POST['eday'])." ".intval($_POST['ehour']).":".intval($_POST['eminute']).":00";
//	echo $starttime;
//	echo $endtime;
	 
        $title=mysqli_real_escape_string($mysqli,$_POST['title']);
        $password=mysqli_real_escape_string($mysqli,$_POST['password']);
        $description=mysqli_real_escape_string($mysqli,$_POST['description']);
        $private=mysqli_real_escape_string($mysqli,$_POST['private']);
        if (get_magic_quotes_gpc ()) {
      		  $title = stripslashes ( $title);
	          $password = stripslashes ( $password);
        //$description = stripslashes ( $description);
        }

   $lang=$_POST['lang'];
   $langmask=0;
   foreach($lang as $t){
			$langmask+=1<<$t;
	} 
	$langmask=((1<<count($language_ext))-1)&(~$langmask);
	echo $langmask;	

	$hid=intval($_POST['hid']);
	if(!(isset($_SESSION["k$hid"])||isset($_SESSION['administrator']))) exit();
	$sql="UPDATE `homework` set `title`='$title',description='$description',`start_time`='$starttime',`end_time`='$endtime',`private`='$private',`langmask`=$langmask  ,password='$password' WHERE `homework_id`=$hid";
	//是否重判添加进来
	if(isset($_POST['recheck']))
		$recheck='Y';
	$sql="UPDATE `homework` set `title`='$title',description='$description',`start_time`='$starttime',`end_time`='$endtime',`private`='$private',`langmask`=$langmask  ,password='$password', `recheck`='$recheck' WHERE `homework_id`=$hid";
	//echo $sql;
	mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
	$sql="DELETE FROM `homework_problem` WHERE `homework_id`=$hid";
	mysqli_query($mysqli,$sql);
	$plist=trim($_POST['cproblem']);
	$pieces = explode(',', $plist);
	if (count($pieces)>0 && strlen($pieces[0])>0){
		$sql_1="INSERT INTO `homework_problem`(`homework_id`,`problem_id`,`num`) 
			VALUES ('$hid','$pieces[0]',0)";
		for ($i=1;$i<count($pieces);$i++)
			$sql_1=$sql_1.",('$hid','$pieces[$i]',$i)";
		mysqli_query($mysqli,"update solution set num=-1 where homework_id=$hid");
		for ($i=0;$i<count($pieces);$i++){
			$sql_2="update solution set num='$i' where homework_id='$hid' and problem_id='$pieces[$i]';";
			mysqli_query($mysqli,$sql_2);
		}
		//echo $sql_1;
		mysqli_query($mysqli,$sql_1) or die(mysqli_error($mysqli));
		$sql="update `problem` set defunct='N' where `problem_id` in ($plist)";
		mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
	
	}
	//添加用户权限，首先删除所有用户，接着逐一添加
	$sql="DELETE FROM `privilege` WHERE `rightstr`='h$hid'";
	mysqli_query($mysqli,$sql);
	$pieces = explode("\n", trim($_POST['ulist']));
	if (count($pieces)>0 && strlen($pieces[0])>0){
		$sql_1="INSERT INTO `privilege`(`user_id`,`rightstr`) 
			VALUES ('".trim($pieces[0])."','h$hid')";
		for ($i=1;$i<count($pieces);$i++)
			$sql_1=$sql_1.",('".trim($pieces[$i])."','h$hid')";
		//echo $sql_1;
		mysqli_query($mysqli,$sql_1) or die(mysqli_error($mysqli));
	}
	//添加用户真实名字，不用删除，直接插入即可，插入失败的就选用更新操作
	$stuname = explode("\n", trim($_POST['uname']));
	//应以用户真实姓名为准，当没有输入用户姓名时，不做更新操作。
	if (count($stuname)>0 && strlen($stuname[0])>0){
		for ($i=0;$i<count($pieces);$i++)
		{
			$stuname[$i]=mysqli_real_escape_string($mysqli,htmlentities ($stuname[$i],ENT_QUOTES,"UTF-8"));
			$sql_1="select * from users where user_id='".trim($pieces[$i])."'";
			if(mysqli_query($mysqli,$sql_1))//数据库中找到用户就进行更新
			{
				$sql_1="UPDATE `users` 
				SET `name`='".trim($stuname[$i]).
				"' WHERE (`user_id`='".trim($pieces[$i])."')";
				mysqli_query($mysqli,$sql_1);
			}
		}
	}
	echo "<script>window.location.href=\"homework_list.php\";</script>";
	exit();
}else{
	$hid=intval($_GET['hid']);
	$sql="SELECT * FROM `homework` WHERE `homework_id`=$hid";
	$result=mysqli_query($mysqli,$sql);
	if (mysqli_num_rows($result)!=1){
		mysqli_free_result($result);
		echo "No such homework!";
		exit(0);
	}
	$row=mysqli_fetch_assoc($result);
	$starttime=$row['start_time'];
	$endtime=$row['end_time'];
	$private=$row['private'];
	$password=$row['password'];
	$langmask=$row['langmask'];
	$description=$row['description'];
	//重判新增
	$recheck=$row['recheck'];
	$title=htmlentities($row['title'],ENT_QUOTES,"UTF-8");
	mysqli_free_result($result);
	$plist="";
	$sql="SELECT `problem_id` FROM `homework_problem` WHERE `homework_id`=$hid ORDER BY `num`";
	$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
	for ($i=mysqli_num_rows($result);$i>0;$i--){
		$row=mysqli_fetch_row($result);
		$plist=$plist.$row[0];
		if ($i>1) $plist=$plist.',';
	}
	//show user id
	$ulist="";
	$sql="SELECT `user_id` FROM `privilege` WHERE `rightstr`='h$hid' order by user_id";
	$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
	for ($i=mysqli_num_rows($result);$i>0;$i--){
		$row=mysqli_fetch_row($result);
		$ulist=$ulist.$row[0];
		if ($i>1) $ulist=$ulist."\n";
	}
	//关于学生姓名，也添加进来
	$uname="";
	$sql="select `name` from
	(select privilege.user_id,users.name from privilege left join users on privilege.user_id=users.user_id WHERE `rightstr`='h$hid' order by user_id)as Tabname
	";
	$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
	for ($i=mysqli_num_rows($result);$i>0;$i--){
		$row=mysqli_fetch_row($result);
		$uname=trim($uname.$row[0]);
		if ($i>1) $uname=$uname."\n";
	}
}
?>

<form method=POST >
<?php require_once("../include/set_post_key.php");?>
<p align=center><font size=4 color=#333399>Edit a homework</font></p>
<input type=hidden name='hid' value=<?php echo $hid?>>
<p align=left>Title:<input class=input-xxlarge type=text name=title size=71 value='<?php echo $title?>'></p>
<p align=left>Start Time:<br>&nbsp;&nbsp;&nbsp;
Year:<input class=input-mini  type=text name=syear value=<?php echo substr($starttime,0,4)?> size=4 >
Month:<input class=input-mini  type=text name=smonth value='<?php echo substr($starttime,5,2)?>' size=2 >
Day:<input class=input-mini  type=text name=sday size=2 value='<?php echo substr($starttime,8,2)?>'>
Hour:<input class=input-mini  type=text name=shour size=2 value='<?php echo substr($starttime,11,2)?>'>
Minute:<input class=input-mini  type=text name=sminute size=2 value=<?php echo substr($starttime,14,2)?>></p>
<p align=left>End Time:<br>&nbsp;&nbsp;&nbsp;

Year:<input class=input-mini  type=text name=eyear value=<?php echo substr($endtime,0,4)?> size=4 >
Month:<input class=input-mini  type=text name=emonth value=<?php echo substr($endtime,5,2)?> size=2 >
Day:<input class=input-mini  type=text name=eday size=2 value=<?php echo substr($endtime,8,2)?>>
Hour:<input class=input-mini  type=text name=ehour size=2 value=<?php echo substr($endtime,11,2)?>> 
Minute:<input class=input-mini  type=text name=eminute size=2 value=<?php echo substr($endtime,14,2)?>></p>

Public/Private:<select name=private>
	<option value=0 <?php echo $private=='0'?'selected=selected':''?>>Public</option>
	<option value=1 <?php echo $private=='1'?'selected=selected':''?>>Private</option>
</select>
Password:<input type=text name=password value="<?php echo htmlentities($password,ENT_QUOTES,'utf-8')?>">
<br>Problems:<input class=input-xxlarge type=text size=60 name=cproblem value='<?php echo $plist?>'>

 Language:<select name="lang[]"  multiple="multiple"    style="height:220px">
<?php
$lang_count=count($language_ext);


  $lang=(~((int)$langmask))&((1<<$lang_count)-1);
if(isset($_COOKIE['lastlang'])) $lastlang=$_COOKIE['lastlang'];
 else $lastlang=0;
 for($i=0;$i<$lang_count;$i++){
               
                 echo  "<option value=$i ".( $lang&(1<<$i)?"selected":"").">
                        ".$language_name[$i]."
                 </option>";
  }

?>
	
   </select>
	

<br>
<p align=left>Description:<br>
<textarea class="kindeditor" rows=13 name=description cols=80>
<?php echo htmlentities($description,ENT_QUOTES,"UTF-8")?>
</textarea>
<!--显示是否重重判-->
<br />可选项：<input type="checkbox" name="recheck"
<?php
if($recheck=='Y')
	echo " checked"
?>
>是否重判</input><br /><br />
Users:
<textarea name="ulist" rows="20" cols="20">
<?php if (isset($ulist)) { echo $ulist; } ?>
</textarea>
 <!--添加用户姓名-->
    学生名字:
    <textarea name="uname" rows="20" cols="20">
	<?php
	 if (isset($uname)) { echo $uname; }
	 //加入用户真实姓名信息，进行显示，模仿实现即可
	  ?>
      </textarea>

<h1>				&nbsp;&nbsp;&nbsp;
<input type=submit value=Submit name=submit>
<input type=reset value=Reset name=reset>
</h1>
    学生名字可以不用录入，将会在作业提示学生输入<br />
    如果输入，请左右保持一致，一行中id与姓名相对应
</form>
<?php 
require_once("../oj-footer.php");
?>