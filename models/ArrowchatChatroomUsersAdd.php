<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ArrowchatChatroomUsersAdd extends ArrowchatChatroomUsers
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'arrowchat_chatroom_users';

    // Page object name
    public $PageObjName = "ArrowchatChatroomUsersAdd";

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

        // Table object (arrowchat_chatroom_users)
        if (!isset($GLOBALS["arrowchat_chatroom_users"]) || get_class($GLOBALS["arrowchat_chatroom_users"]) == PROJECT_NAMESPACE . "arrowchat_chatroom_users") {
            $GLOBALS["arrowchat_chatroom_users"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'arrowchat_chatroom_users');
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
                $doc = new $class(Container("arrowchat_chatroom_users"));
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
                    if ($pageName == "ArrowchatChatroomUsersView") {
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
            $key .= @$ar['user_id'] . Config("COMPOSITE_KEY_SEPARATOR");
            $key .= @$ar['chatroom_id'];
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
        $this->user_id->setVisibility();
        $this->chatroom_id->setVisibility();
        $this->is_admin->setVisibility();
        $this->is_mod->setVisibility();
        $this->block_chats->setVisibility();
        $this->silence_length->setVisibility();
        $this->silence_time->setVisibility();
        $this->session_time->setVisibility();
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
            if (($keyValue = Get("user_id") ?? Route("user_id")) !== null) {
                $this->user_id->setQueryStringValue($keyValue);
            }
            if (($keyValue = Get("chatroom_id") ?? Route("chatroom_id")) !== null) {
                $this->chatroom_id->setQueryStringValue($keyValue);
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
                    $this->terminate("ArrowchatChatroomUsersList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "ArrowchatChatroomUsersList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ArrowchatChatroomUsersView") {
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
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->user_id->CurrentValue = null;
        $this->user_id->OldValue = $this->user_id->CurrentValue;
        $this->chatroom_id->CurrentValue = null;
        $this->chatroom_id->OldValue = $this->chatroom_id->CurrentValue;
        $this->is_admin->CurrentValue = 0;
        $this->is_mod->CurrentValue = 0;
        $this->block_chats->CurrentValue = 0;
        $this->silence_length->CurrentValue = null;
        $this->silence_length->OldValue = $this->silence_length->CurrentValue;
        $this->silence_time->CurrentValue = null;
        $this->silence_time->OldValue = $this->silence_time->CurrentValue;
        $this->session_time->CurrentValue = null;
        $this->session_time->OldValue = $this->session_time->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'user_id' first before field var 'x_user_id'
        $val = $CurrentForm->hasValue("user_id") ? $CurrentForm->getValue("user_id") : $CurrentForm->getValue("x_user_id");
        if (!$this->user_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_id->Visible = false; // Disable update for API request
            } else {
                $this->user_id->setFormValue($val);
            }
        }

        // Check field name 'chatroom_id' first before field var 'x_chatroom_id'
        $val = $CurrentForm->hasValue("chatroom_id") ? $CurrentForm->getValue("chatroom_id") : $CurrentForm->getValue("x_chatroom_id");
        if (!$this->chatroom_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->chatroom_id->Visible = false; // Disable update for API request
            } else {
                $this->chatroom_id->setFormValue($val);
            }
        }

        // Check field name 'is_admin' first before field var 'x_is_admin'
        $val = $CurrentForm->hasValue("is_admin") ? $CurrentForm->getValue("is_admin") : $CurrentForm->getValue("x_is_admin");
        if (!$this->is_admin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->is_admin->Visible = false; // Disable update for API request
            } else {
                $this->is_admin->setFormValue($val);
            }
        }

        // Check field name 'is_mod' first before field var 'x_is_mod'
        $val = $CurrentForm->hasValue("is_mod") ? $CurrentForm->getValue("is_mod") : $CurrentForm->getValue("x_is_mod");
        if (!$this->is_mod->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->is_mod->Visible = false; // Disable update for API request
            } else {
                $this->is_mod->setFormValue($val);
            }
        }

        // Check field name 'block_chats' first before field var 'x_block_chats'
        $val = $CurrentForm->hasValue("block_chats") ? $CurrentForm->getValue("block_chats") : $CurrentForm->getValue("x_block_chats");
        if (!$this->block_chats->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->block_chats->Visible = false; // Disable update for API request
            } else {
                $this->block_chats->setFormValue($val);
            }
        }

        // Check field name 'silence_length' first before field var 'x_silence_length'
        $val = $CurrentForm->hasValue("silence_length") ? $CurrentForm->getValue("silence_length") : $CurrentForm->getValue("x_silence_length");
        if (!$this->silence_length->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->silence_length->Visible = false; // Disable update for API request
            } else {
                $this->silence_length->setFormValue($val);
            }
        }

        // Check field name 'silence_time' first before field var 'x_silence_time'
        $val = $CurrentForm->hasValue("silence_time") ? $CurrentForm->getValue("silence_time") : $CurrentForm->getValue("x_silence_time");
        if (!$this->silence_time->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->silence_time->Visible = false; // Disable update for API request
            } else {
                $this->silence_time->setFormValue($val);
            }
        }

        // Check field name 'session_time' first before field var 'x_session_time'
        $val = $CurrentForm->hasValue("session_time") ? $CurrentForm->getValue("session_time") : $CurrentForm->getValue("x_session_time");
        if (!$this->session_time->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->session_time->Visible = false; // Disable update for API request
            } else {
                $this->session_time->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->user_id->CurrentValue = $this->user_id->FormValue;
        $this->chatroom_id->CurrentValue = $this->chatroom_id->FormValue;
        $this->is_admin->CurrentValue = $this->is_admin->FormValue;
        $this->is_mod->CurrentValue = $this->is_mod->FormValue;
        $this->block_chats->CurrentValue = $this->block_chats->FormValue;
        $this->silence_length->CurrentValue = $this->silence_length->FormValue;
        $this->silence_time->CurrentValue = $this->silence_time->FormValue;
        $this->session_time->CurrentValue = $this->session_time->FormValue;
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
        $this->user_id->setDbValue($row['user_id']);
        $this->chatroom_id->setDbValue($row['chatroom_id']);
        $this->is_admin->setDbValue($row['is_admin']);
        $this->is_mod->setDbValue($row['is_mod']);
        $this->block_chats->setDbValue($row['block_chats']);
        $this->silence_length->setDbValue($row['silence_length']);
        $this->silence_time->setDbValue($row['silence_time']);
        $this->session_time->setDbValue($row['session_time']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['user_id'] = $this->user_id->CurrentValue;
        $row['chatroom_id'] = $this->chatroom_id->CurrentValue;
        $row['is_admin'] = $this->is_admin->CurrentValue;
        $row['is_mod'] = $this->is_mod->CurrentValue;
        $row['block_chats'] = $this->block_chats->CurrentValue;
        $row['silence_length'] = $this->silence_length->CurrentValue;
        $row['silence_time'] = $this->silence_time->CurrentValue;
        $row['session_time'] = $this->session_time->CurrentValue;
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

        // user_id

        // chatroom_id

        // is_admin

        // is_mod

        // block_chats

        // silence_length

        // silence_time

        // session_time
        if ($this->RowType == ROWTYPE_VIEW) {
            // user_id
            $this->user_id->ViewValue = $this->user_id->CurrentValue;
            $this->user_id->ViewCustomAttributes = "";

            // chatroom_id
            $this->chatroom_id->ViewValue = $this->chatroom_id->CurrentValue;
            $this->chatroom_id->ViewValue = FormatNumber($this->chatroom_id->ViewValue, 0, -2, -2, -2);
            $this->chatroom_id->ViewCustomAttributes = "";

            // is_admin
            if (ConvertToBool($this->is_admin->CurrentValue)) {
                $this->is_admin->ViewValue = $this->is_admin->tagCaption(1) != "" ? $this->is_admin->tagCaption(1) : "Yes";
            } else {
                $this->is_admin->ViewValue = $this->is_admin->tagCaption(2) != "" ? $this->is_admin->tagCaption(2) : "No";
            }
            $this->is_admin->ViewCustomAttributes = "";

            // is_mod
            if (ConvertToBool($this->is_mod->CurrentValue)) {
                $this->is_mod->ViewValue = $this->is_mod->tagCaption(1) != "" ? $this->is_mod->tagCaption(1) : "Yes";
            } else {
                $this->is_mod->ViewValue = $this->is_mod->tagCaption(2) != "" ? $this->is_mod->tagCaption(2) : "No";
            }
            $this->is_mod->ViewCustomAttributes = "";

            // block_chats
            $this->block_chats->ViewValue = $this->block_chats->CurrentValue;
            $this->block_chats->ViewValue = FormatNumber($this->block_chats->ViewValue, 0, -2, -2, -2);
            $this->block_chats->ViewCustomAttributes = "";

            // silence_length
            $this->silence_length->ViewValue = $this->silence_length->CurrentValue;
            $this->silence_length->ViewValue = FormatNumber($this->silence_length->ViewValue, 0, -2, -2, -2);
            $this->silence_length->ViewCustomAttributes = "";

            // silence_time
            $this->silence_time->ViewValue = $this->silence_time->CurrentValue;
            $this->silence_time->ViewValue = FormatNumber($this->silence_time->ViewValue, 0, -2, -2, -2);
            $this->silence_time->ViewCustomAttributes = "";

            // session_time
            $this->session_time->ViewValue = $this->session_time->CurrentValue;
            $this->session_time->ViewValue = FormatNumber($this->session_time->ViewValue, 0, -2, -2, -2);
            $this->session_time->ViewCustomAttributes = "";

            // user_id
            $this->user_id->LinkCustomAttributes = "";
            $this->user_id->HrefValue = "";
            $this->user_id->TooltipValue = "";

            // chatroom_id
            $this->chatroom_id->LinkCustomAttributes = "";
            $this->chatroom_id->HrefValue = "";
            $this->chatroom_id->TooltipValue = "";

            // is_admin
            $this->is_admin->LinkCustomAttributes = "";
            $this->is_admin->HrefValue = "";
            $this->is_admin->TooltipValue = "";

            // is_mod
            $this->is_mod->LinkCustomAttributes = "";
            $this->is_mod->HrefValue = "";
            $this->is_mod->TooltipValue = "";

            // block_chats
            $this->block_chats->LinkCustomAttributes = "";
            $this->block_chats->HrefValue = "";
            $this->block_chats->TooltipValue = "";

            // silence_length
            $this->silence_length->LinkCustomAttributes = "";
            $this->silence_length->HrefValue = "";
            $this->silence_length->TooltipValue = "";

            // silence_time
            $this->silence_time->LinkCustomAttributes = "";
            $this->silence_time->HrefValue = "";
            $this->silence_time->TooltipValue = "";

            // session_time
            $this->session_time->LinkCustomAttributes = "";
            $this->session_time->HrefValue = "";
            $this->session_time->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // user_id
            $this->user_id->EditAttrs["class"] = "form-control";
            $this->user_id->EditCustomAttributes = "";
            if (!$this->user_id->Raw) {
                $this->user_id->CurrentValue = HtmlDecode($this->user_id->CurrentValue);
            }
            $this->user_id->EditValue = HtmlEncode($this->user_id->CurrentValue);
            $this->user_id->PlaceHolder = RemoveHtml($this->user_id->caption());

            // chatroom_id
            $this->chatroom_id->EditAttrs["class"] = "form-control";
            $this->chatroom_id->EditCustomAttributes = "";
            $this->chatroom_id->EditValue = HtmlEncode($this->chatroom_id->CurrentValue);
            $this->chatroom_id->PlaceHolder = RemoveHtml($this->chatroom_id->caption());

            // is_admin
            $this->is_admin->EditCustomAttributes = "";
            $this->is_admin->EditValue = $this->is_admin->options(false);
            $this->is_admin->PlaceHolder = RemoveHtml($this->is_admin->caption());

            // is_mod
            $this->is_mod->EditCustomAttributes = "";
            $this->is_mod->EditValue = $this->is_mod->options(false);
            $this->is_mod->PlaceHolder = RemoveHtml($this->is_mod->caption());

            // block_chats
            $this->block_chats->EditAttrs["class"] = "form-control";
            $this->block_chats->EditCustomAttributes = "";
            $this->block_chats->EditValue = HtmlEncode($this->block_chats->CurrentValue);
            $this->block_chats->PlaceHolder = RemoveHtml($this->block_chats->caption());

            // silence_length
            $this->silence_length->EditAttrs["class"] = "form-control";
            $this->silence_length->EditCustomAttributes = "";
            $this->silence_length->EditValue = HtmlEncode($this->silence_length->CurrentValue);
            $this->silence_length->PlaceHolder = RemoveHtml($this->silence_length->caption());

            // silence_time
            $this->silence_time->EditAttrs["class"] = "form-control";
            $this->silence_time->EditCustomAttributes = "";
            $this->silence_time->EditValue = HtmlEncode($this->silence_time->CurrentValue);
            $this->silence_time->PlaceHolder = RemoveHtml($this->silence_time->caption());

            // session_time
            $this->session_time->EditAttrs["class"] = "form-control";
            $this->session_time->EditCustomAttributes = "";
            $this->session_time->EditValue = HtmlEncode($this->session_time->CurrentValue);
            $this->session_time->PlaceHolder = RemoveHtml($this->session_time->caption());

            // Add refer script

            // user_id
            $this->user_id->LinkCustomAttributes = "";
            $this->user_id->HrefValue = "";

            // chatroom_id
            $this->chatroom_id->LinkCustomAttributes = "";
            $this->chatroom_id->HrefValue = "";

            // is_admin
            $this->is_admin->LinkCustomAttributes = "";
            $this->is_admin->HrefValue = "";

            // is_mod
            $this->is_mod->LinkCustomAttributes = "";
            $this->is_mod->HrefValue = "";

            // block_chats
            $this->block_chats->LinkCustomAttributes = "";
            $this->block_chats->HrefValue = "";

            // silence_length
            $this->silence_length->LinkCustomAttributes = "";
            $this->silence_length->HrefValue = "";

            // silence_time
            $this->silence_time->LinkCustomAttributes = "";
            $this->silence_time->HrefValue = "";

            // session_time
            $this->session_time->LinkCustomAttributes = "";
            $this->session_time->HrefValue = "";
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
        if ($this->user_id->Required) {
            if (!$this->user_id->IsDetailKey && EmptyValue($this->user_id->FormValue)) {
                $this->user_id->addErrorMessage(str_replace("%s", $this->user_id->caption(), $this->user_id->RequiredErrorMessage));
            }
        }
        if ($this->chatroom_id->Required) {
            if (!$this->chatroom_id->IsDetailKey && EmptyValue($this->chatroom_id->FormValue)) {
                $this->chatroom_id->addErrorMessage(str_replace("%s", $this->chatroom_id->caption(), $this->chatroom_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->chatroom_id->FormValue)) {
            $this->chatroom_id->addErrorMessage($this->chatroom_id->getErrorMessage(false));
        }
        if ($this->is_admin->Required) {
            if ($this->is_admin->FormValue == "") {
                $this->is_admin->addErrorMessage(str_replace("%s", $this->is_admin->caption(), $this->is_admin->RequiredErrorMessage));
            }
        }
        if ($this->is_mod->Required) {
            if ($this->is_mod->FormValue == "") {
                $this->is_mod->addErrorMessage(str_replace("%s", $this->is_mod->caption(), $this->is_mod->RequiredErrorMessage));
            }
        }
        if ($this->block_chats->Required) {
            if (!$this->block_chats->IsDetailKey && EmptyValue($this->block_chats->FormValue)) {
                $this->block_chats->addErrorMessage(str_replace("%s", $this->block_chats->caption(), $this->block_chats->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->block_chats->FormValue)) {
            $this->block_chats->addErrorMessage($this->block_chats->getErrorMessage(false));
        }
        if ($this->silence_length->Required) {
            if (!$this->silence_length->IsDetailKey && EmptyValue($this->silence_length->FormValue)) {
                $this->silence_length->addErrorMessage(str_replace("%s", $this->silence_length->caption(), $this->silence_length->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->silence_length->FormValue)) {
            $this->silence_length->addErrorMessage($this->silence_length->getErrorMessage(false));
        }
        if ($this->silence_time->Required) {
            if (!$this->silence_time->IsDetailKey && EmptyValue($this->silence_time->FormValue)) {
                $this->silence_time->addErrorMessage(str_replace("%s", $this->silence_time->caption(), $this->silence_time->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->silence_time->FormValue)) {
            $this->silence_time->addErrorMessage($this->silence_time->getErrorMessage(false));
        }
        if ($this->session_time->Required) {
            if (!$this->session_time->IsDetailKey && EmptyValue($this->session_time->FormValue)) {
                $this->session_time->addErrorMessage(str_replace("%s", $this->session_time->caption(), $this->session_time->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->session_time->FormValue)) {
            $this->session_time->addErrorMessage($this->session_time->getErrorMessage(false));
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
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // user_id
        $this->user_id->setDbValueDef($rsnew, $this->user_id->CurrentValue, "", false);

        // chatroom_id
        $this->chatroom_id->setDbValueDef($rsnew, $this->chatroom_id->CurrentValue, 0, false);

        // is_admin
        $tmpBool = $this->is_admin->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->is_admin->setDbValueDef($rsnew, $tmpBool, 0, strval($this->is_admin->CurrentValue) == "");

        // is_mod
        $tmpBool = $this->is_mod->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->is_mod->setDbValueDef($rsnew, $tmpBool, 0, strval($this->is_mod->CurrentValue) == "");

        // block_chats
        $this->block_chats->setDbValueDef($rsnew, $this->block_chats->CurrentValue, 0, strval($this->block_chats->CurrentValue) == "");

        // silence_length
        $this->silence_length->setDbValueDef($rsnew, $this->silence_length->CurrentValue, null, false);

        // silence_time
        $this->silence_time->setDbValueDef($rsnew, $this->silence_time->CurrentValue, null, false);

        // session_time
        $this->session_time->setDbValueDef($rsnew, $this->session_time->CurrentValue, 0, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['user_id']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['chatroom_id']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($rsnew);
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
        }
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ArrowchatChatroomUsersList"), "", $this->TableVar, true);
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
                case "x_is_admin":
                    break;
                case "x_is_mod":
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
