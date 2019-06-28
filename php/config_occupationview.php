<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "config_occupationinfo.php" ?>
<?php include_once "ksdb_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$config_occupation_view = NULL; // Initialize page object first

class cconfig_occupation_view extends cconfig_occupation {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_occupation';

	// Page object name
	var $PageObjName = 'config_occupation_view';

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

		// Table object (config_occupation)
		if (!isset($GLOBALS["config_occupation"]) || get_class($GLOBALS["config_occupation"]) == "cconfig_occupation") {
			$GLOBALS["config_occupation"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_occupation"];
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
			define("EW_TABLE_NAME", 'config_occupation', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("config_occupationlist.php"));
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
		$this->Basics->SetVisibility();
		$this->HP->SetVisibility();
		$this->MP->SetVisibility();
		$this->AD->SetVisibility();
		$this->AP->SetVisibility();
		$this->Defense->SetVisibility();
		$this->Hit->SetVisibility();
		$this->Dodge->SetVisibility();
		$this->Crit->SetVisibility();
		$this->AbsorbHP->SetVisibility();
		$this->ADPTV->SetVisibility();
		$this->ADPTR->SetVisibility();
		$this->APPTR->SetVisibility();
		$this->APPTV->SetVisibility();
		$this->ImmuneDamage->SetVisibility();
		$this->Intro->SetVisibility();
		$this->ExclusiveSkills->SetVisibility();
		$this->TransferDemand->SetVisibility();
		$this->TransferLevel->SetVisibility();
		$this->FormerOccupation->SetVisibility();
		$this->Belong->SetVisibility();
		$this->AttackEffect->SetVisibility();
		$this->AttackTips->SetVisibility();
		$this->MagicResistance->SetVisibility();
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
		global $EW_EXPORT, $config_occupation;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($config_occupation);
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
					if ($pageName == "config_occupationview.php")
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
				$sReturnUrl = "config_occupationlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "config_occupationlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "config_occupationlist.php"; // Not page request, return to list
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
		$this->Basics->setDbValue($row['Basics']);
		$this->HP->setDbValue($row['HP']);
		$this->MP->setDbValue($row['MP']);
		$this->AD->setDbValue($row['AD']);
		$this->AP->setDbValue($row['AP']);
		$this->Defense->setDbValue($row['Defense']);
		$this->Hit->setDbValue($row['Hit']);
		$this->Dodge->setDbValue($row['Dodge']);
		$this->Crit->setDbValue($row['Crit']);
		$this->AbsorbHP->setDbValue($row['AbsorbHP']);
		$this->ADPTV->setDbValue($row['ADPTV']);
		$this->ADPTR->setDbValue($row['ADPTR']);
		$this->APPTR->setDbValue($row['APPTR']);
		$this->APPTV->setDbValue($row['APPTV']);
		$this->ImmuneDamage->setDbValue($row['ImmuneDamage']);
		$this->Intro->setDbValue($row['Intro']);
		$this->ExclusiveSkills->setDbValue($row['ExclusiveSkills']);
		$this->TransferDemand->setDbValue($row['TransferDemand']);
		$this->TransferLevel->setDbValue($row['TransferLevel']);
		$this->FormerOccupation->setDbValue($row['FormerOccupation']);
		$this->Belong->setDbValue($row['Belong']);
		$this->AttackEffect->setDbValue($row['AttackEffect']);
		$this->AttackTips->setDbValue($row['AttackTips']);
		$this->MagicResistance->setDbValue($row['MagicResistance']);
		$this->IgnoreShield->setDbValue($row['IgnoreShield']);
		$this->DATETIME->setDbValue($row['DATETIME']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['Name'] = NULL;
		$row['Basics'] = NULL;
		$row['HP'] = NULL;
		$row['MP'] = NULL;
		$row['AD'] = NULL;
		$row['AP'] = NULL;
		$row['Defense'] = NULL;
		$row['Hit'] = NULL;
		$row['Dodge'] = NULL;
		$row['Crit'] = NULL;
		$row['AbsorbHP'] = NULL;
		$row['ADPTV'] = NULL;
		$row['ADPTR'] = NULL;
		$row['APPTR'] = NULL;
		$row['APPTV'] = NULL;
		$row['ImmuneDamage'] = NULL;
		$row['Intro'] = NULL;
		$row['ExclusiveSkills'] = NULL;
		$row['TransferDemand'] = NULL;
		$row['TransferLevel'] = NULL;
		$row['FormerOccupation'] = NULL;
		$row['Belong'] = NULL;
		$row['AttackEffect'] = NULL;
		$row['AttackTips'] = NULL;
		$row['MagicResistance'] = NULL;
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
		$this->Name->DbValue = $row['Name'];
		$this->Basics->DbValue = $row['Basics'];
		$this->HP->DbValue = $row['HP'];
		$this->MP->DbValue = $row['MP'];
		$this->AD->DbValue = $row['AD'];
		$this->AP->DbValue = $row['AP'];
		$this->Defense->DbValue = $row['Defense'];
		$this->Hit->DbValue = $row['Hit'];
		$this->Dodge->DbValue = $row['Dodge'];
		$this->Crit->DbValue = $row['Crit'];
		$this->AbsorbHP->DbValue = $row['AbsorbHP'];
		$this->ADPTV->DbValue = $row['ADPTV'];
		$this->ADPTR->DbValue = $row['ADPTR'];
		$this->APPTR->DbValue = $row['APPTR'];
		$this->APPTV->DbValue = $row['APPTV'];
		$this->ImmuneDamage->DbValue = $row['ImmuneDamage'];
		$this->Intro->DbValue = $row['Intro'];
		$this->ExclusiveSkills->DbValue = $row['ExclusiveSkills'];
		$this->TransferDemand->DbValue = $row['TransferDemand'];
		$this->TransferLevel->DbValue = $row['TransferLevel'];
		$this->FormerOccupation->DbValue = $row['FormerOccupation'];
		$this->Belong->DbValue = $row['Belong'];
		$this->AttackEffect->DbValue = $row['AttackEffect'];
		$this->AttackTips->DbValue = $row['AttackTips'];
		$this->MagicResistance->DbValue = $row['MagicResistance'];
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
		// Name
		// Basics
		// HP
		// MP
		// AD
		// AP
		// Defense
		// Hit
		// Dodge
		// Crit
		// AbsorbHP
		// ADPTV
		// ADPTR
		// APPTR
		// APPTV
		// ImmuneDamage
		// Intro
		// ExclusiveSkills
		// TransferDemand
		// TransferLevel
		// FormerOccupation
		// Belong
		// AttackEffect
		// AttackTips
		// MagicResistance
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

		// Name
		$this->Name->ViewValue = $this->Name->CurrentValue;
		$this->Name->ViewCustomAttributes = "";

		// Basics
		$this->Basics->ViewValue = $this->Basics->CurrentValue;
		$this->Basics->ViewCustomAttributes = "";

		// HP
		$this->HP->ViewValue = $this->HP->CurrentValue;
		$this->HP->ViewCustomAttributes = "";

		// MP
		$this->MP->ViewValue = $this->MP->CurrentValue;
		$this->MP->ViewCustomAttributes = "";

		// AD
		$this->AD->ViewValue = $this->AD->CurrentValue;
		$this->AD->ViewCustomAttributes = "";

		// AP
		$this->AP->ViewValue = $this->AP->CurrentValue;
		$this->AP->ViewCustomAttributes = "";

		// Defense
		$this->Defense->ViewValue = $this->Defense->CurrentValue;
		$this->Defense->ViewCustomAttributes = "";

		// Hit
		$this->Hit->ViewValue = $this->Hit->CurrentValue;
		$this->Hit->ViewCustomAttributes = "";

		// Dodge
		$this->Dodge->ViewValue = $this->Dodge->CurrentValue;
		$this->Dodge->ViewCustomAttributes = "";

		// Crit
		$this->Crit->ViewValue = $this->Crit->CurrentValue;
		$this->Crit->ViewCustomAttributes = "";

		// AbsorbHP
		$this->AbsorbHP->ViewValue = $this->AbsorbHP->CurrentValue;
		$this->AbsorbHP->ViewCustomAttributes = "";

		// ADPTV
		$this->ADPTV->ViewValue = $this->ADPTV->CurrentValue;
		$this->ADPTV->ViewCustomAttributes = "";

		// ADPTR
		$this->ADPTR->ViewValue = $this->ADPTR->CurrentValue;
		$this->ADPTR->ViewCustomAttributes = "";

		// APPTR
		$this->APPTR->ViewValue = $this->APPTR->CurrentValue;
		$this->APPTR->ViewCustomAttributes = "";

		// APPTV
		$this->APPTV->ViewValue = $this->APPTV->CurrentValue;
		$this->APPTV->ViewCustomAttributes = "";

		// ImmuneDamage
		$this->ImmuneDamage->ViewValue = $this->ImmuneDamage->CurrentValue;
		$this->ImmuneDamage->ViewCustomAttributes = "";

		// Intro
		$this->Intro->ViewValue = $this->Intro->CurrentValue;
		$this->Intro->ViewCustomAttributes = "";

		// ExclusiveSkills
		$this->ExclusiveSkills->ViewValue = $this->ExclusiveSkills->CurrentValue;
		$this->ExclusiveSkills->ViewCustomAttributes = "";

		// TransferDemand
		$this->TransferDemand->ViewValue = $this->TransferDemand->CurrentValue;
		$this->TransferDemand->ViewCustomAttributes = "";

		// TransferLevel
		$this->TransferLevel->ViewValue = $this->TransferLevel->CurrentValue;
		$this->TransferLevel->ViewCustomAttributes = "";

		// FormerOccupation
		$this->FormerOccupation->ViewValue = $this->FormerOccupation->CurrentValue;
		$this->FormerOccupation->ViewCustomAttributes = "";

		// Belong
		$this->Belong->ViewValue = $this->Belong->CurrentValue;
		$this->Belong->ViewCustomAttributes = "";

		// AttackEffect
		$this->AttackEffect->ViewValue = $this->AttackEffect->CurrentValue;
		$this->AttackEffect->ViewCustomAttributes = "";

		// AttackTips
		$this->AttackTips->ViewValue = $this->AttackTips->CurrentValue;
		$this->AttackTips->ViewCustomAttributes = "";

		// MagicResistance
		$this->MagicResistance->ViewValue = $this->MagicResistance->CurrentValue;
		$this->MagicResistance->ViewCustomAttributes = "";

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

			// Name
			$this->Name->LinkCustomAttributes = "";
			$this->Name->HrefValue = "";
			$this->Name->TooltipValue = "";

			// Basics
			$this->Basics->LinkCustomAttributes = "";
			$this->Basics->HrefValue = "";
			$this->Basics->TooltipValue = "";

			// HP
			$this->HP->LinkCustomAttributes = "";
			$this->HP->HrefValue = "";
			$this->HP->TooltipValue = "";

			// MP
			$this->MP->LinkCustomAttributes = "";
			$this->MP->HrefValue = "";
			$this->MP->TooltipValue = "";

			// AD
			$this->AD->LinkCustomAttributes = "";
			$this->AD->HrefValue = "";
			$this->AD->TooltipValue = "";

			// AP
			$this->AP->LinkCustomAttributes = "";
			$this->AP->HrefValue = "";
			$this->AP->TooltipValue = "";

			// Defense
			$this->Defense->LinkCustomAttributes = "";
			$this->Defense->HrefValue = "";
			$this->Defense->TooltipValue = "";

			// Hit
			$this->Hit->LinkCustomAttributes = "";
			$this->Hit->HrefValue = "";
			$this->Hit->TooltipValue = "";

			// Dodge
			$this->Dodge->LinkCustomAttributes = "";
			$this->Dodge->HrefValue = "";
			$this->Dodge->TooltipValue = "";

			// Crit
			$this->Crit->LinkCustomAttributes = "";
			$this->Crit->HrefValue = "";
			$this->Crit->TooltipValue = "";

			// AbsorbHP
			$this->AbsorbHP->LinkCustomAttributes = "";
			$this->AbsorbHP->HrefValue = "";
			$this->AbsorbHP->TooltipValue = "";

			// ADPTV
			$this->ADPTV->LinkCustomAttributes = "";
			$this->ADPTV->HrefValue = "";
			$this->ADPTV->TooltipValue = "";

			// ADPTR
			$this->ADPTR->LinkCustomAttributes = "";
			$this->ADPTR->HrefValue = "";
			$this->ADPTR->TooltipValue = "";

			// APPTR
			$this->APPTR->LinkCustomAttributes = "";
			$this->APPTR->HrefValue = "";
			$this->APPTR->TooltipValue = "";

			// APPTV
			$this->APPTV->LinkCustomAttributes = "";
			$this->APPTV->HrefValue = "";
			$this->APPTV->TooltipValue = "";

			// ImmuneDamage
			$this->ImmuneDamage->LinkCustomAttributes = "";
			$this->ImmuneDamage->HrefValue = "";
			$this->ImmuneDamage->TooltipValue = "";

			// Intro
			$this->Intro->LinkCustomAttributes = "";
			$this->Intro->HrefValue = "";
			$this->Intro->TooltipValue = "";

			// ExclusiveSkills
			$this->ExclusiveSkills->LinkCustomAttributes = "";
			$this->ExclusiveSkills->HrefValue = "";
			$this->ExclusiveSkills->TooltipValue = "";

			// TransferDemand
			$this->TransferDemand->LinkCustomAttributes = "";
			$this->TransferDemand->HrefValue = "";
			$this->TransferDemand->TooltipValue = "";

			// TransferLevel
			$this->TransferLevel->LinkCustomAttributes = "";
			$this->TransferLevel->HrefValue = "";
			$this->TransferLevel->TooltipValue = "";

			// FormerOccupation
			$this->FormerOccupation->LinkCustomAttributes = "";
			$this->FormerOccupation->HrefValue = "";
			$this->FormerOccupation->TooltipValue = "";

			// Belong
			$this->Belong->LinkCustomAttributes = "";
			$this->Belong->HrefValue = "";
			$this->Belong->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_occupationlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($config_occupation_view)) $config_occupation_view = new cconfig_occupation_view();

// Page init
$config_occupation_view->Page_Init();

// Page main
$config_occupation_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_occupation_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fconfig_occupationview = new ew_Form("fconfig_occupationview", "view");

// Form_CustomValidate event
fconfig_occupationview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_occupationview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $config_occupation_view->ExportOptions->Render("body") ?>
<?php
	foreach ($config_occupation_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $config_occupation_view->ShowPageHeader(); ?>
<?php
$config_occupation_view->ShowMessage();
?>
<form name="fconfig_occupationview" id="fconfig_occupationview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_occupation_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_occupation_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_occupation">
<input type="hidden" name="modal" value="<?php echo intval($config_occupation_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($config_occupation->unid->Visible) { // unid ?>
	<tr id="r_unid">
		<td class="col-sm-2"><span id="elh_config_occupation_unid"><?php echo $config_occupation->unid->FldCaption() ?></span></td>
		<td data-name="unid"<?php echo $config_occupation->unid->CellAttributes() ?>>
<span id="el_config_occupation_unid">
<span<?php echo $config_occupation->unid->ViewAttributes() ?>>
<?php echo $config_occupation->unid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->u_id->Visible) { // u_id ?>
	<tr id="r_u_id">
		<td class="col-sm-2"><span id="elh_config_occupation_u_id"><?php echo $config_occupation->u_id->FldCaption() ?></span></td>
		<td data-name="u_id"<?php echo $config_occupation->u_id->CellAttributes() ?>>
<span id="el_config_occupation_u_id">
<span<?php echo $config_occupation->u_id->ViewAttributes() ?>>
<?php echo $config_occupation->u_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->acl_id->Visible) { // acl_id ?>
	<tr id="r_acl_id">
		<td class="col-sm-2"><span id="elh_config_occupation_acl_id"><?php echo $config_occupation->acl_id->FldCaption() ?></span></td>
		<td data-name="acl_id"<?php echo $config_occupation->acl_id->CellAttributes() ?>>
<span id="el_config_occupation_acl_id">
<span<?php echo $config_occupation->acl_id->ViewAttributes() ?>>
<?php echo $config_occupation->acl_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->Name->Visible) { // Name ?>
	<tr id="r_Name">
		<td class="col-sm-2"><span id="elh_config_occupation_Name"><?php echo $config_occupation->Name->FldCaption() ?></span></td>
		<td data-name="Name"<?php echo $config_occupation->Name->CellAttributes() ?>>
<span id="el_config_occupation_Name">
<span<?php echo $config_occupation->Name->ViewAttributes() ?>>
<?php echo $config_occupation->Name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->Basics->Visible) { // Basics ?>
	<tr id="r_Basics">
		<td class="col-sm-2"><span id="elh_config_occupation_Basics"><?php echo $config_occupation->Basics->FldCaption() ?></span></td>
		<td data-name="Basics"<?php echo $config_occupation->Basics->CellAttributes() ?>>
<span id="el_config_occupation_Basics">
<span<?php echo $config_occupation->Basics->ViewAttributes() ?>>
<?php echo $config_occupation->Basics->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->HP->Visible) { // HP ?>
	<tr id="r_HP">
		<td class="col-sm-2"><span id="elh_config_occupation_HP"><?php echo $config_occupation->HP->FldCaption() ?></span></td>
		<td data-name="HP"<?php echo $config_occupation->HP->CellAttributes() ?>>
<span id="el_config_occupation_HP">
<span<?php echo $config_occupation->HP->ViewAttributes() ?>>
<?php echo $config_occupation->HP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->MP->Visible) { // MP ?>
	<tr id="r_MP">
		<td class="col-sm-2"><span id="elh_config_occupation_MP"><?php echo $config_occupation->MP->FldCaption() ?></span></td>
		<td data-name="MP"<?php echo $config_occupation->MP->CellAttributes() ?>>
<span id="el_config_occupation_MP">
<span<?php echo $config_occupation->MP->ViewAttributes() ?>>
<?php echo $config_occupation->MP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->AD->Visible) { // AD ?>
	<tr id="r_AD">
		<td class="col-sm-2"><span id="elh_config_occupation_AD"><?php echo $config_occupation->AD->FldCaption() ?></span></td>
		<td data-name="AD"<?php echo $config_occupation->AD->CellAttributes() ?>>
<span id="el_config_occupation_AD">
<span<?php echo $config_occupation->AD->ViewAttributes() ?>>
<?php echo $config_occupation->AD->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->AP->Visible) { // AP ?>
	<tr id="r_AP">
		<td class="col-sm-2"><span id="elh_config_occupation_AP"><?php echo $config_occupation->AP->FldCaption() ?></span></td>
		<td data-name="AP"<?php echo $config_occupation->AP->CellAttributes() ?>>
<span id="el_config_occupation_AP">
<span<?php echo $config_occupation->AP->ViewAttributes() ?>>
<?php echo $config_occupation->AP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->Defense->Visible) { // Defense ?>
	<tr id="r_Defense">
		<td class="col-sm-2"><span id="elh_config_occupation_Defense"><?php echo $config_occupation->Defense->FldCaption() ?></span></td>
		<td data-name="Defense"<?php echo $config_occupation->Defense->CellAttributes() ?>>
<span id="el_config_occupation_Defense">
<span<?php echo $config_occupation->Defense->ViewAttributes() ?>>
<?php echo $config_occupation->Defense->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->Hit->Visible) { // Hit ?>
	<tr id="r_Hit">
		<td class="col-sm-2"><span id="elh_config_occupation_Hit"><?php echo $config_occupation->Hit->FldCaption() ?></span></td>
		<td data-name="Hit"<?php echo $config_occupation->Hit->CellAttributes() ?>>
<span id="el_config_occupation_Hit">
<span<?php echo $config_occupation->Hit->ViewAttributes() ?>>
<?php echo $config_occupation->Hit->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->Dodge->Visible) { // Dodge ?>
	<tr id="r_Dodge">
		<td class="col-sm-2"><span id="elh_config_occupation_Dodge"><?php echo $config_occupation->Dodge->FldCaption() ?></span></td>
		<td data-name="Dodge"<?php echo $config_occupation->Dodge->CellAttributes() ?>>
<span id="el_config_occupation_Dodge">
<span<?php echo $config_occupation->Dodge->ViewAttributes() ?>>
<?php echo $config_occupation->Dodge->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->Crit->Visible) { // Crit ?>
	<tr id="r_Crit">
		<td class="col-sm-2"><span id="elh_config_occupation_Crit"><?php echo $config_occupation->Crit->FldCaption() ?></span></td>
		<td data-name="Crit"<?php echo $config_occupation->Crit->CellAttributes() ?>>
<span id="el_config_occupation_Crit">
<span<?php echo $config_occupation->Crit->ViewAttributes() ?>>
<?php echo $config_occupation->Crit->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->AbsorbHP->Visible) { // AbsorbHP ?>
	<tr id="r_AbsorbHP">
		<td class="col-sm-2"><span id="elh_config_occupation_AbsorbHP"><?php echo $config_occupation->AbsorbHP->FldCaption() ?></span></td>
		<td data-name="AbsorbHP"<?php echo $config_occupation->AbsorbHP->CellAttributes() ?>>
<span id="el_config_occupation_AbsorbHP">
<span<?php echo $config_occupation->AbsorbHP->ViewAttributes() ?>>
<?php echo $config_occupation->AbsorbHP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->ADPTV->Visible) { // ADPTV ?>
	<tr id="r_ADPTV">
		<td class="col-sm-2"><span id="elh_config_occupation_ADPTV"><?php echo $config_occupation->ADPTV->FldCaption() ?></span></td>
		<td data-name="ADPTV"<?php echo $config_occupation->ADPTV->CellAttributes() ?>>
<span id="el_config_occupation_ADPTV">
<span<?php echo $config_occupation->ADPTV->ViewAttributes() ?>>
<?php echo $config_occupation->ADPTV->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->ADPTR->Visible) { // ADPTR ?>
	<tr id="r_ADPTR">
		<td class="col-sm-2"><span id="elh_config_occupation_ADPTR"><?php echo $config_occupation->ADPTR->FldCaption() ?></span></td>
		<td data-name="ADPTR"<?php echo $config_occupation->ADPTR->CellAttributes() ?>>
<span id="el_config_occupation_ADPTR">
<span<?php echo $config_occupation->ADPTR->ViewAttributes() ?>>
<?php echo $config_occupation->ADPTR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->APPTR->Visible) { // APPTR ?>
	<tr id="r_APPTR">
		<td class="col-sm-2"><span id="elh_config_occupation_APPTR"><?php echo $config_occupation->APPTR->FldCaption() ?></span></td>
		<td data-name="APPTR"<?php echo $config_occupation->APPTR->CellAttributes() ?>>
<span id="el_config_occupation_APPTR">
<span<?php echo $config_occupation->APPTR->ViewAttributes() ?>>
<?php echo $config_occupation->APPTR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->APPTV->Visible) { // APPTV ?>
	<tr id="r_APPTV">
		<td class="col-sm-2"><span id="elh_config_occupation_APPTV"><?php echo $config_occupation->APPTV->FldCaption() ?></span></td>
		<td data-name="APPTV"<?php echo $config_occupation->APPTV->CellAttributes() ?>>
<span id="el_config_occupation_APPTV">
<span<?php echo $config_occupation->APPTV->ViewAttributes() ?>>
<?php echo $config_occupation->APPTV->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->ImmuneDamage->Visible) { // ImmuneDamage ?>
	<tr id="r_ImmuneDamage">
		<td class="col-sm-2"><span id="elh_config_occupation_ImmuneDamage"><?php echo $config_occupation->ImmuneDamage->FldCaption() ?></span></td>
		<td data-name="ImmuneDamage"<?php echo $config_occupation->ImmuneDamage->CellAttributes() ?>>
<span id="el_config_occupation_ImmuneDamage">
<span<?php echo $config_occupation->ImmuneDamage->ViewAttributes() ?>>
<?php echo $config_occupation->ImmuneDamage->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->Intro->Visible) { // Intro ?>
	<tr id="r_Intro">
		<td class="col-sm-2"><span id="elh_config_occupation_Intro"><?php echo $config_occupation->Intro->FldCaption() ?></span></td>
		<td data-name="Intro"<?php echo $config_occupation->Intro->CellAttributes() ?>>
<span id="el_config_occupation_Intro">
<span<?php echo $config_occupation->Intro->ViewAttributes() ?>>
<?php echo $config_occupation->Intro->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->ExclusiveSkills->Visible) { // ExclusiveSkills ?>
	<tr id="r_ExclusiveSkills">
		<td class="col-sm-2"><span id="elh_config_occupation_ExclusiveSkills"><?php echo $config_occupation->ExclusiveSkills->FldCaption() ?></span></td>
		<td data-name="ExclusiveSkills"<?php echo $config_occupation->ExclusiveSkills->CellAttributes() ?>>
<span id="el_config_occupation_ExclusiveSkills">
<span<?php echo $config_occupation->ExclusiveSkills->ViewAttributes() ?>>
<?php echo $config_occupation->ExclusiveSkills->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->TransferDemand->Visible) { // TransferDemand ?>
	<tr id="r_TransferDemand">
		<td class="col-sm-2"><span id="elh_config_occupation_TransferDemand"><?php echo $config_occupation->TransferDemand->FldCaption() ?></span></td>
		<td data-name="TransferDemand"<?php echo $config_occupation->TransferDemand->CellAttributes() ?>>
<span id="el_config_occupation_TransferDemand">
<span<?php echo $config_occupation->TransferDemand->ViewAttributes() ?>>
<?php echo $config_occupation->TransferDemand->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->TransferLevel->Visible) { // TransferLevel ?>
	<tr id="r_TransferLevel">
		<td class="col-sm-2"><span id="elh_config_occupation_TransferLevel"><?php echo $config_occupation->TransferLevel->FldCaption() ?></span></td>
		<td data-name="TransferLevel"<?php echo $config_occupation->TransferLevel->CellAttributes() ?>>
<span id="el_config_occupation_TransferLevel">
<span<?php echo $config_occupation->TransferLevel->ViewAttributes() ?>>
<?php echo $config_occupation->TransferLevel->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->FormerOccupation->Visible) { // FormerOccupation ?>
	<tr id="r_FormerOccupation">
		<td class="col-sm-2"><span id="elh_config_occupation_FormerOccupation"><?php echo $config_occupation->FormerOccupation->FldCaption() ?></span></td>
		<td data-name="FormerOccupation"<?php echo $config_occupation->FormerOccupation->CellAttributes() ?>>
<span id="el_config_occupation_FormerOccupation">
<span<?php echo $config_occupation->FormerOccupation->ViewAttributes() ?>>
<?php echo $config_occupation->FormerOccupation->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->Belong->Visible) { // Belong ?>
	<tr id="r_Belong">
		<td class="col-sm-2"><span id="elh_config_occupation_Belong"><?php echo $config_occupation->Belong->FldCaption() ?></span></td>
		<td data-name="Belong"<?php echo $config_occupation->Belong->CellAttributes() ?>>
<span id="el_config_occupation_Belong">
<span<?php echo $config_occupation->Belong->ViewAttributes() ?>>
<?php echo $config_occupation->Belong->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->AttackEffect->Visible) { // AttackEffect ?>
	<tr id="r_AttackEffect">
		<td class="col-sm-2"><span id="elh_config_occupation_AttackEffect"><?php echo $config_occupation->AttackEffect->FldCaption() ?></span></td>
		<td data-name="AttackEffect"<?php echo $config_occupation->AttackEffect->CellAttributes() ?>>
<span id="el_config_occupation_AttackEffect">
<span<?php echo $config_occupation->AttackEffect->ViewAttributes() ?>>
<?php echo $config_occupation->AttackEffect->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->AttackTips->Visible) { // AttackTips ?>
	<tr id="r_AttackTips">
		<td class="col-sm-2"><span id="elh_config_occupation_AttackTips"><?php echo $config_occupation->AttackTips->FldCaption() ?></span></td>
		<td data-name="AttackTips"<?php echo $config_occupation->AttackTips->CellAttributes() ?>>
<span id="el_config_occupation_AttackTips">
<span<?php echo $config_occupation->AttackTips->ViewAttributes() ?>>
<?php echo $config_occupation->AttackTips->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->MagicResistance->Visible) { // MagicResistance ?>
	<tr id="r_MagicResistance">
		<td class="col-sm-2"><span id="elh_config_occupation_MagicResistance"><?php echo $config_occupation->MagicResistance->FldCaption() ?></span></td>
		<td data-name="MagicResistance"<?php echo $config_occupation->MagicResistance->CellAttributes() ?>>
<span id="el_config_occupation_MagicResistance">
<span<?php echo $config_occupation->MagicResistance->ViewAttributes() ?>>
<?php echo $config_occupation->MagicResistance->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->IgnoreShield->Visible) { // IgnoreShield ?>
	<tr id="r_IgnoreShield">
		<td class="col-sm-2"><span id="elh_config_occupation_IgnoreShield"><?php echo $config_occupation->IgnoreShield->FldCaption() ?></span></td>
		<td data-name="IgnoreShield"<?php echo $config_occupation->IgnoreShield->CellAttributes() ?>>
<span id="el_config_occupation_IgnoreShield">
<span<?php echo $config_occupation->IgnoreShield->ViewAttributes() ?>>
<?php echo $config_occupation->IgnoreShield->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($config_occupation->DATETIME->Visible) { // DATETIME ?>
	<tr id="r_DATETIME">
		<td class="col-sm-2"><span id="elh_config_occupation_DATETIME"><?php echo $config_occupation->DATETIME->FldCaption() ?></span></td>
		<td data-name="DATETIME"<?php echo $config_occupation->DATETIME->CellAttributes() ?>>
<span id="el_config_occupation_DATETIME">
<span<?php echo $config_occupation->DATETIME->ViewAttributes() ?>>
<?php echo $config_occupation->DATETIME->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fconfig_occupationview.Init();
</script>
<?php
$config_occupation_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_occupation_view->Page_Terminate();
?>
