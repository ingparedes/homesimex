<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ArrowchatStatusView extends ArrowchatStatus
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'arrowchat_status';

    // Page object name
    public $PageObjName = "ArrowchatStatusView";

    // Rendering View
    public $RenderingView = false;

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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
        if (($keyValue = Get("_userid") ?? Route("_userid")) !== null) {
            $this->RecKey["_userid"] = $keyValue;
        }
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";

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

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
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
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;

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

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
        if ($this->isPageRequest()) { // Validate request
            if (($keyValue = Get("_userid") ?? Route("_userid")) !== null) {
                $this->_userid->setQueryStringValue($keyValue);
                $this->RecKey["_userid"] = $this->_userid->QueryStringValue;
            } elseif (Post("_userid") !== null) {
                $this->_userid->setFormValue(Post("_userid"));
                $this->RecKey["_userid"] = $this->_userid->FormValue;
            } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
                $this->_userid->setQueryStringValue($keyValue);
                $this->RecKey["_userid"] = $this->_userid->QueryStringValue;
            } else {
                $returnUrl = "ArrowchatStatusList"; // Return to list
            }

            // Get action
            $this->CurrentAction = "show"; // Display
            switch ($this->CurrentAction) {
                case "show": // Get a record to display

                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $this->Recordset = LoadRecordset($sql, $conn);
                        $res = $this->Recordset && !$this->Recordset->EOF;
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "ArrowchatStatusList"; // No matching record, return to list
                    }
                    break;
            }
        } else {
            $returnUrl = "ArrowchatStatusList"; // Not page request, return to list
        }
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = ROWTYPE_VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows]);
            $this->terminate(true);
            return;
        }

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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->AddUrl)) . "'});\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = ($this->AddUrl != "" && $Security->canAdd());

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->EditUrl)) . "'});\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = ($this->EditUrl != "" && $Security->canEdit());

        // Copy
        $item = &$option->add("copy");
        $copycaption = HtmlTitle($Language->phrase("ViewPageCopyLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'" . HtmlEncode(GetUrl($this->CopyUrl)) . "'});\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        }
        $item->Visible = ($this->CopyUrl != "" && $Security->canAdd());

        // Delete
        $item = &$option->add("delete");
        if ($this->IsModal) { // Handle as inline delete
            $item->Body = "<a onclick=\"return ew.confirmDelete(this);\" class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(UrlAddQuery(GetUrl($this->DeleteUrl), "action=1")) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        }
        $item->Visible = ($this->DeleteUrl != "" && $Security->canDelete());

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = false;
        $option->UseButtonGroup = true;
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

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
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ArrowchatStatusList"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
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

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }
}
