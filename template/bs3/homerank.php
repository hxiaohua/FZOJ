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
<?php
$rank=1;
?>
<center><h3>Homework RankList <?php echo $title?></h3>
<!--不必下载用户的测评数据，注销此行
<a href="homeworkrank.xls.php?hid=<?php echo $hid?>" >Download</a>
-->
<?php
if($OJ_MEMCACHE){
  ?>
<a href="homeworkrank2.php?hid=<?php echo $hid?>" >Replay</a>

<?php
}
 ?>
</center>
<table id=rank><thead>
<tr class=toprow align=center>
<td class="{sorter:'false'}" width=10%>User
<th width=10%>Name</th>
<?php
	
for ($i=0;$i<$lie;$i++){
	//加上题目标题
	$sql="select title from problem where problem_id='$Qnum[$i]'";
	$re=mysqli_query($mysqli,$sql);
	$row=mysqli_fetch_row($re);
	echo "<td><a href=problem.php?id=$Qnum[$i]><font color='white'>$Qnum[$i]</font></a><br />$row[0]</td>";
}
echo "</tr></thead>\n<tbody>";
for ($i=0;$i<$hang;$i++){
	echo '<tr class="evenrow" align="center">';
	echo "<td>".$TabInfo[$i][0]."</td>";
	echo "<td>".$TabInfo[$i][1]."</td>";
	for ($j=0;$j<$lie;$j++){
		//echo "<td>".$TabInfo[$i][$j+2]."</td>";
		if($TabInfo[$i][$j+2]=="Y")
		echo '<td class="well" style="background-color:#33ff33">Y</td>';
		else
		echo '<td class="well" style="background-color:#eeeeee"></td>';
		
	}
echo "</tr>\n";
}
echo "</tbody></table>";
?>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php include("template/$OJ_TEMPLATE/js.php");?>	    
<script type="text/javascript" src="include/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$.tablesorter.addParser({
// set a unique id
id: 'punish',
is: function(s) {
// return false so this parser is not auto detected
return false;
},
format: function(s) {
// format your data for normalization
var v=s.toLowerCase().replace(/\:/,'').replace(/\:/,'').replace(/\(-/,'.').replace(/\)/,'');
//alert(v);
v=parseFloat('0'+v);
return v>1?v:v+Number.MAX_VALUE-1;
},
// set type, either numeric or text
type: 'numeric'
});
$("#rank").tablesorter({
headers: {
4: {
sorter:'punish'
}
<?php
for ($i=0;$i<$pid_cnt;$i++){
echo ",".($i+5).": { ";
echo " sorter:'punish' ";
echo "}";
}
?>
}
});
}
);
</script>
<script>
function getTotal(rows){
var total=0;
for(var i=0;i<rows.length&&total==0;i++){
try{
total=parseInt(rows[rows.length-i].cells[0].innerHTML);
if(isNaN(total)) total=0;
}catch(e){
}
}
return total;
}
function metal(){
var tb=window.document.getElementById('rank');
var rows=tb.rows;
try{
var total=getTotal(rows);
//alert(total);
for(var i=1;i<rows.length;i++){
var cell=rows[i].cells[0];
var acc=rows[i].cells[3];
var ac=parseInt(acc.innerText);
if (isNaN(ac)) ac=parseInt(acc.textContent);
if(cell.innerHTML!="*"&&ac>0){
var r=parseInt(cell.innerHTML);
if(r==1){
cell.innerHTML="Winner";
//cell.style.cssText="background-color:gold;color:red";
cell.className="badge btn-warning";
}
if(r>1&&r<=total*.05+1)
cell.className="badge btn-warning";
if(r>total*.05+1&&r<=total*.20+1)
cell.className="badge";
if(r>total*.20+1&&r<=total*.45+1)
cell.className="badge btn-danger";
if(r>total*.45+1&&ac>0)
cell.className="badge badge-info";
}
}
}catch(e){
//alert(e);
}
}
metal();
</script>
<style>
.well{
   background-image:none;
   padding:1px;
}
td{
   white-space:nowrap;

}
</style>
  </body>
</html>
