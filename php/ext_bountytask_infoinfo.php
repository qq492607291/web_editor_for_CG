<?php

// Global variable for table object
$ext_bountytask_info = NULL;

//
// Table class for ext_bountytask_info
//
class cext_bountytask_info extends cTable {
	var $unid;
	var $u_id;
	var $acl_id;
	var $fromGroup____NOT_NULL;
	var $fromQQ_______NOT_NULL;
	var $taskName;
	var $taskType;
	var $taskTarget;
	var $taskCount;
	var $taskReward;
	var $taskNotes;
	var $TIMESTAMP;
	var $endTime;
	var $DATETIME;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ext_bountytask_info';
		$this->TableName = 'ext_bountytask_info';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ext_bountytask_info`";
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
		$this->unid = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_unid', 'unid', '`unid`', '`unid`', 3, -1, FALSE, '`unid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->unid->Sortable = TRUE; // Allow sort
		$this->unid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unid'] = &$this->unid;

		// u_id
		$this->u_id = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_u_id', 'u_id', '`u_id`', '`u_id`', 3, -1, FALSE, '`u_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_id->Sortable = TRUE; // Allow sort
		$this->u_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_id'] = &$this->u_id;

		// acl_id
		$this->acl_id = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_acl_id', 'acl_id', '`acl_id`', '`acl_id`', 3, -1, FALSE, '`acl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->acl_id->Sortable = TRUE; // Allow sort
		$this->acl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['acl_id'] = &$this->acl_id;

		// fromGroup    NOT NULL
		$this->fromGroup____NOT_NULL = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_fromGroup____NOT_NULL', 'fromGroup    NOT NULL', '`fromGroup    NOT NULL`', '`fromGroup    NOT NULL`', 201, -1, FALSE, '`fromGroup    NOT NULL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fromGroup____NOT_NULL->Sortable = TRUE; // Allow sort
		$this->fields['fromGroup    NOT NULL'] = &$this->fromGroup____NOT_NULL;

		// fromQQ       NOT NULL
		$this->fromQQ_______NOT_NULL = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_fromQQ_______NOT_NULL', 'fromQQ       NOT NULL', '`fromQQ       NOT NULL`', '`fromQQ       NOT NULL`', 201, -1, FALSE, '`fromQQ       NOT NULL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fromQQ_______NOT_NULL->Sortable = TRUE; // Allow sort
		$this->fields['fromQQ       NOT NULL'] = &$this->fromQQ_______NOT_NULL;

		// taskName
		$this->taskName = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_taskName', 'taskName', '`taskName`', '`taskName`', 201, -1, FALSE, '`taskName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->taskName->Sortable = TRUE; // Allow sort
		$this->fields['taskName'] = &$this->taskName;

		// taskType
		$this->taskType = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_taskType', 'taskType', '`taskType`', '`taskType`', 201, -1, FALSE, '`taskType`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->taskType->Sortable = TRUE; // Allow sort
		$this->fields['taskType'] = &$this->taskType;

		// taskTarget
		$this->taskTarget = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_taskTarget', 'taskTarget', '`taskTarget`', '`taskTarget`', 201, -1, FALSE, '`taskTarget`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->taskTarget->Sortable = TRUE; // Allow sort
		$this->fields['taskTarget'] = &$this->taskTarget;

		// taskCount
		$this->taskCount = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_taskCount', 'taskCount', '`taskCount`', '`taskCount`', 201, -1, FALSE, '`taskCount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->taskCount->Sortable = TRUE; // Allow sort
		$this->fields['taskCount'] = &$this->taskCount;

		// taskReward
		$this->taskReward = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_taskReward', 'taskReward', '`taskReward`', '`taskReward`', 201, -1, FALSE, '`taskReward`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->taskReward->Sortable = TRUE; // Allow sort
		$this->fields['taskReward'] = &$this->taskReward;

		// taskNotes
		$this->taskNotes = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_taskNotes', 'taskNotes', '`taskNotes`', '`taskNotes`', 201, -1, FALSE, '`taskNotes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->taskNotes->Sortable = TRUE; // Allow sort
		$this->fields['taskNotes'] = &$this->taskNotes;

		// TIMESTAMP
		$this->TIMESTAMP = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_TIMESTAMP', 'TIMESTAMP', '`TIMESTAMP`', '`TIMESTAMP`', 201, -1, FALSE, '`TIMESTAMP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->TIMESTAMP->Sortable = TRUE; // Allow sort
		$this->fields['TIMESTAMP'] = &$this->TIMESTAMP;

		// endTime
		$this->endTime = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_endTime', 'endTime', '`endTime`', '`endTime`', 201, -1, FALSE, '`endTime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->endTime->Sortable = TRUE; // Allow sort
		$this->fields['endTime'] = &$this->endTime;

		// DATETIME
		$this->DATETIME = new cField('ext_bountytask_info', 'ext_bountytask_info', 'x_DATETIME', 'DATETIME', '`DATETIME`', ew_CastDateFieldForLike('`DATETIME`', 0, "DB"), 135, 0, FALSE, '`DATETIME`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ext_bountytask_info`";
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
			return "ext_bountytask_infolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "ext_bountytask_infoview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "ext_bountytask_infoedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "ext_bountytask_infoadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "ext_bountytask_infolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ext_bountytask_infoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ext_bountytask_infoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ext_bountytask_infoadd.php?" . $this->UrlParm($parm);
		else
			$url = "ext_bountytask_infoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ext_bountytask_infoedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ext_bountytask_infoadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ext_bountytask_infodelete.php", $this->UrlParm());
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
		$this->fromGroup____NOT_NULL->setDbValue($rs->fields('fromGroup    NOT NULL'));
		$this->fromQQ_______NOT_NULL->setDbValue($rs->fields('fromQQ       NOT NULL'));
		$this->taskName->setDbValue($rs->fields('taskName'));
		$this->taskType->setDbValue($rs->fields('taskType'));
		$this->taskTarget->setDbValue($rs->fields('taskTarget'));
		$this->taskCount->setDbValue($rs->fields('taskCount'));
		$this->taskReward->setDbValue($rs->fields('taskReward'));
		$this->taskNotes->setDbValue($rs->fields('taskNotes'));
		$this->TIMESTAMP->setDbValue($rs->fields('TIMESTAMP'));
		$this->endTime->setDbValue($rs->fields('endTime'));
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
		// fromGroup    NOT NULL
		// fromQQ       NOT NULL
		// taskName
		// taskType
		// taskTarget
		// taskCount
		// taskReward
		// taskNotes
		// TIMESTAMP
		// endTime
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

		// fromGroup    NOT NULL
		$this->fromGroup____NOT_NULL->ViewValue = $this->fromGroup____NOT_NULL->CurrentValue;
		$this->fromGroup____NOT_NULL->ViewCustomAttributes = "";

		// fromQQ       NOT NULL
		$this->fromQQ_______NOT_NULL->ViewValue = $this->fromQQ_______NOT_NULL->CurrentValue;
		$this->fromQQ_______NOT_NULL->ViewCustomAttributes = "";

		// taskName
		$this->taskName->ViewValue = $this->taskName->CurrentValue;
		$this->taskName->ViewCustomAttributes = "";

		// taskType
		$this->taskType->ViewValue = $this->taskType->CurrentValue;
		$this->taskType->ViewCustomAttributes = "";

		// taskTarget
		$this->taskTarget->ViewValue = $this->taskTarget->CurrentValue;
		$this->taskTarget->ViewCustomAttributes = "";

		// taskCount
		$this->taskCount->ViewValue = $this->taskCount->CurrentValue;
		$this->taskCount->ViewCustomAttributes = "";

		// taskReward
		$this->taskReward->ViewValue = $this->taskReward->CurrentValue;
		$this->taskReward->ViewCustomAttributes = "";

		// taskNotes
		$this->taskNotes->ViewValue = $this->taskNotes->CurrentValue;
		$this->taskNotes->ViewCustomAttributes = "";

		// TIMESTAMP
		$this->TIMESTAMP->ViewValue = $this->TIMESTAMP->CurrentValue;
		$this->TIMESTAMP->ViewCustomAttributes = "";

		// endTime
		$this->endTime->ViewValue = $this->endTime->CurrentValue;
		$this->endTime->ViewCustomAttributes = "";

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

		// fromGroup    NOT NULL
		$this->fromGroup____NOT_NULL->LinkCustomAttributes = "";
		$this->fromGroup____NOT_NULL->HrefValue = "";
		$this->fromGroup____NOT_NULL->TooltipValue = "";

		// fromQQ       NOT NULL
		$this->fromQQ_______NOT_NULL->LinkCustomAttributes = "";
		$this->fromQQ_______NOT_NULL->HrefValue = "";
		$this->fromQQ_______NOT_NULL->TooltipValue = "";

		// taskName
		$this->taskName->LinkCustomAttributes = "";
		$this->taskName->HrefValue = "";
		$this->taskName->TooltipValue = "";

		// taskType
		$this->taskType->LinkCustomAttributes = "";
		$this->taskType->HrefValue = "";
		$this->taskType->TooltipValue = "";

		// taskTarget
		$this->taskTarget->LinkCustomAttributes = "";
		$this->taskTarget->HrefValue = "";
		$this->taskTarget->TooltipValue = "";

		// taskCount
		$this->taskCount->LinkCustomAttributes = "";
		$this->taskCount->HrefValue = "";
		$this->taskCount->TooltipValue = "";

		// taskReward
		$this->taskReward->LinkCustomAttributes = "";
		$this->taskReward->HrefValue = "";
		$this->taskReward->TooltipValue = "";

		// taskNotes
		$this->taskNotes->LinkCustomAttributes = "";
		$this->taskNotes->HrefValue = "";
		$this->taskNotes->TooltipValue = "";

		// TIMESTAMP
		$this->TIMESTAMP->LinkCustomAttributes = "";
		$this->TIMESTAMP->HrefValue = "";
		$this->TIMESTAMP->TooltipValue = "";

		// endTime
		$this->endTime->LinkCustomAttributes = "";
		$this->endTime->HrefValue = "";
		$this->endTime->TooltipValue = "";

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

		// fromGroup    NOT NULL
		$this->fromGroup____NOT_NULL->EditAttrs["class"] = "form-control";
		$this->fromGroup____NOT_NULL->EditCustomAttributes = "";
		$this->fromGroup____NOT_NULL->EditValue = $this->fromGroup____NOT_NULL->CurrentValue;
		$this->fromGroup____NOT_NULL->PlaceHolder = ew_RemoveHtml($this->fromGroup____NOT_NULL->FldCaption());

		// fromQQ       NOT NULL
		$this->fromQQ_______NOT_NULL->EditAttrs["class"] = "form-control";
		$this->fromQQ_______NOT_NULL->EditCustomAttributes = "";
		$this->fromQQ_______NOT_NULL->EditValue = $this->fromQQ_______NOT_NULL->CurrentValue;
		$this->fromQQ_______NOT_NULL->PlaceHolder = ew_RemoveHtml($this->fromQQ_______NOT_NULL->FldCaption());

		// taskName
		$this->taskName->EditAttrs["class"] = "form-control";
		$this->taskName->EditCustomAttributes = "";
		$this->taskName->EditValue = $this->taskName->CurrentValue;
		$this->taskName->PlaceHolder = ew_RemoveHtml($this->taskName->FldCaption());

		// taskType
		$this->taskType->EditAttrs["class"] = "form-control";
		$this->taskType->EditCustomAttributes = "";
		$this->taskType->EditValue = $this->taskType->CurrentValue;
		$this->taskType->PlaceHolder = ew_RemoveHtml($this->taskType->FldCaption());

		// taskTarget
		$this->taskTarget->EditAttrs["class"] = "form-control";
		$this->taskTarget->EditCustomAttributes = "";
		$this->taskTarget->EditValue = $this->taskTarget->CurrentValue;
		$this->taskTarget->PlaceHolder = ew_RemoveHtml($this->taskTarget->FldCaption());

		// taskCount
		$this->taskCount->EditAttrs["class"] = "form-control";
		$this->taskCount->EditCustomAttributes = "";
		$this->taskCount->EditValue = $this->taskCount->CurrentValue;
		$this->taskCount->PlaceHolder = ew_RemoveHtml($this->taskCount->FldCaption());

		// taskReward
		$this->taskReward->EditAttrs["class"] = "form-control";
		$this->taskReward->EditCustomAttributes = "";
		$this->taskReward->EditValue = $this->taskReward->CurrentValue;
		$this->taskReward->PlaceHolder = ew_RemoveHtml($this->taskReward->FldCaption());

		// taskNotes
		$this->taskNotes->EditAttrs["class"] = "form-control";
		$this->taskNotes->EditCustomAttributes = "";
		$this->taskNotes->EditValue = $this->taskNotes->CurrentValue;
		$this->taskNotes->PlaceHolder = ew_RemoveHtml($this->taskNotes->FldCaption());

		// TIMESTAMP
		$this->TIMESTAMP->EditAttrs["class"] = "form-control";
		$this->TIMESTAMP->EditCustomAttributes = "";
		$this->TIMESTAMP->EditValue = $this->TIMESTAMP->CurrentValue;
		$this->TIMESTAMP->PlaceHolder = ew_RemoveHtml($this->TIMESTAMP->FldCaption());

		// endTime
		$this->endTime->EditAttrs["class"] = "form-control";
		$this->endTime->EditCustomAttributes = "";
		$this->endTime->EditValue = $this->endTime->CurrentValue;
		$this->endTime->PlaceHolder = ew_RemoveHtml($this->endTime->FldCaption());

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
					if ($this->fromGroup____NOT_NULL->Exportable) $Doc->ExportCaption($this->fromGroup____NOT_NULL);
					if ($this->fromQQ_______NOT_NULL->Exportable) $Doc->ExportCaption($this->fromQQ_______NOT_NULL);
					if ($this->taskName->Exportable) $Doc->ExportCaption($this->taskName);
					if ($this->taskType->Exportable) $Doc->ExportCaption($this->taskType);
					if ($this->taskTarget->Exportable) $Doc->ExportCaption($this->taskTarget);
					if ($this->taskCount->Exportable) $Doc->ExportCaption($this->taskCount);
					if ($this->taskReward->Exportable) $Doc->ExportCaption($this->taskReward);
					if ($this->taskNotes->Exportable) $Doc->ExportCaption($this->taskNotes);
					if ($this->TIMESTAMP->Exportable) $Doc->ExportCaption($this->TIMESTAMP);
					if ($this->endTime->Exportable) $Doc->ExportCaption($this->endTime);
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
						if ($this->fromGroup____NOT_NULL->Exportable) $Doc->ExportField($this->fromGroup____NOT_NULL);
						if ($this->fromQQ_______NOT_NULL->Exportable) $Doc->ExportField($this->fromQQ_______NOT_NULL);
						if ($this->taskName->Exportable) $Doc->ExportField($this->taskName);
						if ($this->taskType->Exportable) $Doc->ExportField($this->taskType);
						if ($this->taskTarget->Exportable) $Doc->ExportField($this->taskTarget);
						if ($this->taskCount->Exportable) $Doc->ExportField($this->taskCount);
						if ($this->taskReward->Exportable) $Doc->ExportField($this->taskReward);
						if ($this->taskNotes->Exportable) $Doc->ExportField($this->taskNotes);
						if ($this->TIMESTAMP->Exportable) $Doc->ExportField($this->TIMESTAMP);
						if ($this->endTime->Exportable) $Doc->ExportField($this->endTime);
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
