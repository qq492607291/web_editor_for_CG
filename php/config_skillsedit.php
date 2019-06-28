<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_skillsinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_skills_edit = NULL; // Initialize page object first

class cconfig_skills_edit extends cconfig_skills {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_skills';

	// Page object name
	var $PageObjName = 'config_skills_edit';

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

		// Table object (config_skills)
		if (!isset($GLOBALS["config_skills"]) || get_class($GLOBALS["config_skills"]) == "cconfig_skills") {
			$GLOBALS["config_skills"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_skills"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'config_skills', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("config_skillslist.php"));
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
		$this->Type->SetVisibility();
		$this->Consume->SetVisibility();
		$this->Effect->SetVisibility();
		$this->EO->SetVisibility();
		$this->LV->SetVisibility();
		$this->ConsumeType->SetVisibility();
		$this->Cooling->SetVisibility();
		$this->Accurate->SetVisibility();
		$this->AttackTips->SetVisibility();
		$this->Introduce->SetVisibility();
		$this->ACS->SetVisibility();
		$this->Shield->SetVisibility();
		$this->IgnoreShield->SetVisibility();
		$this->IgnoreIM->SetVisibility();
		$this->IgnoreRE->SetVisibility();
		$this->BanAbsorb->SetVisibility();
		$this->BanMultipleShot->SetVisibility();
		$this->ProhibitUO->SetVisibility();
		$this->ConsumableGoods->SetVisibility();
		$this->Continued_Round->SetVisibility();
		$this->Continued_Type->SetVisibility();
		$this->Continued_Effect->SetVisibility();
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
		global $EW_EXPORT, $config_skills;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_skills);
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
					if ($pageName == "config_skillsview.php")
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
					$this->Page_Terminate("config_skillslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "config_skillslist.php")
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
		if (!$this->Type->FldIsDetailKey) {
			$this->Type->setFormValue($objForm->GetValue("x_Type"));
		}
		if (!$this->Consume->FldIsDetailKey) {
			$this->Consume->setFormValue($objForm->GetValue("x_Consume"));
		}
		if (!$this->Effect->FldIsDetailKey) {
			$this->Effect->setFormValue($objForm->GetValue("x_Effect"));
		}
		if (!$this->EO->FldIsDetailKey) {
			$this->EO->setFormValue($objForm->GetValue("x_EO"));
		}
		if (!$this->LV->FldIsDetailKey) {
			$this->LV->setFormValue($objForm->GetValue("x_LV"));
		}
		if (!$this->ConsumeType->FldIsDetailKey) {
			$this->ConsumeType->setFormValue($objForm->GetValue("x_ConsumeType"));
		}
		if (!$this->Cooling->FldIsDetailKey) {
			$this->Cooling->setFormValue($objForm->GetValue("x_Cooling"));
		}
		if (!$this->Accurate->FldIsDetailKey) {
			$this->Accurate->setFormValue($objForm->GetValue("x_Accurate"));
		}
		if (!$this->AttackTips->FldIsDetailKey) {
			$this->AttackTips->setFormValue($objForm->GetValue("x_AttackTips"));
		}
		if (!$this->Introduce->FldIsDetailKey) {
			$this->Introduce->setFormValue($objForm->GetValue("x_Introduce"));
		}
		if (!$this->ACS->FldIsDetailKey) {
			$this->ACS->setFormValue($objForm->GetValue("x_ACS"));
		}
		if (!$this->Shield->FldIsDetailKey) {
			$this->Shield->setFormValue($objForm->GetValue("x_Shield"));
		}
		if (!$this->IgnoreShield->FldIsDetailKey) {
			$this->IgnoreShield->setFormValue($objForm->GetValue("x_IgnoreShield"));
		}
		if (!$this->IgnoreIM->FldIsDetailKey) {
			$this->IgnoreIM->setFormValue($objForm->GetValue("x_IgnoreIM"));
		}
		if (!$this->IgnoreRE->FldIsDetailKey) {
			$this->IgnoreRE->setFormValue($objForm->GetValue("x_IgnoreRE"));
		}
		if (!$this->BanAbsorb->FldIsDetailKey) {
			$this->BanAbsorb->setFormValue($objForm->GetValue("x_BanAbsorb"));
		}
		if (!$this->BanMultipleShot->FldIsDetailKey) {
			$this->BanMultipleShot->setFormValue($objForm->GetValue("x_BanMultipleShot"));
		}
		if (!$this->ProhibitUO->FldIsDetailKey) {
			$this->ProhibitUO->setFormValue($objForm->GetValue("x_ProhibitUO"));
		}
		if (!$this->ConsumableGoods->FldIsDetailKey) {
			$this->ConsumableGoods->setFormValue($objForm->GetValue("x_ConsumableGoods"));
		}
		if (!$this->Continued_Round->FldIsDetailKey) {
			$this->Continued_Round->setFormValue($objForm->GetValue("x_Continued_Round"));
		}
		if (!$this->Continued_Type->FldIsDetailKey) {
			$this->Continued_Type->setFormValue($objForm->GetValue("x_Continued_Type"));
		}
		if (!$this->Continued_Effect->FldIsDetailKey) {
			$this->Continued_Effect->setFormValue($objForm->GetValue("x_Continued_Effect"));
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
		$this->Type->CurrentValue = $this->Type->FormValue;
		$this->Consume->CurrentValue = $this->Consume->FormValue;
		$this->Effect->CurrentValue = $this->Effect->FormValue;
		$this->EO->CurrentValue = $this->EO->FormValue;
		$this->LV->CurrentValue = $this->LV->FormValue;
		$this->ConsumeType->CurrentValue = $this->ConsumeType->FormValue;
		$this->Cooling->CurrentValue = $this->Cooling->FormValue;
		$this->Accurate->CurrentValue = $this->Accurate->FormValue;
		$this->AttackTips->CurrentValue = $this->AttackTips->FormValue;
		$this->Introduce->CurrentValue = $this->Introduce->FormValue;
		$this->ACS->CurrentValue = $this->ACS->FormValue;
		$this->Shield->CurrentValue = $this->Shield->FormValue;
		$this->IgnoreShield->CurrentValue = $this->IgnoreShield->FormValue;
		$this->IgnoreIM->CurrentValue = $this->IgnoreIM->FormValue;
		$this->IgnoreRE->CurrentValue = $this->IgnoreRE->FormValue;
		$this->BanAbsorb->CurrentValue = $this->BanAbsorb->FormValue;
		$this->BanMultipleShot->CurrentValue = $this->BanMultipleShot->FormValue;
		$this->ProhibitUO->CurrentValue = $this->ProhibitUO->FormValue;
		$this->ConsumableGoods->CurrentValue = $this->ConsumableGoods->FormValue;
		$this->Continued_Round->CurrentValue = $this->Continued_Round->FormValue;
		$this->Continued_Type->CurrentValue = $this->Continued_Type->FormValue;
		$this->Continued_Effect->CurrentValue = $this->Continued_Effect->FormValue;
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
		$this->Type->setDbValue($row['Type']);
		$this->Consume->setDbValue($row['Consume']);
		$this->Effect->setDbValue($row['Effect']);
		$this->EO->setDbValue($row['EO']);
		$this->LV->setDbValue($row['LV']);
		$this->ConsumeType->setDbValue($row['ConsumeType']);
		$this->Cooling->setDbValue($row['Cooling']);
		$this->Accurate->setDbValue($row['Accurate']);
		$this->AttackTips->setDbValue($row['AttackTips']);
		$this->Introduce->setDbValue($row['Introduce']);
		$this->ACS->setDbValue($row['ACS']);
		$this->Shield->setDbValue($row['Shield']);
		$this->IgnoreShield->setDbValue($row['IgnoreShield']);
		$this->IgnoreIM->setDbValue($row['IgnoreIM']);
		$this->IgnoreRE->setDbValue($row['IgnoreRE']);
		$this->BanAbsorb->setDbValue($row['BanAbsorb']);
		$this->BanMultipleShot->setDbValue($row['BanMultipleShot']);
		$this->ProhibitUO->setDbValue($row['ProhibitUO']);
		$this->ConsumableGoods->setDbValue($row['ConsumableGoods']);
		$this->Continued_Round->setDbValue($row['Continued_Round']);
		$this->Continued_Type->setDbValue($row['Continued_Type']);
		$this->Continued_Effect->setDbValue($row['Continued_Effect']);
		$this->DATETIME->setDbValue($row['DATETIME']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['Name'] = NULL;
		$row['Type'] = NULL;
		$row['Consume'] = NULL;
		$row['Effect'] = NULL;
		$row['EO'] = NULL;
		$row['LV'] = NULL;
		$row['ConsumeType'] = NULL;
		$row['Cooling'] = NULL;
		$row['Accurate'] = NULL;
		$row['AttackTips'] = NULL;
		$row['Introduce'] = NULL;
		$row['ACS'] = NULL;
		$row['Shield'] = NULL;
		$row['IgnoreShield'] = NULL;
		$row['IgnoreIM'] = NULL;
		$row['IgnoreRE'] = NULL;
		$row['BanAbsorb'] = NULL;
		$row['BanMultipleShot'] = NULL;
		$row['ProhibitUO'] = NULL;
		$row['ConsumableGoods'] = NULL;
		$row['Continued_Round'] = NULL;
		$row['Continued_Type'] = NULL;
		$row['Continued_Effect'] = NULL;
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
		$this->Type->DbValue = $row['Type'];
		$this->Consume->DbValue = $row['Consume'];
		$this->Effect->DbValue = $row['Effect'];
		$this->EO->DbValue = $row['EO'];
		$this->LV->DbValue = $row['LV'];
		$this->ConsumeType->DbValue = $row['ConsumeType'];
		$this->Cooling->DbValue = $row['Cooling'];
		$this->Accurate->DbValue = $row['Accurate'];
		$this->AttackTips->DbValue = $row['AttackTips'];
		$this->Introduce->DbValue = $row['Introduce'];
		$this->ACS->DbValue = $row['ACS'];
		$this->Shield->DbValue = $row['Shield'];
		$this->IgnoreShield->DbValue = $row['IgnoreShield'];
		$this->IgnoreIM->DbValue = $row['IgnoreIM'];
		$this->IgnoreRE->DbValue = $row['IgnoreRE'];
		$this->BanAbsorb->DbValue = $row['BanAbsorb'];
		$this->BanMultipleShot->DbValue = $row['BanMultipleShot'];
		$this->ProhibitUO->DbValue = $row['ProhibitUO'];
		$this->ConsumableGoods->DbValue = $row['ConsumableGoods'];
		$this->Continued_Round->DbValue = $row['Continued_Round'];
		$this->Continued_Type->DbValue = $row['Continued_Type'];
		$this->Continued_Effect->DbValue = $row['Continued_Effect'];
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
		// Type
		// Consume
		// Effect
		// EO
		// LV
		// ConsumeType
		// Cooling
		// Accurate
		// AttackTips
		// Introduce
		// ACS
		// Shield
		// IgnoreShield
		// IgnoreIM
		// IgnoreRE
		// BanAbsorb
		// BanMultipleShot
		// ProhibitUO
		// ConsumableGoods
		// Continued_Round
		// Continued_Type
		// Continued_Effect
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

		// Type
		$this->Type->ViewValue = $this->Type->CurrentValue;
		$this->Type->ViewCustomAttributes = "";

		// Consume
		$this->Consume->ViewValue = $this->Consume->CurrentValue;
		$this->Consume->ViewCustomAttributes = "";

		// Effect
		$this->Effect->ViewValue = $this->Effect->CurrentValue;
		$this->Effect->ViewCustomAttributes = "";

		// EO
		$this->EO->ViewValue = $this->EO->CurrentValue;
		$this->EO->ViewCustomAttributes = "";

		// LV
		$this->LV->ViewValue = $this->LV->CurrentValue;
		$this->LV->ViewCustomAttributes = "";

		// ConsumeType
		$this->ConsumeType->ViewValue = $this->ConsumeType->CurrentValue;
		$this->ConsumeType->ViewCustomAttributes = "";

		// Cooling
		$this->Cooling->ViewValue = $this->Cooling->CurrentValue;
		$this->Cooling->ViewCustomAttributes = "";

		// Accurate
		$this->Accurate->ViewValue = $this->Accurate->CurrentValue;
		$this->Accurate->ViewCustomAttributes = "";

		// AttackTips
		$this->AttackTips->ViewValue = $this->AttackTips->CurrentValue;
		$this->AttackTips->ViewCustomAttributes = "";

		// Introduce
		$this->Introduce->ViewValue = $this->Introduce->CurrentValue;
		$this->Introduce->ViewCustomAttributes = "";

		// ACS
		$this->ACS->ViewValue = $this->ACS->CurrentValue;
		$this->ACS->ViewCustomAttributes = "";

		// Shield
		$this->Shield->ViewValue = $this->Shield->CurrentValue;
		$this->Shield->ViewCustomAttributes = "";

		// IgnoreShield
		$this->IgnoreShield->ViewValue = $this->IgnoreShield->CurrentValue;
		$this->IgnoreShield->ViewCustomAttributes = "";

		// IgnoreIM
		$this->IgnoreIM->ViewValue = $this->IgnoreIM->CurrentValue;
		$this->IgnoreIM->ViewCustomAttributes = "";

		// IgnoreRE
		$this->IgnoreRE->ViewValue = $this->IgnoreRE->CurrentValue;
		$this->IgnoreRE->ViewCustomAttributes = "";

		// BanAbsorb
		$this->BanAbsorb->ViewValue = $this->BanAbsorb->CurrentValue;
		$this->BanAbsorb->ViewCustomAttributes = "";

		// BanMultipleShot
		$this->BanMultipleShot->ViewValue = $this->BanMultipleShot->CurrentValue;
		$this->BanMultipleShot->ViewCustomAttributes = "";

		// ProhibitUO
		$this->ProhibitUO->ViewValue = $this->ProhibitUO->CurrentValue;
		$this->ProhibitUO->ViewCustomAttributes = "";

		// ConsumableGoods
		$this->ConsumableGoods->ViewValue = $this->ConsumableGoods->CurrentValue;
		$this->ConsumableGoods->ViewCustomAttributes = "";

		// Continued_Round
		$this->Continued_Round->ViewValue = $this->Continued_Round->CurrentValue;
		$this->Continued_Round->ViewCustomAttributes = "";

		// Continued_Type
		$this->Continued_Type->ViewValue = $this->Continued_Type->CurrentValue;
		$this->Continued_Type->ViewCustomAttributes = "";

		// Continued_Effect
		$this->Continued_Effect->ViewValue = $this->Continued_Effect->CurrentValue;
		$this->Continued_Effect->ViewCustomAttributes = "";

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

			// Type
			$this->Type->LinkCustomAttributes = "";
			$this->Type->HrefValue = "";
			$this->Type->TooltipValue = "";

			// Consume
			$this->Consume->LinkCustomAttributes = "";
			$this->Consume->HrefValue = "";
			$this->Consume->TooltipValue = "";

			// Effect
			$this->Effect->LinkCustomAttributes = "";
			$this->Effect->HrefValue = "";
			$this->Effect->TooltipValue = "";

			// EO
			$this->EO->LinkCustomAttributes = "";
			$this->EO->HrefValue = "";
			$this->EO->TooltipValue = "";

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";
			$this->LV->TooltipValue = "";

			// ConsumeType
			$this->ConsumeType->LinkCustomAttributes = "";
			$this->ConsumeType->HrefValue = "";
			$this->ConsumeType->TooltipValue = "";

			// Cooling
			$this->Cooling->LinkCustomAttributes = "";
			$this->Cooling->HrefValue = "";
			$this->Cooling->TooltipValue = "";

			// Accurate
			$this->Accurate->LinkCustomAttributes = "";
			$this->Accurate->HrefValue = "";
			$this->Accurate->TooltipValue = "";

			// AttackTips
			$this->AttackTips->LinkCustomAttributes = "";
			$this->AttackTips->HrefValue = "";
			$this->AttackTips->TooltipValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";
			$this->Introduce->TooltipValue = "";

			// ACS
			$this->ACS->LinkCustomAttributes = "";
			$this->ACS->HrefValue = "";
			$this->ACS->TooltipValue = "";

			// Shield
			$this->Shield->LinkCustomAttributes = "";
			$this->Shield->HrefValue = "";
			$this->Shield->TooltipValue = "";

			// IgnoreShield
			$this->IgnoreShield->LinkCustomAttributes = "";
			$this->IgnoreShield->HrefValue = "";
			$this->IgnoreShield->TooltipValue = "";

			// IgnoreIM
			$this->IgnoreIM->LinkCustomAttributes = "";
			$this->IgnoreIM->HrefValue = "";
			$this->IgnoreIM->TooltipValue = "";

			// IgnoreRE
			$this->IgnoreRE->LinkCustomAttributes = "";
			$this->IgnoreRE->HrefValue = "";
			$this->IgnoreRE->TooltipValue = "";

			// BanAbsorb
			$this->BanAbsorb->LinkCustomAttributes = "";
			$this->BanAbsorb->HrefValue = "";
			$this->BanAbsorb->TooltipValue = "";

			// BanMultipleShot
			$this->BanMultipleShot->LinkCustomAttributes = "";
			$this->BanMultipleShot->HrefValue = "";
			$this->BanMultipleShot->TooltipValue = "";

			// ProhibitUO
			$this->ProhibitUO->LinkCustomAttributes = "";
			$this->ProhibitUO->HrefValue = "";
			$this->ProhibitUO->TooltipValue = "";

			// ConsumableGoods
			$this->ConsumableGoods->LinkCustomAttributes = "";
			$this->ConsumableGoods->HrefValue = "";
			$this->ConsumableGoods->TooltipValue = "";

			// Continued_Round
			$this->Continued_Round->LinkCustomAttributes = "";
			$this->Continued_Round->HrefValue = "";
			$this->Continued_Round->TooltipValue = "";

			// Continued_Type
			$this->Continued_Type->LinkCustomAttributes = "";
			$this->Continued_Type->HrefValue = "";
			$this->Continued_Type->TooltipValue = "";

			// Continued_Effect
			$this->Continued_Effect->LinkCustomAttributes = "";
			$this->Continued_Effect->HrefValue = "";
			$this->Continued_Effect->TooltipValue = "";

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

			// Type
			$this->Type->EditAttrs["class"] = "form-control";
			$this->Type->EditCustomAttributes = "";
			$this->Type->EditValue = ew_HtmlEncode($this->Type->CurrentValue);
			$this->Type->PlaceHolder = ew_RemoveHtml($this->Type->FldCaption());

			// Consume
			$this->Consume->EditAttrs["class"] = "form-control";
			$this->Consume->EditCustomAttributes = "";
			$this->Consume->EditValue = ew_HtmlEncode($this->Consume->CurrentValue);
			$this->Consume->PlaceHolder = ew_RemoveHtml($this->Consume->FldCaption());

			// Effect
			$this->Effect->EditAttrs["class"] = "form-control";
			$this->Effect->EditCustomAttributes = "";
			$this->Effect->EditValue = ew_HtmlEncode($this->Effect->CurrentValue);
			$this->Effect->PlaceHolder = ew_RemoveHtml($this->Effect->FldCaption());

			// EO
			$this->EO->EditAttrs["class"] = "form-control";
			$this->EO->EditCustomAttributes = "";
			$this->EO->EditValue = ew_HtmlEncode($this->EO->CurrentValue);
			$this->EO->PlaceHolder = ew_RemoveHtml($this->EO->FldCaption());

			// LV
			$this->LV->EditAttrs["class"] = "form-control";
			$this->LV->EditCustomAttributes = "";
			$this->LV->EditValue = ew_HtmlEncode($this->LV->CurrentValue);
			$this->LV->PlaceHolder = ew_RemoveHtml($this->LV->FldCaption());

			// ConsumeType
			$this->ConsumeType->EditAttrs["class"] = "form-control";
			$this->ConsumeType->EditCustomAttributes = "";
			$this->ConsumeType->EditValue = ew_HtmlEncode($this->ConsumeType->CurrentValue);
			$this->ConsumeType->PlaceHolder = ew_RemoveHtml($this->ConsumeType->FldCaption());

			// Cooling
			$this->Cooling->EditAttrs["class"] = "form-control";
			$this->Cooling->EditCustomAttributes = "";
			$this->Cooling->EditValue = ew_HtmlEncode($this->Cooling->CurrentValue);
			$this->Cooling->PlaceHolder = ew_RemoveHtml($this->Cooling->FldCaption());

			// Accurate
			$this->Accurate->EditAttrs["class"] = "form-control";
			$this->Accurate->EditCustomAttributes = "";
			$this->Accurate->EditValue = ew_HtmlEncode($this->Accurate->CurrentValue);
			$this->Accurate->PlaceHolder = ew_RemoveHtml($this->Accurate->FldCaption());

			// AttackTips
			$this->AttackTips->EditAttrs["class"] = "form-control";
			$this->AttackTips->EditCustomAttributes = "";
			$this->AttackTips->EditValue = ew_HtmlEncode($this->AttackTips->CurrentValue);
			$this->AttackTips->PlaceHolder = ew_RemoveHtml($this->AttackTips->FldCaption());

			// Introduce
			$this->Introduce->EditAttrs["class"] = "form-control";
			$this->Introduce->EditCustomAttributes = "";
			$this->Introduce->EditValue = ew_HtmlEncode($this->Introduce->CurrentValue);
			$this->Introduce->PlaceHolder = ew_RemoveHtml($this->Introduce->FldCaption());

			// ACS
			$this->ACS->EditAttrs["class"] = "form-control";
			$this->ACS->EditCustomAttributes = "";
			$this->ACS->EditValue = ew_HtmlEncode($this->ACS->CurrentValue);
			$this->ACS->PlaceHolder = ew_RemoveHtml($this->ACS->FldCaption());

			// Shield
			$this->Shield->EditAttrs["class"] = "form-control";
			$this->Shield->EditCustomAttributes = "";
			$this->Shield->EditValue = ew_HtmlEncode($this->Shield->CurrentValue);
			$this->Shield->PlaceHolder = ew_RemoveHtml($this->Shield->FldCaption());

			// IgnoreShield
			$this->IgnoreShield->EditAttrs["class"] = "form-control";
			$this->IgnoreShield->EditCustomAttributes = "";
			$this->IgnoreShield->EditValue = ew_HtmlEncode($this->IgnoreShield->CurrentValue);
			$this->IgnoreShield->PlaceHolder = ew_RemoveHtml($this->IgnoreShield->FldCaption());

			// IgnoreIM
			$this->IgnoreIM->EditAttrs["class"] = "form-control";
			$this->IgnoreIM->EditCustomAttributes = "";
			$this->IgnoreIM->EditValue = ew_HtmlEncode($this->IgnoreIM->CurrentValue);
			$this->IgnoreIM->PlaceHolder = ew_RemoveHtml($this->IgnoreIM->FldCaption());

			// IgnoreRE
			$this->IgnoreRE->EditAttrs["class"] = "form-control";
			$this->IgnoreRE->EditCustomAttributes = "";
			$this->IgnoreRE->EditValue = ew_HtmlEncode($this->IgnoreRE->CurrentValue);
			$this->IgnoreRE->PlaceHolder = ew_RemoveHtml($this->IgnoreRE->FldCaption());

			// BanAbsorb
			$this->BanAbsorb->EditAttrs["class"] = "form-control";
			$this->BanAbsorb->EditCustomAttributes = "";
			$this->BanAbsorb->EditValue = ew_HtmlEncode($this->BanAbsorb->CurrentValue);
			$this->BanAbsorb->PlaceHolder = ew_RemoveHtml($this->BanAbsorb->FldCaption());

			// BanMultipleShot
			$this->BanMultipleShot->EditAttrs["class"] = "form-control";
			$this->BanMultipleShot->EditCustomAttributes = "";
			$this->BanMultipleShot->EditValue = ew_HtmlEncode($this->BanMultipleShot->CurrentValue);
			$this->BanMultipleShot->PlaceHolder = ew_RemoveHtml($this->BanMultipleShot->FldCaption());

			// ProhibitUO
			$this->ProhibitUO->EditAttrs["class"] = "form-control";
			$this->ProhibitUO->EditCustomAttributes = "";
			$this->ProhibitUO->EditValue = ew_HtmlEncode($this->ProhibitUO->CurrentValue);
			$this->ProhibitUO->PlaceHolder = ew_RemoveHtml($this->ProhibitUO->FldCaption());

			// ConsumableGoods
			$this->ConsumableGoods->EditAttrs["class"] = "form-control";
			$this->ConsumableGoods->EditCustomAttributes = "";
			$this->ConsumableGoods->EditValue = ew_HtmlEncode($this->ConsumableGoods->CurrentValue);
			$this->ConsumableGoods->PlaceHolder = ew_RemoveHtml($this->ConsumableGoods->FldCaption());

			// Continued_Round
			$this->Continued_Round->EditAttrs["class"] = "form-control";
			$this->Continued_Round->EditCustomAttributes = "";
			$this->Continued_Round->EditValue = ew_HtmlEncode($this->Continued_Round->CurrentValue);
			$this->Continued_Round->PlaceHolder = ew_RemoveHtml($this->Continued_Round->FldCaption());

			// Continued_Type
			$this->Continued_Type->EditAttrs["class"] = "form-control";
			$this->Continued_Type->EditCustomAttributes = "";
			$this->Continued_Type->EditValue = ew_HtmlEncode($this->Continued_Type->CurrentValue);
			$this->Continued_Type->PlaceHolder = ew_RemoveHtml($this->Continued_Type->FldCaption());

			// Continued_Effect
			$this->Continued_Effect->EditAttrs["class"] = "form-control";
			$this->Continued_Effect->EditCustomAttributes = "";
			$this->Continued_Effect->EditValue = ew_HtmlEncode($this->Continued_Effect->CurrentValue);
			$this->Continued_Effect->PlaceHolder = ew_RemoveHtml($this->Continued_Effect->FldCaption());

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

			// Type
			$this->Type->LinkCustomAttributes = "";
			$this->Type->HrefValue = "";

			// Consume
			$this->Consume->LinkCustomAttributes = "";
			$this->Consume->HrefValue = "";

			// Effect
			$this->Effect->LinkCustomAttributes = "";
			$this->Effect->HrefValue = "";

			// EO
			$this->EO->LinkCustomAttributes = "";
			$this->EO->HrefValue = "";

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";

			// ConsumeType
			$this->ConsumeType->LinkCustomAttributes = "";
			$this->ConsumeType->HrefValue = "";

			// Cooling
			$this->Cooling->LinkCustomAttributes = "";
			$this->Cooling->HrefValue = "";

			// Accurate
			$this->Accurate->LinkCustomAttributes = "";
			$this->Accurate->HrefValue = "";

			// AttackTips
			$this->AttackTips->LinkCustomAttributes = "";
			$this->AttackTips->HrefValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";

			// ACS
			$this->ACS->LinkCustomAttributes = "";
			$this->ACS->HrefValue = "";

			// Shield
			$this->Shield->LinkCustomAttributes = "";
			$this->Shield->HrefValue = "";

			// IgnoreShield
			$this->IgnoreShield->LinkCustomAttributes = "";
			$this->IgnoreShield->HrefValue = "";

			// IgnoreIM
			$this->IgnoreIM->LinkCustomAttributes = "";
			$this->IgnoreIM->HrefValue = "";

			// IgnoreRE
			$this->IgnoreRE->LinkCustomAttributes = "";
			$this->IgnoreRE->HrefValue = "";

			// BanAbsorb
			$this->BanAbsorb->LinkCustomAttributes = "";
			$this->BanAbsorb->HrefValue = "";

			// BanMultipleShot
			$this->BanMultipleShot->LinkCustomAttributes = "";
			$this->BanMultipleShot->HrefValue = "";

			// ProhibitUO
			$this->ProhibitUO->LinkCustomAttributes = "";
			$this->ProhibitUO->HrefValue = "";

			// ConsumableGoods
			$this->ConsumableGoods->LinkCustomAttributes = "";
			$this->ConsumableGoods->HrefValue = "";

			// Continued_Round
			$this->Continued_Round->LinkCustomAttributes = "";
			$this->Continued_Round->HrefValue = "";

			// Continued_Type
			$this->Continued_Type->LinkCustomAttributes = "";
			$this->Continued_Type->HrefValue = "";

			// Continued_Effect
			$this->Continued_Effect->LinkCustomAttributes = "";
			$this->Continued_Effect->HrefValue = "";

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
		if (!$this->Type->FldIsDetailKey && !is_null($this->Type->FormValue) && $this->Type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Type->FldCaption(), $this->Type->ReqErrMsg));
		}
		if (!$this->Consume->FldIsDetailKey && !is_null($this->Consume->FormValue) && $this->Consume->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Consume->FldCaption(), $this->Consume->ReqErrMsg));
		}
		if (!$this->Effect->FldIsDetailKey && !is_null($this->Effect->FormValue) && $this->Effect->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Effect->FldCaption(), $this->Effect->ReqErrMsg));
		}
		if (!$this->EO->FldIsDetailKey && !is_null($this->EO->FormValue) && $this->EO->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->EO->FldCaption(), $this->EO->ReqErrMsg));
		}
		if (!$this->LV->FldIsDetailKey && !is_null($this->LV->FormValue) && $this->LV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->LV->FldCaption(), $this->LV->ReqErrMsg));
		}
		if (!$this->ConsumeType->FldIsDetailKey && !is_null($this->ConsumeType->FormValue) && $this->ConsumeType->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ConsumeType->FldCaption(), $this->ConsumeType->ReqErrMsg));
		}
		if (!$this->Cooling->FldIsDetailKey && !is_null($this->Cooling->FormValue) && $this->Cooling->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cooling->FldCaption(), $this->Cooling->ReqErrMsg));
		}
		if (!$this->Accurate->FldIsDetailKey && !is_null($this->Accurate->FormValue) && $this->Accurate->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Accurate->FldCaption(), $this->Accurate->ReqErrMsg));
		}
		if (!$this->AttackTips->FldIsDetailKey && !is_null($this->AttackTips->FormValue) && $this->AttackTips->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AttackTips->FldCaption(), $this->AttackTips->ReqErrMsg));
		}
		if (!$this->Introduce->FldIsDetailKey && !is_null($this->Introduce->FormValue) && $this->Introduce->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Introduce->FldCaption(), $this->Introduce->ReqErrMsg));
		}
		if (!$this->ACS->FldIsDetailKey && !is_null($this->ACS->FormValue) && $this->ACS->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ACS->FldCaption(), $this->ACS->ReqErrMsg));
		}
		if (!$this->Shield->FldIsDetailKey && !is_null($this->Shield->FormValue) && $this->Shield->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Shield->FldCaption(), $this->Shield->ReqErrMsg));
		}
		if (!$this->IgnoreShield->FldIsDetailKey && !is_null($this->IgnoreShield->FormValue) && $this->IgnoreShield->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->IgnoreShield->FldCaption(), $this->IgnoreShield->ReqErrMsg));
		}
		if (!$this->IgnoreIM->FldIsDetailKey && !is_null($this->IgnoreIM->FormValue) && $this->IgnoreIM->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->IgnoreIM->FldCaption(), $this->IgnoreIM->ReqErrMsg));
		}
		if (!$this->IgnoreRE->FldIsDetailKey && !is_null($this->IgnoreRE->FormValue) && $this->IgnoreRE->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->IgnoreRE->FldCaption(), $this->IgnoreRE->ReqErrMsg));
		}
		if (!$this->BanAbsorb->FldIsDetailKey && !is_null($this->BanAbsorb->FormValue) && $this->BanAbsorb->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->BanAbsorb->FldCaption(), $this->BanAbsorb->ReqErrMsg));
		}
		if (!$this->BanMultipleShot->FldIsDetailKey && !is_null($this->BanMultipleShot->FormValue) && $this->BanMultipleShot->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->BanMultipleShot->FldCaption(), $this->BanMultipleShot->ReqErrMsg));
		}
		if (!$this->ProhibitUO->FldIsDetailKey && !is_null($this->ProhibitUO->FormValue) && $this->ProhibitUO->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ProhibitUO->FldCaption(), $this->ProhibitUO->ReqErrMsg));
		}
		if (!$this->ConsumableGoods->FldIsDetailKey && !is_null($this->ConsumableGoods->FormValue) && $this->ConsumableGoods->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ConsumableGoods->FldCaption(), $this->ConsumableGoods->ReqErrMsg));
		}
		if (!$this->Continued_Round->FldIsDetailKey && !is_null($this->Continued_Round->FormValue) && $this->Continued_Round->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Continued_Round->FldCaption(), $this->Continued_Round->ReqErrMsg));
		}
		if (!$this->Continued_Type->FldIsDetailKey && !is_null($this->Continued_Type->FormValue) && $this->Continued_Type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Continued_Type->FldCaption(), $this->Continued_Type->ReqErrMsg));
		}
		if (!$this->Continued_Effect->FldIsDetailKey && !is_null($this->Continued_Effect->FormValue) && $this->Continued_Effect->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Continued_Effect->FldCaption(), $this->Continued_Effect->ReqErrMsg));
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

			// Type
			$this->Type->SetDbValueDef($rsnew, $this->Type->CurrentValue, "", $this->Type->ReadOnly);

			// Consume
			$this->Consume->SetDbValueDef($rsnew, $this->Consume->CurrentValue, "", $this->Consume->ReadOnly);

			// Effect
			$this->Effect->SetDbValueDef($rsnew, $this->Effect->CurrentValue, "", $this->Effect->ReadOnly);

			// EO
			$this->EO->SetDbValueDef($rsnew, $this->EO->CurrentValue, "", $this->EO->ReadOnly);

			// LV
			$this->LV->SetDbValueDef($rsnew, $this->LV->CurrentValue, "", $this->LV->ReadOnly);

			// ConsumeType
			$this->ConsumeType->SetDbValueDef($rsnew, $this->ConsumeType->CurrentValue, "", $this->ConsumeType->ReadOnly);

			// Cooling
			$this->Cooling->SetDbValueDef($rsnew, $this->Cooling->CurrentValue, "", $this->Cooling->ReadOnly);

			// Accurate
			$this->Accurate->SetDbValueDef($rsnew, $this->Accurate->CurrentValue, "", $this->Accurate->ReadOnly);

			// AttackTips
			$this->AttackTips->SetDbValueDef($rsnew, $this->AttackTips->CurrentValue, "", $this->AttackTips->ReadOnly);

			// Introduce
			$this->Introduce->SetDbValueDef($rsnew, $this->Introduce->CurrentValue, "", $this->Introduce->ReadOnly);

			// ACS
			$this->ACS->SetDbValueDef($rsnew, $this->ACS->CurrentValue, "", $this->ACS->ReadOnly);

			// Shield
			$this->Shield->SetDbValueDef($rsnew, $this->Shield->CurrentValue, "", $this->Shield->ReadOnly);

			// IgnoreShield
			$this->IgnoreShield->SetDbValueDef($rsnew, $this->IgnoreShield->CurrentValue, "", $this->IgnoreShield->ReadOnly);

			// IgnoreIM
			$this->IgnoreIM->SetDbValueDef($rsnew, $this->IgnoreIM->CurrentValue, "", $this->IgnoreIM->ReadOnly);

			// IgnoreRE
			$this->IgnoreRE->SetDbValueDef($rsnew, $this->IgnoreRE->CurrentValue, "", $this->IgnoreRE->ReadOnly);

			// BanAbsorb
			$this->BanAbsorb->SetDbValueDef($rsnew, $this->BanAbsorb->CurrentValue, "", $this->BanAbsorb->ReadOnly);

			// BanMultipleShot
			$this->BanMultipleShot->SetDbValueDef($rsnew, $this->BanMultipleShot->CurrentValue, "", $this->BanMultipleShot->ReadOnly);

			// ProhibitUO
			$this->ProhibitUO->SetDbValueDef($rsnew, $this->ProhibitUO->CurrentValue, "", $this->ProhibitUO->ReadOnly);

			// ConsumableGoods
			$this->ConsumableGoods->SetDbValueDef($rsnew, $this->ConsumableGoods->CurrentValue, "", $this->ConsumableGoods->ReadOnly);

			// Continued_Round
			$this->Continued_Round->SetDbValueDef($rsnew, $this->Continued_Round->CurrentValue, "", $this->Continued_Round->ReadOnly);

			// Continued_Type
			$this->Continued_Type->SetDbValueDef($rsnew, $this->Continued_Type->CurrentValue, "", $this->Continued_Type->ReadOnly);

			// Continued_Effect
			$this->Continued_Effect->SetDbValueDef($rsnew, $this->Continued_Effect->CurrentValue, "", $this->Continued_Effect->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_skillslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_skills_edit)) $config_skills_edit = new cconfig_skills_edit();

// Page init
$config_skills_edit->Page_Init();

// Page main
$config_skills_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_skills_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fconfig_skillsedit = new ew_Form("fconfig_skillsedit", "edit");

// Validate form
fconfig_skillsedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->u_id->FldCaption(), $config_skills->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_skills->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->acl_id->FldCaption(), $config_skills->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_skills->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Name->FldCaption(), $config_skills->Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Type->FldCaption(), $config_skills->Type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Consume");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Consume->FldCaption(), $config_skills->Consume->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Effect");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Effect->FldCaption(), $config_skills->Effect->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_EO");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->EO->FldCaption(), $config_skills->EO->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->LV->FldCaption(), $config_skills->LV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ConsumeType");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->ConsumeType->FldCaption(), $config_skills->ConsumeType->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cooling");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Cooling->FldCaption(), $config_skills->Cooling->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Accurate");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Accurate->FldCaption(), $config_skills->Accurate->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AttackTips");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->AttackTips->FldCaption(), $config_skills->AttackTips->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Introduce");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Introduce->FldCaption(), $config_skills->Introduce->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ACS");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->ACS->FldCaption(), $config_skills->ACS->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Shield");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Shield->FldCaption(), $config_skills->Shield->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_IgnoreShield");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->IgnoreShield->FldCaption(), $config_skills->IgnoreShield->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_IgnoreIM");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->IgnoreIM->FldCaption(), $config_skills->IgnoreIM->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_IgnoreRE");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->IgnoreRE->FldCaption(), $config_skills->IgnoreRE->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_BanAbsorb");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->BanAbsorb->FldCaption(), $config_skills->BanAbsorb->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_BanMultipleShot");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->BanMultipleShot->FldCaption(), $config_skills->BanMultipleShot->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ProhibitUO");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->ProhibitUO->FldCaption(), $config_skills->ProhibitUO->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ConsumableGoods");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->ConsumableGoods->FldCaption(), $config_skills->ConsumableGoods->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Continued_Round");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Continued_Round->FldCaption(), $config_skills->Continued_Round->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Continued_Type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Continued_Type->FldCaption(), $config_skills->Continued_Type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Continued_Effect");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->Continued_Effect->FldCaption(), $config_skills->Continued_Effect->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_skills->DATETIME->FldCaption(), $config_skills->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_skills->DATETIME->FldErrMsg()) ?>");

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
fconfig_skillsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_skillsedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $config_skills_edit->ShowPageHeader(); ?>
<?php
$config_skills_edit->ShowMessage();
?>
<form name="fconfig_skillsedit" id="fconfig_skillsedit" class="<?php echo $config_skills_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_skills_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_skills_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_skills">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($config_skills_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($config_skills->unid->Visible) { // unid ?>
	<div id="r_unid" class="form-group">
		<label id="elh_config_skills_unid" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->unid->FldCaption() ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->unid->CellAttributes() ?>>
<span id="el_config_skills_unid">
<span<?php echo $config_skills->unid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $config_skills->unid->EditValue ?></p></span>
</span>
<input type="hidden" data-table="config_skills" data-field="x_unid" name="x_unid" id="x_unid" value="<?php echo ew_HtmlEncode($config_skills->unid->CurrentValue) ?>">
<?php echo $config_skills->unid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_config_skills_u_id" for="x_u_id" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->u_id->CellAttributes() ?>>
<span id="el_config_skills_u_id">
<input type="text" data-table="config_skills" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_skills->u_id->getPlaceHolder()) ?>" value="<?php echo $config_skills->u_id->EditValue ?>"<?php echo $config_skills->u_id->EditAttributes() ?>>
</span>
<?php echo $config_skills->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_config_skills_acl_id" for="x_acl_id" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->acl_id->CellAttributes() ?>>
<span id="el_config_skills_acl_id">
<input type="text" data-table="config_skills" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_skills->acl_id->getPlaceHolder()) ?>" value="<?php echo $config_skills->acl_id->EditValue ?>"<?php echo $config_skills->acl_id->EditAttributes() ?>>
</span>
<?php echo $config_skills->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Name->Visible) { // Name ?>
	<div id="r_Name" class="form-group">
		<label id="elh_config_skills_Name" for="x_Name" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Name->CellAttributes() ?>>
<span id="el_config_skills_Name">
<textarea data-table="config_skills" data-field="x_Name" name="x_Name" id="x_Name" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Name->getPlaceHolder()) ?>"<?php echo $config_skills->Name->EditAttributes() ?>><?php echo $config_skills->Name->EditValue ?></textarea>
</span>
<?php echo $config_skills->Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Type->Visible) { // Type ?>
	<div id="r_Type" class="form-group">
		<label id="elh_config_skills_Type" for="x_Type" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Type->CellAttributes() ?>>
<span id="el_config_skills_Type">
<textarea data-table="config_skills" data-field="x_Type" name="x_Type" id="x_Type" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Type->getPlaceHolder()) ?>"<?php echo $config_skills->Type->EditAttributes() ?>><?php echo $config_skills->Type->EditValue ?></textarea>
</span>
<?php echo $config_skills->Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Consume->Visible) { // Consume ?>
	<div id="r_Consume" class="form-group">
		<label id="elh_config_skills_Consume" for="x_Consume" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Consume->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Consume->CellAttributes() ?>>
<span id="el_config_skills_Consume">
<textarea data-table="config_skills" data-field="x_Consume" name="x_Consume" id="x_Consume" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Consume->getPlaceHolder()) ?>"<?php echo $config_skills->Consume->EditAttributes() ?>><?php echo $config_skills->Consume->EditValue ?></textarea>
</span>
<?php echo $config_skills->Consume->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Effect->Visible) { // Effect ?>
	<div id="r_Effect" class="form-group">
		<label id="elh_config_skills_Effect" for="x_Effect" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Effect->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Effect->CellAttributes() ?>>
<span id="el_config_skills_Effect">
<textarea data-table="config_skills" data-field="x_Effect" name="x_Effect" id="x_Effect" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Effect->getPlaceHolder()) ?>"<?php echo $config_skills->Effect->EditAttributes() ?>><?php echo $config_skills->Effect->EditValue ?></textarea>
</span>
<?php echo $config_skills->Effect->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->EO->Visible) { // EO ?>
	<div id="r_EO" class="form-group">
		<label id="elh_config_skills_EO" for="x_EO" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->EO->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->EO->CellAttributes() ?>>
<span id="el_config_skills_EO">
<textarea data-table="config_skills" data-field="x_EO" name="x_EO" id="x_EO" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->EO->getPlaceHolder()) ?>"<?php echo $config_skills->EO->EditAttributes() ?>><?php echo $config_skills->EO->EditValue ?></textarea>
</span>
<?php echo $config_skills->EO->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->LV->Visible) { // LV ?>
	<div id="r_LV" class="form-group">
		<label id="elh_config_skills_LV" for="x_LV" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->LV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->LV->CellAttributes() ?>>
<span id="el_config_skills_LV">
<textarea data-table="config_skills" data-field="x_LV" name="x_LV" id="x_LV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->LV->getPlaceHolder()) ?>"<?php echo $config_skills->LV->EditAttributes() ?>><?php echo $config_skills->LV->EditValue ?></textarea>
</span>
<?php echo $config_skills->LV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->ConsumeType->Visible) { // ConsumeType ?>
	<div id="r_ConsumeType" class="form-group">
		<label id="elh_config_skills_ConsumeType" for="x_ConsumeType" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->ConsumeType->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->ConsumeType->CellAttributes() ?>>
<span id="el_config_skills_ConsumeType">
<textarea data-table="config_skills" data-field="x_ConsumeType" name="x_ConsumeType" id="x_ConsumeType" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->ConsumeType->getPlaceHolder()) ?>"<?php echo $config_skills->ConsumeType->EditAttributes() ?>><?php echo $config_skills->ConsumeType->EditValue ?></textarea>
</span>
<?php echo $config_skills->ConsumeType->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Cooling->Visible) { // Cooling ?>
	<div id="r_Cooling" class="form-group">
		<label id="elh_config_skills_Cooling" for="x_Cooling" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Cooling->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Cooling->CellAttributes() ?>>
<span id="el_config_skills_Cooling">
<textarea data-table="config_skills" data-field="x_Cooling" name="x_Cooling" id="x_Cooling" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Cooling->getPlaceHolder()) ?>"<?php echo $config_skills->Cooling->EditAttributes() ?>><?php echo $config_skills->Cooling->EditValue ?></textarea>
</span>
<?php echo $config_skills->Cooling->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Accurate->Visible) { // Accurate ?>
	<div id="r_Accurate" class="form-group">
		<label id="elh_config_skills_Accurate" for="x_Accurate" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Accurate->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Accurate->CellAttributes() ?>>
<span id="el_config_skills_Accurate">
<textarea data-table="config_skills" data-field="x_Accurate" name="x_Accurate" id="x_Accurate" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Accurate->getPlaceHolder()) ?>"<?php echo $config_skills->Accurate->EditAttributes() ?>><?php echo $config_skills->Accurate->EditValue ?></textarea>
</span>
<?php echo $config_skills->Accurate->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->AttackTips->Visible) { // AttackTips ?>
	<div id="r_AttackTips" class="form-group">
		<label id="elh_config_skills_AttackTips" for="x_AttackTips" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->AttackTips->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->AttackTips->CellAttributes() ?>>
<span id="el_config_skills_AttackTips">
<textarea data-table="config_skills" data-field="x_AttackTips" name="x_AttackTips" id="x_AttackTips" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->AttackTips->getPlaceHolder()) ?>"<?php echo $config_skills->AttackTips->EditAttributes() ?>><?php echo $config_skills->AttackTips->EditValue ?></textarea>
</span>
<?php echo $config_skills->AttackTips->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Introduce->Visible) { // Introduce ?>
	<div id="r_Introduce" class="form-group">
		<label id="elh_config_skills_Introduce" for="x_Introduce" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Introduce->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Introduce->CellAttributes() ?>>
<span id="el_config_skills_Introduce">
<textarea data-table="config_skills" data-field="x_Introduce" name="x_Introduce" id="x_Introduce" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Introduce->getPlaceHolder()) ?>"<?php echo $config_skills->Introduce->EditAttributes() ?>><?php echo $config_skills->Introduce->EditValue ?></textarea>
</span>
<?php echo $config_skills->Introduce->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->ACS->Visible) { // ACS ?>
	<div id="r_ACS" class="form-group">
		<label id="elh_config_skills_ACS" for="x_ACS" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->ACS->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->ACS->CellAttributes() ?>>
<span id="el_config_skills_ACS">
<textarea data-table="config_skills" data-field="x_ACS" name="x_ACS" id="x_ACS" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->ACS->getPlaceHolder()) ?>"<?php echo $config_skills->ACS->EditAttributes() ?>><?php echo $config_skills->ACS->EditValue ?></textarea>
</span>
<?php echo $config_skills->ACS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Shield->Visible) { // Shield ?>
	<div id="r_Shield" class="form-group">
		<label id="elh_config_skills_Shield" for="x_Shield" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Shield->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Shield->CellAttributes() ?>>
<span id="el_config_skills_Shield">
<textarea data-table="config_skills" data-field="x_Shield" name="x_Shield" id="x_Shield" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Shield->getPlaceHolder()) ?>"<?php echo $config_skills->Shield->EditAttributes() ?>><?php echo $config_skills->Shield->EditValue ?></textarea>
</span>
<?php echo $config_skills->Shield->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->IgnoreShield->Visible) { // IgnoreShield ?>
	<div id="r_IgnoreShield" class="form-group">
		<label id="elh_config_skills_IgnoreShield" for="x_IgnoreShield" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->IgnoreShield->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->IgnoreShield->CellAttributes() ?>>
<span id="el_config_skills_IgnoreShield">
<textarea data-table="config_skills" data-field="x_IgnoreShield" name="x_IgnoreShield" id="x_IgnoreShield" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->IgnoreShield->getPlaceHolder()) ?>"<?php echo $config_skills->IgnoreShield->EditAttributes() ?>><?php echo $config_skills->IgnoreShield->EditValue ?></textarea>
</span>
<?php echo $config_skills->IgnoreShield->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->IgnoreIM->Visible) { // IgnoreIM ?>
	<div id="r_IgnoreIM" class="form-group">
		<label id="elh_config_skills_IgnoreIM" for="x_IgnoreIM" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->IgnoreIM->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->IgnoreIM->CellAttributes() ?>>
<span id="el_config_skills_IgnoreIM">
<textarea data-table="config_skills" data-field="x_IgnoreIM" name="x_IgnoreIM" id="x_IgnoreIM" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->IgnoreIM->getPlaceHolder()) ?>"<?php echo $config_skills->IgnoreIM->EditAttributes() ?>><?php echo $config_skills->IgnoreIM->EditValue ?></textarea>
</span>
<?php echo $config_skills->IgnoreIM->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->IgnoreRE->Visible) { // IgnoreRE ?>
	<div id="r_IgnoreRE" class="form-group">
		<label id="elh_config_skills_IgnoreRE" for="x_IgnoreRE" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->IgnoreRE->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->IgnoreRE->CellAttributes() ?>>
<span id="el_config_skills_IgnoreRE">
<textarea data-table="config_skills" data-field="x_IgnoreRE" name="x_IgnoreRE" id="x_IgnoreRE" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->IgnoreRE->getPlaceHolder()) ?>"<?php echo $config_skills->IgnoreRE->EditAttributes() ?>><?php echo $config_skills->IgnoreRE->EditValue ?></textarea>
</span>
<?php echo $config_skills->IgnoreRE->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->BanAbsorb->Visible) { // BanAbsorb ?>
	<div id="r_BanAbsorb" class="form-group">
		<label id="elh_config_skills_BanAbsorb" for="x_BanAbsorb" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->BanAbsorb->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->BanAbsorb->CellAttributes() ?>>
<span id="el_config_skills_BanAbsorb">
<textarea data-table="config_skills" data-field="x_BanAbsorb" name="x_BanAbsorb" id="x_BanAbsorb" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->BanAbsorb->getPlaceHolder()) ?>"<?php echo $config_skills->BanAbsorb->EditAttributes() ?>><?php echo $config_skills->BanAbsorb->EditValue ?></textarea>
</span>
<?php echo $config_skills->BanAbsorb->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->BanMultipleShot->Visible) { // BanMultipleShot ?>
	<div id="r_BanMultipleShot" class="form-group">
		<label id="elh_config_skills_BanMultipleShot" for="x_BanMultipleShot" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->BanMultipleShot->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->BanMultipleShot->CellAttributes() ?>>
<span id="el_config_skills_BanMultipleShot">
<textarea data-table="config_skills" data-field="x_BanMultipleShot" name="x_BanMultipleShot" id="x_BanMultipleShot" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->BanMultipleShot->getPlaceHolder()) ?>"<?php echo $config_skills->BanMultipleShot->EditAttributes() ?>><?php echo $config_skills->BanMultipleShot->EditValue ?></textarea>
</span>
<?php echo $config_skills->BanMultipleShot->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->ProhibitUO->Visible) { // ProhibitUO ?>
	<div id="r_ProhibitUO" class="form-group">
		<label id="elh_config_skills_ProhibitUO" for="x_ProhibitUO" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->ProhibitUO->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->ProhibitUO->CellAttributes() ?>>
<span id="el_config_skills_ProhibitUO">
<textarea data-table="config_skills" data-field="x_ProhibitUO" name="x_ProhibitUO" id="x_ProhibitUO" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->ProhibitUO->getPlaceHolder()) ?>"<?php echo $config_skills->ProhibitUO->EditAttributes() ?>><?php echo $config_skills->ProhibitUO->EditValue ?></textarea>
</span>
<?php echo $config_skills->ProhibitUO->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->ConsumableGoods->Visible) { // ConsumableGoods ?>
	<div id="r_ConsumableGoods" class="form-group">
		<label id="elh_config_skills_ConsumableGoods" for="x_ConsumableGoods" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->ConsumableGoods->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->ConsumableGoods->CellAttributes() ?>>
<span id="el_config_skills_ConsumableGoods">
<textarea data-table="config_skills" data-field="x_ConsumableGoods" name="x_ConsumableGoods" id="x_ConsumableGoods" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->ConsumableGoods->getPlaceHolder()) ?>"<?php echo $config_skills->ConsumableGoods->EditAttributes() ?>><?php echo $config_skills->ConsumableGoods->EditValue ?></textarea>
</span>
<?php echo $config_skills->ConsumableGoods->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Continued_Round->Visible) { // Continued_Round ?>
	<div id="r_Continued_Round" class="form-group">
		<label id="elh_config_skills_Continued_Round" for="x_Continued_Round" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Continued_Round->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Continued_Round->CellAttributes() ?>>
<span id="el_config_skills_Continued_Round">
<textarea data-table="config_skills" data-field="x_Continued_Round" name="x_Continued_Round" id="x_Continued_Round" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Continued_Round->getPlaceHolder()) ?>"<?php echo $config_skills->Continued_Round->EditAttributes() ?>><?php echo $config_skills->Continued_Round->EditValue ?></textarea>
</span>
<?php echo $config_skills->Continued_Round->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Continued_Type->Visible) { // Continued_Type ?>
	<div id="r_Continued_Type" class="form-group">
		<label id="elh_config_skills_Continued_Type" for="x_Continued_Type" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Continued_Type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Continued_Type->CellAttributes() ?>>
<span id="el_config_skills_Continued_Type">
<textarea data-table="config_skills" data-field="x_Continued_Type" name="x_Continued_Type" id="x_Continued_Type" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Continued_Type->getPlaceHolder()) ?>"<?php echo $config_skills->Continued_Type->EditAttributes() ?>><?php echo $config_skills->Continued_Type->EditValue ?></textarea>
</span>
<?php echo $config_skills->Continued_Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->Continued_Effect->Visible) { // Continued_Effect ?>
	<div id="r_Continued_Effect" class="form-group">
		<label id="elh_config_skills_Continued_Effect" for="x_Continued_Effect" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->Continued_Effect->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->Continued_Effect->CellAttributes() ?>>
<span id="el_config_skills_Continued_Effect">
<textarea data-table="config_skills" data-field="x_Continued_Effect" name="x_Continued_Effect" id="x_Continued_Effect" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_skills->Continued_Effect->getPlaceHolder()) ?>"<?php echo $config_skills->Continued_Effect->EditAttributes() ?>><?php echo $config_skills->Continued_Effect->EditValue ?></textarea>
</span>
<?php echo $config_skills->Continued_Effect->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_skills->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_config_skills_DATETIME" for="x_DATETIME" class="<?php echo $config_skills_edit->LeftColumnClass ?>"><?php echo $config_skills->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_skills_edit->RightColumnClass ?>"><div<?php echo $config_skills->DATETIME->CellAttributes() ?>>
<span id="el_config_skills_DATETIME">
<input type="text" data-table="config_skills" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($config_skills->DATETIME->getPlaceHolder()) ?>" value="<?php echo $config_skills->DATETIME->EditValue ?>"<?php echo $config_skills->DATETIME->EditAttributes() ?>>
</span>
<?php echo $config_skills->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$config_skills_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $config_skills_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $config_skills_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fconfig_skillsedit.Init();
</script>
<?php
$config_skills_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_skills_edit->Page_Terminate();
?>
