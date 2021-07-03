<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ArrowchatStatusDelete extends ArrowchatStatus
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'arrowchat_status';

    // Page object name
    public $PageObjName = "ArrowchatStatusDelete";

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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action
        $this->_userid->setVisibility();
        $this->guest_name->setVisibility();
        $this->message->Visible = false;
        $this->status->setVisibility();
        $this->theme->setVisibility();
        $this->popout->setVisibility();
        $this->typing->Visible = false;
        $this->hide_bar->setVisibility();
        $this->play_sound->setVisibility();
        $this->window_open->setVisibility();
        $this->only_names->setVisibility();
        $this->chatroom_window->setVisibility();
        $this->chatroom_stay->setVisibility();
        $this->chatroom_unfocus->Visible = false;
        $this->chatroom_show_names->setVisibility();
        $this->chatroom_block_chats->setVisibility();
        $this->chatroom_sound->setVisibility();
        $this->announcement->setVisibility();
        $this->unfocus_chat->Visible = false;
        $this->focus_chat->setVisibility();
        $this->last_message->Visible = false;
        $this->clear_chats->Visible = false;
        $this->apps_bookmarks->Visible = false;
        $this->apps_other->Visible = false;
        $this->apps_open->setVisibility();
        $this->apps_load->Visible = false;
        $this->block_chats->Visible = false;
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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("ArrowchatStatusList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("ArrowchatStatusList"); // Return to list
                return;
            }
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

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
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

            // focus_chat
            $this->focus_chat->ViewValue = $this->focus_chat->CurrentValue;
            $this->focus_chat->ViewCustomAttributes = "";

            // apps_open
            $this->apps_open->ViewValue = $this->apps_open->CurrentValue;
            $this->apps_open->ViewValue = FormatNumber($this->apps_open->ViewValue, 0, -2, -2, -2);
            $this->apps_open->ViewCustomAttributes = "";

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

            // focus_chat
            $this->focus_chat->LinkCustomAttributes = "";
            $this->focus_chat->HrefValue = "";
            $this->focus_chat->TooltipValue = "";

            // apps_open
            $this->apps_open->LinkCustomAttributes = "";
            $this->apps_open->HrefValue = "";
            $this->apps_open->TooltipValue = "";

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

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        $conn->beginTransaction();

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['userid'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            $conn->commit(); // Commit the changes
        } else {
            $conn->rollback(); // Rollback changes
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ArrowchatStatusList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
}
