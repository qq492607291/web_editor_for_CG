<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ext_sam_base_infoinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$ext_sam_base_info_edit = NULL; // Initialize page object first

class cext_sam_base_info_edit extends cext_sam_base_info {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'ext_sam_base_info';

	// Page object name
	var $PageObjName = 'ext_sam_base_info_edit';

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

		// Table object (ext_sam_base_info)
		if (!isset($GLOBALS["ext_sam_base_info"]) || get_class($GLOBALS["ext_sam_base_info"]) == "cext_sam_base_info") {
			$GLOBALS["ext_sam_base_info"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ext_sam_base_info"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ext_sam_base_info', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ext_sam_base_infolist.php"));
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
		$this->LV->SetVisibility();
		$this->MainCat->SetVisibility();
		$this->SubCat->SetVisibility();
		$this->Location->SetVisibility();
		$this->Dialog->SetVisibility();
		$this->Function->SetVisibility();
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
		global $EW_EXPORT, $ext_sam_base_info;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ext_sam_base_info);
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
					if ($pageName == "ext_sam_base_infoview.php")
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
					$this->Page_Terminate("ext_sam_base_infolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "ext_sam_base_infolist.php")
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
		$this->LV->CurrentValue = $this->LV->FormValue;
		$this->MainCat->CurrentValue = $this->MainCat->FormValue;
		$this->SubCat->CurrentValue = $this->SubCat->FormValue;
		$this->Location->CurrentValue = $this->Location->FormValue;
		$this->Dialog->CurrentValue = $this->Dialog->FormValue;
		$this->Function->CurrentValue = $this->Function->FormValue;
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
		$row['LV'] = NULL;
		$row['MainCat'] = NULL;
		$row['SubCat'] = NULL;
		$row['Location'] = NULL;
		$row['Dialog'] = NULL;
		$row['Function'] = NULL;
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
		$this->LV->DbValue = $row['LV'];
		$this->MainCat->DbValue = $row['MainCat'];
		$this->SubCat->DbValue = $row['SubCat'];
		$this->Location->DbValue = $row['Location'];
		$this->Dialog->DbValue = $row['Dialog'];
		$this->Function->DbValue = $row['Function'];
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

			// LV
			$this->LV->SetDbValueDef($rsnew, $this->LV->CurrentValue, "", $this->LV->ReadOnly);

			// MainCat
			$this->MainCat->SetDbValueDef($rsnew, $this->MainCat->CurrentValue, "", $this->MainCat->ReadOnly);

			// SubCat
			$this->SubCat->SetDbValueDef($rsnew, $this->SubCat->CurrentValue, "", $this->SubCat->ReadOnly);

			// Location
			$this->Location->SetDbValueDef($rsnew, $this->Location->CurrentValue, "", $this->Location->ReadOnly);

			// Dialog
			$this->Dialog->SetDbValueDef($rsnew, $this->Dialog->CurrentValue, "", $this->Dialog->ReadOnly);

			// Function
			$this->Function->SetDbValueDef($rsnew, $this->Function->CurrentValue, "", $this->Function->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ext_sam_base_infolist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ext_sam_base_info_edit)) $ext_sam_base_info_edit = new cext_sam_base_info_edit();

// Page init
$ext_sam_base_info_edit->Page_Init();

// Page main
$ext_sam_base_info_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ext_sam_base_info_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fext_sam_base_infoedit = new ew_Form("fext_sam_base_infoedit", "edit");

// Validate form
fext_sam_base_infoedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->u_id->FldCaption(), $ext_sam_base_info->u_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_sam_base_info->u_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->acl_id->FldCaption(), $ext_sam_base_info->acl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_acl_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_sam_base_info->acl_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->Name->FldCaption(), $ext_sam_base_info->Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->LV->FldCaption(), $ext_sam_base_info->LV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_MainCat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->MainCat->FldCaption(), $ext_sam_base_info->MainCat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_SubCat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->SubCat->FldCaption(), $ext_sam_base_info->SubCat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Location");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->Location->FldCaption(), $ext_sam_base_info->Location->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Dialog");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->Dialog->FldCaption(), $ext_sam_base_info->Dialog->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Function");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->Function->FldCaption(), $ext_sam_base_info->Function->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Introduce");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->Introduce->FldCaption(), $ext_sam_base_info->Introduce->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ext_sam_base_info->DATETIME->FldCaption(), $ext_sam_base_info->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ext_sam_base_info->DATETIME->FldErrMsg()) ?>");

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
fext_sam_base_infoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fext_sam_base_infoedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $ext_sam_base_info_edit->ShowPageHeader(); ?>
<?php
$ext_sam_base_info_edit->ShowMessage();
?>
<form name="fext_sam_base_infoedit" id="fext_sam_base_infoedit" class="<?php echo $ext_sam_base_info_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ext_sam_base_info_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ext_sam_base_info_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ext_sam_base_info">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($ext_sam_base_info_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($ext_sam_base_info->unid->Visible) { // unid ?>
	<div id="r_unid" class="form-group">
		<label id="elh_ext_sam_base_info_unid" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->unid->FldCaption() ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->unid->CellAttributes() ?>>
<span id="el_ext_sam_base_info_unid">
<span<?php echo $ext_sam_base_info->unid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ext_sam_base_info->unid->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ext_sam_base_info" data-field="x_unid" name="x_unid" id="x_unid" value="<?php echo ew_HtmlEncode($ext_sam_base_info->unid->CurrentValue) ?>">
<?php echo $ext_sam_base_info->unid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->u_id->Visible) { // u_id ?>
	<div id="r_u_id" class="form-group">
		<label id="elh_ext_sam_base_info_u_id" for="x_u_id" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->u_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->u_id->CellAttributes() ?>>
<span id="el_ext_sam_base_info_u_id">
<input type="text" data-table="ext_sam_base_info" data-field="x_u_id" name="x_u_id" id="x_u_id" size="30" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->u_id->getPlaceHolder()) ?>" value="<?php echo $ext_sam_base_info->u_id->EditValue ?>"<?php echo $ext_sam_base_info->u_id->EditAttributes() ?>>
</span>
<?php echo $ext_sam_base_info->u_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->acl_id->Visible) { // acl_id ?>
	<div id="r_acl_id" class="form-group">
		<label id="elh_ext_sam_base_info_acl_id" for="x_acl_id" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->acl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->acl_id->CellAttributes() ?>>
<span id="el_ext_sam_base_info_acl_id">
<input type="text" data-table="ext_sam_base_info" data-field="x_acl_id" name="x_acl_id" id="x_acl_id" size="30" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->acl_id->getPlaceHolder()) ?>" value="<?php echo $ext_sam_base_info->acl_id->EditValue ?>"<?php echo $ext_sam_base_info->acl_id->EditAttributes() ?>>
</span>
<?php echo $ext_sam_base_info->acl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->Name->Visible) { // Name ?>
	<div id="r_Name" class="form-group">
		<label id="elh_ext_sam_base_info_Name" for="x_Name" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->Name->CellAttributes() ?>>
<span id="el_ext_sam_base_info_Name">
<textarea data-table="ext_sam_base_info" data-field="x_Name" name="x_Name" id="x_Name" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->Name->getPlaceHolder()) ?>"<?php echo $ext_sam_base_info->Name->EditAttributes() ?>><?php echo $ext_sam_base_info->Name->EditValue ?></textarea>
</span>
<?php echo $ext_sam_base_info->Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->LV->Visible) { // LV ?>
	<div id="r_LV" class="form-group">
		<label id="elh_ext_sam_base_info_LV" for="x_LV" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->LV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->LV->CellAttributes() ?>>
<span id="el_ext_sam_base_info_LV">
<textarea data-table="ext_sam_base_info" data-field="x_LV" name="x_LV" id="x_LV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->LV->getPlaceHolder()) ?>"<?php echo $ext_sam_base_info->LV->EditAttributes() ?>><?php echo $ext_sam_base_info->LV->EditValue ?></textarea>
</span>
<?php echo $ext_sam_base_info->LV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->MainCat->Visible) { // MainCat ?>
	<div id="r_MainCat" class="form-group">
		<label id="elh_ext_sam_base_info_MainCat" for="x_MainCat" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->MainCat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->MainCat->CellAttributes() ?>>
<span id="el_ext_sam_base_info_MainCat">
<textarea data-table="ext_sam_base_info" data-field="x_MainCat" name="x_MainCat" id="x_MainCat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->MainCat->getPlaceHolder()) ?>"<?php echo $ext_sam_base_info->MainCat->EditAttributes() ?>><?php echo $ext_sam_base_info->MainCat->EditValue ?></textarea>
</span>
<?php echo $ext_sam_base_info->MainCat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->SubCat->Visible) { // SubCat ?>
	<div id="r_SubCat" class="form-group">
		<label id="elh_ext_sam_base_info_SubCat" for="x_SubCat" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->SubCat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->SubCat->CellAttributes() ?>>
<span id="el_ext_sam_base_info_SubCat">
<textarea data-table="ext_sam_base_info" data-field="x_SubCat" name="x_SubCat" id="x_SubCat" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->SubCat->getPlaceHolder()) ?>"<?php echo $ext_sam_base_info->SubCat->EditAttributes() ?>><?php echo $ext_sam_base_info->SubCat->EditValue ?></textarea>
</span>
<?php echo $ext_sam_base_info->SubCat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->Location->Visible) { // Location ?>
	<div id="r_Location" class="form-group">
		<label id="elh_ext_sam_base_info_Location" for="x_Location" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->Location->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->Location->CellAttributes() ?>>
<span id="el_ext_sam_base_info_Location">
<textarea data-table="ext_sam_base_info" data-field="x_Location" name="x_Location" id="x_Location" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->Location->getPlaceHolder()) ?>"<?php echo $ext_sam_base_info->Location->EditAttributes() ?>><?php echo $ext_sam_base_info->Location->EditValue ?></textarea>
</span>
<?php echo $ext_sam_base_info->Location->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->Dialog->Visible) { // Dialog ?>
	<div id="r_Dialog" class="form-group">
		<label id="elh_ext_sam_base_info_Dialog" for="x_Dialog" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->Dialog->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->Dialog->CellAttributes() ?>>
<span id="el_ext_sam_base_info_Dialog">
<textarea data-table="ext_sam_base_info" data-field="x_Dialog" name="x_Dialog" id="x_Dialog" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->Dialog->getPlaceHolder()) ?>"<?php echo $ext_sam_base_info->Dialog->EditAttributes() ?>><?php echo $ext_sam_base_info->Dialog->EditValue ?></textarea>
</span>
<?php echo $ext_sam_base_info->Dialog->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->Function->Visible) { // Function ?>
	<div id="r_Function" class="form-group">
		<label id="elh_ext_sam_base_info_Function" for="x_Function" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->Function->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->Function->CellAttributes() ?>>
<span id="el_ext_sam_base_info_Function">
<textarea data-table="ext_sam_base_info" data-field="x_Function" name="x_Function" id="x_Function" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->Function->getPlaceHolder()) ?>"<?php echo $ext_sam_base_info->Function->EditAttributes() ?>><?php echo $ext_sam_base_info->Function->EditValue ?></textarea>
</span>
<?php echo $ext_sam_base_info->Function->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->Introduce->Visible) { // Introduce ?>
	<div id="r_Introduce" class="form-group">
		<label id="elh_ext_sam_base_info_Introduce" for="x_Introduce" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->Introduce->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->Introduce->CellAttributes() ?>>
<span id="el_ext_sam_base_info_Introduce">
<textarea data-table="ext_sam_base_info" data-field="x_Introduce" name="x_Introduce" id="x_Introduce" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->Introduce->getPlaceHolder()) ?>"<?php echo $ext_sam_base_info->Introduce->EditAttributes() ?>><?php echo $ext_sam_base_info->Introduce->EditValue ?></textarea>
</span>
<?php echo $ext_sam_base_info->Introduce->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ext_sam_base_info->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_ext_sam_base_info_DATETIME" for="x_DATETIME" class="<?php echo $ext_sam_base_info_edit->LeftColumnClass ?>"><?php echo $ext_sam_base_info->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ext_sam_base_info_edit->RightColumnClass ?>"><div<?php echo $ext_sam_base_info->DATETIME->CellAttributes() ?>>
<span id="el_ext_sam_base_info_DATETIME">
<input type="text" data-table="ext_sam_base_info" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($ext_sam_base_info->DATETIME->getPlaceHolder()) ?>" value="<?php echo $ext_sam_base_info->DATETIME->EditValue ?>"<?php echo $ext_sam_base_info->DATETIME->EditAttributes() ?>>
</span>
<?php echo $ext_sam_base_info->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$ext_sam_base_info_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $ext_sam_base_info_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ext_sam_base_info_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fext_sam_base_infoedit.Init();
</script>
<?php
$ext_sam_base_info_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ext_sam_base_info_edit->Page_Terminate();
?>
