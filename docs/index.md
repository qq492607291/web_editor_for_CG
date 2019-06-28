## web编辑cg数据库的巨坑

### 开发环境/原型进展

* 从cg数据库，导出sql语句a
 * 完成，参见 test/gamedata.sql
* 写Php的代码，将导出的sql语句a转成mysql格式b
 * （主要是为了批量获得mysql建表语句） 完成，参见 test\for-mysql\*.sql
* 创建mysql数据库并导入b 
 * 完成
* 按照mysql数据库开发对应的web操作见面 
 * 目前是偷懒使用phpmaker2018按照数据库自动构建的php代码，现有了基本的增删改查框架。
 * 这里后续需要大量修改，让对应的页面实际可用。TODO
* 编写同步代码，将web上修改的内容更新到cg数据库
 * TODO  
