<?php
if(isset($_POST['check']))
echo "你勾选了选项";
else
echo "没有勾选";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<!--测试表单，一个可选框-->
<form method="post">
<input type="checkbox" name="check" id="check" value="重判">是否重判</input>

<input type=submit value=Submit name=submit>
 <input type=reset value=Reset name=reset>
</form>
</body>
</html>