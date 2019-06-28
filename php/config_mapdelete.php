<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_mapinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_map_delete = NULL; // Initialize page object first

class cconfig_map_delete extends cconfig_map {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_map';

	// Page object name
	var $PageObjName = 'config_map_delete';

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

		// Table object (config_map)
		if (!isset($GLOBALS["config_map"]) || get_class($GLOBALS["config_map"]) == "cconfig_map") {
			$GLOBALS["config_map"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_map"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'config_map', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("config_maplist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Name->SetVisibility();
		$this->LV->SetVisibility();
		$this->Introduce->SetVisibility();
		$this->_Security->SetVisibility();
		$this->Hid->SetVisibility();
		$this->Basis->SetVisibility();
		$this->Monster->SetVisibility();
		$this->UP->SetVisibility();
		$this->Down->SetVisibility();
		$this->Left->SetVisibility();
		$this->Right->SetVisibility();
		$this->Consume->SetVisibility();
		$this->LV_UP->SetVisibility();

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
		global $EW_EXPORT, $config_map;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_map);
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
			$this->Page_Terminate("config_maplist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in config_map class, config_mapinfo.php

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
				$this->Page_Terminate("config_maplist.php"); // Return to list
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
		$this->unid->setDbValue($row['unid']);
		$this->u_id->setDbValue($row['u_id']);
		$this->acl_id->setDbValue($row['acl_id']);
		$this->Name->setDbValue($row['Name']);
		$this->LV->setDbValue($row['LV']);
		$this->Introduce->setDbValue($row['Introduce']);
		$this->_Security->setDbValue($row['Security']);
		$this->Hid->setDbValue($row['Hid']);
		$this->Basis->setDbValue($row['Basis']);
		$this->Monster->setDbValue($row['Monster']);
		$this->UP->setDbValue($row['UP']);
		$this->Down->setDbValue($row['Down']);
		$this->Left->setDbValue($row['Left']);
		$this->Right->setDbValue($row['Right']);
		$this->Consume->setDbValue($row['Consume']);
		$this->LV_UP->setDbValue($row['LV_UP']);
		$this->DATETIME->setDbValue($row['DATETIME']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['Name'] = NULL;
		$row['LV'] = NULL;
		$row['Introduce'] = NULL;
		$row['Security'] = NULL;
		$row['Hid'] = NULL;
		$row['Basis'] = NULL;
		$row['Monster'] = NULL;
		$row['UP'] = NULL;
		$row['Down'] = NULL;
		$row['Left'] = NULL;
		$row['Right'] = NULL;
		$row['Consume'] = NULL;
		$row['LV_UP'] = NULL;
		$row['DATETIME'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->unid->DbValue = $row['unid'];
		$this->u_id->DbValue = $row['u_id'];
		$this->acl_id->DbValue = $row['acl_id'];
		$this->Name->DbValue = $row['Name'];
		$this->LV->DbValue = $row['LV'];
		$this->Introduce->DbValue = $row['Introduce'];
		$this->_Security->DbValue = $row['Security'];
		$this->Hid->DbValue = $row['Hid'];
		$this->Basis->DbValue = $row['Basis'];
		$this->Monster->DbValue = $row['Monster'];
		$this->UP->DbValue = $row['UP'];
		$this->Down->DbValue = $row['Down'];
		$this->Left->DbValue = $row['Left'];
		$this->Right->DbValue = $row['Right'];
		$this->Consume->DbValue = $row['Consume'];
		$this->LV_UP->DbValue = $row['LV_UP'];
		$this->DATETIME->DbValue = $row['DATETIME'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// unid
		// u_id
		// acl_id
		// Name
		// LV
		// Introduce
		// Security
		// Hid
		// Basis
		// Monster
		// UP
		// Down
		// Left
		// Right
		// Consume
		// LV_UP
		// DATETIME

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Name
		$this->Name->ViewValue = $this->Name->CurrentValue;
		$this->Name->ViewCustomAttributes = "";

		// LV
		$this->LV->ViewValue = $this->LV->CurrentValue;
		$this->LV->ViewCustomAttributes = "";

		// Introduce
		$this->Introduce->ViewValue = $this->Introduce->CurrentValue;
		$this->Introduce->ViewCustomAttributes = "";

		// Security
		$this->_Security->ViewValue = $this->_Security->CurrentValue;
		$this->_Security->ViewCustomAttributes = "";

		// Hid
		$this->Hid->ViewValue = $this->Hid->CurrentValue;
		$this->Hid->ViewCustomAttributes = "";

		// Basis
		$this->Basis->ViewValue = $this->Basis->CurrentValue;
		$this->Basis->ViewCustomAttributes = "";

		// Monster
		$this->Monster->ViewValue = $this->Monster->CurrentValue;
		$this->Monster->ViewCustomAttributes = "";

		// UP
		$this->UP->ViewValue = $this->UP->CurrentValue;
		$this->UP->ViewCustomAttributes = "";

		// Down
		$this->Down->ViewValue = $this->Down->CurrentValue;
		$this->Down->ViewCustomAttributes = "";

		// Left
		$this->Left->ViewValue = $this->Left->CurrentValue;
		$this->Left->ViewCustomAttributes = "";

		// Right
		$this->Right->ViewValue = $this->Right->CurrentValue;
		$this->Right->ViewCustomAttributes = "";

		// Consume
		$this->Consume->ViewValue = $this->Consume->CurrentValue;
		$this->Consume->ViewCustomAttributes = "";

		// LV_UP
		$this->LV_UP->ViewValue = $this->LV_UP->CurrentValue;
		$this->LV_UP->ViewCustomAttributes = "";

			// Name
			$this->Name->LinkCustomAttributes = "";
			$this->Name->HrefValue = "";
			$this->Name->TooltipValue = "";

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";
			$this->LV->TooltipValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";
			$this->Introduce->TooltipValue = "";

			// Security
			$this->_Security->LinkCustomAttributes = "";
			$this->_Security->HrefValue = "";
			$this->_Security->TooltipValue = "";

			// Hid
			$this->Hid->LinkCustomAttributes = "";
			$this->Hid->HrefValue = "";
			$this->Hid->TooltipValue = "";

			// Basis
			$this->Basis->LinkCustomAttributes = "";
			$this->Basis->HrefValue = "";
			$this->Basis->TooltipValue = "";

			// Monster
			$this->Monster->LinkCustomAttributes = "";
			$this->Monster->HrefValue = "";
			$this->Monster->TooltipValue = "";

			// UP
			$this->UP->LinkCustomAttributes = "";
			$this->UP->HrefValue = "";
			$this->UP->TooltipValue = "";

			// Down
			$this->Down->LinkCustomAttributes = "";
			$this->Down->HrefValue = "";
			$this->Down->TooltipValue = "";

			// Left
			$this->Left->LinkCustomAttributes = "";
			$this->Left->HrefValue = "";
			$this->Left->TooltipValue = "";

			// Right
			$this->Right->LinkCustomAttributes = "";
			$this->Right->HrefValue = "";
			$this->Right->TooltipValue = "";

			// Consume
			$this->Consume->LinkCustomAttributes = "";
			$this->Consume->HrefValue = "";
			$this->Consume->TooltipValue = "";

			// LV_UP
			$this->LV_UP->LinkCustomAttributes = "";
			$this->LV_UP->HrefValue = "";
			$this->LV_UP->TooltipValue = "";
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
				$sThisKey .= $row['unid'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_maplist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_map_delete)) $config_map_delete = new cconfig_map_delete();

// Page init
$config_map_delete->Page_Init();

// Page main
$config_map_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_map_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fconfig_mapdelete = new ew_Form("fconfig_mapdelete", "delete");

// Form_CustomValidate event
fconfig_mapdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_mapdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $config_map_delete->ShowPageHeader(); ?>
<?php
$config_map_delete->ShowMessage();
?>
<form name="fconfig_mapdelete" id="fconfig_mapdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_map_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_map_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_map">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($config_map_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($config_map->Name->Visible) { // Name ?>
		<th class="<?php echo $config_map->Name->HeaderCellClass() ?>"><span id="elh_config_map_Name" class="config_map_Name"><?php echo $config_map->Name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->LV->Visible) { // LV ?>
		<th class="<?php echo $config_map->LV->HeaderCellClass() ?>"><span id="elh_config_map_LV" class="config_map_LV"><?php echo $config_map->LV->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->Introduce->Visible) { // Introduce ?>
		<th class="<?php echo $config_map->Introduce->HeaderCellClass() ?>"><span id="elh_config_map_Introduce" class="config_map_Introduce"><?php echo $config_map->Introduce->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->_Security->Visible) { // Security ?>
		<th class="<?php echo $config_map->_Security->HeaderCellClass() ?>"><span id="elh_config_map__Security" class="config_map__Security"><?php echo $config_map->_Security->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->Hid->Visible) { // Hid ?>
		<th class="<?php echo $config_map->Hid->HeaderCellClass() ?>"><span id="elh_config_map_Hid" class="config_map_Hid"><?php echo $config_map->Hid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->Basis->Visible) { // Basis ?>
		<th class="<?php echo $config_map->Basis->HeaderCellClass() ?>"><span id="elh_config_map_Basis" class="config_map_Basis"><?php echo $config_map->Basis->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->Monster->Visible) { // Monster ?>
		<th class="<?php echo $config_map->Monster->HeaderCellClass() ?>"><span id="elh_config_map_Monster" class="config_map_Monster"><?php echo $config_map->Monster->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->UP->Visible) { // UP ?>
		<th class="<?php echo $config_map->UP->HeaderCellClass() ?>"><span id="elh_config_map_UP" class="config_map_UP"><?php echo $config_map->UP->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->Down->Visible) { // Down ?>
		<th class="<?php echo $config_map->Down->HeaderCellClass() ?>"><span id="elh_config_map_Down" class="config_map_Down"><?php echo $config_map->Down->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->Left->Visible) { // Left ?>
		<th class="<?php echo $config_map->Left->HeaderCellClass() ?>"><span id="elh_config_map_Left" class="config_map_Left"><?php echo $config_map->Left->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->Right->Visible) { // Right ?>
		<th class="<?php echo $config_map->Right->HeaderCellClass() ?>"><span id="elh_config_map_Right" class="config_map_Right"><?php echo $config_map->Right->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->Consume->Visible) { // Consume ?>
		<th class="<?php echo $config_map->Consume->HeaderCellClass() ?>"><span id="elh_config_map_Consume" class="config_map_Consume"><?php echo $config_map->Consume->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_map->LV_UP->Visible) { // LV_UP ?>
		<th class="<?php echo $config_map->LV_UP->HeaderCellClass() ?>"><span id="elh_config_map_LV_UP" class="config_map_LV_UP"><?php echo $config_map->LV_UP->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$config_map_delete->RecCnt = 0;
$i = 0;
while (!$config_map_delete->Recordset->EOF) {
	$config_map_delete->RecCnt++;
	$config_map_delete->RowCnt++;

	// Set row properties
	$config_map->ResetAttrs();
	$config_map->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$config_map_delete->LoadRowValues($config_map_delete->Recordset);

	// Render row
	$config_map_delete->RenderRow();
?>
	<tr<?php echo $config_map->RowAttributes() ?>>
<?php if ($config_map->Name->Visible) { // Name ?>
		<td<?php echo $config_map->Name->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_Name" class="config_map_Name">
<span<?php echo $config_map->Name->ViewAttributes() ?>>
<?php echo $config_map->Name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->LV->Visible) { // LV ?>
		<td<?php echo $config_map->LV->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_LV" class="config_map_LV">
<span<?php echo $config_map->LV->ViewAttributes() ?>>
<?php echo $config_map->LV->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->Introduce->Visible) { // Introduce ?>
		<td<?php echo $config_map->Introduce->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_Introduce" class="config_map_Introduce">
<span<?php echo $config_map->Introduce->ViewAttributes() ?>>
<?php echo $config_map->Introduce->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->_Security->Visible) { // Security ?>
		<td<?php echo $config_map->_Security->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map__Security" class="config_map__Security">
<span<?php echo $config_map->_Security->ViewAttributes() ?>>
<?php echo $config_map->_Security->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->Hid->Visible) { // Hid ?>
		<td<?php echo $config_map->Hid->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_Hid" class="config_map_Hid">
<span<?php echo $config_map->Hid->ViewAttributes() ?>>
<?php echo $config_map->Hid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->Basis->Visible) { // Basis ?>
		<td<?php echo $config_map->Basis->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_Basis" class="config_map_Basis">
<span<?php echo $config_map->Basis->ViewAttributes() ?>>
<?php echo $config_map->Basis->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->Monster->Visible) { // Monster ?>
		<td<?php echo $config_map->Monster->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_Monster" class="config_map_Monster">
<span<?php echo $config_map->Monster->ViewAttributes() ?>>
<?php echo $config_map->Monster->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->UP->Visible) { // UP ?>
		<td<?php echo $config_map->UP->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_UP" class="config_map_UP">
<span<?php echo $config_map->UP->ViewAttributes() ?>>
<?php echo $config_map->UP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->Down->Visible) { // Down ?>
		<td<?php echo $config_map->Down->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_Down" class="config_map_Down">
<span<?php echo $config_map->Down->ViewAttributes() ?>>
<?php echo $config_map->Down->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->Left->Visible) { // Left ?>
		<td<?php echo $config_map->Left->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_Left" class="config_map_Left">
<span<?php echo $config_map->Left->ViewAttributes() ?>>
<?php echo $config_map->Left->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->Right->Visible) { // Right ?>
		<td<?php echo $config_map->Right->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_Right" class="config_map_Right">
<span<?php echo $config_map->Right->ViewAttributes() ?>>
<?php echo $config_map->Right->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->Consume->Visible) { // Consume ?>
		<td<?php echo $config_map->Consume->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_Consume" class="config_map_Consume">
<span<?php echo $config_map->Consume->ViewAttributes() ?>>
<?php echo $config_map->Consume->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_map->LV_UP->Visible) { // LV_UP ?>
		<td<?php echo $config_map->LV_UP->CellAttributes() ?>>
<span id="el<?php echo $config_map_delete->RowCnt ?>_config_map_LV_UP" class="config_map_LV_UP">
<span<?php echo $config_map->LV_UP->ViewAttributes() ?>>
<?php echo $config_map->LV_UP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$config_map_delete->Recordset->MoveNext();
}
$config_map_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $config_map_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fconfig_mapdelete.Init();
</script>
<?php
$config_map_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_map_delete->Page_Terminate();
?>
