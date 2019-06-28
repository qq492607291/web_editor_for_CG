<?php

// Global variable for table object
$config_occupation = NULL;

//
// Table class for config_occupation
//
class cconfig_occupation extends cTable {
	var $unid;
	var $u_id;
	var $acl_id;
	var $Name;
	var $Basics;
	var $HP;
	var $MP;
	var $AD;
	var $AP;
	var $Defense;
	var $Hit;
	var $Dodge;
	var $Crit;
	var $AbsorbHP;
	var $ADPTV;
	var $ADPTR;
	var $APPTR;
	var $APPTV;
	var $ImmuneDamage;
	var $Intro;
	var $ExclusiveSkills;
	var $TransferDemand;
	var $TransferLevel;
	var $FormerOccupation;
	var $Belong;
	var $AttackEffect;
	var $AttackTips;
	var $MagicResistance;
	var $IgnoreShield;
	var $DATETIME;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'config_occupation';
		$this->TableName = 'config_occupation';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`config_occupation`";
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
		$this->unid = new cField('config_occupation', 'config_occupation', 'x_unid', 'unid', '`unid`', '`unid`', 3, -1, FALSE, '`unid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->unid->Sortable = TRUE; // Allow sort
		$this->unid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unid'] = &$this->unid;

		// u_id
		$this->u_id = new cField('config_occupation', 'config_occupation', 'x_u_id', 'u_id', '`u_id`', '`u_id`', 3, -1, FALSE, '`u_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_id->Sortable = TRUE; // Allow sort
		$this->u_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_id'] = &$this->u_id;

		// acl_id
		$this->acl_id = new cField('config_occupation', 'config_occupation', 'x_acl_id', 'acl_id', '`acl_id`', '`acl_id`', 3, -1, FALSE, '`acl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acl_id->Sortable = TRUE; // Allow sort
		$this->acl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['acl_id'] = &$this->acl_id;

		// Name
		$this->Name = new cField('config_occupation', 'config_occupation', 'x_Name', 'Name', '`Name`', '`Name`', 201, -1, FALSE, '`Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Name->Sortable = TRUE; // Allow sort
		$this->fields['Name'] = &$this->Name;

		// Basics
		$this->Basics = new cField('config_occupation', 'config_occupation', 'x_Basics', 'Basics', '`Basics`', '`Basics`', 201, -1, FALSE, '`Basics`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Basics->Sortable = TRUE; // Allow sort
		$this->fields['Basics'] = &$this->Basics;

		// HP
		$this->HP = new cField('config_occupation', 'config_occupation', 'x_HP', 'HP', '`HP`', '`HP`', 201, -1, FALSE, '`HP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->HP->Sortable = TRUE; // Allow sort
		$this->fields['HP'] = &$this->HP;

		// MP
		$this->MP = new cField('config_occupation', 'config_occupation', 'x_MP', 'MP', '`MP`', '`MP`', 201, -1, FALSE, '`MP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->MP->Sortable = TRUE; // Allow sort
		$this->fields['MP'] = &$this->MP;

		// AD
		$this->AD = new cField('config_occupation', 'config_occupation', 'x_AD', 'AD', '`AD`', '`AD`', 201, -1, FALSE, '`AD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->AD->Sortable = TRUE; // Allow sort
		$this->fields['AD'] = &$this->AD;

		// AP
		$this->AP = new cField('config_occupation', 'config_occupation', 'x_AP', 'AP', '`AP`', '`AP`', 201, -1, FALSE, '`AP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->AP->Sortable = TRUE; // Allow sort
		$this->fields['AP'] = &$this->AP;

		// Defense
		$this->Defense = new cField('config_occupation', 'config_occupation', 'x_Defense', 'Defense', '`Defense`', '`Defense`', 201, -1, FALSE, '`Defense`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Defense->Sortable = TRUE; // Allow sort
		$this->fields['Defense'] = &$this->Defense;

		// Hit
		$this->Hit = new cField('config_occupation', 'config_occupation', 'x_Hit', 'Hit', '`Hit`', '`Hit`', 201, -1, FALSE, '`Hit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Hit->Sortable = TRUE; // Allow sort
		$this->fields['Hit'] = &$this->Hit;

		// Dodge
		$this->Dodge = new cField('config_occupation', 'config_occupation', 'x_Dodge', 'Dodge', '`Dodge`', '`Dodge`', 201, -1, FALSE, '`Dodge`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Dodge->Sortable = TRUE; // Allow sort
		$this->fields['Dodge'] = &$this->Dodge;

		// Crit
		$this->Crit = new cField('config_occupation', 'config_occupation', 'x_Crit', 'Crit', '`Crit`', '`Crit`', 201, -1, FALSE, '`Crit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Crit->Sortable = TRUE; // Allow sort
		$this->fields['Crit'] = &$this->Crit;

		// AbsorbHP
		$this->AbsorbHP = new cField('config_occupation', 'config_occupation', 'x_AbsorbHP', 'AbsorbHP', '`AbsorbHP`', '`AbsorbHP`', 201, -1, FALSE, '`AbsorbHP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->AbsorbHP->Sortable = TRUE; // Allow sort
		$this->fields['AbsorbHP'] = &$this->AbsorbHP;

		// ADPTV
		$this->ADPTV = new cField('config_occupation', 'config_occupation', 'x_ADPTV', 'ADPTV', '`ADPTV`', '`ADPTV`', 201, -1, FALSE, '`ADPTV`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->ADPTV->Sortable = TRUE; // Allow sort
		$this->fields['ADPTV'] = &$this->ADPTV;

		// ADPTR
		$this->ADPTR = new cField('config_occupation', 'config_occupation', 'x_ADPTR', 'ADPTR', '`ADPTR`', '`ADPTR`', 201, -1, FALSE, '`ADPTR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->ADPTR->Sortable = TRUE; // Allow sort
		$this->fields['ADPTR'] = &$this->ADPTR;

		// APPTR
		$this->APPTR = new cField('config_occupation', 'config_occupation', 'x_APPTR', 'APPTR', '`APPTR`', '`APPTR`', 201, -1, FALSE, '`APPTR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->APPTR->Sortable = TRUE; // Allow sort
		$this->fields['APPTR'] = &$this->APPTR;

		// APPTV
		$this->APPTV = new cField('config_occupation', 'config_occupation', 'x_APPTV', 'APPTV', '`APPTV`', '`APPTV`', 201, -1, FALSE, '`APPTV`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->APPTV->Sortable = TRUE; // Allow sort
		$this->fields['APPTV'] = &$this->APPTV;

		// ImmuneDamage
		$this->ImmuneDamage = new cField('config_occupation', 'config_occupation', 'x_ImmuneDamage', 'ImmuneDamage', '`ImmuneDamage`', '`ImmuneDamage`', 201, -1, FALSE, '`ImmuneDamage`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->ImmuneDamage->Sortable = TRUE; // Allow sort
		$this->fields['ImmuneDamage'] = &$this->ImmuneDamage;

		// Intro
		$this->Intro = new cField('config_occupation', 'config_occupation', 'x_Intro', 'Intro', '`Intro`', '`Intro`', 201, -1, FALSE, '`Intro`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Intro->Sortable = TRUE; // Allow sort
		$this->fields['Intro'] = &$this->Intro;

		// ExclusiveSkills
		$this->ExclusiveSkills = new cField('config_occupation', 'config_occupation', 'x_ExclusiveSkills', 'ExclusiveSkills', '`ExclusiveSkills`', '`ExclusiveSkills`', 201, -1, FALSE, '`ExclusiveSkills`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->ExclusiveSkills->Sortable = TRUE; // Allow sort
		$this->fields['ExclusiveSkills'] = &$this->ExclusiveSkills;

		// TransferDemand
		$this->TransferDemand = new cField('config_occupation', 'config_occupation', 'x_TransferDemand', 'TransferDemand', '`TransferDemand`', '`TransferDemand`', 201, -1, FALSE, '`TransferDemand`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->TransferDemand->Sortable = TRUE; // Allow sort
		$this->fields['TransferDemand'] = &$this->TransferDemand;

		// TransferLevel
		$this->TransferLevel = new cField('config_occupation', 'config_occupation', 'x_TransferLevel', 'TransferLevel', '`TransferLevel`', '`TransferLevel`', 201, -1, FALSE, '`TransferLevel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->TransferLevel->Sortable = TRUE; // Allow sort
		$this->fields['TransferLevel'] = &$this->TransferLevel;

		// FormerOccupation
		$this->FormerOccupation = new cField('config_occupation', 'config_occupation', 'x_FormerOccupation', 'FormerOccupation', '`FormerOccupation`', '`FormerOccupation`', 201, -1, FALSE, '`FormerOccupation`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->FormerOccupation->Sortable = TRUE; // Allow sort
		$this->fields['FormerOccupation'] = &$this->FormerOccupation;

		// Belong
		$this->Belong = new cField('config_occupation', 'config_occupation', 'x_Belong', 'Belong', '`Belong`', '`Belong`', 201, -1, FALSE, '`Belong`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Belong->Sortable = TRUE; // Allow sort
		$this->fields['Belong'] = &$this->Belong;

		// AttackEffect
		$this->AttackEffect = new cField('config_occupation', 'config_occupation', 'x_AttackEffect', 'AttackEffect', '`AttackEffect`', '`AttackEffect`', 201, -1, FALSE, '`AttackEffect`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->AttackEffect->Sortable = TRUE; // Allow sort
		$this->fields['AttackEffect'] = &$this->AttackEffect;

		// AttackTips
		$this->AttackTips = new cField('config_occupation', 'config_occupation', 'x_AttackTips', 'AttackTips', '`AttackTips`', '`AttackTips`', 201, -1, FALSE, '`AttackTips`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->AttackTips->Sortable = TRUE; // Allow sort
		$this->fields['AttackTips'] = &$this->AttackTips;

		// MagicResistance
		$this->MagicResistance = new cField('config_occupation', 'config_occupation', 'x_MagicResistance', 'MagicResistance', '`MagicResistance`', '`MagicResistance`', 201, -1, FALSE, '`MagicResistance`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->MagicResistance->Sortable = TRUE; // Allow sort
		$this->fields['MagicResistance'] = &$this->MagicResistance;

		// IgnoreShield
		$this->IgnoreShield = new cField('config_occupation', 'config_occupation', 'x_IgnoreShield', 'IgnoreShield', '`IgnoreShield`', '`IgnoreShield`', 201, -1, FALSE, '`IgnoreShield`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->IgnoreShield->Sortable = TRUE; // Allow sort
		$this->fields['IgnoreShield'] = &$this->IgnoreShield;

		// DATETIME
		$this->DATETIME = new cField('config_occupation', 'config_occupation', 'x_DATETIME', 'DATETIME', '`DATETIME`', ew_CastDateFieldForLike('`DATETIME`', 0, "DB"), 135, 0, FALSE, '`DATETIME`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DATETIME->Sortable = TRUE; // Allow sort
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`config_occupation`";
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
			return "config_occupationlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "config_occupationview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "config_occupationedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "config_occupationadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "config_occupationlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("config_occupationview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("config_occupationview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "config_occupationadd.php?" . $this->UrlParm($parm);
		else
			$url = "config_occupationadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("config_occupationedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("config_occupationadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("config_occupationdelete.php", $this->UrlParm());
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
		$this->Name->setDbValue($rs->fields('Name'));
		$this->Basics->setDbValue($rs->fields('Basics'));
		$this->HP->setDbValue($rs->fields('HP'));
		$this->MP->setDbValue($rs->fields('MP'));
		$this->AD->setDbValue($rs->fields('AD'));
		$this->AP->setDbValue($rs->fields('AP'));
		$this->Defense->setDbValue($rs->fields('Defense'));
		$this->Hit->setDbValue($rs->fields('Hit'));
		$this->Dodge->setDbValue($rs->fields('Dodge'));
		$this->Crit->setDbValue($rs->fields('Crit'));
		$this->AbsorbHP->setDbValue($rs->fields('AbsorbHP'));
		$this->ADPTV->setDbValue($rs->fields('ADPTV'));
		$this->ADPTR->setDbValue($rs->fields('ADPTR'));
		$this->APPTR->setDbValue($rs->fields('APPTR'));
		$this->APPTV->setDbValue($rs->fields('APPTV'));
		$this->ImmuneDamage->setDbValue($rs->fields('ImmuneDamage'));
		$this->Intro->setDbValue($rs->fields('Intro'));
		$this->ExclusiveSkills->setDbValue($rs->fields('ExclusiveSkills'));
		$this->TransferDemand->setDbValue($rs->fields('TransferDemand'));
		$this->TransferLevel->setDbValue($rs->fields('TransferLevel'));
		$this->FormerOccupation->setDbValue($rs->fields('FormerOccupation'));
		$this->Belong->setDbValue($rs->fields('Belong'));
		$this->AttackEffect->setDbValue($rs->fields('AttackEffect'));
		$this->AttackTips->setDbValue($rs->fields('AttackTips'));
		$this->MagicResistance->setDbValue($rs->fields('MagicResistance'));
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
		// Name
		// Basics
		// HP
		// MP
		// AD
		// AP
		// Defense
		// Hit
		// Dodge
		// Crit
		// AbsorbHP
		// ADPTV
		// ADPTR
		// APPTR
		// APPTV
		// ImmuneDamage
		// Intro
		// ExclusiveSkills
		// TransferDemand
		// TransferLevel
		// FormerOccupation
		// Belong
		// AttackEffect
		// AttackTips
		// MagicResistance
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

		// Name
		$this->Name->ViewValue = $this->Name->CurrentValue;
		$this->Name->ViewCustomAttributes = "";

		// Basics
		$this->Basics->ViewValue = $this->Basics->CurrentValue;
		$this->Basics->ViewCustomAttributes = "";

		// HP
		$this->HP->ViewValue = $this->HP->CurrentValue;
		$this->HP->ViewCustomAttributes = "";

		// MP
		$this->MP->ViewValue = $this->MP->CurrentValue;
		$this->MP->ViewCustomAttributes = "";

		// AD
		$this->AD->ViewValue = $this->AD->CurrentValue;
		$this->AD->ViewCustomAttributes = "";

		// AP
		$this->AP->ViewValue = $this->AP->CurrentValue;
		$this->AP->ViewCustomAttributes = "";

		// Defense
		$this->Defense->ViewValue = $this->Defense->CurrentValue;
		$this->Defense->ViewCustomAttributes = "";

		// Hit
		$this->Hit->ViewValue = $this->Hit->CurrentValue;
		$this->Hit->ViewCustomAttributes = "";

		// Dodge
		$this->Dodge->ViewValue = $this->Dodge->CurrentValue;
		$this->Dodge->ViewCustomAttributes = "";

		// Crit
		$this->Crit->ViewValue = $this->Crit->CurrentValue;
		$this->Crit->ViewCustomAttributes = "";

		// AbsorbHP
		$this->AbsorbHP->ViewValue = $this->AbsorbHP->CurrentValue;
		$this->AbsorbHP->ViewCustomAttributes = "";

		// ADPTV
		$this->ADPTV->ViewValue = $this->ADPTV->CurrentValue;
		$this->ADPTV->ViewCustomAttributes = "";

		// ADPTR
		$this->ADPTR->ViewValue = $this->ADPTR->CurrentValue;
		$this->ADPTR->ViewCustomAttributes = "";

		// APPTR
		$this->APPTR->ViewValue = $this->APPTR->CurrentValue;
		$this->APPTR->ViewCustomAttributes = "";

		// APPTV
		$this->APPTV->ViewValue = $this->APPTV->CurrentValue;
		$this->APPTV->ViewCustomAttributes = "";

		// ImmuneDamage
		$this->ImmuneDamage->ViewValue = $this->ImmuneDamage->CurrentValue;
		$this->ImmuneDamage->ViewCustomAttributes = "";

		// Intro
		$this->Intro->ViewValue = $this->Intro->CurrentValue;
		$this->Intro->ViewCustomAttributes = "";

		// ExclusiveSkills
		$this->ExclusiveSkills->ViewValue = $this->ExclusiveSkills->CurrentValue;
		$this->ExclusiveSkills->ViewCustomAttributes = "";

		// TransferDemand
		$this->TransferDemand->ViewValue = $this->TransferDemand->CurrentValue;
		$this->TransferDemand->ViewCustomAttributes = "";

		// TransferLevel
		$this->TransferLevel->ViewValue = $this->TransferLevel->CurrentValue;
		$this->TransferLevel->ViewCustomAttributes = "";

		// FormerOccupation
		$this->FormerOccupation->ViewValue = $this->FormerOccupation->CurrentValue;
		$this->FormerOccupation->ViewCustomAttributes = "";

		// Belong
		$this->Belong->ViewValue = $this->Belong->CurrentValue;
		$this->Belong->ViewCustomAttributes = "";

		// AttackEffect
		$this->AttackEffect->ViewValue = $this->AttackEffect->CurrentValue;
		$this->AttackEffect->ViewCustomAttributes = "";

		// AttackTips
		$this->AttackTips->ViewValue = $this->AttackTips->CurrentValue;
		$this->AttackTips->ViewCustomAttributes = "";

		// MagicResistance
		$this->MagicResistance->ViewValue = $this->MagicResistance->CurrentValue;
		$this->MagicResistance->ViewCustomAttributes = "";

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

		// Name
		$this->Name->LinkCustomAttributes = "";
		$this->Name->HrefValue = "";
		$this->Name->TooltipValue = "";

		// Basics
		$this->Basics->LinkCustomAttributes = "";
		$this->Basics->HrefValue = "";
		$this->Basics->TooltipValue = "";

		// HP
		$this->HP->LinkCustomAttributes = "";
		$this->HP->HrefValue = "";
		$this->HP->TooltipValue = "";

		// MP
		$this->MP->LinkCustomAttributes = "";
		$this->MP->HrefValue = "";
		$this->MP->TooltipValue = "";

		// AD
		$this->AD->LinkCustomAttributes = "";
		$this->AD->HrefValue = "";
		$this->AD->TooltipValue = "";

		// AP
		$this->AP->LinkCustomAttributes = "";
		$this->AP->HrefValue = "";
		$this->AP->TooltipValue = "";

		// Defense
		$this->Defense->LinkCustomAttributes = "";
		$this->Defense->HrefValue = "";
		$this->Defense->TooltipValue = "";

		// Hit
		$this->Hit->LinkCustomAttributes = "";
		$this->Hit->HrefValue = "";
		$this->Hit->TooltipValue = "";

		// Dodge
		$this->Dodge->LinkCustomAttributes = "";
		$this->Dodge->HrefValue = "";
		$this->Dodge->TooltipValue = "";

		// Crit
		$this->Crit->LinkCustomAttributes = "";
		$this->Crit->HrefValue = "";
		$this->Crit->TooltipValue = "";

		// AbsorbHP
		$this->AbsorbHP->LinkCustomAttributes = "";
		$this->AbsorbHP->HrefValue = "";
		$this->AbsorbHP->TooltipValue = "";

		// ADPTV
		$this->ADPTV->LinkCustomAttributes = "";
		$this->ADPTV->HrefValue = "";
		$this->ADPTV->TooltipValue = "";

		// ADPTR
		$this->ADPTR->LinkCustomAttributes = "";
		$this->ADPTR->HrefValue = "";
		$this->ADPTR->TooltipValue = "";

		// APPTR
		$this->APPTR->LinkCustomAttributes = "";
		$this->APPTR->HrefValue = "";
		$this->APPTR->TooltipValue = "";

		// APPTV
		$this->APPTV->LinkCustomAttributes = "";
		$this->APPTV->HrefValue = "";
		$this->APPTV->TooltipValue = "";

		// ImmuneDamage
		$this->ImmuneDamage->LinkCustomAttributes = "";
		$this->ImmuneDamage->HrefValue = "";
		$this->ImmuneDamage->TooltipValue = "";

		// Intro
		$this->Intro->LinkCustomAttributes = "";
		$this->Intro->HrefValue = "";
		$this->Intro->TooltipValue = "";

		// ExclusiveSkills
		$this->ExclusiveSkills->LinkCustomAttributes = "";
		$this->ExclusiveSkills->HrefValue = "";
		$this->ExclusiveSkills->TooltipValue = "";

		// TransferDemand
		$this->TransferDemand->LinkCustomAttributes = "";
		$this->TransferDemand->HrefValue = "";
		$this->TransferDemand->TooltipValue = "";

		// TransferLevel
		$this->TransferLevel->LinkCustomAttributes = "";
		$this->TransferLevel->HrefValue = "";
		$this->TransferLevel->TooltipValue = "";

		// FormerOccupation
		$this->FormerOccupation->LinkCustomAttributes = "";
		$this->FormerOccupation->HrefValue = "";
		$this->FormerOccupation->TooltipValue = "";

		// Belong
		$this->Belong->LinkCustomAttributes = "";
		$this->Belong->HrefValue = "";
		$this->Belong->TooltipValue = "";

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

		// Name
		$this->Name->EditAttrs["class"] = "form-control";
		$this->Name->EditCustomAttributes = "";
		$this->Name->EditValue = $this->Name->CurrentValue;
		$this->Name->PlaceHolder = ew_RemoveHtml($this->Name->FldCaption());

		// Basics
		$this->Basics->EditAttrs["class"] = "form-control";
		$this->Basics->EditCustomAttributes = "";
		$this->Basics->EditValue = $this->Basics->CurrentValue;
		$this->Basics->PlaceHolder = ew_RemoveHtml($this->Basics->FldCaption());

		// HP
		$this->HP->EditAttrs["class"] = "form-control";
		$this->HP->EditCustomAttributes = "";
		$this->HP->EditValue = $this->HP->CurrentValue;
		$this->HP->PlaceHolder = ew_RemoveHtml($this->HP->FldCaption());

		// MP
		$this->MP->EditAttrs["class"] = "form-control";
		$this->MP->EditCustomAttributes = "";
		$this->MP->EditValue = $this->MP->CurrentValue;
		$this->MP->PlaceHolder = ew_RemoveHtml($this->MP->FldCaption());

		// AD
		$this->AD->EditAttrs["class"] = "form-control";
		$this->AD->EditCustomAttributes = "";
		$this->AD->EditValue = $this->AD->CurrentValue;
		$this->AD->PlaceHolder = ew_RemoveHtml($this->AD->FldCaption());

		// AP
		$this->AP->EditAttrs["class"] = "form-control";
		$this->AP->EditCustomAttributes = "";
		$this->AP->EditValue = $this->AP->CurrentValue;
		$this->AP->PlaceHolder = ew_RemoveHtml($this->AP->FldCaption());

		// Defense
		$this->Defense->EditAttrs["class"] = "form-control";
		$this->Defense->EditCustomAttributes = "";
		$this->Defense->EditValue = $this->Defense->CurrentValue;
		$this->Defense->PlaceHolder = ew_RemoveHtml($this->Defense->FldCaption());

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

		// Crit
		$this->Crit->EditAttrs["class"] = "form-control";
		$this->Crit->EditCustomAttributes = "";
		$this->Crit->EditValue = $this->Crit->CurrentValue;
		$this->Crit->PlaceHolder = ew_RemoveHtml($this->Crit->FldCaption());

		// AbsorbHP
		$this->AbsorbHP->EditAttrs["class"] = "form-control";
		$this->AbsorbHP->EditCustomAttributes = "";
		$this->AbsorbHP->EditValue = $this->AbsorbHP->CurrentValue;
		$this->AbsorbHP->PlaceHolder = ew_RemoveHtml($this->AbsorbHP->FldCaption());

		// ADPTV
		$this->ADPTV->EditAttrs["class"] = "form-control";
		$this->ADPTV->EditCustomAttributes = "";
		$this->ADPTV->EditValue = $this->ADPTV->CurrentValue;
		$this->ADPTV->PlaceHolder = ew_RemoveHtml($this->ADPTV->FldCaption());

		// ADPTR
		$this->ADPTR->EditAttrs["class"] = "form-control";
		$this->ADPTR->EditCustomAttributes = "";
		$this->ADPTR->EditValue = $this->ADPTR->CurrentValue;
		$this->ADPTR->PlaceHolder = ew_RemoveHtml($this->ADPTR->FldCaption());

		// APPTR
		$this->APPTR->EditAttrs["class"] = "form-control";
		$this->APPTR->EditCustomAttributes = "";
		$this->APPTR->EditValue = $this->APPTR->CurrentValue;
		$this->APPTR->PlaceHolder = ew_RemoveHtml($this->APPTR->FldCaption());

		// APPTV
		$this->APPTV->EditAttrs["class"] = "form-control";
		$this->APPTV->EditCustomAttributes = "";
		$this->APPTV->EditValue = $this->APPTV->CurrentValue;
		$this->APPTV->PlaceHolder = ew_RemoveHtml($this->APPTV->FldCaption());

		// ImmuneDamage
		$this->ImmuneDamage->EditAttrs["class"] = "form-control";
		$this->ImmuneDamage->EditCustomAttributes = "";
		$this->ImmuneDamage->EditValue = $this->ImmuneDamage->CurrentValue;
		$this->ImmuneDamage->PlaceHolder = ew_RemoveHtml($this->ImmuneDamage->FldCaption());

		// Intro
		$this->Intro->EditAttrs["class"] = "form-control";
		$this->Intro->EditCustomAttributes = "";
		$this->Intro->EditValue = $this->Intro->CurrentValue;
		$this->Intro->PlaceHolder = ew_RemoveHtml($this->Intro->FldCaption());

		// ExclusiveSkills
		$this->ExclusiveSkills->EditAttrs["class"] = "form-control";
		$this->ExclusiveSkills->EditCustomAttributes = "";
		$this->ExclusiveSkills->EditValue = $this->ExclusiveSkills->CurrentValue;
		$this->ExclusiveSkills->PlaceHolder = ew_RemoveHtml($this->ExclusiveSkills->FldCaption());

		// TransferDemand
		$this->TransferDemand->EditAttrs["class"] = "form-control";
		$this->TransferDemand->EditCustomAttributes = "";
		$this->TransferDemand->EditValue = $this->TransferDemand->CurrentValue;
		$this->TransferDemand->PlaceHolder = ew_RemoveHtml($this->TransferDemand->FldCaption());

		// TransferLevel
		$this->TransferLevel->EditAttrs["class"] = "form-control";
		$this->TransferLevel->EditCustomAttributes = "";
		$this->TransferLevel->EditValue = $this->TransferLevel->CurrentValue;
		$this->TransferLevel->PlaceHolder = ew_RemoveHtml($this->TransferLevel->FldCaption());

		// FormerOccupation
		$this->FormerOccupation->EditAttrs["class"] = "form-control";
		$this->FormerOccupation->EditCustomAttributes = "";
		$this->FormerOccupation->EditValue = $this->FormerOccupation->CurrentValue;
		$this->FormerOccupation->PlaceHolder = ew_RemoveHtml($this->FormerOccupation->FldCaption());

		// Belong
		$this->Belong->EditAttrs["class"] = "form-control";
		$this->Belong->EditCustomAttributes = "";
		$this->Belong->EditValue = $this->Belong->CurrentValue;
		$this->Belong->PlaceHolder = ew_RemoveHtml($this->Belong->FldCaption());

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
					if ($this->Name->Exportable) $Doc->ExportCaption($this->Name);
					if ($this->Basics->Exportable) $Doc->ExportCaption($this->Basics);
					if ($this->HP->Exportable) $Doc->ExportCaption($this->HP);
					if ($this->MP->Exportable) $Doc->ExportCaption($this->MP);
					if ($this->AD->Exportable) $Doc->ExportCaption($this->AD);
					if ($this->AP->Exportable) $Doc->ExportCaption($this->AP);
					if ($this->Defense->Exportable) $Doc->ExportCaption($this->Defense);
					if ($this->Hit->Exportable) $Doc->ExportCaption($this->Hit);
					if ($this->Dodge->Exportable) $Doc->ExportCaption($this->Dodge);
					if ($this->Crit->Exportable) $Doc->ExportCaption($this->Crit);
					if ($this->AbsorbHP->Exportable) $Doc->ExportCaption($this->AbsorbHP);
					if ($this->ADPTV->Exportable) $Doc->ExportCaption($this->ADPTV);
					if ($this->ADPTR->Exportable) $Doc->ExportCaption($this->ADPTR);
					if ($this->APPTR->Exportable) $Doc->ExportCaption($this->APPTR);
					if ($this->APPTV->Exportable) $Doc->ExportCaption($this->APPTV);
					if ($this->ImmuneDamage->Exportable) $Doc->ExportCaption($this->ImmuneDamage);
					if ($this->Intro->Exportable) $Doc->ExportCaption($this->Intro);
					if ($this->ExclusiveSkills->Exportable) $Doc->ExportCaption($this->ExclusiveSkills);
					if ($this->TransferDemand->Exportable) $Doc->ExportCaption($this->TransferDemand);
					if ($this->TransferLevel->Exportable) $Doc->ExportCaption($this->TransferLevel);
					if ($this->FormerOccupation->Exportable) $Doc->ExportCaption($this->FormerOccupation);
					if ($this->Belong->Exportable) $Doc->ExportCaption($this->Belong);
					if ($this->AttackEffect->Exportable) $Doc->ExportCaption($this->AttackEffect);
					if ($this->AttackTips->Exportable) $Doc->ExportCaption($this->AttackTips);
					if ($this->MagicResistance->Exportable) $Doc->ExportCaption($this->MagicResistance);
					if ($this->IgnoreShield->Exportable) $Doc->ExportCaption($this->IgnoreShield);
					if ($this->DATETIME->Exportable) $Doc->ExportCaption($this->DATETIME);
				} else {
					if ($this->unid->Exportable) $Doc->ExportCaption($this->unid);
					if ($this->u_id->Exportable) $Doc->ExportCaption($this->u_id);
					if ($this->acl_id->Exportable) $Doc->ExportCaption($this->acl_id);
					if ($this->DATETIME->Exportable) $Doc->ExportCaption($this->DATETIME);
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
						if ($this->Name->Exportable) $Doc->ExportField($this->Name);
						if ($this->Basics->Exportable) $Doc->ExportField($this->Basics);
						if ($this->HP->Exportable) $Doc->ExportField($this->HP);
						if ($this->MP->Exportable) $Doc->ExportField($this->MP);
						if ($this->AD->Exportable) $Doc->ExportField($this->AD);
						if ($this->AP->Exportable) $Doc->ExportField($this->AP);
						if ($this->Defense->Exportable) $Doc->ExportField($this->Defense);
						if ($this->Hit->Exportable) $Doc->ExportField($this->Hit);
						if ($this->Dodge->Exportable) $Doc->ExportField($this->Dodge);
						if ($this->Crit->Exportable) $Doc->ExportField($this->Crit);
						if ($this->AbsorbHP->Exportable) $Doc->ExportField($this->AbsorbHP);
						if ($this->ADPTV->Exportable) $Doc->ExportField($this->ADPTV);
						if ($this->ADPTR->Exportable) $Doc->ExportField($this->ADPTR);
						if ($this->APPTR->Exportable) $Doc->ExportField($this->APPTR);
						if ($this->APPTV->Exportable) $Doc->ExportField($this->APPTV);
						if ($this->ImmuneDamage->Exportable) $Doc->ExportField($this->ImmuneDamage);
						if ($this->Intro->Exportable) $Doc->ExportField($this->Intro);
						if ($this->ExclusiveSkills->Exportable) $Doc->ExportField($this->ExclusiveSkills);
						if ($this->TransferDemand->Exportable) $Doc->ExportField($this->TransferDemand);
						if ($this->TransferLevel->Exportable) $Doc->ExportField($this->TransferLevel);
						if ($this->FormerOccupation->Exportable) $Doc->ExportField($this->FormerOccupation);
						if ($this->Belong->Exportable) $Doc->ExportField($this->Belong);
						if ($this->AttackEffect->Exportable) $Doc->ExportField($this->AttackEffect);
						if ($this->AttackTips->Exportable) $Doc->ExportField($this->AttackTips);
						if ($this->MagicResistance->Exportable) $Doc->ExportField($this->MagicResistance);
						if ($this->IgnoreShield->Exportable) $Doc->ExportField($this->IgnoreShield);
						if ($this->DATETIME->Exportable) $Doc->ExportField($this->DATETIME);
					} else {
						if ($this->unid->Exportable) $Doc->ExportField($this->unid);
						if ($this->u_id->Exportable) $Doc->ExportField($this->u_id);
						if ($this->acl_id->Exportable) $Doc->ExportField($this->acl_id);
						if ($this->DATETIME->Exportable) $Doc->ExportField($this->DATETIME);
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
