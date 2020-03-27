<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">
<title><?php echo $OJ_NAME?></title>
<?php include("template/$OJ_TEMPLATE/css.php");?>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --> 
<!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]--> 
    <script src="markdown/polyfill.min.js?features=es6"></script> 
<script>
  MathJax = {
    tex: {inlineMath: [['$', '$'], ['\\(', '\\)']]}
  };
  </script> 
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
    <style>
.jumbotron1{ 
    font-size: 18px; 
}
</style>
</head>

<body font-size: 100px;>
<div class="container">
  <?php include("template/$OJ_TEMPLATE/nav.php");?>
  <!-- Main component for a primary marketing message or call to action -->
  <div class="jumbotron1">
    <?php
    if ( $pr_flag ) {
      echo "<title>$MSG_PROBLEM $row->problem_id. -- $row->title</title>";
      echo "<center><h2>$id: $row->title</h2>";
    } else {
      $PID = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $id = $row->problem_id;
      echo "<title>$MSG_PROBLEM $PID[$pid]: $row->title </title>";
      echo "<center><h2>$MSG_PROBLEM $PID[$pid]: $row->title</h2>";
    }
    echo "<span class=green>$MSG_Time_Limit: </span>$row->time_limit Sec&nbsp;&nbsp;";
    echo "<span class=green>$MSG_Memory_Limit: </span>" . $row->memory_limit . " MB";
    if ( $row->spj )echo "&nbsp;&nbsp;<span class=red>Special Judge</span>";
    echo "<br><span class=green>$MSG_SUBMIT: </span>" . $row->submit . "&nbsp;&nbsp;";
    echo "<span class=green>$MSG_SOVLED: </span>" . $row->accepted . "<br>";
    if ( $pr_flag ) {
      echo "[<a href='submitpage.php?id=$id'>$MSG_SUBMIT</a>]";
      echo "[<a href='plus\show_solution_by_problem_id.php?problem_id=$id'>题解</a>]";
    } else {
      echo "[<a href='submitpage.php?cid=$cid&pid=$pid&langmask=$langmask'>$MSG_SUBMIT</a>]";
    }
    echo "[<a href='problemstatus.php?id=" . $row->problem_id . "'>$MSG_STATUS</a>]";
    echo "[<a href='bbs.php?pid=" . $row->problem_id . "$ucid'>$MSG_BBS</a>]";
    if ( isset( $_SESSION[ 'administrator' ] ) ) {
      require_once( "include/set_get_key.php" );
      ?>
    [<a href="admin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION['getkey']?>" >Edit</a>]
    [<a href='javascript:phpfm(<?php echo $row->problem_id;?>)'>TestData</a>] 
    <!--  [<a href="admin/quixplorer/index.php?action=list&dir=<?php echo $row->problem_id?>&order=name&srt=yes" >TestData</a>]-->
    <?php
    }
    echo "</center>";
    //$view_description = $row->description;
      echo $row->input;
   // require_once( "markdown/markdown_view.php" );
    ?>
    <?php
    echo "<center>";
    if ( $pr_flag ) {
      echo "[<a href='submitpage.php?id=$id'>$MSG_SUBMIT</a>]";
    } else {
      echo "[<a href='submitpage.php?cid=$cid&pid=$pid&langmask=$langmask'>$MSG_SUBMIT</a>]";
    }
    echo "[<a href='problemstatus.php?id=" . $row->problem_id . "'>$MSG_STATUS</a>]";
    //echo "[<a href='bbs.php?pid=".$row->problem_id."$ucid'>$MSG_BBS</a>]";
    if ( isset( $_SESSION[ 'administrator' ] ) ) {
      require_once( "include/set_get_key.php" );
      ?>
    [<a href="admin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION['getkey']?>" >Edit</a>]
    [<a href='javascript:phpfm(<?php echo $row->problem_id;?>)'>TestData</a>]
    <?php
    }
    echo "</center>";
    ?>
  </div>
</div>
<!-- /container --> 

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster -->
<?php include("template/$OJ_TEMPLATE/js.php");?>
<script>
function phpfm(pid){
        //alert(pid);
        $.post("admin/phpfm.php",{'frame':3,'pid':pid,'pass':''},function(data,status){
                if(status=="success"){
                        document.location.href="admin/phpfm.php?frame=3&pid="+pid;
                }
        });
}
</script>
</body>
</html>
