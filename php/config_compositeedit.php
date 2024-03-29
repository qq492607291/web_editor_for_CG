<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_compositeinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_composite_edit = NULL; // Initialize page object first

class cconfig_composite_edit extends cconfig_composite {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_composite';

	// Page object name
	var $PageObjName = 'config_composite_edit';

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

		// Table object (config_composite)
		if (!isset($GLOBALS["config_composite"]) || get_class($GLOBALS["config_composite"]) == "cconfig_composite") {
			$GLOBALS["config_composite"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_composite"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'config_composite', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("config_compositelist.php"));
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
		$this->Produce->SetVisibility();
		$this->ConsumeGoods->SetVisibility();
		$this->ConsumeGold->SetVisibility();
		$this->ConsumeDiamond->SetVisibility();
		$this->Success->SetVisibility();
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
		global $EW_EXPORT, $config_composite;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_composite);
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
					if ($pageName == "config_compositeview.php")
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
					$this->Page_Terminate("config_compositelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "config_compositelist.php")
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
		if (!$this->Produce->FldIsDetailKey) {
			$this->Produce->setFormValue($objForm->GetValue("x_Produce"));
		}
		if (!$this->ConsumeGoods->FldIsDetailKey) {
			$this->ConsumeGoods->setFormValue($objForm->GetValue("x_ConsumeGoods"));
		}
		if (!$this->ConsumeGold->FldIsDetailKey) {
			$this->ConsumeGold->setFormValue($objForm->GetValue("x_ConsumeGold"));
		}
		if (!$this->ConsumeDiamond->FldIsDetailKey) {
			$this->ConsumeDiamond->setFormValue($objForm->GetValue("x_ConsumeDiamond"));
		}
		if (!$this->Success->FldIsDetailKey) {
			$this->Success->setFormValue($objForm->GetValue("x_Success"));
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
		$this->Produce->CurrentValue = $this->Produce->FormValue;
		$this->ConsumeGoods->CurrentValue = $this->ConsumeGoods->FormValue;
		$this->ConsumeGold->CurrentValue = $this->ConsumeGold->FormValue;
		$this->ConsumeDiamond->CurrentValue = $this->ConsumeDiamond->FormValue;
		$this->Success->CurrentValue = $this->Success->FormValue;
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
		$this->Produce->setDbValue($row['Produce']);
		$this->ConsumeGoods->setDbValue($row['ConsumeGoods']);
		$this->ConsumeGold->setDbValue($row['ConsumeGold']);
		$this->ConsumeDiamond->setDbValue($row['ConsumeDiamond']);
		$this->Success->setDbValue($row['Success']);
		$this->DATETIME->setDbValue($row['DATETIME']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['Produce'] = NULL;
		$row['ConsumeGoods'] = NULL;
		$row['ConsumeGold'] = NULL;
		$row['ConsumeDiamond'] = NULL;
		$row['Success'] = NULL;
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
		$this->Produce->DbValue = $row['Produce'];
		$this->ConsumeGoods->DbValue = $row['ConsumeGoods'];
		$this->ConsumeGold->DbValue = $row['ConsumeGold'];
		$this->ConsumeDiamond->DbValue = $row['ConsumeDiamond'];
		$this->Success->DbValue = $row['Success'];
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
		// Produce
		// ConsumeGoods
		// ConsumeGold
		// ConsumeDiamond
		// Success
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

		// Produce
		$this->Produce->ViewValue = $this->Produce->CurrentValue;
		$this->Produce->ViewCustomAttributes = "";

		// ConsumeGoods
		$this->ConsumeGoods->ViewValue = $this->ConsumeGoods->CurrentValue;
		$this->ConsumeGoods->ViewCustomAttributes = "";

		// ConsumeGold
		$this->ConsumeGold->ViewValue = $this->ConsumeGold->CurrentValue;
		$this->ConsumeGold->ViewCustomAttributes = "";

		// ConsumeDiamond
		$this->ConsumeDiamond->ViewValue = $this->ConsumeDiamond->CurrentValue;
		$this->ConsumeDiamond->ViewCustomAttributes = "";

		// Success
		$this->Success->ViewValue = $this->Success->CurrentValue;
		$this->Success->ViewCustomAttributes = "";

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

			// Produce
			$this->Produce->LinkCustomAttributes = "";
			$this->Produce->HrefValue = "";
			$this->Produce->TooltipValue = "";

			// ConsumeGoods
			$this->ConsumeGoods->LinkCustomAttributes = "";
			$this->ConsumeGoods->HrefValue = "";
			$this->ConsumeGoods->TooltipValue = "";

			// ConsumeGold
			$this->ConsumeGold->LinkCustomAttributes = "";
			$this->ConsumeGold->HrefValue = "";
			$this->ConsumeGold->TooltipValue = "";

			// ConsumeDiamond
			$this->ConsumeDiamond->LinkCustomAttributes = "";
			$this->ConsumeDiamond->HrefValue = "";
			$this->ConsumeDiamond->TooltipValue = "";

			// Success
			$this->Success->LinkCustomAttributes = "";
			$this->Success->HrefValue = "";
			$this->Success->TooltipValue = "";

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

			// Produce
			$this->Produce->EditAttrs["class"] = "form-control";
			$this->Produce->EditCustomAttributes = "";
			$this->Produce->EditValue = ew_HtmlEncode($this->Produce->CurrentValue);
			$this->Produce->PlaceHolder = ew_RemoveHtml($this->Produce->FldCaption());

			// ConsumeGoods
			$this->ConsumeGoods->EditAttrs["class"] = "form-control";
			$this->ConsumeGoods->EditCustomAttributes = "";
			$this->ConsumeGoods->EditValue = ew_HtmlEncode($this->ConsumeGoods->CurrentValue);
			$this->ConsumeGoods->PlaceHolder = ew_RemoveHtml($this->ConsumeGoods->FldCaption());

			// ConsumeGold
			$this->ConsumeGold->EditAttrs["class"] = "form-control";
			$this->ConsumeGold->EditCustomAttributes = "";
			$this->ConsumeGold->EditValue = ew_HtmlEncode($this->ConsumeGold->CurrentValue);
			$this->ConsumeGold->PlaceHolder = ew_RemoveHtml($this->ConsumeGold->FldCaption());

			// ConsumeDiamond
			$this->ConsumeDiamond->EditAttrs["class"] = "form-control";
			$this->ConsumeDiamond->EditCustomAttributes = "";
			$this->ConsumeDiamond->EditValue = ew_HtmlEncode($this->ConsumeDiamond->CurrentValue);
			$this->ConsumeDiamond->PlaceHolder = ew_RemoveHtml($this->ConsumeDiamond->FldCaption());

			// Success
			$this->Success->EditAttrs["class"] = "form-control";
			$this->Success->EditCustomAttributes = "";
			$this->Success->EditValue = ew_HtmlEncode($this->Success->CurrentValue);
			$this->Success->PlaceHolder = ew_RemoveHtml($this->Success->FldCaption());

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

			// Produce
			$this->Produce->LinkCustomAttributes = "";
			$this->Produce->HrefValue = "";

			// ConsumeGoods
			$this->ConsumeGoods->LinkCustomAttributes = "";
			$this->ConsumeGoods->HrefValue = "";

			// ConsumeGold
			$this->ConsumeGold->LinkCustomAttributes = "";
			$this->ConsumeGold->HrefValue = "";

			// ConsumeDiamond
			$this->ConsumeDiamond->LinkCustomAttributes = "";
			$this->ConsumeDiamond->HrefValue = "";

			// Success
			$this->Success->LinkCustomAttributes = "";
			$this->Success->HrefValue = "";

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
		if (!$this->Produce->FldIsDetailKey && !is_null($this->Produce->FormValue) && $this->Produce->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Produce->FldCaption(), $this->Produce->ReqErrMsg));
		}
		if (!$this->ConsumeGoods->FldIsDetailKey && !is_null($this->ConsumeGoods->FormValue) && $this->ConsumeGoods->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ConsumeGoods->FldCaption(), $this->ConsumeGoods->ReqErrMsg));
		}
		if (!$this->ConsumeGold->FldIsDetailKey && !is_null($this->ConsumeGold->FormValue) && $this->ConsumeGold->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ConsumeGold->FldCaption(), $this->ConsumeGold->ReqErrMsg));
		}
		if (!$this->ConsumeDiamond->FldIsDetailKey && !is_null($this->ConsumeDiamond->FormValue) && $this->ConsumeDiamond->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ConsumeDiamond->FldCaption(), $this->ConsumeDiamond->ReqErrMsg));
		}
		if (!$this->Success->FldIsDetailKey && !is_null($this->Success->FormValue) && $this->Success->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Success->FldCaption(), $this->Success->ReqErrMsg));
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

			// Produce
			$this->Produce->SetDbValueDef($rsnew, $this->Produce->CurrentValue, "", $this->Produce->ReadOnly);

			// ConsumeGoods
			$this->ConsumeGoods->SetDbValueDef($rsnew, $this->ConsumeGoods->CurrentValue, "", $this->ConsumeGoods->ReadOnly);

			// ConsumeGold
			$this->ConsumeGold->SetDbValueDef($rsnew, $this->ConsumeGold->CurrentValue, "", $this->ConsumeGold->ReadOnly);

			// ConsumeDiamond
			$this->ConsumeDiamond->SetDbValueDef($rsnew, $this->ConsumeDiamond->CurrentValue, "", $this->ConsumeDiamond->ReadOnly);

			// Success
			$this->Success->SetDbValueDef($rsnew, $this->Success->CurrentValue, "", $this->Success->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_compositelist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_composite_edit)) $config_composite_edit = new cconfig_composite_edit();

// Page init
$config_composite_edit->Page_Init();

// Page main
$config_composite_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_composite_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fconfig_compositeedit = new ew_Form("fconfig_compositeedit", "edit");

// Validate form
fconfig_compositeedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_composite->u_id->FldCaption(), $config_composite->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_composite->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_composite->acl_id->FldCaption(), $config_composite->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_composite->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Produce");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_composite->Produce->FldCaption(), $config_composite->Produce->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ConsumeGoods");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_composite->ConsumeGoods->FldCaption(), $config_composite->ConsumeGoods->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ConsumeGold");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_composite->ConsumeGold->FldCaption(), $config_composite->ConsumeGold->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ConsumeDiamond");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_composite->ConsumeDiamond->FldCaption(), $config_composite->ConsumeDiamond->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Success");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_composite->Success->FldCaption(), $config_composite->Success->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_composite->DATETIME->FldCaption(), $config_composite->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_composite->DATETIME->FldErrMsg()) ?>");

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
fconfig_compositeedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_compositeedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $config_composite_edit->ShowPageHeader(); ?>
<?php
$config_composite_edit->ShowMessage();
?>
<form name="fconfig_compositeedit" id="fconfig_compositeedit" class="<?php echo $config_composite_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_composite_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_composite_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_composite">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($config_composite_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($config_composite->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_config_composite_u_id" for="x_u_id" class="<?php echo $config_composite_edit->LeftColumnClass ?>"><?php echo $config_composite->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_composite_edit->RightColumnClass ?>"><div<?php echo $config_composite->u_id->CellAttributes() ?>>
<span id="el_config_composite_u_id">
<input type="text" data-table="config_composite" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_composite->u_id->getPlaceHolder()) ?>" value="<?php echo $config_composite->u_id->EditValue ?>"<?php echo $config_composite->u_id->EditAttributes() ?>>
</span>
<?php echo $config_composite->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_composite->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_config_composite_acl_id" for="x_acl_id" class="<?php echo $config_composite_edit->LeftColumnClass ?>"><?php echo $config_composite->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_composite_edit->RightColumnClass ?>"><div<?php echo $config_composite->acl_id->CellAttributes() ?>>
<span id="el_config_composite_acl_id">
<input type="text" data-table="config_composite" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_composite->acl_id->getPlaceHolder()) ?>" value="<?php echo $config_composite->acl_id->EditValue ?>"<?php echo $config_composite->acl_id->EditAttributes() ?>>
</span>
<?php echo $config_composite->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_composite->Produce->Visible) { // Produce ?>
	<div id="r_Produce" class="form-group">
		<label id="elh_config_composite_Produce" for="x_Produce" class="<?php echo $config_composite_edit->LeftColumnClass ?>"><?php echo $config_composite->Produce->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_composite_edit->RightColumnClass ?>"><div<?php echo $config_composite->Produce->CellAttributes() ?>>
<span id="el_config_composite_Produce">
<textarea data-table="config_composite" data-field="x_Produce" name="x_Produce" id="x_Produce" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_composite->Produce->getPlaceHolder()) ?>"<?php echo $config_composite->Produce->EditAttributes() ?>><?php echo $config_composite->Produce->EditValue ?></textarea>
</span>
<?php echo $config_composite->Produce->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_composite->ConsumeGoods->Visible) { // ConsumeGoods ?>
	<div id="r_ConsumeGoods" class="form-group">
		<label id="elh_config_composite_ConsumeGoods" for="x_ConsumeGoods" class="<?php echo $config_composite_edit->LeftColumnClass ?>"><?php echo $config_composite->ConsumeGoods->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_composite_edit->RightColumnClass ?>"><div<?php echo $config_composite->ConsumeGoods->CellAttributes() ?>>
<span id="el_config_composite_ConsumeGoods">
<textarea data-table="config_composite" data-field="x_ConsumeGoods" name="x_ConsumeGoods" id="x_ConsumeGoods" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_composite->ConsumeGoods->getPlaceHolder()) ?>"<?php echo $config_composite->ConsumeGoods->EditAttributes() ?>><?php echo $config_composite->ConsumeGoods->EditValue ?></textarea>
</span>
<?php echo $config_composite->ConsumeGoods->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_composite->ConsumeGold->Visible) { // ConsumeGold ?>
	<div id="r_ConsumeGold" class="form-group">
		<label id="elh_config_composite_ConsumeGold" for="x_ConsumeGold" class="<?php echo $config_composite_edit->LeftColumnClass ?>"><?php echo $config_composite->ConsumeGold->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_composite_edit->RightColumnClass ?>"><div<?php echo $config_composite->ConsumeGold->CellAttributes() ?>>
<span id="el_config_composite_ConsumeGold">
<textarea data-table="config_composite" data-field="x_ConsumeGold" name="x_ConsumeGold" id="x_ConsumeGold" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_composite->ConsumeGold->getPlaceHolder()) ?>"<?php echo $config_composite->ConsumeGold->EditAttributes() ?>><?php echo $config_composite->ConsumeGold->EditValue ?></textarea>
</span>
<?php echo $config_composite->ConsumeGold->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_composite->ConsumeDiamond->Visible) { // ConsumeDiamond ?>
	<div id="r_ConsumeDiamond" class="form-group">
		<label id="elh_config_composite_ConsumeDiamond" for="x_ConsumeDiamond" class="<?php echo $config_composite_edit->LeftColumnClass ?>"><?php echo $config_composite->ConsumeDiamond->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_composite_edit->RightColumnClass ?>"><div<?php echo $config_composite->ConsumeDiamond->CellAttributes() ?>>
<span id="el_config_composite_ConsumeDiamond">
<textarea data-table="config_composite" data-field="x_ConsumeDiamond" name="x_ConsumeDiamond" id="x_ConsumeDiamond" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_composite->ConsumeDiamond->getPlaceHolder()) ?>"<?php echo $config_composite->ConsumeDiamond->EditAttributes() ?>><?php echo $config_composite->ConsumeDiamond->EditValue ?></textarea>
</span>
<?php echo $config_composite->ConsumeDiamond->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_composite->Success->Visible) { // Success ?>
	<div id="r_Success" class="form-group">
		<label id="elh_config_composite_Success" for="x_Success" class="<?php echo $config_composite_edit->LeftColumnClass ?>"><?php echo $config_composite->Success->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_composite_edit->RightColumnClass ?>"><div<?php echo $config_composite->Success->CellAttributes() ?>>
<span id="el_config_composite_Success">
<textarea data-table="config_composite" data-field="x_Success" name="x_Success" id="x_Success" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_composite->Success->getPlaceHolder()) ?>"<?php echo $config_composite->Success->EditAttributes() ?>><?php echo $config_composite->Success->EditValue ?></textarea>
</span>
<?php echo $config_composite->Success->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_composite->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_config_composite_DATETIME" for="x_DATETIME" class="<?php echo $config_composite_edit->LeftColumnClass ?>"><?php echo $config_composite->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_composite_edit->RightColumnClass ?>"><div<?php echo $config_composite->DATETIME->CellAttributes() ?>>
<span id="el_config_composite_DATETIME">
<input type="text" data-table="config_composite" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($config_composite->DATETIME->getPlaceHolder()) ?>" value="<?php echo $config_composite->DATETIME->EditValue ?>"<?php echo $config_composite->DATETIME->EditAttributes() ?>>
</span>
<?php echo $config_composite->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="config_composite" data-field="x_unid" name="x_unid" id="x_unid" value="<?php echo ew_HtmlEncode($config_composite->unid->CurrentValue) ?>">
<?php if (!$config_composite_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $config_composite_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $config_composite_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fconfig_compositeedit.Init();
</script>
<?php
$config_composite_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_composite_edit->Page_Terminate();
?>
