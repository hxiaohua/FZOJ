<!--加入markdown显示 2020-->
 <link rel="stylesheet" href="markdown/css/editormd.preview.css" />
<div id="markdown-view"> 
<textarea style="display:none;"><?php if(isset($view_description)) echo $view_description;?></textarea>
</div>
<script src="markdown/examples/js/jquery.min.js"></script> 
<script src="markdown/editormd.js"></script> 
<script src="markdown/lib/marked.min.js"></script> 
<script src="markdown/lib/prettify.min.js"></script> 
<script type="text/javascript">
    $(function() {
            editormd.katexURL = {
            js:"markdown/katex/katex.min",  // default: //cdnjs.cloudflare.com/ajax/libs/KaTeX/0.3.0/katex.min
            css:"markdown/katex/katex.min"   // default: //cdnjs.cloudflare.com/ajax/libs/KaTeX/0.3.0/katex.min
        };
	    var testView = editormd.markdownToHTML("markdown-view", {
             //markdown : "[TOC]\n### Hello world!\n## Heading 2", // Also, you can dynamic set Markdown text
            // htmlDecode : true,  // Enable / disable HTML tag encode.
            // htmlDecode : "style,script,iframe",  // Note: If enabled, you should filter some dangerous HTML tags for website security.
           tex:true,                   // 开启科学公式TeX语言支持，默认关闭
        });
    });
</script>   
<!--加入markdown显示 by hxh -->

<!--
2020 引入该文件即可显示markdown编辑器

注意：要保持文中有个PHP变量传过来

实现改全改
-->