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

$config_map_list = NULL; // Initialize page object first

class cconfig_map_list extends cconfig_map {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_map';

	// Page object name
	var $PageObjName = 'config_map_list';

	// Grid form hidden field names
	var $FormName = 'fconfig_maplist';
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

		// Table object (config_map)
		if (!isset($GLOBALS["config_map"]) || get_class($GLOBALS["config_map"]) == "cconfig_map") {
			$GLOBALS["config_map"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_map"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "config_mapadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "config_mapdelete.php";
		$this->MultiUpdateUrl = "config_mapupdate.php";

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fconfig_maplistsrch";

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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fconfig_maplistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->unid->AdvancedSearch->ToJson(), ","); // Field unid
		$sFilterList = ew_Concat($sFilterList, $this->u_id->AdvancedSearch->ToJson(), ","); // Field u_id
		$sFilterList = ew_Concat($sFilterList, $this->acl_id->AdvancedSearch->ToJson(), ","); // Field acl_id
		$sFilterList = ew_Concat($sFilterList, $this->Name->AdvancedSearch->ToJson(), ","); // Field Name
		$sFilterList = ew_Concat($sFilterList, $this->LV->AdvancedSearch->ToJson(), ","); // Field LV
		$sFilterList = ew_Concat($sFilterList, $this->Introduce->AdvancedSearch->ToJson(), ","); // Field Introduce
		$sFilterList = ew_Concat($sFilterList, $this->_Security->AdvancedSearch->ToJson(), ","); // Field Security
		$sFilterList = ew_Concat($sFilterList, $this->Hid->AdvancedSearch->ToJson(), ","); // Field Hid
		$sFilterList = ew_Concat($sFilterList, $this->Basis->AdvancedSearch->ToJson(), ","); // Field Basis
		$sFilterList = ew_Concat($sFilterList, $this->Monster->AdvancedSearch->ToJson(), ","); // Field Monster
		$sFilterList = ew_Concat($sFilterList, $this->UP->AdvancedSearch->ToJson(), ","); // Field UP
		$sFilterList = ew_Concat($sFilterList, $this->Down->AdvancedSearch->ToJson(), ","); // Field Down
		$sFilterList = ew_Concat($sFilterList, $this->Left->AdvancedSearch->ToJson(), ","); // Field Left
		$sFilterList = ew_Concat($sFilterList, $this->Right->AdvancedSearch->ToJson(), ","); // Field Right
		$sFilterList = ew_Concat($sFilterList, $this->Consume->AdvancedSearch->ToJson(), ","); // Field Consume
		$sFilterList = ew_Concat($sFilterList, $this->LV_UP->AdvancedSearch->ToJson(), ","); // Field LV_UP
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fconfig_maplistsrch", $filters);

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

		// Field LV
		$this->LV->AdvancedSearch->SearchValue = @$filter["x_LV"];
		$this->LV->AdvancedSearch->SearchOperator = @$filter["z_LV"];
		$this->LV->AdvancedSearch->SearchCondition = @$filter["v_LV"];
		$this->LV->AdvancedSearch->SearchValue2 = @$filter["y_LV"];
		$this->LV->AdvancedSearch->SearchOperator2 = @$filter["w_LV"];
		$this->LV->AdvancedSearch->Save();

		// Field Introduce
		$this->Introduce->AdvancedSearch->SearchValue = @$filter["x_Introduce"];
		$this->Introduce->AdvancedSearch->SearchOperator = @$filter["z_Introduce"];
		$this->Introduce->AdvancedSearch->SearchCondition = @$filter["v_Introduce"];
		$this->Introduce->AdvancedSearch->SearchValue2 = @$filter["y_Introduce"];
		$this->Introduce->AdvancedSearch->SearchOperator2 = @$filter["w_Introduce"];
		$this->Introduce->AdvancedSearch->Save();

		// Field Security
		$this->_Security->AdvancedSearch->SearchValue = @$filter["x__Security"];
		$this->_Security->AdvancedSearch->SearchOperator = @$filter["z__Security"];
		$this->_Security->AdvancedSearch->SearchCondition = @$filter["v__Security"];
		$this->_Security->AdvancedSearch->SearchValue2 = @$filter["y__Security"];
		$this->_Security->AdvancedSearch->SearchOperator2 = @$filter["w__Security"];
		$this->_Security->AdvancedSearch->Save();

		// Field Hid
		$this->Hid->AdvancedSearch->SearchValue = @$filter["x_Hid"];
		$this->Hid->AdvancedSearch->SearchOperator = @$filter["z_Hid"];
		$this->Hid->AdvancedSearch->SearchCondition = @$filter["v_Hid"];
		$this->Hid->AdvancedSearch->SearchValue2 = @$filter["y_Hid"];
		$this->Hid->AdvancedSearch->SearchOperator2 = @$filter["w_Hid"];
		$this->Hid->AdvancedSearch->Save();

		// Field Basis
		$this->Basis->AdvancedSearch->SearchValue = @$filter["x_Basis"];
		$this->Basis->AdvancedSearch->SearchOperator = @$filter["z_Basis"];
		$this->Basis->AdvancedSearch->SearchCondition = @$filter["v_Basis"];
		$this->Basis->AdvancedSearch->SearchValue2 = @$filter["y_Basis"];
		$this->Basis->AdvancedSearch->SearchOperator2 = @$filter["w_Basis"];
		$this->Basis->AdvancedSearch->Save();

		// Field Monster
		$this->Monster->AdvancedSearch->SearchValue = @$filter["x_Monster"];
		$this->Monster->AdvancedSearch->SearchOperator = @$filter["z_Monster"];
		$this->Monster->AdvancedSearch->SearchCondition = @$filter["v_Monster"];
		$this->Monster->AdvancedSearch->SearchValue2 = @$filter["y_Monster"];
		$this->Monster->AdvancedSearch->SearchOperator2 = @$filter["w_Monster"];
		$this->Monster->AdvancedSearch->Save();

		// Field UP
		$this->UP->AdvancedSearch->SearchValue = @$filter["x_UP"];
		$this->UP->AdvancedSearch->SearchOperator = @$filter["z_UP"];
		$this->UP->AdvancedSearch->SearchCondition = @$filter["v_UP"];
		$this->UP->AdvancedSearch->SearchValue2 = @$filter["y_UP"];
		$this->UP->AdvancedSearch->SearchOperator2 = @$filter["w_UP"];
		$this->UP->AdvancedSearch->Save();

		// Field Down
		$this->Down->AdvancedSearch->SearchValue = @$filter["x_Down"];
		$this->Down->AdvancedSearch->SearchOperator = @$filter["z_Down"];
		$this->Down->AdvancedSearch->SearchCondition = @$filter["v_Down"];
		$this->Down->AdvancedSearch->SearchValue2 = @$filter["y_Down"];
		$this->Down->AdvancedSearch->SearchOperator2 = @$filter["w_Down"];
		$this->Down->AdvancedSearch->Save();

		// Field Left
		$this->Left->AdvancedSearch->SearchValue = @$filter["x_Left"];
		$this->Left->AdvancedSearch->SearchOperator = @$filter["z_Left"];
		$this->Left->AdvancedSearch->SearchCondition = @$filter["v_Left"];
		$this->Left->AdvancedSearch->SearchValue2 = @$filter["y_Left"];
		$this->Left->AdvancedSearch->SearchOperator2 = @$filter["w_Left"];
		$this->Left->AdvancedSearch->Save();

		// Field Right
		$this->Right->AdvancedSearch->SearchValue = @$filter["x_Right"];
		$this->Right->AdvancedSearch->SearchOperator = @$filter["z_Right"];
		$this->Right->AdvancedSearch->SearchCondition = @$filter["v_Right"];
		$this->Right->AdvancedSearch->SearchValue2 = @$filter["y_Right"];
		$this->Right->AdvancedSearch->SearchOperator2 = @$filter["w_Right"];
		$this->Right->AdvancedSearch->Save();

		// Field Consume
		$this->Consume->AdvancedSearch->SearchValue = @$filter["x_Consume"];
		$this->Consume->AdvancedSearch->SearchOperator = @$filter["z_Consume"];
		$this->Consume->AdvancedSearch->SearchCondition = @$filter["v_Consume"];
		$this->Consume->AdvancedSearch->SearchValue2 = @$filter["y_Consume"];
		$this->Consume->AdvancedSearch->SearchOperator2 = @$filter["w_Consume"];
		$this->Consume->AdvancedSearch->Save();

		// Field LV_UP
		$this->LV_UP->AdvancedSearch->SearchValue = @$filter["x_LV_UP"];
		$this->LV_UP->AdvancedSearch->SearchOperator = @$filter["z_LV_UP"];
		$this->LV_UP->AdvancedSearch->SearchCondition = @$filter["v_LV_UP"];
		$this->LV_UP->AdvancedSearch->SearchValue2 = @$filter["y_LV_UP"];
		$this->LV_UP->AdvancedSearch->SearchOperator2 = @$filter["w_LV_UP"];
		$this->LV_UP->AdvancedSearch->Save();

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
		$this->BuildBasicSearchSQL($sWhere, $this->LV, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Introduce, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->_Security, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Hid, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Basis, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->UP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Down, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Left, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Right, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Consume, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->LV_UP, $arKeywords, $type);
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
			$this->UpdateSort($this->LV); // LV
			$this->UpdateSort($this->Introduce); // Introduce
			$this->UpdateSort($this->_Security); // Security
			$this->UpdateSort($this->Hid); // Hid
			$this->UpdateSort($this->Basis); // Basis
			$this->UpdateSort($this->Monster); // Monster
			$this->UpdateSort($this->UP); // UP
			$this->UpdateSort($this->Down); // Down
			$this->UpdateSort($this->Left); // Left
			$this->UpdateSort($this->Right); // Right
			$this->UpdateSort($this->Consume); // Consume
			$this->UpdateSort($this->LV_UP); // LV_UP
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
				$this->LV->setSort("");
				$this->Introduce->setSort("");
				$this->_Security->setSort("");
				$this->Hid->setSort("");
				$this->Basis->setSort("");
				$this->Monster->setSort("");
				$this->UP->setSort("");
				$this->Down->setSort("");
				$this->Left->setSort("");
				$this->Right->setSort("");
				$this->Consume->setSort("");
				$this->LV_UP->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fconfig_maplistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fconfig_maplistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fconfig_maplist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fconfig_maplistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
if (!isset($config_map_list)) $config_map_list = new cconfig_map_list();

// Page init
$config_map_list->Page_Init();

// Page main
$config_map_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_map_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fconfig_maplist = new ew_Form("fconfig_maplist", "list");
fconfig_maplist.FormKeyCountName = '<?php echo $config_map_list->FormKeyCountName ?>';

// Form_CustomValidate event
fconfig_maplist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_maplist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fconfig_maplistsrch = new ew_Form("fconfig_maplistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($config_map_list->TotalRecs > 0 && $config_map_list->ExportOptions->Visible()) { ?>
<?php $config_map_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($config_map_list->SearchOptions->Visible()) { ?>
<?php $config_map_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($config_map_list->FilterOptions->Visible()) { ?>
<?php $config_map_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $config_map_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($config_map_list->TotalRecs <= 0)
			$config_map_list->TotalRecs = $config_map->ListRecordCount();
	} else {
		if (!$config_map_list->Recordset && ($config_map_list->Recordset = $config_map_list->LoadRecordset()))
			$config_map_list->TotalRecs = $config_map_list->Recordset->RecordCount();
	}
	$config_map_list->StartRec = 1;
	if ($config_map_list->DisplayRecs <= 0 || ($config_map->Export <> "" && $config_map->ExportAll)) // Display all records
		$config_map_list->DisplayRecs = $config_map_list->TotalRecs;
	if (!($config_map->Export <> "" && $config_map->ExportAll))
		$config_map_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$config_map_list->Recordset = $config_map_list->LoadRecordset($config_map_list->StartRec-1, $config_map_list->DisplayRecs);

	// Set no record found message
	if ($config_map->CurrentAction == "" && $config_map_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$config_map_list->setWarningMessage(ew_DeniedMsg());
		if ($config_map_list->SearchWhere == "0=101")
			$config_map_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$config_map_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$config_map_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($config_map->Export == "" && $config_map->CurrentAction == "") { ?>
<form name="fconfig_maplistsrch" id="fconfig_maplistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($config_map_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fconfig_maplistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="config_map">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($config_map_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($config_map_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $config_map_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($config_map_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($config_map_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($config_map_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($config_map_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $config_map_list->ShowPageHeader(); ?>
<?php
$config_map_list->ShowMessage();
?>
<?php if ($config_map_list->TotalRecs > 0 || $config_map->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($config_map_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> config_map">
<form name="fconfig_maplist" id="fconfig_maplist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_map_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_map_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_map">
<div id="gmp_config_map" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($config_map_list->TotalRecs > 0 || $config_map->CurrentAction == "gridedit") { ?>
<table id="tbl_config_maplist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$config_map_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$config_map_list->RenderListOptions();

// Render list options (header, left)
$config_map_list->ListOptions->Render("header", "left");
?>
<?php if ($config_map->Name->Visible) { // Name ?>
	<?php if ($config_map->SortUrl($config_map->Name) == "") { ?>
		<th data-name="Name" class="<?php echo $config_map->Name->HeaderCellClass() ?>"><div id="elh_config_map_Name" class="config_map_Name"><div class="ewTableHeaderCaption"><?php echo $config_map->Name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Name" class="<?php echo $config_map->Name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->Name) ?>',1);"><div id="elh_config_map_Name" class="config_map_Name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->Name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->Name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->Name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->LV->Visible) { // LV ?>
	<?php if ($config_map->SortUrl($config_map->LV) == "") { ?>
		<th data-name="LV" class="<?php echo $config_map->LV->HeaderCellClass() ?>"><div id="elh_config_map_LV" class="config_map_LV"><div class="ewTableHeaderCaption"><?php echo $config_map->LV->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="LV" class="<?php echo $config_map->LV->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->LV) ?>',1);"><div id="elh_config_map_LV" class="config_map_LV">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->LV->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->LV->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->LV->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->Introduce->Visible) { // Introduce ?>
	<?php if ($config_map->SortUrl($config_map->Introduce) == "") { ?>
		<th data-name="Introduce" class="<?php echo $config_map->Introduce->HeaderCellClass() ?>"><div id="elh_config_map_Introduce" class="config_map_Introduce"><div class="ewTableHeaderCaption"><?php echo $config_map->Introduce->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Introduce" class="<?php echo $config_map->Introduce->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->Introduce) ?>',1);"><div id="elh_config_map_Introduce" class="config_map_Introduce">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->Introduce->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->Introduce->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->Introduce->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->_Security->Visible) { // Security ?>
	<?php if ($config_map->SortUrl($config_map->_Security) == "") { ?>
		<th data-name="_Security" class="<?php echo $config_map->_Security->HeaderCellClass() ?>"><div id="elh_config_map__Security" class="config_map__Security"><div class="ewTableHeaderCaption"><?php echo $config_map->_Security->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_Security" class="<?php echo $config_map->_Security->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->_Security) ?>',1);"><div id="elh_config_map__Security" class="config_map__Security">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->_Security->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->_Security->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->_Security->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->Hid->Visible) { // Hid ?>
	<?php if ($config_map->SortUrl($config_map->Hid) == "") { ?>
		<th data-name="Hid" class="<?php echo $config_map->Hid->HeaderCellClass() ?>"><div id="elh_config_map_Hid" class="config_map_Hid"><div class="ewTableHeaderCaption"><?php echo $config_map->Hid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Hid" class="<?php echo $config_map->Hid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->Hid) ?>',1);"><div id="elh_config_map_Hid" class="config_map_Hid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->Hid->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->Hid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->Hid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->Basis->Visible) { // Basis ?>
	<?php if ($config_map->SortUrl($config_map->Basis) == "") { ?>
		<th data-name="Basis" class="<?php echo $config_map->Basis->HeaderCellClass() ?>"><div id="elh_config_map_Basis" class="config_map_Basis"><div class="ewTableHeaderCaption"><?php echo $config_map->Basis->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Basis" class="<?php echo $config_map->Basis->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->Basis) ?>',1);"><div id="elh_config_map_Basis" class="config_map_Basis">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->Basis->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->Basis->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->Basis->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->Monster->Visible) { // Monster ?>
	<?php if ($config_map->SortUrl($config_map->Monster) == "") { ?>
		<th data-name="Monster" class="<?php echo $config_map->Monster->HeaderCellClass() ?>"><div id="elh_config_map_Monster" class="config_map_Monster"><div class="ewTableHeaderCaption"><?php echo $config_map->Monster->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster" class="<?php echo $config_map->Monster->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->Monster) ?>',1);"><div id="elh_config_map_Monster" class="config_map_Monster">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->Monster->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->Monster->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->Monster->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->UP->Visible) { // UP ?>
	<?php if ($config_map->SortUrl($config_map->UP) == "") { ?>
		<th data-name="UP" class="<?php echo $config_map->UP->HeaderCellClass() ?>"><div id="elh_config_map_UP" class="config_map_UP"><div class="ewTableHeaderCaption"><?php echo $config_map->UP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="UP" class="<?php echo $config_map->UP->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->UP) ?>',1);"><div id="elh_config_map_UP" class="config_map_UP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->UP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->UP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->UP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->Down->Visible) { // Down ?>
	<?php if ($config_map->SortUrl($config_map->Down) == "") { ?>
		<th data-name="Down" class="<?php echo $config_map->Down->HeaderCellClass() ?>"><div id="elh_config_map_Down" class="config_map_Down"><div class="ewTableHeaderCaption"><?php echo $config_map->Down->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Down" class="<?php echo $config_map->Down->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->Down) ?>',1);"><div id="elh_config_map_Down" class="config_map_Down">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->Down->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->Down->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->Down->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->Left->Visible) { // Left ?>
	<?php if ($config_map->SortUrl($config_map->Left) == "") { ?>
		<th data-name="Left" class="<?php echo $config_map->Left->HeaderCellClass() ?>"><div id="elh_config_map_Left" class="config_map_Left"><div class="ewTableHeaderCaption"><?php echo $config_map->Left->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Left" class="<?php echo $config_map->Left->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->Left) ?>',1);"><div id="elh_config_map_Left" class="config_map_Left">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->Left->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->Left->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->Left->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->Right->Visible) { // Right ?>
	<?php if ($config_map->SortUrl($config_map->Right) == "") { ?>
		<th data-name="Right" class="<?php echo $config_map->Right->HeaderCellClass() ?>"><div id="elh_config_map_Right" class="config_map_Right"><div class="ewTableHeaderCaption"><?php echo $config_map->Right->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Right" class="<?php echo $config_map->Right->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->Right) ?>',1);"><div id="elh_config_map_Right" class="config_map_Right">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->Right->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->Right->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->Right->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->Consume->Visible) { // Consume ?>
	<?php if ($config_map->SortUrl($config_map->Consume) == "") { ?>
		<th data-name="Consume" class="<?php echo $config_map->Consume->HeaderCellClass() ?>"><div id="elh_config_map_Consume" class="config_map_Consume"><div class="ewTableHeaderCaption"><?php echo $config_map->Consume->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Consume" class="<?php echo $config_map->Consume->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->Consume) ?>',1);"><div id="elh_config_map_Consume" class="config_map_Consume">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->Consume->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->Consume->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->Consume->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_map->LV_UP->Visible) { // LV_UP ?>
	<?php if ($config_map->SortUrl($config_map->LV_UP) == "") { ?>
		<th data-name="LV_UP" class="<?php echo $config_map->LV_UP->HeaderCellClass() ?>"><div id="elh_config_map_LV_UP" class="config_map_LV_UP"><div class="ewTableHeaderCaption"><?php echo $config_map->LV_UP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="LV_UP" class="<?php echo $config_map->LV_UP->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_map->SortUrl($config_map->LV_UP) ?>',1);"><div id="elh_config_map_LV_UP" class="config_map_LV_UP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_map->LV_UP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_map->LV_UP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_map->LV_UP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$config_map_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($config_map->ExportAll && $config_map->Export <> "") {
	$config_map_list->StopRec = $config_map_list->TotalRecs;
} else {

	// Set the last record to display
	if ($config_map_list->TotalRecs > $config_map_list->StartRec + $config_map_list->DisplayRecs - 1)
		$config_map_list->StopRec = $config_map_list->StartRec + $config_map_list->DisplayRecs - 1;
	else
		$config_map_list->StopRec = $config_map_list->TotalRecs;
}
$config_map_list->RecCnt = $config_map_list->StartRec - 1;
if ($config_map_list->Recordset && !$config_map_list->Recordset->EOF) {
	$config_map_list->Recordset->MoveFirst();
	$bSelectLimit = $config_map_list->UseSelectLimit;
	if (!$bSelectLimit && $config_map_list->StartRec > 1)
		$config_map_list->Recordset->Move($config_map_list->StartRec - 1);
} elseif (!$config_map->AllowAddDeleteRow && $config_map_list->StopRec == 0) {
	$config_map_list->StopRec = $config_map->GridAddRowCount;
}

// Initialize aggregate
$config_map->RowType = EW_ROWTYPE_AGGREGATEINIT;
$config_map->ResetAttrs();
$config_map_list->RenderRow();
while ($config_map_list->RecCnt < $config_map_list->StopRec) {
	$config_map_list->RecCnt++;
	if (intval($config_map_list->RecCnt) >= intval($config_map_list->StartRec)) {
		$config_map_list->RowCnt++;

		// Set up key count
		$config_map_list->KeyCount = $config_map_list->RowIndex;

		// Init row class and style
		$config_map->ResetAttrs();
		$config_map->CssClass = "";
		if ($config_map->CurrentAction == "gridadd") {
		} else {
			$config_map_list->LoadRowValues($config_map_list->Recordset); // Load row values
		}
		$config_map->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$config_map->RowAttrs = array_merge($config_map->RowAttrs, array('data-rowindex'=>$config_map_list->RowCnt, 'id'=>'r' . $config_map_list->RowCnt . '_config_map', 'data-rowtype'=>$config_map->RowType));

		// Render row
		$config_map_list->RenderRow();

		// Render list options
		$config_map_list->RenderListOptions();
?>
	<tr<?php echo $config_map->RowAttributes() ?>>
<?php

// Render list options (body, left)
$config_map_list->ListOptions->Render("body", "left", $config_map_list->RowCnt);
?>
	<?php if ($config_map->Name->Visible) { // Name ?>
		<td data-name="Name"<?php echo $config_map->Name->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_Name" class="config_map_Name">
<span<?php echo $config_map->Name->ViewAttributes() ?>>
<?php echo $config_map->Name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->LV->Visible) { // LV ?>
		<td data-name="LV"<?php echo $config_map->LV->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_LV" class="config_map_LV">
<span<?php echo $config_map->LV->ViewAttributes() ?>>
<?php echo $config_map->LV->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->Introduce->Visible) { // Introduce ?>
		<td data-name="Introduce"<?php echo $config_map->Introduce->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_Introduce" class="config_map_Introduce">
<span<?php echo $config_map->Introduce->ViewAttributes() ?>>
<?php echo $config_map->Introduce->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->_Security->Visible) { // Security ?>
		<td data-name="_Security"<?php echo $config_map->_Security->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map__Security" class="config_map__Security">
<span<?php echo $config_map->_Security->ViewAttributes() ?>>
<?php echo $config_map->_Security->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->Hid->Visible) { // Hid ?>
		<td data-name="Hid"<?php echo $config_map->Hid->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_Hid" class="config_map_Hid">
<span<?php echo $config_map->Hid->ViewAttributes() ?>>
<?php echo $config_map->Hid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->Basis->Visible) { // Basis ?>
		<td data-name="Basis"<?php echo $config_map->Basis->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_Basis" class="config_map_Basis">
<span<?php echo $config_map->Basis->ViewAttributes() ?>>
<?php echo $config_map->Basis->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->Monster->Visible) { // Monster ?>
		<td data-name="Monster"<?php echo $config_map->Monster->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_Monster" class="config_map_Monster">
<span<?php echo $config_map->Monster->ViewAttributes() ?>>
<?php echo $config_map->Monster->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->UP->Visible) { // UP ?>
		<td data-name="UP"<?php echo $config_map->UP->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_UP" class="config_map_UP">
<span<?php echo $config_map->UP->ViewAttributes() ?>>
<?php echo $config_map->UP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->Down->Visible) { // Down ?>
		<td data-name="Down"<?php echo $config_map->Down->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_Down" class="config_map_Down">
<span<?php echo $config_map->Down->ViewAttributes() ?>>
<?php echo $config_map->Down->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->Left->Visible) { // Left ?>
		<td data-name="Left"<?php echo $config_map->Left->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_Left" class="config_map_Left">
<span<?php echo $config_map->Left->ViewAttributes() ?>>
<?php echo $config_map->Left->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->Right->Visible) { // Right ?>
		<td data-name="Right"<?php echo $config_map->Right->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_Right" class="config_map_Right">
<span<?php echo $config_map->Right->ViewAttributes() ?>>
<?php echo $config_map->Right->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->Consume->Visible) { // Consume ?>
		<td data-name="Consume"<?php echo $config_map->Consume->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_Consume" class="config_map_Consume">
<span<?php echo $config_map->Consume->ViewAttributes() ?>>
<?php echo $config_map->Consume->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_map->LV_UP->Visible) { // LV_UP ?>
		<td data-name="LV_UP"<?php echo $config_map->LV_UP->CellAttributes() ?>>
<span id="el<?php echo $config_map_list->RowCnt ?>_config_map_LV_UP" class="config_map_LV_UP">
<span<?php echo $config_map->LV_UP->ViewAttributes() ?>>
<?php echo $config_map->LV_UP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$config_map_list->ListOptions->Render("body", "right", $config_map_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($config_map->CurrentAction <> "gridadd")
		$config_map_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($config_map->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($config_map_list->Recordset)
	$config_map_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($config_map->CurrentAction <> "gridadd" && $config_map->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($config_map_list->Pager)) $config_map_list->Pager = new cPrevNextPager($config_map_list->StartRec, $config_map_list->DisplayRecs, $config_map_list->TotalRecs, $config_map_list->AutoHidePager) ?>
<?php if ($config_map_list->Pager->RecordCount > 0 && $config_map_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($config_map_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $config_map_list->PageUrl() ?>start=<?php echo $config_map_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($config_map_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $config_map_list->PageUrl() ?>start=<?php echo $config_map_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $config_map_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($config_map_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $config_map_list->PageUrl() ?>start=<?php echo $config_map_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($config_map_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $config_map_list->PageUrl() ?>start=<?php echo $config_map_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $config_map_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($config_map_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $config_map_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $config_map_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $config_map_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($config_map_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($config_map_list->TotalRecs == 0 && $config_map->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($config_map_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fconfig_maplistsrch.FilterList = <?php echo $config_map_list->GetFilterList() ?>;
fconfig_maplistsrch.Init();
fconfig_maplist.Init();
</script>
<?php
$config_map_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_map_list->Page_Terminate();
?>
