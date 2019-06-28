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

$ext_goodsextattr_view = NULL; // Initialize page object first

class cext_goodsextattr_view extends cext_goodsextattr {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'ext_goodsextattr';

	// Page object name
	var $PageObjName = 'ext_goodsextattr_view';

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

		// Table object (ext_goodsextattr)
		if (!isset($GLOBALS["ext_goodsextattr"]) || get_class($GLOBALS["ext_goodsextattr"]) == "cext_goodsextattr") {
			$GLOBALS["ext_goodsextattr"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ext_goodsextattr"];
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
				$this->Page_Terminate(ew_GetUrl("ext_goodsextattrlist.php"));
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
				$sReturnUrl = "ext_goodsextattrlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "ext_goodsextattrlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "ext_goodsextattrlist.php"; // Not page request, return to list
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
		$row = array();
		$row['unid'] = NULL;
		$row['u_id'] = NULL;
		$row['acl_id'] = NULL;
		$row['Name'] = NULL;
		$row['PriceNum'] = NULL;
		$row['PriceType'] = NULL;
		$row['UD_qualityNum'] = NULL;
		$row['UD_cat'] = NULL;
		$row['UD_qualityType'] = NULL;
		$row['UD_kv4'] = NULL;
		$row['UD_kv5'] = NULL;
		$row['UD_kv6'] = NULL;
		$row['UD_kv7'] = NULL;
		$row['UD_kv8'] = NULL;
		$row['UD_kv9'] = NULL;
		$row['UD_kv10'] = NULL;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ext_goodsextattrlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ext_goodsextattr_view)) $ext_goodsextattr_view = new cext_goodsextattr_view();

// Page init
$ext_goodsextattr_view->Page_Init();

// Page main
$ext_goodsextattr_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ext_goodsextattr_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fext_goodsextattrview = new ew_Form("fext_goodsextattrview", "view");

// Form_CustomValidate event
fext_goodsextattrview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fext_goodsextattrview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $ext_goodsextattr_view->ExportOptions->Render("body") ?>
<?php
	foreach ($ext_goodsextattr_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $ext_goodsextattr_view->ShowPageHeader(); ?>
<?php
$ext_goodsextattr_view->ShowMessage();
?>
<form name="fext_goodsextattrview" id="fext_goodsextattrview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ext_goodsextattr_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ext_goodsextattr_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ext_goodsextattr">
<input type="hidden" name="modal" value="<?php echo intval($ext_goodsextattr_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($ext_goodsextattr->unid->Visible) { // unid ?>
	<tr id="r_unid">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_unid"><?php echo $ext_goodsextattr->unid->FldCaption() ?></span></td>
		<td data-name="unid"<?php echo $ext_goodsextattr->unid->CellAttributes() ?>>
<span id="el_ext_goodsextattr_unid">
<span<?php echo $ext_goodsextattr->unid->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->unid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->u_id->Visible) { // u_id ?>
	<tr id="r_u_id">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_u_id"><?php echo $ext_goodsextattr->u_id->FldCaption() ?></span></td>
		<td data-name="u_id"<?php echo $ext_goodsextattr->u_id->CellAttributes() ?>>
<span id="el_ext_goodsextattr_u_id">
<span<?php echo $ext_goodsextattr->u_id->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->u_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->acl_id->Visible) { // acl_id ?>
	<tr id="r_acl_id">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_acl_id"><?php echo $ext_goodsextattr->acl_id->FldCaption() ?></span></td>
		<td data-name="acl_id"<?php echo $ext_goodsextattr->acl_id->CellAttributes() ?>>
<span id="el_ext_goodsextattr_acl_id">
<span<?php echo $ext_goodsextattr->acl_id->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->acl_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->Name->Visible) { // Name ?>
	<tr id="r_Name">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_Name"><?php echo $ext_goodsextattr->Name->FldCaption() ?></span></td>
		<td data-name="Name"<?php echo $ext_goodsextattr->Name->CellAttributes() ?>>
<span id="el_ext_goodsextattr_Name">
<span<?php echo $ext_goodsextattr->Name->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->Name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->PriceNum->Visible) { // PriceNum ?>
	<tr id="r_PriceNum">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_PriceNum"><?php echo $ext_goodsextattr->PriceNum->FldCaption() ?></span></td>
		<td data-name="PriceNum"<?php echo $ext_goodsextattr->PriceNum->CellAttributes() ?>>
<span id="el_ext_goodsextattr_PriceNum">
<span<?php echo $ext_goodsextattr->PriceNum->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->PriceNum->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->PriceType->Visible) { // PriceType ?>
	<tr id="r_PriceType">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_PriceType"><?php echo $ext_goodsextattr->PriceType->FldCaption() ?></span></td>
		<td data-name="PriceType"<?php echo $ext_goodsextattr->PriceType->CellAttributes() ?>>
<span id="el_ext_goodsextattr_PriceType">
<span<?php echo $ext_goodsextattr->PriceType->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->PriceType->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->UD_qualityNum->Visible) { // UD_qualityNum ?>
	<tr id="r_UD_qualityNum">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_UD_qualityNum"><?php echo $ext_goodsextattr->UD_qualityNum->FldCaption() ?></span></td>
		<td data-name="UD_qualityNum"<?php echo $ext_goodsextattr->UD_qualityNum->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_qualityNum">
<span<?php echo $ext_goodsextattr->UD_qualityNum->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->UD_qualityNum->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->UD_cat->Visible) { // UD_cat ?>
	<tr id="r_UD_cat">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_UD_cat"><?php echo $ext_goodsextattr->UD_cat->FldCaption() ?></span></td>
		<td data-name="UD_cat"<?php echo $ext_goodsextattr->UD_cat->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_cat">
<span<?php echo $ext_goodsextattr->UD_cat->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->UD_cat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->UD_qualityType->Visible) { // UD_qualityType ?>
	<tr id="r_UD_qualityType">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_UD_qualityType"><?php echo $ext_goodsextattr->UD_qualityType->FldCaption() ?></span></td>
		<td data-name="UD_qualityType"<?php echo $ext_goodsextattr->UD_qualityType->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_qualityType">
<span<?php echo $ext_goodsextattr->UD_qualityType->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->UD_qualityType->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv4->Visible) { // UD_kv4 ?>
	<tr id="r_UD_kv4">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_UD_kv4"><?php echo $ext_goodsextattr->UD_kv4->FldCaption() ?></span></td>
		<td data-name="UD_kv4"<?php echo $ext_goodsextattr->UD_kv4->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv4">
<span<?php echo $ext_goodsextattr->UD_kv4->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->UD_kv4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv5->Visible) { // UD_kv5 ?>
	<tr id="r_UD_kv5">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_UD_kv5"><?php echo $ext_goodsextattr->UD_kv5->FldCaption() ?></span></td>
		<td data-name="UD_kv5"<?php echo $ext_goodsextattr->UD_kv5->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv5">
<span<?php echo $ext_goodsextattr->UD_kv5->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->UD_kv5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv6->Visible) { // UD_kv6 ?>
	<tr id="r_UD_kv6">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_UD_kv6"><?php echo $ext_goodsextattr->UD_kv6->FldCaption() ?></span></td>
		<td data-name="UD_kv6"<?php echo $ext_goodsextattr->UD_kv6->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv6">
<span<?php echo $ext_goodsextattr->UD_kv6->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->UD_kv6->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv7->Visible) { // UD_kv7 ?>
	<tr id="r_UD_kv7">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_UD_kv7"><?php echo $ext_goodsextattr->UD_kv7->FldCaption() ?></span></td>
		<td data-name="UD_kv7"<?php echo $ext_goodsextattr->UD_kv7->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv7">
<span<?php echo $ext_goodsextattr->UD_kv7->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->UD_kv7->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv8->Visible) { // UD_kv8 ?>
	<tr id="r_UD_kv8">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_UD_kv8"><?php echo $ext_goodsextattr->UD_kv8->FldCaption() ?></span></td>
		<td data-name="UD_kv8"<?php echo $ext_goodsextattr->UD_kv8->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv8">
<span<?php echo $ext_goodsextattr->UD_kv8->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->UD_kv8->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv9->Visible) { // UD_kv9 ?>
	<tr id="r_UD_kv9">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_UD_kv9"><?php echo $ext_goodsextattr->UD_kv9->FldCaption() ?></span></td>
		<td data-name="UD_kv9"<?php echo $ext_goodsextattr->UD_kv9->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv9">
<span<?php echo $ext_goodsextattr->UD_kv9->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->UD_kv9->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->UD_kv10->Visible) { // UD_kv10 ?>
	<tr id="r_UD_kv10">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_UD_kv10"><?php echo $ext_goodsextattr->UD_kv10->FldCaption() ?></span></td>
		<td data-name="UD_kv10"<?php echo $ext_goodsextattr->UD_kv10->CellAttributes() ?>>
<span id="el_ext_goodsextattr_UD_kv10">
<span<?php echo $ext_goodsextattr->UD_kv10->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->UD_kv10->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ext_goodsextattr->DATETIME->Visible) { // DATETIME ?>
	<tr id="r_DATETIME">
		<td class="col-sm-2"><span id="elh_ext_goodsextattr_DATETIME"><?php echo $ext_goodsextattr->DATETIME->FldCaption() ?></span></td>
		<td data-name="DATETIME"<?php echo $ext_goodsextattr->DATETIME->CellAttributes() ?>>
<span id="el_ext_goodsextattr_DATETIME">
<span<?php echo $ext_goodsextattr->DATETIME->ViewAttributes() ?>>
<?php echo $ext_goodsextattr->DATETIME->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fext_goodsextattrview.Init();
</script>
<?php
$ext_goodsextattr_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ext_goodsextattr_view->Page_Terminate();
?>
