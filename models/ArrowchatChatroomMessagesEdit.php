<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ArrowchatChatroomMessagesEdit extends ArrowchatChatroomMessages
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'arrowchat_chatroom_messages';

    // Page object name
    public $PageObjName = "ArrowchatChatroomMessagesEdit";

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

        // Table object (arrowchat_chatroom_messages)
        if (!isset($GLOBALS["arrowchat_chatroom_messages"]) || get_class($GLOBALS["arrowchat_chatroom_messages"]) == PROJECT_NAMESPACE . "arrowchat_chatroom_messages") {
            $GLOBALS["arrowchat_chatroom_messages"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'arrowchat_chatroom_messages');
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
                $doc = new $class(Container("arrowchat_chatroom_messages"));
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
                    if ($pageName == "ArrowchatChatroomMessagesView") {
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
            $key .= @$ar['id'];
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
            $this->id->Visible = false;
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
        $this->id->setVisibility();
        $this->chatroom_id->setVisibility();
        $this->user_id->setVisibility();
        $this->_username->setVisibility();
        $this->message->setVisibility();
        $this->global_message->setVisibility();
        $this->is_mod->setVisibility();
        $this->is_admin->setVisibility();
        $this->sent->setVisibility();
        $this->_action->setVisibility();
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
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
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
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
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
                    $this->terminate("ArrowchatChatroomMessagesList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ArrowchatChatroomMessagesList") {
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
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

        // Check field name 'user_id' first before field var 'x_user_id'
        $val = $CurrentForm->hasValue("user_id") ? $CurrentForm->getValue("user_id") : $CurrentForm->getValue("x_user_id");
        if (!$this->user_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_id->Visible = false; // Disable update for API request
            } else {
                $this->user_id->setFormValue($val);
            }
        }

        // Check field name 'username' first before field var 'x__username'
        $val = $CurrentForm->hasValue("username") ? $CurrentForm->getValue("username") : $CurrentForm->getValue("x__username");
        if (!$this->_username->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_username->Visible = false; // Disable update for API request
            } else {
                $this->_username->setFormValue($val);
            }
        }

        // Check field name 'message' first before field var 'x_message'
        $val = $CurrentForm->hasValue("message") ? $CurrentForm->getValue("message") : $CurrentForm->getValue("x_message");
        if (!$this->message->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->message->Visible = false; // Disable update for API request
            } else {
                $this->message->setFormValue($val);
            }
        }

        // Check field name 'global_message' first before field var 'x_global_message'
        $val = $CurrentForm->hasValue("global_message") ? $CurrentForm->getValue("global_message") : $CurrentForm->getValue("x_global_message");
        if (!$this->global_message->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->global_message->Visible = false; // Disable update for API request
            } else {
                $this->global_message->setFormValue($val);
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

        // Check field name 'is_admin' first before field var 'x_is_admin'
        $val = $CurrentForm->hasValue("is_admin") ? $CurrentForm->getValue("is_admin") : $CurrentForm->getValue("x_is_admin");
        if (!$this->is_admin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->is_admin->Visible = false; // Disable update for API request
            } else {
                $this->is_admin->setFormValue($val);
            }
        }

        // Check field name 'sent' first before field var 'x_sent'
        $val = $CurrentForm->hasValue("sent") ? $CurrentForm->getValue("sent") : $CurrentForm->getValue("x_sent");
        if (!$this->sent->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sent->Visible = false; // Disable update for API request
            } else {
                $this->sent->setFormValue($val);
            }
        }

        // Check field name '_action' first before field var 'x__action'
        $val = $CurrentForm->hasValue("_action") ? $CurrentForm->getValue("_action") : $CurrentForm->getValue("x__action");
        if (!$this->_action->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_action->Visible = false; // Disable update for API request
            } else {
                $this->_action->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->chatroom_id->CurrentValue = $this->chatroom_id->FormValue;
        $this->user_id->CurrentValue = $this->user_id->FormValue;
        $this->_username->CurrentValue = $this->_username->FormValue;
        $this->message->CurrentValue = $this->message->FormValue;
        $this->global_message->CurrentValue = $this->global_message->FormValue;
        $this->is_mod->CurrentValue = $this->is_mod->FormValue;
        $this->is_admin->CurrentValue = $this->is_admin->FormValue;
        $this->sent->CurrentValue = $this->sent->FormValue;
        $this->_action->CurrentValue = $this->_action->FormValue;
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
        $this->id->setDbValue($row['id']);
        $this->chatroom_id->setDbValue($row['chatroom_id']);
        $this->user_id->setDbValue($row['user_id']);
        $this->_username->setDbValue($row['username']);
        $this->message->setDbValue($row['message']);
        $this->global_message->setDbValue($row['global_message']);
        $this->is_mod->setDbValue($row['is_mod']);
        $this->is_admin->setDbValue($row['is_admin']);
        $this->sent->setDbValue($row['sent']);
        $this->_action->setDbValue($row['action']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['chatroom_id'] = null;
        $row['user_id'] = null;
        $row['username'] = null;
        $row['message'] = null;
        $row['global_message'] = null;
        $row['is_mod'] = null;
        $row['is_admin'] = null;
        $row['sent'] = null;
        $row['action'] = null;
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

        // id

        // chatroom_id

        // user_id

        // username

        // message

        // global_message

        // is_mod

        // is_admin

        // sent

        // action
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // chatroom_id
            $this->chatroom_id->ViewValue = $this->chatroom_id->CurrentValue;
            $this->chatroom_id->ViewValue = FormatNumber($this->chatroom_id->ViewValue, 0, -2, -2, -2);
            $this->chatroom_id->ViewCustomAttributes = "";

            // user_id
            $this->user_id->ViewValue = $this->user_id->CurrentValue;
            $this->user_id->ViewCustomAttributes = "";

            // username
            $this->_username->ViewValue = $this->_username->CurrentValue;
            $this->_username->ViewCustomAttributes = "";

            // message
            $this->message->ViewValue = $this->message->CurrentValue;
            $this->message->ViewCustomAttributes = "";

            // global_message
            if (ConvertToBool($this->global_message->CurrentValue)) {
                $this->global_message->ViewValue = $this->global_message->tagCaption(1) != "" ? $this->global_message->tagCaption(1) : "Yes";
            } else {
                $this->global_message->ViewValue = $this->global_message->tagCaption(2) != "" ? $this->global_message->tagCaption(2) : "No";
            }
            $this->global_message->ViewCustomAttributes = "";

            // is_mod
            if (ConvertToBool($this->is_mod->CurrentValue)) {
                $this->is_mod->ViewValue = $this->is_mod->tagCaption(1) != "" ? $this->is_mod->tagCaption(1) : "Yes";
            } else {
                $this->is_mod->ViewValue = $this->is_mod->tagCaption(2) != "" ? $this->is_mod->tagCaption(2) : "No";
            }
            $this->is_mod->ViewCustomAttributes = "";

            // is_admin
            if (ConvertToBool($this->is_admin->CurrentValue)) {
                $this->is_admin->ViewValue = $this->is_admin->tagCaption(1) != "" ? $this->is_admin->tagCaption(1) : "Yes";
            } else {
                $this->is_admin->ViewValue = $this->is_admin->tagCaption(2) != "" ? $this->is_admin->tagCaption(2) : "No";
            }
            $this->is_admin->ViewCustomAttributes = "";

            // sent
            $this->sent->ViewValue = $this->sent->CurrentValue;
            $this->sent->ViewValue = FormatNumber($this->sent->ViewValue, 0, -2, -2, -2);
            $this->sent->ViewCustomAttributes = "";

            // action
            if (ConvertToBool($this->_action->CurrentValue)) {
                $this->_action->ViewValue = $this->_action->tagCaption(1) != "" ? $this->_action->tagCaption(1) : "Yes";
            } else {
                $this->_action->ViewValue = $this->_action->tagCaption(2) != "" ? $this->_action->tagCaption(2) : "No";
            }
            $this->_action->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // chatroom_id
            $this->chatroom_id->LinkCustomAttributes = "";
            $this->chatroom_id->HrefValue = "";
            $this->chatroom_id->TooltipValue = "";

            // user_id
            $this->user_id->LinkCustomAttributes = "";
            $this->user_id->HrefValue = "";
            $this->user_id->TooltipValue = "";

            // username
            $this->_username->LinkCustomAttributes = "";
            $this->_username->HrefValue = "";
            $this->_username->TooltipValue = "";

            // message
            $this->message->LinkCustomAttributes = "";
            $this->message->HrefValue = "";
            $this->message->TooltipValue = "";

            // global_message
            $this->global_message->LinkCustomAttributes = "";
            $this->global_message->HrefValue = "";
            $this->global_message->TooltipValue = "";

            // is_mod
            $this->is_mod->LinkCustomAttributes = "";
            $this->is_mod->HrefValue = "";
            $this->is_mod->TooltipValue = "";

            // is_admin
            $this->is_admin->LinkCustomAttributes = "";
            $this->is_admin->HrefValue = "";
            $this->is_admin->TooltipValue = "";

            // sent
            $this->sent->LinkCustomAttributes = "";
            $this->sent->HrefValue = "";
            $this->sent->TooltipValue = "";

            // action
            $this->_action->LinkCustomAttributes = "";
            $this->_action->HrefValue = "";
            $this->_action->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // chatroom_id
            $this->chatroom_id->EditAttrs["class"] = "form-control";
            $this->chatroom_id->EditCustomAttributes = "";
            $this->chatroom_id->EditValue = HtmlEncode($this->chatroom_id->CurrentValue);
            $this->chatroom_id->PlaceHolder = RemoveHtml($this->chatroom_id->caption());

            // user_id
            $this->user_id->EditAttrs["class"] = "form-control";
            $this->user_id->EditCustomAttributes = "";
            if (!$this->user_id->Raw) {
                $this->user_id->CurrentValue = HtmlDecode($this->user_id->CurrentValue);
            }
            $this->user_id->EditValue = HtmlEncode($this->user_id->CurrentValue);
            $this->user_id->PlaceHolder = RemoveHtml($this->user_id->caption());

            // username
            $this->_username->EditAttrs["class"] = "form-control";
            $this->_username->EditCustomAttributes = "";
            if (!$this->_username->Raw) {
                $this->_username->CurrentValue = HtmlDecode($this->_username->CurrentValue);
            }
            $this->_username->EditValue = HtmlEncode($this->_username->CurrentValue);
            $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

            // message
            $this->message->EditAttrs["class"] = "form-control";
            $this->message->EditCustomAttributes = "";
            $this->message->EditValue = HtmlEncode($this->message->CurrentValue);
            $this->message->PlaceHolder = RemoveHtml($this->message->caption());

            // global_message
            $this->global_message->EditCustomAttributes = "";
            $this->global_message->EditValue = $this->global_message->options(false);
            $this->global_message->PlaceHolder = RemoveHtml($this->global_message->caption());

            // is_mod
            $this->is_mod->EditCustomAttributes = "";
            $this->is_mod->EditValue = $this->is_mod->options(false);
            $this->is_mod->PlaceHolder = RemoveHtml($this->is_mod->caption());

            // is_admin
            $this->is_admin->EditCustomAttributes = "";
            $this->is_admin->EditValue = $this->is_admin->options(false);
            $this->is_admin->PlaceHolder = RemoveHtml($this->is_admin->caption());

            // sent
            $this->sent->EditAttrs["class"] = "form-control";
            $this->sent->EditCustomAttributes = "";
            $this->sent->EditValue = HtmlEncode($this->sent->CurrentValue);
            $this->sent->PlaceHolder = RemoveHtml($this->sent->caption());

            // action
            $this->_action->EditCustomAttributes = "";
            $this->_action->EditValue = $this->_action->options(false);
            $this->_action->PlaceHolder = RemoveHtml($this->_action->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // chatroom_id
            $this->chatroom_id->LinkCustomAttributes = "";
            $this->chatroom_id->HrefValue = "";

            // user_id
            $this->user_id->LinkCustomAttributes = "";
            $this->user_id->HrefValue = "";

            // username
            $this->_username->LinkCustomAttributes = "";
            $this->_username->HrefValue = "";

            // message
            $this->message->LinkCustomAttributes = "";
            $this->message->HrefValue = "";

            // global_message
            $this->global_message->LinkCustomAttributes = "";
            $this->global_message->HrefValue = "";

            // is_mod
            $this->is_mod->LinkCustomAttributes = "";
            $this->is_mod->HrefValue = "";

            // is_admin
            $this->is_admin->LinkCustomAttributes = "";
            $this->is_admin->HrefValue = "";

            // sent
            $this->sent->LinkCustomAttributes = "";
            $this->sent->HrefValue = "";

            // action
            $this->_action->LinkCustomAttributes = "";
            $this->_action->HrefValue = "";
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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
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
        if ($this->user_id->Required) {
            if (!$this->user_id->IsDetailKey && EmptyValue($this->user_id->FormValue)) {
                $this->user_id->addErrorMessage(str_replace("%s", $this->user_id->caption(), $this->user_id->RequiredErrorMessage));
            }
        }
        if ($this->_username->Required) {
            if (!$this->_username->IsDetailKey && EmptyValue($this->_username->FormValue)) {
                $this->_username->addErrorMessage(str_replace("%s", $this->_username->caption(), $this->_username->RequiredErrorMessage));
            }
        }
        if ($this->message->Required) {
            if (!$this->message->IsDetailKey && EmptyValue($this->message->FormValue)) {
                $this->message->addErrorMessage(str_replace("%s", $this->message->caption(), $this->message->RequiredErrorMessage));
            }
        }
        if ($this->global_message->Required) {
            if ($this->global_message->FormValue == "") {
                $this->global_message->addErrorMessage(str_replace("%s", $this->global_message->caption(), $this->global_message->RequiredErrorMessage));
            }
        }
        if ($this->is_mod->Required) {
            if ($this->is_mod->FormValue == "") {
                $this->is_mod->addErrorMessage(str_replace("%s", $this->is_mod->caption(), $this->is_mod->RequiredErrorMessage));
            }
        }
        if ($this->is_admin->Required) {
            if ($this->is_admin->FormValue == "") {
                $this->is_admin->addErrorMessage(str_replace("%s", $this->is_admin->caption(), $this->is_admin->RequiredErrorMessage));
            }
        }
        if ($this->sent->Required) {
            if (!$this->sent->IsDetailKey && EmptyValue($this->sent->FormValue)) {
                $this->sent->addErrorMessage(str_replace("%s", $this->sent->caption(), $this->sent->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->sent->FormValue)) {
            $this->sent->addErrorMessage($this->sent->getErrorMessage(false));
        }
        if ($this->_action->Required) {
            if ($this->_action->FormValue == "") {
                $this->_action->addErrorMessage(str_replace("%s", $this->_action->caption(), $this->_action->RequiredErrorMessage));
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

            // chatroom_id
            $this->chatroom_id->setDbValueDef($rsnew, $this->chatroom_id->CurrentValue, 0, $this->chatroom_id->ReadOnly);

            // user_id
            $this->user_id->setDbValueDef($rsnew, $this->user_id->CurrentValue, "", $this->user_id->ReadOnly);

            // username
            $this->_username->setDbValueDef($rsnew, $this->_username->CurrentValue, "", $this->_username->ReadOnly);

            // message
            $this->message->setDbValueDef($rsnew, $this->message->CurrentValue, "", $this->message->ReadOnly);

            // global_message
            $tmpBool = $this->global_message->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->global_message->setDbValueDef($rsnew, $tmpBool, null, $this->global_message->ReadOnly);

            // is_mod
            $tmpBool = $this->is_mod->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->is_mod->setDbValueDef($rsnew, $tmpBool, null, $this->is_mod->ReadOnly);

            // is_admin
            $tmpBool = $this->is_admin->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->is_admin->setDbValueDef($rsnew, $tmpBool, null, $this->is_admin->ReadOnly);

            // sent
            $this->sent->setDbValueDef($rsnew, $this->sent->CurrentValue, 0, $this->sent->ReadOnly);

            // action
            $tmpBool = $this->_action->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->_action->setDbValueDef($rsnew, $tmpBool, null, $this->_action->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ArrowchatChatroomMessagesList"), "", $this->TableVar, true);
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
                case "x_global_message":
                    break;
                case "x_is_mod":
                    break;
                case "x_is_admin":
                    break;
                case "x__action":
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
