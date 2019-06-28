<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_suitinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_suit_view = NULL; // Initialize page object first

class cconfig_suit_view extends cconfig_suit {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_suit';

	// Page object name
	var $PageObjName = 'config_suit_view';

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

		// Table object (config_suit)
		if (!isset($GLOBALS["config_suit"]) || get_class($GLOBALS["config_suit"]) == "cconfig_suit") {
			$GLOBALS["config_suit"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_suit"];
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
			define("EW_TABLE_NAME", 'config_suit', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("config_suitlist.php"));
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
		$this->Name->SetVisibility();
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
		global $EW_EXPORT, $config_suit;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_suit);
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
					if ($pageName == "config_suitview.php")
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
				$sReturnUrl = "config_suitlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "config_suitlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "config_suitlist.php"; // Not page request, return to list
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
		$this->Name->setDbValue($row['Name']);
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
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['Name'] = NULL;
		$row['Add_HP'] = NULL;
		$row['Add_MP'] = NULL;
		$row['Add_Defense'] = NULL;
		$row['Add_Magic'] = NULL;
		$row['Add_AD'] = NULL;
		$row['Add_AP'] = NULL;
		$row['Add_Hit'] = NULL;
		$row['Add_Dodge'] = NULL;
		$row['Add_Crit'] = NULL;
		$row['Add_AbsorbHP'] = NULL;
		$row['Add_ADPTV'] = NULL;
		$row['Add_ADPTR'] = NULL;
		$row['Add_APPTR'] = NULL;
		$row['Add_APPTV'] = NULL;
		$row['Add_ImmuneDamage'] = NULL;
		$row['Special_Type'] = NULL;
		$row['Special_Value'] = NULL;
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
		// Name
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

		// Name
		$this->Name->ViewValue = $this->Name->CurrentValue;
		$this->Name->ViewCustomAttributes = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_suitlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_suit_view)) $config_suit_view = new cconfig_suit_view();

// Page init
$config_suit_view->Page_Init();

// Page main
$config_suit_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_suit_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fconfig_suitview = new ew_Form("fconfig_suitview", "view");

// Form_CustomValidate event
fconfig_suitview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_suitview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $config_suit_view->ExportOptions->Render("body") ?>
<?php
	foreach ($config_suit_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $config_suit_view->ShowPageHeader(); ?>
<?php
$config_suit_view->ShowMessage();
?>
<form name="fconfig_suitview" id="fconfig_suitview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_suit_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_suit_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_suit">
<input type="hidden" name="modal" value="<?php echo intval($config_suit_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($config_suit->unid->Visible) { // unid ?>
	<tr id="r_unid">
		<td class="col-sm-2"><span id="elh_config_suit_unid"><?php echo $config_suit->unid->FldCaption() ?></span></td>
		<td data-name="unid"<?php echo $config_suit->unid->CellAttributes() ?>>
<span id="el_config_suit_unid">
<span<?php echo $config_suit->unid->ViewAttributes() ?>>
<?php echo $config_suit->unid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->u_id->Visible) { // u_id ?>
	<tr id="r_u_id">
		<td class="col-sm-2"><span id="elh_config_suit_u_id"><?php echo $config_suit->u_id->FldCaption() ?></span></td>
		<td data-name="u_id"<?php echo $config_suit->u_id->CellAttributes() ?>>
<span id="el_config_suit_u_id">
<span<?php echo $config_suit->u_id->ViewAttributes() ?>>
<?php echo $config_suit->u_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->acl_id->Visible) { // acl_id ?>
	<tr id="r_acl_id">
		<td class="col-sm-2"><span id="elh_config_suit_acl_id"><?php echo $config_suit->acl_id->FldCaption() ?></span></td>
		<td data-name="acl_id"<?php echo $config_suit->acl_id->CellAttributes() ?>>
<span id="el_config_suit_acl_id">
<span<?php echo $config_suit->acl_id->ViewAttributes() ?>>
<?php echo $config_suit->acl_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Name->Visible) { // Name ?>
	<tr id="r_Name">
		<td class="col-sm-2"><span id="elh_config_suit_Name"><?php echo $config_suit->Name->FldCaption() ?></span></td>
		<td data-name="Name"<?php echo $config_suit->Name->CellAttributes() ?>>
<span id="el_config_suit_Name">
<span<?php echo $config_suit->Name->ViewAttributes() ?>>
<?php echo $config_suit->Name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_HP->Visible) { // Add_HP ?>
	<tr id="r_Add_HP">
		<td class="col-sm-2"><span id="elh_config_suit_Add_HP"><?php echo $config_suit->Add_HP->FldCaption() ?></span></td>
		<td data-name="Add_HP"<?php echo $config_suit->Add_HP->CellAttributes() ?>>
<span id="el_config_suit_Add_HP">
<span<?php echo $config_suit->Add_HP->ViewAttributes() ?>>
<?php echo $config_suit->Add_HP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_MP->Visible) { // Add_MP ?>
	<tr id="r_Add_MP">
		<td class="col-sm-2"><span id="elh_config_suit_Add_MP"><?php echo $config_suit->Add_MP->FldCaption() ?></span></td>
		<td data-name="Add_MP"<?php echo $config_suit->Add_MP->CellAttributes() ?>>
<span id="el_config_suit_Add_MP">
<span<?php echo $config_suit->Add_MP->ViewAttributes() ?>>
<?php echo $config_suit->Add_MP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_Defense->Visible) { // Add_Defense ?>
	<tr id="r_Add_Defense">
		<td class="col-sm-2"><span id="elh_config_suit_Add_Defense"><?php echo $config_suit->Add_Defense->FldCaption() ?></span></td>
		<td data-name="Add_Defense"<?php echo $config_suit->Add_Defense->CellAttributes() ?>>
<span id="el_config_suit_Add_Defense">
<span<?php echo $config_suit->Add_Defense->ViewAttributes() ?>>
<?php echo $config_suit->Add_Defense->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_Magic->Visible) { // Add_Magic ?>
	<tr id="r_Add_Magic">
		<td class="col-sm-2"><span id="elh_config_suit_Add_Magic"><?php echo $config_suit->Add_Magic->FldCaption() ?></span></td>
		<td data-name="Add_Magic"<?php echo $config_suit->Add_Magic->CellAttributes() ?>>
<span id="el_config_suit_Add_Magic">
<span<?php echo $config_suit->Add_Magic->ViewAttributes() ?>>
<?php echo $config_suit->Add_Magic->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_AD->Visible) { // Add_AD ?>
	<tr id="r_Add_AD">
		<td class="col-sm-2"><span id="elh_config_suit_Add_AD"><?php echo $config_suit->Add_AD->FldCaption() ?></span></td>
		<td data-name="Add_AD"<?php echo $config_suit->Add_AD->CellAttributes() ?>>
<span id="el_config_suit_Add_AD">
<span<?php echo $config_suit->Add_AD->ViewAttributes() ?>>
<?php echo $config_suit->Add_AD->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_AP->Visible) { // Add_AP ?>
	<tr id="r_Add_AP">
		<td class="col-sm-2"><span id="elh_config_suit_Add_AP"><?php echo $config_suit->Add_AP->FldCaption() ?></span></td>
		<td data-name="Add_AP"<?php echo $config_suit->Add_AP->CellAttributes() ?>>
<span id="el_config_suit_Add_AP">
<span<?php echo $config_suit->Add_AP->ViewAttributes() ?>>
<?php echo $config_suit->Add_AP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_Hit->Visible) { // Add_Hit ?>
	<tr id="r_Add_Hit">
		<td class="col-sm-2"><span id="elh_config_suit_Add_Hit"><?php echo $config_suit->Add_Hit->FldCaption() ?></span></td>
		<td data-name="Add_Hit"<?php echo $config_suit->Add_Hit->CellAttributes() ?>>
<span id="el_config_suit_Add_Hit">
<span<?php echo $config_suit->Add_Hit->ViewAttributes() ?>>
<?php echo $config_suit->Add_Hit->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_Dodge->Visible) { // Add_Dodge ?>
	<tr id="r_Add_Dodge">
		<td class="col-sm-2"><span id="elh_config_suit_Add_Dodge"><?php echo $config_suit->Add_Dodge->FldCaption() ?></span></td>
		<td data-name="Add_Dodge"<?php echo $config_suit->Add_Dodge->CellAttributes() ?>>
<span id="el_config_suit_Add_Dodge">
<span<?php echo $config_suit->Add_Dodge->ViewAttributes() ?>>
<?php echo $config_suit->Add_Dodge->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_Crit->Visible) { // Add_Crit ?>
	<tr id="r_Add_Crit">
		<td class="col-sm-2"><span id="elh_config_suit_Add_Crit"><?php echo $config_suit->Add_Crit->FldCaption() ?></span></td>
		<td data-name="Add_Crit"<?php echo $config_suit->Add_Crit->CellAttributes() ?>>
<span id="el_config_suit_Add_Crit">
<span<?php echo $config_suit->Add_Crit->ViewAttributes() ?>>
<?php echo $config_suit->Add_Crit->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_AbsorbHP->Visible) { // Add_AbsorbHP ?>
	<tr id="r_Add_AbsorbHP">
		<td class="col-sm-2"><span id="elh_config_suit_Add_AbsorbHP"><?php echo $config_suit->Add_AbsorbHP->FldCaption() ?></span></td>
		<td data-name="Add_AbsorbHP"<?php echo $config_suit->Add_AbsorbHP->CellAttributes() ?>>
<span id="el_config_suit_Add_AbsorbHP">
<span<?php echo $config_suit->Add_AbsorbHP->ViewAttributes() ?>>
<?php echo $config_suit->Add_AbsorbHP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_ADPTV->Visible) { // Add_ADPTV ?>
	<tr id="r_Add_ADPTV">
		<td class="col-sm-2"><span id="elh_config_suit_Add_ADPTV"><?php echo $config_suit->Add_ADPTV->FldCaption() ?></span></td>
		<td data-name="Add_ADPTV"<?php echo $config_suit->Add_ADPTV->CellAttributes() ?>>
<span id="el_config_suit_Add_ADPTV">
<span<?php echo $config_suit->Add_ADPTV->ViewAttributes() ?>>
<?php echo $config_suit->Add_ADPTV->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_ADPTR->Visible) { // Add_ADPTR ?>
	<tr id="r_Add_ADPTR">
		<td class="col-sm-2"><span id="elh_config_suit_Add_ADPTR"><?php echo $config_suit->Add_ADPTR->FldCaption() ?></span></td>
		<td data-name="Add_ADPTR"<?php echo $config_suit->Add_ADPTR->CellAttributes() ?>>
<span id="el_config_suit_Add_ADPTR">
<span<?php echo $config_suit->Add_ADPTR->ViewAttributes() ?>>
<?php echo $config_suit->Add_ADPTR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_APPTR->Visible) { // Add_APPTR ?>
	<tr id="r_Add_APPTR">
		<td class="col-sm-2"><span id="elh_config_suit_Add_APPTR"><?php echo $config_suit->Add_APPTR->FldCaption() ?></span></td>
		<td data-name="Add_APPTR"<?php echo $config_suit->Add_APPTR->CellAttributes() ?>>
<span id="el_config_suit_Add_APPTR">
<span<?php echo $config_suit->Add_APPTR->ViewAttributes() ?>>
<?php echo $config_suit->Add_APPTR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_APPTV->Visible) { // Add_APPTV ?>
	<tr id="r_Add_APPTV">
		<td class="col-sm-2"><span id="elh_config_suit_Add_APPTV"><?php echo $config_suit->Add_APPTV->FldCaption() ?></span></td>
		<td data-name="Add_APPTV"<?php echo $config_suit->Add_APPTV->CellAttributes() ?>>
<span id="el_config_suit_Add_APPTV">
<span<?php echo $config_suit->Add_APPTV->ViewAttributes() ?>>
<?php echo $config_suit->Add_APPTV->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Add_ImmuneDamage->Visible) { // Add_ImmuneDamage ?>
	<tr id="r_Add_ImmuneDamage">
		<td class="col-sm-2"><span id="elh_config_suit_Add_ImmuneDamage"><?php echo $config_suit->Add_ImmuneDamage->FldCaption() ?></span></td>
		<td data-name="Add_ImmuneDamage"<?php echo $config_suit->Add_ImmuneDamage->CellAttributes() ?>>
<span id="el_config_suit_Add_ImmuneDamage">
<span<?php echo $config_suit->Add_ImmuneDamage->ViewAttributes() ?>>
<?php echo $config_suit->Add_ImmuneDamage->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Special_Type->Visible) { // Special_Type ?>
	<tr id="r_Special_Type">
		<td class="col-sm-2"><span id="elh_config_suit_Special_Type"><?php echo $config_suit->Special_Type->FldCaption() ?></span></td>
		<td data-name="Special_Type"<?php echo $config_suit->Special_Type->CellAttributes() ?>>
<span id="el_config_suit_Special_Type">
<span<?php echo $config_suit->Special_Type->ViewAttributes() ?>>
<?php echo $config_suit->Special_Type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->Special_Value->Visible) { // Special_Value ?>
	<tr id="r_Special_Value">
		<td class="col-sm-2"><span id="elh_config_suit_Special_Value"><?php echo $config_suit->Special_Value->FldCaption() ?></span></td>
		<td data-name="Special_Value"<?php echo $config_suit->Special_Value->CellAttributes() ?>>
<span id="el_config_suit_Special_Value">
<span<?php echo $config_suit->Special_Value->ViewAttributes() ?>>
<?php echo $config_suit->Special_Value->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_suit->DATETIME->Visible) { // DATETIME ?>
	<tr id="r_DATETIME">
		<td class="col-sm-2"><span id="elh_config_suit_DATETIME"><?php echo $config_suit->DATETIME->FldCaption() ?></span></td>
		<td data-name="DATETIME"<?php echo $config_suit->DATETIME->CellAttributes() ?>>
<span id="el_config_suit_DATETIME">
<span<?php echo $config_suit->DATETIME->ViewAttributes() ?>>
<?php echo $config_suit->DATETIME->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fconfig_suitview.Init();
</script>
<?php
$config_suit_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_suit_view->Page_Terminate();
?>
