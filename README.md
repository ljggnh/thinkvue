# ThinkVue
--------------
## 安装方法



## 注意的地方：

1. 使用请求头authKey和sessionId验证权限，关闭了cookie；
2. 在全局配置文件config/app.php中
3. 使用严格路由，未声明的地址重定位至 `admin/base/miss` ，可在`route/route.php`中取消。

## 投入生产环境应做如下更改：

1. 更改日志文件级别（在全局配置文件/config/app.php中）
2. 关闭调试模式（/config/app.php=>app_debug）
3. 更改数据库密码（/config/database.php）
4. 如果在开发环境中关闭了缺省路由，则应注意开启缺省路由

## 返回格式和约定返回值

返回格式为 ` json([code=>int,data=>object,error=>msg]) ` ，其中code为返回值，大于0为正确返回，小于0为错误返回。1为默认返回，-1为默认错误
* -1001~-1999 用户权限信息错误
    + -1001 登录失效
    + -1002 没有操作权限
    + -1003 账号或者密码错误
    + -1004 修改的新密码与原密码一致（准备废弃，用-2002代替）
    + -1005 该客户端未绑定账号
    + -1006 账号被禁用
* -2001~-2999 系统错误
    + -2001 发生了严重错误导致无法进行
    + -2002 参数错误
* -3001~-3999 数据错误
    + -3001 数据结构错误
    + -3002 数据存在冲突
    + -3003 数据库未知错误
    + -3004 指定数据不存在
* -4001~-4999 配置错误
    + -4001 地址错误
    + -4002 第三方OAuth2.0登录错误