<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "skill_registerinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$skill_register_add = NULL; // Initialize page object first

class cskill_register_add extends cskill_register {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'skill_register';

	// Page object name
	var $PageObjName = 'skill_register_add';

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

		// Table object (skill_register)
		if (!isset($GLOBALS["skill_register"]) || get_class($GLOBALS["skill_register"]) == "cskill_register") {
			$GLOBALS["skill_register"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["skill_register"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'skill_register', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("skill_registerlist.php"));
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
		$this->User->SetVisibility();
		$this->SkillName->SetVisibility();
		$this->Proficiency->SetVisibility();
		$this->LastUseDate->SetVisibility();
		$this->Occupation->SetVisibility();
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
		global $EW_EXPORT, $skill_register;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($skill_register);
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
					if ($pageName == "skill_registerview.php")
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["unid"] != "") {
				$this->unid->setQueryStringValue($_GET["unid"]);
				$this->setKey("unid", $this->unid->CurrentValue); // Set up key
			} else {
				$this->setKey("unid", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("skill_registerlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "skill_registerlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "skill_registerview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->unid->CurrentValue = NULL;
		$this->unid->OldValue = $this->unid->CurrentValue;
		$this->u_id->CurrentValue = NULL;
		$this->u_id->OldValue = $this->u_id->CurrentValue;
		$this->acl_id->CurrentValue = NULL;
		$this->acl_id->OldValue = $this->acl_id->CurrentValue;
		$this->User->CurrentValue = NULL;
		$this->User->OldValue = $this->User->CurrentValue;
		$this->SkillName->CurrentValue = NULL;
		$this->SkillName->OldValue = $this->SkillName->CurrentValue;
		$this->Proficiency->CurrentValue = NULL;
		$this->Proficiency->OldValue = $this->Proficiency->CurrentValue;
		$this->LastUseDate->CurrentValue = NULL;
		$this->LastUseDate->OldValue = $this->LastUseDate->CurrentValue;
		$this->Occupation->CurrentValue = NULL;
		$this->Occupation->OldValue = $this->Occupation->CurrentValue;
		$this->DATETIME->CurrentValue = NULL;
		$this->DATETIME->OldValue = $this->DATETIME->CurrentValue;
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
		if (!$this->User->FldIsDetailKey) {
			$this->User->setFormValue($objForm->GetValue("x_User"));
		}
		if (!$this->SkillName->FldIsDetailKey) {
			$this->SkillName->setFormValue($objForm->GetValue("x_SkillName"));
		}
		if (!$this->Proficiency->FldIsDetailKey) {
			$this->Proficiency->setFormValue($objForm->GetValue("x_Proficiency"));
		}
		if (!$this->LastUseDate->FldIsDetailKey) {
			$this->LastUseDate->setFormValue($objForm->GetValue("x_LastUseDate"));
		}
		if (!$this->Occupation->FldIsDetailKey) {
			$this->Occupation->setFormValue($objForm->GetValue("x_Occupation"));
		}
		if (!$this->DATETIME->FldIsDetailKey) {
			$this->DATETIME->setFormValue($objForm->GetValue("x_DATETIME"));
			$this->DATETIME->CurrentValue = ew_UnFormatDateTime($this->DATETIME->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->u_id->CurrentValue = $this->u_id->FormValue;
		$this->acl_id->CurrentValue = $this->acl_id->FormValue;
		$this->User->CurrentValue = $this->User->FormValue;
		$this->SkillName->CurrentValue = $this->SkillName->FormValue;
		$this->Proficiency->CurrentValue = $this->Proficiency->FormValue;
		$this->LastUseDate->CurrentValue = $this->LastUseDate->FormValue;
		$this->Occupation->CurrentValue = $this->Occupation->FormValue;
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
		$this->User->setDbValue($row['User']);
		$this->SkillName->setDbValue($row['SkillName']);
		$this->Proficiency->setDbValue($row['Proficiency']);
		$this->LastUseDate->setDbValue($row['LastUseDate']);
		$this->Occupation->setDbValue($row['Occupation']);
		$this->DATETIME->setDbValue($row['DATETIME']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['unid'] = $this->unid->CurrentValue;
		$row['u_id'] = $this->u_id->CurrentValue;
		$row['acl_id'] = $this->acl_id->CurrentValue;
		$row['User'] = $this->User->CurrentValue;
		$row['SkillName'] = $this->SkillName->CurrentValue;
		$row['Proficiency'] = $this->Proficiency->CurrentValue;
		$row['LastUseDate'] = $this->LastUseDate->CurrentValue;
		$row['Occupation'] = $this->Occupation->CurrentValue;
		$row['DATETIME'] = $this->DATETIME->CurrentValue;
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
		$this->User->DbValue = $row['User'];
		$this->SkillName->DbValue = $row['SkillName'];
		$this->Proficiency->DbValue = $row['Proficiency'];
		$this->LastUseDate->DbValue = $row['LastUseDate'];
		$this->Occupation->DbValue = $row['Occupation'];
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
		// User
		// SkillName
		// Proficiency
		// LastUseDate
		// Occupation
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

		// User
		$this->User->ViewValue = $this->User->CurrentValue;
		$this->User->ViewCustomAttributes = "";

		// SkillName
		$this->SkillName->ViewValue = $this->SkillName->CurrentValue;
		$this->SkillName->ViewCustomAttributes = "";

		// Proficiency
		$this->Proficiency->ViewValue = $this->Proficiency->CurrentValue;
		$this->Proficiency->ViewCustomAttributes = "";

		// LastUseDate
		$this->LastUseDate->ViewValue = $this->LastUseDate->CurrentValue;
		$this->LastUseDate->ViewCustomAttributes = "";

		// Occupation
		$this->Occupation->ViewValue = $this->Occupation->CurrentValue;
		$this->Occupation->ViewCustomAttributes = "";

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

			// User
			$this->User->LinkCustomAttributes = "";
			$this->User->HrefValue = "";
			$this->User->TooltipValue = "";

			// SkillName
			$this->SkillName->LinkCustomAttributes = "";
			$this->SkillName->HrefValue = "";
			$this->SkillName->TooltipValue = "";

			// Proficiency
			$this->Proficiency->LinkCustomAttributes = "";
			$this->Proficiency->HrefValue = "";
			$this->Proficiency->TooltipValue = "";

			// LastUseDate
			$this->LastUseDate->LinkCustomAttributes = "";
			$this->LastUseDate->HrefValue = "";
			$this->LastUseDate->TooltipValue = "";

			// Occupation
			$this->Occupation->LinkCustomAttributes = "";
			$this->Occupation->HrefValue = "";
			$this->Occupation->TooltipValue = "";

			// DATETIME
			$this->DATETIME->LinkCustomAttributes = "";
			$this->DATETIME->HrefValue = "";
			$this->DATETIME->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// User
			$this->User->EditAttrs["class"] = "form-control";
			$this->User->EditCustomAttributes = "";
			$this->User->EditValue = ew_HtmlEncode($this->User->CurrentValue);
			$this->User->PlaceHolder = ew_RemoveHtml($this->User->FldCaption());

			// SkillName
			$this->SkillName->EditAttrs["class"] = "form-control";
			$this->SkillName->EditCustomAttributes = "";
			$this->SkillName->EditValue = ew_HtmlEncode($this->SkillName->CurrentValue);
			$this->SkillName->PlaceHolder = ew_RemoveHtml($this->SkillName->FldCaption());

			// Proficiency
			$this->Proficiency->EditAttrs["class"] = "form-control";
			$this->Proficiency->EditCustomAttributes = "";
			$this->Proficiency->EditValue = ew_HtmlEncode($this->Proficiency->CurrentValue);
			$this->Proficiency->PlaceHolder = ew_RemoveHtml($this->Proficiency->FldCaption());

			// LastUseDate
			$this->LastUseDate->EditAttrs["class"] = "form-control";
			$this->LastUseDate->EditCustomAttributes = "";
			$this->LastUseDate->EditValue = ew_HtmlEncode($this->LastUseDate->CurrentValue);
			$this->LastUseDate->PlaceHolder = ew_RemoveHtml($this->LastUseDate->FldCaption());

			// Occupation
			$this->Occupation->EditAttrs["class"] = "form-control";
			$this->Occupation->EditCustomAttributes = "";
			$this->Occupation->EditValue = ew_HtmlEncode($this->Occupation->CurrentValue);
			$this->Occupation->PlaceHolder = ew_RemoveHtml($this->Occupation->FldCaption());

			// DATETIME
			$this->DATETIME->EditAttrs["class"] = "form-control";
			$this->DATETIME->EditCustomAttributes = "";
			$this->DATETIME->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->DATETIME->CurrentValue, 8));
			$this->DATETIME->PlaceHolder = ew_RemoveHtml($this->DATETIME->FldCaption());

			// Add refer script
			// u_id

			$this->u_id->LinkCustomAttributes = "";
			$this->u_id->HrefValue = "";

			// acl_id
			$this->acl_id->LinkCustomAttributes = "";
			$this->acl_id->HrefValue = "";

			// User
			$this->User->LinkCustomAttributes = "";
			$this->User->HrefValue = "";

			// SkillName
			$this->SkillName->LinkCustomAttributes = "";
			$this->SkillName->HrefValue = "";

			// Proficiency
			$this->Proficiency->LinkCustomAttributes = "";
			$this->Proficiency->HrefValue = "";

			// LastUseDate
			$this->LastUseDate->LinkCustomAttributes = "";
			$this->LastUseDate->HrefValue = "";

			// Occupation
			$this->Occupation->LinkCustomAttributes = "";
			$this->Occupation->HrefValue = "";

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
		if (!$this->User->FldIsDetailKey && !is_null($this->User->FormValue) && $this->User->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->User->FldCaption(), $this->User->ReqErrMsg));
		}
		if (!$this->SkillName->FldIsDetailKey && !is_null($this->SkillName->FormValue) && $this->SkillName->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->SkillName->FldCaption(), $this->SkillName->ReqErrMsg));
		}
		if (!$this->Proficiency->FldIsDetailKey && !is_null($this->Proficiency->FormValue) && $this->Proficiency->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Proficiency->FldCaption(), $this->Proficiency->ReqErrMsg));
		}
		if (!$this->LastUseDate->FldIsDetailKey && !is_null($this->LastUseDate->FormValue) && $this->LastUseDate->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->LastUseDate->FldCaption(), $this->LastUseDate->ReqErrMsg));
		}
		if (!$this->Occupation->FldIsDetailKey && !is_null($this->Occupation->FormValue) && $this->Occupation->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Occupation->FldCaption(), $this->Occupation->ReqErrMsg));
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// u_id
		$this->u_id->SetDbValueDef($rsnew, $this->u_id->CurrentValue, 0, FALSE);

		// acl_id
		$this->acl_id->SetDbValueDef($rsnew, $this->acl_id->CurrentValue, 0, FALSE);

		// User
		$this->User->SetDbValueDef($rsnew, $this->User->CurrentValue, "", FALSE);

		// SkillName
		$this->SkillName->SetDbValueDef($rsnew, $this->SkillName->CurrentValue, "", FALSE);

		// Proficiency
		$this->Proficiency->SetDbValueDef($rsnew, $this->Proficiency->CurrentValue, "", FALSE);

		// LastUseDate
		$this->LastUseDate->SetDbValueDef($rsnew, $this->LastUseDate->CurrentValue, "", FALSE);

		// Occupation
		$this->Occupation->SetDbValueDef($rsnew, $this->Occupation->CurrentValue, "", FALSE);

		// DATETIME
		$this->DATETIME->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->DATETIME->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("skill_registerlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($skill_register_add)) $skill_register_add = new cskill_register_add();

// Page init
$skill_register_add->Page_Init();

// Page main
$skill_register_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$skill_register_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fskill_registeradd = new ew_Form("fskill_registeradd", "add");

// Validate form
fskill_registeradd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skill_register->u_id->FldCaption(), $skill_register->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($skill_register->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skill_register->acl_id->FldCaption(), $skill_register->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($skill_register->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_User");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skill_register->User->FldCaption(), $skill_register->User->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_SkillName");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skill_register->SkillName->FldCaption(), $skill_register->SkillName->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Proficiency");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skill_register->Proficiency->FldCaption(), $skill_register->Proficiency->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LastUseDate");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skill_register->LastUseDate->FldCaption(), $skill_register->LastUseDate->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Occupation");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skill_register->Occupation->FldCaption(), $skill_register->Occupation->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $skill_register->DATETIME->FldCaption(), $skill_register->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($skill_register->DATETIME->FldErrMsg()) ?>");

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
fskill_registeradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fskill_registeradd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $skill_register_add->ShowPageHeader(); ?>
<?php
$skill_register_add->ShowMessage();
?>
<form name="fskill_registeradd" id="fskill_registeradd" class="<?php echo $skill_register_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($skill_register_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $skill_register_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="skill_register">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($skill_register_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($skill_register->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_skill_register_u_id" for="x_u_id" class="<?php echo $skill_register_add->LeftColumnClass ?>"><?php echo $skill_register->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $skill_register_add->RightColumnClass ?>"><div<?php echo $skill_register->u_id->CellAttributes() ?>>
<span id="el_skill_register_u_id">
<input type="text" data-table="skill_register" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($skill_register->u_id->getPlaceHolder()) ?>" value="<?php echo $skill_register->u_id->EditValue ?>"<?php echo $skill_register->u_id->EditAttributes() ?>>
</span>
<?php echo $skill_register->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skill_register->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_skill_register_acl_id" for="x_acl_id" class="<?php echo $skill_register_add->LeftColumnClass ?>"><?php echo $skill_register->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $skill_register_add->RightColumnClass ?>"><div<?php echo $skill_register->acl_id->CellAttributes() ?>>
<span id="el_skill_register_acl_id">
<input type="text" data-table="skill_register" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($skill_register->acl_id->getPlaceHolder()) ?>" value="<?php echo $skill_register->acl_id->EditValue ?>"<?php echo $skill_register->acl_id->EditAttributes() ?>>
</span>
<?php echo $skill_register->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skill_register->User->Visible) { // User ?>
	<div id="r_User" class="form-group">
		<label id="elh_skill_register_User" for="x_User" class="<?php echo $skill_register_add->LeftColumnClass ?>"><?php echo $skill_register->User->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $skill_register_add->RightColumnClass ?>"><div<?php echo $skill_register->User->CellAttributes() ?>>
<span id="el_skill_register_User">
<textarea data-table="skill_register" data-field="x_User" name="x_User" id="x_User" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($skill_register->User->getPlaceHolder()) ?>"<?php echo $skill_register->User->EditAttributes() ?>><?php echo $skill_register->User->EditValue ?></textarea>
</span>
<?php echo $skill_register->User->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skill_register->SkillName->Visible) { // SkillName ?>
	<div id="r_SkillName" class="form-group">
		<label id="elh_skill_register_SkillName" for="x_SkillName" class="<?php echo $skill_register_add->LeftColumnClass ?>"><?php echo $skill_register->SkillName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $skill_register_add->RightColumnClass ?>"><div<?php echo $skill_register->SkillName->CellAttributes() ?>>
<span id="el_skill_register_SkillName">
<textarea data-table="skill_register" data-field="x_SkillName" name="x_SkillName" id="x_SkillName" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($skill_register->SkillName->getPlaceHolder()) ?>"<?php echo $skill_register->SkillName->EditAttributes() ?>><?php echo $skill_register->SkillName->EditValue ?></textarea>
</span>
<?php echo $skill_register->SkillName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skill_register->Proficiency->Visible) { // Proficiency ?>
	<div id="r_Proficiency" class="form-group">
		<label id="elh_skill_register_Proficiency" for="x_Proficiency" class="<?php echo $skill_register_add->LeftColumnClass ?>"><?php echo $skill_register->Proficiency->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $skill_register_add->RightColumnClass ?>"><div<?php echo $skill_register->Proficiency->CellAttributes() ?>>
<span id="el_skill_register_Proficiency">
<textarea data-table="skill_register" data-field="x_Proficiency" name="x_Proficiency" id="x_Proficiency" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($skill_register->Proficiency->getPlaceHolder()) ?>"<?php echo $skill_register->Proficiency->EditAttributes() ?>><?php echo $skill_register->Proficiency->EditValue ?></textarea>
</span>
<?php echo $skill_register->Proficiency->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skill_register->LastUseDate->Visible) { // LastUseDate ?>
	<div id="r_LastUseDate" class="form-group">
		<label id="elh_skill_register_LastUseDate" for="x_LastUseDate" class="<?php echo $skill_register_add->LeftColumnClass ?>"><?php echo $skill_register->LastUseDate->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $skill_register_add->RightColumnClass ?>"><div<?php echo $skill_register->LastUseDate->CellAttributes() ?>>
<span id="el_skill_register_LastUseDate">
<textarea data-table="skill_register" data-field="x_LastUseDate" name="x_LastUseDate" id="x_LastUseDate" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($skill_register->LastUseDate->getPlaceHolder()) ?>"<?php echo $skill_register->LastUseDate->EditAttributes() ?>><?php echo $skill_register->LastUseDate->EditValue ?></textarea>
</span>
<?php echo $skill_register->LastUseDate->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skill_register->Occupation->Visible) { // Occupation ?>
	<div id="r_Occupation" class="form-group">
		<label id="elh_skill_register_Occupation" for="x_Occupation" class="<?php echo $skill_register_add->LeftColumnClass ?>"><?php echo $skill_register->Occupation->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $skill_register_add->RightColumnClass ?>"><div<?php echo $skill_register->Occupation->CellAttributes() ?>>
<span id="el_skill_register_Occupation">
<textarea data-table="skill_register" data-field="x_Occupation" name="x_Occupation" id="x_Occupation" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($skill_register->Occupation->getPlaceHolder()) ?>"<?php echo $skill_register->Occupation->EditAttributes() ?>><?php echo $skill_register->Occupation->EditValue ?></textarea>
</span>
<?php echo $skill_register->Occupation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($skill_register->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_skill_register_DATETIME" for="x_DATETIME" class="<?php echo $skill_register_add->LeftColumnClass ?>"><?php echo $skill_register->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $skill_register_add->RightColumnClass ?>"><div<?php echo $skill_register->DATETIME->CellAttributes() ?>>
<span id="el_skill_register_DATETIME">
<input type="text" data-table="skill_register" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($skill_register->DATETIME->getPlaceHolder()) ?>" value="<?php echo $skill_register->DATETIME->EditValue ?>"<?php echo $skill_register->DATETIME->EditAttributes() ?>>
</span>
<?php echo $skill_register->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$skill_register_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $skill_register_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $skill_register_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fskill_registeradd.Init();
</script>
<?php
$skill_register_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$skill_register_add->Page_Terminate();
?>
