<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MensajesUsuariosEdit extends MensajesUsuarios
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'mensajes_usuarios';

    // Page object name
    public $PageObjName = "MensajesUsuariosEdit";

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

        // Table object (mensajes_usuarios)
        if (!isset($GLOBALS["mensajes_usuarios"]) || get_class($GLOBALS["mensajes_usuarios"]) == PROJECT_NAMESPACE . "mensajes_usuarios") {
            $GLOBALS["mensajes_usuarios"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'mensajes_usuarios');
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
                $doc = new $class(Container("mensajes_usuarios"));
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
                    if ($pageName == "MensajesUsuariosView") {
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
            $key .= @$ar['id_mensaje_usuario'];
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
            $this->id_mensaje_usuario->Visible = false;
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
        $this->id_mensaje_usuario->setVisibility();
        $this->id_user_remitente->setVisibility();
        $this->id_user_destinatario->setVisibility();
        $this->id_mensaje->setVisibility();
        $this->leido->setVisibility();
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
            if (($keyValue = Get("id_mensaje_usuario") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_mensaje_usuario->setQueryStringValue($keyValue);
                $this->id_mensaje_usuario->setOldValue($this->id_mensaje_usuario->QueryStringValue);
            } elseif (Post("id_mensaje_usuario") !== null) {
                $this->id_mensaje_usuario->setFormValue(Post("id_mensaje_usuario"));
                $this->id_mensaje_usuario->setOldValue($this->id_mensaje_usuario->FormValue);
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
                if (($keyValue = Get("id_mensaje_usuario") ?? Route("id_mensaje_usuario")) !== null) {
                    $this->id_mensaje_usuario->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_mensaje_usuario->CurrentValue = null;
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
                    $this->terminate("MensajesUsuariosList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "MensajesUsuariosList") {
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

        // Check field name 'id_mensaje_usuario' first before field var 'x_id_mensaje_usuario'
        $val = $CurrentForm->hasValue("id_mensaje_usuario") ? $CurrentForm->getValue("id_mensaje_usuario") : $CurrentForm->getValue("x_id_mensaje_usuario");
        if (!$this->id_mensaje_usuario->IsDetailKey) {
            $this->id_mensaje_usuario->setFormValue($val);
        }

        // Check field name 'id_user_remitente' first before field var 'x_id_user_remitente'
        $val = $CurrentForm->hasValue("id_user_remitente") ? $CurrentForm->getValue("id_user_remitente") : $CurrentForm->getValue("x_id_user_remitente");
        if (!$this->id_user_remitente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_user_remitente->Visible = false; // Disable update for API request
            } else {
                $this->id_user_remitente->setFormValue($val);
            }
        }

        // Check field name 'id_user_destinatario' first before field var 'x_id_user_destinatario'
        $val = $CurrentForm->hasValue("id_user_destinatario") ? $CurrentForm->getValue("id_user_destinatario") : $CurrentForm->getValue("x_id_user_destinatario");
        if (!$this->id_user_destinatario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_user_destinatario->Visible = false; // Disable update for API request
            } else {
                $this->id_user_destinatario->setFormValue($val);
            }
        }

        // Check field name 'id_mensaje' first before field var 'x_id_mensaje'
        $val = $CurrentForm->hasValue("id_mensaje") ? $CurrentForm->getValue("id_mensaje") : $CurrentForm->getValue("x_id_mensaje");
        if (!$this->id_mensaje->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_mensaje->Visible = false; // Disable update for API request
            } else {
                $this->id_mensaje->setFormValue($val);
            }
        }

        // Check field name 'leido' first before field var 'x_leido'
        $val = $CurrentForm->hasValue("leido") ? $CurrentForm->getValue("leido") : $CurrentForm->getValue("x_leido");
        if (!$this->leido->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->leido->Visible = false; // Disable update for API request
            } else {
                $this->leido->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_mensaje_usuario->CurrentValue = $this->id_mensaje_usuario->FormValue;
        $this->id_user_remitente->CurrentValue = $this->id_user_remitente->FormValue;
        $this->id_user_destinatario->CurrentValue = $this->id_user_destinatario->FormValue;
        $this->id_mensaje->CurrentValue = $this->id_mensaje->FormValue;
        $this->leido->CurrentValue = $this->leido->FormValue;
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
        $this->id_mensaje_usuario->setDbValue($row['id_mensaje_usuario']);
        $this->id_user_remitente->setDbValue($row['id_user_remitente']);
        $this->id_user_destinatario->setDbValue($row['id_user_destinatario']);
        $this->id_mensaje->setDbValue($row['id_mensaje']);
        $this->leido->setDbValue($row['leido']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_mensaje_usuario'] = null;
        $row['id_user_remitente'] = null;
        $row['id_user_destinatario'] = null;
        $row['id_mensaje'] = null;
        $row['leido'] = null;
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

        // id_mensaje_usuario

        // id_user_remitente

        // id_user_destinatario

        // id_mensaje

        // leido
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_mensaje_usuario
            $this->id_mensaje_usuario->ViewValue = $this->id_mensaje_usuario->CurrentValue;
            $this->id_mensaje_usuario->ViewCustomAttributes = "";

            // id_user_remitente
            $this->id_user_remitente->ViewValue = $this->id_user_remitente->CurrentValue;
            $this->id_user_remitente->ViewValue = FormatNumber($this->id_user_remitente->ViewValue, 0, -2, -2, -2);
            $this->id_user_remitente->ViewCustomAttributes = "";

            // id_user_destinatario
            $this->id_user_destinatario->ViewValue = $this->id_user_destinatario->CurrentValue;
            $this->id_user_destinatario->ViewValue = FormatNumber($this->id_user_destinatario->ViewValue, 0, -2, -2, -2);
            $this->id_user_destinatario->ViewCustomAttributes = "";

            // id_mensaje
            $this->id_mensaje->ViewValue = $this->id_mensaje->CurrentValue;
            $this->id_mensaje->ViewValue = FormatNumber($this->id_mensaje->ViewValue, 0, -2, -2, -2);
            $this->id_mensaje->ViewCustomAttributes = "";

            // leido
            if (ConvertToBool($this->leido->CurrentValue)) {
                $this->leido->ViewValue = $this->leido->tagCaption(1) != "" ? $this->leido->tagCaption(1) : "Yes";
            } else {
                $this->leido->ViewValue = $this->leido->tagCaption(2) != "" ? $this->leido->tagCaption(2) : "No";
            }
            $this->leido->ViewCustomAttributes = "";

            // id_mensaje_usuario
            $this->id_mensaje_usuario->LinkCustomAttributes = "";
            $this->id_mensaje_usuario->HrefValue = "";
            $this->id_mensaje_usuario->TooltipValue = "";

            // id_user_remitente
            $this->id_user_remitente->LinkCustomAttributes = "";
            $this->id_user_remitente->HrefValue = "";
            $this->id_user_remitente->TooltipValue = "";

            // id_user_destinatario
            $this->id_user_destinatario->LinkCustomAttributes = "";
            $this->id_user_destinatario->HrefValue = "";
            $this->id_user_destinatario->TooltipValue = "";

            // id_mensaje
            $this->id_mensaje->LinkCustomAttributes = "";
            $this->id_mensaje->HrefValue = "";
            $this->id_mensaje->TooltipValue = "";

            // leido
            $this->leido->LinkCustomAttributes = "";
            $this->leido->HrefValue = "";
            $this->leido->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id_mensaje_usuario
            $this->id_mensaje_usuario->EditAttrs["class"] = "form-control";
            $this->id_mensaje_usuario->EditCustomAttributes = "";
            $this->id_mensaje_usuario->EditValue = $this->id_mensaje_usuario->CurrentValue;
            $this->id_mensaje_usuario->ViewCustomAttributes = "";

            // id_user_remitente
            $this->id_user_remitente->EditAttrs["class"] = "form-control";
            $this->id_user_remitente->EditCustomAttributes = "";
            $this->id_user_remitente->EditValue = HtmlEncode($this->id_user_remitente->CurrentValue);
            $this->id_user_remitente->PlaceHolder = RemoveHtml($this->id_user_remitente->caption());

            // id_user_destinatario
            $this->id_user_destinatario->EditAttrs["class"] = "form-control";
            $this->id_user_destinatario->EditCustomAttributes = "";
            $this->id_user_destinatario->EditValue = HtmlEncode($this->id_user_destinatario->CurrentValue);
            $this->id_user_destinatario->PlaceHolder = RemoveHtml($this->id_user_destinatario->caption());

            // id_mensaje
            $this->id_mensaje->EditAttrs["class"] = "form-control";
            $this->id_mensaje->EditCustomAttributes = "";
            $this->id_mensaje->EditValue = HtmlEncode($this->id_mensaje->CurrentValue);
            $this->id_mensaje->PlaceHolder = RemoveHtml($this->id_mensaje->caption());

            // leido
            $this->leido->EditCustomAttributes = "";
            $this->leido->EditValue = $this->leido->options(false);
            $this->leido->PlaceHolder = RemoveHtml($this->leido->caption());

            // Edit refer script

            // id_mensaje_usuario
            $this->id_mensaje_usuario->LinkCustomAttributes = "";
            $this->id_mensaje_usuario->HrefValue = "";

            // id_user_remitente
            $this->id_user_remitente->LinkCustomAttributes = "";
            $this->id_user_remitente->HrefValue = "";

            // id_user_destinatario
            $this->id_user_destinatario->LinkCustomAttributes = "";
            $this->id_user_destinatario->HrefValue = "";

            // id_mensaje
            $this->id_mensaje->LinkCustomAttributes = "";
            $this->id_mensaje->HrefValue = "";

            // leido
            $this->leido->LinkCustomAttributes = "";
            $this->leido->HrefValue = "";
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
        if ($this->id_mensaje_usuario->Required) {
            if (!$this->id_mensaje_usuario->IsDetailKey && EmptyValue($this->id_mensaje_usuario->FormValue)) {
                $this->id_mensaje_usuario->addErrorMessage(str_replace("%s", $this->id_mensaje_usuario->caption(), $this->id_mensaje_usuario->RequiredErrorMessage));
            }
        }
        if ($this->id_user_remitente->Required) {
            if (!$this->id_user_remitente->IsDetailKey && EmptyValue($this->id_user_remitente->FormValue)) {
                $this->id_user_remitente->addErrorMessage(str_replace("%s", $this->id_user_remitente->caption(), $this->id_user_remitente->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id_user_remitente->FormValue)) {
            $this->id_user_remitente->addErrorMessage($this->id_user_remitente->getErrorMessage(false));
        }
        if ($this->id_user_destinatario->Required) {
            if (!$this->id_user_destinatario->IsDetailKey && EmptyValue($this->id_user_destinatario->FormValue)) {
                $this->id_user_destinatario->addErrorMessage(str_replace("%s", $this->id_user_destinatario->caption(), $this->id_user_destinatario->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id_user_destinatario->FormValue)) {
            $this->id_user_destinatario->addErrorMessage($this->id_user_destinatario->getErrorMessage(false));
        }
        if ($this->id_mensaje->Required) {
            if (!$this->id_mensaje->IsDetailKey && EmptyValue($this->id_mensaje->FormValue)) {
                $this->id_mensaje->addErrorMessage(str_replace("%s", $this->id_mensaje->caption(), $this->id_mensaje->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id_mensaje->FormValue)) {
            $this->id_mensaje->addErrorMessage($this->id_mensaje->getErrorMessage(false));
        }
        if ($this->leido->Required) {
            if ($this->leido->FormValue == "") {
                $this->leido->addErrorMessage(str_replace("%s", $this->leido->caption(), $this->leido->RequiredErrorMessage));
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

            // id_user_remitente
            $this->id_user_remitente->setDbValueDef($rsnew, $this->id_user_remitente->CurrentValue, null, $this->id_user_remitente->ReadOnly);

            // id_user_destinatario
            $this->id_user_destinatario->setDbValueDef($rsnew, $this->id_user_destinatario->CurrentValue, null, $this->id_user_destinatario->ReadOnly);

            // id_mensaje
            $this->id_mensaje->setDbValueDef($rsnew, $this->id_mensaje->CurrentValue, null, $this->id_mensaje->ReadOnly);

            // leido
            $tmpBool = $this->leido->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->leido->setDbValueDef($rsnew, $tmpBool, null, $this->leido->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("MensajesUsuariosList"), "", $this->TableVar, true);
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
                case "x_leido":
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
