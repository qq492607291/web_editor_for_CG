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

$config_occupation_list = NULL; // Initialize page object first

class cconfig_occupation_list extends cconfig_occupation {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_occupation';

	// Page object name
	var $PageObjName = 'config_occupation_list';

	// Grid form hidden field names
	var $FormName = 'fconfig_occupationlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "config_occupationadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "config_occupationdelete.php";
		$this->MultiUpdateUrl = "config_occupationupdate.php";

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fconfig_occupationlistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->unid->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->unid->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server" && isset($UserProfile))
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fconfig_occupationlistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->unid->AdvancedSearch->ToJson(), ","); // Field unid
		$sFilterList = ew_Concat($sFilterList, $this->u_id->AdvancedSearch->ToJson(), ","); // Field u_id
		$sFilterList = ew_Concat($sFilterList, $this->acl_id->AdvancedSearch->ToJson(), ","); // Field acl_id
		$sFilterList = ew_Concat($sFilterList, $this->Name->AdvancedSearch->ToJson(), ","); // Field Name
		$sFilterList = ew_Concat($sFilterList, $this->Basics->AdvancedSearch->ToJson(), ","); // Field Basics
		$sFilterList = ew_Concat($sFilterList, $this->HP->AdvancedSearch->ToJson(), ","); // Field HP
		$sFilterList = ew_Concat($sFilterList, $this->MP->AdvancedSearch->ToJson(), ","); // Field MP
		$sFilterList = ew_Concat($sFilterList, $this->AD->AdvancedSearch->ToJson(), ","); // Field AD
		$sFilterList = ew_Concat($sFilterList, $this->AP->AdvancedSearch->ToJson(), ","); // Field AP
		$sFilterList = ew_Concat($sFilterList, $this->Defense->AdvancedSearch->ToJson(), ","); // Field Defense
		$sFilterList = ew_Concat($sFilterList, $this->Hit->AdvancedSearch->ToJson(), ","); // Field Hit
		$sFilterList = ew_Concat($sFilterList, $this->Dodge->AdvancedSearch->ToJson(), ","); // Field Dodge
		$sFilterList = ew_Concat($sFilterList, $this->Crit->AdvancedSearch->ToJson(), ","); // Field Crit
		$sFilterList = ew_Concat($sFilterList, $this->AbsorbHP->AdvancedSearch->ToJson(), ","); // Field AbsorbHP
		$sFilterList = ew_Concat($sFilterList, $this->ADPTV->AdvancedSearch->ToJson(), ","); // Field ADPTV
		$sFilterList = ew_Concat($sFilterList, $this->ADPTR->AdvancedSearch->ToJson(), ","); // Field ADPTR
		$sFilterList = ew_Concat($sFilterList, $this->APPTR->AdvancedSearch->ToJson(), ","); // Field APPTR
		$sFilterList = ew_Concat($sFilterList, $this->APPTV->AdvancedSearch->ToJson(), ","); // Field APPTV
		$sFilterList = ew_Concat($sFilterList, $this->ImmuneDamage->AdvancedSearch->ToJson(), ","); // Field ImmuneDamage
		$sFilterList = ew_Concat($sFilterList, $this->Intro->AdvancedSearch->ToJson(), ","); // Field Intro
		$sFilterList = ew_Concat($sFilterList, $this->ExclusiveSkills->AdvancedSearch->ToJson(), ","); // Field ExclusiveSkills
		$sFilterList = ew_Concat($sFilterList, $this->TransferDemand->AdvancedSearch->ToJson(), ","); // Field TransferDemand
		$sFilterList = ew_Concat($sFilterList, $this->TransferLevel->AdvancedSearch->ToJson(), ","); // Field TransferLevel
		$sFilterList = ew_Concat($sFilterList, $this->FormerOccupation->AdvancedSearch->ToJson(), ","); // Field FormerOccupation
		$sFilterList = ew_Concat($sFilterList, $this->Belong->AdvancedSearch->ToJson(), ","); // Field Belong
		$sFilterList = ew_Concat($sFilterList, $this->AttackEffect->AdvancedSearch->ToJson(), ","); // Field AttackEffect
		$sFilterList = ew_Concat($sFilterList, $this->AttackTips->AdvancedSearch->ToJson(), ","); // Field AttackTips
		$sFilterList = ew_Concat($sFilterList, $this->MagicResistance->AdvancedSearch->ToJson(), ","); // Field MagicResistance
		$sFilterList = ew_Concat($sFilterList, $this->IgnoreShield->AdvancedSearch->ToJson(), ","); // Field IgnoreShield
		$sFilterList = ew_Concat($sFilterList, $this->DATETIME->AdvancedSearch->ToJson(), ","); // Field DATETIME
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "fconfig_occupationlistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field unid
		$this->unid->AdvancedSearch->SearchValue = @$filter["x_unid"];
		$this->unid->AdvancedSearch->SearchOperator = @$filter["z_unid"];
		$this->unid->AdvancedSearch->SearchCondition = @$filter["v_unid"];
		$this->unid->AdvancedSearch->SearchValue2 = @$filter["y_unid"];
		$this->unid->AdvancedSearch->SearchOperator2 = @$filter["w_unid"];
		$this->unid->AdvancedSearch->Save();

		// Field u_id
		$this->u_id->AdvancedSearch->SearchValue = @$filter["x_u_id"];
		$this->u_id->AdvancedSearch->SearchOperator = @$filter["z_u_id"];
		$this->u_id->AdvancedSearch->SearchCondition = @$filter["v_u_id"];
		$this->u_id->AdvancedSearch->SearchValue2 = @$filter["y_u_id"];
		$this->u_id->AdvancedSearch->SearchOperator2 = @$filter["w_u_id"];
		$this->u_id->AdvancedSearch->Save();

		// Field acl_id
		$this->acl_id->AdvancedSearch->SearchValue = @$filter["x_acl_id"];
		$this->acl_id->AdvancedSearch->SearchOperator = @$filter["z_acl_id"];
		$this->acl_id->AdvancedSearch->SearchCondition = @$filter["v_acl_id"];
		$this->acl_id->AdvancedSearch->SearchValue2 = @$filter["y_acl_id"];
		$this->acl_id->AdvancedSearch->SearchOperator2 = @$filter["w_acl_id"];
		$this->acl_id->AdvancedSearch->Save();

		// Field Name
		$this->Name->AdvancedSearch->SearchValue = @$filter["x_Name"];
		$this->Name->AdvancedSearch->SearchOperator = @$filter["z_Name"];
		$this->Name->AdvancedSearch->SearchCondition = @$filter["v_Name"];
		$this->Name->AdvancedSearch->SearchValue2 = @$filter["y_Name"];
		$this->Name->AdvancedSearch->SearchOperator2 = @$filter["w_Name"];
		$this->Name->AdvancedSearch->Save();

		// Field Basics
		$this->Basics->AdvancedSearch->SearchValue = @$filter["x_Basics"];
		$this->Basics->AdvancedSearch->SearchOperator = @$filter["z_Basics"];
		$this->Basics->AdvancedSearch->SearchCondition = @$filter["v_Basics"];
		$this->Basics->AdvancedSearch->SearchValue2 = @$filter["y_Basics"];
		$this->Basics->AdvancedSearch->SearchOperator2 = @$filter["w_Basics"];
		$this->Basics->AdvancedSearch->Save();

		// Field HP
		$this->HP->AdvancedSearch->SearchValue = @$filter["x_HP"];
		$this->HP->AdvancedSearch->SearchOperator = @$filter["z_HP"];
		$this->HP->AdvancedSearch->SearchCondition = @$filter["v_HP"];
		$this->HP->AdvancedSearch->SearchValue2 = @$filter["y_HP"];
		$this->HP->AdvancedSearch->SearchOperator2 = @$filter["w_HP"];
		$this->HP->AdvancedSearch->Save();

		// Field MP
		$this->MP->AdvancedSearch->SearchValue = @$filter["x_MP"];
		$this->MP->AdvancedSearch->SearchOperator = @$filter["z_MP"];
		$this->MP->AdvancedSearch->SearchCondition = @$filter["v_MP"];
		$this->MP->AdvancedSearch->SearchValue2 = @$filter["y_MP"];
		$this->MP->AdvancedSearch->SearchOperator2 = @$filter["w_MP"];
		$this->MP->AdvancedSearch->Save();

		// Field AD
		$this->AD->AdvancedSearch->SearchValue = @$filter["x_AD"];
		$this->AD->AdvancedSearch->SearchOperator = @$filter["z_AD"];
		$this->AD->AdvancedSearch->SearchCondition = @$filter["v_AD"];
		$this->AD->AdvancedSearch->SearchValue2 = @$filter["y_AD"];
		$this->AD->AdvancedSearch->SearchOperator2 = @$filter["w_AD"];
		$this->AD->AdvancedSearch->Save();

		// Field AP
		$this->AP->AdvancedSearch->SearchValue = @$filter["x_AP"];
		$this->AP->AdvancedSearch->SearchOperator = @$filter["z_AP"];
		$this->AP->AdvancedSearch->SearchCondition = @$filter["v_AP"];
		$this->AP->AdvancedSearch->SearchValue2 = @$filter["y_AP"];
		$this->AP->AdvancedSearch->SearchOperator2 = @$filter["w_AP"];
		$this->AP->AdvancedSearch->Save();

		// Field Defense
		$this->Defense->AdvancedSearch->SearchValue = @$filter["x_Defense"];
		$this->Defense->AdvancedSearch->SearchOperator = @$filter["z_Defense"];
		$this->Defense->AdvancedSearch->SearchCondition = @$filter["v_Defense"];
		$this->Defense->AdvancedSearch->SearchValue2 = @$filter["y_Defense"];
		$this->Defense->AdvancedSearch->SearchOperator2 = @$filter["w_Defense"];
		$this->Defense->AdvancedSearch->Save();

		// Field Hit
		$this->Hit->AdvancedSearch->SearchValue = @$filter["x_Hit"];
		$this->Hit->AdvancedSearch->SearchOperator = @$filter["z_Hit"];
		$this->Hit->AdvancedSearch->SearchCondition = @$filter["v_Hit"];
		$this->Hit->AdvancedSearch->SearchValue2 = @$filter["y_Hit"];
		$this->Hit->AdvancedSearch->SearchOperator2 = @$filter["w_Hit"];
		$this->Hit->AdvancedSearch->Save();

		// Field Dodge
		$this->Dodge->AdvancedSearch->SearchValue = @$filter["x_Dodge"];
		$this->Dodge->AdvancedSearch->SearchOperator = @$filter["z_Dodge"];
		$this->Dodge->AdvancedSearch->SearchCondition = @$filter["v_Dodge"];
		$this->Dodge->AdvancedSearch->SearchValue2 = @$filter["y_Dodge"];
		$this->Dodge->AdvancedSearch->SearchOperator2 = @$filter["w_Dodge"];
		$this->Dodge->AdvancedSearch->Save();

		// Field Crit
		$this->Crit->AdvancedSearch->SearchValue = @$filter["x_Crit"];
		$this->Crit->AdvancedSearch->SearchOperator = @$filter["z_Crit"];
		$this->Crit->AdvancedSearch->SearchCondition = @$filter["v_Crit"];
		$this->Crit->AdvancedSearch->SearchValue2 = @$filter["y_Crit"];
		$this->Crit->AdvancedSearch->SearchOperator2 = @$filter["w_Crit"];
		$this->Crit->AdvancedSearch->Save();

		// Field AbsorbHP
		$this->AbsorbHP->AdvancedSearch->SearchValue = @$filter["x_AbsorbHP"];
		$this->AbsorbHP->AdvancedSearch->SearchOperator = @$filter["z_AbsorbHP"];
		$this->AbsorbHP->AdvancedSearch->SearchCondition = @$filter["v_AbsorbHP"];
		$this->AbsorbHP->AdvancedSearch->SearchValue2 = @$filter["y_AbsorbHP"];
		$this->AbsorbHP->AdvancedSearch->SearchOperator2 = @$filter["w_AbsorbHP"];
		$this->AbsorbHP->AdvancedSearch->Save();

		// Field ADPTV
		$this->ADPTV->AdvancedSearch->SearchValue = @$filter["x_ADPTV"];
		$this->ADPTV->AdvancedSearch->SearchOperator = @$filter["z_ADPTV"];
		$this->ADPTV->AdvancedSearch->SearchCondition = @$filter["v_ADPTV"];
		$this->ADPTV->AdvancedSearch->SearchValue2 = @$filter["y_ADPTV"];
		$this->ADPTV->AdvancedSearch->SearchOperator2 = @$filter["w_ADPTV"];
		$this->ADPTV->AdvancedSearch->Save();

		// Field ADPTR
		$this->ADPTR->AdvancedSearch->SearchValue = @$filter["x_ADPTR"];
		$this->ADPTR->AdvancedSearch->SearchOperator = @$filter["z_ADPTR"];
		$this->ADPTR->AdvancedSearch->SearchCondition = @$filter["v_ADPTR"];
		$this->ADPTR->AdvancedSearch->SearchValue2 = @$filter["y_ADPTR"];
		$this->ADPTR->AdvancedSearch->SearchOperator2 = @$filter["w_ADPTR"];
		$this->ADPTR->AdvancedSearch->Save();

		// Field APPTR
		$this->APPTR->AdvancedSearch->SearchValue = @$filter["x_APPTR"];
		$this->APPTR->AdvancedSearch->SearchOperator = @$filter["z_APPTR"];
		$this->APPTR->AdvancedSearch->SearchCondition = @$filter["v_APPTR"];
		$this->APPTR->AdvancedSearch->SearchValue2 = @$filter["y_APPTR"];
		$this->APPTR->AdvancedSearch->SearchOperator2 = @$filter["w_APPTR"];
		$this->APPTR->AdvancedSearch->Save();

		// Field APPTV
		$this->APPTV->AdvancedSearch->SearchValue = @$filter["x_APPTV"];
		$this->APPTV->AdvancedSearch->SearchOperator = @$filter["z_APPTV"];
		$this->APPTV->AdvancedSearch->SearchCondition = @$filter["v_APPTV"];
		$this->APPTV->AdvancedSearch->SearchValue2 = @$filter["y_APPTV"];
		$this->APPTV->AdvancedSearch->SearchOperator2 = @$filter["w_APPTV"];
		$this->APPTV->AdvancedSearch->Save();

		// Field ImmuneDamage
		$this->ImmuneDamage->AdvancedSearch->SearchValue = @$filter["x_ImmuneDamage"];
		$this->ImmuneDamage->AdvancedSearch->SearchOperator = @$filter["z_ImmuneDamage"];
		$this->ImmuneDamage->AdvancedSearch->SearchCondition = @$filter["v_ImmuneDamage"];
		$this->ImmuneDamage->AdvancedSearch->SearchValue2 = @$filter["y_ImmuneDamage"];
		$this->ImmuneDamage->AdvancedSearch->SearchOperator2 = @$filter["w_ImmuneDamage"];
		$this->ImmuneDamage->AdvancedSearch->Save();

		// Field Intro
		$this->Intro->AdvancedSearch->SearchValue = @$filter["x_Intro"];
		$this->Intro->AdvancedSearch->SearchOperator = @$filter["z_Intro"];
		$this->Intro->AdvancedSearch->SearchCondition = @$filter["v_Intro"];
		$this->Intro->AdvancedSearch->SearchValue2 = @$filter["y_Intro"];
		$this->Intro->AdvancedSearch->SearchOperator2 = @$filter["w_Intro"];
		$this->Intro->AdvancedSearch->Save();

		// Field ExclusiveSkills
		$this->ExclusiveSkills->AdvancedSearch->SearchValue = @$filter["x_ExclusiveSkills"];
		$this->ExclusiveSkills->AdvancedSearch->SearchOperator = @$filter["z_ExclusiveSkills"];
		$this->ExclusiveSkills->AdvancedSearch->SearchCondition = @$filter["v_ExclusiveSkills"];
		$this->ExclusiveSkills->AdvancedSearch->SearchValue2 = @$filter["y_ExclusiveSkills"];
		$this->ExclusiveSkills->AdvancedSearch->SearchOperator2 = @$filter["w_ExclusiveSkills"];
		$this->ExclusiveSkills->AdvancedSearch->Save();

		// Field TransferDemand
		$this->TransferDemand->AdvancedSearch->SearchValue = @$filter["x_TransferDemand"];
		$this->TransferDemand->AdvancedSearch->SearchOperator = @$filter["z_TransferDemand"];
		$this->TransferDemand->AdvancedSearch->SearchCondition = @$filter["v_TransferDemand"];
		$this->TransferDemand->AdvancedSearch->SearchValue2 = @$filter["y_TransferDemand"];
		$this->TransferDemand->AdvancedSearch->SearchOperator2 = @$filter["w_TransferDemand"];
		$this->TransferDemand->AdvancedSearch->Save();

		// Field TransferLevel
		$this->TransferLevel->AdvancedSearch->SearchValue = @$filter["x_TransferLevel"];
		$this->TransferLevel->AdvancedSearch->SearchOperator = @$filter["z_TransferLevel"];
		$this->TransferLevel->AdvancedSearch->SearchCondition = @$filter["v_TransferLevel"];
		$this->TransferLevel->AdvancedSearch->SearchValue2 = @$filter["y_TransferLevel"];
		$this->TransferLevel->AdvancedSearch->SearchOperator2 = @$filter["w_TransferLevel"];
		$this->TransferLevel->AdvancedSearch->Save();

		// Field FormerOccupation
		$this->FormerOccupation->AdvancedSearch->SearchValue = @$filter["x_FormerOccupation"];
		$this->FormerOccupation->AdvancedSearch->SearchOperator = @$filter["z_FormerOccupation"];
		$this->FormerOccupation->AdvancedSearch->SearchCondition = @$filter["v_FormerOccupation"];
		$this->FormerOccupation->AdvancedSearch->SearchValue2 = @$filter["y_FormerOccupation"];
		$this->FormerOccupation->AdvancedSearch->SearchOperator2 = @$filter["w_FormerOccupation"];
		$this->FormerOccupation->AdvancedSearch->Save();

		// Field Belong
		$this->Belong->AdvancedSearch->SearchValue = @$filter["x_Belong"];
		$this->Belong->AdvancedSearch->SearchOperator = @$filter["z_Belong"];
		$this->Belong->AdvancedSearch->SearchCondition = @$filter["v_Belong"];
		$this->Belong->AdvancedSearch->SearchValue2 = @$filter["y_Belong"];
		$this->Belong->AdvancedSearch->SearchOperator2 = @$filter["w_Belong"];
		$this->Belong->AdvancedSearch->Save();

		// Field AttackEffect
		$this->AttackEffect->AdvancedSearch->SearchValue = @$filter["x_AttackEffect"];
		$this->AttackEffect->AdvancedSearch->SearchOperator = @$filter["z_AttackEffect"];
		$this->AttackEffect->AdvancedSearch->SearchCondition = @$filter["v_AttackEffect"];
		$this->AttackEffect->AdvancedSearch->SearchValue2 = @$filter["y_AttackEffect"];
		$this->AttackEffect->AdvancedSearch->SearchOperator2 = @$filter["w_AttackEffect"];
		$this->AttackEffect->AdvancedSearch->Save();

		// Field AttackTips
		$this->AttackTips->AdvancedSearch->SearchValue = @$filter["x_AttackTips"];
		$this->AttackTips->AdvancedSearch->SearchOperator = @$filter["z_AttackTips"];
		$this->AttackTips->AdvancedSearch->SearchCondition = @$filter["v_AttackTips"];
		$this->AttackTips->AdvancedSearch->SearchValue2 = @$filter["y_AttackTips"];
		$this->AttackTips->AdvancedSearch->SearchOperator2 = @$filter["w_AttackTips"];
		$this->AttackTips->AdvancedSearch->Save();

		// Field MagicResistance
		$this->MagicResistance->AdvancedSearch->SearchValue = @$filter["x_MagicResistance"];
		$this->MagicResistance->AdvancedSearch->SearchOperator = @$filter["z_MagicResistance"];
		$this->MagicResistance->AdvancedSearch->SearchCondition = @$filter["v_MagicResistance"];
		$this->MagicResistance->AdvancedSearch->SearchValue2 = @$filter["y_MagicResistance"];
		$this->MagicResistance->AdvancedSearch->SearchOperator2 = @$filter["w_MagicResistance"];
		$this->MagicResistance->AdvancedSearch->Save();

		// Field IgnoreShield
		$this->IgnoreShield->AdvancedSearch->SearchValue = @$filter["x_IgnoreShield"];
		$this->IgnoreShield->AdvancedSearch->SearchOperator = @$filter["z_IgnoreShield"];
		$this->IgnoreShield->AdvancedSearch->SearchCondition = @$filter["v_IgnoreShield"];
		$this->IgnoreShield->AdvancedSearch->SearchValue2 = @$filter["y_IgnoreShield"];
		$this->IgnoreShield->AdvancedSearch->SearchOperator2 = @$filter["w_IgnoreShield"];
		$this->IgnoreShield->AdvancedSearch->Save();

		// Field DATETIME
		$this->DATETIME->AdvancedSearch->SearchValue = @$filter["x_DATETIME"];
		$this->DATETIME->AdvancedSearch->SearchOperator = @$filter["z_DATETIME"];
		$this->DATETIME->AdvancedSearch->SearchCondition = @$filter["v_DATETIME"];
		$this->DATETIME->AdvancedSearch->SearchValue2 = @$filter["y_DATETIME"];
		$this->DATETIME->AdvancedSearch->SearchOperator2 = @$filter["w_DATETIME"];
		$this->DATETIME->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->Name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Basics, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->HP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->MP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->AD, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->AP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Defense, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Hit, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Dodge, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Crit, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->AbsorbHP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ADPTV, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ADPTR, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->APPTR, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->APPTV, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ImmuneDamage, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Intro, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ExclusiveSkills, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->TransferDemand, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->TransferLevel, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->FormerOccupation, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Belong, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->AttackEffect, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->AttackTips, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->MagicResistance, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->IgnoreShield, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Name); // Name
			$this->UpdateSort($this->Basics); // Basics
			$this->UpdateSort($this->HP); // HP
			$this->UpdateSort($this->MP); // MP
			$this->UpdateSort($this->AD); // AD
			$this->UpdateSort($this->AP); // AP
			$this->UpdateSort($this->Defense); // Defense
			$this->UpdateSort($this->Hit); // Hit
			$this->UpdateSort($this->Dodge); // Dodge
			$this->UpdateSort($this->Crit); // Crit
			$this->UpdateSort($this->AbsorbHP); // AbsorbHP
			$this->UpdateSort($this->DATETIME); // DATETIME
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Name->setSort("");
				$this->Basics->setSort("");
				$this->HP->setSort("");
				$this->MP->setSort("");
				$this->AD->setSort("");
				$this->AP->setSort("");
				$this->Defense->setSort("");
				$this->Hit->setSort("");
				$this->Dodge->setSort("");
				$this->Crit->setSort("");
				$this->AbsorbHP->setSort("");
				$this->DATETIME->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit2" ks add
		//EditUrl  config_occupationedit.php?unid=10002
		$tmpEdit2Url =str_replace('?unid', '&unid', $this->EditUrl);
		$tmpEdit2Url ='../lp3k/api.php?c='. $tmpEdit2Url;
		$oListOpt->Body .= "<a class=\"ewRowLink ewEdit\" title=\"EDIT New\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($tmpEdit2Url) . "\"> EDIT New </a>";


		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->unid->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fconfig_occupationlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fconfig_occupationlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fconfig_occupationlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fconfig_occupationlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

		// DATETIME
		$this->DATETIME->ViewValue = $this->DATETIME->CurrentValue;
		$this->DATETIME->ViewValue = ew_FormatDateTime($this->DATETIME->ViewValue, 0);
		$this->DATETIME->ViewCustomAttributes = "";

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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($config_occupation_list)) $config_occupation_list = new cconfig_occupation_list();

// Page init
$config_occupation_list->Page_Init();

// Page main
$config_occupation_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_occupation_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fconfig_occupationlist = new ew_Form("fconfig_occupationlist", "list");
fconfig_occupationlist.FormKeyCountName = '<?php echo $config_occupation_list->FormKeyCountName ?>';

// Form_CustomValidate event
fconfig_occupationlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_occupationlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fconfig_occupationlistsrch = new ew_Form("fconfig_occupationlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($config_occupation_list->TotalRecs > 0 && $config_occupation_list->ExportOptions->Visible()) { ?>
<?php $config_occupation_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($config_occupation_list->SearchOptions->Visible()) { ?>
<?php $config_occupation_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($config_occupation_list->FilterOptions->Visible()) { ?>
<?php $config_occupation_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $config_occupation_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($config_occupation_list->TotalRecs <= 0)
			$config_occupation_list->TotalRecs = $config_occupation->ListRecordCount();
	} else {
		if (!$config_occupation_list->Recordset && ($config_occupation_list->Recordset = $config_occupation_list->LoadRecordset()))
			$config_occupation_list->TotalRecs = $config_occupation_list->Recordset->RecordCount();
	}
	$config_occupation_list->StartRec = 1;
	if ($config_occupation_list->DisplayRecs <= 0 || ($config_occupation->Export <> "" && $config_occupation->ExportAll)) // Display all records
		$config_occupation_list->DisplayRecs = $config_occupation_list->TotalRecs;
	if (!($config_occupation->Export <> "" && $config_occupation->ExportAll))
		$config_occupation_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$config_occupation_list->Recordset = $config_occupation_list->LoadRecordset($config_occupation_list->StartRec-1, $config_occupation_list->DisplayRecs);

	// Set no record found message
	if ($config_occupation->CurrentAction == "" && $config_occupation_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$config_occupation_list->setWarningMessage(ew_DeniedMsg());
		if ($config_occupation_list->SearchWhere == "0=101")
			$config_occupation_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$config_occupation_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$config_occupation_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($config_occupation->Export == "" && $config_occupation->CurrentAction == "") { ?>
<form name="fconfig_occupationlistsrch" id="fconfig_occupationlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($config_occupation_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fconfig_occupationlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="config_occupation">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($config_occupation_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($config_occupation_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $config_occupation_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($config_occupation_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($config_occupation_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($config_occupation_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($config_occupation_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $config_occupation_list->ShowPageHeader(); ?>
<?php
$config_occupation_list->ShowMessage();
?>
<?php if ($config_occupation_list->TotalRecs > 0 || $config_occupation->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($config_occupation_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> config_occupation">
<form name="fconfig_occupationlist" id="fconfig_occupationlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_occupation_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_occupation_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_occupation">
<div id="gmp_config_occupation" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($config_occupation_list->TotalRecs > 0 || $config_occupation->CurrentAction == "gridedit") { ?>
<table id="tbl_config_occupationlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$config_occupation_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$config_occupation_list->RenderListOptions();

// Render list options (header, left)
$config_occupation_list->ListOptions->Render("header", "left");
?>
<?php if ($config_occupation->Name->Visible) { // Name ?>
	<?php if ($config_occupation->SortUrl($config_occupation->Name) == "") { ?>
		<th data-name="Name" class="<?php echo $config_occupation->Name->HeaderCellClass() ?>"><div id="elh_config_occupation_Name" class="config_occupation_Name"><div class="ewTableHeaderCaption"><?php echo $config_occupation->Name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Name" class="<?php echo $config_occupation->Name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->Name) ?>',1);"><div id="elh_config_occupation_Name" class="config_occupation_Name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->Name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->Name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->Name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->Basics->Visible) { // Basics ?>
	<?php if ($config_occupation->SortUrl($config_occupation->Basics) == "") { ?>
		<th data-name="Basics" class="<?php echo $config_occupation->Basics->HeaderCellClass() ?>"><div id="elh_config_occupation_Basics" class="config_occupation_Basics"><div class="ewTableHeaderCaption"><?php echo $config_occupation->Basics->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Basics" class="<?php echo $config_occupation->Basics->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->Basics) ?>',1);"><div id="elh_config_occupation_Basics" class="config_occupation_Basics">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->Basics->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->Basics->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->Basics->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->HP->Visible) { // HP ?>
	<?php if ($config_occupation->SortUrl($config_occupation->HP) == "") { ?>
		<th data-name="HP" class="<?php echo $config_occupation->HP->HeaderCellClass() ?>"><div id="elh_config_occupation_HP" class="config_occupation_HP"><div class="ewTableHeaderCaption"><?php echo $config_occupation->HP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="HP" class="<?php echo $config_occupation->HP->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->HP) ?>',1);"><div id="elh_config_occupation_HP" class="config_occupation_HP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->HP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->HP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->HP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->MP->Visible) { // MP ?>
	<?php if ($config_occupation->SortUrl($config_occupation->MP) == "") { ?>
		<th data-name="MP" class="<?php echo $config_occupation->MP->HeaderCellClass() ?>"><div id="elh_config_occupation_MP" class="config_occupation_MP"><div class="ewTableHeaderCaption"><?php echo $config_occupation->MP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="MP" class="<?php echo $config_occupation->MP->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->MP) ?>',1);"><div id="elh_config_occupation_MP" class="config_occupation_MP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->MP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->MP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->MP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->AD->Visible) { // AD ?>
	<?php if ($config_occupation->SortUrl($config_occupation->AD) == "") { ?>
		<th data-name="AD" class="<?php echo $config_occupation->AD->HeaderCellClass() ?>"><div id="elh_config_occupation_AD" class="config_occupation_AD"><div class="ewTableHeaderCaption"><?php echo $config_occupation->AD->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AD" class="<?php echo $config_occupation->AD->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->AD) ?>',1);"><div id="elh_config_occupation_AD" class="config_occupation_AD">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->AD->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->AD->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->AD->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->AP->Visible) { // AP ?>
	<?php if ($config_occupation->SortUrl($config_occupation->AP) == "") { ?>
		<th data-name="AP" class="<?php echo $config_occupation->AP->HeaderCellClass() ?>"><div id="elh_config_occupation_AP" class="config_occupation_AP"><div class="ewTableHeaderCaption"><?php echo $config_occupation->AP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AP" class="<?php echo $config_occupation->AP->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->AP) ?>',1);"><div id="elh_config_occupation_AP" class="config_occupation_AP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->AP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->AP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->AP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->Defense->Visible) { // Defense ?>
	<?php if ($config_occupation->SortUrl($config_occupation->Defense) == "") { ?>
		<th data-name="Defense" class="<?php echo $config_occupation->Defense->HeaderCellClass() ?>"><div id="elh_config_occupation_Defense" class="config_occupation_Defense"><div class="ewTableHeaderCaption"><?php echo $config_occupation->Defense->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Defense" class="<?php echo $config_occupation->Defense->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->Defense) ?>',1);"><div id="elh_config_occupation_Defense" class="config_occupation_Defense">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->Defense->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->Defense->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->Defense->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->Hit->Visible) { // Hit ?>
	<?php if ($config_occupation->SortUrl($config_occupation->Hit) == "") { ?>
		<th data-name="Hit" class="<?php echo $config_occupation->Hit->HeaderCellClass() ?>"><div id="elh_config_occupation_Hit" class="config_occupation_Hit"><div class="ewTableHeaderCaption"><?php echo $config_occupation->Hit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Hit" class="<?php echo $config_occupation->Hit->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->Hit) ?>',1);"><div id="elh_config_occupation_Hit" class="config_occupation_Hit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->Hit->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->Hit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->Hit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->Dodge->Visible) { // Dodge ?>
	<?php if ($config_occupation->SortUrl($config_occupation->Dodge) == "") { ?>
		<th data-name="Dodge" class="<?php echo $config_occupation->Dodge->HeaderCellClass() ?>"><div id="elh_config_occupation_Dodge" class="config_occupation_Dodge"><div class="ewTableHeaderCaption"><?php echo $config_occupation->Dodge->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dodge" class="<?php echo $config_occupation->Dodge->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->Dodge) ?>',1);"><div id="elh_config_occupation_Dodge" class="config_occupation_Dodge">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->Dodge->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->Dodge->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->Dodge->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->Crit->Visible) { // Crit ?>
	<?php if ($config_occupation->SortUrl($config_occupation->Crit) == "") { ?>
		<th data-name="Crit" class="<?php echo $config_occupation->Crit->HeaderCellClass() ?>"><div id="elh_config_occupation_Crit" class="config_occupation_Crit"><div class="ewTableHeaderCaption"><?php echo $config_occupation->Crit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Crit" class="<?php echo $config_occupation->Crit->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->Crit) ?>',1);"><div id="elh_config_occupation_Crit" class="config_occupation_Crit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->Crit->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->Crit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->Crit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->AbsorbHP->Visible) { // AbsorbHP ?>
	<?php if ($config_occupation->SortUrl($config_occupation->AbsorbHP) == "") { ?>
		<th data-name="AbsorbHP" class="<?php echo $config_occupation->AbsorbHP->HeaderCellClass() ?>"><div id="elh_config_occupation_AbsorbHP" class="config_occupation_AbsorbHP"><div class="ewTableHeaderCaption"><?php echo $config_occupation->AbsorbHP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AbsorbHP" class="<?php echo $config_occupation->AbsorbHP->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->AbsorbHP) ?>',1);"><div id="elh_config_occupation_AbsorbHP" class="config_occupation_AbsorbHP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->AbsorbHP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->AbsorbHP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->AbsorbHP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_occupation->DATETIME->Visible) { // DATETIME ?>
	<?php if ($config_occupation->SortUrl($config_occupation->DATETIME) == "") { ?>
		<th data-name="DATETIME" class="<?php echo $config_occupation->DATETIME->HeaderCellClass() ?>"><div id="elh_config_occupation_DATETIME" class="config_occupation_DATETIME"><div class="ewTableHeaderCaption"><?php echo $config_occupation->DATETIME->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DATETIME" class="<?php echo $config_occupation->DATETIME->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_occupation->SortUrl($config_occupation->DATETIME) ?>',1);"><div id="elh_config_occupation_DATETIME" class="config_occupation_DATETIME">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_occupation->DATETIME->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($config_occupation->DATETIME->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_occupation->DATETIME->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$config_occupation_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($config_occupation->ExportAll && $config_occupation->Export <> "") {
	$config_occupation_list->StopRec = $config_occupation_list->TotalRecs;
} else {

	// Set the last record to display
	if ($config_occupation_list->TotalRecs > $config_occupation_list->StartRec + $config_occupation_list->DisplayRecs - 1)
		$config_occupation_list->StopRec = $config_occupation_list->StartRec + $config_occupation_list->DisplayRecs - 1;
	else
		$config_occupation_list->StopRec = $config_occupation_list->TotalRecs;
}
$config_occupation_list->RecCnt = $config_occupation_list->StartRec - 1;
if ($config_occupation_list->Recordset && !$config_occupation_list->Recordset->EOF) {
	$config_occupation_list->Recordset->MoveFirst();
	$bSelectLimit = $config_occupation_list->UseSelectLimit;
	if (!$bSelectLimit && $config_occupation_list->StartRec > 1)
		$config_occupation_list->Recordset->Move($config_occupation_list->StartRec - 1);
} elseif (!$config_occupation->AllowAddDeleteRow && $config_occupation_list->StopRec == 0) {
	$config_occupation_list->StopRec = $config_occupation->GridAddRowCount;
}

// Initialize aggregate
$config_occupation->RowType = EW_ROWTYPE_AGGREGATEINIT;
$config_occupation->ResetAttrs();
$config_occupation_list->RenderRow();
while ($config_occupation_list->RecCnt < $config_occupation_list->StopRec) {
	$config_occupation_list->RecCnt++;
	if (intval($config_occupation_list->RecCnt) >= intval($config_occupation_list->StartRec)) {
		$config_occupation_list->RowCnt++;

		// Set up key count
		$config_occupation_list->KeyCount = $config_occupation_list->RowIndex;

		// Init row class and style
		$config_occupation->ResetAttrs();
		$config_occupation->CssClass = "";
		if ($config_occupation->CurrentAction == "gridadd") {
		} else {
			$config_occupation_list->LoadRowValues($config_occupation_list->Recordset); // Load row values
		}
		$config_occupation->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$config_occupation->RowAttrs = array_merge($config_occupation->RowAttrs, array('data-rowindex'=>$config_occupation_list->RowCnt, 'id'=>'r' . $config_occupation_list->RowCnt . '_config_occupation', 'data-rowtype'=>$config_occupation->RowType));

		// Render row
		$config_occupation_list->RenderRow();

		// Render list options
		$config_occupation_list->RenderListOptions();
?>
	<tr<?php echo $config_occupation->RowAttributes() ?>>
<?php

// Render list options (body, left)
$config_occupation_list->ListOptions->Render("body", "left", $config_occupation_list->RowCnt);
?>
	<?php if ($config_occupation->Name->Visible) { // Name ?>
		<td data-name="Name"<?php echo $config_occupation->Name->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_Name" class="config_occupation_Name">
<span<?php echo $config_occupation->Name->ViewAttributes() ?>>
<?php echo $config_occupation->Name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->Basics->Visible) { // Basics ?>
		<td data-name="Basics"<?php echo $config_occupation->Basics->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_Basics" class="config_occupation_Basics">
<span<?php echo $config_occupation->Basics->ViewAttributes() ?>>
<?php echo $config_occupation->Basics->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->HP->Visible) { // HP ?>
		<td data-name="HP"<?php echo $config_occupation->HP->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_HP" class="config_occupation_HP">
<span<?php echo $config_occupation->HP->ViewAttributes() ?>>
<?php echo $config_occupation->HP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->MP->Visible) { // MP ?>
		<td data-name="MP"<?php echo $config_occupation->MP->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_MP" class="config_occupation_MP">
<span<?php echo $config_occupation->MP->ViewAttributes() ?>>
<?php echo $config_occupation->MP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->AD->Visible) { // AD ?>
		<td data-name="AD"<?php echo $config_occupation->AD->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_AD" class="config_occupation_AD">
<span<?php echo $config_occupation->AD->ViewAttributes() ?>>
<?php echo $config_occupation->AD->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->AP->Visible) { // AP ?>
		<td data-name="AP"<?php echo $config_occupation->AP->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_AP" class="config_occupation_AP">
<span<?php echo $config_occupation->AP->ViewAttributes() ?>>
<?php echo $config_occupation->AP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->Defense->Visible) { // Defense ?>
		<td data-name="Defense"<?php echo $config_occupation->Defense->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_Defense" class="config_occupation_Defense">
<span<?php echo $config_occupation->Defense->ViewAttributes() ?>>
<?php echo $config_occupation->Defense->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->Hit->Visible) { // Hit ?>
		<td data-name="Hit"<?php echo $config_occupation->Hit->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_Hit" class="config_occupation_Hit">
<span<?php echo $config_occupation->Hit->ViewAttributes() ?>>
<?php echo $config_occupation->Hit->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->Dodge->Visible) { // Dodge ?>
		<td data-name="Dodge"<?php echo $config_occupation->Dodge->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_Dodge" class="config_occupation_Dodge">
<span<?php echo $config_occupation->Dodge->ViewAttributes() ?>>
<?php echo $config_occupation->Dodge->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->Crit->Visible) { // Crit ?>
		<td data-name="Crit"<?php echo $config_occupation->Crit->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_Crit" class="config_occupation_Crit">
<span<?php echo $config_occupation->Crit->ViewAttributes() ?>>
<?php echo $config_occupation->Crit->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->AbsorbHP->Visible) { // AbsorbHP ?>
		<td data-name="AbsorbHP"<?php echo $config_occupation->AbsorbHP->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_AbsorbHP" class="config_occupation_AbsorbHP">
<span<?php echo $config_occupation->AbsorbHP->ViewAttributes() ?>>
<?php echo $config_occupation->AbsorbHP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_occupation->DATETIME->Visible) { // DATETIME ?>
		<td data-name="DATETIME"<?php echo $config_occupation->DATETIME->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_list->RowCnt ?>_config_occupation_DATETIME" class="config_occupation_DATETIME">
<span<?php echo $config_occupation->DATETIME->ViewAttributes() ?>>
<?php echo $config_occupation->DATETIME->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$config_occupation_list->ListOptions->Render("body", "right", $config_occupation_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($config_occupation->CurrentAction <> "gridadd")
		$config_occupation_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($config_occupation->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($config_occupation_list->Recordset)
	$config_occupation_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($config_occupation->CurrentAction <> "gridadd" && $config_occupation->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($config_occupation_list->Pager)) $config_occupation_list->Pager = new cPrevNextPager($config_occupation_list->StartRec, $config_occupation_list->DisplayRecs, $config_occupation_list->TotalRecs, $config_occupation_list->AutoHidePager) ?>
<?php if ($config_occupation_list->Pager->RecordCount > 0 && $config_occupation_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($config_occupation_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $config_occupation_list->PageUrl() ?>start=<?php echo $config_occupation_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($config_occupation_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $config_occupation_list->PageUrl() ?>start=<?php echo $config_occupation_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $config_occupation_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($config_occupation_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $config_occupation_list->PageUrl() ?>start=<?php echo $config_occupation_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($config_occupation_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $config_occupation_list->PageUrl() ?>start=<?php echo $config_occupation_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $config_occupation_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($config_occupation_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $config_occupation_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $config_occupation_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $config_occupation_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($config_occupation_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($config_occupation_list->TotalRecs == 0 && $config_occupation->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($config_occupation_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fconfig_occupationlistsrch.FilterList = <?php echo $config_occupation_list->GetFilterList() ?>;
fconfig_occupationlistsrch.Init();
fconfig_occupationlist.Init();
</script>
<?php
$config_occupation_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_occupation_list->Page_Terminate();
?>
