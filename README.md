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


