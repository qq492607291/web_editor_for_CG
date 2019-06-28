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

$config_task_view = NULL; // Initialize page object first

class cconfig_task_view extends cconfig_task {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_task';

	// Page object name
	var $PageObjName = 'config_task_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["unid"] <> "") {
			$this->RecKey["unid"] = $_GET["unid"];
			$KeyUrl .= "&amp;unid=" . urlencode($this->RecKey["unid"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["unid"] <> "") {
				$this->unid->setQueryStringValue($_GET["unid"]);
				$this->RecKey["unid"] = $this->unid->QueryStringValue;
			} elseif (@$_POST["unid"] <> "") {
				$this->unid->setFormValue($_POST["unid"]);
				$this->RecKey["unid"] = $this->unid->FormValue;
			} else {
				$sReturnUrl = "config_tasklist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "config_tasklist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "config_tasklist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_tasklist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($config_task_view)) $config_task_view = new cconfig_task_view();

// Page init
$config_task_view->Page_Init();

// Page main
$config_task_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_task_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fconfig_taskview = new ew_Form("fconfig_taskview", "view");

// Form_CustomValidate event
fconfig_taskview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_taskview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $config_task_view->ExportOptions->Render("body") ?>
<?php
	foreach ($config_task_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $config_task_view->ShowPageHeader(); ?>
<?php
$config_task_view->ShowMessage();
?>
<form name="fconfig_taskview" id="fconfig_taskview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_task_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_task_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_task">
<input type="hidden" name="modal" value="<?php echo intval($config_task_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($config_task->unid->Visible) { // unid ?>
	<tr id="r_unid">
		<td class="col-sm-2"><span id="elh_config_task_unid"><?php echo $config_task->unid->FldCaption() ?></span></td>
		<td data-name="unid"<?php echo $config_task->unid->CellAttributes() ?>>
<span id="el_config_task_unid">
<span<?php echo $config_task->unid->ViewAttributes() ?>>
<?php echo $config_task->unid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->u_id->Visible) { // u_id ?>
	<tr id="r_u_id">
		<td class="col-sm-2"><span id="elh_config_task_u_id"><?php echo $config_task->u_id->FldCaption() ?></span></td>
		<td data-name="u_id"<?php echo $config_task->u_id->CellAttributes() ?>>
<span id="el_config_task_u_id">
<span<?php echo $config_task->u_id->ViewAttributes() ?>>
<?php echo $config_task->u_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->acl_id->Visible) { // acl_id ?>
	<tr id="r_acl_id">
		<td class="col-sm-2"><span id="elh_config_task_acl_id"><?php echo $config_task->acl_id->FldCaption() ?></span></td>
		<td data-name="acl_id"<?php echo $config_task->acl_id->CellAttributes() ?>>
<span id="el_config_task_acl_id">
<span<?php echo $config_task->acl_id->ViewAttributes() ?>>
<?php echo $config_task->acl_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->Title->Visible) { // Title ?>
	<tr id="r_Title">
		<td class="col-sm-2"><span id="elh_config_task_Title"><?php echo $config_task->Title->FldCaption() ?></span></td>
		<td data-name="Title"<?php echo $config_task->Title->CellAttributes() ?>>
<span id="el_config_task_Title">
<span<?php echo $config_task->Title->ViewAttributes() ?>>
<?php echo $config_task->Title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->LV->Visible) { // LV ?>
	<tr id="r_LV">
		<td class="col-sm-2"><span id="elh_config_task_LV"><?php echo $config_task->LV->FldCaption() ?></span></td>
		<td data-name="LV"<?php echo $config_task->LV->CellAttributes() ?>>
<span id="el_config_task_LV">
<span<?php echo $config_task->LV->ViewAttributes() ?>>
<?php echo $config_task->LV->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->Type->Visible) { // Type ?>
	<tr id="r_Type">
		<td class="col-sm-2"><span id="elh_config_task_Type"><?php echo $config_task->Type->FldCaption() ?></span></td>
		<td data-name="Type"<?php echo $config_task->Type->CellAttributes() ?>>
<span id="el_config_task_Type">
<span<?php echo $config_task->Type->ViewAttributes() ?>>
<?php echo $config_task->Type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->ResetTime->Visible) { // ResetTime ?>
	<tr id="r_ResetTime">
		<td class="col-sm-2"><span id="elh_config_task_ResetTime"><?php echo $config_task->ResetTime->FldCaption() ?></span></td>
		<td data-name="ResetTime"<?php echo $config_task->ResetTime->CellAttributes() ?>>
<span id="el_config_task_ResetTime">
<span<?php echo $config_task->ResetTime->ViewAttributes() ?>>
<?php echo $config_task->ResetTime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->ResetType->Visible) { // ResetType ?>
	<tr id="r_ResetType">
		<td class="col-sm-2"><span id="elh_config_task_ResetType"><?php echo $config_task->ResetType->FldCaption() ?></span></td>
		<td data-name="ResetType"<?php echo $config_task->ResetType->CellAttributes() ?>>
<span id="el_config_task_ResetType">
<span<?php echo $config_task->ResetType->ViewAttributes() ?>>
<?php echo $config_task->ResetType->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->CompleteTask->Visible) { // CompleteTask ?>
	<tr id="r_CompleteTask">
		<td class="col-sm-2"><span id="elh_config_task_CompleteTask"><?php echo $config_task->CompleteTask->FldCaption() ?></span></td>
		<td data-name="CompleteTask"<?php echo $config_task->CompleteTask->CellAttributes() ?>>
<span id="el_config_task_CompleteTask">
<span<?php echo $config_task->CompleteTask->ViewAttributes() ?>>
<?php echo $config_task->CompleteTask->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->Occupation->Visible) { // Occupation ?>
	<tr id="r_Occupation">
		<td class="col-sm-2"><span id="elh_config_task_Occupation"><?php echo $config_task->Occupation->FldCaption() ?></span></td>
		<td data-name="Occupation"<?php echo $config_task->Occupation->CellAttributes() ?>>
<span id="el_config_task_Occupation">
<span<?php echo $config_task->Occupation->ViewAttributes() ?>>
<?php echo $config_task->Occupation->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->Target->Visible) { // Target ?>
	<tr id="r_Target">
		<td class="col-sm-2"><span id="elh_config_task_Target"><?php echo $config_task->Target->FldCaption() ?></span></td>
		<td data-name="Target"<?php echo $config_task->Target->CellAttributes() ?>>
<span id="el_config_task_Target">
<span<?php echo $config_task->Target->ViewAttributes() ?>>
<?php echo $config_task->Target->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->Data->Visible) { // Data ?>
	<tr id="r_Data">
		<td class="col-sm-2"><span id="elh_config_task_Data"><?php echo $config_task->Data->FldCaption() ?></span></td>
		<td data-name="Data"<?php echo $config_task->Data->CellAttributes() ?>>
<span id="el_config_task_Data">
<span<?php echo $config_task->Data->ViewAttributes() ?>>
<?php echo $config_task->Data->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->Reward_Gold->Visible) { // Reward_Gold ?>
	<tr id="r_Reward_Gold">
		<td class="col-sm-2"><span id="elh_config_task_Reward_Gold"><?php echo $config_task->Reward_Gold->FldCaption() ?></span></td>
		<td data-name="Reward_Gold"<?php echo $config_task->Reward_Gold->CellAttributes() ?>>
<span id="el_config_task_Reward_Gold">
<span<?php echo $config_task->Reward_Gold->ViewAttributes() ?>>
<?php echo $config_task->Reward_Gold->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->Reward_Diamonds->Visible) { // Reward_Diamonds ?>
	<tr id="r_Reward_Diamonds">
		<td class="col-sm-2"><span id="elh_config_task_Reward_Diamonds"><?php echo $config_task->Reward_Diamonds->FldCaption() ?></span></td>
		<td data-name="Reward_Diamonds"<?php echo $config_task->Reward_Diamonds->CellAttributes() ?>>
<span id="el_config_task_Reward_Diamonds">
<span<?php echo $config_task->Reward_Diamonds->ViewAttributes() ?>>
<?php echo $config_task->Reward_Diamonds->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->Reward_EXP->Visible) { // Reward_EXP ?>
	<tr id="r_Reward_EXP">
		<td class="col-sm-2"><span id="elh_config_task_Reward_EXP"><?php echo $config_task->Reward_EXP->FldCaption() ?></span></td>
		<td data-name="Reward_EXP"<?php echo $config_task->Reward_EXP->CellAttributes() ?>>
<span id="el_config_task_Reward_EXP">
<span<?php echo $config_task->Reward_EXP->ViewAttributes() ?>>
<?php echo $config_task->Reward_EXP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->Reward_Goods->Visible) { // Reward_Goods ?>
	<tr id="r_Reward_Goods">
		<td class="col-sm-2"><span id="elh_config_task_Reward_Goods"><?php echo $config_task->Reward_Goods->FldCaption() ?></span></td>
		<td data-name="Reward_Goods"<?php echo $config_task->Reward_Goods->CellAttributes() ?>>
<span id="el_config_task_Reward_Goods">
<span<?php echo $config_task->Reward_Goods->ViewAttributes() ?>>
<?php echo $config_task->Reward_Goods->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->Info->Visible) { // Info ?>
	<tr id="r_Info">
		<td class="col-sm-2"><span id="elh_config_task_Info"><?php echo $config_task->Info->FldCaption() ?></span></td>
		<td data-name="Info"<?php echo $config_task->Info->CellAttributes() ?>>
<span id="el_config_task_Info">
<span<?php echo $config_task->Info->ViewAttributes() ?>>
<?php echo $config_task->Info->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_task->DATETIME->Visible) { // DATETIME ?>
	<tr id="r_DATETIME">
		<td class="col-sm-2"><span id="elh_config_task_DATETIME"><?php echo $config_task->DATETIME->FldCaption() ?></span></td>
		<td data-name="DATETIME"<?php echo $config_task->DATETIME->CellAttributes() ?>>
<span id="el_config_task_DATETIME">
<span<?php echo $config_task->DATETIME->ViewAttributes() ?>>
<?php echo $config_task->DATETIME->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fconfig_taskview.Init();
</script>
<?php
$config_task_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_task_view->Page_Terminate();
?>
