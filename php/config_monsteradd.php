<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_monsterinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_monster_add = NULL; // Initialize page object first

class cconfig_monster_add extends cconfig_monster {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_monster';

	// Page object name
	var $PageObjName = 'config_monster_add';

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

		// Table object (config_monster)
		if (!isset($GLOBALS["config_monster"]) || get_class($GLOBALS["config_monster"]) == "cconfig_monster") {
			$GLOBALS["config_monster"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_monster"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'config_monster', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("config_monsterlist.php"));
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
		$this->Monster_Name->SetVisibility();
		$this->Monster_Type->SetVisibility();
		$this->Monster_AD->SetVisibility();
		$this->Monster_AP->SetVisibility();
		$this->Monster_HP->SetVisibility();
		$this->Monster_Defense->SetVisibility();
		$this->Monster_AbsorbHP->SetVisibility();
		$this->Monster_ADPTV->SetVisibility();
		$this->Monster_ADPTR->SetVisibility();
		$this->Monster_APPTR->SetVisibility();
		$this->Monster_APPTV->SetVisibility();
		$this->Monster_ImmuneDamage->SetVisibility();
		$this->Skills->SetVisibility();
		$this->Reward_Goods->SetVisibility();
		$this->Reward_Exp->SetVisibility();
		$this->Reward_Gold->SetVisibility();
		$this->Introduce->SetVisibility();
		$this->AttackEffect->SetVisibility();
		$this->AttackTips->SetVisibility();
		$this->MagicResistance->SetVisibility();
		$this->Hit->SetVisibility();
		$this->Dodge->SetVisibility();
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
		global $EW_EXPORT, $config_monster;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_monster);
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
					if ($pageName == "config_monsterview.php")
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
					$this->Page_Terminate("config_monsterlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "config_monsterlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "config_monsterview.php")
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
		$this->Monster_Name->CurrentValue = NULL;
		$this->Monster_Name->OldValue = $this->Monster_Name->CurrentValue;
		$this->Monster_Type->CurrentValue = NULL;
		$this->Monster_Type->OldValue = $this->Monster_Type->CurrentValue;
		$this->Monster_AD->CurrentValue = NULL;
		$this->Monster_AD->OldValue = $this->Monster_AD->CurrentValue;
		$this->Monster_AP->CurrentValue = NULL;
		$this->Monster_AP->OldValue = $this->Monster_AP->CurrentValue;
		$this->Monster_HP->CurrentValue = NULL;
		$this->Monster_HP->OldValue = $this->Monster_HP->CurrentValue;
		$this->Monster_Defense->CurrentValue = NULL;
		$this->Monster_Defense->OldValue = $this->Monster_Defense->CurrentValue;
		$this->Monster_AbsorbHP->CurrentValue = NULL;
		$this->Monster_AbsorbHP->OldValue = $this->Monster_AbsorbHP->CurrentValue;
		$this->Monster_ADPTV->CurrentValue = NULL;
		$this->Monster_ADPTV->OldValue = $this->Monster_ADPTV->CurrentValue;
		$this->Monster_ADPTR->CurrentValue = NULL;
		$this->Monster_ADPTR->OldValue = $this->Monster_ADPTR->CurrentValue;
		$this->Monster_APPTR->CurrentValue = NULL;
		$this->Monster_APPTR->OldValue = $this->Monster_APPTR->CurrentValue;
		$this->Monster_APPTV->CurrentValue = NULL;
		$this->Monster_APPTV->OldValue = $this->Monster_APPTV->CurrentValue;
		$this->Monster_ImmuneDamage->CurrentValue = NULL;
		$this->Monster_ImmuneDamage->OldValue = $this->Monster_ImmuneDamage->CurrentValue;
		$this->Skills->CurrentValue = NULL;
		$this->Skills->OldValue = $this->Skills->CurrentValue;
		$this->Reward_Goods->CurrentValue = NULL;
		$this->Reward_Goods->OldValue = $this->Reward_Goods->CurrentValue;
		$this->Reward_Exp->CurrentValue = NULL;
		$this->Reward_Exp->OldValue = $this->Reward_Exp->CurrentValue;
		$this->Reward_Gold->CurrentValue = NULL;
		$this->Reward_Gold->OldValue = $this->Reward_Gold->CurrentValue;
		$this->Introduce->CurrentValue = NULL;
		$this->Introduce->OldValue = $this->Introduce->CurrentValue;
		$this->AttackEffect->CurrentValue = NULL;
		$this->AttackEffect->OldValue = $this->AttackEffect->CurrentValue;
		$this->AttackTips->CurrentValue = NULL;
		$this->AttackTips->OldValue = $this->AttackTips->CurrentValue;
		$this->MagicResistance->CurrentValue = NULL;
		$this->MagicResistance->OldValue = $this->MagicResistance->CurrentValue;
		$this->Hit->CurrentValue = NULL;
		$this->Hit->OldValue = $this->Hit->CurrentValue;
		$this->Dodge->CurrentValue = NULL;
		$this->Dodge->OldValue = $this->Dodge->CurrentValue;
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
		if (!$this->Monster_Name->FldIsDetailKey) {
			$this->Monster_Name->setFormValue($objForm->GetValue("x_Monster_Name"));
		}
		if (!$this->Monster_Type->FldIsDetailKey) {
			$this->Monster_Type->setFormValue($objForm->GetValue("x_Monster_Type"));
		}
		if (!$this->Monster_AD->FldIsDetailKey) {
			$this->Monster_AD->setFormValue($objForm->GetValue("x_Monster_AD"));
		}
		if (!$this->Monster_AP->FldIsDetailKey) {
			$this->Monster_AP->setFormValue($objForm->GetValue("x_Monster_AP"));
		}
		if (!$this->Monster_HP->FldIsDetailKey) {
			$this->Monster_HP->setFormValue($objForm->GetValue("x_Monster_HP"));
		}
		if (!$this->Monster_Defense->FldIsDetailKey) {
			$this->Monster_Defense->setFormValue($objForm->GetValue("x_Monster_Defense"));
		}
		if (!$this->Monster_AbsorbHP->FldIsDetailKey) {
			$this->Monster_AbsorbHP->setFormValue($objForm->GetValue("x_Monster_AbsorbHP"));
		}
		if (!$this->Monster_ADPTV->FldIsDetailKey) {
			$this->Monster_ADPTV->setFormValue($objForm->GetValue("x_Monster_ADPTV"));
		}
		if (!$this->Monster_ADPTR->FldIsDetailKey) {
			$this->Monster_ADPTR->setFormValue($objForm->GetValue("x_Monster_ADPTR"));
		}
		if (!$this->Monster_APPTR->FldIsDetailKey) {
			$this->Monster_APPTR->setFormValue($objForm->GetValue("x_Monster_APPTR"));
		}
		if (!$this->Monster_APPTV->FldIsDetailKey) {
			$this->Monster_APPTV->setFormValue($objForm->GetValue("x_Monster_APPTV"));
		}
		if (!$this->Monster_ImmuneDamage->FldIsDetailKey) {
			$this->Monster_ImmuneDamage->setFormValue($objForm->GetValue("x_Monster_ImmuneDamage"));
		}
		if (!$this->Skills->FldIsDetailKey) {
			$this->Skills->setFormValue($objForm->GetValue("x_Skills"));
		}
		if (!$this->Reward_Goods->FldIsDetailKey) {
			$this->Reward_Goods->setFormValue($objForm->GetValue("x_Reward_Goods"));
		}
		if (!$this->Reward_Exp->FldIsDetailKey) {
			$this->Reward_Exp->setFormValue($objForm->GetValue("x_Reward_Exp"));
		}
		if (!$this->Reward_Gold->FldIsDetailKey) {
			$this->Reward_Gold->setFormValue($objForm->GetValue("x_Reward_Gold"));
		}
		if (!$this->Introduce->FldIsDetailKey) {
			$this->Introduce->setFormValue($objForm->GetValue("x_Introduce"));
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
		if (!$this->Hit->FldIsDetailKey) {
			$this->Hit->setFormValue($objForm->GetValue("x_Hit"));
		}
		if (!$this->Dodge->FldIsDetailKey) {
			$this->Dodge->setFormValue($objForm->GetValue("x_Dodge"));
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
		$this->Monster_Name->CurrentValue = $this->Monster_Name->FormValue;
		$this->Monster_Type->CurrentValue = $this->Monster_Type->FormValue;
		$this->Monster_AD->CurrentValue = $this->Monster_AD->FormValue;
		$this->Monster_AP->CurrentValue = $this->Monster_AP->FormValue;
		$this->Monster_HP->CurrentValue = $this->Monster_HP->FormValue;
		$this->Monster_Defense->CurrentValue = $this->Monster_Defense->FormValue;
		$this->Monster_AbsorbHP->CurrentValue = $this->Monster_AbsorbHP->FormValue;
		$this->Monster_ADPTV->CurrentValue = $this->Monster_ADPTV->FormValue;
		$this->Monster_ADPTR->CurrentValue = $this->Monster_ADPTR->FormValue;
		$this->Monster_APPTR->CurrentValue = $this->Monster_APPTR->FormValue;
		$this->Monster_APPTV->CurrentValue = $this->Monster_APPTV->FormValue;
		$this->Monster_ImmuneDamage->CurrentValue = $this->Monster_ImmuneDamage->FormValue;
		$this->Skills->CurrentValue = $this->Skills->FormValue;
		$this->Reward_Goods->CurrentValue = $this->Reward_Goods->FormValue;
		$this->Reward_Exp->CurrentValue = $this->Reward_Exp->FormValue;
		$this->Reward_Gold->CurrentValue = $this->Reward_Gold->FormValue;
		$this->Introduce->CurrentValue = $this->Introduce->FormValue;
		$this->AttackEffect->CurrentValue = $this->AttackEffect->FormValue;
		$this->AttackTips->CurrentValue = $this->AttackTips->FormValue;
		$this->MagicResistance->CurrentValue = $this->MagicResistance->FormValue;
		$this->Hit->CurrentValue = $this->Hit->FormValue;
		$this->Dodge->CurrentValue = $this->Dodge->FormValue;
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
		$this->Monster_Name->setDbValue($row['Monster_Name']);
		$this->Monster_Type->setDbValue($row['Monster_Type']);
		$this->Monster_AD->setDbValue($row['Monster_AD']);
		$this->Monster_AP->setDbValue($row['Monster_AP']);
		$this->Monster_HP->setDbValue($row['Monster_HP']);
		$this->Monster_Defense->setDbValue($row['Monster_Defense']);
		$this->Monster_AbsorbHP->setDbValue($row['Monster_AbsorbHP']);
		$this->Monster_ADPTV->setDbValue($row['Monster_ADPTV']);
		$this->Monster_ADPTR->setDbValue($row['Monster_ADPTR']);
		$this->Monster_APPTR->setDbValue($row['Monster_APPTR']);
		$this->Monster_APPTV->setDbValue($row['Monster_APPTV']);
		$this->Monster_ImmuneDamage->setDbValue($row['Monster_ImmuneDamage']);
		$this->Skills->setDbValue($row['Skills']);
		$this->Reward_Goods->setDbValue($row['Reward_Goods']);
		$this->Reward_Exp->setDbValue($row['Reward_Exp']);
		$this->Reward_Gold->setDbValue($row['Reward_Gold']);
		$this->Introduce->setDbValue($row['Introduce']);
		$this->AttackEffect->setDbValue($row['AttackEffect']);
		$this->AttackTips->setDbValue($row['AttackTips']);
		$this->MagicResistance->setDbValue($row['MagicResistance']);
		$this->Hit->setDbValue($row['Hit']);
		$this->Dodge->setDbValue($row['Dodge']);
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
		$row['Monster_Name'] = $this->Monster_Name->CurrentValue;
		$row['Monster_Type'] = $this->Monster_Type->CurrentValue;
		$row['Monster_AD'] = $this->Monster_AD->CurrentValue;
		$row['Monster_AP'] = $this->Monster_AP->CurrentValue;
		$row['Monster_HP'] = $this->Monster_HP->CurrentValue;
		$row['Monster_Defense'] = $this->Monster_Defense->CurrentValue;
		$row['Monster_AbsorbHP'] = $this->Monster_AbsorbHP->CurrentValue;
		$row['Monster_ADPTV'] = $this->Monster_ADPTV->CurrentValue;
		$row['Monster_ADPTR'] = $this->Monster_ADPTR->CurrentValue;
		$row['Monster_APPTR'] = $this->Monster_APPTR->CurrentValue;
		$row['Monster_APPTV'] = $this->Monster_APPTV->CurrentValue;
		$row['Monster_ImmuneDamage'] = $this->Monster_ImmuneDamage->CurrentValue;
		$row['Skills'] = $this->Skills->CurrentValue;
		$row['Reward_Goods'] = $this->Reward_Goods->CurrentValue;
		$row['Reward_Exp'] = $this->Reward_Exp->CurrentValue;
		$row['Reward_Gold'] = $this->Reward_Gold->CurrentValue;
		$row['Introduce'] = $this->Introduce->CurrentValue;
		$row['AttackEffect'] = $this->AttackEffect->CurrentValue;
		$row['AttackTips'] = $this->AttackTips->CurrentValue;
		$row['MagicResistance'] = $this->MagicResistance->CurrentValue;
		$row['Hit'] = $this->Hit->CurrentValue;
		$row['Dodge'] = $this->Dodge->CurrentValue;
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
		$this->Monster_Name->DbValue = $row['Monster_Name'];
		$this->Monster_Type->DbValue = $row['Monster_Type'];
		$this->Monster_AD->DbValue = $row['Monster_AD'];
		$this->Monster_AP->DbValue = $row['Monster_AP'];
		$this->Monster_HP->DbValue = $row['Monster_HP'];
		$this->Monster_Defense->DbValue = $row['Monster_Defense'];
		$this->Monster_AbsorbHP->DbValue = $row['Monster_AbsorbHP'];
		$this->Monster_ADPTV->DbValue = $row['Monster_ADPTV'];
		$this->Monster_ADPTR->DbValue = $row['Monster_ADPTR'];
		$this->Monster_APPTR->DbValue = $row['Monster_APPTR'];
		$this->Monster_APPTV->DbValue = $row['Monster_APPTV'];
		$this->Monster_ImmuneDamage->DbValue = $row['Monster_ImmuneDamage'];
		$this->Skills->DbValue = $row['Skills'];
		$this->Reward_Goods->DbValue = $row['Reward_Goods'];
		$this->Reward_Exp->DbValue = $row['Reward_Exp'];
		$this->Reward_Gold->DbValue = $row['Reward_Gold'];
		$this->Introduce->DbValue = $row['Introduce'];
		$this->AttackEffect->DbValue = $row['AttackEffect'];
		$this->AttackTips->DbValue = $row['AttackTips'];
		$this->MagicResistance->DbValue = $row['MagicResistance'];
		$this->Hit->DbValue = $row['Hit'];
		$this->Dodge->DbValue = $row['Dodge'];
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
		// Monster_Name
		// Monster_Type
		// Monster_AD
		// Monster_AP
		// Monster_HP
		// Monster_Defense
		// Monster_AbsorbHP
		// Monster_ADPTV
		// Monster_ADPTR
		// Monster_APPTR
		// Monster_APPTV
		// Monster_ImmuneDamage
		// Skills
		// Reward_Goods
		// Reward_Exp
		// Reward_Gold
		// Introduce
		// AttackEffect
		// AttackTips
		// MagicResistance
		// Hit
		// Dodge
		// IgnoreShield
		// DATETIME

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// u_id
		$this->u_id->ViewValue = $this->u_id->CurrentValue;
		$this->u_id->ViewCustomAttributes = "";

		// acl_id
		$this->acl_id->ViewValue = $this->acl_id->CurrentValue;
		$this->acl_id->ViewCustomAttributes = "";

		// Monster_Name
		$this->Monster_Name->ViewValue = $this->Monster_Name->CurrentValue;
		$this->Monster_Name->ViewCustomAttributes = "";

		// Monster_Type
		$this->Monster_Type->ViewValue = $this->Monster_Type->CurrentValue;
		$this->Monster_Type->ViewCustomAttributes = "";

		// Monster_AD
		$this->Monster_AD->ViewValue = $this->Monster_AD->CurrentValue;
		$this->Monster_AD->ViewCustomAttributes = "";

		// Monster_AP
		$this->Monster_AP->ViewValue = $this->Monster_AP->CurrentValue;
		$this->Monster_AP->ViewCustomAttributes = "";

		// Monster_HP
		$this->Monster_HP->ViewValue = $this->Monster_HP->CurrentValue;
		$this->Monster_HP->ViewCustomAttributes = "";

		// Monster_Defense
		$this->Monster_Defense->ViewValue = $this->Monster_Defense->CurrentValue;
		$this->Monster_Defense->ViewCustomAttributes = "";

		// Monster_AbsorbHP
		$this->Monster_AbsorbHP->ViewValue = $this->Monster_AbsorbHP->CurrentValue;
		$this->Monster_AbsorbHP->ViewCustomAttributes = "";

		// Monster_ADPTV
		$this->Monster_ADPTV->ViewValue = $this->Monster_ADPTV->CurrentValue;
		$this->Monster_ADPTV->ViewCustomAttributes = "";

		// Monster_ADPTR
		$this->Monster_ADPTR->ViewValue = $this->Monster_ADPTR->CurrentValue;
		$this->Monster_ADPTR->ViewCustomAttributes = "";

		// Monster_APPTR
		$this->Monster_APPTR->ViewValue = $this->Monster_APPTR->CurrentValue;
		$this->Monster_APPTR->ViewCustomAttributes = "";

		// Monster_APPTV
		$this->Monster_APPTV->ViewValue = $this->Monster_APPTV->CurrentValue;
		$this->Monster_APPTV->ViewCustomAttributes = "";

		// Monster_ImmuneDamage
		$this->Monster_ImmuneDamage->ViewValue = $this->Monster_ImmuneDamage->CurrentValue;
		$this->Monster_ImmuneDamage->ViewCustomAttributes = "";

		// Skills
		$this->Skills->ViewValue = $this->Skills->CurrentValue;
		$this->Skills->ViewCustomAttributes = "";

		// Reward_Goods
		$this->Reward_Goods->ViewValue = $this->Reward_Goods->CurrentValue;
		$this->Reward_Goods->ViewCustomAttributes = "";

		// Reward_Exp
		$this->Reward_Exp->ViewValue = $this->Reward_Exp->CurrentValue;
		$this->Reward_Exp->ViewCustomAttributes = "";

		// Reward_Gold
		$this->Reward_Gold->ViewValue = $this->Reward_Gold->CurrentValue;
		$this->Reward_Gold->ViewCustomAttributes = "";

		// Introduce
		$this->Introduce->ViewValue = $this->Introduce->CurrentValue;
		$this->Introduce->ViewCustomAttributes = "";

		// AttackEffect
		$this->AttackEffect->ViewValue = $this->AttackEffect->CurrentValue;
		$this->AttackEffect->ViewCustomAttributes = "";

		// AttackTips
		$this->AttackTips->ViewValue = $this->AttackTips->CurrentValue;
		$this->AttackTips->ViewCustomAttributes = "";

		// MagicResistance
		$this->MagicResistance->ViewValue = $this->MagicResistance->CurrentValue;
		$this->MagicResistance->ViewCustomAttributes = "";

		// Hit
		$this->Hit->ViewValue = $this->Hit->CurrentValue;
		$this->Hit->ViewCustomAttributes = "";

		// Dodge
		$this->Dodge->ViewValue = $this->Dodge->CurrentValue;
		$this->Dodge->ViewCustomAttributes = "";

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

			// Monster_Name
			$this->Monster_Name->LinkCustomAttributes = "";
			$this->Monster_Name->HrefValue = "";
			$this->Monster_Name->TooltipValue = "";

			// Monster_Type
			$this->Monster_Type->LinkCustomAttributes = "";
			$this->Monster_Type->HrefValue = "";
			$this->Monster_Type->TooltipValue = "";

			// Monster_AD
			$this->Monster_AD->LinkCustomAttributes = "";
			$this->Monster_AD->HrefValue = "";
			$this->Monster_AD->TooltipValue = "";

			// Monster_AP
			$this->Monster_AP->LinkCustomAttributes = "";
			$this->Monster_AP->HrefValue = "";
			$this->Monster_AP->TooltipValue = "";

			// Monster_HP
			$this->Monster_HP->LinkCustomAttributes = "";
			$this->Monster_HP->HrefValue = "";
			$this->Monster_HP->TooltipValue = "";

			// Monster_Defense
			$this->Monster_Defense->LinkCustomAttributes = "";
			$this->Monster_Defense->HrefValue = "";
			$this->Monster_Defense->TooltipValue = "";

			// Monster_AbsorbHP
			$this->Monster_AbsorbHP->LinkCustomAttributes = "";
			$this->Monster_AbsorbHP->HrefValue = "";
			$this->Monster_AbsorbHP->TooltipValue = "";

			// Monster_ADPTV
			$this->Monster_ADPTV->LinkCustomAttributes = "";
			$this->Monster_ADPTV->HrefValue = "";
			$this->Monster_ADPTV->TooltipValue = "";

			// Monster_ADPTR
			$this->Monster_ADPTR->LinkCustomAttributes = "";
			$this->Monster_ADPTR->HrefValue = "";
			$this->Monster_ADPTR->TooltipValue = "";

			// Monster_APPTR
			$this->Monster_APPTR->LinkCustomAttributes = "";
			$this->Monster_APPTR->HrefValue = "";
			$this->Monster_APPTR->TooltipValue = "";

			// Monster_APPTV
			$this->Monster_APPTV->LinkCustomAttributes = "";
			$this->Monster_APPTV->HrefValue = "";
			$this->Monster_APPTV->TooltipValue = "";

			// Monster_ImmuneDamage
			$this->Monster_ImmuneDamage->LinkCustomAttributes = "";
			$this->Monster_ImmuneDamage->HrefValue = "";
			$this->Monster_ImmuneDamage->TooltipValue = "";

			// Skills
			$this->Skills->LinkCustomAttributes = "";
			$this->Skills->HrefValue = "";
			$this->Skills->TooltipValue = "";

			// Reward_Goods
			$this->Reward_Goods->LinkCustomAttributes = "";
			$this->Reward_Goods->HrefValue = "";
			$this->Reward_Goods->TooltipValue = "";

			// Reward_Exp
			$this->Reward_Exp->LinkCustomAttributes = "";
			$this->Reward_Exp->HrefValue = "";
			$this->Reward_Exp->TooltipValue = "";

			// Reward_Gold
			$this->Reward_Gold->LinkCustomAttributes = "";
			$this->Reward_Gold->HrefValue = "";
			$this->Reward_Gold->TooltipValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";
			$this->Introduce->TooltipValue = "";

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

			// Hit
			$this->Hit->LinkCustomAttributes = "";
			$this->Hit->HrefValue = "";
			$this->Hit->TooltipValue = "";

			// Dodge
			$this->Dodge->LinkCustomAttributes = "";
			$this->Dodge->HrefValue = "";
			$this->Dodge->TooltipValue = "";

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

			// Monster_Name
			$this->Monster_Name->EditAttrs["class"] = "form-control";
			$this->Monster_Name->EditCustomAttributes = "";
			$this->Monster_Name->EditValue = ew_HtmlEncode($this->Monster_Name->CurrentValue);
			$this->Monster_Name->PlaceHolder = ew_RemoveHtml($this->Monster_Name->FldCaption());

			// Monster_Type
			$this->Monster_Type->EditAttrs["class"] = "form-control";
			$this->Monster_Type->EditCustomAttributes = "";
			$this->Monster_Type->EditValue = ew_HtmlEncode($this->Monster_Type->CurrentValue);
			$this->Monster_Type->PlaceHolder = ew_RemoveHtml($this->Monster_Type->FldCaption());

			// Monster_AD
			$this->Monster_AD->EditAttrs["class"] = "form-control";
			$this->Monster_AD->EditCustomAttributes = "";
			$this->Monster_AD->EditValue = ew_HtmlEncode($this->Monster_AD->CurrentValue);
			$this->Monster_AD->PlaceHolder = ew_RemoveHtml($this->Monster_AD->FldCaption());

			// Monster_AP
			$this->Monster_AP->EditAttrs["class"] = "form-control";
			$this->Monster_AP->EditCustomAttributes = "";
			$this->Monster_AP->EditValue = ew_HtmlEncode($this->Monster_AP->CurrentValue);
			$this->Monster_AP->PlaceHolder = ew_RemoveHtml($this->Monster_AP->FldCaption());

			// Monster_HP
			$this->Monster_HP->EditAttrs["class"] = "form-control";
			$this->Monster_HP->EditCustomAttributes = "";
			$this->Monster_HP->EditValue = ew_HtmlEncode($this->Monster_HP->CurrentValue);
			$this->Monster_HP->PlaceHolder = ew_RemoveHtml($this->Monster_HP->FldCaption());

			// Monster_Defense
			$this->Monster_Defense->EditAttrs["class"] = "form-control";
			$this->Monster_Defense->EditCustomAttributes = "";
			$this->Monster_Defense->EditValue = ew_HtmlEncode($this->Monster_Defense->CurrentValue);
			$this->Monster_Defense->PlaceHolder = ew_RemoveHtml($this->Monster_Defense->FldCaption());

			// Monster_AbsorbHP
			$this->Monster_AbsorbHP->EditAttrs["class"] = "form-control";
			$this->Monster_AbsorbHP->EditCustomAttributes = "";
			$this->Monster_AbsorbHP->EditValue = ew_HtmlEncode($this->Monster_AbsorbHP->CurrentValue);
			$this->Monster_AbsorbHP->PlaceHolder = ew_RemoveHtml($this->Monster_AbsorbHP->FldCaption());

			// Monster_ADPTV
			$this->Monster_ADPTV->EditAttrs["class"] = "form-control";
			$this->Monster_ADPTV->EditCustomAttributes = "";
			$this->Monster_ADPTV->EditValue = ew_HtmlEncode($this->Monster_ADPTV->CurrentValue);
			$this->Monster_ADPTV->PlaceHolder = ew_RemoveHtml($this->Monster_ADPTV->FldCaption());

			// Monster_ADPTR
			$this->Monster_ADPTR->EditAttrs["class"] = "form-control";
			$this->Monster_ADPTR->EditCustomAttributes = "";
			$this->Monster_ADPTR->EditValue = ew_HtmlEncode($this->Monster_ADPTR->CurrentValue);
			$this->Monster_ADPTR->PlaceHolder = ew_RemoveHtml($this->Monster_ADPTR->FldCaption());

			// Monster_APPTR
			$this->Monster_APPTR->EditAttrs["class"] = "form-control";
			$this->Monster_APPTR->EditCustomAttributes = "";
			$this->Monster_APPTR->EditValue = ew_HtmlEncode($this->Monster_APPTR->CurrentValue);
			$this->Monster_APPTR->PlaceHolder = ew_RemoveHtml($this->Monster_APPTR->FldCaption());

			// Monster_APPTV
			$this->Monster_APPTV->EditAttrs["class"] = "form-control";
			$this->Monster_APPTV->EditCustomAttributes = "";
			$this->Monster_APPTV->EditValue = ew_HtmlEncode($this->Monster_APPTV->CurrentValue);
			$this->Monster_APPTV->PlaceHolder = ew_RemoveHtml($this->Monster_APPTV->FldCaption());

			// Monster_ImmuneDamage
			$this->Monster_ImmuneDamage->EditAttrs["class"] = "form-control";
			$this->Monster_ImmuneDamage->EditCustomAttributes = "";
			$this->Monster_ImmuneDamage->EditValue = ew_HtmlEncode($this->Monster_ImmuneDamage->CurrentValue);
			$this->Monster_ImmuneDamage->PlaceHolder = ew_RemoveHtml($this->Monster_ImmuneDamage->FldCaption());

			// Skills
			$this->Skills->EditAttrs["class"] = "form-control";
			$this->Skills->EditCustomAttributes = "";
			$this->Skills->EditValue = ew_HtmlEncode($this->Skills->CurrentValue);
			$this->Skills->PlaceHolder = ew_RemoveHtml($this->Skills->FldCaption());

			// Reward_Goods
			$this->Reward_Goods->EditAttrs["class"] = "form-control";
			$this->Reward_Goods->EditCustomAttributes = "";
			$this->Reward_Goods->EditValue = ew_HtmlEncode($this->Reward_Goods->CurrentValue);
			$this->Reward_Goods->PlaceHolder = ew_RemoveHtml($this->Reward_Goods->FldCaption());

			// Reward_Exp
			$this->Reward_Exp->EditAttrs["class"] = "form-control";
			$this->Reward_Exp->EditCustomAttributes = "";
			$this->Reward_Exp->EditValue = ew_HtmlEncode($this->Reward_Exp->CurrentValue);
			$this->Reward_Exp->PlaceHolder = ew_RemoveHtml($this->Reward_Exp->FldCaption());

			// Reward_Gold
			$this->Reward_Gold->EditAttrs["class"] = "form-control";
			$this->Reward_Gold->EditCustomAttributes = "";
			$this->Reward_Gold->EditValue = ew_HtmlEncode($this->Reward_Gold->CurrentValue);
			$this->Reward_Gold->PlaceHolder = ew_RemoveHtml($this->Reward_Gold->FldCaption());

			// Introduce
			$this->Introduce->EditAttrs["class"] = "form-control";
			$this->Introduce->EditCustomAttributes = "";
			$this->Introduce->EditValue = ew_HtmlEncode($this->Introduce->CurrentValue);
			$this->Introduce->PlaceHolder = ew_RemoveHtml($this->Introduce->FldCaption());

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

			// Monster_Name
			$this->Monster_Name->LinkCustomAttributes = "";
			$this->Monster_Name->HrefValue = "";

			// Monster_Type
			$this->Monster_Type->LinkCustomAttributes = "";
			$this->Monster_Type->HrefValue = "";

			// Monster_AD
			$this->Monster_AD->LinkCustomAttributes = "";
			$this->Monster_AD->HrefValue = "";

			// Monster_AP
			$this->Monster_AP->LinkCustomAttributes = "";
			$this->Monster_AP->HrefValue = "";

			// Monster_HP
			$this->Monster_HP->LinkCustomAttributes = "";
			$this->Monster_HP->HrefValue = "";

			// Monster_Defense
			$this->Monster_Defense->LinkCustomAttributes = "";
			$this->Monster_Defense->HrefValue = "";

			// Monster_AbsorbHP
			$this->Monster_AbsorbHP->LinkCustomAttributes = "";
			$this->Monster_AbsorbHP->HrefValue = "";

			// Monster_ADPTV
			$this->Monster_ADPTV->LinkCustomAttributes = "";
			$this->Monster_ADPTV->HrefValue = "";

			// Monster_ADPTR
			$this->Monster_ADPTR->LinkCustomAttributes = "";
			$this->Monster_ADPTR->HrefValue = "";

			// Monster_APPTR
			$this->Monster_APPTR->LinkCustomAttributes = "";
			$this->Monster_APPTR->HrefValue = "";

			// Monster_APPTV
			$this->Monster_APPTV->LinkCustomAttributes = "";
			$this->Monster_APPTV->HrefValue = "";

			// Monster_ImmuneDamage
			$this->Monster_ImmuneDamage->LinkCustomAttributes = "";
			$this->Monster_ImmuneDamage->HrefValue = "";

			// Skills
			$this->Skills->LinkCustomAttributes = "";
			$this->Skills->HrefValue = "";

			// Reward_Goods
			$this->Reward_Goods->LinkCustomAttributes = "";
			$this->Reward_Goods->HrefValue = "";

			// Reward_Exp
			$this->Reward_Exp->LinkCustomAttributes = "";
			$this->Reward_Exp->HrefValue = "";

			// Reward_Gold
			$this->Reward_Gold->LinkCustomAttributes = "";
			$this->Reward_Gold->HrefValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";

			// AttackEffect
			$this->AttackEffect->LinkCustomAttributes = "";
			$this->AttackEffect->HrefValue = "";

			// AttackTips
			$this->AttackTips->LinkCustomAttributes = "";
			$this->AttackTips->HrefValue = "";

			// MagicResistance
			$this->MagicResistance->LinkCustomAttributes = "";
			$this->MagicResistance->HrefValue = "";

			// Hit
			$this->Hit->LinkCustomAttributes = "";
			$this->Hit->HrefValue = "";

			// Dodge
			$this->Dodge->LinkCustomAttributes = "";
			$this->Dodge->HrefValue = "";

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
		if (!$this->Monster_Name->FldIsDetailKey && !is_null($this->Monster_Name->FormValue) && $this->Monster_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_Name->FldCaption(), $this->Monster_Name->ReqErrMsg));
		}
		if (!$this->Monster_Type->FldIsDetailKey && !is_null($this->Monster_Type->FormValue) && $this->Monster_Type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_Type->FldCaption(), $this->Monster_Type->ReqErrMsg));
		}
		if (!$this->Monster_AD->FldIsDetailKey && !is_null($this->Monster_AD->FormValue) && $this->Monster_AD->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_AD->FldCaption(), $this->Monster_AD->ReqErrMsg));
		}
		if (!$this->Monster_AP->FldIsDetailKey && !is_null($this->Monster_AP->FormValue) && $this->Monster_AP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_AP->FldCaption(), $this->Monster_AP->ReqErrMsg));
		}
		if (!$this->Monster_HP->FldIsDetailKey && !is_null($this->Monster_HP->FormValue) && $this->Monster_HP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_HP->FldCaption(), $this->Monster_HP->ReqErrMsg));
		}
		if (!$this->Monster_Defense->FldIsDetailKey && !is_null($this->Monster_Defense->FormValue) && $this->Monster_Defense->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_Defense->FldCaption(), $this->Monster_Defense->ReqErrMsg));
		}
		if (!$this->Monster_AbsorbHP->FldIsDetailKey && !is_null($this->Monster_AbsorbHP->FormValue) && $this->Monster_AbsorbHP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_AbsorbHP->FldCaption(), $this->Monster_AbsorbHP->ReqErrMsg));
		}
		if (!$this->Monster_ADPTV->FldIsDetailKey && !is_null($this->Monster_ADPTV->FormValue) && $this->Monster_ADPTV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_ADPTV->FldCaption(), $this->Monster_ADPTV->ReqErrMsg));
		}
		if (!$this->Monster_ADPTR->FldIsDetailKey && !is_null($this->Monster_ADPTR->FormValue) && $this->Monster_ADPTR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_ADPTR->FldCaption(), $this->Monster_ADPTR->ReqErrMsg));
		}
		if (!$this->Monster_APPTR->FldIsDetailKey && !is_null($this->Monster_APPTR->FormValue) && $this->Monster_APPTR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_APPTR->FldCaption(), $this->Monster_APPTR->ReqErrMsg));
		}
		if (!$this->Monster_APPTV->FldIsDetailKey && !is_null($this->Monster_APPTV->FormValue) && $this->Monster_APPTV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_APPTV->FldCaption(), $this->Monster_APPTV->ReqErrMsg));
		}
		if (!$this->Monster_ImmuneDamage->FldIsDetailKey && !is_null($this->Monster_ImmuneDamage->FormValue) && $this->Monster_ImmuneDamage->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster_ImmuneDamage->FldCaption(), $this->Monster_ImmuneDamage->ReqErrMsg));
		}
		if (!$this->Skills->FldIsDetailKey && !is_null($this->Skills->FormValue) && $this->Skills->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Skills->FldCaption(), $this->Skills->ReqErrMsg));
		}
		if (!$this->Reward_Goods->FldIsDetailKey && !is_null($this->Reward_Goods->FormValue) && $this->Reward_Goods->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Reward_Goods->FldCaption(), $this->Reward_Goods->ReqErrMsg));
		}
		if (!$this->Reward_Exp->FldIsDetailKey && !is_null($this->Reward_Exp->FormValue) && $this->Reward_Exp->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Reward_Exp->FldCaption(), $this->Reward_Exp->ReqErrMsg));
		}
		if (!$this->Reward_Gold->FldIsDetailKey && !is_null($this->Reward_Gold->FormValue) && $this->Reward_Gold->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Reward_Gold->FldCaption(), $this->Reward_Gold->ReqErrMsg));
		}
		if (!$this->Introduce->FldIsDetailKey && !is_null($this->Introduce->FormValue) && $this->Introduce->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Introduce->FldCaption(), $this->Introduce->ReqErrMsg));
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
		if (!$this->Hit->FldIsDetailKey && !is_null($this->Hit->FormValue) && $this->Hit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Hit->FldCaption(), $this->Hit->ReqErrMsg));
		}
		if (!$this->Dodge->FldIsDetailKey && !is_null($this->Dodge->FormValue) && $this->Dodge->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dodge->FldCaption(), $this->Dodge->ReqErrMsg));
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

		// Monster_Name
		$this->Monster_Name->SetDbValueDef($rsnew, $this->Monster_Name->CurrentValue, "", FALSE);

		// Monster_Type
		$this->Monster_Type->SetDbValueDef($rsnew, $this->Monster_Type->CurrentValue, "", FALSE);

		// Monster_AD
		$this->Monster_AD->SetDbValueDef($rsnew, $this->Monster_AD->CurrentValue, "", FALSE);

		// Monster_AP
		$this->Monster_AP->SetDbValueDef($rsnew, $this->Monster_AP->CurrentValue, "", FALSE);

		// Monster_HP
		$this->Monster_HP->SetDbValueDef($rsnew, $this->Monster_HP->CurrentValue, "", FALSE);

		// Monster_Defense
		$this->Monster_Defense->SetDbValueDef($rsnew, $this->Monster_Defense->CurrentValue, "", FALSE);

		// Monster_AbsorbHP
		$this->Monster_AbsorbHP->SetDbValueDef($rsnew, $this->Monster_AbsorbHP->CurrentValue, "", FALSE);

		// Monster_ADPTV
		$this->Monster_ADPTV->SetDbValueDef($rsnew, $this->Monster_ADPTV->CurrentValue, "", FALSE);

		// Monster_ADPTR
		$this->Monster_ADPTR->SetDbValueDef($rsnew, $this->Monster_ADPTR->CurrentValue, "", FALSE);

		// Monster_APPTR
		$this->Monster_APPTR->SetDbValueDef($rsnew, $this->Monster_APPTR->CurrentValue, "", FALSE);

		// Monster_APPTV
		$this->Monster_APPTV->SetDbValueDef($rsnew, $this->Monster_APPTV->CurrentValue, "", FALSE);

		// Monster_ImmuneDamage
		$this->Monster_ImmuneDamage->SetDbValueDef($rsnew, $this->Monster_ImmuneDamage->CurrentValue, "", FALSE);

		// Skills
		$this->Skills->SetDbValueDef($rsnew, $this->Skills->CurrentValue, "", FALSE);

		// Reward_Goods
		$this->Reward_Goods->SetDbValueDef($rsnew, $this->Reward_Goods->CurrentValue, "", FALSE);

		// Reward_Exp
		$this->Reward_Exp->SetDbValueDef($rsnew, $this->Reward_Exp->CurrentValue, "", FALSE);

		// Reward_Gold
		$this->Reward_Gold->SetDbValueDef($rsnew, $this->Reward_Gold->CurrentValue, "", FALSE);

		// Introduce
		$this->Introduce->SetDbValueDef($rsnew, $this->Introduce->CurrentValue, "", FALSE);

		// AttackEffect
		$this->AttackEffect->SetDbValueDef($rsnew, $this->AttackEffect->CurrentValue, "", FALSE);

		// AttackTips
		$this->AttackTips->SetDbValueDef($rsnew, $this->AttackTips->CurrentValue, "", FALSE);

		// MagicResistance
		$this->MagicResistance->SetDbValueDef($rsnew, $this->MagicResistance->CurrentValue, "", FALSE);

		// Hit
		$this->Hit->SetDbValueDef($rsnew, $this->Hit->CurrentValue, "", FALSE);

		// Dodge
		$this->Dodge->SetDbValueDef($rsnew, $this->Dodge->CurrentValue, "", FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_monsterlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_monster_add)) $config_monster_add = new cconfig_monster_add();

// Page init
$config_monster_add->Page_Init();

// Page main
$config_monster_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_monster_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fconfig_monsteradd = new ew_Form("fconfig_monsteradd", "add");

// Validate form
fconfig_monsteradd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->u_id->FldCaption(), $config_monster->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_monster->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->acl_id->FldCaption(), $config_monster->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_monster->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Monster_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_Name->FldCaption(), $config_monster->Monster_Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_Type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_Type->FldCaption(), $config_monster->Monster_Type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_AD");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_AD->FldCaption(), $config_monster->Monster_AD->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_AP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_AP->FldCaption(), $config_monster->Monster_AP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_HP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_HP->FldCaption(), $config_monster->Monster_HP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_Defense");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_Defense->FldCaption(), $config_monster->Monster_Defense->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_AbsorbHP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_AbsorbHP->FldCaption(), $config_monster->Monster_AbsorbHP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_ADPTV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_ADPTV->FldCaption(), $config_monster->Monster_ADPTV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_ADPTR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_ADPTR->FldCaption(), $config_monster->Monster_ADPTR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_APPTR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_APPTR->FldCaption(), $config_monster->Monster_APPTR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_APPTV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_APPTV->FldCaption(), $config_monster->Monster_APPTV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster_ImmuneDamage");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Monster_ImmuneDamage->FldCaption(), $config_monster->Monster_ImmuneDamage->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Skills");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Skills->FldCaption(), $config_monster->Skills->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Reward_Goods");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Reward_Goods->FldCaption(), $config_monster->Reward_Goods->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Reward_Exp");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Reward_Exp->FldCaption(), $config_monster->Reward_Exp->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Reward_Gold");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Reward_Gold->FldCaption(), $config_monster->Reward_Gold->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Introduce");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Introduce->FldCaption(), $config_monster->Introduce->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AttackEffect");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->AttackEffect->FldCaption(), $config_monster->AttackEffect->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AttackTips");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->AttackTips->FldCaption(), $config_monster->AttackTips->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_MagicResistance");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->MagicResistance->FldCaption(), $config_monster->MagicResistance->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Hit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Hit->FldCaption(), $config_monster->Hit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dodge");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->Dodge->FldCaption(), $config_monster->Dodge->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_IgnoreShield");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->IgnoreShield->FldCaption(), $config_monster->IgnoreShield->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_monster->DATETIME->FldCaption(), $config_monster->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_monster->DATETIME->FldErrMsg()) ?>");

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
fconfig_monsteradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_monsteradd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $config_monster_add->ShowPageHeader(); ?>
<?php
$config_monster_add->ShowMessage();
?>
<form name="fconfig_monsteradd" id="fconfig_monsteradd" class="<?php echo $config_monster_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_monster_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_monster_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_monster">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($config_monster_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($config_monster->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_config_monster_u_id" for="x_u_id" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->u_id->CellAttributes() ?>>
<span id="el_config_monster_u_id">
<input type="text" data-table="config_monster" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_monster->u_id->getPlaceHolder()) ?>" value="<?php echo $config_monster->u_id->EditValue ?>"<?php echo $config_monster->u_id->EditAttributes() ?>>
</span>
<?php echo $config_monster->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_config_monster_acl_id" for="x_acl_id" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->acl_id->CellAttributes() ?>>
<span id="el_config_monster_acl_id">
<input type="text" data-table="config_monster" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($config_monster->acl_id->getPlaceHolder()) ?>" value="<?php echo $config_monster->acl_id->EditValue ?>"<?php echo $config_monster->acl_id->EditAttributes() ?>>
</span>
<?php echo $config_monster->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_Name->Visible) { // Monster_Name ?>
	<div id="r_Monster_Name" class="form-group">
		<label id="elh_config_monster_Monster_Name" for="x_Monster_Name" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_Name->CellAttributes() ?>>
<span id="el_config_monster_Monster_Name">
<textarea data-table="config_monster" data-field="x_Monster_Name" name="x_Monster_Name" id="x_Monster_Name" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_Name->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_Name->EditAttributes() ?>><?php echo $config_monster->Monster_Name->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_Type->Visible) { // Monster_Type ?>
	<div id="r_Monster_Type" class="form-group">
		<label id="elh_config_monster_Monster_Type" for="x_Monster_Type" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_Type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_Type->CellAttributes() ?>>
<span id="el_config_monster_Monster_Type">
<textarea data-table="config_monster" data-field="x_Monster_Type" name="x_Monster_Type" id="x_Monster_Type" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_Type->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_Type->EditAttributes() ?>><?php echo $config_monster->Monster_Type->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_AD->Visible) { // Monster_AD ?>
	<div id="r_Monster_AD" class="form-group">
		<label id="elh_config_monster_Monster_AD" for="x_Monster_AD" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_AD->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_AD->CellAttributes() ?>>
<span id="el_config_monster_Monster_AD">
<textarea data-table="config_monster" data-field="x_Monster_AD" name="x_Monster_AD" id="x_Monster_AD" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_AD->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_AD->EditAttributes() ?>><?php echo $config_monster->Monster_AD->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_AD->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_AP->Visible) { // Monster_AP ?>
	<div id="r_Monster_AP" class="form-group">
		<label id="elh_config_monster_Monster_AP" for="x_Monster_AP" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_AP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_AP->CellAttributes() ?>>
<span id="el_config_monster_Monster_AP">
<textarea data-table="config_monster" data-field="x_Monster_AP" name="x_Monster_AP" id="x_Monster_AP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_AP->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_AP->EditAttributes() ?>><?php echo $config_monster->Monster_AP->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_AP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_HP->Visible) { // Monster_HP ?>
	<div id="r_Monster_HP" class="form-group">
		<label id="elh_config_monster_Monster_HP" for="x_Monster_HP" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_HP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_HP->CellAttributes() ?>>
<span id="el_config_monster_Monster_HP">
<textarea data-table="config_monster" data-field="x_Monster_HP" name="x_Monster_HP" id="x_Monster_HP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_HP->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_HP->EditAttributes() ?>><?php echo $config_monster->Monster_HP->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_HP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_Defense->Visible) { // Monster_Defense ?>
	<div id="r_Monster_Defense" class="form-group">
		<label id="elh_config_monster_Monster_Defense" for="x_Monster_Defense" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_Defense->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_Defense->CellAttributes() ?>>
<span id="el_config_monster_Monster_Defense">
<textarea data-table="config_monster" data-field="x_Monster_Defense" name="x_Monster_Defense" id="x_Monster_Defense" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_Defense->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_Defense->EditAttributes() ?>><?php echo $config_monster->Monster_Defense->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_Defense->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_AbsorbHP->Visible) { // Monster_AbsorbHP ?>
	<div id="r_Monster_AbsorbHP" class="form-group">
		<label id="elh_config_monster_Monster_AbsorbHP" for="x_Monster_AbsorbHP" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_AbsorbHP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_AbsorbHP->CellAttributes() ?>>
<span id="el_config_monster_Monster_AbsorbHP">
<textarea data-table="config_monster" data-field="x_Monster_AbsorbHP" name="x_Monster_AbsorbHP" id="x_Monster_AbsorbHP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_AbsorbHP->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_AbsorbHP->EditAttributes() ?>><?php echo $config_monster->Monster_AbsorbHP->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_AbsorbHP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_ADPTV->Visible) { // Monster_ADPTV ?>
	<div id="r_Monster_ADPTV" class="form-group">
		<label id="elh_config_monster_Monster_ADPTV" for="x_Monster_ADPTV" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_ADPTV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_ADPTV->CellAttributes() ?>>
<span id="el_config_monster_Monster_ADPTV">
<textarea data-table="config_monster" data-field="x_Monster_ADPTV" name="x_Monster_ADPTV" id="x_Monster_ADPTV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_ADPTV->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_ADPTV->EditAttributes() ?>><?php echo $config_monster->Monster_ADPTV->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_ADPTV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_ADPTR->Visible) { // Monster_ADPTR ?>
	<div id="r_Monster_ADPTR" class="form-group">
		<label id="elh_config_monster_Monster_ADPTR" for="x_Monster_ADPTR" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_ADPTR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_ADPTR->CellAttributes() ?>>
<span id="el_config_monster_Monster_ADPTR">
<textarea data-table="config_monster" data-field="x_Monster_ADPTR" name="x_Monster_ADPTR" id="x_Monster_ADPTR" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_ADPTR->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_ADPTR->EditAttributes() ?>><?php echo $config_monster->Monster_ADPTR->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_ADPTR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_APPTR->Visible) { // Monster_APPTR ?>
	<div id="r_Monster_APPTR" class="form-group">
		<label id="elh_config_monster_Monster_APPTR" for="x_Monster_APPTR" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_APPTR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_APPTR->CellAttributes() ?>>
<span id="el_config_monster_Monster_APPTR">
<textarea data-table="config_monster" data-field="x_Monster_APPTR" name="x_Monster_APPTR" id="x_Monster_APPTR" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_APPTR->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_APPTR->EditAttributes() ?>><?php echo $config_monster->Monster_APPTR->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_APPTR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_APPTV->Visible) { // Monster_APPTV ?>
	<div id="r_Monster_APPTV" class="form-group">
		<label id="elh_config_monster_Monster_APPTV" for="x_Monster_APPTV" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_APPTV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_APPTV->CellAttributes() ?>>
<span id="el_config_monster_Monster_APPTV">
<textarea data-table="config_monster" data-field="x_Monster_APPTV" name="x_Monster_APPTV" id="x_Monster_APPTV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_APPTV->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_APPTV->EditAttributes() ?>><?php echo $config_monster->Monster_APPTV->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_APPTV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Monster_ImmuneDamage->Visible) { // Monster_ImmuneDamage ?>
	<div id="r_Monster_ImmuneDamage" class="form-group">
		<label id="elh_config_monster_Monster_ImmuneDamage" for="x_Monster_ImmuneDamage" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Monster_ImmuneDamage->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Monster_ImmuneDamage->CellAttributes() ?>>
<span id="el_config_monster_Monster_ImmuneDamage">
<textarea data-table="config_monster" data-field="x_Monster_ImmuneDamage" name="x_Monster_ImmuneDamage" id="x_Monster_ImmuneDamage" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Monster_ImmuneDamage->getPlaceHolder()) ?>"<?php echo $config_monster->Monster_ImmuneDamage->EditAttributes() ?>><?php echo $config_monster->Monster_ImmuneDamage->EditValue ?></textarea>
</span>
<?php echo $config_monster->Monster_ImmuneDamage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Skills->Visible) { // Skills ?>
	<div id="r_Skills" class="form-group">
		<label id="elh_config_monster_Skills" for="x_Skills" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Skills->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Skills->CellAttributes() ?>>
<span id="el_config_monster_Skills">
<textarea data-table="config_monster" data-field="x_Skills" name="x_Skills" id="x_Skills" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Skills->getPlaceHolder()) ?>"<?php echo $config_monster->Skills->EditAttributes() ?>><?php echo $config_monster->Skills->EditValue ?></textarea>
</span>
<?php echo $config_monster->Skills->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Reward_Goods->Visible) { // Reward_Goods ?>
	<div id="r_Reward_Goods" class="form-group">
		<label id="elh_config_monster_Reward_Goods" for="x_Reward_Goods" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Reward_Goods->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Reward_Goods->CellAttributes() ?>>
<span id="el_config_monster_Reward_Goods">
<textarea data-table="config_monster" data-field="x_Reward_Goods" name="x_Reward_Goods" id="x_Reward_Goods" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Reward_Goods->getPlaceHolder()) ?>"<?php echo $config_monster->Reward_Goods->EditAttributes() ?>><?php echo $config_monster->Reward_Goods->EditValue ?></textarea>
</span>
<?php echo $config_monster->Reward_Goods->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Reward_Exp->Visible) { // Reward_Exp ?>
	<div id="r_Reward_Exp" class="form-group">
		<label id="elh_config_monster_Reward_Exp" for="x_Reward_Exp" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Reward_Exp->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Reward_Exp->CellAttributes() ?>>
<span id="el_config_monster_Reward_Exp">
<textarea data-table="config_monster" data-field="x_Reward_Exp" name="x_Reward_Exp" id="x_Reward_Exp" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Reward_Exp->getPlaceHolder()) ?>"<?php echo $config_monster->Reward_Exp->EditAttributes() ?>><?php echo $config_monster->Reward_Exp->EditValue ?></textarea>
</span>
<?php echo $config_monster->Reward_Exp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Reward_Gold->Visible) { // Reward_Gold ?>
	<div id="r_Reward_Gold" class="form-group">
		<label id="elh_config_monster_Reward_Gold" for="x_Reward_Gold" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Reward_Gold->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Reward_Gold->CellAttributes() ?>>
<span id="el_config_monster_Reward_Gold">
<textarea data-table="config_monster" data-field="x_Reward_Gold" name="x_Reward_Gold" id="x_Reward_Gold" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Reward_Gold->getPlaceHolder()) ?>"<?php echo $config_monster->Reward_Gold->EditAttributes() ?>><?php echo $config_monster->Reward_Gold->EditValue ?></textarea>
</span>
<?php echo $config_monster->Reward_Gold->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Introduce->Visible) { // Introduce ?>
	<div id="r_Introduce" class="form-group">
		<label id="elh_config_monster_Introduce" for="x_Introduce" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Introduce->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Introduce->CellAttributes() ?>>
<span id="el_config_monster_Introduce">
<textarea data-table="config_monster" data-field="x_Introduce" name="x_Introduce" id="x_Introduce" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Introduce->getPlaceHolder()) ?>"<?php echo $config_monster->Introduce->EditAttributes() ?>><?php echo $config_monster->Introduce->EditValue ?></textarea>
</span>
<?php echo $config_monster->Introduce->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->AttackEffect->Visible) { // AttackEffect ?>
	<div id="r_AttackEffect" class="form-group">
		<label id="elh_config_monster_AttackEffect" for="x_AttackEffect" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->AttackEffect->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->AttackEffect->CellAttributes() ?>>
<span id="el_config_monster_AttackEffect">
<textarea data-table="config_monster" data-field="x_AttackEffect" name="x_AttackEffect" id="x_AttackEffect" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->AttackEffect->getPlaceHolder()) ?>"<?php echo $config_monster->AttackEffect->EditAttributes() ?>><?php echo $config_monster->AttackEffect->EditValue ?></textarea>
</span>
<?php echo $config_monster->AttackEffect->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->AttackTips->Visible) { // AttackTips ?>
	<div id="r_AttackTips" class="form-group">
		<label id="elh_config_monster_AttackTips" for="x_AttackTips" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->AttackTips->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->AttackTips->CellAttributes() ?>>
<span id="el_config_monster_AttackTips">
<textarea data-table="config_monster" data-field="x_AttackTips" name="x_AttackTips" id="x_AttackTips" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->AttackTips->getPlaceHolder()) ?>"<?php echo $config_monster->AttackTips->EditAttributes() ?>><?php echo $config_monster->AttackTips->EditValue ?></textarea>
</span>
<?php echo $config_monster->AttackTips->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->MagicResistance->Visible) { // MagicResistance ?>
	<div id="r_MagicResistance" class="form-group">
		<label id="elh_config_monster_MagicResistance" for="x_MagicResistance" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->MagicResistance->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->MagicResistance->CellAttributes() ?>>
<span id="el_config_monster_MagicResistance">
<textarea data-table="config_monster" data-field="x_MagicResistance" name="x_MagicResistance" id="x_MagicResistance" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->MagicResistance->getPlaceHolder()) ?>"<?php echo $config_monster->MagicResistance->EditAttributes() ?>><?php echo $config_monster->MagicResistance->EditValue ?></textarea>
</span>
<?php echo $config_monster->MagicResistance->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Hit->Visible) { // Hit ?>
	<div id="r_Hit" class="form-group">
		<label id="elh_config_monster_Hit" for="x_Hit" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Hit->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Hit->CellAttributes() ?>>
<span id="el_config_monster_Hit">
<textarea data-table="config_monster" data-field="x_Hit" name="x_Hit" id="x_Hit" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Hit->getPlaceHolder()) ?>"<?php echo $config_monster->Hit->EditAttributes() ?>><?php echo $config_monster->Hit->EditValue ?></textarea>
</span>
<?php echo $config_monster->Hit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->Dodge->Visible) { // Dodge ?>
	<div id="r_Dodge" class="form-group">
		<label id="elh_config_monster_Dodge" for="x_Dodge" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->Dodge->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->Dodge->CellAttributes() ?>>
<span id="el_config_monster_Dodge">
<textarea data-table="config_monster" data-field="x_Dodge" name="x_Dodge" id="x_Dodge" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->Dodge->getPlaceHolder()) ?>"<?php echo $config_monster->Dodge->EditAttributes() ?>><?php echo $config_monster->Dodge->EditValue ?></textarea>
</span>
<?php echo $config_monster->Dodge->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->IgnoreShield->Visible) { // IgnoreShield ?>
	<div id="r_IgnoreShield" class="form-group">
		<label id="elh_config_monster_IgnoreShield" for="x_IgnoreShield" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->IgnoreShield->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->IgnoreShield->CellAttributes() ?>>
<span id="el_config_monster_IgnoreShield">
<textarea data-table="config_monster" data-field="x_IgnoreShield" name="x_IgnoreShield" id="x_IgnoreShield" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_monster->IgnoreShield->getPlaceHolder()) ?>"<?php echo $config_monster->IgnoreShield->EditAttributes() ?>><?php echo $config_monster->IgnoreShield->EditValue ?></textarea>
</span>
<?php echo $config_monster->IgnoreShield->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_monster->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_config_monster_DATETIME" for="x_DATETIME" class="<?php echo $config_monster_add->LeftColumnClass ?>"><?php echo $config_monster->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_monster_add->RightColumnClass ?>"><div<?php echo $config_monster->DATETIME->CellAttributes() ?>>
<span id="el_config_monster_DATETIME">
<input type="text" data-table="config_monster" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($config_monster->DATETIME->getPlaceHolder()) ?>" value="<?php echo $config_monster->DATETIME->EditValue ?>"<?php echo $config_monster->DATETIME->EditAttributes() ?>>
</span>
<?php echo $config_monster->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$config_monster_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $config_monster_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $config_monster_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fconfig_monsteradd.Init();
</script>
<?php
$config_monster_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_monster_add->Page_Terminate();
?>
