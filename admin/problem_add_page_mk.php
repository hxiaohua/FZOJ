<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>New Problem</title>
</head>
<body leftmargin="30" >

<?php require_once("../include/db_info.inc.php");?>
<?php require_once("admin-header.php");
if (!(isset($_SESSION['administrator'])||isset($_SESSION['problem_editor']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<?php
include_once("kindeditor.php") ;
?>
<h1 >Add New problem Markdown</h1>
    <h2>返回<a href="problem_add_page.php">传统界面编辑</a></h2>
<form method=POST action=problem_add.php>
<input type=hidden name=problem_id value="New Problem">
<p align=left>Problem Id:&nbsp;&nbsp;New Problem</p>
<p align=left>Title:<input class="input input-xxlarge" type=text name=title size=71></p>
<p align=left>Time Limit:<input type=text name=time_limit size=20 value=1>S</p>
<p align=left>Memory Limit:<input type=text name=memory_limit size=20 value=128>MByte</p>
<p align=left>Description:<br>
  <!--修正为markdown-->
<!--markdown引入样式文件-->
<link rel="stylesheet" href="../markdown/css/editormd.min.css" />
<div id="editor"> 
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
            tex:true,                   // 开启科学公式TeX语言支持，默认关闭
            imageUpload : true,
            imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL : "../kindeditor/php/upload_mk_json.php",
        })
    });
</script>
    <!--修正为markdown-->
    <!--升级为markdown编辑器，保留原来的name，添加hidden标签-->
<input type="hidden" name="isMarkdown" value="1"/>
<input type="hidden" name="input" value=""/>
<input type="hidden" name="output" value=""/>
<input type="hidden" name="sample_input" value=""/>
<input type="hidden" name="sample_output" value=""/>
<input type="hidden" name="test_input" value=""/>
<input type="hidden" name="test_output" value=""/>
<input type="hidden" name="hint" value=""/>

<p>SpecialJudge: N<input type=radio name=spj value='0' checked>Y<input type=radio name=spj value='1'></p>
<p align=left>Source:<br><textarea name=source rows=1 cols=70></textarea></p>
<p align=left>contest:
	<select  name=contest_id>
<?php $sql="SELECT `contest_id`,`title` FROM `contest` WHERE `start_time`>NOW() order by `contest_id`";
$result=mysqli_query($mysqli,$sql);
echo "<option value=''>none</option>";
if (mysqli_num_rows($result)==0){
}else{
	for (;$row=mysqli_fetch_object($result);)
		echo "<option value='$row->contest_id'>$row->contest_id $row->title</option>";
}
?>
	</select>
</p>
<div align=center>
<?php require_once("../include/set_post_key.php");?>
<input type=submit value=Submit name=submit>
</div></form>
<p>
<?php require_once("../oj-footer.php");?>
</body></html>

