<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MensajesAdd extends Mensajes
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'mensajes';

    // Page object name
    public $PageObjName = "MensajesAdd";

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

        // Table object (mensajes)
        if (!isset($GLOBALS["mensajes"]) || get_class($GLOBALS["mensajes"]) == PROJECT_NAMESPACE . "mensajes") {
            $GLOBALS["mensajes"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'mensajes');
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
                $doc = new $class(Container("mensajes"));
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
                    if ($pageName == "MensajesView") {
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
            $key .= @$ar['id_inyect'];
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
        $this->id_inyect->Visible = false;
        $this->id_tarea->setVisibility();
        $this->titulo->setVisibility();
        $this->mensaje->setVisibility();
        $this->fechareal_start->setVisibility();
        $this->fechasim_start->setVisibility();
        $this->medios->setVisibility();
        $this->actividad_esperada->setVisibility();
        $this->id_actor->setVisibility();
        $this->enviado->Visible = false;
        $this->para->setVisibility();
        $this->adjunto->setVisibility();
        $this->dif_horaria->Visible = false;
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
        $this->setupLookupOptions($this->id_tarea);
        $this->setupLookupOptions($this->id_actor);
        $this->setupLookupOptions($this->para);
        $this->setupLookupOptions($this->adjunto);

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
            if (($keyValue = Get("id_inyect") ?? Route("id_inyect")) !== null) {
                $this->id_inyect->setQueryStringValue($keyValue);
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

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("MensajesList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = "MensajesList";
                    if (GetPageName($returnUrl) == "MensajesList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "MensajesView") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id_inyect->CurrentValue = null;
        $this->id_inyect->OldValue = $this->id_inyect->CurrentValue;
        $this->id_tarea->CurrentValue = null;
        $this->id_tarea->OldValue = $this->id_tarea->CurrentValue;
        $this->titulo->CurrentValue = null;
        $this->titulo->OldValue = $this->titulo->CurrentValue;
        $this->mensaje->CurrentValue = null;
        $this->mensaje->OldValue = $this->mensaje->CurrentValue;
        $this->fechareal_start->CurrentValue = null;
        $this->fechareal_start->OldValue = $this->fechareal_start->CurrentValue;
        $this->fechasim_start->CurrentValue = null;
        $this->fechasim_start->OldValue = $this->fechasim_start->CurrentValue;
        $this->medios->CurrentValue = null;
        $this->medios->OldValue = $this->medios->CurrentValue;
        $this->actividad_esperada->CurrentValue = null;
        $this->actividad_esperada->OldValue = $this->actividad_esperada->CurrentValue;
        $this->id_actor->CurrentValue = null;
        $this->id_actor->OldValue = $this->id_actor->CurrentValue;
        $this->enviado->CurrentValue = null;
        $this->enviado->OldValue = $this->enviado->CurrentValue;
        $this->para->CurrentValue = null;
        $this->para->OldValue = $this->para->CurrentValue;
        $this->adjunto->CurrentValue = null;
        $this->adjunto->OldValue = $this->adjunto->CurrentValue;
        $this->dif_horaria->CurrentValue = 0;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_tarea' first before field var 'x_id_tarea'
        $val = $CurrentForm->hasValue("id_tarea") ? $CurrentForm->getValue("id_tarea") : $CurrentForm->getValue("x_id_tarea");
        if (!$this->id_tarea->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_tarea->Visible = false; // Disable update for API request
            } else {
                $this->id_tarea->setFormValue($val);
            }
        }

        // Check field name 'titulo' first before field var 'x_titulo'
        $val = $CurrentForm->hasValue("titulo") ? $CurrentForm->getValue("titulo") : $CurrentForm->getValue("x_titulo");
        if (!$this->titulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titulo->Visible = false; // Disable update for API request
            } else {
                $this->titulo->setFormValue($val);
            }
        }

        // Check field name 'mensaje' first before field var 'x_mensaje'
        $val = $CurrentForm->hasValue("mensaje") ? $CurrentForm->getValue("mensaje") : $CurrentForm->getValue("x_mensaje");
        if (!$this->mensaje->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mensaje->Visible = false; // Disable update for API request
            } else {
                $this->mensaje->setFormValue($val);
            }
        }

        // Check field name 'fechareal_start' first before field var 'x_fechareal_start'
        $val = $CurrentForm->hasValue("fechareal_start") ? $CurrentForm->getValue("fechareal_start") : $CurrentForm->getValue("x_fechareal_start");
        if (!$this->fechareal_start->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechareal_start->Visible = false; // Disable update for API request
            } else {
                $this->fechareal_start->setFormValue($val);
            }
            $this->fechareal_start->CurrentValue = UnFormatDateTime($this->fechareal_start->CurrentValue, 109);
        }

        // Check field name 'fechasim_start' first before field var 'x_fechasim_start'
        $val = $CurrentForm->hasValue("fechasim_start") ? $CurrentForm->getValue("fechasim_start") : $CurrentForm->getValue("x_fechasim_start");
        if (!$this->fechasim_start->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechasim_start->Visible = false; // Disable update for API request
            } else {
                $this->fechasim_start->setFormValue($val);
            }
            $this->fechasim_start->CurrentValue = UnFormatDateTime($this->fechasim_start->CurrentValue, 109);
        }

        // Check field name 'medios' first before field var 'x_medios'
        $val = $CurrentForm->hasValue("medios") ? $CurrentForm->getValue("medios") : $CurrentForm->getValue("x_medios");
        if (!$this->medios->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->medios->Visible = false; // Disable update for API request
            } else {
                $this->medios->setFormValue($val);
            }
        }

        // Check field name 'actividad_esperada' first before field var 'x_actividad_esperada'
        $val = $CurrentForm->hasValue("actividad_esperada") ? $CurrentForm->getValue("actividad_esperada") : $CurrentForm->getValue("x_actividad_esperada");
        if (!$this->actividad_esperada->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->actividad_esperada->Visible = false; // Disable update for API request
            } else {
                $this->actividad_esperada->setFormValue($val);
            }
        }

        // Check field name 'id_actor' first before field var 'x_id_actor'
        $val = $CurrentForm->hasValue("id_actor") ? $CurrentForm->getValue("id_actor") : $CurrentForm->getValue("x_id_actor");
        if (!$this->id_actor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_actor->Visible = false; // Disable update for API request
            } else {
                $this->id_actor->setFormValue($val);
            }
        }

        // Check field name 'para' first before field var 'x_para'
        $val = $CurrentForm->hasValue("para") ? $CurrentForm->getValue("para") : $CurrentForm->getValue("x_para");
        if (!$this->para->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->para->Visible = false; // Disable update for API request
            } else {
                $this->para->setFormValue($val);
            }
        }

        // Check field name 'adjunto' first before field var 'x_adjunto'
        $val = $CurrentForm->hasValue("adjunto") ? $CurrentForm->getValue("adjunto") : $CurrentForm->getValue("x_adjunto");
        if (!$this->adjunto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->adjunto->Visible = false; // Disable update for API request
            } else {
                $this->adjunto->setFormValue($val);
            }
        }

        // Check field name 'id_inyect' first before field var 'x_id_inyect'
        $val = $CurrentForm->hasValue("id_inyect") ? $CurrentForm->getValue("id_inyect") : $CurrentForm->getValue("x_id_inyect");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_tarea->CurrentValue = $this->id_tarea->FormValue;
        $this->titulo->CurrentValue = $this->titulo->FormValue;
        $this->mensaje->CurrentValue = $this->mensaje->FormValue;
        $this->fechareal_start->CurrentValue = $this->fechareal_start->FormValue;
        $this->fechareal_start->CurrentValue = UnFormatDateTime($this->fechareal_start->CurrentValue, 109);
        $this->fechasim_start->CurrentValue = $this->fechasim_start->FormValue;
        $this->fechasim_start->CurrentValue = UnFormatDateTime($this->fechasim_start->CurrentValue, 109);
        $this->medios->CurrentValue = $this->medios->FormValue;
        $this->actividad_esperada->CurrentValue = $this->actividad_esperada->FormValue;
        $this->id_actor->CurrentValue = $this->id_actor->FormValue;
        $this->para->CurrentValue = $this->para->FormValue;
        $this->adjunto->CurrentValue = $this->adjunto->FormValue;
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
        $this->id_inyect->setDbValue($row['id_inyect']);
        $this->id_tarea->setDbValue($row['id_tarea']);
        $this->titulo->setDbValue($row['titulo']);
        $this->mensaje->setDbValue($row['mensaje']);
        $this->fechareal_start->setDbValue($row['fechareal_start']);
        $this->fechasim_start->setDbValue($row['fechasim_start']);
        $this->medios->setDbValue($row['medios']);
        $this->actividad_esperada->setDbValue($row['actividad_esperada']);
        $this->id_actor->setDbValue($row['id_actor']);
        $this->enviado->setDbValue($row['enviado']);
        $this->para->setDbValue($row['para']);
        $this->adjunto->setDbValue($row['adjunto']);
        $this->dif_horaria->setDbValue($row['dif_horaria']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id_inyect'] = $this->id_inyect->CurrentValue;
        $row['id_tarea'] = $this->id_tarea->CurrentValue;
        $row['titulo'] = $this->titulo->CurrentValue;
        $row['mensaje'] = $this->mensaje->CurrentValue;
        $row['fechareal_start'] = $this->fechareal_start->CurrentValue;
        $row['fechasim_start'] = $this->fechasim_start->CurrentValue;
        $row['medios'] = $this->medios->CurrentValue;
        $row['actividad_esperada'] = $this->actividad_esperada->CurrentValue;
        $row['id_actor'] = $this->id_actor->CurrentValue;
        $row['enviado'] = $this->enviado->CurrentValue;
        $row['para'] = $this->para->CurrentValue;
        $row['adjunto'] = $this->adjunto->CurrentValue;
        $row['dif_horaria'] = $this->dif_horaria->CurrentValue;
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

        // id_inyect

        // id_tarea

        // titulo

        // mensaje

        // fechareal_start

        // fechasim_start

        // medios

        // actividad_esperada

        // id_actor

        // enviado

        // para

        // adjunto

        // dif_horaria
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_inyect
            $this->id_inyect->ViewValue = $this->id_inyect->CurrentValue;
            $this->id_inyect->ViewCustomAttributes = "";

            // id_tarea
            $curVal = trim(strval($this->id_tarea->CurrentValue));
            if ($curVal != "") {
                $this->id_tarea->ViewValue = $this->id_tarea->lookupCacheOption($curVal);
                if ($this->id_tarea->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_tarea`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->id_tarea->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->id_tarea->Lookup->renderViewRow($rswrk[0]);
                        $this->id_tarea->ViewValue = $this->id_tarea->displayValue($arwrk);
                    } else {
                        $this->id_tarea->ViewValue = $this->id_tarea->CurrentValue;
                    }
                }
            } else {
                $this->id_tarea->ViewValue = null;
            }
            $this->id_tarea->ViewCustomAttributes = "";

            // titulo
            $this->titulo->ViewValue = $this->titulo->CurrentValue;
            $this->titulo->ViewCustomAttributes = "";

            // mensaje
            $this->mensaje->ViewValue = $this->mensaje->CurrentValue;
            $this->mensaje->ViewCustomAttributes = "";

            // fechareal_start
            $this->fechareal_start->ViewValue = $this->fechareal_start->CurrentValue;
            $this->fechareal_start->ViewValue = FormatDateTime($this->fechareal_start->ViewValue, 109);
            $this->fechareal_start->CssClass = "font-italic";
            $this->fechareal_start->ViewCustomAttributes = "";

            // fechasim_start
            $this->fechasim_start->ViewValue = $this->fechasim_start->CurrentValue;
            $this->fechasim_start->ViewValue = FormatDateTime($this->fechasim_start->ViewValue, 109);
            $this->fechasim_start->ViewCustomAttributes = "";

            // medios
            if (strval($this->medios->CurrentValue) != "") {
                $this->medios->ViewValue = $this->medios->optionCaption($this->medios->CurrentValue);
            } else {
                $this->medios->ViewValue = null;
            }
            $this->medios->ViewCustomAttributes = "";

            // actividad_esperada
            $this->actividad_esperada->ViewValue = $this->actividad_esperada->CurrentValue;
            $this->actividad_esperada->ViewCustomAttributes = "";

            // id_actor
            $curVal = trim(strval($this->id_actor->CurrentValue));
            if ($curVal != "") {
                $this->id_actor->ViewValue = $this->id_actor->lookupCacheOption($curVal);
                if ($this->id_actor->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_actor`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->id_actor->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->id_actor->Lookup->renderViewRow($rswrk[0]);
                        $this->id_actor->ViewValue = $this->id_actor->displayValue($arwrk);
                    } else {
                        $this->id_actor->ViewValue = $this->id_actor->CurrentValue;
                    }
                }
            } else {
                $this->id_actor->ViewValue = null;
            }
            $this->id_actor->ViewCustomAttributes = "";

            // para
            $curVal = trim(strval($this->para->CurrentValue));
            if ($curVal != "") {
                $this->para->ViewValue = $this->para->lookupCacheOption($curVal);
                if ($this->para->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`id`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->para->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->para->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->para->Lookup->renderViewRow($row);
                            $this->para->ViewValue->add($this->para->displayValue($arwrk));
                        }
                    } else {
                        $this->para->ViewValue = $this->para->CurrentValue;
                    }
                }
            } else {
                $this->para->ViewValue = null;
            }
            $this->para->ViewCustomAttributes = "";

            // adjunto
            $curVal = trim(strval($this->adjunto->CurrentValue));
            if ($curVal != "") {
                $this->adjunto->ViewValue = $this->adjunto->lookupCacheOption($curVal);
                if ($this->adjunto->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_file`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->adjunto->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->adjunto->Lookup->renderViewRow($rswrk[0]);
                        $this->adjunto->ViewValue = $this->adjunto->displayValue($arwrk);
                    } else {
                        $this->adjunto->ViewValue = $this->adjunto->CurrentValue;
                    }
                }
            } else {
                $this->adjunto->ViewValue = null;
            }
            $this->adjunto->ViewCustomAttributes = "";

            // id_tarea
            $this->id_tarea->LinkCustomAttributes = "";
            $this->id_tarea->HrefValue = "";
            $this->id_tarea->TooltipValue = "";

            // titulo
            $this->titulo->LinkCustomAttributes = "";
            $this->titulo->HrefValue = "";
            if (!$this->isExport()) {
                $this->titulo->TooltipValue = strval($this->mensaje->CurrentValue);
                if ($this->titulo->HrefValue == "") {
                    $this->titulo->HrefValue = "javascript:void(0);";
                }
                $this->titulo->LinkAttrs->appendClass("ew-tooltip-link");
                $this->titulo->LinkAttrs["data-tooltip-id"] = "tt_mensajes_x_titulo";
                $this->titulo->LinkAttrs["data-tooltip-width"] = $this->titulo->TooltipWidth;
                $this->titulo->LinkAttrs["data-placement"] = Config("CSS_FLIP") ? "left" : "right";
            }

            // mensaje
            $this->mensaje->LinkCustomAttributes = "";
            $this->mensaje->HrefValue = "";
            $this->mensaje->TooltipValue = "";

            // fechareal_start
            $this->fechareal_start->LinkCustomAttributes = "";
            $this->fechareal_start->HrefValue = "";
            $this->fechareal_start->TooltipValue = "";

            // fechasim_start
            $this->fechasim_start->LinkCustomAttributes = "";
            $this->fechasim_start->HrefValue = "";
            $this->fechasim_start->TooltipValue = "";

            // medios
            $this->medios->LinkCustomAttributes = "";
            $this->medios->HrefValue = "";
            $this->medios->TooltipValue = "";

            // actividad_esperada
            $this->actividad_esperada->LinkCustomAttributes = "";
            $this->actividad_esperada->HrefValue = "";
            $this->actividad_esperada->TooltipValue = "";

            // id_actor
            $this->id_actor->LinkCustomAttributes = "";
            $this->id_actor->HrefValue = "";
            $this->id_actor->TooltipValue = "";

            // para
            $this->para->LinkCustomAttributes = "";
            $this->para->HrefValue = "";
            $this->para->TooltipValue = "";

            // adjunto
            $this->adjunto->LinkCustomAttributes = "";
            if (!EmptyValue($this->adjunto->CurrentValue)) {
                $this->adjunto->HrefValue = (!empty($this->adjunto->ViewValue) && !is_array($this->adjunto->ViewValue) ? RemoveHtml($this->adjunto->ViewValue) : $this->adjunto->CurrentValue); // Add prefix/suffix
                $this->adjunto->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->adjunto->HrefValue = FullUrl($this->adjunto->HrefValue, "href");
                }
            } else {
                $this->adjunto->HrefValue = "";
            }
            $this->adjunto->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id_tarea
            $this->id_tarea->EditAttrs["class"] = "form-control";
            $this->id_tarea->EditCustomAttributes = "";
            if ($this->id_tarea->getSessionValue() != "") {
                $this->id_tarea->CurrentValue = GetForeignKeyValue($this->id_tarea->getSessionValue());
                $curVal = trim(strval($this->id_tarea->CurrentValue));
                if ($curVal != "") {
                    $this->id_tarea->ViewValue = $this->id_tarea->lookupCacheOption($curVal);
                    if ($this->id_tarea->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id_tarea`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->id_tarea->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->id_tarea->Lookup->renderViewRow($rswrk[0]);
                            $this->id_tarea->ViewValue = $this->id_tarea->displayValue($arwrk);
                        } else {
                            $this->id_tarea->ViewValue = $this->id_tarea->CurrentValue;
                        }
                    }
                } else {
                    $this->id_tarea->ViewValue = null;
                }
                $this->id_tarea->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->id_tarea->CurrentValue));
                if ($curVal != "") {
                    $this->id_tarea->ViewValue = $this->id_tarea->lookupCacheOption($curVal);
                } else {
                    $this->id_tarea->ViewValue = $this->id_tarea->Lookup !== null && is_array($this->id_tarea->Lookup->Options) ? $curVal : null;
                }
                if ($this->id_tarea->ViewValue !== null) { // Load from cache
                    $this->id_tarea->EditValue = array_values($this->id_tarea->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id_tarea`" . SearchString("=", $this->id_tarea->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->id_tarea->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->id_tarea->EditValue = $arwrk;
                }
                $this->id_tarea->PlaceHolder = RemoveHtml($this->id_tarea->caption());
            }

            // titulo
            $this->titulo->EditAttrs["class"] = "form-control";
            $this->titulo->EditCustomAttributes = "";
            if (!$this->titulo->Raw) {
                $this->titulo->CurrentValue = HtmlDecode($this->titulo->CurrentValue);
            }
            $this->titulo->EditValue = HtmlEncode($this->titulo->CurrentValue);
            $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

            // mensaje
            $this->mensaje->EditAttrs["class"] = "form-control";
            $this->mensaje->EditCustomAttributes = "";
            $this->mensaje->EditValue = HtmlEncode($this->mensaje->CurrentValue);
            $this->mensaje->PlaceHolder = RemoveHtml($this->mensaje->caption());

            // fechareal_start
            $this->fechareal_start->EditAttrs["class"] = "form-control";
            $this->fechareal_start->EditCustomAttributes = "";
            $this->fechareal_start->EditValue = HtmlEncode(FormatDateTime($this->fechareal_start->CurrentValue, 109));
            $this->fechareal_start->PlaceHolder = RemoveHtml($this->fechareal_start->caption());

            // fechasim_start
            $this->fechasim_start->EditAttrs["class"] = "form-control";
            $this->fechasim_start->EditCustomAttributes = "";
            $this->fechasim_start->EditValue = HtmlEncode(FormatDateTime($this->fechasim_start->CurrentValue, 109));
            $this->fechasim_start->PlaceHolder = RemoveHtml($this->fechasim_start->caption());

            // medios
            $this->medios->EditAttrs["class"] = "form-control";
            $this->medios->EditCustomAttributes = "";
            $this->medios->EditValue = $this->medios->options(true);
            $this->medios->PlaceHolder = RemoveHtml($this->medios->caption());

            // actividad_esperada
            $this->actividad_esperada->EditAttrs["class"] = "form-control";
            $this->actividad_esperada->EditCustomAttributes = "";
            $this->actividad_esperada->EditValue = HtmlEncode($this->actividad_esperada->CurrentValue);
            $this->actividad_esperada->PlaceHolder = RemoveHtml($this->actividad_esperada->caption());

            // id_actor
            $this->id_actor->EditAttrs["class"] = "form-control";
            $this->id_actor->EditCustomAttributes = "";
            $curVal = trim(strval($this->id_actor->CurrentValue));
            if ($curVal != "") {
                $this->id_actor->ViewValue = $this->id_actor->lookupCacheOption($curVal);
            } else {
                $this->id_actor->ViewValue = $this->id_actor->Lookup !== null && is_array($this->id_actor->Lookup->Options) ? $curVal : null;
            }
            if ($this->id_actor->ViewValue !== null) { // Load from cache
                $this->id_actor->EditValue = array_values($this->id_actor->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_actor`" . SearchString("=", $this->id_actor->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->id_actor->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->id_actor->EditValue = $arwrk;
            }
            $this->id_actor->PlaceHolder = RemoveHtml($this->id_actor->caption());

            // para
            $this->para->EditAttrs["class"] = "form-control";
            $this->para->EditCustomAttributes = "";
            $curVal = trim(strval($this->para->CurrentValue));
            if ($curVal != "") {
                $this->para->ViewValue = $this->para->lookupCacheOption($curVal);
            } else {
                $this->para->ViewValue = $this->para->Lookup !== null && is_array($this->para->Lookup->Options) ? $curVal : null;
            }
            if ($this->para->ViewValue !== null) { // Load from cache
                $this->para->EditValue = array_values($this->para->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`id`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->para->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->para->EditValue = $arwrk;
            }
            $this->para->PlaceHolder = RemoveHtml($this->para->caption());

            // adjunto
            $this->adjunto->EditAttrs["class"] = "form-control";
            $this->adjunto->EditCustomAttributes = "";
            $curVal = trim(strval($this->adjunto->CurrentValue));
            if ($curVal != "") {
                $this->adjunto->ViewValue = $this->adjunto->lookupCacheOption($curVal);
            } else {
                $this->adjunto->ViewValue = $this->adjunto->Lookup !== null && is_array($this->adjunto->Lookup->Options) ? $curVal : null;
            }
            if ($this->adjunto->ViewValue !== null) { // Load from cache
                $this->adjunto->EditValue = array_values($this->adjunto->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_file`" . SearchString("=", $this->adjunto->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->adjunto->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->adjunto->EditValue = $arwrk;
            }
            $this->adjunto->PlaceHolder = RemoveHtml($this->adjunto->caption());

            // Add refer script

            // id_tarea
            $this->id_tarea->LinkCustomAttributes = "";
            $this->id_tarea->HrefValue = "";

            // titulo
            $this->titulo->LinkCustomAttributes = "";
            $this->titulo->HrefValue = "";

            // mensaje
            $this->mensaje->LinkCustomAttributes = "";
            $this->mensaje->HrefValue = "";

            // fechareal_start
            $this->fechareal_start->LinkCustomAttributes = "";
            $this->fechareal_start->HrefValue = "";

            // fechasim_start
            $this->fechasim_start->LinkCustomAttributes = "";
            $this->fechasim_start->HrefValue = "";

            // medios
            $this->medios->LinkCustomAttributes = "";
            $this->medios->HrefValue = "";

            // actividad_esperada
            $this->actividad_esperada->LinkCustomAttributes = "";
            $this->actividad_esperada->HrefValue = "";

            // id_actor
            $this->id_actor->LinkCustomAttributes = "";
            $this->id_actor->HrefValue = "";

            // para
            $this->para->LinkCustomAttributes = "";
            $this->para->HrefValue = "";

            // adjunto
            $this->adjunto->LinkCustomAttributes = "";
            if (!EmptyValue($this->adjunto->CurrentValue)) {
                $this->adjunto->HrefValue = (!empty($this->adjunto->EditValue) && !is_array($this->adjunto->EditValue) ? RemoveHtml($this->adjunto->EditValue) : $this->adjunto->CurrentValue); // Add prefix/suffix
                $this->adjunto->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->adjunto->HrefValue = FullUrl($this->adjunto->HrefValue, "href");
                }
            } else {
                $this->adjunto->HrefValue = "";
            }
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
        if ($this->id_tarea->Required) {
            if (!$this->id_tarea->IsDetailKey && EmptyValue($this->id_tarea->FormValue)) {
                $this->id_tarea->addErrorMessage(str_replace("%s", $this->id_tarea->caption(), $this->id_tarea->RequiredErrorMessage));
            }
        }
        if ($this->titulo->Required) {
            if (!$this->titulo->IsDetailKey && EmptyValue($this->titulo->FormValue)) {
                $this->titulo->addErrorMessage(str_replace("%s", $this->titulo->caption(), $this->titulo->RequiredErrorMessage));
            }
        }
        if ($this->mensaje->Required) {
            if (!$this->mensaje->IsDetailKey && EmptyValue($this->mensaje->FormValue)) {
                $this->mensaje->addErrorMessage(str_replace("%s", $this->mensaje->caption(), $this->mensaje->RequiredErrorMessage));
            }
        }
        if ($this->fechareal_start->Required) {
            if (!$this->fechareal_start->IsDetailKey && EmptyValue($this->fechareal_start->FormValue)) {
                $this->fechareal_start->addErrorMessage(str_replace("%s", $this->fechareal_start->caption(), $this->fechareal_start->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechareal_start->FormValue)) {
            $this->fechareal_start->addErrorMessage($this->fechareal_start->getErrorMessage(false));
        }
        if ($this->fechasim_start->Required) {
            if (!$this->fechasim_start->IsDetailKey && EmptyValue($this->fechasim_start->FormValue)) {
                $this->fechasim_start->addErrorMessage(str_replace("%s", $this->fechasim_start->caption(), $this->fechasim_start->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechasim_start->FormValue)) {
            $this->fechasim_start->addErrorMessage($this->fechasim_start->getErrorMessage(false));
        }
        if ($this->medios->Required) {
            if (!$this->medios->IsDetailKey && EmptyValue($this->medios->FormValue)) {
                $this->medios->addErrorMessage(str_replace("%s", $this->medios->caption(), $this->medios->RequiredErrorMessage));
            }
        }
        if ($this->actividad_esperada->Required) {
            if (!$this->actividad_esperada->IsDetailKey && EmptyValue($this->actividad_esperada->FormValue)) {
                $this->actividad_esperada->addErrorMessage(str_replace("%s", $this->actividad_esperada->caption(), $this->actividad_esperada->RequiredErrorMessage));
            }
        }
        if ($this->id_actor->Required) {
            if (!$this->id_actor->IsDetailKey && EmptyValue($this->id_actor->FormValue)) {
                $this->id_actor->addErrorMessage(str_replace("%s", $this->id_actor->caption(), $this->id_actor->RequiredErrorMessage));
            }
        }
        if ($this->para->Required) {
            if ($this->para->FormValue == "") {
                $this->para->addErrorMessage(str_replace("%s", $this->para->caption(), $this->para->RequiredErrorMessage));
            }
        }
        if ($this->adjunto->Required) {
            if (!$this->adjunto->IsDetailKey && EmptyValue($this->adjunto->FormValue)) {
                $this->adjunto->addErrorMessage(str_replace("%s", $this->adjunto->caption(), $this->adjunto->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ResmensajeGrid");
        if (in_array("resmensaje", $detailTblVar) && $detailPage->DetailAdd) {
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Check referential integrity for master table 'mensajes'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_tareas();
        if (strval($this->id_tarea->CurrentValue) != "") {
            $masterFilter = str_replace("@id_tarea@", AdjustSql($this->id_tarea->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("tareas")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "tareas", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // id_tarea
        $this->id_tarea->setDbValueDef($rsnew, $this->id_tarea->CurrentValue, null, false);

        // titulo
        $this->titulo->setDbValueDef($rsnew, $this->titulo->CurrentValue, null, false);

        // mensaje
        $this->mensaje->setDbValueDef($rsnew, $this->mensaje->CurrentValue, null, false);

        // fechareal_start
        $this->fechareal_start->setDbValueDef($rsnew, UnFormatDateTime($this->fechareal_start->CurrentValue, 109), null, false);

        // fechasim_start
        $this->fechasim_start->setDbValueDef($rsnew, UnFormatDateTime($this->fechasim_start->CurrentValue, 109), null, false);

        // medios
        $this->medios->setDbValueDef($rsnew, $this->medios->CurrentValue, null, false);

        // actividad_esperada
        $this->actividad_esperada->setDbValueDef($rsnew, $this->actividad_esperada->CurrentValue, null, false);

        // id_actor
        $this->id_actor->setDbValueDef($rsnew, $this->id_actor->CurrentValue, null, false);

        // para
        $this->para->setDbValueDef($rsnew, $this->para->CurrentValue, null, false);

        // adjunto
        $this->adjunto->setDbValueDef($rsnew, $this->adjunto->CurrentValue, null, strval($this->adjunto->CurrentValue) == "");

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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("ResmensajeGrid");
            if (in_array("resmensaje", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->id_inyect->setSessionValue($this->id_inyect->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "resmensaje"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->id_inyect->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                $conn->commit(); // Commit transaction
            } else {
                $conn->rollback(); // Rollback transaction
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
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
            if ($masterTblVar == "tareas") {
                $validMaster = true;
                $masterTbl = Container("tareas");
                if (($parm = Get("fk_id_tarea", Get("id_tarea"))) !== null) {
                    $masterTbl->id_tarea->setQueryStringValue($parm);
                    $this->id_tarea->setQueryStringValue($masterTbl->id_tarea->QueryStringValue);
                    $this->id_tarea->setSessionValue($this->id_tarea->QueryStringValue);
                    if (!is_numeric($masterTbl->id_tarea->QueryStringValue)) {
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
            if ($masterTblVar == "tareas") {
                $validMaster = true;
                $masterTbl = Container("tareas");
                if (($parm = Post("fk_id_tarea", Post("id_tarea"))) !== null) {
                    $masterTbl->id_tarea->setFormValue($parm);
                    $this->id_tarea->setFormValue($masterTbl->id_tarea->FormValue);
                    $this->id_tarea->setSessionValue($this->id_tarea->FormValue);
                    if (!is_numeric($masterTbl->id_tarea->FormValue)) {
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
            if ($masterTblVar != "tareas") {
                if ($this->id_tarea->CurrentValue == "") {
                    $this->id_tarea->setSessionValue("");
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
            if (in_array("resmensaje", $detailTblVar)) {
                $detailPageObj = Container("ResmensajeGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->id_inyect->IsDetailKey = true;
                    $detailPageObj->id_inyect->CurrentValue = $this->id_inyect->CurrentValue;
                    $detailPageObj->id_inyect->setSessionValue($detailPageObj->id_inyect->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("MensajesList"), "", $this->TableVar, true);
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
                case "x_id_tarea":
                    break;
                case "x_medios":
                    break;
                case "x_id_actor":
                    break;
                case "x_para":
                    break;
                case "x_adjunto":
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
            if (@$_POST["xxxx"] <> "") // Check if the page is doing insert and check if the 2nd button is pressed
    $url = "MensajesAdd?showmaster=tareas&fk_id_tarea=".Container("tareas")->id_tarea->CurrentValue;
    //"xxxedit.php?YourPrimaryKey=" . urlencode($this->YourPrimaryKey->DbValue);
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
       // $customerID = $_GET['fk_id_tarea'];
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
