<?php

// Global variable for table object
$config_monster = NULL;

//
// Table class for config_monster
//
class cconfig_monster extends cTable {
	var $unid;
	var $u_id;
	var $acl_id;
	var $Monster_Name;
	var $Monster_Type;
	var $Monster_AD;
	var $Monster_AP;
	var $Monster_HP;
	var $Monster_Defense;
	var $Monster_AbsorbHP;
	var $Monster_ADPTV;
	var $Monster_ADPTR;
	var $Monster_APPTR;
	var $Monster_APPTV;
	var $Monster_ImmuneDamage;
	var $Skills;
	var $Reward_Goods;
	var $Reward_Exp;
	var $Reward_Gold;
	var $Introduce;
	var $AttackEffect;
	var $AttackTips;
	var $MagicResistance;
	var $Hit;
	var $Dodge;
	var $IgnoreShield;
	var $DATETIME;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'config_monster';
		$this->TableName = 'config_monster';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`config_monster`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// unid
		$this->unid = new cField('config_monster', 'config_monster', 'x_unid', 'unid', '`unid`', '`unid`', 3, -1, FALSE, '`unid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->unid->Sortable = TRUE; // Allow sort
		$this->unid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unid'] = &$this->unid;

		// u_id
		$this->u_id = new cField('config_monster', 'config_monster', 'x_u_id', 'u_id', '`u_id`', '`u_id`', 3, -1, FALSE, '`u_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_id->Sortable = TRUE; // Allow sort
		$this->u_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_id'] = &$this->u_id;

		// acl_id
		$this->acl_id = new cField('config_monster', 'config_monster', 'x_acl_id', 'acl_id', '`acl_id`', '`acl_id`', 3, -1, FALSE, '`acl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acl_id->Sortable = TRUE; // Allow sort
		$this->acl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['acl_id'] = &$this->acl_id;

		// Monster_Name
		$this->Monster_Name = new cField('config_monster', 'config_monster', 'x_Monster_Name', 'Monster_Name', '`Monster_Name`', '`Monster_Name`', 201, -1, FALSE, '`Monster_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_Name->Sortable = TRUE; // Allow sort
		$this->fields['Monster_Name'] = &$this->Monster_Name;

		// Monster_Type
		$this->Monster_Type = new cField('config_monster', 'config_monster', 'x_Monster_Type', 'Monster_Type', '`Monster_Type`', '`Monster_Type`', 201, -1, FALSE, '`Monster_Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_Type->Sortable = TRUE; // Allow sort
		$this->fields['Monster_Type'] = &$this->Monster_Type;

		// Monster_AD
		$this->Monster_AD = new cField('config_monster', 'config_monster', 'x_Monster_AD', 'Monster_AD', '`Monster_AD`', '`Monster_AD`', 201, -1, FALSE, '`Monster_AD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_AD->Sortable = TRUE; // Allow sort
		$this->fields['Monster_AD'] = &$this->Monster_AD;

		// Monster_AP
		$this->Monster_AP = new cField('config_monster', 'config_monster', 'x_Monster_AP', 'Monster_AP', '`Monster_AP`', '`Monster_AP`', 201, -1, FALSE, '`Monster_AP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_AP->Sortable = TRUE; // Allow sort
		$this->fields['Monster_AP'] = &$this->Monster_AP;

		// Monster_HP
		$this->Monster_HP = new cField('config_monster', 'config_monster', 'x_Monster_HP', 'Monster_HP', '`Monster_HP`', '`Monster_HP`', 201, -1, FALSE, '`Monster_HP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_HP->Sortable = TRUE; // Allow sort
		$this->fields['Monster_HP'] = &$this->Monster_HP;

		// Monster_Defense
		$this->Monster_Defense = new cField('config_monster', 'config_monster', 'x_Monster_Defense', 'Monster_Defense', '`Monster_Defense`', '`Monster_Defense`', 201, -1, FALSE, '`Monster_Defense`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_Defense->Sortable = TRUE; // Allow sort
		$this->fields['Monster_Defense'] = &$this->Monster_Defense;

		// Monster_AbsorbHP
		$this->Monster_AbsorbHP = new cField('config_monster', 'config_monster', 'x_Monster_AbsorbHP', 'Monster_AbsorbHP', '`Monster_AbsorbHP`', '`Monster_AbsorbHP`', 201, -1, FALSE, '`Monster_AbsorbHP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_AbsorbHP->Sortable = TRUE; // Allow sort
		$this->fields['Monster_AbsorbHP'] = &$this->Monster_AbsorbHP;

		// Monster_ADPTV
		$this->Monster_ADPTV = new cField('config_monster', 'config_monster', 'x_Monster_ADPTV', 'Monster_ADPTV', '`Monster_ADPTV`', '`Monster_ADPTV`', 201, -1, FALSE, '`Monster_ADPTV`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_ADPTV->Sortable = TRUE; // Allow sort
		$this->fields['Monster_ADPTV'] = &$this->Monster_ADPTV;

		// Monster_ADPTR
		$this->Monster_ADPTR = new cField('config_monster', 'config_monster', 'x_Monster_ADPTR', 'Monster_ADPTR', '`Monster_ADPTR`', '`Monster_ADPTR`', 201, -1, FALSE, '`Monster_ADPTR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_ADPTR->Sortable = TRUE; // Allow sort
		$this->fields['Monster_ADPTR'] = &$this->Monster_ADPTR;

		// Monster_APPTR
		$this->Monster_APPTR = new cField('config_monster', 'config_monster', 'x_Monster_APPTR', 'Monster_APPTR', '`Monster_APPTR`', '`Monster_APPTR`', 201, -1, FALSE, '`Monster_APPTR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_APPTR->Sortable = TRUE; // Allow sort
		$this->fields['Monster_APPTR'] = &$this->Monster_APPTR;

		// Monster_APPTV
		$this->Monster_APPTV = new cField('config_monster', 'config_monster', 'x_Monster_APPTV', 'Monster_APPTV', '`Monster_APPTV`', '`Monster_APPTV`', 201, -1, FALSE, '`Monster_APPTV`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_APPTV->Sortable = TRUE; // Allow sort
		$this->fields['Monster_APPTV'] = &$this->Monster_APPTV;

		// Monster_ImmuneDamage
		$this->Monster_ImmuneDamage = new cField('config_monster', 'config_monster', 'x_Monster_ImmuneDamage', 'Monster_ImmuneDamage', '`Monster_ImmuneDamage`', '`Monster_ImmuneDamage`', 201, -1, FALSE, '`Monster_ImmuneDamage`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Monster_ImmuneDamage->Sortable = TRUE; // Allow sort
		$this->fields['Monster_ImmuneDamage'] = &$this->Monster_ImmuneDamage;

		// Skills
		$this->Skills = new cField('config_monster', 'config_monster', 'x_Skills', 'Skills', '`Skills`', '`Skills`', 201, -1, FALSE, '`Skills`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Skills->Sortable = TRUE; // Allow sort
		$this->fields['Skills'] = &$this->Skills;

		// Reward_Goods
		$this->Reward_Goods = new cField('config_monster', 'config_monster', 'x_Reward_Goods', 'Reward_Goods', '`Reward_Goods`', '`Reward_Goods`', 201, -1, FALSE, '`Reward_Goods`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Reward_Goods->Sortable = TRUE; // Allow sort
		$this->fields['Reward_Goods'] = &$this->Reward_Goods;

		// Reward_Exp
		$this->Reward_Exp = new cField('config_monster', 'config_monster', 'x_Reward_Exp', 'Reward_Exp', '`Reward_Exp`', '`Reward_Exp`', 201, -1, FALSE, '`Reward_Exp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Reward_Exp->Sortable = TRUE; // Allow sort
		$this->fields['Reward_Exp'] = &$this->Reward_Exp;

		// Reward_Gold
		$this->Reward_Gold = new cField('config_monster', 'config_monster', 'x_Reward_Gold', 'Reward_Gold', '`Reward_Gold`', '`Reward_Gold`', 201, -1, FALSE, '`Reward_Gold`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Reward_Gold->Sortable = TRUE; // Allow sort
		$this->fields['Reward_Gold'] = &$this->Reward_Gold;

		// Introduce
		$this->Introduce = new cField('config_monster', 'config_monster', 'x_Introduce', 'Introduce', '`Introduce`', '`Introduce`', 201, -1, FALSE, '`Introduce`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Introduce->Sortable = TRUE; // Allow sort
		$this->fields['Introduce'] = &$this->Introduce;

		// AttackEffect
		$this->AttackEffect = new cField('config_monster', 'config_monster', 'x_AttackEffect', 'AttackEffect', '`AttackEffect`', '`AttackEffect`', 201, -1, FALSE, '`AttackEffect`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->AttackEffect->Sortable = TRUE; // Allow sort
		$this->fields['AttackEffect'] = &$this->AttackEffect;

		// AttackTips
		$this->AttackTips = new cField('config_monster', 'config_monster', 'x_AttackTips', 'AttackTips', '`AttackTips`', '`AttackTips`', 201, -1, FALSE, '`AttackTips`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->AttackTips->Sortable = TRUE; // Allow sort
		$this->fields['AttackTips'] = &$this->AttackTips;

		// MagicResistance
		$this->MagicResistance = new cField('config_monster', 'config_monster', 'x_MagicResistance', 'MagicResistance', '`MagicResistance`', '`MagicResistance`', 201, -1, FALSE, '`MagicResistance`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->MagicResistance->Sortable = TRUE; // Allow sort
		$this->fields['MagicResistance'] = &$this->MagicResistance;

		// Hit
		$this->Hit = new cField('config_monster', 'config_monster', 'x_Hit', 'Hit', '`Hit`', '`Hit`', 201, -1, FALSE, '`Hit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Hit->Sortable = TRUE; // Allow sort
		$this->fields['Hit'] = &$this->Hit;

		// Dodge
		$this->Dodge = new cField('config_monster', 'config_monster', 'x_Dodge', 'Dodge', '`Dodge`', '`Dodge`', 201, -1, FALSE, '`Dodge`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Dodge->Sortable = TRUE; // Allow sort
		$this->fields['Dodge'] = &$this->Dodge;

		// IgnoreShield
		$this->IgnoreShield = new cField('config_monster', 'config_monster', 'x_IgnoreShield', 'IgnoreShield', '`IgnoreShield`', '`IgnoreShield`', 201, -1, FALSE, '`IgnoreShield`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->IgnoreShield->Sortable = TRUE; // Allow sort
		$this->fields['IgnoreShield'] = &$this->IgnoreShield;

		// DATETIME
		$this->DATETIME = new cField('config_monster', 'config_monster', 'x_DATETIME', 'DATETIME', '`DATETIME`', ew_CastDateFieldForLike('`DATETIME`', 0, "DB"), 135, 0, FALSE, '`DATETIME`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DATETIME->Sortable = FALSE; // Allow sort
		$this->DATETIME->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['DATETIME'] = &$this->DATETIME;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`config_monster`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->unid->setDbValue($conn->Insert_ID());
			$rs['unid'] = $this->unid->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('unid', $rs))
				ew_AddFilter($where, ew_QuotedName('unid', $this->DBID) . '=' . ew_QuotedValue($rs['unid'], $this->unid->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`unid` = @unid@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->unid->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->unid->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@unid@", ew_AdjustSql($this->unid->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "config_monsterlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "config_monsterview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "config_monsteredit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "config_monsteradd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "config_monsterlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("config_monsterview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("config_monsterview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "config_monsteradd.php?" . $this->UrlParm($parm);
		else
			$url = "config_monsteradd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("config_monsteredit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("config_monsteradd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("config_monsterdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "unid:" . ew_VarToJson($this->unid->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->unid->CurrentValue)) {
			$sUrl .= "unid=" . urlencode($this->unid->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["unid"]))
				$arKeys[] = $_POST["unid"];
			elseif (isset($_GET["unid"]))
				$arKeys[] = $_GET["unid"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->unid->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->unid->setDbValue($rs->fields('unid'));
		$this->u_id->setDbValue($rs->fields('u_id'));
		$this->acl_id->setDbValue($rs->fields('acl_id'));
		$this->Monster_Name->setDbValue($rs->fields('Monster_Name'));
		$this->Monster_Type->setDbValue($rs->fields('Monster_Type'));
		$this->Monster_AD->setDbValue($rs->fields('Monster_AD'));
		$this->Monster_AP->setDbValue($rs->fields('Monster_AP'));
		$this->Monster_HP->setDbValue($rs->fields('Monster_HP'));
		$this->Monster_Defense->setDbValue($rs->fields('Monster_Defense'));
		$this->Monster_AbsorbHP->setDbValue($rs->fields('Monster_AbsorbHP'));
		$this->Monster_ADPTV->setDbValue($rs->fields('Monster_ADPTV'));
		$this->Monster_ADPTR->setDbValue($rs->fields('Monster_ADPTR'));
		$this->Monster_APPTR->setDbValue($rs->fields('Monster_APPTR'));
		$this->Monster_APPTV->setDbValue($rs->fields('Monster_APPTV'));
		$this->Monster_ImmuneDamage->setDbValue($rs->fields('Monster_ImmuneDamage'));
		$this->Skills->setDbValue($rs->fields('Skills'));
		$this->Reward_Goods->setDbValue($rs->fields('Reward_Goods'));
		$this->Reward_Exp->setDbValue($rs->fields('Reward_Exp'));
		$this->Reward_Gold->setDbValue($rs->fields('Reward_Gold'));
		$this->Introduce->setDbValue($rs->fields('Introduce'));
		$this->AttackEffect->setDbValue($rs->fields('AttackEffect'));
		$this->AttackTips->setDbValue($rs->fields('AttackTips'));
		$this->MagicResistance->setDbValue($rs->fields('MagicResistance'));
		$this->Hit->setDbValue($rs->fields('Hit'));
		$this->Dodge->setDbValue($rs->fields('Dodge'));
		$this->IgnoreShield->setDbValue($rs->fields('IgnoreShield'));
		$this->DATETIME->setDbValue($rs->fields('DATETIME'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// unid
		// u_id
		// acl_id
		// Monster_Name
		// Monster_Type
		// Monster_AD
		// Monster_AP
		// Monster_HP
		// Monster_Defense
		// Monster_AbsorbHP
		// Monster_ADPTV
		// Monster_ADPTR
		// Monster_APPTR
		// Monster_APPTV
		// Monster_ImmuneDamage
		// Skills
		// Reward_Goods
		// Reward_Exp
		// Reward_Gold
		// Introduce
		// AttackEffect
		// AttackTips
		// MagicResistance
		// Hit
		// Dodge
		// IgnoreShield
		// DATETIME
		// unid

		$this->unid->ViewValue = $this->unid->CurrentValue;
		$this->unid->ViewCustomAttributes = "";

		// u_id
		$this->u_id->ViewValue = $this->u_id->CurrentValue;
		$this->u_id->ViewCustomAttributes = "";

		// acl_id
		$this->acl_id->ViewValue = $this->acl_id->CurrentValue;
		$this->acl_id->ViewCustomAttributes = "";

		// Monster_Name
		$this->Monster_Name->ViewValue = $this->Monster_Name->CurrentValue;
		$this->Monster_Name->ViewCustomAttributes = "";

		// Monster_Type
		$this->Monster_Type->ViewValue = $this->Monster_Type->CurrentValue;
		$this->Monster_Type->ViewCustomAttributes = "";

		// Monster_AD
		$this->Monster_AD->ViewValue = $this->Monster_AD->CurrentValue;
		$this->Monster_AD->ViewCustomAttributes = "";

		// Monster_AP
		$this->Monster_AP->ViewValue = $this->Monster_AP->CurrentValue;
		$this->Monster_AP->ViewCustomAttributes = "";

		// Monster_HP
		$this->Monster_HP->ViewValue = $this->Monster_HP->CurrentValue;
		$this->Monster_HP->ViewCustomAttributes = "";

		// Monster_Defense
		$this->Monster_Defense->ViewValue = $this->Monster_Defense->CurrentValue;
		$this->Monster_Defense->ViewCustomAttributes = "";

		// Monster_AbsorbHP
		$this->Monster_AbsorbHP->ViewValue = $this->Monster_AbsorbHP->CurrentValue;
		$this->Monster_AbsorbHP->ViewCustomAttributes = "";

		// Monster_ADPTV
		$this->Monster_ADPTV->ViewValue = $this->Monster_ADPTV->CurrentValue;
		$this->Monster_ADPTV->ViewCustomAttributes = "";

		// Monster_ADPTR
		$this->Monster_ADPTR->ViewValue = $this->Monster_ADPTR->CurrentValue;
		$this->Monster_ADPTR->ViewCustomAttributes = "";

		// Monster_APPTR
		$this->Monster_APPTR->ViewValue = $this->Monster_APPTR->CurrentValue;
		$this->Monster_APPTR->ViewCustomAttributes = "";

		// Monster_APPTV
		$this->Monster_APPTV->ViewValue = $this->Monster_APPTV->CurrentValue;
		$this->Monster_APPTV->ViewCustomAttributes = "";

		// Monster_ImmuneDamage
		$this->Monster_ImmuneDamage->ViewValue = $this->Monster_ImmuneDamage->CurrentValue;
		$this->Monster_ImmuneDamage->ViewCustomAttributes = "";

		// Skills
		$this->Skills->ViewValue = $this->Skills->CurrentValue;
		$this->Skills->ViewCustomAttributes = "";

		// Reward_Goods
		$this->Reward_Goods->ViewValue = $this->Reward_Goods->CurrentValue;
		$this->Reward_Goods->ViewCustomAttributes = "";

		// Reward_Exp
		$this->Reward_Exp->ViewValue = $this->Reward_Exp->CurrentValue;
		$this->Reward_Exp->ViewCustomAttributes = "";

		// Reward_Gold
		$this->Reward_Gold->ViewValue = $this->Reward_Gold->CurrentValue;
		$this->Reward_Gold->ViewCustomAttributes = "";

		// Introduce
		$this->Introduce->ViewValue = $this->Introduce->CurrentValue;
		$this->Introduce->ViewCustomAttributes = "";

		// AttackEffect
		$this->AttackEffect->ViewValue = $this->AttackEffect->CurrentValue;
		$this->AttackEffect->ViewCustomAttributes = "";

		// AttackTips
		$this->AttackTips->ViewValue = $this->AttackTips->CurrentValue;
		$this->AttackTips->ViewCustomAttributes = "";

		// MagicResistance
		$this->MagicResistance->ViewValue = $this->MagicResistance->CurrentValue;
		$this->MagicResistance->ViewCustomAttributes = "";

		// Hit
		$this->Hit->ViewValue = $this->Hit->CurrentValue;
		$this->Hit->ViewCustomAttributes = "";

		// Dodge
		$this->Dodge->ViewValue = $this->Dodge->CurrentValue;
		$this->Dodge->ViewCustomAttributes = "";

		// IgnoreShield
		$this->IgnoreShield->ViewValue = $this->IgnoreShield->CurrentValue;
		$this->IgnoreShield->ViewCustomAttributes = "";

		// DATETIME
		$this->DATETIME->ViewValue = $this->DATETIME->CurrentValue;
		$this->DATETIME->ViewValue = ew_FormatDateTime($this->DATETIME->ViewValue, 0);
		$this->DATETIME->ViewCustomAttributes = "";

		// unid
		$this->unid->LinkCustomAttributes = "";
		$this->unid->HrefValue = "";
		$this->unid->TooltipValue = "";

		// u_id
		$this->u_id->LinkCustomAttributes = "";
		$this->u_id->HrefValue = "";
		$this->u_id->TooltipValue = "";

		// acl_id
		$this->acl_id->LinkCustomAttributes = "";
		$this->acl_id->HrefValue = "";
		$this->acl_id->TooltipValue = "";

		// Monster_Name
		$this->Monster_Name->LinkCustomAttributes = "";
		$this->Monster_Name->HrefValue = "";
		$this->Monster_Name->TooltipValue = "";

		// Monster_Type
		$this->Monster_Type->LinkCustomAttributes = "";
		$this->Monster_Type->HrefValue = "";
		$this->Monster_Type->TooltipValue = "";

		// Monster_AD
		$this->Monster_AD->LinkCustomAttributes = "";
		$this->Monster_AD->HrefValue = "";
		$this->Monster_AD->TooltipValue = "";

		// Monster_AP
		$this->Monster_AP->LinkCustomAttributes = "";
		$this->Monster_AP->HrefValue = "";
		$this->Monster_AP->TooltipValue = "";

		// Monster_HP
		$this->Monster_HP->LinkCustomAttributes = "";
		$this->Monster_HP->HrefValue = "";
		$this->Monster_HP->TooltipValue = "";

		// Monster_Defense
		$this->Monster_Defense->LinkCustomAttributes = "";
		$this->Monster_Defense->HrefValue = "";
		$this->Monster_Defense->TooltipValue = "";

		// Monster_AbsorbHP
		$this->Monster_AbsorbHP->LinkCustomAttributes = "";
		$this->Monster_AbsorbHP->HrefValue = "";
		$this->Monster_AbsorbHP->TooltipValue = "";

		// Monster_ADPTV
		$this->Monster_ADPTV->LinkCustomAttributes = "";
		$this->Monster_ADPTV->HrefValue = "";
		$this->Monster_ADPTV->TooltipValue = "";

		// Monster_ADPTR
		$this->Monster_ADPTR->LinkCustomAttributes = "";
		$this->Monster_ADPTR->HrefValue = "";
		$this->Monster_ADPTR->TooltipValue = "";

		// Monster_APPTR
		$this->Monster_APPTR->LinkCustomAttributes = "";
		$this->Monster_APPTR->HrefValue = "";
		$this->Monster_APPTR->TooltipValue = "";

		// Monster_APPTV
		$this->Monster_APPTV->LinkCustomAttributes = "";
		$this->Monster_APPTV->HrefValue = "";
		$this->Monster_APPTV->TooltipValue = "";

		// Monster_ImmuneDamage
		$this->Monster_ImmuneDamage->LinkCustomAttributes = "";
		$this->Monster_ImmuneDamage->HrefValue = "";
		$this->Monster_ImmuneDamage->TooltipValue = "";

		// Skills
		$this->Skills->LinkCustomAttributes = "";
		$this->Skills->HrefValue = "";
		$this->Skills->TooltipValue = "";

		// Reward_Goods
		$this->Reward_Goods->LinkCustomAttributes = "";
		$this->Reward_Goods->HrefValue = "";
		$this->Reward_Goods->TooltipValue = "";

		// Reward_Exp
		$this->Reward_Exp->LinkCustomAttributes = "";
		$this->Reward_Exp->HrefValue = "";
		$this->Reward_Exp->TooltipValue = "";

		// Reward_Gold
		$this->Reward_Gold->LinkCustomAttributes = "";
		$this->Reward_Gold->HrefValue = "";
		$this->Reward_Gold->TooltipValue = "";

		// Introduce
		$this->Introduce->LinkCustomAttributes = "";
		$this->Introduce->HrefValue = "";
		$this->Introduce->TooltipValue = "";

		// AttackEffect
		$this->AttackEffect->LinkCustomAttributes = "";
		$this->AttackEffect->HrefValue = "";
		$this->AttackEffect->TooltipValue = "";

		// AttackTips
		$this->AttackTips->LinkCustomAttributes = "";
		$this->AttackTips->HrefValue = "";
		$this->AttackTips->TooltipValue = "";

		// MagicResistance
		$this->MagicResistance->LinkCustomAttributes = "";
		$this->MagicResistance->HrefValue = "";
		$this->MagicResistance->TooltipValue = "";

		// Hit
		$this->Hit->LinkCustomAttributes = "";
		$this->Hit->HrefValue = "";
		$this->Hit->TooltipValue = "";

		// Dodge
		$this->Dodge->LinkCustomAttributes = "";
		$this->Dodge->HrefValue = "";
		$this->Dodge->TooltipValue = "";

		// IgnoreShield
		$this->IgnoreShield->LinkCustomAttributes = "";
		$this->IgnoreShield->HrefValue = "";
		$this->IgnoreShield->TooltipValue = "";

		// DATETIME
		$this->DATETIME->LinkCustomAttributes = "";
		$this->DATETIME->HrefValue = "";
		$this->DATETIME->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// unid
		$this->unid->EditAttrs["class"] = "form-control";
		$this->unid->EditCustomAttributes = "";
		$this->unid->EditValue = $this->unid->CurrentValue;
		$this->unid->ViewCustomAttributes = "";

		// u_id
		$this->u_id->EditAttrs["class"] = "form-control";
		$this->u_id->EditCustomAttributes = "";
		$this->u_id->EditValue = $this->u_id->CurrentValue;
		$this->u_id->PlaceHolder = ew_RemoveHtml($this->u_id->FldCaption());

		// acl_id
		$this->acl_id->EditAttrs["class"] = "form-control";
		$this->acl_id->EditCustomAttributes = "";
		$this->acl_id->EditValue = $this->acl_id->CurrentValue;
		$this->acl_id->PlaceHolder = ew_RemoveHtml($this->acl_id->FldCaption());

		// Monster_Name
		$this->Monster_Name->EditAttrs["class"] = "form-control";
		$this->Monster_Name->EditCustomAttributes = "";
		$this->Monster_Name->EditValue = $this->Monster_Name->CurrentValue;
		$this->Monster_Name->PlaceHolder = ew_RemoveHtml($this->Monster_Name->FldCaption());

		// Monster_Type
		$this->Monster_Type->EditAttrs["class"] = "form-control";
		$this->Monster_Type->EditCustomAttributes = "";
		$this->Monster_Type->EditValue = $this->Monster_Type->CurrentValue;
		$this->Monster_Type->PlaceHolder = ew_RemoveHtml($this->Monster_Type->FldCaption());

		// Monster_AD
		$this->Monster_AD->EditAttrs["class"] = "form-control";
		$this->Monster_AD->EditCustomAttributes = "";
		$this->Monster_AD->EditValue = $this->Monster_AD->CurrentValue;
		$this->Monster_AD->PlaceHolder = ew_RemoveHtml($this->Monster_AD->FldCaption());

		// Monster_AP
		$this->Monster_AP->EditAttrs["class"] = "form-control";
		$this->Monster_AP->EditCustomAttributes = "";
		$this->Monster_AP->EditValue = $this->Monster_AP->CurrentValue;
		$this->Monster_AP->PlaceHolder = ew_RemoveHtml($this->Monster_AP->FldCaption());

		// Monster_HP
		$this->Monster_HP->EditAttrs["class"] = "form-control";
		$this->Monster_HP->EditCustomAttributes = "";
		$this->Monster_HP->EditValue = $this->Monster_HP->CurrentValue;
		$this->Monster_HP->PlaceHolder = ew_RemoveHtml($this->Monster_HP->FldCaption());

		// Monster_Defense
		$this->Monster_Defense->EditAttrs["class"] = "form-control";
		$this->Monster_Defense->EditCustomAttributes = "";
		$this->Monster_Defense->EditValue = $this->Monster_Defense->CurrentValue;
		$this->Monster_Defense->PlaceHolder = ew_RemoveHtml($this->Monster_Defense->FldCaption());

		// Monster_AbsorbHP
		$this->Monster_AbsorbHP->EditAttrs["class"] = "form-control";
		$this->Monster_AbsorbHP->EditCustomAttributes = "";
		$this->Monster_AbsorbHP->EditValue = $this->Monster_AbsorbHP->CurrentValue;
		$this->Monster_AbsorbHP->PlaceHolder = ew_RemoveHtml($this->Monster_AbsorbHP->FldCaption());

		// Monster_ADPTV
		$this->Monster_ADPTV->EditAttrs["class"] = "form-control";
		$this->Monster_ADPTV->EditCustomAttributes = "";
		$this->Monster_ADPTV->EditValue = $this->Monster_ADPTV->CurrentValue;
		$this->Monster_ADPTV->PlaceHolder = ew_RemoveHtml($this->Monster_ADPTV->FldCaption());

		// Monster_ADPTR
		$this->Monster_ADPTR->EditAttrs["class"] = "form-control";
		$this->Monster_ADPTR->EditCustomAttributes = "";
		$this->Monster_ADPTR->EditValue = $this->Monster_ADPTR->CurrentValue;
		$this->Monster_ADPTR->PlaceHolder = ew_RemoveHtml($this->Monster_ADPTR->FldCaption());

		// Monster_APPTR
		$this->Monster_APPTR->EditAttrs["class"] = "form-control";
		$this->Monster_APPTR->EditCustomAttributes = "";
		$this->Monster_APPTR->EditValue = $this->Monster_APPTR->CurrentValue;
		$this->Monster_APPTR->PlaceHolder = ew_RemoveHtml($this->Monster_APPTR->FldCaption());

		// Monster_APPTV
		$this->Monster_APPTV->EditAttrs["class"] = "form-control";
		$this->Monster_APPTV->EditCustomAttributes = "";
		$this->Monster_APPTV->EditValue = $this->Monster_APPTV->CurrentValue;
		$this->Monster_APPTV->PlaceHolder = ew_RemoveHtml($this->Monster_APPTV->FldCaption());

		// Monster_ImmuneDamage
		$this->Monster_ImmuneDamage->EditAttrs["class"] = "form-control";
		$this->Monster_ImmuneDamage->EditCustomAttributes = "";
		$this->Monster_ImmuneDamage->EditValue = $this->Monster_ImmuneDamage->CurrentValue;
		$this->Monster_ImmuneDamage->PlaceHolder = ew_RemoveHtml($this->Monster_ImmuneDamage->FldCaption());

		// Skills
		$this->Skills->EditAttrs["class"] = "form-control";
		$this->Skills->EditCustomAttributes = "";
		$this->Skills->EditValue = $this->Skills->CurrentValue;
		$this->Skills->PlaceHolder = ew_RemoveHtml($this->Skills->FldCaption());

		// Reward_Goods
		$this->Reward_Goods->EditAttrs["class"] = "form-control";
		$this->Reward_Goods->EditCustomAttributes = "";
		$this->Reward_Goods->EditValue = $this->Reward_Goods->CurrentValue;
		$this->Reward_Goods->PlaceHolder = ew_RemoveHtml($this->Reward_Goods->FldCaption());

		// Reward_Exp
		$this->Reward_Exp->EditAttrs["class"] = "form-control";
		$this->Reward_Exp->EditCustomAttributes = "";
		$this->Reward_Exp->EditValue = $this->Reward_Exp->CurrentValue;
		$this->Reward_Exp->PlaceHolder = ew_RemoveHtml($this->Reward_Exp->FldCaption());

		// Reward_Gold
		$this->Reward_Gold->EditAttrs["class"] = "form-control";
		$this->Reward_Gold->EditCustomAttributes = "";
		$this->Reward_Gold->EditValue = $this->Reward_Gold->CurrentValue;
		$this->Reward_Gold->PlaceHolder = ew_RemoveHtml($this->Reward_Gold->FldCaption());

		// Introduce
		$this->Introduce->EditAttrs["class"] = "form-control";
		$this->Introduce->EditCustomAttributes = "";
		$this->Introduce->EditValue = $this->Introduce->CurrentValue;
		$this->Introduce->PlaceHolder = ew_RemoveHtml($this->Introduce->FldCaption());

		// AttackEffect
		$this->AttackEffect->EditAttrs["class"] = "form-control";
		$this->AttackEffect->EditCustomAttributes = "";
		$this->AttackEffect->EditValue = $this->AttackEffect->CurrentValue;
		$this->AttackEffect->PlaceHolder = ew_RemoveHtml($this->AttackEffect->FldCaption());

		// AttackTips
		$this->AttackTips->EditAttrs["class"] = "form-control";
		$this->AttackTips->EditCustomAttributes = "";
		$this->AttackTips->EditValue = $this->AttackTips->CurrentValue;
		$this->AttackTips->PlaceHolder = ew_RemoveHtml($this->AttackTips->FldCaption());

		// MagicResistance
		$this->MagicResistance->EditAttrs["class"] = "form-control";
		$this->MagicResistance->EditCustomAttributes = "";
		$this->MagicResistance->EditValue = $this->MagicResistance->CurrentValue;
		$this->MagicResistance->PlaceHolder = ew_RemoveHtml($this->MagicResistance->FldCaption());

		// Hit
		$this->Hit->EditAttrs["class"] = "form-control";
		$this->Hit->EditCustomAttributes = "";
		$this->Hit->EditValue = $this->Hit->CurrentValue;
		$this->Hit->PlaceHolder = ew_RemoveHtml($this->Hit->FldCaption());

		// Dodge
		$this->Dodge->EditAttrs["class"] = "form-control";
		$this->Dodge->EditCustomAttributes = "";
		$this->Dodge->EditValue = $this->Dodge->CurrentValue;
		$this->Dodge->PlaceHolder = ew_RemoveHtml($this->Dodge->FldCaption());

		// IgnoreShield
		$this->IgnoreShield->EditAttrs["class"] = "form-control";
		$this->IgnoreShield->EditCustomAttributes = "";
		$this->IgnoreShield->EditValue = $this->IgnoreShield->CurrentValue;
		$this->IgnoreShield->PlaceHolder = ew_RemoveHtml($this->IgnoreShield->FldCaption());

		// DATETIME
		$this->DATETIME->EditAttrs["class"] = "form-control";
		$this->DATETIME->EditCustomAttributes = "";
		$this->DATETIME->EditValue = ew_FormatDateTime($this->DATETIME->CurrentValue, 8);
		$this->DATETIME->PlaceHolder = ew_RemoveHtml($this->DATETIME->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->unid->Exportable) $Doc->ExportCaption($this->unid);
					if ($this->u_id->Exportable) $Doc->ExportCaption($this->u_id);
					if ($this->acl_id->Exportable) $Doc->ExportCaption($this->acl_id);
					if ($this->Monster_Name->Exportable) $Doc->ExportCaption($this->Monster_Name);
					if ($this->Monster_Type->Exportable) $Doc->ExportCaption($this->Monster_Type);
					if ($this->Monster_AD->Exportable) $Doc->ExportCaption($this->Monster_AD);
					if ($this->Monster_AP->Exportable) $Doc->ExportCaption($this->Monster_AP);
					if ($this->Monster_HP->Exportable) $Doc->ExportCaption($this->Monster_HP);
					if ($this->Monster_Defense->Exportable) $Doc->ExportCaption($this->Monster_Defense);
					if ($this->Monster_AbsorbHP->Exportable) $Doc->ExportCaption($this->Monster_AbsorbHP);
					if ($this->Monster_ADPTV->Exportable) $Doc->ExportCaption($this->Monster_ADPTV);
					if ($this->Monster_ADPTR->Exportable) $Doc->ExportCaption($this->Monster_ADPTR);
					if ($this->Monster_APPTR->Exportable) $Doc->ExportCaption($this->Monster_APPTR);
					if ($this->Monster_APPTV->Exportable) $Doc->ExportCaption($this->Monster_APPTV);
					if ($this->Monster_ImmuneDamage->Exportable) $Doc->ExportCaption($this->Monster_ImmuneDamage);
					if ($this->Skills->Exportable) $Doc->ExportCaption($this->Skills);
					if ($this->Reward_Goods->Exportable) $Doc->ExportCaption($this->Reward_Goods);
					if ($this->Reward_Exp->Exportable) $Doc->ExportCaption($this->Reward_Exp);
					if ($this->Reward_Gold->Exportable) $Doc->ExportCaption($this->Reward_Gold);
					if ($this->Introduce->Exportable) $Doc->ExportCaption($this->Introduce);
					if ($this->AttackEffect->Exportable) $Doc->ExportCaption($this->AttackEffect);
					if ($this->AttackTips->Exportable) $Doc->ExportCaption($this->AttackTips);
					if ($this->MagicResistance->Exportable) $Doc->ExportCaption($this->MagicResistance);
					if ($this->Hit->Exportable) $Doc->ExportCaption($this->Hit);
					if ($this->Dodge->Exportable) $Doc->ExportCaption($this->Dodge);
					if ($this->IgnoreShield->Exportable) $Doc->ExportCaption($this->IgnoreShield);
					if ($this->DATETIME->Exportable) $Doc->ExportCaption($this->DATETIME);
				} else {
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->unid->Exportable) $Doc->ExportField($this->unid);
						if ($this->u_id->Exportable) $Doc->ExportField($this->u_id);
						if ($this->acl_id->Exportable) $Doc->ExportField($this->acl_id);
						if ($this->Monster_Name->Exportable) $Doc->ExportField($this->Monster_Name);
						if ($this->Monster_Type->Exportable) $Doc->ExportField($this->Monster_Type);
						if ($this->Monster_AD->Exportable) $Doc->ExportField($this->Monster_AD);
						if ($this->Monster_AP->Exportable) $Doc->ExportField($this->Monster_AP);
						if ($this->Monster_HP->Exportable) $Doc->ExportField($this->Monster_HP);
						if ($this->Monster_Defense->Exportable) $Doc->ExportField($this->Monster_Defense);
						if ($this->Monster_AbsorbHP->Exportable) $Doc->ExportField($this->Monster_AbsorbHP);
						if ($this->Monster_ADPTV->Exportable) $Doc->ExportField($this->Monster_ADPTV);
						if ($this->Monster_ADPTR->Exportable) $Doc->ExportField($this->Monster_ADPTR);
						if ($this->Monster_APPTR->Exportable) $Doc->ExportField($this->Monster_APPTR);
						if ($this->Monster_APPTV->Exportable) $Doc->ExportField($this->Monster_APPTV);
						if ($this->Monster_ImmuneDamage->Exportable) $Doc->ExportField($this->Monster_ImmuneDamage);
						if ($this->Skills->Exportable) $Doc->ExportField($this->Skills);
						if ($this->Reward_Goods->Exportable) $Doc->ExportField($this->Reward_Goods);
						if ($this->Reward_Exp->Exportable) $Doc->ExportField($this->Reward_Exp);
						if ($this->Reward_Gold->Exportable) $Doc->ExportField($this->Reward_Gold);
						if ($this->Introduce->Exportable) $Doc->ExportField($this->Introduce);
						if ($this->AttackEffect->Exportable) $Doc->ExportField($this->AttackEffect);
						if ($this->AttackTips->Exportable) $Doc->ExportField($this->AttackTips);
						if ($this->MagicResistance->Exportable) $Doc->ExportField($this->MagicResistance);
						if ($this->Hit->Exportable) $Doc->ExportField($this->Hit);
						if ($this->Dodge->Exportable) $Doc->ExportField($this->Dodge);
						if ($this->IgnoreShield->Exportable) $Doc->ExportField($this->IgnoreShield);
						if ($this->DATETIME->Exportable) $Doc->ExportField($this->DATETIME);
					} else {
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
