<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_taskinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_task_edit = NULL; // Initialize page object first

class cconfig_task_edit extends cconfig_task {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_task';

	// Page object name
	var $PageObjName = 'config_task_edit';

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

		// Table object (config_task)
		if (!isset($GLOBALS["config_task"]) || get_class($GLOBALS["config_task"]) == "cconfig_task") {
			$GLOBALS["config_task"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_task"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'config_task', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("config_tasklist.php"));
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
		$this->Title->SetVisibility();
		$this->LV->SetVisibility();
		$this->Type->SetVisibility();
		$this->ResetTime->SetVisibility();
		$this->ResetType->SetVisibility();
		$this->CompleteTask->SetVisibility();
		$this->Occupation->SetVisibility();
		$this->Target->SetVisibility();
		$this->Data->SetVisibility();
		$this->Reward_Gold->SetVisibility();
		$this->Reward_Diamonds->SetVisibility();
		$this->Reward_EXP->SetVisibility();
		$this->Reward_Goods->SetVisibility();
		$this->Info->SetVisibility();
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
		global $EW_EXPORT, $config_task;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_task);
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
					if ($pageName == "config_taskview.php")
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
					$this->Page_Terminate("config_tasklist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "config_tasklist.php")
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
		if (!$this->Title->FldIsDetailKey) {
			$this->Title->setFormValue($objForm->GetValue("x_Title"));
		}
		if (!$this->LV->FldIsDetailKey) {
			$this->LV->setFormValue($objForm->GetValue("x_LV"));
		}
		if (!$this->Type->FldIsDetailKey) {
			$this->Type->setFormValue($objForm->GetValue("x_Type"));
		}
		if (!$this->ResetTime->FldIsDetailKey) {
			$this->ResetTime->setFormValue($objForm->GetValue("x_ResetTime"));
		}
		if (!$this->ResetType->FldIsDetailKey) {
			$this->ResetType->setFormValue($objForm->GetValue("x_ResetType"));
		}
		if (!$this->CompleteTask->FldIsDetailKey) {
			$this->CompleteTask->setFormValue($objForm->GetValue("x_CompleteTask"));
		}
		if (!$this->Occupation->FldIsDetailKey) {
			$this->Occupation->setFormValue($objForm->GetValue("x_Occupation"));
		}
		if (!$this->Target->FldIsDetailKey) {
			$this->Target->setFormValue($objForm->GetValue("x_Target"));
		}
		if (!$this->Data->FldIsDetailKey) {
			$this->Data->setFormValue($objForm->GetValue("x_Data"));
		}
		if (!$this->Reward_Gold->FldIsDetailKey) {
			$this->Reward_Gold->setFormValue($objForm->GetValue("x_Reward_Gold"));
		}
		if (!$this->Reward_Diamonds->FldIsDetailKey) {
			$this->Reward_Diamonds->setFormValue($objForm->GetValue("x_Reward_Diamonds"));
		}
		if (!$this->Reward_EXP->FldIsDetailKey) {
			$this->Reward_EXP->setFormValue($objForm->GetValue("x_Reward_EXP"));
		}
		if (!$this->Reward_Goods->FldIsDetailKey) {
			$this->Reward_Goods->setFormValue($objForm->GetValue("x_Reward_Goods"));
		}
		if (!$this->Info->FldIsDetailKey) {
			$this->Info->setFormValue($objForm->GetValue("x_Info"));
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
		$this->Title->CurrentValue = $this->Title->FormValue;
		$this->LV->CurrentValue = $this->LV->FormValue;
		$this->Type->CurrentValue = $this->Type->FormValue;
		$this->ResetTime->CurrentValue = $this->ResetTime->FormValue;
		$this->ResetType->CurrentValue = $this->ResetType->FormValue;
		$this->CompleteTask->CurrentValue = $this->CompleteTask->FormValue;
		$this->Occupation->CurrentValue = $this->Occupation->FormValue;
		$this->Target->CurrentValue = $this->Target->FormValue;
		$this->Data->CurrentValue = $this->Data->FormValue;
		$this->Reward_Gold->CurrentValue = $this->Reward_Gold->FormValue;
		$this->Reward_Diamonds->CurrentValue = $this->Reward_Diamonds->FormValue;
		$this->Reward_EXP->CurrentValue = $this->Reward_EXP->FormValue;
		$this->Reward_Goods->CurrentValue = $this->Reward_Goods->FormValue;
		$this->Info->CurrentValue = $this->Info->FormValue;
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
		$this->Title->setDbValue($row['Title']);
		$this->LV->setDbValue($row['LV']);
		$this->Type->setDbValue($row['Type']);
		$this->ResetTime->setDbValue($row['ResetTime']);
		$this->ResetType->setDbValue($row['ResetType']);
		$this->CompleteTask->setDbValue($row['CompleteTask']);
		$this->Occupation->setDbValue($row['Occupation']);
		$this->Target->setDbValue($row['Target']);
		$this->Data->setDbValue($row['Data']);
		$this->Reward_Gold->setDbValue($row['Reward_Gold']);
		$this->Reward_Diamonds->setDbValue($row['Reward_Diamonds']);
		$this->Reward_EXP->setDbValue($row['Reward_EXP']);
		$this->Reward_Goods->setDbValue($row['Reward_Goods']);
		$this->Info->setDbValue($row['Info']);
		$this->DATETIME->setDbValue($row['DATETIME']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['Title'] = NULL;
		$row['LV'] = NULL;
		$row['Type'] = NULL;
		$row['ResetTime'] = NULL;
		$row['ResetType'] = NULL;
		$row['CompleteTask'] = NULL;
		$row['Occupation'] = NULL;
		$row['Target'] = NULL;
		$row['Data'] = NULL;
		$row['Reward_Gold'] = NULL;
		$row['Reward_Diamonds'] = NULL;
		$row['Reward_EXP'] = NULL;
		$row['Reward_Goods'] = NULL;
		$row['Info'] = NULL;
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
		$this->Title->DbValue = $row['Title'];
		$this->LV->DbValue = $row['LV'];
		$this->Type->DbValue = $row['Type'];
		$this->ResetTime->DbValue = $row['ResetTime'];
		$this->ResetType->DbValue = $row['ResetType'];
		$this->CompleteTask->DbValue = $row['CompleteTask'];
		$this->Occupation->DbValue = $row['Occupation'];
		$this->Target->DbValue = $row['Target'];
		$this->Data->DbValue = $row['Data'];
		$this->Reward_Gold->DbValue = $row['Reward_Gold'];
		$this->Reward_Diamonds->DbValue = $row['Reward_Diamonds'];
		$this->Reward_EXP->DbValue = $row['Reward_EXP'];
		$this->Reward_Goods->DbValue = $row['Reward_Goods'];
		$this->Info->DbValue = $row['Info'];
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

			// Title
			$this->Title->EditAttrs["class"] = "form-control";
			$this->Title->EditCustomAttributes = "";
			$this->Title->EditValue = ew_HtmlEncode($this->Title->CurrentValue);
			$this->Title->PlaceHolder = ew_RemoveHtml($this->Title->FldCaption());

			// LV
			$this->LV->EditAttrs["class"] = "form-control";
			$this->LV->EditCustomAttributes = "";
			$this->LV->EditValue = ew_HtmlEncode($this->LV->CurrentValue);
			$this->LV->PlaceHolder = ew_RemoveHtml($this->LV->FldCaption());

			// Type
			$this->Type->EditAttrs["class"] = "form-control";
			$this->Type->EditCustomAttributes = "";
			$this->Type->EditValue = ew_HtmlEncode($this->Type->CurrentValue);
			$this->Type->PlaceHolder = ew_RemoveHtml($this->Type->FldCaption());

			// ResetTime
			$this->ResetTime->EditAttrs["class"] = "form-control";
			$this->ResetTime->EditCustomAttributes = "";
			$this->ResetTime->EditValue = ew_HtmlEncode($this->ResetTime->CurrentValue);
			$this->ResetTime->PlaceHolder = ew_RemoveHtml($this->ResetTime->FldCaption());

			// ResetType
			$this->ResetType->EditAttrs["class"] = "form-control";
			$this->ResetType->EditCustomAttributes = "";
			$this->ResetType->EditValue = ew_HtmlEncode($this->ResetType->CurrentValue);
			$this->ResetType->PlaceHolder = ew_RemoveHtml($this->ResetType->FldCaption());

			// CompleteTask
			$this->CompleteTask->EditAttrs["class"] = "form-control";
			$this->CompleteTask->EditCustomAttributes = "";
			$this->CompleteTask->EditValue = ew_HtmlEncode($this->CompleteTask->CurrentValue);
			$this->CompleteTask->PlaceHolder = ew_RemoveHtml($this->CompleteTask->FldCaption());

			// Occupation
			$this->Occupation->EditAttrs["class"] = "form-control";
			$this->Occupation->EditCustomAttributes = "";
			$this->Occupation->EditValue = ew_HtmlEncode($this->Occupation->CurrentValue);
			$this->Occupation->PlaceHolder = ew_RemoveHtml($this->Occupation->FldCaption());

			// Target
			$this->Target->EditAttrs["class"] = "form-control";
			$this->Target->EditCustomAttributes = "";
			$this->Target->EditValue = ew_HtmlEncode($this->Target->CurrentValue);
			$this->Target->PlaceHolder = ew_RemoveHtml($this->Target->FldCaption());

			// Data
			$this->Data->EditAttrs["class"] = "form-control";
			$this->Data->EditCustomAttributes = "";
			$this->Data->EditValue = ew_HtmlEncode($this->Data->CurrentValue);
			$this->Data->PlaceHolder = ew_RemoveHtml($this->Data->FldCaption());

			// Reward_Gold
			$this->Reward_Gold->EditAttrs["class"] = "form-control";
			$this->Reward_Gold->EditCustomAttributes = "";
			$this->Reward_Gold->EditValue = ew_HtmlEncode($this->Reward_Gold->CurrentValue);
			$this->Reward_Gold->PlaceHolder = ew_RemoveHtml($this->Reward_Gold->FldCaption());

			// Reward_Diamonds
			$this->Reward_Diamonds->EditAttrs["class"] = "form-control";
			$this->Reward_Diamonds->EditCustomAttributes = "";
			$this->Reward_Diamonds->EditValue = ew_HtmlEncode($this->Reward_Diamonds->CurrentValue);
			$this->Reward_Diamonds->PlaceHolder = ew_RemoveHtml($this->Reward_Diamonds->FldCaption());

			// Reward_EXP
			$this->Reward_EXP->EditAttrs["class"] = "form-control";
			$this->Reward_EXP->EditCustomAttributes = "";
			$this->Reward_EXP->EditValue = ew_HtmlEncode($this->Reward_EXP->CurrentValue);
			$this->Reward_EXP->PlaceHolder = ew_RemoveHtml($this->Reward_EXP->FldCaption());

			// Reward_Goods
			$this->Reward_Goods->EditAttrs["class"] = "form-control";
			$this->Reward_Goods->EditCustomAttributes = "";
			$this->Reward_Goods->EditValue = ew_HtmlEncode($this->Reward_Goods->CurrentValue);
			$this->Reward_Goods->PlaceHolder = ew_RemoveHtml($this->Reward_Goods->FldCaption());

			// Info
			$this->Info->EditAttrs["class"] = "form-control";
			$this->Info->EditCustomAttributes = "";
			$this->Info->EditValue = ew_HtmlEncode($this->Info->CurrentValue);
			$this->Info->PlaceHolder = ew_RemoveHtml($this->Info->FldCaption());

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

			// Title
			$this->Title->LinkCustomAttributes = "";
			$this->Title->HrefValue = "";

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";

			// Type
			$this->Type->LinkCustomAttributes = "";
			$this->Type->HrefValue = "";

			// ResetTime
			$this->ResetTime->LinkCustomAttributes = "";
			$this->ResetTime->HrefValue = "";

			// ResetType
			$this->ResetType->LinkCustomAttributes = "";
			$this->ResetType->HrefValue = "";

			// CompleteTask
			$this->CompleteTask->LinkCustomAttributes = "";
			$this->CompleteTask->HrefValue = "";

			// Occupation
			$this->Occupation->LinkCustomAttributes = "";
			$this->Occupation->HrefValue = "";

			// Target
			$this->Target->LinkCustomAttributes = "";
			$this->Target->HrefValue = "";

			// Data
			$this->Data->LinkCustomAttributes = "";
			$this->Data->HrefValue = "";

			// Reward_Gold
			$this->Reward_Gold->LinkCustomAttributes = "";
			$this->Reward_Gold->HrefValue = "";

			// Reward_Diamonds
			$this->Reward_Diamonds->LinkCustomAttributes = "";
			$this->Reward_Diamonds->HrefValue = "";

			// Reward_EXP
			$this->Reward_EXP->LinkCustomAttributes = "";
			$this->Reward_EXP->HrefValue = "";

			// Reward_Goods
			$this->Reward_Goods->LinkCustomAttributes = "";
			$this->Reward_Goods->HrefValue = "";

			// Info
			$this->Info->LinkCustomAttributes = "";
			$this->Info->HrefValue = "";

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
		if (!$this->Title->FldIsDetailKey && !is_null($this->Title->FormValue) && $this->Title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Title->FldCaption(), $this->Title->ReqErrMsg));
		}
		if (!$this->LV->FldIsDetailKey && !is_null($this->LV->FormValue) && $this->LV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->LV->FldCaption(), $this->LV->ReqErrMsg));
		}
		if (!$this->Type->FldIsDetailKey && !is_null($this->Type->FormValue) && $this->Type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Type->FldCaption(), $this->Type->ReqErrMsg));
		}
		if (!$this->ResetTime->FldIsDetailKey && !is_null($this->ResetTime->FormValue) && $this->ResetTime->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ResetTime->FldCaption(), $this->ResetTime->ReqErrMsg));
		}
		if (!$this->ResetType->FldIsDetailKey && !is_null($this->ResetType->FormValue) && $this->ResetType->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ResetType->FldCaption(), $this->ResetType->ReqErrMsg));
		}
		if (!$this->CompleteTask->FldIsDetailKey && !is_null($this->CompleteTask->FormValue) && $this->CompleteTask->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->CompleteTask->FldCaption(), $this->CompleteTask->ReqErrMsg));
		}
		if (!$this->Occupation->FldIsDetailKey && !is_null($this->Occupation->FormValue) && $this->Occupation->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Occupation->FldCaption(), $this->Occupation->ReqErrMsg));
		}
		if (!$this->Target->FldIsDetailKey && !is_null($this->Target->FormValue) && $this->Target->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Target->FldCaption(), $this->Target->ReqErrMsg));
		}
		if (!$this->Data->FldIsDetailKey && !is_null($this->Data->FormValue) && $this->Data->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Data->FldCaption(), $this->Data->ReqErrMsg));
		}
		if (!$this->Reward_Gold->FldIsDetailKey && !is_null($this->Reward_Gold->FormValue) && $this->Reward_Gold->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Reward_Gold->FldCaption(), $this->Reward_Gold->ReqErrMsg));
		}
		if (!$this->Reward_Diamonds->FldIsDetailKey && !is_null($this->Reward_Diamonds->FormValue) && $this->Reward_Diamonds->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Reward_Diamonds->FldCaption(), $this->Reward_Diamonds->ReqErrMsg));
		}
		if (!$this->Reward_EXP->FldIsDetailKey && !is_null($this->Reward_EXP->FormValue) && $this->Reward_EXP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Reward_EXP->FldCaption(), $this->Reward_EXP->ReqErrMsg));
		}
		if (!$this->Reward_Goods->FldIsDetailKey && !is_null($this->Reward_Goods->FormValue) && $this->Reward_Goods->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Reward_Goods->FldCaption(), $this->Reward_Goods->ReqErrMsg));
		}
		if (!$this->Info->FldIsDetailKey && !is_null($this->Info->FormValue) && $this->Info->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Info->FldCaption(), $this->Info->ReqErrMsg));
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

			// Title
			$this->Title->SetDbValueDef($rsnew, $this->Title->CurrentValue, "", $this->Title->ReadOnly);

			// LV
			$this->LV->SetDbValueDef($rsnew, $this->LV->CurrentValue, "", $this->LV->ReadOnly);

			// Type
			$this->Type->SetDbValueDef($rsnew, $this->Type->CurrentValue, "", $this->Type->ReadOnly);

			// ResetTime
			$this->ResetTime->SetDbValueDef($rsnew, $this->ResetTime->CurrentValue, "", $this->ResetTime->ReadOnly);

			// ResetType
			$this->ResetType->SetDbValueDef($rsnew, $this->ResetType->CurrentValue, "", $this->ResetType->ReadOnly);

			// CompleteTask
			$this->CompleteTask->SetDbValueDef($rsnew, $this->CompleteTask->CurrentValue, "", $this->CompleteTask->ReadOnly);

			// Occupation
			$this->Occupation->SetDbValueDef($rsnew, $this->Occupation->CurrentValue, "", $this->Occupation->ReadOnly);

			// Target
			$this->Target->SetDbValueDef($rsnew, $this->Target->CurrentValue, "", $this->Target->ReadOnly);

			// Data
			$this->Data->SetDbValueDef($rsnew, $this->Data->CurrentValue, "", $this->Data->ReadOnly);

			// Reward_Gold
			$this->Reward_Gold->SetDbValueDef($rsnew, $this->Reward_Gold->CurrentValue, "", $this->Reward_Gold->ReadOnly);

			// Reward_Diamonds
			$this->Reward_Diamonds->SetDbValueDef($rsnew, $this->Reward_Diamonds->CurrentValue, "", $this->Reward_Diamonds->ReadOnly);

			// Reward_EXP
			$this->Reward_EXP->SetDbValueDef($rsnew, $this->Reward_EXP->CurrentValue, "", $this->Reward_EXP->ReadOnly);

			// Reward_Goods
			$this->Reward_Goods->SetDbValueDef($rsnew, $this->Reward_Goods->CurrentValue, "", $this->Reward_Goods->ReadOnly);

			// Info
			$this->Info->SetDbValueDef($rsnew, $this->Info->CurrentValue, "", $this->Info->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_tasklist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_task_edit)) $config_task_edit = new cconfig_task_edit();

// Page init
$config_task_edit->Page_Init();

// Page main
$config_task_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_task_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fconfig_taskedit = new ew_Form("fconfig_taskedit", "edit");

// Validate form
fconfig_taskedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->u_id->FldCaption(), $config_task->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_task->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->acl_id->FldCaption(), $config_task->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_task->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->Title->FldCaption(), $config_task->Title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->LV->FldCaption(), $config_task->LV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->Type->FldCaption(), $config_task->Type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ResetTime");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->ResetTime->FldCaption(), $config_task->ResetTime->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ResetType");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->ResetType->FldCaption(), $config_task->ResetType->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_CompleteTask");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->CompleteTask->FldCaption(), $config_task->CompleteTask->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Occupation");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->Occupation->FldCaption(), $config_task->Occupation->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Target");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->Target->FldCaption(), $config_task->Target->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Data");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->Data->FldCaption(), $config_task->Data->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Reward_Gold");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->Reward_Gold->FldCaption(), $config_task->Reward_Gold->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Reward_Diamonds");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->Reward_Diamonds->FldCaption(), $config_task->Reward_Diamonds->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Reward_EXP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->Reward_EXP->FldCaption(), $config_task->Reward_EXP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Reward_Goods");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->Reward_Goods->FldCaption(), $config_task->Reward_Goods->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Info");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->Info->FldCaption(), $config_task->Info->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_task->DATETIME->FldCaption(), $config_task->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_task->DATETIME->FldErrMsg()) ?>");

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
fconfig_taskedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_taskedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $config_task_edit->ShowPageHeader(); ?>
<?php
$config_task_edit->ShowMessage();
?>
<form name="fconfig_taskedit" id="fconfig_taskedit" class="<?php echo $config_task_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_task_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_task_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_task">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($config_task_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($config_task->unid->Visible) { // unid ?>
	<div id="r_unid" class="form-group">
		<label id="elh_config_task_unid" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->unid->FldCaption() ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->unid->CellAttributes() ?>>
<span id="el_config_task_unid">
<span<?php echo $config_task->unid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $config_task->unid->EditValue ?></p></span>
</span>
<input type="hidden" data-table="config_task" data-field="x_unid" name="x_unid" id="x_unid" value="<?php echo ew_HtmlEncode($config_task->unid->CurrentValue) ?>">
<?php echo $config_task->unid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_config_task_u_id" for="x_u_id" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->u_id->CellAttributes() ?>>
<span id="el_config_task_u_id">
<input type="text" data-table="config_task" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_task->u_id->getPlaceHolder()) ?>" value="<?php echo $config_task->u_id->EditValue ?>"<?php echo $config_task->u_id->EditAttributes() ?>>
</span>
<?php echo $config_task->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_config_task_acl_id" for="x_acl_id" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->acl_id->CellAttributes() ?>>
<span id="el_config_task_acl_id">
<input type="text" data-table="config_task" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_task->acl_id->getPlaceHolder()) ?>" value="<?php echo $config_task->acl_id->EditValue ?>"<?php echo $config_task->acl_id->EditAttributes() ?>>
</span>
<?php echo $config_task->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->Title->Visible) { // Title ?>
	<div id="r_Title" class="form-group">
		<label id="elh_config_task_Title" for="x_Title" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->Title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->Title->CellAttributes() ?>>
<span id="el_config_task_Title">
<textarea data-table="config_task" data-field="x_Title" name="x_Title" id="x_Title" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->Title->getPlaceHolder()) ?>"<?php echo $config_task->Title->EditAttributes() ?>><?php echo $config_task->Title->EditValue ?></textarea>
</span>
<?php echo $config_task->Title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->LV->Visible) { // LV ?>
	<div id="r_LV" class="form-group">
		<label id="elh_config_task_LV" for="x_LV" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->LV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->LV->CellAttributes() ?>>
<span id="el_config_task_LV">
<textarea data-table="config_task" data-field="x_LV" name="x_LV" id="x_LV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->LV->getPlaceHolder()) ?>"<?php echo $config_task->LV->EditAttributes() ?>><?php echo $config_task->LV->EditValue ?></textarea>
</span>
<?php echo $config_task->LV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->Type->Visible) { // Type ?>
	<div id="r_Type" class="form-group">
		<label id="elh_config_task_Type" for="x_Type" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->Type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->Type->CellAttributes() ?>>
<span id="el_config_task_Type">
<textarea data-table="config_task" data-field="x_Type" name="x_Type" id="x_Type" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->Type->getPlaceHolder()) ?>"<?php echo $config_task->Type->EditAttributes() ?>><?php echo $config_task->Type->EditValue ?></textarea>
</span>
<?php echo $config_task->Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->ResetTime->Visible) { // ResetTime ?>
	<div id="r_ResetTime" class="form-group">
		<label id="elh_config_task_ResetTime" for="x_ResetTime" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->ResetTime->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->ResetTime->CellAttributes() ?>>
<span id="el_config_task_ResetTime">
<textarea data-table="config_task" data-field="x_ResetTime" name="x_ResetTime" id="x_ResetTime" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->ResetTime->getPlaceHolder()) ?>"<?php echo $config_task->ResetTime->EditAttributes() ?>><?php echo $config_task->ResetTime->EditValue ?></textarea>
</span>
<?php echo $config_task->ResetTime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->ResetType->Visible) { // ResetType ?>
	<div id="r_ResetType" class="form-group">
		<label id="elh_config_task_ResetType" for="x_ResetType" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->ResetType->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->ResetType->CellAttributes() ?>>
<span id="el_config_task_ResetType">
<textarea data-table="config_task" data-field="x_ResetType" name="x_ResetType" id="x_ResetType" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->ResetType->getPlaceHolder()) ?>"<?php echo $config_task->ResetType->EditAttributes() ?>><?php echo $config_task->ResetType->EditValue ?></textarea>
</span>
<?php echo $config_task->ResetType->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->CompleteTask->Visible) { // CompleteTask ?>
	<div id="r_CompleteTask" class="form-group">
		<label id="elh_config_task_CompleteTask" for="x_CompleteTask" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->CompleteTask->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->CompleteTask->CellAttributes() ?>>
<span id="el_config_task_CompleteTask">
<textarea data-table="config_task" data-field="x_CompleteTask" name="x_CompleteTask" id="x_CompleteTask" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->CompleteTask->getPlaceHolder()) ?>"<?php echo $config_task->CompleteTask->EditAttributes() ?>><?php echo $config_task->CompleteTask->EditValue ?></textarea>
</span>
<?php echo $config_task->CompleteTask->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->Occupation->Visible) { // Occupation ?>
	<div id="r_Occupation" class="form-group">
		<label id="elh_config_task_Occupation" for="x_Occupation" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->Occupation->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->Occupation->CellAttributes() ?>>
<span id="el_config_task_Occupation">
<textarea data-table="config_task" data-field="x_Occupation" name="x_Occupation" id="x_Occupation" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->Occupation->getPlaceHolder()) ?>"<?php echo $config_task->Occupation->EditAttributes() ?>><?php echo $config_task->Occupation->EditValue ?></textarea>
</span>
<?php echo $config_task->Occupation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->Target->Visible) { // Target ?>
	<div id="r_Target" class="form-group">
		<label id="elh_config_task_Target" for="x_Target" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->Target->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->Target->CellAttributes() ?>>
<span id="el_config_task_Target">
<textarea data-table="config_task" data-field="x_Target" name="x_Target" id="x_Target" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->Target->getPlaceHolder()) ?>"<?php echo $config_task->Target->EditAttributes() ?>><?php echo $config_task->Target->EditValue ?></textarea>
</span>
<?php echo $config_task->Target->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->Data->Visible) { // Data ?>
	<div id="r_Data" class="form-group">
		<label id="elh_config_task_Data" for="x_Data" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->Data->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->Data->CellAttributes() ?>>
<span id="el_config_task_Data">
<textarea data-table="config_task" data-field="x_Data" name="x_Data" id="x_Data" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->Data->getPlaceHolder()) ?>"<?php echo $config_task->Data->EditAttributes() ?>><?php echo $config_task->Data->EditValue ?></textarea>
</span>
<?php echo $config_task->Data->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->Reward_Gold->Visible) { // Reward_Gold ?>
	<div id="r_Reward_Gold" class="form-group">
		<label id="elh_config_task_Reward_Gold" for="x_Reward_Gold" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->Reward_Gold->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->Reward_Gold->CellAttributes() ?>>
<span id="el_config_task_Reward_Gold">
<textarea data-table="config_task" data-field="x_Reward_Gold" name="x_Reward_Gold" id="x_Reward_Gold" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->Reward_Gold->getPlaceHolder()) ?>"<?php echo $config_task->Reward_Gold->EditAttributes() ?>><?php echo $config_task->Reward_Gold->EditValue ?></textarea>
</span>
<?php echo $config_task->Reward_Gold->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->Reward_Diamonds->Visible) { // Reward_Diamonds ?>
	<div id="r_Reward_Diamonds" class="form-group">
		<label id="elh_config_task_Reward_Diamonds" for="x_Reward_Diamonds" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->Reward_Diamonds->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->Reward_Diamonds->CellAttributes() ?>>
<span id="el_config_task_Reward_Diamonds">
<textarea data-table="config_task" data-field="x_Reward_Diamonds" name="x_Reward_Diamonds" id="x_Reward_Diamonds" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->Reward_Diamonds->getPlaceHolder()) ?>"<?php echo $config_task->Reward_Diamonds->EditAttributes() ?>><?php echo $config_task->Reward_Diamonds->EditValue ?></textarea>
</span>
<?php echo $config_task->Reward_Diamonds->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->Reward_EXP->Visible) { // Reward_EXP ?>
	<div id="r_Reward_EXP" class="form-group">
		<label id="elh_config_task_Reward_EXP" for="x_Reward_EXP" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->Reward_EXP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->Reward_EXP->CellAttributes() ?>>
<span id="el_config_task_Reward_EXP">
<textarea data-table="config_task" data-field="x_Reward_EXP" name="x_Reward_EXP" id="x_Reward_EXP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->Reward_EXP->getPlaceHolder()) ?>"<?php echo $config_task->Reward_EXP->EditAttributes() ?>><?php echo $config_task->Reward_EXP->EditValue ?></textarea>
</span>
<?php echo $config_task->Reward_EXP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->Reward_Goods->Visible) { // Reward_Goods ?>
	<div id="r_Reward_Goods" class="form-group">
		<label id="elh_config_task_Reward_Goods" for="x_Reward_Goods" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->Reward_Goods->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->Reward_Goods->CellAttributes() ?>>
<span id="el_config_task_Reward_Goods">
<textarea data-table="config_task" data-field="x_Reward_Goods" name="x_Reward_Goods" id="x_Reward_Goods" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->Reward_Goods->getPlaceHolder()) ?>"<?php echo $config_task->Reward_Goods->EditAttributes() ?>><?php echo $config_task->Reward_Goods->EditValue ?></textarea>
</span>
<?php echo $config_task->Reward_Goods->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->Info->Visible) { // Info ?>
	<div id="r_Info" class="form-group">
		<label id="elh_config_task_Info" for="x_Info" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->Info->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->Info->CellAttributes() ?>>
<span id="el_config_task_Info">
<textarea data-table="config_task" data-field="x_Info" name="x_Info" id="x_Info" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_task->Info->getPlaceHolder()) ?>"<?php echo $config_task->Info->EditAttributes() ?>><?php echo $config_task->Info->EditValue ?></textarea>
</span>
<?php echo $config_task->Info->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_task->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_config_task_DATETIME" for="x_DATETIME" class="<?php echo $config_task_edit->LeftColumnClass ?>"><?php echo $config_task->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_task_edit->RightColumnClass ?>"><div<?php echo $config_task->DATETIME->CellAttributes() ?>>
<span id="el_config_task_DATETIME">
<input type="text" data-table="config_task" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($config_task->DATETIME->getPlaceHolder()) ?>" value="<?php echo $config_task->DATETIME->EditValue ?>"<?php echo $config_task->DATETIME->EditAttributes() ?>>
</span>
<?php echo $config_task->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$config_task_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $config_task_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $config_task_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fconfig_taskedit.Init();
</script>
<?php
$config_task_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_task_edit->Page_Terminate();
?>
