<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_occupationinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_occupation_add = NULL; // Initialize page object first

class cconfig_occupation_add extends cconfig_occupation {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_occupation';

	// Page object name
	var $PageObjName = 'config_occupation_add';

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

		// Table object (config_occupation)
		if (!isset($GLOBALS["config_occupation"]) || get_class($GLOBALS["config_occupation"]) == "cconfig_occupation") {
			$GLOBALS["config_occupation"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_occupation"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'config_occupation', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("config_occupationlist.php"));
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
		$this->Name->SetVisibility();
		$this->Basics->SetVisibility();
		$this->HP->SetVisibility();
		$this->MP->SetVisibility();
		$this->AD->SetVisibility();
		$this->AP->SetVisibility();
		$this->Defense->SetVisibility();
		$this->Hit->SetVisibility();
		$this->Dodge->SetVisibility();
		$this->Crit->SetVisibility();
		$this->AbsorbHP->SetVisibility();
		$this->ADPTV->SetVisibility();
		$this->ADPTR->SetVisibility();
		$this->APPTR->SetVisibility();
		$this->APPTV->SetVisibility();
		$this->ImmuneDamage->SetVisibility();
		$this->Intro->SetVisibility();
		$this->ExclusiveSkills->SetVisibility();
		$this->TransferDemand->SetVisibility();
		$this->TransferLevel->SetVisibility();
		$this->FormerOccupation->SetVisibility();
		$this->Belong->SetVisibility();
		$this->AttackEffect->SetVisibility();
		$this->AttackTips->SetVisibility();
		$this->MagicResistance->SetVisibility();
		$this->IgnoreShield->SetVisibility();
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
		global $EW_EXPORT, $config_occupation;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_occupation);
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
					if ($pageName == "config_occupationview.php")
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
					$this->Page_Terminate("config_occupationlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "config_occupationlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "config_occupationview.php")
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
		$this->Name->CurrentValue = NULL;
		$this->Name->OldValue = $this->Name->CurrentValue;
		$this->Basics->CurrentValue = NULL;
		$this->Basics->OldValue = $this->Basics->CurrentValue;
		$this->HP->CurrentValue = NULL;
		$this->HP->OldValue = $this->HP->CurrentValue;
		$this->MP->CurrentValue = NULL;
		$this->MP->OldValue = $this->MP->CurrentValue;
		$this->AD->CurrentValue = NULL;
		$this->AD->OldValue = $this->AD->CurrentValue;
		$this->AP->CurrentValue = NULL;
		$this->AP->OldValue = $this->AP->CurrentValue;
		$this->Defense->CurrentValue = NULL;
		$this->Defense->OldValue = $this->Defense->CurrentValue;
		$this->Hit->CurrentValue = NULL;
		$this->Hit->OldValue = $this->Hit->CurrentValue;
		$this->Dodge->CurrentValue = NULL;
		$this->Dodge->OldValue = $this->Dodge->CurrentValue;
		$this->Crit->CurrentValue = NULL;
		$this->Crit->OldValue = $this->Crit->CurrentValue;
		$this->AbsorbHP->CurrentValue = NULL;
		$this->AbsorbHP->OldValue = $this->AbsorbHP->CurrentValue;
		$this->ADPTV->CurrentValue = NULL;
		$this->ADPTV->OldValue = $this->ADPTV->CurrentValue;
		$this->ADPTR->CurrentValue = NULL;
		$this->ADPTR->OldValue = $this->ADPTR->CurrentValue;
		$this->APPTR->CurrentValue = NULL;
		$this->APPTR->OldValue = $this->APPTR->CurrentValue;
		$this->APPTV->CurrentValue = NULL;
		$this->APPTV->OldValue = $this->APPTV->CurrentValue;
		$this->ImmuneDamage->CurrentValue = NULL;
		$this->ImmuneDamage->OldValue = $this->ImmuneDamage->CurrentValue;
		$this->Intro->CurrentValue = NULL;
		$this->Intro->OldValue = $this->Intro->CurrentValue;
		$this->ExclusiveSkills->CurrentValue = NULL;
		$this->ExclusiveSkills->OldValue = $this->ExclusiveSkills->CurrentValue;
		$this->TransferDemand->CurrentValue = NULL;
		$this->TransferDemand->OldValue = $this->TransferDemand->CurrentValue;
		$this->TransferLevel->CurrentValue = NULL;
		$this->TransferLevel->OldValue = $this->TransferLevel->CurrentValue;
		$this->FormerOccupation->CurrentValue = NULL;
		$this->FormerOccupation->OldValue = $this->FormerOccupation->CurrentValue;
		$this->Belong->CurrentValue = NULL;
		$this->Belong->OldValue = $this->Belong->CurrentValue;
		$this->AttackEffect->CurrentValue = NULL;
		$this->AttackEffect->OldValue = $this->AttackEffect->CurrentValue;
		$this->AttackTips->CurrentValue = NULL;
		$this->AttackTips->OldValue = $this->AttackTips->CurrentValue;
		$this->MagicResistance->CurrentValue = NULL;
		$this->MagicResistance->OldValue = $this->MagicResistance->CurrentValue;
		$this->IgnoreShield->CurrentValue = NULL;
		$this->IgnoreShield->OldValue = $this->IgnoreShield->CurrentValue;
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
		if (!$this->Name->FldIsDetailKey) {
			$this->Name->setFormValue($objForm->GetValue("x_Name"));
		}
		if (!$this->Basics->FldIsDetailKey) {
			$this->Basics->setFormValue($objForm->GetValue("x_Basics"));
		}
		if (!$this->HP->FldIsDetailKey) {
			$this->HP->setFormValue($objForm->GetValue("x_HP"));
		}
		if (!$this->MP->FldIsDetailKey) {
			$this->MP->setFormValue($objForm->GetValue("x_MP"));
		}
		if (!$this->AD->FldIsDetailKey) {
			$this->AD->setFormValue($objForm->GetValue("x_AD"));
		}
		if (!$this->AP->FldIsDetailKey) {
			$this->AP->setFormValue($objForm->GetValue("x_AP"));
		}
		if (!$this->Defense->FldIsDetailKey) {
			$this->Defense->setFormValue($objForm->GetValue("x_Defense"));
		}
		if (!$this->Hit->FldIsDetailKey) {
			$this->Hit->setFormValue($objForm->GetValue("x_Hit"));
		}
		if (!$this->Dodge->FldIsDetailKey) {
			$this->Dodge->setFormValue($objForm->GetValue("x_Dodge"));
		}
		if (!$this->Crit->FldIsDetailKey) {
			$this->Crit->setFormValue($objForm->GetValue("x_Crit"));
		}
		if (!$this->AbsorbHP->FldIsDetailKey) {
			$this->AbsorbHP->setFormValue($objForm->GetValue("x_AbsorbHP"));
		}
		if (!$this->ADPTV->FldIsDetailKey) {
			$this->ADPTV->setFormValue($objForm->GetValue("x_ADPTV"));
		}
		if (!$this->ADPTR->FldIsDetailKey) {
			$this->ADPTR->setFormValue($objForm->GetValue("x_ADPTR"));
		}
		if (!$this->APPTR->FldIsDetailKey) {
			$this->APPTR->setFormValue($objForm->GetValue("x_APPTR"));
		}
		if (!$this->APPTV->FldIsDetailKey) {
			$this->APPTV->setFormValue($objForm->GetValue("x_APPTV"));
		}
		if (!$this->ImmuneDamage->FldIsDetailKey) {
			$this->ImmuneDamage->setFormValue($objForm->GetValue("x_ImmuneDamage"));
		}
		if (!$this->Intro->FldIsDetailKey) {
			$this->Intro->setFormValue($objForm->GetValue("x_Intro"));
		}
		if (!$this->ExclusiveSkills->FldIsDetailKey) {
			$this->ExclusiveSkills->setFormValue($objForm->GetValue("x_ExclusiveSkills"));
		}
		if (!$this->TransferDemand->FldIsDetailKey) {
			$this->TransferDemand->setFormValue($objForm->GetValue("x_TransferDemand"));
		}
		if (!$this->TransferLevel->FldIsDetailKey) {
			$this->TransferLevel->setFormValue($objForm->GetValue("x_TransferLevel"));
		}
		if (!$this->FormerOccupation->FldIsDetailKey) {
			$this->FormerOccupation->setFormValue($objForm->GetValue("x_FormerOccupation"));
		}
		if (!$this->Belong->FldIsDetailKey) {
			$this->Belong->setFormValue($objForm->GetValue("x_Belong"));
		}
		if (!$this->AttackEffect->FldIsDetailKey) {
			$this->AttackEffect->setFormValue($objForm->GetValue("x_AttackEffect"));
		}
		if (!$this->AttackTips->FldIsDetailKey) {
			$this->AttackTips->setFormValue($objForm->GetValue("x_AttackTips"));
		}
		if (!$this->MagicResistance->FldIsDetailKey) {
			$this->MagicResistance->setFormValue($objForm->GetValue("x_MagicResistance"));
		}
		if (!$this->IgnoreShield->FldIsDetailKey) {
			$this->IgnoreShield->setFormValue($objForm->GetValue("x_IgnoreShield"));
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
		$this->Name->CurrentValue = $this->Name->FormValue;
		$this->Basics->CurrentValue = $this->Basics->FormValue;
		$this->HP->CurrentValue = $this->HP->FormValue;
		$this->MP->CurrentValue = $this->MP->FormValue;
		$this->AD->CurrentValue = $this->AD->FormValue;
		$this->AP->CurrentValue = $this->AP->FormValue;
		$this->Defense->CurrentValue = $this->Defense->FormValue;
		$this->Hit->CurrentValue = $this->Hit->FormValue;
		$this->Dodge->CurrentValue = $this->Dodge->FormValue;
		$this->Crit->CurrentValue = $this->Crit->FormValue;
		$this->AbsorbHP->CurrentValue = $this->AbsorbHP->FormValue;
		$this->ADPTV->CurrentValue = $this->ADPTV->FormValue;
		$this->ADPTR->CurrentValue = $this->ADPTR->FormValue;
		$this->APPTR->CurrentValue = $this->APPTR->FormValue;
		$this->APPTV->CurrentValue = $this->APPTV->FormValue;
		$this->ImmuneDamage->CurrentValue = $this->ImmuneDamage->FormValue;
		$this->Intro->CurrentValue = $this->Intro->FormValue;
		$this->ExclusiveSkills->CurrentValue = $this->ExclusiveSkills->FormValue;
		$this->TransferDemand->CurrentValue = $this->TransferDemand->FormValue;
		$this->TransferLevel->CurrentValue = $this->TransferLevel->FormValue;
		$this->FormerOccupation->CurrentValue = $this->FormerOccupation->FormValue;
		$this->Belong->CurrentValue = $this->Belong->FormValue;
		$this->AttackEffect->CurrentValue = $this->AttackEffect->FormValue;
		$this->AttackTips->CurrentValue = $this->AttackTips->FormValue;
		$this->MagicResistance->CurrentValue = $this->MagicResistance->FormValue;
		$this->IgnoreShield->CurrentValue = $this->IgnoreShield->FormValue;
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
		$this->Basics->setDbValue($row['Basics']);
		$this->HP->setDbValue($row['HP']);
		$this->MP->setDbValue($row['MP']);
		$this->AD->setDbValue($row['AD']);
		$this->AP->setDbValue($row['AP']);
		$this->Defense->setDbValue($row['Defense']);
		$this->Hit->setDbValue($row['Hit']);
		$this->Dodge->setDbValue($row['Dodge']);
		$this->Crit->setDbValue($row['Crit']);
		$this->AbsorbHP->setDbValue($row['AbsorbHP']);
		$this->ADPTV->setDbValue($row['ADPTV']);
		$this->ADPTR->setDbValue($row['ADPTR']);
		$this->APPTR->setDbValue($row['APPTR']);
		$this->APPTV->setDbValue($row['APPTV']);
		$this->ImmuneDamage->setDbValue($row['ImmuneDamage']);
		$this->Intro->setDbValue($row['Intro']);
		$this->ExclusiveSkills->setDbValue($row['ExclusiveSkills']);
		$this->TransferDemand->setDbValue($row['TransferDemand']);
		$this->TransferLevel->setDbValue($row['TransferLevel']);
		$this->FormerOccupation->setDbValue($row['FormerOccupation']);
		$this->Belong->setDbValue($row['Belong']);
		$this->AttackEffect->setDbValue($row['AttackEffect']);
		$this->AttackTips->setDbValue($row['AttackTips']);
		$this->MagicResistance->setDbValue($row['MagicResistance']);
		$this->IgnoreShield->setDbValue($row['IgnoreShield']);
		$this->DATETIME->setDbValue($row['DATETIME']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['unid'] = $this->unid->CurrentValue;
		$row['u_id'] = $this->u_id->CurrentValue;
		$row['acl_id'] = $this->acl_id->CurrentValue;
		$row['Name'] = $this->Name->CurrentValue;
		$row['Basics'] = $this->Basics->CurrentValue;
		$row['HP'] = $this->HP->CurrentValue;
		$row['MP'] = $this->MP->CurrentValue;
		$row['AD'] = $this->AD->CurrentValue;
		$row['AP'] = $this->AP->CurrentValue;
		$row['Defense'] = $this->Defense->CurrentValue;
		$row['Hit'] = $this->Hit->CurrentValue;
		$row['Dodge'] = $this->Dodge->CurrentValue;
		$row['Crit'] = $this->Crit->CurrentValue;
		$row['AbsorbHP'] = $this->AbsorbHP->CurrentValue;
		$row['ADPTV'] = $this->ADPTV->CurrentValue;
		$row['ADPTR'] = $this->ADPTR->CurrentValue;
		$row['APPTR'] = $this->APPTR->CurrentValue;
		$row['APPTV'] = $this->APPTV->CurrentValue;
		$row['ImmuneDamage'] = $this->ImmuneDamage->CurrentValue;
		$row['Intro'] = $this->Intro->CurrentValue;
		$row['ExclusiveSkills'] = $this->ExclusiveSkills->CurrentValue;
		$row['TransferDemand'] = $this->TransferDemand->CurrentValue;
		$row['TransferLevel'] = $this->TransferLevel->CurrentValue;
		$row['FormerOccupation'] = $this->FormerOccupation->CurrentValue;
		$row['Belong'] = $this->Belong->CurrentValue;
		$row['AttackEffect'] = $this->AttackEffect->CurrentValue;
		$row['AttackTips'] = $this->AttackTips->CurrentValue;
		$row['MagicResistance'] = $this->MagicResistance->CurrentValue;
		$row['IgnoreShield'] = $this->IgnoreShield->CurrentValue;
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
		$this->Name->DbValue = $row['Name'];
		$this->Basics->DbValue = $row['Basics'];
		$this->HP->DbValue = $row['HP'];
		$this->MP->DbValue = $row['MP'];
		$this->AD->DbValue = $row['AD'];
		$this->AP->DbValue = $row['AP'];
		$this->Defense->DbValue = $row['Defense'];
		$this->Hit->DbValue = $row['Hit'];
		$this->Dodge->DbValue = $row['Dodge'];
		$this->Crit->DbValue = $row['Crit'];
		$this->AbsorbHP->DbValue = $row['AbsorbHP'];
		$this->ADPTV->DbValue = $row['ADPTV'];
		$this->ADPTR->DbValue = $row['ADPTR'];
		$this->APPTR->DbValue = $row['APPTR'];
		$this->APPTV->DbValue = $row['APPTV'];
		$this->ImmuneDamage->DbValue = $row['ImmuneDamage'];
		$this->Intro->DbValue = $row['Intro'];
		$this->ExclusiveSkills->DbValue = $row['ExclusiveSkills'];
		$this->TransferDemand->DbValue = $row['TransferDemand'];
		$this->TransferLevel->DbValue = $row['TransferLevel'];
		$this->FormerOccupation->DbValue = $row['FormerOccupation'];
		$this->Belong->DbValue = $row['Belong'];
		$this->AttackEffect->DbValue = $row['AttackEffect'];
		$this->AttackTips->DbValue = $row['AttackTips'];
		$this->MagicResistance->DbValue = $row['MagicResistance'];
		$this->IgnoreShield->DbValue = $row['IgnoreShield'];
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
		// Basics
		// HP
		// MP
		// AD
		// AP
		// Defense
		// Hit
		// Dodge
		// Crit
		// AbsorbHP
		// ADPTV
		// ADPTR
		// APPTR
		// APPTV
		// ImmuneDamage
		// Intro
		// ExclusiveSkills
		// TransferDemand
		// TransferLevel
		// FormerOccupation
		// Belong
		// AttackEffect
		// AttackTips
		// MagicResistance
		// IgnoreShield
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

		// Basics
		$this->Basics->ViewValue = $this->Basics->CurrentValue;
		$this->Basics->ViewCustomAttributes = "";

		// HP
		$this->HP->ViewValue = $this->HP->CurrentValue;
		$this->HP->ViewCustomAttributes = "";

		// MP
		$this->MP->ViewValue = $this->MP->CurrentValue;
		$this->MP->ViewCustomAttributes = "";

		// AD
		$this->AD->ViewValue = $this->AD->CurrentValue;
		$this->AD->ViewCustomAttributes = "";

		// AP
		$this->AP->ViewValue = $this->AP->CurrentValue;
		$this->AP->ViewCustomAttributes = "";

		// Defense
		$this->Defense->ViewValue = $this->Defense->CurrentValue;
		$this->Defense->ViewCustomAttributes = "";

		// Hit
		$this->Hit->ViewValue = $this->Hit->CurrentValue;
		$this->Hit->ViewCustomAttributes = "";

		// Dodge
		$this->Dodge->ViewValue = $this->Dodge->CurrentValue;
		$this->Dodge->ViewCustomAttributes = "";

		// Crit
		$this->Crit->ViewValue = $this->Crit->CurrentValue;
		$this->Crit->ViewCustomAttributes = "";

		// AbsorbHP
		$this->AbsorbHP->ViewValue = $this->AbsorbHP->CurrentValue;
		$this->AbsorbHP->ViewCustomAttributes = "";

		// ADPTV
		$this->ADPTV->ViewValue = $this->ADPTV->CurrentValue;
		$this->ADPTV->ViewCustomAttributes = "";

		// ADPTR
		$this->ADPTR->ViewValue = $this->ADPTR->CurrentValue;
		$this->ADPTR->ViewCustomAttributes = "";

		// APPTR
		$this->APPTR->ViewValue = $this->APPTR->CurrentValue;
		$this->APPTR->ViewCustomAttributes = "";

		// APPTV
		$this->APPTV->ViewValue = $this->APPTV->CurrentValue;
		$this->APPTV->ViewCustomAttributes = "";

		// ImmuneDamage
		$this->ImmuneDamage->ViewValue = $this->ImmuneDamage->CurrentValue;
		$this->ImmuneDamage->ViewCustomAttributes = "";

		// Intro
		$this->Intro->ViewValue = $this->Intro->CurrentValue;
		$this->Intro->ViewCustomAttributes = "";

		// ExclusiveSkills
		$this->ExclusiveSkills->ViewValue = $this->ExclusiveSkills->CurrentValue;
		$this->ExclusiveSkills->ViewCustomAttributes = "";

		// TransferDemand
		$this->TransferDemand->ViewValue = $this->TransferDemand->CurrentValue;
		$this->TransferDemand->ViewCustomAttributes = "";

		// TransferLevel
		$this->TransferLevel->ViewValue = $this->TransferLevel->CurrentValue;
		$this->TransferLevel->ViewCustomAttributes = "";

		// FormerOccupation
		$this->FormerOccupation->ViewValue = $this->FormerOccupation->CurrentValue;
		$this->FormerOccupation->ViewCustomAttributes = "";

		// Belong
		$this->Belong->ViewValue = $this->Belong->CurrentValue;
		$this->Belong->ViewCustomAttributes = "";

		// AttackEffect
		$this->AttackEffect->ViewValue = $this->AttackEffect->CurrentValue;
		$this->AttackEffect->ViewCustomAttributes = "";

		// AttackTips
		$this->AttackTips->ViewValue = $this->AttackTips->CurrentValue;
		$this->AttackTips->ViewCustomAttributes = "";

		// MagicResistance
		$this->MagicResistance->ViewValue = $this->MagicResistance->CurrentValue;
		$this->MagicResistance->ViewCustomAttributes = "";

		// IgnoreShield
		$this->IgnoreShield->ViewValue = $this->IgnoreShield->CurrentValue;
		$this->IgnoreShield->ViewCustomAttributes = "";

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

			// Name
			$this->Name->LinkCustomAttributes = "";
			$this->Name->HrefValue = "";
			$this->Name->TooltipValue = "";

			// Basics
			$this->Basics->LinkCustomAttributes = "";
			$this->Basics->HrefValue = "";
			$this->Basics->TooltipValue = "";

			// HP
			$this->HP->LinkCustomAttributes = "";
			$this->HP->HrefValue = "";
			$this->HP->TooltipValue = "";

			// MP
			$this->MP->LinkCustomAttributes = "";
			$this->MP->HrefValue = "";
			$this->MP->TooltipValue = "";

			// AD
			$this->AD->LinkCustomAttributes = "";
			$this->AD->HrefValue = "";
			$this->AD->TooltipValue = "";

			// AP
			$this->AP->LinkCustomAttributes = "";
			$this->AP->HrefValue = "";
			$this->AP->TooltipValue = "";

			// Defense
			$this->Defense->LinkCustomAttributes = "";
			$this->Defense->HrefValue = "";
			$this->Defense->TooltipValue = "";

			// Hit
			$this->Hit->LinkCustomAttributes = "";
			$this->Hit->HrefValue = "";
			$this->Hit->TooltipValue = "";

			// Dodge
			$this->Dodge->LinkCustomAttributes = "";
			$this->Dodge->HrefValue = "";
			$this->Dodge->TooltipValue = "";

			// Crit
			$this->Crit->LinkCustomAttributes = "";
			$this->Crit->HrefValue = "";
			$this->Crit->TooltipValue = "";

			// AbsorbHP
			$this->AbsorbHP->LinkCustomAttributes = "";
			$this->AbsorbHP->HrefValue = "";
			$this->AbsorbHP->TooltipValue = "";

			// ADPTV
			$this->ADPTV->LinkCustomAttributes = "";
			$this->ADPTV->HrefValue = "";
			$this->ADPTV->TooltipValue = "";

			// ADPTR
			$this->ADPTR->LinkCustomAttributes = "";
			$this->ADPTR->HrefValue = "";
			$this->ADPTR->TooltipValue = "";

			// APPTR
			$this->APPTR->LinkCustomAttributes = "";
			$this->APPTR->HrefValue = "";
			$this->APPTR->TooltipValue = "";

			// APPTV
			$this->APPTV->LinkCustomAttributes = "";
			$this->APPTV->HrefValue = "";
			$this->APPTV->TooltipValue = "";

			// ImmuneDamage
			$this->ImmuneDamage->LinkCustomAttributes = "";
			$this->ImmuneDamage->HrefValue = "";
			$this->ImmuneDamage->TooltipValue = "";

			// Intro
			$this->Intro->LinkCustomAttributes = "";
			$this->Intro->HrefValue = "";
			$this->Intro->TooltipValue = "";

			// ExclusiveSkills
			$this->ExclusiveSkills->LinkCustomAttributes = "";
			$this->ExclusiveSkills->HrefValue = "";
			$this->ExclusiveSkills->TooltipValue = "";

			// TransferDemand
			$this->TransferDemand->LinkCustomAttributes = "";
			$this->TransferDemand->HrefValue = "";
			$this->TransferDemand->TooltipValue = "";

			// TransferLevel
			$this->TransferLevel->LinkCustomAttributes = "";
			$this->TransferLevel->HrefValue = "";
			$this->TransferLevel->TooltipValue = "";

			// FormerOccupation
			$this->FormerOccupation->LinkCustomAttributes = "";
			$this->FormerOccupation->HrefValue = "";
			$this->FormerOccupation->TooltipValue = "";

			// Belong
			$this->Belong->LinkCustomAttributes = "";
			$this->Belong->HrefValue = "";
			$this->Belong->TooltipValue = "";

			// AttackEffect
			$this->AttackEffect->LinkCustomAttributes = "";
			$this->AttackEffect->HrefValue = "";
			$this->AttackEffect->TooltipValue = "";

			// AttackTips
			$this->AttackTips->LinkCustomAttributes = "";
			$this->AttackTips->HrefValue = "";
			$this->AttackTips->TooltipValue = "";

			// MagicResistance
			$this->MagicResistance->LinkCustomAttributes = "";
			$this->MagicResistance->HrefValue = "";
			$this->MagicResistance->TooltipValue = "";

			// IgnoreShield
			$this->IgnoreShield->LinkCustomAttributes = "";
			$this->IgnoreShield->HrefValue = "";
			$this->IgnoreShield->TooltipValue = "";

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

			// Name
			$this->Name->EditAttrs["class"] = "form-control";
			$this->Name->EditCustomAttributes = "";
			$this->Name->EditValue = ew_HtmlEncode($this->Name->CurrentValue);
			$this->Name->PlaceHolder = ew_RemoveHtml($this->Name->FldCaption());

			// Basics
			$this->Basics->EditAttrs["class"] = "form-control";
			$this->Basics->EditCustomAttributes = "";
			$this->Basics->EditValue = ew_HtmlEncode($this->Basics->CurrentValue);
			$this->Basics->PlaceHolder = ew_RemoveHtml($this->Basics->FldCaption());

			// HP
			$this->HP->EditAttrs["class"] = "form-control";
			$this->HP->EditCustomAttributes = "";
			$this->HP->EditValue = ew_HtmlEncode($this->HP->CurrentValue);
			$this->HP->PlaceHolder = ew_RemoveHtml($this->HP->FldCaption());

			// MP
			$this->MP->EditAttrs["class"] = "form-control";
			$this->MP->EditCustomAttributes = "";
			$this->MP->EditValue = ew_HtmlEncode($this->MP->CurrentValue);
			$this->MP->PlaceHolder = ew_RemoveHtml($this->MP->FldCaption());

			// AD
			$this->AD->EditAttrs["class"] = "form-control";
			$this->AD->EditCustomAttributes = "";
			$this->AD->EditValue = ew_HtmlEncode($this->AD->CurrentValue);
			$this->AD->PlaceHolder = ew_RemoveHtml($this->AD->FldCaption());

			// AP
			$this->AP->EditAttrs["class"] = "form-control";
			$this->AP->EditCustomAttributes = "";
			$this->AP->EditValue = ew_HtmlEncode($this->AP->CurrentValue);
			$this->AP->PlaceHolder = ew_RemoveHtml($this->AP->FldCaption());

			// Defense
			$this->Defense->EditAttrs["class"] = "form-control";
			$this->Defense->EditCustomAttributes = "";
			$this->Defense->EditValue = ew_HtmlEncode($this->Defense->CurrentValue);
			$this->Defense->PlaceHolder = ew_RemoveHtml($this->Defense->FldCaption());

			// Hit
			$this->Hit->EditAttrs["class"] = "form-control";
			$this->Hit->EditCustomAttributes = "";
			$this->Hit->EditValue = ew_HtmlEncode($this->Hit->CurrentValue);
			$this->Hit->PlaceHolder = ew_RemoveHtml($this->Hit->FldCaption());

			// Dodge
			$this->Dodge->EditAttrs["class"] = "form-control";
			$this->Dodge->EditCustomAttributes = "";
			$this->Dodge->EditValue = ew_HtmlEncode($this->Dodge->CurrentValue);
			$this->Dodge->PlaceHolder = ew_RemoveHtml($this->Dodge->FldCaption());

			// Crit
			$this->Crit->EditAttrs["class"] = "form-control";
			$this->Crit->EditCustomAttributes = "";
			$this->Crit->EditValue = ew_HtmlEncode($this->Crit->CurrentValue);
			$this->Crit->PlaceHolder = ew_RemoveHtml($this->Crit->FldCaption());

			// AbsorbHP
			$this->AbsorbHP->EditAttrs["class"] = "form-control";
			$this->AbsorbHP->EditCustomAttributes = "";
			$this->AbsorbHP->EditValue = ew_HtmlEncode($this->AbsorbHP->CurrentValue);
			$this->AbsorbHP->PlaceHolder = ew_RemoveHtml($this->AbsorbHP->FldCaption());

			// ADPTV
			$this->ADPTV->EditAttrs["class"] = "form-control";
			$this->ADPTV->EditCustomAttributes = "";
			$this->ADPTV->EditValue = ew_HtmlEncode($this->ADPTV->CurrentValue);
			$this->ADPTV->PlaceHolder = ew_RemoveHtml($this->ADPTV->FldCaption());

			// ADPTR
			$this->ADPTR->EditAttrs["class"] = "form-control";
			$this->ADPTR->EditCustomAttributes = "";
			$this->ADPTR->EditValue = ew_HtmlEncode($this->ADPTR->CurrentValue);
			$this->ADPTR->PlaceHolder = ew_RemoveHtml($this->ADPTR->FldCaption());

			// APPTR
			$this->APPTR->EditAttrs["class"] = "form-control";
			$this->APPTR->EditCustomAttributes = "";
			$this->APPTR->EditValue = ew_HtmlEncode($this->APPTR->CurrentValue);
			$this->APPTR->PlaceHolder = ew_RemoveHtml($this->APPTR->FldCaption());

			// APPTV
			$this->APPTV->EditAttrs["class"] = "form-control";
			$this->APPTV->EditCustomAttributes = "";
			$this->APPTV->EditValue = ew_HtmlEncode($this->APPTV->CurrentValue);
			$this->APPTV->PlaceHolder = ew_RemoveHtml($this->APPTV->FldCaption());

			// ImmuneDamage
			$this->ImmuneDamage->EditAttrs["class"] = "form-control";
			$this->ImmuneDamage->EditCustomAttributes = "";
			$this->ImmuneDamage->EditValue = ew_HtmlEncode($this->ImmuneDamage->CurrentValue);
			$this->ImmuneDamage->PlaceHolder = ew_RemoveHtml($this->ImmuneDamage->FldCaption());

			// Intro
			$this->Intro->EditAttrs["class"] = "form-control";
			$this->Intro->EditCustomAttributes = "";
			$this->Intro->EditValue = ew_HtmlEncode($this->Intro->CurrentValue);
			$this->Intro->PlaceHolder = ew_RemoveHtml($this->Intro->FldCaption());

			// ExclusiveSkills
			$this->ExclusiveSkills->EditAttrs["class"] = "form-control";
			$this->ExclusiveSkills->EditCustomAttributes = "";
			$this->ExclusiveSkills->EditValue = ew_HtmlEncode($this->ExclusiveSkills->CurrentValue);
			$this->ExclusiveSkills->PlaceHolder = ew_RemoveHtml($this->ExclusiveSkills->FldCaption());

			// TransferDemand
			$this->TransferDemand->EditAttrs["class"] = "form-control";
			$this->TransferDemand->EditCustomAttributes = "";
			$this->TransferDemand->EditValue = ew_HtmlEncode($this->TransferDemand->CurrentValue);
			$this->TransferDemand->PlaceHolder = ew_RemoveHtml($this->TransferDemand->FldCaption());

			// TransferLevel
			$this->TransferLevel->EditAttrs["class"] = "form-control";
			$this->TransferLevel->EditCustomAttributes = "";
			$this->TransferLevel->EditValue = ew_HtmlEncode($this->TransferLevel->CurrentValue);
			$this->TransferLevel->PlaceHolder = ew_RemoveHtml($this->TransferLevel->FldCaption());

			// FormerOccupation
			$this->FormerOccupation->EditAttrs["class"] = "form-control";
			$this->FormerOccupation->EditCustomAttributes = "";
			$this->FormerOccupation->EditValue = ew_HtmlEncode($this->FormerOccupation->CurrentValue);
			$this->FormerOccupation->PlaceHolder = ew_RemoveHtml($this->FormerOccupation->FldCaption());

			// Belong
			$this->Belong->EditAttrs["class"] = "form-control";
			$this->Belong->EditCustomAttributes = "";
			$this->Belong->EditValue = ew_HtmlEncode($this->Belong->CurrentValue);
			$this->Belong->PlaceHolder = ew_RemoveHtml($this->Belong->FldCaption());

			// AttackEffect
			$this->AttackEffect->EditAttrs["class"] = "form-control";
			$this->AttackEffect->EditCustomAttributes = "";
			$this->AttackEffect->EditValue = ew_HtmlEncode($this->AttackEffect->CurrentValue);
			$this->AttackEffect->PlaceHolder = ew_RemoveHtml($this->AttackEffect->FldCaption());

			// AttackTips
			$this->AttackTips->EditAttrs["class"] = "form-control";
			$this->AttackTips->EditCustomAttributes = "";
			$this->AttackTips->EditValue = ew_HtmlEncode($this->AttackTips->CurrentValue);
			$this->AttackTips->PlaceHolder = ew_RemoveHtml($this->AttackTips->FldCaption());

			// MagicResistance
			$this->MagicResistance->EditAttrs["class"] = "form-control";
			$this->MagicResistance->EditCustomAttributes = "";
			$this->MagicResistance->EditValue = ew_HtmlEncode($this->MagicResistance->CurrentValue);
			$this->MagicResistance->PlaceHolder = ew_RemoveHtml($this->MagicResistance->FldCaption());

			// IgnoreShield
			$this->IgnoreShield->EditAttrs["class"] = "form-control";
			$this->IgnoreShield->EditCustomAttributes = "";
			$this->IgnoreShield->EditValue = ew_HtmlEncode($this->IgnoreShield->CurrentValue);
			$this->IgnoreShield->PlaceHolder = ew_RemoveHtml($this->IgnoreShield->FldCaption());

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

			// Name
			$this->Name->LinkCustomAttributes = "";
			$this->Name->HrefValue = "";

			// Basics
			$this->Basics->LinkCustomAttributes = "";
			$this->Basics->HrefValue = "";

			// HP
			$this->HP->LinkCustomAttributes = "";
			$this->HP->HrefValue = "";

			// MP
			$this->MP->LinkCustomAttributes = "";
			$this->MP->HrefValue = "";

			// AD
			$this->AD->LinkCustomAttributes = "";
			$this->AD->HrefValue = "";

			// AP
			$this->AP->LinkCustomAttributes = "";
			$this->AP->HrefValue = "";

			// Defense
			$this->Defense->LinkCustomAttributes = "";
			$this->Defense->HrefValue = "";

			// Hit
			$this->Hit->LinkCustomAttributes = "";
			$this->Hit->HrefValue = "";

			// Dodge
			$this->Dodge->LinkCustomAttributes = "";
			$this->Dodge->HrefValue = "";

			// Crit
			$this->Crit->LinkCustomAttributes = "";
			$this->Crit->HrefValue = "";

			// AbsorbHP
			$this->AbsorbHP->LinkCustomAttributes = "";
			$this->AbsorbHP->HrefValue = "";

			// ADPTV
			$this->ADPTV->LinkCustomAttributes = "";
			$this->ADPTV->HrefValue = "";

			// ADPTR
			$this->ADPTR->LinkCustomAttributes = "";
			$this->ADPTR->HrefValue = "";

			// APPTR
			$this->APPTR->LinkCustomAttributes = "";
			$this->APPTR->HrefValue = "";

			// APPTV
			$this->APPTV->LinkCustomAttributes = "";
			$this->APPTV->HrefValue = "";

			// ImmuneDamage
			$this->ImmuneDamage->LinkCustomAttributes = "";
			$this->ImmuneDamage->HrefValue = "";

			// Intro
			$this->Intro->LinkCustomAttributes = "";
			$this->Intro->HrefValue = "";

			// ExclusiveSkills
			$this->ExclusiveSkills->LinkCustomAttributes = "";
			$this->ExclusiveSkills->HrefValue = "";

			// TransferDemand
			$this->TransferDemand->LinkCustomAttributes = "";
			$this->TransferDemand->HrefValue = "";

			// TransferLevel
			$this->TransferLevel->LinkCustomAttributes = "";
			$this->TransferLevel->HrefValue = "";

			// FormerOccupation
			$this->FormerOccupation->LinkCustomAttributes = "";
			$this->FormerOccupation->HrefValue = "";

			// Belong
			$this->Belong->LinkCustomAttributes = "";
			$this->Belong->HrefValue = "";

			// AttackEffect
			$this->AttackEffect->LinkCustomAttributes = "";
			$this->AttackEffect->HrefValue = "";

			// AttackTips
			$this->AttackTips->LinkCustomAttributes = "";
			$this->AttackTips->HrefValue = "";

			// MagicResistance
			$this->MagicResistance->LinkCustomAttributes = "";
			$this->MagicResistance->HrefValue = "";

			// IgnoreShield
			$this->IgnoreShield->LinkCustomAttributes = "";
			$this->IgnoreShield->HrefValue = "";

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
		if (!$this->Basics->FldIsDetailKey && !is_null($this->Basics->FormValue) && $this->Basics->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Basics->FldCaption(), $this->Basics->ReqErrMsg));
		}
		if (!$this->HP->FldIsDetailKey && !is_null($this->HP->FormValue) && $this->HP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->HP->FldCaption(), $this->HP->ReqErrMsg));
		}
		if (!$this->MP->FldIsDetailKey && !is_null($this->MP->FormValue) && $this->MP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->MP->FldCaption(), $this->MP->ReqErrMsg));
		}
		if (!$this->AD->FldIsDetailKey && !is_null($this->AD->FormValue) && $this->AD->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AD->FldCaption(), $this->AD->ReqErrMsg));
		}
		if (!$this->AP->FldIsDetailKey && !is_null($this->AP->FormValue) && $this->AP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AP->FldCaption(), $this->AP->ReqErrMsg));
		}
		if (!$this->Defense->FldIsDetailKey && !is_null($this->Defense->FormValue) && $this->Defense->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Defense->FldCaption(), $this->Defense->ReqErrMsg));
		}
		if (!$this->Hit->FldIsDetailKey && !is_null($this->Hit->FormValue) && $this->Hit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Hit->FldCaption(), $this->Hit->ReqErrMsg));
		}
		if (!$this->Dodge->FldIsDetailKey && !is_null($this->Dodge->FormValue) && $this->Dodge->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dodge->FldCaption(), $this->Dodge->ReqErrMsg));
		}
		if (!$this->Crit->FldIsDetailKey && !is_null($this->Crit->FormValue) && $this->Crit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Crit->FldCaption(), $this->Crit->ReqErrMsg));
		}
		if (!$this->AbsorbHP->FldIsDetailKey && !is_null($this->AbsorbHP->FormValue) && $this->AbsorbHP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AbsorbHP->FldCaption(), $this->AbsorbHP->ReqErrMsg));
		}
		if (!$this->ADPTV->FldIsDetailKey && !is_null($this->ADPTV->FormValue) && $this->ADPTV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ADPTV->FldCaption(), $this->ADPTV->ReqErrMsg));
		}
		if (!$this->ADPTR->FldIsDetailKey && !is_null($this->ADPTR->FormValue) && $this->ADPTR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ADPTR->FldCaption(), $this->ADPTR->ReqErrMsg));
		}
		if (!$this->APPTR->FldIsDetailKey && !is_null($this->APPTR->FormValue) && $this->APPTR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->APPTR->FldCaption(), $this->APPTR->ReqErrMsg));
		}
		if (!$this->APPTV->FldIsDetailKey && !is_null($this->APPTV->FormValue) && $this->APPTV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->APPTV->FldCaption(), $this->APPTV->ReqErrMsg));
		}
		if (!$this->ImmuneDamage->FldIsDetailKey && !is_null($this->ImmuneDamage->FormValue) && $this->ImmuneDamage->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ImmuneDamage->FldCaption(), $this->ImmuneDamage->ReqErrMsg));
		}
		if (!$this->Intro->FldIsDetailKey && !is_null($this->Intro->FormValue) && $this->Intro->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Intro->FldCaption(), $this->Intro->ReqErrMsg));
		}
		if (!$this->ExclusiveSkills->FldIsDetailKey && !is_null($this->ExclusiveSkills->FormValue) && $this->ExclusiveSkills->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ExclusiveSkills->FldCaption(), $this->ExclusiveSkills->ReqErrMsg));
		}
		if (!$this->TransferDemand->FldIsDetailKey && !is_null($this->TransferDemand->FormValue) && $this->TransferDemand->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TransferDemand->FldCaption(), $this->TransferDemand->ReqErrMsg));
		}
		if (!$this->TransferLevel->FldIsDetailKey && !is_null($this->TransferLevel->FormValue) && $this->TransferLevel->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TransferLevel->FldCaption(), $this->TransferLevel->ReqErrMsg));
		}
		if (!$this->FormerOccupation->FldIsDetailKey && !is_null($this->FormerOccupation->FormValue) && $this->FormerOccupation->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->FormerOccupation->FldCaption(), $this->FormerOccupation->ReqErrMsg));
		}
		if (!$this->Belong->FldIsDetailKey && !is_null($this->Belong->FormValue) && $this->Belong->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Belong->FldCaption(), $this->Belong->ReqErrMsg));
		}
		if (!$this->AttackEffect->FldIsDetailKey && !is_null($this->AttackEffect->FormValue) && $this->AttackEffect->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AttackEffect->FldCaption(), $this->AttackEffect->ReqErrMsg));
		}
		if (!$this->AttackTips->FldIsDetailKey && !is_null($this->AttackTips->FormValue) && $this->AttackTips->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AttackTips->FldCaption(), $this->AttackTips->ReqErrMsg));
		}
		if (!$this->MagicResistance->FldIsDetailKey && !is_null($this->MagicResistance->FormValue) && $this->MagicResistance->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->MagicResistance->FldCaption(), $this->MagicResistance->ReqErrMsg));
		}
		if (!$this->IgnoreShield->FldIsDetailKey && !is_null($this->IgnoreShield->FormValue) && $this->IgnoreShield->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->IgnoreShield->FldCaption(), $this->IgnoreShield->ReqErrMsg));
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

		// Name
		$this->Name->SetDbValueDef($rsnew, $this->Name->CurrentValue, "", FALSE);

		// Basics
		$this->Basics->SetDbValueDef($rsnew, $this->Basics->CurrentValue, "", FALSE);

		// HP
		$this->HP->SetDbValueDef($rsnew, $this->HP->CurrentValue, "", FALSE);

		// MP
		$this->MP->SetDbValueDef($rsnew, $this->MP->CurrentValue, "", FALSE);

		// AD
		$this->AD->SetDbValueDef($rsnew, $this->AD->CurrentValue, "", FALSE);

		// AP
		$this->AP->SetDbValueDef($rsnew, $this->AP->CurrentValue, "", FALSE);

		// Defense
		$this->Defense->SetDbValueDef($rsnew, $this->Defense->CurrentValue, "", FALSE);

		// Hit
		$this->Hit->SetDbValueDef($rsnew, $this->Hit->CurrentValue, "", FALSE);

		// Dodge
		$this->Dodge->SetDbValueDef($rsnew, $this->Dodge->CurrentValue, "", FALSE);

		// Crit
		$this->Crit->SetDbValueDef($rsnew, $this->Crit->CurrentValue, "", FALSE);

		// AbsorbHP
		$this->AbsorbHP->SetDbValueDef($rsnew, $this->AbsorbHP->CurrentValue, "", FALSE);

		// ADPTV
		$this->ADPTV->SetDbValueDef($rsnew, $this->ADPTV->CurrentValue, "", FALSE);

		// ADPTR
		$this->ADPTR->SetDbValueDef($rsnew, $this->ADPTR->CurrentValue, "", FALSE);

		// APPTR
		$this->APPTR->SetDbValueDef($rsnew, $this->APPTR->CurrentValue, "", FALSE);

		// APPTV
		$this->APPTV->SetDbValueDef($rsnew, $this->APPTV->CurrentValue, "", FALSE);

		// ImmuneDamage
		$this->ImmuneDamage->SetDbValueDef($rsnew, $this->ImmuneDamage->CurrentValue, "", FALSE);

		// Intro
		$this->Intro->SetDbValueDef($rsnew, $this->Intro->CurrentValue, "", FALSE);

		// ExclusiveSkills
		$this->ExclusiveSkills->SetDbValueDef($rsnew, $this->ExclusiveSkills->CurrentValue, "", FALSE);

		// TransferDemand
		$this->TransferDemand->SetDbValueDef($rsnew, $this->TransferDemand->CurrentValue, "", FALSE);

		// TransferLevel
		$this->TransferLevel->SetDbValueDef($rsnew, $this->TransferLevel->CurrentValue, "", FALSE);

		// FormerOccupation
		$this->FormerOccupation->SetDbValueDef($rsnew, $this->FormerOccupation->CurrentValue, "", FALSE);

		// Belong
		$this->Belong->SetDbValueDef($rsnew, $this->Belong->CurrentValue, "", FALSE);

		// AttackEffect
		$this->AttackEffect->SetDbValueDef($rsnew, $this->AttackEffect->CurrentValue, "", FALSE);

		// AttackTips
		$this->AttackTips->SetDbValueDef($rsnew, $this->AttackTips->CurrentValue, "", FALSE);

		// MagicResistance
		$this->MagicResistance->SetDbValueDef($rsnew, $this->MagicResistance->CurrentValue, "", FALSE);

		// IgnoreShield
		$this->IgnoreShield->SetDbValueDef($rsnew, $this->IgnoreShield->CurrentValue, "", FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_occupationlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_occupation_add)) $config_occupation_add = new cconfig_occupation_add();

// Page init
$config_occupation_add->Page_Init();

// Page main
$config_occupation_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_occupation_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fconfig_occupationadd = new ew_Form("fconfig_occupationadd", "add");

// Validate form
fconfig_occupationadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->u_id->FldCaption(), $config_occupation->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_occupation->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->acl_id->FldCaption(), $config_occupation->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_occupation->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->Name->FldCaption(), $config_occupation->Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Basics");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->Basics->FldCaption(), $config_occupation->Basics->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_HP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->HP->FldCaption(), $config_occupation->HP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_MP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->MP->FldCaption(), $config_occupation->MP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AD");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->AD->FldCaption(), $config_occupation->AD->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->AP->FldCaption(), $config_occupation->AP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Defense");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->Defense->FldCaption(), $config_occupation->Defense->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Hit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->Hit->FldCaption(), $config_occupation->Hit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dodge");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->Dodge->FldCaption(), $config_occupation->Dodge->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Crit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->Crit->FldCaption(), $config_occupation->Crit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AbsorbHP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->AbsorbHP->FldCaption(), $config_occupation->AbsorbHP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ADPTV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->ADPTV->FldCaption(), $config_occupation->ADPTV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ADPTR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->ADPTR->FldCaption(), $config_occupation->ADPTR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_APPTR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->APPTR->FldCaption(), $config_occupation->APPTR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_APPTV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->APPTV->FldCaption(), $config_occupation->APPTV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ImmuneDamage");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->ImmuneDamage->FldCaption(), $config_occupation->ImmuneDamage->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Intro");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->Intro->FldCaption(), $config_occupation->Intro->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ExclusiveSkills");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->ExclusiveSkills->FldCaption(), $config_occupation->ExclusiveSkills->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TransferDemand");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->TransferDemand->FldCaption(), $config_occupation->TransferDemand->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TransferLevel");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->TransferLevel->FldCaption(), $config_occupation->TransferLevel->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_FormerOccupation");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->FormerOccupation->FldCaption(), $config_occupation->FormerOccupation->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Belong");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->Belong->FldCaption(), $config_occupation->Belong->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AttackEffect");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->AttackEffect->FldCaption(), $config_occupation->AttackEffect->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AttackTips");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->AttackTips->FldCaption(), $config_occupation->AttackTips->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_MagicResistance");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->MagicResistance->FldCaption(), $config_occupation->MagicResistance->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_IgnoreShield");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->IgnoreShield->FldCaption(), $config_occupation->IgnoreShield->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_occupation->DATETIME->FldCaption(), $config_occupation->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_occupation->DATETIME->FldErrMsg()) ?>");

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
fconfig_occupationadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_occupationadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $config_occupation_add->ShowPageHeader(); ?>
<?php
$config_occupation_add->ShowMessage();
?>
<form name="fconfig_occupationadd" id="fconfig_occupationadd" class="<?php echo $config_occupation_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_occupation_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_occupation_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_occupation">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($config_occupation_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($config_occupation->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_config_occupation_u_id" for="x_u_id" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->u_id->CellAttributes() ?>>
<span id="el_config_occupation_u_id">
<input type="text" data-table="config_occupation" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_occupation->u_id->getPlaceHolder()) ?>" value="<?php echo $config_occupation->u_id->EditValue ?>"<?php echo $config_occupation->u_id->EditAttributes() ?>>
</span>
<?php echo $config_occupation->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_config_occupation_acl_id" for="x_acl_id" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->acl_id->CellAttributes() ?>>
<span id="el_config_occupation_acl_id">
<input type="text" data-table="config_occupation" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_occupation->acl_id->getPlaceHolder()) ?>" value="<?php echo $config_occupation->acl_id->EditValue ?>"<?php echo $config_occupation->acl_id->EditAttributes() ?>>
</span>
<?php echo $config_occupation->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->Name->Visible) { // Name ?>
	<div id="r_Name" class="form-group">
		<label id="elh_config_occupation_Name" for="x_Name" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->Name->CellAttributes() ?>>
<span id="el_config_occupation_Name">
<textarea data-table="config_occupation" data-field="x_Name" name="x_Name" id="x_Name" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->Name->getPlaceHolder()) ?>"<?php echo $config_occupation->Name->EditAttributes() ?>><?php echo $config_occupation->Name->EditValue ?></textarea>
</span>
<?php echo $config_occupation->Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->Basics->Visible) { // Basics ?>
	<div id="r_Basics" class="form-group">
		<label id="elh_config_occupation_Basics" for="x_Basics" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->Basics->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->Basics->CellAttributes() ?>>
<span id="el_config_occupation_Basics">
<textarea data-table="config_occupation" data-field="x_Basics" name="x_Basics" id="x_Basics" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->Basics->getPlaceHolder()) ?>"<?php echo $config_occupation->Basics->EditAttributes() ?>><?php echo $config_occupation->Basics->EditValue ?></textarea>
</span>
<?php echo $config_occupation->Basics->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->HP->Visible) { // HP ?>
	<div id="r_HP" class="form-group">
		<label id="elh_config_occupation_HP" for="x_HP" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->HP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->HP->CellAttributes() ?>>
<span id="el_config_occupation_HP">
<textarea data-table="config_occupation" data-field="x_HP" name="x_HP" id="x_HP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->HP->getPlaceHolder()) ?>"<?php echo $config_occupation->HP->EditAttributes() ?>><?php echo $config_occupation->HP->EditValue ?></textarea>
</span>
<?php echo $config_occupation->HP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->MP->Visible) { // MP ?>
	<div id="r_MP" class="form-group">
		<label id="elh_config_occupation_MP" for="x_MP" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->MP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->MP->CellAttributes() ?>>
<span id="el_config_occupation_MP">
<textarea data-table="config_occupation" data-field="x_MP" name="x_MP" id="x_MP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->MP->getPlaceHolder()) ?>"<?php echo $config_occupation->MP->EditAttributes() ?>><?php echo $config_occupation->MP->EditValue ?></textarea>
</span>
<?php echo $config_occupation->MP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->AD->Visible) { // AD ?>
	<div id="r_AD" class="form-group">
		<label id="elh_config_occupation_AD" for="x_AD" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->AD->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->AD->CellAttributes() ?>>
<span id="el_config_occupation_AD">
<textarea data-table="config_occupation" data-field="x_AD" name="x_AD" id="x_AD" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->AD->getPlaceHolder()) ?>"<?php echo $config_occupation->AD->EditAttributes() ?>><?php echo $config_occupation->AD->EditValue ?></textarea>
</span>
<?php echo $config_occupation->AD->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->AP->Visible) { // AP ?>
	<div id="r_AP" class="form-group">
		<label id="elh_config_occupation_AP" for="x_AP" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->AP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->AP->CellAttributes() ?>>
<span id="el_config_occupation_AP">
<textarea data-table="config_occupation" data-field="x_AP" name="x_AP" id="x_AP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->AP->getPlaceHolder()) ?>"<?php echo $config_occupation->AP->EditAttributes() ?>><?php echo $config_occupation->AP->EditValue ?></textarea>
</span>
<?php echo $config_occupation->AP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->Defense->Visible) { // Defense ?>
	<div id="r_Defense" class="form-group">
		<label id="elh_config_occupation_Defense" for="x_Defense" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->Defense->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->Defense->CellAttributes() ?>>
<span id="el_config_occupation_Defense">
<textarea data-table="config_occupation" data-field="x_Defense" name="x_Defense" id="x_Defense" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->Defense->getPlaceHolder()) ?>"<?php echo $config_occupation->Defense->EditAttributes() ?>><?php echo $config_occupation->Defense->EditValue ?></textarea>
</span>
<?php echo $config_occupation->Defense->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->Hit->Visible) { // Hit ?>
	<div id="r_Hit" class="form-group">
		<label id="elh_config_occupation_Hit" for="x_Hit" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->Hit->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->Hit->CellAttributes() ?>>
<span id="el_config_occupation_Hit">
<textarea data-table="config_occupation" data-field="x_Hit" name="x_Hit" id="x_Hit" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->Hit->getPlaceHolder()) ?>"<?php echo $config_occupation->Hit->EditAttributes() ?>><?php echo $config_occupation->Hit->EditValue ?></textarea>
</span>
<?php echo $config_occupation->Hit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->Dodge->Visible) { // Dodge ?>
	<div id="r_Dodge" class="form-group">
		<label id="elh_config_occupation_Dodge" for="x_Dodge" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->Dodge->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->Dodge->CellAttributes() ?>>
<span id="el_config_occupation_Dodge">
<textarea data-table="config_occupation" data-field="x_Dodge" name="x_Dodge" id="x_Dodge" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->Dodge->getPlaceHolder()) ?>"<?php echo $config_occupation->Dodge->EditAttributes() ?>><?php echo $config_occupation->Dodge->EditValue ?></textarea>
</span>
<?php echo $config_occupation->Dodge->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->Crit->Visible) { // Crit ?>
	<div id="r_Crit" class="form-group">
		<label id="elh_config_occupation_Crit" for="x_Crit" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->Crit->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->Crit->CellAttributes() ?>>
<span id="el_config_occupation_Crit">
<textarea data-table="config_occupation" data-field="x_Crit" name="x_Crit" id="x_Crit" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->Crit->getPlaceHolder()) ?>"<?php echo $config_occupation->Crit->EditAttributes() ?>><?php echo $config_occupation->Crit->EditValue ?></textarea>
</span>
<?php echo $config_occupation->Crit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->AbsorbHP->Visible) { // AbsorbHP ?>
	<div id="r_AbsorbHP" class="form-group">
		<label id="elh_config_occupation_AbsorbHP" for="x_AbsorbHP" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->AbsorbHP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->AbsorbHP->CellAttributes() ?>>
<span id="el_config_occupation_AbsorbHP">
<textarea data-table="config_occupation" data-field="x_AbsorbHP" name="x_AbsorbHP" id="x_AbsorbHP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->AbsorbHP->getPlaceHolder()) ?>"<?php echo $config_occupation->AbsorbHP->EditAttributes() ?>><?php echo $config_occupation->AbsorbHP->EditValue ?></textarea>
</span>
<?php echo $config_occupation->AbsorbHP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->ADPTV->Visible) { // ADPTV ?>
	<div id="r_ADPTV" class="form-group">
		<label id="elh_config_occupation_ADPTV" for="x_ADPTV" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->ADPTV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->ADPTV->CellAttributes() ?>>
<span id="el_config_occupation_ADPTV">
<textarea data-table="config_occupation" data-field="x_ADPTV" name="x_ADPTV" id="x_ADPTV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->ADPTV->getPlaceHolder()) ?>"<?php echo $config_occupation->ADPTV->EditAttributes() ?>><?php echo $config_occupation->ADPTV->EditValue ?></textarea>
</span>
<?php echo $config_occupation->ADPTV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->ADPTR->Visible) { // ADPTR ?>
	<div id="r_ADPTR" class="form-group">
		<label id="elh_config_occupation_ADPTR" for="x_ADPTR" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->ADPTR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->ADPTR->CellAttributes() ?>>
<span id="el_config_occupation_ADPTR">
<textarea data-table="config_occupation" data-field="x_ADPTR" name="x_ADPTR" id="x_ADPTR" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->ADPTR->getPlaceHolder()) ?>"<?php echo $config_occupation->ADPTR->EditAttributes() ?>><?php echo $config_occupation->ADPTR->EditValue ?></textarea>
</span>
<?php echo $config_occupation->ADPTR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->APPTR->Visible) { // APPTR ?>
	<div id="r_APPTR" class="form-group">
		<label id="elh_config_occupation_APPTR" for="x_APPTR" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->APPTR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->APPTR->CellAttributes() ?>>
<span id="el_config_occupation_APPTR">
<textarea data-table="config_occupation" data-field="x_APPTR" name="x_APPTR" id="x_APPTR" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->APPTR->getPlaceHolder()) ?>"<?php echo $config_occupation->APPTR->EditAttributes() ?>><?php echo $config_occupation->APPTR->EditValue ?></textarea>
</span>
<?php echo $config_occupation->APPTR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->APPTV->Visible) { // APPTV ?>
	<div id="r_APPTV" class="form-group">
		<label id="elh_config_occupation_APPTV" for="x_APPTV" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->APPTV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->APPTV->CellAttributes() ?>>
<span id="el_config_occupation_APPTV">
<textarea data-table="config_occupation" data-field="x_APPTV" name="x_APPTV" id="x_APPTV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->APPTV->getPlaceHolder()) ?>"<?php echo $config_occupation->APPTV->EditAttributes() ?>><?php echo $config_occupation->APPTV->EditValue ?></textarea>
</span>
<?php echo $config_occupation->APPTV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->ImmuneDamage->Visible) { // ImmuneDamage ?>
	<div id="r_ImmuneDamage" class="form-group">
		<label id="elh_config_occupation_ImmuneDamage" for="x_ImmuneDamage" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->ImmuneDamage->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->ImmuneDamage->CellAttributes() ?>>
<span id="el_config_occupation_ImmuneDamage">
<textarea data-table="config_occupation" data-field="x_ImmuneDamage" name="x_ImmuneDamage" id="x_ImmuneDamage" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->ImmuneDamage->getPlaceHolder()) ?>"<?php echo $config_occupation->ImmuneDamage->EditAttributes() ?>><?php echo $config_occupation->ImmuneDamage->EditValue ?></textarea>
</span>
<?php echo $config_occupation->ImmuneDamage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->Intro->Visible) { // Intro ?>
	<div id="r_Intro" class="form-group">
		<label id="elh_config_occupation_Intro" for="x_Intro" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->Intro->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->Intro->CellAttributes() ?>>
<span id="el_config_occupation_Intro">
<textarea data-table="config_occupation" data-field="x_Intro" name="x_Intro" id="x_Intro" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->Intro->getPlaceHolder()) ?>"<?php echo $config_occupation->Intro->EditAttributes() ?>><?php echo $config_occupation->Intro->EditValue ?></textarea>
</span>
<?php echo $config_occupation->Intro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->ExclusiveSkills->Visible) { // ExclusiveSkills ?>
	<div id="r_ExclusiveSkills" class="form-group">
		<label id="elh_config_occupation_ExclusiveSkills" for="x_ExclusiveSkills" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->ExclusiveSkills->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->ExclusiveSkills->CellAttributes() ?>>
<span id="el_config_occupation_ExclusiveSkills">
<textarea data-table="config_occupation" data-field="x_ExclusiveSkills" name="x_ExclusiveSkills" id="x_ExclusiveSkills" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->ExclusiveSkills->getPlaceHolder()) ?>"<?php echo $config_occupation->ExclusiveSkills->EditAttributes() ?>><?php echo $config_occupation->ExclusiveSkills->EditValue ?></textarea>
</span>
<?php echo $config_occupation->ExclusiveSkills->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->TransferDemand->Visible) { // TransferDemand ?>
	<div id="r_TransferDemand" class="form-group">
		<label id="elh_config_occupation_TransferDemand" for="x_TransferDemand" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->TransferDemand->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->TransferDemand->CellAttributes() ?>>
<span id="el_config_occupation_TransferDemand">
<textarea data-table="config_occupation" data-field="x_TransferDemand" name="x_TransferDemand" id="x_TransferDemand" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->TransferDemand->getPlaceHolder()) ?>"<?php echo $config_occupation->TransferDemand->EditAttributes() ?>><?php echo $config_occupation->TransferDemand->EditValue ?></textarea>
</span>
<?php echo $config_occupation->TransferDemand->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->TransferLevel->Visible) { // TransferLevel ?>
	<div id="r_TransferLevel" class="form-group">
		<label id="elh_config_occupation_TransferLevel" for="x_TransferLevel" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->TransferLevel->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->TransferLevel->CellAttributes() ?>>
<span id="el_config_occupation_TransferLevel">
<textarea data-table="config_occupation" data-field="x_TransferLevel" name="x_TransferLevel" id="x_TransferLevel" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->TransferLevel->getPlaceHolder()) ?>"<?php echo $config_occupation->TransferLevel->EditAttributes() ?>><?php echo $config_occupation->TransferLevel->EditValue ?></textarea>
</span>
<?php echo $config_occupation->TransferLevel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->FormerOccupation->Visible) { // FormerOccupation ?>
	<div id="r_FormerOccupation" class="form-group">
		<label id="elh_config_occupation_FormerOccupation" for="x_FormerOccupation" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->FormerOccupation->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->FormerOccupation->CellAttributes() ?>>
<span id="el_config_occupation_FormerOccupation">
<textarea data-table="config_occupation" data-field="x_FormerOccupation" name="x_FormerOccupation" id="x_FormerOccupation" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->FormerOccupation->getPlaceHolder()) ?>"<?php echo $config_occupation->FormerOccupation->EditAttributes() ?>><?php echo $config_occupation->FormerOccupation->EditValue ?></textarea>
</span>
<?php echo $config_occupation->FormerOccupation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->Belong->Visible) { // Belong ?>
	<div id="r_Belong" class="form-group">
		<label id="elh_config_occupation_Belong" for="x_Belong" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->Belong->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->Belong->CellAttributes() ?>>
<span id="el_config_occupation_Belong">
<textarea data-table="config_occupation" data-field="x_Belong" name="x_Belong" id="x_Belong" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->Belong->getPlaceHolder()) ?>"<?php echo $config_occupation->Belong->EditAttributes() ?>><?php echo $config_occupation->Belong->EditValue ?></textarea>
</span>
<?php echo $config_occupation->Belong->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->AttackEffect->Visible) { // AttackEffect ?>
	<div id="r_AttackEffect" class="form-group">
		<label id="elh_config_occupation_AttackEffect" for="x_AttackEffect" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->AttackEffect->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->AttackEffect->CellAttributes() ?>>
<span id="el_config_occupation_AttackEffect">
<textarea data-table="config_occupation" data-field="x_AttackEffect" name="x_AttackEffect" id="x_AttackEffect" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->AttackEffect->getPlaceHolder()) ?>"<?php echo $config_occupation->AttackEffect->EditAttributes() ?>><?php echo $config_occupation->AttackEffect->EditValue ?></textarea>
</span>
<?php echo $config_occupation->AttackEffect->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->AttackTips->Visible) { // AttackTips ?>
	<div id="r_AttackTips" class="form-group">
		<label id="elh_config_occupation_AttackTips" for="x_AttackTips" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->AttackTips->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->AttackTips->CellAttributes() ?>>
<span id="el_config_occupation_AttackTips">
<textarea data-table="config_occupation" data-field="x_AttackTips" name="x_AttackTips" id="x_AttackTips" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->AttackTips->getPlaceHolder()) ?>"<?php echo $config_occupation->AttackTips->EditAttributes() ?>><?php echo $config_occupation->AttackTips->EditValue ?></textarea>
</span>
<?php echo $config_occupation->AttackTips->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->MagicResistance->Visible) { // MagicResistance ?>
	<div id="r_MagicResistance" class="form-group">
		<label id="elh_config_occupation_MagicResistance" for="x_MagicResistance" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->MagicResistance->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->MagicResistance->CellAttributes() ?>>
<span id="el_config_occupation_MagicResistance">
<textarea data-table="config_occupation" data-field="x_MagicResistance" name="x_MagicResistance" id="x_MagicResistance" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->MagicResistance->getPlaceHolder()) ?>"<?php echo $config_occupation->MagicResistance->EditAttributes() ?>><?php echo $config_occupation->MagicResistance->EditValue ?></textarea>
</span>
<?php echo $config_occupation->MagicResistance->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->IgnoreShield->Visible) { // IgnoreShield ?>
	<div id="r_IgnoreShield" class="form-group">
		<label id="elh_config_occupation_IgnoreShield" for="x_IgnoreShield" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->IgnoreShield->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->IgnoreShield->CellAttributes() ?>>
<span id="el_config_occupation_IgnoreShield">
<textarea data-table="config_occupation" data-field="x_IgnoreShield" name="x_IgnoreShield" id="x_IgnoreShield" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_occupation->IgnoreShield->getPlaceHolder()) ?>"<?php echo $config_occupation->IgnoreShield->EditAttributes() ?>><?php echo $config_occupation->IgnoreShield->EditValue ?></textarea>
</span>
<?php echo $config_occupation->IgnoreShield->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_occupation->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_config_occupation_DATETIME" for="x_DATETIME" class="<?php echo $config_occupation_add->LeftColumnClass ?>"><?php echo $config_occupation->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_occupation_add->RightColumnClass ?>"><div<?php echo $config_occupation->DATETIME->CellAttributes() ?>>
<span id="el_config_occupation_DATETIME">
<input type="text" data-table="config_occupation" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($config_occupation->DATETIME->getPlaceHolder()) ?>" value="<?php echo $config_occupation->DATETIME->EditValue ?>"<?php echo $config_occupation->DATETIME->EditAttributes() ?>>
</span>
<?php echo $config_occupation->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$config_occupation_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $config_occupation_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $config_occupation_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fconfig_occupationadd.Init();
</script>
<?php
$config_occupation_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_occupation_add->Page_Terminate();
?>
