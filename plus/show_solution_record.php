<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $_GET['user_id']; ?> solution table</title>


</head>
<body>

<?php require_once("../include/db_info.inc.php");?>
<?php include("../template/$OJ_TEMPLATE/css.php");?>	

<script src="js/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="css/style.css">



<div class= "container">
<h1 class="text-center"><?php echo $_GET['user_id']; ?> solution table</h1>
        <?php 
            if( $user_id == $_SESSION['user_id'])
              echo '<h2><a href = "add_solution_record.php">增加记录</a></h2>';

          ?>
<table class = "table table-hover">
  <thead>
  <tr>
          <th>#</th>
          <th>题目</th>
          <th>题目描述</th>
          <th>解法</th>
          <th>状态</th>
          <th>来源</th>
          <th>类型</th>
          <th>备注</th>

          <?php 
            if( $user_id == $_SESSION['user_id'])
              echo '<th>操作</th>';

          ?>

  </tr>
  <thead>
  <tbody>
      <!--加入markdown显示 2020-->
<link rel="stylesheet" href="../markdown/css/editormd.preview.css" />
<script src="../markdown/examples/js/jquery.min.js"></script> 
<script src="../markdown/editormd.js"></script> 
<script src="../markdown/lib/marked.min.js"></script> 
<script src="../markdown/lib/prettify.min.js"></script> 
    <?php
      $i=1;
     // var_dump($result);
   // if(!$result)
      while ($row=mysqli_fetch_object($result)){
        echo '<tr> <th>'.$i.'</th>';

        //echo title begin
        if($row ->isfzoj ){
          $url = $OJ_URL."problem.php?id=".$row->problem_id;
        }else
          $url = $row->url;

        echo '<td><a href="'.$url.'" >'.$row ->title.'</a></td>';
        //echo title end

        //echo '<td>'.$row ->description.'</td>';
        $descriptiontxt=$row ->description;
        echo "<td><div id='test-markdown-view$i'><textarea style='display:none;'>$descriptiontxt</textarea></div>";
        echo "<script>$(function() {var testView = editormd.markdownToHTML('test-markdown-view$i', {});});</script></td>";
          
        echo '<td>'.$row ->solution.'</td>';
        echo '<td>'.$row ->status.'</td>';
        echo '<td>'.$row ->source.'</td>';
        echo '<td>'.$row ->tags.'</td>';
        echo '<td>'.$row ->notes.'</td>';



        //echo operation begin
     
        if( $user_id == $_SESSION['user_id']){
          $del_url = "c_del_solution_record.php?id=".$row->id;
          $update_url = "update_solution_record.php?id=".$row->id;
          echo '<td><a href="'.$update_url.'">修改<a> <a href="'.$del_url.'"  onclick="javascript:return p_del()">删除</a></td>';
        }
        //echo operation end.


        $i++;
        echo '</tr>';
      }



    ?>

  </tbody>
<table>


</div>

<SCRIPT LANGUAGE=javascript> 
function p_del() { 
  var msg = "您真的确定要删除吗？\n\n请确认！"; 
  if (confirm(msg)==true){ 
    return true; 
  }else{ 
    return false; 
  } 
  } 
</SCRIPT> 

<?php require_once("../oj-footer.php");?>
</body></html>

