<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Add New solution</title>


</head>
<body>

<?php require_once("../include/db_info.inc.php");?>
<?php include("../template/$OJ_TEMPLATE/css.php");?>	

<script src="js/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="css/style.css">

<?php 

if (!isset($_SESSION['user_id'])){
	
	echo "<a href='../loginpage.php'>请登录后继续操作</a>";
	
	exit(0);
}

$now=strftime("%Y-%m-%d %H:%M",time());
$user_id=$_SESSION['user_id'];

?>
<div class= "container">
<h1 class="text-center">Add New solution</h1>
<form class="form-horizontal" action = "c_add_solution_record.php" method="POST">
  <div class="form-group">
    <label for="inputTitle" class="col-sm-2 control-label">title</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputTitle" name="title" placeholder="题目标题">
    </div>
  </div>

 <div class="form-group" id="isFzojRadio" >
    <label for="inputIsFzoj" class="col-sm-2 control-label">是否是FZOJ题目</label>
    <div class="col-sm-10">
     <label class="radio-inline">
	  <input type="radio" name="isfzoj" id="inputIsFzoj1" value="1" <?php if(isset($_GET['problem_id'])) echo 'checked';?> > 是
	</label>
	<label class="radio-inline">
	  <input type="radio" name="isfzoj" id="inputIsFzoj2" value="0"> 否
	</label>
    </div>
  </div>

  <div class="form-group hidden" id="urlDiv"  >
    <label for="inputUrl" class="col-sm-2 control-label">url</label>
    <div class="col-sm-10">
      <input type="url" class="form-control" name="url" id="inputUrl" placeholder="题目链接地址">
    </div>
  </div>

  <div class="form-group <?php if(isset($_GET['problem_id'])) echo 'show'; else echo 'hidden';?>"  id="ProblemIdDiv" >
    <label for="inputProblemId" class="col-sm-2 control-label">Problem-Id</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputProblemId" name="problem_id" placeholder="FZOJ题目ID" value="<?php if(isset($_GET['problem_id'])) echo $_GET['problem_id'];?>">
    </div>
  </div>
    
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
</script>
    <!--修正为markdown-->
<!-- 注释原来的代码
<div class="form-group">
    <label for="inputDescription" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
      <textarea class="form-control" name="description" rows="3">题目描述</textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="inputSolution" class="col-sm-2 control-label">Solution</label>
    <div class="col-sm-10">
      <textarea class="form-control" name="solution" rows="3">解法</textarea>
    </div>
  </div>-->

  <div class="form-group">
    <label for="inputStatus" class="col-sm-2 control-label">Status</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputStatus" name="status" placeholder="状态">
    </div>
  </div>

  <div class="form-group">
    <label for="inputSource" class="col-sm-2 control-label">source</label>
    <div class="col-sm-10">
       <input type="text" class="form-control" id="inputSource" name="source" placeholder="来源">
    
    </div>
  </div>

  <div class="form-group">
    <label for="inputTags" class="col-sm-2 control-label">Tags</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputTags" name="tags" placeholder="类型，多个类型以逗号隔开">
    </div>
  </div>

 <div class="form-group">
    <label for="inputNotes" class="col-sm-2 control-label">Notes</label>
    <div class="col-sm-10">
      <textarea class="form-control" name="notes"  rows="3">备注</textarea>
    </div>
  </div>


  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>
</form>
</div>

<script>
	$(document).ready(function(){

		    $("#addTask").on( "click", function(){
				var newId=lastId+1;
                $("#task"+lastId+"-value").parent().parent().after("<div class='form-group'><label for='inputCourseTask' class='col-sm-2 control-label'> </label><label for='inputCourseTask' class='col-sm-2 control-label'>题目"+newId+"</label><div class='col-sm-2'><input type='text' class='form-control' id='task"+newId+"-name' name='task"+newId+"_name' placeholder='题目名称'></div><div class='col-sm-4'><input type='text' class='form-control' id='task"+newId+"-src' name='task"+newId+"_src' placeholder='题目地址'></div><div class='col-sm-2'><input type='text' class='form-control' id='task"+newId+"-value' name='task"+newId+"_value' placeholder='题目分值'></div></div>");
				lastId=newId;
               
           });
		  $(":radio").click(function(){
		     if($(this).val()==1){
		     	$("#ProblemIdDiv").removeClass("hidden");
		     	$("#ProblemIdDiv").addClass("show");
		  		$("#urlDiv").addClass("hidden");
		  		$("#urlDiv").removeClass("show");
		  	  }else{		  	  	
		  		$("#ProblemIdDiv").removeClass("show");
		     	$("#ProblemIdDiv").addClass("hidden");
		  		$("#urlDiv").addClass("show");
		  		$("#urlDiv").removeClass("hidden");
		  	  }
		  });

	});
</script>


<?php require_once("../oj-footer.php");?>
</body></html>

