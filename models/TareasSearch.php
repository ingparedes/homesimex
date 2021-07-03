<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class TareasSearch extends Tareas
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'tareas';

    // Page object name
    public $PageObjName = "TareasSearch";

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

        // Table object (tareas)
        if (!isset($GLOBALS["tareas"]) || get_class($GLOBALS["tareas"]) == PROJECT_NAMESPACE . "tareas") {
            $GLOBALS["tareas"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'tareas');
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
                $doc = new $class(Container("tareas"));
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
                    if ($pageName == "TareasView") {
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
            $key .= @$ar['id_tarea'];
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
            $this->id_tarea->Visible = false;
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
    public $FormClassName = "ew-horizontal ew-form ew-search-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

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
        $this->id_tarea->setVisibility();
        $this->id_escenario->setVisibility();
        $this->id_grupo->setVisibility();
        $this->titulo_tarea->setVisibility();
        $this->descripcion_tarea->setVisibility();
        $this->fechainireal_tarea->setVisibility();
        $this->fechafin_tarea->setVisibility();
        $this->fechainisimulado_tarea->setVisibility();
        $this->fechafinsimulado_tarea->setVisibility();
        $this->id_tarearelacion->setVisibility();
        $this->archivo->setVisibility();
        $this->id_subgrupo->setVisibility();
        $this->valoracion->setVisibility();
        $this->color->setVisibility();
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
        $this->setupLookupOptions($this->id_grupo);
        $this->setupLookupOptions($this->id_tarearelacion);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        if ($this->isPageRequest()) {
            // Get action
            $this->CurrentAction = Post("action");
            if ($this->isSearch()) {
                // Build search string for advanced search, remove blank field
                $this->loadSearchValues(); // Get search values
                if ($this->validateSearch()) {
                    $srchStr = $this->buildAdvancedSearch();
                } else {
                    $srchStr = "";
                }
                if ($srchStr != "") {
                    $srchStr = $this->getUrlParm($srchStr);
                    $srchStr = "TareasList" . "?" . $srchStr;
                    $this->terminate($srchStr); // Go to list page
                    return;
                }
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Render row for search
        $this->RowType = ROWTYPE_SEARCH;
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

    // Build advanced search
    protected function buildAdvancedSearch()
    {
        $srchUrl = "";
        $this->buildSearchUrl($srchUrl, $this->id_tarea); // id_tarea
        $this->buildSearchUrl($srchUrl, $this->id_escenario); // id_escenario
        $this->buildSearchUrl($srchUrl, $this->id_grupo); // id_grupo
        $this->buildSearchUrl($srchUrl, $this->titulo_tarea); // titulo_tarea
        $this->buildSearchUrl($srchUrl, $this->descripcion_tarea); // descripcion_tarea
        $this->buildSearchUrl($srchUrl, $this->fechainireal_tarea); // fechainireal_tarea
        $this->buildSearchUrl($srchUrl, $this->fechafin_tarea); // fechafin_tarea
        $this->buildSearchUrl($srchUrl, $this->fechainisimulado_tarea); // fechainisimulado_tarea
        $this->buildSearchUrl($srchUrl, $this->fechafinsimulado_tarea); // fechafinsimulado_tarea
        $this->buildSearchUrl($srchUrl, $this->id_tarearelacion); // id_tarearelacion
        $this->buildSearchUrl($srchUrl, $this->archivo); // archivo
        $this->buildSearchUrl($srchUrl, $this->id_subgrupo); // id_subgrupo
        $this->buildSearchUrl($srchUrl, $this->valoracion); // valoracion
        $this->buildSearchUrl($srchUrl, $this->color); // color
        if ($srchUrl != "") {
            $srchUrl .= "&";
        }
        $srchUrl .= "cmd=search";
        return $srchUrl;
    }

    // Build search URL
    protected function buildSearchUrl(&$url, &$fld, $oprOnly = false)
    {
        global $CurrentForm;
        $wrk = "";
        $fldParm = $fld->Param;
        $fldVal = $CurrentForm->getValue("x_$fldParm");
        $fldOpr = $CurrentForm->getValue("z_$fldParm");
        $fldCond = $CurrentForm->getValue("v_$fldParm");
        $fldVal2 = $CurrentForm->getValue("y_$fldParm");
        $fldOpr2 = $CurrentForm->getValue("w_$fldParm");
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        $fldDataType = ($fld->IsVirtual) ? DATATYPE_STRING : $fld->DataType;
        if ($fldOpr == "BETWEEN") {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal) && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal != "" && $fldVal2 != "" && $isValidValue) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            }
        } else {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal));
            if ($fldVal != "" && $isValidValue && IsValidOperator($fldOpr, $fldDataType)) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            } elseif ($fldOpr == "IS NULL" || $fldOpr == "IS NOT NULL" || ($fldOpr != "" && $oprOnly && IsValidOperator($fldOpr, $fldDataType))) {
                $wrk = "z_" . $fldParm . "=" . urlencode($fldOpr);
            }
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal2 != "" && $isValidValue && IsValidOperator($fldOpr2, $fldDataType)) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&w_" . $fldParm . "=" . urlencode($fldOpr2);
            } elseif ($fldOpr2 == "IS NULL" || $fldOpr2 == "IS NOT NULL" || ($fldOpr2 != "" && $oprOnly && IsValidOperator($fldOpr2, $fldDataType))) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "w_" . $fldParm . "=" . urlencode($fldOpr2);
            }
        }
        if ($wrk != "") {
            if ($url != "") {
                $url .= "&";
            }
            $url .= $wrk;
        }
    }

    // Check if search value is numeric
    protected function searchValueIsNumeric($fld, $value)
    {
        if (IsFloatFormat($fld->Type)) {
            $value = ConvertToFloatString($value);
        }
        return is_numeric($value);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;
        if ($this->id_tarea->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->id_escenario->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->id_grupo->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->titulo_tarea->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->descripcion_tarea->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->fechainireal_tarea->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->fechafin_tarea->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->fechainisimulado_tarea->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->fechafinsimulado_tarea->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->id_tarearelacion->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->archivo->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->id_subgrupo->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->valoracion->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->color->AdvancedSearch->post()) {
            $hasValue = true;
        }
        return $hasValue;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id_tarea

        // id_escenario

        // id_grupo

        // titulo_tarea

        // descripcion_tarea

        // fechainireal_tarea

        // fechafin_tarea

        // fechainisimulado_tarea

        // fechafinsimulado_tarea

        // id_tarearelacion

        // archivo

        // id_subgrupo

        // valoracion

        // color
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_tarea
            $this->id_tarea->ViewValue = $this->id_tarea->CurrentValue;
            $this->id_tarea->ViewCustomAttributes = "";

            // id_escenario
            $this->id_escenario->ViewValue = $this->id_escenario->CurrentValue;
            $this->id_escenario->ViewValue = FormatNumber($this->id_escenario->ViewValue, 0, -2, -2, -2);
            $this->id_escenario->ViewCustomAttributes = "";

            // id_grupo
            $curVal = strval($this->id_grupo->CurrentValue);
            if ($curVal != "") {
                $this->id_grupo->ViewValue = $this->id_grupo->lookupCacheOption($curVal);
                if ($this->id_grupo->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_grupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentUserInfo("perfil") != 1) ? "id_grupo = '".CurrentUserInfo("grupo")."'" : "id_escenario = '".CurrentUserInfo("escenario")."'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->id_grupo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->id_grupo->Lookup->renderViewRow($rswrk[0]);
                        $this->id_grupo->ViewValue = $this->id_grupo->displayValue($arwrk);
                    } else {
                        $this->id_grupo->ViewValue = $this->id_grupo->CurrentValue;
                    }
                }
            } else {
                $this->id_grupo->ViewValue = null;
            }
            $this->id_grupo->ViewCustomAttributes = "";

            // titulo_tarea
            $this->titulo_tarea->ViewValue = $this->titulo_tarea->CurrentValue;
            $this->titulo_tarea->ViewCustomAttributes = "";

            // descripcion_tarea
            $this->descripcion_tarea->ViewValue = $this->descripcion_tarea->CurrentValue;
            $this->descripcion_tarea->ViewCustomAttributes = "";

            // fechainireal_tarea
            $this->fechainireal_tarea->ViewValue = $this->fechainireal_tarea->CurrentValue;
            $this->fechainireal_tarea->ViewValue = FormatDateTime($this->fechainireal_tarea->ViewValue, 109);
            $this->fechainireal_tarea->ViewCustomAttributes = "";

            // fechafin_tarea
            $this->fechafin_tarea->ViewValue = $this->fechafin_tarea->CurrentValue;
            $this->fechafin_tarea->ViewValue = FormatDateTime($this->fechafin_tarea->ViewValue, 109);
            $this->fechafin_tarea->ViewCustomAttributes = "";

            // fechainisimulado_tarea
            $this->fechainisimulado_tarea->ViewValue = $this->fechainisimulado_tarea->CurrentValue;
            $this->fechainisimulado_tarea->ViewValue = FormatDateTime($this->fechainisimulado_tarea->ViewValue, 109);
            $this->fechainisimulado_tarea->ViewCustomAttributes = "";

            // fechafinsimulado_tarea
            $this->fechafinsimulado_tarea->ViewValue = $this->fechafinsimulado_tarea->CurrentValue;
            $this->fechafinsimulado_tarea->ViewValue = FormatDateTime($this->fechafinsimulado_tarea->ViewValue, 109);
            $this->fechafinsimulado_tarea->ViewCustomAttributes = "";

            // id_tarearelacion
            $curVal = strval($this->id_tarearelacion->CurrentValue);
            if ($curVal != "") {
                $this->id_tarearelacion->ViewValue = $this->id_tarearelacion->lookupCacheOption($curVal);
                if ($this->id_tarearelacion->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_tarea`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentUserInfo("perfil") != 1) ? "id_grupo = '".CurrentUserInfo("grupo")."'" : "id_escenario = '".$_GET["fk_id_escenario"]."'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->id_tarearelacion->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->id_tarearelacion->Lookup->renderViewRow($rswrk[0]);
                        $this->id_tarearelacion->ViewValue = $this->id_tarearelacion->displayValue($arwrk);
                    } else {
                        $this->id_tarearelacion->ViewValue = $this->id_tarearelacion->CurrentValue;
                    }
                }
            } else {
                $this->id_tarearelacion->ViewValue = null;
            }
            $this->id_tarearelacion->ViewCustomAttributes = "";

            // archivo
            if (!EmptyValue($this->archivo->Upload->DbValue)) {
                $this->archivo->ViewValue = $this->archivo->Upload->DbValue;
            } else {
                $this->archivo->ViewValue = "";
            }
            $this->archivo->ViewCustomAttributes = "";

            // id_subgrupo
            $this->id_subgrupo->ViewValue = $this->id_subgrupo->CurrentValue;
            $this->id_subgrupo->ViewValue = FormatNumber($this->id_subgrupo->ViewValue, 0, -2, -2, -2);
            $this->id_subgrupo->ViewCustomAttributes = "";

            // valoracion
            $this->valoracion->ViewValue = $this->valoracion->CurrentValue;
            $this->valoracion->ViewValue = FormatNumber($this->valoracion->ViewValue, 0, -2, -2, -2);
            $this->valoracion->ViewCustomAttributes = "";

            // color
            $this->color->ViewCustomAttributes = "";

            // id_tarea
            $this->id_tarea->LinkCustomAttributes = "";
            $this->id_tarea->HrefValue = "";
            $this->id_tarea->TooltipValue = "";

            // id_escenario
            $this->id_escenario->LinkCustomAttributes = "";
            $this->id_escenario->HrefValue = "";
            $this->id_escenario->TooltipValue = "";

            // id_grupo
            $this->id_grupo->LinkCustomAttributes = "";
            $this->id_grupo->HrefValue = "";
            $this->id_grupo->TooltipValue = "";

            // titulo_tarea
            $this->titulo_tarea->LinkCustomAttributes = "";
            $this->titulo_tarea->HrefValue = "";
            $this->titulo_tarea->TooltipValue = "";

            // descripcion_tarea
            $this->descripcion_tarea->LinkCustomAttributes = "";
            $this->descripcion_tarea->HrefValue = "";
            $this->descripcion_tarea->TooltipValue = "";

            // fechainireal_tarea
            $this->fechainireal_tarea->LinkCustomAttributes = "";
            $this->fechainireal_tarea->HrefValue = "";
            $this->fechainireal_tarea->TooltipValue = "";

            // fechafin_tarea
            $this->fechafin_tarea->LinkCustomAttributes = "";
            $this->fechafin_tarea->HrefValue = "";
            $this->fechafin_tarea->TooltipValue = "";

            // fechainisimulado_tarea
            $this->fechainisimulado_tarea->LinkCustomAttributes = "";
            $this->fechainisimulado_tarea->HrefValue = "";
            $this->fechainisimulado_tarea->TooltipValue = "";

            // fechafinsimulado_tarea
            $this->fechafinsimulado_tarea->LinkCustomAttributes = "";
            $this->fechafinsimulado_tarea->HrefValue = "";
            $this->fechafinsimulado_tarea->TooltipValue = "";

            // id_tarearelacion
            $this->id_tarearelacion->LinkCustomAttributes = "";
            $this->id_tarearelacion->HrefValue = "";
            $this->id_tarearelacion->TooltipValue = "";

            // archivo
            $this->archivo->LinkCustomAttributes = "";
            $this->archivo->HrefValue = "";
            $this->archivo->ExportHrefValue = $this->archivo->UploadPath . $this->archivo->Upload->DbValue;
            $this->archivo->TooltipValue = "";

            // id_subgrupo
            $this->id_subgrupo->LinkCustomAttributes = "";
            $this->id_subgrupo->HrefValue = "";
            $this->id_subgrupo->TooltipValue = "";

            // valoracion
            $this->valoracion->LinkCustomAttributes = "";
            $this->valoracion->HrefValue = "";
            $this->valoracion->TooltipValue = "";

            // color
            $this->color->LinkCustomAttributes = "";
            $this->color->HrefValue = "";
            $this->color->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // id_tarea
            $this->id_tarea->EditAttrs["class"] = "form-control";
            $this->id_tarea->EditCustomAttributes = "";
            $this->id_tarea->EditValue = HtmlEncode($this->id_tarea->AdvancedSearch->SearchValue);
            $this->id_tarea->PlaceHolder = RemoveHtml($this->id_tarea->caption());

            // id_escenario
            $this->id_escenario->EditAttrs["class"] = "form-control";
            $this->id_escenario->EditCustomAttributes = "";
            $this->id_escenario->EditValue = HtmlEncode($this->id_escenario->AdvancedSearch->SearchValue);
            $this->id_escenario->PlaceHolder = RemoveHtml($this->id_escenario->caption());

            // id_grupo
            $this->id_grupo->EditCustomAttributes = "";
            $curVal = trim(strval($this->id_grupo->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->id_grupo->AdvancedSearch->ViewValue = $this->id_grupo->lookupCacheOption($curVal);
            } else {
                $this->id_grupo->AdvancedSearch->ViewValue = $this->id_grupo->Lookup !== null && is_array($this->id_grupo->Lookup->Options) ? $curVal : null;
            }
            if ($this->id_grupo->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->id_grupo->EditValue = array_values($this->id_grupo->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_grupo`" . SearchString("=", $this->id_grupo->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return (CurrentUserInfo("perfil") != 1) ? "id_grupo = '".CurrentUserInfo("grupo")."'" : "id_escenario = '".CurrentUserInfo("escenario")."'";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->id_grupo->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->id_grupo->EditValue = $arwrk;
            }
            $this->id_grupo->PlaceHolder = RemoveHtml($this->id_grupo->caption());

            // titulo_tarea
            $this->titulo_tarea->EditAttrs["class"] = "form-control";
            $this->titulo_tarea->EditCustomAttributes = "";
            if (!$this->titulo_tarea->Raw) {
                $this->titulo_tarea->AdvancedSearch->SearchValue = HtmlDecode($this->titulo_tarea->AdvancedSearch->SearchValue);
            }
            $this->titulo_tarea->EditValue = HtmlEncode($this->titulo_tarea->AdvancedSearch->SearchValue);
            $this->titulo_tarea->PlaceHolder = RemoveHtml($this->titulo_tarea->caption());

            // descripcion_tarea
            $this->descripcion_tarea->EditAttrs["class"] = "form-control";
            $this->descripcion_tarea->EditCustomAttributes = "";
            $this->descripcion_tarea->EditValue = HtmlEncode($this->descripcion_tarea->AdvancedSearch->SearchValue);
            $this->descripcion_tarea->PlaceHolder = RemoveHtml($this->descripcion_tarea->caption());

            // fechainireal_tarea
            $this->fechainireal_tarea->EditAttrs["class"] = "form-control";
            $this->fechainireal_tarea->EditCustomAttributes = "";
            $this->fechainireal_tarea->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fechainireal_tarea->AdvancedSearch->SearchValue, 109), 109));
            $this->fechainireal_tarea->PlaceHolder = RemoveHtml($this->fechainireal_tarea->caption());

            // fechafin_tarea
            $this->fechafin_tarea->EditAttrs["class"] = "form-control";
            $this->fechafin_tarea->EditCustomAttributes = "";
            $this->fechafin_tarea->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fechafin_tarea->AdvancedSearch->SearchValue, 109), 109));
            $this->fechafin_tarea->PlaceHolder = RemoveHtml($this->fechafin_tarea->caption());

            // fechainisimulado_tarea
            $this->fechainisimulado_tarea->EditAttrs["class"] = "form-control";
            $this->fechainisimulado_tarea->EditCustomAttributes = "";
            $this->fechainisimulado_tarea->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fechainisimulado_tarea->AdvancedSearch->SearchValue, 109), 109));
            $this->fechainisimulado_tarea->PlaceHolder = RemoveHtml($this->fechainisimulado_tarea->caption());

            // fechafinsimulado_tarea
            $this->fechafinsimulado_tarea->EditAttrs["class"] = "form-control";
            $this->fechafinsimulado_tarea->EditCustomAttributes = "";
            $this->fechafinsimulado_tarea->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fechafinsimulado_tarea->AdvancedSearch->SearchValue, 109), 109));
            $this->fechafinsimulado_tarea->PlaceHolder = RemoveHtml($this->fechafinsimulado_tarea->caption());

            // id_tarearelacion
            $this->id_tarearelacion->EditCustomAttributes = "";
            $curVal = trim(strval($this->id_tarearelacion->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->id_tarearelacion->AdvancedSearch->ViewValue = $this->id_tarearelacion->lookupCacheOption($curVal);
            } else {
                $this->id_tarearelacion->AdvancedSearch->ViewValue = $this->id_tarearelacion->Lookup !== null && is_array($this->id_tarearelacion->Lookup->Options) ? $curVal : null;
            }
            if ($this->id_tarearelacion->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->id_tarearelacion->EditValue = array_values($this->id_tarearelacion->Lookup->Options);
                if ($this->id_tarearelacion->AdvancedSearch->ViewValue == "") {
                    $this->id_tarearelacion->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_tarea`" . SearchString("=", $this->id_tarearelacion->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return (CurrentUserInfo("perfil") != 1) ? "id_grupo = '".CurrentUserInfo("grupo")."'" : "id_escenario = '".$_GET["fk_id_escenario"]."'";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->id_tarearelacion->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->id_tarearelacion->Lookup->renderViewRow($rswrk[0]);
                    $this->id_tarearelacion->AdvancedSearch->ViewValue = $this->id_tarearelacion->displayValue($arwrk);
                } else {
                    $this->id_tarearelacion->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->id_tarearelacion->Lookup->renderViewRow($row);
                $this->id_tarearelacion->EditValue = $arwrk;
            }
            $this->id_tarearelacion->PlaceHolder = RemoveHtml($this->id_tarearelacion->caption());

            // archivo
            $this->archivo->EditAttrs["class"] = "form-control";
            $this->archivo->EditCustomAttributes = "";
            if (!$this->archivo->Raw) {
                $this->archivo->AdvancedSearch->SearchValue = HtmlDecode($this->archivo->AdvancedSearch->SearchValue);
            }
            $this->archivo->EditValue = HtmlEncode($this->archivo->AdvancedSearch->SearchValue);
            $this->archivo->PlaceHolder = RemoveHtml($this->archivo->caption());

            // id_subgrupo
            $this->id_subgrupo->EditAttrs["class"] = "form-control";
            $this->id_subgrupo->EditCustomAttributes = "";
            $this->id_subgrupo->EditValue = HtmlEncode($this->id_subgrupo->AdvancedSearch->SearchValue);
            $this->id_subgrupo->PlaceHolder = RemoveHtml($this->id_subgrupo->caption());

            // valoracion
            $this->valoracion->EditAttrs["class"] = "form-control";
            $this->valoracion->EditCustomAttributes = "";
            $this->valoracion->EditValue = HtmlEncode($this->valoracion->AdvancedSearch->SearchValue);
            $this->valoracion->PlaceHolder = RemoveHtml($this->valoracion->caption());

            // color
            $this->color->EditAttrs["class"] = "form-control";
            $this->color->EditCustomAttributes = "";
            $this->color->PlaceHolder = RemoveHtml($this->color->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckInteger($this->id_tarea->AdvancedSearch->SearchValue)) {
            $this->id_tarea->addErrorMessage($this->id_tarea->getErrorMessage(false));
        }
        if (!CheckInteger($this->id_escenario->AdvancedSearch->SearchValue)) {
            $this->id_escenario->addErrorMessage($this->id_escenario->getErrorMessage(false));
        }
        if (!CheckDate($this->fechainireal_tarea->AdvancedSearch->SearchValue)) {
            $this->fechainireal_tarea->addErrorMessage($this->fechainireal_tarea->getErrorMessage(false));
        }
        if (!CheckDate($this->fechafin_tarea->AdvancedSearch->SearchValue)) {
            $this->fechafin_tarea->addErrorMessage($this->fechafin_tarea->getErrorMessage(false));
        }
        if (!CheckDate($this->fechainisimulado_tarea->AdvancedSearch->SearchValue)) {
            $this->fechainisimulado_tarea->addErrorMessage($this->fechainisimulado_tarea->getErrorMessage(false));
        }
        if (!CheckDate($this->fechafinsimulado_tarea->AdvancedSearch->SearchValue)) {
            $this->fechafinsimulado_tarea->addErrorMessage($this->fechafinsimulado_tarea->getErrorMessage(false));
        }
        if (!CheckInteger($this->id_subgrupo->AdvancedSearch->SearchValue)) {
            $this->id_subgrupo->addErrorMessage($this->id_subgrupo->getErrorMessage(false));
        }
        if (!CheckInteger($this->valoracion->AdvancedSearch->SearchValue)) {
            $this->valoracion->addErrorMessage($this->valoracion->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->id_tarea->AdvancedSearch->load();
        $this->id_escenario->AdvancedSearch->load();
        $this->id_grupo->AdvancedSearch->load();
        $this->titulo_tarea->AdvancedSearch->load();
        $this->descripcion_tarea->AdvancedSearch->load();
        $this->fechainireal_tarea->AdvancedSearch->load();
        $this->fechafin_tarea->AdvancedSearch->load();
        $this->fechainisimulado_tarea->AdvancedSearch->load();
        $this->fechafinsimulado_tarea->AdvancedSearch->load();
        $this->id_tarearelacion->AdvancedSearch->load();
        $this->archivo->AdvancedSearch->load();
        $this->id_subgrupo->AdvancedSearch->load();
        $this->valoracion->AdvancedSearch->load();
        $this->color->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TareasList"), "", $this->TableVar, true);
        $pageId = "search";
        $Breadcrumb->add("search", $pageId, $url);
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
                case "x_id_grupo":
                    $lookupFilter = function () {
                        return (CurrentUserInfo("perfil") != 1) ? "id_grupo = '".CurrentUserInfo("grupo")."'" : "id_escenario = '".CurrentUserInfo("escenario")."'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_id_tarearelacion":
                    $lookupFilter = function () {
                        return (CurrentUserInfo("perfil") != 1) ? "id_grupo = '".CurrentUserInfo("grupo")."'" : "id_escenario = '".$_GET["fk_id_escenario"]."'";
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
