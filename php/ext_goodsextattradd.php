<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ext_goodsextattrinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$ext_goodsextattr_add = NULL; // Initialize page object first

class cext_goodsextattr_add extends cext_goodsextattr {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'ext_goodsextattr';

	// Page object name
	var $PageObjName = 'ext_goodsextattr_add';

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

		// Table object (ext_goodsextattr)
		if (!isset($GLOBALS["ext_goodsextattr"]) || get_class($GLOBALS["ext_goodsextattr"]) == "cext_goodsextattr") {
			$GLOBALS["ext_goodsextattr"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ext_goodsextattr"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ext_goodsextattr', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ext_goodsextattrlist.php"));
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
		$this->PriceNum->SetVisibility();
		$this->PriceType->SetVisibility();
		$this->UD_qualityNum->SetVisibility();
		$this->UD_cat->SetVisibility();
		$this->UD_qualityType->SetVisibility();
		$this->UD_kv4->SetVisibility();
		$this->UD_kv5->SetVisibility();
		$this->UD_kv6->SetVisibility();
		$this->UD_kv7->SetVisibility();
		$this->UD_kv8->SetVisibility();
		$this->UD_kv9->SetVisibility();
		$this->UD_kv10->SetVisibility();
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
		global $EW_EXPORT, $ext_goodsextattr;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ext_goodsextattr);
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
					if ($pageName == "ext_goodsextattrview.php")
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
					$this->Page_Terminate("ext_goodsextattrlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ext_goodsextattrlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "ext_goodsextattrview.php")
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
		$this->PriceNum->CurrentValue = NULL;
		$this->PriceNum->OldValue = $this->PriceNum->CurrentValue;
		$this->PriceType->CurrentValue = NULL;
		$this->PriceType->OldValue = $this->PriceType->CurrentValue;
		$this->UD_qualityNum->CurrentValue = NULL;
		$this->UD_qualityNum->OldValue = $this->UD_qualityNum->CurrentValue;
		$this->UD_cat->CurrentValue = NULL;
		$this->UD_cat->OldValue = $this->UD_cat->CurrentValue;
		$this->UD_qualityType->CurrentValue = NULL;
		$this->UD_qualityType->OldValue = $this->UD_qualityType->CurrentValue;
		$this->UD_kv4->CurrentValue = NULL;
		$this->UD_kv4->OldValue = $this->UD_kv4->CurrentValue;
		$this->UD_kv5->CurrentValue = NULL;
		$this->UD_kv5->OldValue = $this->UD_kv5->CurrentValue;
		$this->UD_kv6->CurrentValue = NULL;
		$this->UD_kv6->OldValue = $this->UD_kv6->CurrentValue;
		$this->UD_kv7->CurrentValue = NULL;
		$this->UD_kv7->OldValue = $this->UD_kv7->CurrentValue;
		$this->UD_kv8->CurrentValue = NULL;
		$this->UD_kv8->OldValue = $this->UD_kv8->CurrentValue;
		$this->UD_kv9->CurrentValue = NULL;
		$this->UD_kv9->OldValue = $this->UD_kv9->CurrentValue;
		$this->UD_kv10->CurrentValue = NULL;
		$this->UD_kv10->OldValue = $this->UD_kv10->CurrentValue;
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
		if (!$this->PriceNum->FldIsDetailKey) {
			$this->PriceNum->setFormValue($objForm->GetValue("x_PriceNum"));
		}
		if (!$this->PriceType->FldIsDetailKey) {
			$this->PriceType->setFormValue($objForm->GetValue("x_PriceType"));
		}
		if (!$this->UD_qualityNum->FldIsDetailKey) {
			$this->UD_qualityNum->setFormValue($objForm->GetValue("x_UD_qualityNum"));
		}
		if (!$this->UD_cat->FldIsDetailKey) {
			$this->UD_cat->setFormValue($objForm->GetValue("x_UD_cat"));
		}
		if (!$this->UD_qualityType->FldIsDetailKey) {
			$this->UD_qualityType->setFormValue($objForm->GetValue("x_UD_qualityType"));
		}
		if (!$this->UD_kv4->FldIsDetailKey) {
			$this->UD_kv4->setFormValue($objForm->GetValue("x_UD_kv4"));
		}
		if (!$this->UD_kv5->FldIsDetailKey) {
			$this->UD_kv5->setFormValue($objForm->GetValue("x_UD_kv5"));
		}
		if (!$this->UD_kv6->FldIsDetailKey) {
			$this->UD_kv6->setFormValue($objForm->GetValue("x_UD_kv6"));
		}
		if (!$this->UD_kv7->FldIsDetailKey) {
			$this->UD_kv7->setFormValue($objForm->GetValue("x_UD_kv7"));
		}
		if (!$this->UD_kv8->FldIsDetailKey) {
			$this->UD_kv8->setFormValue($objForm->GetValue("x_UD_kv8"));
		}
		if (!$this->UD_kv9->FldIsDetailKey) {
			$this->UD_kv9->setFormValue($objForm->GetValue("x_UD_kv9"));
		}
		if (!$this->UD_kv10->FldIsDetailKey) {
			$this->UD_kv10->setFormValue($objForm->GetValue("x_UD_kv10"));
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
		$this->PriceNum->CurrentValue = $this->PriceNum->FormValue;
		$this->PriceType->CurrentValue = $this->PriceType->FormValue;
		$this->UD_qualityNum->CurrentValue = $this->UD_qualityNum->FormValue;
		$this->UD_cat->CurrentValue = $this->UD_cat->FormValue;
		$this->UD_qualityType->CurrentValue = $this->UD_qualityType->FormValue;
		$this->UD_kv4->CurrentValue = $this->UD_kv4->FormValue;
		$this->UD_kv5->CurrentValue = $this->UD_kv5->FormValue;
		$this->UD_kv6->CurrentValue = $this->UD_kv6->FormValue;
		$this->UD_kv7->CurrentValue = $this->UD_kv7->FormValue;
		$this->UD_kv8->CurrentValue = $this->UD_kv8->FormValue;
		$this->UD_kv9->CurrentValue = $this->UD_kv9->FormValue;
		$this->UD_kv10->CurrentValue = $this->UD_kv10->FormValue;
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
		$this->PriceNum->setDbValue($row['PriceNum']);
		$this->PriceType->setDbValue($row['PriceType']);
		$this->UD_qualityNum->setDbValue($row['UD_qualityNum']);
		$this->UD_cat->setDbValue($row['UD_cat']);
		$this->UD_qualityType->setDbValue($row['UD_qualityType']);
		$this->UD_kv4->setDbValue($row['UD_kv4']);
		$this->UD_kv5->setDbValue($row['UD_kv5']);
		$this->UD_kv6->setDbValue($row['UD_kv6']);
		$this->UD_kv7->setDbValue($row['UD_kv7']);
		$this->UD_kv8->setDbValue($row['UD_kv8']);
		$this->UD_kv9->setDbValue($row['UD_kv9']);
		$this->UD_kv10->setDbValue($row['UD_kv10']);
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
		$row['PriceNum'] = $this->PriceNum->CurrentValue;
		$row['PriceType'] = $this->PriceType->CurrentValue;
		$row['UD_qualityNum'] = $this->UD_qualityNum->CurrentValue;
		$row['UD_cat'] = $this->UD_cat->CurrentValue;
		$row['UD_qualityType'] = $this->UD_qualityType->CurrentValue;
		$row['UD_kv4'] = $this->UD_kv4->CurrentValue;
		$row['UD_kv5'] = $this->UD_kv5->CurrentValue;
		$row['UD_kv6'] = $this->UD_kv6->CurrentValue;
		$row['UD_kv7'] = $this->UD_kv7->CurrentValue;
		$row['UD_kv8'] = $this->UD_kv8->CurrentValue;
		$row['UD_kv9'] = $this->UD_kv9->CurrentValue;
		$row['UD_kv10'] = $this->UD_kv10->CurrentValue;
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
		$this->PriceNum->DbValue = $row['PriceNum'];
		$this->PriceType->DbValue = $row['PriceType'];
		$this->UD_qualityNum->DbValue = $row['UD_qualityNum'];
		$this->UD_cat->DbValue = $row['UD_cat'];
		$this->UD_qualityType->DbValue = $row['UD_qualityType'];
		$this->UD_kv4->DbValue = $row['UD_kv4'];
		$this->UD_kv5->DbValue = $row['UD_kv5'];
		$this->UD_kv6->DbValue = $row['UD_kv6'];
		$this->UD_kv7->DbValue = $row['UD_kv7'];
		$this->UD_kv8->DbValue = $row['UD_kv8'];
		$this->UD_kv9->DbValue = $row['UD_kv9'];
		$this->UD_kv10->DbValue = $row['UD_kv10'];
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
		// PriceNum
		// PriceType
		// UD_qualityNum
		// UD_cat
		// UD_qualityType
		// UD_kv4
		// UD_kv5
		// UD_kv6
		// UD_kv7
		// UD_kv8
		// UD_kv9
		// UD_kv10
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

		// PriceNum
		$this->PriceNum->ViewValue = $this->PriceNum->CurrentValue;
		$this->PriceNum->ViewCustomAttributes = "";

		// PriceType
		$this->PriceType->ViewValue = $this->PriceType->CurrentValue;
		$this->PriceType->ViewCustomAttributes = "";

		// UD_qualityNum
		$this->UD_qualityNum->ViewValue = $this->UD_qualityNum->CurrentValue;
		$this->UD_qualityNum->ViewCustomAttributes = "";

		// UD_cat
		$this->UD_cat->ViewValue = $this->UD_cat->CurrentValue;
		$this->UD_cat->ViewCustomAttributes = "";

		// UD_qualityType
		$this->UD_qualityType->ViewValue = $this->UD_qualityType->CurrentValue;
		$this->UD_qualityType->ViewCustomAttributes = "";

		// UD_kv4
		$this->UD_kv4->ViewValue = $this->UD_kv4->CurrentValue;
		$this->UD_kv4->ViewCustomAttributes = "";

		// UD_kv5
		$this->UD_kv5->ViewValue = $this->UD_kv5->CurrentValue;
		$this->UD_kv5->ViewCustomAttributes = "";

		// UD_kv6
		$this->UD_kv6->ViewValue = $this->UD_kv6->CurrentValue;
		$this->UD_kv6->ViewCustomAttributes = "";

		// UD_kv7
		$this->UD_kv7->ViewValue = $this->UD_kv7->CurrentValue;
		$this->UD_kv7->ViewCustomAttributes = "";

		// UD_kv8
		$this->UD_kv8->ViewValue = $this->UD_kv8->CurrentValue;
		$this->UD_kv8->ViewCustomAttributes = "";

		// UD_kv9
		$this->UD_kv9->ViewValue = $this->UD_kv9->CurrentValue;
		$this->UD_kv9->ViewCustomAttributes = "";

		// UD_kv10
		$this->UD_kv10->ViewValue = $this->UD_kv10->CurrentValue;
		$this->UD_kv10->ViewCustomAttributes = "";

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

			// PriceNum
			$this->PriceNum->LinkCustomAttributes = "";
			$this->PriceNum->HrefValue = "";
			$this->PriceNum->TooltipValue = "";

			// PriceType
			$this->PriceType->LinkCustomAttributes = "";
			$this->PriceType->HrefValue = "";
			$this->PriceType->TooltipValue = "";

			// UD_qualityNum
			$this->UD_qualityNum->LinkCustomAttributes = "";
			$this->UD_qualityNum->HrefValue = "";
			$this->UD_qualityNum->TooltipValue = "";

			// UD_cat
			$this->UD_cat->LinkCustomAttributes = "";
			$this->UD_cat->HrefValue = "";
			$this->UD_cat->TooltipValue = "";

			// UD_qualityType
			$this->UD_qualityType->LinkCustomAttributes = "";
			$this->UD_qualityType->HrefValue = "";
			$this->UD_qualityType->TooltipValue = "";

			// UD_kv4
			$this->UD_kv4->LinkCustomAttributes = "";
			$this->UD_kv4->HrefValue = "";
			$this->UD_kv4->TooltipValue = "";

			// UD_kv5
			$this->UD_kv5->LinkCustomAttributes = "";
			$this->UD_kv5->HrefValue = "";
			$this->UD_kv5->TooltipValue = "";

			// UD_kv6
			$this->UD_kv6->LinkCustomAttributes = "";
			$this->UD_kv6->HrefValue = "";
			$this->UD_kv6->TooltipValue = "";

			// UD_kv7
			$this->UD_kv7->LinkCustomAttributes = "";
			$this->UD_kv7->HrefValue = "";
			$this->UD_kv7->TooltipValue = "";

			// UD_kv8
			$this->UD_kv8->LinkCustomAttributes = "";
			$this->UD_kv8->HrefValue = "";
			$this->UD_kv8->TooltipValue = "";

			// UD_kv9
			$this->UD_kv9->LinkCustomAttributes = "";
			$this->UD_kv9->HrefValue = "";
			$this->UD_kv9->TooltipValue = "";

			// UD_kv10
			$this->UD_kv10->LinkCustomAttributes = "";
			$this->UD_kv10->HrefValue = "";
			$this->UD_kv10->TooltipValue = "";

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

			// PriceNum
			$this->PriceNum->EditAttrs["class"] = "form-control";
			$this->PriceNum->EditCustomAttributes = "";
			$this->PriceNum->EditValue = ew_HtmlEncode($this->PriceNum->CurrentValue);
			$this->PriceNum->PlaceHolder = ew_RemoveHtml($this->PriceNum->FldCaption());

			// PriceType
			$this->PriceType->EditAttrs["class"] = "form-control";
			$this->PriceType->EditCustomAttributes = "";
			$this->PriceType->EditValue = ew_HtmlEncode($this->PriceType->CurrentValue);
			$this->PriceType->PlaceHolder = ew_RemoveHtml($this->PriceType->FldCaption());

			// UD_qualityNum
			$this->UD_qualityNum->EditAttrs["class"] = "form-control";
			$this->UD_qualityNum->EditCustomAttributes = "";
			$this->UD_qualityNum->EditValue = ew_HtmlEncode($this->UD_qualityNum->CurrentValue);
			$this->UD_qualityNum->PlaceHolder = ew_RemoveHtml($this->UD_qualityNum->FldCaption());

			// UD_cat
			$this->UD_cat->EditAttrs["class"] = "form-control";
			$this->UD_cat->EditCustomAttributes = "";
			$this->UD_cat->EditValue = ew_HtmlEncode($this->UD_cat->CurrentValue);
			$this->UD_cat->PlaceHolder = ew_RemoveHtml($this->UD_cat->FldCaption());

			// UD_qualityType
			$this->UD_qualityType->EditAttrs["class"] = "form-control";
			$this->UD_qualityType->EditCustomAttributes = "";
			$this->UD_qualityType->EditValue = ew_HtmlEncode($this->UD_qualityType->CurrentValue);
			$this->UD_qualityType->PlaceHolder = ew_RemoveHtml($this->UD_qualityType->FldCaption());

			// UD_kv4
			$this->UD_kv4->EditAttrs["class"] = "form-control";
			$this->UD_kv4->EditCustomAttributes = "";
			$this->UD_kv4->EditValue = ew_HtmlEncode($this->UD_kv4->CurrentValue);
			$this->UD_kv4->PlaceHolder = ew_RemoveHtml($this->UD_kv4->FldCaption());

			// UD_kv5
			$this->UD_kv5->EditAttrs["class"] = "form-control";
			$this->UD_kv5->EditCustomAttributes = "";
			$this->UD_kv5->EditValue = ew_HtmlEncode($this->UD_kv5->CurrentValue);
			$this->UD_kv5->PlaceHolder = ew_RemoveHtml($this->UD_kv5->FldCaption());

			// UD_kv6
			$this->UD_kv6->EditAttrs["class"] = "form-control";
			$this->UD_kv6->EditCustomAttributes = "";
			$this->UD_kv6->EditValue = ew_HtmlEncode($this->UD_kv6->CurrentValue);
			$this->UD_kv6->PlaceHolder = ew_RemoveHtml($this->UD_kv6->FldCaption());

			// UD_kv7
			$this->UD_kv7->EditAttrs["class"] = "form-control";
			$this->UD_kv7->EditCustomAttributes = "";
			$this->UD_kv7->EditValue = ew_HtmlEncode($this->UD_kv7->CurrentValue);
			$this->UD_kv7->PlaceHolder = ew_RemoveHtml($this->UD_kv7->FldCaption());

			// UD_kv8
			$this->UD_kv8->EditAttrs["class"] = "form-control";
			$this->UD_kv8->EditCustomAttributes = "";
			$this->UD_kv8->EditValue = ew_HtmlEncode($this->UD_kv8->CurrentValue);
			$this->UD_kv8->PlaceHolder = ew_RemoveHtml($this->UD_kv8->FldCaption());

			// UD_kv9
			$this->UD_kv9->EditAttrs["class"] = "form-control";
			$this->UD_kv9->EditCustomAttributes = "";
			$this->UD_kv9->EditValue = ew_HtmlEncode($this->UD_kv9->CurrentValue);
			$this->UD_kv9->PlaceHolder = ew_RemoveHtml($this->UD_kv9->FldCaption());

			// UD_kv10
			$this->UD_kv10->EditAttrs["class"] = "form-control";
			$this->UD_kv10->EditCustomAttributes = "";
			$this->UD_kv10->EditValue = ew_HtmlEncode($this->UD_kv10->CurrentValue);
			$this->UD_kv10->PlaceHolder = ew_RemoveHtml($this->UD_kv10->FldCaption());

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

			// PriceNum
			$this->PriceNum->LinkCustomAttributes = "";
			$this->PriceNum->HrefValue = "";

			// PriceType
			$this->PriceType->LinkCustomAttributes = "";
			$this->PriceType->HrefValue = "";

			// UD_qualityNum
			$this->UD_qualityNum->LinkCustomAttributes = "";
			$this->UD_qualityNum->HrefValue = "";

			// UD_cat
			$this->UD_cat->LinkCustomAttributes = "";
			$this->UD_cat->HrefValue = "";

			// UD_qualityType
			$this->UD_qualityType->LinkCustomAttributes = "";
			$this->UD_qualityType->HrefValue = "";

			// UD_kv4
			$this->UD_kv4->LinkCustomAttributes = "";
			$this->UD_kv4->HrefValue = "";

			// UD_kv5
			$this->UD_kv5->LinkCustomAttributes = "";
			$this->UD_kv5->HrefValue = "";

			// UD_kv6
			$this->UD_kv6->LinkCustomAttributes = "";
			$this->UD_kv6->HrefValue = "";

			// UD_kv7
			$this->UD_kv7->LinkCustomAttributes = "";
			$this->UD_kv7->HrefValue = "";

			// UD_kv8
			$this->UD_kv8->LinkCustomAttributes = "";
			$this->UD_kv8->HrefValue = "";

			// UD_kv9
			$this->UD_kv9->LinkCustomAttributes = "";
			$this->UD_kv9->HrefValue = "";

			// UD_kv10
			$this->UD_kv10->LinkCustomAttributes = "";
			$this->UD_kv10->HrefValue = "";

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
		if (!$this->PriceNum->FldIsDetailKey && !is_null($this->PriceNum->FormValue) && $this->PriceNum->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->PriceNum->FldCaption(), $this->PriceNum->ReqErrMsg));
		}
		if (!$this->PriceType->FldIsDetailKey && !is_null($this->PriceType->FormValue) && $this->PriceType->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->PriceType->FldCaption(), $this->PriceType->ReqErrMsg));
		}
		if (!$this->UD_qualityNum->FldIsDetailKey && !is_null($this->UD_qualityNum->FormValue) && $this->UD_qualityNum->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD_qualityNum->FldCaption(), $this->UD_qualityNum->ReqErrMsg));
		}
		if (!$this->UD_cat->FldIsDetailKey && !is_null($this->UD_cat->FormValue) && $this->UD_cat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD_cat->FldCaption(), $this->UD_cat->ReqErrMsg));
		}
		if (!$this->UD_qualityType->FldIsDetailKey && !is_null($this->UD_qualityType->FormValue) && $this->UD_qualityType->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD_qualityType->FldCaption(), $this->UD_qualityType->ReqErrMsg));
		}
		if (!$this->UD_kv4->FldIsDetailKey && !is_null($this->UD_kv4->FormValue) && $this->UD_kv4->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD_kv4->FldCaption(), $this->UD_kv4->ReqErrMsg));
		}
		if (!$this->UD_kv5->FldIsDetailKey && !is_null($this->UD_kv5->FormValue) && $this->UD_kv5->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD_kv5->FldCaption(), $this->UD_kv5->ReqErrMsg));
		}
		if (!$this->UD_kv6->FldIsDetailKey && !is_null($this->UD_kv6->FormValue) && $this->UD_kv6->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD_kv6->FldCaption(), $this->UD_kv6->ReqErrMsg));
		}
		if (!$this->UD_kv7->FldIsDetailKey && !is_null($this->UD_kv7->FormValue) && $this->UD_kv7->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD_kv7->FldCaption(), $this->UD_kv7->ReqErrMsg));
		}
		if (!$this->UD_kv8->FldIsDetailKey && !is_null($this->UD_kv8->FormValue) && $this->UD_kv8->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD_kv8->FldCaption(), $this->UD_kv8->ReqErrMsg));
		}
		if (!$this->UD_kv9->FldIsDetailKey && !is_null($this->UD_kv9->FormValue) && $this->UD_kv9->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD_kv9->FldCaption(), $this->UD_kv9->ReqErrMsg));
		}
		if (!$this->UD_kv10->FldIsDetailKey && !is_null($this->UD_kv10->FormValue) && $this->UD_kv10->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UD_kv10->FldCaption(), $this->UD_kv10->ReqErrMsg));
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

		// PriceNum
		$this->PriceNum->SetDbValueDef($rsnew, $this->PriceNum->CurrentValue, "", FALSE);

		// PriceType
		$this->PriceType->SetDbValueDef($rsnew, $this->PriceType->CurrentValue, "", FALSE);

		// UD_qualityNum
		$this->UD_qualityNum->SetDbValueDef($rsnew, $this->UD_qualityNum->CurrentValue, "", FALSE);

		// UD_cat
		$this->UD_cat->SetDbValueDef($rsnew, $this->UD_cat->CurrentValue, "", FALSE);

		// UD_qualityType
		$this->UD_qualityType->SetDbValueDef($rsnew, $this->UD_qualityType->CurrentValue, "", FALSE);

		// UD_kv4
		$this->UD_kv4->SetDbValueDef($rsnew, $this->UD_kv4->CurrentValue, "", FALSE);

		// UD_kv5
		$this->UD_kv5->SetDbValueDef($rsnew, $this->UD_kv5->CurrentValue, "", FALSE);

		// UD_kv6
		$this->UD_kv6->SetDbValueDef($rsnew, $this->UD_kv6->CurrentValue, "", FALSE);

		// UD_kv7
		$this->UD_kv7->SetDbValueDef($rsnew, $this->UD_kv7->CurrentValue, "", FALSE);

		// UD_kv8
		$this->UD_kv8->SetDbValueDef($rsnew, $this->UD_kv8->CurrentValue, "", FALSE);

		// UD_kv9
		$this->UD_kv9->SetDbValueDef($rsnew, $this->UD_kv9->CurrentValue, "", FALSE);

		// UD_kv10
		$this->UD_kv10->SetDbValueDef($rsnew, $this->UD_kv10->CurrentValue, "", FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ext_goodsextattrlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ext_goodsextattr_add)) $ext_goodsextattr_add = new cext_goodsextattr_add();

// Page init
$ext_goodsextattr_add->Page_Init();

// Page main
$ext_goodsextattr_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ext_goodsextattr_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fext_goodsextattradd = new ew_Form("fext_goodsextattradd", "add");

// Validate form
fext_goodsextattradd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->u_id->FldCaption(), $ext_goodsextattr->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_goodsextattr->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->acl_id->FldCaption(), $ext_goodsextattr->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_goodsextattr->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->Name->FldCaption(), $ext_goodsextattr->Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PriceNum");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->PriceNum->FldCaption(), $ext_goodsextattr->PriceNum->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PriceType");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->PriceType->FldCaption(), $ext_goodsextattr->PriceType->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD_qualityNum");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->UD_qualityNum->FldCaption(), $ext_goodsextattr->UD_qualityNum->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD_cat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->UD_cat->FldCaption(), $ext_goodsextattr->UD_cat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD_qualityType");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->UD_qualityType->FldCaption(), $ext_goodsextattr->UD_qualityType->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD_kv4");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->UD_kv4->FldCaption(), $ext_goodsextattr->UD_kv4->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD_kv5");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->UD_kv5->FldCaption(), $ext_goodsextattr->UD_kv5->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD_kv6");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->UD_kv6->FldCaption(), $ext_goodsextattr->UD_kv6->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD_kv7");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->UD_kv7->FldCaption(), $ext_goodsextattr->UD_kv7->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD_kv8");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->UD_kv8->FldCaption(), $ext_goodsextattr->UD_kv8->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD_kv9");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->UD_kv9->FldCaption(), $ext_goodsextattr->UD_kv9->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UD_kv10");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->UD_kv10->FldCaption(), $ext_goodsextattr->UD_kv10->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_goodsextattr->DATETIME->FldCaption(), $ext_goodsextattr->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_goodsextattr->DATETIME->FldErrMsg()) ?>");

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
fext_goodsextattradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fext_goodsextattradd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $ext_goodsextattr_add->ShowPageHeader(); ?>
<?php
$ext_goodsextattr_add->ShowMessage();
?>
<form name="fext_goodsextattradd" id="fext_goodsextattradd" class="<?php echo $ext_goodsextattr_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ext_goodsextattr_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ext_goodsextattr_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ext_goodsextattr">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($ext_goodsextattr_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($ext_goodsextattr->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_ext_goodsextattr_u_id" for="x_u_id" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->u_id->CellAttributes() ?>>
<span id="el_ext_goodsextattr_u_id">
<input type="text" data-table="ext_goodsextattr" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->u_id->getPlaceHolder()) ?>" value="<?php echo $ext_goodsextattr->u_id->EditValue ?>"<?php echo $ext_goodsextattr->u_id->EditAttributes() ?>>
</span>
<?php echo $ext_goodsextattr->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_ext_goodsextattr_acl_id" for="x_acl_id" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->acl_id->CellAttributes() ?>>
<span id="el_ext_goodsextattr_acl_id">
<input type="text" data-table="ext_goodsextattr" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->acl_id->getPlaceHolder()) ?>" value="<?php echo $ext_goodsextattr->acl_id->EditValue ?>"<?php echo $ext_goodsextattr->acl_id->EditAttributes() ?>>
</span>
<?php echo $ext_goodsextattr->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->Name->Visible) { // Name ?>
	<div id="r_Name" class="form-group">
		<label id="elh_ext_goodsextattr_Name" for="x_Name" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->Name->CellAttributes() ?>>
<span id="el_ext_goodsextattr_Name">
<textarea data-table="ext_goodsextattr" data-field="x_Name" name="x_Name" id="x_Name" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->Name->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->Name->EditAttributes() ?>><?php echo $ext_goodsextattr->Name->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->PriceNum->Visible) { // PriceNum ?>
	<div id="r_PriceNum" class="form-group">
		<label id="elh_ext_goodsextattr_PriceNum" for="x_PriceNum" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->PriceNum->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->PriceNum->CellAttributes() ?>>
<span id="el_ext_goodsextattr_PriceNum">
<textarea data-table="ext_goodsextattr" data-field="x_PriceNum" name="x_PriceNum" id="x_PriceNum" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->PriceNum->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->PriceNum->EditAttributes() ?>><?php echo $ext_goodsextattr->PriceNum->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->PriceNum->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->PriceType->Visible) { // PriceType ?>
	<div id="r_PriceType" class="form-group">
		<label id="elh_ext_goodsextattr_PriceType" for="x_PriceType" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->PriceType->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->PriceType->CellAttributes() ?>>
<span id="el_ext_goodsextattr_PriceType">
<textarea data-table="ext_goodsextattr" data-field="x_PriceType" name="x_PriceType" id="x_PriceType" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->PriceType->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->PriceType->EditAttributes() ?>><?php echo $ext_goodsextattr->PriceType->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->PriceType->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->UD_qualityNum->Visible) { // UD_qualityNum ?>
	<div id="r_UD_qualityNum" class="form-group">
		<label id="elh_ext_goodsextattr_UD_qualityNum" for="x_UD_qualityNum" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->UD_qualityNum->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->UD_qualityNum->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_qualityNum">
<textarea data-table="ext_goodsextattr" data-field="x_UD_qualityNum" name="x_UD_qualityNum" id="x_UD_qualityNum" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->UD_qualityNum->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->UD_qualityNum->EditAttributes() ?>><?php echo $ext_goodsextattr->UD_qualityNum->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->UD_qualityNum->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->UD_cat->Visible) { // UD_cat ?>
	<div id="r_UD_cat" class="form-group">
		<label id="elh_ext_goodsextattr_UD_cat" for="x_UD_cat" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->UD_cat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->UD_cat->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_cat">
<textarea data-table="ext_goodsextattr" data-field="x_UD_cat" name="x_UD_cat" id="x_UD_cat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->UD_cat->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->UD_cat->EditAttributes() ?>><?php echo $ext_goodsextattr->UD_cat->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->UD_cat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->UD_qualityType->Visible) { // UD_qualityType ?>
	<div id="r_UD_qualityType" class="form-group">
		<label id="elh_ext_goodsextattr_UD_qualityType" for="x_UD_qualityType" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->UD_qualityType->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->UD_qualityType->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_qualityType">
<textarea data-table="ext_goodsextattr" data-field="x_UD_qualityType" name="x_UD_qualityType" id="x_UD_qualityType" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->UD_qualityType->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->UD_qualityType->EditAttributes() ?>><?php echo $ext_goodsextattr->UD_qualityType->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->UD_qualityType->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv4->Visible) { // UD_kv4 ?>
	<div id="r_UD_kv4" class="form-group">
		<label id="elh_ext_goodsextattr_UD_kv4" for="x_UD_kv4" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->UD_kv4->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->UD_kv4->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv4">
<textarea data-table="ext_goodsextattr" data-field="x_UD_kv4" name="x_UD_kv4" id="x_UD_kv4" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->UD_kv4->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->UD_kv4->EditAttributes() ?>><?php echo $ext_goodsextattr->UD_kv4->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->UD_kv4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv5->Visible) { // UD_kv5 ?>
	<div id="r_UD_kv5" class="form-group">
		<label id="elh_ext_goodsextattr_UD_kv5" for="x_UD_kv5" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->UD_kv5->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->UD_kv5->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv5">
<textarea data-table="ext_goodsextattr" data-field="x_UD_kv5" name="x_UD_kv5" id="x_UD_kv5" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->UD_kv5->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->UD_kv5->EditAttributes() ?>><?php echo $ext_goodsextattr->UD_kv5->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->UD_kv5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv6->Visible) { // UD_kv6 ?>
	<div id="r_UD_kv6" class="form-group">
		<label id="elh_ext_goodsextattr_UD_kv6" for="x_UD_kv6" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->UD_kv6->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->UD_kv6->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv6">
<textarea data-table="ext_goodsextattr" data-field="x_UD_kv6" name="x_UD_kv6" id="x_UD_kv6" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->UD_kv6->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->UD_kv6->EditAttributes() ?>><?php echo $ext_goodsextattr->UD_kv6->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->UD_kv6->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv7->Visible) { // UD_kv7 ?>
	<div id="r_UD_kv7" class="form-group">
		<label id="elh_ext_goodsextattr_UD_kv7" for="x_UD_kv7" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->UD_kv7->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->UD_kv7->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv7">
<textarea data-table="ext_goodsextattr" data-field="x_UD_kv7" name="x_UD_kv7" id="x_UD_kv7" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->UD_kv7->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->UD_kv7->EditAttributes() ?>><?php echo $ext_goodsextattr->UD_kv7->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->UD_kv7->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv8->Visible) { // UD_kv8 ?>
	<div id="r_UD_kv8" class="form-group">
		<label id="elh_ext_goodsextattr_UD_kv8" for="x_UD_kv8" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->UD_kv8->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->UD_kv8->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv8">
<textarea data-table="ext_goodsextattr" data-field="x_UD_kv8" name="x_UD_kv8" id="x_UD_kv8" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->UD_kv8->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->UD_kv8->EditAttributes() ?>><?php echo $ext_goodsextattr->UD_kv8->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->UD_kv8->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv9->Visible) { // UD_kv9 ?>
	<div id="r_UD_kv9" class="form-group">
		<label id="elh_ext_goodsextattr_UD_kv9" for="x_UD_kv9" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->UD_kv9->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->UD_kv9->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv9">
<textarea data-table="ext_goodsextattr" data-field="x_UD_kv9" name="x_UD_kv9" id="x_UD_kv9" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->UD_kv9->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->UD_kv9->EditAttributes() ?>><?php echo $ext_goodsextattr->UD_kv9->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->UD_kv9->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv10->Visible) { // UD_kv10 ?>
	<div id="r_UD_kv10" class="form-group">
		<label id="elh_ext_goodsextattr_UD_kv10" for="x_UD_kv10" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->UD_kv10->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->UD_kv10->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv10">
<textarea data-table="ext_goodsextattr" data-field="x_UD_kv10" name="x_UD_kv10" id="x_UD_kv10" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->UD_kv10->getPlaceHolder()) ?>"<?php echo $ext_goodsextattr->UD_kv10->EditAttributes() ?>><?php echo $ext_goodsextattr->UD_kv10->EditValue ?></textarea>
</span>
<?php echo $ext_goodsextattr->UD_kv10->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_goodsextattr->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_ext_goodsextattr_DATETIME" for="x_DATETIME" class="<?php echo $ext_goodsextattr_add->LeftColumnClass ?>"><?php echo $ext_goodsextattr->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_goodsextattr_add->RightColumnClass ?>"><div<?php echo $ext_goodsextattr->DATETIME->CellAttributes() ?>>
<span id="el_ext_goodsextattr_DATETIME">
<input type="text" data-table="ext_goodsextattr" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($ext_goodsextattr->DATETIME->getPlaceHolder()) ?>" value="<?php echo $ext_goodsextattr->DATETIME->EditValue ?>"<?php echo $ext_goodsextattr->DATETIME->EditAttributes() ?>>
</span>
<?php echo $ext_goodsextattr->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$ext_goodsextattr_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $ext_goodsextattr_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ext_goodsextattr_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fext_goodsextattradd.Init();
</script>
<?php
$ext_goodsextattr_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ext_goodsextattr_add->Page_Terminate();
?>
