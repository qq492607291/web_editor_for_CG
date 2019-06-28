<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_skillsinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_skills_view = NULL; // Initialize page object first

class cconfig_skills_view extends cconfig_skills {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_skills';

	// Page object name
	var $PageObjName = 'config_skills_view';

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

		// Table object (config_skills)
		if (!isset($GLOBALS["config_skills"]) || get_class($GLOBALS["config_skills"]) == "cconfig_skills") {
			$GLOBALS["config_skills"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_skills"];
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
			define("EW_TABLE_NAME", 'config_skills', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("config_skillslist.php"));
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
		$this->Type->SetVisibility();
		$this->Consume->SetVisibility();
		$this->Effect->SetVisibility();
		$this->EO->SetVisibility();
		$this->LV->SetVisibility();
		$this->ConsumeType->SetVisibility();
		$this->Cooling->SetVisibility();
		$this->Accurate->SetVisibility();
		$this->AttackTips->SetVisibility();
		$this->Introduce->SetVisibility();
		$this->ACS->SetVisibility();
		$this->Shield->SetVisibility();
		$this->IgnoreShield->SetVisibility();
		$this->IgnoreIM->SetVisibility();
		$this->IgnoreRE->SetVisibility();
		$this->BanAbsorb->SetVisibility();
		$this->BanMultipleShot->SetVisibility();
		$this->ProhibitUO->SetVisibility();
		$this->ConsumableGoods->SetVisibility();
		$this->Continued_Round->SetVisibility();
		$this->Continued_Type->SetVisibility();
		$this->Continued_Effect->SetVisibility();
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
		global $EW_EXPORT, $config_skills;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_skills);
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
					if ($pageName == "config_skillsview.php")
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
				$sReturnUrl = "config_skillslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "config_skillslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "config_skillslist.php"; // Not page request, return to list
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
		$this->Type->setDbValue($row['Type']);
		$this->Consume->setDbValue($row['Consume']);
		$this->Effect->setDbValue($row['Effect']);
		$this->EO->setDbValue($row['EO']);
		$this->LV->setDbValue($row['LV']);
		$this->ConsumeType->setDbValue($row['ConsumeType']);
		$this->Cooling->setDbValue($row['Cooling']);
		$this->Accurate->setDbValue($row['Accurate']);
		$this->AttackTips->setDbValue($row['AttackTips']);
		$this->Introduce->setDbValue($row['Introduce']);
		$this->ACS->setDbValue($row['ACS']);
		$this->Shield->setDbValue($row['Shield']);
		$this->IgnoreShield->setDbValue($row['IgnoreShield']);
		$this->IgnoreIM->setDbValue($row['IgnoreIM']);
		$this->IgnoreRE->setDbValue($row['IgnoreRE']);
		$this->BanAbsorb->setDbValue($row['BanAbsorb']);
		$this->BanMultipleShot->setDbValue($row['BanMultipleShot']);
		$this->ProhibitUO->setDbValue($row['ProhibitUO']);
		$this->ConsumableGoods->setDbValue($row['ConsumableGoods']);
		$this->Continued_Round->setDbValue($row['Continued_Round']);
		$this->Continued_Type->setDbValue($row['Continued_Type']);
		$this->Continued_Effect->setDbValue($row['Continued_Effect']);
		$this->DATETIME->setDbValue($row['DATETIME']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['Name'] = NULL;
		$row['Type'] = NULL;
		$row['Consume'] = NULL;
		$row['Effect'] = NULL;
		$row['EO'] = NULL;
		$row['LV'] = NULL;
		$row['ConsumeType'] = NULL;
		$row['Cooling'] = NULL;
		$row['Accurate'] = NULL;
		$row['AttackTips'] = NULL;
		$row['Introduce'] = NULL;
		$row['ACS'] = NULL;
		$row['Shield'] = NULL;
		$row['IgnoreShield'] = NULL;
		$row['IgnoreIM'] = NULL;
		$row['IgnoreRE'] = NULL;
		$row['BanAbsorb'] = NULL;
		$row['BanMultipleShot'] = NULL;
		$row['ProhibitUO'] = NULL;
		$row['ConsumableGoods'] = NULL;
		$row['Continued_Round'] = NULL;
		$row['Continued_Type'] = NULL;
		$row['Continued_Effect'] = NULL;
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
		$this->Type->DbValue = $row['Type'];
		$this->Consume->DbValue = $row['Consume'];
		$this->Effect->DbValue = $row['Effect'];
		$this->EO->DbValue = $row['EO'];
		$this->LV->DbValue = $row['LV'];
		$this->ConsumeType->DbValue = $row['ConsumeType'];
		$this->Cooling->DbValue = $row['Cooling'];
		$this->Accurate->DbValue = $row['Accurate'];
		$this->AttackTips->DbValue = $row['AttackTips'];
		$this->Introduce->DbValue = $row['Introduce'];
		$this->ACS->DbValue = $row['ACS'];
		$this->Shield->DbValue = $row['Shield'];
		$this->IgnoreShield->DbValue = $row['IgnoreShield'];
		$this->IgnoreIM->DbValue = $row['IgnoreIM'];
		$this->IgnoreRE->DbValue = $row['IgnoreRE'];
		$this->BanAbsorb->DbValue = $row['BanAbsorb'];
		$this->BanMultipleShot->DbValue = $row['BanMultipleShot'];
		$this->ProhibitUO->DbValue = $row['ProhibitUO'];
		$this->ConsumableGoods->DbValue = $row['ConsumableGoods'];
		$this->Continued_Round->DbValue = $row['Continued_Round'];
		$this->Continued_Type->DbValue = $row['Continued_Type'];
		$this->Continued_Effect->DbValue = $row['Continued_Effect'];
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
		// Type
		// Consume
		// Effect
		// EO
		// LV
		// ConsumeType
		// Cooling
		// Accurate
		// AttackTips
		// Introduce
		// ACS
		// Shield
		// IgnoreShield
		// IgnoreIM
		// IgnoreRE
		// BanAbsorb
		// BanMultipleShot
		// ProhibitUO
		// ConsumableGoods
		// Continued_Round
		// Continued_Type
		// Continued_Effect
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

		// Type
		$this->Type->ViewValue = $this->Type->CurrentValue;
		$this->Type->ViewCustomAttributes = "";

		// Consume
		$this->Consume->ViewValue = $this->Consume->CurrentValue;
		$this->Consume->ViewCustomAttributes = "";

		// Effect
		$this->Effect->ViewValue = $this->Effect->CurrentValue;
		$this->Effect->ViewCustomAttributes = "";

		// EO
		$this->EO->ViewValue = $this->EO->CurrentValue;
		$this->EO->ViewCustomAttributes = "";

		// LV
		$this->LV->ViewValue = $this->LV->CurrentValue;
		$this->LV->ViewCustomAttributes = "";

		// ConsumeType
		$this->ConsumeType->ViewValue = $this->ConsumeType->CurrentValue;
		$this->ConsumeType->ViewCustomAttributes = "";

		// Cooling
		$this->Cooling->ViewValue = $this->Cooling->CurrentValue;
		$this->Cooling->ViewCustomAttributes = "";

		// Accurate
		$this->Accurate->ViewValue = $this->Accurate->CurrentValue;
		$this->Accurate->ViewCustomAttributes = "";

		// AttackTips
		$this->AttackTips->ViewValue = $this->AttackTips->CurrentValue;
		$this->AttackTips->ViewCustomAttributes = "";

		// Introduce
		$this->Introduce->ViewValue = $this->Introduce->CurrentValue;
		$this->Introduce->ViewCustomAttributes = "";

		// ACS
		$this->ACS->ViewValue = $this->ACS->CurrentValue;
		$this->ACS->ViewCustomAttributes = "";

		// Shield
		$this->Shield->ViewValue = $this->Shield->CurrentValue;
		$this->Shield->ViewCustomAttributes = "";

		// IgnoreShield
		$this->IgnoreShield->ViewValue = $this->IgnoreShield->CurrentValue;
		$this->IgnoreShield->ViewCustomAttributes = "";

		// IgnoreIM
		$this->IgnoreIM->ViewValue = $this->IgnoreIM->CurrentValue;
		$this->IgnoreIM->ViewCustomAttributes = "";

		// IgnoreRE
		$this->IgnoreRE->ViewValue = $this->IgnoreRE->CurrentValue;
		$this->IgnoreRE->ViewCustomAttributes = "";

		// BanAbsorb
		$this->BanAbsorb->ViewValue = $this->BanAbsorb->CurrentValue;
		$this->BanAbsorb->ViewCustomAttributes = "";

		// BanMultipleShot
		$this->BanMultipleShot->ViewValue = $this->BanMultipleShot->CurrentValue;
		$this->BanMultipleShot->ViewCustomAttributes = "";

		// ProhibitUO
		$this->ProhibitUO->ViewValue = $this->ProhibitUO->CurrentValue;
		$this->ProhibitUO->ViewCustomAttributes = "";

		// ConsumableGoods
		$this->ConsumableGoods->ViewValue = $this->ConsumableGoods->CurrentValue;
		$this->ConsumableGoods->ViewCustomAttributes = "";

		// Continued_Round
		$this->Continued_Round->ViewValue = $this->Continued_Round->CurrentValue;
		$this->Continued_Round->ViewCustomAttributes = "";

		// Continued_Type
		$this->Continued_Type->ViewValue = $this->Continued_Type->CurrentValue;
		$this->Continued_Type->ViewCustomAttributes = "";

		// Continued_Effect
		$this->Continued_Effect->ViewValue = $this->Continued_Effect->CurrentValue;
		$this->Continued_Effect->ViewCustomAttributes = "";

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

			// Type
			$this->Type->LinkCustomAttributes = "";
			$this->Type->HrefValue = "";
			$this->Type->TooltipValue = "";

			// Consume
			$this->Consume->LinkCustomAttributes = "";
			$this->Consume->HrefValue = "";
			$this->Consume->TooltipValue = "";

			// Effect
			$this->Effect->LinkCustomAttributes = "";
			$this->Effect->HrefValue = "";
			$this->Effect->TooltipValue = "";

			// EO
			$this->EO->LinkCustomAttributes = "";
			$this->EO->HrefValue = "";
			$this->EO->TooltipValue = "";

			// LV
			$this->LV->LinkCustomAttributes = "";
			$this->LV->HrefValue = "";
			$this->LV->TooltipValue = "";

			// ConsumeType
			$this->ConsumeType->LinkCustomAttributes = "";
			$this->ConsumeType->HrefValue = "";
			$this->ConsumeType->TooltipValue = "";

			// Cooling
			$this->Cooling->LinkCustomAttributes = "";
			$this->Cooling->HrefValue = "";
			$this->Cooling->TooltipValue = "";

			// Accurate
			$this->Accurate->LinkCustomAttributes = "";
			$this->Accurate->HrefValue = "";
			$this->Accurate->TooltipValue = "";

			// AttackTips
			$this->AttackTips->LinkCustomAttributes = "";
			$this->AttackTips->HrefValue = "";
			$this->AttackTips->TooltipValue = "";

			// Introduce
			$this->Introduce->LinkCustomAttributes = "";
			$this->Introduce->HrefValue = "";
			$this->Introduce->TooltipValue = "";

			// ACS
			$this->ACS->LinkCustomAttributes = "";
			$this->ACS->HrefValue = "";
			$this->ACS->TooltipValue = "";

			// Shield
			$this->Shield->LinkCustomAttributes = "";
			$this->Shield->HrefValue = "";
			$this->Shield->TooltipValue = "";

			// IgnoreShield
			$this->IgnoreShield->LinkCustomAttributes = "";
			$this->IgnoreShield->HrefValue = "";
			$this->IgnoreShield->TooltipValue = "";

			// IgnoreIM
			$this->IgnoreIM->LinkCustomAttributes = "";
			$this->IgnoreIM->HrefValue = "";
			$this->IgnoreIM->TooltipValue = "";

			// IgnoreRE
			$this->IgnoreRE->LinkCustomAttributes = "";
			$this->IgnoreRE->HrefValue = "";
			$this->IgnoreRE->TooltipValue = "";

			// BanAbsorb
			$this->BanAbsorb->LinkCustomAttributes = "";
			$this->BanAbsorb->HrefValue = "";
			$this->BanAbsorb->TooltipValue = "";

			// BanMultipleShot
			$this->BanMultipleShot->LinkCustomAttributes = "";
			$this->BanMultipleShot->HrefValue = "";
			$this->BanMultipleShot->TooltipValue = "";

			// ProhibitUO
			$this->ProhibitUO->LinkCustomAttributes = "";
			$this->ProhibitUO->HrefValue = "";
			$this->ProhibitUO->TooltipValue = "";

			// ConsumableGoods
			$this->ConsumableGoods->LinkCustomAttributes = "";
			$this->ConsumableGoods->HrefValue = "";
			$this->ConsumableGoods->TooltipValue = "";

			// Continued_Round
			$this->Continued_Round->LinkCustomAttributes = "";
			$this->Continued_Round->HrefValue = "";
			$this->Continued_Round->TooltipValue = "";

			// Continued_Type
			$this->Continued_Type->LinkCustomAttributes = "";
			$this->Continued_Type->HrefValue = "";
			$this->Continued_Type->TooltipValue = "";

			// Continued_Effect
			$this->Continued_Effect->LinkCustomAttributes = "";
			$this->Continued_Effect->HrefValue = "";
			$this->Continued_Effect->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_skillslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_skills_view)) $config_skills_view = new cconfig_skills_view();

// Page init
$config_skills_view->Page_Init();

// Page main
$config_skills_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_skills_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fconfig_skillsview = new ew_Form("fconfig_skillsview", "view");

// Form_CustomValidate event
fconfig_skillsview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_skillsview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $config_skills_view->ExportOptions->Render("body") ?>
<?php
	foreach ($config_skills_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $config_skills_view->ShowPageHeader(); ?>
<?php
$config_skills_view->ShowMessage();
?>
<form name="fconfig_skillsview" id="fconfig_skillsview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_skills_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_skills_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_skills">
<input type="hidden" name="modal" value="<?php echo intval($config_skills_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($config_skills->unid->Visible) { // unid ?>
	<tr id="r_unid">
		<td class="col-sm-2"><span id="elh_config_skills_unid"><?php echo $config_skills->unid->FldCaption() ?></span></td>
		<td data-name="unid"<?php echo $config_skills->unid->CellAttributes() ?>>
<span id="el_config_skills_unid">
<span<?php echo $config_skills->unid->ViewAttributes() ?>>
<?php echo $config_skills->unid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->u_id->Visible) { // u_id ?>
	<tr id="r_u_id">
		<td class="col-sm-2"><span id="elh_config_skills_u_id"><?php echo $config_skills->u_id->FldCaption() ?></span></td>
		<td data-name="u_id"<?php echo $config_skills->u_id->CellAttributes() ?>>
<span id="el_config_skills_u_id">
<span<?php echo $config_skills->u_id->ViewAttributes() ?>>
<?php echo $config_skills->u_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->acl_id->Visible) { // acl_id ?>
	<tr id="r_acl_id">
		<td class="col-sm-2"><span id="elh_config_skills_acl_id"><?php echo $config_skills->acl_id->FldCaption() ?></span></td>
		<td data-name="acl_id"<?php echo $config_skills->acl_id->CellAttributes() ?>>
<span id="el_config_skills_acl_id">
<span<?php echo $config_skills->acl_id->ViewAttributes() ?>>
<?php echo $config_skills->acl_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Name->Visible) { // Name ?>
	<tr id="r_Name">
		<td class="col-sm-2"><span id="elh_config_skills_Name"><?php echo $config_skills->Name->FldCaption() ?></span></td>
		<td data-name="Name"<?php echo $config_skills->Name->CellAttributes() ?>>
<span id="el_config_skills_Name">
<span<?php echo $config_skills->Name->ViewAttributes() ?>>
<?php echo $config_skills->Name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Type->Visible) { // Type ?>
	<tr id="r_Type">
		<td class="col-sm-2"><span id="elh_config_skills_Type"><?php echo $config_skills->Type->FldCaption() ?></span></td>
		<td data-name="Type"<?php echo $config_skills->Type->CellAttributes() ?>>
<span id="el_config_skills_Type">
<span<?php echo $config_skills->Type->ViewAttributes() ?>>
<?php echo $config_skills->Type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Consume->Visible) { // Consume ?>
	<tr id="r_Consume">
		<td class="col-sm-2"><span id="elh_config_skills_Consume"><?php echo $config_skills->Consume->FldCaption() ?></span></td>
		<td data-name="Consume"<?php echo $config_skills->Consume->CellAttributes() ?>>
<span id="el_config_skills_Consume">
<span<?php echo $config_skills->Consume->ViewAttributes() ?>>
<?php echo $config_skills->Consume->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Effect->Visible) { // Effect ?>
	<tr id="r_Effect">
		<td class="col-sm-2"><span id="elh_config_skills_Effect"><?php echo $config_skills->Effect->FldCaption() ?></span></td>
		<td data-name="Effect"<?php echo $config_skills->Effect->CellAttributes() ?>>
<span id="el_config_skills_Effect">
<span<?php echo $config_skills->Effect->ViewAttributes() ?>>
<?php echo $config_skills->Effect->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->EO->Visible) { // EO ?>
	<tr id="r_EO">
		<td class="col-sm-2"><span id="elh_config_skills_EO"><?php echo $config_skills->EO->FldCaption() ?></span></td>
		<td data-name="EO"<?php echo $config_skills->EO->CellAttributes() ?>>
<span id="el_config_skills_EO">
<span<?php echo $config_skills->EO->ViewAttributes() ?>>
<?php echo $config_skills->EO->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->LV->Visible) { // LV ?>
	<tr id="r_LV">
		<td class="col-sm-2"><span id="elh_config_skills_LV"><?php echo $config_skills->LV->FldCaption() ?></span></td>
		<td data-name="LV"<?php echo $config_skills->LV->CellAttributes() ?>>
<span id="el_config_skills_LV">
<span<?php echo $config_skills->LV->ViewAttributes() ?>>
<?php echo $config_skills->LV->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->ConsumeType->Visible) { // ConsumeType ?>
	<tr id="r_ConsumeType">
		<td class="col-sm-2"><span id="elh_config_skills_ConsumeType"><?php echo $config_skills->ConsumeType->FldCaption() ?></span></td>
		<td data-name="ConsumeType"<?php echo $config_skills->ConsumeType->CellAttributes() ?>>
<span id="el_config_skills_ConsumeType">
<span<?php echo $config_skills->ConsumeType->ViewAttributes() ?>>
<?php echo $config_skills->ConsumeType->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Cooling->Visible) { // Cooling ?>
	<tr id="r_Cooling">
		<td class="col-sm-2"><span id="elh_config_skills_Cooling"><?php echo $config_skills->Cooling->FldCaption() ?></span></td>
		<td data-name="Cooling"<?php echo $config_skills->Cooling->CellAttributes() ?>>
<span id="el_config_skills_Cooling">
<span<?php echo $config_skills->Cooling->ViewAttributes() ?>>
<?php echo $config_skills->Cooling->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Accurate->Visible) { // Accurate ?>
	<tr id="r_Accurate">
		<td class="col-sm-2"><span id="elh_config_skills_Accurate"><?php echo $config_skills->Accurate->FldCaption() ?></span></td>
		<td data-name="Accurate"<?php echo $config_skills->Accurate->CellAttributes() ?>>
<span id="el_config_skills_Accurate">
<span<?php echo $config_skills->Accurate->ViewAttributes() ?>>
<?php echo $config_skills->Accurate->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->AttackTips->Visible) { // AttackTips ?>
	<tr id="r_AttackTips">
		<td class="col-sm-2"><span id="elh_config_skills_AttackTips"><?php echo $config_skills->AttackTips->FldCaption() ?></span></td>
		<td data-name="AttackTips"<?php echo $config_skills->AttackTips->CellAttributes() ?>>
<span id="el_config_skills_AttackTips">
<span<?php echo $config_skills->AttackTips->ViewAttributes() ?>>
<?php echo $config_skills->AttackTips->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Introduce->Visible) { // Introduce ?>
	<tr id="r_Introduce">
		<td class="col-sm-2"><span id="elh_config_skills_Introduce"><?php echo $config_skills->Introduce->FldCaption() ?></span></td>
		<td data-name="Introduce"<?php echo $config_skills->Introduce->CellAttributes() ?>>
<span id="el_config_skills_Introduce">
<span<?php echo $config_skills->Introduce->ViewAttributes() ?>>
<?php echo $config_skills->Introduce->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->ACS->Visible) { // ACS ?>
	<tr id="r_ACS">
		<td class="col-sm-2"><span id="elh_config_skills_ACS"><?php echo $config_skills->ACS->FldCaption() ?></span></td>
		<td data-name="ACS"<?php echo $config_skills->ACS->CellAttributes() ?>>
<span id="el_config_skills_ACS">
<span<?php echo $config_skills->ACS->ViewAttributes() ?>>
<?php echo $config_skills->ACS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Shield->Visible) { // Shield ?>
	<tr id="r_Shield">
		<td class="col-sm-2"><span id="elh_config_skills_Shield"><?php echo $config_skills->Shield->FldCaption() ?></span></td>
		<td data-name="Shield"<?php echo $config_skills->Shield->CellAttributes() ?>>
<span id="el_config_skills_Shield">
<span<?php echo $config_skills->Shield->ViewAttributes() ?>>
<?php echo $config_skills->Shield->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->IgnoreShield->Visible) { // IgnoreShield ?>
	<tr id="r_IgnoreShield">
		<td class="col-sm-2"><span id="elh_config_skills_IgnoreShield"><?php echo $config_skills->IgnoreShield->FldCaption() ?></span></td>
		<td data-name="IgnoreShield"<?php echo $config_skills->IgnoreShield->CellAttributes() ?>>
<span id="el_config_skills_IgnoreShield">
<span<?php echo $config_skills->IgnoreShield->ViewAttributes() ?>>
<?php echo $config_skills->IgnoreShield->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->IgnoreIM->Visible) { // IgnoreIM ?>
	<tr id="r_IgnoreIM">
		<td class="col-sm-2"><span id="elh_config_skills_IgnoreIM"><?php echo $config_skills->IgnoreIM->FldCaption() ?></span></td>
		<td data-name="IgnoreIM"<?php echo $config_skills->IgnoreIM->CellAttributes() ?>>
<span id="el_config_skills_IgnoreIM">
<span<?php echo $config_skills->IgnoreIM->ViewAttributes() ?>>
<?php echo $config_skills->IgnoreIM->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->IgnoreRE->Visible) { // IgnoreRE ?>
	<tr id="r_IgnoreRE">
		<td class="col-sm-2"><span id="elh_config_skills_IgnoreRE"><?php echo $config_skills->IgnoreRE->FldCaption() ?></span></td>
		<td data-name="IgnoreRE"<?php echo $config_skills->IgnoreRE->CellAttributes() ?>>
<span id="el_config_skills_IgnoreRE">
<span<?php echo $config_skills->IgnoreRE->ViewAttributes() ?>>
<?php echo $config_skills->IgnoreRE->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->BanAbsorb->Visible) { // BanAbsorb ?>
	<tr id="r_BanAbsorb">
		<td class="col-sm-2"><span id="elh_config_skills_BanAbsorb"><?php echo $config_skills->BanAbsorb->FldCaption() ?></span></td>
		<td data-name="BanAbsorb"<?php echo $config_skills->BanAbsorb->CellAttributes() ?>>
<span id="el_config_skills_BanAbsorb">
<span<?php echo $config_skills->BanAbsorb->ViewAttributes() ?>>
<?php echo $config_skills->BanAbsorb->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->BanMultipleShot->Visible) { // BanMultipleShot ?>
	<tr id="r_BanMultipleShot">
		<td class="col-sm-2"><span id="elh_config_skills_BanMultipleShot"><?php echo $config_skills->BanMultipleShot->FldCaption() ?></span></td>
		<td data-name="BanMultipleShot"<?php echo $config_skills->BanMultipleShot->CellAttributes() ?>>
<span id="el_config_skills_BanMultipleShot">
<span<?php echo $config_skills->BanMultipleShot->ViewAttributes() ?>>
<?php echo $config_skills->BanMultipleShot->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->ProhibitUO->Visible) { // ProhibitUO ?>
	<tr id="r_ProhibitUO">
		<td class="col-sm-2"><span id="elh_config_skills_ProhibitUO"><?php echo $config_skills->ProhibitUO->FldCaption() ?></span></td>
		<td data-name="ProhibitUO"<?php echo $config_skills->ProhibitUO->CellAttributes() ?>>
<span id="el_config_skills_ProhibitUO">
<span<?php echo $config_skills->ProhibitUO->ViewAttributes() ?>>
<?php echo $config_skills->ProhibitUO->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->ConsumableGoods->Visible) { // ConsumableGoods ?>
	<tr id="r_ConsumableGoods">
		<td class="col-sm-2"><span id="elh_config_skills_ConsumableGoods"><?php echo $config_skills->ConsumableGoods->FldCaption() ?></span></td>
		<td data-name="ConsumableGoods"<?php echo $config_skills->ConsumableGoods->CellAttributes() ?>>
<span id="el_config_skills_ConsumableGoods">
<span<?php echo $config_skills->ConsumableGoods->ViewAttributes() ?>>
<?php echo $config_skills->ConsumableGoods->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Continued_Round->Visible) { // Continued_Round ?>
	<tr id="r_Continued_Round">
		<td class="col-sm-2"><span id="elh_config_skills_Continued_Round"><?php echo $config_skills->Continued_Round->FldCaption() ?></span></td>
		<td data-name="Continued_Round"<?php echo $config_skills->Continued_Round->CellAttributes() ?>>
<span id="el_config_skills_Continued_Round">
<span<?php echo $config_skills->Continued_Round->ViewAttributes() ?>>
<?php echo $config_skills->Continued_Round->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Continued_Type->Visible) { // Continued_Type ?>
	<tr id="r_Continued_Type">
		<td class="col-sm-2"><span id="elh_config_skills_Continued_Type"><?php echo $config_skills->Continued_Type->FldCaption() ?></span></td>
		<td data-name="Continued_Type"<?php echo $config_skills->Continued_Type->CellAttributes() ?>>
<span id="el_config_skills_Continued_Type">
<span<?php echo $config_skills->Continued_Type->ViewAttributes() ?>>
<?php echo $config_skills->Continued_Type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->Continued_Effect->Visible) { // Continued_Effect ?>
	<tr id="r_Continued_Effect">
		<td class="col-sm-2"><span id="elh_config_skills_Continued_Effect"><?php echo $config_skills->Continued_Effect->FldCaption() ?></span></td>
		<td data-name="Continued_Effect"<?php echo $config_skills->Continued_Effect->CellAttributes() ?>>
<span id="el_config_skills_Continued_Effect">
<span<?php echo $config_skills->Continued_Effect->ViewAttributes() ?>>
<?php echo $config_skills->Continued_Effect->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_skills->DATETIME->Visible) { // DATETIME ?>
	<tr id="r_DATETIME">
		<td class="col-sm-2"><span id="elh_config_skills_DATETIME"><?php echo $config_skills->DATETIME->FldCaption() ?></span></td>
		<td data-name="DATETIME"<?php echo $config_skills->DATETIME->CellAttributes() ?>>
<span id="el_config_skills_DATETIME">
<span<?php echo $config_skills->DATETIME->ViewAttributes() ?>>
<?php echo $config_skills->DATETIME->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fconfig_skillsview.Init();
</script>
<?php
$config_skills_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_skills_view->Page_Terminate();
?>
