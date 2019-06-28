<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_unioninfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_union_edit = NULL; // Initialize page object first

class cconfig_union_edit extends cconfig_union {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_union';

	// Page object name
	var $PageObjName = 'config_union_edit';

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

		// Table object (config_union)
		if (!isset($GLOBALS["config_union"]) || get_class($GLOBALS["config_union"]) == "cconfig_union") {
			$GLOBALS["config_union"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_union"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'config_union', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("config_unionlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->u_id->SetVisibility();
		$this->acl_id->SetVisibility();
		$this->ID->SetVisibility();
		$this->LV->SetVisibility();
		$this->EXP->SetVisibility();
		$this->NeedEXP->SetVisibility();
		$this->CDR->SetVisibility();
		$this->LimitLV->SetVisibility();
		$this->Data->SetVisibility();
		$this->DATETIME->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $config_union;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_union);
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "config_unionview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_unid")) {
				$this->unid->setFormValue($objForm->GetValue("x_unid"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["unid"])) {
				$this->unid->setQueryStringValue($_GET["unid"]);
				$loadByQuery = TRUE;
			} else {
				$this->unid->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("config_unionlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "config_unionlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->u_id->FldIsDetailKey) {
			$this->u_id->setFormValue($objForm->GetValue("x_u_id"));
		}
		if (!$this->acl_id->FldIsDetailKey) {
			$this->acl_id->setFormValue($objForm->GetValue("x_acl_id"));
		}
		if (!$this->ID->FldIsDetailKey) {
			$this->ID->setFormValue($objForm->GetValue("x_ID"));
		}
		if (!$this->LV->FldIsDetailKey) {
			$this->LV->setFormValue($objForm->GetValue("x_LV"));
		}
		if (!$this->EXP->FldIsDetailKey) {
			$this->EXP->setFormValue($objForm->GetValue("x_EXP"));
		}
		if (!$this->NeedEXP->FldIsDetailKey) {
			$this->NeedEXP->setFormValue($objForm->GetValue("x_NeedEXP"));
		}
		if (!$this->CDR->FldIsDetailKey) {
			$this->CDR->setFormValue($objForm->GetValue("x_CDR"));
		}
		if (!$this->LimitLV->FldIsDetailKey) {
			$this->LimitLV->setFormValue($objForm->GetValue("x_LimitLV"));
		}
		if (!$this->Data->FldIsDetailKey) {
			$this->Data->setFormValue($objForm->GetValue("x_Data"));
		}
		if (!$this->DATETIME->FldIsDetailKey) {
			$this->DATETIME->setFormValue($objForm->GetValue("x_DATETIME"));
			$this->DATETIME->CurrentValue = ew_UnFormatDateTime($this->DATETIME->CurrentValue, 0);
		}
		if (!$this->unid->FldIsDetailKey)
			$this->unid->setFormValue($objForm->GetValue("x_unid"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->unid->CurrentValue = $this->unid->FormValue;
		$this->u_id->CurrentValue = $this->u_id->FormValue;
		$this->acl_id->CurrentValue = $this->acl_id->FormValue;
		$this->ID->CurrentValue = $this->ID->FormValue;
		$this->LV->CurrentValue = $this->LV->FormValue;
		$this->EXP->CurrentValue = $this->EXP->FormValue;
		$this->NeedEXP->CurrentValue = $this->NeedEXP->FormValue;
		$this->CDR->CurrentValue = $this->CDR->FormValue;
		$this->LimitLV->CurrentValue = $this->LimitLV->FormValue;
		$this->Data->CurrentValue = $this->Data->FormValue;
		$this->DATETIME->CurrentValue = $this->DATETIME->FormValue;
		$this->DATETIME->CurrentValue = ew_UnFormatDateTime($this->DATETIME->CurrentValue, 0);
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
		$this->ID->setDbValue($row['ID']);
		$this->LV->setDbValue($row['LV']);
		$this->EXP->setDbValue($row['EXP']);
		$this->NeedEXP->setDbValue($row['NeedEXP']);
		$this->CDR->setDbValue($row['CDR']);
		$this->LimitLV->setDbValue($row['LimitLV']);
		$this->Data->setDbValue($row['Data']);
		$this->DATETIME->setDbValue($row['DATETIME']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['ID'] = NULL;
		$row['LV'] = NULL;
		$row['EXP'] = NULL;
		$row['NeedEXP'] = NULL;
		$row['CDR'] = NULL;
		$row['LimitLV'] = NULL;
		$row['Data'] = NULL;
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
		$this->ID->DbValue = $row['ID'];
		$this->LV->DbValue = $row['LV'];
		$this->EXP->DbValue = $row['EXP'];
		$this->NeedEXP->DbValue = $row['NeedEXP'];
		$this->CDR->DbValue = $row['CDR'];
		$this->LimitLV->DbValue = $row['LimitLV'];
		$this->Data->DbValue = $row['Data'];
		$this->DATETIME->DbValue = $row['DATETIME'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("unid")) <> "")
			$this->unid->CurrentValue = $this->getKey("unid"); // unid
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
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
		// ID
		// LV
		// EXP
		// NeedEXP
		// CDR
		// LimitLV
		// Data
		// DATETIME

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// unid
		$this->unid->ViewValue = $this->unid->CurrentValue;
		$this->unid->ViewCustomAttributes = "";

		// u_id
		$this->u_id->ViewValue = $this->u_id->CurrentValue;
		$this->u_id->ViewCustomAttributes = "";

		// acl_id
		$this->acl_id->ViewValue = $this->acl_id->CurrentValue;
		$this->acl_id->ViewCustomAttributes = "";

		// ID
		$this->ID->ViewValue = $this->ID->CurrentValue;
		$this->ID->ViewCustomAttributes = "";

		// LV
		$this->LV->ViewValue = $this->LV->CurrentValue;
		$this->LV->ViewCustomAttributes = "";

		// EXP
		$this->EXP->ViewValue = $this->EXP->CurrentValue;
		$this->EXP->ViewCustomAttributes = "";

		// NeedEXP
		$this->NeedEXP->ViewValue = $this->NeedEXP->CurrentValue;
		$this->NeedEXP->ViewCustomAttributes = "";

		// CDR
		$this->CDR->ViewValue = $this->CDR->CurrentValue;
		$this->CDR->ViewCustomAttributes = "";

		// LimitLV
		$this->LimitLV->ViewValue = $this->LimitLV->CurrentValue;
		$this->LimitLV->ViewCustomAttributes = "";

		// Data
		$this->Data->ViewValue = $this->Data->CurrentValue;
		$this->Data->ViewCustomAttributes = "";

		// DATETIME
		$this->DATETIME->ViewValue = $this->DATETIME->CurrentValue;
		$this->DATETIME->ViewValue = ew_FormatDateTime($this->DATETIME->ViewValue, 0);
		$this->DATETIME->ViewCustomAttributes = "";

			// u_id
			$this->u_id->LinkCustomAttributes = "";
			$this->u_id->HrefValue = "";
			$this->u_id->TooltipValue = "";

			// acl_id
			$this->acl_id->LinkCustomAttributes = "";
			$this->acl_id->HrefValue = "";
			$this->acl_id->TooltipValue = "";

			// ID
			$this->ID->LinkCustomAttributes = "";
			$this->ID->HrefValue = "";
			$this->ID->TooltipValue = "";

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";
			$this->LV->TooltipValue = "";

			// EXP
			$this->EXP->LinkCustomAttributes = "";
			$this->EXP->HrefValue = "";
			$this->EXP->TooltipValue = "";

			// NeedEXP
			$this->NeedEXP->LinkCustomAttributes = "";
			$this->NeedEXP->HrefValue = "";
			$this->NeedEXP->TooltipValue = "";

			// CDR
			$this->CDR->LinkCustomAttributes = "";
			$this->CDR->HrefValue = "";
			$this->CDR->TooltipValue = "";

			// LimitLV
			$this->LimitLV->LinkCustomAttributes = "";
			$this->LimitLV->HrefValue = "";
			$this->LimitLV->TooltipValue = "";

			// Data
			$this->Data->LinkCustomAttributes = "";
			$this->Data->HrefValue = "";
			$this->Data->TooltipValue = "";

			// DATETIME
			$this->DATETIME->LinkCustomAttributes = "";
			$this->DATETIME->HrefValue = "";
			$this->DATETIME->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// u_id
			$this->u_id->EditAttrs["class"] = "form-control";
			$this->u_id->EditCustomAttributes = "";
			$this->u_id->EditValue = ew_HtmlEncode($this->u_id->CurrentValue);
			$this->u_id->PlaceHolder = ew_RemoveHtml($this->u_id->FldCaption());

			// acl_id
			$this->acl_id->EditAttrs["class"] = "form-control";
			$this->acl_id->EditCustomAttributes = "";
			$this->acl_id->EditValue = ew_HtmlEncode($this->acl_id->CurrentValue);
			$this->acl_id->PlaceHolder = ew_RemoveHtml($this->acl_id->FldCaption());

			// ID
			$this->ID->EditAttrs["class"] = "form-control";
			$this->ID->EditCustomAttributes = "";
			$this->ID->EditValue = ew_HtmlEncode($this->ID->CurrentValue);
			$this->ID->PlaceHolder = ew_RemoveHtml($this->ID->FldCaption());

			// LV
			$this->LV->EditAttrs["class"] = "form-control";
			$this->LV->EditCustomAttributes = "";
			$this->LV->EditValue = ew_HtmlEncode($this->LV->CurrentValue);
			$this->LV->PlaceHolder = ew_RemoveHtml($this->LV->FldCaption());

			// EXP
			$this->EXP->EditAttrs["class"] = "form-control";
			$this->EXP->EditCustomAttributes = "";
			$this->EXP->EditValue = ew_HtmlEncode($this->EXP->CurrentValue);
			$this->EXP->PlaceHolder = ew_RemoveHtml($this->EXP->FldCaption());

			// NeedEXP
			$this->NeedEXP->EditAttrs["class"] = "form-control";
			$this->NeedEXP->EditCustomAttributes = "";
			$this->NeedEXP->EditValue = ew_HtmlEncode($this->NeedEXP->CurrentValue);
			$this->NeedEXP->PlaceHolder = ew_RemoveHtml($this->NeedEXP->FldCaption());

			// CDR
			$this->CDR->EditAttrs["class"] = "form-control";
			$this->CDR->EditCustomAttributes = "";
			$this->CDR->EditValue = ew_HtmlEncode($this->CDR->CurrentValue);
			$this->CDR->PlaceHolder = ew_RemoveHtml($this->CDR->FldCaption());

			// LimitLV
			$this->LimitLV->EditAttrs["class"] = "form-control";
			$this->LimitLV->EditCustomAttributes = "";
			$this->LimitLV->EditValue = ew_HtmlEncode($this->LimitLV->CurrentValue);
			$this->LimitLV->PlaceHolder = ew_RemoveHtml($this->LimitLV->FldCaption());

			// Data
			$this->Data->EditAttrs["class"] = "form-control";
			$this->Data->EditCustomAttributes = "";
			$this->Data->EditValue = ew_HtmlEncode($this->Data->CurrentValue);
			$this->Data->PlaceHolder = ew_RemoveHtml($this->Data->FldCaption());

			// DATETIME
			$this->DATETIME->EditAttrs["class"] = "form-control";
			$this->DATETIME->EditCustomAttributes = "";
			$this->DATETIME->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->DATETIME->CurrentValue, 8));
			$this->DATETIME->PlaceHolder = ew_RemoveHtml($this->DATETIME->FldCaption());

			// Edit refer script
			// u_id

			$this->u_id->LinkCustomAttributes = "";
			$this->u_id->HrefValue = "";

			// acl_id
			$this->acl_id->LinkCustomAttributes = "";
			$this->acl_id->HrefValue = "";

			// ID
			$this->ID->LinkCustomAttributes = "";
			$this->ID->HrefValue = "";

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";

			// EXP
			$this->EXP->LinkCustomAttributes = "";
			$this->EXP->HrefValue = "";

			// NeedEXP
			$this->NeedEXP->LinkCustomAttributes = "";
			$this->NeedEXP->HrefValue = "";

			// CDR
			$this->CDR->LinkCustomAttributes = "";
			$this->CDR->HrefValue = "";

			// LimitLV
			$this->LimitLV->LinkCustomAttributes = "";
			$this->LimitLV->HrefValue = "";

			// Data
			$this->Data->LinkCustomAttributes = "";
			$this->Data->HrefValue = "";

			// DATETIME
			$this->DATETIME->LinkCustomAttributes = "";
			$this->DATETIME->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->u_id->FldIsDetailKey && !is_null($this->u_id->FormValue) && $this->u_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->u_id->FldCaption(), $this->u_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->u_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->u_id->FldErrMsg());
		}
		if (!$this->acl_id->FldIsDetailKey && !is_null($this->acl_id->FormValue) && $this->acl_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->acl_id->FldCaption(), $this->acl_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->acl_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->acl_id->FldErrMsg());
		}
		if (!$this->ID->FldIsDetailKey && !is_null($this->ID->FormValue) && $this->ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ID->FldCaption(), $this->ID->ReqErrMsg));
		}
		if (!$this->LV->FldIsDetailKey && !is_null($this->LV->FormValue) && $this->LV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->LV->FldCaption(), $this->LV->ReqErrMsg));
		}
		if (!$this->EXP->FldIsDetailKey && !is_null($this->EXP->FormValue) && $this->EXP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->EXP->FldCaption(), $this->EXP->ReqErrMsg));
		}
		if (!$this->NeedEXP->FldIsDetailKey && !is_null($this->NeedEXP->FormValue) && $this->NeedEXP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NeedEXP->FldCaption(), $this->NeedEXP->ReqErrMsg));
		}
		if (!$this->CDR->FldIsDetailKey && !is_null($this->CDR->FormValue) && $this->CDR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->CDR->FldCaption(), $this->CDR->ReqErrMsg));
		}
		if (!$this->LimitLV->FldIsDetailKey && !is_null($this->LimitLV->FormValue) && $this->LimitLV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->LimitLV->FldCaption(), $this->LimitLV->ReqErrMsg));
		}
		if (!$this->Data->FldIsDetailKey && !is_null($this->Data->FormValue) && $this->Data->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Data->FldCaption(), $this->Data->ReqErrMsg));
		}
		if (!$this->DATETIME->FldIsDetailKey && !is_null($this->DATETIME->FormValue) && $this->DATETIME->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->DATETIME->FldCaption(), $this->DATETIME->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->DATETIME->FormValue)) {
			ew_AddMessage($gsFormError, $this->DATETIME->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// u_id
			$this->u_id->SetDbValueDef($rsnew, $this->u_id->CurrentValue, 0, $this->u_id->ReadOnly);

			// acl_id
			$this->acl_id->SetDbValueDef($rsnew, $this->acl_id->CurrentValue, 0, $this->acl_id->ReadOnly);

			// ID
			$this->ID->SetDbValueDef($rsnew, $this->ID->CurrentValue, "", $this->ID->ReadOnly);

			// LV
			$this->LV->SetDbValueDef($rsnew, $this->LV->CurrentValue, "", $this->LV->ReadOnly);

			// EXP
			$this->EXP->SetDbValueDef($rsnew, $this->EXP->CurrentValue, "", $this->EXP->ReadOnly);

			// NeedEXP
			$this->NeedEXP->SetDbValueDef($rsnew, $this->NeedEXP->CurrentValue, "", $this->NeedEXP->ReadOnly);

			// CDR
			$this->CDR->SetDbValueDef($rsnew, $this->CDR->CurrentValue, "", $this->CDR->ReadOnly);

			// LimitLV
			$this->LimitLV->SetDbValueDef($rsnew, $this->LimitLV->CurrentValue, "", $this->LimitLV->ReadOnly);

			// Data
			$this->Data->SetDbValueDef($rsnew, $this->Data->CurrentValue, "", $this->Data->ReadOnly);

			// DATETIME
			$this->DATETIME->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->DATETIME->CurrentValue, 0), ew_CurrentDate(), $this->DATETIME->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_unionlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($config_union_edit)) $config_union_edit = new cconfig_union_edit();

// Page init
$config_union_edit->Page_Init();

// Page main
$config_union_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_union_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fconfig_unionedit = new ew_Form("fconfig_unionedit", "edit");

// Validate form
fconfig_unionedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_union->u_id->FldCaption(), $config_union->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_union->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_union->acl_id->FldCaption(), $config_union->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_union->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_union->ID->FldCaption(), $config_union->ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_union->LV->FldCaption(), $config_union->LV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_EXP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_union->EXP->FldCaption(), $config_union->EXP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NeedEXP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_union->NeedEXP->FldCaption(), $config_union->NeedEXP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_CDR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_union->CDR->FldCaption(), $config_union->CDR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LimitLV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_union->LimitLV->FldCaption(), $config_union->LimitLV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Data");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_union->Data->FldCaption(), $config_union->Data->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_union->DATETIME->FldCaption(), $config_union->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_union->DATETIME->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fconfig_unionedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_unionedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $config_union_edit->ShowPageHeader(); ?>
<?php
$config_union_edit->ShowMessage();
?>
<form name="fconfig_unionedit" id="fconfig_unionedit" class="<?php echo $config_union_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_union_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_union_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_union">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($config_union_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($config_union->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_config_union_u_id" for="x_u_id" class="<?php echo $config_union_edit->LeftColumnClass ?>"><?php echo $config_union->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_union_edit->RightColumnClass ?>"><div<?php echo $config_union->u_id->CellAttributes() ?>>
<span id="el_config_union_u_id">
<input type="text" data-table="config_union" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_union->u_id->getPlaceHolder()) ?>" value="<?php echo $config_union->u_id->EditValue ?>"<?php echo $config_union->u_id->EditAttributes() ?>>
</span>
<?php echo $config_union->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_union->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_config_union_acl_id" for="x_acl_id" class="<?php echo $config_union_edit->LeftColumnClass ?>"><?php echo $config_union->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_union_edit->RightColumnClass ?>"><div<?php echo $config_union->acl_id->CellAttributes() ?>>
<span id="el_config_union_acl_id">
<input type="text" data-table="config_union" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_union->acl_id->getPlaceHolder()) ?>" value="<?php echo $config_union->acl_id->EditValue ?>"<?php echo $config_union->acl_id->EditAttributes() ?>>
</span>
<?php echo $config_union->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_union->ID->Visible) { // ID ?>
	<div id="r_ID" class="form-group">
		<label id="elh_config_union_ID" for="x_ID" class="<?php echo $config_union_edit->LeftColumnClass ?>"><?php echo $config_union->ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_union_edit->RightColumnClass ?>"><div<?php echo $config_union->ID->CellAttributes() ?>>
<span id="el_config_union_ID">
<textarea data-table="config_union" data-field="x_ID" name="x_ID" id="x_ID" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_union->ID->getPlaceHolder()) ?>"<?php echo $config_union->ID->EditAttributes() ?>><?php echo $config_union->ID->EditValue ?></textarea>
</span>
<?php echo $config_union->ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_union->LV->Visible) { // LV ?>
	<div id="r_LV" class="form-group">
		<label id="elh_config_union_LV" for="x_LV" class="<?php echo $config_union_edit->LeftColumnClass ?>"><?php echo $config_union->LV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_union_edit->RightColumnClass ?>"><div<?php echo $config_union->LV->CellAttributes() ?>>
<span id="el_config_union_LV">
<textarea data-table="config_union" data-field="x_LV" name="x_LV" id="x_LV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_union->LV->getPlaceHolder()) ?>"<?php echo $config_union->LV->EditAttributes() ?>><?php echo $config_union->LV->EditValue ?></textarea>
</span>
<?php echo $config_union->LV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_union->EXP->Visible) { // EXP ?>
	<div id="r_EXP" class="form-group">
		<label id="elh_config_union_EXP" for="x_EXP" class="<?php echo $config_union_edit->LeftColumnClass ?>"><?php echo $config_union->EXP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_union_edit->RightColumnClass ?>"><div<?php echo $config_union->EXP->CellAttributes() ?>>
<span id="el_config_union_EXP">
<textarea data-table="config_union" data-field="x_EXP" name="x_EXP" id="x_EXP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_union->EXP->getPlaceHolder()) ?>"<?php echo $config_union->EXP->EditAttributes() ?>><?php echo $config_union->EXP->EditValue ?></textarea>
</span>
<?php echo $config_union->EXP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_union->NeedEXP->Visible) { // NeedEXP ?>
	<div id="r_NeedEXP" class="form-group">
		<label id="elh_config_union_NeedEXP" for="x_NeedEXP" class="<?php echo $config_union_edit->LeftColumnClass ?>"><?php echo $config_union->NeedEXP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_union_edit->RightColumnClass ?>"><div<?php echo $config_union->NeedEXP->CellAttributes() ?>>
<span id="el_config_union_NeedEXP">
<textarea data-table="config_union" data-field="x_NeedEXP" name="x_NeedEXP" id="x_NeedEXP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_union->NeedEXP->getPlaceHolder()) ?>"<?php echo $config_union->NeedEXP->EditAttributes() ?>><?php echo $config_union->NeedEXP->EditValue ?></textarea>
</span>
<?php echo $config_union->NeedEXP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_union->CDR->Visible) { // CDR ?>
	<div id="r_CDR" class="form-group">
		<label id="elh_config_union_CDR" for="x_CDR" class="<?php echo $config_union_edit->LeftColumnClass ?>"><?php echo $config_union->CDR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_union_edit->RightColumnClass ?>"><div<?php echo $config_union->CDR->CellAttributes() ?>>
<span id="el_config_union_CDR">
<textarea data-table="config_union" data-field="x_CDR" name="x_CDR" id="x_CDR" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_union->CDR->getPlaceHolder()) ?>"<?php echo $config_union->CDR->EditAttributes() ?>><?php echo $config_union->CDR->EditValue ?></textarea>
</span>
<?php echo $config_union->CDR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_union->LimitLV->Visible) { // LimitLV ?>
	<div id="r_LimitLV" class="form-group">
		<label id="elh_config_union_LimitLV" for="x_LimitLV" class="<?php echo $config_union_edit->LeftColumnClass ?>"><?php echo $config_union->LimitLV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_union_edit->RightColumnClass ?>"><div<?php echo $config_union->LimitLV->CellAttributes() ?>>
<span id="el_config_union_LimitLV">
<textarea data-table="config_union" data-field="x_LimitLV" name="x_LimitLV" id="x_LimitLV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_union->LimitLV->getPlaceHolder()) ?>"<?php echo $config_union->LimitLV->EditAttributes() ?>><?php echo $config_union->LimitLV->EditValue ?></textarea>
</span>
<?php echo $config_union->LimitLV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_union->Data->Visible) { // Data ?>
	<div id="r_Data" class="form-group">
		<label id="elh_config_union_Data" for="x_Data" class="<?php echo $config_union_edit->LeftColumnClass ?>"><?php echo $config_union->Data->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_union_edit->RightColumnClass ?>"><div<?php echo $config_union->Data->CellAttributes() ?>>
<span id="el_config_union_Data">
<textarea data-table="config_union" data-field="x_Data" name="x_Data" id="x_Data" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_union->Data->getPlaceHolder()) ?>"<?php echo $config_union->Data->EditAttributes() ?>><?php echo $config_union->Data->EditValue ?></textarea>
</span>
<?php echo $config_union->Data->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_union->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_config_union_DATETIME" for="x_DATETIME" class="<?php echo $config_union_edit->LeftColumnClass ?>"><?php echo $config_union->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_union_edit->RightColumnClass ?>"><div<?php echo $config_union->DATETIME->CellAttributes() ?>>
<span id="el_config_union_DATETIME">
<input type="text" data-table="config_union" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($config_union->DATETIME->getPlaceHolder()) ?>" value="<?php echo $config_union->DATETIME->EditValue ?>"<?php echo $config_union->DATETIME->EditAttributes() ?>>
</span>
<?php echo $config_union->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="config_union" data-field="x_unid" name="x_unid" id="x_unid" value="<?php echo ew_HtmlEncode($config_union->unid->CurrentValue) ?>">
<?php if (!$config_union_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $config_union_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $config_union_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fconfig_unionedit.Init();
</script>
<?php
$config_union_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_union_edit->Page_Terminate();
?>
