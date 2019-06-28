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

$config_occupation_delete = NULL; // Initialize page object first

class cconfig_occupation_delete extends cconfig_occupation {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{5DAF7451-EE21-4ABF-A979-870614CA82FC}';

	// Table name
	var $TableName = 'config_occupation';

	// Page object name
	var $PageObjName = 'config_occupation_delete';

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

		// Table object (ksdb_user)
		if (!isset($GLOBALS['ksdb_user'])) $GLOBALS['ksdb_user'] = new cksdb_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
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
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("config_occupationlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in config_occupation class, config_occupationinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("config_occupationlist.php"); // Return to list
			}
		}
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['unid'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("config_occupationlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($config_occupation_delete)) $config_occupation_delete = new cconfig_occupation_delete();

// Page init
$config_occupation_delete->Page_Init();

// Page main
$config_occupation_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$config_occupation_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fconfig_occupationdelete = new ew_Form("fconfig_occupationdelete", "delete");

// Form_CustomValidate event
fconfig_occupationdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fconfig_occupationdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $config_occupation_delete->ShowPageHeader(); ?>
<?php
$config_occupation_delete->ShowMessage();
?>
<form name="fconfig_occupationdelete" id="fconfig_occupationdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($config_occupation_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $config_occupation_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="config_occupation">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($config_occupation_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($config_occupation->Name->Visible) { // Name ?>
		<th class="<?php echo $config_occupation->Name->HeaderCellClass() ?>"><span id="elh_config_occupation_Name" class="config_occupation_Name"><?php echo $config_occupation->Name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->Basics->Visible) { // Basics ?>
		<th class="<?php echo $config_occupation->Basics->HeaderCellClass() ?>"><span id="elh_config_occupation_Basics" class="config_occupation_Basics"><?php echo $config_occupation->Basics->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->HP->Visible) { // HP ?>
		<th class="<?php echo $config_occupation->HP->HeaderCellClass() ?>"><span id="elh_config_occupation_HP" class="config_occupation_HP"><?php echo $config_occupation->HP->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->MP->Visible) { // MP ?>
		<th class="<?php echo $config_occupation->MP->HeaderCellClass() ?>"><span id="elh_config_occupation_MP" class="config_occupation_MP"><?php echo $config_occupation->MP->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->AD->Visible) { // AD ?>
		<th class="<?php echo $config_occupation->AD->HeaderCellClass() ?>"><span id="elh_config_occupation_AD" class="config_occupation_AD"><?php echo $config_occupation->AD->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->AP->Visible) { // AP ?>
		<th class="<?php echo $config_occupation->AP->HeaderCellClass() ?>"><span id="elh_config_occupation_AP" class="config_occupation_AP"><?php echo $config_occupation->AP->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->Defense->Visible) { // Defense ?>
		<th class="<?php echo $config_occupation->Defense->HeaderCellClass() ?>"><span id="elh_config_occupation_Defense" class="config_occupation_Defense"><?php echo $config_occupation->Defense->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->Hit->Visible) { // Hit ?>
		<th class="<?php echo $config_occupation->Hit->HeaderCellClass() ?>"><span id="elh_config_occupation_Hit" class="config_occupation_Hit"><?php echo $config_occupation->Hit->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->Dodge->Visible) { // Dodge ?>
		<th class="<?php echo $config_occupation->Dodge->HeaderCellClass() ?>"><span id="elh_config_occupation_Dodge" class="config_occupation_Dodge"><?php echo $config_occupation->Dodge->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->Crit->Visible) { // Crit ?>
		<th class="<?php echo $config_occupation->Crit->HeaderCellClass() ?>"><span id="elh_config_occupation_Crit" class="config_occupation_Crit"><?php echo $config_occupation->Crit->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->AbsorbHP->Visible) { // AbsorbHP ?>
		<th class="<?php echo $config_occupation->AbsorbHP->HeaderCellClass() ?>"><span id="elh_config_occupation_AbsorbHP" class="config_occupation_AbsorbHP"><?php echo $config_occupation->AbsorbHP->FldCaption() ?></span></th>
<?php } ?>
<?php if ($config_occupation->DATETIME->Visible) { // DATETIME ?>
		<th class="<?php echo $config_occupation->DATETIME->HeaderCellClass() ?>"><span id="elh_config_occupation_DATETIME" class="config_occupation_DATETIME"><?php echo $config_occupation->DATETIME->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$config_occupation_delete->RecCnt = 0;
$i = 0;
while (!$config_occupation_delete->Recordset->EOF) {
	$config_occupation_delete->RecCnt++;
	$config_occupation_delete->RowCnt++;

	// Set row properties
	$config_occupation->ResetAttrs();
	$config_occupation->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$config_occupation_delete->LoadRowValues($config_occupation_delete->Recordset);

	// Render row
	$config_occupation_delete->RenderRow();
?>
	<tr<?php echo $config_occupation->RowAttributes() ?>>
<?php if ($config_occupation->Name->Visible) { // Name ?>
		<td<?php echo $config_occupation->Name->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_Name" class="config_occupation_Name">
<span<?php echo $config_occupation->Name->ViewAttributes() ?>>
<?php echo $config_occupation->Name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->Basics->Visible) { // Basics ?>
		<td<?php echo $config_occupation->Basics->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_Basics" class="config_occupation_Basics">
<span<?php echo $config_occupation->Basics->ViewAttributes() ?>>
<?php echo $config_occupation->Basics->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->HP->Visible) { // HP ?>
		<td<?php echo $config_occupation->HP->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_HP" class="config_occupation_HP">
<span<?php echo $config_occupation->HP->ViewAttributes() ?>>
<?php echo $config_occupation->HP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->MP->Visible) { // MP ?>
		<td<?php echo $config_occupation->MP->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_MP" class="config_occupation_MP">
<span<?php echo $config_occupation->MP->ViewAttributes() ?>>
<?php echo $config_occupation->MP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->AD->Visible) { // AD ?>
		<td<?php echo $config_occupation->AD->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_AD" class="config_occupation_AD">
<span<?php echo $config_occupation->AD->ViewAttributes() ?>>
<?php echo $config_occupation->AD->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->AP->Visible) { // AP ?>
		<td<?php echo $config_occupation->AP->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_AP" class="config_occupation_AP">
<span<?php echo $config_occupation->AP->ViewAttributes() ?>>
<?php echo $config_occupation->AP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->Defense->Visible) { // Defense ?>
		<td<?php echo $config_occupation->Defense->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_Defense" class="config_occupation_Defense">
<span<?php echo $config_occupation->Defense->ViewAttributes() ?>>
<?php echo $config_occupation->Defense->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->Hit->Visible) { // Hit ?>
		<td<?php echo $config_occupation->Hit->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_Hit" class="config_occupation_Hit">
<span<?php echo $config_occupation->Hit->ViewAttributes() ?>>
<?php echo $config_occupation->Hit->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->Dodge->Visible) { // Dodge ?>
		<td<?php echo $config_occupation->Dodge->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_Dodge" class="config_occupation_Dodge">
<span<?php echo $config_occupation->Dodge->ViewAttributes() ?>>
<?php echo $config_occupation->Dodge->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->Crit->Visible) { // Crit ?>
		<td<?php echo $config_occupation->Crit->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_Crit" class="config_occupation_Crit">
<span<?php echo $config_occupation->Crit->ViewAttributes() ?>>
<?php echo $config_occupation->Crit->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->AbsorbHP->Visible) { // AbsorbHP ?>
		<td<?php echo $config_occupation->AbsorbHP->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_AbsorbHP" class="config_occupation_AbsorbHP">
<span<?php echo $config_occupation->AbsorbHP->ViewAttributes() ?>>
<?php echo $config_occupation->AbsorbHP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($config_occupation->DATETIME->Visible) { // DATETIME ?>
		<td<?php echo $config_occupation->DATETIME->CellAttributes() ?>>
<span id="el<?php echo $config_occupation_delete->RowCnt ?>_config_occupation_DATETIME" class="config_occupation_DATETIME">
<span<?php echo $config_occupation->DATETIME->ViewAttributes() ?>>
<?php echo $config_occupation->DATETIME->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$config_occupation_delete->Recordset->MoveNext();
}
$config_occupation_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $config_occupation_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fconfig_occupationdelete.Init();
</script>
<?php
$config_occupation_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$config_occupation_delete->Page_Terminate();
?>
