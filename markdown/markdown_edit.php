
<!--markdown引入样式文件-->
<link rel="stylesheet" href="../markdown/css/editormd.min.css" />
<script src="../markdown/examples/js/jquery.min.js"></script> 
<script src="../markdown/editormd.js"></script> 
  <div id="editor"> 
    <textarea style="display:none;" name="description"><?php if(isset($description)) echo $description;?></textarea>
  </div>

  <script>
    $(function() {	
		editormd.katexURL = {
			js  : "../markdown/katex/katex.min",  
			css : "../markdown/katex/katex.min"  
};
        var testEditor = editormd("editor",{
            width:"90%",
            height : 720,
            path:"../markdown/lib/",//设置文件保存的路径
            saveHTMLToTextarea:true,//增加html代码，取消公式功能
			//tex:true,                   // 开启科学公式TeX语言支持，默认关闭
			flowChart:true,             // 开启流程图支持，默认关闭
            imageUpload : true,
            imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL : "../kindeditor/php/upload_mk_json.php",
        })
    });
</script>
<!--
2020 引入该文件即可显示markdown编辑器

注意：要保持文中有个PHP变量传过来

实现一改全改

Powered By hxh 202002 
-->