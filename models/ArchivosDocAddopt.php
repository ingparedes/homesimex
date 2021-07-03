<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ArchivosDocAddopt extends ArchivosDoc
{
    use MessagesTrait;

    // Page ID
    public $PageID = "addopt";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'archivos_doc';

    // Page object name
    public $PageObjName = "ArchivosDocAddopt";

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

        // Table object (archivos_doc)
        if (!isset($GLOBALS["archivos_doc"]) || get_class($GLOBALS["archivos_doc"]) == PROJECT_NAMESPACE . "archivos_doc") {
            $GLOBALS["archivos_doc"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'archivos_doc');
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
                $doc = new $class(Container("archivos_doc"));
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
            $key .= @$ar['id_file'];
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
            $this->id_file->Visible = false;
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
    public $IsModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id_file->Visible = false;
        $this->id_users->setVisibility();
        $this->file_name->setVisibility();
        $this->fecha_created->setVisibility();
        $this->boton->setVisibility();
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
        $this->setupLookupOptions($this->id_users);

        // Set up Breadcrumb
        //$this->setupBreadcrumb(); // Not used
        $this->loadRowValues(); // Load default values

        // Render row
        $this->RowType = ROWTYPE_ADD; // Render add type
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
        $this->file_name->Upload->Index = $CurrentForm->Index;
        $this->file_name->Upload->uploadFile();
        $this->file_name->CurrentValue = $this->file_name->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id_file->CurrentValue = null;
        $this->id_file->OldValue = $this->id_file->CurrentValue;
        $this->id_users->CurrentValue = CurrentUserID();
        $this->file_name->Upload->DbValue = null;
        $this->file_name->OldValue = $this->file_name->Upload->DbValue;
        $this->file_name->CurrentValue = null; // Clear file related field
        $this->fecha_created->CurrentValue = null;
        $this->fecha_created->OldValue = $this->fecha_created->CurrentValue;
        $this->boton->CurrentValue = null;
        $this->boton->OldValue = $this->boton->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_users' first before field var 'x_id_users'
        $val = $CurrentForm->hasValue("id_users") ? $CurrentForm->getValue("id_users") : $CurrentForm->getValue("x_id_users");
        if (!$this->id_users->IsDetailKey) {
            $this->id_users->setFormValue(ConvertFromUtf8($val));
        }

        // Check field name 'fecha_created' first before field var 'x_fecha_created'
        $val = $CurrentForm->hasValue("fecha_created") ? $CurrentForm->getValue("fecha_created") : $CurrentForm->getValue("x_fecha_created");
        if (!$this->fecha_created->IsDetailKey) {
            $this->fecha_created->setFormValue(ConvertFromUtf8($val));
            $this->fecha_created->CurrentValue = UnFormatDateTime($this->fecha_created->CurrentValue, 9);
        }

        // Check field name 'boton' first before field var 'x_boton'
        $val = $CurrentForm->hasValue("boton") ? $CurrentForm->getValue("boton") : $CurrentForm->getValue("x_boton");
        if (!$this->boton->IsDetailKey) {
            $this->boton->setFormValue(ConvertFromUtf8($val));
        }

        // Check field name 'id_file' first before field var 'x_id_file'
        $val = $CurrentForm->hasValue("id_file") ? $CurrentForm->getValue("id_file") : $CurrentForm->getValue("x_id_file");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_users->CurrentValue = ConvertToUtf8($this->id_users->FormValue);
        $this->fecha_created->CurrentValue = ConvertToUtf8($this->fecha_created->FormValue);
        $this->fecha_created->CurrentValue = UnFormatDateTime($this->fecha_created->CurrentValue, 9);
        $this->boton->CurrentValue = ConvertToUtf8($this->boton->FormValue);
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
        $this->id_file->setDbValue($row['id_file']);
        $this->id_users->setDbValue($row['id_users']);
        $this->file_name->Upload->DbValue = $row['file_name'];
        $this->file_name->setDbValue($this->file_name->Upload->DbValue);
        $this->fecha_created->setDbValue($row['fecha_created']);
        $this->boton->setDbValue($row['boton']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id_file'] = $this->id_file->CurrentValue;
        $row['id_users'] = $this->id_users->CurrentValue;
        $row['file_name'] = $this->file_name->Upload->DbValue;
        $row['fecha_created'] = $this->fecha_created->CurrentValue;
        $row['boton'] = $this->boton->CurrentValue;
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

        // id_file

        // id_users

        // file_name

        // fecha_created

        // boton
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_file
            $this->id_file->ViewValue = $this->id_file->CurrentValue;
            $this->id_file->ViewCustomAttributes = "";

            // id_users
            $curVal = trim(strval($this->id_users->CurrentValue));
            if ($curVal != "") {
                $this->id_users->ViewValue = $this->id_users->lookupCacheOption($curVal);
                if ($this->id_users->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->id_users->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->id_users->Lookup->renderViewRow($rswrk[0]);
                        $this->id_users->ViewValue = $this->id_users->displayValue($arwrk);
                    } else {
                        $this->id_users->ViewValue = $this->id_users->CurrentValue;
                    }
                }
            } else {
                $this->id_users->ViewValue = null;
            }
            $this->id_users->ViewCustomAttributes = "";

            // file_name
            if (!EmptyValue($this->file_name->Upload->DbValue)) {
                $this->file_name->ViewValue = $this->file_name->Upload->DbValue;
            } else {
                $this->file_name->ViewValue = "";
            }
            $this->file_name->ViewCustomAttributes = "";

            // fecha_created
            $this->fecha_created->ViewValue = $this->fecha_created->CurrentValue;
            $this->fecha_created->ViewValue = FormatDateTime($this->fecha_created->ViewValue, 9);
            $this->fecha_created->ViewCustomAttributes = "";

            // boton
            $this->boton->ViewValue = $this->boton->CurrentValue;
            $this->boton->ViewCustomAttributes = "";

            // id_users
            $this->id_users->LinkCustomAttributes = "";
            $this->id_users->HrefValue = "";
            $this->id_users->TooltipValue = "";

            // file_name
            $this->file_name->LinkCustomAttributes = "";
            $this->file_name->HrefValue = "";
            $this->file_name->ExportHrefValue = $this->file_name->UploadPath . $this->file_name->Upload->DbValue;
            $this->file_name->TooltipValue = "";

            // fecha_created
            $this->fecha_created->LinkCustomAttributes = "";
            $this->fecha_created->HrefValue = "";
            $this->fecha_created->TooltipValue = "";

            // boton
            $this->boton->LinkCustomAttributes = "";
            $this->boton->HrefValue = "";
            $this->boton->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id_users
            $this->id_users->EditAttrs["class"] = "form-control";
            $this->id_users->EditCustomAttributes = "";
            if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("addopt")) { // Non system admin
                $this->id_users->CurrentValue = CurrentUserID();
                $curVal = trim(strval($this->id_users->CurrentValue));
                if ($curVal != "") {
                    $this->id_users->EditValue = $this->id_users->lookupCacheOption($curVal);
                    if ($this->id_users->EditValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                        $sqlWrk = $this->id_users->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->id_users->Lookup->renderViewRow($rswrk[0]);
                            $this->id_users->EditValue = $this->id_users->displayValue($arwrk);
                        } else {
                            $this->id_users->EditValue = $this->id_users->CurrentValue;
                        }
                    }
                } else {
                    $this->id_users->EditValue = null;
                }
                $this->id_users->ViewCustomAttributes = "";
            } else {
                $this->id_users->CurrentValue = CurrentUserID();
            }

            // file_name
            $this->file_name->EditAttrs["class"] = "form-control";
            $this->file_name->EditCustomAttributes = "";
            if (!EmptyValue($this->file_name->Upload->DbValue)) {
                $this->file_name->EditValue = $this->file_name->Upload->DbValue;
            } else {
                $this->file_name->EditValue = "";
            }
            if (!EmptyValue($this->file_name->CurrentValue)) {
                $this->file_name->Upload->FileName = $this->file_name->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->file_name);
            }

            // fecha_created
            $this->fecha_created->EditAttrs["class"] = "form-control";
            $this->fecha_created->EditCustomAttributes = "";
            $this->fecha_created->CurrentValue = FormatDateTime(CurrentDateTime(), 9);

            // boton
            $this->boton->EditAttrs["class"] = "form-control";
            $this->boton->EditCustomAttributes = "";
            $this->boton->EditValue = HtmlEncode($this->boton->CurrentValue);
            $this->boton->PlaceHolder = RemoveHtml($this->boton->caption());

            // Add refer script

            // id_users
            $this->id_users->LinkCustomAttributes = "";
            $this->id_users->HrefValue = "";

            // file_name
            $this->file_name->LinkCustomAttributes = "";
            $this->file_name->HrefValue = "";
            $this->file_name->ExportHrefValue = $this->file_name->UploadPath . $this->file_name->Upload->DbValue;

            // fecha_created
            $this->fecha_created->LinkCustomAttributes = "";
            $this->fecha_created->HrefValue = "";

            // boton
            $this->boton->LinkCustomAttributes = "";
            $this->boton->HrefValue = "";
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
        if ($this->id_users->Required) {
            if (!$this->id_users->IsDetailKey && EmptyValue($this->id_users->FormValue)) {
                $this->id_users->addErrorMessage(str_replace("%s", $this->id_users->caption(), $this->id_users->RequiredErrorMessage));
            }
        }
        if ($this->file_name->Required) {
            if ($this->file_name->Upload->FileName == "" && !$this->file_name->Upload->KeepFile) {
                $this->file_name->addErrorMessage(str_replace("%s", $this->file_name->caption(), $this->file_name->RequiredErrorMessage));
            }
        }
        if ($this->fecha_created->Required) {
            if (!$this->fecha_created->IsDetailKey && EmptyValue($this->fecha_created->FormValue)) {
                $this->fecha_created->addErrorMessage(str_replace("%s", $this->fecha_created->caption(), $this->fecha_created->RequiredErrorMessage));
            }
        }
        if ($this->boton->Required) {
            if (!$this->boton->IsDetailKey && EmptyValue($this->boton->FormValue)) {
                $this->boton->addErrorMessage(str_replace("%s", $this->boton->caption(), $this->boton->RequiredErrorMessage));
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ArchivosDocList"), "", $this->TableVar, true);
        $pageId = "addopt";
        $Breadcrumb->add("addopt", $pageId, $url);
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
                case "x_id_users":
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
