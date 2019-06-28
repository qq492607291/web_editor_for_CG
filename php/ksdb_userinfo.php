<?php

// Global variable for table object
$ksdb_user = NULL;

//
// Table class for ksdb_user
//
class cksdb_user extends cTable {
	var $id;
	var $name;
	var $pinyin;
	var $_email;
	var $password;
	var $avatar_small;
	var $avatar_normal;
	var $level;
	var $timeline;
	var $settings;
	var $is_closed;
	var $mobile;
	var $tel;
	var $eid;
	var $weibo;
	var $desp;
	var $groups;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ksdb_user';
		$this->TableName = 'ksdb_user';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ksdb_user`";
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

		// id
		$this->id = new cField('ksdb_user', 'ksdb_user', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// name
		$this->name = new cField('ksdb_user', 'ksdb_user', 'x_name', 'name', '`name`', '`name`', 200, -1, FALSE, '`name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->name->Sortable = TRUE; // Allow sort
		$this->fields['name'] = &$this->name;

		// pinyin
		$this->pinyin = new cField('ksdb_user', 'ksdb_user', 'x_pinyin', 'pinyin', '`pinyin`', '`pinyin`', 200, -1, FALSE, '`pinyin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pinyin->Sortable = TRUE; // Allow sort
		$this->fields['pinyin'] = &$this->pinyin;

		// email
		$this->_email = new cField('ksdb_user', 'ksdb_user', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_email->Sortable = TRUE; // Allow sort
		$this->fields['email'] = &$this->_email;

		// password
		$this->password = new cField('ksdb_user', 'ksdb_user', 'x_password', 'password', '`password`', '`password`', 200, -1, FALSE, '`password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->password->Sortable = TRUE; // Allow sort
		$this->fields['password'] = &$this->password;

		// avatar_small
		$this->avatar_small = new cField('ksdb_user', 'ksdb_user', 'x_avatar_small', 'avatar_small', '`avatar_small`', '`avatar_small`', 200, -1, FALSE, '`avatar_small`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->avatar_small->Sortable = TRUE; // Allow sort
		$this->fields['avatar_small'] = &$this->avatar_small;

		// avatar_normal
		$this->avatar_normal = new cField('ksdb_user', 'ksdb_user', 'x_avatar_normal', 'avatar_normal', '`avatar_normal`', '`avatar_normal`', 200, -1, FALSE, '`avatar_normal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->avatar_normal->Sortable = TRUE; // Allow sort
		$this->fields['avatar_normal'] = &$this->avatar_normal;

		// level
		$this->level = new cField('ksdb_user', 'ksdb_user', 'x_level', 'level', '`level`', '`level`', 16, -1, FALSE, '`level`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->level->Sortable = TRUE; // Allow sort
		$this->level->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['level'] = &$this->level;

		// timeline
		$this->timeline = new cField('ksdb_user', 'ksdb_user', 'x_timeline', 'timeline', '`timeline`', ew_CastDateFieldForLike('`timeline`', 0, "DB"), 135, 0, FALSE, '`timeline`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->timeline->Sortable = TRUE; // Allow sort
		$this->timeline->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['timeline'] = &$this->timeline;

		// settings
		$this->settings = new cField('ksdb_user', 'ksdb_user', 'x_settings', 'settings', '`settings`', '`settings`', 201, -1, FALSE, '`settings`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->settings->Sortable = TRUE; // Allow sort
		$this->fields['settings'] = &$this->settings;

		// is_closed
		$this->is_closed = new cField('ksdb_user', 'ksdb_user', 'x_is_closed', 'is_closed', '`is_closed`', '`is_closed`', 16, -1, FALSE, '`is_closed`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->is_closed->Sortable = TRUE; // Allow sort
		$this->is_closed->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['is_closed'] = &$this->is_closed;

		// mobile
		$this->mobile = new cField('ksdb_user', 'ksdb_user', 'x_mobile', 'mobile', '`mobile`', '`mobile`', 200, -1, FALSE, '`mobile`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->mobile->Sortable = TRUE; // Allow sort
		$this->fields['mobile'] = &$this->mobile;

		// tel
		$this->tel = new cField('ksdb_user', 'ksdb_user', 'x_tel', 'tel', '`tel`', '`tel`', 200, -1, FALSE, '`tel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tel->Sortable = TRUE; // Allow sort
		$this->fields['tel'] = &$this->tel;

		// eid
		$this->eid = new cField('ksdb_user', 'ksdb_user', 'x_eid', 'eid', '`eid`', '`eid`', 200, -1, FALSE, '`eid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eid->Sortable = TRUE; // Allow sort
		$this->fields['eid'] = &$this->eid;

		// weibo
		$this->weibo = new cField('ksdb_user', 'ksdb_user', 'x_weibo', 'weibo', '`weibo`', '`weibo`', 200, -1, FALSE, '`weibo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->weibo->Sortable = TRUE; // Allow sort
		$this->fields['weibo'] = &$this->weibo;

		// desp
		$this->desp = new cField('ksdb_user', 'ksdb_user', 'x_desp', 'desp', '`desp`', '`desp`', 201, -1, FALSE, '`desp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->desp->Sortable = TRUE; // Allow sort
		$this->fields['desp'] = &$this->desp;

		// groups
		$this->groups = new cField('ksdb_user', 'ksdb_user', 'x_groups', 'groups', '`groups`', '`groups`', 200, -1, FALSE, '`groups`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->groups->Sortable = TRUE; // Allow sort
		$this->fields['groups'] = &$this->groups;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ksdb_user`";
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'password')
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
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
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			if (EW_ENCRYPTED_PASSWORD && $name == 'password') {
				if ($value == $this->fields[$name]->OldValue) // No need to update hashed password if not changed
					continue;
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
			}
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
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
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
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "ksdb_userlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "ksdb_userview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "ksdb_useredit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "ksdb_useradd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "ksdb_userlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ksdb_userview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ksdb_userview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ksdb_useradd.php?" . $this->UrlParm($parm);
		else
			$url = "ksdb_useradd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ksdb_useredit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ksdb_useradd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ksdb_userdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
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
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
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
			$this->id->CurrentValue = $key;
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
		$this->id->setDbValue($rs->fields('id'));
		$this->name->setDbValue($rs->fields('name'));
		$this->pinyin->setDbValue($rs->fields('pinyin'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->password->setDbValue($rs->fields('password'));
		$this->avatar_small->setDbValue($rs->fields('avatar_small'));
		$this->avatar_normal->setDbValue($rs->fields('avatar_normal'));
		$this->level->setDbValue($rs->fields('level'));
		$this->timeline->setDbValue($rs->fields('timeline'));
		$this->settings->setDbValue($rs->fields('settings'));
		$this->is_closed->setDbValue($rs->fields('is_closed'));
		$this->mobile->setDbValue($rs->fields('mobile'));
		$this->tel->setDbValue($rs->fields('tel'));
		$this->eid->setDbValue($rs->fields('eid'));
		$this->weibo->setDbValue($rs->fields('weibo'));
		$this->desp->setDbValue($rs->fields('desp'));
		$this->groups->setDbValue($rs->fields('groups'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// name
		// pinyin
		// email
		// password
		// avatar_small
		// avatar_normal
		// level
		// timeline
		// settings
		// is_closed
		// mobile
		// tel
		// eid
		// weibo
		// desp
		// groups
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// pinyin
		$this->pinyin->ViewValue = $this->pinyin->CurrentValue;
		$this->pinyin->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// password
		$this->password->ViewValue = $this->password->CurrentValue;
		$this->password->ViewCustomAttributes = "";

		// avatar_small
		$this->avatar_small->ViewValue = $this->avatar_small->CurrentValue;
		$this->avatar_small->ViewCustomAttributes = "";

		// avatar_normal
		$this->avatar_normal->ViewValue = $this->avatar_normal->CurrentValue;
		$this->avatar_normal->ViewCustomAttributes = "";

		// level
		$this->level->ViewValue = $this->level->CurrentValue;
		$this->level->ViewCustomAttributes = "";

		// timeline
		$this->timeline->ViewValue = $this->timeline->CurrentValue;
		$this->timeline->ViewValue = ew_FormatDateTime($this->timeline->ViewValue, 0);
		$this->timeline->ViewCustomAttributes = "";

		// settings
		$this->settings->ViewValue = $this->settings->CurrentValue;
		$this->settings->ViewCustomAttributes = "";

		// is_closed
		$this->is_closed->ViewValue = $this->is_closed->CurrentValue;
		$this->is_closed->ViewCustomAttributes = "";

		// mobile
		$this->mobile->ViewValue = $this->mobile->CurrentValue;
		$this->mobile->ViewCustomAttributes = "";

		// tel
		$this->tel->ViewValue = $this->tel->CurrentValue;
		$this->tel->ViewCustomAttributes = "";

		// eid
		$this->eid->ViewValue = $this->eid->CurrentValue;
		$this->eid->ViewCustomAttributes = "";

		// weibo
		$this->weibo->ViewValue = $this->weibo->CurrentValue;
		$this->weibo->ViewCustomAttributes = "";

		// desp
		$this->desp->ViewValue = $this->desp->CurrentValue;
		$this->desp->ViewCustomAttributes = "";

		// groups
		$this->groups->ViewValue = $this->groups->CurrentValue;
		$this->groups->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// name
		$this->name->LinkCustomAttributes = "";
		$this->name->HrefValue = "";
		$this->name->TooltipValue = "";

		// pinyin
		$this->pinyin->LinkCustomAttributes = "";
		$this->pinyin->HrefValue = "";
		$this->pinyin->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// password
		$this->password->LinkCustomAttributes = "";
		$this->password->HrefValue = "";
		$this->password->TooltipValue = "";

		// avatar_small
		$this->avatar_small->LinkCustomAttributes = "";
		$this->avatar_small->HrefValue = "";
		$this->avatar_small->TooltipValue = "";

		// avatar_normal
		$this->avatar_normal->LinkCustomAttributes = "";
		$this->avatar_normal->HrefValue = "";
		$this->avatar_normal->TooltipValue = "";

		// level
		$this->level->LinkCustomAttributes = "";
		$this->level->HrefValue = "";
		$this->level->TooltipValue = "";

		// timeline
		$this->timeline->LinkCustomAttributes = "";
		$this->timeline->HrefValue = "";
		$this->timeline->TooltipValue = "";

		// settings
		$this->settings->LinkCustomAttributes = "";
		$this->settings->HrefValue = "";
		$this->settings->TooltipValue = "";

		// is_closed
		$this->is_closed->LinkCustomAttributes = "";
		$this->is_closed->HrefValue = "";
		$this->is_closed->TooltipValue = "";

		// mobile
		$this->mobile->LinkCustomAttributes = "";
		$this->mobile->HrefValue = "";
		$this->mobile->TooltipValue = "";

		// tel
		$this->tel->LinkCustomAttributes = "";
		$this->tel->HrefValue = "";
		$this->tel->TooltipValue = "";

		// eid
		$this->eid->LinkCustomAttributes = "";
		$this->eid->HrefValue = "";
		$this->eid->TooltipValue = "";

		// weibo
		$this->weibo->LinkCustomAttributes = "";
		$this->weibo->HrefValue = "";
		$this->weibo->TooltipValue = "";

		// desp
		$this->desp->LinkCustomAttributes = "";
		$this->desp->HrefValue = "";
		$this->desp->TooltipValue = "";

		// groups
		$this->groups->LinkCustomAttributes = "";
		$this->groups->HrefValue = "";
		$this->groups->TooltipValue = "";

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

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// name
		$this->name->EditAttrs["class"] = "form-control";
		$this->name->EditCustomAttributes = "";
		$this->name->EditValue = $this->name->CurrentValue;
		$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

		// pinyin
		$this->pinyin->EditAttrs["class"] = "form-control";
		$this->pinyin->EditCustomAttributes = "";
		$this->pinyin->EditValue = $this->pinyin->CurrentValue;
		$this->pinyin->PlaceHolder = ew_RemoveHtml($this->pinyin->FldCaption());

		// email
		$this->_email->EditAttrs["class"] = "form-control";
		$this->_email->EditCustomAttributes = "";
		$this->_email->EditValue = $this->_email->CurrentValue;
		$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

		// password
		$this->password->EditAttrs["class"] = "form-control";
		$this->password->EditCustomAttributes = "";
		$this->password->EditValue = $this->password->CurrentValue;
		$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

		// avatar_small
		$this->avatar_small->EditAttrs["class"] = "form-control";
		$this->avatar_small->EditCustomAttributes = "";
		$this->avatar_small->EditValue = $this->avatar_small->CurrentValue;
		$this->avatar_small->PlaceHolder = ew_RemoveHtml($this->avatar_small->FldCaption());

		// avatar_normal
		$this->avatar_normal->EditAttrs["class"] = "form-control";
		$this->avatar_normal->EditCustomAttributes = "";
		$this->avatar_normal->EditValue = $this->avatar_normal->CurrentValue;
		$this->avatar_normal->PlaceHolder = ew_RemoveHtml($this->avatar_normal->FldCaption());

		// level
		$this->level->EditAttrs["class"] = "form-control";
		$this->level->EditCustomAttributes = "";
		$this->level->EditValue = $this->level->CurrentValue;
		$this->level->PlaceHolder = ew_RemoveHtml($this->level->FldCaption());

		// timeline
		$this->timeline->EditAttrs["class"] = "form-control";
		$this->timeline->EditCustomAttributes = "";
		$this->timeline->EditValue = ew_FormatDateTime($this->timeline->CurrentValue, 8);
		$this->timeline->PlaceHolder = ew_RemoveHtml($this->timeline->FldCaption());

		// settings
		$this->settings->EditAttrs["class"] = "form-control";
		$this->settings->EditCustomAttributes = "";
		$this->settings->EditValue = $this->settings->CurrentValue;
		$this->settings->PlaceHolder = ew_RemoveHtml($this->settings->FldCaption());

		// is_closed
		$this->is_closed->EditAttrs["class"] = "form-control";
		$this->is_closed->EditCustomAttributes = "";
		$this->is_closed->EditValue = $this->is_closed->CurrentValue;
		$this->is_closed->PlaceHolder = ew_RemoveHtml($this->is_closed->FldCaption());

		// mobile
		$this->mobile->EditAttrs["class"] = "form-control";
		$this->mobile->EditCustomAttributes = "";
		$this->mobile->EditValue = $this->mobile->CurrentValue;
		$this->mobile->PlaceHolder = ew_RemoveHtml($this->mobile->FldCaption());

		// tel
		$this->tel->EditAttrs["class"] = "form-control";
		$this->tel->EditCustomAttributes = "";
		$this->tel->EditValue = $this->tel->CurrentValue;
		$this->tel->PlaceHolder = ew_RemoveHtml($this->tel->FldCaption());

		// eid
		$this->eid->EditAttrs["class"] = "form-control";
		$this->eid->EditCustomAttributes = "";
		$this->eid->EditValue = $this->eid->CurrentValue;
		$this->eid->PlaceHolder = ew_RemoveHtml($this->eid->FldCaption());

		// weibo
		$this->weibo->EditAttrs["class"] = "form-control";
		$this->weibo->EditCustomAttributes = "";
		$this->weibo->EditValue = $this->weibo->CurrentValue;
		$this->weibo->PlaceHolder = ew_RemoveHtml($this->weibo->FldCaption());

		// desp
		$this->desp->EditAttrs["class"] = "form-control";
		$this->desp->EditCustomAttributes = "";
		$this->desp->EditValue = $this->desp->CurrentValue;
		$this->desp->PlaceHolder = ew_RemoveHtml($this->desp->FldCaption());

		// groups
		$this->groups->EditAttrs["class"] = "form-control";
		$this->groups->EditCustomAttributes = "";
		$this->groups->EditValue = $this->groups->CurrentValue;
		$this->groups->PlaceHolder = ew_RemoveHtml($this->groups->FldCaption());

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
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->pinyin->Exportable) $Doc->ExportCaption($this->pinyin);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->password->Exportable) $Doc->ExportCaption($this->password);
					if ($this->avatar_small->Exportable) $Doc->ExportCaption($this->avatar_small);
					if ($this->avatar_normal->Exportable) $Doc->ExportCaption($this->avatar_normal);
					if ($this->level->Exportable) $Doc->ExportCaption($this->level);
					if ($this->timeline->Exportable) $Doc->ExportCaption($this->timeline);
					if ($this->settings->Exportable) $Doc->ExportCaption($this->settings);
					if ($this->is_closed->Exportable) $Doc->ExportCaption($this->is_closed);
					if ($this->mobile->Exportable) $Doc->ExportCaption($this->mobile);
					if ($this->tel->Exportable) $Doc->ExportCaption($this->tel);
					if ($this->eid->Exportable) $Doc->ExportCaption($this->eid);
					if ($this->weibo->Exportable) $Doc->ExportCaption($this->weibo);
					if ($this->desp->Exportable) $Doc->ExportCaption($this->desp);
					if ($this->groups->Exportable) $Doc->ExportCaption($this->groups);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->pinyin->Exportable) $Doc->ExportCaption($this->pinyin);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->password->Exportable) $Doc->ExportCaption($this->password);
					if ($this->avatar_small->Exportable) $Doc->ExportCaption($this->avatar_small);
					if ($this->avatar_normal->Exportable) $Doc->ExportCaption($this->avatar_normal);
					if ($this->level->Exportable) $Doc->ExportCaption($this->level);
					if ($this->timeline->Exportable) $Doc->ExportCaption($this->timeline);
					if ($this->is_closed->Exportable) $Doc->ExportCaption($this->is_closed);
					if ($this->mobile->Exportable) $Doc->ExportCaption($this->mobile);
					if ($this->tel->Exportable) $Doc->ExportCaption($this->tel);
					if ($this->eid->Exportable) $Doc->ExportCaption($this->eid);
					if ($this->weibo->Exportable) $Doc->ExportCaption($this->weibo);
					if ($this->groups->Exportable) $Doc->ExportCaption($this->groups);
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
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->pinyin->Exportable) $Doc->ExportField($this->pinyin);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->password->Exportable) $Doc->ExportField($this->password);
						if ($this->avatar_small->Exportable) $Doc->ExportField($this->avatar_small);
						if ($this->avatar_normal->Exportable) $Doc->ExportField($this->avatar_normal);
						if ($this->level->Exportable) $Doc->ExportField($this->level);
						if ($this->timeline->Exportable) $Doc->ExportField($this->timeline);
						if ($this->settings->Exportable) $Doc->ExportField($this->settings);
						if ($this->is_closed->Exportable) $Doc->ExportField($this->is_closed);
						if ($this->mobile->Exportable) $Doc->ExportField($this->mobile);
						if ($this->tel->Exportable) $Doc->ExportField($this->tel);
						if ($this->eid->Exportable) $Doc->ExportField($this->eid);
						if ($this->weibo->Exportable) $Doc->ExportField($this->weibo);
						if ($this->desp->Exportable) $Doc->ExportField($this->desp);
						if ($this->groups->Exportable) $Doc->ExportField($this->groups);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->pinyin->Exportable) $Doc->ExportField($this->pinyin);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->password->Exportable) $Doc->ExportField($this->password);
						if ($this->avatar_small->Exportable) $Doc->ExportField($this->avatar_small);
						if ($this->avatar_normal->Exportable) $Doc->ExportField($this->avatar_normal);
						if ($this->level->Exportable) $Doc->ExportField($this->level);
						if ($this->timeline->Exportable) $Doc->ExportField($this->timeline);
						if ($this->is_closed->Exportable) $Doc->ExportField($this->is_closed);
						if ($this->mobile->Exportable) $Doc->ExportField($this->mobile);
						if ($this->tel->Exportable) $Doc->ExportField($this->tel);
						if ($this->eid->Exportable) $Doc->ExportField($this->eid);
						if ($this->weibo->Exportable) $Doc->ExportField($this->weibo);
						if ($this->groups->Exportable) $Doc->ExportField($this->groups);
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
