<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_mapinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_map_edit = NULL; // Initialize page object first

class cconfig_map_edit extends cconfig_map {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_map';

	// Page object name
	var $PageObjName = 'config_map_edit';

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

		// Table object (config_map)
		if (!isset($GLOBALS["config_map"]) || get_class($GLOBALS["config_map"]) == "cconfig_map") {
			$GLOBALS["config_map"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_map"];
		}

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'config_map', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("config_maplist.php"));
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
		$this->Name->SetVisibility();
		$this->LV->SetVisibility();
		$this->Introduce->SetVisibility();
		$this->_Security->SetVisibility();
		$this->Hid->SetVisibility();
		$this->Basis->SetVisibility();
		$this->Monster->SetVisibility();
		$this->UP->SetVisibility();
		$this->Down->SetVisibility();
		$this->Left->SetVisibility();
		$this->Right->SetVisibility();
		$this->Consume->SetVisibility();
		$this->LV_UP->SetVisibility();
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
		global $EW_EXPORT, $config_map;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_map);
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
					if ($pageName == "config_mapview.php")
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
					$this->Page_Terminate("config_maplist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "config_maplist.php")
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
		if (!$this->Name->FldIsDetailKey) {
			$this->Name->setFormValue($objForm->GetValue("x_Name"));
		}
		if (!$this->LV->FldIsDetailKey) {
			$this->LV->setFormValue($objForm->GetValue("x_LV"));
		}
		if (!$this->Introduce->FldIsDetailKey) {
			$this->Introduce->setFormValue($objForm->GetValue("x_Introduce"));
		}
		if (!$this->_Security->FldIsDetailKey) {
			$this->_Security->setFormValue($objForm->GetValue("x__Security"));
		}
		if (!$this->Hid->FldIsDetailKey) {
			$this->Hid->setFormValue($objForm->GetValue("x_Hid"));
		}
		if (!$this->Basis->FldIsDetailKey) {
			$this->Basis->setFormValue($objForm->GetValue("x_Basis"));
		}
		if (!$this->Monster->FldIsDetailKey) {
			$this->Monster->setFormValue($objForm->GetValue("x_Monster"));
		}
		if (!$this->UP->FldIsDetailKey) {
			$this->UP->setFormValue($objForm->GetValue("x_UP"));
		}
		if (!$this->Down->FldIsDetailKey) {
			$this->Down->setFormValue($objForm->GetValue("x_Down"));
		}
		if (!$this->Left->FldIsDetailKey) {
			$this->Left->setFormValue($objForm->GetValue("x_Left"));
		}
		if (!$this->Right->FldIsDetailKey) {
			$this->Right->setFormValue($objForm->GetValue("x_Right"));
		}
		if (!$this->Consume->FldIsDetailKey) {
			$this->Consume->setFormValue($objForm->GetValue("x_Consume"));
		}
		if (!$this->LV_UP->FldIsDetailKey) {
			$this->LV_UP->setFormValue($objForm->GetValue("x_LV_UP"));
		}
		if (!$this->DATETIME->FldIsDetailKey) {
			$this->DATETIME->setFormValue($objForm->GetValue("x_DATETIME"));
			$this->DATETIME->CurrentValue = ew_UnFormatDateTime($this->DATETIME->CurrentValue, 0);
		}
		if (!$this->unid->FldIsDetailKey)
			$this->unid->setFormValue($objForm->GetValue("x_unid"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->unid->CurrentValue = $this->unid->FormValue;
		$this->Name->CurrentValue = $this->Name->FormValue;
		$this->LV->CurrentValue = $this->LV->FormValue;
		$this->Introduce->CurrentValue = $this->Introduce->FormValue;
		$this->_Security->CurrentValue = $this->_Security->FormValue;
		$this->Hid->CurrentValue = $this->Hid->FormValue;
		$this->Basis->CurrentValue = $this->Basis->FormValue;
		$this->Monster->CurrentValue = $this->Monster->FormValue;
		$this->UP->CurrentValue = $this->UP->FormValue;
		$this->Down->CurrentValue = $this->Down->FormValue;
		$this->Left->CurrentValue = $this->Left->FormValue;
		$this->Right->CurrentValue = $this->Right->FormValue;
		$this->Consume->CurrentValue = $this->Consume->FormValue;
		$this->LV_UP->CurrentValue = $this->LV_UP->FormValue;
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
		$this->Introduce->setDbValue($row['Introduce']);
		$this->_Security->setDbValue($row['Security']);
		$this->Hid->setDbValue($row['Hid']);
		$this->Basis->setDbValue($row['Basis']);
		$this->Monster->setDbValue($row['Monster']);
		$this->UP->setDbValue($row['UP']);
		$this->Down->setDbValue($row['Down']);
		$this->Left->setDbValue($row['Left']);
		$this->Right->setDbValue($row['Right']);
		$this->Consume->setDbValue($row['Consume']);
		$this->LV_UP->setDbValue($row['LV_UP']);
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
		$row['Introduce'] = NULL;
		$row['Security'] = NULL;
		$row['Hid'] = NULL;
		$row['Basis'] = NULL;
		$row['Monster'] = NULL;
		$row['UP'] = NULL;
		$row['Down'] = NULL;
		$row['Left'] = NULL;
		$row['Right'] = NULL;
		$row['Consume'] = NULL;
		$row['LV_UP'] = NULL;
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
		$this->Introduce->DbValue = $row['Introduce'];
		$this->_Security->DbValue = $row['Security'];
		$this->Hid->DbValue = $row['Hid'];
		$this->Basis->DbValue = $row['Basis'];
		$this->Monster->DbValue = $row['Monster'];
		$this->UP->DbValue = $row['UP'];
		$this->Down->DbValue = $row['Down'];
		$this->Left->DbValue = $row['Left'];
		$this->Right->DbValue = $row['Right'];
		$this->Consume->DbValue = $row['Consume'];
		$this->LV_UP->DbValue = $row['LV_UP'];
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
		// Introduce
		// Security
		// Hid
		// Basis
		// Monster
		// UP
		// Down
		// Left
		// Right
		// Consume
		// LV_UP
		// DATETIME

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Name
		$this->Name->ViewValue = $this->Name->CurrentValue;
		$this->Name->ViewCustomAttributes = "";

		// LV
		$this->LV->ViewValue = $this->LV->CurrentValue;
		$this->LV->ViewCustomAttributes = "";

		// Introduce
		$this->Introduce->ViewValue = $this->Introduce->CurrentValue;
		$this->Introduce->ViewCustomAttributes = "";

		// Security
		$this->_Security->ViewValue = $this->_Security->CurrentValue;
		$this->_Security->ViewCustomAttributes = "";

		// Hid
		$this->Hid->ViewValue = $this->Hid->CurrentValue;
		$this->Hid->ViewCustomAttributes = "";

		// Basis
		$this->Basis->ViewValue = $this->Basis->CurrentValue;
		$this->Basis->ViewCustomAttributes = "";

		// Monster
		$this->Monster->ViewValue = $this->Monster->CurrentValue;
		$this->Monster->ViewCustomAttributes = "";

		// UP
		$this->UP->ViewValue = $this->UP->CurrentValue;
		$this->UP->ViewCustomAttributes = "";

		// Down
		$this->Down->ViewValue = $this->Down->CurrentValue;
		$this->Down->ViewCustomAttributes = "";

		// Left
		$this->Left->ViewValue = $this->Left->CurrentValue;
		$this->Left->ViewCustomAttributes = "";

		// Right
		$this->Right->ViewValue = $this->Right->CurrentValue;
		$this->Right->ViewCustomAttributes = "";

		// Consume
		$this->Consume->ViewValue = $this->Consume->CurrentValue;
		$this->Consume->ViewCustomAttributes = "";

		// LV_UP
		$this->LV_UP->ViewValue = $this->LV_UP->CurrentValue;
		$this->LV_UP->ViewCustomAttributes = "";

		// DATETIME
		$this->DATETIME->ViewValue = $this->DATETIME->CurrentValue;
		$this->DATETIME->ViewValue = ew_FormatDateTime($this->DATETIME->ViewValue, 0);
		$this->DATETIME->ViewCustomAttributes = "";

			// Name
			$this->Name->LinkCustomAttributes = "";
			$this->Name->HrefValue = "";
			$this->Name->TooltipValue = "";

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";
			$this->LV->TooltipValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";
			$this->Introduce->TooltipValue = "";

			// Security
			$this->_Security->LinkCustomAttributes = "";
			$this->_Security->HrefValue = "";
			$this->_Security->TooltipValue = "";

			// Hid
			$this->Hid->LinkCustomAttributes = "";
			$this->Hid->HrefValue = "";
			$this->Hid->TooltipValue = "";

			// Basis
			$this->Basis->LinkCustomAttributes = "";
			$this->Basis->HrefValue = "";
			$this->Basis->TooltipValue = "";

			// Monster
			$this->Monster->LinkCustomAttributes = "";
			$this->Monster->HrefValue = "";
			$this->Monster->TooltipValue = "";

			// UP
			$this->UP->LinkCustomAttributes = "";
			$this->UP->HrefValue = "";
			$this->UP->TooltipValue = "";

			// Down
			$this->Down->LinkCustomAttributes = "";
			$this->Down->HrefValue = "";
			$this->Down->TooltipValue = "";

			// Left
			$this->Left->LinkCustomAttributes = "";
			$this->Left->HrefValue = "";
			$this->Left->TooltipValue = "";

			// Right
			$this->Right->LinkCustomAttributes = "";
			$this->Right->HrefValue = "";
			$this->Right->TooltipValue = "";

			// Consume
			$this->Consume->LinkCustomAttributes = "";
			$this->Consume->HrefValue = "";
			$this->Consume->TooltipValue = "";

			// LV_UP
			$this->LV_UP->LinkCustomAttributes = "";
			$this->LV_UP->HrefValue = "";
			$this->LV_UP->TooltipValue = "";

			// DATETIME
			$this->DATETIME->LinkCustomAttributes = "";
			$this->DATETIME->HrefValue = "";
			$this->DATETIME->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// Introduce
			$this->Introduce->EditAttrs["class"] = "form-control";
			$this->Introduce->EditCustomAttributes = "";
			$this->Introduce->EditValue = ew_HtmlEncode($this->Introduce->CurrentValue);
			$this->Introduce->PlaceHolder = ew_RemoveHtml($this->Introduce->FldCaption());

			// Security
			$this->_Security->EditAttrs["class"] = "form-control";
			$this->_Security->EditCustomAttributes = "";
			$this->_Security->EditValue = ew_HtmlEncode($this->_Security->CurrentValue);
			$this->_Security->PlaceHolder = ew_RemoveHtml($this->_Security->FldCaption());

			// Hid
			$this->Hid->EditAttrs["class"] = "form-control";
			$this->Hid->EditCustomAttributes = "";
			$this->Hid->EditValue = ew_HtmlEncode($this->Hid->CurrentValue);
			$this->Hid->PlaceHolder = ew_RemoveHtml($this->Hid->FldCaption());

			// Basis
			$this->Basis->EditAttrs["class"] = "form-control";
			$this->Basis->EditCustomAttributes = "";
			$this->Basis->EditValue = ew_HtmlEncode($this->Basis->CurrentValue);
			$this->Basis->PlaceHolder = ew_RemoveHtml($this->Basis->FldCaption());

			// Monster
			$this->Monster->EditAttrs["class"] = "form-control";
			$this->Monster->EditCustomAttributes = "";
			$this->Monster->EditValue = ew_HtmlEncode($this->Monster->CurrentValue);
			$this->Monster->PlaceHolder = ew_RemoveHtml($this->Monster->FldCaption());

			// UP
			$this->UP->EditAttrs["class"] = "form-control";
			$this->UP->EditCustomAttributes = "";
			$this->UP->EditValue = ew_HtmlEncode($this->UP->CurrentValue);
			$this->UP->PlaceHolder = ew_RemoveHtml($this->UP->FldCaption());

			// Down
			$this->Down->EditAttrs["class"] = "form-control";
			$this->Down->EditCustomAttributes = "";
			$this->Down->EditValue = ew_HtmlEncode($this->Down->CurrentValue);
			$this->Down->PlaceHolder = ew_RemoveHtml($this->Down->FldCaption());

			// Left
			$this->Left->EditAttrs["class"] = "form-control";
			$this->Left->EditCustomAttributes = "";
			$this->Left->EditValue = ew_HtmlEncode($this->Left->CurrentValue);
			$this->Left->PlaceHolder = ew_RemoveHtml($this->Left->FldCaption());

			// Right
			$this->Right->EditAttrs["class"] = "form-control";
			$this->Right->EditCustomAttributes = "";
			$this->Right->EditValue = ew_HtmlEncode($this->Right->CurrentValue);
			$this->Right->PlaceHolder = ew_RemoveHtml($this->Right->FldCaption());

			// Consume
			$this->Consume->EditAttrs["class"] = "form-control";
			$this->Consume->EditCustomAttributes = "";
			$this->Consume->EditValue = ew_HtmlEncode($this->Consume->CurrentValue);
			$this->Consume->PlaceHolder = ew_RemoveHtml($this->Consume->FldCaption());

			// LV_UP
			$this->LV_UP->EditAttrs["class"] = "form-control";
			$this->LV_UP->EditCustomAttributes = "";
			$this->LV_UP->EditValue = ew_HtmlEncode($this->LV_UP->CurrentValue);
			$this->LV_UP->PlaceHolder = ew_RemoveHtml($this->LV_UP->FldCaption());

			// DATETIME
			$this->DATETIME->EditAttrs["class"] = "form-control";
			$this->DATETIME->EditCustomAttributes = "";
			$this->DATETIME->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->DATETIME->CurrentValue, 8));
			$this->DATETIME->PlaceHolder = ew_RemoveHtml($this->DATETIME->FldCaption());

			// Edit refer script
			// Name

			$this->Name->LinkCustomAttributes = "";
			$this->Name->HrefValue = "";

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";

			// Security
			$this->_Security->LinkCustomAttributes = "";
			$this->_Security->HrefValue = "";

			// Hid
			$this->Hid->LinkCustomAttributes = "";
			$this->Hid->HrefValue = "";

			// Basis
			$this->Basis->LinkCustomAttributes = "";
			$this->Basis->HrefValue = "";

			// Monster
			$this->Monster->LinkCustomAttributes = "";
			$this->Monster->HrefValue = "";

			// UP
			$this->UP->LinkCustomAttributes = "";
			$this->UP->HrefValue = "";

			// Down
			$this->Down->LinkCustomAttributes = "";
			$this->Down->HrefValue = "";

			// Left
			$this->Left->LinkCustomAttributes = "";
			$this->Left->HrefValue = "";

			// Right
			$this->Right->LinkCustomAttributes = "";
			$this->Right->HrefValue = "";

			// Consume
			$this->Consume->LinkCustomAttributes = "";
			$this->Consume->HrefValue = "";

			// LV_UP
			$this->LV_UP->LinkCustomAttributes = "";
			$this->LV_UP->HrefValue = "";

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
		if (!$this->Name->FldIsDetailKey && !is_null($this->Name->FormValue) && $this->Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Name->FldCaption(), $this->Name->ReqErrMsg));
		}
		if (!$this->LV->FldIsDetailKey && !is_null($this->LV->FormValue) && $this->LV->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->LV->FldCaption(), $this->LV->ReqErrMsg));
		}
		if (!$this->Introduce->FldIsDetailKey && !is_null($this->Introduce->FormValue) && $this->Introduce->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Introduce->FldCaption(), $this->Introduce->ReqErrMsg));
		}
		if (!$this->_Security->FldIsDetailKey && !is_null($this->_Security->FormValue) && $this->_Security->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_Security->FldCaption(), $this->_Security->ReqErrMsg));
		}
		if (!$this->Hid->FldIsDetailKey && !is_null($this->Hid->FormValue) && $this->Hid->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Hid->FldCaption(), $this->Hid->ReqErrMsg));
		}
		if (!$this->Basis->FldIsDetailKey && !is_null($this->Basis->FormValue) && $this->Basis->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Basis->FldCaption(), $this->Basis->ReqErrMsg));
		}
		if (!$this->Monster->FldIsDetailKey && !is_null($this->Monster->FormValue) && $this->Monster->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Monster->FldCaption(), $this->Monster->ReqErrMsg));
		}
		if (!$this->UP->FldIsDetailKey && !is_null($this->UP->FormValue) && $this->UP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UP->FldCaption(), $this->UP->ReqErrMsg));
		}
		if (!$this->Down->FldIsDetailKey && !is_null($this->Down->FormValue) && $this->Down->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Down->FldCaption(), $this->Down->ReqErrMsg));
		}
		if (!$this->Left->FldIsDetailKey && !is_null($this->Left->FormValue) && $this->Left->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Left->FldCaption(), $this->Left->ReqErrMsg));
		}
		if (!$this->Right->FldIsDetailKey && !is_null($this->Right->FormValue) && $this->Right->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Right->FldCaption(), $this->Right->ReqErrMsg));
		}
		if (!$this->Consume->FldIsDetailKey && !is_null($this->Consume->FormValue) && $this->Consume->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Consume->FldCaption(), $this->Consume->ReqErrMsg));
		}
		if (!$this->LV_UP->FldIsDetailKey && !is_null($this->LV_UP->FormValue) && $this->LV_UP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->LV_UP->FldCaption(), $this->LV_UP->ReqErrMsg));
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

			// Name
			$this->Name->SetDbValueDef($rsnew, $this->Name->CurrentValue, "", $this->Name->ReadOnly);

			// LV
			$this->LV->SetDbValueDef($rsnew, $this->LV->CurrentValue, "", $this->LV->ReadOnly);

			// Introduce
			$this->Introduce->SetDbValueDef($rsnew, $this->Introduce->CurrentValue, "", $this->Introduce->ReadOnly);

			// Security
			$this->_Security->SetDbValueDef($rsnew, $this->_Security->CurrentValue, "", $this->_Security->ReadOnly);

			// Hid
			$this->Hid->SetDbValueDef($rsnew, $this->Hid->CurrentValue, "", $this->Hid->ReadOnly);

			// Basis
			$this->Basis->SetDbValueDef($rsnew, $this->Basis->CurrentValue, "", $this->Basis->ReadOnly);

			// Monster
			$this->Monster->SetDbValueDef($rsnew, $this->Monster->CurrentValue, "", $this->Monster->ReadOnly);

			// UP
			$this->UP->SetDbValueDef($rsnew, $this->UP->CurrentValue, "", $this->UP->ReadOnly);

			// Down
			$this->Down->SetDbValueDef($rsnew, $this->Down->CurrentValue, "", $this->Down->ReadOnly);

			// Left
			$this->Left->SetDbValueDef($rsnew, $this->Left->CurrentValue, "", $this->Left->ReadOnly);

			// Right
			$this->Right->SetDbValueDef($rsnew, $this->Right->CurrentValue, "", $this->Right->ReadOnly);

			// Consume
			$this->Consume->SetDbValueDef($rsnew, $this->Consume->CurrentValue, "", $this->Consume->ReadOnly);

			// LV_UP
			$this->LV_UP->SetDbValueDef($rsnew, $this->LV_UP->CurrentValue, "", $this->LV_UP->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_maplist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_map_edit)) $config_map_edit = new cconfig_map_edit();

// Page init
$config_map_edit->Page_Init();

// Page main
$config_map_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_map_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fconfig_mapedit = new ew_Form("fconfig_mapedit", "edit");

// Validate form
fconfig_mapedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->Name->FldCaption(), $config_map->Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LV");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->LV->FldCaption(), $config_map->LV->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Introduce");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->Introduce->FldCaption(), $config_map->Introduce->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__Security");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->_Security->FldCaption(), $config_map->_Security->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Hid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->Hid->FldCaption(), $config_map->Hid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Basis");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->Basis->FldCaption(), $config_map->Basis->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Monster");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->Monster->FldCaption(), $config_map->Monster->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->UP->FldCaption(), $config_map->UP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Down");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->Down->FldCaption(), $config_map->Down->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Left");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->Left->FldCaption(), $config_map->Left->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Right");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->Right->FldCaption(), $config_map->Right->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Consume");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->Consume->FldCaption(), $config_map->Consume->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LV_UP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->LV_UP->FldCaption(), $config_map->LV_UP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $config_map->DATETIME->FldCaption(), $config_map->DATETIME->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DATETIME");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($config_map->DATETIME->FldErrMsg()) ?>");

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
fconfig_mapedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_mapedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $config_map_edit->ShowPageHeader(); ?>
<?php
$config_map_edit->ShowMessage();
?>
<form name="fconfig_mapedit" id="fconfig_mapedit" class="<?php echo $config_map_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_map_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_map_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_map">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($config_map_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($config_map->Name->Visible) { // Name ?>
	<div id="r_Name" class="form-group">
		<label id="elh_config_map_Name" for="x_Name" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->Name->CellAttributes() ?>>
<span id="el_config_map_Name">
<textarea data-table="config_map" data-field="x_Name" name="x_Name" id="x_Name" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->Name->getPlaceHolder()) ?>"<?php echo $config_map->Name->EditAttributes() ?>><?php echo $config_map->Name->EditValue ?></textarea>
</span>
<?php echo $config_map->Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->LV->Visible) { // LV ?>
	<div id="r_LV" class="form-group">
		<label id="elh_config_map_LV" for="x_LV" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->LV->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->LV->CellAttributes() ?>>
<span id="el_config_map_LV">
<textarea data-table="config_map" data-field="x_LV" name="x_LV" id="x_LV" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->LV->getPlaceHolder()) ?>"<?php echo $config_map->LV->EditAttributes() ?>><?php echo $config_map->LV->EditValue ?></textarea>
</span>
<?php echo $config_map->LV->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->Introduce->Visible) { // Introduce ?>
	<div id="r_Introduce" class="form-group">
		<label id="elh_config_map_Introduce" for="x_Introduce" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->Introduce->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->Introduce->CellAttributes() ?>>
<span id="el_config_map_Introduce">
<textarea data-table="config_map" data-field="x_Introduce" name="x_Introduce" id="x_Introduce" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->Introduce->getPlaceHolder()) ?>"<?php echo $config_map->Introduce->EditAttributes() ?>><?php echo $config_map->Introduce->EditValue ?></textarea>
</span>
<?php echo $config_map->Introduce->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->_Security->Visible) { // Security ?>
	<div id="r__Security" class="form-group">
		<label id="elh_config_map__Security" for="x__Security" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->_Security->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->_Security->CellAttributes() ?>>
<span id="el_config_map__Security">
<textarea data-table="config_map" data-field="x__Security" name="x__Security" id="x__Security" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->_Security->getPlaceHolder()) ?>"<?php echo $config_map->_Security->EditAttributes() ?>><?php echo $config_map->_Security->EditValue ?></textarea>
</span>
<?php echo $config_map->_Security->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->Hid->Visible) { // Hid ?>
	<div id="r_Hid" class="form-group">
		<label id="elh_config_map_Hid" for="x_Hid" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->Hid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->Hid->CellAttributes() ?>>
<span id="el_config_map_Hid">
<textarea data-table="config_map" data-field="x_Hid" name="x_Hid" id="x_Hid" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->Hid->getPlaceHolder()) ?>"<?php echo $config_map->Hid->EditAttributes() ?>><?php echo $config_map->Hid->EditValue ?></textarea>
</span>
<?php echo $config_map->Hid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->Basis->Visible) { // Basis ?>
	<div id="r_Basis" class="form-group">
		<label id="elh_config_map_Basis" for="x_Basis" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->Basis->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->Basis->CellAttributes() ?>>
<span id="el_config_map_Basis">
<textarea data-table="config_map" data-field="x_Basis" name="x_Basis" id="x_Basis" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->Basis->getPlaceHolder()) ?>"<?php echo $config_map->Basis->EditAttributes() ?>><?php echo $config_map->Basis->EditValue ?></textarea>
</span>
<?php echo $config_map->Basis->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->Monster->Visible) { // Monster ?>
	<div id="r_Monster" class="form-group">
		<label id="elh_config_map_Monster" for="x_Monster" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->Monster->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->Monster->CellAttributes() ?>>
<span id="el_config_map_Monster">
<textarea data-table="config_map" data-field="x_Monster" name="x_Monster" id="x_Monster" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->Monster->getPlaceHolder()) ?>"<?php echo $config_map->Monster->EditAttributes() ?>><?php echo $config_map->Monster->EditValue ?></textarea>
</span>
<?php echo $config_map->Monster->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->UP->Visible) { // UP ?>
	<div id="r_UP" class="form-group">
		<label id="elh_config_map_UP" for="x_UP" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->UP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->UP->CellAttributes() ?>>
<span id="el_config_map_UP">
<textarea data-table="config_map" data-field="x_UP" name="x_UP" id="x_UP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->UP->getPlaceHolder()) ?>"<?php echo $config_map->UP->EditAttributes() ?>><?php echo $config_map->UP->EditValue ?></textarea>
</span>
<?php echo $config_map->UP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->Down->Visible) { // Down ?>
	<div id="r_Down" class="form-group">
		<label id="elh_config_map_Down" for="x_Down" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->Down->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->Down->CellAttributes() ?>>
<span id="el_config_map_Down">
<textarea data-table="config_map" data-field="x_Down" name="x_Down" id="x_Down" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->Down->getPlaceHolder()) ?>"<?php echo $config_map->Down->EditAttributes() ?>><?php echo $config_map->Down->EditValue ?></textarea>
</span>
<?php echo $config_map->Down->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->Left->Visible) { // Left ?>
	<div id="r_Left" class="form-group">
		<label id="elh_config_map_Left" for="x_Left" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->Left->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->Left->CellAttributes() ?>>
<span id="el_config_map_Left">
<textarea data-table="config_map" data-field="x_Left" name="x_Left" id="x_Left" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->Left->getPlaceHolder()) ?>"<?php echo $config_map->Left->EditAttributes() ?>><?php echo $config_map->Left->EditValue ?></textarea>
</span>
<?php echo $config_map->Left->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->Right->Visible) { // Right ?>
	<div id="r_Right" class="form-group">
		<label id="elh_config_map_Right" for="x_Right" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->Right->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->Right->CellAttributes() ?>>
<span id="el_config_map_Right">
<textarea data-table="config_map" data-field="x_Right" name="x_Right" id="x_Right" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->Right->getPlaceHolder()) ?>"<?php echo $config_map->Right->EditAttributes() ?>><?php echo $config_map->Right->EditValue ?></textarea>
</span>
<?php echo $config_map->Right->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->Consume->Visible) { // Consume ?>
	<div id="r_Consume" class="form-group">
		<label id="elh_config_map_Consume" for="x_Consume" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->Consume->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->Consume->CellAttributes() ?>>
<span id="el_config_map_Consume">
<textarea data-table="config_map" data-field="x_Consume" name="x_Consume" id="x_Consume" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->Consume->getPlaceHolder()) ?>"<?php echo $config_map->Consume->EditAttributes() ?>><?php echo $config_map->Consume->EditValue ?></textarea>
</span>
<?php echo $config_map->Consume->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->LV_UP->Visible) { // LV_UP ?>
	<div id="r_LV_UP" class="form-group">
		<label id="elh_config_map_LV_UP" for="x_LV_UP" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->LV_UP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->LV_UP->CellAttributes() ?>>
<span id="el_config_map_LV_UP">
<textarea data-table="config_map" data-field="x_LV_UP" name="x_LV_UP" id="x_LV_UP" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($config_map->LV_UP->getPlaceHolder()) ?>"<?php echo $config_map->LV_UP->EditAttributes() ?>><?php echo $config_map->LV_UP->EditValue ?></textarea>
</span>
<?php echo $config_map->LV_UP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($config_map->DATETIME->Visible) { // DATETIME ?>
	<div id="r_DATETIME" class="form-group">
		<label id="elh_config_map_DATETIME" for="x_DATETIME" class="<?php echo $config_map_edit->LeftColumnClass ?>"><?php echo $config_map->DATETIME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $config_map_edit->RightColumnClass ?>"><div<?php echo $config_map->DATETIME->CellAttributes() ?>>
<span id="el_config_map_DATETIME">
<input type="text" data-table="config_map" data-field="x_DATETIME" name="x_DATETIME" id="x_DATETIME" placeholder="<?php echo ew_HtmlEncode($config_map->DATETIME->getPlaceHolder()) ?>" value="<?php echo $config_map->DATETIME->EditValue ?>"<?php echo $config_map->DATETIME->EditAttributes() ?>>
</span>
<?php echo $config_map->DATETIME->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="config_map" data-field="x_unid" name="x_unid" id="x_unid" value="<?php echo ew_HtmlEncode($config_map->unid->CurrentValue) ?>">
<?php if (!$config_map_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $config_map_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $config_map_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fconfig_mapedit.Init();
</script>
<?php
$config_map_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_map_edit->Page_Terminate();
?>
