<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo $_GET['problem_id']; ?> solutions</title>


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
  
}else{

  
  if ( isset($_GET['problem_id']) ){
    $id = $_GET['problem_id'];
    $sql = "select * from solution_record where isfzoj=1 and problem_id = ".$id;
    
    $result=mysqli_query($mysqli,$sql); 
  //  var_dump($result);   
  }
}

$now=strftime("%Y-%m-%d %H:%M",time());
$user_id=$_SESSION['user_id'];

?>

<div class= "container">
<h1 class="text-center"> <?php echo $_GET['problem_id']; ?> solution list</h1>
        <?php 
            if( $user_id == $_SESSION['user_id'])
              echo '<h2><a href = "add_solution_record.php?problem_id='.$_GET['problem_id'].'"">增加题解</a></h2>';

          ?>
<table class = "table table-hover">
  <thead>
  <tr>
          <th>#</th>
          <th>题解</th>
          <th>标记类型</th>
          <th>作者</th>
          <th>更新时间</th>
          


  </tr>
  <thead>
  <tbody>
    <?php
      $i=1;
     // var_dump($result);
   // if(!$result)
      while ($row=mysqli_fetch_object($result)){
        echo '<tr> <th>'.$i.'</th>';
        echo '<td>'.$row ->solution.'</td>';
        echo '<td>'.$row ->tags.'</td>';
        $user_url=$OJ_URL.'/userinfo.php?user='.$row ->user_id;
        echo '<td><a href="'.$user_url.'">'.$row ->user_id.'</a></td>';
        echo '<td>'.$row ->update_time.'</td>';
        $i++;
        echo '</tr>';
      }



    ?>

  </tbody>
<table>


</div>


<?php require_once("../oj-footer.php");?>
</body></html>

