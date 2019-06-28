<?php

// Global variable for table object
$equip_register = NULL;

//
// Table class for equip_register
//
class cequip_register extends cTable {
	var $unid;
	var $u_id;
	var $acl_id;
	var $User;
	var $SlotName;
	var $EquipName;
	var $Add_HP;
	var $Add_MP;
	var $Add_Defense;
	var $Add_Magic;
	var $Add_AD;
	var $Add_AP;
	var $Add_Hit;
	var $Add_Dodge;
	var $Add_Crit;
	var $Add_AbsorbHP;
	var $Add_ADPTV;
	var $Add_ADPTR;
	var $Add_APPTR;
	var $Add_APPTV;
	var $Add_ImmuneDamage;
	var $Special_Type;
	var $Special_Value;
	var $DATETIME;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'equip_register';
		$this->TableName = 'equip_register';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`equip_register`";
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
		$this->unid = new cField('equip_register', 'equip_register', 'x_unid', 'unid', '`unid`', '`unid`', 3, -1, FALSE, '`unid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->unid->Sortable = TRUE; // Allow sort
		$this->unid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unid'] = &$this->unid;

		// u_id
		$this->u_id = new cField('equip_register', 'equip_register', 'x_u_id', 'u_id', '`u_id`', '`u_id`', 3, -1, FALSE, '`u_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_id->Sortable = TRUE; // Allow sort
		$this->u_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_id'] = &$this->u_id;

		// acl_id
		$this->acl_id = new cField('equip_register', 'equip_register', 'x_acl_id', 'acl_id', '`acl_id`', '`acl_id`', 3, -1, FALSE, '`acl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acl_id->Sortable = TRUE; // Allow sort
		$this->acl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['acl_id'] = &$this->acl_id;

		// User
		$this->User = new cField('equip_register', 'equip_register', 'x_User', 'User', '`User`', '`User`', 201, -1, FALSE, '`User`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->User->Sortable = TRUE; // Allow sort
		$this->fields['User'] = &$this->User;

		// SlotName
		$this->SlotName = new cField('equip_register', 'equip_register', 'x_SlotName', 'SlotName', '`SlotName`', '`SlotName`', 201, -1, FALSE, '`SlotName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->SlotName->Sortable = TRUE; // Allow sort
		$this->fields['SlotName'] = &$this->SlotName;

		// EquipName
		$this->EquipName = new cField('equip_register', 'equip_register', 'x_EquipName', 'EquipName', '`EquipName`', '`EquipName`', 201, -1, FALSE, '`EquipName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->EquipName->Sortable = TRUE; // Allow sort
		$this->fields['EquipName'] = &$this->EquipName;

		// Add_HP
		$this->Add_HP = new cField('equip_register', 'equip_register', 'x_Add_HP', 'Add_HP', '`Add_HP`', '`Add_HP`', 201, -1, FALSE, '`Add_HP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_HP->Sortable = TRUE; // Allow sort
		$this->fields['Add_HP'] = &$this->Add_HP;

		// Add_MP
		$this->Add_MP = new cField('equip_register', 'equip_register', 'x_Add_MP', 'Add_MP', '`Add_MP`', '`Add_MP`', 201, -1, FALSE, '`Add_MP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_MP->Sortable = TRUE; // Allow sort
		$this->fields['Add_MP'] = &$this->Add_MP;

		// Add_Defense
		$this->Add_Defense = new cField('equip_register', 'equip_register', 'x_Add_Defense', 'Add_Defense', '`Add_Defense`', '`Add_Defense`', 201, -1, FALSE, '`Add_Defense`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_Defense->Sortable = TRUE; // Allow sort
		$this->fields['Add_Defense'] = &$this->Add_Defense;

		// Add_Magic
		$this->Add_Magic = new cField('equip_register', 'equip_register', 'x_Add_Magic', 'Add_Magic', '`Add_Magic`', '`Add_Magic`', 201, -1, FALSE, '`Add_Magic`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_Magic->Sortable = TRUE; // Allow sort
		$this->fields['Add_Magic'] = &$this->Add_Magic;

		// Add_AD
		$this->Add_AD = new cField('equip_register', 'equip_register', 'x_Add_AD', 'Add_AD', '`Add_AD`', '`Add_AD`', 201, -1, FALSE, '`Add_AD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_AD->Sortable = TRUE; // Allow sort
		$this->fields['Add_AD'] = &$this->Add_AD;

		// Add_AP
		$this->Add_AP = new cField('equip_register', 'equip_register', 'x_Add_AP', 'Add_AP', '`Add_AP`', '`Add_AP`', 201, -1, FALSE, '`Add_AP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_AP->Sortable = TRUE; // Allow sort
		$this->fields['Add_AP'] = &$this->Add_AP;

		// Add_Hit
		$this->Add_Hit = new cField('equip_register', 'equip_register', 'x_Add_Hit', 'Add_Hit', '`Add_Hit`', '`Add_Hit`', 201, -1, FALSE, '`Add_Hit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_Hit->Sortable = TRUE; // Allow sort
		$this->fields['Add_Hit'] = &$this->Add_Hit;

		// Add_Dodge
		$this->Add_Dodge = new cField('equip_register', 'equip_register', 'x_Add_Dodge', 'Add_Dodge', '`Add_Dodge`', '`Add_Dodge`', 201, -1, FALSE, '`Add_Dodge`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_Dodge->Sortable = TRUE; // Allow sort
		$this->fields['Add_Dodge'] = &$this->Add_Dodge;

		// Add_Crit
		$this->Add_Crit = new cField('equip_register', 'equip_register', 'x_Add_Crit', 'Add_Crit', '`Add_Crit`', '`Add_Crit`', 201, -1, FALSE, '`Add_Crit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_Crit->Sortable = TRUE; // Allow sort
		$this->fields['Add_Crit'] = &$this->Add_Crit;

		// Add_AbsorbHP
		$this->Add_AbsorbHP = new cField('equip_register', 'equip_register', 'x_Add_AbsorbHP', 'Add_AbsorbHP', '`Add_AbsorbHP`', '`Add_AbsorbHP`', 201, -1, FALSE, '`Add_AbsorbHP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_AbsorbHP->Sortable = TRUE; // Allow sort
		$this->fields['Add_AbsorbHP'] = &$this->Add_AbsorbHP;

		// Add_ADPTV
		$this->Add_ADPTV = new cField('equip_register', 'equip_register', 'x_Add_ADPTV', 'Add_ADPTV', '`Add_ADPTV`', '`Add_ADPTV`', 201, -1, FALSE, '`Add_ADPTV`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_ADPTV->Sortable = TRUE; // Allow sort
		$this->fields['Add_ADPTV'] = &$this->Add_ADPTV;

		// Add_ADPTR
		$this->Add_ADPTR = new cField('equip_register', 'equip_register', 'x_Add_ADPTR', 'Add_ADPTR', '`Add_ADPTR`', '`Add_ADPTR`', 201, -1, FALSE, '`Add_ADPTR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_ADPTR->Sortable = TRUE; // Allow sort
		$this->fields['Add_ADPTR'] = &$this->Add_ADPTR;

		// Add_APPTR
		$this->Add_APPTR = new cField('equip_register', 'equip_register', 'x_Add_APPTR', 'Add_APPTR', '`Add_APPTR`', '`Add_APPTR`', 201, -1, FALSE, '`Add_APPTR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_APPTR->Sortable = TRUE; // Allow sort
		$this->fields['Add_APPTR'] = &$this->Add_APPTR;

		// Add_APPTV
		$this->Add_APPTV = new cField('equip_register', 'equip_register', 'x_Add_APPTV', 'Add_APPTV', '`Add_APPTV`', '`Add_APPTV`', 201, -1, FALSE, '`Add_APPTV`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_APPTV->Sortable = TRUE; // Allow sort
		$this->fields['Add_APPTV'] = &$this->Add_APPTV;

		// Add_ImmuneDamage
		$this->Add_ImmuneDamage = new cField('equip_register', 'equip_register', 'x_Add_ImmuneDamage', 'Add_ImmuneDamage', '`Add_ImmuneDamage`', '`Add_ImmuneDamage`', 201, -1, FALSE, '`Add_ImmuneDamage`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Add_ImmuneDamage->Sortable = TRUE; // Allow sort
		$this->fields['Add_ImmuneDamage'] = &$this->Add_ImmuneDamage;

		// Special_Type
		$this->Special_Type = new cField('equip_register', 'equip_register', 'x_Special_Type', 'Special_Type', '`Special_Type`', '`Special_Type`', 201, -1, FALSE, '`Special_Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Special_Type->Sortable = TRUE; // Allow sort
		$this->fields['Special_Type'] = &$this->Special_Type;

		// Special_Value
		$this->Special_Value = new cField('equip_register', 'equip_register', 'x_Special_Value', 'Special_Value', '`Special_Value`', '`Special_Value`', 201, -1, FALSE, '`Special_Value`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Special_Value->Sortable = TRUE; // Allow sort
		$this->fields['Special_Value'] = &$this->Special_Value;

		// DATETIME
		$this->DATETIME = new cField('equip_register', 'equip_register', 'x_DATETIME', 'DATETIME', '`DATETIME`', ew_CastDateFieldForLike('`DATETIME`', 0, "DB"), 135, 0, FALSE, '`DATETIME`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`equip_register`";
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
			return "equip_registerlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "equip_registerview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "equip_registeredit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "equip_registeradd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "equip_registerlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("equip_registerview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("equip_registerview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "equip_registeradd.php?" . $this->UrlParm($parm);
		else
			$url = "equip_registeradd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("equip_registeredit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("equip_registeradd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("equip_registerdelete.php", $this->UrlParm());
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
		$this->User->setDbValue($rs->fields('User'));
		$this->SlotName->setDbValue($rs->fields('SlotName'));
		$this->EquipName->setDbValue($rs->fields('EquipName'));
		$this->Add_HP->setDbValue($rs->fields('Add_HP'));
		$this->Add_MP->setDbValue($rs->fields('Add_MP'));
		$this->Add_Defense->setDbValue($rs->fields('Add_Defense'));
		$this->Add_Magic->setDbValue($rs->fields('Add_Magic'));
		$this->Add_AD->setDbValue($rs->fields('Add_AD'));
		$this->Add_AP->setDbValue($rs->fields('Add_AP'));
		$this->Add_Hit->setDbValue($rs->fields('Add_Hit'));
		$this->Add_Dodge->setDbValue($rs->fields('Add_Dodge'));
		$this->Add_Crit->setDbValue($rs->fields('Add_Crit'));
		$this->Add_AbsorbHP->setDbValue($rs->fields('Add_AbsorbHP'));
		$this->Add_ADPTV->setDbValue($rs->fields('Add_ADPTV'));
		$this->Add_ADPTR->setDbValue($rs->fields('Add_ADPTR'));
		$this->Add_APPTR->setDbValue($rs->fields('Add_APPTR'));
		$this->Add_APPTV->setDbValue($rs->fields('Add_APPTV'));
		$this->Add_ImmuneDamage->setDbValue($rs->fields('Add_ImmuneDamage'));
		$this->Special_Type->setDbValue($rs->fields('Special_Type'));
		$this->Special_Value->setDbValue($rs->fields('Special_Value'));
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
		// User
		// SlotName
		// EquipName
		// Add_HP
		// Add_MP
		// Add_Defense
		// Add_Magic
		// Add_AD
		// Add_AP
		// Add_Hit
		// Add_Dodge
		// Add_Crit
		// Add_AbsorbHP
		// Add_ADPTV
		// Add_ADPTR
		// Add_APPTR
		// Add_APPTV
		// Add_ImmuneDamage
		// Special_Type
		// Special_Value
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

		// User
		$this->User->ViewValue = $this->User->CurrentValue;
		$this->User->ViewCustomAttributes = "";

		// SlotName
		$this->SlotName->ViewValue = $this->SlotName->CurrentValue;
		$this->SlotName->ViewCustomAttributes = "";

		// EquipName
		$this->EquipName->ViewValue = $this->EquipName->CurrentValue;
		$this->EquipName->ViewCustomAttributes = "";

		// Add_HP
		$this->Add_HP->ViewValue = $this->Add_HP->CurrentValue;
		$this->Add_HP->ViewCustomAttributes = "";

		// Add_MP
		$this->Add_MP->ViewValue = $this->Add_MP->CurrentValue;
		$this->Add_MP->ViewCustomAttributes = "";

		// Add_Defense
		$this->Add_Defense->ViewValue = $this->Add_Defense->CurrentValue;
		$this->Add_Defense->ViewCustomAttributes = "";

		// Add_Magic
		$this->Add_Magic->ViewValue = $this->Add_Magic->CurrentValue;
		$this->Add_Magic->ViewCustomAttributes = "";

		// Add_AD
		$this->Add_AD->ViewValue = $this->Add_AD->CurrentValue;
		$this->Add_AD->ViewCustomAttributes = "";

		// Add_AP
		$this->Add_AP->ViewValue = $this->Add_AP->CurrentValue;
		$this->Add_AP->ViewCustomAttributes = "";

		// Add_Hit
		$this->Add_Hit->ViewValue = $this->Add_Hit->CurrentValue;
		$this->Add_Hit->ViewCustomAttributes = "";

		// Add_Dodge
		$this->Add_Dodge->ViewValue = $this->Add_Dodge->CurrentValue;
		$this->Add_Dodge->ViewCustomAttributes = "";

		// Add_Crit
		$this->Add_Crit->ViewValue = $this->Add_Crit->CurrentValue;
		$this->Add_Crit->ViewCustomAttributes = "";

		// Add_AbsorbHP
		$this->Add_AbsorbHP->ViewValue = $this->Add_AbsorbHP->CurrentValue;
		$this->Add_AbsorbHP->ViewCustomAttributes = "";

		// Add_ADPTV
		$this->Add_ADPTV->ViewValue = $this->Add_ADPTV->CurrentValue;
		$this->Add_ADPTV->ViewCustomAttributes = "";

		// Add_ADPTR
		$this->Add_ADPTR->ViewValue = $this->Add_ADPTR->CurrentValue;
		$this->Add_ADPTR->ViewCustomAttributes = "";

		// Add_APPTR
		$this->Add_APPTR->ViewValue = $this->Add_APPTR->CurrentValue;
		$this->Add_APPTR->ViewCustomAttributes = "";

		// Add_APPTV
		$this->Add_APPTV->ViewValue = $this->Add_APPTV->CurrentValue;
		$this->Add_APPTV->ViewCustomAttributes = "";

		// Add_ImmuneDamage
		$this->Add_ImmuneDamage->ViewValue = $this->Add_ImmuneDamage->CurrentValue;
		$this->Add_ImmuneDamage->ViewCustomAttributes = "";

		// Special_Type
		$this->Special_Type->ViewValue = $this->Special_Type->CurrentValue;
		$this->Special_Type->ViewCustomAttributes = "";

		// Special_Value
		$this->Special_Value->ViewValue = $this->Special_Value->CurrentValue;
		$this->Special_Value->ViewCustomAttributes = "";

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

		// User
		$this->User->LinkCustomAttributes = "";
		$this->User->HrefValue = "";
		$this->User->TooltipValue = "";

		// SlotName
		$this->SlotName->LinkCustomAttributes = "";
		$this->SlotName->HrefValue = "";
		$this->SlotName->TooltipValue = "";

		// EquipName
		$this->EquipName->LinkCustomAttributes = "";
		$this->EquipName->HrefValue = "";
		$this->EquipName->TooltipValue = "";

		// Add_HP
		$this->Add_HP->LinkCustomAttributes = "";
		$this->Add_HP->HrefValue = "";
		$this->Add_HP->TooltipValue = "";

		// Add_MP
		$this->Add_MP->LinkCustomAttributes = "";
		$this->Add_MP->HrefValue = "";
		$this->Add_MP->TooltipValue = "";

		// Add_Defense
		$this->Add_Defense->LinkCustomAttributes = "";
		$this->Add_Defense->HrefValue = "";
		$this->Add_Defense->TooltipValue = "";

		// Add_Magic
		$this->Add_Magic->LinkCustomAttributes = "";
		$this->Add_Magic->HrefValue = "";
		$this->Add_Magic->TooltipValue = "";

		// Add_AD
		$this->Add_AD->LinkCustomAttributes = "";
		$this->Add_AD->HrefValue = "";
		$this->Add_AD->TooltipValue = "";

		// Add_AP
		$this->Add_AP->LinkCustomAttributes = "";
		$this->Add_AP->HrefValue = "";
		$this->Add_AP->TooltipValue = "";

		// Add_Hit
		$this->Add_Hit->LinkCustomAttributes = "";
		$this->Add_Hit->HrefValue = "";
		$this->Add_Hit->TooltipValue = "";

		// Add_Dodge
		$this->Add_Dodge->LinkCustomAttributes = "";
		$this->Add_Dodge->HrefValue = "";
		$this->Add_Dodge->TooltipValue = "";

		// Add_Crit
		$this->Add_Crit->LinkCustomAttributes = "";
		$this->Add_Crit->HrefValue = "";
		$this->Add_Crit->TooltipValue = "";

		// Add_AbsorbHP
		$this->Add_AbsorbHP->LinkCustomAttributes = "";
		$this->Add_AbsorbHP->HrefValue = "";
		$this->Add_AbsorbHP->TooltipValue = "";

		// Add_ADPTV
		$this->Add_ADPTV->LinkCustomAttributes = "";
		$this->Add_ADPTV->HrefValue = "";
		$this->Add_ADPTV->TooltipValue = "";

		// Add_ADPTR
		$this->Add_ADPTR->LinkCustomAttributes = "";
		$this->Add_ADPTR->HrefValue = "";
		$this->Add_ADPTR->TooltipValue = "";

		// Add_APPTR
		$this->Add_APPTR->LinkCustomAttributes = "";
		$this->Add_APPTR->HrefValue = "";
		$this->Add_APPTR->TooltipValue = "";

		// Add_APPTV
		$this->Add_APPTV->LinkCustomAttributes = "";
		$this->Add_APPTV->HrefValue = "";
		$this->Add_APPTV->TooltipValue = "";

		// Add_ImmuneDamage
		$this->Add_ImmuneDamage->LinkCustomAttributes = "";
		$this->Add_ImmuneDamage->HrefValue = "";
		$this->Add_ImmuneDamage->TooltipValue = "";

		// Special_Type
		$this->Special_Type->LinkCustomAttributes = "";
		$this->Special_Type->HrefValue = "";
		$this->Special_Type->TooltipValue = "";

		// Special_Value
		$this->Special_Value->LinkCustomAttributes = "";
		$this->Special_Value->HrefValue = "";
		$this->Special_Value->TooltipValue = "";

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

		// User
		$this->User->EditAttrs["class"] = "form-control";
		$this->User->EditCustomAttributes = "";
		$this->User->EditValue = $this->User->CurrentValue;
		$this->User->PlaceHolder = ew_RemoveHtml($this->User->FldCaption());

		// SlotName
		$this->SlotName->EditAttrs["class"] = "form-control";
		$this->SlotName->EditCustomAttributes = "";
		$this->SlotName->EditValue = $this->SlotName->CurrentValue;
		$this->SlotName->PlaceHolder = ew_RemoveHtml($this->SlotName->FldCaption());

		// EquipName
		$this->EquipName->EditAttrs["class"] = "form-control";
		$this->EquipName->EditCustomAttributes = "";
		$this->EquipName->EditValue = $this->EquipName->CurrentValue;
		$this->EquipName->PlaceHolder = ew_RemoveHtml($this->EquipName->FldCaption());

		// Add_HP
		$this->Add_HP->EditAttrs["class"] = "form-control";
		$this->Add_HP->EditCustomAttributes = "";
		$this->Add_HP->EditValue = $this->Add_HP->CurrentValue;
		$this->Add_HP->PlaceHolder = ew_RemoveHtml($this->Add_HP->FldCaption());

		// Add_MP
		$this->Add_MP->EditAttrs["class"] = "form-control";
		$this->Add_MP->EditCustomAttributes = "";
		$this->Add_MP->EditValue = $this->Add_MP->CurrentValue;
		$this->Add_MP->PlaceHolder = ew_RemoveHtml($this->Add_MP->FldCaption());

		// Add_Defense
		$this->Add_Defense->EditAttrs["class"] = "form-control";
		$this->Add_Defense->EditCustomAttributes = "";
		$this->Add_Defense->EditValue = $this->Add_Defense->CurrentValue;
		$this->Add_Defense->PlaceHolder = ew_RemoveHtml($this->Add_Defense->FldCaption());

		// Add_Magic
		$this->Add_Magic->EditAttrs["class"] = "form-control";
		$this->Add_Magic->EditCustomAttributes = "";
		$this->Add_Magic->EditValue = $this->Add_Magic->CurrentValue;
		$this->Add_Magic->PlaceHolder = ew_RemoveHtml($this->Add_Magic->FldCaption());

		// Add_AD
		$this->Add_AD->EditAttrs["class"] = "form-control";
		$this->Add_AD->EditCustomAttributes = "";
		$this->Add_AD->EditValue = $this->Add_AD->CurrentValue;
		$this->Add_AD->PlaceHolder = ew_RemoveHtml($this->Add_AD->FldCaption());

		// Add_AP
		$this->Add_AP->EditAttrs["class"] = "form-control";
		$this->Add_AP->EditCustomAttributes = "";
		$this->Add_AP->EditValue = $this->Add_AP->CurrentValue;
		$this->Add_AP->PlaceHolder = ew_RemoveHtml($this->Add_AP->FldCaption());

		// Add_Hit
		$this->Add_Hit->EditAttrs["class"] = "form-control";
		$this->Add_Hit->EditCustomAttributes = "";
		$this->Add_Hit->EditValue = $this->Add_Hit->CurrentValue;
		$this->Add_Hit->PlaceHolder = ew_RemoveHtml($this->Add_Hit->FldCaption());

		// Add_Dodge
		$this->Add_Dodge->EditAttrs["class"] = "form-control";
		$this->Add_Dodge->EditCustomAttributes = "";
		$this->Add_Dodge->EditValue = $this->Add_Dodge->CurrentValue;
		$this->Add_Dodge->PlaceHolder = ew_RemoveHtml($this->Add_Dodge->FldCaption());

		// Add_Crit
		$this->Add_Crit->EditAttrs["class"] = "form-control";
		$this->Add_Crit->EditCustomAttributes = "";
		$this->Add_Crit->EditValue = $this->Add_Crit->CurrentValue;
		$this->Add_Crit->PlaceHolder = ew_RemoveHtml($this->Add_Crit->FldCaption());

		// Add_AbsorbHP
		$this->Add_AbsorbHP->EditAttrs["class"] = "form-control";
		$this->Add_AbsorbHP->EditCustomAttributes = "";
		$this->Add_AbsorbHP->EditValue = $this->Add_AbsorbHP->CurrentValue;
		$this->Add_AbsorbHP->PlaceHolder = ew_RemoveHtml($this->Add_AbsorbHP->FldCaption());

		// Add_ADPTV
		$this->Add_ADPTV->EditAttrs["class"] = "form-control";
		$this->Add_ADPTV->EditCustomAttributes = "";
		$this->Add_ADPTV->EditValue = $this->Add_ADPTV->CurrentValue;
		$this->Add_ADPTV->PlaceHolder = ew_RemoveHtml($this->Add_ADPTV->FldCaption());

		// Add_ADPTR
		$this->Add_ADPTR->EditAttrs["class"] = "form-control";
		$this->Add_ADPTR->EditCustomAttributes = "";
		$this->Add_ADPTR->EditValue = $this->Add_ADPTR->CurrentValue;
		$this->Add_ADPTR->PlaceHolder = ew_RemoveHtml($this->Add_ADPTR->FldCaption());

		// Add_APPTR
		$this->Add_APPTR->EditAttrs["class"] = "form-control";
		$this->Add_APPTR->EditCustomAttributes = "";
		$this->Add_APPTR->EditValue = $this->Add_APPTR->CurrentValue;
		$this->Add_APPTR->PlaceHolder = ew_RemoveHtml($this->Add_APPTR->FldCaption());

		// Add_APPTV
		$this->Add_APPTV->EditAttrs["class"] = "form-control";
		$this->Add_APPTV->EditCustomAttributes = "";
		$this->Add_APPTV->EditValue = $this->Add_APPTV->CurrentValue;
		$this->Add_APPTV->PlaceHolder = ew_RemoveHtml($this->Add_APPTV->FldCaption());

		// Add_ImmuneDamage
		$this->Add_ImmuneDamage->EditAttrs["class"] = "form-control";
		$this->Add_ImmuneDamage->EditCustomAttributes = "";
		$this->Add_ImmuneDamage->EditValue = $this->Add_ImmuneDamage->CurrentValue;
		$this->Add_ImmuneDamage->PlaceHolder = ew_RemoveHtml($this->Add_ImmuneDamage->FldCaption());

		// Special_Type
		$this->Special_Type->EditAttrs["class"] = "form-control";
		$this->Special_Type->EditCustomAttributes = "";
		$this->Special_Type->EditValue = $this->Special_Type->CurrentValue;
		$this->Special_Type->PlaceHolder = ew_RemoveHtml($this->Special_Type->FldCaption());

		// Special_Value
		$this->Special_Value->EditAttrs["class"] = "form-control";
		$this->Special_Value->EditCustomAttributes = "";
		$this->Special_Value->EditValue = $this->Special_Value->CurrentValue;
		$this->Special_Value->PlaceHolder = ew_RemoveHtml($this->Special_Value->FldCaption());

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
					if ($this->User->Exportable) $Doc->ExportCaption($this->User);
					if ($this->SlotName->Exportable) $Doc->ExportCaption($this->SlotName);
					if ($this->EquipName->Exportable) $Doc->ExportCaption($this->EquipName);
					if ($this->Add_HP->Exportable) $Doc->ExportCaption($this->Add_HP);
					if ($this->Add_MP->Exportable) $Doc->ExportCaption($this->Add_MP);
					if ($this->Add_Defense->Exportable) $Doc->ExportCaption($this->Add_Defense);
					if ($this->Add_Magic->Exportable) $Doc->ExportCaption($this->Add_Magic);
					if ($this->Add_AD->Exportable) $Doc->ExportCaption($this->Add_AD);
					if ($this->Add_AP->Exportable) $Doc->ExportCaption($this->Add_AP);
					if ($this->Add_Hit->Exportable) $Doc->ExportCaption($this->Add_Hit);
					if ($this->Add_Dodge->Exportable) $Doc->ExportCaption($this->Add_Dodge);
					if ($this->Add_Crit->Exportable) $Doc->ExportCaption($this->Add_Crit);
					if ($this->Add_AbsorbHP->Exportable) $Doc->ExportCaption($this->Add_AbsorbHP);
					if ($this->Add_ADPTV->Exportable) $Doc->ExportCaption($this->Add_ADPTV);
					if ($this->Add_ADPTR->Exportable) $Doc->ExportCaption($this->Add_ADPTR);
					if ($this->Add_APPTR->Exportable) $Doc->ExportCaption($this->Add_APPTR);
					if ($this->Add_APPTV->Exportable) $Doc->ExportCaption($this->Add_APPTV);
					if ($this->Add_ImmuneDamage->Exportable) $Doc->ExportCaption($this->Add_ImmuneDamage);
					if ($this->Special_Type->Exportable) $Doc->ExportCaption($this->Special_Type);
					if ($this->Special_Value->Exportable) $Doc->ExportCaption($this->Special_Value);
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
						if ($this->User->Exportable) $Doc->ExportField($this->User);
						if ($this->SlotName->Exportable) $Doc->ExportField($this->SlotName);
						if ($this->EquipName->Exportable) $Doc->ExportField($this->EquipName);
						if ($this->Add_HP->Exportable) $Doc->ExportField($this->Add_HP);
						if ($this->Add_MP->Exportable) $Doc->ExportField($this->Add_MP);
						if ($this->Add_Defense->Exportable) $Doc->ExportField($this->Add_Defense);
						if ($this->Add_Magic->Exportable) $Doc->ExportField($this->Add_Magic);
						if ($this->Add_AD->Exportable) $Doc->ExportField($this->Add_AD);
						if ($this->Add_AP->Exportable) $Doc->ExportField($this->Add_AP);
						if ($this->Add_Hit->Exportable) $Doc->ExportField($this->Add_Hit);
						if ($this->Add_Dodge->Exportable) $Doc->ExportField($this->Add_Dodge);
						if ($this->Add_Crit->Exportable) $Doc->ExportField($this->Add_Crit);
						if ($this->Add_AbsorbHP->Exportable) $Doc->ExportField($this->Add_AbsorbHP);
						if ($this->Add_ADPTV->Exportable) $Doc->ExportField($this->Add_ADPTV);
						if ($this->Add_ADPTR->Exportable) $Doc->ExportField($this->Add_ADPTR);
						if ($this->Add_APPTR->Exportable) $Doc->ExportField($this->Add_APPTR);
						if ($this->Add_APPTV->Exportable) $Doc->ExportField($this->Add_APPTV);
						if ($this->Add_ImmuneDamage->Exportable) $Doc->ExportField($this->Add_ImmuneDamage);
						if ($this->Special_Type->Exportable) $Doc->ExportField($this->Special_Type);
						if ($this->Special_Value->Exportable) $Doc->ExportField($this->Special_Value);
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
