<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "equip_registerinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$equip_register_add = NULL; // Initialize page object first

class cequip_register_add extends cequip_register {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'equip_register';

	// Page object name
	var $PageObjName = 'equip_register_add';

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

		// Table object (equip_register)
		if (!isset($GLOBALS["equip_register"]) || get_class($GLOBALS["equip_register"]) == "cequip_register") {
			$GLOBALS["equip_register"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["equip_register"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'equip_register', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("equip_registerlist.php"));
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
		$this->SlotName->SetVisibility();
		$this->EquipName->SetVisibility();
		$this->Add_HP->SetVisibility();
		$this->Add_MP->SetVisibility();
		$this->Add_Defense->SetVisibility();
		$this->Add_Magic->SetVisibility();
		$this->Add_AD->SetVisibility();
		$this->Add_AP->SetVisibility();
		$this->Add_Hit->SetVisibility();
		$this->Add_Dodge->SetVisibility();
		$this->Add_Crit->SetVisibility();
		$this->Add_AbsorbHP->SetVisibility();
		$this->Add_ADPTV->SetVisibility();
		$this->Add_ADPTR->SetVisibility();
		$this->Add_APPTR->SetVisibility();
		$this->Add_APPTV->SetVisibility();
		$this->Add_ImmuneDamage->SetVisibility();
		$this->Special_Type->SetVisibility();
		$this->Special_Value->SetVisibility();
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
		global $EW_EXPORT, $equip_register;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($equip_register);
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
					if ($pageName == "equip_registerview.php")
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
					$this->Page_Terminate("equip_registerlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "equip_registerlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "equip_registerview.php")
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
		$this->SlotName->CurrentValue = NULL;
		$this->SlotName->OldValue = $this->SlotName->CurrentValue;
		$this->EquipName->CurrentValue = NULL;
		$this->EquipName->OldValue = $this->EquipName->CurrentValue;
		$this->Add_HP->CurrentValue = NULL;
		$this->Add_HP->OldValue = $this->Add_HP->CurrentValue;
		$this->Add_MP->CurrentValue = NULL;
		$this->Add_MP->OldValue = $this->Add_MP->CurrentValue;
		$this->Add_Defense->CurrentValue = NULL;
		$this->Add_Defense->OldValue = $this->Add_Defense->CurrentValue;
		$this->Add_Magic->CurrentValue = NULL;
		$this->Add_Magic->OldValue = $this->Add_Magic->CurrentValue;
		$this->Add_AD->CurrentValue = NULL;
		$this->Add_AD->OldValue = $this->Add_AD->CurrentValue;
		$this->Add_AP->CurrentValue = NULL;
		$this->Add_AP->OldValue = $this->Add_AP->CurrentValue;
		$this->Add_Hit->CurrentValue = NULL;
		$this->Add_Hit->OldValue = $this->Add_Hit->CurrentValue;
		$this->Add_Dodge->CurrentValue = NULL;
		$this->Add_Dodge->OldValue = $this->Add_Dodge->CurrentValue;
		$this->Add_Crit->CurrentValue = NULL;
		$this->Add_Crit->OldValue = $this->Add_Crit->CurrentValue;
		$this->Add_AbsorbHP->CurrentValue = NULL;
		$this->Add_AbsorbHP->OldValue = $this->Add_AbsorbHP->CurrentValue;
		$this->Add_ADPTV->CurrentValue = NULL;
		$this->Add_ADPTV->OldValue = $this->Add_ADPTV->CurrentValue;
		$this->Add_ADPTR->CurrentValue = NULL;
		$this->Add_ADPTR->OldValue = $this->Add_ADPTR->CurrentValue;
		$this->Add_APPTR->CurrentValue = NULL;
		$this->Add_APPTR->OldValue = $this->Add_APPTR->CurrentValue;
		$this->Add_APPTV->CurrentValue = NULL;
		$this->Add_APPTV->OldValue = $this->Add_APPTV->CurrentValue;
		$this->Add_ImmuneDamage->CurrentValue = NULL;
		$this->Add_ImmuneDamage->OldValue = $this->Add_ImmuneDamage->CurrentValue;
		$this->Special_Type->CurrentValue = NULL;
		$this->Special_Type->OldValue = $this->Special_Type->CurrentValue;
		$this->Special_Value->CurrentValue = NULL;
		$this->Special_Value->OldValue = $this->Special_Value->CurrentValue;
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
		if (!$this->SlotName->FldIsDetailKey) {
			$this->SlotName->setFormValue($objForm->GetValue("x_SlotName"));
		}
		if (!$this->EquipName->FldIsDetailKey) {
			$this->EquipName->setFormValue($objForm->GetValue("x_EquipName"));
		}
		if (!$this->Add_HP->FldIsDetailKey) {
			$this->Add_HP->setFormValue($objForm->GetValue("x_Add_HP"));
		}
		if (!$this->Add_MP->FldIsDetailKey) {
			$this->Add_MP->setFormValue($objForm->GetValue("x_Add_MP"));
		}
		if (!$this->Add_Defense->FldIsDetailKey) {
			$this->Add_Defense->setFormValue($objForm->GetValue("x_Add_Defense"));
		}
		if (!$this->Add_Magic->FldIsDetailKey) {
			$this->Add_Magic->setFormValue($objForm->GetValue("x_Add_Magic"));
		}
		if (!$this->Add_AD->FldIsDetailKey) {
			$this->Add_AD->setFormValue($objForm->GetValue("x_Add_AD"));
		}
		if (!$this->Add_AP->FldIsDetailKey) {
			$this->Add_AP->setFormValue($objForm->GetValue("x_Add_AP"));
		}
		if (!$this->Add_Hit->FldIsDetailKey) {
			$this->Add_Hit->setFormValue($objForm->GetValue("x_Add_Hit"));
		}
		if (!$this->Add_Dodge->FldIsDetailKey) {
			$this->Add_Dodge->setFormValue($objForm->GetValue("x_Add_Dodge"));
		}
		if (!$this->Add_Crit->FldIsDetailKey) {
			$this->Add_Crit->setFormValue($objForm->GetValue("x_Add_Crit"));
		}
		if (!$this->Add_AbsorbHP->FldIsDetailKey) {
			$this->Add_AbsorbHP->setFormValue($objForm->GetValue("x_Add_AbsorbHP"));
		}
		if (!$this->Add_ADPTV->FldIsDetailKey) {
			$this->Add_ADPTV->setFormValue($objForm->GetValue("x_Add_ADPTV"));
		}
		if (!$this->Add_ADPTR->FldIsDetailKey) {
			$this->Add_ADPTR->setFormValue($objForm->GetValue("x_Add_ADPTR"));
		}
		if (!$this->Add_APPTR->FldIsDetailKey) {
			$this->Add_APPTR->setFormValue($objForm->GetValue("x_Add_APPTR"));
		}
		if (!$this->Add_APPTV->FldIsDetailKey) {
			$this->Add_APPTV->setFormValue($objForm->GetValue("x_Add_APPTV"));
		}
		if (!$this->Add_ImmuneDamage->FldIsDetailKey) {
			$this->Add_ImmuneDamage->setFormValue($objForm->GetValue("x_Add_ImmuneDamage"));
		}
		if (!$this->Special_Type->FldIsDetailKey) {
			$this->Special_Type->setFormValue($objForm->GetValue("x_Special_Type"));
		}
		if (!$this->Special_Value->FldIsDetailKey) {
			$this->Special_Value->setFormValue($objForm->GetValue("x_Special_Value"));
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
		$this->SlotName->CurrentValue = $this->SlotName->FormValue;
		$this->EquipName->CurrentValue = $this->EquipName->FormValue;
		$this->Add_HP->CurrentValue = $this->Add_HP->FormValue;
		$this->Add_MP->CurrentValue = $this->Add_MP->FormValue;
		$this->Add_Defense->CurrentValue = $this->Add_Defense->FormValue;
		$this->Add_Magic->CurrentValue = $this->Add_Magic->FormValue;
		$this->Add_AD->CurrentValue = $this->Add_AD->FormValue;
		$this->Add_AP->CurrentValue = $this->Add_AP->FormValue;
		$this->Add_Hit->CurrentValue = $this->Add_Hit->FormValue;
		$this->Add_Dodge->CurrentValue = $this->Add_Dodge->FormValue;
		$this->Add_Crit->CurrentValue = $this->Add_Crit->FormValue;
		$this->Add_AbsorbHP->CurrentValue = $this->Add_AbsorbHP->FormValue;
		$this->Add_ADPTV->CurrentValue = $this->Add_ADPTV->FormValue;
		$this->Add_ADPTR->CurrentValue = $this->Add_ADPTR->FormValue;
		$this->Add_APPTR->CurrentValue = $this->Add_APPTR->FormValue;
		$this->Add_APPTV->CurrentValue = $this->Add_APPTV->FormValue;
		$this->Add_ImmuneDamage->CurrentValue = $this->Add_ImmuneDamage->FormValue;
		$this->Special_Type->CurrentValue = $this->Special_Type->FormValue;
		$this->Special_Value->CurrentValue = $this->Special_Value->FormValue;
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
		$this->SlotName->setDbValue($row['SlotName']);
		$this->EquipName->setDbValue($row['EquipName']);
		$this->Add_HP->setDbValue($row['Add_HP']);
		$this->Add_MP->setDbValue($row['Add_MP']);
		$this->Add_Defense->setDbValue($row['Add_Defense']);
		$this->Add_Magic->setDbValue($row['Add_Magic']);
		$this->Add_AD->setDbValue($row['Add_AD']);
		$this->Add_AP->setDbValue($row['Add_AP']);
		$this->Add_Hit->setDbValue($row['Add_Hit']);
		$this->Add_Dodge->setDbValue($row['Add_Dodge']);
		$this->Add_Crit->setDbValue($row['Add_Crit']);
		$this->Add_AbsorbHP->setDbValue($row['Add_AbsorbHP']);
		$this->Add_ADPTV->setDbValue($row['Add_ADPTV']);
		$this->Add_ADPTR->setDbValue($row['Add_ADPTR']);
		$this->Add_APPTR->setDbValue($row['Add_APPTR']);
		$this->Add_APPTV->setDbValue($row['Add_APPTV']);
		$this->Add_ImmuneDamage->setDbValue($row['Add_ImmuneDamage']);
		$this->Special_Type->setDbValue($row['Special_Type']);
		$this->Special_Value->setDbValue($row['Special_Value']);
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
		$row['SlotName'] = $this->SlotName->CurrentValue;
		$row['EquipName'] = $this->EquipName->CurrentValue;
		$row['Add_HP'] = $this->Add_HP->CurrentValue;
		$row['Add_MP'] = $this->Add_MP->CurrentValue;
		$row['Add_Defense'] = $this->Add_Defense->CurrentValue;
		$row['Add_Magic'] = $this->Add_Magic->CurrentValue;
		$row['Add_AD'] = $this->Add_AD->CurrentValue;
		$row['Add_AP'] = $this->Add_AP->CurrentValue;
		$row['Add_Hit'] = $this->Add_Hit->CurrentValue;
		$row['Add_Dodge'] = $this->Add_Dodge->CurrentValue;
		$row['Add_Crit'] = $this->Add_Crit->CurrentValue;
		$row['Add_AbsorbHP'] = $this->Add_AbsorbHP->CurrentValue;
		$row['Add_ADPTV'] = $this->Add_ADPTV->CurrentValue;
		$row['Add_ADPTR'] = $this->Add_ADPTR->CurrentValue;
		$row['Add_APPTR'] = $this->Add_APPTR->CurrentValue;
		$row['Add_APPTV'] = $this->Add_APPTV->CurrentValue;
		$row['Add_ImmuneDamage'] = $this->Add_ImmuneDamage->CurrentValue;
		$row['Special_Type'] = $this->Special_Type->CurrentValue;
		$row['Special_Value'] = $this->Special_Value->CurrentValue;
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
		$this->SlotName->DbValue = $row['SlotName'];
		$this->EquipName->DbValue = $row['EquipName'];
		$this->Add_HP->DbValue = $row['Add_HP'];
		$this->Add_MP->DbValue = $row['Add_MP'];
		$this->Add_Defense->DbValue = $row['Add_Defense'];
		$this->Add_Magic->DbValue = $row['Add_Magic'];
		$this->Add_AD->DbValue = $row['Add_AD'];
		$this->Add_AP->DbValue = $row['Add_AP'];
		$this->Add_Hit->DbValue = $row['Add_Hit'];
		$this->Add_Dodge->DbValue = $row['Add_Dodge'];
		$this->Add_Crit->DbValue = $row['Add_Crit'];
		$this->Add_AbsorbHP->DbValue = $row['Add_AbsorbHP'];
		$this->Add_ADPTV->DbValue = $row['Add_ADPTV'];
		$this->Add_ADPTR->DbValue = $row['Add_ADPTR'];
		$this->Add_APPTR->DbValue = $row['Add_APPTR'];
		$this->Add_APPTV->DbValue = $row['Add_APPTV'];
		$this->Add_ImmuneDamage->DbValue = $row['Add_ImmuneDamage'];
		$this->Special_Type->DbValue = $row['Special_Type'];
		$this->Special_Value->DbValue = $row['Special_Value'];
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
		// SlotName
		// EquipName
		// Add_HP
		// Add_MP
		// Add_Defense
		// Add_Magic
		// Add_AD
		// Add_AP
		// Add_Hit
		// Add_Dodge
		// Add_Crit
		// Add_AbsorbHP
		// Add_ADPTV
		// Add_ADPTR
		// Add_APPTR
		// Add_APPTV
		// Add_ImmuneDamage
		// Special_Type
		// Special_Value
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

		// SlotName
		$this->SlotName->ViewValue = $this->SlotName->CurrentValue;
		$this->SlotName->ViewCustomAttributes = "";

		// EquipName
		$this->EquipName->ViewValue = $this->EquipName->CurrentValue;
		$this->EquipName->ViewCustomAttributes = "";

		// Add_HP
		$this->Add_HP->ViewValue = $this->Add_HP->CurrentValue;
		$this->Add_HP->ViewCustomAttributes = "";

		// Add_MP
		$this->Add_MP->ViewValue = $this->Add_MP->CurrentValue;
		$this->Add_MP->ViewCustomAttributes = "";

		// Add_Defense
		$this->Add_Defense->ViewValue = $this->Add_Defense->CurrentValue;
		$this->Add_Defense->ViewCustomAttributes = "";

		// Add_Magic
		$this->Add_Magic->ViewValue = $this->Add_Magic->CurrentValue;
		$this->Add_Magic->ViewCustomAttributes = "";

		// Add_AD
		$this->Add_AD->ViewValue = $this->Add_AD->CurrentValue;
		$this->Add_AD->ViewCustomAttributes = "";

		// Add_AP
		$this->Add_AP->ViewValue = $this->Add_AP->CurrentValue;
		$this->Add_AP->ViewCustomAttributes = "";

		// Add_Hit
		$this->Add_Hit->ViewValue = $this->Add_Hit->CurrentValue;
		$this->Add_Hit->ViewCustomAttributes = "";

		// Add_Dodge
		$this->Add_Dodge->ViewValue = $this->Add_Dodge->CurrentValue;
		$this->Add_Dodge->ViewCustomAttributes = "";

		// Add_Crit
		$this->Add_Crit->ViewValue = $this->Add_Crit->CurrentValue;
		$this->Add_Crit->ViewCustomAttributes = "";

		// Add_AbsorbHP
		$this->Add_AbsorbHP->ViewValue = $this->Add_AbsorbHP->CurrentValue;
		$this->Add_AbsorbHP->ViewCustomAttributes = "";

		// Add_ADPTV
		$this->Add_ADPTV->ViewValue = $this->Add_ADPTV->CurrentValue;
		$this->Add_ADPTV->ViewCustomAttributes = "";

		// Add_ADPTR
		$this->Add_ADPTR->ViewValue = $this->Add_ADPTR->CurrentValue;
		$this->Add_ADPTR->ViewCustomAttributes = "";

		// Add_APPTR
		$this->Add_APPTR->ViewValue = $this->Add_APPTR->CurrentValue;
		$this->Add_APPTR->ViewCustomAttributes = "";

		// Add_APPTV
		$this->Add_APPTV->ViewValue = $this->Add_APPTV->CurrentValue;
		$this->Add_APPTV->ViewCustomAttributes = "";

		// Add_ImmuneDamage
		$this->Add_ImmuneDamage->ViewValue = $this->Add_ImmuneDamage->CurrentValue;
		$this->Add_ImmuneDamage->ViewCustomAttributes = "";

		// Special_Type
		$this->Special_Type->ViewValue = $this->Special_Type->CurrentValue;
		$this->Special_Type->ViewCustomAttributes = "";

		// Special_Value
		$this->Special_Value->ViewValue = $this->Special_Value->CurrentValue;
		$this->Special_Value->ViewCustomAttributes = "";

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

			// SlotName
			$this->SlotName->LinkCustomAttributes = "";
			$this->SlotName->HrefValue = "";
			$this->SlotName->TooltipValue = "";

			// EquipName
			$this->EquipName->LinkCustomAttributes = "";
			$this->EquipName->HrefValue = "";
			$this->EquipName->TooltipValue = "";

			// Add_HP
			$this->Add_HP->LinkCustomAttributes = "";
			$this->Add_HP->HrefValue = "";
			$this->Add_HP->TooltipValue = "";

			// Add_MP
			$this->Add_MP->LinkCustomAttributes = "";
			$this->Add_MP->HrefValue = "";
			$this->Add_MP->TooltipValue = "";

			// Add_Defense
			$this->Add_Defense->LinkCustomAttributes = "";
			$this->Add_Defense->HrefValue = "";
			$this->Add_Defense->TooltipValue = "";

			// Add_Magic
			$this->Add_Magic->LinkCustomAttributes = "";
			$this->Add_Magic->HrefValue = "";
			$this->Add_Magic->TooltipValue = "";

			// Add_AD
			$this->Add_AD->LinkCustomAttributes = "";
			$this->Add_AD->HrefValue = "";
			$this->Add_AD->TooltipValue = "";

			// Add_AP
			$this->Add_AP->LinkCustomAttributes = "";
			$this->Add_AP->HrefValue = "";
			$this->Add_AP->TooltipValue = "";

			// Add_Hit
			$this->Add_Hit->LinkCustomAttributes = "";
			$this->Add_Hit->HrefValue = "";
			$this->Add_Hit->TooltipValue = "";

			// Add_Dodge
			$this->Add_Dodge->LinkCustomAttributes = "";
			$this->Add_Dodge->HrefValue = "";
			$this->Add_Dodge->TooltipValue = "";

			// Add_Crit
			$this->Add_Crit->LinkCustomAttributes = "";
			$this->Add_Crit->HrefValue = "";
			$this->Add_Crit->TooltipValue = "";

			// Add_AbsorbHP
			$this->Add_AbsorbHP->LinkCustomAttributes = "";
			$this->Add_AbsorbHP->HrefValue = "";
			$this->Add_AbsorbHP->TooltipValue = "";

			// Add_ADPTV
			$this->Add_ADPTV->LinkCustomAttributes = "";
			$this->Add_ADPTV->HrefValue = "";
			$this->Add_ADPTV->TooltipValue = "";

			// Add_ADPTR
			$this->Add_ADPTR->LinkCustomAttributes = "";
			$this->Add_ADPTR->HrefValue = "";
			$this->Add_ADPTR->TooltipValue = "";

			// Add_APPTR
			$this->Add_APPTR->LinkCustomAttributes = "";
			$this->Add_APPTR->HrefValue = "";
			$this->Add_APPTR->TooltipValue = "";

			// Add_APPTV
			$this->Add_APPTV->LinkCustomAttributes = "";
			$this->Add_APPTV->HrefValue = "";
			$this->Add_APPTV->TooltipValue = "";

			// Add_ImmuneDamage
			$this->Add_ImmuneDamage->LinkCustomAttributes = "";
			$this->Add_ImmuneDamage->HrefValue = "";
			$this->Add_ImmuneDamage->TooltipValue = "";

			// Special_Type
			$this->Special_Type->LinkCustomAttributes = "";
			$this->Special_Type->HrefValue = "";
			$this->Special_Type->TooltipValue = "";

			// Special_Value
			$this->Special_Value->LinkCustomAttributes = "";
			$this->Special_Value->HrefValue = "";
			$this->Special_Value->TooltipValue = "";

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

			// SlotName
			$this->SlotName->EditAttrs["class"] = "form-control";
			$this->SlotName->EditCustomAttributes = "";
			$this->SlotName->EditValue = ew_HtmlEncode($this->SlotName->CurrentValue);
			$this->SlotName->PlaceHolder = ew_RemoveHtml($this->SlotName->FldCaption());

			// EquipName
			$this->EquipName->EditAttrs["class"] = "form-control";
			$this->EquipName->EditCustomAttributes = "";
			$this->EquipName->EditValue = ew_HtmlEncode($this->EquipName->CurrentValue);
			$this->EquipName->PlaceHolder = ew_RemoveHtml($this->EquipName->FldCaption());

			// Add_HP
			$this->Add_HP->EditAttrs["class"] = "form-control";
			$this->Add_HP->EditCustomAttributes = "";
			$this->Add_HP->EditValue = ew_HtmlEncode($this->Add_HP->CurrentValue);
			$this->Add_HP->PlaceHolder = ew_RemoveHtml($this->Add_HP->FldCaption());

			// Add_MP
			$this->Add_MP->EditAttrs["class"] = "form-control";
			$this->Add_MP->EditCustomAttributes = "";
			$this->Add_MP->EditValue = ew_HtmlEncode($this->Add_MP->CurrentValue);
			$this->Add_MP->PlaceHolder = ew_RemoveHtml($this->Add_MP->FldCaption());

			// Add_Defense
			$this->Add_Defense->EditAttrs["class"] = "form-control";
			$this->Add_Defense->EditCustomAttributes = "";
			$this->Add_Defense->EditValue = ew_HtmlEncode($this->Add_Defense->CurrentValue);
			$this->Add_Defense->PlaceHolder = ew_RemoveHtml($this->Add_Defense->FldCaption());

			// Add_Magic
			$this->Add_Magic->EditAttrs["class"] = "form-control";
			$this->Add_Magic->EditCustomAttributes = "";
			$this->Add_Magic->EditValue = ew_HtmlEncode($this->Add_Magic->CurrentValue);
			$this->Add_Magic->PlaceHolder = ew_RemoveHtml($this->Add_Magic->FldCaption());

			// Add_AD
			$this->Add_AD->EditAttrs["class"] = "form-control";
			$this->Add_AD->EditCustomAttributes = "";
			$this->Add_AD->EditValue = ew_HtmlEncode($this->Add_AD->CurrentValue);
			$this->Add_AD->PlaceHolder = ew_RemoveHtml($this->Add_AD->FldCaption());

			// Add_AP
			$this->Add_AP->EditAttrs["class"] = "form-control";
			$this->Add_AP->EditCustomAttributes = "";
			$this->Add_AP->EditValue = ew_HtmlEncode($this->Add_AP->CurrentValue);
			$this->Add_AP->PlaceHolder = ew_RemoveHtml($this->Add_AP->FldCaption());

			// Add_Hit
			$this->Add_Hit->EditAttrs["class"] = "form-control";
			$this->Add_Hit->EditCustomAttributes = "";
			$this->Add_Hit->EditValue = ew_HtmlEncode($this->Add_Hit->CurrentValue);
			$this->Add_Hit->PlaceHolder = ew_RemoveHtml($this->Add_Hit->FldCaption());

			// Add_Dodge
			$this->Add_Dodge->EditAttrs["class"] = "form-control";
			$this->Add_Dodge->EditCustomAttributes = "";
			$this->Add_Dodge->EditValue = ew_HtmlEncode($this->Add_Dodge->CurrentValue);
			$this->Add_Dodge->PlaceHolder = ew_RemoveHtml($this->Add_Dodge->FldCaption());

			// Add_Crit
			$this->Add_Crit->EditAttrs["class"] = "form-control";
			$this->Add_Crit->EditCustomAttributes = "";
			$this->Add_Crit->EditValue = ew_HtmlEncode($this->Add_Crit->CurrentValue);
			$this->Add_Crit->PlaceHolder = ew_RemoveHtml($this->Add_Crit->FldCaption());

			// Add_AbsorbHP
			$this->Add_AbsorbHP->EditAttrs["class"] = "form-control";
			$this->Add_AbsorbHP->EditCustomAttributes = "";
			$this->Add_AbsorbHP->EditValue = ew_HtmlEncode($this->Add_AbsorbHP->CurrentValue);
			$this->Add_AbsorbHP->PlaceHolder = ew_RemoveHtml($this->Add_AbsorbHP->FldCaption());

			// Add_ADPTV
			$this->Add_ADPTV->EditAttrs["class"] = "form-control";
			$this->Add_ADPTV->EditCustomAttributes = "";
			$this->Add_ADPTV->EditValue = ew_HtmlEncode($this->Add_ADPTV->CurrentValue);
			$this->Add_ADPTV->PlaceHolder = ew_RemoveHtml($this->Add_ADPTV->FldCaption());

			// Add_ADPTR
			$this->Add_ADPTR->EditAttrs["class"] = "form-control";
			$this->Add_ADPTR->EditCustomAttributes = "";
			$this->Add_ADPTR->EditValue = ew_HtmlEncode($this->Add_ADPTR->CurrentValue);
			$this->Add_ADPTR->PlaceHolder = ew_RemoveHtml($this->Add_ADPTR->FldCaption());

			// Add_APPTR
			$this->Add_APPTR->EditAttrs["class"] = "form-control";
			$this->Add_APPTR->EditCustomAttributes = "";
			$this->Add_APPTR->EditValue = ew_HtmlEncode($this->Add_APPTR->CurrentValue);
			$this->Add_APPTR->PlaceHolder = ew_RemoveHtml($this->Add_APPTR->FldCaption());

			// Add_APPTV
			$this->Add_APPTV->EditAttrs["class"] = "form-control";
			$this->Add_APPTV->EditCustomAttributes = "";
			$this->Add_APPTV->EditValue = ew_HtmlEncode($this->Add_APPTV->CurrentValue);
			$this->Add_APPTV->PlaceHolder = ew_RemoveHtml($this->Add_APPTV->FldCaption());

			// Add_ImmuneDamage
			$this->Add_ImmuneDamage->EditAttrs["class"] = "form-control";
			$this->Add_ImmuneDamage->EditCustomAttributes = "";
			$this->Add_ImmuneDamage->EditValue = ew_HtmlEncode($this->Add_ImmuneDamage->CurrentValue);
			$this->Add_ImmuneDamage->PlaceHolder = ew_RemoveHtml($this->Add_ImmuneDamage->FldCaption());

			// Special_Type
			$this->Special_Type->EditAttrs["class"] = "form-control";
			$this->Special_Type->EditCustomAttributes = "";
			$this->Special_Type->EditValue = ew_HtmlEncode($this->Special_Type->CurrentValue);
			$this->Special_Type->PlaceHolder = ew_RemoveHtml($this->Special_Type->FldCaption());

			// Special_Value
			$this->Special_Value->EditAttrs["class"] = "form-control";
			$this->Special_Value->EditCustomAttributes = "";
			$this->Special_Value->EditValue = ew_HtmlEncode($this->Special_Value->CurrentValue);
			$this->Special_Value->PlaceHolder = ew_RemoveHtml($this->Special_Value->FldCaption());

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

			// SlotName
			$this->SlotName->LinkCustomAttributes = "";
			$this->SlotName->HrefValue = "";

			// EquipName
			$this->EquipName->LinkCustomAttributes = "";
			$this->EquipName->HrefValue = "";

			// Add_HP
			$this->Add_HP->LinkCustomAttributes = "";
			$this->Add_HP->HrefValue = "";

			// Add_MP
			$this->Add_MP->LinkCustomAttributes = "";
			$this->Add_MP->HrefValue = "";

			// Add_Defense
			$this->Add_Defense->LinkCustomAttributes = "";
			$this->Add_Defense->HrefValue = "";

			// Add_Magic
			$this->Add_Magic->LinkCustomAttributes = "";
			$this->Add_Magic->HrefValue = "";

			// Add_AD
			$this->Add_AD->LinkCustomAttributes = "";
			$this->Add_AD->HrefValue = "";

			// Add_AP
			$this->Add_AP->LinkCustomAttributes = "";
			$this->Add_AP->HrefValue = "";

			// Add_Hit
			$this->Add_Hit->LinkCustomAttributes = "";
			$this->Add_Hit->HrefValue = "";

			// Add_Dodge
			$this->Add_Dodge->LinkCustomAttributes = "";
			$this->Add_Dodge->HrefValue = "";

			// Add_Crit
			$this->Add_Crit->LinkCustomAttributes = "";
			$this->Add_Crit->HrefValue = "";

			// Add_AbsorbHP
			$this->Add_AbsorbHP->LinkCustomAttributes = "";
			$this->Add_AbsorbHP->HrefValue = "";

			// Add_ADPTV
			$this->Add_ADPTV->LinkCustomAttributes = "";
			$this->Add_ADPTV->HrefValue = "";

			// Add_ADPTR
			$this->Add_ADPTR->LinkCustomAttributes = "";
			$this->Add_ADPTR->HrefValue = "";

			// Add_APPTR
			$this->Add_APPTR->LinkCustomAttributes = "";
			$this->Add_APPTR->HrefValue = "";

			// Add_APPTV
			$this->Add_APPTV->LinkCustomAttributes = "";
			$this->Add_APPTV->HrefValue = "";

			// Add_ImmuneDamage
			$this->Add_ImmuneDamage->LinkCustomAttributes = "";
			$this->Add_ImmuneDamage->HrefValue = "";

			// Special_Type
			$this->Special_Type->LinkCustomAttributes = "";
			$this->Special_Type->HrefValue = "";

			// Special_Value
			$this->Special_Value->LinkCustomAttributes = "";
			$this->Special_Value->HrefValue = "";

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
		if (!$this->SlotName->FldIsDetailKey && !is_null($this->SlotName->FormValue) && $this->SlotName->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->SlotName->FldCaption(), $this->SlotName->ReqErrMsg));
		}
		if (!$this->EquipName->FldIsDetailKey && !is_null($this->EquipName->FormValue) && $this->EquipName->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->EquipName->FldCaption(), $this->EquipName->ReqErrMsg));
		}
		if (!$this->Add_HP->FldIsDetailKey && !is_null($this->Add_HP->FormValue) && $this->Add_HP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_HP->FldCaption(), $this->Add_HP->ReqErrMsg));
		}
		if (!$this->Add_MP->FldIsDetailKey && !is_null($this->Add_MP->FormValue) && $this->Add_MP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_MP->FldCaption(), $this->Add_MP->ReqErrMsg));
		}
		if (!$this->Add_Defense->FldIsDetailKey && !is_null($this->Add_Defense->FormValue) && $this->Add_Defense->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_Defense->FldCaption(), $this->Add_Defense->ReqErrMsg));
		}
		if (!$this->Add_Magic->FldIsDetailKey && !is_null($this->Add_Magic->FormValue) && $this->Add_Magic->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_Magic->FldCaption(), $this->Add_Magic->ReqErrMsg));
		}
		if (!$this->Add_AD->FldIsDetailKey && !is_null($this->Add_AD->FormValue) && $this->Add_AD->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_AD->FldCaption(), $this->Add_AD->ReqErrMsg));
		}
		if (!$this->Add_AP->FldIsDetailKey && !is_null($this->Add_AP->FormValue) && $this->Add_AP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_AP->FldCaption(), $this->Add_AP->ReqErrMsg));
		}
		if (!$this->Add_Hit->FldIsDetailKey && !is_null($this->Add_Hit->FormValue) && $this->Add_Hit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_Hit->FldCaption(), $this->Add_Hit->ReqErrMsg));
		}
		if (!$this->Add_Dodge->FldIsDetailKey && !is_null($this->Add_Dodge->FormValue) && $this->Add_Dodge->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_Dodge->FldCaption(), $this->Add_Dodge->ReqErrMsg));
		}
		if (!$this->Add_Crit->FldIsDetailKey && !is_null($this->Add_Crit->FormValue) && $this->Add_Crit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_Crit->FldCaption(), $this->Add_Crit->ReqErrMsg));
		}
		if (!$this->Add_AbsorbHP->FldIsDetailKey && !is_null($this->Add_AbsorbHP->FormValue) && $this->Add_AbsorbHP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_AbsorbHP->FldCaption(), $this->Add_AbsorbHP->ReqErrMsg));
		}
		if (!$this->Add_ADPTV->FldIsDetailKey && !is_null($this->Add_ADPTV->FormValue) && $this->Add_ADPTV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_ADPTV->FldCaption(), $this->Add_ADPTV->ReqErrMsg));
		}
		if (!$this->Add_ADPTR->FldIsDetailKey && !is_null($this->Add_ADPTR->FormValue) && $this->Add_ADPTR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_ADPTR->FldCaption(), $this->Add_ADPTR->ReqErrMsg));
		}
		if (!$this->Add_APPTR->FldIsDetailKey && !is_null($this->Add_APPTR->FormValue) && $this->Add_APPTR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_APPTR->FldCaption(), $this->Add_APPTR->ReqErrMsg));
		}
		if (!$this->Add_APPTV->FldIsDetailKey && !is_null($this->Add_APPTV->FormValue) && $this->Add_APPTV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_APPTV->FldCaption(), $this->Add_APPTV->ReqErrMsg));
		}
		if (!$this->Add_ImmuneDamage->FldIsDetailKey && !is_null($this->Add_ImmuneDamage->FormValue) && $this->Add_ImmuneDamage->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Add_ImmuneDamage->FldCaption(), $this->Add_ImmuneDamage->ReqErrMsg));
		}
		if (!$this->Special_Type->FldIsDetailKey && !is_null($this->Special_Type->FormValue) && $this->Special_Type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Special_Type->FldCaption(), $this->Special_Type->ReqErrMsg));
		}
		if (!$this->Special_Value->FldIsDetailKey && !is_null($this->Special_Value->FormValue) && $this->Special_Value->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Special_Value->FldCaption(), $this->Special_Value->ReqErrMsg));
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

		// SlotName
		$this->SlotName->SetDbValueDef($rsnew, $this->SlotName->CurrentValue, "", FALSE);

		// EquipName
		$this->EquipName->SetDbValueDef($rsnew, $this->EquipName->CurrentValue, "", FALSE);

		// Add_HP
		$this->Add_HP->SetDbValueDef($rsnew, $this->Add_HP->CurrentValue, "", FALSE);

		// Add_MP
		$this->Add_MP->SetDbValueDef($rsnew, $this->Add_MP->CurrentValue, "", FALSE);

		// Add_Defense
		$this->Add_Defense->SetDbValueDef($rsnew, $this->Add_Defense->CurrentValue, "", FALSE);

		// Add_Magic
		$this->Add_Magic->SetDbValueDef($rsnew, $this->Add_Magic->CurrentValue, "", FALSE);

		// Add_AD
		$this->Add_AD->SetDbValueDef($rsnew, $this->Add_AD->CurrentValue, "", FALSE);

		// Add_AP
		$this->Add_AP->SetDbValueDef($rsnew, $this->Add_AP->CurrentValue, "", FALSE);

		// Add_Hit
		$this->Add_Hit->SetDbValueDef($rsnew, $this->Add_Hit->CurrentValue, "", FALSE);

		// Add_Dodge
		$this->Add_Dodge->SetDbValueDef($rsnew, $this->Add_Dodge->CurrentValue, "", FALSE);

		// Add_Crit
		$this->Add_Crit->SetDbValueDef($rsnew, $this->Add_Crit->CurrentValue, "", FALSE);

		// Add_AbsorbHP
		$this->Add_AbsorbHP->SetDbValueDef($rsnew, $this->Add_AbsorbHP->CurrentValue, "", FALSE);

		// Add_ADPTV
		$this->Add_ADPTV->SetDbValueDef($rsnew, $this->Add_ADPTV->CurrentValue, "", FALSE);

		// Add_ADPTR
		$this->Add_ADPTR->SetDbValueDef($rsnew, $this->Add_ADPTR->CurrentValue, "", FALSE);

		// Add_APPTR
		$this->Add_APPTR->SetDbValueDef($rsnew, $this->Add_APPTR->CurrentValue, "", FALSE);

		// Add_APPTV
		$this->Add_APPTV->SetDbValueDef($rsnew, $this->Add_APPTV->CurrentValue, "", FALSE);

		// Add_ImmuneDamage
		$this->Add_ImmuneDamage->SetDbValueDef($rsnew, $this->Add_ImmuneDamage->CurrentValue, "", FALSE);

		// Special_Type
		$this->Special_Type->SetDbValueDef($rsnew, $this->Special_Type->CurrentValue, "", FALSE);

		// Special_Value
		$this->Special_Value->SetDbValueDef($rsnew, $this->Special_Value->CurrentValue, "", FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("equip_registerlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($equip_register_add)) $equip_register_add = new cequip_register_add();

// Page init
$equip_register_add->Page_Init();

// Page main
$equip_register_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$equip_register_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fequip_registeradd = new ew_Form("fequip_registeradd", "add");

// Validate form
fequip_registeradd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->u_id->FldCaption(), $equip_register->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($equip_register->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->acl_id->FldCaption(), $equip_register->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($equip_register->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_User");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->User->FldCaption(), $equip_register->User->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_SlotName");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->SlotName->FldCaption(), $equip_register->SlotName->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_EquipName");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->EquipName->FldCaption(), $equip_register->EquipName->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_HP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_HP->FldCaption(), $equip_register->Add_HP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_MP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_MP->FldCaption(), $equip_register->Add_MP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_Defense");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_Defense->FldCaption(), $equip_register->Add_Defense->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_Magic");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_Magic->FldCaption(), $equip_register->Add_Magic->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_AD");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_AD->FldCaption(), $equip_register->Add_AD->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_AP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_AP->FldCaption(), $equip_register->Add_AP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_Hit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_Hit->FldCaption(), $equip_register->Add_Hit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_Dodge");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_Dodge->FldCaption(), $equip_register->Add_Dodge->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_Crit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_Crit->FldCaption(), $equip_register->Add_Crit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_AbsorbHP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_AbsorbHP->FldCaption(), $equip_register->Add_AbsorbHP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_ADPTV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_ADPTV->FldCaption(), $equip_register->Add_ADPTV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_ADPTR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_ADPTR->FldCaption(), $equip_register->Add_ADPTR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_APPTR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_APPTR->FldCaption(), $equip_register->Add_APPTR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_APPTV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_APPTV->FldCaption(), $equip_register->Add_APPTV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Add_ImmuneDamage");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Add_ImmuneDamage->FldCaption(), $equip_register->Add_ImmuneDamage->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Special_Type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Special_Type->FldCaption(), $equip_register->Special_Type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Special_Value");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->Special_Value->FldCaption(), $equip_register->Special_Value->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $equip_register->DATETIME->FldCaption(), $equip_register->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($equip_register->DATETIME->FldErrMsg()) ?>");

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
fequip_registeradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fequip_registeradd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $equip_register_add->ShowPageHeader(); ?>
<?php
$equip_register_add->ShowMessage();
?>
<form name="fequip_registeradd" id="fequip_registeradd" class="<?php echo $equip_register_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($equip_register_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $equip_register_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="equip_register">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($equip_register_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($equip_register->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_equip_register_u_id" for="x_u_id" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->u_id->CellAttributes() ?>>
<span id="el_equip_register_u_id">
<input type="text" data-table="equip_register" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($equip_register->u_id->getPlaceHolder()) ?>" value="<?php echo $equip_register->u_id->EditValue ?>"<?php echo $equip_register->u_id->EditAttributes() ?>>
</span>
<?php echo $equip_register->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_equip_register_acl_id" for="x_acl_id" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->acl_id->CellAttributes() ?>>
<span id="el_equip_register_acl_id">
<input type="text" data-table="equip_register" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($equip_register->acl_id->getPlaceHolder()) ?>" value="<?php echo $equip_register->acl_id->EditValue ?>"<?php echo $equip_register->acl_id->EditAttributes() ?>>
</span>
<?php echo $equip_register->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->User->Visible) { // User ?>
	<div id="r_User" class="form-group">
		<label id="elh_equip_register_User" for="x_User" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->User->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->User->CellAttributes() ?>>
<span id="el_equip_register_User">
<textarea data-table="equip_register" data-field="x_User" name="x_User" id="x_User" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->User->getPlaceHolder()) ?>"<?php echo $equip_register->User->EditAttributes() ?>><?php echo $equip_register->User->EditValue ?></textarea>
</span>
<?php echo $equip_register->User->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->SlotName->Visible) { // SlotName ?>
	<div id="r_SlotName" class="form-group">
		<label id="elh_equip_register_SlotName" for="x_SlotName" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->SlotName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->SlotName->CellAttributes() ?>>
<span id="el_equip_register_SlotName">
<textarea data-table="equip_register" data-field="x_SlotName" name="x_SlotName" id="x_SlotName" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->SlotName->getPlaceHolder()) ?>"<?php echo $equip_register->SlotName->EditAttributes() ?>><?php echo $equip_register->SlotName->EditValue ?></textarea>
</span>
<?php echo $equip_register->SlotName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->EquipName->Visible) { // EquipName ?>
	<div id="r_EquipName" class="form-group">
		<label id="elh_equip_register_EquipName" for="x_EquipName" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->EquipName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->EquipName->CellAttributes() ?>>
<span id="el_equip_register_EquipName">
<textarea data-table="equip_register" data-field="x_EquipName" name="x_EquipName" id="x_EquipName" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->EquipName->getPlaceHolder()) ?>"<?php echo $equip_register->EquipName->EditAttributes() ?>><?php echo $equip_register->EquipName->EditValue ?></textarea>
</span>
<?php echo $equip_register->EquipName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_HP->Visible) { // Add_HP ?>
	<div id="r_Add_HP" class="form-group">
		<label id="elh_equip_register_Add_HP" for="x_Add_HP" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_HP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_HP->CellAttributes() ?>>
<span id="el_equip_register_Add_HP">
<textarea data-table="equip_register" data-field="x_Add_HP" name="x_Add_HP" id="x_Add_HP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_HP->getPlaceHolder()) ?>"<?php echo $equip_register->Add_HP->EditAttributes() ?>><?php echo $equip_register->Add_HP->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_HP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_MP->Visible) { // Add_MP ?>
	<div id="r_Add_MP" class="form-group">
		<label id="elh_equip_register_Add_MP" for="x_Add_MP" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_MP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_MP->CellAttributes() ?>>
<span id="el_equip_register_Add_MP">
<textarea data-table="equip_register" data-field="x_Add_MP" name="x_Add_MP" id="x_Add_MP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_MP->getPlaceHolder()) ?>"<?php echo $equip_register->Add_MP->EditAttributes() ?>><?php echo $equip_register->Add_MP->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_MP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_Defense->Visible) { // Add_Defense ?>
	<div id="r_Add_Defense" class="form-group">
		<label id="elh_equip_register_Add_Defense" for="x_Add_Defense" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_Defense->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_Defense->CellAttributes() ?>>
<span id="el_equip_register_Add_Defense">
<textarea data-table="equip_register" data-field="x_Add_Defense" name="x_Add_Defense" id="x_Add_Defense" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_Defense->getPlaceHolder()) ?>"<?php echo $equip_register->Add_Defense->EditAttributes() ?>><?php echo $equip_register->Add_Defense->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_Defense->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_Magic->Visible) { // Add_Magic ?>
	<div id="r_Add_Magic" class="form-group">
		<label id="elh_equip_register_Add_Magic" for="x_Add_Magic" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_Magic->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_Magic->CellAttributes() ?>>
<span id="el_equip_register_Add_Magic">
<textarea data-table="equip_register" data-field="x_Add_Magic" name="x_Add_Magic" id="x_Add_Magic" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_Magic->getPlaceHolder()) ?>"<?php echo $equip_register->Add_Magic->EditAttributes() ?>><?php echo $equip_register->Add_Magic->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_Magic->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_AD->Visible) { // Add_AD ?>
	<div id="r_Add_AD" class="form-group">
		<label id="elh_equip_register_Add_AD" for="x_Add_AD" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_AD->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_AD->CellAttributes() ?>>
<span id="el_equip_register_Add_AD">
<textarea data-table="equip_register" data-field="x_Add_AD" name="x_Add_AD" id="x_Add_AD" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_AD->getPlaceHolder()) ?>"<?php echo $equip_register->Add_AD->EditAttributes() ?>><?php echo $equip_register->Add_AD->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_AD->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_AP->Visible) { // Add_AP ?>
	<div id="r_Add_AP" class="form-group">
		<label id="elh_equip_register_Add_AP" for="x_Add_AP" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_AP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_AP->CellAttributes() ?>>
<span id="el_equip_register_Add_AP">
<textarea data-table="equip_register" data-field="x_Add_AP" name="x_Add_AP" id="x_Add_AP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_AP->getPlaceHolder()) ?>"<?php echo $equip_register->Add_AP->EditAttributes() ?>><?php echo $equip_register->Add_AP->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_AP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_Hit->Visible) { // Add_Hit ?>
	<div id="r_Add_Hit" class="form-group">
		<label id="elh_equip_register_Add_Hit" for="x_Add_Hit" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_Hit->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_Hit->CellAttributes() ?>>
<span id="el_equip_register_Add_Hit">
<textarea data-table="equip_register" data-field="x_Add_Hit" name="x_Add_Hit" id="x_Add_Hit" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_Hit->getPlaceHolder()) ?>"<?php echo $equip_register->Add_Hit->EditAttributes() ?>><?php echo $equip_register->Add_Hit->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_Hit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_Dodge->Visible) { // Add_Dodge ?>
	<div id="r_Add_Dodge" class="form-group">
		<label id="elh_equip_register_Add_Dodge" for="x_Add_Dodge" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_Dodge->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_Dodge->CellAttributes() ?>>
<span id="el_equip_register_Add_Dodge">
<textarea data-table="equip_register" data-field="x_Add_Dodge" name="x_Add_Dodge" id="x_Add_Dodge" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_Dodge->getPlaceHolder()) ?>"<?php echo $equip_register->Add_Dodge->EditAttributes() ?>><?php echo $equip_register->Add_Dodge->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_Dodge->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_Crit->Visible) { // Add_Crit ?>
	<div id="r_Add_Crit" class="form-group">
		<label id="elh_equip_register_Add_Crit" for="x_Add_Crit" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_Crit->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_Crit->CellAttributes() ?>>
<span id="el_equip_register_Add_Crit">
<textarea data-table="equip_register" data-field="x_Add_Crit" name="x_Add_Crit" id="x_Add_Crit" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_Crit->getPlaceHolder()) ?>"<?php echo $equip_register->Add_Crit->EditAttributes() ?>><?php echo $equip_register->Add_Crit->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_Crit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_AbsorbHP->Visible) { // Add_AbsorbHP ?>
	<div id="r_Add_AbsorbHP" class="form-group">
		<label id="elh_equip_register_Add_AbsorbHP" for="x_Add_AbsorbHP" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_AbsorbHP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_AbsorbHP->CellAttributes() ?>>
<span id="el_equip_register_Add_AbsorbHP">
<textarea data-table="equip_register" data-field="x_Add_AbsorbHP" name="x_Add_AbsorbHP" id="x_Add_AbsorbHP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_AbsorbHP->getPlaceHolder()) ?>"<?php echo $equip_register->Add_AbsorbHP->EditAttributes() ?>><?php echo $equip_register->Add_AbsorbHP->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_AbsorbHP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_ADPTV->Visible) { // Add_ADPTV ?>
	<div id="r_Add_ADPTV" class="form-group">
		<label id="elh_equip_register_Add_ADPTV" for="x_Add_ADPTV" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_ADPTV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_ADPTV->CellAttributes() ?>>
<span id="el_equip_register_Add_ADPTV">
<textarea data-table="equip_register" data-field="x_Add_ADPTV" name="x_Add_ADPTV" id="x_Add_ADPTV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_ADPTV->getPlaceHolder()) ?>"<?php echo $equip_register->Add_ADPTV->EditAttributes() ?>><?php echo $equip_register->Add_ADPTV->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_ADPTV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_ADPTR->Visible) { // Add_ADPTR ?>
	<div id="r_Add_ADPTR" class="form-group">
		<label id="elh_equip_register_Add_ADPTR" for="x_Add_ADPTR" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_ADPTR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_ADPTR->CellAttributes() ?>>
<span id="el_equip_register_Add_ADPTR">
<textarea data-table="equip_register" data-field="x_Add_ADPTR" name="x_Add_ADPTR" id="x_Add_ADPTR" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_ADPTR->getPlaceHolder()) ?>"<?php echo $equip_register->Add_ADPTR->EditAttributes() ?>><?php echo $equip_register->Add_ADPTR->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_ADPTR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_APPTR->Visible) { // Add_APPTR ?>
	<div id="r_Add_APPTR" class="form-group">
		<label id="elh_equip_register_Add_APPTR" for="x_Add_APPTR" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_APPTR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_APPTR->CellAttributes() ?>>
<span id="el_equip_register_Add_APPTR">
<textarea data-table="equip_register" data-field="x_Add_APPTR" name="x_Add_APPTR" id="x_Add_APPTR" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_APPTR->getPlaceHolder()) ?>"<?php echo $equip_register->Add_APPTR->EditAttributes() ?>><?php echo $equip_register->Add_APPTR->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_APPTR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_APPTV->Visible) { // Add_APPTV ?>
	<div id="r_Add_APPTV" class="form-group">
		<label id="elh_equip_register_Add_APPTV" for="x_Add_APPTV" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_APPTV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_APPTV->CellAttributes() ?>>
<span id="el_equip_register_Add_APPTV">
<textarea data-table="equip_register" data-field="x_Add_APPTV" name="x_Add_APPTV" id="x_Add_APPTV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_APPTV->getPlaceHolder()) ?>"<?php echo $equip_register->Add_APPTV->EditAttributes() ?>><?php echo $equip_register->Add_APPTV->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_APPTV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Add_ImmuneDamage->Visible) { // Add_ImmuneDamage ?>
	<div id="r_Add_ImmuneDamage" class="form-group">
		<label id="elh_equip_register_Add_ImmuneDamage" for="x_Add_ImmuneDamage" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Add_ImmuneDamage->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Add_ImmuneDamage->CellAttributes() ?>>
<span id="el_equip_register_Add_ImmuneDamage">
<textarea data-table="equip_register" data-field="x_Add_ImmuneDamage" name="x_Add_ImmuneDamage" id="x_Add_ImmuneDamage" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Add_ImmuneDamage->getPlaceHolder()) ?>"<?php echo $equip_register->Add_ImmuneDamage->EditAttributes() ?>><?php echo $equip_register->Add_ImmuneDamage->EditValue ?></textarea>
</span>
<?php echo $equip_register->Add_ImmuneDamage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Special_Type->Visible) { // Special_Type ?>
	<div id="r_Special_Type" class="form-group">
		<label id="elh_equip_register_Special_Type" for="x_Special_Type" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Special_Type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Special_Type->CellAttributes() ?>>
<span id="el_equip_register_Special_Type">
<textarea data-table="equip_register" data-field="x_Special_Type" name="x_Special_Type" id="x_Special_Type" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Special_Type->getPlaceHolder()) ?>"<?php echo $equip_register->Special_Type->EditAttributes() ?>><?php echo $equip_register->Special_Type->EditValue ?></textarea>
</span>
<?php echo $equip_register->Special_Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->Special_Value->Visible) { // Special_Value ?>
	<div id="r_Special_Value" class="form-group">
		<label id="elh_equip_register_Special_Value" for="x_Special_Value" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->Special_Value->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->Special_Value->CellAttributes() ?>>
<span id="el_equip_register_Special_Value">
<textarea data-table="equip_register" data-field="x_Special_Value" name="x_Special_Value" id="x_Special_Value" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($equip_register->Special_Value->getPlaceHolder()) ?>"<?php echo $equip_register->Special_Value->EditAttributes() ?>><?php echo $equip_register->Special_Value->EditValue ?></textarea>
</span>
<?php echo $equip_register->Special_Value->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($equip_register->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_equip_register_DATETIME" for="x_DATETIME" class="<?php echo $equip_register_add->LeftColumnClass ?>"><?php echo $equip_register->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $equip_register_add->RightColumnClass ?>"><div<?php echo $equip_register->DATETIME->CellAttributes() ?>>
<span id="el_equip_register_DATETIME">
<input type="text" data-table="equip_register" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($equip_register->DATETIME->getPlaceHolder()) ?>" value="<?php echo $equip_register->DATETIME->EditValue ?>"<?php echo $equip_register->DATETIME->EditAttributes() ?>>
</span>
<?php echo $equip_register->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$equip_register_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $equip_register_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $equip_register_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fequip_registeradd.Init();
</script>
<?php
$equip_register_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$equip_register_add->Page_Terminate();
?>
