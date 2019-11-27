<?php require("admin-header.php");

        if(isset($OJ_LANG)){
                require_once("../lang/$OJ_LANG.php");
        }
echo "<title>Problem List</title>";
echo "<center><h2>homework List</h2></center>";
require_once("../include/set_get_key.php");
$sql="SELECT max(`homework_id`) as upid, min(`homework_id`) as btid  FROM `homework`";
$page_cnt=50;
$result=mysqli_query($mysqli,$sql);
echo mysqli_error($mysqli);
$row=mysqli_fetch_object($result);
$base=intval($row->btid);
$cnt=intval($row->upid)-$base;
$cnt=intval($cnt/$page_cnt)+(($cnt%$page_cnt)>0?1:0);
if (isset($_GET['page'])){
        $page=intval($_GET['page']);
}else $page=$cnt;
$pstart=$base+$page_cnt*intval($page-1);
$pend=$pstart+$page_cnt;
for ($i=1;$i<=$cnt;$i++){
        if ($i>1) echo '&nbsp;';
        if ($i==$page) echo "<span class=red>$i</span>";
        else echo "<a href='homework_list.php?page=".$i."'>".$i."</a>";
}
$sql="select `homework_id`,`title`,`start_time`,`end_time`,`private`,`defunct` FROM `homework` where homework_id>=$pstart and homework_id <=$pend order by `homework_id` desc";
if(isset($_GET['keyword'])) 
	$keyword=$_GET['keyword'];
else
	$keyword="";
$keyword=mysqli_real_escape_string($mysqli,$keyword);
if($keyword) 
	$sql="select `homework_id`,`title`,`start_time`,`end_time`,`private`,`defunct` FROM `homework` where title like '%$keyword%' ";
$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
?>
<form action=homework_list.php class=center><input name=keyword><input type=submit value="<?php echo $MSG_SEARCH?>" ></form>


<?php
echo "<center><table class='table table-striped' width=90% border=1>";
echo "<tr><td>homeworkID<td>Title<td>StartTime<td>EndTime<td>Private<td>Status<td>Edit<td>Copy<td>Export<td>Logs";
echo "</tr>";
for (;$row=mysqli_fetch_object($result);){
        echo "<tr>";
        echo "<td>".$row->homework_id;
        echo "<td><a href='../homework.php?hid=$row->homework_id'>".$row->title."</a>";
        echo "<td>".$row->start_time;
        echo "<td>".$row->end_time;
        $hid=$row->homework_id;
        if(isset($_SESSION['administrator'])||isset($_SESSION["m$hid"])){
                echo "<td><a href=homework_pr_change.php?hid=$row->homework_id&getkey=".$_SESSION['getkey'].">".($row->private=="0"?"<span class=green>Public</span>":"<span class=red>Private<span>")."</a>";
                echo "<td><a href=homework_df_change.php?hid=$row->homework_id&getkey=".$_SESSION['getkey'].">".($row->defunct=="N"?"<span class=green>Available</span>":"<span class=red>Reserved</span>")."</a>";
                echo "<td><a href=homework_edit.php?hid=$row->homework_id>Edit</a>";
                echo "<td><a href=homework_add.php?hid=$row->homework_id>Copy</a>";
                if(isset($_SESSION['administrator'])){
                        echo "<td><a href=\"problem_export_xml.php?hid=$row->homework_id&getkey=".$_SESSION['getkey']."\">Export</a>";
                }else{
                  echo "<td>";
                }
     echo "<td> <a href=\"../export_homework_code.php?hid=$row->homework_id&getkey=".$_SESSION['getkey']."\">Logs</a>";
        }else{
                echo "<td colspan=5 align=right><a href=homework_add.php?hid=$row->homework_id>Copy</a><td>";
        }
        echo "</tr>";
}
echo "</table></center>";
require("../oj-footer.php");
?>
