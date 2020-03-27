# 更新日志 2017-2019，2020

## 20191127更新
作业模块已经初步完成，还有细节问题。

## 20170527 数据表优化
将username数据表与user合并，优化数据库逻辑

查看用户真实姓名权限，需要调试

竞赛模块由于数据表username删除

只需要将原先的页面中的nick修改为name即可

## 20170603
作业模块基本可以使用了，管理页面判断条件没加

用户权限管理页面开始调试

用户分页完成，用户权限编辑、删除用户权限正在努力完成。

## 20170610
新增用户资料管理页面，用户权限管理页面
## 20170621
作业模块添加判题功能，基本完成可能会有bug
# OJ 2019 优化

Drew 2020 真好用，一键git,

Github入门教程与提高：https://www.jianshu.com/p/ec21055556f7
## 20191126
题单、homework、强制登录已经OK 
## 20191127
用户部分，更新说明：

1、后台页面添加了“修改姓名”

检测用户管理员的关键代码为 if (isset($_SESSION['administrator'])) 

修改的页面为：状态、排名和问题状态页面

修改方式：在之前的页面新增一个入口，只在管理员身份显示，打开页面也会查看是否管理员登录。

2、继续编辑用户管理

增加一个是否被禁用和备注字段，只有在后台管理用户的时候可见，也只有管理员在后台才可修改

1208 用户列表和资料编辑已完成！

在users表增加note字段，用于备注，类型是varchar

下一步：锁定或禁止用户，无法登陆 和批量添加功能

批量添加、用户锁定已经完成 1209

管理页面，user_id和keywords搜索功能Bug完成 1220

## 2020年更新记录

取消作业编辑和竞赛编辑页面的用户姓名更新，保留姓名显示 20200105

加入markdown编辑器源码，还有图片上传的接口API

Homework已经完成了markdown显示与回显功能，其他页面可以参考实现。

题解系统更新了相关的代码，支持markdown显示了

problem数据表添加isMarkdown字段，默认值为0

Markdown功能基本完成，等待测试

markdown显示问题，将jumbotron1改名，可能是不兼容bootstrap的某些CSS样式

/markdown在线编辑器功能，可以防止长时间未登陆Cookie失效，编辑好后复制走即可。

## 202002更新记录

为了解决数学公式显示问题的提出的，仍然需要用$$间隔开

取消后端公式功能,后端编辑时将markdown和html同时存贮，前端显示html时加载原生KaTeX解析数学公式

无数据库变动，html字段存贮到input字段

在线markdown编辑器增加可视化公式编辑按钮和首页按钮

0327 更新记录

取消原先的公式显示，转换为https://www.mathjax.org/

1、在原markdown显示页面，将tex公式注释掉

2、在展示页面的head，加入以下代码：

<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script> 

<script>
    
  MathJax = {
  
    tex: {inlineMath: [['$', '$'], ['\\(', '\\)']]}
    
  };
  </script> 
  
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js">

</script>

3、其他照常，甚至可以不保存数据到input字段

4、公式显示支持用一个$符号就可以实现效果啦



