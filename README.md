# 更新日志 2017-2019

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


用户部分，

1、后台页面添加了“修改姓名”
检测用户管理员的关键代码：
if (isset($_SESSION['administrator'])) 
状态页面需要区分，普通状态页面和作业状态页面，
实际作业是单独的状态，所以只用普通状态页面修改即可
在模板页面添加，一个入口。
排名和状态完成，在每个页面开头检测是否管理员

