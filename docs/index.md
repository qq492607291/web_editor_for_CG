## web编辑cg数据库的巨坑

### 开发环境/原型进展

* 从cg数据库，导出sql语句a
 *  完成 ，参见 test/gamedata.sql
* 写Php的代码，将导出的sql语句a转成mysql格式b
 * （主要是为了批量获得mysql建表语句） 完成，参见 test\for-mysql\*.sql
* 创建mysql数据库并导入b 
 * 完成，详见 test/init/*.sql 
* 按照mysql数据库开发对应的web操作见面 
 * 目前是偷懒使用phpmaker2018按照数据库自动构建的php代码，现有了基本的增删改查框架。
 * 这里后续需要大量修改，让对应的页面实际可用。
  1. - [ ] 改造登录和权限。
  2. - [ ] 地图表
  3. - [ ] 任务表
  4. - [ ] 技能表
  5. - [ ] 怪物表
  6. - [ ] 职业表
  7. - [ ] 物品表
  8. - [ ] 合成表
  9. - [ ] 分解表
  10. - [ ] 帮助信息表
  11. - [ ] 消息模板表

* 编写同步代码，将web上修改的内容更新到cg数据库
 - [ ] TODO
 - [ ] 初步考虑是用易语言写CG数据库与mysql数据库的同步工具
