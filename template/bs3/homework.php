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
  </head>

  <body>

    <div class="container">
    <?php include("template/$OJ_TEMPLATE/nav.php");?>	    
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
<center>
<div>
<h3>[<a href="homerank.php?hid=<?php echo $hid?>">完成情况</a>]-[<a href="admin/homework_edit.php?hid=<?php echo $hid?>">作业编辑</a>]
</h3>

<h3>homework<?php echo $view_hid?> - <?php echo $view_title ?></h3>
</center>
<p><?php //echo $view_description;如果采用原输出，请将本行注释删除即可?></p>
<!--加入markdown显示 2020-->
 <link rel="stylesheet" href="../markdown/css/editormd.preview.css" />
<div id="test-markdown-view"> 
<textarea style="display:none;"><?php echo $view_description;?></textarea>
</div>
<script src="../markdown/examples/js/jquery.min.js"></script> 
<script src="../markdown/editormd.js"></script> 
<script src="../markdown/lib/marked.min.js"></script> 
<script src="../markdown/lib/prettify.min.js"></script> 
<script type="text/javascript">
    $(function() {
	    var testView = editormd.markdownToHTML("test-markdown-view", {
             //markdown : "[TOC]\n### Hello world!\n## Heading 2", // Also, you can dynamic set Markdown text
            // htmlDecode : true,  // Enable / disable HTML tag encode.
            // htmlDecode : "style,script,iframe",  // Note: If enabled, you should filter some dangerous HTML tags for website security.
        });
    });
</script>   
<!--加入markdown显示 by hxh -->
</div>
<center>
<table id='problemset' class='table table-striped'  width='90%'>
<thead>
<tr align=center class='toprow'>
<td width='5'>
<td style="cursor:hand" onclick="sortTable('problemset', 1, 'int');" ><?php echo $MSG_PROBLEM_ID?>
<td width='60%'><?php echo $MSG_TITLE?></td>
<td width='10%'><?php echo $MSG_SOURCE?></td>
<td style="cursor:hand" onclick="sortTable('problemset', 4, 'int');" width='5%'><?php echo $MSG_AC?></td>
<td style="cursor:hand" onclick="sortTable('problemset', 5, 'int');" width='5%'><?php echo $MSG_SUBMIT?></td>
</tr>
</thead>
<tbody>
<?php
//将数组显示出来的php，前提是数组获取没有问题，也就是在mc中没有问题
$cnt=0;
foreach($view_problemset as $row){
if ($cnt)
echo "<tr class='oddrow'>";
else
echo "<tr class='evenrow'>";
foreach($row as $table_cell){
echo "<td>";
echo "\t".$table_cell;
echo "</td>";
}
echo "</tr>";
$cnt=1-$cnt;
}
?>
</tbody>
</table>

</center>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php include("template/$OJ_TEMPLATE/js.php");?>	    
<script src="include/sortTable.js"></script>
<script>
var diff=new Date("<?php echo date("Y/m/d H:i:s")?>").getTime()-new Date().getTime();
//alert(diff);
function clock()
{
var x,h,m,s,n,xingqi,y,mon,d;
var x = new Date(new Date().getTime()+diff);
y = x.getYear()+1900;
if (y>3000) y-=1900;
mon = x.getMonth()+1;
d = x.getDate();
xingqi = x.getDay();
h=x.getHours();
m=x.getMinutes();
s=x.getSeconds();
n=y+"-"+mon+"-"+d+" "+(h>=10?h:"0"+h)+":"+(m>=10?m:"0"+m)+":"+(s>=10?s:"0"+s);
//alert(n);
document.getElementById('nowdate').innerHTML=n;
setTimeout("clock()",1000);
}
clock();
</script>
  </body>
</html>
