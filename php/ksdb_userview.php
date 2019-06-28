<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$ksdb_user_view = NULL; // Initialize page object first

class cksdb_user_view extends cksdb_user {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'ksdb_user';

	// Page object name
	var $PageObjName = 'ksdb_user_view';

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

		// Table object (ksdb_user)
		if (!isset($GLOBALS["ksdb_user"]) || get_class($GLOBALS["ksdb_user"]) == "cksdb_user") {
			$GLOBALS["ksdb_user"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ksdb_user"];
		}
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ksdb_user', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ksdb_userlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->name->SetVisibility();
		$this->pinyin->SetVisibility();
		$this->_email->SetVisibility();
		$this->avatar_small->SetVisibility();
		$this->avatar_normal->SetVisibility();
		$this->level->SetVisibility();
		$this->timeline->SetVisibility();
		$this->settings->SetVisibility();
		$this->is_closed->SetVisibility();
		$this->mobile->SetVisibility();
		$this->tel->SetVisibility();
		$this->eid->SetVisibility();
		$this->weibo->SetVisibility();
		$this->desp->SetVisibility();
		$this->groups->SetVisibility();

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
		global $EW_EXPORT, $ksdb_user;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ksdb_user);
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
					if ($pageName == "ksdb_userview.php")
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
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "ksdb_userlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "ksdb_userlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "ksdb_userlist.php"; // Not page request, return to list
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
		$this->id->setDbValue($row['id']);
		$this->name->setDbValue($row['name']);
		$this->pinyin->setDbValue($row['pinyin']);
		$this->_email->setDbValue($row['email']);
		$this->password->setDbValue($row['password']);
		$this->avatar_small->setDbValue($row['avatar_small']);
		$this->avatar_normal->setDbValue($row['avatar_normal']);
		$this->level->setDbValue($row['level']);
		$this->timeline->setDbValue($row['timeline']);
		$this->settings->setDbValue($row['settings']);
		$this->is_closed->setDbValue($row['is_closed']);
		$this->mobile->setDbValue($row['mobile']);
		$this->tel->setDbValue($row['tel']);
		$this->eid->setDbValue($row['eid']);
		$this->weibo->setDbValue($row['weibo']);
		$this->desp->setDbValue($row['desp']);
		$this->groups->setDbValue($row['groups']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['name'] = NULL;
		$row['pinyin'] = NULL;
		$row['email'] = NULL;
		$row['password'] = NULL;
		$row['avatar_small'] = NULL;
		$row['avatar_normal'] = NULL;
		$row['level'] = NULL;
		$row['timeline'] = NULL;
		$row['settings'] = NULL;
		$row['is_closed'] = NULL;
		$row['mobile'] = NULL;
		$row['tel'] = NULL;
		$row['eid'] = NULL;
		$row['weibo'] = NULL;
		$row['desp'] = NULL;
		$row['groups'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->name->DbValue = $row['name'];
		$this->pinyin->DbValue = $row['pinyin'];
		$this->_email->DbValue = $row['email'];
		$this->password->DbValue = $row['password'];
		$this->avatar_small->DbValue = $row['avatar_small'];
		$this->avatar_normal->DbValue = $row['avatar_normal'];
		$this->level->DbValue = $row['level'];
		$this->timeline->DbValue = $row['timeline'];
		$this->settings->DbValue = $row['settings'];
		$this->is_closed->DbValue = $row['is_closed'];
		$this->mobile->DbValue = $row['mobile'];
		$this->tel->DbValue = $row['tel'];
		$this->eid->DbValue = $row['eid'];
		$this->weibo->DbValue = $row['weibo'];
		$this->desp->DbValue = $row['desp'];
		$this->groups->DbValue = $row['groups'];
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
		// id
		// name
		// pinyin
		// email
		// password
		// avatar_small
		// avatar_normal
		// level
		// timeline
		// settings
		// is_closed
		// mobile
		// tel
		// eid
		// weibo
		// desp
		// groups

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// pinyin
		$this->pinyin->ViewValue = $this->pinyin->CurrentValue;
		$this->pinyin->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// avatar_small
		$this->avatar_small->ViewValue = $this->avatar_small->CurrentValue;
		$this->avatar_small->ViewCustomAttributes = "";

		// avatar_normal
		$this->avatar_normal->ViewValue = $this->avatar_normal->CurrentValue;
		$this->avatar_normal->ViewCustomAttributes = "";

		// level
		$this->level->ViewValue = $this->level->CurrentValue;
		$this->level->ViewCustomAttributes = "";

		// timeline
		$this->timeline->ViewValue = $this->timeline->CurrentValue;
		$this->timeline->ViewValue = ew_FormatDateTime($this->timeline->ViewValue, 0);
		$this->timeline->ViewCustomAttributes = "";

		// settings
		$this->settings->ViewValue = $this->settings->CurrentValue;
		$this->settings->ViewCustomAttributes = "";

		// is_closed
		$this->is_closed->ViewValue = $this->is_closed->CurrentValue;
		$this->is_closed->ViewCustomAttributes = "";

		// mobile
		$this->mobile->ViewValue = $this->mobile->CurrentValue;
		$this->mobile->ViewCustomAttributes = "";

		// tel
		$this->tel->ViewValue = $this->tel->CurrentValue;
		$this->tel->ViewCustomAttributes = "";

		// eid
		$this->eid->ViewValue = $this->eid->CurrentValue;
		$this->eid->ViewCustomAttributes = "";

		// weibo
		$this->weibo->ViewValue = $this->weibo->CurrentValue;
		$this->weibo->ViewCustomAttributes = "";

		// desp
		$this->desp->ViewValue = $this->desp->CurrentValue;
		$this->desp->ViewCustomAttributes = "";

		// groups
		$this->groups->ViewValue = $this->groups->CurrentValue;
		$this->groups->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// pinyin
			$this->pinyin->LinkCustomAttributes = "";
			$this->pinyin->HrefValue = "";
			$this->pinyin->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// avatar_small
			$this->avatar_small->LinkCustomAttributes = "";
			$this->avatar_small->HrefValue = "";
			$this->avatar_small->TooltipValue = "";

			// avatar_normal
			$this->avatar_normal->LinkCustomAttributes = "";
			$this->avatar_normal->HrefValue = "";
			$this->avatar_normal->TooltipValue = "";

			// level
			$this->level->LinkCustomAttributes = "";
			$this->level->HrefValue = "";
			$this->level->TooltipValue = "";

			// timeline
			$this->timeline->LinkCustomAttributes = "";
			$this->timeline->HrefValue = "";
			$this->timeline->TooltipValue = "";

			// settings
			$this->settings->LinkCustomAttributes = "";
			$this->settings->HrefValue = "";
			$this->settings->TooltipValue = "";

			// is_closed
			$this->is_closed->LinkCustomAttributes = "";
			$this->is_closed->HrefValue = "";
			$this->is_closed->TooltipValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";
			$this->mobile->TooltipValue = "";

			// tel
			$this->tel->LinkCustomAttributes = "";
			$this->tel->HrefValue = "";
			$this->tel->TooltipValue = "";

			// eid
			$this->eid->LinkCustomAttributes = "";
			$this->eid->HrefValue = "";
			$this->eid->TooltipValue = "";

			// weibo
			$this->weibo->LinkCustomAttributes = "";
			$this->weibo->HrefValue = "";
			$this->weibo->TooltipValue = "";

			// desp
			$this->desp->LinkCustomAttributes = "";
			$this->desp->HrefValue = "";
			$this->desp->TooltipValue = "";

			// groups
			$this->groups->LinkCustomAttributes = "";
			$this->groups->HrefValue = "";
			$this->groups->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ksdb_userlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ksdb_user_view)) $ksdb_user_view = new cksdb_user_view();

// Page init
$ksdb_user_view->Page_Init();

// Page main
$ksdb_user_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ksdb_user_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fksdb_userview = new ew_Form("fksdb_userview", "view");

// Form_CustomValidate event
fksdb_userview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fksdb_userview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $ksdb_user_view->ExportOptions->Render("body") ?>
<?php
	foreach ($ksdb_user_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $ksdb_user_view->ShowPageHeader(); ?>
<?php
$ksdb_user_view->ShowMessage();
?>
<form name="fksdb_userview" id="fksdb_userview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ksdb_user_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ksdb_user_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ksdb_user">
<input type="hidden" name="modal" value="<?php echo intval($ksdb_user_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($ksdb_user->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="col-sm-2"><span id="elh_ksdb_user_id"><?php echo $ksdb_user->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $ksdb_user->id->CellAttributes() ?>>
<span id="el_ksdb_user_id">
<span<?php echo $ksdb_user->id->ViewAttributes() ?>>
<?php echo $ksdb_user->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->name->Visible) { // name ?>
	<tr id="r_name">
		<td class="col-sm-2"><span id="elh_ksdb_user_name"><?php echo $ksdb_user->name->FldCaption() ?></span></td>
		<td data-name="name"<?php echo $ksdb_user->name->CellAttributes() ?>>
<span id="el_ksdb_user_name">
<span<?php echo $ksdb_user->name->ViewAttributes() ?>>
<?php echo $ksdb_user->name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->pinyin->Visible) { // pinyin ?>
	<tr id="r_pinyin">
		<td class="col-sm-2"><span id="elh_ksdb_user_pinyin"><?php echo $ksdb_user->pinyin->FldCaption() ?></span></td>
		<td data-name="pinyin"<?php echo $ksdb_user->pinyin->CellAttributes() ?>>
<span id="el_ksdb_user_pinyin">
<span<?php echo $ksdb_user->pinyin->ViewAttributes() ?>>
<?php echo $ksdb_user->pinyin->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->_email->Visible) { // email ?>
	<tr id="r__email">
		<td class="col-sm-2"><span id="elh_ksdb_user__email"><?php echo $ksdb_user->_email->FldCaption() ?></span></td>
		<td data-name="_email"<?php echo $ksdb_user->_email->CellAttributes() ?>>
<span id="el_ksdb_user__email">
<span<?php echo $ksdb_user->_email->ViewAttributes() ?>>
<?php echo $ksdb_user->_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->avatar_small->Visible) { // avatar_small ?>
	<tr id="r_avatar_small">
		<td class="col-sm-2"><span id="elh_ksdb_user_avatar_small"><?php echo $ksdb_user->avatar_small->FldCaption() ?></span></td>
		<td data-name="avatar_small"<?php echo $ksdb_user->avatar_small->CellAttributes() ?>>
<span id="el_ksdb_user_avatar_small">
<span<?php echo $ksdb_user->avatar_small->ViewAttributes() ?>>
<?php echo $ksdb_user->avatar_small->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->avatar_normal->Visible) { // avatar_normal ?>
	<tr id="r_avatar_normal">
		<td class="col-sm-2"><span id="elh_ksdb_user_avatar_normal"><?php echo $ksdb_user->avatar_normal->FldCaption() ?></span></td>
		<td data-name="avatar_normal"<?php echo $ksdb_user->avatar_normal->CellAttributes() ?>>
<span id="el_ksdb_user_avatar_normal">
<span<?php echo $ksdb_user->avatar_normal->ViewAttributes() ?>>
<?php echo $ksdb_user->avatar_normal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->level->Visible) { // level ?>
	<tr id="r_level">
		<td class="col-sm-2"><span id="elh_ksdb_user_level"><?php echo $ksdb_user->level->FldCaption() ?></span></td>
		<td data-name="level"<?php echo $ksdb_user->level->CellAttributes() ?>>
<span id="el_ksdb_user_level">
<span<?php echo $ksdb_user->level->ViewAttributes() ?>>
<?php echo $ksdb_user->level->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->timeline->Visible) { // timeline ?>
	<tr id="r_timeline">
		<td class="col-sm-2"><span id="elh_ksdb_user_timeline"><?php echo $ksdb_user->timeline->FldCaption() ?></span></td>
		<td data-name="timeline"<?php echo $ksdb_user->timeline->CellAttributes() ?>>
<span id="el_ksdb_user_timeline">
<span<?php echo $ksdb_user->timeline->ViewAttributes() ?>>
<?php echo $ksdb_user->timeline->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->settings->Visible) { // settings ?>
	<tr id="r_settings">
		<td class="col-sm-2"><span id="elh_ksdb_user_settings"><?php echo $ksdb_user->settings->FldCaption() ?></span></td>
		<td data-name="settings"<?php echo $ksdb_user->settings->CellAttributes() ?>>
<span id="el_ksdb_user_settings">
<span<?php echo $ksdb_user->settings->ViewAttributes() ?>>
<?php echo $ksdb_user->settings->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->is_closed->Visible) { // is_closed ?>
	<tr id="r_is_closed">
		<td class="col-sm-2"><span id="elh_ksdb_user_is_closed"><?php echo $ksdb_user->is_closed->FldCaption() ?></span></td>
		<td data-name="is_closed"<?php echo $ksdb_user->is_closed->CellAttributes() ?>>
<span id="el_ksdb_user_is_closed">
<span<?php echo $ksdb_user->is_closed->ViewAttributes() ?>>
<?php echo $ksdb_user->is_closed->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->mobile->Visible) { // mobile ?>
	<tr id="r_mobile">
		<td class="col-sm-2"><span id="elh_ksdb_user_mobile"><?php echo $ksdb_user->mobile->FldCaption() ?></span></td>
		<td data-name="mobile"<?php echo $ksdb_user->mobile->CellAttributes() ?>>
<span id="el_ksdb_user_mobile">
<span<?php echo $ksdb_user->mobile->ViewAttributes() ?>>
<?php echo $ksdb_user->mobile->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->tel->Visible) { // tel ?>
	<tr id="r_tel">
		<td class="col-sm-2"><span id="elh_ksdb_user_tel"><?php echo $ksdb_user->tel->FldCaption() ?></span></td>
		<td data-name="tel"<?php echo $ksdb_user->tel->CellAttributes() ?>>
<span id="el_ksdb_user_tel">
<span<?php echo $ksdb_user->tel->ViewAttributes() ?>>
<?php echo $ksdb_user->tel->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->eid->Visible) { // eid ?>
	<tr id="r_eid">
		<td class="col-sm-2"><span id="elh_ksdb_user_eid"><?php echo $ksdb_user->eid->FldCaption() ?></span></td>
		<td data-name="eid"<?php echo $ksdb_user->eid->CellAttributes() ?>>
<span id="el_ksdb_user_eid">
<span<?php echo $ksdb_user->eid->ViewAttributes() ?>>
<?php echo $ksdb_user->eid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->weibo->Visible) { // weibo ?>
	<tr id="r_weibo">
		<td class="col-sm-2"><span id="elh_ksdb_user_weibo"><?php echo $ksdb_user->weibo->FldCaption() ?></span></td>
		<td data-name="weibo"<?php echo $ksdb_user->weibo->CellAttributes() ?>>
<span id="el_ksdb_user_weibo">
<span<?php echo $ksdb_user->weibo->ViewAttributes() ?>>
<?php echo $ksdb_user->weibo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->desp->Visible) { // desp ?>
	<tr id="r_desp">
		<td class="col-sm-2"><span id="elh_ksdb_user_desp"><?php echo $ksdb_user->desp->FldCaption() ?></span></td>
		<td data-name="desp"<?php echo $ksdb_user->desp->CellAttributes() ?>>
<span id="el_ksdb_user_desp">
<span<?php echo $ksdb_user->desp->ViewAttributes() ?>>
<?php echo $ksdb_user->desp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ksdb_user->groups->Visible) { // groups ?>
	<tr id="r_groups">
		<td class="col-sm-2"><span id="elh_ksdb_user_groups"><?php echo $ksdb_user->groups->FldCaption() ?></span></td>
		<td data-name="groups"<?php echo $ksdb_user->groups->CellAttributes() ?>>
<span id="el_ksdb_user_groups">
<span<?php echo $ksdb_user->groups->ViewAttributes() ?>>
<?php echo $ksdb_user->groups->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fksdb_userview.Init();
</script>
<?php
$ksdb_user_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ksdb_user_view->Page_Terminate();
?>
