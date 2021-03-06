<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class SendEmail2Edit extends SendEmail2
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'send_email';

    // Page object name
    public $PageObjName = "SendEmail2Edit";

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

        // Table object (send_email2)
        if (!isset($GLOBALS["send_email2"]) || get_class($GLOBALS["send_email2"]) == PROJECT_NAMESPACE . "send_email2") {
            $GLOBALS["send_email2"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'send_email');
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
                $doc = new $class(Container("send_email2"));
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
                    if ($pageName == "SendEmail2View") {
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
            $key .= @$ar['id_sendemail'];
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
            $this->id_sendemail->Visible = false;
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
        $this->id_sendemail->setVisibility();
        $this->sujeto->setVisibility();
        $this->mensaje->setVisibility();
        $this->tiempo->setVisibility();
        $this->archivo->setVisibility();
        $this->status->setVisibility();
        $this->de_user->setVisibility();
        $this->copy_user->setVisibility();
        $this->para_user->setVisibility();
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
        $this->setupLookupOptions($this->para_user);

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
            if (($keyValue = Get("id_sendemail") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_sendemail->setQueryStringValue($keyValue);
                $this->id_sendemail->setOldValue($this->id_sendemail->QueryStringValue);
            } elseif (Post("id_sendemail") !== null) {
                $this->id_sendemail->setFormValue(Post("id_sendemail"));
                $this->id_sendemail->setOldValue($this->id_sendemail->FormValue);
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
                if (($keyValue = Get("id_sendemail") ?? Route("id_sendemail")) !== null) {
                    $this->id_sendemail->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_sendemail->CurrentValue = null;
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
                    $this->terminate("SendEmail2List"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "SendEmail2List") {
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

            // Page Rendering event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->archivo->Upload->Index = $CurrentForm->Index;
        $this->archivo->Upload->uploadFile();
        $this->archivo->CurrentValue = $this->archivo->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_sendemail' first before field var 'x_id_sendemail'
        $val = $CurrentForm->hasValue("id_sendemail") ? $CurrentForm->getValue("id_sendemail") : $CurrentForm->getValue("x_id_sendemail");
        if (!$this->id_sendemail->IsDetailKey) {
            $this->id_sendemail->setFormValue($val);
        }

        // Check field name 'sujeto' first before field var 'x_sujeto'
        $val = $CurrentForm->hasValue("sujeto") ? $CurrentForm->getValue("sujeto") : $CurrentForm->getValue("x_sujeto");
        if (!$this->sujeto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sujeto->Visible = false; // Disable update for API request
            } else {
                $this->sujeto->setFormValue($val);
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

        // Check field name 'tiempo' first before field var 'x_tiempo'
        $val = $CurrentForm->hasValue("tiempo") ? $CurrentForm->getValue("tiempo") : $CurrentForm->getValue("x_tiempo");
        if (!$this->tiempo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tiempo->Visible = false; // Disable update for API request
            } else {
                $this->tiempo->setFormValue($val);
            }
            $this->tiempo->CurrentValue = UnFormatDateTime($this->tiempo->CurrentValue, 15);
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }

        // Check field name 'de_user' first before field var 'x_de_user'
        $val = $CurrentForm->hasValue("de_user") ? $CurrentForm->getValue("de_user") : $CurrentForm->getValue("x_de_user");
        if (!$this->de_user->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->de_user->Visible = false; // Disable update for API request
            } else {
                $this->de_user->setFormValue($val);
            }
        }

        // Check field name 'copy_user' first before field var 'x_copy_user'
        $val = $CurrentForm->hasValue("copy_user") ? $CurrentForm->getValue("copy_user") : $CurrentForm->getValue("x_copy_user");
        if (!$this->copy_user->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->copy_user->Visible = false; // Disable update for API request
            } else {
                $this->copy_user->setFormValue($val);
            }
        }

        // Check field name 'para_user' first before field var 'x_para_user'
        $val = $CurrentForm->hasValue("para_user") ? $CurrentForm->getValue("para_user") : $CurrentForm->getValue("x_para_user");
        if (!$this->para_user->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->para_user->Visible = false; // Disable update for API request
            } else {
                $this->para_user->setFormValue($val);
            }
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_sendemail->CurrentValue = $this->id_sendemail->FormValue;
        $this->sujeto->CurrentValue = $this->sujeto->FormValue;
        $this->mensaje->CurrentValue = $this->mensaje->FormValue;
        $this->tiempo->CurrentValue = $this->tiempo->FormValue;
        $this->tiempo->CurrentValue = UnFormatDateTime($this->tiempo->CurrentValue, 15);
        $this->status->CurrentValue = $this->status->FormValue;
        $this->de_user->CurrentValue = $this->de_user->FormValue;
        $this->copy_user->CurrentValue = $this->copy_user->FormValue;
        $this->para_user->CurrentValue = $this->para_user->FormValue;
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
        $this->id_sendemail->setDbValue($row['id_sendemail']);
        $this->sujeto->setDbValue($row['sujeto']);
        $this->mensaje->setDbValue($row['mensaje']);
        $this->tiempo->setDbValue($row['tiempo']);
        $this->archivo->Upload->DbValue = $row['archivo'];
        $this->archivo->setDbValue($this->archivo->Upload->DbValue);
        $this->status->setDbValue($row['status']);
        $this->de_user->setDbValue($row['de_user']);
        $this->copy_user->setDbValue($row['copy_user']);
        $this->para_user->setDbValue($row['para_user']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_sendemail'] = null;
        $row['sujeto'] = null;
        $row['mensaje'] = null;
        $row['tiempo'] = null;
        $row['archivo'] = null;
        $row['status'] = null;
        $row['de_user'] = null;
        $row['copy_user'] = null;
        $row['para_user'] = null;
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

        // id_sendemail

        // sujeto

        // mensaje

        // tiempo

        // archivo

        // status

        // de_user

        // copy_user

        // para_user
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_sendemail
            $this->id_sendemail->ViewValue = $this->id_sendemail->CurrentValue;
            $this->id_sendemail->ViewCustomAttributes = "";

            // sujeto
            $this->sujeto->ViewValue = $this->sujeto->CurrentValue;
            $this->sujeto->ViewCustomAttributes = "";

            // mensaje
            $this->mensaje->ViewValue = $this->mensaje->CurrentValue;
            $this->mensaje->ViewCustomAttributes = "";

            // tiempo
            $this->tiempo->ViewValue = $this->tiempo->CurrentValue;
            $this->tiempo->ViewValue = FormatDateTime($this->tiempo->ViewValue, 15);
            $this->tiempo->ViewCustomAttributes = "";

            // archivo
            if (!EmptyValue($this->archivo->Upload->DbValue)) {
                $this->archivo->ViewValue = $this->archivo->Upload->DbValue;
            } else {
                $this->archivo->ViewValue = "";
            }
            $this->archivo->ViewCustomAttributes = "";

            // status
            if (ConvertToBool($this->status->CurrentValue)) {
                $this->status->ViewValue = $this->status->tagCaption(1) != "" ? $this->status->tagCaption(1) : "Yes";
            } else {
                $this->status->ViewValue = $this->status->tagCaption(2) != "" ? $this->status->tagCaption(2) : "No";
            }
            $this->status->ViewCustomAttributes = "";

            // de_user
            $this->de_user->ViewValue = $this->de_user->CurrentValue;
            $this->de_user->ViewValue = FormatNumber($this->de_user->ViewValue, 0, -2, -2, -2);
            $this->de_user->ViewCustomAttributes = "";

            // copy_user
            $this->copy_user->ViewValue = $this->copy_user->CurrentValue;
            $this->copy_user->ViewCustomAttributes = "";

            // para_user
            $curVal = strval($this->para_user->CurrentValue);
            if ($curVal != "") {
                $this->para_user->ViewValue = $this->para_user->lookupCacheOption($curVal);
                if ($this->para_user->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_users`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->para_user->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->para_user->Lookup->renderViewRow($rswrk[0]);
                        $this->para_user->ViewValue = $this->para_user->displayValue($arwrk);
                    } else {
                        $this->para_user->ViewValue = $this->para_user->CurrentValue;
                    }
                }
            } else {
                $this->para_user->ViewValue = null;
            }
            $this->para_user->ViewCustomAttributes = "";

            // id_sendemail
            $this->id_sendemail->LinkCustomAttributes = "";
            $this->id_sendemail->HrefValue = "";
            $this->id_sendemail->TooltipValue = "";

            // sujeto
            $this->sujeto->LinkCustomAttributes = "";
            $this->sujeto->HrefValue = "";
            $this->sujeto->TooltipValue = "";

            // mensaje
            $this->mensaje->LinkCustomAttributes = "";
            $this->mensaje->HrefValue = "";
            $this->mensaje->TooltipValue = "";

            // tiempo
            $this->tiempo->LinkCustomAttributes = "";
            $this->tiempo->HrefValue = "";
            $this->tiempo->TooltipValue = "";

            // archivo
            $this->archivo->LinkCustomAttributes = "";
            $this->archivo->HrefValue = "";
            $this->archivo->ExportHrefValue = $this->archivo->UploadPath . $this->archivo->Upload->DbValue;
            $this->archivo->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // de_user
            $this->de_user->LinkCustomAttributes = "";
            $this->de_user->HrefValue = "";
            $this->de_user->TooltipValue = "";

            // copy_user
            $this->copy_user->LinkCustomAttributes = "";
            $this->copy_user->HrefValue = "";
            $this->copy_user->TooltipValue = "";

            // para_user
            $this->para_user->LinkCustomAttributes = "";
            $this->para_user->HrefValue = "";
            $this->para_user->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id_sendemail
            $this->id_sendemail->EditAttrs["class"] = "form-control";
            $this->id_sendemail->EditCustomAttributes = "";
            $this->id_sendemail->EditValue = $this->id_sendemail->CurrentValue;
            $this->id_sendemail->ViewCustomAttributes = "";

            // sujeto
            $this->sujeto->EditAttrs["class"] = "form-control";
            $this->sujeto->EditCustomAttributes = "";
            if (!$this->sujeto->Raw) {
                $this->sujeto->CurrentValue = HtmlDecode($this->sujeto->CurrentValue);
            }
            $this->sujeto->EditValue = HtmlEncode($this->sujeto->CurrentValue);
            $this->sujeto->PlaceHolder = RemoveHtml($this->sujeto->caption());

            // mensaje
            $this->mensaje->EditAttrs["class"] = "form-control";
            $this->mensaje->EditCustomAttributes = "";
            $this->mensaje->EditValue = HtmlEncode($this->mensaje->CurrentValue);
            $this->mensaje->PlaceHolder = RemoveHtml($this->mensaje->caption());

            // tiempo

            // archivo
            $this->archivo->EditAttrs["class"] = "form-control";
            $this->archivo->EditCustomAttributes = "";
            if (!EmptyValue($this->archivo->Upload->DbValue)) {
                $this->archivo->EditValue = $this->archivo->Upload->DbValue;
            } else {
                $this->archivo->EditValue = "";
            }
            if (!EmptyValue($this->archivo->CurrentValue)) {
                $this->archivo->Upload->FileName = $this->archivo->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->archivo);
            }

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // de_user

            // copy_user
            $this->copy_user->EditAttrs["class"] = "form-control";
            $this->copy_user->EditCustomAttributes = "";
            if (!$this->copy_user->Raw) {
                $this->copy_user->CurrentValue = HtmlDecode($this->copy_user->CurrentValue);
            }
            $this->copy_user->EditValue = HtmlEncode($this->copy_user->CurrentValue);
            $this->copy_user->PlaceHolder = RemoveHtml($this->copy_user->caption());

            // para_user
            $this->para_user->EditCustomAttributes = "";
            $curVal = trim(strval($this->para_user->CurrentValue));
            if ($curVal != "") {
                $this->para_user->ViewValue = $this->para_user->lookupCacheOption($curVal);
            } else {
                $this->para_user->ViewValue = $this->para_user->Lookup !== null && is_array($this->para_user->Lookup->Options) ? $curVal : null;
            }
            if ($this->para_user->ViewValue !== null) { // Load from cache
                $this->para_user->EditValue = array_values($this->para_user->Lookup->Options);
                if ($this->para_user->ViewValue == "") {
                    $this->para_user->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_users`" . SearchString("=", $this->para_user->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->para_user->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->para_user->Lookup->renderViewRow($rswrk[0]);
                    $this->para_user->ViewValue = $this->para_user->displayValue($arwrk);
                } else {
                    $this->para_user->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->para_user->EditValue = $arwrk;
            }
            $this->para_user->PlaceHolder = RemoveHtml($this->para_user->caption());

            // Edit refer script

            // id_sendemail
            $this->id_sendemail->LinkCustomAttributes = "";
            $this->id_sendemail->HrefValue = "";

            // sujeto
            $this->sujeto->LinkCustomAttributes = "";
            $this->sujeto->HrefValue = "";

            // mensaje
            $this->mensaje->LinkCustomAttributes = "";
            $this->mensaje->HrefValue = "";

            // tiempo
            $this->tiempo->LinkCustomAttributes = "";
            $this->tiempo->HrefValue = "";

            // archivo
            $this->archivo->LinkCustomAttributes = "";
            $this->archivo->HrefValue = "";
            $this->archivo->ExportHrefValue = $this->archivo->UploadPath . $this->archivo->Upload->DbValue;

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // de_user
            $this->de_user->LinkCustomAttributes = "";
            $this->de_user->HrefValue = "";

            // copy_user
            $this->copy_user->LinkCustomAttributes = "";
            $this->copy_user->HrefValue = "";

            // para_user
            $this->para_user->LinkCustomAttributes = "";
            $this->para_user->HrefValue = "";
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
        if ($this->id_sendemail->Required) {
            if (!$this->id_sendemail->IsDetailKey && EmptyValue($this->id_sendemail->FormValue)) {
                $this->id_sendemail->addErrorMessage(str_replace("%s", $this->id_sendemail->caption(), $this->id_sendemail->RequiredErrorMessage));
            }
        }
        if ($this->sujeto->Required) {
            if (!$this->sujeto->IsDetailKey && EmptyValue($this->sujeto->FormValue)) {
                $this->sujeto->addErrorMessage(str_replace("%s", $this->sujeto->caption(), $this->sujeto->RequiredErrorMessage));
            }
        }
        if ($this->mensaje->Required) {
            if (!$this->mensaje->IsDetailKey && EmptyValue($this->mensaje->FormValue)) {
                $this->mensaje->addErrorMessage(str_replace("%s", $this->mensaje->caption(), $this->mensaje->RequiredErrorMessage));
            }
        }
        if ($this->tiempo->Required) {
            if (!$this->tiempo->IsDetailKey && EmptyValue($this->tiempo->FormValue)) {
                $this->tiempo->addErrorMessage(str_replace("%s", $this->tiempo->caption(), $this->tiempo->RequiredErrorMessage));
            }
        }
        if ($this->archivo->Required) {
            if ($this->archivo->Upload->FileName == "" && !$this->archivo->Upload->KeepFile) {
                $this->archivo->addErrorMessage(str_replace("%s", $this->archivo->caption(), $this->archivo->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if ($this->status->FormValue == "") {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->de_user->Required) {
            if (!$this->de_user->IsDetailKey && EmptyValue($this->de_user->FormValue)) {
                $this->de_user->addErrorMessage(str_replace("%s", $this->de_user->caption(), $this->de_user->RequiredErrorMessage));
            }
        }
        if ($this->copy_user->Required) {
            if (!$this->copy_user->IsDetailKey && EmptyValue($this->copy_user->FormValue)) {
                $this->copy_user->addErrorMessage(str_replace("%s", $this->copy_user->caption(), $this->copy_user->RequiredErrorMessage));
            }
        }
        if ($this->para_user->Required) {
            if (!$this->para_user->IsDetailKey && EmptyValue($this->para_user->FormValue)) {
                $this->para_user->addErrorMessage(str_replace("%s", $this->para_user->caption(), $this->para_user->RequiredErrorMessage));
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

            // sujeto
            $this->sujeto->setDbValueDef($rsnew, $this->sujeto->CurrentValue, null, $this->sujeto->ReadOnly);

            // mensaje
            $this->mensaje->setDbValueDef($rsnew, $this->mensaje->CurrentValue, null, $this->mensaje->ReadOnly);

            // tiempo
            $this->tiempo->CurrentValue = CurrentDateTime();
            $this->tiempo->setDbValueDef($rsnew, $this->tiempo->CurrentValue, null);

            // archivo
            if ($this->archivo->Visible && !$this->archivo->ReadOnly && !$this->archivo->Upload->KeepFile) {
                $this->archivo->Upload->DbValue = $rsold['archivo']; // Get original value
                if ($this->archivo->Upload->FileName == "") {
                    $rsnew['archivo'] = null;
                } else {
                    $rsnew['archivo'] = $this->archivo->Upload->FileName;
                }
            }

            // status
            $tmpBool = $this->status->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->status->setDbValueDef($rsnew, $tmpBool, null, $this->status->ReadOnly);

            // de_user
            $this->de_user->CurrentValue = CurrentUserID();
            $this->de_user->setDbValueDef($rsnew, $this->de_user->CurrentValue, null);

            // copy_user
            $this->copy_user->setDbValueDef($rsnew, $this->copy_user->CurrentValue, null, $this->copy_user->ReadOnly);

            // para_user
            $this->para_user->setDbValueDef($rsnew, $this->para_user->CurrentValue, null, $this->para_user->ReadOnly);
            if ($this->archivo->Visible && !$this->archivo->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->archivo->Upload->DbValue) ? [] : [$this->archivo->htmlDecode($this->archivo->Upload->DbValue)];
                if (!EmptyValue($this->archivo->Upload->FileName)) {
                    $newFiles = [$this->archivo->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->archivo, $this->archivo->Upload->Index);
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
                                $file1 = UniqueFilename($this->archivo->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->archivo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->archivo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->archivo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->archivo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->archivo->setDbValueDef($rsnew, $this->archivo->Upload->FileName, null, $this->archivo->ReadOnly);
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
                    if ($this->archivo->Visible && !$this->archivo->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->archivo->Upload->DbValue) ? [] : [$this->archivo->htmlDecode($this->archivo->Upload->DbValue)];
                        if (!EmptyValue($this->archivo->Upload->FileName)) {
                            $newFiles = [$this->archivo->Upload->FileName];
                            $newFiles2 = [$this->archivo->htmlDecode($rsnew['archivo'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->archivo, $this->archivo->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->archivo->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->archivo->oldPhysicalUploadPath() . $oldFile);
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
            // archivo
            CleanUploadTempPath($this->archivo, $this->archivo->Upload->Index);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("SendEmail2List"), "", $this->TableVar, true);
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
                case "x_status":
                    break;
                case "x_para_user":
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
