> ACL, 访问控制列表（ACL，Access Control Lists）

## 基本权限逻辑（草稿）
 * 用户注册时就绑定一个ACL_ID(主要用于区分这组数据对应哪一个CG的sqlite3数据库)
 * 每个登录用户有一个唯一的UID。
 * 所有数据库记录在CG数据库字段基础上，统一增加下列字段
  * UNID，记录的唯一ID
  * ACL_ID，数据
  * UID，最后更新的用户
  * DATATIEM，最后更新时间戳
