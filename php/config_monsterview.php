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

$config_monster_view = NULL; // Initialize page object first

class cconfig_monster_view extends cconfig_monster {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_monster';

	// Page object name
	var $PageObjName = 'config_monster_view';

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

		// Table object (config_monster)
		if (!isset($GLOBALS["config_monster"]) || get_class($GLOBALS["config_monster"]) == "cconfig_monster") {
			$GLOBALS["config_monster"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_monster"];
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
				$this->Page_Terminate(ew_GetUrl("config_monsterlist.php"));
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
				$sReturnUrl = "config_monsterlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "config_monsterlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "config_monsterlist.php"; // Not page request, return to list
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
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['Monster_Name'] = NULL;
		$row['Monster_Type'] = NULL;
		$row['Monster_AD'] = NULL;
		$row['Monster_AP'] = NULL;
		$row['Monster_HP'] = NULL;
		$row['Monster_Defense'] = NULL;
		$row['Monster_AbsorbHP'] = NULL;
		$row['Monster_ADPTV'] = NULL;
		$row['Monster_ADPTR'] = NULL;
		$row['Monster_APPTR'] = NULL;
		$row['Monster_APPTV'] = NULL;
		$row['Monster_ImmuneDamage'] = NULL;
		$row['Skills'] = NULL;
		$row['Reward_Goods'] = NULL;
		$row['Reward_Exp'] = NULL;
		$row['Reward_Gold'] = NULL;
		$row['Introduce'] = NULL;
		$row['AttackEffect'] = NULL;
		$row['AttackTips'] = NULL;
		$row['MagicResistance'] = NULL;
		$row['Hit'] = NULL;
		$row['Dodge'] = NULL;
		$row['IgnoreShield'] = NULL;
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

		// unid
		$this->unid->ViewValue = $this->unid->CurrentValue;
		$this->unid->ViewCustomAttributes = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_monsterlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_monster_view)) $config_monster_view = new cconfig_monster_view();

// Page init
$config_monster_view->Page_Init();

// Page main
$config_monster_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_monster_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fconfig_monsterview = new ew_Form("fconfig_monsterview", "view");

// Form_CustomValidate event
fconfig_monsterview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_monsterview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $config_monster_view->ExportOptions->Render("body") ?>
<?php
	foreach ($config_monster_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $config_monster_view->ShowPageHeader(); ?>
<?php
$config_monster_view->ShowMessage();
?>
<form name="fconfig_monsterview" id="fconfig_monsterview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_monster_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_monster_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_monster">
<input type="hidden" name="modal" value="<?php echo intval($config_monster_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($config_monster->unid->Visible) { // unid ?>
	<tr id="r_unid">
		<td class="col-sm-2"><span id="elh_config_monster_unid"><?php echo $config_monster->unid->FldCaption() ?></span></td>
		<td data-name="unid"<?php echo $config_monster->unid->CellAttributes() ?>>
<span id="el_config_monster_unid">
<span<?php echo $config_monster->unid->ViewAttributes() ?>>
<?php echo $config_monster->unid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->u_id->Visible) { // u_id ?>
	<tr id="r_u_id">
		<td class="col-sm-2"><span id="elh_config_monster_u_id"><?php echo $config_monster->u_id->FldCaption() ?></span></td>
		<td data-name="u_id"<?php echo $config_monster->u_id->CellAttributes() ?>>
<span id="el_config_monster_u_id">
<span<?php echo $config_monster->u_id->ViewAttributes() ?>>
<?php echo $config_monster->u_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->acl_id->Visible) { // acl_id ?>
	<tr id="r_acl_id">
		<td class="col-sm-2"><span id="elh_config_monster_acl_id"><?php echo $config_monster->acl_id->FldCaption() ?></span></td>
		<td data-name="acl_id"<?php echo $config_monster->acl_id->CellAttributes() ?>>
<span id="el_config_monster_acl_id">
<span<?php echo $config_monster->acl_id->ViewAttributes() ?>>
<?php echo $config_monster->acl_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_Name->Visible) { // Monster_Name ?>
	<tr id="r_Monster_Name">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_Name"><?php echo $config_monster->Monster_Name->FldCaption() ?></span></td>
		<td data-name="Monster_Name"<?php echo $config_monster->Monster_Name->CellAttributes() ?>>
<span id="el_config_monster_Monster_Name">
<span<?php echo $config_monster->Monster_Name->ViewAttributes() ?>>
<?php echo $config_monster->Monster_Name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_Type->Visible) { // Monster_Type ?>
	<tr id="r_Monster_Type">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_Type"><?php echo $config_monster->Monster_Type->FldCaption() ?></span></td>
		<td data-name="Monster_Type"<?php echo $config_monster->Monster_Type->CellAttributes() ?>>
<span id="el_config_monster_Monster_Type">
<span<?php echo $config_monster->Monster_Type->ViewAttributes() ?>>
<?php echo $config_monster->Monster_Type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_AD->Visible) { // Monster_AD ?>
	<tr id="r_Monster_AD">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_AD"><?php echo $config_monster->Monster_AD->FldCaption() ?></span></td>
		<td data-name="Monster_AD"<?php echo $config_monster->Monster_AD->CellAttributes() ?>>
<span id="el_config_monster_Monster_AD">
<span<?php echo $config_monster->Monster_AD->ViewAttributes() ?>>
<?php echo $config_monster->Monster_AD->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_AP->Visible) { // Monster_AP ?>
	<tr id="r_Monster_AP">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_AP"><?php echo $config_monster->Monster_AP->FldCaption() ?></span></td>
		<td data-name="Monster_AP"<?php echo $config_monster->Monster_AP->CellAttributes() ?>>
<span id="el_config_monster_Monster_AP">
<span<?php echo $config_monster->Monster_AP->ViewAttributes() ?>>
<?php echo $config_monster->Monster_AP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_HP->Visible) { // Monster_HP ?>
	<tr id="r_Monster_HP">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_HP"><?php echo $config_monster->Monster_HP->FldCaption() ?></span></td>
		<td data-name="Monster_HP"<?php echo $config_monster->Monster_HP->CellAttributes() ?>>
<span id="el_config_monster_Monster_HP">
<span<?php echo $config_monster->Monster_HP->ViewAttributes() ?>>
<?php echo $config_monster->Monster_HP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_Defense->Visible) { // Monster_Defense ?>
	<tr id="r_Monster_Defense">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_Defense"><?php echo $config_monster->Monster_Defense->FldCaption() ?></span></td>
		<td data-name="Monster_Defense"<?php echo $config_monster->Monster_Defense->CellAttributes() ?>>
<span id="el_config_monster_Monster_Defense">
<span<?php echo $config_monster->Monster_Defense->ViewAttributes() ?>>
<?php echo $config_monster->Monster_Defense->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_AbsorbHP->Visible) { // Monster_AbsorbHP ?>
	<tr id="r_Monster_AbsorbHP">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_AbsorbHP"><?php echo $config_monster->Monster_AbsorbHP->FldCaption() ?></span></td>
		<td data-name="Monster_AbsorbHP"<?php echo $config_monster->Monster_AbsorbHP->CellAttributes() ?>>
<span id="el_config_monster_Monster_AbsorbHP">
<span<?php echo $config_monster->Monster_AbsorbHP->ViewAttributes() ?>>
<?php echo $config_monster->Monster_AbsorbHP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_ADPTV->Visible) { // Monster_ADPTV ?>
	<tr id="r_Monster_ADPTV">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_ADPTV"><?php echo $config_monster->Monster_ADPTV->FldCaption() ?></span></td>
		<td data-name="Monster_ADPTV"<?php echo $config_monster->Monster_ADPTV->CellAttributes() ?>>
<span id="el_config_monster_Monster_ADPTV">
<span<?php echo $config_monster->Monster_ADPTV->ViewAttributes() ?>>
<?php echo $config_monster->Monster_ADPTV->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_ADPTR->Visible) { // Monster_ADPTR ?>
	<tr id="r_Monster_ADPTR">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_ADPTR"><?php echo $config_monster->Monster_ADPTR->FldCaption() ?></span></td>
		<td data-name="Monster_ADPTR"<?php echo $config_monster->Monster_ADPTR->CellAttributes() ?>>
<span id="el_config_monster_Monster_ADPTR">
<span<?php echo $config_monster->Monster_ADPTR->ViewAttributes() ?>>
<?php echo $config_monster->Monster_ADPTR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_APPTR->Visible) { // Monster_APPTR ?>
	<tr id="r_Monster_APPTR">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_APPTR"><?php echo $config_monster->Monster_APPTR->FldCaption() ?></span></td>
		<td data-name="Monster_APPTR"<?php echo $config_monster->Monster_APPTR->CellAttributes() ?>>
<span id="el_config_monster_Monster_APPTR">
<span<?php echo $config_monster->Monster_APPTR->ViewAttributes() ?>>
<?php echo $config_monster->Monster_APPTR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_APPTV->Visible) { // Monster_APPTV ?>
	<tr id="r_Monster_APPTV">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_APPTV"><?php echo $config_monster->Monster_APPTV->FldCaption() ?></span></td>
		<td data-name="Monster_APPTV"<?php echo $config_monster->Monster_APPTV->CellAttributes() ?>>
<span id="el_config_monster_Monster_APPTV">
<span<?php echo $config_monster->Monster_APPTV->ViewAttributes() ?>>
<?php echo $config_monster->Monster_APPTV->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Monster_ImmuneDamage->Visible) { // Monster_ImmuneDamage ?>
	<tr id="r_Monster_ImmuneDamage">
		<td class="col-sm-2"><span id="elh_config_monster_Monster_ImmuneDamage"><?php echo $config_monster->Monster_ImmuneDamage->FldCaption() ?></span></td>
		<td data-name="Monster_ImmuneDamage"<?php echo $config_monster->Monster_ImmuneDamage->CellAttributes() ?>>
<span id="el_config_monster_Monster_ImmuneDamage">
<span<?php echo $config_monster->Monster_ImmuneDamage->ViewAttributes() ?>>
<?php echo $config_monster->Monster_ImmuneDamage->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Skills->Visible) { // Skills ?>
	<tr id="r_Skills">
		<td class="col-sm-2"><span id="elh_config_monster_Skills"><?php echo $config_monster->Skills->FldCaption() ?></span></td>
		<td data-name="Skills"<?php echo $config_monster->Skills->CellAttributes() ?>>
<span id="el_config_monster_Skills">
<span<?php echo $config_monster->Skills->ViewAttributes() ?>>
<?php echo $config_monster->Skills->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Reward_Goods->Visible) { // Reward_Goods ?>
	<tr id="r_Reward_Goods">
		<td class="col-sm-2"><span id="elh_config_monster_Reward_Goods"><?php echo $config_monster->Reward_Goods->FldCaption() ?></span></td>
		<td data-name="Reward_Goods"<?php echo $config_monster->Reward_Goods->CellAttributes() ?>>
<span id="el_config_monster_Reward_Goods">
<span<?php echo $config_monster->Reward_Goods->ViewAttributes() ?>>
<?php echo $config_monster->Reward_Goods->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Reward_Exp->Visible) { // Reward_Exp ?>
	<tr id="r_Reward_Exp">
		<td class="col-sm-2"><span id="elh_config_monster_Reward_Exp"><?php echo $config_monster->Reward_Exp->FldCaption() ?></span></td>
		<td data-name="Reward_Exp"<?php echo $config_monster->Reward_Exp->CellAttributes() ?>>
<span id="el_config_monster_Reward_Exp">
<span<?php echo $config_monster->Reward_Exp->ViewAttributes() ?>>
<?php echo $config_monster->Reward_Exp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Reward_Gold->Visible) { // Reward_Gold ?>
	<tr id="r_Reward_Gold">
		<td class="col-sm-2"><span id="elh_config_monster_Reward_Gold"><?php echo $config_monster->Reward_Gold->FldCaption() ?></span></td>
		<td data-name="Reward_Gold"<?php echo $config_monster->Reward_Gold->CellAttributes() ?>>
<span id="el_config_monster_Reward_Gold">
<span<?php echo $config_monster->Reward_Gold->ViewAttributes() ?>>
<?php echo $config_monster->Reward_Gold->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Introduce->Visible) { // Introduce ?>
	<tr id="r_Introduce">
		<td class="col-sm-2"><span id="elh_config_monster_Introduce"><?php echo $config_monster->Introduce->FldCaption() ?></span></td>
		<td data-name="Introduce"<?php echo $config_monster->Introduce->CellAttributes() ?>>
<span id="el_config_monster_Introduce">
<span<?php echo $config_monster->Introduce->ViewAttributes() ?>>
<?php echo $config_monster->Introduce->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->AttackEffect->Visible) { // AttackEffect ?>
	<tr id="r_AttackEffect">
		<td class="col-sm-2"><span id="elh_config_monster_AttackEffect"><?php echo $config_monster->AttackEffect->FldCaption() ?></span></td>
		<td data-name="AttackEffect"<?php echo $config_monster->AttackEffect->CellAttributes() ?>>
<span id="el_config_monster_AttackEffect">
<span<?php echo $config_monster->AttackEffect->ViewAttributes() ?>>
<?php echo $config_monster->AttackEffect->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->AttackTips->Visible) { // AttackTips ?>
	<tr id="r_AttackTips">
		<td class="col-sm-2"><span id="elh_config_monster_AttackTips"><?php echo $config_monster->AttackTips->FldCaption() ?></span></td>
		<td data-name="AttackTips"<?php echo $config_monster->AttackTips->CellAttributes() ?>>
<span id="el_config_monster_AttackTips">
<span<?php echo $config_monster->AttackTips->ViewAttributes() ?>>
<?php echo $config_monster->AttackTips->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->MagicResistance->Visible) { // MagicResistance ?>
	<tr id="r_MagicResistance">
		<td class="col-sm-2"><span id="elh_config_monster_MagicResistance"><?php echo $config_monster->MagicResistance->FldCaption() ?></span></td>
		<td data-name="MagicResistance"<?php echo $config_monster->MagicResistance->CellAttributes() ?>>
<span id="el_config_monster_MagicResistance">
<span<?php echo $config_monster->MagicResistance->ViewAttributes() ?>>
<?php echo $config_monster->MagicResistance->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Hit->Visible) { // Hit ?>
	<tr id="r_Hit">
		<td class="col-sm-2"><span id="elh_config_monster_Hit"><?php echo $config_monster->Hit->FldCaption() ?></span></td>
		<td data-name="Hit"<?php echo $config_monster->Hit->CellAttributes() ?>>
<span id="el_config_monster_Hit">
<span<?php echo $config_monster->Hit->ViewAttributes() ?>>
<?php echo $config_monster->Hit->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->Dodge->Visible) { // Dodge ?>
	<tr id="r_Dodge">
		<td class="col-sm-2"><span id="elh_config_monster_Dodge"><?php echo $config_monster->Dodge->FldCaption() ?></span></td>
		<td data-name="Dodge"<?php echo $config_monster->Dodge->CellAttributes() ?>>
<span id="el_config_monster_Dodge">
<span<?php echo $config_monster->Dodge->ViewAttributes() ?>>
<?php echo $config_monster->Dodge->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->IgnoreShield->Visible) { // IgnoreShield ?>
	<tr id="r_IgnoreShield">
		<td class="col-sm-2"><span id="elh_config_monster_IgnoreShield"><?php echo $config_monster->IgnoreShield->FldCaption() ?></span></td>
		<td data-name="IgnoreShield"<?php echo $config_monster->IgnoreShield->CellAttributes() ?>>
<span id="el_config_monster_IgnoreShield">
<span<?php echo $config_monster->IgnoreShield->ViewAttributes() ?>>
<?php echo $config_monster->IgnoreShield->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_monster->DATETIME->Visible) { // DATETIME ?>
	<tr id="r_DATETIME">
		<td class="col-sm-2"><span id="elh_config_monster_DATETIME"><?php echo $config_monster->DATETIME->FldCaption() ?></span></td>
		<td data-name="DATETIME"<?php echo $config_monster->DATETIME->CellAttributes() ?>>
<span id="el_config_monster_DATETIME">
<span<?php echo $config_monster->DATETIME->ViewAttributes() ?>>
<?php echo $config_monster->DATETIME->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fconfig_monsterview.Init();
</script>
<?php
$config_monster_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_monster_view->Page_Terminate();
?>
