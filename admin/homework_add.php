<?php require_once("admin-header.php");
if(isset($OJ_LANG))
	require_once("../lang/$OJ_LANG.php");
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<title>Add a homework</title>

<?php
	require_once("../include/db_info.inc.php");
	require_once("../include/const.inc.php");

$description="";
 if (isset($_POST['syear']))
{
	
	require_once("../include/check_post_key.php");
	
	$starttime=intval($_POST['syear'])."-".intval($_POST['smonth'])."-".intval($_POST['sday'])." ".intval($_POST['shour']).":".intval($_POST['sminute']).":00";
	$endtime=intval($_POST['eyear'])."-".intval($_POST['emonth'])."-".intval($_POST['eday'])." ".intval($_POST['ehour']).":".intval($_POST['eminute']).":00";
	//	echo $starttime;
	//	echo $endtime;

        $title=$_POST['title'];
        $private=$_POST['private'];
        $password=$_POST['password'];
        $description=$_POST['description'];
        if (get_magic_quotes_gpc ()){
                $title = stripslashes ($title);
                $private = stripslashes ($private);
                $password = stripslashes ($password);
                $description = stripslashes ($description);
        }

        $title=mysqli_real_escape_string($mysqli,$title);
        $private=mysqli_real_escape_string($mysqli,$private);
        $password=mysqli_real_escape_string($mysqli,$password);
        $description=mysqli_real_escape_string($mysqli,$description);


    $lang=$_POST['lang'];
    $langmask=0;
    foreach($lang as $t){
			$langmask+=1<<$t;
	} 
$langmask=((1<<count($language_ext))-1)&(~$langmask);
	//echo $langmask;	
	
        $sql="INSERT INTO `homework`(`title`,`start_time`,`end_time`,`private`,`langmask`,`description`,`password`)
                VALUES('$title','$starttime','$endtime','$private',$langmask,'$description','$password')";
	//新增，是否重判题，如果存在变量，就说明选中，需要进行重判
	if(isset($_POST['reCheck']))
		$sql="INSERT INTO `homework`(`title`,`start_time`,`end_time`,`private`,`langmask`,`description`,`password`,`recheck`)
                VALUES('$title','$starttime','$endtime','$private',$langmask,'$description','$password','Y')";
	echo $sql;
	mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
	$hid=mysqli_insert_id($mysqli);
	echo "Add homework ".$hid;
	$sql="DELETE FROM `homework_problem` WHERE `homework_id`=$hid";
	$plist=trim($_POST['cproblem']);
	$pieces = explode(",",$plist );
	if (count($pieces)>0 && strlen($pieces[0])>0){
		$sql_1="INSERT INTO `homework_problem`(`homework_id`,`problem_id`,`num`) 
			VALUES ('$hid','$pieces[0]',0)";
		for ($i=1;$i<count($pieces);$i++){
			$sql_1=$sql_1.",('$hid','$pieces[$i]',$i)";
		}
		//echo $sql_1;
		mysqli_query($mysqli,$sql_1) or die(mysqli_error($mysqli));
		$sql="update `problem` set defunct='N' where `problem_id` in ($plist)";
		mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
	}
	$sql="DELETE FROM `privilege` WHERE `rightstr`='h$hid'";
	mysqli_query($mysqli,$sql);
	$sql="insert into `privilege` (`user_id`,`rightstr`)  values('".$_SESSION['user_id']."','k$hid')";
	mysqli_query($mysqli,$sql);
	$_SESSION["k$hid"]=true;
	$pieces = explode("\n", trim($_POST['ulist']));
	if (count($pieces)>0 && strlen($pieces[0])>0){
		$sql_1="INSERT INTO `privilege`(`user_id`,`rightstr`) 
			VALUES ('".trim($pieces[0])."','h$hid')";
		for ($i=1;$i<count($pieces);$i++)
			$sql_1=$sql_1.",('".trim($pieces[$i])."','h$hid')";
		//echo $sql_1;
		mysqli_query($mysqli,$sql_1) or die(mysqli_error($mysqli));
	}
	//一一对应关系，更新用户的真实姓名，学生姓名文本区，没有填写就不进行更新操作
	$stuname = explode("\n", trim($_POST['uname']));
	if (count($pieces)>0 && strlen($pieces[0])>0){
		for ($i=0;$i<count($pieces);$i++)
		{
			$stuname[$i]=mysqli_real_escape_string($mysqli,htmlentities ($stuname[$i],ENT_QUOTES,"UTF-8"));
			$sql_1="select * from users where user_id='".trim($pieces[$i])."'";
			if(mysqli_query($mysqli,$sql_1))//找到该用户，更新姓名操作
			{
				$sql_1="UPDATE `users` 
				SET `name`='".trim($stuname[$i]).
				"' WHERE (`user_id`='".trim($pieces[$i])."')";
				mysqli_query($mysqli,$sql_1);
			}
		}
	}
	echo "<script>window.location.href=\"homework_list.php\";</script>";
}
else{
	//来自copy模块，需要先读取数据库
   if(isset($_GET['hid'])){
		   $hid=intval($_GET['hid']);
		   $sql="select * from homework WHERE `homework_id`='$hid'";
		   $result=mysqli_query($mysqli,$sql);
		   $row=mysqli_fetch_object($result);
		   $title=$row->title;
		   mysqli_free_result($result);
			$plist="";
			$sql="SELECT `problem_id` FROM `homework_problem` WHERE `homework_id`=$hid ORDER BY `num`";
			$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
			for ($i=mysqli_num_rows($result);$i>0;$i--){
				$row=mysqli_fetch_row($result);
				$plist=$plist.$row[0];
				if ($i>1) $plist=$plist.',';
			}
			mysqli_free_result($result);
   }
else if(isset($_POST['problem2homework'])){
	   $plist="";
	   //echo $_POST['pid'];
	   sort($_POST['pid']);
	   foreach($_POST['pid'] as $i){		    
			if ($plist) 
				$plist.=','.$i;
			else
				$plist=$i;
	   }
}else if(isset($_GET['spid'])){
	require_once("../include/check_get_key.php");
		   $spid=intval($_GET['spid']);
		 
			$plist="";
			$sql="SELECT `problem_id` FROM `problem` WHERE `problem_id`>=$spid ";
			$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
			for ($i=mysqli_num_rows($result);$i>0;$i--){
				$row=mysqli_fetch_row($result);
				$plist=$plist.$row[0];
				if ($i>1) $plist=$plist.',';
			}
			mysqli_free_result($result);
}  
  include_once("kindeditor.php") ;
?>
	
	<form method=POST >
	<p align=center><font size=4 color=#333399>Add a homework</font></p>
	<p align=left>Title:<input class=input-xxlarge  type=text name=title size=71 value="<?php echo isset($title)?$title:""?>"></p>
	<p align=left>Start Time:<br>&nbsp;&nbsp;&nbsp;
	Year:<input  class=input-mini type=text name=syear value=<?php echo date('Y')?> size=4 >
	Month:<input class=input-mini  type=text name=smonth value=<?php echo date('m')?> size=2 >
	Day:<input class=input-mini type=text name=sday size=2 value=<?php echo date('d')?> >&nbsp;
	Hour:<input class=input-mini    type=text name=shour size=2 value=<?php echo date('H')?>>&nbsp;
	Minute:<input class=input-mini    type=text name=sminute value=00 size=2 ></p>
	<p align=left>End Time:<br>&nbsp;&nbsp;&nbsp;
	Year:<input class=input-mini    type=text name=eyear value=<?php echo date('Y')?> size=4 >
	Month:<input class=input-mini    type=text name=emonth value=<?php echo date('m')?> size=2 >
	
	Day:<input class=input-mini  type=text name=eday size=2 value=<?php echo date('d')+(date('H')+4>23?1:0)?>>&nbsp;
	Hour:<input class=input-mini  type=text name=ehour size=2 value=<?php echo (date('H')+4)%24?>>&nbsp;
	Minute:<input class=input-mini  type=text name=eminute value=00 size=2 ></p>
	Public:<select name=private><option value=0>Public</option><option value=1>Private</option></select>
	Password:<input type=text name=password value="">
	Language:<select name="lang[]" multiple="multiple"    style="height:220px">
	<?php
$lang_count=count($language_ext);

 $langmask=$OJ_LANGMASK;

 for($i=0;$i<$lang_count;$i++){
                 echo "<option value=$i selected>
                        ".$language_name[$i]."
                 </option>";
  }

?>


        </select>
	<?php require_once("../include/set_post_key.php");?>
	<br>Problems:
    <input class=input-xxlarge placeholder="Example:1000,1001,1002" type=text size=60 name=cproblem value="<?php echo isset($plist)?$plist:""?>">
	<br>

    <p align="left">Description:<br>
     
<!--    <textarea class=kindeditor rows=13 name=description cols=80>
    </textarea>
富文本编辑器已经被注释，如需恢复，请取消注释本区域内代码
-->
        
 <!--修正为markdown-->
    <!--markdown引入样式文件-->
<link rel="stylesheet" href="../markdown/css/editormd.min.css" />
      <div id="editor"> 
    <!-- Tips: Editor.md can auto append a `<textarea>` tag -->
    <textarea style="display:none;" name="description"><?php echo $description;?></textarea>
        </div>
  <script src="../markdown/examples/js/jquery.min.js"></script> 
  <script src="../markdown/editormd.js"></script> 
  <script>
    $(function() {
        var testEditor = editormd("editor",{
            width:"90%",
            height : 500,
            path:"../markdown/lib/",//设置文件保存的路径
            imageUpload : true,
            imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL : "../kindeditor/php/upload_mk_json.php",
        })
    });
</script> <!--修正为markdown-->  
    </p>
	&nbsp;&nbsp;&nbsp;可选项：<input type="checkbox" name="reCheck">是否重判</input><br />
    Users:
    <textarea name="ulist" rows="20" cols="20"></textarea>
    <!--添加用户姓名-->
    学生名字:
    <textarea name="uname" rows="20" cols="20"></textarea>
	<br />
   
	<p><input type=submit value=Submit name=submit>
    <input type=reset value=Reset name=reset>
    </p>
    学生姓名可以不填，如果填写需要id与姓名在一行对应起来<br />
    *可以将学生学号从Excel整列复制过来，然后要求他们用学号做UserID注册,就能进入Private的比赛作为作业和测验。
	</form>
<?php }
require_once("../oj-footer.php");

?>

