<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class GrupoEdit extends Grupo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'grupo';

    // Page object name
    public $PageObjName = "GrupoEdit";

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

        // Custom template
        $this->UseCustomTemplate = true;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (grupo)
        if (!isset($GLOBALS["grupo"]) || get_class($GLOBALS["grupo"]) == PROJECT_NAMESPACE . "grupo") {
            $GLOBALS["grupo"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'grupo');
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
        if (Post("customexport") === null) {
             // Page Unload event
            if (method_exists($this, "pageUnload")) {
                $this->pageUnload();
            }

            // Global Page Unloaded event (in userfn*.php)
            Page_Unloaded();
        }

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            if (is_array(Session(SESSION_TEMP_IMAGES))) { // Restore temp images
                $TempImages = Session(SESSION_TEMP_IMAGES);
            }
            if (Post("data") !== null) {
                $content = Post("data");
            }
            $ExportFileName = Post("filename", "");
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("grupo"));
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
        if ($this->CustomExport) { // Save temp images array for custom export
            if (is_array($TempImages)) {
                $_SESSION[SESSION_TEMP_IMAGES] = $TempImages;
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
                    if ($pageName == "GrupoView") {
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
            $key .= @$ar['id_grupo'];
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
        $this->id_escenario->Visible = false;
        $this->id_grupo->setVisibility();
        $this->imgen_grupo->setVisibility();
        $this->nombre_grupo->setVisibility();
        $this->descripcion_grupo->setVisibility();
        $this->color->setVisibility();
        $this->color_grup->Visible = false;
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
        $this->setupLookupOptions($this->id_escenario);

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
            if (($keyValue = Get("id_grupo") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_grupo->setQueryStringValue($keyValue);
                $this->id_grupo->setOldValue($this->id_grupo->QueryStringValue);
            } elseif (Post("id_grupo") !== null) {
                $this->id_grupo->setFormValue(Post("id_grupo"));
                $this->id_grupo->setOldValue($this->id_grupo->FormValue);
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
                if (($keyValue = Get("id_grupo") ?? Route("id_grupo")) !== null) {
                    $this->id_grupo->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_grupo->CurrentValue = null;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

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

            // Set up detail parameters
            $this->setupDetailParms();
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
                    $this->terminate("GrupoList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "GrupoList") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->imgen_grupo->Upload->Index = $CurrentForm->Index;
        $this->imgen_grupo->Upload->uploadFile();
        $this->imgen_grupo->CurrentValue = $this->imgen_grupo->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_grupo' first before field var 'x_id_grupo'
        $val = $CurrentForm->hasValue("id_grupo") ? $CurrentForm->getValue("id_grupo") : $CurrentForm->getValue("x_id_grupo");
        if (!$this->id_grupo->IsDetailKey) {
            $this->id_grupo->setFormValue($val);
        }

        // Check field name 'nombre_grupo' first before field var 'x_nombre_grupo'
        $val = $CurrentForm->hasValue("nombre_grupo") ? $CurrentForm->getValue("nombre_grupo") : $CurrentForm->getValue("x_nombre_grupo");
        if (!$this->nombre_grupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_grupo->Visible = false; // Disable update for API request
            } else {
                $this->nombre_grupo->setFormValue($val);
            }
        }

        // Check field name 'descripcion_grupo' first before field var 'x_descripcion_grupo'
        $val = $CurrentForm->hasValue("descripcion_grupo") ? $CurrentForm->getValue("descripcion_grupo") : $CurrentForm->getValue("x_descripcion_grupo");
        if (!$this->descripcion_grupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descripcion_grupo->Visible = false; // Disable update for API request
            } else {
                $this->descripcion_grupo->setFormValue($val);
            }
        }

        // Check field name 'color' first before field var 'x_color'
        $val = $CurrentForm->hasValue("color") ? $CurrentForm->getValue("color") : $CurrentForm->getValue("x_color");
        if (!$this->color->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->color->Visible = false; // Disable update for API request
            } else {
                $this->color->setFormValue($val);
            }
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_grupo->CurrentValue = $this->id_grupo->FormValue;
        $this->nombre_grupo->CurrentValue = $this->nombre_grupo->FormValue;
        $this->descripcion_grupo->CurrentValue = $this->descripcion_grupo->FormValue;
        $this->color->CurrentValue = $this->color->FormValue;
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
        $this->id_grupo->setDbValue($row['id_grupo']);
        $this->imgen_grupo->Upload->DbValue = $row['imgen_grupo'];
        $this->imgen_grupo->setDbValue($this->imgen_grupo->Upload->DbValue);
        $this->nombre_grupo->setDbValue($row['nombre_grupo']);
        $this->descripcion_grupo->setDbValue($row['descripcion_grupo']);
        $this->color->setDbValue($row['color']);
        $this->color_grup->setDbValue($row['color_grup']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_escenario'] = null;
        $row['id_grupo'] = null;
        $row['imgen_grupo'] = null;
        $row['nombre_grupo'] = null;
        $row['descripcion_grupo'] = null;
        $row['color'] = null;
        $row['color_grup'] = null;
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

        // id_escenario

        // id_grupo

        // imgen_grupo

        // nombre_grupo

        // descripcion_grupo

        // color

        // color_grup
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_escenario
            $curVal = trim(strval($this->id_escenario->CurrentValue));
            if ($curVal != "") {
                $this->id_escenario->ViewValue = $this->id_escenario->lookupCacheOption($curVal);
                if ($this->id_escenario->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_users`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->id_escenario->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->id_escenario->Lookup->renderViewRow($rswrk[0]);
                        $this->id_escenario->ViewValue = $this->id_escenario->displayValue($arwrk);
                    } else {
                        $this->id_escenario->ViewValue = $this->id_escenario->CurrentValue;
                    }
                }
            } else {
                $this->id_escenario->ViewValue = null;
            }
            $this->id_escenario->ViewCustomAttributes = "";

            // id_grupo
            $this->id_grupo->ViewValue = $this->id_grupo->CurrentValue;
            $this->id_grupo->ViewCustomAttributes = "mr-3 rounded-circle";

            // imgen_grupo
            if (!EmptyValue($this->imgen_grupo->Upload->DbValue)) {
                $this->imgen_grupo->ImageWidth = 50;
                $this->imgen_grupo->ImageHeight = 50;
                $this->imgen_grupo->ImageAlt = $this->imgen_grupo->alt();
                $this->imgen_grupo->ViewValue = $this->imgen_grupo->Upload->DbValue;
            } else {
                $this->imgen_grupo->ViewValue = "";
            }
            $this->imgen_grupo->ViewCustomAttributes = "";

            // nombre_grupo
            $this->nombre_grupo->ViewValue = $this->nombre_grupo->CurrentValue;
            $this->nombre_grupo->ViewCustomAttributes = "";

            // descripcion_grupo
            $this->descripcion_grupo->ViewValue = $this->descripcion_grupo->CurrentValue;
            $this->descripcion_grupo->ViewCustomAttributes = "";

            // color
            $this->color->ViewValue = $this->color->CurrentValue;
            $this->color->ViewCustomAttributes = "";

            // id_grupo
            $this->id_grupo->LinkCustomAttributes = "";
            $this->id_grupo->HrefValue = "";
            $this->id_grupo->TooltipValue = "";

            // imgen_grupo
            $this->imgen_grupo->LinkCustomAttributes = "";
            if (!EmptyValue($this->imgen_grupo->Upload->DbValue)) {
                $this->imgen_grupo->HrefValue = GetFileUploadUrl($this->imgen_grupo, $this->imgen_grupo->htmlDecode($this->imgen_grupo->Upload->DbValue)); // Add prefix/suffix
                $this->imgen_grupo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->imgen_grupo->HrefValue = FullUrl($this->imgen_grupo->HrefValue, "href");
                }
            } else {
                $this->imgen_grupo->HrefValue = "";
            }
            $this->imgen_grupo->ExportHrefValue = $this->imgen_grupo->UploadPath . $this->imgen_grupo->Upload->DbValue;
            $this->imgen_grupo->TooltipValue = "";
            if ($this->imgen_grupo->UseColorbox) {
                if (EmptyValue($this->imgen_grupo->TooltipValue)) {
                    $this->imgen_grupo->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->imgen_grupo->LinkAttrs["data-rel"] = "grupo_x_imgen_grupo";
                $this->imgen_grupo->LinkAttrs->appendClass("ew-lightbox");
            }

            // nombre_grupo
            $this->nombre_grupo->LinkCustomAttributes = "";
            $this->nombre_grupo->HrefValue = "";
            $this->nombre_grupo->TooltipValue = "";

            // descripcion_grupo
            $this->descripcion_grupo->LinkCustomAttributes = "";
            $this->descripcion_grupo->HrefValue = "";
            $this->descripcion_grupo->TooltipValue = "";

            // color
            $this->color->LinkCustomAttributes = "";
            $this->color->HrefValue = "";
            $this->color->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id_grupo
            $this->id_grupo->EditAttrs["class"] = "form-control";
            $this->id_grupo->EditCustomAttributes = "";
            $this->id_grupo->EditValue = $this->id_grupo->CurrentValue;
            $this->id_grupo->ViewCustomAttributes = "mr-3 rounded-circle";

            // imgen_grupo
            $this->imgen_grupo->EditAttrs["class"] = "form-control";
            $this->imgen_grupo->EditCustomAttributes = "";
            if (!EmptyValue($this->imgen_grupo->Upload->DbValue)) {
                $this->imgen_grupo->ImageWidth = 50;
                $this->imgen_grupo->ImageHeight = 50;
                $this->imgen_grupo->ImageAlt = $this->imgen_grupo->alt();
                $this->imgen_grupo->EditValue = $this->imgen_grupo->Upload->DbValue;
            } else {
                $this->imgen_grupo->EditValue = "";
            }
            if (!EmptyValue($this->imgen_grupo->CurrentValue)) {
                $this->imgen_grupo->Upload->FileName = $this->imgen_grupo->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->imgen_grupo);
            }

            // nombre_grupo
            $this->nombre_grupo->EditAttrs["class"] = "form-control";
            $this->nombre_grupo->EditCustomAttributes = "";
            if (!$this->nombre_grupo->Raw) {
                $this->nombre_grupo->CurrentValue = HtmlDecode($this->nombre_grupo->CurrentValue);
            }
            $this->nombre_grupo->EditValue = HtmlEncode($this->nombre_grupo->CurrentValue);
            $this->nombre_grupo->PlaceHolder = RemoveHtml($this->nombre_grupo->caption());

            // descripcion_grupo
            $this->descripcion_grupo->EditAttrs["class"] = "form-control";
            $this->descripcion_grupo->EditCustomAttributes = "";
            if (!$this->descripcion_grupo->Raw) {
                $this->descripcion_grupo->CurrentValue = HtmlDecode($this->descripcion_grupo->CurrentValue);
            }
            $this->descripcion_grupo->EditValue = HtmlEncode($this->descripcion_grupo->CurrentValue);
            $this->descripcion_grupo->PlaceHolder = RemoveHtml($this->descripcion_grupo->caption());

            // color
            $this->color->EditAttrs["class"] = "form-control";
            $this->color->EditCustomAttributes = "hiden";

            // Edit refer script

            // id_grupo
            $this->id_grupo->LinkCustomAttributes = "";
            $this->id_grupo->HrefValue = "";

            // imgen_grupo
            $this->imgen_grupo->LinkCustomAttributes = "";
            if (!EmptyValue($this->imgen_grupo->Upload->DbValue)) {
                $this->imgen_grupo->HrefValue = GetFileUploadUrl($this->imgen_grupo, $this->imgen_grupo->htmlDecode($this->imgen_grupo->Upload->DbValue)); // Add prefix/suffix
                $this->imgen_grupo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->imgen_grupo->HrefValue = FullUrl($this->imgen_grupo->HrefValue, "href");
                }
            } else {
                $this->imgen_grupo->HrefValue = "";
            }
            $this->imgen_grupo->ExportHrefValue = $this->imgen_grupo->UploadPath . $this->imgen_grupo->Upload->DbValue;

            // nombre_grupo
            $this->nombre_grupo->LinkCustomAttributes = "";
            $this->nombre_grupo->HrefValue = "";

            // descripcion_grupo
            $this->descripcion_grupo->LinkCustomAttributes = "";
            $this->descripcion_grupo->HrefValue = "";

            // color
            $this->color->LinkCustomAttributes = "";
            $this->color->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }

        // Save data for Custom Template
        if ($this->RowType == ROWTYPE_VIEW || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_ADD) {
            $this->Rows[] = $this->customTemplateFieldValues();
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
        if ($this->id_grupo->Required) {
            if (!$this->id_grupo->IsDetailKey && EmptyValue($this->id_grupo->FormValue)) {
                $this->id_grupo->addErrorMessage(str_replace("%s", $this->id_grupo->caption(), $this->id_grupo->RequiredErrorMessage));
            }
        }
        if ($this->imgen_grupo->Required) {
            if ($this->imgen_grupo->Upload->FileName == "" && !$this->imgen_grupo->Upload->KeepFile) {
                $this->imgen_grupo->addErrorMessage(str_replace("%s", $this->imgen_grupo->caption(), $this->imgen_grupo->RequiredErrorMessage));
            }
        }
        if ($this->nombre_grupo->Required) {
            if (!$this->nombre_grupo->IsDetailKey && EmptyValue($this->nombre_grupo->FormValue)) {
                $this->nombre_grupo->addErrorMessage(str_replace("%s", $this->nombre_grupo->caption(), $this->nombre_grupo->RequiredErrorMessage));
            }
        }
        if ($this->descripcion_grupo->Required) {
            if (!$this->descripcion_grupo->IsDetailKey && EmptyValue($this->descripcion_grupo->FormValue)) {
                $this->descripcion_grupo->addErrorMessage(str_replace("%s", $this->descripcion_grupo->caption(), $this->descripcion_grupo->RequiredErrorMessage));
            }
        }
        if ($this->color->Required) {
            if (!$this->color->IsDetailKey && EmptyValue($this->color->FormValue)) {
                $this->color->addErrorMessage(str_replace("%s", $this->color->caption(), $this->color->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("SubgrupoGrid");
        if (in_array("subgrupo", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("UsersGrid");
        if (in_array("users", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
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
            // Begin transaction
            if ($this->getCurrentDetailTable() != "") {
                $conn->beginTransaction();
            }

            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // imgen_grupo
            if ($this->imgen_grupo->Visible && !$this->imgen_grupo->ReadOnly && !$this->imgen_grupo->Upload->KeepFile) {
                $this->imgen_grupo->Upload->DbValue = $rsold['imgen_grupo']; // Get original value
                if ($this->imgen_grupo->Upload->FileName == "") {
                    $rsnew['imgen_grupo'] = null;
                } else {
                    $rsnew['imgen_grupo'] = $this->imgen_grupo->Upload->FileName;
                }
                $this->imgen_grupo->ImageWidth = 10; // Resize width
                $this->imgen_grupo->ImageHeight = 10; // Resize height
            }

            // nombre_grupo
            $this->nombre_grupo->setDbValueDef($rsnew, $this->nombre_grupo->CurrentValue, null, $this->nombre_grupo->ReadOnly);

            // descripcion_grupo
            $this->descripcion_grupo->setDbValueDef($rsnew, $this->descripcion_grupo->CurrentValue, null, $this->descripcion_grupo->ReadOnly);

            // color
            $this->color->setDbValueDef($rsnew, $this->color->CurrentValue, null, $this->color->ReadOnly);

            // Check referential integrity for master table 'escenario'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_escenario();
            $keyValue = $rsnew['id_escenario'] ?? $rsold['id_escenario'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@id_escenario@", AdjustSql($keyValue), $masterFilter);
            } else {
                $validMasterRecord = false;
            }
            if ($validMasterRecord) {
                $rsmaster = Container("escenario")->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "escenario", $Language->phrase("RelatedRecordRequired"));
                $this->setFailureMessage($relatedRecordMsg);
                return false;
            }
            if ($this->imgen_grupo->Visible && !$this->imgen_grupo->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->imgen_grupo->Upload->DbValue) ? [] : [$this->imgen_grupo->htmlDecode($this->imgen_grupo->Upload->DbValue)];
                if (!EmptyValue($this->imgen_grupo->Upload->FileName)) {
                    $newFiles = [$this->imgen_grupo->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->imgen_grupo, $this->imgen_grupo->Upload->Index);
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
                                $file1 = UniqueFilename($this->imgen_grupo->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->imgen_grupo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->imgen_grupo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->imgen_grupo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->imgen_grupo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->imgen_grupo->setDbValueDef($rsnew, $this->imgen_grupo->Upload->FileName, null, $this->imgen_grupo->ReadOnly);
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
                    if ($this->imgen_grupo->Visible && !$this->imgen_grupo->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->imgen_grupo->Upload->DbValue) ? [] : [$this->imgen_grupo->htmlDecode($this->imgen_grupo->Upload->DbValue)];
                        if (!EmptyValue($this->imgen_grupo->Upload->FileName)) {
                            $newFiles = [$this->imgen_grupo->Upload->FileName];
                            $newFiles2 = [$this->imgen_grupo->htmlDecode($rsnew['imgen_grupo'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->imgen_grupo, $this->imgen_grupo->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->imgen_grupo->Upload->ResizeAndSaveToFile($this->imgen_grupo->ImageWidth, $this->imgen_grupo->ImageHeight, 100, $newFiles[$i], true, $i)) {
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
                                    @unlink($this->imgen_grupo->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("SubgrupoGrid");
                    if (in_array("subgrupo", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "subgrupo"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("UsersGrid");
                    if (in_array("users", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "users"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }

                // Commit/Rollback transaction
                if ($this->getCurrentDetailTable() != "") {
                    if ($editRow) {
                        $conn->commit(); // Commit transaction
                    } else {
                        $conn->rollback(); // Rollback transaction
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
            // imgen_grupo
            CleanUploadTempPath($this->imgen_grupo, $this->imgen_grupo->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "escenario") {
                $validMaster = true;
                $masterTbl = Container("escenario");
                if (($parm = Get("fk_id_escenario", Get("id_escenario"))) !== null) {
                    $masterTbl->id_escenario->setQueryStringValue($parm);
                    $this->id_escenario->setQueryStringValue($masterTbl->id_escenario->QueryStringValue);
                    $this->id_escenario->setSessionValue($this->id_escenario->QueryStringValue);
                    if (!is_numeric($masterTbl->id_escenario->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "escenario") {
                $validMaster = true;
                $masterTbl = Container("escenario");
                if (($parm = Post("fk_id_escenario", Post("id_escenario"))) !== null) {
                    $masterTbl->id_escenario->setFormValue($parm);
                    $this->id_escenario->setFormValue($masterTbl->id_escenario->FormValue);
                    $this->id_escenario->setSessionValue($this->id_escenario->FormValue);
                    if (!is_numeric($masterTbl->id_escenario->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);
            $this->setSessionWhere($this->getDetailFilter());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "escenario") {
                if ($this->id_escenario->CurrentValue == "") {
                    $this->id_escenario->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("subgrupo", $detailTblVar)) {
                $detailPageObj = Container("SubgrupoGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->id_grupo->IsDetailKey = true;
                    $detailPageObj->id_grupo->CurrentValue = $this->id_grupo->CurrentValue;
                    $detailPageObj->id_grupo->setSessionValue($detailPageObj->id_grupo->CurrentValue);
                }
            }
            if (in_array("users", $detailTblVar)) {
                $detailPageObj = Container("UsersGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->grupo->IsDetailKey = true;
                    $detailPageObj->grupo->CurrentValue = $this->id_grupo->CurrentValue;
                    $detailPageObj->grupo->setSessionValue($detailPageObj->grupo->CurrentValue);
                    $detailPageObj->subgrupo->setSessionValue(""); // Clear session key
                    $detailPageObj->escenario->setSessionValue(""); // Clear session key
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("GrupoList"), "", $this->TableVar, true);
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
                case "x_id_escenario":
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
}
