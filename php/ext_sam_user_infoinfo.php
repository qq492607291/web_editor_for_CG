<?php

// Global variable for table object
$ext_sam_user_info = NULL;

//
// Table class for ext_sam_user_info
//
class cext_sam_user_info extends cTable {
	var $unid;
	var $u_id;
	var $acl_id;
	var $Name;
	var $LV;
	var $MainCat;
	var $SubCat;
	var $Location;
	var $Dialog;
	var $Function;
	var $MasterName;
	var $HP;
	var $MAX_HP;
	var $UD1;
	var $UD2;
	var $UD3;
	var $UD4;
	var $UD5;
	var $UD6;
	var $UD7;
	var $UD8;
	var $UD9;
	var $UD10;
	var $UD11;
	var $UD12;
	var $Introduce;
	var $DATETIME;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ext_sam_user_info';
		$this->TableName = 'ext_sam_user_info';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ext_sam_user_info`";
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
		$this->unid = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_unid', 'unid', '`unid`', '`unid`', 3, -1, FALSE, '`unid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->unid->Sortable = TRUE; // Allow sort
		$this->unid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unid'] = &$this->unid;

		// u_id
		$this->u_id = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_u_id', 'u_id', '`u_id`', '`u_id`', 3, -1, FALSE, '`u_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_id->Sortable = TRUE; // Allow sort
		$this->u_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_id'] = &$this->u_id;

		// acl_id
		$this->acl_id = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_acl_id', 'acl_id', '`acl_id`', '`acl_id`', 3, -1, FALSE, '`acl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acl_id->Sortable = TRUE; // Allow sort
		$this->acl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['acl_id'] = &$this->acl_id;

		// Name
		$this->Name = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_Name', 'Name', '`Name`', '`Name`', 201, -1, FALSE, '`Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Name->Sortable = TRUE; // Allow sort
		$this->fields['Name'] = &$this->Name;

		// LV
		$this->LV = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_LV', 'LV', '`LV`', '`LV`', 201, -1, FALSE, '`LV`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->LV->Sortable = TRUE; // Allow sort
		$this->fields['LV'] = &$this->LV;

		// MainCat
		$this->MainCat = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_MainCat', 'MainCat', '`MainCat`', '`MainCat`', 201, -1, FALSE, '`MainCat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->MainCat->Sortable = TRUE; // Allow sort
		$this->fields['MainCat'] = &$this->MainCat;

		// SubCat
		$this->SubCat = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_SubCat', 'SubCat', '`SubCat`', '`SubCat`', 201, -1, FALSE, '`SubCat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->SubCat->Sortable = TRUE; // Allow sort
		$this->fields['SubCat'] = &$this->SubCat;

		// Location
		$this->Location = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_Location', 'Location', '`Location`', '`Location`', 201, -1, FALSE, '`Location`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Location->Sortable = TRUE; // Allow sort
		$this->fields['Location'] = &$this->Location;

		// Dialog
		$this->Dialog = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_Dialog', 'Dialog', '`Dialog`', '`Dialog`', 201, -1, FALSE, '`Dialog`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Dialog->Sortable = TRUE; // Allow sort
		$this->fields['Dialog'] = &$this->Dialog;

		// Function
		$this->Function = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_Function', 'Function', '`Function`', '`Function`', 201, -1, FALSE, '`Function`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Function->Sortable = TRUE; // Allow sort
		$this->fields['Function'] = &$this->Function;

		// MasterName
		$this->MasterName = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_MasterName', 'MasterName', '`MasterName`', '`MasterName`', 201, -1, FALSE, '`MasterName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->MasterName->Sortable = TRUE; // Allow sort
		$this->fields['MasterName'] = &$this->MasterName;

		// HP
		$this->HP = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_HP', 'HP', '`HP`', '`HP`', 201, -1, FALSE, '`HP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->HP->Sortable = TRUE; // Allow sort
		$this->fields['HP'] = &$this->HP;

		// MAX_HP
		$this->MAX_HP = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_MAX_HP', 'MAX_HP', '`MAX_HP`', '`MAX_HP`', 201, -1, FALSE, '`MAX_HP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->MAX_HP->Sortable = TRUE; // Allow sort
		$this->fields['MAX_HP'] = &$this->MAX_HP;

		// UD1
		$this->UD1 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD1', 'UD1', '`UD1`', '`UD1`', 201, -1, FALSE, '`UD1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD1->Sortable = TRUE; // Allow sort
		$this->fields['UD1'] = &$this->UD1;

		// UD2
		$this->UD2 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD2', 'UD2', '`UD2`', '`UD2`', 201, -1, FALSE, '`UD2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD2->Sortable = TRUE; // Allow sort
		$this->fields['UD2'] = &$this->UD2;

		// UD3
		$this->UD3 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD3', 'UD3', '`UD3`', '`UD3`', 201, -1, FALSE, '`UD3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD3->Sortable = TRUE; // Allow sort
		$this->fields['UD3'] = &$this->UD3;

		// UD4
		$this->UD4 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD4', 'UD4', '`UD4`', '`UD4`', 201, -1, FALSE, '`UD4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD4->Sortable = TRUE; // Allow sort
		$this->fields['UD4'] = &$this->UD4;

		// UD5
		$this->UD5 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD5', 'UD5', '`UD5`', '`UD5`', 201, -1, FALSE, '`UD5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD5->Sortable = TRUE; // Allow sort
		$this->fields['UD5'] = &$this->UD5;

		// UD6
		$this->UD6 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD6', 'UD6', '`UD6`', '`UD6`', 201, -1, FALSE, '`UD6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD6->Sortable = TRUE; // Allow sort
		$this->fields['UD6'] = &$this->UD6;

		// UD7
		$this->UD7 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD7', 'UD7', '`UD7`', '`UD7`', 201, -1, FALSE, '`UD7`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD7->Sortable = TRUE; // Allow sort
		$this->fields['UD7'] = &$this->UD7;

		// UD8
		$this->UD8 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD8', 'UD8', '`UD8`', '`UD8`', 201, -1, FALSE, '`UD8`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD8->Sortable = TRUE; // Allow sort
		$this->fields['UD8'] = &$this->UD8;

		// UD9
		$this->UD9 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD9', 'UD9', '`UD9`', '`UD9`', 201, -1, FALSE, '`UD9`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD9->Sortable = TRUE; // Allow sort
		$this->fields['UD9'] = &$this->UD9;

		// UD10
		$this->UD10 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD10', 'UD10', '`UD10`', '`UD10`', 201, -1, FALSE, '`UD10`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD10->Sortable = TRUE; // Allow sort
		$this->fields['UD10'] = &$this->UD10;

		// UD11
		$this->UD11 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD11', 'UD11', '`UD11`', '`UD11`', 201, -1, FALSE, '`UD11`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD11->Sortable = TRUE; // Allow sort
		$this->fields['UD11'] = &$this->UD11;

		// UD12
		$this->UD12 = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_UD12', 'UD12', '`UD12`', '`UD12`', 201, -1, FALSE, '`UD12`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD12->Sortable = TRUE; // Allow sort
		$this->fields['UD12'] = &$this->UD12;

		// Introduce
		$this->Introduce = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_Introduce', 'Introduce', '`Introduce`', '`Introduce`', 201, -1, FALSE, '`Introduce`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Introduce->Sortable = TRUE; // Allow sort
		$this->fields['Introduce'] = &$this->Introduce;

		// DATETIME
		$this->DATETIME = new cField('ext_sam_user_info', 'ext_sam_user_info', 'x_DATETIME', 'DATETIME', '`DATETIME`', ew_CastDateFieldForLike('`DATETIME`', 0, "DB"), 135, 0, FALSE, '`DATETIME`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ext_sam_user_info`";
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
			return "ext_sam_user_infolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "ext_sam_user_infoview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "ext_sam_user_infoedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "ext_sam_user_infoadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "ext_sam_user_infolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ext_sam_user_infoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ext_sam_user_infoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ext_sam_user_infoadd.php?" . $this->UrlParm($parm);
		else
			$url = "ext_sam_user_infoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ext_sam_user_infoedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ext_sam_user_infoadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ext_sam_user_infodelete.php", $this->UrlParm());
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
		$this->LV->setDbValue($rs->fields('LV'));
		$this->MainCat->setDbValue($rs->fields('MainCat'));
		$this->SubCat->setDbValue($rs->fields('SubCat'));
		$this->Location->setDbValue($rs->fields('Location'));
		$this->Dialog->setDbValue($rs->fields('Dialog'));
		$this->Function->setDbValue($rs->fields('Function'));
		$this->MasterName->setDbValue($rs->fields('MasterName'));
		$this->HP->setDbValue($rs->fields('HP'));
		$this->MAX_HP->setDbValue($rs->fields('MAX_HP'));
		$this->UD1->setDbValue($rs->fields('UD1'));
		$this->UD2->setDbValue($rs->fields('UD2'));
		$this->UD3->setDbValue($rs->fields('UD3'));
		$this->UD4->setDbValue($rs->fields('UD4'));
		$this->UD5->setDbValue($rs->fields('UD5'));
		$this->UD6->setDbValue($rs->fields('UD6'));
		$this->UD7->setDbValue($rs->fields('UD7'));
		$this->UD8->setDbValue($rs->fields('UD8'));
		$this->UD9->setDbValue($rs->fields('UD9'));
		$this->UD10->setDbValue($rs->fields('UD10'));
		$this->UD11->setDbValue($rs->fields('UD11'));
		$this->UD12->setDbValue($rs->fields('UD12'));
		$this->Introduce->setDbValue($rs->fields('Introduce'));
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
		// LV
		// MainCat
		// SubCat
		// Location
		// Dialog
		// Function
		// MasterName
		// HP
		// MAX_HP
		// UD1
		// UD2
		// UD3
		// UD4
		// UD5
		// UD6
		// UD7
		// UD8
		// UD9
		// UD10
		// UD11
		// UD12
		// Introduce
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

		// LV
		$this->LV->ViewValue = $this->LV->CurrentValue;
		$this->LV->ViewCustomAttributes = "";

		// MainCat
		$this->MainCat->ViewValue = $this->MainCat->CurrentValue;
		$this->MainCat->ViewCustomAttributes = "";

		// SubCat
		$this->SubCat->ViewValue = $this->SubCat->CurrentValue;
		$this->SubCat->ViewCustomAttributes = "";

		// Location
		$this->Location->ViewValue = $this->Location->CurrentValue;
		$this->Location->ViewCustomAttributes = "";

		// Dialog
		$this->Dialog->ViewValue = $this->Dialog->CurrentValue;
		$this->Dialog->ViewCustomAttributes = "";

		// Function
		$this->Function->ViewValue = $this->Function->CurrentValue;
		$this->Function->ViewCustomAttributes = "";

		// MasterName
		$this->MasterName->ViewValue = $this->MasterName->CurrentValue;
		$this->MasterName->ViewCustomAttributes = "";

		// HP
		$this->HP->ViewValue = $this->HP->CurrentValue;
		$this->HP->ViewCustomAttributes = "";

		// MAX_HP
		$this->MAX_HP->ViewValue = $this->MAX_HP->CurrentValue;
		$this->MAX_HP->ViewCustomAttributes = "";

		// UD1
		$this->UD1->ViewValue = $this->UD1->CurrentValue;
		$this->UD1->ViewCustomAttributes = "";

		// UD2
		$this->UD2->ViewValue = $this->UD2->CurrentValue;
		$this->UD2->ViewCustomAttributes = "";

		// UD3
		$this->UD3->ViewValue = $this->UD3->CurrentValue;
		$this->UD3->ViewCustomAttributes = "";

		// UD4
		$this->UD4->ViewValue = $this->UD4->CurrentValue;
		$this->UD4->ViewCustomAttributes = "";

		// UD5
		$this->UD5->ViewValue = $this->UD5->CurrentValue;
		$this->UD5->ViewCustomAttributes = "";

		// UD6
		$this->UD6->ViewValue = $this->UD6->CurrentValue;
		$this->UD6->ViewCustomAttributes = "";

		// UD7
		$this->UD7->ViewValue = $this->UD7->CurrentValue;
		$this->UD7->ViewCustomAttributes = "";

		// UD8
		$this->UD8->ViewValue = $this->UD8->CurrentValue;
		$this->UD8->ViewCustomAttributes = "";

		// UD9
		$this->UD9->ViewValue = $this->UD9->CurrentValue;
		$this->UD9->ViewCustomAttributes = "";

		// UD10
		$this->UD10->ViewValue = $this->UD10->CurrentValue;
		$this->UD10->ViewCustomAttributes = "";

		// UD11
		$this->UD11->ViewValue = $this->UD11->CurrentValue;
		$this->UD11->ViewCustomAttributes = "";

		// UD12
		$this->UD12->ViewValue = $this->UD12->CurrentValue;
		$this->UD12->ViewCustomAttributes = "";

		// Introduce
		$this->Introduce->ViewValue = $this->Introduce->CurrentValue;
		$this->Introduce->ViewCustomAttributes = "";

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

		// LV
		$this->LV->LinkCustomAttributes = "";
		$this->LV->HrefValue = "";
		$this->LV->TooltipValue = "";

		// MainCat
		$this->MainCat->LinkCustomAttributes = "";
		$this->MainCat->HrefValue = "";
		$this->MainCat->TooltipValue = "";

		// SubCat
		$this->SubCat->LinkCustomAttributes = "";
		$this->SubCat->HrefValue = "";
		$this->SubCat->TooltipValue = "";

		// Location
		$this->Location->LinkCustomAttributes = "";
		$this->Location->HrefValue = "";
		$this->Location->TooltipValue = "";

		// Dialog
		$this->Dialog->LinkCustomAttributes = "";
		$this->Dialog->HrefValue = "";
		$this->Dialog->TooltipValue = "";

		// Function
		$this->Function->LinkCustomAttributes = "";
		$this->Function->HrefValue = "";
		$this->Function->TooltipValue = "";

		// MasterName
		$this->MasterName->LinkCustomAttributes = "";
		$this->MasterName->HrefValue = "";
		$this->MasterName->TooltipValue = "";

		// HP
		$this->HP->LinkCustomAttributes = "";
		$this->HP->HrefValue = "";
		$this->HP->TooltipValue = "";

		// MAX_HP
		$this->MAX_HP->LinkCustomAttributes = "";
		$this->MAX_HP->HrefValue = "";
		$this->MAX_HP->TooltipValue = "";

		// UD1
		$this->UD1->LinkCustomAttributes = "";
		$this->UD1->HrefValue = "";
		$this->UD1->TooltipValue = "";

		// UD2
		$this->UD2->LinkCustomAttributes = "";
		$this->UD2->HrefValue = "";
		$this->UD2->TooltipValue = "";

		// UD3
		$this->UD3->LinkCustomAttributes = "";
		$this->UD3->HrefValue = "";
		$this->UD3->TooltipValue = "";

		// UD4
		$this->UD4->LinkCustomAttributes = "";
		$this->UD4->HrefValue = "";
		$this->UD4->TooltipValue = "";

		// UD5
		$this->UD5->LinkCustomAttributes = "";
		$this->UD5->HrefValue = "";
		$this->UD5->TooltipValue = "";

		// UD6
		$this->UD6->LinkCustomAttributes = "";
		$this->UD6->HrefValue = "";
		$this->UD6->TooltipValue = "";

		// UD7
		$this->UD7->LinkCustomAttributes = "";
		$this->UD7->HrefValue = "";
		$this->UD7->TooltipValue = "";

		// UD8
		$this->UD8->LinkCustomAttributes = "";
		$this->UD8->HrefValue = "";
		$this->UD8->TooltipValue = "";

		// UD9
		$this->UD9->LinkCustomAttributes = "";
		$this->UD9->HrefValue = "";
		$this->UD9->TooltipValue = "";

		// UD10
		$this->UD10->LinkCustomAttributes = "";
		$this->UD10->HrefValue = "";
		$this->UD10->TooltipValue = "";

		// UD11
		$this->UD11->LinkCustomAttributes = "";
		$this->UD11->HrefValue = "";
		$this->UD11->TooltipValue = "";

		// UD12
		$this->UD12->LinkCustomAttributes = "";
		$this->UD12->HrefValue = "";
		$this->UD12->TooltipValue = "";

		// Introduce
		$this->Introduce->LinkCustomAttributes = "";
		$this->Introduce->HrefValue = "";
		$this->Introduce->TooltipValue = "";

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

		// LV
		$this->LV->EditAttrs["class"] = "form-control";
		$this->LV->EditCustomAttributes = "";
		$this->LV->EditValue = $this->LV->CurrentValue;
		$this->LV->PlaceHolder = ew_RemoveHtml($this->LV->FldCaption());

		// MainCat
		$this->MainCat->EditAttrs["class"] = "form-control";
		$this->MainCat->EditCustomAttributes = "";
		$this->MainCat->EditValue = $this->MainCat->CurrentValue;
		$this->MainCat->PlaceHolder = ew_RemoveHtml($this->MainCat->FldCaption());

		// SubCat
		$this->SubCat->EditAttrs["class"] = "form-control";
		$this->SubCat->EditCustomAttributes = "";
		$this->SubCat->EditValue = $this->SubCat->CurrentValue;
		$this->SubCat->PlaceHolder = ew_RemoveHtml($this->SubCat->FldCaption());

		// Location
		$this->Location->EditAttrs["class"] = "form-control";
		$this->Location->EditCustomAttributes = "";
		$this->Location->EditValue = $this->Location->CurrentValue;
		$this->Location->PlaceHolder = ew_RemoveHtml($this->Location->FldCaption());

		// Dialog
		$this->Dialog->EditAttrs["class"] = "form-control";
		$this->Dialog->EditCustomAttributes = "";
		$this->Dialog->EditValue = $this->Dialog->CurrentValue;
		$this->Dialog->PlaceHolder = ew_RemoveHtml($this->Dialog->FldCaption());

		// Function
		$this->Function->EditAttrs["class"] = "form-control";
		$this->Function->EditCustomAttributes = "";
		$this->Function->EditValue = $this->Function->CurrentValue;
		$this->Function->PlaceHolder = ew_RemoveHtml($this->Function->FldCaption());

		// MasterName
		$this->MasterName->EditAttrs["class"] = "form-control";
		$this->MasterName->EditCustomAttributes = "";
		$this->MasterName->EditValue = $this->MasterName->CurrentValue;
		$this->MasterName->PlaceHolder = ew_RemoveHtml($this->MasterName->FldCaption());

		// HP
		$this->HP->EditAttrs["class"] = "form-control";
		$this->HP->EditCustomAttributes = "";
		$this->HP->EditValue = $this->HP->CurrentValue;
		$this->HP->PlaceHolder = ew_RemoveHtml($this->HP->FldCaption());

		// MAX_HP
		$this->MAX_HP->EditAttrs["class"] = "form-control";
		$this->MAX_HP->EditCustomAttributes = "";
		$this->MAX_HP->EditValue = $this->MAX_HP->CurrentValue;
		$this->MAX_HP->PlaceHolder = ew_RemoveHtml($this->MAX_HP->FldCaption());

		// UD1
		$this->UD1->EditAttrs["class"] = "form-control";
		$this->UD1->EditCustomAttributes = "";
		$this->UD1->EditValue = $this->UD1->CurrentValue;
		$this->UD1->PlaceHolder = ew_RemoveHtml($this->UD1->FldCaption());

		// UD2
		$this->UD2->EditAttrs["class"] = "form-control";
		$this->UD2->EditCustomAttributes = "";
		$this->UD2->EditValue = $this->UD2->CurrentValue;
		$this->UD2->PlaceHolder = ew_RemoveHtml($this->UD2->FldCaption());

		// UD3
		$this->UD3->EditAttrs["class"] = "form-control";
		$this->UD3->EditCustomAttributes = "";
		$this->UD3->EditValue = $this->UD3->CurrentValue;
		$this->UD3->PlaceHolder = ew_RemoveHtml($this->UD3->FldCaption());

		// UD4
		$this->UD4->EditAttrs["class"] = "form-control";
		$this->UD4->EditCustomAttributes = "";
		$this->UD4->EditValue = $this->UD4->CurrentValue;
		$this->UD4->PlaceHolder = ew_RemoveHtml($this->UD4->FldCaption());

		// UD5
		$this->UD5->EditAttrs["class"] = "form-control";
		$this->UD5->EditCustomAttributes = "";
		$this->UD5->EditValue = $this->UD5->CurrentValue;
		$this->UD5->PlaceHolder = ew_RemoveHtml($this->UD5->FldCaption());

		// UD6
		$this->UD6->EditAttrs["class"] = "form-control";
		$this->UD6->EditCustomAttributes = "";
		$this->UD6->EditValue = $this->UD6->CurrentValue;
		$this->UD6->PlaceHolder = ew_RemoveHtml($this->UD6->FldCaption());

		// UD7
		$this->UD7->EditAttrs["class"] = "form-control";
		$this->UD7->EditCustomAttributes = "";
		$this->UD7->EditValue = $this->UD7->CurrentValue;
		$this->UD7->PlaceHolder = ew_RemoveHtml($this->UD7->FldCaption());

		// UD8
		$this->UD8->EditAttrs["class"] = "form-control";
		$this->UD8->EditCustomAttributes = "";
		$this->UD8->EditValue = $this->UD8->CurrentValue;
		$this->UD8->PlaceHolder = ew_RemoveHtml($this->UD8->FldCaption());

		// UD9
		$this->UD9->EditAttrs["class"] = "form-control";
		$this->UD9->EditCustomAttributes = "";
		$this->UD9->EditValue = $this->UD9->CurrentValue;
		$this->UD9->PlaceHolder = ew_RemoveHtml($this->UD9->FldCaption());

		// UD10
		$this->UD10->EditAttrs["class"] = "form-control";
		$this->UD10->EditCustomAttributes = "";
		$this->UD10->EditValue = $this->UD10->CurrentValue;
		$this->UD10->PlaceHolder = ew_RemoveHtml($this->UD10->FldCaption());

		// UD11
		$this->UD11->EditAttrs["class"] = "form-control";
		$this->UD11->EditCustomAttributes = "";
		$this->UD11->EditValue = $this->UD11->CurrentValue;
		$this->UD11->PlaceHolder = ew_RemoveHtml($this->UD11->FldCaption());

		// UD12
		$this->UD12->EditAttrs["class"] = "form-control";
		$this->UD12->EditCustomAttributes = "";
		$this->UD12->EditValue = $this->UD12->CurrentValue;
		$this->UD12->PlaceHolder = ew_RemoveHtml($this->UD12->FldCaption());

		// Introduce
		$this->Introduce->EditAttrs["class"] = "form-control";
		$this->Introduce->EditCustomAttributes = "";
		$this->Introduce->EditValue = $this->Introduce->CurrentValue;
		$this->Introduce->PlaceHolder = ew_RemoveHtml($this->Introduce->FldCaption());

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
					if ($this->LV->Exportable) $Doc->ExportCaption($this->LV);
					if ($this->MainCat->Exportable) $Doc->ExportCaption($this->MainCat);
					if ($this->SubCat->Exportable) $Doc->ExportCaption($this->SubCat);
					if ($this->Location->Exportable) $Doc->ExportCaption($this->Location);
					if ($this->Dialog->Exportable) $Doc->ExportCaption($this->Dialog);
					if ($this->Function->Exportable) $Doc->ExportCaption($this->Function);
					if ($this->MasterName->Exportable) $Doc->ExportCaption($this->MasterName);
					if ($this->HP->Exportable) $Doc->ExportCaption($this->HP);
					if ($this->MAX_HP->Exportable) $Doc->ExportCaption($this->MAX_HP);
					if ($this->UD1->Exportable) $Doc->ExportCaption($this->UD1);
					if ($this->UD2->Exportable) $Doc->ExportCaption($this->UD2);
					if ($this->UD3->Exportable) $Doc->ExportCaption($this->UD3);
					if ($this->UD4->Exportable) $Doc->ExportCaption($this->UD4);
					if ($this->UD5->Exportable) $Doc->ExportCaption($this->UD5);
					if ($this->UD6->Exportable) $Doc->ExportCaption($this->UD6);
					if ($this->UD7->Exportable) $Doc->ExportCaption($this->UD7);
					if ($this->UD8->Exportable) $Doc->ExportCaption($this->UD8);
					if ($this->UD9->Exportable) $Doc->ExportCaption($this->UD9);
					if ($this->UD10->Exportable) $Doc->ExportCaption($this->UD10);
					if ($this->UD11->Exportable) $Doc->ExportCaption($this->UD11);
					if ($this->UD12->Exportable) $Doc->ExportCaption($this->UD12);
					if ($this->Introduce->Exportable) $Doc->ExportCaption($this->Introduce);
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
						if ($this->LV->Exportable) $Doc->ExportField($this->LV);
						if ($this->MainCat->Exportable) $Doc->ExportField($this->MainCat);
						if ($this->SubCat->Exportable) $Doc->ExportField($this->SubCat);
						if ($this->Location->Exportable) $Doc->ExportField($this->Location);
						if ($this->Dialog->Exportable) $Doc->ExportField($this->Dialog);
						if ($this->Function->Exportable) $Doc->ExportField($this->Function);
						if ($this->MasterName->Exportable) $Doc->ExportField($this->MasterName);
						if ($this->HP->Exportable) $Doc->ExportField($this->HP);
						if ($this->MAX_HP->Exportable) $Doc->ExportField($this->MAX_HP);
						if ($this->UD1->Exportable) $Doc->ExportField($this->UD1);
						if ($this->UD2->Exportable) $Doc->ExportField($this->UD2);
						if ($this->UD3->Exportable) $Doc->ExportField($this->UD3);
						if ($this->UD4->Exportable) $Doc->ExportField($this->UD4);
						if ($this->UD5->Exportable) $Doc->ExportField($this->UD5);
						if ($this->UD6->Exportable) $Doc->ExportField($this->UD6);
						if ($this->UD7->Exportable) $Doc->ExportField($this->UD7);
						if ($this->UD8->Exportable) $Doc->ExportField($this->UD8);
						if ($this->UD9->Exportable) $Doc->ExportField($this->UD9);
						if ($this->UD10->Exportable) $Doc->ExportField($this->UD10);
						if ($this->UD11->Exportable) $Doc->ExportField($this->UD11);
						if ($this->UD12->Exportable) $Doc->ExportField($this->UD12);
						if ($this->Introduce->Exportable) $Doc->ExportField($this->Introduce);
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
