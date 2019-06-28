<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ext_sam_user_infoinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$ext_sam_user_info_add = NULL; // Initialize page object first

class cext_sam_user_info_add extends cext_sam_user_info {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'ext_sam_user_info';

	// Page object name
	var $PageObjName = 'ext_sam_user_info_add';

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

		// Table object (ext_sam_user_info)
		if (!isset($GLOBALS["ext_sam_user_info"]) || get_class($GLOBALS["ext_sam_user_info"]) == "cext_sam_user_info") {
			$GLOBALS["ext_sam_user_info"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ext_sam_user_info"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ext_sam_user_info', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ext_sam_user_infolist.php"));
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
		$this->LV->SetVisibility();
		$this->MainCat->SetVisibility();
		$this->SubCat->SetVisibility();
		$this->Location->SetVisibility();
		$this->Dialog->SetVisibility();
		$this->Function->SetVisibility();
		$this->MasterName->SetVisibility();
		$this->HP->SetVisibility();
		$this->MAX_HP->SetVisibility();
		$this->UD1->SetVisibility();
		$this->UD2->SetVisibility();
		$this->UD3->SetVisibility();
		$this->UD4->SetVisibility();
		$this->UD5->SetVisibility();
		$this->UD6->SetVisibility();
		$this->UD7->SetVisibility();
		$this->UD8->SetVisibility();
		$this->UD9->SetVisibility();
		$this->UD10->SetVisibility();
		$this->UD11->SetVisibility();
		$this->UD12->SetVisibility();
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
		global $EW_EXPORT, $ext_sam_user_info;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ext_sam_user_info);
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
					if ($pageName == "ext_sam_user_infoview.php")
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
					$this->Page_Terminate("ext_sam_user_infolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ext_sam_user_infolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "ext_sam_user_infoview.php")
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
		$this->LV->CurrentValue = NULL;
		$this->LV->OldValue = $this->LV->CurrentValue;
		$this->MainCat->CurrentValue = NULL;
		$this->MainCat->OldValue = $this->MainCat->CurrentValue;
		$this->SubCat->CurrentValue = NULL;
		$this->SubCat->OldValue = $this->SubCat->CurrentValue;
		$this->Location->CurrentValue = NULL;
		$this->Location->OldValue = $this->Location->CurrentValue;
		$this->Dialog->CurrentValue = NULL;
		$this->Dialog->OldValue = $this->Dialog->CurrentValue;
		$this->Function->CurrentValue = NULL;
		$this->Function->OldValue = $this->Function->CurrentValue;
		$this->MasterName->CurrentValue = NULL;
		$this->MasterName->OldValue = $this->MasterName->CurrentValue;
		$this->HP->CurrentValue = NULL;
		$this->HP->OldValue = $this->HP->CurrentValue;
		$this->MAX_HP->CurrentValue = NULL;
		$this->MAX_HP->OldValue = $this->MAX_HP->CurrentValue;
		$this->UD1->CurrentValue = NULL;
		$this->UD1->OldValue = $this->UD1->CurrentValue;
		$this->UD2->CurrentValue = NULL;
		$this->UD2->OldValue = $this->UD2->CurrentValue;
		$this->UD3->CurrentValue = NULL;
		$this->UD3->OldValue = $this->UD3->CurrentValue;
		$this->UD4->CurrentValue = NULL;
		$this->UD4->OldValue = $this->UD4->CurrentValue;
		$this->UD5->CurrentValue = NULL;
		$this->UD5->OldValue = $this->UD5->CurrentValue;
		$this->UD6->CurrentValue = NULL;
		$this->UD6->OldValue = $this->UD6->CurrentValue;
		$this->UD7->CurrentValue = NULL;
		$this->UD7->OldValue = $this->UD7->CurrentValue;
		$this->UD8->CurrentValue = NULL;
		$this->UD8->OldValue = $this->UD8->CurrentValue;
		$this->UD9->CurrentValue = NULL;
		$this->UD9->OldValue = $this->UD9->CurrentValue;
		$this->UD10->CurrentValue = NULL;
		$this->UD10->OldValue = $this->UD10->CurrentValue;
		$this->UD11->CurrentValue = NULL;
		$this->UD11->OldValue = $this->UD11->CurrentValue;
		$this->UD12->CurrentValue = NULL;
		$this->UD12->OldValue = $this->UD12->CurrentValue;
		$this->Introduce->CurrentValue = NULL;
		$this->Introduce->OldValue = $this->Introduce->CurrentValue;
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
		if (!$this->LV->FldIsDetailKey) {
			$this->LV->setFormValue($objForm->GetValue("x_LV"));
		}
		if (!$this->MainCat->FldIsDetailKey) {
			$this->MainCat->setFormValue($objForm->GetValue("x_MainCat"));
		}
		if (!$this->SubCat->FldIsDetailKey) {
			$this->SubCat->setFormValue($objForm->GetValue("x_SubCat"));
		}
		if (!$this->Location->FldIsDetailKey) {
			$this->Location->setFormValue($objForm->GetValue("x_Location"));
		}
		if (!$this->Dialog->FldIsDetailKey) {
			$this->Dialog->setFormValue($objForm->GetValue("x_Dialog"));
		}
		if (!$this->Function->FldIsDetailKey) {
			$this->Function->setFormValue($objForm->GetValue("x_Function"));
		}
		if (!$this->MasterName->FldIsDetailKey) {
			$this->MasterName->setFormValue($objForm->GetValue("x_MasterName"));
		}
		if (!$this->HP->FldIsDetailKey) {
			$this->HP->setFormValue($objForm->GetValue("x_HP"));
		}
		if (!$this->MAX_HP->FldIsDetailKey) {
			$this->MAX_HP->setFormValue($objForm->GetValue("x_MAX_HP"));
		}
		if (!$this->UD1->FldIsDetailKey) {
			$this->UD1->setFormValue($objForm->GetValue("x_UD1"));
		}
		if (!$this->UD2->FldIsDetailKey) {
			$this->UD2->setFormValue($objForm->GetValue("x_UD2"));
		}
		if (!$this->UD3->FldIsDetailKey) {
			$this->UD3->setFormValue($objForm->GetValue("x_UD3"));
		}
		if (!$this->UD4->FldIsDetailKey) {
			$this->UD4->setFormValue($objForm->GetValue("x_UD4"));
		}
		if (!$this->UD5->FldIsDetailKey) {
			$this->UD5->setFormValue($objForm->GetValue("x_UD5"));
		}
		if (!$this->UD6->FldIsDetailKey) {
			$this->UD6->setFormValue($objForm->GetValue("x_UD6"));
		}
		if (!$this->UD7->FldIsDetailKey) {
			$this->UD7->setFormValue($objForm->GetValue("x_UD7"));
		}
		if (!$this->UD8->FldIsDetailKey) {
			$this->UD8->setFormValue($objForm->GetValue("x_UD8"));
		}
		if (!$this->UD9->FldIsDetailKey) {
			$this->UD9->setFormValue($objForm->GetValue("x_UD9"));
		}
		if (!$this->UD10->FldIsDetailKey) {
			$this->UD10->setFormValue($objForm->GetValue("x_UD10"));
		}
		if (!$this->UD11->FldIsDetailKey) {
			$this->UD11->setFormValue($objForm->GetValue("x_UD11"));
		}
		if (!$this->UD12->FldIsDetailKey) {
			$this->UD12->setFormValue($objForm->GetValue("x_UD12"));
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
		$this->u_id->CurrentValue = $this->u_id->FormValue;
		$this->acl_id->CurrentValue = $this->acl_id->FormValue;
		$this->Name->CurrentValue = $this->Name->FormValue;
		$this->LV->CurrentValue = $this->LV->FormValue;
		$this->MainCat->CurrentValue = $this->MainCat->FormValue;
		$this->SubCat->CurrentValue = $this->SubCat->FormValue;
		$this->Location->CurrentValue = $this->Location->FormValue;
		$this->Dialog->CurrentValue = $this->Dialog->FormValue;
		$this->Function->CurrentValue = $this->Function->FormValue;
		$this->MasterName->CurrentValue = $this->MasterName->FormValue;
		$this->HP->CurrentValue = $this->HP->FormValue;
		$this->MAX_HP->CurrentValue = $this->MAX_HP->FormValue;
		$this->UD1->CurrentValue = $this->UD1->FormValue;
		$this->UD2->CurrentValue = $this->UD2->FormValue;
		$this->UD3->CurrentValue = $this->UD3->FormValue;
		$this->UD4->CurrentValue = $this->UD4->FormValue;
		$this->UD5->CurrentValue = $this->UD5->FormValue;
		$this->UD6->CurrentValue = $this->UD6->FormValue;
		$this->UD7->CurrentValue = $this->UD7->FormValue;
		$this->UD8->CurrentValue = $this->UD8->FormValue;
		$this->UD9->CurrentValue = $this->UD9->FormValue;
		$this->UD10->CurrentValue = $this->UD10->FormValue;
		$this->UD11->CurrentValue = $this->UD11->FormValue;
		$this->UD12->CurrentValue = $this->UD12->FormValue;
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
		$this->LV->setDbValue($row['LV']);
		$this->MainCat->setDbValue($row['MainCat']);
		$this->SubCat->setDbValue($row['SubCat']);
		$this->Location->setDbValue($row['Location']);
		$this->Dialog->setDbValue($row['Dialog']);
		$this->Function->setDbValue($row['Function']);
		$this->MasterName->setDbValue($row['MasterName']);
		$this->HP->setDbValue($row['HP']);
		$this->MAX_HP->setDbValue($row['MAX_HP']);
		$this->UD1->setDbValue($row['UD1']);
		$this->UD2->setDbValue($row['UD2']);
		$this->UD3->setDbValue($row['UD3']);
		$this->UD4->setDbValue($row['UD4']);
		$this->UD5->setDbValue($row['UD5']);
		$this->UD6->setDbValue($row['UD6']);
		$this->UD7->setDbValue($row['UD7']);
		$this->UD8->setDbValue($row['UD8']);
		$this->UD9->setDbValue($row['UD9']);
		$this->UD10->setDbValue($row['UD10']);
		$this->UD11->setDbValue($row['UD11']);
		$this->UD12->setDbValue($row['UD12']);
		$this->Introduce->setDbValue($row['Introduce']);
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
		$row['LV'] = $this->LV->CurrentValue;
		$row['MainCat'] = $this->MainCat->CurrentValue;
		$row['SubCat'] = $this->SubCat->CurrentValue;
		$row['Location'] = $this->Location->CurrentValue;
		$row['Dialog'] = $this->Dialog->CurrentValue;
		$row['Function'] = $this->Function->CurrentValue;
		$row['MasterName'] = $this->MasterName->CurrentValue;
		$row['HP'] = $this->HP->CurrentValue;
		$row['MAX_HP'] = $this->MAX_HP->CurrentValue;
		$row['UD1'] = $this->UD1->CurrentValue;
		$row['UD2'] = $this->UD2->CurrentValue;
		$row['UD3'] = $this->UD3->CurrentValue;
		$row['UD4'] = $this->UD4->CurrentValue;
		$row['UD5'] = $this->UD5->CurrentValue;
		$row['UD6'] = $this->UD6->CurrentValue;
		$row['UD7'] = $this->UD7->CurrentValue;
		$row['UD8'] = $this->UD8->CurrentValue;
		$row['UD9'] = $this->UD9->CurrentValue;
		$row['UD10'] = $this->UD10->CurrentValue;
		$row['UD11'] = $this->UD11->CurrentValue;
		$row['UD12'] = $this->UD12->CurrentValue;
		$row['Introduce'] = $this->Introduce->CurrentValue;
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
		$this->LV->DbValue = $row['LV'];
		$this->MainCat->DbValue = $row['MainCat'];
		$this->SubCat->DbValue = $row['SubCat'];
		$this->Location->DbValue = $row['Location'];
		$this->Dialog->DbValue = $row['Dialog'];
		$this->Function->DbValue = $row['Function'];
		$this->MasterName->DbValue = $row['MasterName'];
		$this->HP->DbValue = $row['HP'];
		$this->MAX_HP->DbValue = $row['MAX_HP'];
		$this->UD1->DbValue = $row['UD1'];
		$this->UD2->DbValue = $row['UD2'];
		$this->UD3->DbValue = $row['UD3'];
		$this->UD4->DbValue = $row['UD4'];
		$this->UD5->DbValue = $row['UD5'];
		$this->UD6->DbValue = $row['UD6'];
		$this->UD7->DbValue = $row['UD7'];
		$this->UD8->DbValue = $row['UD8'];
		$this->UD9->DbValue = $row['UD9'];
		$this->UD10->DbValue = $row['UD10'];
		$this->UD11->DbValue = $row['UD11'];
		$this->UD12->DbValue = $row['UD12'];
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
		// LV
		// MainCat
		// SubCat
		// Location
		// Dialog
		// Function
		// MasterName
		// HP
		// MAX_HP
		// UD1
		// UD2
		// UD3
		// UD4
		// UD5
		// UD6
		// UD7
		// UD8
		// UD9
		// UD10
		// UD11
		// UD12
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

		// LV
		$this->LV->ViewValue = $this->LV->CurrentValue;
		$this->LV->ViewCustomAttributes = "";

		// MainCat
		$this->MainCat->ViewValue = $this->MainCat->CurrentValue;
		$this->MainCat->ViewCustomAttributes = "";

		// SubCat
		$this->SubCat->ViewValue = $this->SubCat->CurrentValue;
		$this->SubCat->ViewCustomAttributes = "";

		// Location
		$this->Location->ViewValue = $this->Location->CurrentValue;
		$this->Location->ViewCustomAttributes = "";

		// Dialog
		$this->Dialog->ViewValue = $this->Dialog->CurrentValue;
		$this->Dialog->ViewCustomAttributes = "";

		// Function
		$this->Function->ViewValue = $this->Function->CurrentValue;
		$this->Function->ViewCustomAttributes = "";

		// MasterName
		$this->MasterName->ViewValue = $this->MasterName->CurrentValue;
		$this->MasterName->ViewCustomAttributes = "";

		// HP
		$this->HP->ViewValue = $this->HP->CurrentValue;
		$this->HP->ViewCustomAttributes = "";

		// MAX_HP
		$this->MAX_HP->ViewValue = $this->MAX_HP->CurrentValue;
		$this->MAX_HP->ViewCustomAttributes = "";

		// UD1
		$this->UD1->ViewValue = $this->UD1->CurrentValue;
		$this->UD1->ViewCustomAttributes = "";

		// UD2
		$this->UD2->ViewValue = $this->UD2->CurrentValue;
		$this->UD2->ViewCustomAttributes = "";

		// UD3
		$this->UD3->ViewValue = $this->UD3->CurrentValue;
		$this->UD3->ViewCustomAttributes = "";

		// UD4
		$this->UD4->ViewValue = $this->UD4->CurrentValue;
		$this->UD4->ViewCustomAttributes = "";

		// UD5
		$this->UD5->ViewValue = $this->UD5->CurrentValue;
		$this->UD5->ViewCustomAttributes = "";

		// UD6
		$this->UD6->ViewValue = $this->UD6->CurrentValue;
		$this->UD6->ViewCustomAttributes = "";

		// UD7
		$this->UD7->ViewValue = $this->UD7->CurrentValue;
		$this->UD7->ViewCustomAttributes = "";

		// UD8
		$this->UD8->ViewValue = $this->UD8->CurrentValue;
		$this->UD8->ViewCustomAttributes = "";

		// UD9
		$this->UD9->ViewValue = $this->UD9->CurrentValue;
		$this->UD9->ViewCustomAttributes = "";

		// UD10
		$this->UD10->ViewValue = $this->UD10->CurrentValue;
		$this->UD10->ViewCustomAttributes = "";

		// UD11
		$this->UD11->ViewValue = $this->UD11->CurrentValue;
		$this->UD11->ViewCustomAttributes = "";

		// UD12
		$this->UD12->ViewValue = $this->UD12->CurrentValue;
		$this->UD12->ViewCustomAttributes = "";

		// Introduce
		$this->Introduce->ViewValue = $this->Introduce->CurrentValue;
		$this->Introduce->ViewCustomAttributes = "";

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

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";
			$this->LV->TooltipValue = "";

			// MainCat
			$this->MainCat->LinkCustomAttributes = "";
			$this->MainCat->HrefValue = "";
			$this->MainCat->TooltipValue = "";

			// SubCat
			$this->SubCat->LinkCustomAttributes = "";
			$this->SubCat->HrefValue = "";
			$this->SubCat->TooltipValue = "";

			// Location
			$this->Location->LinkCustomAttributes = "";
			$this->Location->HrefValue = "";
			$this->Location->TooltipValue = "";

			// Dialog
			$this->Dialog->LinkCustomAttributes = "";
			$this->Dialog->HrefValue = "";
			$this->Dialog->TooltipValue = "";

			// Function
			$this->Function->LinkCustomAttributes = "";
			$this->Function->HrefValue = "";
			$this->Function->TooltipValue = "";

			// MasterName
			$this->MasterName->LinkCustomAttributes = "";
			$this->MasterName->HrefValue = "";
			$this->MasterName->TooltipValue = "";

			// HP
			$this->HP->LinkCustomAttributes = "";
			$this->HP->HrefValue = "";
			$this->HP->TooltipValue = "";

			// MAX_HP
			$this->MAX_HP->LinkCustomAttributes = "";
			$this->MAX_HP->HrefValue = "";
			$this->MAX_HP->TooltipValue = "";

			// UD1
			$this->UD1->LinkCustomAttributes = "";
			$this->UD1->HrefValue = "";
			$this->UD1->TooltipValue = "";

			// UD2
			$this->UD2->LinkCustomAttributes = "";
			$this->UD2->HrefValue = "";
			$this->UD2->TooltipValue = "";

			// UD3
			$this->UD3->LinkCustomAttributes = "";
			$this->UD3->HrefValue = "";
			$this->UD3->TooltipValue = "";

			// UD4
			$this->UD4->LinkCustomAttributes = "";
			$this->UD4->HrefValue = "";
			$this->UD4->TooltipValue = "";

			// UD5
			$this->UD5->LinkCustomAttributes = "";
			$this->UD5->HrefValue = "";
			$this->UD5->TooltipValue = "";

			// UD6
			$this->UD6->LinkCustomAttributes = "";
			$this->UD6->HrefValue = "";
			$this->UD6->TooltipValue = "";

			// UD7
			$this->UD7->LinkCustomAttributes = "";
			$this->UD7->HrefValue = "";
			$this->UD7->TooltipValue = "";

			// UD8
			$this->UD8->LinkCustomAttributes = "";
			$this->UD8->HrefValue = "";
			$this->UD8->TooltipValue = "";

			// UD9
			$this->UD9->LinkCustomAttributes = "";
			$this->UD9->HrefValue = "";
			$this->UD9->TooltipValue = "";

			// UD10
			$this->UD10->LinkCustomAttributes = "";
			$this->UD10->HrefValue = "";
			$this->UD10->TooltipValue = "";

			// UD11
			$this->UD11->LinkCustomAttributes = "";
			$this->UD11->HrefValue = "";
			$this->UD11->TooltipValue = "";

			// UD12
			$this->UD12->LinkCustomAttributes = "";
			$this->UD12->HrefValue = "";
			$this->UD12->TooltipValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";
			$this->Introduce->TooltipValue = "";

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

			// LV
			$this->LV->EditAttrs["class"] = "form-control";
			$this->LV->EditCustomAttributes = "";
			$this->LV->EditValue = ew_HtmlEncode($this->LV->CurrentValue);
			$this->LV->PlaceHolder = ew_RemoveHtml($this->LV->FldCaption());

			// MainCat
			$this->MainCat->EditAttrs["class"] = "form-control";
			$this->MainCat->EditCustomAttributes = "";
			$this->MainCat->EditValue = ew_HtmlEncode($this->MainCat->CurrentValue);
			$this->MainCat->PlaceHolder = ew_RemoveHtml($this->MainCat->FldCaption());

			// SubCat
			$this->SubCat->EditAttrs["class"] = "form-control";
			$this->SubCat->EditCustomAttributes = "";
			$this->SubCat->EditValue = ew_HtmlEncode($this->SubCat->CurrentValue);
			$this->SubCat->PlaceHolder = ew_RemoveHtml($this->SubCat->FldCaption());

			// Location
			$this->Location->EditAttrs["class"] = "form-control";
			$this->Location->EditCustomAttributes = "";
			$this->Location->EditValue = ew_HtmlEncode($this->Location->CurrentValue);
			$this->Location->PlaceHolder = ew_RemoveHtml($this->Location->FldCaption());

			// Dialog
			$this->Dialog->EditAttrs["class"] = "form-control";
			$this->Dialog->EditCustomAttributes = "";
			$this->Dialog->EditValue = ew_HtmlEncode($this->Dialog->CurrentValue);
			$this->Dialog->PlaceHolder = ew_RemoveHtml($this->Dialog->FldCaption());

			// Function
			$this->Function->EditAttrs["class"] = "form-control";
			$this->Function->EditCustomAttributes = "";
			$this->Function->EditValue = ew_HtmlEncode($this->Function->CurrentValue);
			$this->Function->PlaceHolder = ew_RemoveHtml($this->Function->FldCaption());

			// MasterName
			$this->MasterName->EditAttrs["class"] = "form-control";
			$this->MasterName->EditCustomAttributes = "";
			$this->MasterName->EditValue = ew_HtmlEncode($this->MasterName->CurrentValue);
			$this->MasterName->PlaceHolder = ew_RemoveHtml($this->MasterName->FldCaption());

			// HP
			$this->HP->EditAttrs["class"] = "form-control";
			$this->HP->EditCustomAttributes = "";
			$this->HP->EditValue = ew_HtmlEncode($this->HP->CurrentValue);
			$this->HP->PlaceHolder = ew_RemoveHtml($this->HP->FldCaption());

			// MAX_HP
			$this->MAX_HP->EditAttrs["class"] = "form-control";
			$this->MAX_HP->EditCustomAttributes = "";
			$this->MAX_HP->EditValue = ew_HtmlEncode($this->MAX_HP->CurrentValue);
			$this->MAX_HP->PlaceHolder = ew_RemoveHtml($this->MAX_HP->FldCaption());

			// UD1
			$this->UD1->EditAttrs["class"] = "form-control";
			$this->UD1->EditCustomAttributes = "";
			$this->UD1->EditValue = ew_HtmlEncode($this->UD1->CurrentValue);
			$this->UD1->PlaceHolder = ew_RemoveHtml($this->UD1->FldCaption());

			// UD2
			$this->UD2->EditAttrs["class"] = "form-control";
			$this->UD2->EditCustomAttributes = "";
			$this->UD2->EditValue = ew_HtmlEncode($this->UD2->CurrentValue);
			$this->UD2->PlaceHolder = ew_RemoveHtml($this->UD2->FldCaption());

			// UD3
			$this->UD3->EditAttrs["class"] = "form-control";
			$this->UD3->EditCustomAttributes = "";
			$this->UD3->EditValue = ew_HtmlEncode($this->UD3->CurrentValue);
			$this->UD3->PlaceHolder = ew_RemoveHtml($this->UD3->FldCaption());

			// UD4
			$this->UD4->EditAttrs["class"] = "form-control";
			$this->UD4->EditCustomAttributes = "";
			$this->UD4->EditValue = ew_HtmlEncode($this->UD4->CurrentValue);
			$this->UD4->PlaceHolder = ew_RemoveHtml($this->UD4->FldCaption());

			// UD5
			$this->UD5->EditAttrs["class"] = "form-control";
			$this->UD5->EditCustomAttributes = "";
			$this->UD5->EditValue = ew_HtmlEncode($this->UD5->CurrentValue);
			$this->UD5->PlaceHolder = ew_RemoveHtml($this->UD5->FldCaption());

			// UD6
			$this->UD6->EditAttrs["class"] = "form-control";
			$this->UD6->EditCustomAttributes = "";
			$this->UD6->EditValue = ew_HtmlEncode($this->UD6->CurrentValue);
			$this->UD6->PlaceHolder = ew_RemoveHtml($this->UD6->FldCaption());

			// UD7
			$this->UD7->EditAttrs["class"] = "form-control";
			$this->UD7->EditCustomAttributes = "";
			$this->UD7->EditValue = ew_HtmlEncode($this->UD7->CurrentValue);
			$this->UD7->PlaceHolder = ew_RemoveHtml($this->UD7->FldCaption());

			// UD8
			$this->UD8->EditAttrs["class"] = "form-control";
			$this->UD8->EditCustomAttributes = "";
			$this->UD8->EditValue = ew_HtmlEncode($this->UD8->CurrentValue);
			$this->UD8->PlaceHolder = ew_RemoveHtml($this->UD8->FldCaption());

			// UD9
			$this->UD9->EditAttrs["class"] = "form-control";
			$this->UD9->EditCustomAttributes = "";
			$this->UD9->EditValue = ew_HtmlEncode($this->UD9->CurrentValue);
			$this->UD9->PlaceHolder = ew_RemoveHtml($this->UD9->FldCaption());

			// UD10
			$this->UD10->EditAttrs["class"] = "form-control";
			$this->UD10->EditCustomAttributes = "";
			$this->UD10->EditValue = ew_HtmlEncode($this->UD10->CurrentValue);
			$this->UD10->PlaceHolder = ew_RemoveHtml($this->UD10->FldCaption());

			// UD11
			$this->UD11->EditAttrs["class"] = "form-control";
			$this->UD11->EditCustomAttributes = "";
			$this->UD11->EditValue = ew_HtmlEncode($this->UD11->CurrentValue);
			$this->UD11->PlaceHolder = ew_RemoveHtml($this->UD11->FldCaption());

			// UD12
			$this->UD12->EditAttrs["class"] = "form-control";
			$this->UD12->EditCustomAttributes = "";
			$this->UD12->EditValue = ew_HtmlEncode($this->UD12->CurrentValue);
			$this->UD12->PlaceHolder = ew_RemoveHtml($this->UD12->FldCaption());

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

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";

			// MainCat
			$this->MainCat->LinkCustomAttributes = "";
			$this->MainCat->HrefValue = "";

			// SubCat
			$this->SubCat->LinkCustomAttributes = "";
			$this->SubCat->HrefValue = "";

			// Location
			$this->Location->LinkCustomAttributes = "";
			$this->Location->HrefValue = "";

			// Dialog
			$this->Dialog->LinkCustomAttributes = "";
			$this->Dialog->HrefValue = "";

			// Function
			$this->Function->LinkCustomAttributes = "";
			$this->Function->HrefValue = "";

			// MasterName
			$this->MasterName->LinkCustomAttributes = "";
			$this->MasterName->HrefValue = "";

			// HP
			$this->HP->LinkCustomAttributes = "";
			$this->HP->HrefValue = "";

			// MAX_HP
			$this->MAX_HP->LinkCustomAttributes = "";
			$this->MAX_HP->HrefValue = "";

			// UD1
			$this->UD1->LinkCustomAttributes = "";
			$this->UD1->HrefValue = "";

			// UD2
			$this->UD2->LinkCustomAttributes = "";
			$this->UD2->HrefValue = "";

			// UD3
			$this->UD3->LinkCustomAttributes = "";
			$this->UD3->HrefValue = "";

			// UD4
			$this->UD4->LinkCustomAttributes = "";
			$this->UD4->HrefValue = "";

			// UD5
			$this->UD5->LinkCustomAttributes = "";
			$this->UD5->HrefValue = "";

			// UD6
			$this->UD6->LinkCustomAttributes = "";
			$this->UD6->HrefValue = "";

			// UD7
			$this->UD7->LinkCustomAttributes = "";
			$this->UD7->HrefValue = "";

			// UD8
			$this->UD8->LinkCustomAttributes = "";
			$this->UD8->HrefValue = "";

			// UD9
			$this->UD9->LinkCustomAttributes = "";
			$this->UD9->HrefValue = "";

			// UD10
			$this->UD10->LinkCustomAttributes = "";
			$this->UD10->HrefValue = "";

			// UD11
			$this->UD11->LinkCustomAttributes = "";
			$this->UD11->HrefValue = "";

			// UD12
			$this->UD12->LinkCustomAttributes = "";
			$this->UD12->HrefValue = "";

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
		if (!$this->LV->FldIsDetailKey && !is_null($this->LV->FormValue) && $this->LV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->LV->FldCaption(), $this->LV->ReqErrMsg));
		}
		if (!$this->MainCat->FldIsDetailKey && !is_null($this->MainCat->FormValue) && $this->MainCat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->MainCat->FldCaption(), $this->MainCat->ReqErrMsg));
		}
		if (!$this->SubCat->FldIsDetailKey && !is_null($this->SubCat->FormValue) && $this->SubCat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->SubCat->FldCaption(), $this->SubCat->ReqErrMsg));
		}
		if (!$this->Location->FldIsDetailKey && !is_null($this->Location->FormValue) && $this->Location->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Location->FldCaption(), $this->Location->ReqErrMsg));
		}
		if (!$this->Dialog->FldIsDetailKey && !is_null($this->Dialog->FormValue) && $this->Dialog->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dialog->FldCaption(), $this->Dialog->ReqErrMsg));
		}
		if (!$this->Function->FldIsDetailKey && !is_null($this->Function->FormValue) && $this->Function->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Function->FldCaption(), $this->Function->ReqErrMsg));
		}
		if (!$this->MasterName->FldIsDetailKey && !is_null($this->MasterName->FormValue) && $this->MasterName->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->MasterName->FldCaption(), $this->MasterName->ReqErrMsg));
		}
		if (!$this->HP->FldIsDetailKey && !is_null($this->HP->FormValue) && $this->HP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->HP->FldCaption(), $this->HP->ReqErrMsg));
		}
		if (!$this->MAX_HP->FldIsDetailKey && !is_null($this->MAX_HP->FormValue) && $this->MAX_HP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->MAX_HP->FldCaption(), $this->MAX_HP->ReqErrMsg));
		}
		if (!$this->UD1->FldIsDetailKey && !is_null($this->UD1->FormValue) && $this->UD1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD1->FldCaption(), $this->UD1->ReqErrMsg));
		}
		if (!$this->UD2->FldIsDetailKey && !is_null($this->UD2->FormValue) && $this->UD2->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD2->FldCaption(), $this->UD2->ReqErrMsg));
		}
		if (!$this->UD3->FldIsDetailKey && !is_null($this->UD3->FormValue) && $this->UD3->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD3->FldCaption(), $this->UD3->ReqErrMsg));
		}
		if (!$this->UD4->FldIsDetailKey && !is_null($this->UD4->FormValue) && $this->UD4->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD4->FldCaption(), $this->UD4->ReqErrMsg));
		}
		if (!$this->UD5->FldIsDetailKey && !is_null($this->UD5->FormValue) && $this->UD5->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD5->FldCaption(), $this->UD5->ReqErrMsg));
		}
		if (!$this->UD6->FldIsDetailKey && !is_null($this->UD6->FormValue) && $this->UD6->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD6->FldCaption(), $this->UD6->ReqErrMsg));
		}
		if (!$this->UD7->FldIsDetailKey && !is_null($this->UD7->FormValue) && $this->UD7->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD7->FldCaption(), $this->UD7->ReqErrMsg));
		}
		if (!$this->UD8->FldIsDetailKey && !is_null($this->UD8->FormValue) && $this->UD8->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD8->FldCaption(), $this->UD8->ReqErrMsg));
		}
		if (!$this->UD9->FldIsDetailKey && !is_null($this->UD9->FormValue) && $this->UD9->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD9->FldCaption(), $this->UD9->ReqErrMsg));
		}
		if (!$this->UD10->FldIsDetailKey && !is_null($this->UD10->FormValue) && $this->UD10->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD10->FldCaption(), $this->UD10->ReqErrMsg));
		}
		if (!$this->UD11->FldIsDetailKey && !is_null($this->UD11->FormValue) && $this->UD11->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD11->FldCaption(), $this->UD11->ReqErrMsg));
		}
		if (!$this->UD12->FldIsDetailKey && !is_null($this->UD12->FormValue) && $this->UD12->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD12->FldCaption(), $this->UD12->ReqErrMsg));
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

		// LV
		$this->LV->SetDbValueDef($rsnew, $this->LV->CurrentValue, "", FALSE);

		// MainCat
		$this->MainCat->SetDbValueDef($rsnew, $this->MainCat->CurrentValue, "", FALSE);

		// SubCat
		$this->SubCat->SetDbValueDef($rsnew, $this->SubCat->CurrentValue, "", FALSE);

		// Location
		$this->Location->SetDbValueDef($rsnew, $this->Location->CurrentValue, "", FALSE);

		// Dialog
		$this->Dialog->SetDbValueDef($rsnew, $this->Dialog->CurrentValue, "", FALSE);

		// Function
		$this->Function->SetDbValueDef($rsnew, $this->Function->CurrentValue, "", FALSE);

		// MasterName
		$this->MasterName->SetDbValueDef($rsnew, $this->MasterName->CurrentValue, "", FALSE);

		// HP
		$this->HP->SetDbValueDef($rsnew, $this->HP->CurrentValue, "", FALSE);

		// MAX_HP
		$this->MAX_HP->SetDbValueDef($rsnew, $this->MAX_HP->CurrentValue, "", FALSE);

		// UD1
		$this->UD1->SetDbValueDef($rsnew, $this->UD1->CurrentValue, "", FALSE);

		// UD2
		$this->UD2->SetDbValueDef($rsnew, $this->UD2->CurrentValue, "", FALSE);

		// UD3
		$this->UD3->SetDbValueDef($rsnew, $this->UD3->CurrentValue, "", FALSE);

		// UD4
		$this->UD4->SetDbValueDef($rsnew, $this->UD4->CurrentValue, "", FALSE);

		// UD5
		$this->UD5->SetDbValueDef($rsnew, $this->UD5->CurrentValue, "", FALSE);

		// UD6
		$this->UD6->SetDbValueDef($rsnew, $this->UD6->CurrentValue, "", FALSE);

		// UD7
		$this->UD7->SetDbValueDef($rsnew, $this->UD7->CurrentValue, "", FALSE);

		// UD8
		$this->UD8->SetDbValueDef($rsnew, $this->UD8->CurrentValue, "", FALSE);

		// UD9
		$this->UD9->SetDbValueDef($rsnew, $this->UD9->CurrentValue, "", FALSE);

		// UD10
		$this->UD10->SetDbValueDef($rsnew, $this->UD10->CurrentValue, "", FALSE);

		// UD11
		$this->UD11->SetDbValueDef($rsnew, $this->UD11->CurrentValue, "", FALSE);

		// UD12
		$this->UD12->SetDbValueDef($rsnew, $this->UD12->CurrentValue, "", FALSE);

		// Introduce
		$this->Introduce->SetDbValueDef($rsnew, $this->Introduce->CurrentValue, "", FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ext_sam_user_infolist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ext_sam_user_info_add)) $ext_sam_user_info_add = new cext_sam_user_info_add();

// Page init
$ext_sam_user_info_add->Page_Init();

// Page main
$ext_sam_user_info_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ext_sam_user_info_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fext_sam_user_infoadd = new ew_Form("fext_sam_user_infoadd", "add");

// Validate form
fext_sam_user_infoadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->u_id->FldCaption(), $ext_sam_user_info->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_sam_user_info->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->acl_id->FldCaption(), $ext_sam_user_info->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_sam_user_info->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->Name->FldCaption(), $ext_sam_user_info->Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->LV->FldCaption(), $ext_sam_user_info->LV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_MainCat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->MainCat->FldCaption(), $ext_sam_user_info->MainCat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_SubCat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->SubCat->FldCaption(), $ext_sam_user_info->SubCat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Location");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->Location->FldCaption(), $ext_sam_user_info->Location->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dialog");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->Dialog->FldCaption(), $ext_sam_user_info->Dialog->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Function");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->Function->FldCaption(), $ext_sam_user_info->Function->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_MasterName");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->MasterName->FldCaption(), $ext_sam_user_info->MasterName->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_HP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->HP->FldCaption(), $ext_sam_user_info->HP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_MAX_HP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->MAX_HP->FldCaption(), $ext_sam_user_info->MAX_HP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD1->FldCaption(), $ext_sam_user_info->UD1->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD2");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD2->FldCaption(), $ext_sam_user_info->UD2->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD3");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD3->FldCaption(), $ext_sam_user_info->UD3->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD4");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD4->FldCaption(), $ext_sam_user_info->UD4->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD5");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD5->FldCaption(), $ext_sam_user_info->UD5->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD6");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD6->FldCaption(), $ext_sam_user_info->UD6->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD7");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD7->FldCaption(), $ext_sam_user_info->UD7->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD8");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD8->FldCaption(), $ext_sam_user_info->UD8->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD9");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD9->FldCaption(), $ext_sam_user_info->UD9->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD10");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD10->FldCaption(), $ext_sam_user_info->UD10->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD11");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD11->FldCaption(), $ext_sam_user_info->UD11->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD12");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->UD12->FldCaption(), $ext_sam_user_info->UD12->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Introduce");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->Introduce->FldCaption(), $ext_sam_user_info->Introduce->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_user_info->DATETIME->FldCaption(), $ext_sam_user_info->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_sam_user_info->DATETIME->FldErrMsg()) ?>");

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
fext_sam_user_infoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fext_sam_user_infoadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $ext_sam_user_info_add->ShowPageHeader(); ?>
<?php
$ext_sam_user_info_add->ShowMessage();
?>
<form name="fext_sam_user_infoadd" id="fext_sam_user_infoadd" class="<?php echo $ext_sam_user_info_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ext_sam_user_info_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ext_sam_user_info_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ext_sam_user_info">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($ext_sam_user_info_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($ext_sam_user_info->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_ext_sam_user_info_u_id" for="x_u_id" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->u_id->CellAttributes() ?>>
<span id="el_ext_sam_user_info_u_id">
<input type="text" data-table="ext_sam_user_info" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->u_id->getPlaceHolder()) ?>" value="<?php echo $ext_sam_user_info->u_id->EditValue ?>"<?php echo $ext_sam_user_info->u_id->EditAttributes() ?>>
</span>
<?php echo $ext_sam_user_info->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_ext_sam_user_info_acl_id" for="x_acl_id" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->acl_id->CellAttributes() ?>>
<span id="el_ext_sam_user_info_acl_id">
<input type="text" data-table="ext_sam_user_info" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->acl_id->getPlaceHolder()) ?>" value="<?php echo $ext_sam_user_info->acl_id->EditValue ?>"<?php echo $ext_sam_user_info->acl_id->EditAttributes() ?>>
</span>
<?php echo $ext_sam_user_info->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->Name->Visible) { // Name ?>
	<div id="r_Name" class="form-group">
		<label id="elh_ext_sam_user_info_Name" for="x_Name" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->Name->CellAttributes() ?>>
<span id="el_ext_sam_user_info_Name">
<textarea data-table="ext_sam_user_info" data-field="x_Name" name="x_Name" id="x_Name" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->Name->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->Name->EditAttributes() ?>><?php echo $ext_sam_user_info->Name->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->LV->Visible) { // LV ?>
	<div id="r_LV" class="form-group">
		<label id="elh_ext_sam_user_info_LV" for="x_LV" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->LV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->LV->CellAttributes() ?>>
<span id="el_ext_sam_user_info_LV">
<textarea data-table="ext_sam_user_info" data-field="x_LV" name="x_LV" id="x_LV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->LV->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->LV->EditAttributes() ?>><?php echo $ext_sam_user_info->LV->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->LV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->MainCat->Visible) { // MainCat ?>
	<div id="r_MainCat" class="form-group">
		<label id="elh_ext_sam_user_info_MainCat" for="x_MainCat" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->MainCat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->MainCat->CellAttributes() ?>>
<span id="el_ext_sam_user_info_MainCat">
<textarea data-table="ext_sam_user_info" data-field="x_MainCat" name="x_MainCat" id="x_MainCat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->MainCat->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->MainCat->EditAttributes() ?>><?php echo $ext_sam_user_info->MainCat->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->MainCat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->SubCat->Visible) { // SubCat ?>
	<div id="r_SubCat" class="form-group">
		<label id="elh_ext_sam_user_info_SubCat" for="x_SubCat" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->SubCat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->SubCat->CellAttributes() ?>>
<span id="el_ext_sam_user_info_SubCat">
<textarea data-table="ext_sam_user_info" data-field="x_SubCat" name="x_SubCat" id="x_SubCat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->SubCat->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->SubCat->EditAttributes() ?>><?php echo $ext_sam_user_info->SubCat->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->SubCat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->Location->Visible) { // Location ?>
	<div id="r_Location" class="form-group">
		<label id="elh_ext_sam_user_info_Location" for="x_Location" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->Location->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->Location->CellAttributes() ?>>
<span id="el_ext_sam_user_info_Location">
<textarea data-table="ext_sam_user_info" data-field="x_Location" name="x_Location" id="x_Location" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->Location->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->Location->EditAttributes() ?>><?php echo $ext_sam_user_info->Location->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->Location->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->Dialog->Visible) { // Dialog ?>
	<div id="r_Dialog" class="form-group">
		<label id="elh_ext_sam_user_info_Dialog" for="x_Dialog" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->Dialog->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->Dialog->CellAttributes() ?>>
<span id="el_ext_sam_user_info_Dialog">
<textarea data-table="ext_sam_user_info" data-field="x_Dialog" name="x_Dialog" id="x_Dialog" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->Dialog->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->Dialog->EditAttributes() ?>><?php echo $ext_sam_user_info->Dialog->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->Dialog->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->Function->Visible) { // Function ?>
	<div id="r_Function" class="form-group">
		<label id="elh_ext_sam_user_info_Function" for="x_Function" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->Function->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->Function->CellAttributes() ?>>
<span id="el_ext_sam_user_info_Function">
<textarea data-table="ext_sam_user_info" data-field="x_Function" name="x_Function" id="x_Function" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->Function->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->Function->EditAttributes() ?>><?php echo $ext_sam_user_info->Function->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->Function->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->MasterName->Visible) { // MasterName ?>
	<div id="r_MasterName" class="form-group">
		<label id="elh_ext_sam_user_info_MasterName" for="x_MasterName" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->MasterName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->MasterName->CellAttributes() ?>>
<span id="el_ext_sam_user_info_MasterName">
<textarea data-table="ext_sam_user_info" data-field="x_MasterName" name="x_MasterName" id="x_MasterName" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->MasterName->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->MasterName->EditAttributes() ?>><?php echo $ext_sam_user_info->MasterName->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->MasterName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->HP->Visible) { // HP ?>
	<div id="r_HP" class="form-group">
		<label id="elh_ext_sam_user_info_HP" for="x_HP" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->HP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->HP->CellAttributes() ?>>
<span id="el_ext_sam_user_info_HP">
<textarea data-table="ext_sam_user_info" data-field="x_HP" name="x_HP" id="x_HP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->HP->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->HP->EditAttributes() ?>><?php echo $ext_sam_user_info->HP->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->HP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->MAX_HP->Visible) { // MAX_HP ?>
	<div id="r_MAX_HP" class="form-group">
		<label id="elh_ext_sam_user_info_MAX_HP" for="x_MAX_HP" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->MAX_HP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->MAX_HP->CellAttributes() ?>>
<span id="el_ext_sam_user_info_MAX_HP">
<textarea data-table="ext_sam_user_info" data-field="x_MAX_HP" name="x_MAX_HP" id="x_MAX_HP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->MAX_HP->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->MAX_HP->EditAttributes() ?>><?php echo $ext_sam_user_info->MAX_HP->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->MAX_HP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD1->Visible) { // UD1 ?>
	<div id="r_UD1" class="form-group">
		<label id="elh_ext_sam_user_info_UD1" for="x_UD1" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD1->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD1">
<textarea data-table="ext_sam_user_info" data-field="x_UD1" name="x_UD1" id="x_UD1" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD1->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD1->EditAttributes() ?>><?php echo $ext_sam_user_info->UD1->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD2->Visible) { // UD2 ?>
	<div id="r_UD2" class="form-group">
		<label id="elh_ext_sam_user_info_UD2" for="x_UD2" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD2->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD2->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD2">
<textarea data-table="ext_sam_user_info" data-field="x_UD2" name="x_UD2" id="x_UD2" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD2->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD2->EditAttributes() ?>><?php echo $ext_sam_user_info->UD2->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD3->Visible) { // UD3 ?>
	<div id="r_UD3" class="form-group">
		<label id="elh_ext_sam_user_info_UD3" for="x_UD3" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD3->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD3->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD3">
<textarea data-table="ext_sam_user_info" data-field="x_UD3" name="x_UD3" id="x_UD3" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD3->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD3->EditAttributes() ?>><?php echo $ext_sam_user_info->UD3->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD4->Visible) { // UD4 ?>
	<div id="r_UD4" class="form-group">
		<label id="elh_ext_sam_user_info_UD4" for="x_UD4" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD4->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD4->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD4">
<textarea data-table="ext_sam_user_info" data-field="x_UD4" name="x_UD4" id="x_UD4" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD4->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD4->EditAttributes() ?>><?php echo $ext_sam_user_info->UD4->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD5->Visible) { // UD5 ?>
	<div id="r_UD5" class="form-group">
		<label id="elh_ext_sam_user_info_UD5" for="x_UD5" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD5->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD5->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD5">
<textarea data-table="ext_sam_user_info" data-field="x_UD5" name="x_UD5" id="x_UD5" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD5->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD5->EditAttributes() ?>><?php echo $ext_sam_user_info->UD5->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD6->Visible) { // UD6 ?>
	<div id="r_UD6" class="form-group">
		<label id="elh_ext_sam_user_info_UD6" for="x_UD6" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD6->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD6->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD6">
<textarea data-table="ext_sam_user_info" data-field="x_UD6" name="x_UD6" id="x_UD6" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD6->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD6->EditAttributes() ?>><?php echo $ext_sam_user_info->UD6->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD6->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD7->Visible) { // UD7 ?>
	<div id="r_UD7" class="form-group">
		<label id="elh_ext_sam_user_info_UD7" for="x_UD7" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD7->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD7->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD7">
<textarea data-table="ext_sam_user_info" data-field="x_UD7" name="x_UD7" id="x_UD7" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD7->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD7->EditAttributes() ?>><?php echo $ext_sam_user_info->UD7->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD7->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD8->Visible) { // UD8 ?>
	<div id="r_UD8" class="form-group">
		<label id="elh_ext_sam_user_info_UD8" for="x_UD8" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD8->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD8->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD8">
<textarea data-table="ext_sam_user_info" data-field="x_UD8" name="x_UD8" id="x_UD8" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD8->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD8->EditAttributes() ?>><?php echo $ext_sam_user_info->UD8->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD8->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD9->Visible) { // UD9 ?>
	<div id="r_UD9" class="form-group">
		<label id="elh_ext_sam_user_info_UD9" for="x_UD9" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD9->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD9->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD9">
<textarea data-table="ext_sam_user_info" data-field="x_UD9" name="x_UD9" id="x_UD9" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD9->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD9->EditAttributes() ?>><?php echo $ext_sam_user_info->UD9->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD9->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD10->Visible) { // UD10 ?>
	<div id="r_UD10" class="form-group">
		<label id="elh_ext_sam_user_info_UD10" for="x_UD10" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD10->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD10->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD10">
<textarea data-table="ext_sam_user_info" data-field="x_UD10" name="x_UD10" id="x_UD10" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD10->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD10->EditAttributes() ?>><?php echo $ext_sam_user_info->UD10->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD10->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD11->Visible) { // UD11 ?>
	<div id="r_UD11" class="form-group">
		<label id="elh_ext_sam_user_info_UD11" for="x_UD11" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD11->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD11->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD11">
<textarea data-table="ext_sam_user_info" data-field="x_UD11" name="x_UD11" id="x_UD11" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD11->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD11->EditAttributes() ?>><?php echo $ext_sam_user_info->UD11->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD11->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->UD12->Visible) { // UD12 ?>
	<div id="r_UD12" class="form-group">
		<label id="elh_ext_sam_user_info_UD12" for="x_UD12" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->UD12->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->UD12->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD12">
<textarea data-table="ext_sam_user_info" data-field="x_UD12" name="x_UD12" id="x_UD12" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->UD12->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->UD12->EditAttributes() ?>><?php echo $ext_sam_user_info->UD12->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->UD12->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->Introduce->Visible) { // Introduce ?>
	<div id="r_Introduce" class="form-group">
		<label id="elh_ext_sam_user_info_Introduce" for="x_Introduce" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->Introduce->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->Introduce->CellAttributes() ?>>
<span id="el_ext_sam_user_info_Introduce">
<textarea data-table="ext_sam_user_info" data-field="x_Introduce" name="x_Introduce" id="x_Introduce" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->Introduce->getPlaceHolder()) ?>"<?php echo $ext_sam_user_info->Introduce->EditAttributes() ?>><?php echo $ext_sam_user_info->Introduce->EditValue ?></textarea>
</span>
<?php echo $ext_sam_user_info->Introduce->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_user_info->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_ext_sam_user_info_DATETIME" for="x_DATETIME" class="<?php echo $ext_sam_user_info_add->LeftColumnClass ?>"><?php echo $ext_sam_user_info->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_user_info_add->RightColumnClass ?>"><div<?php echo $ext_sam_user_info->DATETIME->CellAttributes() ?>>
<span id="el_ext_sam_user_info_DATETIME">
<input type="text" data-table="ext_sam_user_info" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($ext_sam_user_info->DATETIME->getPlaceHolder()) ?>" value="<?php echo $ext_sam_user_info->DATETIME->EditValue ?>"<?php echo $ext_sam_user_info->DATETIME->EditAttributes() ?>>
</span>
<?php echo $ext_sam_user_info->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$ext_sam_user_info_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $ext_sam_user_info_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ext_sam_user_info_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fext_sam_user_infoadd.Init();
</script>
<?php
$ext_sam_user_info_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ext_sam_user_info_add->Page_Terminate();
?>
