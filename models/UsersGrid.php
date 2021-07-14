<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class UsersGrid extends Users
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'users';

    // Page object name
    public $PageObjName = "UsersGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fusersgrid";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (users)
        if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == PROJECT_NAMESPACE . "users") {
            $GLOBALS["users"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        $this->AddUrl = "UsersAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'users');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("users"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id_users'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id_users->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->fecha->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $ShowOtherOptions = false;
    public $DisplayRecords = 10;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->id_users->setVisibility();
        $this->fecha->setVisibility();
        $this->nombres->setVisibility();
        $this->apellidos->setVisibility();
        $this->escenario->Visible = false;
        $this->grupo->setVisibility();
        $this->subgrupo->setVisibility();
        $this->perfil->setVisibility();
        $this->_email->setVisibility();
        $this->telefono->setVisibility();
        $this->pais->setVisibility();
        $this->pw->Visible = false;
        $this->estado->setVisibility();
        $this->horario->Visible = false;
        $this->limite->Visible = false;
        $this->img_user->setVisibility();
        $this->blocks->Visible = false;
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->escenario);
        $this->setupLookupOptions($this->grupo);
        $this->setupLookupOptions($this->subgrupo);
        $this->setupLookupOptions($this->perfil);
        $this->setupLookupOptions($this->pais);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Set up sorting order
            $this->setupSortOrder();
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 10; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }

        // Restore master/detail filter
        $this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "subgrupo") {
            $masterTbl = Container("subgrupo");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("SubgrupoList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "grupo") {
            $masterTbl = Container("grupo");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("GrupoList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "escenario") {
            $masterTbl = Container("escenario");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("EscenarioList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 10; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAll();
            $rs->closeCursor();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            return false;
        }
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
            // Get new records
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            return false;
        }

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->id_users->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode

            // Send notify email
            $table = 'users';
            $subject = $table . " " . $Language->phrase("RecordInserted");
            $action = $Language->phrase("ActionInsertedGridAdd");
            $email = new Email();
            $email->load(Config("EMAIL_NOTIFY_TEMPLATE"));
            $email->replaceSender(Config("SENDER_EMAIL")); // Replace Sender
            $email->replaceRecipient(Config("RECIPIENT_EMAIL")); // Replace Recipient
            $email->replaceSubject($subject); // Replace Subject
            $email->replaceContent("<!--table-->", $table);
            $email->replaceContent("<!--key-->", $key);
            $email->replaceContent("<!--action-->", $action);
            $args = [];
            $args["rsnew"] = &$rsnew;
            $emailSent = false;
            if ($this->emailSending($email, $args)) {
                $emailSent = $email->send();
            }
            if (!$emailSent) {
                $this->setFailureMessage($email->SendErrDescription);
            }
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_nombres") && $CurrentForm->hasValue("o_nombres") && $this->nombres->CurrentValue != $this->nombres->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_apellidos") && $CurrentForm->hasValue("o_apellidos") && $this->apellidos->CurrentValue != $this->apellidos->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_grupo") && $CurrentForm->hasValue("o_grupo") && $this->grupo->CurrentValue != $this->grupo->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_subgrupo") && $CurrentForm->hasValue("o_subgrupo") && $this->subgrupo->CurrentValue != $this->subgrupo->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_perfil") && $CurrentForm->hasValue("o_perfil") && $this->perfil->CurrentValue != $this->perfil->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x__email") && $CurrentForm->hasValue("o__email") && $this->_email->CurrentValue != $this->_email->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_telefono") && $CurrentForm->hasValue("o_telefono") && $this->telefono->CurrentValue != $this->telefono->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_pais") && $CurrentForm->hasValue("o_pais") && $this->pais->CurrentValue != $this->pais->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_estado") && $CurrentForm->hasValue("o_estado") && $this->estado->CurrentValue != $this->estado->OldValue) {
            return false;
        }
        if (!EmptyValue($this->img_user->Upload->Value)) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->id_users->clearErrorMessage();
        $this->fecha->clearErrorMessage();
        $this->nombres->clearErrorMessage();
        $this->apellidos->clearErrorMessage();
        $this->grupo->clearErrorMessage();
        $this->subgrupo->clearErrorMessage();
        $this->perfil->clearErrorMessage();
        $this->_email->clearErrorMessage();
        $this->telefono->clearErrorMessage();
        $this->pais->clearErrorMessage();
        $this->estado->clearErrorMessage();
        $this->img_user->clearErrorMessage();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->subgrupo->setSessionValue("");
                        $this->grupo->setSessionValue("");
                        $this->escenario->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = false;
            $item->Visible = false; // Default hidden
        }

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = true;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" . " onclick=\"return ew.confirmDelete(this);\"" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $option = $this->OtherOptions["addedit"];
        $option->UseDropDownButton = false;
        $option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $option->UseButtonGroup = true;
        //$option->ButtonClass = ""; // Class for button group
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
            if ($this->AllowAddDeleteRow) {
                $option = $options["addedit"];
                $option->UseDropDownButton = false;
                $item = &$option->add("addblankrow");
                $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                $item->Visible = $Security->canAdd();
                $this->ShowOtherOptions = $item->Visible;
            }
        }
        if ($this->CurrentMode == "view") { // Check view mode
            $option = $options["addedit"];
            $item = $option["add"];
            $this->ShowOtherOptions = $item && $item->Visible;
        }
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
        global $Security, $Language;
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->img_user->Upload->Index = $CurrentForm->Index;
        $this->img_user->Upload->uploadFile();
        $this->img_user->CurrentValue = $this->img_user->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id_users->CurrentValue = null;
        $this->id_users->OldValue = $this->id_users->CurrentValue;
        $this->fecha->CurrentValue = null;
        $this->fecha->OldValue = $this->fecha->CurrentValue;
        $this->nombres->CurrentValue = null;
        $this->nombres->OldValue = $this->nombres->CurrentValue;
        $this->apellidos->CurrentValue = null;
        $this->apellidos->OldValue = $this->apellidos->CurrentValue;
        $this->escenario->CurrentValue = null;
        $this->escenario->OldValue = $this->escenario->CurrentValue;
        $this->grupo->CurrentValue = null;
        $this->grupo->OldValue = $this->grupo->CurrentValue;
        $this->subgrupo->CurrentValue = null;
        $this->subgrupo->OldValue = $this->subgrupo->CurrentValue;
        $this->perfil->CurrentValue = null;
        $this->perfil->OldValue = $this->perfil->CurrentValue;
        $this->_email->CurrentValue = null;
        $this->_email->OldValue = $this->_email->CurrentValue;
        $this->telefono->CurrentValue = null;
        $this->telefono->OldValue = $this->telefono->CurrentValue;
        $this->pais->CurrentValue = null;
        $this->pais->OldValue = $this->pais->CurrentValue;
        $this->pw->CurrentValue = null;
        $this->pw->OldValue = $this->pw->CurrentValue;
        $this->estado->CurrentValue = null;
        $this->estado->OldValue = $this->estado->CurrentValue;
        $this->horario->CurrentValue = null;
        $this->horario->OldValue = $this->horario->CurrentValue;
        $this->limite->CurrentValue = null;
        $this->limite->OldValue = $this->limite->CurrentValue;
        $this->img_user->Upload->DbValue = null;
        $this->img_user->OldValue = $this->img_user->Upload->DbValue;
        $this->img_user->Upload->Index = $this->RowIndex;
        $this->blocks->CurrentValue = null;
        $this->blocks->OldValue = $this->blocks->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;

        // Check field name 'id_users' first before field var 'x_id_users'
        $val = $CurrentForm->hasValue("id_users") ? $CurrentForm->getValue("id_users") : $CurrentForm->getValue("x_id_users");
        if (!$this->id_users->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->id_users->setFormValue($val);
        }

        // Check field name 'fecha' first before field var 'x_fecha'
        $val = $CurrentForm->hasValue("fecha") ? $CurrentForm->getValue("fecha") : $CurrentForm->getValue("x_fecha");
        if (!$this->fecha->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha->Visible = false; // Disable update for API request
            } else {
                $this->fecha->setFormValue($val);
            }
            $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, 5);
        }
        if ($CurrentForm->hasValue("o_fecha")) {
            $this->fecha->setOldValue($CurrentForm->getValue("o_fecha"));
        }

        // Check field name 'nombres' first before field var 'x_nombres'
        $val = $CurrentForm->hasValue("nombres") ? $CurrentForm->getValue("nombres") : $CurrentForm->getValue("x_nombres");
        if (!$this->nombres->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombres->Visible = false; // Disable update for API request
            } else {
                $this->nombres->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_nombres")) {
            $this->nombres->setOldValue($CurrentForm->getValue("o_nombres"));
        }

        // Check field name 'apellidos' first before field var 'x_apellidos'
        $val = $CurrentForm->hasValue("apellidos") ? $CurrentForm->getValue("apellidos") : $CurrentForm->getValue("x_apellidos");
        if (!$this->apellidos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apellidos->Visible = false; // Disable update for API request
            } else {
                $this->apellidos->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_apellidos")) {
            $this->apellidos->setOldValue($CurrentForm->getValue("o_apellidos"));
        }

        // Check field name 'grupo' first before field var 'x_grupo'
        $val = $CurrentForm->hasValue("grupo") ? $CurrentForm->getValue("grupo") : $CurrentForm->getValue("x_grupo");
        if (!$this->grupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->grupo->Visible = false; // Disable update for API request
            } else {
                $this->grupo->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_grupo")) {
            $this->grupo->setOldValue($CurrentForm->getValue("o_grupo"));
        }

        // Check field name 'subgrupo' first before field var 'x_subgrupo'
        $val = $CurrentForm->hasValue("subgrupo") ? $CurrentForm->getValue("subgrupo") : $CurrentForm->getValue("x_subgrupo");
        if (!$this->subgrupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->subgrupo->Visible = false; // Disable update for API request
            } else {
                $this->subgrupo->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_subgrupo")) {
            $this->subgrupo->setOldValue($CurrentForm->getValue("o_subgrupo"));
        }

        // Check field name 'perfil' first before field var 'x_perfil'
        $val = $CurrentForm->hasValue("perfil") ? $CurrentForm->getValue("perfil") : $CurrentForm->getValue("x_perfil");
        if (!$this->perfil->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->perfil->Visible = false; // Disable update for API request
            } else {
                $this->perfil->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_perfil")) {
            $this->perfil->setOldValue($CurrentForm->getValue("o_perfil"));
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o__email")) {
            $this->_email->setOldValue($CurrentForm->getValue("o__email"));
        }

        // Check field name 'telefono' first before field var 'x_telefono'
        $val = $CurrentForm->hasValue("telefono") ? $CurrentForm->getValue("telefono") : $CurrentForm->getValue("x_telefono");
        if (!$this->telefono->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefono->Visible = false; // Disable update for API request
            } else {
                $this->telefono->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_telefono")) {
            $this->telefono->setOldValue($CurrentForm->getValue("o_telefono"));
        }

        // Check field name 'pais' first before field var 'x_pais'
        $val = $CurrentForm->hasValue("pais") ? $CurrentForm->getValue("pais") : $CurrentForm->getValue("x_pais");
        if (!$this->pais->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pais->Visible = false; // Disable update for API request
            } else {
                $this->pais->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_pais")) {
            $this->pais->setOldValue($CurrentForm->getValue("o_pais"));
        }

        // Check field name 'estado' first before field var 'x_estado'
        $val = $CurrentForm->hasValue("estado") ? $CurrentForm->getValue("estado") : $CurrentForm->getValue("x_estado");
        if (!$this->estado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estado->Visible = false; // Disable update for API request
            } else {
                $this->estado->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_estado")) {
            $this->estado->setOldValue($CurrentForm->getValue("o_estado"));
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id_users->CurrentValue = $this->id_users->FormValue;
        }
        $this->fecha->CurrentValue = $this->fecha->FormValue;
        $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, 5);
        $this->nombres->CurrentValue = $this->nombres->FormValue;
        $this->apellidos->CurrentValue = $this->apellidos->FormValue;
        $this->grupo->CurrentValue = $this->grupo->FormValue;
        $this->subgrupo->CurrentValue = $this->subgrupo->FormValue;
        $this->perfil->CurrentValue = $this->perfil->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->telefono->CurrentValue = $this->telefono->FormValue;
        $this->pais->CurrentValue = $this->pais->FormValue;
        $this->estado->CurrentValue = $this->estado->FormValue;
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->id_users->setDbValue($row['id_users']);
        $this->fecha->setDbValue($row['fecha']);
        $this->nombres->setDbValue($row['nombres']);
        $this->apellidos->setDbValue($row['apellidos']);
        $this->escenario->setDbValue($row['escenario']);
        $this->grupo->setDbValue($row['grupo']);
        $this->subgrupo->setDbValue($row['subgrupo']);
        $this->perfil->setDbValue($row['perfil']);
        $this->_email->setDbValue($row['email']);
        $this->telefono->setDbValue($row['telefono']);
        $this->pais->setDbValue($row['pais']);
        $this->pw->setDbValue($row['pw']);
        $this->estado->setDbValue($row['estado']);
        $this->horario->setDbValue($row['horario']);
        $this->limite->setDbValue($row['limite']);
        $this->img_user->Upload->DbValue = $row['img_user'];
        $this->img_user->setDbValue($this->img_user->Upload->DbValue);
        $this->img_user->Upload->Index = $this->RowIndex;
        $this->blocks->setDbValue($row['blocks']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id_users'] = $this->id_users->CurrentValue;
        $row['fecha'] = $this->fecha->CurrentValue;
        $row['nombres'] = $this->nombres->CurrentValue;
        $row['apellidos'] = $this->apellidos->CurrentValue;
        $row['escenario'] = $this->escenario->CurrentValue;
        $row['grupo'] = $this->grupo->CurrentValue;
        $row['subgrupo'] = $this->subgrupo->CurrentValue;
        $row['perfil'] = $this->perfil->CurrentValue;
        $row['email'] = $this->_email->CurrentValue;
        $row['telefono'] = $this->telefono->CurrentValue;
        $row['pais'] = $this->pais->CurrentValue;
        $row['pw'] = $this->pw->CurrentValue;
        $row['estado'] = $this->estado->CurrentValue;
        $row['horario'] = $this->horario->CurrentValue;
        $row['limite'] = $this->limite->CurrentValue;
        $row['img_user'] = $this->img_user->Upload->DbValue;
        $row['blocks'] = $this->blocks->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id_users

        // fecha

        // nombres

        // apellidos

        // escenario

        // grupo

        // subgrupo

        // perfil

        // email

        // telefono

        // pais

        // pw

        // estado

        // horario

        // limite

        // img_user

        // blocks
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_users
            $this->id_users->ViewValue = $this->id_users->CurrentValue;
            $this->id_users->ViewCustomAttributes = "";

            // fecha
            $this->fecha->ViewValue = $this->fecha->CurrentValue;
            $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, 5);
            $this->fecha->ViewCustomAttributes = "";

            // nombres
            $this->nombres->ViewValue = $this->nombres->CurrentValue;
            $this->nombres->ViewCustomAttributes = "";

            // apellidos
            $this->apellidos->ViewValue = $this->apellidos->CurrentValue;
            $this->apellidos->ViewCustomAttributes = "";

            // escenario
            $curVal = trim(strval($this->escenario->CurrentValue));
            if ($curVal != "") {
                $this->escenario->ViewValue = $this->escenario->lookupCacheOption($curVal);
                if ($this->escenario->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_escenario`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentUserInfo("perfil") != 1) ? "id_escenario = '".CurrentUserInfo("escenario")."'"  : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->escenario->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->escenario->Lookup->renderViewRow($rswrk[0]);
                        $this->escenario->ViewValue = $this->escenario->displayValue($arwrk);
                    } else {
                        $this->escenario->ViewValue = $this->escenario->CurrentValue;
                    }
                }
            } else {
                $this->escenario->ViewValue = null;
            }
            $this->escenario->ViewCustomAttributes = "";

            // grupo
            $curVal = trim(strval($this->grupo->CurrentValue));
            if ($curVal != "") {
                $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
                if ($this->grupo->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_grupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->grupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->grupo->Lookup->renderViewRow($rswrk[0]);
                        $this->grupo->ViewValue = $this->grupo->displayValue($arwrk);
                    } else {
                        $this->grupo->ViewValue = $this->grupo->CurrentValue;
                    }
                }
            } else {
                $this->grupo->ViewValue = null;
            }
            $this->grupo->ViewCustomAttributes = "";

            // subgrupo
            $curVal = trim(strval($this->subgrupo->CurrentValue));
            if ($curVal != "") {
                $this->subgrupo->ViewValue = $this->subgrupo->lookupCacheOption($curVal);
                if ($this->subgrupo->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_subgrupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->subgrupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->subgrupo->Lookup->renderViewRow($rswrk[0]);
                        $this->subgrupo->ViewValue = $this->subgrupo->displayValue($arwrk);
                    } else {
                        $this->subgrupo->ViewValue = $this->subgrupo->CurrentValue;
                    }
                }
            } else {
                $this->subgrupo->ViewValue = null;
            }
            $this->subgrupo->ViewCustomAttributes = "";

            // perfil
            if ($Security->canAdmin()) { // System admin
                $curVal = trim(strval($this->perfil->CurrentValue));
                if ($curVal != "") {
                    $this->perfil->ViewValue = $this->perfil->lookupCacheOption($curVal);
                    if ($this->perfil->ViewValue === null) { // Lookup from database
                        $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $lookupFilter = function() {
                            return (CurrentUserInfo("perfil") != -1) ? "`userlevelid` IN ('1','2','3','4')" : "";
                        };
                        $lookupFilter = $lookupFilter->bindTo($this);
                        $sqlWrk = $this->perfil->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->perfil->Lookup->renderViewRow($rswrk[0]);
                            $this->perfil->ViewValue = $this->perfil->displayValue($arwrk);
                        } else {
                            $this->perfil->ViewValue = $this->perfil->CurrentValue;
                        }
                    }
                } else {
                    $this->perfil->ViewValue = null;
                }
            } else {
                $this->perfil->ViewValue = $Language->phrase("PasswordMask");
            }
            $this->perfil->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // telefono
            $this->telefono->ViewValue = $this->telefono->CurrentValue;
            $this->telefono->ViewCustomAttributes = "";

            // pais
            $curVal = trim(strval($this->pais->CurrentValue));
            if ($curVal != "") {
                $this->pais->ViewValue = $this->pais->lookupCacheOption($curVal);
                if ($this->pais->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_zone`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->pais->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->pais->Lookup->renderViewRow($rswrk[0]);
                        $this->pais->ViewValue = $this->pais->displayValue($arwrk);
                    } else {
                        $this->pais->ViewValue = $this->pais->CurrentValue;
                    }
                }
            } else {
                $this->pais->ViewValue = null;
            }
            $this->pais->ViewCustomAttributes = "";

            // pw
            $this->pw->ViewValue = $Language->phrase("PasswordMask");
            $this->pw->ViewCustomAttributes = "";

            // estado
            if (strval($this->estado->CurrentValue) != "") {
                $this->estado->ViewValue = $this->estado->optionCaption($this->estado->CurrentValue);
            } else {
                $this->estado->ViewValue = null;
            }
            $this->estado->ViewCustomAttributes = "";

            // horario
            $this->horario->ViewValue = $this->horario->CurrentValue;
            $this->horario->ViewValue = FormatDateTime($this->horario->ViewValue, 0);
            $this->horario->ViewCustomAttributes = "";

            // limite
            $this->limite->ViewValue = $this->limite->CurrentValue;
            $this->limite->ViewValue = FormatDateTime($this->limite->ViewValue, 0);
            $this->limite->ViewCustomAttributes = "";

            // img_user
            if (!EmptyValue($this->img_user->Upload->DbValue)) {
                $this->img_user->ImageWidth = 50;
                $this->img_user->ImageHeight = 50;
                $this->img_user->ImageAlt = $this->img_user->alt();
                $this->img_user->ViewValue = $this->img_user->Upload->DbValue;
            } else {
                $this->img_user->ViewValue = "";
            }
            $this->img_user->ViewCustomAttributes = "";

            // blocks
            $this->blocks->ViewValue = $this->blocks->CurrentValue;
            $this->blocks->ViewCustomAttributes = "";

            // id_users
            $this->id_users->LinkCustomAttributes = "";
            $this->id_users->HrefValue = "";
            $this->id_users->TooltipValue = "";

            // fecha
            $this->fecha->LinkCustomAttributes = "";
            $this->fecha->HrefValue = "";
            $this->fecha->TooltipValue = "";

            // nombres
            $this->nombres->LinkCustomAttributes = "";
            $this->nombres->HrefValue = "";
            $this->nombres->TooltipValue = "";

            // apellidos
            $this->apellidos->LinkCustomAttributes = "";
            $this->apellidos->HrefValue = "";
            $this->apellidos->TooltipValue = "";

            // grupo
            $this->grupo->LinkCustomAttributes = "";
            $this->grupo->HrefValue = "";
            $this->grupo->TooltipValue = "";

            // subgrupo
            $this->subgrupo->LinkCustomAttributes = "";
            $this->subgrupo->HrefValue = "";
            $this->subgrupo->TooltipValue = "";

            // perfil
            $this->perfil->LinkCustomAttributes = "";
            $this->perfil->HrefValue = "";
            $this->perfil->TooltipValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // telefono
            $this->telefono->LinkCustomAttributes = "";
            $this->telefono->HrefValue = "";
            $this->telefono->TooltipValue = "";

            // pais
            $this->pais->LinkCustomAttributes = "";
            $this->pais->HrefValue = "";
            $this->pais->TooltipValue = "";

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";
            $this->estado->TooltipValue = "";

            // img_user
            $this->img_user->LinkCustomAttributes = "";
            if (!EmptyValue($this->img_user->Upload->DbValue)) {
                $this->img_user->HrefValue = GetFileUploadUrl($this->img_user, $this->img_user->htmlDecode($this->img_user->Upload->DbValue)); // Add prefix/suffix
                $this->img_user->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->img_user->HrefValue = FullUrl($this->img_user->HrefValue, "href");
                }
            } else {
                $this->img_user->HrefValue = "";
            }
            $this->img_user->ExportHrefValue = $this->img_user->UploadPath . $this->img_user->Upload->DbValue;
            $this->img_user->TooltipValue = "";
            if ($this->img_user->UseColorbox) {
                if (EmptyValue($this->img_user->TooltipValue)) {
                    $this->img_user->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->img_user->LinkAttrs["data-rel"] = "users_x" . $this->RowCount . "_img_user";
                $this->img_user->LinkAttrs->appendClass("ew-lightbox");
            }
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id_users

            // fecha

            // nombres
            $this->nombres->EditAttrs["class"] = "form-control";
            $this->nombres->EditCustomAttributes = "";
            if (!$this->nombres->Raw) {
                $this->nombres->CurrentValue = HtmlDecode($this->nombres->CurrentValue);
            }
            $this->nombres->EditValue = HtmlEncode($this->nombres->CurrentValue);
            $this->nombres->PlaceHolder = RemoveHtml($this->nombres->caption());

            // apellidos
            $this->apellidos->EditAttrs["class"] = "form-control";
            $this->apellidos->EditCustomAttributes = "";
            if (!$this->apellidos->Raw) {
                $this->apellidos->CurrentValue = HtmlDecode($this->apellidos->CurrentValue);
            }
            $this->apellidos->EditValue = HtmlEncode($this->apellidos->CurrentValue);
            $this->apellidos->PlaceHolder = RemoveHtml($this->apellidos->caption());

            // grupo
            $this->grupo->EditAttrs["class"] = "form-control";
            $this->grupo->EditCustomAttributes = "";
            if ($this->grupo->getSessionValue() != "") {
                $this->grupo->CurrentValue = GetForeignKeyValue($this->grupo->getSessionValue());
                $this->grupo->OldValue = $this->grupo->CurrentValue;
                $curVal = trim(strval($this->grupo->CurrentValue));
                if ($curVal != "") {
                    $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
                    if ($this->grupo->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id_grupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->grupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->grupo->Lookup->renderViewRow($rswrk[0]);
                            $this->grupo->ViewValue = $this->grupo->displayValue($arwrk);
                        } else {
                            $this->grupo->ViewValue = $this->grupo->CurrentValue;
                        }
                    }
                } else {
                    $this->grupo->ViewValue = null;
                }
                $this->grupo->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->grupo->CurrentValue));
                if ($curVal != "") {
                    $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
                } else {
                    $this->grupo->ViewValue = $this->grupo->Lookup !== null && is_array($this->grupo->Lookup->Options) ? $curVal : null;
                }
                if ($this->grupo->ViewValue !== null) { // Load from cache
                    $this->grupo->EditValue = array_values($this->grupo->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id_grupo`" . SearchString("=", $this->grupo->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->grupo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->grupo->EditValue = $arwrk;
                }
                $this->grupo->PlaceHolder = RemoveHtml($this->grupo->caption());
            }

            // subgrupo
            $this->subgrupo->EditAttrs["class"] = "form-control";
            $this->subgrupo->EditCustomAttributes = "";
            if ($this->subgrupo->getSessionValue() != "") {
                $this->subgrupo->CurrentValue = GetForeignKeyValue($this->subgrupo->getSessionValue());
                $this->subgrupo->OldValue = $this->subgrupo->CurrentValue;
                $curVal = trim(strval($this->subgrupo->CurrentValue));
                if ($curVal != "") {
                    $this->subgrupo->ViewValue = $this->subgrupo->lookupCacheOption($curVal);
                    if ($this->subgrupo->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id_subgrupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->subgrupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->subgrupo->Lookup->renderViewRow($rswrk[0]);
                            $this->subgrupo->ViewValue = $this->subgrupo->displayValue($arwrk);
                        } else {
                            $this->subgrupo->ViewValue = $this->subgrupo->CurrentValue;
                        }
                    }
                } else {
                    $this->subgrupo->ViewValue = null;
                }
                $this->subgrupo->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->subgrupo->CurrentValue));
                if ($curVal != "") {
                    $this->subgrupo->ViewValue = $this->subgrupo->lookupCacheOption($curVal);
                } else {
                    $this->subgrupo->ViewValue = $this->subgrupo->Lookup !== null && is_array($this->subgrupo->Lookup->Options) ? $curVal : null;
                }
                if ($this->subgrupo->ViewValue !== null) { // Load from cache
                    $this->subgrupo->EditValue = array_values($this->subgrupo->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id_subgrupo`" . SearchString("=", $this->subgrupo->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->subgrupo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->subgrupo->EditValue = $arwrk;
                }
                $this->subgrupo->PlaceHolder = RemoveHtml($this->subgrupo->caption());
            }

            // perfil
            $this->perfil->EditAttrs["class"] = "form-control";
            $this->perfil->EditCustomAttributes = "";
            if (!$Security->canAdmin()) { // System admin
                $this->perfil->EditValue = $Language->phrase("PasswordMask");
            } else {
                $curVal = trim(strval($this->perfil->CurrentValue));
                if ($curVal != "") {
                    $this->perfil->ViewValue = $this->perfil->lookupCacheOption($curVal);
                } else {
                    $this->perfil->ViewValue = $this->perfil->Lookup !== null && is_array($this->perfil->Lookup->Options) ? $curVal : null;
                }
                if ($this->perfil->ViewValue !== null) { // Load from cache
                    $this->perfil->EditValue = array_values($this->perfil->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`userlevelid`" . SearchString("=", $this->perfil->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return (CurrentUserInfo("perfil") != -1) ? "`userlevelid` IN ('1','2','3','4')" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->perfil->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->perfil->EditValue = $arwrk;
                }
                $this->perfil->PlaceHolder = RemoveHtml($this->perfil->caption());
            }

            // email
            $this->_email->EditAttrs["class"] = "form-control";
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // telefono
            $this->telefono->EditAttrs["class"] = "form-control";
            $this->telefono->EditCustomAttributes = "";
            if (!$this->telefono->Raw) {
                $this->telefono->CurrentValue = HtmlDecode($this->telefono->CurrentValue);
            }
            $this->telefono->EditValue = HtmlEncode($this->telefono->CurrentValue);
            $this->telefono->PlaceHolder = RemoveHtml($this->telefono->caption());

            // pais
            $this->pais->EditAttrs["class"] = "form-control";
            $this->pais->EditCustomAttributes = "";
            $curVal = trim(strval($this->pais->CurrentValue));
            if ($curVal != "") {
                $this->pais->ViewValue = $this->pais->lookupCacheOption($curVal);
            } else {
                $this->pais->ViewValue = $this->pais->Lookup !== null && is_array($this->pais->Lookup->Options) ? $curVal : null;
            }
            if ($this->pais->ViewValue !== null) { // Load from cache
                $this->pais->EditValue = array_values($this->pais->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_zone`" . SearchString("=", $this->pais->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->pais->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->pais->EditValue = $arwrk;
            }
            $this->pais->PlaceHolder = RemoveHtml($this->pais->caption());

            // estado
            $this->estado->EditCustomAttributes = "";
            $this->estado->EditValue = $this->estado->options(false);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // img_user
            $this->img_user->EditAttrs["class"] = "form-control";
            $this->img_user->EditCustomAttributes = "";
            if (!EmptyValue($this->img_user->Upload->DbValue)) {
                $this->img_user->ImageWidth = 50;
                $this->img_user->ImageHeight = 50;
                $this->img_user->ImageAlt = $this->img_user->alt();
                $this->img_user->EditValue = $this->img_user->Upload->DbValue;
            } else {
                $this->img_user->EditValue = "";
            }
            if (!EmptyValue($this->img_user->CurrentValue)) {
                $this->img_user->Upload->FileName = $this->img_user->CurrentValue;
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->img_user, $this->RowIndex);
            }

            // Add refer script

            // id_users
            $this->id_users->LinkCustomAttributes = "";
            $this->id_users->HrefValue = "";

            // fecha
            $this->fecha->LinkCustomAttributes = "";
            $this->fecha->HrefValue = "";

            // nombres
            $this->nombres->LinkCustomAttributes = "";
            $this->nombres->HrefValue = "";

            // apellidos
            $this->apellidos->LinkCustomAttributes = "";
            $this->apellidos->HrefValue = "";

            // grupo
            $this->grupo->LinkCustomAttributes = "";
            $this->grupo->HrefValue = "";

            // subgrupo
            $this->subgrupo->LinkCustomAttributes = "";
            $this->subgrupo->HrefValue = "";

            // perfil
            $this->perfil->LinkCustomAttributes = "";
            $this->perfil->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // telefono
            $this->telefono->LinkCustomAttributes = "";
            $this->telefono->HrefValue = "";

            // pais
            $this->pais->LinkCustomAttributes = "";
            $this->pais->HrefValue = "";

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";

            // img_user
            $this->img_user->LinkCustomAttributes = "";
            if (!EmptyValue($this->img_user->Upload->DbValue)) {
                $this->img_user->HrefValue = GetFileUploadUrl($this->img_user, $this->img_user->htmlDecode($this->img_user->Upload->DbValue)); // Add prefix/suffix
                $this->img_user->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->img_user->HrefValue = FullUrl($this->img_user->HrefValue, "href");
                }
            } else {
                $this->img_user->HrefValue = "";
            }
            $this->img_user->ExportHrefValue = $this->img_user->UploadPath . $this->img_user->Upload->DbValue;
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id_users
            $this->id_users->EditAttrs["class"] = "form-control";
            $this->id_users->EditCustomAttributes = "";
            $this->id_users->EditValue = $this->id_users->CurrentValue;
            $this->id_users->ViewCustomAttributes = "";

            // fecha

            // nombres
            $this->nombres->EditAttrs["class"] = "form-control";
            $this->nombres->EditCustomAttributes = "";
            if (!$this->nombres->Raw) {
                $this->nombres->CurrentValue = HtmlDecode($this->nombres->CurrentValue);
            }
            $this->nombres->EditValue = HtmlEncode($this->nombres->CurrentValue);
            $this->nombres->PlaceHolder = RemoveHtml($this->nombres->caption());

            // apellidos
            $this->apellidos->EditAttrs["class"] = "form-control";
            $this->apellidos->EditCustomAttributes = "";
            if (!$this->apellidos->Raw) {
                $this->apellidos->CurrentValue = HtmlDecode($this->apellidos->CurrentValue);
            }
            $this->apellidos->EditValue = HtmlEncode($this->apellidos->CurrentValue);
            $this->apellidos->PlaceHolder = RemoveHtml($this->apellidos->caption());

            // grupo
            $this->grupo->EditAttrs["class"] = "form-control";
            $this->grupo->EditCustomAttributes = "";
            if ($this->grupo->getSessionValue() != "") {
                $this->grupo->CurrentValue = GetForeignKeyValue($this->grupo->getSessionValue());
                $this->grupo->OldValue = $this->grupo->CurrentValue;
                $curVal = trim(strval($this->grupo->CurrentValue));
                if ($curVal != "") {
                    $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
                    if ($this->grupo->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id_grupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->grupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->grupo->Lookup->renderViewRow($rswrk[0]);
                            $this->grupo->ViewValue = $this->grupo->displayValue($arwrk);
                        } else {
                            $this->grupo->ViewValue = $this->grupo->CurrentValue;
                        }
                    }
                } else {
                    $this->grupo->ViewValue = null;
                }
                $this->grupo->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->grupo->CurrentValue));
                if ($curVal != "") {
                    $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
                } else {
                    $this->grupo->ViewValue = $this->grupo->Lookup !== null && is_array($this->grupo->Lookup->Options) ? $curVal : null;
                }
                if ($this->grupo->ViewValue !== null) { // Load from cache
                    $this->grupo->EditValue = array_values($this->grupo->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id_grupo`" . SearchString("=", $this->grupo->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->grupo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->grupo->EditValue = $arwrk;
                }
                $this->grupo->PlaceHolder = RemoveHtml($this->grupo->caption());
            }

            // subgrupo
            $this->subgrupo->EditAttrs["class"] = "form-control";
            $this->subgrupo->EditCustomAttributes = "";
            if ($this->subgrupo->getSessionValue() != "") {
                $this->subgrupo->CurrentValue = GetForeignKeyValue($this->subgrupo->getSessionValue());
                $this->subgrupo->OldValue = $this->subgrupo->CurrentValue;
                $curVal = trim(strval($this->subgrupo->CurrentValue));
                if ($curVal != "") {
                    $this->subgrupo->ViewValue = $this->subgrupo->lookupCacheOption($curVal);
                    if ($this->subgrupo->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id_subgrupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->subgrupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->subgrupo->Lookup->renderViewRow($rswrk[0]);
                            $this->subgrupo->ViewValue = $this->subgrupo->displayValue($arwrk);
                        } else {
                            $this->subgrupo->ViewValue = $this->subgrupo->CurrentValue;
                        }
                    }
                } else {
                    $this->subgrupo->ViewValue = null;
                }
                $this->subgrupo->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->subgrupo->CurrentValue));
                if ($curVal != "") {
                    $this->subgrupo->ViewValue = $this->subgrupo->lookupCacheOption($curVal);
                } else {
                    $this->subgrupo->ViewValue = $this->subgrupo->Lookup !== null && is_array($this->subgrupo->Lookup->Options) ? $curVal : null;
                }
                if ($this->subgrupo->ViewValue !== null) { // Load from cache
                    $this->subgrupo->EditValue = array_values($this->subgrupo->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id_subgrupo`" . SearchString("=", $this->subgrupo->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->subgrupo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->subgrupo->EditValue = $arwrk;
                }
                $this->subgrupo->PlaceHolder = RemoveHtml($this->subgrupo->caption());
            }

            // perfil
            $this->perfil->EditAttrs["class"] = "form-control";
            $this->perfil->EditCustomAttributes = "";
            if (!$Security->canAdmin()) { // System admin
                $this->perfil->EditValue = $Language->phrase("PasswordMask");
            } else {
                $curVal = trim(strval($this->perfil->CurrentValue));
                if ($curVal != "") {
                    $this->perfil->ViewValue = $this->perfil->lookupCacheOption($curVal);
                } else {
                    $this->perfil->ViewValue = $this->perfil->Lookup !== null && is_array($this->perfil->Lookup->Options) ? $curVal : null;
                }
                if ($this->perfil->ViewValue !== null) { // Load from cache
                    $this->perfil->EditValue = array_values($this->perfil->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`userlevelid`" . SearchString("=", $this->perfil->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return (CurrentUserInfo("perfil") != -1) ? "`userlevelid` IN ('1','2','3','4')" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->perfil->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->perfil->EditValue = $arwrk;
                }
                $this->perfil->PlaceHolder = RemoveHtml($this->perfil->caption());
            }

            // email
            $this->_email->EditAttrs["class"] = "form-control";
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // telefono
            $this->telefono->EditAttrs["class"] = "form-control";
            $this->telefono->EditCustomAttributes = "";
            if (!$this->telefono->Raw) {
                $this->telefono->CurrentValue = HtmlDecode($this->telefono->CurrentValue);
            }
            $this->telefono->EditValue = HtmlEncode($this->telefono->CurrentValue);
            $this->telefono->PlaceHolder = RemoveHtml($this->telefono->caption());

            // pais
            $this->pais->EditAttrs["class"] = "form-control";
            $this->pais->EditCustomAttributes = "";
            $curVal = trim(strval($this->pais->CurrentValue));
            if ($curVal != "") {
                $this->pais->ViewValue = $this->pais->lookupCacheOption($curVal);
            } else {
                $this->pais->ViewValue = $this->pais->Lookup !== null && is_array($this->pais->Lookup->Options) ? $curVal : null;
            }
            if ($this->pais->ViewValue !== null) { // Load from cache
                $this->pais->EditValue = array_values($this->pais->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_zone`" . SearchString("=", $this->pais->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->pais->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->pais->EditValue = $arwrk;
            }
            $this->pais->PlaceHolder = RemoveHtml($this->pais->caption());

            // estado
            $this->estado->EditCustomAttributes = "";
            $this->estado->EditValue = $this->estado->options(false);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // img_user
            $this->img_user->EditAttrs["class"] = "form-control";
            $this->img_user->EditCustomAttributes = "";
            if (!EmptyValue($this->img_user->Upload->DbValue)) {
                $this->img_user->ImageWidth = 50;
                $this->img_user->ImageHeight = 50;
                $this->img_user->ImageAlt = $this->img_user->alt();
                $this->img_user->EditValue = $this->img_user->Upload->DbValue;
            } else {
                $this->img_user->EditValue = "";
            }
            if (!EmptyValue($this->img_user->CurrentValue)) {
                $this->img_user->Upload->FileName = $this->img_user->CurrentValue;
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->img_user, $this->RowIndex);
            }

            // Edit refer script

            // id_users
            $this->id_users->LinkCustomAttributes = "";
            $this->id_users->HrefValue = "";

            // fecha
            $this->fecha->LinkCustomAttributes = "";
            $this->fecha->HrefValue = "";

            // nombres
            $this->nombres->LinkCustomAttributes = "";
            $this->nombres->HrefValue = "";

            // apellidos
            $this->apellidos->LinkCustomAttributes = "";
            $this->apellidos->HrefValue = "";

            // grupo
            $this->grupo->LinkCustomAttributes = "";
            $this->grupo->HrefValue = "";

            // subgrupo
            $this->subgrupo->LinkCustomAttributes = "";
            $this->subgrupo->HrefValue = "";

            // perfil
            $this->perfil->LinkCustomAttributes = "";
            $this->perfil->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // telefono
            $this->telefono->LinkCustomAttributes = "";
            $this->telefono->HrefValue = "";

            // pais
            $this->pais->LinkCustomAttributes = "";
            $this->pais->HrefValue = "";

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";

            // img_user
            $this->img_user->LinkCustomAttributes = "";
            if (!EmptyValue($this->img_user->Upload->DbValue)) {
                $this->img_user->HrefValue = GetFileUploadUrl($this->img_user, $this->img_user->htmlDecode($this->img_user->Upload->DbValue)); // Add prefix/suffix
                $this->img_user->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->img_user->HrefValue = FullUrl($this->img_user->HrefValue, "href");
                }
            } else {
                $this->img_user->HrefValue = "";
            }
            $this->img_user->ExportHrefValue = $this->img_user->UploadPath . $this->img_user->Upload->DbValue;
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->id_users->Required) {
            if (!$this->id_users->IsDetailKey && EmptyValue($this->id_users->FormValue)) {
                $this->id_users->addErrorMessage(str_replace("%s", $this->id_users->caption(), $this->id_users->RequiredErrorMessage));
            }
        }
        if ($this->fecha->Required) {
            if (!$this->fecha->IsDetailKey && EmptyValue($this->fecha->FormValue)) {
                $this->fecha->addErrorMessage(str_replace("%s", $this->fecha->caption(), $this->fecha->RequiredErrorMessage));
            }
        }
        if ($this->nombres->Required) {
            if (!$this->nombres->IsDetailKey && EmptyValue($this->nombres->FormValue)) {
                $this->nombres->addErrorMessage(str_replace("%s", $this->nombres->caption(), $this->nombres->RequiredErrorMessage));
            }
        }
        if ($this->apellidos->Required) {
            if (!$this->apellidos->IsDetailKey && EmptyValue($this->apellidos->FormValue)) {
                $this->apellidos->addErrorMessage(str_replace("%s", $this->apellidos->caption(), $this->apellidos->RequiredErrorMessage));
            }
        }
        if ($this->grupo->Required) {
            if (!$this->grupo->IsDetailKey && EmptyValue($this->grupo->FormValue)) {
                $this->grupo->addErrorMessage(str_replace("%s", $this->grupo->caption(), $this->grupo->RequiredErrorMessage));
            }
        }
        if ($this->subgrupo->Required) {
            if (!$this->subgrupo->IsDetailKey && EmptyValue($this->subgrupo->FormValue)) {
                $this->subgrupo->addErrorMessage(str_replace("%s", $this->subgrupo->caption(), $this->subgrupo->RequiredErrorMessage));
            }
        }
        if ($this->perfil->Required) {
            if (!$this->perfil->IsDetailKey && EmptyValue($this->perfil->FormValue)) {
                $this->perfil->addErrorMessage(str_replace("%s", $this->perfil->caption(), $this->perfil->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if (!CheckEmail($this->_email->FormValue)) {
            $this->_email->addErrorMessage($this->_email->getErrorMessage(false));
        }
        if (!$this->_email->Raw && Config("REMOVE_XSS") && CheckUsername($this->_email->FormValue)) {
            $this->_email->addErrorMessage($Language->phrase("InvalidUsernameChars"));
        }
        if ($this->telefono->Required) {
            if (!$this->telefono->IsDetailKey && EmptyValue($this->telefono->FormValue)) {
                $this->telefono->addErrorMessage(str_replace("%s", $this->telefono->caption(), $this->telefono->RequiredErrorMessage));
            }
        }
        if ($this->pais->Required) {
            if (!$this->pais->IsDetailKey && EmptyValue($this->pais->FormValue)) {
                $this->pais->addErrorMessage(str_replace("%s", $this->pais->caption(), $this->pais->RequiredErrorMessage));
            }
        }
        if ($this->estado->Required) {
            if ($this->estado->FormValue == "") {
                $this->estado->addErrorMessage(str_replace("%s", $this->estado->caption(), $this->estado->RequiredErrorMessage));
            }
        }
        if ($this->img_user->Required) {
            if ($this->img_user->Upload->FileName == "" && !$this->img_user->Upload->KeepFile) {
                $this->img_user->addErrorMessage(str_replace("%s", $this->img_user->caption(), $this->img_user->RequiredErrorMessage));
            }
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['id_users'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        if ($this->_email->CurrentValue != "") { // Check field with unique index
            $filterChk = "(`email` = '" . AdjustSql($this->_email->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->_email->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->_email->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                $rsChk->closeCursor();
                return false;
            }
        }
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // fecha
            $this->fecha->CurrentValue = CurrentDateTime();
            $this->fecha->setDbValueDef($rsnew, $this->fecha->CurrentValue, null);

            // nombres
            $this->nombres->setDbValueDef($rsnew, $this->nombres->CurrentValue, null, $this->nombres->ReadOnly);

            // apellidos
            $this->apellidos->setDbValueDef($rsnew, $this->apellidos->CurrentValue, null, $this->apellidos->ReadOnly);

            // grupo
            if ($this->grupo->getSessionValue() != "") {
                $this->grupo->ReadOnly = true;
            }
            $this->grupo->setDbValueDef($rsnew, $this->grupo->CurrentValue, null, $this->grupo->ReadOnly);

            // subgrupo
            if ($this->subgrupo->getSessionValue() != "") {
                $this->subgrupo->ReadOnly = true;
            }
            $this->subgrupo->setDbValueDef($rsnew, $this->subgrupo->CurrentValue, null, $this->subgrupo->ReadOnly);

            // perfil
            if ($Security->canAdmin()) { // System admin
                $this->perfil->setDbValueDef($rsnew, $this->perfil->CurrentValue, null, $this->perfil->ReadOnly);
            }

            // email
            $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, $this->_email->ReadOnly);

            // telefono
            $this->telefono->setDbValueDef($rsnew, $this->telefono->CurrentValue, null, $this->telefono->ReadOnly);

            // pais
            $this->pais->setDbValueDef($rsnew, $this->pais->CurrentValue, null, $this->pais->ReadOnly);

            // estado
            $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, null, $this->estado->ReadOnly);

            // img_user
            if ($this->img_user->Visible && !$this->img_user->ReadOnly && !$this->img_user->Upload->KeepFile) {
                $this->img_user->Upload->DbValue = $rsold['img_user']; // Get original value
                if ($this->img_user->Upload->FileName == "") {
                    $rsnew['img_user'] = null;
                } else {
                    $rsnew['img_user'] = $this->img_user->Upload->FileName;
                }
            }
            if ($this->img_user->Visible && !$this->img_user->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->img_user->Upload->DbValue) ? [] : [$this->img_user->htmlDecode($this->img_user->Upload->DbValue)];
                if (!EmptyValue($this->img_user->Upload->FileName)) {
                    $newFiles = [$this->img_user->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->img_user, $this->img_user->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->img_user->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->img_user->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->img_user->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->img_user->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->img_user->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->img_user->setDbValueDef($rsnew, $this->img_user->Upload->FileName, null, $this->img_user->ReadOnly);
                }
            }

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                    if ($this->img_user->Visible && !$this->img_user->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->img_user->Upload->DbValue) ? [] : [$this->img_user->htmlDecode($this->img_user->Upload->DbValue)];
                        if (!EmptyValue($this->img_user->Upload->FileName)) {
                            $newFiles = [$this->img_user->Upload->FileName];
                            $newFiles2 = [$this->img_user->htmlDecode($rsnew['img_user'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->img_user, $this->img_user->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->img_user->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->img_user->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
            // img_user
            CleanUploadTempPath($this->img_user, $this->img_user->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "subgrupo") {
            $this->subgrupo->CurrentValue = $this->subgrupo->getSessionValue();
        }
        if ($this->getCurrentMasterTable() == "grupo") {
            $this->grupo->CurrentValue = $this->grupo->getSessionValue();
        }
        if ($this->getCurrentMasterTable() == "escenario") {
            $this->escenario->CurrentValue = $this->escenario->getSessionValue();
        }
        if ($this->_email->CurrentValue != "") { // Check field with unique index
            $filter = "(`email` = '" . AdjustSql($this->_email->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->_email->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->_email->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // fecha
        $this->fecha->CurrentValue = CurrentDateTime();
        $this->fecha->setDbValueDef($rsnew, $this->fecha->CurrentValue, null);

        // nombres
        $this->nombres->setDbValueDef($rsnew, $this->nombres->CurrentValue, null, false);

        // apellidos
        $this->apellidos->setDbValueDef($rsnew, $this->apellidos->CurrentValue, null, false);

        // grupo
        $this->grupo->setDbValueDef($rsnew, $this->grupo->CurrentValue, null, strval($this->grupo->CurrentValue) == "");

        // subgrupo
        $this->subgrupo->setDbValueDef($rsnew, $this->subgrupo->CurrentValue, null, strval($this->subgrupo->CurrentValue) == "");

        // perfil
        if ($Security->canAdmin()) { // System admin
            $this->perfil->setDbValueDef($rsnew, $this->perfil->CurrentValue, null, false);
        }

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, false);

        // telefono
        $this->telefono->setDbValueDef($rsnew, $this->telefono->CurrentValue, null, false);

        // pais
        $this->pais->setDbValueDef($rsnew, $this->pais->CurrentValue, null, false);

        // estado
        $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, null, strval($this->estado->CurrentValue) == "");

        // img_user
        if ($this->img_user->Visible && !$this->img_user->Upload->KeepFile) {
            $this->img_user->Upload->DbValue = ""; // No need to delete old file
            if ($this->img_user->Upload->FileName == "") {
                $rsnew['img_user'] = null;
            } else {
                $rsnew['img_user'] = $this->img_user->Upload->FileName;
            }
        }

        // escenario
        if ($this->escenario->getSessionValue() != "") {
            $rsnew['escenario'] = $this->escenario->getSessionValue();
        }
        if ($this->img_user->Visible && !$this->img_user->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->img_user->Upload->DbValue) ? [] : [$this->img_user->htmlDecode($this->img_user->Upload->DbValue)];
            if (!EmptyValue($this->img_user->Upload->FileName)) {
                $newFiles = [$this->img_user->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->img_user, $this->img_user->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->img_user->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->img_user->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->img_user->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->img_user->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->img_user->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->img_user->setDbValueDef($rsnew, $this->img_user->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
                if ($this->img_user->Visible && !$this->img_user->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->img_user->Upload->DbValue) ? [] : [$this->img_user->htmlDecode($this->img_user->Upload->DbValue)];
                    if (!EmptyValue($this->img_user->Upload->FileName)) {
                        $newFiles = [$this->img_user->Upload->FileName];
                        $newFiles2 = [$this->img_user->htmlDecode($rsnew['img_user'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->img_user, $this->img_user->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->img_user->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->img_user->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // img_user
            CleanUploadTempPath($this->img_user, $this->img_user->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "subgrupo") {
            $masterTbl = Container("subgrupo");
            $this->subgrupo->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        if ($masterTblVar == "grupo") {
            $masterTbl = Container("grupo");
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        if ($masterTblVar == "escenario") {
            $masterTbl = Container("escenario");
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_escenario":
                    $lookupFilter = function () {
                        return (CurrentUserInfo("perfil") != 1) ? "id_escenario = '".CurrentUserInfo("escenario")."'"  : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_grupo":
                    break;
                case "x_subgrupo":
                    break;
                case "x_perfil":
                    $lookupFilter = function () {
                        return (CurrentUserInfo("perfil") != -1) ? "`userlevelid` IN ('1','2','3','4')" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_pais":
                    break;
                case "x_estado":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
        if ($this->CurrentAction == "gridedit") 
    {
    $this->email->Visible = FALSE;
    $this->telefono->Visible = FALSE;
    $this->pais->Visible = FALSE;
    $this->pw->Visible = FALSE;
    $this->img_user->Visible = FALSE;
    $this->perfil->Visible = FALSE;
    }
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
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
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }
}
