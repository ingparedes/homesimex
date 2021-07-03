<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ArrowchatChatroomRoomsEdit extends ArrowchatChatroomRooms
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'arrowchat_chatroom_rooms';

    // Page object name
    public $PageObjName = "ArrowchatChatroomRoomsEdit";

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

        // Table object (arrowchat_chatroom_rooms)
        if (!isset($GLOBALS["arrowchat_chatroom_rooms"]) || get_class($GLOBALS["arrowchat_chatroom_rooms"]) == PROJECT_NAMESPACE . "arrowchat_chatroom_rooms") {
            $GLOBALS["arrowchat_chatroom_rooms"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'arrowchat_chatroom_rooms');
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
                $doc = new $class(Container("arrowchat_chatroom_rooms"));
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
                    if ($pageName == "ArrowchatChatroomRoomsView") {
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
        $this->author_id->setVisibility();
        $this->name->setVisibility();
        $this->description->setVisibility();
        $this->welcome_message->setVisibility();
        $this->image->setVisibility();
        $this->type->setVisibility();
        $this->_password->setVisibility();
        $this->length->setVisibility();
        $this->is_featured->setVisibility();
        $this->max_users->setVisibility();
        $this->limit_message_num->setVisibility();
        $this->limit_seconds_num->setVisibility();
        $this->disallowed_groups->setVisibility();
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
                    $this->terminate("ArrowchatChatroomRoomsList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ArrowchatChatroomRoomsList") {
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

        // Check field name 'author_id' first before field var 'x_author_id'
        $val = $CurrentForm->hasValue("author_id") ? $CurrentForm->getValue("author_id") : $CurrentForm->getValue("x_author_id");
        if (!$this->author_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->author_id->Visible = false; // Disable update for API request
            } else {
                $this->author_id->setFormValue($val);
            }
        }

        // Check field name 'name' first before field var 'x_name'
        $val = $CurrentForm->hasValue("name") ? $CurrentForm->getValue("name") : $CurrentForm->getValue("x_name");
        if (!$this->name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->name->Visible = false; // Disable update for API request
            } else {
                $this->name->setFormValue($val);
            }
        }

        // Check field name 'description' first before field var 'x_description'
        $val = $CurrentForm->hasValue("description") ? $CurrentForm->getValue("description") : $CurrentForm->getValue("x_description");
        if (!$this->description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->description->Visible = false; // Disable update for API request
            } else {
                $this->description->setFormValue($val);
            }
        }

        // Check field name 'welcome_message' first before field var 'x_welcome_message'
        $val = $CurrentForm->hasValue("welcome_message") ? $CurrentForm->getValue("welcome_message") : $CurrentForm->getValue("x_welcome_message");
        if (!$this->welcome_message->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->welcome_message->Visible = false; // Disable update for API request
            } else {
                $this->welcome_message->setFormValue($val);
            }
        }

        // Check field name 'image' first before field var 'x_image'
        $val = $CurrentForm->hasValue("image") ? $CurrentForm->getValue("image") : $CurrentForm->getValue("x_image");
        if (!$this->image->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->image->Visible = false; // Disable update for API request
            } else {
                $this->image->setFormValue($val);
            }
        }

        // Check field name 'type' first before field var 'x_type'
        $val = $CurrentForm->hasValue("type") ? $CurrentForm->getValue("type") : $CurrentForm->getValue("x_type");
        if (!$this->type->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->type->Visible = false; // Disable update for API request
            } else {
                $this->type->setFormValue($val);
            }
        }

        // Check field name 'password' first before field var 'x__password'
        $val = $CurrentForm->hasValue("password") ? $CurrentForm->getValue("password") : $CurrentForm->getValue("x__password");
        if (!$this->_password->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_password->Visible = false; // Disable update for API request
            } else {
                $this->_password->setFormValue($val);
            }
        }

        // Check field name 'length' first before field var 'x_length'
        $val = $CurrentForm->hasValue("length") ? $CurrentForm->getValue("length") : $CurrentForm->getValue("x_length");
        if (!$this->length->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->length->Visible = false; // Disable update for API request
            } else {
                $this->length->setFormValue($val);
            }
        }

        // Check field name 'is_featured' first before field var 'x_is_featured'
        $val = $CurrentForm->hasValue("is_featured") ? $CurrentForm->getValue("is_featured") : $CurrentForm->getValue("x_is_featured");
        if (!$this->is_featured->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->is_featured->Visible = false; // Disable update for API request
            } else {
                $this->is_featured->setFormValue($val);
            }
        }

        // Check field name 'max_users' first before field var 'x_max_users'
        $val = $CurrentForm->hasValue("max_users") ? $CurrentForm->getValue("max_users") : $CurrentForm->getValue("x_max_users");
        if (!$this->max_users->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->max_users->Visible = false; // Disable update for API request
            } else {
                $this->max_users->setFormValue($val);
            }
        }

        // Check field name 'limit_message_num' first before field var 'x_limit_message_num'
        $val = $CurrentForm->hasValue("limit_message_num") ? $CurrentForm->getValue("limit_message_num") : $CurrentForm->getValue("x_limit_message_num");
        if (!$this->limit_message_num->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->limit_message_num->Visible = false; // Disable update for API request
            } else {
                $this->limit_message_num->setFormValue($val);
            }
        }

        // Check field name 'limit_seconds_num' first before field var 'x_limit_seconds_num'
        $val = $CurrentForm->hasValue("limit_seconds_num") ? $CurrentForm->getValue("limit_seconds_num") : $CurrentForm->getValue("x_limit_seconds_num");
        if (!$this->limit_seconds_num->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->limit_seconds_num->Visible = false; // Disable update for API request
            } else {
                $this->limit_seconds_num->setFormValue($val);
            }
        }

        // Check field name 'disallowed_groups' first before field var 'x_disallowed_groups'
        $val = $CurrentForm->hasValue("disallowed_groups") ? $CurrentForm->getValue("disallowed_groups") : $CurrentForm->getValue("x_disallowed_groups");
        if (!$this->disallowed_groups->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->disallowed_groups->Visible = false; // Disable update for API request
            } else {
                $this->disallowed_groups->setFormValue($val);
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
        $this->id->CurrentValue = $this->id->FormValue;
        $this->author_id->CurrentValue = $this->author_id->FormValue;
        $this->name->CurrentValue = $this->name->FormValue;
        $this->description->CurrentValue = $this->description->FormValue;
        $this->welcome_message->CurrentValue = $this->welcome_message->FormValue;
        $this->image->CurrentValue = $this->image->FormValue;
        $this->type->CurrentValue = $this->type->FormValue;
        $this->_password->CurrentValue = $this->_password->FormValue;
        $this->length->CurrentValue = $this->length->FormValue;
        $this->is_featured->CurrentValue = $this->is_featured->FormValue;
        $this->max_users->CurrentValue = $this->max_users->FormValue;
        $this->limit_message_num->CurrentValue = $this->limit_message_num->FormValue;
        $this->limit_seconds_num->CurrentValue = $this->limit_seconds_num->FormValue;
        $this->disallowed_groups->CurrentValue = $this->disallowed_groups->FormValue;
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
        $this->id->setDbValue($row['id']);
        $this->author_id->setDbValue($row['author_id']);
        $this->name->setDbValue($row['name']);
        $this->description->setDbValue($row['description']);
        $this->welcome_message->setDbValue($row['welcome_message']);
        $this->image->setDbValue($row['image']);
        $this->type->setDbValue($row['type']);
        $this->_password->setDbValue($row['password']);
        $this->length->setDbValue($row['length']);
        $this->is_featured->setDbValue($row['is_featured']);
        $this->max_users->setDbValue($row['max_users']);
        $this->limit_message_num->setDbValue($row['limit_message_num']);
        $this->limit_seconds_num->setDbValue($row['limit_seconds_num']);
        $this->disallowed_groups->setDbValue($row['disallowed_groups']);
        $this->session_time->setDbValue($row['session_time']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['author_id'] = null;
        $row['name'] = null;
        $row['description'] = null;
        $row['welcome_message'] = null;
        $row['image'] = null;
        $row['type'] = null;
        $row['password'] = null;
        $row['length'] = null;
        $row['is_featured'] = null;
        $row['max_users'] = null;
        $row['limit_message_num'] = null;
        $row['limit_seconds_num'] = null;
        $row['disallowed_groups'] = null;
        $row['session_time'] = null;
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

        // author_id

        // name

        // description

        // welcome_message

        // image

        // type

        // password

        // length

        // is_featured

        // max_users

        // limit_message_num

        // limit_seconds_num

        // disallowed_groups

        // session_time
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // author_id
            $this->author_id->ViewValue = $this->author_id->CurrentValue;
            $this->author_id->ViewCustomAttributes = "";

            // name
            $this->name->ViewValue = $this->name->CurrentValue;
            $this->name->ViewCustomAttributes = "";

            // description
            $this->description->ViewValue = $this->description->CurrentValue;
            $this->description->ViewCustomAttributes = "";

            // welcome_message
            $this->welcome_message->ViewValue = $this->welcome_message->CurrentValue;
            $this->welcome_message->ViewCustomAttributes = "";

            // image
            $this->image->ViewValue = $this->image->CurrentValue;
            $this->image->ViewCustomAttributes = "";

            // type
            if (ConvertToBool($this->type->CurrentValue)) {
                $this->type->ViewValue = $this->type->tagCaption(1) != "" ? $this->type->tagCaption(1) : "Yes";
            } else {
                $this->type->ViewValue = $this->type->tagCaption(2) != "" ? $this->type->tagCaption(2) : "No";
            }
            $this->type->ViewCustomAttributes = "";

            // password
            $this->_password->ViewValue = $this->_password->CurrentValue;
            $this->_password->ViewCustomAttributes = "";

            // length
            $this->length->ViewValue = $this->length->CurrentValue;
            $this->length->ViewValue = FormatNumber($this->length->ViewValue, 0, -2, -2, -2);
            $this->length->ViewCustomAttributes = "";

            // is_featured
            if (ConvertToBool($this->is_featured->CurrentValue)) {
                $this->is_featured->ViewValue = $this->is_featured->tagCaption(1) != "" ? $this->is_featured->tagCaption(1) : "Yes";
            } else {
                $this->is_featured->ViewValue = $this->is_featured->tagCaption(2) != "" ? $this->is_featured->tagCaption(2) : "No";
            }
            $this->is_featured->ViewCustomAttributes = "";

            // max_users
            $this->max_users->ViewValue = $this->max_users->CurrentValue;
            $this->max_users->ViewValue = FormatNumber($this->max_users->ViewValue, 0, -2, -2, -2);
            $this->max_users->ViewCustomAttributes = "";

            // limit_message_num
            $this->limit_message_num->ViewValue = $this->limit_message_num->CurrentValue;
            $this->limit_message_num->ViewValue = FormatNumber($this->limit_message_num->ViewValue, 0, -2, -2, -2);
            $this->limit_message_num->ViewCustomAttributes = "";

            // limit_seconds_num
            $this->limit_seconds_num->ViewValue = $this->limit_seconds_num->CurrentValue;
            $this->limit_seconds_num->ViewValue = FormatNumber($this->limit_seconds_num->ViewValue, 0, -2, -2, -2);
            $this->limit_seconds_num->ViewCustomAttributes = "";

            // disallowed_groups
            $this->disallowed_groups->ViewValue = $this->disallowed_groups->CurrentValue;
            $this->disallowed_groups->ViewCustomAttributes = "";

            // session_time
            $this->session_time->ViewValue = $this->session_time->CurrentValue;
            $this->session_time->ViewValue = FormatNumber($this->session_time->ViewValue, 0, -2, -2, -2);
            $this->session_time->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // author_id
            $this->author_id->LinkCustomAttributes = "";
            $this->author_id->HrefValue = "";
            $this->author_id->TooltipValue = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";
            $this->name->TooltipValue = "";

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";
            $this->description->TooltipValue = "";

            // welcome_message
            $this->welcome_message->LinkCustomAttributes = "";
            $this->welcome_message->HrefValue = "";
            $this->welcome_message->TooltipValue = "";

            // image
            $this->image->LinkCustomAttributes = "";
            $this->image->HrefValue = "";
            $this->image->TooltipValue = "";

            // type
            $this->type->LinkCustomAttributes = "";
            $this->type->HrefValue = "";
            $this->type->TooltipValue = "";

            // password
            $this->_password->LinkCustomAttributes = "";
            $this->_password->HrefValue = "";
            $this->_password->TooltipValue = "";

            // length
            $this->length->LinkCustomAttributes = "";
            $this->length->HrefValue = "";
            $this->length->TooltipValue = "";

            // is_featured
            $this->is_featured->LinkCustomAttributes = "";
            $this->is_featured->HrefValue = "";
            $this->is_featured->TooltipValue = "";

            // max_users
            $this->max_users->LinkCustomAttributes = "";
            $this->max_users->HrefValue = "";
            $this->max_users->TooltipValue = "";

            // limit_message_num
            $this->limit_message_num->LinkCustomAttributes = "";
            $this->limit_message_num->HrefValue = "";
            $this->limit_message_num->TooltipValue = "";

            // limit_seconds_num
            $this->limit_seconds_num->LinkCustomAttributes = "";
            $this->limit_seconds_num->HrefValue = "";
            $this->limit_seconds_num->TooltipValue = "";

            // disallowed_groups
            $this->disallowed_groups->LinkCustomAttributes = "";
            $this->disallowed_groups->HrefValue = "";
            $this->disallowed_groups->TooltipValue = "";

            // session_time
            $this->session_time->LinkCustomAttributes = "";
            $this->session_time->HrefValue = "";
            $this->session_time->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // author_id
            $this->author_id->EditAttrs["class"] = "form-control";
            $this->author_id->EditCustomAttributes = "";
            if (!$this->author_id->Raw) {
                $this->author_id->CurrentValue = HtmlDecode($this->author_id->CurrentValue);
            }
            $this->author_id->EditValue = HtmlEncode($this->author_id->CurrentValue);
            $this->author_id->PlaceHolder = RemoveHtml($this->author_id->caption());

            // name
            $this->name->EditAttrs["class"] = "form-control";
            $this->name->EditCustomAttributes = "";
            if (!$this->name->Raw) {
                $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
            }
            $this->name->EditValue = HtmlEncode($this->name->CurrentValue);
            $this->name->PlaceHolder = RemoveHtml($this->name->caption());

            // description
            $this->description->EditAttrs["class"] = "form-control";
            $this->description->EditCustomAttributes = "";
            if (!$this->description->Raw) {
                $this->description->CurrentValue = HtmlDecode($this->description->CurrentValue);
            }
            $this->description->EditValue = HtmlEncode($this->description->CurrentValue);
            $this->description->PlaceHolder = RemoveHtml($this->description->caption());

            // welcome_message
            $this->welcome_message->EditAttrs["class"] = "form-control";
            $this->welcome_message->EditCustomAttributes = "";
            if (!$this->welcome_message->Raw) {
                $this->welcome_message->CurrentValue = HtmlDecode($this->welcome_message->CurrentValue);
            }
            $this->welcome_message->EditValue = HtmlEncode($this->welcome_message->CurrentValue);
            $this->welcome_message->PlaceHolder = RemoveHtml($this->welcome_message->caption());

            // image
            $this->image->EditAttrs["class"] = "form-control";
            $this->image->EditCustomAttributes = "";
            if (!$this->image->Raw) {
                $this->image->CurrentValue = HtmlDecode($this->image->CurrentValue);
            }
            $this->image->EditValue = HtmlEncode($this->image->CurrentValue);
            $this->image->PlaceHolder = RemoveHtml($this->image->caption());

            // type
            $this->type->EditCustomAttributes = "";
            $this->type->EditValue = $this->type->options(false);
            $this->type->PlaceHolder = RemoveHtml($this->type->caption());

            // password
            $this->_password->EditAttrs["class"] = "form-control";
            $this->_password->EditCustomAttributes = "";
            if (!$this->_password->Raw) {
                $this->_password->CurrentValue = HtmlDecode($this->_password->CurrentValue);
            }
            $this->_password->EditValue = HtmlEncode($this->_password->CurrentValue);
            $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

            // length
            $this->length->EditAttrs["class"] = "form-control";
            $this->length->EditCustomAttributes = "";
            $this->length->EditValue = HtmlEncode($this->length->CurrentValue);
            $this->length->PlaceHolder = RemoveHtml($this->length->caption());

            // is_featured
            $this->is_featured->EditCustomAttributes = "";
            $this->is_featured->EditValue = $this->is_featured->options(false);
            $this->is_featured->PlaceHolder = RemoveHtml($this->is_featured->caption());

            // max_users
            $this->max_users->EditAttrs["class"] = "form-control";
            $this->max_users->EditCustomAttributes = "";
            $this->max_users->EditValue = HtmlEncode($this->max_users->CurrentValue);
            $this->max_users->PlaceHolder = RemoveHtml($this->max_users->caption());

            // limit_message_num
            $this->limit_message_num->EditAttrs["class"] = "form-control";
            $this->limit_message_num->EditCustomAttributes = "";
            $this->limit_message_num->EditValue = HtmlEncode($this->limit_message_num->CurrentValue);
            $this->limit_message_num->PlaceHolder = RemoveHtml($this->limit_message_num->caption());

            // limit_seconds_num
            $this->limit_seconds_num->EditAttrs["class"] = "form-control";
            $this->limit_seconds_num->EditCustomAttributes = "";
            $this->limit_seconds_num->EditValue = HtmlEncode($this->limit_seconds_num->CurrentValue);
            $this->limit_seconds_num->PlaceHolder = RemoveHtml($this->limit_seconds_num->caption());

            // disallowed_groups
            $this->disallowed_groups->EditAttrs["class"] = "form-control";
            $this->disallowed_groups->EditCustomAttributes = "";
            $this->disallowed_groups->EditValue = HtmlEncode($this->disallowed_groups->CurrentValue);
            $this->disallowed_groups->PlaceHolder = RemoveHtml($this->disallowed_groups->caption());

            // session_time
            $this->session_time->EditAttrs["class"] = "form-control";
            $this->session_time->EditCustomAttributes = "";
            $this->session_time->EditValue = HtmlEncode($this->session_time->CurrentValue);
            $this->session_time->PlaceHolder = RemoveHtml($this->session_time->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // author_id
            $this->author_id->LinkCustomAttributes = "";
            $this->author_id->HrefValue = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";

            // description
            $this->description->LinkCustomAttributes = "";
            $this->description->HrefValue = "";

            // welcome_message
            $this->welcome_message->LinkCustomAttributes = "";
            $this->welcome_message->HrefValue = "";

            // image
            $this->image->LinkCustomAttributes = "";
            $this->image->HrefValue = "";

            // type
            $this->type->LinkCustomAttributes = "";
            $this->type->HrefValue = "";

            // password
            $this->_password->LinkCustomAttributes = "";
            $this->_password->HrefValue = "";

            // length
            $this->length->LinkCustomAttributes = "";
            $this->length->HrefValue = "";

            // is_featured
            $this->is_featured->LinkCustomAttributes = "";
            $this->is_featured->HrefValue = "";

            // max_users
            $this->max_users->LinkCustomAttributes = "";
            $this->max_users->HrefValue = "";

            // limit_message_num
            $this->limit_message_num->LinkCustomAttributes = "";
            $this->limit_message_num->HrefValue = "";

            // limit_seconds_num
            $this->limit_seconds_num->LinkCustomAttributes = "";
            $this->limit_seconds_num->HrefValue = "";

            // disallowed_groups
            $this->disallowed_groups->LinkCustomAttributes = "";
            $this->disallowed_groups->HrefValue = "";

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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->author_id->Required) {
            if (!$this->author_id->IsDetailKey && EmptyValue($this->author_id->FormValue)) {
                $this->author_id->addErrorMessage(str_replace("%s", $this->author_id->caption(), $this->author_id->RequiredErrorMessage));
            }
        }
        if ($this->name->Required) {
            if (!$this->name->IsDetailKey && EmptyValue($this->name->FormValue)) {
                $this->name->addErrorMessage(str_replace("%s", $this->name->caption(), $this->name->RequiredErrorMessage));
            }
        }
        if ($this->description->Required) {
            if (!$this->description->IsDetailKey && EmptyValue($this->description->FormValue)) {
                $this->description->addErrorMessage(str_replace("%s", $this->description->caption(), $this->description->RequiredErrorMessage));
            }
        }
        if ($this->welcome_message->Required) {
            if (!$this->welcome_message->IsDetailKey && EmptyValue($this->welcome_message->FormValue)) {
                $this->welcome_message->addErrorMessage(str_replace("%s", $this->welcome_message->caption(), $this->welcome_message->RequiredErrorMessage));
            }
        }
        if ($this->image->Required) {
            if (!$this->image->IsDetailKey && EmptyValue($this->image->FormValue)) {
                $this->image->addErrorMessage(str_replace("%s", $this->image->caption(), $this->image->RequiredErrorMessage));
            }
        }
        if ($this->type->Required) {
            if ($this->type->FormValue == "") {
                $this->type->addErrorMessage(str_replace("%s", $this->type->caption(), $this->type->RequiredErrorMessage));
            }
        }
        if ($this->_password->Required) {
            if (!$this->_password->IsDetailKey && EmptyValue($this->_password->FormValue)) {
                $this->_password->addErrorMessage(str_replace("%s", $this->_password->caption(), $this->_password->RequiredErrorMessage));
            }
        }
        if ($this->length->Required) {
            if (!$this->length->IsDetailKey && EmptyValue($this->length->FormValue)) {
                $this->length->addErrorMessage(str_replace("%s", $this->length->caption(), $this->length->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->length->FormValue)) {
            $this->length->addErrorMessage($this->length->getErrorMessage(false));
        }
        if ($this->is_featured->Required) {
            if ($this->is_featured->FormValue == "") {
                $this->is_featured->addErrorMessage(str_replace("%s", $this->is_featured->caption(), $this->is_featured->RequiredErrorMessage));
            }
        }
        if ($this->max_users->Required) {
            if (!$this->max_users->IsDetailKey && EmptyValue($this->max_users->FormValue)) {
                $this->max_users->addErrorMessage(str_replace("%s", $this->max_users->caption(), $this->max_users->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->max_users->FormValue)) {
            $this->max_users->addErrorMessage($this->max_users->getErrorMessage(false));
        }
        if ($this->limit_message_num->Required) {
            if (!$this->limit_message_num->IsDetailKey && EmptyValue($this->limit_message_num->FormValue)) {
                $this->limit_message_num->addErrorMessage(str_replace("%s", $this->limit_message_num->caption(), $this->limit_message_num->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->limit_message_num->FormValue)) {
            $this->limit_message_num->addErrorMessage($this->limit_message_num->getErrorMessage(false));
        }
        if ($this->limit_seconds_num->Required) {
            if (!$this->limit_seconds_num->IsDetailKey && EmptyValue($this->limit_seconds_num->FormValue)) {
                $this->limit_seconds_num->addErrorMessage(str_replace("%s", $this->limit_seconds_num->caption(), $this->limit_seconds_num->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->limit_seconds_num->FormValue)) {
            $this->limit_seconds_num->addErrorMessage($this->limit_seconds_num->getErrorMessage(false));
        }
        if ($this->disallowed_groups->Required) {
            if (!$this->disallowed_groups->IsDetailKey && EmptyValue($this->disallowed_groups->FormValue)) {
                $this->disallowed_groups->addErrorMessage(str_replace("%s", $this->disallowed_groups->caption(), $this->disallowed_groups->RequiredErrorMessage));
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

            // author_id
            $this->author_id->setDbValueDef($rsnew, $this->author_id->CurrentValue, "", $this->author_id->ReadOnly);

            // name
            $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, "", $this->name->ReadOnly);

            // description
            $this->description->setDbValueDef($rsnew, $this->description->CurrentValue, null, $this->description->ReadOnly);

            // welcome_message
            $this->welcome_message->setDbValueDef($rsnew, $this->welcome_message->CurrentValue, null, $this->welcome_message->ReadOnly);

            // image
            $this->image->setDbValueDef($rsnew, $this->image->CurrentValue, null, $this->image->ReadOnly);

            // type
            $tmpBool = $this->type->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->type->setDbValueDef($rsnew, $tmpBool, 0, $this->type->ReadOnly);

            // password
            $this->_password->setDbValueDef($rsnew, $this->_password->CurrentValue, null, $this->_password->ReadOnly);

            // length
            $this->length->setDbValueDef($rsnew, $this->length->CurrentValue, 0, $this->length->ReadOnly);

            // is_featured
            $tmpBool = $this->is_featured->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->is_featured->setDbValueDef($rsnew, $tmpBool, null, $this->is_featured->ReadOnly);

            // max_users
            $this->max_users->setDbValueDef($rsnew, $this->max_users->CurrentValue, 0, $this->max_users->ReadOnly);

            // limit_message_num
            $this->limit_message_num->setDbValueDef($rsnew, $this->limit_message_num->CurrentValue, 0, $this->limit_message_num->ReadOnly);

            // limit_seconds_num
            $this->limit_seconds_num->setDbValueDef($rsnew, $this->limit_seconds_num->CurrentValue, 0, $this->limit_seconds_num->ReadOnly);

            // disallowed_groups
            $this->disallowed_groups->setDbValueDef($rsnew, $this->disallowed_groups->CurrentValue, "", $this->disallowed_groups->ReadOnly);

            // session_time
            $this->session_time->setDbValueDef($rsnew, $this->session_time->CurrentValue, 0, $this->session_time->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ArrowchatChatroomRoomsList"), "", $this->TableVar, true);
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
                case "x_type":
                    break;
                case "x_is_featured":
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
