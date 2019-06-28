<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$ksdb_user_delete = NULL; // Initialize page object first

class cksdb_user_delete extends cksdb_user {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'ksdb_user';

	// Page object name
	var $PageObjName = 'ksdb_user_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (ksdb_user)
		if (!isset($GLOBALS["ksdb_user"]) || get_class($GLOBALS["ksdb_user"]) == "cksdb_user") {
			$GLOBALS["ksdb_user"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ksdb_user"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ksdb_user', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (ksdb_user)
		if (!isset($UserTable)) {
			$UserTable = new cksdb_user();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("ksdb_userlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->name->SetVisibility();
		$this->pinyin->SetVisibility();
		$this->_email->SetVisibility();
		$this->avatar_small->SetVisibility();
		$this->avatar_normal->SetVisibility();
		$this->level->SetVisibility();
		$this->timeline->SetVisibility();
		$this->is_closed->SetVisibility();
		$this->mobile->SetVisibility();
		$this->tel->SetVisibility();
		$this->eid->SetVisibility();
		$this->weibo->SetVisibility();
		$this->groups->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $ksdb_user;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ksdb_user);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("ksdb_userlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in ksdb_user class, ksdb_userinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("ksdb_userlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->id->setDbValue($row['id']);
		$this->name->setDbValue($row['name']);
		$this->pinyin->setDbValue($row['pinyin']);
		$this->_email->setDbValue($row['email']);
		$this->password->setDbValue($row['password']);
		$this->avatar_small->setDbValue($row['avatar_small']);
		$this->avatar_normal->setDbValue($row['avatar_normal']);
		$this->level->setDbValue($row['level']);
		$this->timeline->setDbValue($row['timeline']);
		$this->settings->setDbValue($row['settings']);
		$this->is_closed->setDbValue($row['is_closed']);
		$this->mobile->setDbValue($row['mobile']);
		$this->tel->setDbValue($row['tel']);
		$this->eid->setDbValue($row['eid']);
		$this->weibo->setDbValue($row['weibo']);
		$this->desp->setDbValue($row['desp']);
		$this->groups->setDbValue($row['groups']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['name'] = NULL;
		$row['pinyin'] = NULL;
		$row['email'] = NULL;
		$row['password'] = NULL;
		$row['avatar_small'] = NULL;
		$row['avatar_normal'] = NULL;
		$row['level'] = NULL;
		$row['timeline'] = NULL;
		$row['settings'] = NULL;
		$row['is_closed'] = NULL;
		$row['mobile'] = NULL;
		$row['tel'] = NULL;
		$row['eid'] = NULL;
		$row['weibo'] = NULL;
		$row['desp'] = NULL;
		$row['groups'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->name->DbValue = $row['name'];
		$this->pinyin->DbValue = $row['pinyin'];
		$this->_email->DbValue = $row['email'];
		$this->password->DbValue = $row['password'];
		$this->avatar_small->DbValue = $row['avatar_small'];
		$this->avatar_normal->DbValue = $row['avatar_normal'];
		$this->level->DbValue = $row['level'];
		$this->timeline->DbValue = $row['timeline'];
		$this->settings->DbValue = $row['settings'];
		$this->is_closed->DbValue = $row['is_closed'];
		$this->mobile->DbValue = $row['mobile'];
		$this->tel->DbValue = $row['tel'];
		$this->eid->DbValue = $row['eid'];
		$this->weibo->DbValue = $row['weibo'];
		$this->desp->DbValue = $row['desp'];
		$this->groups->DbValue = $row['groups'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// name
		// pinyin
		// email
		// password

		$this->password->CellCssStyle = "white-space: nowrap;";

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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// groups
			$this->groups->LinkCustomAttributes = "";
			$this->groups->HrefValue = "";
			$this->groups->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ksdb_userlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($ksdb_user_delete)) $ksdb_user_delete = new cksdb_user_delete();

// Page init
$ksdb_user_delete->Page_Init();

// Page main
$ksdb_user_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ksdb_user_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fksdb_userdelete = new ew_Form("fksdb_userdelete", "delete");

// Form_CustomValidate event
fksdb_userdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fksdb_userdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $ksdb_user_delete->ShowPageHeader(); ?>
<?php
$ksdb_user_delete->ShowMessage();
?>
<form name="fksdb_userdelete" id="fksdb_userdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ksdb_user_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ksdb_user_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ksdb_user">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ksdb_user_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($ksdb_user->id->Visible) { // id ?>
		<th class="<?php echo $ksdb_user->id->HeaderCellClass() ?>"><span id="elh_ksdb_user_id" class="ksdb_user_id"><?php echo $ksdb_user->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->name->Visible) { // name ?>
		<th class="<?php echo $ksdb_user->name->HeaderCellClass() ?>"><span id="elh_ksdb_user_name" class="ksdb_user_name"><?php echo $ksdb_user->name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->pinyin->Visible) { // pinyin ?>
		<th class="<?php echo $ksdb_user->pinyin->HeaderCellClass() ?>"><span id="elh_ksdb_user_pinyin" class="ksdb_user_pinyin"><?php echo $ksdb_user->pinyin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->_email->Visible) { // email ?>
		<th class="<?php echo $ksdb_user->_email->HeaderCellClass() ?>"><span id="elh_ksdb_user__email" class="ksdb_user__email"><?php echo $ksdb_user->_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->avatar_small->Visible) { // avatar_small ?>
		<th class="<?php echo $ksdb_user->avatar_small->HeaderCellClass() ?>"><span id="elh_ksdb_user_avatar_small" class="ksdb_user_avatar_small"><?php echo $ksdb_user->avatar_small->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->avatar_normal->Visible) { // avatar_normal ?>
		<th class="<?php echo $ksdb_user->avatar_normal->HeaderCellClass() ?>"><span id="elh_ksdb_user_avatar_normal" class="ksdb_user_avatar_normal"><?php echo $ksdb_user->avatar_normal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->level->Visible) { // level ?>
		<th class="<?php echo $ksdb_user->level->HeaderCellClass() ?>"><span id="elh_ksdb_user_level" class="ksdb_user_level"><?php echo $ksdb_user->level->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->timeline->Visible) { // timeline ?>
		<th class="<?php echo $ksdb_user->timeline->HeaderCellClass() ?>"><span id="elh_ksdb_user_timeline" class="ksdb_user_timeline"><?php echo $ksdb_user->timeline->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->is_closed->Visible) { // is_closed ?>
		<th class="<?php echo $ksdb_user->is_closed->HeaderCellClass() ?>"><span id="elh_ksdb_user_is_closed" class="ksdb_user_is_closed"><?php echo $ksdb_user->is_closed->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->mobile->Visible) { // mobile ?>
		<th class="<?php echo $ksdb_user->mobile->HeaderCellClass() ?>"><span id="elh_ksdb_user_mobile" class="ksdb_user_mobile"><?php echo $ksdb_user->mobile->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->tel->Visible) { // tel ?>
		<th class="<?php echo $ksdb_user->tel->HeaderCellClass() ?>"><span id="elh_ksdb_user_tel" class="ksdb_user_tel"><?php echo $ksdb_user->tel->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->eid->Visible) { // eid ?>
		<th class="<?php echo $ksdb_user->eid->HeaderCellClass() ?>"><span id="elh_ksdb_user_eid" class="ksdb_user_eid"><?php echo $ksdb_user->eid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->weibo->Visible) { // weibo ?>
		<th class="<?php echo $ksdb_user->weibo->HeaderCellClass() ?>"><span id="elh_ksdb_user_weibo" class="ksdb_user_weibo"><?php echo $ksdb_user->weibo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ksdb_user->groups->Visible) { // groups ?>
		<th class="<?php echo $ksdb_user->groups->HeaderCellClass() ?>"><span id="elh_ksdb_user_groups" class="ksdb_user_groups"><?php echo $ksdb_user->groups->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$ksdb_user_delete->RecCnt = 0;
$i = 0;
while (!$ksdb_user_delete->Recordset->EOF) {
	$ksdb_user_delete->RecCnt++;
	$ksdb_user_delete->RowCnt++;

	// Set row properties
	$ksdb_user->ResetAttrs();
	$ksdb_user->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ksdb_user_delete->LoadRowValues($ksdb_user_delete->Recordset);

	// Render row
	$ksdb_user_delete->RenderRow();
?>
	<tr<?php echo $ksdb_user->RowAttributes() ?>>
<?php if ($ksdb_user->id->Visible) { // id ?>
		<td<?php echo $ksdb_user->id->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_id" class="ksdb_user_id">
<span<?php echo $ksdb_user->id->ViewAttributes() ?>>
<?php echo $ksdb_user->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->name->Visible) { // name ?>
		<td<?php echo $ksdb_user->name->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_name" class="ksdb_user_name">
<span<?php echo $ksdb_user->name->ViewAttributes() ?>>
<?php echo $ksdb_user->name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->pinyin->Visible) { // pinyin ?>
		<td<?php echo $ksdb_user->pinyin->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_pinyin" class="ksdb_user_pinyin">
<span<?php echo $ksdb_user->pinyin->ViewAttributes() ?>>
<?php echo $ksdb_user->pinyin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->_email->Visible) { // email ?>
		<td<?php echo $ksdb_user->_email->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user__email" class="ksdb_user__email">
<span<?php echo $ksdb_user->_email->ViewAttributes() ?>>
<?php echo $ksdb_user->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->avatar_small->Visible) { // avatar_small ?>
		<td<?php echo $ksdb_user->avatar_small->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_avatar_small" class="ksdb_user_avatar_small">
<span<?php echo $ksdb_user->avatar_small->ViewAttributes() ?>>
<?php echo $ksdb_user->avatar_small->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->avatar_normal->Visible) { // avatar_normal ?>
		<td<?php echo $ksdb_user->avatar_normal->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_avatar_normal" class="ksdb_user_avatar_normal">
<span<?php echo $ksdb_user->avatar_normal->ViewAttributes() ?>>
<?php echo $ksdb_user->avatar_normal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->level->Visible) { // level ?>
		<td<?php echo $ksdb_user->level->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_level" class="ksdb_user_level">
<span<?php echo $ksdb_user->level->ViewAttributes() ?>>
<?php echo $ksdb_user->level->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->timeline->Visible) { // timeline ?>
		<td<?php echo $ksdb_user->timeline->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_timeline" class="ksdb_user_timeline">
<span<?php echo $ksdb_user->timeline->ViewAttributes() ?>>
<?php echo $ksdb_user->timeline->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->is_closed->Visible) { // is_closed ?>
		<td<?php echo $ksdb_user->is_closed->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_is_closed" class="ksdb_user_is_closed">
<span<?php echo $ksdb_user->is_closed->ViewAttributes() ?>>
<?php echo $ksdb_user->is_closed->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->mobile->Visible) { // mobile ?>
		<td<?php echo $ksdb_user->mobile->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_mobile" class="ksdb_user_mobile">
<span<?php echo $ksdb_user->mobile->ViewAttributes() ?>>
<?php echo $ksdb_user->mobile->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->tel->Visible) { // tel ?>
		<td<?php echo $ksdb_user->tel->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_tel" class="ksdb_user_tel">
<span<?php echo $ksdb_user->tel->ViewAttributes() ?>>
<?php echo $ksdb_user->tel->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->eid->Visible) { // eid ?>
		<td<?php echo $ksdb_user->eid->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_eid" class="ksdb_user_eid">
<span<?php echo $ksdb_user->eid->ViewAttributes() ?>>
<?php echo $ksdb_user->eid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->weibo->Visible) { // weibo ?>
		<td<?php echo $ksdb_user->weibo->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_weibo" class="ksdb_user_weibo">
<span<?php echo $ksdb_user->weibo->ViewAttributes() ?>>
<?php echo $ksdb_user->weibo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ksdb_user->groups->Visible) { // groups ?>
		<td<?php echo $ksdb_user->groups->CellAttributes() ?>>
<span id="el<?php echo $ksdb_user_delete->RowCnt ?>_ksdb_user_groups" class="ksdb_user_groups">
<span<?php echo $ksdb_user->groups->ViewAttributes() ?>>
<?php echo $ksdb_user->groups->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$ksdb_user_delete->Recordset->MoveNext();
}
$ksdb_user_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ksdb_user_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fksdb_userdelete.Init();
</script>
<?php
$ksdb_user_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ksdb_user_delete->Page_Terminate();
?>
