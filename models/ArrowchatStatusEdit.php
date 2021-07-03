<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ArrowchatStatusEdit extends ArrowchatStatus
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'arrowchat_status';

    // Page object name
    public $PageObjName = "ArrowchatStatusEdit";

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

        // Table object (arrowchat_status)
        if (!isset($GLOBALS["arrowchat_status"]) || get_class($GLOBALS["arrowchat_status"]) == PROJECT_NAMESPACE . "arrowchat_status") {
            $GLOBALS["arrowchat_status"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'arrowchat_status');
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
                $doc = new $class(Container("arrowchat_status"));
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
                    if ($pageName == "ArrowchatStatusView") {
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
            $key .= @$ar['userid'];
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
        $this->_userid->setVisibility();
        $this->guest_name->setVisibility();
        $this->message->setVisibility();
        $this->status->setVisibility();
        $this->theme->setVisibility();
        $this->popout->setVisibility();
        $this->typing->setVisibility();
        $this->hide_bar->setVisibility();
        $this->play_sound->setVisibility();
        $this->window_open->setVisibility();
        $this->only_names->setVisibility();
        $this->chatroom_window->setVisibility();
        $this->chatroom_stay->setVisibility();
        $this->chatroom_unfocus->setVisibility();
        $this->chatroom_show_names->setVisibility();
        $this->chatroom_block_chats->setVisibility();
        $this->chatroom_sound->setVisibility();
        $this->announcement->setVisibility();
        $this->unfocus_chat->setVisibility();
        $this->focus_chat->setVisibility();
        $this->last_message->setVisibility();
        $this->clear_chats->setVisibility();
        $this->apps_bookmarks->setVisibility();
        $this->apps_other->setVisibility();
        $this->apps_open->setVisibility();
        $this->apps_load->setVisibility();
        $this->block_chats->setVisibility();
        $this->session_time->setVisibility();
        $this->is_admin->setVisibility();
        $this->is_mod->setVisibility();
        $this->hash_id->setVisibility();
        $this->ip_address->setVisibility();
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
            if (($keyValue = Get("_userid") ?? Key(0) ?? Route(2)) !== null) {
                $this->_userid->setQueryStringValue($keyValue);
                $this->_userid->setOldValue($this->_userid->QueryStringValue);
            } elseif (Post("_userid") !== null) {
                $this->_userid->setFormValue(Post("_userid"));
                $this->_userid->setOldValue($this->_userid->FormValue);
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
                if (($keyValue = Get("_userid") ?? Route("_userid")) !== null) {
                    $this->_userid->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->_userid->CurrentValue = null;
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
                    $this->terminate("ArrowchatStatusList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ArrowchatStatusList") {
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

        // Check field name 'userid' first before field var 'x__userid'
        $val = $CurrentForm->hasValue("userid") ? $CurrentForm->getValue("userid") : $CurrentForm->getValue("x__userid");
        if (!$this->_userid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_userid->Visible = false; // Disable update for API request
            } else {
                $this->_userid->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o__userid")) {
            $this->_userid->setOldValue($CurrentForm->getValue("o__userid"));
        }

        // Check field name 'guest_name' first before field var 'x_guest_name'
        $val = $CurrentForm->hasValue("guest_name") ? $CurrentForm->getValue("guest_name") : $CurrentForm->getValue("x_guest_name");
        if (!$this->guest_name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->guest_name->Visible = false; // Disable update for API request
            } else {
                $this->guest_name->setFormValue($val);
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

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }

        // Check field name 'theme' first before field var 'x_theme'
        $val = $CurrentForm->hasValue("theme") ? $CurrentForm->getValue("theme") : $CurrentForm->getValue("x_theme");
        if (!$this->theme->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->theme->Visible = false; // Disable update for API request
            } else {
                $this->theme->setFormValue($val);
            }
        }

        // Check field name 'popout' first before field var 'x_popout'
        $val = $CurrentForm->hasValue("popout") ? $CurrentForm->getValue("popout") : $CurrentForm->getValue("x_popout");
        if (!$this->popout->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->popout->Visible = false; // Disable update for API request
            } else {
                $this->popout->setFormValue($val);
            }
        }

        // Check field name 'typing' first before field var 'x_typing'
        $val = $CurrentForm->hasValue("typing") ? $CurrentForm->getValue("typing") : $CurrentForm->getValue("x_typing");
        if (!$this->typing->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->typing->Visible = false; // Disable update for API request
            } else {
                $this->typing->setFormValue($val);
            }
        }

        // Check field name 'hide_bar' first before field var 'x_hide_bar'
        $val = $CurrentForm->hasValue("hide_bar") ? $CurrentForm->getValue("hide_bar") : $CurrentForm->getValue("x_hide_bar");
        if (!$this->hide_bar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hide_bar->Visible = false; // Disable update for API request
            } else {
                $this->hide_bar->setFormValue($val);
            }
        }

        // Check field name 'play_sound' first before field var 'x_play_sound'
        $val = $CurrentForm->hasValue("play_sound") ? $CurrentForm->getValue("play_sound") : $CurrentForm->getValue("x_play_sound");
        if (!$this->play_sound->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->play_sound->Visible = false; // Disable update for API request
            } else {
                $this->play_sound->setFormValue($val);
            }
        }

        // Check field name 'window_open' first before field var 'x_window_open'
        $val = $CurrentForm->hasValue("window_open") ? $CurrentForm->getValue("window_open") : $CurrentForm->getValue("x_window_open");
        if (!$this->window_open->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->window_open->Visible = false; // Disable update for API request
            } else {
                $this->window_open->setFormValue($val);
            }
        }

        // Check field name 'only_names' first before field var 'x_only_names'
        $val = $CurrentForm->hasValue("only_names") ? $CurrentForm->getValue("only_names") : $CurrentForm->getValue("x_only_names");
        if (!$this->only_names->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->only_names->Visible = false; // Disable update for API request
            } else {
                $this->only_names->setFormValue($val);
            }
        }

        // Check field name 'chatroom_window' first before field var 'x_chatroom_window'
        $val = $CurrentForm->hasValue("chatroom_window") ? $CurrentForm->getValue("chatroom_window") : $CurrentForm->getValue("x_chatroom_window");
        if (!$this->chatroom_window->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->chatroom_window->Visible = false; // Disable update for API request
            } else {
                $this->chatroom_window->setFormValue($val);
            }
        }

        // Check field name 'chatroom_stay' first before field var 'x_chatroom_stay'
        $val = $CurrentForm->hasValue("chatroom_stay") ? $CurrentForm->getValue("chatroom_stay") : $CurrentForm->getValue("x_chatroom_stay");
        if (!$this->chatroom_stay->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->chatroom_stay->Visible = false; // Disable update for API request
            } else {
                $this->chatroom_stay->setFormValue($val);
            }
        }

        // Check field name 'chatroom_unfocus' first before field var 'x_chatroom_unfocus'
        $val = $CurrentForm->hasValue("chatroom_unfocus") ? $CurrentForm->getValue("chatroom_unfocus") : $CurrentForm->getValue("x_chatroom_unfocus");
        if (!$this->chatroom_unfocus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->chatroom_unfocus->Visible = false; // Disable update for API request
            } else {
                $this->chatroom_unfocus->setFormValue($val);
            }
        }

        // Check field name 'chatroom_show_names' first before field var 'x_chatroom_show_names'
        $val = $CurrentForm->hasValue("chatroom_show_names") ? $CurrentForm->getValue("chatroom_show_names") : $CurrentForm->getValue("x_chatroom_show_names");
        if (!$this->chatroom_show_names->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->chatroom_show_names->Visible = false; // Disable update for API request
            } else {
                $this->chatroom_show_names->setFormValue($val);
            }
        }

        // Check field name 'chatroom_block_chats' first before field var 'x_chatroom_block_chats'
        $val = $CurrentForm->hasValue("chatroom_block_chats") ? $CurrentForm->getValue("chatroom_block_chats") : $CurrentForm->getValue("x_chatroom_block_chats");
        if (!$this->chatroom_block_chats->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->chatroom_block_chats->Visible = false; // Disable update for API request
            } else {
                $this->chatroom_block_chats->setFormValue($val);
            }
        }

        // Check field name 'chatroom_sound' first before field var 'x_chatroom_sound'
        $val = $CurrentForm->hasValue("chatroom_sound") ? $CurrentForm->getValue("chatroom_sound") : $CurrentForm->getValue("x_chatroom_sound");
        if (!$this->chatroom_sound->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->chatroom_sound->Visible = false; // Disable update for API request
            } else {
                $this->chatroom_sound->setFormValue($val);
            }
        }

        // Check field name 'announcement' first before field var 'x_announcement'
        $val = $CurrentForm->hasValue("announcement") ? $CurrentForm->getValue("announcement") : $CurrentForm->getValue("x_announcement");
        if (!$this->announcement->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->announcement->Visible = false; // Disable update for API request
            } else {
                $this->announcement->setFormValue($val);
            }
        }

        // Check field name 'unfocus_chat' first before field var 'x_unfocus_chat'
        $val = $CurrentForm->hasValue("unfocus_chat") ? $CurrentForm->getValue("unfocus_chat") : $CurrentForm->getValue("x_unfocus_chat");
        if (!$this->unfocus_chat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unfocus_chat->Visible = false; // Disable update for API request
            } else {
                $this->unfocus_chat->setFormValue($val);
            }
        }

        // Check field name 'focus_chat' first before field var 'x_focus_chat'
        $val = $CurrentForm->hasValue("focus_chat") ? $CurrentForm->getValue("focus_chat") : $CurrentForm->getValue("x_focus_chat");
        if (!$this->focus_chat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->focus_chat->Visible = false; // Disable update for API request
            } else {
                $this->focus_chat->setFormValue($val);
            }
        }

        // Check field name 'last_message' first before field var 'x_last_message'
        $val = $CurrentForm->hasValue("last_message") ? $CurrentForm->getValue("last_message") : $CurrentForm->getValue("x_last_message");
        if (!$this->last_message->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->last_message->Visible = false; // Disable update for API request
            } else {
                $this->last_message->setFormValue($val);
            }
        }

        // Check field name 'clear_chats' first before field var 'x_clear_chats'
        $val = $CurrentForm->hasValue("clear_chats") ? $CurrentForm->getValue("clear_chats") : $CurrentForm->getValue("x_clear_chats");
        if (!$this->clear_chats->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->clear_chats->Visible = false; // Disable update for API request
            } else {
                $this->clear_chats->setFormValue($val);
            }
        }

        // Check field name 'apps_bookmarks' first before field var 'x_apps_bookmarks'
        $val = $CurrentForm->hasValue("apps_bookmarks") ? $CurrentForm->getValue("apps_bookmarks") : $CurrentForm->getValue("x_apps_bookmarks");
        if (!$this->apps_bookmarks->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apps_bookmarks->Visible = false; // Disable update for API request
            } else {
                $this->apps_bookmarks->setFormValue($val);
            }
        }

        // Check field name 'apps_other' first before field var 'x_apps_other'
        $val = $CurrentForm->hasValue("apps_other") ? $CurrentForm->getValue("apps_other") : $CurrentForm->getValue("x_apps_other");
        if (!$this->apps_other->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apps_other->Visible = false; // Disable update for API request
            } else {
                $this->apps_other->setFormValue($val);
            }
        }

        // Check field name 'apps_open' first before field var 'x_apps_open'
        $val = $CurrentForm->hasValue("apps_open") ? $CurrentForm->getValue("apps_open") : $CurrentForm->getValue("x_apps_open");
        if (!$this->apps_open->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apps_open->Visible = false; // Disable update for API request
            } else {
                $this->apps_open->setFormValue($val);
            }
        }

        // Check field name 'apps_load' first before field var 'x_apps_load'
        $val = $CurrentForm->hasValue("apps_load") ? $CurrentForm->getValue("apps_load") : $CurrentForm->getValue("x_apps_load");
        if (!$this->apps_load->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apps_load->Visible = false; // Disable update for API request
            } else {
                $this->apps_load->setFormValue($val);
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

        // Check field name 'session_time' first before field var 'x_session_time'
        $val = $CurrentForm->hasValue("session_time") ? $CurrentForm->getValue("session_time") : $CurrentForm->getValue("x_session_time");
        if (!$this->session_time->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->session_time->Visible = false; // Disable update for API request
            } else {
                $this->session_time->setFormValue($val);
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

        // Check field name 'hash_id' first before field var 'x_hash_id'
        $val = $CurrentForm->hasValue("hash_id") ? $CurrentForm->getValue("hash_id") : $CurrentForm->getValue("x_hash_id");
        if (!$this->hash_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hash_id->Visible = false; // Disable update for API request
            } else {
                $this->hash_id->setFormValue($val);
            }
        }

        // Check field name 'ip_address' first before field var 'x_ip_address'
        $val = $CurrentForm->hasValue("ip_address") ? $CurrentForm->getValue("ip_address") : $CurrentForm->getValue("x_ip_address");
        if (!$this->ip_address->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ip_address->Visible = false; // Disable update for API request
            } else {
                $this->ip_address->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->_userid->CurrentValue = $this->_userid->FormValue;
        $this->guest_name->CurrentValue = $this->guest_name->FormValue;
        $this->message->CurrentValue = $this->message->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->theme->CurrentValue = $this->theme->FormValue;
        $this->popout->CurrentValue = $this->popout->FormValue;
        $this->typing->CurrentValue = $this->typing->FormValue;
        $this->hide_bar->CurrentValue = $this->hide_bar->FormValue;
        $this->play_sound->CurrentValue = $this->play_sound->FormValue;
        $this->window_open->CurrentValue = $this->window_open->FormValue;
        $this->only_names->CurrentValue = $this->only_names->FormValue;
        $this->chatroom_window->CurrentValue = $this->chatroom_window->FormValue;
        $this->chatroom_stay->CurrentValue = $this->chatroom_stay->FormValue;
        $this->chatroom_unfocus->CurrentValue = $this->chatroom_unfocus->FormValue;
        $this->chatroom_show_names->CurrentValue = $this->chatroom_show_names->FormValue;
        $this->chatroom_block_chats->CurrentValue = $this->chatroom_block_chats->FormValue;
        $this->chatroom_sound->CurrentValue = $this->chatroom_sound->FormValue;
        $this->announcement->CurrentValue = $this->announcement->FormValue;
        $this->unfocus_chat->CurrentValue = $this->unfocus_chat->FormValue;
        $this->focus_chat->CurrentValue = $this->focus_chat->FormValue;
        $this->last_message->CurrentValue = $this->last_message->FormValue;
        $this->clear_chats->CurrentValue = $this->clear_chats->FormValue;
        $this->apps_bookmarks->CurrentValue = $this->apps_bookmarks->FormValue;
        $this->apps_other->CurrentValue = $this->apps_other->FormValue;
        $this->apps_open->CurrentValue = $this->apps_open->FormValue;
        $this->apps_load->CurrentValue = $this->apps_load->FormValue;
        $this->block_chats->CurrentValue = $this->block_chats->FormValue;
        $this->session_time->CurrentValue = $this->session_time->FormValue;
        $this->is_admin->CurrentValue = $this->is_admin->FormValue;
        $this->is_mod->CurrentValue = $this->is_mod->FormValue;
        $this->hash_id->CurrentValue = $this->hash_id->FormValue;
        $this->ip_address->CurrentValue = $this->ip_address->FormValue;
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
        $this->_userid->setDbValue($row['userid']);
        $this->guest_name->setDbValue($row['guest_name']);
        $this->message->setDbValue($row['message']);
        $this->status->setDbValue($row['status']);
        $this->theme->setDbValue($row['theme']);
        $this->popout->setDbValue($row['popout']);
        $this->typing->setDbValue($row['typing']);
        $this->hide_bar->setDbValue($row['hide_bar']);
        $this->play_sound->setDbValue($row['play_sound']);
        $this->window_open->setDbValue($row['window_open']);
        $this->only_names->setDbValue($row['only_names']);
        $this->chatroom_window->setDbValue($row['chatroom_window']);
        $this->chatroom_stay->setDbValue($row['chatroom_stay']);
        $this->chatroom_unfocus->setDbValue($row['chatroom_unfocus']);
        $this->chatroom_show_names->setDbValue($row['chatroom_show_names']);
        $this->chatroom_block_chats->setDbValue($row['chatroom_block_chats']);
        $this->chatroom_sound->setDbValue($row['chatroom_sound']);
        $this->announcement->setDbValue($row['announcement']);
        $this->unfocus_chat->setDbValue($row['unfocus_chat']);
        $this->focus_chat->setDbValue($row['focus_chat']);
        $this->last_message->setDbValue($row['last_message']);
        $this->clear_chats->setDbValue($row['clear_chats']);
        $this->apps_bookmarks->setDbValue($row['apps_bookmarks']);
        $this->apps_other->setDbValue($row['apps_other']);
        $this->apps_open->setDbValue($row['apps_open']);
        $this->apps_load->setDbValue($row['apps_load']);
        $this->block_chats->setDbValue($row['block_chats']);
        $this->session_time->setDbValue($row['session_time']);
        $this->is_admin->setDbValue($row['is_admin']);
        $this->is_mod->setDbValue($row['is_mod']);
        $this->hash_id->setDbValue($row['hash_id']);
        $this->ip_address->setDbValue($row['ip_address']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['userid'] = null;
        $row['guest_name'] = null;
        $row['message'] = null;
        $row['status'] = null;
        $row['theme'] = null;
        $row['popout'] = null;
        $row['typing'] = null;
        $row['hide_bar'] = null;
        $row['play_sound'] = null;
        $row['window_open'] = null;
        $row['only_names'] = null;
        $row['chatroom_window'] = null;
        $row['chatroom_stay'] = null;
        $row['chatroom_unfocus'] = null;
        $row['chatroom_show_names'] = null;
        $row['chatroom_block_chats'] = null;
        $row['chatroom_sound'] = null;
        $row['announcement'] = null;
        $row['unfocus_chat'] = null;
        $row['focus_chat'] = null;
        $row['last_message'] = null;
        $row['clear_chats'] = null;
        $row['apps_bookmarks'] = null;
        $row['apps_other'] = null;
        $row['apps_open'] = null;
        $row['apps_load'] = null;
        $row['block_chats'] = null;
        $row['session_time'] = null;
        $row['is_admin'] = null;
        $row['is_mod'] = null;
        $row['hash_id'] = null;
        $row['ip_address'] = null;
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

        // userid

        // guest_name

        // message

        // status

        // theme

        // popout

        // typing

        // hide_bar

        // play_sound

        // window_open

        // only_names

        // chatroom_window

        // chatroom_stay

        // chatroom_unfocus

        // chatroom_show_names

        // chatroom_block_chats

        // chatroom_sound

        // announcement

        // unfocus_chat

        // focus_chat

        // last_message

        // clear_chats

        // apps_bookmarks

        // apps_other

        // apps_open

        // apps_load

        // block_chats

        // session_time

        // is_admin

        // is_mod

        // hash_id

        // ip_address
        if ($this->RowType == ROWTYPE_VIEW) {
            // userid
            $this->_userid->ViewValue = $this->_userid->CurrentValue;
            $this->_userid->ViewCustomAttributes = "";

            // guest_name
            $this->guest_name->ViewValue = $this->guest_name->CurrentValue;
            $this->guest_name->ViewCustomAttributes = "";

            // message
            $this->message->ViewValue = $this->message->CurrentValue;
            $this->message->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // theme
            $this->theme->ViewValue = $this->theme->CurrentValue;
            $this->theme->ViewValue = FormatNumber($this->theme->ViewValue, 0, -2, -2, -2);
            $this->theme->ViewCustomAttributes = "";

            // popout
            $this->popout->ViewValue = $this->popout->CurrentValue;
            $this->popout->ViewValue = FormatNumber($this->popout->ViewValue, 0, -2, -2, -2);
            $this->popout->ViewCustomAttributes = "";

            // typing
            $this->typing->ViewValue = $this->typing->CurrentValue;
            $this->typing->ViewCustomAttributes = "";

            // hide_bar
            if (ConvertToBool($this->hide_bar->CurrentValue)) {
                $this->hide_bar->ViewValue = $this->hide_bar->tagCaption(1) != "" ? $this->hide_bar->tagCaption(1) : "Yes";
            } else {
                $this->hide_bar->ViewValue = $this->hide_bar->tagCaption(2) != "" ? $this->hide_bar->tagCaption(2) : "No";
            }
            $this->hide_bar->ViewCustomAttributes = "";

            // play_sound
            if (ConvertToBool($this->play_sound->CurrentValue)) {
                $this->play_sound->ViewValue = $this->play_sound->tagCaption(1) != "" ? $this->play_sound->tagCaption(1) : "Yes";
            } else {
                $this->play_sound->ViewValue = $this->play_sound->tagCaption(2) != "" ? $this->play_sound->tagCaption(2) : "No";
            }
            $this->play_sound->ViewCustomAttributes = "";

            // window_open
            if (ConvertToBool($this->window_open->CurrentValue)) {
                $this->window_open->ViewValue = $this->window_open->tagCaption(1) != "" ? $this->window_open->tagCaption(1) : "Yes";
            } else {
                $this->window_open->ViewValue = $this->window_open->tagCaption(2) != "" ? $this->window_open->tagCaption(2) : "No";
            }
            $this->window_open->ViewCustomAttributes = "";

            // only_names
            if (ConvertToBool($this->only_names->CurrentValue)) {
                $this->only_names->ViewValue = $this->only_names->tagCaption(1) != "" ? $this->only_names->tagCaption(1) : "Yes";
            } else {
                $this->only_names->ViewValue = $this->only_names->tagCaption(2) != "" ? $this->only_names->tagCaption(2) : "No";
            }
            $this->only_names->ViewCustomAttributes = "";

            // chatroom_window
            $this->chatroom_window->ViewValue = $this->chatroom_window->CurrentValue;
            $this->chatroom_window->ViewCustomAttributes = "";

            // chatroom_stay
            $this->chatroom_stay->ViewValue = $this->chatroom_stay->CurrentValue;
            $this->chatroom_stay->ViewCustomAttributes = "";

            // chatroom_unfocus
            $this->chatroom_unfocus->ViewValue = $this->chatroom_unfocus->CurrentValue;
            $this->chatroom_unfocus->ViewCustomAttributes = "";

            // chatroom_show_names
            if (ConvertToBool($this->chatroom_show_names->CurrentValue)) {
                $this->chatroom_show_names->ViewValue = $this->chatroom_show_names->tagCaption(1) != "" ? $this->chatroom_show_names->tagCaption(1) : "Yes";
            } else {
                $this->chatroom_show_names->ViewValue = $this->chatroom_show_names->tagCaption(2) != "" ? $this->chatroom_show_names->tagCaption(2) : "No";
            }
            $this->chatroom_show_names->ViewCustomAttributes = "";

            // chatroom_block_chats
            if (ConvertToBool($this->chatroom_block_chats->CurrentValue)) {
                $this->chatroom_block_chats->ViewValue = $this->chatroom_block_chats->tagCaption(1) != "" ? $this->chatroom_block_chats->tagCaption(1) : "Yes";
            } else {
                $this->chatroom_block_chats->ViewValue = $this->chatroom_block_chats->tagCaption(2) != "" ? $this->chatroom_block_chats->tagCaption(2) : "No";
            }
            $this->chatroom_block_chats->ViewCustomAttributes = "";

            // chatroom_sound
            if (ConvertToBool($this->chatroom_sound->CurrentValue)) {
                $this->chatroom_sound->ViewValue = $this->chatroom_sound->tagCaption(1) != "" ? $this->chatroom_sound->tagCaption(1) : "Yes";
            } else {
                $this->chatroom_sound->ViewValue = $this->chatroom_sound->tagCaption(2) != "" ? $this->chatroom_sound->tagCaption(2) : "No";
            }
            $this->chatroom_sound->ViewCustomAttributes = "";

            // announcement
            if (ConvertToBool($this->announcement->CurrentValue)) {
                $this->announcement->ViewValue = $this->announcement->tagCaption(1) != "" ? $this->announcement->tagCaption(1) : "Yes";
            } else {
                $this->announcement->ViewValue = $this->announcement->tagCaption(2) != "" ? $this->announcement->tagCaption(2) : "No";
            }
            $this->announcement->ViewCustomAttributes = "";

            // unfocus_chat
            $this->unfocus_chat->ViewValue = $this->unfocus_chat->CurrentValue;
            $this->unfocus_chat->ViewCustomAttributes = "";

            // focus_chat
            $this->focus_chat->ViewValue = $this->focus_chat->CurrentValue;
            $this->focus_chat->ViewCustomAttributes = "";

            // last_message
            $this->last_message->ViewValue = $this->last_message->CurrentValue;
            $this->last_message->ViewCustomAttributes = "";

            // clear_chats
            $this->clear_chats->ViewValue = $this->clear_chats->CurrentValue;
            $this->clear_chats->ViewCustomAttributes = "";

            // apps_bookmarks
            $this->apps_bookmarks->ViewValue = $this->apps_bookmarks->CurrentValue;
            $this->apps_bookmarks->ViewCustomAttributes = "";

            // apps_other
            $this->apps_other->ViewValue = $this->apps_other->CurrentValue;
            $this->apps_other->ViewCustomAttributes = "";

            // apps_open
            $this->apps_open->ViewValue = $this->apps_open->CurrentValue;
            $this->apps_open->ViewValue = FormatNumber($this->apps_open->ViewValue, 0, -2, -2, -2);
            $this->apps_open->ViewCustomAttributes = "";

            // apps_load
            $this->apps_load->ViewValue = $this->apps_load->CurrentValue;
            $this->apps_load->ViewCustomAttributes = "";

            // block_chats
            $this->block_chats->ViewValue = $this->block_chats->CurrentValue;
            $this->block_chats->ViewCustomAttributes = "";

            // session_time
            $this->session_time->ViewValue = $this->session_time->CurrentValue;
            $this->session_time->ViewValue = FormatNumber($this->session_time->ViewValue, 0, -2, -2, -2);
            $this->session_time->ViewCustomAttributes = "";

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

            // hash_id
            $this->hash_id->ViewValue = $this->hash_id->CurrentValue;
            $this->hash_id->ViewCustomAttributes = "";

            // ip_address
            $this->ip_address->ViewValue = $this->ip_address->CurrentValue;
            $this->ip_address->ViewCustomAttributes = "";

            // userid
            $this->_userid->LinkCustomAttributes = "";
            $this->_userid->HrefValue = "";
            $this->_userid->TooltipValue = "";

            // guest_name
            $this->guest_name->LinkCustomAttributes = "";
            $this->guest_name->HrefValue = "";
            $this->guest_name->TooltipValue = "";

            // message
            $this->message->LinkCustomAttributes = "";
            $this->message->HrefValue = "";
            $this->message->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // theme
            $this->theme->LinkCustomAttributes = "";
            $this->theme->HrefValue = "";
            $this->theme->TooltipValue = "";

            // popout
            $this->popout->LinkCustomAttributes = "";
            $this->popout->HrefValue = "";
            $this->popout->TooltipValue = "";

            // typing
            $this->typing->LinkCustomAttributes = "";
            $this->typing->HrefValue = "";
            $this->typing->TooltipValue = "";

            // hide_bar
            $this->hide_bar->LinkCustomAttributes = "";
            $this->hide_bar->HrefValue = "";
            $this->hide_bar->TooltipValue = "";

            // play_sound
            $this->play_sound->LinkCustomAttributes = "";
            $this->play_sound->HrefValue = "";
            $this->play_sound->TooltipValue = "";

            // window_open
            $this->window_open->LinkCustomAttributes = "";
            $this->window_open->HrefValue = "";
            $this->window_open->TooltipValue = "";

            // only_names
            $this->only_names->LinkCustomAttributes = "";
            $this->only_names->HrefValue = "";
            $this->only_names->TooltipValue = "";

            // chatroom_window
            $this->chatroom_window->LinkCustomAttributes = "";
            $this->chatroom_window->HrefValue = "";
            $this->chatroom_window->TooltipValue = "";

            // chatroom_stay
            $this->chatroom_stay->LinkCustomAttributes = "";
            $this->chatroom_stay->HrefValue = "";
            $this->chatroom_stay->TooltipValue = "";

            // chatroom_unfocus
            $this->chatroom_unfocus->LinkCustomAttributes = "";
            $this->chatroom_unfocus->HrefValue = "";
            $this->chatroom_unfocus->TooltipValue = "";

            // chatroom_show_names
            $this->chatroom_show_names->LinkCustomAttributes = "";
            $this->chatroom_show_names->HrefValue = "";
            $this->chatroom_show_names->TooltipValue = "";

            // chatroom_block_chats
            $this->chatroom_block_chats->LinkCustomAttributes = "";
            $this->chatroom_block_chats->HrefValue = "";
            $this->chatroom_block_chats->TooltipValue = "";

            // chatroom_sound
            $this->chatroom_sound->LinkCustomAttributes = "";
            $this->chatroom_sound->HrefValue = "";
            $this->chatroom_sound->TooltipValue = "";

            // announcement
            $this->announcement->LinkCustomAttributes = "";
            $this->announcement->HrefValue = "";
            $this->announcement->TooltipValue = "";

            // unfocus_chat
            $this->unfocus_chat->LinkCustomAttributes = "";
            $this->unfocus_chat->HrefValue = "";
            $this->unfocus_chat->TooltipValue = "";

            // focus_chat
            $this->focus_chat->LinkCustomAttributes = "";
            $this->focus_chat->HrefValue = "";
            $this->focus_chat->TooltipValue = "";

            // last_message
            $this->last_message->LinkCustomAttributes = "";
            $this->last_message->HrefValue = "";
            $this->last_message->TooltipValue = "";

            // clear_chats
            $this->clear_chats->LinkCustomAttributes = "";
            $this->clear_chats->HrefValue = "";
            $this->clear_chats->TooltipValue = "";

            // apps_bookmarks
            $this->apps_bookmarks->LinkCustomAttributes = "";
            $this->apps_bookmarks->HrefValue = "";
            $this->apps_bookmarks->TooltipValue = "";

            // apps_other
            $this->apps_other->LinkCustomAttributes = "";
            $this->apps_other->HrefValue = "";
            $this->apps_other->TooltipValue = "";

            // apps_open
            $this->apps_open->LinkCustomAttributes = "";
            $this->apps_open->HrefValue = "";
            $this->apps_open->TooltipValue = "";

            // apps_load
            $this->apps_load->LinkCustomAttributes = "";
            $this->apps_load->HrefValue = "";
            $this->apps_load->TooltipValue = "";

            // block_chats
            $this->block_chats->LinkCustomAttributes = "";
            $this->block_chats->HrefValue = "";
            $this->block_chats->TooltipValue = "";

            // session_time
            $this->session_time->LinkCustomAttributes = "";
            $this->session_time->HrefValue = "";
            $this->session_time->TooltipValue = "";

            // is_admin
            $this->is_admin->LinkCustomAttributes = "";
            $this->is_admin->HrefValue = "";
            $this->is_admin->TooltipValue = "";

            // is_mod
            $this->is_mod->LinkCustomAttributes = "";
            $this->is_mod->HrefValue = "";
            $this->is_mod->TooltipValue = "";

            // hash_id
            $this->hash_id->LinkCustomAttributes = "";
            $this->hash_id->HrefValue = "";
            $this->hash_id->TooltipValue = "";

            // ip_address
            $this->ip_address->LinkCustomAttributes = "";
            $this->ip_address->HrefValue = "";
            $this->ip_address->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // userid
            $this->_userid->EditAttrs["class"] = "form-control";
            $this->_userid->EditCustomAttributes = "";
            if (!$this->_userid->Raw) {
                $this->_userid->CurrentValue = HtmlDecode($this->_userid->CurrentValue);
            }
            $this->_userid->EditValue = HtmlEncode($this->_userid->CurrentValue);
            $this->_userid->PlaceHolder = RemoveHtml($this->_userid->caption());

            // guest_name
            $this->guest_name->EditAttrs["class"] = "form-control";
            $this->guest_name->EditCustomAttributes = "";
            if (!$this->guest_name->Raw) {
                $this->guest_name->CurrentValue = HtmlDecode($this->guest_name->CurrentValue);
            }
            $this->guest_name->EditValue = HtmlEncode($this->guest_name->CurrentValue);
            $this->guest_name->PlaceHolder = RemoveHtml($this->guest_name->caption());

            // message
            $this->message->EditAttrs["class"] = "form-control";
            $this->message->EditCustomAttributes = "";
            $this->message->EditValue = HtmlEncode($this->message->CurrentValue);
            $this->message->PlaceHolder = RemoveHtml($this->message->caption());

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // theme
            $this->theme->EditAttrs["class"] = "form-control";
            $this->theme->EditCustomAttributes = "";
            $this->theme->EditValue = HtmlEncode($this->theme->CurrentValue);
            $this->theme->PlaceHolder = RemoveHtml($this->theme->caption());

            // popout
            $this->popout->EditAttrs["class"] = "form-control";
            $this->popout->EditCustomAttributes = "";
            $this->popout->EditValue = HtmlEncode($this->popout->CurrentValue);
            $this->popout->PlaceHolder = RemoveHtml($this->popout->caption());

            // typing
            $this->typing->EditAttrs["class"] = "form-control";
            $this->typing->EditCustomAttributes = "";
            $this->typing->EditValue = HtmlEncode($this->typing->CurrentValue);
            $this->typing->PlaceHolder = RemoveHtml($this->typing->caption());

            // hide_bar
            $this->hide_bar->EditCustomAttributes = "";
            $this->hide_bar->EditValue = $this->hide_bar->options(false);
            $this->hide_bar->PlaceHolder = RemoveHtml($this->hide_bar->caption());

            // play_sound
            $this->play_sound->EditCustomAttributes = "";
            $this->play_sound->EditValue = $this->play_sound->options(false);
            $this->play_sound->PlaceHolder = RemoveHtml($this->play_sound->caption());

            // window_open
            $this->window_open->EditCustomAttributes = "";
            $this->window_open->EditValue = $this->window_open->options(false);
            $this->window_open->PlaceHolder = RemoveHtml($this->window_open->caption());

            // only_names
            $this->only_names->EditCustomAttributes = "";
            $this->only_names->EditValue = $this->only_names->options(false);
            $this->only_names->PlaceHolder = RemoveHtml($this->only_names->caption());

            // chatroom_window
            $this->chatroom_window->EditAttrs["class"] = "form-control";
            $this->chatroom_window->EditCustomAttributes = "";
            if (!$this->chatroom_window->Raw) {
                $this->chatroom_window->CurrentValue = HtmlDecode($this->chatroom_window->CurrentValue);
            }
            $this->chatroom_window->EditValue = HtmlEncode($this->chatroom_window->CurrentValue);
            $this->chatroom_window->PlaceHolder = RemoveHtml($this->chatroom_window->caption());

            // chatroom_stay
            $this->chatroom_stay->EditAttrs["class"] = "form-control";
            $this->chatroom_stay->EditCustomAttributes = "";
            if (!$this->chatroom_stay->Raw) {
                $this->chatroom_stay->CurrentValue = HtmlDecode($this->chatroom_stay->CurrentValue);
            }
            $this->chatroom_stay->EditValue = HtmlEncode($this->chatroom_stay->CurrentValue);
            $this->chatroom_stay->PlaceHolder = RemoveHtml($this->chatroom_stay->caption());

            // chatroom_unfocus
            $this->chatroom_unfocus->EditAttrs["class"] = "form-control";
            $this->chatroom_unfocus->EditCustomAttributes = "";
            $this->chatroom_unfocus->EditValue = HtmlEncode($this->chatroom_unfocus->CurrentValue);
            $this->chatroom_unfocus->PlaceHolder = RemoveHtml($this->chatroom_unfocus->caption());

            // chatroom_show_names
            $this->chatroom_show_names->EditCustomAttributes = "";
            $this->chatroom_show_names->EditValue = $this->chatroom_show_names->options(false);
            $this->chatroom_show_names->PlaceHolder = RemoveHtml($this->chatroom_show_names->caption());

            // chatroom_block_chats
            $this->chatroom_block_chats->EditCustomAttributes = "";
            $this->chatroom_block_chats->EditValue = $this->chatroom_block_chats->options(false);
            $this->chatroom_block_chats->PlaceHolder = RemoveHtml($this->chatroom_block_chats->caption());

            // chatroom_sound
            $this->chatroom_sound->EditCustomAttributes = "";
            $this->chatroom_sound->EditValue = $this->chatroom_sound->options(false);
            $this->chatroom_sound->PlaceHolder = RemoveHtml($this->chatroom_sound->caption());

            // announcement
            $this->announcement->EditCustomAttributes = "";
            $this->announcement->EditValue = $this->announcement->options(false);
            $this->announcement->PlaceHolder = RemoveHtml($this->announcement->caption());

            // unfocus_chat
            $this->unfocus_chat->EditAttrs["class"] = "form-control";
            $this->unfocus_chat->EditCustomAttributes = "";
            $this->unfocus_chat->EditValue = HtmlEncode($this->unfocus_chat->CurrentValue);
            $this->unfocus_chat->PlaceHolder = RemoveHtml($this->unfocus_chat->caption());

            // focus_chat
            $this->focus_chat->EditAttrs["class"] = "form-control";
            $this->focus_chat->EditCustomAttributes = "";
            if (!$this->focus_chat->Raw) {
                $this->focus_chat->CurrentValue = HtmlDecode($this->focus_chat->CurrentValue);
            }
            $this->focus_chat->EditValue = HtmlEncode($this->focus_chat->CurrentValue);
            $this->focus_chat->PlaceHolder = RemoveHtml($this->focus_chat->caption());

            // last_message
            $this->last_message->EditAttrs["class"] = "form-control";
            $this->last_message->EditCustomAttributes = "";
            $this->last_message->EditValue = HtmlEncode($this->last_message->CurrentValue);
            $this->last_message->PlaceHolder = RemoveHtml($this->last_message->caption());

            // clear_chats
            $this->clear_chats->EditAttrs["class"] = "form-control";
            $this->clear_chats->EditCustomAttributes = "";
            $this->clear_chats->EditValue = HtmlEncode($this->clear_chats->CurrentValue);
            $this->clear_chats->PlaceHolder = RemoveHtml($this->clear_chats->caption());

            // apps_bookmarks
            $this->apps_bookmarks->EditAttrs["class"] = "form-control";
            $this->apps_bookmarks->EditCustomAttributes = "";
            $this->apps_bookmarks->EditValue = HtmlEncode($this->apps_bookmarks->CurrentValue);
            $this->apps_bookmarks->PlaceHolder = RemoveHtml($this->apps_bookmarks->caption());

            // apps_other
            $this->apps_other->EditAttrs["class"] = "form-control";
            $this->apps_other->EditCustomAttributes = "";
            $this->apps_other->EditValue = HtmlEncode($this->apps_other->CurrentValue);
            $this->apps_other->PlaceHolder = RemoveHtml($this->apps_other->caption());

            // apps_open
            $this->apps_open->EditAttrs["class"] = "form-control";
            $this->apps_open->EditCustomAttributes = "";
            $this->apps_open->EditValue = HtmlEncode($this->apps_open->CurrentValue);
            $this->apps_open->PlaceHolder = RemoveHtml($this->apps_open->caption());

            // apps_load
            $this->apps_load->EditAttrs["class"] = "form-control";
            $this->apps_load->EditCustomAttributes = "";
            $this->apps_load->EditValue = HtmlEncode($this->apps_load->CurrentValue);
            $this->apps_load->PlaceHolder = RemoveHtml($this->apps_load->caption());

            // block_chats
            $this->block_chats->EditAttrs["class"] = "form-control";
            $this->block_chats->EditCustomAttributes = "";
            $this->block_chats->EditValue = HtmlEncode($this->block_chats->CurrentValue);
            $this->block_chats->PlaceHolder = RemoveHtml($this->block_chats->caption());

            // session_time
            $this->session_time->EditAttrs["class"] = "form-control";
            $this->session_time->EditCustomAttributes = "";
            $this->session_time->EditValue = HtmlEncode($this->session_time->CurrentValue);
            $this->session_time->PlaceHolder = RemoveHtml($this->session_time->caption());

            // is_admin
            $this->is_admin->EditCustomAttributes = "";
            $this->is_admin->EditValue = $this->is_admin->options(false);
            $this->is_admin->PlaceHolder = RemoveHtml($this->is_admin->caption());

            // is_mod
            $this->is_mod->EditCustomAttributes = "";
            $this->is_mod->EditValue = $this->is_mod->options(false);
            $this->is_mod->PlaceHolder = RemoveHtml($this->is_mod->caption());

            // hash_id
            $this->hash_id->EditAttrs["class"] = "form-control";
            $this->hash_id->EditCustomAttributes = "";
            if (!$this->hash_id->Raw) {
                $this->hash_id->CurrentValue = HtmlDecode($this->hash_id->CurrentValue);
            }
            $this->hash_id->EditValue = HtmlEncode($this->hash_id->CurrentValue);
            $this->hash_id->PlaceHolder = RemoveHtml($this->hash_id->caption());

            // ip_address
            $this->ip_address->EditAttrs["class"] = "form-control";
            $this->ip_address->EditCustomAttributes = "";
            if (!$this->ip_address->Raw) {
                $this->ip_address->CurrentValue = HtmlDecode($this->ip_address->CurrentValue);
            }
            $this->ip_address->EditValue = HtmlEncode($this->ip_address->CurrentValue);
            $this->ip_address->PlaceHolder = RemoveHtml($this->ip_address->caption());

            // Edit refer script

            // userid
            $this->_userid->LinkCustomAttributes = "";
            $this->_userid->HrefValue = "";

            // guest_name
            $this->guest_name->LinkCustomAttributes = "";
            $this->guest_name->HrefValue = "";

            // message
            $this->message->LinkCustomAttributes = "";
            $this->message->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // theme
            $this->theme->LinkCustomAttributes = "";
            $this->theme->HrefValue = "";

            // popout
            $this->popout->LinkCustomAttributes = "";
            $this->popout->HrefValue = "";

            // typing
            $this->typing->LinkCustomAttributes = "";
            $this->typing->HrefValue = "";

            // hide_bar
            $this->hide_bar->LinkCustomAttributes = "";
            $this->hide_bar->HrefValue = "";

            // play_sound
            $this->play_sound->LinkCustomAttributes = "";
            $this->play_sound->HrefValue = "";

            // window_open
            $this->window_open->LinkCustomAttributes = "";
            $this->window_open->HrefValue = "";

            // only_names
            $this->only_names->LinkCustomAttributes = "";
            $this->only_names->HrefValue = "";

            // chatroom_window
            $this->chatroom_window->LinkCustomAttributes = "";
            $this->chatroom_window->HrefValue = "";

            // chatroom_stay
            $this->chatroom_stay->LinkCustomAttributes = "";
            $this->chatroom_stay->HrefValue = "";

            // chatroom_unfocus
            $this->chatroom_unfocus->LinkCustomAttributes = "";
            $this->chatroom_unfocus->HrefValue = "";

            // chatroom_show_names
            $this->chatroom_show_names->LinkCustomAttributes = "";
            $this->chatroom_show_names->HrefValue = "";

            // chatroom_block_chats
            $this->chatroom_block_chats->LinkCustomAttributes = "";
            $this->chatroom_block_chats->HrefValue = "";

            // chatroom_sound
            $this->chatroom_sound->LinkCustomAttributes = "";
            $this->chatroom_sound->HrefValue = "";

            // announcement
            $this->announcement->LinkCustomAttributes = "";
            $this->announcement->HrefValue = "";

            // unfocus_chat
            $this->unfocus_chat->LinkCustomAttributes = "";
            $this->unfocus_chat->HrefValue = "";

            // focus_chat
            $this->focus_chat->LinkCustomAttributes = "";
            $this->focus_chat->HrefValue = "";

            // last_message
            $this->last_message->LinkCustomAttributes = "";
            $this->last_message->HrefValue = "";

            // clear_chats
            $this->clear_chats->LinkCustomAttributes = "";
            $this->clear_chats->HrefValue = "";

            // apps_bookmarks
            $this->apps_bookmarks->LinkCustomAttributes = "";
            $this->apps_bookmarks->HrefValue = "";

            // apps_other
            $this->apps_other->LinkCustomAttributes = "";
            $this->apps_other->HrefValue = "";

            // apps_open
            $this->apps_open->LinkCustomAttributes = "";
            $this->apps_open->HrefValue = "";

            // apps_load
            $this->apps_load->LinkCustomAttributes = "";
            $this->apps_load->HrefValue = "";

            // block_chats
            $this->block_chats->LinkCustomAttributes = "";
            $this->block_chats->HrefValue = "";

            // session_time
            $this->session_time->LinkCustomAttributes = "";
            $this->session_time->HrefValue = "";

            // is_admin
            $this->is_admin->LinkCustomAttributes = "";
            $this->is_admin->HrefValue = "";

            // is_mod
            $this->is_mod->LinkCustomAttributes = "";
            $this->is_mod->HrefValue = "";

            // hash_id
            $this->hash_id->LinkCustomAttributes = "";
            $this->hash_id->HrefValue = "";

            // ip_address
            $this->ip_address->LinkCustomAttributes = "";
            $this->ip_address->HrefValue = "";
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
        if ($this->_userid->Required) {
            if (!$this->_userid->IsDetailKey && EmptyValue($this->_userid->FormValue)) {
                $this->_userid->addErrorMessage(str_replace("%s", $this->_userid->caption(), $this->_userid->RequiredErrorMessage));
            }
        }
        if ($this->guest_name->Required) {
            if (!$this->guest_name->IsDetailKey && EmptyValue($this->guest_name->FormValue)) {
                $this->guest_name->addErrorMessage(str_replace("%s", $this->guest_name->caption(), $this->guest_name->RequiredErrorMessage));
            }
        }
        if ($this->message->Required) {
            if (!$this->message->IsDetailKey && EmptyValue($this->message->FormValue)) {
                $this->message->addErrorMessage(str_replace("%s", $this->message->caption(), $this->message->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->theme->Required) {
            if (!$this->theme->IsDetailKey && EmptyValue($this->theme->FormValue)) {
                $this->theme->addErrorMessage(str_replace("%s", $this->theme->caption(), $this->theme->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->theme->FormValue)) {
            $this->theme->addErrorMessage($this->theme->getErrorMessage(false));
        }
        if ($this->popout->Required) {
            if (!$this->popout->IsDetailKey && EmptyValue($this->popout->FormValue)) {
                $this->popout->addErrorMessage(str_replace("%s", $this->popout->caption(), $this->popout->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->popout->FormValue)) {
            $this->popout->addErrorMessage($this->popout->getErrorMessage(false));
        }
        if ($this->typing->Required) {
            if (!$this->typing->IsDetailKey && EmptyValue($this->typing->FormValue)) {
                $this->typing->addErrorMessage(str_replace("%s", $this->typing->caption(), $this->typing->RequiredErrorMessage));
            }
        }
        if ($this->hide_bar->Required) {
            if ($this->hide_bar->FormValue == "") {
                $this->hide_bar->addErrorMessage(str_replace("%s", $this->hide_bar->caption(), $this->hide_bar->RequiredErrorMessage));
            }
        }
        if ($this->play_sound->Required) {
            if ($this->play_sound->FormValue == "") {
                $this->play_sound->addErrorMessage(str_replace("%s", $this->play_sound->caption(), $this->play_sound->RequiredErrorMessage));
            }
        }
        if ($this->window_open->Required) {
            if ($this->window_open->FormValue == "") {
                $this->window_open->addErrorMessage(str_replace("%s", $this->window_open->caption(), $this->window_open->RequiredErrorMessage));
            }
        }
        if ($this->only_names->Required) {
            if ($this->only_names->FormValue == "") {
                $this->only_names->addErrorMessage(str_replace("%s", $this->only_names->caption(), $this->only_names->RequiredErrorMessage));
            }
        }
        if ($this->chatroom_window->Required) {
            if (!$this->chatroom_window->IsDetailKey && EmptyValue($this->chatroom_window->FormValue)) {
                $this->chatroom_window->addErrorMessage(str_replace("%s", $this->chatroom_window->caption(), $this->chatroom_window->RequiredErrorMessage));
            }
        }
        if ($this->chatroom_stay->Required) {
            if (!$this->chatroom_stay->IsDetailKey && EmptyValue($this->chatroom_stay->FormValue)) {
                $this->chatroom_stay->addErrorMessage(str_replace("%s", $this->chatroom_stay->caption(), $this->chatroom_stay->RequiredErrorMessage));
            }
        }
        if ($this->chatroom_unfocus->Required) {
            if (!$this->chatroom_unfocus->IsDetailKey && EmptyValue($this->chatroom_unfocus->FormValue)) {
                $this->chatroom_unfocus->addErrorMessage(str_replace("%s", $this->chatroom_unfocus->caption(), $this->chatroom_unfocus->RequiredErrorMessage));
            }
        }
        if ($this->chatroom_show_names->Required) {
            if ($this->chatroom_show_names->FormValue == "") {
                $this->chatroom_show_names->addErrorMessage(str_replace("%s", $this->chatroom_show_names->caption(), $this->chatroom_show_names->RequiredErrorMessage));
            }
        }
        if ($this->chatroom_block_chats->Required) {
            if ($this->chatroom_block_chats->FormValue == "") {
                $this->chatroom_block_chats->addErrorMessage(str_replace("%s", $this->chatroom_block_chats->caption(), $this->chatroom_block_chats->RequiredErrorMessage));
            }
        }
        if ($this->chatroom_sound->Required) {
            if ($this->chatroom_sound->FormValue == "") {
                $this->chatroom_sound->addErrorMessage(str_replace("%s", $this->chatroom_sound->caption(), $this->chatroom_sound->RequiredErrorMessage));
            }
        }
        if ($this->announcement->Required) {
            if ($this->announcement->FormValue == "") {
                $this->announcement->addErrorMessage(str_replace("%s", $this->announcement->caption(), $this->announcement->RequiredErrorMessage));
            }
        }
        if ($this->unfocus_chat->Required) {
            if (!$this->unfocus_chat->IsDetailKey && EmptyValue($this->unfocus_chat->FormValue)) {
                $this->unfocus_chat->addErrorMessage(str_replace("%s", $this->unfocus_chat->caption(), $this->unfocus_chat->RequiredErrorMessage));
            }
        }
        if ($this->focus_chat->Required) {
            if (!$this->focus_chat->IsDetailKey && EmptyValue($this->focus_chat->FormValue)) {
                $this->focus_chat->addErrorMessage(str_replace("%s", $this->focus_chat->caption(), $this->focus_chat->RequiredErrorMessage));
            }
        }
        if ($this->last_message->Required) {
            if (!$this->last_message->IsDetailKey && EmptyValue($this->last_message->FormValue)) {
                $this->last_message->addErrorMessage(str_replace("%s", $this->last_message->caption(), $this->last_message->RequiredErrorMessage));
            }
        }
        if ($this->clear_chats->Required) {
            if (!$this->clear_chats->IsDetailKey && EmptyValue($this->clear_chats->FormValue)) {
                $this->clear_chats->addErrorMessage(str_replace("%s", $this->clear_chats->caption(), $this->clear_chats->RequiredErrorMessage));
            }
        }
        if ($this->apps_bookmarks->Required) {
            if (!$this->apps_bookmarks->IsDetailKey && EmptyValue($this->apps_bookmarks->FormValue)) {
                $this->apps_bookmarks->addErrorMessage(str_replace("%s", $this->apps_bookmarks->caption(), $this->apps_bookmarks->RequiredErrorMessage));
            }
        }
        if ($this->apps_other->Required) {
            if (!$this->apps_other->IsDetailKey && EmptyValue($this->apps_other->FormValue)) {
                $this->apps_other->addErrorMessage(str_replace("%s", $this->apps_other->caption(), $this->apps_other->RequiredErrorMessage));
            }
        }
        if ($this->apps_open->Required) {
            if (!$this->apps_open->IsDetailKey && EmptyValue($this->apps_open->FormValue)) {
                $this->apps_open->addErrorMessage(str_replace("%s", $this->apps_open->caption(), $this->apps_open->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->apps_open->FormValue)) {
            $this->apps_open->addErrorMessage($this->apps_open->getErrorMessage(false));
        }
        if ($this->apps_load->Required) {
            if (!$this->apps_load->IsDetailKey && EmptyValue($this->apps_load->FormValue)) {
                $this->apps_load->addErrorMessage(str_replace("%s", $this->apps_load->caption(), $this->apps_load->RequiredErrorMessage));
            }
        }
        if ($this->block_chats->Required) {
            if (!$this->block_chats->IsDetailKey && EmptyValue($this->block_chats->FormValue)) {
                $this->block_chats->addErrorMessage(str_replace("%s", $this->block_chats->caption(), $this->block_chats->RequiredErrorMessage));
            }
        }
        if ($this->session_time->Required) {
            if (!$this->session_time->IsDetailKey && EmptyValue($this->session_time->FormValue)) {
                $this->session_time->addErrorMessage(str_replace("%s", $this->session_time->caption(), $this->session_time->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->session_time->FormValue)) {
            $this->session_time->addErrorMessage($this->session_time->getErrorMessage(false));
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
        if ($this->hash_id->Required) {
            if (!$this->hash_id->IsDetailKey && EmptyValue($this->hash_id->FormValue)) {
                $this->hash_id->addErrorMessage(str_replace("%s", $this->hash_id->caption(), $this->hash_id->RequiredErrorMessage));
            }
        }
        if ($this->ip_address->Required) {
            if (!$this->ip_address->IsDetailKey && EmptyValue($this->ip_address->FormValue)) {
                $this->ip_address->addErrorMessage(str_replace("%s", $this->ip_address->caption(), $this->ip_address->RequiredErrorMessage));
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

            // userid
            $this->_userid->setDbValueDef($rsnew, $this->_userid->CurrentValue, "", $this->_userid->ReadOnly);

            // guest_name
            $this->guest_name->setDbValueDef($rsnew, $this->guest_name->CurrentValue, null, $this->guest_name->ReadOnly);

            // message
            $this->message->setDbValueDef($rsnew, $this->message->CurrentValue, null, $this->message->ReadOnly);

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, $this->status->ReadOnly);

            // theme
            $this->theme->setDbValueDef($rsnew, $this->theme->CurrentValue, null, $this->theme->ReadOnly);

            // popout
            $this->popout->setDbValueDef($rsnew, $this->popout->CurrentValue, null, $this->popout->ReadOnly);

            // typing
            $this->typing->setDbValueDef($rsnew, $this->typing->CurrentValue, null, $this->typing->ReadOnly);

            // hide_bar
            $tmpBool = $this->hide_bar->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->hide_bar->setDbValueDef($rsnew, $tmpBool, null, $this->hide_bar->ReadOnly);

            // play_sound
            $tmpBool = $this->play_sound->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->play_sound->setDbValueDef($rsnew, $tmpBool, null, $this->play_sound->ReadOnly);

            // window_open
            $tmpBool = $this->window_open->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->window_open->setDbValueDef($rsnew, $tmpBool, null, $this->window_open->ReadOnly);

            // only_names
            $tmpBool = $this->only_names->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->only_names->setDbValueDef($rsnew, $tmpBool, null, $this->only_names->ReadOnly);

            // chatroom_window
            $this->chatroom_window->setDbValueDef($rsnew, $this->chatroom_window->CurrentValue, "", $this->chatroom_window->ReadOnly);

            // chatroom_stay
            $this->chatroom_stay->setDbValueDef($rsnew, $this->chatroom_stay->CurrentValue, "", $this->chatroom_stay->ReadOnly);

            // chatroom_unfocus
            $this->chatroom_unfocus->setDbValueDef($rsnew, $this->chatroom_unfocus->CurrentValue, null, $this->chatroom_unfocus->ReadOnly);

            // chatroom_show_names
            $tmpBool = $this->chatroom_show_names->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->chatroom_show_names->setDbValueDef($rsnew, $tmpBool, null, $this->chatroom_show_names->ReadOnly);

            // chatroom_block_chats
            $tmpBool = $this->chatroom_block_chats->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->chatroom_block_chats->setDbValueDef($rsnew, $tmpBool, null, $this->chatroom_block_chats->ReadOnly);

            // chatroom_sound
            $tmpBool = $this->chatroom_sound->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->chatroom_sound->setDbValueDef($rsnew, $tmpBool, null, $this->chatroom_sound->ReadOnly);

            // announcement
            $tmpBool = $this->announcement->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->announcement->setDbValueDef($rsnew, $tmpBool, 0, $this->announcement->ReadOnly);

            // unfocus_chat
            $this->unfocus_chat->setDbValueDef($rsnew, $this->unfocus_chat->CurrentValue, null, $this->unfocus_chat->ReadOnly);

            // focus_chat
            $this->focus_chat->setDbValueDef($rsnew, $this->focus_chat->CurrentValue, null, $this->focus_chat->ReadOnly);

            // last_message
            $this->last_message->setDbValueDef($rsnew, $this->last_message->CurrentValue, null, $this->last_message->ReadOnly);

            // clear_chats
            $this->clear_chats->setDbValueDef($rsnew, $this->clear_chats->CurrentValue, null, $this->clear_chats->ReadOnly);

            // apps_bookmarks
            $this->apps_bookmarks->setDbValueDef($rsnew, $this->apps_bookmarks->CurrentValue, null, $this->apps_bookmarks->ReadOnly);

            // apps_other
            $this->apps_other->setDbValueDef($rsnew, $this->apps_other->CurrentValue, null, $this->apps_other->ReadOnly);

            // apps_open
            $this->apps_open->setDbValueDef($rsnew, $this->apps_open->CurrentValue, null, $this->apps_open->ReadOnly);

            // apps_load
            $this->apps_load->setDbValueDef($rsnew, $this->apps_load->CurrentValue, null, $this->apps_load->ReadOnly);

            // block_chats
            $this->block_chats->setDbValueDef($rsnew, $this->block_chats->CurrentValue, null, $this->block_chats->ReadOnly);

            // session_time
            $this->session_time->setDbValueDef($rsnew, $this->session_time->CurrentValue, 0, $this->session_time->ReadOnly);

            // is_admin
            $tmpBool = $this->is_admin->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->is_admin->setDbValueDef($rsnew, $tmpBool, 0, $this->is_admin->ReadOnly);

            // is_mod
            $tmpBool = $this->is_mod->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->is_mod->setDbValueDef($rsnew, $tmpBool, 0, $this->is_mod->ReadOnly);

            // hash_id
            $this->hash_id->setDbValueDef($rsnew, $this->hash_id->CurrentValue, "", $this->hash_id->ReadOnly);

            // ip_address
            $this->ip_address->setDbValueDef($rsnew, $this->ip_address->CurrentValue, null, $this->ip_address->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);

            // Check for duplicate key when key changed
            if ($updateRow) {
                $newKeyFilter = $this->getRecordFilter($rsnew);
                if ($newKeyFilter != $oldKeyFilter) {
                    $rsChk = $this->loadRs($newKeyFilter)->fetch();
                    if ($rsChk !== false) {
                        $keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
                        $this->setFailureMessage($keyErrMsg);
                        $updateRow = false;
                    }
                }
            }
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ArrowchatStatusList"), "", $this->TableVar, true);
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
                case "x_hide_bar":
                    break;
                case "x_play_sound":
                    break;
                case "x_window_open":
                    break;
                case "x_only_names":
                    break;
                case "x_chatroom_show_names":
                    break;
                case "x_chatroom_block_chats":
                    break;
                case "x_chatroom_sound":
                    break;
                case "x_announcement":
                    break;
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
