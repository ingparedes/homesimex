<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ImboxMailEdit extends ImboxMail
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'imbox_mail';

    // Page object name
    public $PageObjName = "ImboxMailEdit";

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

        // Table object (imbox_mail)
        if (!isset($GLOBALS["imbox_mail"]) || get_class($GLOBALS["imbox_mail"]) == PROJECT_NAMESPACE . "imbox_mail") {
            $GLOBALS["imbox_mail"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'imbox_mail');
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
                $doc = new $class(Container("imbox_mail"));
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
                    if ($pageName == "ImboxMailView") {
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
            $key .= @$ar['id_email'];
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
            $this->id_email->Visible = false;
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
        $this->id_email->setVisibility();
        $this->sender_userid->setVisibility();
        $this->reciever_userid->setVisibility();
        $this->alerta->setVisibility();
        $this->copy_sender->setVisibility();
        $this->sujeto->setVisibility();
        $this->mensaje->setVisibility();
        $this->archivo->setVisibility();
        $this->tiempo->setVisibility();
        $this->estado_msg->setVisibility();
        $this->id_mensaje->setVisibility();
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
        $this->setupLookupOptions($this->sender_userid);
        $this->setupLookupOptions($this->reciever_userid);
        $this->setupLookupOptions($this->copy_sender);

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
            if (($keyValue = Get("id_email") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_email->setQueryStringValue($keyValue);
                $this->id_email->setOldValue($this->id_email->QueryStringValue);
            } elseif (Post("id_email") !== null) {
                $this->id_email->setFormValue(Post("id_email"));
                $this->id_email->setOldValue($this->id_email->FormValue);
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
                if (($keyValue = Get("id_email") ?? Route("id_email")) !== null) {
                    $this->id_email->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_email->CurrentValue = null;
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
                    $this->terminate("ImboxMailList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ImboxMailList") {
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
        $this->archivo->Upload->Index = $CurrentForm->Index;
        $this->archivo->Upload->uploadFile();
        $this->archivo->CurrentValue = $this->archivo->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_email' first before field var 'x_id_email'
        $val = $CurrentForm->hasValue("id_email") ? $CurrentForm->getValue("id_email") : $CurrentForm->getValue("x_id_email");
        if (!$this->id_email->IsDetailKey) {
            $this->id_email->setFormValue($val);
        }

        // Check field name 'sender_userid' first before field var 'x_sender_userid'
        $val = $CurrentForm->hasValue("sender_userid") ? $CurrentForm->getValue("sender_userid") : $CurrentForm->getValue("x_sender_userid");
        if (!$this->sender_userid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sender_userid->Visible = false; // Disable update for API request
            } else {
                $this->sender_userid->setFormValue($val);
            }
        }

        // Check field name 'reciever_userid' first before field var 'x_reciever_userid'
        $val = $CurrentForm->hasValue("reciever_userid") ? $CurrentForm->getValue("reciever_userid") : $CurrentForm->getValue("x_reciever_userid");
        if (!$this->reciever_userid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->reciever_userid->Visible = false; // Disable update for API request
            } else {
                $this->reciever_userid->setFormValue($val);
            }
        }

        // Check field name 'alerta' first before field var 'x_alerta'
        $val = $CurrentForm->hasValue("alerta") ? $CurrentForm->getValue("alerta") : $CurrentForm->getValue("x_alerta");
        if (!$this->alerta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alerta->Visible = false; // Disable update for API request
            } else {
                $this->alerta->setFormValue($val);
            }
        }

        // Check field name 'copy_sender' first before field var 'x_copy_sender'
        $val = $CurrentForm->hasValue("copy_sender") ? $CurrentForm->getValue("copy_sender") : $CurrentForm->getValue("x_copy_sender");
        if (!$this->copy_sender->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->copy_sender->Visible = false; // Disable update for API request
            } else {
                $this->copy_sender->setFormValue($val);
            }
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
            $this->tiempo->CurrentValue = UnFormatDateTime($this->tiempo->CurrentValue, 9);
        }

        // Check field name 'estado_msg' first before field var 'x_estado_msg'
        $val = $CurrentForm->hasValue("estado_msg") ? $CurrentForm->getValue("estado_msg") : $CurrentForm->getValue("x_estado_msg");
        if (!$this->estado_msg->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estado_msg->Visible = false; // Disable update for API request
            } else {
                $this->estado_msg->setFormValue($val);
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
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_email->CurrentValue = $this->id_email->FormValue;
        $this->sender_userid->CurrentValue = $this->sender_userid->FormValue;
        $this->reciever_userid->CurrentValue = $this->reciever_userid->FormValue;
        $this->alerta->CurrentValue = $this->alerta->FormValue;
        $this->copy_sender->CurrentValue = $this->copy_sender->FormValue;
        $this->sujeto->CurrentValue = $this->sujeto->FormValue;
        $this->mensaje->CurrentValue = $this->mensaje->FormValue;
        $this->tiempo->CurrentValue = $this->tiempo->FormValue;
        $this->tiempo->CurrentValue = UnFormatDateTime($this->tiempo->CurrentValue, 9);
        $this->estado_msg->CurrentValue = $this->estado_msg->FormValue;
        $this->id_mensaje->CurrentValue = $this->id_mensaje->FormValue;
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
        $this->id_email->setDbValue($row['id_email']);
        $this->sender_userid->setDbValue($row['sender_userid']);
        $this->reciever_userid->setDbValue($row['reciever_userid']);
        $this->alerta->setDbValue($row['alerta']);
        $this->copy_sender->setDbValue($row['copy_sender']);
        $this->sujeto->setDbValue($row['sujeto']);
        $this->mensaje->setDbValue($row['mensaje']);
        $this->archivo->Upload->DbValue = $row['archivo'];
        $this->archivo->setDbValue($this->archivo->Upload->DbValue);
        $this->tiempo->setDbValue($row['tiempo']);
        $this->estado_msg->setDbValue($row['estado_msg']);
        $this->id_mensaje->setDbValue($row['id_mensaje']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_email'] = null;
        $row['sender_userid'] = null;
        $row['reciever_userid'] = null;
        $row['alerta'] = null;
        $row['copy_sender'] = null;
        $row['sujeto'] = null;
        $row['mensaje'] = null;
        $row['archivo'] = null;
        $row['tiempo'] = null;
        $row['estado_msg'] = null;
        $row['id_mensaje'] = null;
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

        // id_email

        // sender_userid

        // reciever_userid

        // alerta

        // copy_sender

        // sujeto

        // mensaje

        // archivo

        // tiempo

        // estado_msg

        // id_mensaje
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_email
            $this->id_email->ViewValue = $this->id_email->CurrentValue;
            $this->id_email->ViewCustomAttributes = "";

            // sender_userid
            $curVal = trim(strval($this->sender_userid->CurrentValue));
            if ($curVal != "") {
                $this->sender_userid->ViewValue = $this->sender_userid->lookupCacheOption($curVal);
                if ($this->sender_userid->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`id_users`" . SearchString("=", trim($wrk), DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return "`id_users` !=  '".CurrentUserID()."'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->sender_userid->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->sender_userid->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->sender_userid->Lookup->renderViewRow($row);
                            $this->sender_userid->ViewValue->add($this->sender_userid->displayValue($arwrk));
                        }
                    } else {
                        $this->sender_userid->ViewValue = $this->sender_userid->CurrentValue;
                    }
                }
            } else {
                $this->sender_userid->ViewValue = null;
            }
            $this->sender_userid->ViewCustomAttributes = "";

            // reciever_userid
            $this->reciever_userid->ViewValue = $this->reciever_userid->CurrentValue;
            $curVal = trim(strval($this->reciever_userid->CurrentValue));
            if ($curVal != "") {
                $this->reciever_userid->ViewValue = $this->reciever_userid->lookupCacheOption($curVal);
                if ($this->reciever_userid->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_users`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->reciever_userid->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->reciever_userid->Lookup->renderViewRow($rswrk[0]);
                        $this->reciever_userid->ViewValue = $this->reciever_userid->displayValue($arwrk);
                    } else {
                        $this->reciever_userid->ViewValue = $this->reciever_userid->CurrentValue;
                    }
                }
            } else {
                $this->reciever_userid->ViewValue = null;
            }
            $this->reciever_userid->ViewCustomAttributes = "";

            // alerta
            $this->alerta->ViewValue = $this->alerta->CurrentValue;
            $this->alerta->ViewCustomAttributes = "";

            // copy_sender
            $curVal = trim(strval($this->copy_sender->CurrentValue));
            if ($curVal != "") {
                $this->copy_sender->ViewValue = $this->copy_sender->lookupCacheOption($curVal);
                if ($this->copy_sender->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`id_users`" . SearchString("=", trim($wrk), DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return "`id_users` !=  '".CurrentUserID()."'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->copy_sender->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->copy_sender->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->copy_sender->Lookup->renderViewRow($row);
                            $this->copy_sender->ViewValue->add($this->copy_sender->displayValue($arwrk));
                        }
                    } else {
                        $this->copy_sender->ViewValue = $this->copy_sender->CurrentValue;
                    }
                }
            } else {
                $this->copy_sender->ViewValue = null;
            }
            $this->copy_sender->ViewCustomAttributes = "";

            // sujeto
            $this->sujeto->ViewValue = $this->sujeto->CurrentValue;
            $this->sujeto->ViewCustomAttributes = "";

            // mensaje
            $this->mensaje->ViewValue = $this->mensaje->CurrentValue;
            $this->mensaje->ViewCustomAttributes = "";

            // archivo
            if (!EmptyValue($this->archivo->Upload->DbValue)) {
                $this->archivo->ViewValue = $this->archivo->Upload->DbValue;
            } else {
                $this->archivo->ViewValue = "";
            }
            $this->archivo->ViewCustomAttributes = "";

            // tiempo
            $this->tiempo->ViewValue = $this->tiempo->CurrentValue;
            $this->tiempo->ViewValue = FormatDateTime($this->tiempo->ViewValue, 9);
            $this->tiempo->ViewCustomAttributes = "";

            // estado_msg
            $this->estado_msg->ViewValue = $this->estado_msg->CurrentValue;
            $this->estado_msg->ViewValue = FormatNumber($this->estado_msg->ViewValue, 0, -2, -2, -2);
            $this->estado_msg->ViewCustomAttributes = "";

            // id_mensaje
            $this->id_mensaje->ViewValue = $this->id_mensaje->CurrentValue;
            $this->id_mensaje->ViewValue = FormatNumber($this->id_mensaje->ViewValue, 0, -2, -2, -2);
            $this->id_mensaje->ViewCustomAttributes = "";

            // id_email
            $this->id_email->LinkCustomAttributes = "";
            $this->id_email->HrefValue = "";
            $this->id_email->TooltipValue = "";

            // sender_userid
            $this->sender_userid->LinkCustomAttributes = "";
            $this->sender_userid->HrefValue = "";
            $this->sender_userid->TooltipValue = "";

            // reciever_userid
            $this->reciever_userid->LinkCustomAttributes = "";
            $this->reciever_userid->HrefValue = "";
            $this->reciever_userid->TooltipValue = "";

            // alerta
            $this->alerta->LinkCustomAttributes = "";
            $this->alerta->HrefValue = "";
            $this->alerta->TooltipValue = "";

            // copy_sender
            $this->copy_sender->LinkCustomAttributes = "";
            $this->copy_sender->HrefValue = "";
            $this->copy_sender->TooltipValue = "";

            // sujeto
            $this->sujeto->LinkCustomAttributes = "";
            $this->sujeto->HrefValue = "";
            $this->sujeto->TooltipValue = "";

            // mensaje
            $this->mensaje->LinkCustomAttributes = "";
            $this->mensaje->HrefValue = "";
            $this->mensaje->TooltipValue = "";

            // archivo
            $this->archivo->LinkCustomAttributes = "";
            $this->archivo->HrefValue = "";
            $this->archivo->ExportHrefValue = $this->archivo->UploadPath . $this->archivo->Upload->DbValue;
            $this->archivo->TooltipValue = "";

            // tiempo
            $this->tiempo->LinkCustomAttributes = "";
            $this->tiempo->HrefValue = "";
            $this->tiempo->TooltipValue = "";

            // estado_msg
            $this->estado_msg->LinkCustomAttributes = "";
            $this->estado_msg->HrefValue = "";
            $this->estado_msg->TooltipValue = "";

            // id_mensaje
            $this->id_mensaje->LinkCustomAttributes = "";
            $this->id_mensaje->HrefValue = "";
            $this->id_mensaje->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id_email
            $this->id_email->EditAttrs["class"] = "form-control";
            $this->id_email->EditCustomAttributes = "";
            $this->id_email->EditValue = $this->id_email->CurrentValue;
            $this->id_email->ViewCustomAttributes = "";

            // sender_userid
            $this->sender_userid->EditCustomAttributes = "";
            $curVal = trim(strval($this->sender_userid->CurrentValue));
            if ($curVal != "") {
                $this->sender_userid->ViewValue = $this->sender_userid->lookupCacheOption($curVal);
            } else {
                $this->sender_userid->ViewValue = $this->sender_userid->Lookup !== null && is_array($this->sender_userid->Lookup->Options) ? $curVal : null;
            }
            if ($this->sender_userid->ViewValue !== null) { // Load from cache
                $this->sender_userid->EditValue = array_values($this->sender_userid->Lookup->Options);
                if ($this->sender_userid->ViewValue == "") {
                    $this->sender_userid->ViewValue = $Language->phrase("PleaseSelect");
                }
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
                        $filterWrk .= "`id_users`" . SearchString("=", trim($wrk), DATATYPE_NUMBER, "");
                    }
                }
                $lookupFilter = function() {
                    return "`id_users` !=  '".CurrentUserID()."'";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->sender_userid->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->sender_userid->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->sender_userid->Lookup->renderViewRow($row);
                        $this->sender_userid->ViewValue->add($this->sender_userid->displayValue($arwrk));
                        $ari++;
                    }
                } else {
                    $this->sender_userid->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->sender_userid->EditValue = $arwrk;
            }
            $this->sender_userid->PlaceHolder = RemoveHtml($this->sender_userid->caption());

            // reciever_userid

            // alerta
            $this->alerta->EditAttrs["class"] = "form-control";
            $this->alerta->EditCustomAttributes = "";
            $this->alerta->EditValue = HtmlEncode($this->alerta->CurrentValue);
            $this->alerta->PlaceHolder = RemoveHtml($this->alerta->caption());

            // copy_sender
            $this->copy_sender->EditCustomAttributes = "";
            $curVal = trim(strval($this->copy_sender->CurrentValue));
            if ($curVal != "") {
                $this->copy_sender->ViewValue = $this->copy_sender->lookupCacheOption($curVal);
            } else {
                $this->copy_sender->ViewValue = $this->copy_sender->Lookup !== null && is_array($this->copy_sender->Lookup->Options) ? $curVal : null;
            }
            if ($this->copy_sender->ViewValue !== null) { // Load from cache
                $this->copy_sender->EditValue = array_values($this->copy_sender->Lookup->Options);
                if ($this->copy_sender->ViewValue == "") {
                    $this->copy_sender->ViewValue = $Language->phrase("PleaseSelect");
                }
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
                        $filterWrk .= "`id_users`" . SearchString("=", trim($wrk), DATATYPE_NUMBER, "");
                    }
                }
                $lookupFilter = function() {
                    return "`id_users` !=  '".CurrentUserID()."'";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->copy_sender->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->copy_sender->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->copy_sender->Lookup->renderViewRow($row);
                        $this->copy_sender->ViewValue->add($this->copy_sender->displayValue($arwrk));
                        $ari++;
                    }
                } else {
                    $this->copy_sender->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->copy_sender->EditValue = $arwrk;
            }
            $this->copy_sender->PlaceHolder = RemoveHtml($this->copy_sender->caption());

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

            // tiempo

            // estado_msg
            $this->estado_msg->EditAttrs["class"] = "form-control";
            $this->estado_msg->EditCustomAttributes = "";
            $this->estado_msg->EditValue = HtmlEncode($this->estado_msg->CurrentValue);
            $this->estado_msg->PlaceHolder = RemoveHtml($this->estado_msg->caption());

            // id_mensaje
            $this->id_mensaje->EditAttrs["class"] = "form-control";
            $this->id_mensaje->EditCustomAttributes = "";
            $this->id_mensaje->EditValue = HtmlEncode($this->id_mensaje->CurrentValue);
            $this->id_mensaje->PlaceHolder = RemoveHtml($this->id_mensaje->caption());

            // Edit refer script

            // id_email
            $this->id_email->LinkCustomAttributes = "";
            $this->id_email->HrefValue = "";

            // sender_userid
            $this->sender_userid->LinkCustomAttributes = "";
            $this->sender_userid->HrefValue = "";

            // reciever_userid
            $this->reciever_userid->LinkCustomAttributes = "";
            $this->reciever_userid->HrefValue = "";

            // alerta
            $this->alerta->LinkCustomAttributes = "";
            $this->alerta->HrefValue = "";

            // copy_sender
            $this->copy_sender->LinkCustomAttributes = "";
            $this->copy_sender->HrefValue = "";

            // sujeto
            $this->sujeto->LinkCustomAttributes = "";
            $this->sujeto->HrefValue = "";

            // mensaje
            $this->mensaje->LinkCustomAttributes = "";
            $this->mensaje->HrefValue = "";

            // archivo
            $this->archivo->LinkCustomAttributes = "";
            $this->archivo->HrefValue = "";
            $this->archivo->ExportHrefValue = $this->archivo->UploadPath . $this->archivo->Upload->DbValue;

            // tiempo
            $this->tiempo->LinkCustomAttributes = "";
            $this->tiempo->HrefValue = "";

            // estado_msg
            $this->estado_msg->LinkCustomAttributes = "";
            $this->estado_msg->HrefValue = "";

            // id_mensaje
            $this->id_mensaje->LinkCustomAttributes = "";
            $this->id_mensaje->HrefValue = "";
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
        if ($this->id_email->Required) {
            if (!$this->id_email->IsDetailKey && EmptyValue($this->id_email->FormValue)) {
                $this->id_email->addErrorMessage(str_replace("%s", $this->id_email->caption(), $this->id_email->RequiredErrorMessage));
            }
        }
        if ($this->sender_userid->Required) {
            if ($this->sender_userid->FormValue == "") {
                $this->sender_userid->addErrorMessage(str_replace("%s", $this->sender_userid->caption(), $this->sender_userid->RequiredErrorMessage));
            }
        }
        if ($this->reciever_userid->Required) {
            if (!$this->reciever_userid->IsDetailKey && EmptyValue($this->reciever_userid->FormValue)) {
                $this->reciever_userid->addErrorMessage(str_replace("%s", $this->reciever_userid->caption(), $this->reciever_userid->RequiredErrorMessage));
            }
        }
        if ($this->alerta->Required) {
            if (!$this->alerta->IsDetailKey && EmptyValue($this->alerta->FormValue)) {
                $this->alerta->addErrorMessage(str_replace("%s", $this->alerta->caption(), $this->alerta->RequiredErrorMessage));
            }
        }
        if ($this->copy_sender->Required) {
            if ($this->copy_sender->FormValue == "") {
                $this->copy_sender->addErrorMessage(str_replace("%s", $this->copy_sender->caption(), $this->copy_sender->RequiredErrorMessage));
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
        if ($this->archivo->Required) {
            if ($this->archivo->Upload->FileName == "" && !$this->archivo->Upload->KeepFile) {
                $this->archivo->addErrorMessage(str_replace("%s", $this->archivo->caption(), $this->archivo->RequiredErrorMessage));
            }
        }
        if ($this->tiempo->Required) {
            if (!$this->tiempo->IsDetailKey && EmptyValue($this->tiempo->FormValue)) {
                $this->tiempo->addErrorMessage(str_replace("%s", $this->tiempo->caption(), $this->tiempo->RequiredErrorMessage));
            }
        }
        if ($this->estado_msg->Required) {
            if (!$this->estado_msg->IsDetailKey && EmptyValue($this->estado_msg->FormValue)) {
                $this->estado_msg->addErrorMessage(str_replace("%s", $this->estado_msg->caption(), $this->estado_msg->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->estado_msg->FormValue)) {
            $this->estado_msg->addErrorMessage($this->estado_msg->getErrorMessage(false));
        }
        if ($this->id_mensaje->Required) {
            if (!$this->id_mensaje->IsDetailKey && EmptyValue($this->id_mensaje->FormValue)) {
                $this->id_mensaje->addErrorMessage(str_replace("%s", $this->id_mensaje->caption(), $this->id_mensaje->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id_mensaje->FormValue)) {
            $this->id_mensaje->addErrorMessage($this->id_mensaje->getErrorMessage(false));
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

            // sender_userid
            $this->sender_userid->setDbValueDef($rsnew, $this->sender_userid->CurrentValue, null, $this->sender_userid->ReadOnly);

            // reciever_userid
            $this->reciever_userid->CurrentValue = CurrentUserID();
            $this->reciever_userid->setDbValueDef($rsnew, $this->reciever_userid->CurrentValue, null);

            // alerta
            $this->alerta->setDbValueDef($rsnew, $this->alerta->CurrentValue, "", $this->alerta->ReadOnly);

            // copy_sender
            $this->copy_sender->setDbValueDef($rsnew, $this->copy_sender->CurrentValue, null, $this->copy_sender->ReadOnly);

            // sujeto
            $this->sujeto->setDbValueDef($rsnew, $this->sujeto->CurrentValue, null, $this->sujeto->ReadOnly);

            // mensaje
            $this->mensaje->setDbValueDef($rsnew, $this->mensaje->CurrentValue, null, $this->mensaje->ReadOnly);

            // archivo
            if ($this->archivo->Visible && !$this->archivo->ReadOnly && !$this->archivo->Upload->KeepFile) {
                $this->archivo->Upload->DbValue = $rsold['archivo']; // Get original value
                if ($this->archivo->Upload->FileName == "") {
                    $rsnew['archivo'] = null;
                } else {
                    $rsnew['archivo'] = $this->archivo->Upload->FileName;
                }
            }

            // tiempo
            $this->tiempo->CurrentValue = CurrentDateTime();
            $this->tiempo->setDbValueDef($rsnew, $this->tiempo->CurrentValue, null);

            // estado_msg
            $this->estado_msg->setDbValueDef($rsnew, $this->estado_msg->CurrentValue, null, $this->estado_msg->ReadOnly);

            // id_mensaje
            $this->id_mensaje->setDbValueDef($rsnew, $this->id_mensaje->CurrentValue, null, $this->id_mensaje->ReadOnly);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ImboxMailList"), "", $this->TableVar, true);
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
                case "x_sender_userid":
                    $lookupFilter = function () {
                        return "`id_users` !=  '".CurrentUserID()."'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_reciever_userid":
                    break;
                case "x_copy_sender":
                    $lookupFilter = function () {
                        return "`id_users` !=  '".CurrentUserID()."'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
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
