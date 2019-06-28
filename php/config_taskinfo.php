<?php

// Global variable for table object
$config_task = NULL;

//
// Table class for config_task
//
class cconfig_task extends cTable {
	var $unid;
	var $u_id;
	var $acl_id;
	var $Title;
	var $LV;
	var $Type;
	var $ResetTime;
	var $ResetType;
	var $CompleteTask;
	var $Occupation;
	var $Target;
	var $Data;
	var $Reward_Gold;
	var $Reward_Diamonds;
	var $Reward_EXP;
	var $Reward_Goods;
	var $Info;
	var $DATETIME;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'config_task';
		$this->TableName = 'config_task';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`config_task`";
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
		$this->unid = new cField('config_task', 'config_task', 'x_unid', 'unid', '`unid`', '`unid`', 3, -1, FALSE, '`unid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->unid->Sortable = TRUE; // Allow sort
		$this->unid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unid'] = &$this->unid;

		// u_id
		$this->u_id = new cField('config_task', 'config_task', 'x_u_id', 'u_id', '`u_id`', '`u_id`', 3, -1, FALSE, '`u_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_id->Sortable = TRUE; // Allow sort
		$this->u_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_id'] = &$this->u_id;

		// acl_id
		$this->acl_id = new cField('config_task', 'config_task', 'x_acl_id', 'acl_id', '`acl_id`', '`acl_id`', 3, -1, FALSE, '`acl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acl_id->Sortable = TRUE; // Allow sort
		$this->acl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['acl_id'] = &$this->acl_id;

		// Title
		$this->Title = new cField('config_task', 'config_task', 'x_Title', 'Title', '`Title`', '`Title`', 201, -1, FALSE, '`Title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Title->Sortable = TRUE; // Allow sort
		$this->fields['Title'] = &$this->Title;

		// LV
		$this->LV = new cField('config_task', 'config_task', 'x_LV', 'LV', '`LV`', '`LV`', 201, -1, FALSE, '`LV`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->LV->Sortable = TRUE; // Allow sort
		$this->fields['LV'] = &$this->LV;

		// Type
		$this->Type = new cField('config_task', 'config_task', 'x_Type', 'Type', '`Type`', '`Type`', 201, -1, FALSE, '`Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Type->Sortable = TRUE; // Allow sort
		$this->fields['Type'] = &$this->Type;

		// ResetTime
		$this->ResetTime = new cField('config_task', 'config_task', 'x_ResetTime', 'ResetTime', '`ResetTime`', '`ResetTime`', 201, -1, FALSE, '`ResetTime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->ResetTime->Sortable = TRUE; // Allow sort
		$this->fields['ResetTime'] = &$this->ResetTime;

		// ResetType
		$this->ResetType = new cField('config_task', 'config_task', 'x_ResetType', 'ResetType', '`ResetType`', '`ResetType`', 201, -1, FALSE, '`ResetType`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->ResetType->Sortable = TRUE; // Allow sort
		$this->fields['ResetType'] = &$this->ResetType;

		// CompleteTask
		$this->CompleteTask = new cField('config_task', 'config_task', 'x_CompleteTask', 'CompleteTask', '`CompleteTask`', '`CompleteTask`', 201, -1, FALSE, '`CompleteTask`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->CompleteTask->Sortable = TRUE; // Allow sort
		$this->fields['CompleteTask'] = &$this->CompleteTask;

		// Occupation
		$this->Occupation = new cField('config_task', 'config_task', 'x_Occupation', 'Occupation', '`Occupation`', '`Occupation`', 201, -1, FALSE, '`Occupation`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Occupation->Sortable = TRUE; // Allow sort
		$this->fields['Occupation'] = &$this->Occupation;

		// Target
		$this->Target = new cField('config_task', 'config_task', 'x_Target', 'Target', '`Target`', '`Target`', 201, -1, FALSE, '`Target`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Target->Sortable = TRUE; // Allow sort
		$this->fields['Target'] = &$this->Target;

		// Data
		$this->Data = new cField('config_task', 'config_task', 'x_Data', 'Data', '`Data`', '`Data`', 201, -1, FALSE, '`Data`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Data->Sortable = TRUE; // Allow sort
		$this->fields['Data'] = &$this->Data;

		// Reward_Gold
		$this->Reward_Gold = new cField('config_task', 'config_task', 'x_Reward_Gold', 'Reward_Gold', '`Reward_Gold`', '`Reward_Gold`', 201, -1, FALSE, '`Reward_Gold`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Reward_Gold->Sortable = TRUE; // Allow sort
		$this->fields['Reward_Gold'] = &$this->Reward_Gold;

		// Reward_Diamonds
		$this->Reward_Diamonds = new cField('config_task', 'config_task', 'x_Reward_Diamonds', 'Reward_Diamonds', '`Reward_Diamonds`', '`Reward_Diamonds`', 201, -1, FALSE, '`Reward_Diamonds`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Reward_Diamonds->Sortable = TRUE; // Allow sort
		$this->fields['Reward_Diamonds'] = &$this->Reward_Diamonds;

		// Reward_EXP
		$this->Reward_EXP = new cField('config_task', 'config_task', 'x_Reward_EXP', 'Reward_EXP', '`Reward_EXP`', '`Reward_EXP`', 201, -1, FALSE, '`Reward_EXP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Reward_EXP->Sortable = TRUE; // Allow sort
		$this->fields['Reward_EXP'] = &$this->Reward_EXP;

		// Reward_Goods
		$this->Reward_Goods = new cField('config_task', 'config_task', 'x_Reward_Goods', 'Reward_Goods', '`Reward_Goods`', '`Reward_Goods`', 201, -1, FALSE, '`Reward_Goods`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Reward_Goods->Sortable = TRUE; // Allow sort
		$this->fields['Reward_Goods'] = &$this->Reward_Goods;

		// Info
		$this->Info = new cField('config_task', 'config_task', 'x_Info', 'Info', '`Info`', '`Info`', 201, -1, FALSE, '`Info`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Info->Sortable = TRUE; // Allow sort
		$this->fields['Info'] = &$this->Info;

		// DATETIME
		$this->DATETIME = new cField('config_task', 'config_task', 'x_DATETIME', 'DATETIME', '`DATETIME`', ew_CastDateFieldForLike('`DATETIME`', 0, "DB"), 135, 0, FALSE, '`DATETIME`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`config_task`";
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
			return "config_tasklist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "config_taskview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "config_taskedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "config_taskadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "config_tasklist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("config_taskview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("config_taskview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "config_taskadd.php?" . $this->UrlParm($parm);
		else
			$url = "config_taskadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("config_taskedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("config_taskadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("config_taskdelete.php", $this->UrlParm());
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
		$this->Title->setDbValue($rs->fields('Title'));
		$this->LV->setDbValue($rs->fields('LV'));
		$this->Type->setDbValue($rs->fields('Type'));
		$this->ResetTime->setDbValue($rs->fields('ResetTime'));
		$this->ResetType->setDbValue($rs->fields('ResetType'));
		$this->CompleteTask->setDbValue($rs->fields('CompleteTask'));
		$this->Occupation->setDbValue($rs->fields('Occupation'));
		$this->Target->setDbValue($rs->fields('Target'));
		$this->Data->setDbValue($rs->fields('Data'));
		$this->Reward_Gold->setDbValue($rs->fields('Reward_Gold'));
		$this->Reward_Diamonds->setDbValue($rs->fields('Reward_Diamonds'));
		$this->Reward_EXP->setDbValue($rs->fields('Reward_EXP'));
		$this->Reward_Goods->setDbValue($rs->fields('Reward_Goods'));
		$this->Info->setDbValue($rs->fields('Info'));
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
		// Title
		// LV
		// Type
		// ResetTime
		// ResetType
		// CompleteTask
		// Occupation
		// Target
		// Data
		// Reward_Gold
		// Reward_Diamonds
		// Reward_EXP
		// Reward_Goods
		// Info
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

		// Title
		$this->Title->ViewValue = $this->Title->CurrentValue;
		$this->Title->ViewCustomAttributes = "";

		// LV
		$this->LV->ViewValue = $this->LV->CurrentValue;
		$this->LV->ViewCustomAttributes = "";

		// Type
		$this->Type->ViewValue = $this->Type->CurrentValue;
		$this->Type->ViewCustomAttributes = "";

		// ResetTime
		$this->ResetTime->ViewValue = $this->ResetTime->CurrentValue;
		$this->ResetTime->ViewCustomAttributes = "";

		// ResetType
		$this->ResetType->ViewValue = $this->ResetType->CurrentValue;
		$this->ResetType->ViewCustomAttributes = "";

		// CompleteTask
		$this->CompleteTask->ViewValue = $this->CompleteTask->CurrentValue;
		$this->CompleteTask->ViewCustomAttributes = "";

		// Occupation
		$this->Occupation->ViewValue = $this->Occupation->CurrentValue;
		$this->Occupation->ViewCustomAttributes = "";

		// Target
		$this->Target->ViewValue = $this->Target->CurrentValue;
		$this->Target->ViewCustomAttributes = "";

		// Data
		$this->Data->ViewValue = $this->Data->CurrentValue;
		$this->Data->ViewCustomAttributes = "";

		// Reward_Gold
		$this->Reward_Gold->ViewValue = $this->Reward_Gold->CurrentValue;
		$this->Reward_Gold->ViewCustomAttributes = "";

		// Reward_Diamonds
		$this->Reward_Diamonds->ViewValue = $this->Reward_Diamonds->CurrentValue;
		$this->Reward_Diamonds->ViewCustomAttributes = "";

		// Reward_EXP
		$this->Reward_EXP->ViewValue = $this->Reward_EXP->CurrentValue;
		$this->Reward_EXP->ViewCustomAttributes = "";

		// Reward_Goods
		$this->Reward_Goods->ViewValue = $this->Reward_Goods->CurrentValue;
		$this->Reward_Goods->ViewCustomAttributes = "";

		// Info
		$this->Info->ViewValue = $this->Info->CurrentValue;
		$this->Info->ViewCustomAttributes = "";

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

		// Title
		$this->Title->LinkCustomAttributes = "";
		$this->Title->HrefValue = "";
		$this->Title->TooltipValue = "";

		// LV
		$this->LV->LinkCustomAttributes = "";
		$this->LV->HrefValue = "";
		$this->LV->TooltipValue = "";

		// Type
		$this->Type->LinkCustomAttributes = "";
		$this->Type->HrefValue = "";
		$this->Type->TooltipValue = "";

		// ResetTime
		$this->ResetTime->LinkCustomAttributes = "";
		$this->ResetTime->HrefValue = "";
		$this->ResetTime->TooltipValue = "";

		// ResetType
		$this->ResetType->LinkCustomAttributes = "";
		$this->ResetType->HrefValue = "";
		$this->ResetType->TooltipValue = "";

		// CompleteTask
		$this->CompleteTask->LinkCustomAttributes = "";
		$this->CompleteTask->HrefValue = "";
		$this->CompleteTask->TooltipValue = "";

		// Occupation
		$this->Occupation->LinkCustomAttributes = "";
		$this->Occupation->HrefValue = "";
		$this->Occupation->TooltipValue = "";

		// Target
		$this->Target->LinkCustomAttributes = "";
		$this->Target->HrefValue = "";
		$this->Target->TooltipValue = "";

		// Data
		$this->Data->LinkCustomAttributes = "";
		$this->Data->HrefValue = "";
		$this->Data->TooltipValue = "";

		// Reward_Gold
		$this->Reward_Gold->LinkCustomAttributes = "";
		$this->Reward_Gold->HrefValue = "";
		$this->Reward_Gold->TooltipValue = "";

		// Reward_Diamonds
		$this->Reward_Diamonds->LinkCustomAttributes = "";
		$this->Reward_Diamonds->HrefValue = "";
		$this->Reward_Diamonds->TooltipValue = "";

		// Reward_EXP
		$this->Reward_EXP->LinkCustomAttributes = "";
		$this->Reward_EXP->HrefValue = "";
		$this->Reward_EXP->TooltipValue = "";

		// Reward_Goods
		$this->Reward_Goods->LinkCustomAttributes = "";
		$this->Reward_Goods->HrefValue = "";
		$this->Reward_Goods->TooltipValue = "";

		// Info
		$this->Info->LinkCustomAttributes = "";
		$this->Info->HrefValue = "";
		$this->Info->TooltipValue = "";

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

		// Title
		$this->Title->EditAttrs["class"] = "form-control";
		$this->Title->EditCustomAttributes = "";
		$this->Title->EditValue = $this->Title->CurrentValue;
		$this->Title->PlaceHolder = ew_RemoveHtml($this->Title->FldCaption());

		// LV
		$this->LV->EditAttrs["class"] = "form-control";
		$this->LV->EditCustomAttributes = "";
		$this->LV->EditValue = $this->LV->CurrentValue;
		$this->LV->PlaceHolder = ew_RemoveHtml($this->LV->FldCaption());

		// Type
		$this->Type->EditAttrs["class"] = "form-control";
		$this->Type->EditCustomAttributes = "";
		$this->Type->EditValue = $this->Type->CurrentValue;
		$this->Type->PlaceHolder = ew_RemoveHtml($this->Type->FldCaption());

		// ResetTime
		$this->ResetTime->EditAttrs["class"] = "form-control";
		$this->ResetTime->EditCustomAttributes = "";
		$this->ResetTime->EditValue = $this->ResetTime->CurrentValue;
		$this->ResetTime->PlaceHolder = ew_RemoveHtml($this->ResetTime->FldCaption());

		// ResetType
		$this->ResetType->EditAttrs["class"] = "form-control";
		$this->ResetType->EditCustomAttributes = "";
		$this->ResetType->EditValue = $this->ResetType->CurrentValue;
		$this->ResetType->PlaceHolder = ew_RemoveHtml($this->ResetType->FldCaption());

		// CompleteTask
		$this->CompleteTask->EditAttrs["class"] = "form-control";
		$this->CompleteTask->EditCustomAttributes = "";
		$this->CompleteTask->EditValue = $this->CompleteTask->CurrentValue;
		$this->CompleteTask->PlaceHolder = ew_RemoveHtml($this->CompleteTask->FldCaption());

		// Occupation
		$this->Occupation->EditAttrs["class"] = "form-control";
		$this->Occupation->EditCustomAttributes = "";
		$this->Occupation->EditValue = $this->Occupation->CurrentValue;
		$this->Occupation->PlaceHolder = ew_RemoveHtml($this->Occupation->FldCaption());

		// Target
		$this->Target->EditAttrs["class"] = "form-control";
		$this->Target->EditCustomAttributes = "";
		$this->Target->EditValue = $this->Target->CurrentValue;
		$this->Target->PlaceHolder = ew_RemoveHtml($this->Target->FldCaption());

		// Data
		$this->Data->EditAttrs["class"] = "form-control";
		$this->Data->EditCustomAttributes = "";
		$this->Data->EditValue = $this->Data->CurrentValue;
		$this->Data->PlaceHolder = ew_RemoveHtml($this->Data->FldCaption());

		// Reward_Gold
		$this->Reward_Gold->EditAttrs["class"] = "form-control";
		$this->Reward_Gold->EditCustomAttributes = "";
		$this->Reward_Gold->EditValue = $this->Reward_Gold->CurrentValue;
		$this->Reward_Gold->PlaceHolder = ew_RemoveHtml($this->Reward_Gold->FldCaption());

		// Reward_Diamonds
		$this->Reward_Diamonds->EditAttrs["class"] = "form-control";
		$this->Reward_Diamonds->EditCustomAttributes = "";
		$this->Reward_Diamonds->EditValue = $this->Reward_Diamonds->CurrentValue;
		$this->Reward_Diamonds->PlaceHolder = ew_RemoveHtml($this->Reward_Diamonds->FldCaption());

		// Reward_EXP
		$this->Reward_EXP->EditAttrs["class"] = "form-control";
		$this->Reward_EXP->EditCustomAttributes = "";
		$this->Reward_EXP->EditValue = $this->Reward_EXP->CurrentValue;
		$this->Reward_EXP->PlaceHolder = ew_RemoveHtml($this->Reward_EXP->FldCaption());

		// Reward_Goods
		$this->Reward_Goods->EditAttrs["class"] = "form-control";
		$this->Reward_Goods->EditCustomAttributes = "";
		$this->Reward_Goods->EditValue = $this->Reward_Goods->CurrentValue;
		$this->Reward_Goods->PlaceHolder = ew_RemoveHtml($this->Reward_Goods->FldCaption());

		// Info
		$this->Info->EditAttrs["class"] = "form-control";
		$this->Info->EditCustomAttributes = "";
		$this->Info->EditValue = $this->Info->CurrentValue;
		$this->Info->PlaceHolder = ew_RemoveHtml($this->Info->FldCaption());

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
					if ($this->Title->Exportable) $Doc->ExportCaption($this->Title);
					if ($this->LV->Exportable) $Doc->ExportCaption($this->LV);
					if ($this->Type->Exportable) $Doc->ExportCaption($this->Type);
					if ($this->ResetTime->Exportable) $Doc->ExportCaption($this->ResetTime);
					if ($this->ResetType->Exportable) $Doc->ExportCaption($this->ResetType);
					if ($this->CompleteTask->Exportable) $Doc->ExportCaption($this->CompleteTask);
					if ($this->Occupation->Exportable) $Doc->ExportCaption($this->Occupation);
					if ($this->Target->Exportable) $Doc->ExportCaption($this->Target);
					if ($this->Data->Exportable) $Doc->ExportCaption($this->Data);
					if ($this->Reward_Gold->Exportable) $Doc->ExportCaption($this->Reward_Gold);
					if ($this->Reward_Diamonds->Exportable) $Doc->ExportCaption($this->Reward_Diamonds);
					if ($this->Reward_EXP->Exportable) $Doc->ExportCaption($this->Reward_EXP);
					if ($this->Reward_Goods->Exportable) $Doc->ExportCaption($this->Reward_Goods);
					if ($this->Info->Exportable) $Doc->ExportCaption($this->Info);
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
						if ($this->Title->Exportable) $Doc->ExportField($this->Title);
						if ($this->LV->Exportable) $Doc->ExportField($this->LV);
						if ($this->Type->Exportable) $Doc->ExportField($this->Type);
						if ($this->ResetTime->Exportable) $Doc->ExportField($this->ResetTime);
						if ($this->ResetType->Exportable) $Doc->ExportField($this->ResetType);
						if ($this->CompleteTask->Exportable) $Doc->ExportField($this->CompleteTask);
						if ($this->Occupation->Exportable) $Doc->ExportField($this->Occupation);
						if ($this->Target->Exportable) $Doc->ExportField($this->Target);
						if ($this->Data->Exportable) $Doc->ExportField($this->Data);
						if ($this->Reward_Gold->Exportable) $Doc->ExportField($this->Reward_Gold);
						if ($this->Reward_Diamonds->Exportable) $Doc->ExportField($this->Reward_Diamonds);
						if ($this->Reward_EXP->Exportable) $Doc->ExportField($this->Reward_EXP);
						if ($this->Reward_Goods->Exportable) $Doc->ExportField($this->Reward_Goods);
						if ($this->Info->Exportable) $Doc->ExportField($this->Info);
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
