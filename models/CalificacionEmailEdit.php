<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class CalificacionEmailEdit extends CalificacionEmail
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'calificacion_email';

    // Page object name
    public $PageObjName = "CalificacionEmailEdit";

    // Rendering View
    public $RenderingView = false;

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

        // Table object (calificacion_email)
        if (!isset($GLOBALS["calificacion_email"]) || get_class($GLOBALS["calificacion_email"]) == PROJECT_NAMESPACE . "calificacion_email") {
            $GLOBALS["calificacion_email"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'calificacion_email');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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
                $doc = new $class(Container("calificacion_email"));
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "CalificacionEmailView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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
            $key .= @$ar['id_calificacion_email'];
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
            $this->id_calificacion_email->Visible = false;
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id_calificacion_email->setVisibility();
        $this->id_calificacion->setVisibility();
        $this->id_user_email->setVisibility();
        $this->comentario->setVisibility();
        $this->create_at->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id_calificacion_email") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_calificacion_email->setQueryStringValue($keyValue);
                $this->id_calificacion_email->setOldValue($this->id_calificacion_email->QueryStringValue);
            } elseif (Post("id_calificacion_email") !== null) {
                $this->id_calificacion_email->setFormValue(Post("id_calificacion_email"));
                $this->id_calificacion_email->setOldValue($this->id_calificacion_email->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id_calificacion_email") ?? Route("id_calificacion_email")) !== null) {
                    $this->id_calificacion_email->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_calificacion_email->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("CalificacionEmailList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "CalificacionEmailList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_calificacion_email' first before field var 'x_id_calificacion_email'
        $val = $CurrentForm->hasValue("id_calificacion_email") ? $CurrentForm->getValue("id_calificacion_email") : $CurrentForm->getValue("x_id_calificacion_email");
        if (!$this->id_calificacion_email->IsDetailKey) {
            $this->id_calificacion_email->setFormValue($val);
        }

        // Check field name 'id_calificacion' first before field var 'x_id_calificacion'
        $val = $CurrentForm->hasValue("id_calificacion") ? $CurrentForm->getValue("id_calificacion") : $CurrentForm->getValue("x_id_calificacion");
        if (!$this->id_calificacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_calificacion->Visible = false; // Disable update for API request
            } else {
                $this->id_calificacion->setFormValue($val);
            }
        }

        // Check field name 'id_user_email' first before field var 'x_id_user_email'
        $val = $CurrentForm->hasValue("id_user_email") ? $CurrentForm->getValue("id_user_email") : $CurrentForm->getValue("x_id_user_email");
        if (!$this->id_user_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_user_email->Visible = false; // Disable update for API request
            } else {
                $this->id_user_email->setFormValue($val);
            }
        }

        // Check field name 'comentario' first before field var 'x_comentario'
        $val = $CurrentForm->hasValue("comentario") ? $CurrentForm->getValue("comentario") : $CurrentForm->getValue("x_comentario");
        if (!$this->comentario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->comentario->Visible = false; // Disable update for API request
            } else {
                $this->comentario->setFormValue($val);
            }
        }

        // Check field name 'create_at' first before field var 'x_create_at'
        $val = $CurrentForm->hasValue("create_at") ? $CurrentForm->getValue("create_at") : $CurrentForm->getValue("x_create_at");
        if (!$this->create_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->create_at->Visible = false; // Disable update for API request
            } else {
                $this->create_at->setFormValue($val);
            }
            $this->create_at->CurrentValue = UnFormatDateTime($this->create_at->CurrentValue, 0);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_calificacion_email->CurrentValue = $this->id_calificacion_email->FormValue;
        $this->id_calificacion->CurrentValue = $this->id_calificacion->FormValue;
        $this->id_user_email->CurrentValue = $this->id_user_email->FormValue;
        $this->comentario->CurrentValue = $this->comentario->FormValue;
        $this->create_at->CurrentValue = $this->create_at->FormValue;
        $this->create_at->CurrentValue = UnFormatDateTime($this->create_at->CurrentValue, 0);
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
        $this->id_calificacion_email->setDbValue($row['id_calificacion_email']);
        $this->id_calificacion->setDbValue($row['id_calificacion']);
        $this->id_user_email->setDbValue($row['id_user_email']);
        $this->comentario->setDbValue($row['comentario']);
        $this->create_at->setDbValue($row['create_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_calificacion_email'] = null;
        $row['id_calificacion'] = null;
        $row['id_user_email'] = null;
        $row['comentario'] = null;
        $row['create_at'] = null;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id_calificacion_email

        // id_calificacion

        // id_user_email

        // comentario

        // create_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_calificacion_email
            $this->id_calificacion_email->ViewValue = $this->id_calificacion_email->CurrentValue;
            $this->id_calificacion_email->ViewCustomAttributes = "";

            // id_calificacion
            $this->id_calificacion->ViewValue = $this->id_calificacion->CurrentValue;
            $this->id_calificacion->ViewValue = FormatNumber($this->id_calificacion->ViewValue, 0, -2, -2, -2);
            $this->id_calificacion->ViewCustomAttributes = "";

            // id_user_email
            $this->id_user_email->ViewValue = $this->id_user_email->CurrentValue;
            $this->id_user_email->ViewValue = FormatNumber($this->id_user_email->ViewValue, 0, -2, -2, -2);
            $this->id_user_email->ViewCustomAttributes = "";

            // comentario
            $this->comentario->ViewValue = $this->comentario->CurrentValue;
            $this->comentario->ViewCustomAttributes = "";

            // create_at
            $this->create_at->ViewValue = $this->create_at->CurrentValue;
            $this->create_at->ViewValue = FormatDateTime($this->create_at->ViewValue, 0);
            $this->create_at->ViewCustomAttributes = "";

            // id_calificacion_email
            $this->id_calificacion_email->LinkCustomAttributes = "";
            $this->id_calificacion_email->HrefValue = "";
            $this->id_calificacion_email->TooltipValue = "";

            // id_calificacion
            $this->id_calificacion->LinkCustomAttributes = "";
            $this->id_calificacion->HrefValue = "";
            $this->id_calificacion->TooltipValue = "";

            // id_user_email
            $this->id_user_email->LinkCustomAttributes = "";
            $this->id_user_email->HrefValue = "";
            $this->id_user_email->TooltipValue = "";

            // comentario
            $this->comentario->LinkCustomAttributes = "";
            $this->comentario->HrefValue = "";
            $this->comentario->TooltipValue = "";

            // create_at
            $this->create_at->LinkCustomAttributes = "";
            $this->create_at->HrefValue = "";
            $this->create_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id_calificacion_email
            $this->id_calificacion_email->EditAttrs["class"] = "form-control";
            $this->id_calificacion_email->EditCustomAttributes = "";
            $this->id_calificacion_email->EditValue = $this->id_calificacion_email->CurrentValue;
            $this->id_calificacion_email->ViewCustomAttributes = "";

            // id_calificacion
            $this->id_calificacion->EditAttrs["class"] = "form-control";
            $this->id_calificacion->EditCustomAttributes = "";
            $this->id_calificacion->EditValue = HtmlEncode($this->id_calificacion->CurrentValue);
            $this->id_calificacion->PlaceHolder = RemoveHtml($this->id_calificacion->caption());

            // id_user_email
            $this->id_user_email->EditAttrs["class"] = "form-control";
            $this->id_user_email->EditCustomAttributes = "";
            $this->id_user_email->EditValue = HtmlEncode($this->id_user_email->CurrentValue);
            $this->id_user_email->PlaceHolder = RemoveHtml($this->id_user_email->caption());

            // comentario
            $this->comentario->EditAttrs["class"] = "form-control";
            $this->comentario->EditCustomAttributes = "";
            $this->comentario->EditValue = HtmlEncode($this->comentario->CurrentValue);
            $this->comentario->PlaceHolder = RemoveHtml($this->comentario->caption());

            // create_at
            $this->create_at->EditAttrs["class"] = "form-control";
            $this->create_at->EditCustomAttributes = "";
            $this->create_at->EditValue = HtmlEncode(FormatDateTime($this->create_at->CurrentValue, 8));
            $this->create_at->PlaceHolder = RemoveHtml($this->create_at->caption());

            // Edit refer script

            // id_calificacion_email
            $this->id_calificacion_email->LinkCustomAttributes = "";
            $this->id_calificacion_email->HrefValue = "";

            // id_calificacion
            $this->id_calificacion->LinkCustomAttributes = "";
            $this->id_calificacion->HrefValue = "";

            // id_user_email
            $this->id_user_email->LinkCustomAttributes = "";
            $this->id_user_email->HrefValue = "";

            // comentario
            $this->comentario->LinkCustomAttributes = "";
            $this->comentario->HrefValue = "";

            // create_at
            $this->create_at->LinkCustomAttributes = "";
            $this->create_at->HrefValue = "";
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
        if ($this->id_calificacion_email->Required) {
            if (!$this->id_calificacion_email->IsDetailKey && EmptyValue($this->id_calificacion_email->FormValue)) {
                $this->id_calificacion_email->addErrorMessage(str_replace("%s", $this->id_calificacion_email->caption(), $this->id_calificacion_email->RequiredErrorMessage));
            }
        }
        if ($this->id_calificacion->Required) {
            if (!$this->id_calificacion->IsDetailKey && EmptyValue($this->id_calificacion->FormValue)) {
                $this->id_calificacion->addErrorMessage(str_replace("%s", $this->id_calificacion->caption(), $this->id_calificacion->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id_calificacion->FormValue)) {
            $this->id_calificacion->addErrorMessage($this->id_calificacion->getErrorMessage(false));
        }
        if ($this->id_user_email->Required) {
            if (!$this->id_user_email->IsDetailKey && EmptyValue($this->id_user_email->FormValue)) {
                $this->id_user_email->addErrorMessage(str_replace("%s", $this->id_user_email->caption(), $this->id_user_email->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id_user_email->FormValue)) {
            $this->id_user_email->addErrorMessage($this->id_user_email->getErrorMessage(false));
        }
        if ($this->comentario->Required) {
            if (!$this->comentario->IsDetailKey && EmptyValue($this->comentario->FormValue)) {
                $this->comentario->addErrorMessage(str_replace("%s", $this->comentario->caption(), $this->comentario->RequiredErrorMessage));
            }
        }
        if ($this->create_at->Required) {
            if (!$this->create_at->IsDetailKey && EmptyValue($this->create_at->FormValue)) {
                $this->create_at->addErrorMessage(str_replace("%s", $this->create_at->caption(), $this->create_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->create_at->FormValue)) {
            $this->create_at->addErrorMessage($this->create_at->getErrorMessage(false));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
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

            // id_calificacion
            $this->id_calificacion->setDbValueDef($rsnew, $this->id_calificacion->CurrentValue, null, $this->id_calificacion->ReadOnly);

            // id_user_email
            $this->id_user_email->setDbValueDef($rsnew, $this->id_user_email->CurrentValue, null, $this->id_user_email->ReadOnly);

            // comentario
            $this->comentario->setDbValueDef($rsnew, $this->comentario->CurrentValue, null, $this->comentario->ReadOnly);

            // create_at
            $this->create_at->setDbValueDef($rsnew, UnFormatDateTime($this->create_at->CurrentValue, 0), null, $this->create_at->ReadOnly);

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
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("CalificacionEmailList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
}
