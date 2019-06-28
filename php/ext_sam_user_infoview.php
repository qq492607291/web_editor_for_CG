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

$ext_sam_user_info_view = NULL; // Initialize page object first

class cext_sam_user_info_view extends cext_sam_user_info {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'ext_sam_user_info';

	// Page object name
	var $PageObjName = 'ext_sam_user_info_view';

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

		// Table object (ext_sam_user_info)
		if (!isset($GLOBALS["ext_sam_user_info"]) || get_class($GLOBALS["ext_sam_user_info"]) == "cext_sam_user_info") {
			$GLOBALS["ext_sam_user_info"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ext_sam_user_info"];
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
				$this->Page_Terminate(ew_GetUrl("ext_sam_user_infolist.php"));
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
				$sReturnUrl = "ext_sam_user_infolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "ext_sam_user_infolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "ext_sam_user_infolist.php"; // Not page request, return to list
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
		$row['MasterName'] = NULL;
		$row['HP'] = NULL;
		$row['MAX_HP'] = NULL;
		$row['UD1'] = NULL;
		$row['UD2'] = NULL;
		$row['UD3'] = NULL;
		$row['UD4'] = NULL;
		$row['UD5'] = NULL;
		$row['UD6'] = NULL;
		$row['UD7'] = NULL;
		$row['UD8'] = NULL;
		$row['UD9'] = NULL;
		$row['UD10'] = NULL;
		$row['UD11'] = NULL;
		$row['UD12'] = NULL;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ext_sam_user_infolist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ext_sam_user_info_view)) $ext_sam_user_info_view = new cext_sam_user_info_view();

// Page init
$ext_sam_user_info_view->Page_Init();

// Page main
$ext_sam_user_info_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ext_sam_user_info_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fext_sam_user_infoview = new ew_Form("fext_sam_user_infoview", "view");

// Form_CustomValidate event
fext_sam_user_infoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fext_sam_user_infoview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $ext_sam_user_info_view->ExportOptions->Render("body") ?>
<?php
	foreach ($ext_sam_user_info_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $ext_sam_user_info_view->ShowPageHeader(); ?>
<?php
$ext_sam_user_info_view->ShowMessage();
?>
<form name="fext_sam_user_infoview" id="fext_sam_user_infoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ext_sam_user_info_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ext_sam_user_info_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ext_sam_user_info">
<input type="hidden" name="modal" value="<?php echo intval($ext_sam_user_info_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($ext_sam_user_info->unid->Visible) { // unid ?>
	<tr id="r_unid">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_unid"><?php echo $ext_sam_user_info->unid->FldCaption() ?></span></td>
		<td data-name="unid"<?php echo $ext_sam_user_info->unid->CellAttributes() ?>>
<span id="el_ext_sam_user_info_unid">
<span<?php echo $ext_sam_user_info->unid->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->unid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->u_id->Visible) { // u_id ?>
	<tr id="r_u_id">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_u_id"><?php echo $ext_sam_user_info->u_id->FldCaption() ?></span></td>
		<td data-name="u_id"<?php echo $ext_sam_user_info->u_id->CellAttributes() ?>>
<span id="el_ext_sam_user_info_u_id">
<span<?php echo $ext_sam_user_info->u_id->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->u_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->acl_id->Visible) { // acl_id ?>
	<tr id="r_acl_id">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_acl_id"><?php echo $ext_sam_user_info->acl_id->FldCaption() ?></span></td>
		<td data-name="acl_id"<?php echo $ext_sam_user_info->acl_id->CellAttributes() ?>>
<span id="el_ext_sam_user_info_acl_id">
<span<?php echo $ext_sam_user_info->acl_id->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->acl_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->Name->Visible) { // Name ?>
	<tr id="r_Name">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_Name"><?php echo $ext_sam_user_info->Name->FldCaption() ?></span></td>
		<td data-name="Name"<?php echo $ext_sam_user_info->Name->CellAttributes() ?>>
<span id="el_ext_sam_user_info_Name">
<span<?php echo $ext_sam_user_info->Name->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->Name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->LV->Visible) { // LV ?>
	<tr id="r_LV">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_LV"><?php echo $ext_sam_user_info->LV->FldCaption() ?></span></td>
		<td data-name="LV"<?php echo $ext_sam_user_info->LV->CellAttributes() ?>>
<span id="el_ext_sam_user_info_LV">
<span<?php echo $ext_sam_user_info->LV->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->LV->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->MainCat->Visible) { // MainCat ?>
	<tr id="r_MainCat">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_MainCat"><?php echo $ext_sam_user_info->MainCat->FldCaption() ?></span></td>
		<td data-name="MainCat"<?php echo $ext_sam_user_info->MainCat->CellAttributes() ?>>
<span id="el_ext_sam_user_info_MainCat">
<span<?php echo $ext_sam_user_info->MainCat->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->MainCat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->SubCat->Visible) { // SubCat ?>
	<tr id="r_SubCat">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_SubCat"><?php echo $ext_sam_user_info->SubCat->FldCaption() ?></span></td>
		<td data-name="SubCat"<?php echo $ext_sam_user_info->SubCat->CellAttributes() ?>>
<span id="el_ext_sam_user_info_SubCat">
<span<?php echo $ext_sam_user_info->SubCat->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->SubCat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->Location->Visible) { // Location ?>
	<tr id="r_Location">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_Location"><?php echo $ext_sam_user_info->Location->FldCaption() ?></span></td>
		<td data-name="Location"<?php echo $ext_sam_user_info->Location->CellAttributes() ?>>
<span id="el_ext_sam_user_info_Location">
<span<?php echo $ext_sam_user_info->Location->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->Location->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->Dialog->Visible) { // Dialog ?>
	<tr id="r_Dialog">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_Dialog"><?php echo $ext_sam_user_info->Dialog->FldCaption() ?></span></td>
		<td data-name="Dialog"<?php echo $ext_sam_user_info->Dialog->CellAttributes() ?>>
<span id="el_ext_sam_user_info_Dialog">
<span<?php echo $ext_sam_user_info->Dialog->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->Dialog->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->Function->Visible) { // Function ?>
	<tr id="r_Function">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_Function"><?php echo $ext_sam_user_info->Function->FldCaption() ?></span></td>
		<td data-name="Function"<?php echo $ext_sam_user_info->Function->CellAttributes() ?>>
<span id="el_ext_sam_user_info_Function">
<span<?php echo $ext_sam_user_info->Function->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->Function->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->MasterName->Visible) { // MasterName ?>
	<tr id="r_MasterName">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_MasterName"><?php echo $ext_sam_user_info->MasterName->FldCaption() ?></span></td>
		<td data-name="MasterName"<?php echo $ext_sam_user_info->MasterName->CellAttributes() ?>>
<span id="el_ext_sam_user_info_MasterName">
<span<?php echo $ext_sam_user_info->MasterName->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->MasterName->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->HP->Visible) { // HP ?>
	<tr id="r_HP">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_HP"><?php echo $ext_sam_user_info->HP->FldCaption() ?></span></td>
		<td data-name="HP"<?php echo $ext_sam_user_info->HP->CellAttributes() ?>>
<span id="el_ext_sam_user_info_HP">
<span<?php echo $ext_sam_user_info->HP->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->HP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->MAX_HP->Visible) { // MAX_HP ?>
	<tr id="r_MAX_HP">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_MAX_HP"><?php echo $ext_sam_user_info->MAX_HP->FldCaption() ?></span></td>
		<td data-name="MAX_HP"<?php echo $ext_sam_user_info->MAX_HP->CellAttributes() ?>>
<span id="el_ext_sam_user_info_MAX_HP">
<span<?php echo $ext_sam_user_info->MAX_HP->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->MAX_HP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD1->Visible) { // UD1 ?>
	<tr id="r_UD1">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD1"><?php echo $ext_sam_user_info->UD1->FldCaption() ?></span></td>
		<td data-name="UD1"<?php echo $ext_sam_user_info->UD1->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD1">
<span<?php echo $ext_sam_user_info->UD1->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD2->Visible) { // UD2 ?>
	<tr id="r_UD2">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD2"><?php echo $ext_sam_user_info->UD2->FldCaption() ?></span></td>
		<td data-name="UD2"<?php echo $ext_sam_user_info->UD2->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD2">
<span<?php echo $ext_sam_user_info->UD2->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD3->Visible) { // UD3 ?>
	<tr id="r_UD3">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD3"><?php echo $ext_sam_user_info->UD3->FldCaption() ?></span></td>
		<td data-name="UD3"<?php echo $ext_sam_user_info->UD3->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD3">
<span<?php echo $ext_sam_user_info->UD3->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD4->Visible) { // UD4 ?>
	<tr id="r_UD4">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD4"><?php echo $ext_sam_user_info->UD4->FldCaption() ?></span></td>
		<td data-name="UD4"<?php echo $ext_sam_user_info->UD4->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD4">
<span<?php echo $ext_sam_user_info->UD4->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD5->Visible) { // UD5 ?>
	<tr id="r_UD5">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD5"><?php echo $ext_sam_user_info->UD5->FldCaption() ?></span></td>
		<td data-name="UD5"<?php echo $ext_sam_user_info->UD5->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD5">
<span<?php echo $ext_sam_user_info->UD5->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD6->Visible) { // UD6 ?>
	<tr id="r_UD6">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD6"><?php echo $ext_sam_user_info->UD6->FldCaption() ?></span></td>
		<td data-name="UD6"<?php echo $ext_sam_user_info->UD6->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD6">
<span<?php echo $ext_sam_user_info->UD6->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD6->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD7->Visible) { // UD7 ?>
	<tr id="r_UD7">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD7"><?php echo $ext_sam_user_info->UD7->FldCaption() ?></span></td>
		<td data-name="UD7"<?php echo $ext_sam_user_info->UD7->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD7">
<span<?php echo $ext_sam_user_info->UD7->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD7->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD8->Visible) { // UD8 ?>
	<tr id="r_UD8">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD8"><?php echo $ext_sam_user_info->UD8->FldCaption() ?></span></td>
		<td data-name="UD8"<?php echo $ext_sam_user_info->UD8->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD8">
<span<?php echo $ext_sam_user_info->UD8->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD8->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD9->Visible) { // UD9 ?>
	<tr id="r_UD9">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD9"><?php echo $ext_sam_user_info->UD9->FldCaption() ?></span></td>
		<td data-name="UD9"<?php echo $ext_sam_user_info->UD9->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD9">
<span<?php echo $ext_sam_user_info->UD9->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD9->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD10->Visible) { // UD10 ?>
	<tr id="r_UD10">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD10"><?php echo $ext_sam_user_info->UD10->FldCaption() ?></span></td>
		<td data-name="UD10"<?php echo $ext_sam_user_info->UD10->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD10">
<span<?php echo $ext_sam_user_info->UD10->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD10->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD11->Visible) { // UD11 ?>
	<tr id="r_UD11">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD11"><?php echo $ext_sam_user_info->UD11->FldCaption() ?></span></td>
		<td data-name="UD11"<?php echo $ext_sam_user_info->UD11->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD11">
<span<?php echo $ext_sam_user_info->UD11->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD11->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->UD12->Visible) { // UD12 ?>
	<tr id="r_UD12">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_UD12"><?php echo $ext_sam_user_info->UD12->FldCaption() ?></span></td>
		<td data-name="UD12"<?php echo $ext_sam_user_info->UD12->CellAttributes() ?>>
<span id="el_ext_sam_user_info_UD12">
<span<?php echo $ext_sam_user_info->UD12->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->UD12->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->Introduce->Visible) { // Introduce ?>
	<tr id="r_Introduce">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_Introduce"><?php echo $ext_sam_user_info->Introduce->FldCaption() ?></span></td>
		<td data-name="Introduce"<?php echo $ext_sam_user_info->Introduce->CellAttributes() ?>>
<span id="el_ext_sam_user_info_Introduce">
<span<?php echo $ext_sam_user_info->Introduce->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->Introduce->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_sam_user_info->DATETIME->Visible) { // DATETIME ?>
	<tr id="r_DATETIME">
		<td class="col-sm-2"><span id="elh_ext_sam_user_info_DATETIME"><?php echo $ext_sam_user_info->DATETIME->FldCaption() ?></span></td>
		<td data-name="DATETIME"<?php echo $ext_sam_user_info->DATETIME->CellAttributes() ?>>
<span id="el_ext_sam_user_info_DATETIME">
<span<?php echo $ext_sam_user_info->DATETIME->ViewAttributes() ?>>
<?php echo $ext_sam_user_info->DATETIME->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fext_sam_user_infoview.Init();
</script>
<?php
$ext_sam_user_info_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ext_sam_user_info_view->Page_Terminate();
?>
