<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for arrowchat_trayicons
 */
class ArrowchatTrayicons extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $id;
    public $name;
    public $icon;
    public $location;
    public $target;
    public $width;
    public $height;
    public $tray_width;
    public $tray_name;
    public $tray_location;
    public $active;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'arrowchat_trayicons';
        $this->TableName = 'arrowchat_trayicons';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`arrowchat_trayicons`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_id', 'id', '`id`', '`id`', 19, 3, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // name
        $this->name = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_name', 'name', '`name`', '`name`', 200, 100, -1, false, '`name`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->name->Nullable = false; // NOT NULL field
        $this->name->Required = true; // Required field
        $this->name->Sortable = true; // Allow sort
        $this->name->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->name->Param, "CustomMsg");
        $this->Fields['name'] = &$this->name;

        // icon
        $this->icon = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_icon', 'icon', '`icon`', '`icon`', 200, 100, -1, false, '`icon`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->icon->Nullable = false; // NOT NULL field
        $this->icon->Required = true; // Required field
        $this->icon->Sortable = true; // Allow sort
        $this->icon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->icon->Param, "CustomMsg");
        $this->Fields['icon'] = &$this->icon;

        // location
        $this->location = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_location', 'location', '`location`', '`location`', 200, 191, -1, false, '`location`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->location->Nullable = false; // NOT NULL field
        $this->location->Required = true; // Required field
        $this->location->Sortable = true; // Allow sort
        $this->location->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->location->Param, "CustomMsg");
        $this->Fields['location'] = &$this->location;

        // target
        $this->target = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_target', 'target', '`target`', '`target`', 200, 25, -1, false, '`target`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->target->Sortable = true; // Allow sort
        $this->target->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->target->Param, "CustomMsg");
        $this->Fields['target'] = &$this->target;

        // width
        $this->width = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_width', 'width', '`width`', '`width`', 19, 4, -1, false, '`width`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->width->Sortable = true; // Allow sort
        $this->width->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->width->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->width->Param, "CustomMsg");
        $this->Fields['width'] = &$this->width;

        // height
        $this->height = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_height', 'height', '`height`', '`height`', 19, 4, -1, false, '`height`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->height->Sortable = true; // Allow sort
        $this->height->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->height->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->height->Param, "CustomMsg");
        $this->Fields['height'] = &$this->height;

        // tray_width
        $this->tray_width = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_tray_width', 'tray_width', '`tray_width`', '`tray_width`', 19, 3, -1, false, '`tray_width`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tray_width->Sortable = true; // Allow sort
        $this->tray_width->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tray_width->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tray_width->Param, "CustomMsg");
        $this->Fields['tray_width'] = &$this->tray_width;

        // tray_name
        $this->tray_name = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_tray_name', 'tray_name', '`tray_name`', '`tray_name`', 200, 100, -1, false, '`tray_name`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tray_name->Sortable = true; // Allow sort
        $this->tray_name->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tray_name->Param, "CustomMsg");
        $this->Fields['tray_name'] = &$this->tray_name;

        // tray_location
        $this->tray_location = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_tray_location', 'tray_location', '`tray_location`', '`tray_location`', 19, 3, -1, false, '`tray_location`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tray_location->Nullable = false; // NOT NULL field
        $this->tray_location->Required = true; // Required field
        $this->tray_location->Sortable = true; // Allow sort
        $this->tray_location->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tray_location->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tray_location->Param, "CustomMsg");
        $this->Fields['tray_location'] = &$this->tray_location;

        // active
        $this->active = new DbField('arrowchat_trayicons', 'arrowchat_trayicons', 'x_active', 'active', '`active`', '`active`', 17, 1, -1, false, '`active`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->active->Nullable = false; // NOT NULL field
        $this->active->Sortable = true; // Allow sort
        $this->active->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->active->Lookup = new Lookup('active', 'arrowchat_trayicons', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->active->Lookup = new Lookup('active', 'arrowchat_trayicons', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->active->Lookup = new Lookup('active', 'arrowchat_trayicons', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->active->OptionCount = 2;
        $this->active->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->active->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->active->Param, "CustomMsg");
        $this->Fields['active'] = &$this->active;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`arrowchat_trayicons`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id->DbValue = $row['id'];
        $this->name->DbValue = $row['name'];
        $this->icon->DbValue = $row['icon'];
        $this->location->DbValue = $row['location'];
        $this->target->DbValue = $row['target'];
        $this->width->DbValue = $row['width'];
        $this->height->DbValue = $row['height'];
        $this->tray_width->DbValue = $row['tray_width'];
        $this->tray_name->DbValue = $row['tray_name'];
        $this->tray_location->DbValue = $row['tray_location'];
        $this->active->DbValue = $row['active'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("ArrowchatTrayiconsList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "ArrowchatTrayiconsView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ArrowchatTrayiconsEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ArrowchatTrayiconsAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "ArrowchatTrayiconsView";
            case Config("API_ADD_ACTION"):
                return "ArrowchatTrayiconsAdd";
            case Config("API_EDIT_ACTION"):
                return "ArrowchatTrayiconsEdit";
            case Config("API_DELETE_ACTION"):
                return "ArrowchatTrayiconsDelete";
            case Config("API_LIST_ACTION"):
                return "ArrowchatTrayiconsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ArrowchatTrayiconsList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ArrowchatTrayiconsView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ArrowchatTrayiconsView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ArrowchatTrayiconsAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ArrowchatTrayiconsAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ArrowchatTrayiconsEdit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ArrowchatTrayiconsAdd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("ArrowchatTrayiconsDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id:" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->name->setDbValue($row['name']);
        $this->icon->setDbValue($row['icon']);
        $this->location->setDbValue($row['location']);
        $this->target->setDbValue($row['target']);
        $this->width->setDbValue($row['width']);
        $this->height->setDbValue($row['height']);
        $this->tray_width->setDbValue($row['tray_width']);
        $this->tray_name->setDbValue($row['tray_name']);
        $this->tray_location->setDbValue($row['tray_location']);
        $this->active->setDbValue($row['active']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // name

        // icon

        // location

        // target

        // width

        // height

        // tray_width

        // tray_name

        // tray_location

        // active

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // name
        $this->name->ViewValue = $this->name->CurrentValue;
        $this->name->ViewCustomAttributes = "";

        // icon
        $this->icon->ViewValue = $this->icon->CurrentValue;
        $this->icon->ViewCustomAttributes = "";

        // location
        $this->location->ViewValue = $this->location->CurrentValue;
        $this->location->ViewCustomAttributes = "";

        // target
        $this->target->ViewValue = $this->target->CurrentValue;
        $this->target->ViewCustomAttributes = "";

        // width
        $this->width->ViewValue = $this->width->CurrentValue;
        $this->width->ViewValue = FormatNumber($this->width->ViewValue, 0, -2, -2, -2);
        $this->width->ViewCustomAttributes = "";

        // height
        $this->height->ViewValue = $this->height->CurrentValue;
        $this->height->ViewValue = FormatNumber($this->height->ViewValue, 0, -2, -2, -2);
        $this->height->ViewCustomAttributes = "";

        // tray_width
        $this->tray_width->ViewValue = $this->tray_width->CurrentValue;
        $this->tray_width->ViewValue = FormatNumber($this->tray_width->ViewValue, 0, -2, -2, -2);
        $this->tray_width->ViewCustomAttributes = "";

        // tray_name
        $this->tray_name->ViewValue = $this->tray_name->CurrentValue;
        $this->tray_name->ViewCustomAttributes = "";

        // tray_location
        $this->tray_location->ViewValue = $this->tray_location->CurrentValue;
        $this->tray_location->ViewValue = FormatNumber($this->tray_location->ViewValue, 0, -2, -2, -2);
        $this->tray_location->ViewCustomAttributes = "";

        // active
        if (ConvertToBool($this->active->CurrentValue)) {
            $this->active->ViewValue = $this->active->tagCaption(1) != "" ? $this->active->tagCaption(1) : "Yes";
        } else {
            $this->active->ViewValue = $this->active->tagCaption(2) != "" ? $this->active->tagCaption(2) : "No";
        }
        $this->active->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // name
        $this->name->LinkCustomAttributes = "";
        $this->name->HrefValue = "";
        $this->name->TooltipValue = "";

        // icon
        $this->icon->LinkCustomAttributes = "";
        $this->icon->HrefValue = "";
        $this->icon->TooltipValue = "";

        // location
        $this->location->LinkCustomAttributes = "";
        $this->location->HrefValue = "";
        $this->location->TooltipValue = "";

        // target
        $this->target->LinkCustomAttributes = "";
        $this->target->HrefValue = "";
        $this->target->TooltipValue = "";

        // width
        $this->width->LinkCustomAttributes = "";
        $this->width->HrefValue = "";
        $this->width->TooltipValue = "";

        // height
        $this->height->LinkCustomAttributes = "";
        $this->height->HrefValue = "";
        $this->height->TooltipValue = "";

        // tray_width
        $this->tray_width->LinkCustomAttributes = "";
        $this->tray_width->HrefValue = "";
        $this->tray_width->TooltipValue = "";

        // tray_name
        $this->tray_name->LinkCustomAttributes = "";
        $this->tray_name->HrefValue = "";
        $this->tray_name->TooltipValue = "";

        // tray_location
        $this->tray_location->LinkCustomAttributes = "";
        $this->tray_location->HrefValue = "";
        $this->tray_location->TooltipValue = "";

        // active
        $this->active->LinkCustomAttributes = "";
        $this->active->HrefValue = "";
        $this->active->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id
        $this->id->EditAttrs["class"] = "form-control";
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // name
        $this->name->EditAttrs["class"] = "form-control";
        $this->name->EditCustomAttributes = "";
        if (!$this->name->Raw) {
            $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
        }
        $this->name->EditValue = $this->name->CurrentValue;
        $this->name->PlaceHolder = RemoveHtml($this->name->caption());

        // icon
        $this->icon->EditAttrs["class"] = "form-control";
        $this->icon->EditCustomAttributes = "";
        if (!$this->icon->Raw) {
            $this->icon->CurrentValue = HtmlDecode($this->icon->CurrentValue);
        }
        $this->icon->EditValue = $this->icon->CurrentValue;
        $this->icon->PlaceHolder = RemoveHtml($this->icon->caption());

        // location
        $this->location->EditAttrs["class"] = "form-control";
        $this->location->EditCustomAttributes = "";
        if (!$this->location->Raw) {
            $this->location->CurrentValue = HtmlDecode($this->location->CurrentValue);
        }
        $this->location->EditValue = $this->location->CurrentValue;
        $this->location->PlaceHolder = RemoveHtml($this->location->caption());

        // target
        $this->target->EditAttrs["class"] = "form-control";
        $this->target->EditCustomAttributes = "";
        if (!$this->target->Raw) {
            $this->target->CurrentValue = HtmlDecode($this->target->CurrentValue);
        }
        $this->target->EditValue = $this->target->CurrentValue;
        $this->target->PlaceHolder = RemoveHtml($this->target->caption());

        // width
        $this->width->EditAttrs["class"] = "form-control";
        $this->width->EditCustomAttributes = "";
        $this->width->EditValue = $this->width->CurrentValue;
        $this->width->PlaceHolder = RemoveHtml($this->width->caption());

        // height
        $this->height->EditAttrs["class"] = "form-control";
        $this->height->EditCustomAttributes = "";
        $this->height->EditValue = $this->height->CurrentValue;
        $this->height->PlaceHolder = RemoveHtml($this->height->caption());

        // tray_width
        $this->tray_width->EditAttrs["class"] = "form-control";
        $this->tray_width->EditCustomAttributes = "";
        $this->tray_width->EditValue = $this->tray_width->CurrentValue;
        $this->tray_width->PlaceHolder = RemoveHtml($this->tray_width->caption());

        // tray_name
        $this->tray_name->EditAttrs["class"] = "form-control";
        $this->tray_name->EditCustomAttributes = "";
        if (!$this->tray_name->Raw) {
            $this->tray_name->CurrentValue = HtmlDecode($this->tray_name->CurrentValue);
        }
        $this->tray_name->EditValue = $this->tray_name->CurrentValue;
        $this->tray_name->PlaceHolder = RemoveHtml($this->tray_name->caption());

        // tray_location
        $this->tray_location->EditAttrs["class"] = "form-control";
        $this->tray_location->EditCustomAttributes = "";
        $this->tray_location->EditValue = $this->tray_location->CurrentValue;
        $this->tray_location->PlaceHolder = RemoveHtml($this->tray_location->caption());

        // active
        $this->active->EditCustomAttributes = "";
        $this->active->EditValue = $this->active->options(false);
        $this->active->PlaceHolder = RemoveHtml($this->active->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->icon);
                    $doc->exportCaption($this->location);
                    $doc->exportCaption($this->target);
                    $doc->exportCaption($this->width);
                    $doc->exportCaption($this->height);
                    $doc->exportCaption($this->tray_width);
                    $doc->exportCaption($this->tray_name);
                    $doc->exportCaption($this->tray_location);
                    $doc->exportCaption($this->active);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->icon);
                    $doc->exportCaption($this->location);
                    $doc->exportCaption($this->target);
                    $doc->exportCaption($this->width);
                    $doc->exportCaption($this->height);
                    $doc->exportCaption($this->tray_width);
                    $doc->exportCaption($this->tray_name);
                    $doc->exportCaption($this->tray_location);
                    $doc->exportCaption($this->active);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->id);
                        $doc->exportField($this->name);
                        $doc->exportField($this->icon);
                        $doc->exportField($this->location);
                        $doc->exportField($this->target);
                        $doc->exportField($this->width);
                        $doc->exportField($this->height);
                        $doc->exportField($this->tray_width);
                        $doc->exportField($this->tray_name);
                        $doc->exportField($this->tray_location);
                        $doc->exportField($this->active);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->name);
                        $doc->exportField($this->icon);
                        $doc->exportField($this->location);
                        $doc->exportField($this->target);
                        $doc->exportField($this->width);
                        $doc->exportField($this->height);
                        $doc->exportField($this->tray_width);
                        $doc->exportField($this->tray_name);
                        $doc->exportField($this->tray_location);
                        $doc->exportField($this->active);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
