<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Edit Problem Markdown</title>
</head>
<body>
<center>
<?php require_once("../include/db_info.inc.php");?>
<?php require_once("admin-header.php");

if (!(isset($_SESSION['administrator'])
      ||isset($_SESSION['problem_editor'])
     )){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>

<p align="center"><font color="#333399" size="4">Welcome To Administrator's Page of Judge Online of ACM ICPC, <?php echo $OJ_NAME?>.</font>
<td width="100"></td>
</center>
<hr>
<?php if(isset($_GET['id'])){
;//	require_once("../include/check_get_key.php");
    //markdown提交到自己这里来了，添加也要变化
?>
<h1>Edit problem Markdown</h1>
<form method=POST action=problem_edit_mk.php>
<input type=hidden name=problem_id value=New Problem>
<?php $sql="SELECT * FROM `problem` WHERE `problem_id`=".intval($_GET['id']);
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_object($result);
?>
<p>Problem Id: <?php echo $row->problem_id?></p>
<input type=hidden name=problem_id value='<?php echo $row->problem_id?>'>
<p>Title:<input type=text name=title size=71 value='<?php echo htmlentities($row->title,ENT_QUOTES,"UTF-8")?>'></p>
<p>Time Limit:<input type=text name=time_limit size=20 value='<?php echo $row->time_limit?>'>S</p>
<p>Memory Limit:<input type=text name=memory_limit size=20 value='<?php echo $row->memory_limit?>'>MByte</p>
Description:
    <!--修正为markdown-->
 <?php 
    $description=$row->description;
    require_once("../markdown/markdown_edit.php");
    ?>
    <!--修正为markdown-->
<!--升级为markdown编辑器，保留原来的name，添加hidden标签-->
<input type="hidden" name="input" value=""/>
<input type="hidden" name="output" value=""/>
<input type="hidden" name="sample_input" value=""/>
<input type="hidden" name="sample_output" value=""/>
<input type="hidden" name="test_input" value=""/>
<input type="hidden" name="test_output" value=""/>
<input type="hidden" name="hint" value=""/>

    <!--老的题目改为Markdown 的隐式方法-->
    
SpecialJudge: 
N<input type=radio name=spj value='0' <?php echo $row->spj=="0"?"checked":""?>>
Y<input type=radio name=spj value='1' <?php echo $row->spj=="1"?"checked":""?>></p>
<p>Source:<br><textarea name=source rows=1 cols=70><?php echo htmlentities($row->source,ENT_QUOTES,"UTF-8")?></textarea></p>
<div align=center>
<?php require_once("../include/set_post_key.php");?>
<input type=submit value=Submit name=submit>
</div></form>
<p>
<?php require_once("../oj-footer.php");?>
<?php }else{
require_once("../include/check_post_key.php");
$id=intval($_POST['problem_id']);
if(!(isset($_SESSION["p$id"])||isset($_SESSION['administrator']))) exit();	
$title=$_POST['title'];
$time_limit=$_POST['time_limit'];
$memory_limit=$_POST['memory_limit'];
$description=$_POST['description'];
$input=$_POST['editor-html-code'];//调整为html的markdown代码
$output=$_POST['output'];
$sample_input=$_POST['sample_input'];
$sample_output=$_POST['sample_output'];
$hint=$_POST['hint'];
$source=$_POST['source'];
$spj=$_POST['spj'];
if (get_magic_quotes_gpc ()) {
	$title = stripslashes ( $title);
	$time_limit = stripslashes ( $time_limit);
	$memory_limit = stripslashes ( $memory_limit);
	$description = stripslashes ( $description);
	$input = stripslashes ( $input);
	$output = stripslashes ( $output);
	$sample_input = stripslashes ( $sample_input);
	$sample_output = stripslashes ( $sample_output);
//	$test_input = stripslashes ( $test_input);
//	$test_output = stripslashes ( $test_output);
	$hint = stripslashes ( $hint);
	$source = stripslashes ( $source); 
	$spj = stripslashes ( $spj);
	$source = stripslashes ( $source );
}
$basedir=$OJ_DATA."/$id";
echo "Sample data file in $basedir Updated!<br>";

	if($sample_input&&file_exists($basedir."/sample.in")){
		//mkdir($basedir);
		$fp=fopen($basedir."/sample.in","w");
		fputs($fp,preg_replace("(\r\n)","\n",$sample_input));
		fclose($fp);
		
		$fp=fopen($basedir."/sample.out","w");
		fputs($fp,preg_replace("(\r\n)","\n",$sample_output));
		fclose($fp);
	}
	$title=mysqli_real_escape_string($mysqli,$title);
	$time_limit=mysqli_real_escape_string($mysqli,$time_limit);
	$memory_limit=mysqli_real_escape_string($mysqli,$memory_limit);
	$description=mysqli_real_escape_string($mysqli,$description);
	$input=mysqli_real_escape_string($mysqli,$input);
	$output=mysqli_real_escape_string($mysqli,$output);
	$sample_input=mysqli_real_escape_string($mysqli,$sample_input);
	$sample_output=mysqli_real_escape_string($mysqli,$sample_output);
//	$test_input=($test_input);
//	$test_output=($test_output);
	$hint=mysqli_real_escape_string($mysqli,$hint);
	$source=mysqli_real_escape_string($mysqli,$source);
	$spj=intval($spj);
	
$sql="UPDATE `problem` set `title`='$title',`time_limit`='$time_limit',`memory_limit`='$memory_limit',`isMarkdown`='1',
	`description`='$description',`input`='$input',`output`='$output',`sample_input`='$sample_input',`sample_output`='$sample_output',`hint`='$hint',`source`='$source',`spj`=$spj,`in_date`=NOW()
	WHERE `problem_id`=$id";

@mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
echo "Edit OK!";


		
echo "<a href='../problem.php?id=$id'>See The Problem!</a>";
}
?>
</body>
</html>

