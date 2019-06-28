<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ext_unioncityinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$ext_unioncity_edit = NULL; // Initialize page object first

class cext_unioncity_edit extends cext_unioncity {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'ext_unioncity';

	// Page object name
	var $PageObjName = 'ext_unioncity_edit';

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

		// Table object (ext_unioncity)
		if (!isset($GLOBALS["ext_unioncity"]) || get_class($GLOBALS["ext_unioncity"]) == "cext_unioncity") {
			$GLOBALS["ext_unioncity"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ext_unioncity"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ext_unioncity', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ext_unioncitylist.php"));
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
		$this->unid->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->unid->Visible = FALSE;
		$this->u_id->SetVisibility();
		$this->acl_id->SetVisibility();
		$this->Name->SetVisibility();
		$this->Location->SetVisibility();
		$this->Function->SetVisibility();
		$this->Dialog->SetVisibility();
		$this->Introduce->SetVisibility();
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
		global $EW_EXPORT, $ext_unioncity;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ext_unioncity);
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
					if ($pageName == "ext_unioncityview.php")
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
					$this->Page_Terminate("ext_unioncitylist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "ext_unioncitylist.php")
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
		if (!$this->unid->FldIsDetailKey)
			$this->unid->setFormValue($objForm->GetValue("x_unid"));
		if (!$this->u_id->FldIsDetailKey) {
			$this->u_id->setFormValue($objForm->GetValue("x_u_id"));
		}
		if (!$this->acl_id->FldIsDetailKey) {
			$this->acl_id->setFormValue($objForm->GetValue("x_acl_id"));
		}
		if (!$this->Name->FldIsDetailKey) {
			$this->Name->setFormValue($objForm->GetValue("x_Name"));
		}
		if (!$this->Location->FldIsDetailKey) {
			$this->Location->setFormValue($objForm->GetValue("x_Location"));
		}
		if (!$this->Function->FldIsDetailKey) {
			$this->Function->setFormValue($objForm->GetValue("x_Function"));
		}
		if (!$this->Dialog->FldIsDetailKey) {
			$this->Dialog->setFormValue($objForm->GetValue("x_Dialog"));
		}
		if (!$this->Introduce->FldIsDetailKey) {
			$this->Introduce->setFormValue($objForm->GetValue("x_Introduce"));
		}
		if (!$this->DATETIME->FldIsDetailKey) {
			$this->DATETIME->setFormValue($objForm->GetValue("x_DATETIME"));
			$this->DATETIME->CurrentValue = ew_UnFormatDateTime($this->DATETIME->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->unid->CurrentValue = $this->unid->FormValue;
		$this->u_id->CurrentValue = $this->u_id->FormValue;
		$this->acl_id->CurrentValue = $this->acl_id->FormValue;
		$this->Name->CurrentValue = $this->Name->FormValue;
		$this->Location->CurrentValue = $this->Location->FormValue;
		$this->Function->CurrentValue = $this->Function->FormValue;
		$this->Dialog->CurrentValue = $this->Dialog->FormValue;
		$this->Introduce->CurrentValue = $this->Introduce->FormValue;
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
		$this->Name->setDbValue($row['Name']);
		$this->Location->setDbValue($row['Location']);
		$this->Function->setDbValue($row['Function']);
		$this->Dialog->setDbValue($row['Dialog']);
		$this->Introduce->setDbValue($row['Introduce']);
		$this->DATETIME->setDbValue($row['DATETIME']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['Name'] = NULL;
		$row['Location'] = NULL;
		$row['Function'] = NULL;
		$row['Dialog'] = NULL;
		$row['Introduce'] = NULL;
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
		$this->Location->DbValue = $row['Location'];
		$this->Function->DbValue = $row['Function'];
		$this->Dialog->DbValue = $row['Dialog'];
		$this->Introduce->DbValue = $row['Introduce'];
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
		// Name
		// Location
		// Function
		// Dialog
		// Introduce
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

		// Name
		$this->Name->ViewValue = $this->Name->CurrentValue;
		$this->Name->ViewCustomAttributes = "";

		// Location
		$this->Location->ViewValue = $this->Location->CurrentValue;
		$this->Location->ViewCustomAttributes = "";

		// Function
		$this->Function->ViewValue = $this->Function->CurrentValue;
		$this->Function->ViewCustomAttributes = "";

		// Dialog
		$this->Dialog->ViewValue = $this->Dialog->CurrentValue;
		$this->Dialog->ViewCustomAttributes = "";

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

			// Location
			$this->Location->LinkCustomAttributes = "";
			$this->Location->HrefValue = "";
			$this->Location->TooltipValue = "";

			// Function
			$this->Function->LinkCustomAttributes = "";
			$this->Function->HrefValue = "";
			$this->Function->TooltipValue = "";

			// Dialog
			$this->Dialog->LinkCustomAttributes = "";
			$this->Dialog->HrefValue = "";
			$this->Dialog->TooltipValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";
			$this->Introduce->TooltipValue = "";

			// DATETIME
			$this->DATETIME->LinkCustomAttributes = "";
			$this->DATETIME->HrefValue = "";
			$this->DATETIME->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// unid
			$this->unid->EditAttrs["class"] = "form-control";
			$this->unid->EditCustomAttributes = "";
			$this->unid->EditValue = $this->unid->CurrentValue;
			$this->unid->ViewCustomAttributes = "";

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

			// Name
			$this->Name->EditAttrs["class"] = "form-control";
			$this->Name->EditCustomAttributes = "";
			$this->Name->EditValue = ew_HtmlEncode($this->Name->CurrentValue);
			$this->Name->PlaceHolder = ew_RemoveHtml($this->Name->FldCaption());

			// Location
			$this->Location->EditAttrs["class"] = "form-control";
			$this->Location->EditCustomAttributes = "";
			$this->Location->EditValue = ew_HtmlEncode($this->Location->CurrentValue);
			$this->Location->PlaceHolder = ew_RemoveHtml($this->Location->FldCaption());

			// Function
			$this->Function->EditAttrs["class"] = "form-control";
			$this->Function->EditCustomAttributes = "";
			$this->Function->EditValue = ew_HtmlEncode($this->Function->CurrentValue);
			$this->Function->PlaceHolder = ew_RemoveHtml($this->Function->FldCaption());

			// Dialog
			$this->Dialog->EditAttrs["class"] = "form-control";
			$this->Dialog->EditCustomAttributes = "";
			$this->Dialog->EditValue = ew_HtmlEncode($this->Dialog->CurrentValue);
			$this->Dialog->PlaceHolder = ew_RemoveHtml($this->Dialog->FldCaption());

			// Introduce
			$this->Introduce->EditAttrs["class"] = "form-control";
			$this->Introduce->EditCustomAttributes = "";
			$this->Introduce->EditValue = ew_HtmlEncode($this->Introduce->CurrentValue);
			$this->Introduce->PlaceHolder = ew_RemoveHtml($this->Introduce->FldCaption());

			// DATETIME
			$this->DATETIME->EditAttrs["class"] = "form-control";
			$this->DATETIME->EditCustomAttributes = "";
			$this->DATETIME->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->DATETIME->CurrentValue, 8));
			$this->DATETIME->PlaceHolder = ew_RemoveHtml($this->DATETIME->FldCaption());

			// Edit refer script
			// unid

			$this->unid->LinkCustomAttributes = "";
			$this->unid->HrefValue = "";

			// u_id
			$this->u_id->LinkCustomAttributes = "";
			$this->u_id->HrefValue = "";

			// acl_id
			$this->acl_id->LinkCustomAttributes = "";
			$this->acl_id->HrefValue = "";

			// Name
			$this->Name->LinkCustomAttributes = "";
			$this->Name->HrefValue = "";

			// Location
			$this->Location->LinkCustomAttributes = "";
			$this->Location->HrefValue = "";

			// Function
			$this->Function->LinkCustomAttributes = "";
			$this->Function->HrefValue = "";

			// Dialog
			$this->Dialog->LinkCustomAttributes = "";
			$this->Dialog->HrefValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";

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
		if (!$this->Name->FldIsDetailKey && !is_null($this->Name->FormValue) && $this->Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Name->FldCaption(), $this->Name->ReqErrMsg));
		}
		if (!$this->Location->FldIsDetailKey && !is_null($this->Location->FormValue) && $this->Location->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Location->FldCaption(), $this->Location->ReqErrMsg));
		}
		if (!$this->Function->FldIsDetailKey && !is_null($this->Function->FormValue) && $this->Function->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Function->FldCaption(), $this->Function->ReqErrMsg));
		}
		if (!$this->Dialog->FldIsDetailKey && !is_null($this->Dialog->FormValue) && $this->Dialog->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dialog->FldCaption(), $this->Dialog->ReqErrMsg));
		}
		if (!$this->Introduce->FldIsDetailKey && !is_null($this->Introduce->FormValue) && $this->Introduce->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Introduce->FldCaption(), $this->Introduce->ReqErrMsg));
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

			// Name
			$this->Name->SetDbValueDef($rsnew, $this->Name->CurrentValue, "", $this->Name->ReadOnly);

			// Location
			$this->Location->SetDbValueDef($rsnew, $this->Location->CurrentValue, "", $this->Location->ReadOnly);

			// Function
			$this->Function->SetDbValueDef($rsnew, $this->Function->CurrentValue, "", $this->Function->ReadOnly);

			// Dialog
			$this->Dialog->SetDbValueDef($rsnew, $this->Dialog->CurrentValue, "", $this->Dialog->ReadOnly);

			// Introduce
			$this->Introduce->SetDbValueDef($rsnew, $this->Introduce->CurrentValue, "", $this->Introduce->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ext_unioncitylist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ext_unioncity_edit)) $ext_unioncity_edit = new cext_unioncity_edit();

// Page init
$ext_unioncity_edit->Page_Init();

// Page main
$ext_unioncity_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ext_unioncity_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fext_unioncityedit = new ew_Form("fext_unioncityedit", "edit");

// Validate form
fext_unioncityedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_unioncity->u_id->FldCaption(), $ext_unioncity->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_unioncity->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_unioncity->acl_id->FldCaption(), $ext_unioncity->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_unioncity->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_unioncity->Name->FldCaption(), $ext_unioncity->Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Location");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_unioncity->Location->FldCaption(), $ext_unioncity->Location->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Function");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_unioncity->Function->FldCaption(), $ext_unioncity->Function->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dialog");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_unioncity->Dialog->FldCaption(), $ext_unioncity->Dialog->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Introduce");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_unioncity->Introduce->FldCaption(), $ext_unioncity->Introduce->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_unioncity->DATETIME->FldCaption(), $ext_unioncity->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_unioncity->DATETIME->FldErrMsg()) ?>");

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
fext_unioncityedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fext_unioncityedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $ext_unioncity_edit->ShowPageHeader(); ?>
<?php
$ext_unioncity_edit->ShowMessage();
?>
<form name="fext_unioncityedit" id="fext_unioncityedit" class="<?php echo $ext_unioncity_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ext_unioncity_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ext_unioncity_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ext_unioncity">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($ext_unioncity_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($ext_unioncity->unid->Visible) { // unid ?>
	<div id="r_unid" class="form-group">
		<label id="elh_ext_unioncity_unid" class="<?php echo $ext_unioncity_edit->LeftColumnClass ?>"><?php echo $ext_unioncity->unid->FldCaption() ?></label>
		<div class="<?php echo $ext_unioncity_edit->RightColumnClass ?>"><div<?php echo $ext_unioncity->unid->CellAttributes() ?>>
<span id="el_ext_unioncity_unid">
<span<?php echo $ext_unioncity->unid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ext_unioncity->unid->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ext_unioncity" data-field="x_unid" name="x_unid" id="x_unid" value="<?php echo ew_HtmlEncode($ext_unioncity->unid->CurrentValue) ?>">
<?php echo $ext_unioncity->unid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_unioncity->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_ext_unioncity_u_id" for="x_u_id" class="<?php echo $ext_unioncity_edit->LeftColumnClass ?>"><?php echo $ext_unioncity->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_unioncity_edit->RightColumnClass ?>"><div<?php echo $ext_unioncity->u_id->CellAttributes() ?>>
<span id="el_ext_unioncity_u_id">
<input type="text" data-table="ext_unioncity" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($ext_unioncity->u_id->getPlaceHolder()) ?>" value="<?php echo $ext_unioncity->u_id->EditValue ?>"<?php echo $ext_unioncity->u_id->EditAttributes() ?>>
</span>
<?php echo $ext_unioncity->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_unioncity->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_ext_unioncity_acl_id" for="x_acl_id" class="<?php echo $ext_unioncity_edit->LeftColumnClass ?>"><?php echo $ext_unioncity->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_unioncity_edit->RightColumnClass ?>"><div<?php echo $ext_unioncity->acl_id->CellAttributes() ?>>
<span id="el_ext_unioncity_acl_id">
<input type="text" data-table="ext_unioncity" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($ext_unioncity->acl_id->getPlaceHolder()) ?>" value="<?php echo $ext_unioncity->acl_id->EditValue ?>"<?php echo $ext_unioncity->acl_id->EditAttributes() ?>>
</span>
<?php echo $ext_unioncity->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_unioncity->Name->Visible) { // Name ?>
	<div id="r_Name" class="form-group">
		<label id="elh_ext_unioncity_Name" for="x_Name" class="<?php echo $ext_unioncity_edit->LeftColumnClass ?>"><?php echo $ext_unioncity->Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_unioncity_edit->RightColumnClass ?>"><div<?php echo $ext_unioncity->Name->CellAttributes() ?>>
<span id="el_ext_unioncity_Name">
<textarea data-table="ext_unioncity" data-field="x_Name" name="x_Name" id="x_Name" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_unioncity->Name->getPlaceHolder()) ?>"<?php echo $ext_unioncity->Name->EditAttributes() ?>><?php echo $ext_unioncity->Name->EditValue ?></textarea>
</span>
<?php echo $ext_unioncity->Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_unioncity->Location->Visible) { // Location ?>
	<div id="r_Location" class="form-group">
		<label id="elh_ext_unioncity_Location" for="x_Location" class="<?php echo $ext_unioncity_edit->LeftColumnClass ?>"><?php echo $ext_unioncity->Location->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_unioncity_edit->RightColumnClass ?>"><div<?php echo $ext_unioncity->Location->CellAttributes() ?>>
<span id="el_ext_unioncity_Location">
<textarea data-table="ext_unioncity" data-field="x_Location" name="x_Location" id="x_Location" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_unioncity->Location->getPlaceHolder()) ?>"<?php echo $ext_unioncity->Location->EditAttributes() ?>><?php echo $ext_unioncity->Location->EditValue ?></textarea>
</span>
<?php echo $ext_unioncity->Location->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_unioncity->Function->Visible) { // Function ?>
	<div id="r_Function" class="form-group">
		<label id="elh_ext_unioncity_Function" for="x_Function" class="<?php echo $ext_unioncity_edit->LeftColumnClass ?>"><?php echo $ext_unioncity->Function->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_unioncity_edit->RightColumnClass ?>"><div<?php echo $ext_unioncity->Function->CellAttributes() ?>>
<span id="el_ext_unioncity_Function">
<textarea data-table="ext_unioncity" data-field="x_Function" name="x_Function" id="x_Function" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_unioncity->Function->getPlaceHolder()) ?>"<?php echo $ext_unioncity->Function->EditAttributes() ?>><?php echo $ext_unioncity->Function->EditValue ?></textarea>
</span>
<?php echo $ext_unioncity->Function->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_unioncity->Dialog->Visible) { // Dialog ?>
	<div id="r_Dialog" class="form-group">
		<label id="elh_ext_unioncity_Dialog" for="x_Dialog" class="<?php echo $ext_unioncity_edit->LeftColumnClass ?>"><?php echo $ext_unioncity->Dialog->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_unioncity_edit->RightColumnClass ?>"><div<?php echo $ext_unioncity->Dialog->CellAttributes() ?>>
<span id="el_ext_unioncity_Dialog">
<textarea data-table="ext_unioncity" data-field="x_Dialog" name="x_Dialog" id="x_Dialog" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_unioncity->Dialog->getPlaceHolder()) ?>"<?php echo $ext_unioncity->Dialog->EditAttributes() ?>><?php echo $ext_unioncity->Dialog->EditValue ?></textarea>
</span>
<?php echo $ext_unioncity->Dialog->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_unioncity->Introduce->Visible) { // Introduce ?>
	<div id="r_Introduce" class="form-group">
		<label id="elh_ext_unioncity_Introduce" for="x_Introduce" class="<?php echo $ext_unioncity_edit->LeftColumnClass ?>"><?php echo $ext_unioncity->Introduce->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_unioncity_edit->RightColumnClass ?>"><div<?php echo $ext_unioncity->Introduce->CellAttributes() ?>>
<span id="el_ext_unioncity_Introduce">
<textarea data-table="ext_unioncity" data-field="x_Introduce" name="x_Introduce" id="x_Introduce" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_unioncity->Introduce->getPlaceHolder()) ?>"<?php echo $ext_unioncity->Introduce->EditAttributes() ?>><?php echo $ext_unioncity->Introduce->EditValue ?></textarea>
</span>
<?php echo $ext_unioncity->Introduce->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_unioncity->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_ext_unioncity_DATETIME" for="x_DATETIME" class="<?php echo $ext_unioncity_edit->LeftColumnClass ?>"><?php echo $ext_unioncity->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_unioncity_edit->RightColumnClass ?>"><div<?php echo $ext_unioncity->DATETIME->CellAttributes() ?>>
<span id="el_ext_unioncity_DATETIME">
<input type="text" data-table="ext_unioncity" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($ext_unioncity->DATETIME->getPlaceHolder()) ?>" value="<?php echo $ext_unioncity->DATETIME->EditValue ?>"<?php echo $ext_unioncity->DATETIME->EditAttributes() ?>>
</span>
<?php echo $ext_unioncity->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$ext_unioncity_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $ext_unioncity_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ext_unioncity_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fext_unioncityedit.Init();
</script>
<?php
$ext_unioncity_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ext_unioncity_edit->Page_Terminate();
?>
