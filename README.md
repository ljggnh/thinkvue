ThinkVue
--------------
## 注意的地方：

1. 使用请求头authKey和sessionId验证权限，关闭了cookie和session；
2. 在全局配置文件config/app.php中

## 投入生产环境应做如下更改：

1. 更改日志文件级别（在全局配置文件/config/app.php中）
2. 关闭调试模式（/config/app.php=>app_debug）
3. 更改数据库密码（/config/database.php）
