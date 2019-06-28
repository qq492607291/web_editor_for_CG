<?php

// Global variable for table object
$config_skills = NULL;

//
// Table class for config_skills
//
class cconfig_skills extends cTable {
	var $unid;
	var $u_id;
	var $acl_id;
	var $Name;
	var $Type;
	var $Consume;
	var $Effect;
	var $EO;
	var $LV;
	var $ConsumeType;
	var $Cooling;
	var $Accurate;
	var $AttackTips;
	var $Introduce;
	var $ACS;
	var $Shield;
	var $IgnoreShield;
	var $IgnoreIM;
	var $IgnoreRE;
	var $BanAbsorb;
	var $BanMultipleShot;
	var $ProhibitUO;
	var $ConsumableGoods;
	var $Continued_Round;
	var $Continued_Type;
	var $Continued_Effect;
	var $DATETIME;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'config_skills';
		$this->TableName = 'config_skills';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`config_skills`";
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
		$this->unid = new cField('config_skills', 'config_skills', 'x_unid', 'unid', '`unid`', '`unid`', 3, -1, FALSE, '`unid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->unid->Sortable = TRUE; // Allow sort
		$this->unid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unid'] = &$this->unid;

		// u_id
		$this->u_id = new cField('config_skills', 'config_skills', 'x_u_id', 'u_id', '`u_id`', '`u_id`', 3, -1, FALSE, '`u_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_id->Sortable = TRUE; // Allow sort
		$this->u_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_id'] = &$this->u_id;

		// acl_id
		$this->acl_id = new cField('config_skills', 'config_skills', 'x_acl_id', 'acl_id', '`acl_id`', '`acl_id`', 3, -1, FALSE, '`acl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acl_id->Sortable = TRUE; // Allow sort
		$this->acl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['acl_id'] = &$this->acl_id;

		// Name
		$this->Name = new cField('config_skills', 'config_skills', 'x_Name', 'Name', '`Name`', '`Name`', 201, -1, FALSE, '`Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Name->Sortable = TRUE; // Allow sort
		$this->fields['Name'] = &$this->Name;

		// Type
		$this->Type = new cField('config_skills', 'config_skills', 'x_Type', 'Type', '`Type`', '`Type`', 201, -1, FALSE, '`Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Type->Sortable = TRUE; // Allow sort
		$this->fields['Type'] = &$this->Type;

		// Consume
		$this->Consume = new cField('config_skills', 'config_skills', 'x_Consume', 'Consume', '`Consume`', '`Consume`', 201, -1, FALSE, '`Consume`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Consume->Sortable = TRUE; // Allow sort
		$this->fields['Consume'] = &$this->Consume;

		// Effect
		$this->Effect = new cField('config_skills', 'config_skills', 'x_Effect', 'Effect', '`Effect`', '`Effect`', 201, -1, FALSE, '`Effect`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Effect->Sortable = TRUE; // Allow sort
		$this->fields['Effect'] = &$this->Effect;

		// EO
		$this->EO = new cField('config_skills', 'config_skills', 'x_EO', 'EO', '`EO`', '`EO`', 201, -1, FALSE, '`EO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->EO->Sortable = TRUE; // Allow sort
		$this->fields['EO'] = &$this->EO;

		// LV
		$this->LV = new cField('config_skills', 'config_skills', 'x_LV', 'LV', '`LV`', '`LV`', 201, -1, FALSE, '`LV`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->LV->Sortable = TRUE; // Allow sort
		$this->fields['LV'] = &$this->LV;

		// ConsumeType
		$this->ConsumeType = new cField('config_skills', 'config_skills', 'x_ConsumeType', 'ConsumeType', '`ConsumeType`', '`ConsumeType`', 201, -1, FALSE, '`ConsumeType`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->ConsumeType->Sortable = TRUE; // Allow sort
		$this->fields['ConsumeType'] = &$this->ConsumeType;

		// Cooling
		$this->Cooling = new cField('config_skills', 'config_skills', 'x_Cooling', 'Cooling', '`Cooling`', '`Cooling`', 201, -1, FALSE, '`Cooling`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Cooling->Sortable = TRUE; // Allow sort
		$this->fields['Cooling'] = &$this->Cooling;

		// Accurate
		$this->Accurate = new cField('config_skills', 'config_skills', 'x_Accurate', 'Accurate', '`Accurate`', '`Accurate`', 201, -1, FALSE, '`Accurate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Accurate->Sortable = TRUE; // Allow sort
		$this->fields['Accurate'] = &$this->Accurate;

		// AttackTips
		$this->AttackTips = new cField('config_skills', 'config_skills', 'x_AttackTips', 'AttackTips', '`AttackTips`', '`AttackTips`', 201, -1, FALSE, '`AttackTips`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->AttackTips->Sortable = TRUE; // Allow sort
		$this->fields['AttackTips'] = &$this->AttackTips;

		// Introduce
		$this->Introduce = new cField('config_skills', 'config_skills', 'x_Introduce', 'Introduce', '`Introduce`', '`Introduce`', 201, -1, FALSE, '`Introduce`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Introduce->Sortable = TRUE; // Allow sort
		$this->fields['Introduce'] = &$this->Introduce;

		// ACS
		$this->ACS = new cField('config_skills', 'config_skills', 'x_ACS', 'ACS', '`ACS`', '`ACS`', 201, -1, FALSE, '`ACS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->ACS->Sortable = TRUE; // Allow sort
		$this->fields['ACS'] = &$this->ACS;

		// Shield
		$this->Shield = new cField('config_skills', 'config_skills', 'x_Shield', 'Shield', '`Shield`', '`Shield`', 201, -1, FALSE, '`Shield`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Shield->Sortable = TRUE; // Allow sort
		$this->fields['Shield'] = &$this->Shield;

		// IgnoreShield
		$this->IgnoreShield = new cField('config_skills', 'config_skills', 'x_IgnoreShield', 'IgnoreShield', '`IgnoreShield`', '`IgnoreShield`', 201, -1, FALSE, '`IgnoreShield`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->IgnoreShield->Sortable = TRUE; // Allow sort
		$this->fields['IgnoreShield'] = &$this->IgnoreShield;

		// IgnoreIM
		$this->IgnoreIM = new cField('config_skills', 'config_skills', 'x_IgnoreIM', 'IgnoreIM', '`IgnoreIM`', '`IgnoreIM`', 201, -1, FALSE, '`IgnoreIM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->IgnoreIM->Sortable = TRUE; // Allow sort
		$this->fields['IgnoreIM'] = &$this->IgnoreIM;

		// IgnoreRE
		$this->IgnoreRE = new cField('config_skills', 'config_skills', 'x_IgnoreRE', 'IgnoreRE', '`IgnoreRE`', '`IgnoreRE`', 201, -1, FALSE, '`IgnoreRE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->IgnoreRE->Sortable = TRUE; // Allow sort
		$this->fields['IgnoreRE'] = &$this->IgnoreRE;

		// BanAbsorb
		$this->BanAbsorb = new cField('config_skills', 'config_skills', 'x_BanAbsorb', 'BanAbsorb', '`BanAbsorb`', '`BanAbsorb`', 201, -1, FALSE, '`BanAbsorb`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->BanAbsorb->Sortable = TRUE; // Allow sort
		$this->fields['BanAbsorb'] = &$this->BanAbsorb;

		// BanMultipleShot
		$this->BanMultipleShot = new cField('config_skills', 'config_skills', 'x_BanMultipleShot', 'BanMultipleShot', '`BanMultipleShot`', '`BanMultipleShot`', 201, -1, FALSE, '`BanMultipleShot`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->BanMultipleShot->Sortable = TRUE; // Allow sort
		$this->fields['BanMultipleShot'] = &$this->BanMultipleShot;

		// ProhibitUO
		$this->ProhibitUO = new cField('config_skills', 'config_skills', 'x_ProhibitUO', 'ProhibitUO', '`ProhibitUO`', '`ProhibitUO`', 201, -1, FALSE, '`ProhibitUO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->ProhibitUO->Sortable = TRUE; // Allow sort
		$this->fields['ProhibitUO'] = &$this->ProhibitUO;

		// ConsumableGoods
		$this->ConsumableGoods = new cField('config_skills', 'config_skills', 'x_ConsumableGoods', 'ConsumableGoods', '`ConsumableGoods`', '`ConsumableGoods`', 201, -1, FALSE, '`ConsumableGoods`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->ConsumableGoods->Sortable = TRUE; // Allow sort
		$this->fields['ConsumableGoods'] = &$this->ConsumableGoods;

		// Continued_Round
		$this->Continued_Round = new cField('config_skills', 'config_skills', 'x_Continued_Round', 'Continued_Round', '`Continued_Round`', '`Continued_Round`', 201, -1, FALSE, '`Continued_Round`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Continued_Round->Sortable = TRUE; // Allow sort
		$this->fields['Continued_Round'] = &$this->Continued_Round;

		// Continued_Type
		$this->Continued_Type = new cField('config_skills', 'config_skills', 'x_Continued_Type', 'Continued_Type', '`Continued_Type`', '`Continued_Type`', 201, -1, FALSE, '`Continued_Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Continued_Type->Sortable = TRUE; // Allow sort
		$this->fields['Continued_Type'] = &$this->Continued_Type;

		// Continued_Effect
		$this->Continued_Effect = new cField('config_skills', 'config_skills', 'x_Continued_Effect', 'Continued_Effect', '`Continued_Effect`', '`Continued_Effect`', 201, -1, FALSE, '`Continued_Effect`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Continued_Effect->Sortable = TRUE; // Allow sort
		$this->fields['Continued_Effect'] = &$this->Continued_Effect;

		// DATETIME
		$this->DATETIME = new cField('config_skills', 'config_skills', 'x_DATETIME', 'DATETIME', '`DATETIME`', ew_CastDateFieldForLike('`DATETIME`', 0, "DB"), 135, 0, FALSE, '`DATETIME`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`config_skills`";
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
			return "config_skillslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "config_skillsview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "config_skillsedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "config_skillsadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "config_skillslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("config_skillsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("config_skillsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "config_skillsadd.php?" . $this->UrlParm($parm);
		else
			$url = "config_skillsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("config_skillsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("config_skillsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("config_skillsdelete.php", $this->UrlParm());
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
		$this->Type->setDbValue($rs->fields('Type'));
		$this->Consume->setDbValue($rs->fields('Consume'));
		$this->Effect->setDbValue($rs->fields('Effect'));
		$this->EO->setDbValue($rs->fields('EO'));
		$this->LV->setDbValue($rs->fields('LV'));
		$this->ConsumeType->setDbValue($rs->fields('ConsumeType'));
		$this->Cooling->setDbValue($rs->fields('Cooling'));
		$this->Accurate->setDbValue($rs->fields('Accurate'));
		$this->AttackTips->setDbValue($rs->fields('AttackTips'));
		$this->Introduce->setDbValue($rs->fields('Introduce'));
		$this->ACS->setDbValue($rs->fields('ACS'));
		$this->Shield->setDbValue($rs->fields('Shield'));
		$this->IgnoreShield->setDbValue($rs->fields('IgnoreShield'));
		$this->IgnoreIM->setDbValue($rs->fields('IgnoreIM'));
		$this->IgnoreRE->setDbValue($rs->fields('IgnoreRE'));
		$this->BanAbsorb->setDbValue($rs->fields('BanAbsorb'));
		$this->BanMultipleShot->setDbValue($rs->fields('BanMultipleShot'));
		$this->ProhibitUO->setDbValue($rs->fields('ProhibitUO'));
		$this->ConsumableGoods->setDbValue($rs->fields('ConsumableGoods'));
		$this->Continued_Round->setDbValue($rs->fields('Continued_Round'));
		$this->Continued_Type->setDbValue($rs->fields('Continued_Type'));
		$this->Continued_Effect->setDbValue($rs->fields('Continued_Effect'));
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
		// Type
		// Consume
		// Effect
		// EO
		// LV
		// ConsumeType
		// Cooling
		// Accurate
		// AttackTips
		// Introduce
		// ACS
		// Shield
		// IgnoreShield
		// IgnoreIM
		// IgnoreRE
		// BanAbsorb
		// BanMultipleShot
		// ProhibitUO
		// ConsumableGoods
		// Continued_Round
		// Continued_Type
		// Continued_Effect
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

		// Type
		$this->Type->ViewValue = $this->Type->CurrentValue;
		$this->Type->ViewCustomAttributes = "";

		// Consume
		$this->Consume->ViewValue = $this->Consume->CurrentValue;
		$this->Consume->ViewCustomAttributes = "";

		// Effect
		$this->Effect->ViewValue = $this->Effect->CurrentValue;
		$this->Effect->ViewCustomAttributes = "";

		// EO
		$this->EO->ViewValue = $this->EO->CurrentValue;
		$this->EO->ViewCustomAttributes = "";

		// LV
		$this->LV->ViewValue = $this->LV->CurrentValue;
		$this->LV->ViewCustomAttributes = "";

		// ConsumeType
		$this->ConsumeType->ViewValue = $this->ConsumeType->CurrentValue;
		$this->ConsumeType->ViewCustomAttributes = "";

		// Cooling
		$this->Cooling->ViewValue = $this->Cooling->CurrentValue;
		$this->Cooling->ViewCustomAttributes = "";

		// Accurate
		$this->Accurate->ViewValue = $this->Accurate->CurrentValue;
		$this->Accurate->ViewCustomAttributes = "";

		// AttackTips
		$this->AttackTips->ViewValue = $this->AttackTips->CurrentValue;
		$this->AttackTips->ViewCustomAttributes = "";

		// Introduce
		$this->Introduce->ViewValue = $this->Introduce->CurrentValue;
		$this->Introduce->ViewCustomAttributes = "";

		// ACS
		$this->ACS->ViewValue = $this->ACS->CurrentValue;
		$this->ACS->ViewCustomAttributes = "";

		// Shield
		$this->Shield->ViewValue = $this->Shield->CurrentValue;
		$this->Shield->ViewCustomAttributes = "";

		// IgnoreShield
		$this->IgnoreShield->ViewValue = $this->IgnoreShield->CurrentValue;
		$this->IgnoreShield->ViewCustomAttributes = "";

		// IgnoreIM
		$this->IgnoreIM->ViewValue = $this->IgnoreIM->CurrentValue;
		$this->IgnoreIM->ViewCustomAttributes = "";

		// IgnoreRE
		$this->IgnoreRE->ViewValue = $this->IgnoreRE->CurrentValue;
		$this->IgnoreRE->ViewCustomAttributes = "";

		// BanAbsorb
		$this->BanAbsorb->ViewValue = $this->BanAbsorb->CurrentValue;
		$this->BanAbsorb->ViewCustomAttributes = "";

		// BanMultipleShot
		$this->BanMultipleShot->ViewValue = $this->BanMultipleShot->CurrentValue;
		$this->BanMultipleShot->ViewCustomAttributes = "";

		// ProhibitUO
		$this->ProhibitUO->ViewValue = $this->ProhibitUO->CurrentValue;
		$this->ProhibitUO->ViewCustomAttributes = "";

		// ConsumableGoods
		$this->ConsumableGoods->ViewValue = $this->ConsumableGoods->CurrentValue;
		$this->ConsumableGoods->ViewCustomAttributes = "";

		// Continued_Round
		$this->Continued_Round->ViewValue = $this->Continued_Round->CurrentValue;
		$this->Continued_Round->ViewCustomAttributes = "";

		// Continued_Type
		$this->Continued_Type->ViewValue = $this->Continued_Type->CurrentValue;
		$this->Continued_Type->ViewCustomAttributes = "";

		// Continued_Effect
		$this->Continued_Effect->ViewValue = $this->Continued_Effect->CurrentValue;
		$this->Continued_Effect->ViewCustomAttributes = "";

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

		// Type
		$this->Type->LinkCustomAttributes = "";
		$this->Type->HrefValue = "";
		$this->Type->TooltipValue = "";

		// Consume
		$this->Consume->LinkCustomAttributes = "";
		$this->Consume->HrefValue = "";
		$this->Consume->TooltipValue = "";

		// Effect
		$this->Effect->LinkCustomAttributes = "";
		$this->Effect->HrefValue = "";
		$this->Effect->TooltipValue = "";

		// EO
		$this->EO->LinkCustomAttributes = "";
		$this->EO->HrefValue = "";
		$this->EO->TooltipValue = "";

		// LV
		$this->LV->LinkCustomAttributes = "";
		$this->LV->HrefValue = "";
		$this->LV->TooltipValue = "";

		// ConsumeType
		$this->ConsumeType->LinkCustomAttributes = "";
		$this->ConsumeType->HrefValue = "";
		$this->ConsumeType->TooltipValue = "";

		// Cooling
		$this->Cooling->LinkCustomAttributes = "";
		$this->Cooling->HrefValue = "";
		$this->Cooling->TooltipValue = "";

		// Accurate
		$this->Accurate->LinkCustomAttributes = "";
		$this->Accurate->HrefValue = "";
		$this->Accurate->TooltipValue = "";

		// AttackTips
		$this->AttackTips->LinkCustomAttributes = "";
		$this->AttackTips->HrefValue = "";
		$this->AttackTips->TooltipValue = "";

		// Introduce
		$this->Introduce->LinkCustomAttributes = "";
		$this->Introduce->HrefValue = "";
		$this->Introduce->TooltipValue = "";

		// ACS
		$this->ACS->LinkCustomAttributes = "";
		$this->ACS->HrefValue = "";
		$this->ACS->TooltipValue = "";

		// Shield
		$this->Shield->LinkCustomAttributes = "";
		$this->Shield->HrefValue = "";
		$this->Shield->TooltipValue = "";

		// IgnoreShield
		$this->IgnoreShield->LinkCustomAttributes = "";
		$this->IgnoreShield->HrefValue = "";
		$this->IgnoreShield->TooltipValue = "";

		// IgnoreIM
		$this->IgnoreIM->LinkCustomAttributes = "";
		$this->IgnoreIM->HrefValue = "";
		$this->IgnoreIM->TooltipValue = "";

		// IgnoreRE
		$this->IgnoreRE->LinkCustomAttributes = "";
		$this->IgnoreRE->HrefValue = "";
		$this->IgnoreRE->TooltipValue = "";

		// BanAbsorb
		$this->BanAbsorb->LinkCustomAttributes = "";
		$this->BanAbsorb->HrefValue = "";
		$this->BanAbsorb->TooltipValue = "";

		// BanMultipleShot
		$this->BanMultipleShot->LinkCustomAttributes = "";
		$this->BanMultipleShot->HrefValue = "";
		$this->BanMultipleShot->TooltipValue = "";

		// ProhibitUO
		$this->ProhibitUO->LinkCustomAttributes = "";
		$this->ProhibitUO->HrefValue = "";
		$this->ProhibitUO->TooltipValue = "";

		// ConsumableGoods
		$this->ConsumableGoods->LinkCustomAttributes = "";
		$this->ConsumableGoods->HrefValue = "";
		$this->ConsumableGoods->TooltipValue = "";

		// Continued_Round
		$this->Continued_Round->LinkCustomAttributes = "";
		$this->Continued_Round->HrefValue = "";
		$this->Continued_Round->TooltipValue = "";

		// Continued_Type
		$this->Continued_Type->LinkCustomAttributes = "";
		$this->Continued_Type->HrefValue = "";
		$this->Continued_Type->TooltipValue = "";

		// Continued_Effect
		$this->Continued_Effect->LinkCustomAttributes = "";
		$this->Continued_Effect->HrefValue = "";
		$this->Continued_Effect->TooltipValue = "";

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

		// Type
		$this->Type->EditAttrs["class"] = "form-control";
		$this->Type->EditCustomAttributes = "";
		$this->Type->EditValue = $this->Type->CurrentValue;
		$this->Type->PlaceHolder = ew_RemoveHtml($this->Type->FldCaption());

		// Consume
		$this->Consume->EditAttrs["class"] = "form-control";
		$this->Consume->EditCustomAttributes = "";
		$this->Consume->EditValue = $this->Consume->CurrentValue;
		$this->Consume->PlaceHolder = ew_RemoveHtml($this->Consume->FldCaption());

		// Effect
		$this->Effect->EditAttrs["class"] = "form-control";
		$this->Effect->EditCustomAttributes = "";
		$this->Effect->EditValue = $this->Effect->CurrentValue;
		$this->Effect->PlaceHolder = ew_RemoveHtml($this->Effect->FldCaption());

		// EO
		$this->EO->EditAttrs["class"] = "form-control";
		$this->EO->EditCustomAttributes = "";
		$this->EO->EditValue = $this->EO->CurrentValue;
		$this->EO->PlaceHolder = ew_RemoveHtml($this->EO->FldCaption());

		// LV
		$this->LV->EditAttrs["class"] = "form-control";
		$this->LV->EditCustomAttributes = "";
		$this->LV->EditValue = $this->LV->CurrentValue;
		$this->LV->PlaceHolder = ew_RemoveHtml($this->LV->FldCaption());

		// ConsumeType
		$this->ConsumeType->EditAttrs["class"] = "form-control";
		$this->ConsumeType->EditCustomAttributes = "";
		$this->ConsumeType->EditValue = $this->ConsumeType->CurrentValue;
		$this->ConsumeType->PlaceHolder = ew_RemoveHtml($this->ConsumeType->FldCaption());

		// Cooling
		$this->Cooling->EditAttrs["class"] = "form-control";
		$this->Cooling->EditCustomAttributes = "";
		$this->Cooling->EditValue = $this->Cooling->CurrentValue;
		$this->Cooling->PlaceHolder = ew_RemoveHtml($this->Cooling->FldCaption());

		// Accurate
		$this->Accurate->EditAttrs["class"] = "form-control";
		$this->Accurate->EditCustomAttributes = "";
		$this->Accurate->EditValue = $this->Accurate->CurrentValue;
		$this->Accurate->PlaceHolder = ew_RemoveHtml($this->Accurate->FldCaption());

		// AttackTips
		$this->AttackTips->EditAttrs["class"] = "form-control";
		$this->AttackTips->EditCustomAttributes = "";
		$this->AttackTips->EditValue = $this->AttackTips->CurrentValue;
		$this->AttackTips->PlaceHolder = ew_RemoveHtml($this->AttackTips->FldCaption());

		// Introduce
		$this->Introduce->EditAttrs["class"] = "form-control";
		$this->Introduce->EditCustomAttributes = "";
		$this->Introduce->EditValue = $this->Introduce->CurrentValue;
		$this->Introduce->PlaceHolder = ew_RemoveHtml($this->Introduce->FldCaption());

		// ACS
		$this->ACS->EditAttrs["class"] = "form-control";
		$this->ACS->EditCustomAttributes = "";
		$this->ACS->EditValue = $this->ACS->CurrentValue;
		$this->ACS->PlaceHolder = ew_RemoveHtml($this->ACS->FldCaption());

		// Shield
		$this->Shield->EditAttrs["class"] = "form-control";
		$this->Shield->EditCustomAttributes = "";
		$this->Shield->EditValue = $this->Shield->CurrentValue;
		$this->Shield->PlaceHolder = ew_RemoveHtml($this->Shield->FldCaption());

		// IgnoreShield
		$this->IgnoreShield->EditAttrs["class"] = "form-control";
		$this->IgnoreShield->EditCustomAttributes = "";
		$this->IgnoreShield->EditValue = $this->IgnoreShield->CurrentValue;
		$this->IgnoreShield->PlaceHolder = ew_RemoveHtml($this->IgnoreShield->FldCaption());

		// IgnoreIM
		$this->IgnoreIM->EditAttrs["class"] = "form-control";
		$this->IgnoreIM->EditCustomAttributes = "";
		$this->IgnoreIM->EditValue = $this->IgnoreIM->CurrentValue;
		$this->IgnoreIM->PlaceHolder = ew_RemoveHtml($this->IgnoreIM->FldCaption());

		// IgnoreRE
		$this->IgnoreRE->EditAttrs["class"] = "form-control";
		$this->IgnoreRE->EditCustomAttributes = "";
		$this->IgnoreRE->EditValue = $this->IgnoreRE->CurrentValue;
		$this->IgnoreRE->PlaceHolder = ew_RemoveHtml($this->IgnoreRE->FldCaption());

		// BanAbsorb
		$this->BanAbsorb->EditAttrs["class"] = "form-control";
		$this->BanAbsorb->EditCustomAttributes = "";
		$this->BanAbsorb->EditValue = $this->BanAbsorb->CurrentValue;
		$this->BanAbsorb->PlaceHolder = ew_RemoveHtml($this->BanAbsorb->FldCaption());

		// BanMultipleShot
		$this->BanMultipleShot->EditAttrs["class"] = "form-control";
		$this->BanMultipleShot->EditCustomAttributes = "";
		$this->BanMultipleShot->EditValue = $this->BanMultipleShot->CurrentValue;
		$this->BanMultipleShot->PlaceHolder = ew_RemoveHtml($this->BanMultipleShot->FldCaption());

		// ProhibitUO
		$this->ProhibitUO->EditAttrs["class"] = "form-control";
		$this->ProhibitUO->EditCustomAttributes = "";
		$this->ProhibitUO->EditValue = $this->ProhibitUO->CurrentValue;
		$this->ProhibitUO->PlaceHolder = ew_RemoveHtml($this->ProhibitUO->FldCaption());

		// ConsumableGoods
		$this->ConsumableGoods->EditAttrs["class"] = "form-control";
		$this->ConsumableGoods->EditCustomAttributes = "";
		$this->ConsumableGoods->EditValue = $this->ConsumableGoods->CurrentValue;
		$this->ConsumableGoods->PlaceHolder = ew_RemoveHtml($this->ConsumableGoods->FldCaption());

		// Continued_Round
		$this->Continued_Round->EditAttrs["class"] = "form-control";
		$this->Continued_Round->EditCustomAttributes = "";
		$this->Continued_Round->EditValue = $this->Continued_Round->CurrentValue;
		$this->Continued_Round->PlaceHolder = ew_RemoveHtml($this->Continued_Round->FldCaption());

		// Continued_Type
		$this->Continued_Type->EditAttrs["class"] = "form-control";
		$this->Continued_Type->EditCustomAttributes = "";
		$this->Continued_Type->EditValue = $this->Continued_Type->CurrentValue;
		$this->Continued_Type->PlaceHolder = ew_RemoveHtml($this->Continued_Type->FldCaption());

		// Continued_Effect
		$this->Continued_Effect->EditAttrs["class"] = "form-control";
		$this->Continued_Effect->EditCustomAttributes = "";
		$this->Continued_Effect->EditValue = $this->Continued_Effect->CurrentValue;
		$this->Continued_Effect->PlaceHolder = ew_RemoveHtml($this->Continued_Effect->FldCaption());

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
					if ($this->Type->Exportable) $Doc->ExportCaption($this->Type);
					if ($this->Consume->Exportable) $Doc->ExportCaption($this->Consume);
					if ($this->Effect->Exportable) $Doc->ExportCaption($this->Effect);
					if ($this->EO->Exportable) $Doc->ExportCaption($this->EO);
					if ($this->LV->Exportable) $Doc->ExportCaption($this->LV);
					if ($this->ConsumeType->Exportable) $Doc->ExportCaption($this->ConsumeType);
					if ($this->Cooling->Exportable) $Doc->ExportCaption($this->Cooling);
					if ($this->Accurate->Exportable) $Doc->ExportCaption($this->Accurate);
					if ($this->AttackTips->Exportable) $Doc->ExportCaption($this->AttackTips);
					if ($this->Introduce->Exportable) $Doc->ExportCaption($this->Introduce);
					if ($this->ACS->Exportable) $Doc->ExportCaption($this->ACS);
					if ($this->Shield->Exportable) $Doc->ExportCaption($this->Shield);
					if ($this->IgnoreShield->Exportable) $Doc->ExportCaption($this->IgnoreShield);
					if ($this->IgnoreIM->Exportable) $Doc->ExportCaption($this->IgnoreIM);
					if ($this->IgnoreRE->Exportable) $Doc->ExportCaption($this->IgnoreRE);
					if ($this->BanAbsorb->Exportable) $Doc->ExportCaption($this->BanAbsorb);
					if ($this->BanMultipleShot->Exportable) $Doc->ExportCaption($this->BanMultipleShot);
					if ($this->ProhibitUO->Exportable) $Doc->ExportCaption($this->ProhibitUO);
					if ($this->ConsumableGoods->Exportable) $Doc->ExportCaption($this->ConsumableGoods);
					if ($this->Continued_Round->Exportable) $Doc->ExportCaption($this->Continued_Round);
					if ($this->Continued_Type->Exportable) $Doc->ExportCaption($this->Continued_Type);
					if ($this->Continued_Effect->Exportable) $Doc->ExportCaption($this->Continued_Effect);
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
						if ($this->Type->Exportable) $Doc->ExportField($this->Type);
						if ($this->Consume->Exportable) $Doc->ExportField($this->Consume);
						if ($this->Effect->Exportable) $Doc->ExportField($this->Effect);
						if ($this->EO->Exportable) $Doc->ExportField($this->EO);
						if ($this->LV->Exportable) $Doc->ExportField($this->LV);
						if ($this->ConsumeType->Exportable) $Doc->ExportField($this->ConsumeType);
						if ($this->Cooling->Exportable) $Doc->ExportField($this->Cooling);
						if ($this->Accurate->Exportable) $Doc->ExportField($this->Accurate);
						if ($this->AttackTips->Exportable) $Doc->ExportField($this->AttackTips);
						if ($this->Introduce->Exportable) $Doc->ExportField($this->Introduce);
						if ($this->ACS->Exportable) $Doc->ExportField($this->ACS);
						if ($this->Shield->Exportable) $Doc->ExportField($this->Shield);
						if ($this->IgnoreShield->Exportable) $Doc->ExportField($this->IgnoreShield);
						if ($this->IgnoreIM->Exportable) $Doc->ExportField($this->IgnoreIM);
						if ($this->IgnoreRE->Exportable) $Doc->ExportField($this->IgnoreRE);
						if ($this->BanAbsorb->Exportable) $Doc->ExportField($this->BanAbsorb);
						if ($this->BanMultipleShot->Exportable) $Doc->ExportField($this->BanMultipleShot);
						if ($this->ProhibitUO->Exportable) $Doc->ExportField($this->ProhibitUO);
						if ($this->ConsumableGoods->Exportable) $Doc->ExportField($this->ConsumableGoods);
						if ($this->Continued_Round->Exportable) $Doc->ExportField($this->Continued_Round);
						if ($this->Continued_Type->Exportable) $Doc->ExportField($this->Continued_Type);
						if ($this->Continued_Effect->Exportable) $Doc->ExportField($this->Continued_Effect);
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
