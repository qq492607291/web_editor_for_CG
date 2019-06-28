<?php

// Global variable for table object
$ext_goodsextattr = NULL;

//
// Table class for ext_goodsextattr
//
class cext_goodsextattr extends cTable {
	var $unid;
	var $u_id;
	var $acl_id;
	var $Name;
	var $PriceNum;
	var $PriceType;
	var $UD_qualityNum;
	var $UD_cat;
	var $UD_qualityType;
	var $UD_kv4;
	var $UD_kv5;
	var $UD_kv6;
	var $UD_kv7;
	var $UD_kv8;
	var $UD_kv9;
	var $UD_kv10;
	var $DATETIME;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ext_goodsextattr';
		$this->TableName = 'ext_goodsextattr';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ext_goodsextattr`";
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
		$this->unid = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_unid', 'unid', '`unid`', '`unid`', 3, -1, FALSE, '`unid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->unid->Sortable = TRUE; // Allow sort
		$this->unid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unid'] = &$this->unid;

		// u_id
		$this->u_id = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_u_id', 'u_id', '`u_id`', '`u_id`', 3, -1, FALSE, '`u_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_id->Sortable = TRUE; // Allow sort
		$this->u_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_id'] = &$this->u_id;

		// acl_id
		$this->acl_id = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_acl_id', 'acl_id', '`acl_id`', '`acl_id`', 3, -1, FALSE, '`acl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acl_id->Sortable = TRUE; // Allow sort
		$this->acl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['acl_id'] = &$this->acl_id;

		// Name
		$this->Name = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_Name', 'Name', '`Name`', '`Name`', 201, -1, FALSE, '`Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Name->Sortable = TRUE; // Allow sort
		$this->fields['Name'] = &$this->Name;

		// PriceNum
		$this->PriceNum = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_PriceNum', 'PriceNum', '`PriceNum`', '`PriceNum`', 201, -1, FALSE, '`PriceNum`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->PriceNum->Sortable = TRUE; // Allow sort
		$this->fields['PriceNum'] = &$this->PriceNum;

		// PriceType
		$this->PriceType = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_PriceType', 'PriceType', '`PriceType`', '`PriceType`', 201, -1, FALSE, '`PriceType`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->PriceType->Sortable = TRUE; // Allow sort
		$this->fields['PriceType'] = &$this->PriceType;

		// UD_qualityNum
		$this->UD_qualityNum = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_UD_qualityNum', 'UD_qualityNum', '`UD_qualityNum`', '`UD_qualityNum`', 201, -1, FALSE, '`UD_qualityNum`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD_qualityNum->Sortable = TRUE; // Allow sort
		$this->fields['UD_qualityNum'] = &$this->UD_qualityNum;

		// UD_cat
		$this->UD_cat = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_UD_cat', 'UD_cat', '`UD_cat`', '`UD_cat`', 201, -1, FALSE, '`UD_cat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD_cat->Sortable = TRUE; // Allow sort
		$this->fields['UD_cat'] = &$this->UD_cat;

		// UD_qualityType
		$this->UD_qualityType = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_UD_qualityType', 'UD_qualityType', '`UD_qualityType`', '`UD_qualityType`', 201, -1, FALSE, '`UD_qualityType`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD_qualityType->Sortable = TRUE; // Allow sort
		$this->fields['UD_qualityType'] = &$this->UD_qualityType;

		// UD_kv4
		$this->UD_kv4 = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_UD_kv4', 'UD_kv4', '`UD_kv4`', '`UD_kv4`', 201, -1, FALSE, '`UD_kv4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD_kv4->Sortable = TRUE; // Allow sort
		$this->fields['UD_kv4'] = &$this->UD_kv4;

		// UD_kv5
		$this->UD_kv5 = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_UD_kv5', 'UD_kv5', '`UD_kv5`', '`UD_kv5`', 201, -1, FALSE, '`UD_kv5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD_kv5->Sortable = TRUE; // Allow sort
		$this->fields['UD_kv5'] = &$this->UD_kv5;

		// UD_kv6
		$this->UD_kv6 = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_UD_kv6', 'UD_kv6', '`UD_kv6`', '`UD_kv6`', 201, -1, FALSE, '`UD_kv6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD_kv6->Sortable = TRUE; // Allow sort
		$this->fields['UD_kv6'] = &$this->UD_kv6;

		// UD_kv7
		$this->UD_kv7 = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_UD_kv7', 'UD_kv7', '`UD_kv7`', '`UD_kv7`', 201, -1, FALSE, '`UD_kv7`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD_kv7->Sortable = TRUE; // Allow sort
		$this->fields['UD_kv7'] = &$this->UD_kv7;

		// UD_kv8
		$this->UD_kv8 = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_UD_kv8', 'UD_kv8', '`UD_kv8`', '`UD_kv8`', 201, -1, FALSE, '`UD_kv8`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD_kv8->Sortable = TRUE; // Allow sort
		$this->fields['UD_kv8'] = &$this->UD_kv8;

		// UD_kv9
		$this->UD_kv9 = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_UD_kv9', 'UD_kv9', '`UD_kv9`', '`UD_kv9`', 201, -1, FALSE, '`UD_kv9`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD_kv9->Sortable = TRUE; // Allow sort
		$this->fields['UD_kv9'] = &$this->UD_kv9;

		// UD_kv10
		$this->UD_kv10 = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_UD_kv10', 'UD_kv10', '`UD_kv10`', '`UD_kv10`', 201, -1, FALSE, '`UD_kv10`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->UD_kv10->Sortable = TRUE; // Allow sort
		$this->fields['UD_kv10'] = &$this->UD_kv10;

		// DATETIME
		$this->DATETIME = new cField('ext_goodsextattr', 'ext_goodsextattr', 'x_DATETIME', 'DATETIME', '`DATETIME`', ew_CastDateFieldForLike('`DATETIME`', 0, "DB"), 135, 0, FALSE, '`DATETIME`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ext_goodsextattr`";
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
			return "ext_goodsextattrlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "ext_goodsextattrview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "ext_goodsextattredit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "ext_goodsextattradd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "ext_goodsextattrlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ext_goodsextattrview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ext_goodsextattrview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ext_goodsextattradd.php?" . $this->UrlParm($parm);
		else
			$url = "ext_goodsextattradd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ext_goodsextattredit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ext_goodsextattradd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ext_goodsextattrdelete.php", $this->UrlParm());
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
		$this->PriceNum->setDbValue($rs->fields('PriceNum'));
		$this->PriceType->setDbValue($rs->fields('PriceType'));
		$this->UD_qualityNum->setDbValue($rs->fields('UD_qualityNum'));
		$this->UD_cat->setDbValue($rs->fields('UD_cat'));
		$this->UD_qualityType->setDbValue($rs->fields('UD_qualityType'));
		$this->UD_kv4->setDbValue($rs->fields('UD_kv4'));
		$this->UD_kv5->setDbValue($rs->fields('UD_kv5'));
		$this->UD_kv6->setDbValue($rs->fields('UD_kv6'));
		$this->UD_kv7->setDbValue($rs->fields('UD_kv7'));
		$this->UD_kv8->setDbValue($rs->fields('UD_kv8'));
		$this->UD_kv9->setDbValue($rs->fields('UD_kv9'));
		$this->UD_kv10->setDbValue($rs->fields('UD_kv10'));
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
		// PriceNum
		// PriceType
		// UD_qualityNum
		// UD_cat
		// UD_qualityType
		// UD_kv4
		// UD_kv5
		// UD_kv6
		// UD_kv7
		// UD_kv8
		// UD_kv9
		// UD_kv10
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

		// PriceNum
		$this->PriceNum->ViewValue = $this->PriceNum->CurrentValue;
		$this->PriceNum->ViewCustomAttributes = "";

		// PriceType
		$this->PriceType->ViewValue = $this->PriceType->CurrentValue;
		$this->PriceType->ViewCustomAttributes = "";

		// UD_qualityNum
		$this->UD_qualityNum->ViewValue = $this->UD_qualityNum->CurrentValue;
		$this->UD_qualityNum->ViewCustomAttributes = "";

		// UD_cat
		$this->UD_cat->ViewValue = $this->UD_cat->CurrentValue;
		$this->UD_cat->ViewCustomAttributes = "";

		// UD_qualityType
		$this->UD_qualityType->ViewValue = $this->UD_qualityType->CurrentValue;
		$this->UD_qualityType->ViewCustomAttributes = "";

		// UD_kv4
		$this->UD_kv4->ViewValue = $this->UD_kv4->CurrentValue;
		$this->UD_kv4->ViewCustomAttributes = "";

		// UD_kv5
		$this->UD_kv5->ViewValue = $this->UD_kv5->CurrentValue;
		$this->UD_kv5->ViewCustomAttributes = "";

		// UD_kv6
		$this->UD_kv6->ViewValue = $this->UD_kv6->CurrentValue;
		$this->UD_kv6->ViewCustomAttributes = "";

		// UD_kv7
		$this->UD_kv7->ViewValue = $this->UD_kv7->CurrentValue;
		$this->UD_kv7->ViewCustomAttributes = "";

		// UD_kv8
		$this->UD_kv8->ViewValue = $this->UD_kv8->CurrentValue;
		$this->UD_kv8->ViewCustomAttributes = "";

		// UD_kv9
		$this->UD_kv9->ViewValue = $this->UD_kv9->CurrentValue;
		$this->UD_kv9->ViewCustomAttributes = "";

		// UD_kv10
		$this->UD_kv10->ViewValue = $this->UD_kv10->CurrentValue;
		$this->UD_kv10->ViewCustomAttributes = "";

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

		// PriceNum
		$this->PriceNum->LinkCustomAttributes = "";
		$this->PriceNum->HrefValue = "";
		$this->PriceNum->TooltipValue = "";

		// PriceType
		$this->PriceType->LinkCustomAttributes = "";
		$this->PriceType->HrefValue = "";
		$this->PriceType->TooltipValue = "";

		// UD_qualityNum
		$this->UD_qualityNum->LinkCustomAttributes = "";
		$this->UD_qualityNum->HrefValue = "";
		$this->UD_qualityNum->TooltipValue = "";

		// UD_cat
		$this->UD_cat->LinkCustomAttributes = "";
		$this->UD_cat->HrefValue = "";
		$this->UD_cat->TooltipValue = "";

		// UD_qualityType
		$this->UD_qualityType->LinkCustomAttributes = "";
		$this->UD_qualityType->HrefValue = "";
		$this->UD_qualityType->TooltipValue = "";

		// UD_kv4
		$this->UD_kv4->LinkCustomAttributes = "";
		$this->UD_kv4->HrefValue = "";
		$this->UD_kv4->TooltipValue = "";

		// UD_kv5
		$this->UD_kv5->LinkCustomAttributes = "";
		$this->UD_kv5->HrefValue = "";
		$this->UD_kv5->TooltipValue = "";

		// UD_kv6
		$this->UD_kv6->LinkCustomAttributes = "";
		$this->UD_kv6->HrefValue = "";
		$this->UD_kv6->TooltipValue = "";

		// UD_kv7
		$this->UD_kv7->LinkCustomAttributes = "";
		$this->UD_kv7->HrefValue = "";
		$this->UD_kv7->TooltipValue = "";

		// UD_kv8
		$this->UD_kv8->LinkCustomAttributes = "";
		$this->UD_kv8->HrefValue = "";
		$this->UD_kv8->TooltipValue = "";

		// UD_kv9
		$this->UD_kv9->LinkCustomAttributes = "";
		$this->UD_kv9->HrefValue = "";
		$this->UD_kv9->TooltipValue = "";

		// UD_kv10
		$this->UD_kv10->LinkCustomAttributes = "";
		$this->UD_kv10->HrefValue = "";
		$this->UD_kv10->TooltipValue = "";

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

		// PriceNum
		$this->PriceNum->EditAttrs["class"] = "form-control";
		$this->PriceNum->EditCustomAttributes = "";
		$this->PriceNum->EditValue = $this->PriceNum->CurrentValue;
		$this->PriceNum->PlaceHolder = ew_RemoveHtml($this->PriceNum->FldCaption());

		// PriceType
		$this->PriceType->EditAttrs["class"] = "form-control";
		$this->PriceType->EditCustomAttributes = "";
		$this->PriceType->EditValue = $this->PriceType->CurrentValue;
		$this->PriceType->PlaceHolder = ew_RemoveHtml($this->PriceType->FldCaption());

		// UD_qualityNum
		$this->UD_qualityNum->EditAttrs["class"] = "form-control";
		$this->UD_qualityNum->EditCustomAttributes = "";
		$this->UD_qualityNum->EditValue = $this->UD_qualityNum->CurrentValue;
		$this->UD_qualityNum->PlaceHolder = ew_RemoveHtml($this->UD_qualityNum->FldCaption());

		// UD_cat
		$this->UD_cat->EditAttrs["class"] = "form-control";
		$this->UD_cat->EditCustomAttributes = "";
		$this->UD_cat->EditValue = $this->UD_cat->CurrentValue;
		$this->UD_cat->PlaceHolder = ew_RemoveHtml($this->UD_cat->FldCaption());

		// UD_qualityType
		$this->UD_qualityType->EditAttrs["class"] = "form-control";
		$this->UD_qualityType->EditCustomAttributes = "";
		$this->UD_qualityType->EditValue = $this->UD_qualityType->CurrentValue;
		$this->UD_qualityType->PlaceHolder = ew_RemoveHtml($this->UD_qualityType->FldCaption());

		// UD_kv4
		$this->UD_kv4->EditAttrs["class"] = "form-control";
		$this->UD_kv4->EditCustomAttributes = "";
		$this->UD_kv4->EditValue = $this->UD_kv4->CurrentValue;
		$this->UD_kv4->PlaceHolder = ew_RemoveHtml($this->UD_kv4->FldCaption());

		// UD_kv5
		$this->UD_kv5->EditAttrs["class"] = "form-control";
		$this->UD_kv5->EditCustomAttributes = "";
		$this->UD_kv5->EditValue = $this->UD_kv5->CurrentValue;
		$this->UD_kv5->PlaceHolder = ew_RemoveHtml($this->UD_kv5->FldCaption());

		// UD_kv6
		$this->UD_kv6->EditAttrs["class"] = "form-control";
		$this->UD_kv6->EditCustomAttributes = "";
		$this->UD_kv6->EditValue = $this->UD_kv6->CurrentValue;
		$this->UD_kv6->PlaceHolder = ew_RemoveHtml($this->UD_kv6->FldCaption());

		// UD_kv7
		$this->UD_kv7->EditAttrs["class"] = "form-control";
		$this->UD_kv7->EditCustomAttributes = "";
		$this->UD_kv7->EditValue = $this->UD_kv7->CurrentValue;
		$this->UD_kv7->PlaceHolder = ew_RemoveHtml($this->UD_kv7->FldCaption());

		// UD_kv8
		$this->UD_kv8->EditAttrs["class"] = "form-control";
		$this->UD_kv8->EditCustomAttributes = "";
		$this->UD_kv8->EditValue = $this->UD_kv8->CurrentValue;
		$this->UD_kv8->PlaceHolder = ew_RemoveHtml($this->UD_kv8->FldCaption());

		// UD_kv9
		$this->UD_kv9->EditAttrs["class"] = "form-control";
		$this->UD_kv9->EditCustomAttributes = "";
		$this->UD_kv9->EditValue = $this->UD_kv9->CurrentValue;
		$this->UD_kv9->PlaceHolder = ew_RemoveHtml($this->UD_kv9->FldCaption());

		// UD_kv10
		$this->UD_kv10->EditAttrs["class"] = "form-control";
		$this->UD_kv10->EditCustomAttributes = "";
		$this->UD_kv10->EditValue = $this->UD_kv10->CurrentValue;
		$this->UD_kv10->PlaceHolder = ew_RemoveHtml($this->UD_kv10->FldCaption());

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
					if ($this->PriceNum->Exportable) $Doc->ExportCaption($this->PriceNum);
					if ($this->PriceType->Exportable) $Doc->ExportCaption($this->PriceType);
					if ($this->UD_qualityNum->Exportable) $Doc->ExportCaption($this->UD_qualityNum);
					if ($this->UD_cat->Exportable) $Doc->ExportCaption($this->UD_cat);
					if ($this->UD_qualityType->Exportable) $Doc->ExportCaption($this->UD_qualityType);
					if ($this->UD_kv4->Exportable) $Doc->ExportCaption($this->UD_kv4);
					if ($this->UD_kv5->Exportable) $Doc->ExportCaption($this->UD_kv5);
					if ($this->UD_kv6->Exportable) $Doc->ExportCaption($this->UD_kv6);
					if ($this->UD_kv7->Exportable) $Doc->ExportCaption($this->UD_kv7);
					if ($this->UD_kv8->Exportable) $Doc->ExportCaption($this->UD_kv8);
					if ($this->UD_kv9->Exportable) $Doc->ExportCaption($this->UD_kv9);
					if ($this->UD_kv10->Exportable) $Doc->ExportCaption($this->UD_kv10);
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
						if ($this->PriceNum->Exportable) $Doc->ExportField($this->PriceNum);
						if ($this->PriceType->Exportable) $Doc->ExportField($this->PriceType);
						if ($this->UD_qualityNum->Exportable) $Doc->ExportField($this->UD_qualityNum);
						if ($this->UD_cat->Exportable) $Doc->ExportField($this->UD_cat);
						if ($this->UD_qualityType->Exportable) $Doc->ExportField($this->UD_qualityType);
						if ($this->UD_kv4->Exportable) $Doc->ExportField($this->UD_kv4);
						if ($this->UD_kv5->Exportable) $Doc->ExportField($this->UD_kv5);
						if ($this->UD_kv6->Exportable) $Doc->ExportField($this->UD_kv6);
						if ($this->UD_kv7->Exportable) $Doc->ExportField($this->UD_kv7);
						if ($this->UD_kv8->Exportable) $Doc->ExportField($this->UD_kv8);
						if ($this->UD_kv9->Exportable) $Doc->ExportField($this->UD_kv9);
						if ($this->UD_kv10->Exportable) $Doc->ExportField($this->UD_kv10);
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
