
INSERT INTO CustomAttributes_Register(acl_id,Id, SQL)VALUES (110,1, 'SELECT SUM(aValue) FROM system_uAttributes WHERE AttrName = ''[属性名称]''');
INSERT INTO CustomAttributes_Register(acl_id,Id, SQL)VALUES (110,3, 'SELECT SUM(addAttrNum) FROM Ext_AddAttr_Log WHERE fromQQ = ''[用户标识]'' AND attrName = ''[属性名称]''');
INSERT INTO CustomAttributes_Register(acl_id,Id, SQL)VALUES (110,4, 'SELECT SUM(aValue) FROM editor_attribute_adjustment WHERE uId = ''[用户标识]'' AND aName = ''[属性名称]''');
INSERT INTO CustomAttributes_Register(acl_id,Id, SQL)VALUES (110,5, 'SELECT SUM(aValue) FROM system_uAttributes WHERE AttrName = ''[属性名称]'' ');