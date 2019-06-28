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

$config_monster_list = NULL; // Initialize page object first

class cconfig_monster_list extends cconfig_monster {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_monster';

	// Page object name
	var $PageObjName = 'config_monster_list';

	// Grid form hidden field names
	var $FormName = 'fconfig_monsterlist';
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

		// Table object (config_monster)
		if (!isset($GLOBALS["config_monster"]) || get_class($GLOBALS["config_monster"]) == "cconfig_monster") {
			$GLOBALS["config_monster"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["config_monster"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "config_monsteradd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "config_monsterdelete.php";
		$this->MultiUpdateUrl = "config_monsterupdate.php";

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fconfig_monsterlistsrch";

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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fconfig_monsterlistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->unid->AdvancedSearch->ToJson(), ","); // Field unid
		$sFilterList = ew_Concat($sFilterList, $this->u_id->AdvancedSearch->ToJson(), ","); // Field u_id
		$sFilterList = ew_Concat($sFilterList, $this->acl_id->AdvancedSearch->ToJson(), ","); // Field acl_id
		$sFilterList = ew_Concat($sFilterList, $this->Monster_Name->AdvancedSearch->ToJson(), ","); // Field Monster_Name
		$sFilterList = ew_Concat($sFilterList, $this->Monster_Type->AdvancedSearch->ToJson(), ","); // Field Monster_Type
		$sFilterList = ew_Concat($sFilterList, $this->Monster_AD->AdvancedSearch->ToJson(), ","); // Field Monster_AD
		$sFilterList = ew_Concat($sFilterList, $this->Monster_AP->AdvancedSearch->ToJson(), ","); // Field Monster_AP
		$sFilterList = ew_Concat($sFilterList, $this->Monster_HP->AdvancedSearch->ToJson(), ","); // Field Monster_HP
		$sFilterList = ew_Concat($sFilterList, $this->Monster_Defense->AdvancedSearch->ToJson(), ","); // Field Monster_Defense
		$sFilterList = ew_Concat($sFilterList, $this->Monster_AbsorbHP->AdvancedSearch->ToJson(), ","); // Field Monster_AbsorbHP
		$sFilterList = ew_Concat($sFilterList, $this->Monster_ADPTV->AdvancedSearch->ToJson(), ","); // Field Monster_ADPTV
		$sFilterList = ew_Concat($sFilterList, $this->Monster_ADPTR->AdvancedSearch->ToJson(), ","); // Field Monster_ADPTR
		$sFilterList = ew_Concat($sFilterList, $this->Monster_APPTR->AdvancedSearch->ToJson(), ","); // Field Monster_APPTR
		$sFilterList = ew_Concat($sFilterList, $this->Monster_APPTV->AdvancedSearch->ToJson(), ","); // Field Monster_APPTV
		$sFilterList = ew_Concat($sFilterList, $this->Monster_ImmuneDamage->AdvancedSearch->ToJson(), ","); // Field Monster_ImmuneDamage
		$sFilterList = ew_Concat($sFilterList, $this->Skills->AdvancedSearch->ToJson(), ","); // Field Skills
		$sFilterList = ew_Concat($sFilterList, $this->Reward_Goods->AdvancedSearch->ToJson(), ","); // Field Reward_Goods
		$sFilterList = ew_Concat($sFilterList, $this->Reward_Exp->AdvancedSearch->ToJson(), ","); // Field Reward_Exp
		$sFilterList = ew_Concat($sFilterList, $this->Reward_Gold->AdvancedSearch->ToJson(), ","); // Field Reward_Gold
		$sFilterList = ew_Concat($sFilterList, $this->Introduce->AdvancedSearch->ToJson(), ","); // Field Introduce
		$sFilterList = ew_Concat($sFilterList, $this->AttackEffect->AdvancedSearch->ToJson(), ","); // Field AttackEffect
		$sFilterList = ew_Concat($sFilterList, $this->AttackTips->AdvancedSearch->ToJson(), ","); // Field AttackTips
		$sFilterList = ew_Concat($sFilterList, $this->MagicResistance->AdvancedSearch->ToJson(), ","); // Field MagicResistance
		$sFilterList = ew_Concat($sFilterList, $this->Hit->AdvancedSearch->ToJson(), ","); // Field Hit
		$sFilterList = ew_Concat($sFilterList, $this->Dodge->AdvancedSearch->ToJson(), ","); // Field Dodge
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fconfig_monsterlistsrch", $filters);

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

		// Field Monster_Name
		$this->Monster_Name->AdvancedSearch->SearchValue = @$filter["x_Monster_Name"];
		$this->Monster_Name->AdvancedSearch->SearchOperator = @$filter["z_Monster_Name"];
		$this->Monster_Name->AdvancedSearch->SearchCondition = @$filter["v_Monster_Name"];
		$this->Monster_Name->AdvancedSearch->SearchValue2 = @$filter["y_Monster_Name"];
		$this->Monster_Name->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_Name"];
		$this->Monster_Name->AdvancedSearch->Save();

		// Field Monster_Type
		$this->Monster_Type->AdvancedSearch->SearchValue = @$filter["x_Monster_Type"];
		$this->Monster_Type->AdvancedSearch->SearchOperator = @$filter["z_Monster_Type"];
		$this->Monster_Type->AdvancedSearch->SearchCondition = @$filter["v_Monster_Type"];
		$this->Monster_Type->AdvancedSearch->SearchValue2 = @$filter["y_Monster_Type"];
		$this->Monster_Type->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_Type"];
		$this->Monster_Type->AdvancedSearch->Save();

		// Field Monster_AD
		$this->Monster_AD->AdvancedSearch->SearchValue = @$filter["x_Monster_AD"];
		$this->Monster_AD->AdvancedSearch->SearchOperator = @$filter["z_Monster_AD"];
		$this->Monster_AD->AdvancedSearch->SearchCondition = @$filter["v_Monster_AD"];
		$this->Monster_AD->AdvancedSearch->SearchValue2 = @$filter["y_Monster_AD"];
		$this->Monster_AD->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_AD"];
		$this->Monster_AD->AdvancedSearch->Save();

		// Field Monster_AP
		$this->Monster_AP->AdvancedSearch->SearchValue = @$filter["x_Monster_AP"];
		$this->Monster_AP->AdvancedSearch->SearchOperator = @$filter["z_Monster_AP"];
		$this->Monster_AP->AdvancedSearch->SearchCondition = @$filter["v_Monster_AP"];
		$this->Monster_AP->AdvancedSearch->SearchValue2 = @$filter["y_Monster_AP"];
		$this->Monster_AP->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_AP"];
		$this->Monster_AP->AdvancedSearch->Save();

		// Field Monster_HP
		$this->Monster_HP->AdvancedSearch->SearchValue = @$filter["x_Monster_HP"];
		$this->Monster_HP->AdvancedSearch->SearchOperator = @$filter["z_Monster_HP"];
		$this->Monster_HP->AdvancedSearch->SearchCondition = @$filter["v_Monster_HP"];
		$this->Monster_HP->AdvancedSearch->SearchValue2 = @$filter["y_Monster_HP"];
		$this->Monster_HP->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_HP"];
		$this->Monster_HP->AdvancedSearch->Save();

		// Field Monster_Defense
		$this->Monster_Defense->AdvancedSearch->SearchValue = @$filter["x_Monster_Defense"];
		$this->Monster_Defense->AdvancedSearch->SearchOperator = @$filter["z_Monster_Defense"];
		$this->Monster_Defense->AdvancedSearch->SearchCondition = @$filter["v_Monster_Defense"];
		$this->Monster_Defense->AdvancedSearch->SearchValue2 = @$filter["y_Monster_Defense"];
		$this->Monster_Defense->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_Defense"];
		$this->Monster_Defense->AdvancedSearch->Save();

		// Field Monster_AbsorbHP
		$this->Monster_AbsorbHP->AdvancedSearch->SearchValue = @$filter["x_Monster_AbsorbHP"];
		$this->Monster_AbsorbHP->AdvancedSearch->SearchOperator = @$filter["z_Monster_AbsorbHP"];
		$this->Monster_AbsorbHP->AdvancedSearch->SearchCondition = @$filter["v_Monster_AbsorbHP"];
		$this->Monster_AbsorbHP->AdvancedSearch->SearchValue2 = @$filter["y_Monster_AbsorbHP"];
		$this->Monster_AbsorbHP->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_AbsorbHP"];
		$this->Monster_AbsorbHP->AdvancedSearch->Save();

		// Field Monster_ADPTV
		$this->Monster_ADPTV->AdvancedSearch->SearchValue = @$filter["x_Monster_ADPTV"];
		$this->Monster_ADPTV->AdvancedSearch->SearchOperator = @$filter["z_Monster_ADPTV"];
		$this->Monster_ADPTV->AdvancedSearch->SearchCondition = @$filter["v_Monster_ADPTV"];
		$this->Monster_ADPTV->AdvancedSearch->SearchValue2 = @$filter["y_Monster_ADPTV"];
		$this->Monster_ADPTV->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_ADPTV"];
		$this->Monster_ADPTV->AdvancedSearch->Save();

		// Field Monster_ADPTR
		$this->Monster_ADPTR->AdvancedSearch->SearchValue = @$filter["x_Monster_ADPTR"];
		$this->Monster_ADPTR->AdvancedSearch->SearchOperator = @$filter["z_Monster_ADPTR"];
		$this->Monster_ADPTR->AdvancedSearch->SearchCondition = @$filter["v_Monster_ADPTR"];
		$this->Monster_ADPTR->AdvancedSearch->SearchValue2 = @$filter["y_Monster_ADPTR"];
		$this->Monster_ADPTR->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_ADPTR"];
		$this->Monster_ADPTR->AdvancedSearch->Save();

		// Field Monster_APPTR
		$this->Monster_APPTR->AdvancedSearch->SearchValue = @$filter["x_Monster_APPTR"];
		$this->Monster_APPTR->AdvancedSearch->SearchOperator = @$filter["z_Monster_APPTR"];
		$this->Monster_APPTR->AdvancedSearch->SearchCondition = @$filter["v_Monster_APPTR"];
		$this->Monster_APPTR->AdvancedSearch->SearchValue2 = @$filter["y_Monster_APPTR"];
		$this->Monster_APPTR->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_APPTR"];
		$this->Monster_APPTR->AdvancedSearch->Save();

		// Field Monster_APPTV
		$this->Monster_APPTV->AdvancedSearch->SearchValue = @$filter["x_Monster_APPTV"];
		$this->Monster_APPTV->AdvancedSearch->SearchOperator = @$filter["z_Monster_APPTV"];
		$this->Monster_APPTV->AdvancedSearch->SearchCondition = @$filter["v_Monster_APPTV"];
		$this->Monster_APPTV->AdvancedSearch->SearchValue2 = @$filter["y_Monster_APPTV"];
		$this->Monster_APPTV->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_APPTV"];
		$this->Monster_APPTV->AdvancedSearch->Save();

		// Field Monster_ImmuneDamage
		$this->Monster_ImmuneDamage->AdvancedSearch->SearchValue = @$filter["x_Monster_ImmuneDamage"];
		$this->Monster_ImmuneDamage->AdvancedSearch->SearchOperator = @$filter["z_Monster_ImmuneDamage"];
		$this->Monster_ImmuneDamage->AdvancedSearch->SearchCondition = @$filter["v_Monster_ImmuneDamage"];
		$this->Monster_ImmuneDamage->AdvancedSearch->SearchValue2 = @$filter["y_Monster_ImmuneDamage"];
		$this->Monster_ImmuneDamage->AdvancedSearch->SearchOperator2 = @$filter["w_Monster_ImmuneDamage"];
		$this->Monster_ImmuneDamage->AdvancedSearch->Save();

		// Field Skills
		$this->Skills->AdvancedSearch->SearchValue = @$filter["x_Skills"];
		$this->Skills->AdvancedSearch->SearchOperator = @$filter["z_Skills"];
		$this->Skills->AdvancedSearch->SearchCondition = @$filter["v_Skills"];
		$this->Skills->AdvancedSearch->SearchValue2 = @$filter["y_Skills"];
		$this->Skills->AdvancedSearch->SearchOperator2 = @$filter["w_Skills"];
		$this->Skills->AdvancedSearch->Save();

		// Field Reward_Goods
		$this->Reward_Goods->AdvancedSearch->SearchValue = @$filter["x_Reward_Goods"];
		$this->Reward_Goods->AdvancedSearch->SearchOperator = @$filter["z_Reward_Goods"];
		$this->Reward_Goods->AdvancedSearch->SearchCondition = @$filter["v_Reward_Goods"];
		$this->Reward_Goods->AdvancedSearch->SearchValue2 = @$filter["y_Reward_Goods"];
		$this->Reward_Goods->AdvancedSearch->SearchOperator2 = @$filter["w_Reward_Goods"];
		$this->Reward_Goods->AdvancedSearch->Save();

		// Field Reward_Exp
		$this->Reward_Exp->AdvancedSearch->SearchValue = @$filter["x_Reward_Exp"];
		$this->Reward_Exp->AdvancedSearch->SearchOperator = @$filter["z_Reward_Exp"];
		$this->Reward_Exp->AdvancedSearch->SearchCondition = @$filter["v_Reward_Exp"];
		$this->Reward_Exp->AdvancedSearch->SearchValue2 = @$filter["y_Reward_Exp"];
		$this->Reward_Exp->AdvancedSearch->SearchOperator2 = @$filter["w_Reward_Exp"];
		$this->Reward_Exp->AdvancedSearch->Save();

		// Field Reward_Gold
		$this->Reward_Gold->AdvancedSearch->SearchValue = @$filter["x_Reward_Gold"];
		$this->Reward_Gold->AdvancedSearch->SearchOperator = @$filter["z_Reward_Gold"];
		$this->Reward_Gold->AdvancedSearch->SearchCondition = @$filter["v_Reward_Gold"];
		$this->Reward_Gold->AdvancedSearch->SearchValue2 = @$filter["y_Reward_Gold"];
		$this->Reward_Gold->AdvancedSearch->SearchOperator2 = @$filter["w_Reward_Gold"];
		$this->Reward_Gold->AdvancedSearch->Save();

		// Field Introduce
		$this->Introduce->AdvancedSearch->SearchValue = @$filter["x_Introduce"];
		$this->Introduce->AdvancedSearch->SearchOperator = @$filter["z_Introduce"];
		$this->Introduce->AdvancedSearch->SearchCondition = @$filter["v_Introduce"];
		$this->Introduce->AdvancedSearch->SearchValue2 = @$filter["y_Introduce"];
		$this->Introduce->AdvancedSearch->SearchOperator2 = @$filter["w_Introduce"];
		$this->Introduce->AdvancedSearch->Save();

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
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_Name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_Type, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_AD, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_AP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_HP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_Defense, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_AbsorbHP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_ADPTV, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_ADPTR, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_APPTR, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_APPTV, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Monster_ImmuneDamage, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Skills, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Reward_Goods, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Reward_Exp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Reward_Gold, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Introduce, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->AttackEffect, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->AttackTips, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->MagicResistance, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Hit, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Dodge, $arKeywords, $type);
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
			$this->UpdateSort($this->Monster_Name); // Monster_Name
			$this->UpdateSort($this->Monster_Type); // Monster_Type
			$this->UpdateSort($this->Monster_AD); // Monster_AD
			$this->UpdateSort($this->Monster_AP); // Monster_AP
			$this->UpdateSort($this->Monster_HP); // Monster_HP
			$this->UpdateSort($this->Monster_Defense); // Monster_Defense
			$this->UpdateSort($this->Monster_AbsorbHP); // Monster_AbsorbHP
			$this->UpdateSort($this->Monster_ADPTV); // Monster_ADPTV
			$this->UpdateSort($this->Monster_ADPTR); // Monster_ADPTR
			$this->UpdateSort($this->Monster_APPTR); // Monster_APPTR
			$this->UpdateSort($this->Monster_APPTV); // Monster_APPTV
			$this->UpdateSort($this->Monster_ImmuneDamage); // Monster_ImmuneDamage
			$this->UpdateSort($this->Skills); // Skills
			$this->UpdateSort($this->Reward_Goods); // Reward_Goods
			$this->UpdateSort($this->Reward_Exp); // Reward_Exp
			$this->UpdateSort($this->Reward_Gold); // Reward_Gold
			$this->UpdateSort($this->Introduce); // Introduce
			$this->UpdateSort($this->AttackEffect); // AttackEffect
			$this->UpdateSort($this->AttackTips); // AttackTips
			$this->UpdateSort($this->MagicResistance); // MagicResistance
			$this->UpdateSort($this->Hit); // Hit
			$this->UpdateSort($this->Dodge); // Dodge
			$this->UpdateSort($this->IgnoreShield); // IgnoreShield
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
				$this->Monster_Name->setSort("");
				$this->Monster_Type->setSort("");
				$this->Monster_AD->setSort("");
				$this->Monster_AP->setSort("");
				$this->Monster_HP->setSort("");
				$this->Monster_Defense->setSort("");
				$this->Monster_AbsorbHP->setSort("");
				$this->Monster_ADPTV->setSort("");
				$this->Monster_ADPTR->setSort("");
				$this->Monster_APPTR->setSort("");
				$this->Monster_APPTV->setSort("");
				$this->Monster_ImmuneDamage->setSort("");
				$this->Skills->setSort("");
				$this->Reward_Goods->setSort("");
				$this->Reward_Exp->setSort("");
				$this->Reward_Gold->setSort("");
				$this->Introduce->setSort("");
				$this->AttackEffect->setSort("");
				$this->AttackTips->setSort("");
				$this->MagicResistance->setSort("");
				$this->Hit->setSort("");
				$this->Dodge->setSort("");
				$this->IgnoreShield->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fconfig_monsterlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fconfig_monsterlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fconfig_monsterlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fconfig_monsterlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
if (!isset($config_monster_list)) $config_monster_list = new cconfig_monster_list();

// Page init
$config_monster_list->Page_Init();

// Page main
$config_monster_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_monster_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fconfig_monsterlist = new ew_Form("fconfig_monsterlist", "list");
fconfig_monsterlist.FormKeyCountName = '<?php echo $config_monster_list->FormKeyCountName ?>';

// Form_CustomValidate event
fconfig_monsterlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_monsterlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fconfig_monsterlistsrch = new ew_Form("fconfig_monsterlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($config_monster_list->TotalRecs > 0 && $config_monster_list->ExportOptions->Visible()) { ?>
<?php $config_monster_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($config_monster_list->SearchOptions->Visible()) { ?>
<?php $config_monster_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($config_monster_list->FilterOptions->Visible()) { ?>
<?php $config_monster_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $config_monster_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($config_monster_list->TotalRecs <= 0)
			$config_monster_list->TotalRecs = $config_monster->ListRecordCount();
	} else {
		if (!$config_monster_list->Recordset && ($config_monster_list->Recordset = $config_monster_list->LoadRecordset()))
			$config_monster_list->TotalRecs = $config_monster_list->Recordset->RecordCount();
	}
	$config_monster_list->StartRec = 1;
	if ($config_monster_list->DisplayRecs <= 0 || ($config_monster->Export <> "" && $config_monster->ExportAll)) // Display all records
		$config_monster_list->DisplayRecs = $config_monster_list->TotalRecs;
	if (!($config_monster->Export <> "" && $config_monster->ExportAll))
		$config_monster_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$config_monster_list->Recordset = $config_monster_list->LoadRecordset($config_monster_list->StartRec-1, $config_monster_list->DisplayRecs);

	// Set no record found message
	if ($config_monster->CurrentAction == "" && $config_monster_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$config_monster_list->setWarningMessage(ew_DeniedMsg());
		if ($config_monster_list->SearchWhere == "0=101")
			$config_monster_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$config_monster_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$config_monster_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($config_monster->Export == "" && $config_monster->CurrentAction == "") { ?>
<form name="fconfig_monsterlistsrch" id="fconfig_monsterlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($config_monster_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fconfig_monsterlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="config_monster">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($config_monster_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($config_monster_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $config_monster_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($config_monster_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($config_monster_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($config_monster_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($config_monster_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $config_monster_list->ShowPageHeader(); ?>
<?php
$config_monster_list->ShowMessage();
?>
<?php if ($config_monster_list->TotalRecs > 0 || $config_monster->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($config_monster_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> config_monster">
<form name="fconfig_monsterlist" id="fconfig_monsterlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_monster_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_monster_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_monster">
<div id="gmp_config_monster" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($config_monster_list->TotalRecs > 0 || $config_monster->CurrentAction == "gridedit") { ?>
<table id="tbl_config_monsterlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$config_monster_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$config_monster_list->RenderListOptions();

// Render list options (header, left)
$config_monster_list->ListOptions->Render("header", "left");
?>
<?php if ($config_monster->Monster_Name->Visible) { // Monster_Name ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_Name) == "") { ?>
		<th data-name="Monster_Name" class="<?php echo $config_monster->Monster_Name->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_Name" class="config_monster_Monster_Name"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_Name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_Name" class="<?php echo $config_monster->Monster_Name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_Name) ?>',1);"><div id="elh_config_monster_Monster_Name" class="config_monster_Monster_Name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_Name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_Name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_Name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_Type->Visible) { // Monster_Type ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_Type) == "") { ?>
		<th data-name="Monster_Type" class="<?php echo $config_monster->Monster_Type->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_Type" class="config_monster_Monster_Type"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_Type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_Type" class="<?php echo $config_monster->Monster_Type->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_Type) ?>',1);"><div id="elh_config_monster_Monster_Type" class="config_monster_Monster_Type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_Type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_Type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_Type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_AD->Visible) { // Monster_AD ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_AD) == "") { ?>
		<th data-name="Monster_AD" class="<?php echo $config_monster->Monster_AD->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_AD" class="config_monster_Monster_AD"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_AD->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_AD" class="<?php echo $config_monster->Monster_AD->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_AD) ?>',1);"><div id="elh_config_monster_Monster_AD" class="config_monster_Monster_AD">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_AD->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_AD->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_AD->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_AP->Visible) { // Monster_AP ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_AP) == "") { ?>
		<th data-name="Monster_AP" class="<?php echo $config_monster->Monster_AP->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_AP" class="config_monster_Monster_AP"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_AP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_AP" class="<?php echo $config_monster->Monster_AP->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_AP) ?>',1);"><div id="elh_config_monster_Monster_AP" class="config_monster_Monster_AP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_AP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_AP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_AP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_HP->Visible) { // Monster_HP ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_HP) == "") { ?>
		<th data-name="Monster_HP" class="<?php echo $config_monster->Monster_HP->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_HP" class="config_monster_Monster_HP"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_HP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_HP" class="<?php echo $config_monster->Monster_HP->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_HP) ?>',1);"><div id="elh_config_monster_Monster_HP" class="config_monster_Monster_HP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_HP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_HP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_HP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_Defense->Visible) { // Monster_Defense ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_Defense) == "") { ?>
		<th data-name="Monster_Defense" class="<?php echo $config_monster->Monster_Defense->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_Defense" class="config_monster_Monster_Defense"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_Defense->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_Defense" class="<?php echo $config_monster->Monster_Defense->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_Defense) ?>',1);"><div id="elh_config_monster_Monster_Defense" class="config_monster_Monster_Defense">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_Defense->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_Defense->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_Defense->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_AbsorbHP->Visible) { // Monster_AbsorbHP ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_AbsorbHP) == "") { ?>
		<th data-name="Monster_AbsorbHP" class="<?php echo $config_monster->Monster_AbsorbHP->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_AbsorbHP" class="config_monster_Monster_AbsorbHP"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_AbsorbHP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_AbsorbHP" class="<?php echo $config_monster->Monster_AbsorbHP->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_AbsorbHP) ?>',1);"><div id="elh_config_monster_Monster_AbsorbHP" class="config_monster_Monster_AbsorbHP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_AbsorbHP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_AbsorbHP->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_AbsorbHP->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_ADPTV->Visible) { // Monster_ADPTV ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_ADPTV) == "") { ?>
		<th data-name="Monster_ADPTV" class="<?php echo $config_monster->Monster_ADPTV->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_ADPTV" class="config_monster_Monster_ADPTV"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_ADPTV->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_ADPTV" class="<?php echo $config_monster->Monster_ADPTV->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_ADPTV) ?>',1);"><div id="elh_config_monster_Monster_ADPTV" class="config_monster_Monster_ADPTV">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_ADPTV->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_ADPTV->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_ADPTV->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_ADPTR->Visible) { // Monster_ADPTR ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_ADPTR) == "") { ?>
		<th data-name="Monster_ADPTR" class="<?php echo $config_monster->Monster_ADPTR->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_ADPTR" class="config_monster_Monster_ADPTR"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_ADPTR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_ADPTR" class="<?php echo $config_monster->Monster_ADPTR->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_ADPTR) ?>',1);"><div id="elh_config_monster_Monster_ADPTR" class="config_monster_Monster_ADPTR">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_ADPTR->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_ADPTR->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_ADPTR->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_APPTR->Visible) { // Monster_APPTR ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_APPTR) == "") { ?>
		<th data-name="Monster_APPTR" class="<?php echo $config_monster->Monster_APPTR->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_APPTR" class="config_monster_Monster_APPTR"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_APPTR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_APPTR" class="<?php echo $config_monster->Monster_APPTR->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_APPTR) ?>',1);"><div id="elh_config_monster_Monster_APPTR" class="config_monster_Monster_APPTR">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_APPTR->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_APPTR->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_APPTR->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_APPTV->Visible) { // Monster_APPTV ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_APPTV) == "") { ?>
		<th data-name="Monster_APPTV" class="<?php echo $config_monster->Monster_APPTV->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_APPTV" class="config_monster_Monster_APPTV"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_APPTV->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_APPTV" class="<?php echo $config_monster->Monster_APPTV->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_APPTV) ?>',1);"><div id="elh_config_monster_Monster_APPTV" class="config_monster_Monster_APPTV">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_APPTV->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_APPTV->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_APPTV->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Monster_ImmuneDamage->Visible) { // Monster_ImmuneDamage ?>
	<?php if ($config_monster->SortUrl($config_monster->Monster_ImmuneDamage) == "") { ?>
		<th data-name="Monster_ImmuneDamage" class="<?php echo $config_monster->Monster_ImmuneDamage->HeaderCellClass() ?>"><div id="elh_config_monster_Monster_ImmuneDamage" class="config_monster_Monster_ImmuneDamage"><div class="ewTableHeaderCaption"><?php echo $config_monster->Monster_ImmuneDamage->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Monster_ImmuneDamage" class="<?php echo $config_monster->Monster_ImmuneDamage->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Monster_ImmuneDamage) ?>',1);"><div id="elh_config_monster_Monster_ImmuneDamage" class="config_monster_Monster_ImmuneDamage">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Monster_ImmuneDamage->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Monster_ImmuneDamage->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Monster_ImmuneDamage->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Skills->Visible) { // Skills ?>
	<?php if ($config_monster->SortUrl($config_monster->Skills) == "") { ?>
		<th data-name="Skills" class="<?php echo $config_monster->Skills->HeaderCellClass() ?>"><div id="elh_config_monster_Skills" class="config_monster_Skills"><div class="ewTableHeaderCaption"><?php echo $config_monster->Skills->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Skills" class="<?php echo $config_monster->Skills->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Skills) ?>',1);"><div id="elh_config_monster_Skills" class="config_monster_Skills">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Skills->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Skills->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Skills->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Reward_Goods->Visible) { // Reward_Goods ?>
	<?php if ($config_monster->SortUrl($config_monster->Reward_Goods) == "") { ?>
		<th data-name="Reward_Goods" class="<?php echo $config_monster->Reward_Goods->HeaderCellClass() ?>"><div id="elh_config_monster_Reward_Goods" class="config_monster_Reward_Goods"><div class="ewTableHeaderCaption"><?php echo $config_monster->Reward_Goods->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Reward_Goods" class="<?php echo $config_monster->Reward_Goods->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Reward_Goods) ?>',1);"><div id="elh_config_monster_Reward_Goods" class="config_monster_Reward_Goods">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Reward_Goods->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Reward_Goods->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Reward_Goods->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Reward_Exp->Visible) { // Reward_Exp ?>
	<?php if ($config_monster->SortUrl($config_monster->Reward_Exp) == "") { ?>
		<th data-name="Reward_Exp" class="<?php echo $config_monster->Reward_Exp->HeaderCellClass() ?>"><div id="elh_config_monster_Reward_Exp" class="config_monster_Reward_Exp"><div class="ewTableHeaderCaption"><?php echo $config_monster->Reward_Exp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Reward_Exp" class="<?php echo $config_monster->Reward_Exp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Reward_Exp) ?>',1);"><div id="elh_config_monster_Reward_Exp" class="config_monster_Reward_Exp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Reward_Exp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Reward_Exp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Reward_Exp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Reward_Gold->Visible) { // Reward_Gold ?>
	<?php if ($config_monster->SortUrl($config_monster->Reward_Gold) == "") { ?>
		<th data-name="Reward_Gold" class="<?php echo $config_monster->Reward_Gold->HeaderCellClass() ?>"><div id="elh_config_monster_Reward_Gold" class="config_monster_Reward_Gold"><div class="ewTableHeaderCaption"><?php echo $config_monster->Reward_Gold->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Reward_Gold" class="<?php echo $config_monster->Reward_Gold->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Reward_Gold) ?>',1);"><div id="elh_config_monster_Reward_Gold" class="config_monster_Reward_Gold">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Reward_Gold->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Reward_Gold->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Reward_Gold->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Introduce->Visible) { // Introduce ?>
	<?php if ($config_monster->SortUrl($config_monster->Introduce) == "") { ?>
		<th data-name="Introduce" class="<?php echo $config_monster->Introduce->HeaderCellClass() ?>"><div id="elh_config_monster_Introduce" class="config_monster_Introduce"><div class="ewTableHeaderCaption"><?php echo $config_monster->Introduce->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Introduce" class="<?php echo $config_monster->Introduce->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Introduce) ?>',1);"><div id="elh_config_monster_Introduce" class="config_monster_Introduce">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Introduce->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Introduce->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Introduce->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->AttackEffect->Visible) { // AttackEffect ?>
	<?php if ($config_monster->SortUrl($config_monster->AttackEffect) == "") { ?>
		<th data-name="AttackEffect" class="<?php echo $config_monster->AttackEffect->HeaderCellClass() ?>"><div id="elh_config_monster_AttackEffect" class="config_monster_AttackEffect"><div class="ewTableHeaderCaption"><?php echo $config_monster->AttackEffect->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AttackEffect" class="<?php echo $config_monster->AttackEffect->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->AttackEffect) ?>',1);"><div id="elh_config_monster_AttackEffect" class="config_monster_AttackEffect">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->AttackEffect->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->AttackEffect->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->AttackEffect->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->AttackTips->Visible) { // AttackTips ?>
	<?php if ($config_monster->SortUrl($config_monster->AttackTips) == "") { ?>
		<th data-name="AttackTips" class="<?php echo $config_monster->AttackTips->HeaderCellClass() ?>"><div id="elh_config_monster_AttackTips" class="config_monster_AttackTips"><div class="ewTableHeaderCaption"><?php echo $config_monster->AttackTips->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AttackTips" class="<?php echo $config_monster->AttackTips->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->AttackTips) ?>',1);"><div id="elh_config_monster_AttackTips" class="config_monster_AttackTips">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->AttackTips->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->AttackTips->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->AttackTips->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->MagicResistance->Visible) { // MagicResistance ?>
	<?php if ($config_monster->SortUrl($config_monster->MagicResistance) == "") { ?>
		<th data-name="MagicResistance" class="<?php echo $config_monster->MagicResistance->HeaderCellClass() ?>"><div id="elh_config_monster_MagicResistance" class="config_monster_MagicResistance"><div class="ewTableHeaderCaption"><?php echo $config_monster->MagicResistance->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="MagicResistance" class="<?php echo $config_monster->MagicResistance->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->MagicResistance) ?>',1);"><div id="elh_config_monster_MagicResistance" class="config_monster_MagicResistance">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->MagicResistance->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->MagicResistance->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->MagicResistance->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Hit->Visible) { // Hit ?>
	<?php if ($config_monster->SortUrl($config_monster->Hit) == "") { ?>
		<th data-name="Hit" class="<?php echo $config_monster->Hit->HeaderCellClass() ?>"><div id="elh_config_monster_Hit" class="config_monster_Hit"><div class="ewTableHeaderCaption"><?php echo $config_monster->Hit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Hit" class="<?php echo $config_monster->Hit->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Hit) ?>',1);"><div id="elh_config_monster_Hit" class="config_monster_Hit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Hit->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Hit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Hit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->Dodge->Visible) { // Dodge ?>
	<?php if ($config_monster->SortUrl($config_monster->Dodge) == "") { ?>
		<th data-name="Dodge" class="<?php echo $config_monster->Dodge->HeaderCellClass() ?>"><div id="elh_config_monster_Dodge" class="config_monster_Dodge"><div class="ewTableHeaderCaption"><?php echo $config_monster->Dodge->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dodge" class="<?php echo $config_monster->Dodge->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->Dodge) ?>',1);"><div id="elh_config_monster_Dodge" class="config_monster_Dodge">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->Dodge->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->Dodge->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->Dodge->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($config_monster->IgnoreShield->Visible) { // IgnoreShield ?>
	<?php if ($config_monster->SortUrl($config_monster->IgnoreShield) == "") { ?>
		<th data-name="IgnoreShield" class="<?php echo $config_monster->IgnoreShield->HeaderCellClass() ?>"><div id="elh_config_monster_IgnoreShield" class="config_monster_IgnoreShield"><div class="ewTableHeaderCaption"><?php echo $config_monster->IgnoreShield->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="IgnoreShield" class="<?php echo $config_monster->IgnoreShield->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $config_monster->SortUrl($config_monster->IgnoreShield) ?>',1);"><div id="elh_config_monster_IgnoreShield" class="config_monster_IgnoreShield">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $config_monster->IgnoreShield->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($config_monster->IgnoreShield->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($config_monster->IgnoreShield->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$config_monster_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($config_monster->ExportAll && $config_monster->Export <> "") {
	$config_monster_list->StopRec = $config_monster_list->TotalRecs;
} else {

	// Set the last record to display
	if ($config_monster_list->TotalRecs > $config_monster_list->StartRec + $config_monster_list->DisplayRecs - 1)
		$config_monster_list->StopRec = $config_monster_list->StartRec + $config_monster_list->DisplayRecs - 1;
	else
		$config_monster_list->StopRec = $config_monster_list->TotalRecs;
}
$config_monster_list->RecCnt = $config_monster_list->StartRec - 1;
if ($config_monster_list->Recordset && !$config_monster_list->Recordset->EOF) {
	$config_monster_list->Recordset->MoveFirst();
	$bSelectLimit = $config_monster_list->UseSelectLimit;
	if (!$bSelectLimit && $config_monster_list->StartRec > 1)
		$config_monster_list->Recordset->Move($config_monster_list->StartRec - 1);
} elseif (!$config_monster->AllowAddDeleteRow && $config_monster_list->StopRec == 0) {
	$config_monster_list->StopRec = $config_monster->GridAddRowCount;
}

// Initialize aggregate
$config_monster->RowType = EW_ROWTYPE_AGGREGATEINIT;
$config_monster->ResetAttrs();
$config_monster_list->RenderRow();
while ($config_monster_list->RecCnt < $config_monster_list->StopRec) {
	$config_monster_list->RecCnt++;
	if (intval($config_monster_list->RecCnt) >= intval($config_monster_list->StartRec)) {
		$config_monster_list->RowCnt++;

		// Set up key count
		$config_monster_list->KeyCount = $config_monster_list->RowIndex;

		// Init row class and style
		$config_monster->ResetAttrs();
		$config_monster->CssClass = "";
		if ($config_monster->CurrentAction == "gridadd") {
		} else {
			$config_monster_list->LoadRowValues($config_monster_list->Recordset); // Load row values
		}
		$config_monster->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$config_monster->RowAttrs = array_merge($config_monster->RowAttrs, array('data-rowindex'=>$config_monster_list->RowCnt, 'id'=>'r' . $config_monster_list->RowCnt . '_config_monster', 'data-rowtype'=>$config_monster->RowType));

		// Render row
		$config_monster_list->RenderRow();

		// Render list options
		$config_monster_list->RenderListOptions();
?>
	<tr<?php echo $config_monster->RowAttributes() ?>>
<?php

// Render list options (body, left)
$config_monster_list->ListOptions->Render("body", "left", $config_monster_list->RowCnt);
?>
	<?php if ($config_monster->Monster_Name->Visible) { // Monster_Name ?>
		<td data-name="Monster_Name"<?php echo $config_monster->Monster_Name->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_Name" class="config_monster_Monster_Name">
<span<?php echo $config_monster->Monster_Name->ViewAttributes() ?>>
<?php echo $config_monster->Monster_Name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_Type->Visible) { // Monster_Type ?>
		<td data-name="Monster_Type"<?php echo $config_monster->Monster_Type->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_Type" class="config_monster_Monster_Type">
<span<?php echo $config_monster->Monster_Type->ViewAttributes() ?>>
<?php echo $config_monster->Monster_Type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_AD->Visible) { // Monster_AD ?>
		<td data-name="Monster_AD"<?php echo $config_monster->Monster_AD->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_AD" class="config_monster_Monster_AD">
<span<?php echo $config_monster->Monster_AD->ViewAttributes() ?>>
<?php echo $config_monster->Monster_AD->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_AP->Visible) { // Monster_AP ?>
		<td data-name="Monster_AP"<?php echo $config_monster->Monster_AP->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_AP" class="config_monster_Monster_AP">
<span<?php echo $config_monster->Monster_AP->ViewAttributes() ?>>
<?php echo $config_monster->Monster_AP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_HP->Visible) { // Monster_HP ?>
		<td data-name="Monster_HP"<?php echo $config_monster->Monster_HP->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_HP" class="config_monster_Monster_HP">
<span<?php echo $config_monster->Monster_HP->ViewAttributes() ?>>
<?php echo $config_monster->Monster_HP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_Defense->Visible) { // Monster_Defense ?>
		<td data-name="Monster_Defense"<?php echo $config_monster->Monster_Defense->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_Defense" class="config_monster_Monster_Defense">
<span<?php echo $config_monster->Monster_Defense->ViewAttributes() ?>>
<?php echo $config_monster->Monster_Defense->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_AbsorbHP->Visible) { // Monster_AbsorbHP ?>
		<td data-name="Monster_AbsorbHP"<?php echo $config_monster->Monster_AbsorbHP->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_AbsorbHP" class="config_monster_Monster_AbsorbHP">
<span<?php echo $config_monster->Monster_AbsorbHP->ViewAttributes() ?>>
<?php echo $config_monster->Monster_AbsorbHP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_ADPTV->Visible) { // Monster_ADPTV ?>
		<td data-name="Monster_ADPTV"<?php echo $config_monster->Monster_ADPTV->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_ADPTV" class="config_monster_Monster_ADPTV">
<span<?php echo $config_monster->Monster_ADPTV->ViewAttributes() ?>>
<?php echo $config_monster->Monster_ADPTV->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_ADPTR->Visible) { // Monster_ADPTR ?>
		<td data-name="Monster_ADPTR"<?php echo $config_monster->Monster_ADPTR->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_ADPTR" class="config_monster_Monster_ADPTR">
<span<?php echo $config_monster->Monster_ADPTR->ViewAttributes() ?>>
<?php echo $config_monster->Monster_ADPTR->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_APPTR->Visible) { // Monster_APPTR ?>
		<td data-name="Monster_APPTR"<?php echo $config_monster->Monster_APPTR->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_APPTR" class="config_monster_Monster_APPTR">
<span<?php echo $config_monster->Monster_APPTR->ViewAttributes() ?>>
<?php echo $config_monster->Monster_APPTR->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_APPTV->Visible) { // Monster_APPTV ?>
		<td data-name="Monster_APPTV"<?php echo $config_monster->Monster_APPTV->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_APPTV" class="config_monster_Monster_APPTV">
<span<?php echo $config_monster->Monster_APPTV->ViewAttributes() ?>>
<?php echo $config_monster->Monster_APPTV->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Monster_ImmuneDamage->Visible) { // Monster_ImmuneDamage ?>
		<td data-name="Monster_ImmuneDamage"<?php echo $config_monster->Monster_ImmuneDamage->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Monster_ImmuneDamage" class="config_monster_Monster_ImmuneDamage">
<span<?php echo $config_monster->Monster_ImmuneDamage->ViewAttributes() ?>>
<?php echo $config_monster->Monster_ImmuneDamage->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Skills->Visible) { // Skills ?>
		<td data-name="Skills"<?php echo $config_monster->Skills->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Skills" class="config_monster_Skills">
<span<?php echo $config_monster->Skills->ViewAttributes() ?>>
<?php echo $config_monster->Skills->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Reward_Goods->Visible) { // Reward_Goods ?>
		<td data-name="Reward_Goods"<?php echo $config_monster->Reward_Goods->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Reward_Goods" class="config_monster_Reward_Goods">
<span<?php echo $config_monster->Reward_Goods->ViewAttributes() ?>>
<?php echo $config_monster->Reward_Goods->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Reward_Exp->Visible) { // Reward_Exp ?>
		<td data-name="Reward_Exp"<?php echo $config_monster->Reward_Exp->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Reward_Exp" class="config_monster_Reward_Exp">
<span<?php echo $config_monster->Reward_Exp->ViewAttributes() ?>>
<?php echo $config_monster->Reward_Exp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Reward_Gold->Visible) { // Reward_Gold ?>
		<td data-name="Reward_Gold"<?php echo $config_monster->Reward_Gold->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Reward_Gold" class="config_monster_Reward_Gold">
<span<?php echo $config_monster->Reward_Gold->ViewAttributes() ?>>
<?php echo $config_monster->Reward_Gold->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Introduce->Visible) { // Introduce ?>
		<td data-name="Introduce"<?php echo $config_monster->Introduce->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Introduce" class="config_monster_Introduce">
<span<?php echo $config_monster->Introduce->ViewAttributes() ?>>
<?php echo $config_monster->Introduce->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->AttackEffect->Visible) { // AttackEffect ?>
		<td data-name="AttackEffect"<?php echo $config_monster->AttackEffect->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_AttackEffect" class="config_monster_AttackEffect">
<span<?php echo $config_monster->AttackEffect->ViewAttributes() ?>>
<?php echo $config_monster->AttackEffect->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->AttackTips->Visible) { // AttackTips ?>
		<td data-name="AttackTips"<?php echo $config_monster->AttackTips->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_AttackTips" class="config_monster_AttackTips">
<span<?php echo $config_monster->AttackTips->ViewAttributes() ?>>
<?php echo $config_monster->AttackTips->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->MagicResistance->Visible) { // MagicResistance ?>
		<td data-name="MagicResistance"<?php echo $config_monster->MagicResistance->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_MagicResistance" class="config_monster_MagicResistance">
<span<?php echo $config_monster->MagicResistance->ViewAttributes() ?>>
<?php echo $config_monster->MagicResistance->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Hit->Visible) { // Hit ?>
		<td data-name="Hit"<?php echo $config_monster->Hit->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Hit" class="config_monster_Hit">
<span<?php echo $config_monster->Hit->ViewAttributes() ?>>
<?php echo $config_monster->Hit->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->Dodge->Visible) { // Dodge ?>
		<td data-name="Dodge"<?php echo $config_monster->Dodge->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_Dodge" class="config_monster_Dodge">
<span<?php echo $config_monster->Dodge->ViewAttributes() ?>>
<?php echo $config_monster->Dodge->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($config_monster->IgnoreShield->Visible) { // IgnoreShield ?>
		<td data-name="IgnoreShield"<?php echo $config_monster->IgnoreShield->CellAttributes() ?>>
<span id="el<?php echo $config_monster_list->RowCnt ?>_config_monster_IgnoreShield" class="config_monster_IgnoreShield">
<span<?php echo $config_monster->IgnoreShield->ViewAttributes() ?>>
<?php echo $config_monster->IgnoreShield->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$config_monster_list->ListOptions->Render("body", "right", $config_monster_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($config_monster->CurrentAction <> "gridadd")
		$config_monster_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($config_monster->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($config_monster_list->Recordset)
	$config_monster_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($config_monster->CurrentAction <> "gridadd" && $config_monster->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($config_monster_list->Pager)) $config_monster_list->Pager = new cPrevNextPager($config_monster_list->StartRec, $config_monster_list->DisplayRecs, $config_monster_list->TotalRecs, $config_monster_list->AutoHidePager) ?>
<?php if ($config_monster_list->Pager->RecordCount > 0 && $config_monster_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($config_monster_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $config_monster_list->PageUrl() ?>start=<?php echo $config_monster_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($config_monster_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $config_monster_list->PageUrl() ?>start=<?php echo $config_monster_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $config_monster_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($config_monster_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $config_monster_list->PageUrl() ?>start=<?php echo $config_monster_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($config_monster_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $config_monster_list->PageUrl() ?>start=<?php echo $config_monster_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $config_monster_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($config_monster_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $config_monster_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $config_monster_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $config_monster_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($config_monster_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($config_monster_list->TotalRecs == 0 && $config_monster->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($config_monster_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fconfig_monsterlistsrch.FilterList = <?php echo $config_monster_list->GetFilterList() ?>;
fconfig_monsterlistsrch.Init();
fconfig_monsterlist.Init();
</script>
<?php
$config_monster_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_monster_list->Page_Terminate();
?>
