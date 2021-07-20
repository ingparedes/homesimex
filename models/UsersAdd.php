<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class UsersAdd extends Users
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'users';

    // Page object name
    public $PageObjName = "UsersAdd";

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

        // Table object (users)
        if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == PROJECT_NAMESPACE . "users") {
            $GLOBALS["users"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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
                    if ($pageName == "UsersView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

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
        $this->id_users->Visible = false;
        $this->fecha->setVisibility();
        $this->nombres->setVisibility();
        $this->apellidos->setVisibility();
        $this->escenario->setVisibility();
        $this->grupo->setVisibility();
        $this->subgrupo->setVisibility();
        $this->perfil->setVisibility();
        $this->_email->setVisibility();
        $this->telefono->setVisibility();
        $this->pais->setVisibility();
        $this->pw->setVisibility();
        $this->estado->setVisibility();
        $this->horario->Visible = false;
        $this->limite->Visible = false;
        $this->organizacion->setVisibility();
        $this->img_user->setVisibility();
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
        $this->setupLookupOptions($this->escenario);
        $this->setupLookupOptions($this->grupo);
        $this->setupLookupOptions($this->subgrupo);
        $this->setupLookupOptions($this->perfil);
        $this->setupLookupOptions($this->pais);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id_users") ?? Route("id_users")) !== null) {
                $this->id_users->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("UsersList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "UsersList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "UsersView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
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
        $this->organizacion->CurrentValue = null;
        $this->organizacion->OldValue = $this->organizacion->CurrentValue;
        $this->img_user->Upload->DbValue = null;
        $this->img_user->OldValue = $this->img_user->Upload->DbValue;
        $this->img_user->CurrentValue = null; // Clear file related field
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

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

        // Check field name 'nombres' first before field var 'x_nombres'
        $val = $CurrentForm->hasValue("nombres") ? $CurrentForm->getValue("nombres") : $CurrentForm->getValue("x_nombres");
        if (!$this->nombres->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombres->Visible = false; // Disable update for API request
            } else {
                $this->nombres->setFormValue($val);
            }
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

        // Check field name 'escenario' first before field var 'x_escenario'
        $val = $CurrentForm->hasValue("escenario") ? $CurrentForm->getValue("escenario") : $CurrentForm->getValue("x_escenario");
        if (!$this->escenario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->escenario->Visible = false; // Disable update for API request
            } else {
                $this->escenario->setFormValue($val);
            }
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

        // Check field name 'subgrupo' first before field var 'x_subgrupo'
        $val = $CurrentForm->hasValue("subgrupo") ? $CurrentForm->getValue("subgrupo") : $CurrentForm->getValue("x_subgrupo");
        if (!$this->subgrupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->subgrupo->Visible = false; // Disable update for API request
            } else {
                $this->subgrupo->setFormValue($val);
            }
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

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
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

        // Check field name 'pais' first before field var 'x_pais'
        $val = $CurrentForm->hasValue("pais") ? $CurrentForm->getValue("pais") : $CurrentForm->getValue("x_pais");
        if (!$this->pais->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pais->Visible = false; // Disable update for API request
            } else {
                $this->pais->setFormValue($val);
            }
        }

        // Check field name 'pw' first before field var 'x_pw'
        $val = $CurrentForm->hasValue("pw") ? $CurrentForm->getValue("pw") : $CurrentForm->getValue("x_pw");
        if (!$this->pw->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pw->Visible = false; // Disable update for API request
            } else {
                $this->pw->setFormValue($val);
            }
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

        // Check field name 'organizacion' first before field var 'x_organizacion'
        $val = $CurrentForm->hasValue("organizacion") ? $CurrentForm->getValue("organizacion") : $CurrentForm->getValue("x_organizacion");
        if (!$this->organizacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->organizacion->Visible = false; // Disable update for API request
            } else {
                $this->organizacion->setFormValue($val);
            }
        }

        // Check field name 'id_users' first before field var 'x_id_users'
        $val = $CurrentForm->hasValue("id_users") ? $CurrentForm->getValue("id_users") : $CurrentForm->getValue("x_id_users");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->fecha->CurrentValue = $this->fecha->FormValue;
        $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, 5);
        $this->nombres->CurrentValue = $this->nombres->FormValue;
        $this->apellidos->CurrentValue = $this->apellidos->FormValue;
        $this->escenario->CurrentValue = $this->escenario->FormValue;
        $this->grupo->CurrentValue = $this->grupo->FormValue;
        $this->subgrupo->CurrentValue = $this->subgrupo->FormValue;
        $this->perfil->CurrentValue = $this->perfil->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->telefono->CurrentValue = $this->telefono->FormValue;
        $this->pais->CurrentValue = $this->pais->FormValue;
        $this->pw->CurrentValue = $this->pw->FormValue;
        $this->estado->CurrentValue = $this->estado->FormValue;
        $this->organizacion->CurrentValue = $this->organizacion->FormValue;
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
        $this->organizacion->setDbValue($row['organizacion']);
        $this->img_user->Upload->DbValue = $row['img_user'];
        $this->img_user->setDbValue($this->img_user->Upload->DbValue);
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
        $row['organizacion'] = $this->organizacion->CurrentValue;
        $row['img_user'] = $this->img_user->Upload->DbValue;
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

        // organizacion

        // img_user
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
                        return (CurrentUserInfo("perfil") > 1) ? "id_escenario = '".CurrentUserInfo("escenario")."'"  : "";
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

            // organizacion
            $this->organizacion->ViewValue = $this->organizacion->CurrentValue;
            $this->organizacion->ViewCustomAttributes = "";

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

            // escenario
            $this->escenario->LinkCustomAttributes = "";
            $this->escenario->HrefValue = "";
            $this->escenario->TooltipValue = "";

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

            // pw
            $this->pw->LinkCustomAttributes = "";
            $this->pw->HrefValue = "";
            $this->pw->TooltipValue = "";

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";
            $this->estado->TooltipValue = "";

            // organizacion
            $this->organizacion->LinkCustomAttributes = "";
            $this->organizacion->HrefValue = "";
            $this->organizacion->TooltipValue = "";

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
                $this->img_user->LinkAttrs["data-rel"] = "users_x_img_user";
                $this->img_user->LinkAttrs->appendClass("ew-lightbox");
            }
        } elseif ($this->RowType == ROWTYPE_ADD) {
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

            // escenario
            $this->escenario->EditAttrs["class"] = "form-control";
            $this->escenario->EditCustomAttributes = "";
            if ($this->escenario->getSessionValue() != "") {
                $this->escenario->CurrentValue = GetForeignKeyValue($this->escenario->getSessionValue());
                $curVal = trim(strval($this->escenario->CurrentValue));
                if ($curVal != "") {
                    $this->escenario->ViewValue = $this->escenario->lookupCacheOption($curVal);
                    if ($this->escenario->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id_escenario`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $lookupFilter = function() {
                            return (CurrentUserInfo("perfil") > 1) ? "id_escenario = '".CurrentUserInfo("escenario")."'"  : "";
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
            } else {
                $curVal = trim(strval($this->escenario->CurrentValue));
                if ($curVal != "") {
                    $this->escenario->ViewValue = $this->escenario->lookupCacheOption($curVal);
                } else {
                    $this->escenario->ViewValue = $this->escenario->Lookup !== null && is_array($this->escenario->Lookup->Options) ? $curVal : null;
                }
                if ($this->escenario->ViewValue !== null) { // Load from cache
                    $this->escenario->EditValue = array_values($this->escenario->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id_escenario`" . SearchString("=", $this->escenario->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return (CurrentUserInfo("perfil") > 1) ? "id_escenario = '".CurrentUserInfo("escenario")."'"  : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->escenario->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->escenario->EditValue = $arwrk;
                }
                $this->escenario->PlaceHolder = RemoveHtml($this->escenario->caption());
            }

            // grupo
            $this->grupo->EditAttrs["class"] = "form-control";
            $this->grupo->EditCustomAttributes = "";
            if ($this->grupo->getSessionValue() != "") {
                $this->grupo->CurrentValue = GetForeignKeyValue($this->grupo->getSessionValue());
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

            // pw
            $this->pw->EditAttrs["class"] = "form-control";
            $this->pw->EditCustomAttributes = "";
            $this->pw->PlaceHolder = RemoveHtml($this->pw->caption());

            // estado
            $this->estado->EditCustomAttributes = "";
            $this->estado->EditValue = $this->estado->options(false);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // organizacion
            $this->organizacion->EditAttrs["class"] = "form-control";
            $this->organizacion->EditCustomAttributes = "";
            if (!$this->organizacion->Raw) {
                $this->organizacion->CurrentValue = HtmlDecode($this->organizacion->CurrentValue);
            }
            $this->organizacion->EditValue = HtmlEncode($this->organizacion->CurrentValue);
            $this->organizacion->PlaceHolder = RemoveHtml($this->organizacion->caption());

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
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->img_user);
            }

            // Add refer script

            // fecha
            $this->fecha->LinkCustomAttributes = "";
            $this->fecha->HrefValue = "";

            // nombres
            $this->nombres->LinkCustomAttributes = "";
            $this->nombres->HrefValue = "";

            // apellidos
            $this->apellidos->LinkCustomAttributes = "";
            $this->apellidos->HrefValue = "";

            // escenario
            $this->escenario->LinkCustomAttributes = "";
            $this->escenario->HrefValue = "";

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

            // pw
            $this->pw->LinkCustomAttributes = "";
            $this->pw->HrefValue = "";

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";

            // organizacion
            $this->organizacion->LinkCustomAttributes = "";
            $this->organizacion->HrefValue = "";

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
        if ($this->escenario->Required) {
            if (!$this->escenario->IsDetailKey && EmptyValue($this->escenario->FormValue)) {
                $this->escenario->addErrorMessage(str_replace("%s", $this->escenario->caption(), $this->escenario->RequiredErrorMessage));
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
        if ($this->pw->Required) {
            if (!$this->pw->IsDetailKey && EmptyValue($this->pw->FormValue)) {
                $this->pw->addErrorMessage(str_replace("%s", $this->pw->caption(), $this->pw->RequiredErrorMessage));
            }
        }
        if (!$this->pw->Raw && Config("REMOVE_XSS") && CheckPassword($this->pw->FormValue)) {
            $this->pw->addErrorMessage($Language->phrase("InvalidPasswordChars"));
        }
        if ($this->estado->Required) {
            if ($this->estado->FormValue == "") {
                $this->estado->addErrorMessage(str_replace("%s", $this->estado->caption(), $this->estado->RequiredErrorMessage));
            }
        }
        if ($this->organizacion->Required) {
            if (!$this->organizacion->IsDetailKey && EmptyValue($this->organizacion->FormValue)) {
                $this->organizacion->addErrorMessage(str_replace("%s", $this->organizacion->caption(), $this->organizacion->RequiredErrorMessage));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
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

        // escenario
        $this->escenario->setDbValueDef($rsnew, $this->escenario->CurrentValue, null, strval($this->escenario->CurrentValue) == "");

        // grupo
        $this->grupo->setDbValueDef($rsnew, $this->grupo->CurrentValue, null, strval($this->grupo->CurrentValue) == "");

        // subgrupo
        $this->subgrupo->setDbValueDef($rsnew, $this->subgrupo->CurrentValue, null, strval($this->subgrupo->CurrentValue) == "");

        // perfil
        if ($Security->canAdmin()) { // System admin
            $this->perfil->setDbValueDef($rsnew, $this->perfil->CurrentValue, null, strval($this->perfil->CurrentValue) == "");
        }

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, false);

        // telefono
        $this->telefono->setDbValueDef($rsnew, $this->telefono->CurrentValue, null, false);

        // pais
        $this->pais->setDbValueDef($rsnew, $this->pais->CurrentValue, null, false);

        // pw
        if (!IsMaskedPassword($this->pw->CurrentValue)) {
            $this->pw->setDbValueDef($rsnew, $this->pw->CurrentValue, null, false);
        }

        // estado
        $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, null, strval($this->estado->CurrentValue) == "");

        // organizacion
        $this->organizacion->setDbValueDef($rsnew, $this->organizacion->CurrentValue, null, false);

        // img_user
        if ($this->img_user->Visible && !$this->img_user->Upload->KeepFile) {
            $this->img_user->Upload->DbValue = ""; // No need to delete old file
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
            if ($this->SendEmail) {
                $this->sendEmailOnAdd($rsnew);
            }
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
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "subgrupo") {
                $validMaster = true;
                $masterTbl = Container("subgrupo");
                if (($parm = Get("fk_id_subgrupo", Get("subgrupo"))) !== null) {
                    $masterTbl->id_subgrupo->setQueryStringValue($parm);
                    $this->subgrupo->setQueryStringValue($masterTbl->id_subgrupo->QueryStringValue);
                    $this->subgrupo->setSessionValue($this->subgrupo->QueryStringValue);
                    if (!is_numeric($masterTbl->id_subgrupo->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "grupo") {
                $validMaster = true;
                $masterTbl = Container("grupo");
                if (($parm = Get("fk_id_grupo", Get("grupo"))) !== null) {
                    $masterTbl->id_grupo->setQueryStringValue($parm);
                    $this->grupo->setQueryStringValue($masterTbl->id_grupo->QueryStringValue);
                    $this->grupo->setSessionValue($this->grupo->QueryStringValue);
                    if (!is_numeric($masterTbl->id_grupo->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "escenario") {
                $validMaster = true;
                $masterTbl = Container("escenario");
                if (($parm = Get("fk_id_escenario", Get("escenario"))) !== null) {
                    $masterTbl->id_escenario->setQueryStringValue($parm);
                    $this->escenario->setQueryStringValue($masterTbl->id_escenario->QueryStringValue);
                    $this->escenario->setSessionValue($this->escenario->QueryStringValue);
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
            if ($masterTblVar == "subgrupo") {
                $validMaster = true;
                $masterTbl = Container("subgrupo");
                if (($parm = Post("fk_id_subgrupo", Post("subgrupo"))) !== null) {
                    $masterTbl->id_subgrupo->setFormValue($parm);
                    $this->subgrupo->setFormValue($masterTbl->id_subgrupo->FormValue);
                    $this->subgrupo->setSessionValue($this->subgrupo->FormValue);
                    if (!is_numeric($masterTbl->id_subgrupo->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "grupo") {
                $validMaster = true;
                $masterTbl = Container("grupo");
                if (($parm = Post("fk_id_grupo", Post("grupo"))) !== null) {
                    $masterTbl->id_grupo->setFormValue($parm);
                    $this->grupo->setFormValue($masterTbl->id_grupo->FormValue);
                    $this->grupo->setSessionValue($this->grupo->FormValue);
                    if (!is_numeric($masterTbl->id_grupo->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "escenario") {
                $validMaster = true;
                $masterTbl = Container("escenario");
                if (($parm = Post("fk_id_escenario", Post("escenario"))) !== null) {
                    $masterTbl->id_escenario->setFormValue($parm);
                    $this->escenario->setFormValue($masterTbl->id_escenario->FormValue);
                    $this->escenario->setSessionValue($this->escenario->FormValue);
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

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "subgrupo") {
                if ($this->subgrupo->CurrentValue == "") {
                    $this->subgrupo->setSessionValue("");
                }
            }
            if ($masterTblVar != "grupo") {
                if ($this->grupo->CurrentValue == "") {
                    $this->grupo->setSessionValue("");
                }
            }
            if ($masterTblVar != "escenario") {
                if ($this->escenario->CurrentValue == "") {
                    $this->escenario->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("UsersList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                        return (CurrentUserInfo("perfil") > 1) ? "id_escenario = '".CurrentUserInfo("escenario")."'"  : "";
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
