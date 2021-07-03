<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class EscenarioList extends Escenario
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'escenario';

    // Page object name
    public $PageObjName = "EscenarioList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fescenariolist";
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

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (escenario)
        if (!isset($GLOBALS["escenario"]) || get_class($GLOBALS["escenario"]) == PROJECT_NAMESPACE . "escenario") {
            $GLOBALS["escenario"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->AddUrl = "EscenarioAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "EscenarioDelete";
        $this->MultiUpdateUrl = "EscenarioUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'escenario');
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

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Import options
        $this->ImportOptions = new ListOptions("div");
        $this->ImportOptions->TagClassName = "ew-import-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";

        // Filter options
        $this->FilterOptions = new ListOptions("div");
        $this->FilterOptions->TagClassName = "ew-filter-option fescenariolistsrch";

        // List actions
        $this->ListActions = new ListActions();
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

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("escenario"));
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
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

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
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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
            $key .= @$ar['id_escenario'];
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
            $this->id_escenario->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->fechacreacion_escenario->Visible = false;
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
    public $DisplayRecords = 20;
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
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->id_escenario->setVisibility();
        $this->icon_escenario->setVisibility();
        $this->fechacreacion_escenario->setVisibility();
        $this->nombre_escenario->setVisibility();
        $this->tipo_evento->Visible = false;
        $this->incidente->setVisibility();
        $this->evento_asociado->setVisibility();
        $this->pais_escenario->setVisibility();
        $this->zonahora_escenario->Visible = false;
        $this->descripcion_escenario->Visible = false;
        $this->fechaini_real->setVisibility();
        $this->fechafinal_real->Visible = false;
        $this->fechaini_simulado->setVisibility();
        $this->fechafin_simulado->Visible = false;
        $this->estado->setVisibility();
        $this->image_escenario->Visible = false;
        $this->entrar->setVisibility();
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Show checkbox column if multiple action
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE && $listaction->Allow) {
                $this->ListOptions["checkbox"]->Visible = true;
                break;
            }
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->tipo_evento);
        $this->setupLookupOptions($this->incidente);
        $this->setupLookupOptions($this->evento_asociado);
        $this->setupLookupOptions($this->pais_escenario);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

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

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));
            AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

            // Get and validate search values for advanced search
            $this->loadSearchValues(); // Get search values

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }
            if (!$this->validateSearch()) {
                // Nothing to do
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }

            // Get search criteria for advanced search
            if (!$this->hasInvalidFields()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }

            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere();
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
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
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
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

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->id_escenario->AdvancedSearch->toJson(), ","); // Field id_escenario
        $filterList = Concat($filterList, $this->icon_escenario->AdvancedSearch->toJson(), ","); // Field icon_escenario
        $filterList = Concat($filterList, $this->fechacreacion_escenario->AdvancedSearch->toJson(), ","); // Field fechacreacion_escenario
        $filterList = Concat($filterList, $this->nombre_escenario->AdvancedSearch->toJson(), ","); // Field nombre_escenario
        $filterList = Concat($filterList, $this->tipo_evento->AdvancedSearch->toJson(), ","); // Field tipo_evento
        $filterList = Concat($filterList, $this->incidente->AdvancedSearch->toJson(), ","); // Field incidente
        $filterList = Concat($filterList, $this->evento_asociado->AdvancedSearch->toJson(), ","); // Field evento_asociado
        $filterList = Concat($filterList, $this->pais_escenario->AdvancedSearch->toJson(), ","); // Field pais_escenario
        $filterList = Concat($filterList, $this->zonahora_escenario->AdvancedSearch->toJson(), ","); // Field zonahora_escenario
        $filterList = Concat($filterList, $this->descripcion_escenario->AdvancedSearch->toJson(), ","); // Field descripcion_escenario
        $filterList = Concat($filterList, $this->fechaini_real->AdvancedSearch->toJson(), ","); // Field fechaini_real
        $filterList = Concat($filterList, $this->fechafinal_real->AdvancedSearch->toJson(), ","); // Field fechafinal_real
        $filterList = Concat($filterList, $this->fechaini_simulado->AdvancedSearch->toJson(), ","); // Field fechaini_simulado
        $filterList = Concat($filterList, $this->fechafin_simulado->AdvancedSearch->toJson(), ","); // Field fechafin_simulado
        $filterList = Concat($filterList, $this->estado->AdvancedSearch->toJson(), ","); // Field estado
        $filterList = Concat($filterList, $this->image_escenario->AdvancedSearch->toJson(), ","); // Field image_escenario
        $filterList = Concat($filterList, $this->entrar->AdvancedSearch->toJson(), ","); // Field entrar
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fescenariolistsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field id_escenario
        $this->id_escenario->AdvancedSearch->SearchValue = @$filter["x_id_escenario"];
        $this->id_escenario->AdvancedSearch->SearchOperator = @$filter["z_id_escenario"];
        $this->id_escenario->AdvancedSearch->SearchCondition = @$filter["v_id_escenario"];
        $this->id_escenario->AdvancedSearch->SearchValue2 = @$filter["y_id_escenario"];
        $this->id_escenario->AdvancedSearch->SearchOperator2 = @$filter["w_id_escenario"];
        $this->id_escenario->AdvancedSearch->save();

        // Field icon_escenario
        $this->icon_escenario->AdvancedSearch->SearchValue = @$filter["x_icon_escenario"];
        $this->icon_escenario->AdvancedSearch->SearchOperator = @$filter["z_icon_escenario"];
        $this->icon_escenario->AdvancedSearch->SearchCondition = @$filter["v_icon_escenario"];
        $this->icon_escenario->AdvancedSearch->SearchValue2 = @$filter["y_icon_escenario"];
        $this->icon_escenario->AdvancedSearch->SearchOperator2 = @$filter["w_icon_escenario"];
        $this->icon_escenario->AdvancedSearch->save();

        // Field fechacreacion_escenario
        $this->fechacreacion_escenario->AdvancedSearch->SearchValue = @$filter["x_fechacreacion_escenario"];
        $this->fechacreacion_escenario->AdvancedSearch->SearchOperator = @$filter["z_fechacreacion_escenario"];
        $this->fechacreacion_escenario->AdvancedSearch->SearchCondition = @$filter["v_fechacreacion_escenario"];
        $this->fechacreacion_escenario->AdvancedSearch->SearchValue2 = @$filter["y_fechacreacion_escenario"];
        $this->fechacreacion_escenario->AdvancedSearch->SearchOperator2 = @$filter["w_fechacreacion_escenario"];
        $this->fechacreacion_escenario->AdvancedSearch->save();

        // Field nombre_escenario
        $this->nombre_escenario->AdvancedSearch->SearchValue = @$filter["x_nombre_escenario"];
        $this->nombre_escenario->AdvancedSearch->SearchOperator = @$filter["z_nombre_escenario"];
        $this->nombre_escenario->AdvancedSearch->SearchCondition = @$filter["v_nombre_escenario"];
        $this->nombre_escenario->AdvancedSearch->SearchValue2 = @$filter["y_nombre_escenario"];
        $this->nombre_escenario->AdvancedSearch->SearchOperator2 = @$filter["w_nombre_escenario"];
        $this->nombre_escenario->AdvancedSearch->save();

        // Field tipo_evento
        $this->tipo_evento->AdvancedSearch->SearchValue = @$filter["x_tipo_evento"];
        $this->tipo_evento->AdvancedSearch->SearchOperator = @$filter["z_tipo_evento"];
        $this->tipo_evento->AdvancedSearch->SearchCondition = @$filter["v_tipo_evento"];
        $this->tipo_evento->AdvancedSearch->SearchValue2 = @$filter["y_tipo_evento"];
        $this->tipo_evento->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_evento"];
        $this->tipo_evento->AdvancedSearch->save();

        // Field incidente
        $this->incidente->AdvancedSearch->SearchValue = @$filter["x_incidente"];
        $this->incidente->AdvancedSearch->SearchOperator = @$filter["z_incidente"];
        $this->incidente->AdvancedSearch->SearchCondition = @$filter["v_incidente"];
        $this->incidente->AdvancedSearch->SearchValue2 = @$filter["y_incidente"];
        $this->incidente->AdvancedSearch->SearchOperator2 = @$filter["w_incidente"];
        $this->incidente->AdvancedSearch->save();

        // Field evento_asociado
        $this->evento_asociado->AdvancedSearch->SearchValue = @$filter["x_evento_asociado"];
        $this->evento_asociado->AdvancedSearch->SearchOperator = @$filter["z_evento_asociado"];
        $this->evento_asociado->AdvancedSearch->SearchCondition = @$filter["v_evento_asociado"];
        $this->evento_asociado->AdvancedSearch->SearchValue2 = @$filter["y_evento_asociado"];
        $this->evento_asociado->AdvancedSearch->SearchOperator2 = @$filter["w_evento_asociado"];
        $this->evento_asociado->AdvancedSearch->save();

        // Field pais_escenario
        $this->pais_escenario->AdvancedSearch->SearchValue = @$filter["x_pais_escenario"];
        $this->pais_escenario->AdvancedSearch->SearchOperator = @$filter["z_pais_escenario"];
        $this->pais_escenario->AdvancedSearch->SearchCondition = @$filter["v_pais_escenario"];
        $this->pais_escenario->AdvancedSearch->SearchValue2 = @$filter["y_pais_escenario"];
        $this->pais_escenario->AdvancedSearch->SearchOperator2 = @$filter["w_pais_escenario"];
        $this->pais_escenario->AdvancedSearch->save();

        // Field zonahora_escenario
        $this->zonahora_escenario->AdvancedSearch->SearchValue = @$filter["x_zonahora_escenario"];
        $this->zonahora_escenario->AdvancedSearch->SearchOperator = @$filter["z_zonahora_escenario"];
        $this->zonahora_escenario->AdvancedSearch->SearchCondition = @$filter["v_zonahora_escenario"];
        $this->zonahora_escenario->AdvancedSearch->SearchValue2 = @$filter["y_zonahora_escenario"];
        $this->zonahora_escenario->AdvancedSearch->SearchOperator2 = @$filter["w_zonahora_escenario"];
        $this->zonahora_escenario->AdvancedSearch->save();

        // Field descripcion_escenario
        $this->descripcion_escenario->AdvancedSearch->SearchValue = @$filter["x_descripcion_escenario"];
        $this->descripcion_escenario->AdvancedSearch->SearchOperator = @$filter["z_descripcion_escenario"];
        $this->descripcion_escenario->AdvancedSearch->SearchCondition = @$filter["v_descripcion_escenario"];
        $this->descripcion_escenario->AdvancedSearch->SearchValue2 = @$filter["y_descripcion_escenario"];
        $this->descripcion_escenario->AdvancedSearch->SearchOperator2 = @$filter["w_descripcion_escenario"];
        $this->descripcion_escenario->AdvancedSearch->save();

        // Field fechaini_real
        $this->fechaini_real->AdvancedSearch->SearchValue = @$filter["x_fechaini_real"];
        $this->fechaini_real->AdvancedSearch->SearchOperator = @$filter["z_fechaini_real"];
        $this->fechaini_real->AdvancedSearch->SearchCondition = @$filter["v_fechaini_real"];
        $this->fechaini_real->AdvancedSearch->SearchValue2 = @$filter["y_fechaini_real"];
        $this->fechaini_real->AdvancedSearch->SearchOperator2 = @$filter["w_fechaini_real"];
        $this->fechaini_real->AdvancedSearch->save();

        // Field fechafinal_real
        $this->fechafinal_real->AdvancedSearch->SearchValue = @$filter["x_fechafinal_real"];
        $this->fechafinal_real->AdvancedSearch->SearchOperator = @$filter["z_fechafinal_real"];
        $this->fechafinal_real->AdvancedSearch->SearchCondition = @$filter["v_fechafinal_real"];
        $this->fechafinal_real->AdvancedSearch->SearchValue2 = @$filter["y_fechafinal_real"];
        $this->fechafinal_real->AdvancedSearch->SearchOperator2 = @$filter["w_fechafinal_real"];
        $this->fechafinal_real->AdvancedSearch->save();

        // Field fechaini_simulado
        $this->fechaini_simulado->AdvancedSearch->SearchValue = @$filter["x_fechaini_simulado"];
        $this->fechaini_simulado->AdvancedSearch->SearchOperator = @$filter["z_fechaini_simulado"];
        $this->fechaini_simulado->AdvancedSearch->SearchCondition = @$filter["v_fechaini_simulado"];
        $this->fechaini_simulado->AdvancedSearch->SearchValue2 = @$filter["y_fechaini_simulado"];
        $this->fechaini_simulado->AdvancedSearch->SearchOperator2 = @$filter["w_fechaini_simulado"];
        $this->fechaini_simulado->AdvancedSearch->save();

        // Field fechafin_simulado
        $this->fechafin_simulado->AdvancedSearch->SearchValue = @$filter["x_fechafin_simulado"];
        $this->fechafin_simulado->AdvancedSearch->SearchOperator = @$filter["z_fechafin_simulado"];
        $this->fechafin_simulado->AdvancedSearch->SearchCondition = @$filter["v_fechafin_simulado"];
        $this->fechafin_simulado->AdvancedSearch->SearchValue2 = @$filter["y_fechafin_simulado"];
        $this->fechafin_simulado->AdvancedSearch->SearchOperator2 = @$filter["w_fechafin_simulado"];
        $this->fechafin_simulado->AdvancedSearch->save();

        // Field estado
        $this->estado->AdvancedSearch->SearchValue = @$filter["x_estado"];
        $this->estado->AdvancedSearch->SearchOperator = @$filter["z_estado"];
        $this->estado->AdvancedSearch->SearchCondition = @$filter["v_estado"];
        $this->estado->AdvancedSearch->SearchValue2 = @$filter["y_estado"];
        $this->estado->AdvancedSearch->SearchOperator2 = @$filter["w_estado"];
        $this->estado->AdvancedSearch->save();

        // Field image_escenario
        $this->image_escenario->AdvancedSearch->SearchValue = @$filter["x_image_escenario"];
        $this->image_escenario->AdvancedSearch->SearchOperator = @$filter["z_image_escenario"];
        $this->image_escenario->AdvancedSearch->SearchCondition = @$filter["v_image_escenario"];
        $this->image_escenario->AdvancedSearch->SearchValue2 = @$filter["y_image_escenario"];
        $this->image_escenario->AdvancedSearch->SearchOperator2 = @$filter["w_image_escenario"];
        $this->image_escenario->AdvancedSearch->save();

        // Field entrar
        $this->entrar->AdvancedSearch->SearchValue = @$filter["x_entrar"];
        $this->entrar->AdvancedSearch->SearchOperator = @$filter["z_entrar"];
        $this->entrar->AdvancedSearch->SearchCondition = @$filter["v_entrar"];
        $this->entrar->AdvancedSearch->SearchValue2 = @$filter["y_entrar"];
        $this->entrar->AdvancedSearch->SearchOperator2 = @$filter["w_entrar"];
        $this->entrar->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Advanced search WHERE clause based on QueryString
    protected function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->id_escenario, $default, false); // id_escenario
        $this->buildSearchSql($where, $this->icon_escenario, $default, false); // icon_escenario
        $this->buildSearchSql($where, $this->fechacreacion_escenario, $default, false); // fechacreacion_escenario
        $this->buildSearchSql($where, $this->nombre_escenario, $default, false); // nombre_escenario
        $this->buildSearchSql($where, $this->tipo_evento, $default, false); // tipo_evento
        $this->buildSearchSql($where, $this->incidente, $default, false); // incidente
        $this->buildSearchSql($where, $this->evento_asociado, $default, true); // evento_asociado
        $this->buildSearchSql($where, $this->pais_escenario, $default, false); // pais_escenario
        $this->buildSearchSql($where, $this->zonahora_escenario, $default, false); // zonahora_escenario
        $this->buildSearchSql($where, $this->descripcion_escenario, $default, false); // descripcion_escenario
        $this->buildSearchSql($where, $this->fechaini_real, $default, false); // fechaini_real
        $this->buildSearchSql($where, $this->fechafinal_real, $default, false); // fechafinal_real
        $this->buildSearchSql($where, $this->fechaini_simulado, $default, false); // fechaini_simulado
        $this->buildSearchSql($where, $this->fechafin_simulado, $default, false); // fechafin_simulado
        $this->buildSearchSql($where, $this->estado, $default, false); // estado
        $this->buildSearchSql($where, $this->image_escenario, $default, false); // image_escenario
        $this->buildSearchSql($where, $this->entrar, $default, false); // entrar

        // Set up search parm
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->id_escenario->AdvancedSearch->save(); // id_escenario
            $this->icon_escenario->AdvancedSearch->save(); // icon_escenario
            $this->fechacreacion_escenario->AdvancedSearch->save(); // fechacreacion_escenario
            $this->nombre_escenario->AdvancedSearch->save(); // nombre_escenario
            $this->tipo_evento->AdvancedSearch->save(); // tipo_evento
            $this->incidente->AdvancedSearch->save(); // incidente
            $this->evento_asociado->AdvancedSearch->save(); // evento_asociado
            $this->pais_escenario->AdvancedSearch->save(); // pais_escenario
            $this->zonahora_escenario->AdvancedSearch->save(); // zonahora_escenario
            $this->descripcion_escenario->AdvancedSearch->save(); // descripcion_escenario
            $this->fechaini_real->AdvancedSearch->save(); // fechaini_real
            $this->fechafinal_real->AdvancedSearch->save(); // fechafinal_real
            $this->fechaini_simulado->AdvancedSearch->save(); // fechaini_simulado
            $this->fechafin_simulado->AdvancedSearch->save(); // fechafin_simulado
            $this->estado->AdvancedSearch->save(); // estado
            $this->image_escenario->AdvancedSearch->save(); // image_escenario
            $this->entrar->AdvancedSearch->save(); // entrar
        }
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, &$fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = ($default) ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = ($default) ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = ($default) ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = ($default) ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = ($default) ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $wrk = "";
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        if ($fldOpr == "") {
            $fldOpr = "=";
        }
        $fldOpr2 = strtoupper(trim($fldOpr2));
        if ($fldOpr2 == "") {
            $fldOpr2 = "=";
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk1 = ($fldVal != "") ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = ($fldVal2 != "") ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            $wrk = $wrk1; // Build final SQL
            if ($wrk2 != "") {
                $wrk = ($wrk != "") ? "($wrk) $fldCond ($wrk2)" : $wrk2;
            }
        } else {
            $fldVal = $this->convertSearchValue($fld, $fldVal);
            $fldVal2 = $this->convertSearchValue($fld, $fldVal2);
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        AddFilter($where, $wrk);
    }

    // Convert search value
    protected function convertSearchValue(&$fld, $fldVal)
    {
        if ($fldVal == Config("NULL_VALUE") || $fldVal == Config("NOT_NULL_VALUE")) {
            return $fldVal;
        }
        $value = $fldVal;
        if ($fld->isBoolean()) {
            if ($fldVal != "") {
                $value = (SameText($fldVal, "1") || SameText($fldVal, "y") || SameText($fldVal, "t")) ? $fld->TrueValue : $fld->FalseValue;
            }
        } elseif ($fld->DataType == DATATYPE_DATE || $fld->DataType == DATATYPE_TIME) {
            if ($fldVal != "") {
                $value = UnFormatDateTime($fldVal, $fld->DateTimeFormat);
            }
        }
        return $value;
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->nombre_escenario, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->tipo_evento, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->evento_asociado, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->pais_escenario, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->descripcion_escenario, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->estado, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->image_escenario, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->entrar, $arKeywords, $type);
        return $where;
    }

    // Build basic search SQL
    protected function buildBasicSearchSql(&$where, &$fld, $arKeywords, $type)
    {
        $defCond = ($type == "OR") ? "OR" : "AND";
        $arSql = []; // Array for SQL parts
        $arCond = []; // Array for search conditions
        $cnt = count($arKeywords);
        $j = 0; // Number of SQL parts
        for ($i = 0; $i < $cnt; $i++) {
            $keyword = $arKeywords[$i];
            $keyword = trim($keyword);
            if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
                $keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
                $ar = explode("\\", $keyword);
            } else {
                $ar = [$keyword];
            }
            foreach ($ar as $keyword) {
                if ($keyword != "") {
                    $wrk = "";
                    if ($keyword == "OR" && $type == "") {
                        if ($j > 0) {
                            $arCond[$j - 1] = "OR";
                        }
                    } elseif ($keyword == Config("NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NULL";
                    } elseif ($keyword == Config("NOT_NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NOT NULL";
                    } elseif ($fld->IsVirtual && $fld->Visible) {
                        $wrk = $fld->VirtualExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    } elseif ($fld->DataType != DATATYPE_NUMBER || is_numeric($keyword)) {
                        $wrk = $fld->BasicSearchExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    }
                    if ($wrk != "") {
                        $arSql[$j] = $wrk;
                        $arCond[$j] = $defCond;
                        $j += 1;
                    }
                }
            }
        }
        $cnt = count($arSql);
        $quoted = false;
        $sql = "";
        if ($cnt > 0) {
            for ($i = 0; $i < $cnt - 1; $i++) {
                if ($arCond[$i] == "OR") {
                    if (!$quoted) {
                        $sql .= "(";
                    }
                    $quoted = true;
                }
                $sql .= $arSql[$i];
                if ($quoted && $arCond[$i] != "OR") {
                    $sql .= ")";
                    $quoted = false;
                }
                $sql .= " " . $arCond[$i] . " ";
            }
            $sql .= $arSql[$cnt - 1];
            if ($quoted) {
                $sql .= ")";
            }
        }
        if ($sql != "") {
            if ($where != "") {
                $where .= " OR ";
            }
            $where .= "(" . $sql . ")";
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $searchKeyword = ($default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = ($default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            // Search keyword in any fields
            if (($searchType == "OR" || $searchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
                foreach ($ar as $keyword) {
                    if ($keyword != "") {
                        if ($searchStr != "") {
                            $searchStr .= " " . $searchType . " ";
                        }
                        $searchStr .= "(" . $this->basicSearchSql([$keyword], $searchType) . ")";
                    }
                }
            } else {
                $searchStr = $this->basicSearchSql($ar, $searchType);
            }
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        if ($this->id_escenario->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->icon_escenario->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fechacreacion_escenario->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nombre_escenario->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tipo_evento->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->incidente->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->evento_asociado->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->pais_escenario->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->zonahora_escenario->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->descripcion_escenario->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fechaini_real->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fechafinal_real->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fechaini_simulado->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fechafin_simulado->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->estado->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->image_escenario->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->entrar->AdvancedSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
                $this->estado->AdvancedSearch->loadDefault();
        return true;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
                $this->id_escenario->AdvancedSearch->unsetSession();
                $this->icon_escenario->AdvancedSearch->unsetSession();
                $this->fechacreacion_escenario->AdvancedSearch->unsetSession();
                $this->nombre_escenario->AdvancedSearch->unsetSession();
                $this->tipo_evento->AdvancedSearch->unsetSession();
                $this->incidente->AdvancedSearch->unsetSession();
                $this->evento_asociado->AdvancedSearch->unsetSession();
                $this->pais_escenario->AdvancedSearch->unsetSession();
                $this->zonahora_escenario->AdvancedSearch->unsetSession();
                $this->descripcion_escenario->AdvancedSearch->unsetSession();
                $this->fechaini_real->AdvancedSearch->unsetSession();
                $this->fechafinal_real->AdvancedSearch->unsetSession();
                $this->fechaini_simulado->AdvancedSearch->unsetSession();
                $this->fechafin_simulado->AdvancedSearch->unsetSession();
                $this->estado->AdvancedSearch->unsetSession();
                $this->image_escenario->AdvancedSearch->unsetSession();
                $this->entrar->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
                $this->id_escenario->AdvancedSearch->load();
                $this->icon_escenario->AdvancedSearch->load();
                $this->fechacreacion_escenario->AdvancedSearch->load();
                $this->nombre_escenario->AdvancedSearch->load();
                $this->tipo_evento->AdvancedSearch->load();
                $this->incidente->AdvancedSearch->load();
                $this->evento_asociado->AdvancedSearch->load();
                $this->pais_escenario->AdvancedSearch->load();
                $this->zonahora_escenario->AdvancedSearch->load();
                $this->descripcion_escenario->AdvancedSearch->load();
                $this->fechaini_real->AdvancedSearch->load();
                $this->fechafinal_real->AdvancedSearch->load();
                $this->fechaini_simulado->AdvancedSearch->load();
                $this->fechafin_simulado->AdvancedSearch->load();
                $this->estado->AdvancedSearch->load();
                $this->image_escenario->AdvancedSearch->load();
                $this->entrar->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id_escenario); // id_escenario
            $this->updateSort($this->icon_escenario); // icon_escenario
            $this->updateSort($this->fechacreacion_escenario); // fechacreacion_escenario
            $this->updateSort($this->nombre_escenario); // nombre_escenario
            $this->updateSort($this->incidente); // incidente
            $this->updateSort($this->evento_asociado); // evento_asociado
            $this->updateSort($this->pais_escenario); // pais_escenario
            $this->updateSort($this->fechaini_real); // fechaini_real
            $this->updateSort($this->fechaini_simulado); // fechaini_simulado
            $this->updateSort($this->estado); // estado
            $this->updateSort($this->entrar); // entrar
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
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->id_escenario->setSort("");
                $this->icon_escenario->setSort("");
                $this->fechacreacion_escenario->setSort("");
                $this->nombre_escenario->setSort("");
                $this->tipo_evento->setSort("");
                $this->incidente->setSort("");
                $this->evento_asociado->setSort("");
                $this->pais_escenario->setSort("");
                $this->zonahora_escenario->setSort("");
                $this->descripcion_escenario->setSort("");
                $this->fechaini_real->setSort("");
                $this->fechafinal_real->setSort("");
                $this->fechaini_simulado->setSort("");
                $this->fechafin_simulado->setSort("");
                $this->estado->setSort("");
                $this->image_escenario->setSort("");
                $this->entrar->setSort("");
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

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = false;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

        // "detail_grupo"
        $item = &$this->ListOptions->add("detail_grupo");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'grupo') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_tareas"
        $item = &$this->ListOptions->add("detail_tareas");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'tareas') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_users"
        $item = &$this->ListOptions->add("detail_users");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'users') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$this->ListOptions->add("details");
            $item->CssClass = "text-nowrap";
            $item->Visible = $this->ShowMultipleDetails;
            $item->OnLeft = false;
            $item->ShowInButtonGroup = false;
        }

        // Set up detail pages
        $pages = new SubPages();
        $pages->add("grupo");
        $pages->add("tareas");
        $pages->add("users");
        $this->DetailPages = $pages;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = false;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = false;
        $item->Header = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"custom-control-input\" onclick=\"ew.selectAllKey(this);\"><label class=\"custom-control-label\" for=\"key\"></label></div>";
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

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
        $this->setupListOptionsExt();
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
        $pageUrl = $this->pageUrl();
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

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
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

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_SINGLE && $listaction->Allow) {
                    $action = $listaction->Action;
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $links[] = "<li><a class=\"dropdown-item ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a></li>";
                    if (count($links) == 1) { // Single button
                        $body = "<a class=\"ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a>";
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
                $opt->Visible = true;
            }
        }
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_grupo"
        $opt = $this->ListOptions["detail_grupo"];
        if ($Security->allowList(CurrentProjectID() . 'grupo')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("grupo", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("GrupoList?" . Config("TABLE_SHOW_MASTER") . "=escenario&" . GetForeignKeyUrl("fk_id_escenario", $this->id_escenario->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("GrupoGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=grupo");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "grupo";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=grupo");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "grupo";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $Security->allowAdd(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailCopyLink");
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=grupo");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailCopyTblVar != "") {
                    $detailCopyTblVar .= ",";
                }
                $detailCopyTblVar .= "grupo";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_tareas"
        $opt = $this->ListOptions["detail_tareas"];
        if ($Security->allowList(CurrentProjectID() . 'tareas')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("tareas", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("TareasList?" . Config("TABLE_SHOW_MASTER") . "=escenario&" . GetForeignKeyUrl("fk_id_escenario", $this->id_escenario->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("TareasGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=tareas");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "tareas";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=tareas");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "tareas";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $Security->allowAdd(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailCopyLink");
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=tareas");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailCopyTblVar != "") {
                    $detailCopyTblVar .= ",";
                }
                $detailCopyTblVar .= "tareas";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_users"
        $opt = $this->ListOptions["detail_users"];
        if ($Security->allowList(CurrentProjectID() . 'users')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("users", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("UsersList?" . Config("TABLE_SHOW_MASTER") . "=escenario&" . GetForeignKeyUrl("fk_id_escenario", $this->id_escenario->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("UsersGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=users");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "users";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=users");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "users";
            }
            if ($detailPage->DetailAdd && $Security->canAdd() && $Security->allowAdd(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailCopyLink");
                $url = $this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=users");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailCopyTblVar != "") {
                    $detailCopyTblVar .= ",";
                }
                $detailCopyTblVar .= "users";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailCopyLink")) . "\" href=\"" . HtmlEncode($this->GetCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailCopyLink")) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlTitle($Language->phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $opt = $this->ListOptions["details"];
            $opt->Body = $body;
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->id_escenario->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["detail"];
        $detailTableLink = "";
                $item = &$option->add("detailadd_grupo");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=grupo");
                $detailPage = Container("GrupoGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'escenario') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "grupo";
                }
                $item = &$option->add("detailadd_tareas");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=tareas");
                $detailPage = Container("TareasGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'escenario') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "tareas";
                }
                $item = &$option->add("detailadd_users");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=users");
                $detailPage = Container("UsersGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'escenario') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "users";
                }

        // Add multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$option->add("detailsadd");
            $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailTableLink);
            $caption = $Language->phrase("AddMasterDetailLink");
            $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
            $item->Visible = $detailTableLink != "" && $Security->canAdd();
            // Hide single master/detail items
            $ar = explode(",", $detailTableLink);
            $cnt = count($ar);
            for ($i = 0; $i < $cnt; $i++) {
                if ($item = $option["detailadd_" . $ar[$i]]) {
                    $item->Visible = false;
                }
            }
        }
        $option = $options["action"];

        // Set up options default
        foreach ($options as $option) {
            $option->UseDropDownButton = false;
            $option->UseButtonGroup = true;
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->add($option->GroupOptionName);
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fescenariolistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fescenariolistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listaction->Action);
                $caption = $listaction->Caption;
                $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fescenariolist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
                $item->Visible = $listaction->Allow;
            }
        }

        // Hide grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn, \PDO::FETCH_ASSOC);
            $this->CurrentAction = $userAction;

            // Call row action event
            if ($rs) {
                $conn->beginTransaction();
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    $conn->commit(); // Commit the changes
                    if ($this->getSuccessMessage() == "" && !ob_get_length()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    $conn->rollback(); // Rollback changes

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            $this->CurrentAction = ""; // Clear action
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
        // Hide detail items for dropdown if necessary
        $this->ListOptions->hideDetailItemsForDropDown();
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
        global $Security, $Language;
        $links = "";
        $btngrps = "";
        $sqlwrk = "`id_escenario`=" . AdjustSql($this->id_escenario->CurrentValue, $this->Dbid) . "";

        // Column "detail_grupo"
        if ($this->DetailPages && $this->DetailPages["grupo"] && $this->DetailPages["grupo"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_grupo"];
            $url = "GrupoPreview?t=escenario&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"grupo\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'escenario')) {
                $label = $Language->TablePhrase("grupo", "TblCaption");
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"grupo\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("GrupoList?" . Config("TABLE_SHOW_MASTER") . "=escenario&" . GetForeignKeyUrl("fk_id_escenario", $this->id_escenario->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("grupo", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("GrupoGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=grupo");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=grupo");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`id_escenario`=" . AdjustSql($this->id_escenario->CurrentValue, $this->Dbid) . "";

        // Column "detail_tareas"
        if ($this->DetailPages && $this->DetailPages["tareas"] && $this->DetailPages["tareas"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_tareas"];
            $url = "TareasPreview?t=escenario&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"tareas\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'escenario')) {
                $label = $Language->TablePhrase("tareas", "TblCaption");
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"tareas\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("TareasList?" . Config("TABLE_SHOW_MASTER") . "=escenario&" . GetForeignKeyUrl("fk_id_escenario", $this->id_escenario->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("tareas", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("TareasGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=tareas");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=tareas");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`escenario`=" . AdjustSql($this->id_escenario->CurrentValue, $this->Dbid) . "";

        // Column "detail_users"
        if ($this->DetailPages && $this->DetailPages["users"] && $this->DetailPages["users"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_users"];
            $url = "UsersPreview?t=escenario&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"users\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'escenario')) {
                $label = $Language->TablePhrase("users", "TblCaption");
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"users\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("UsersList?" . Config("TABLE_SHOW_MASTER") . "=escenario&" . GetForeignKeyUrl("fk_id_escenario", $this->id_escenario->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("users", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("UsersGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=users");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'escenario')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=users");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }

        // Hide detail items if necessary
        $this->ListOptions->hideDetailItemsForDropDown();

        // Column "preview"
        $option = $this->ListOptions["preview"];
        if (!$option) { // Add preview column
            $option = &$this->ListOptions->add("preview");
            $option->OnLeft = false;
            if ($option->OnLeft) {
                $option->moveTo($this->ListOptions->itemPos("checkbox") + 1);
            } else {
                $option->moveTo($this->ListOptions->itemPos("checkbox"));
            }
            $option->Visible = !($this->isExport() || $this->isGridAdd() || $this->isGridEdit());
            $option->ShowInDropDown = false;
            $option->ShowInButtonGroup = false;
        }
        if ($option) {
            $option->Body = "<i class=\"ew-preview-row-btn ew-icon icon-expand\"></i>";
            $option->Body .= "<div class=\"d-none ew-preview\">" . $links . $btngrps . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }

        // Column "details" (Multiple details)
        $option = $this->ListOptions["details"];
        if ($option) {
            $option->Body .= "<div class=\"d-none ew-preview\">" . $links . $btngrps . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // id_escenario
        if (!$this->isAddOrEdit() && $this->id_escenario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->id_escenario->AdvancedSearch->SearchValue != "" || $this->id_escenario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // icon_escenario
        if (!$this->isAddOrEdit() && $this->icon_escenario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->icon_escenario->AdvancedSearch->SearchValue != "" || $this->icon_escenario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fechacreacion_escenario
        if (!$this->isAddOrEdit() && $this->fechacreacion_escenario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fechacreacion_escenario->AdvancedSearch->SearchValue != "" || $this->fechacreacion_escenario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nombre_escenario
        if (!$this->isAddOrEdit() && $this->nombre_escenario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nombre_escenario->AdvancedSearch->SearchValue != "" || $this->nombre_escenario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tipo_evento
        if (!$this->isAddOrEdit() && $this->tipo_evento->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tipo_evento->AdvancedSearch->SearchValue != "" || $this->tipo_evento->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // incidente
        if (!$this->isAddOrEdit() && $this->incidente->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->incidente->AdvancedSearch->SearchValue != "" || $this->incidente->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // evento_asociado
        if (!$this->isAddOrEdit() && $this->evento_asociado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->evento_asociado->AdvancedSearch->SearchValue != "" || $this->evento_asociado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        if (is_array($this->evento_asociado->AdvancedSearch->SearchValue)) {
            $this->evento_asociado->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->evento_asociado->AdvancedSearch->SearchValue);
        }
        if (is_array($this->evento_asociado->AdvancedSearch->SearchValue2)) {
            $this->evento_asociado->AdvancedSearch->SearchValue2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->evento_asociado->AdvancedSearch->SearchValue2);
        }

        // pais_escenario
        if (!$this->isAddOrEdit() && $this->pais_escenario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->pais_escenario->AdvancedSearch->SearchValue != "" || $this->pais_escenario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // zonahora_escenario
        if (!$this->isAddOrEdit() && $this->zonahora_escenario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->zonahora_escenario->AdvancedSearch->SearchValue != "" || $this->zonahora_escenario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // descripcion_escenario
        if (!$this->isAddOrEdit() && $this->descripcion_escenario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->descripcion_escenario->AdvancedSearch->SearchValue != "" || $this->descripcion_escenario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fechaini_real
        if (!$this->isAddOrEdit() && $this->fechaini_real->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fechaini_real->AdvancedSearch->SearchValue != "" || $this->fechaini_real->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fechafinal_real
        if (!$this->isAddOrEdit() && $this->fechafinal_real->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fechafinal_real->AdvancedSearch->SearchValue != "" || $this->fechafinal_real->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fechaini_simulado
        if (!$this->isAddOrEdit() && $this->fechaini_simulado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fechaini_simulado->AdvancedSearch->SearchValue != "" || $this->fechaini_simulado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fechafin_simulado
        if (!$this->isAddOrEdit() && $this->fechafin_simulado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fechafin_simulado->AdvancedSearch->SearchValue != "" || $this->fechafin_simulado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // estado
        if (!$this->isAddOrEdit() && $this->estado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->estado->AdvancedSearch->SearchValue != "" || $this->estado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // image_escenario
        if (!$this->isAddOrEdit() && $this->image_escenario->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->image_escenario->AdvancedSearch->SearchValue != "" || $this->image_escenario->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // entrar
        if (!$this->isAddOrEdit() && $this->entrar->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->entrar->AdvancedSearch->SearchValue != "" || $this->entrar->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
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
        $this->id_escenario->setDbValue($row['id_escenario']);
        $this->icon_escenario->setDbValue($row['icon_escenario']);
        $this->fechacreacion_escenario->setDbValue($row['fechacreacion_escenario']);
        $this->nombre_escenario->setDbValue($row['nombre_escenario']);
        $this->tipo_evento->setDbValue($row['tipo_evento']);
        $this->incidente->setDbValue($row['incidente']);
        $this->evento_asociado->setDbValue($row['evento_asociado']);
        $this->pais_escenario->setDbValue($row['pais_escenario']);
        $this->zonahora_escenario->setDbValue($row['zonahora_escenario']);
        $this->descripcion_escenario->setDbValue($row['descripcion_escenario']);
        $this->fechaini_real->setDbValue($row['fechaini_real']);
        $this->fechafinal_real->setDbValue($row['fechafinal_real']);
        $this->fechaini_simulado->setDbValue($row['fechaini_simulado']);
        $this->fechafin_simulado->setDbValue($row['fechafin_simulado']);
        $this->estado->setDbValue($row['estado']);
        $this->image_escenario->Upload->DbValue = $row['image_escenario'];
        $this->image_escenario->setDbValue($this->image_escenario->Upload->DbValue);
        $this->entrar->setDbValue($row['entrar']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_escenario'] = null;
        $row['icon_escenario'] = null;
        $row['fechacreacion_escenario'] = null;
        $row['nombre_escenario'] = null;
        $row['tipo_evento'] = null;
        $row['incidente'] = null;
        $row['evento_asociado'] = null;
        $row['pais_escenario'] = null;
        $row['zonahora_escenario'] = null;
        $row['descripcion_escenario'] = null;
        $row['fechaini_real'] = null;
        $row['fechafinal_real'] = null;
        $row['fechaini_simulado'] = null;
        $row['fechafin_simulado'] = null;
        $row['estado'] = null;
        $row['image_escenario'] = null;
        $row['entrar'] = null;
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
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id_escenario

        // icon_escenario

        // fechacreacion_escenario

        // nombre_escenario

        // tipo_evento

        // incidente

        // evento_asociado

        // pais_escenario

        // zonahora_escenario
        $this->zonahora_escenario->CellCssStyle = "white-space: nowrap;";

        // descripcion_escenario

        // fechaini_real

        // fechafinal_real

        // fechaini_simulado

        // fechafin_simulado

        // estado

        // image_escenario

        // entrar
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_escenario
            $this->id_escenario->ViewValue = $this->id_escenario->CurrentValue;
            $this->id_escenario->ViewCustomAttributes = "";

            // icon_escenario
            $this->icon_escenario->ViewValue = $this->icon_escenario->CurrentValue;
            $this->icon_escenario->ViewCustomAttributes = "";

            // fechacreacion_escenario
            $this->fechacreacion_escenario->ViewValue = $this->fechacreacion_escenario->CurrentValue;
            $this->fechacreacion_escenario->ViewValue = FormatDateTime($this->fechacreacion_escenario->ViewValue, 9);
            $this->fechacreacion_escenario->ViewCustomAttributes = "";

            // nombre_escenario
            $this->nombre_escenario->ViewValue = $this->nombre_escenario->CurrentValue;
            $this->nombre_escenario->ViewCustomAttributes = "";

            // tipo_evento
            $curVal = trim(strval($this->tipo_evento->CurrentValue));
            if ($curVal != "") {
                $this->tipo_evento->ViewValue = $this->tipo_evento->lookupCacheOption($curVal);
                if ($this->tipo_evento->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_tipo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->tipo_evento->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_evento->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_evento->ViewValue = $this->tipo_evento->displayValue($arwrk);
                    } else {
                        $this->tipo_evento->ViewValue = $this->tipo_evento->CurrentValue;
                    }
                }
            } else {
                $this->tipo_evento->ViewValue = null;
            }
            $this->tipo_evento->ViewCustomAttributes = "";

            // incidente
            $curVal = trim(strval($this->incidente->CurrentValue));
            if ($curVal != "") {
                $this->incidente->ViewValue = $this->incidente->lookupCacheOption($curVal);
                if ($this->incidente->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_incidente`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->incidente->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->incidente->Lookup->renderViewRow($rswrk[0]);
                        $this->incidente->ViewValue = $this->incidente->displayValue($arwrk);
                    } else {
                        $this->incidente->ViewValue = $this->incidente->CurrentValue;
                    }
                }
            } else {
                $this->incidente->ViewValue = null;
            }
            $this->incidente->ViewCustomAttributes = "";

            // evento_asociado
            $curVal = trim(strval($this->evento_asociado->CurrentValue));
            if ($curVal != "") {
                $this->evento_asociado->ViewValue = $this->evento_asociado->lookupCacheOption($curVal);
                if ($this->evento_asociado->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`id_incidente`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->evento_asociado->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->evento_asociado->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->evento_asociado->Lookup->renderViewRow($row);
                            $this->evento_asociado->ViewValue->add($this->evento_asociado->displayValue($arwrk));
                        }
                    } else {
                        $this->evento_asociado->ViewValue = $this->evento_asociado->CurrentValue;
                    }
                }
            } else {
                $this->evento_asociado->ViewValue = null;
            }
            $this->evento_asociado->ViewCustomAttributes = "";

            // pais_escenario
            $curVal = trim(strval($this->pais_escenario->CurrentValue));
            if ($curVal != "") {
                $this->pais_escenario->ViewValue = $this->pais_escenario->lookupCacheOption($curVal);
                if ($this->pais_escenario->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_zone`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->pais_escenario->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->pais_escenario->Lookup->renderViewRow($rswrk[0]);
                        $this->pais_escenario->ViewValue = $this->pais_escenario->displayValue($arwrk);
                    } else {
                        $this->pais_escenario->ViewValue = $this->pais_escenario->CurrentValue;
                    }
                }
            } else {
                $this->pais_escenario->ViewValue = null;
            }
            $this->pais_escenario->ViewCustomAttributes = "";

            // fechaini_real
            $this->fechaini_real->ViewValue = $this->fechaini_real->CurrentValue;
            $this->fechaini_real->ViewValue = FormatDateTime($this->fechaini_real->ViewValue, 109);
            $this->fechaini_real->ViewCustomAttributes = "";

            // fechafinal_real
            $this->fechafinal_real->ViewValue = $this->fechafinal_real->CurrentValue;
            $this->fechafinal_real->ViewValue = FormatDateTime($this->fechafinal_real->ViewValue, 109);
            $this->fechafinal_real->ViewCustomAttributes = "";

            // fechaini_simulado
            $this->fechaini_simulado->ViewValue = $this->fechaini_simulado->CurrentValue;
            $this->fechaini_simulado->ViewValue = FormatDateTime($this->fechaini_simulado->ViewValue, 109);
            $this->fechaini_simulado->ViewCustomAttributes = "";

            // fechafin_simulado
            $this->fechafin_simulado->ViewValue = $this->fechafin_simulado->CurrentValue;
            $this->fechafin_simulado->ViewValue = FormatDateTime($this->fechafin_simulado->ViewValue, 109);
            $this->fechafin_simulado->ViewCustomAttributes = "";

            // estado
            if (strval($this->estado->CurrentValue) != "") {
                $this->estado->ViewValue = $this->estado->optionCaption($this->estado->CurrentValue);
            } else {
                $this->estado->ViewValue = null;
            }
            $this->estado->ViewCustomAttributes = "";

            // entrar
            $this->entrar->ViewValue = $this->entrar->CurrentValue;
            $this->entrar->ViewCustomAttributes = "";

            // id_escenario
            $this->id_escenario->LinkCustomAttributes = "";
            $this->id_escenario->HrefValue = "";
            $this->id_escenario->TooltipValue = "";

            // icon_escenario
            $this->icon_escenario->LinkCustomAttributes = "";
            $this->icon_escenario->HrefValue = "";
            $this->icon_escenario->TooltipValue = "";

            // fechacreacion_escenario
            $this->fechacreacion_escenario->LinkCustomAttributes = "";
            $this->fechacreacion_escenario->HrefValue = "";
            $this->fechacreacion_escenario->TooltipValue = "";

            // nombre_escenario
            $this->nombre_escenario->LinkCustomAttributes = "";
            $this->nombre_escenario->HrefValue = "";
            $this->nombre_escenario->TooltipValue = "";

            // incidente
            $this->incidente->LinkCustomAttributes = "";
            $this->incidente->HrefValue = "";
            $this->incidente->TooltipValue = "";

            // evento_asociado
            $this->evento_asociado->LinkCustomAttributes = "";
            $this->evento_asociado->HrefValue = "";
            $this->evento_asociado->TooltipValue = "";

            // pais_escenario
            $this->pais_escenario->LinkCustomAttributes = "";
            $this->pais_escenario->HrefValue = "";
            $this->pais_escenario->TooltipValue = "";

            // fechaini_real
            $this->fechaini_real->LinkCustomAttributes = "";
            $this->fechaini_real->HrefValue = "";
            $this->fechaini_real->TooltipValue = "";

            // fechaini_simulado
            $this->fechaini_simulado->LinkCustomAttributes = "";
            $this->fechaini_simulado->HrefValue = "";
            $this->fechaini_simulado->TooltipValue = "";

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";
            $this->estado->TooltipValue = "";

            // entrar
            $this->entrar->LinkCustomAttributes = "";
            $this->entrar->HrefValue = "";
            $this->entrar->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // id_escenario
            $this->id_escenario->EditAttrs["class"] = "form-control";
            $this->id_escenario->EditCustomAttributes = "";
            $this->id_escenario->EditValue = HtmlEncode($this->id_escenario->AdvancedSearch->SearchValue);
            $this->id_escenario->PlaceHolder = RemoveHtml($this->id_escenario->caption());

            // icon_escenario
            $this->icon_escenario->EditAttrs["class"] = "form-control";
            $this->icon_escenario->EditCustomAttributes = "hidden";
            if (!$this->icon_escenario->Raw) {
                $this->icon_escenario->AdvancedSearch->SearchValue = HtmlDecode($this->icon_escenario->AdvancedSearch->SearchValue);
            }
            $this->icon_escenario->EditValue = HtmlEncode($this->icon_escenario->AdvancedSearch->SearchValue);
            $this->icon_escenario->PlaceHolder = RemoveHtml($this->icon_escenario->caption());

            // fechacreacion_escenario
            $this->fechacreacion_escenario->EditAttrs["class"] = "form-control";
            $this->fechacreacion_escenario->EditCustomAttributes = "";
            $this->fechacreacion_escenario->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fechacreacion_escenario->AdvancedSearch->SearchValue, 9), 9));
            $this->fechacreacion_escenario->PlaceHolder = RemoveHtml($this->fechacreacion_escenario->caption());

            // nombre_escenario
            $this->nombre_escenario->EditAttrs["class"] = "form-control";
            $this->nombre_escenario->EditCustomAttributes = "";
            if (!$this->nombre_escenario->Raw) {
                $this->nombre_escenario->AdvancedSearch->SearchValue = HtmlDecode($this->nombre_escenario->AdvancedSearch->SearchValue);
            }
            $this->nombre_escenario->EditValue = HtmlEncode($this->nombre_escenario->AdvancedSearch->SearchValue);
            $this->nombre_escenario->PlaceHolder = RemoveHtml($this->nombre_escenario->caption());

            // incidente
            $this->incidente->EditCustomAttributes = "";
            $this->incidente->PlaceHolder = RemoveHtml($this->incidente->caption());

            // evento_asociado
            $this->evento_asociado->EditAttrs["class"] = "form-control";
            $this->evento_asociado->EditCustomAttributes = "";
            $this->evento_asociado->PlaceHolder = RemoveHtml($this->evento_asociado->caption());

            // pais_escenario
            $this->pais_escenario->EditAttrs["class"] = "form-control";
            $this->pais_escenario->EditCustomAttributes = "";
            $this->pais_escenario->PlaceHolder = RemoveHtml($this->pais_escenario->caption());

            // fechaini_real
            $this->fechaini_real->EditAttrs["class"] = "form-control";
            $this->fechaini_real->EditCustomAttributes = "";
            $this->fechaini_real->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fechaini_real->AdvancedSearch->SearchValue, 109), 109));
            $this->fechaini_real->PlaceHolder = RemoveHtml($this->fechaini_real->caption());

            // fechaini_simulado
            $this->fechaini_simulado->EditAttrs["class"] = "form-control";
            $this->fechaini_simulado->EditCustomAttributes = "";
            $this->fechaini_simulado->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fechaini_simulado->AdvancedSearch->SearchValue, 109), 109));
            $this->fechaini_simulado->PlaceHolder = RemoveHtml($this->fechaini_simulado->caption());

            // estado
            $this->estado->EditCustomAttributes = "";
            $this->estado->EditValue = $this->estado->options(false);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // entrar
            $this->entrar->EditAttrs["class"] = "form-control";
            $this->entrar->EditCustomAttributes = "";
            if (!$this->entrar->Raw) {
                $this->entrar->AdvancedSearch->SearchValue = HtmlDecode($this->entrar->AdvancedSearch->SearchValue);
            }
            $this->entrar->EditValue = HtmlEncode($this->entrar->AdvancedSearch->SearchValue);
            $this->entrar->PlaceHolder = RemoveHtml($this->entrar->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->id_escenario->AdvancedSearch->load();
        $this->icon_escenario->AdvancedSearch->load();
        $this->fechacreacion_escenario->AdvancedSearch->load();
        $this->nombre_escenario->AdvancedSearch->load();
        $this->tipo_evento->AdvancedSearch->load();
        $this->incidente->AdvancedSearch->load();
        $this->evento_asociado->AdvancedSearch->load();
        $this->pais_escenario->AdvancedSearch->load();
        $this->zonahora_escenario->AdvancedSearch->load();
        $this->descripcion_escenario->AdvancedSearch->load();
        $this->fechaini_real->AdvancedSearch->load();
        $this->fechafinal_real->AdvancedSearch->load();
        $this->fechaini_simulado->AdvancedSearch->load();
        $this->fechafin_simulado->AdvancedSearch->load();
        $this->estado->AdvancedSearch->load();
        $this->image_escenario->AdvancedSearch->load();
        $this->entrar->AdvancedSearch->load();
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions("div");
        $this->SearchOptions->TagClassName = "ew-search-option";

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fescenariolistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ResetSearch") . "\" data-caption=\"" . $Language->phrase("ResetSearch") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ResetSearchBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->add($this->SearchOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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
                case "x_tipo_evento":
                    break;
                case "x_incidente":
                    break;
                case "x_evento_asociado":
                    break;
                case "x_pais_escenario":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
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
        //$this->ListOptions->Items["preview"]->Visible = FALSE;
        //$this->ListOptions->Items["detail_grupo"]->Visible = FALSE;
      //  $this->ListOptions->Items["detail_tareas"]->Visible = FALSE;
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
      // $this->OtherOptions["detail"]->Items["detailsadd_grupo"]->Visible = FALSE;
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
