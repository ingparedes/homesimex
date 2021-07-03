<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for arrowchat_reports
 */
class ArrowchatReports extends DbTable
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
    public $report_from;
    public $report_about;
    public $report_chatroom;
    public $report_time;
    public $working_by;
    public $working_time;
    public $completed_by;
    public $completed_time;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'arrowchat_reports';
        $this->TableName = 'arrowchat_reports';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`arrowchat_reports`";
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
        $this->id = new DbField('arrowchat_reports', 'arrowchat_reports', 'x_id', 'id', '`id`', '`id`', 19, 25, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // report_from
        $this->report_from = new DbField('arrowchat_reports', 'arrowchat_reports', 'x_report_from', 'report_from', '`report_from`', '`report_from`', 200, 25, -1, false, '`report_from`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->report_from->Nullable = false; // NOT NULL field
        $this->report_from->Required = true; // Required field
        $this->report_from->Sortable = true; // Allow sort
        $this->report_from->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->report_from->Param, "CustomMsg");
        $this->Fields['report_from'] = &$this->report_from;

        // report_about
        $this->report_about = new DbField('arrowchat_reports', 'arrowchat_reports', 'x_report_about', 'report_about', '`report_about`', '`report_about`', 200, 25, -1, false, '`report_about`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->report_about->Nullable = false; // NOT NULL field
        $this->report_about->Required = true; // Required field
        $this->report_about->Sortable = true; // Allow sort
        $this->report_about->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->report_about->Param, "CustomMsg");
        $this->Fields['report_about'] = &$this->report_about;

        // report_chatroom
        $this->report_chatroom = new DbField('arrowchat_reports', 'arrowchat_reports', 'x_report_chatroom', 'report_chatroom', '`report_chatroom`', '`report_chatroom`', 19, 10, -1, false, '`report_chatroom`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->report_chatroom->Nullable = false; // NOT NULL field
        $this->report_chatroom->Required = true; // Required field
        $this->report_chatroom->Sortable = true; // Allow sort
        $this->report_chatroom->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->report_chatroom->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->report_chatroom->Param, "CustomMsg");
        $this->Fields['report_chatroom'] = &$this->report_chatroom;

        // report_time
        $this->report_time = new DbField('arrowchat_reports', 'arrowchat_reports', 'x_report_time', 'report_time', '`report_time`', '`report_time`', 19, 20, -1, false, '`report_time`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->report_time->Nullable = false; // NOT NULL field
        $this->report_time->Required = true; // Required field
        $this->report_time->Sortable = true; // Allow sort
        $this->report_time->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->report_time->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->report_time->Param, "CustomMsg");
        $this->Fields['report_time'] = &$this->report_time;

        // working_by
        $this->working_by = new DbField('arrowchat_reports', 'arrowchat_reports', 'x_working_by', 'working_by', '`working_by`', '`working_by`', 200, 25, -1, false, '`working_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->working_by->Nullable = false; // NOT NULL field
        $this->working_by->Required = true; // Required field
        $this->working_by->Sortable = true; // Allow sort
        $this->working_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->working_by->Param, "CustomMsg");
        $this->Fields['working_by'] = &$this->working_by;

        // working_time
        $this->working_time = new DbField('arrowchat_reports', 'arrowchat_reports', 'x_working_time', 'working_time', '`working_time`', '`working_time`', 19, 20, -1, false, '`working_time`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->working_time->Nullable = false; // NOT NULL field
        $this->working_time->Required = true; // Required field
        $this->working_time->Sortable = true; // Allow sort
        $this->working_time->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->working_time->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->working_time->Param, "CustomMsg");
        $this->Fields['working_time'] = &$this->working_time;

        // completed_by
        $this->completed_by = new DbField('arrowchat_reports', 'arrowchat_reports', 'x_completed_by', 'completed_by', '`completed_by`', '`completed_by`', 200, 25, -1, false, '`completed_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->completed_by->Nullable = false; // NOT NULL field
        $this->completed_by->Required = true; // Required field
        $this->completed_by->Sortable = true; // Allow sort
        $this->completed_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->completed_by->Param, "CustomMsg");
        $this->Fields['completed_by'] = &$this->completed_by;

        // completed_time
        $this->completed_time = new DbField('arrowchat_reports', 'arrowchat_reports', 'x_completed_time', 'completed_time', '`completed_time`', '`completed_time`', 19, 20, -1, false, '`completed_time`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->completed_time->Nullable = false; // NOT NULL field
        $this->completed_time->Required = true; // Required field
        $this->completed_time->Sortable = true; // Allow sort
        $this->completed_time->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->completed_time->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->completed_time->Param, "CustomMsg");
        $this->Fields['completed_time'] = &$this->completed_time;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`arrowchat_reports`";
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
        $this->report_from->DbValue = $row['report_from'];
        $this->report_about->DbValue = $row['report_about'];
        $this->report_chatroom->DbValue = $row['report_chatroom'];
        $this->report_time->DbValue = $row['report_time'];
        $this->working_by->DbValue = $row['working_by'];
        $this->working_time->DbValue = $row['working_time'];
        $this->completed_by->DbValue = $row['completed_by'];
        $this->completed_time->DbValue = $row['completed_time'];
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
        return $_SESSION[$name] ?? GetUrl("ArrowchatReportsList");
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
        if ($pageName == "ArrowchatReportsView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ArrowchatReportsEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ArrowchatReportsAdd") {
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
                return "ArrowchatReportsView";
            case Config("API_ADD_ACTION"):
                return "ArrowchatReportsAdd";
            case Config("API_EDIT_ACTION"):
                return "ArrowchatReportsEdit";
            case Config("API_DELETE_ACTION"):
                return "ArrowchatReportsDelete";
            case Config("API_LIST_ACTION"):
                return "ArrowchatReportsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ArrowchatReportsList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ArrowchatReportsView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ArrowchatReportsView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ArrowchatReportsAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ArrowchatReportsAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ArrowchatReportsEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("ArrowchatReportsAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("ArrowchatReportsDelete", $this->getUrlParm());
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
        $this->report_from->setDbValue($row['report_from']);
        $this->report_about->setDbValue($row['report_about']);
        $this->report_chatroom->setDbValue($row['report_chatroom']);
        $this->report_time->setDbValue($row['report_time']);
        $this->working_by->setDbValue($row['working_by']);
        $this->working_time->setDbValue($row['working_time']);
        $this->completed_by->setDbValue($row['completed_by']);
        $this->completed_time->setDbValue($row['completed_time']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // report_from

        // report_about

        // report_chatroom

        // report_time

        // working_by

        // working_time

        // completed_by

        // completed_time

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // report_from
        $this->report_from->ViewValue = $this->report_from->CurrentValue;
        $this->report_from->ViewCustomAttributes = "";

        // report_about
        $this->report_about->ViewValue = $this->report_about->CurrentValue;
        $this->report_about->ViewCustomAttributes = "";

        // report_chatroom
        $this->report_chatroom->ViewValue = $this->report_chatroom->CurrentValue;
        $this->report_chatroom->ViewValue = FormatNumber($this->report_chatroom->ViewValue, 0, -2, -2, -2);
        $this->report_chatroom->ViewCustomAttributes = "";

        // report_time
        $this->report_time->ViewValue = $this->report_time->CurrentValue;
        $this->report_time->ViewValue = FormatNumber($this->report_time->ViewValue, 0, -2, -2, -2);
        $this->report_time->ViewCustomAttributes = "";

        // working_by
        $this->working_by->ViewValue = $this->working_by->CurrentValue;
        $this->working_by->ViewCustomAttributes = "";

        // working_time
        $this->working_time->ViewValue = $this->working_time->CurrentValue;
        $this->working_time->ViewValue = FormatNumber($this->working_time->ViewValue, 0, -2, -2, -2);
        $this->working_time->ViewCustomAttributes = "";

        // completed_by
        $this->completed_by->ViewValue = $this->completed_by->CurrentValue;
        $this->completed_by->ViewCustomAttributes = "";

        // completed_time
        $this->completed_time->ViewValue = $this->completed_time->CurrentValue;
        $this->completed_time->ViewValue = FormatNumber($this->completed_time->ViewValue, 0, -2, -2, -2);
        $this->completed_time->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // report_from
        $this->report_from->LinkCustomAttributes = "";
        $this->report_from->HrefValue = "";
        $this->report_from->TooltipValue = "";

        // report_about
        $this->report_about->LinkCustomAttributes = "";
        $this->report_about->HrefValue = "";
        $this->report_about->TooltipValue = "";

        // report_chatroom
        $this->report_chatroom->LinkCustomAttributes = "";
        $this->report_chatroom->HrefValue = "";
        $this->report_chatroom->TooltipValue = "";

        // report_time
        $this->report_time->LinkCustomAttributes = "";
        $this->report_time->HrefValue = "";
        $this->report_time->TooltipValue = "";

        // working_by
        $this->working_by->LinkCustomAttributes = "";
        $this->working_by->HrefValue = "";
        $this->working_by->TooltipValue = "";

        // working_time
        $this->working_time->LinkCustomAttributes = "";
        $this->working_time->HrefValue = "";
        $this->working_time->TooltipValue = "";

        // completed_by
        $this->completed_by->LinkCustomAttributes = "";
        $this->completed_by->HrefValue = "";
        $this->completed_by->TooltipValue = "";

        // completed_time
        $this->completed_time->LinkCustomAttributes = "";
        $this->completed_time->HrefValue = "";
        $this->completed_time->TooltipValue = "";

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

        // report_from
        $this->report_from->EditAttrs["class"] = "form-control";
        $this->report_from->EditCustomAttributes = "";
        if (!$this->report_from->Raw) {
            $this->report_from->CurrentValue = HtmlDecode($this->report_from->CurrentValue);
        }
        $this->report_from->EditValue = $this->report_from->CurrentValue;
        $this->report_from->PlaceHolder = RemoveHtml($this->report_from->caption());

        // report_about
        $this->report_about->EditAttrs["class"] = "form-control";
        $this->report_about->EditCustomAttributes = "";
        if (!$this->report_about->Raw) {
            $this->report_about->CurrentValue = HtmlDecode($this->report_about->CurrentValue);
        }
        $this->report_about->EditValue = $this->report_about->CurrentValue;
        $this->report_about->PlaceHolder = RemoveHtml($this->report_about->caption());

        // report_chatroom
        $this->report_chatroom->EditAttrs["class"] = "form-control";
        $this->report_chatroom->EditCustomAttributes = "";
        $this->report_chatroom->EditValue = $this->report_chatroom->CurrentValue;
        $this->report_chatroom->PlaceHolder = RemoveHtml($this->report_chatroom->caption());

        // report_time
        $this->report_time->EditAttrs["class"] = "form-control";
        $this->report_time->EditCustomAttributes = "";
        $this->report_time->EditValue = $this->report_time->CurrentValue;
        $this->report_time->PlaceHolder = RemoveHtml($this->report_time->caption());

        // working_by
        $this->working_by->EditAttrs["class"] = "form-control";
        $this->working_by->EditCustomAttributes = "";
        if (!$this->working_by->Raw) {
            $this->working_by->CurrentValue = HtmlDecode($this->working_by->CurrentValue);
        }
        $this->working_by->EditValue = $this->working_by->CurrentValue;
        $this->working_by->PlaceHolder = RemoveHtml($this->working_by->caption());

        // working_time
        $this->working_time->EditAttrs["class"] = "form-control";
        $this->working_time->EditCustomAttributes = "";
        $this->working_time->EditValue = $this->working_time->CurrentValue;
        $this->working_time->PlaceHolder = RemoveHtml($this->working_time->caption());

        // completed_by
        $this->completed_by->EditAttrs["class"] = "form-control";
        $this->completed_by->EditCustomAttributes = "";
        if (!$this->completed_by->Raw) {
            $this->completed_by->CurrentValue = HtmlDecode($this->completed_by->CurrentValue);
        }
        $this->completed_by->EditValue = $this->completed_by->CurrentValue;
        $this->completed_by->PlaceHolder = RemoveHtml($this->completed_by->caption());

        // completed_time
        $this->completed_time->EditAttrs["class"] = "form-control";
        $this->completed_time->EditCustomAttributes = "";
        $this->completed_time->EditValue = $this->completed_time->CurrentValue;
        $this->completed_time->PlaceHolder = RemoveHtml($this->completed_time->caption());

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
                    $doc->exportCaption($this->report_from);
                    $doc->exportCaption($this->report_about);
                    $doc->exportCaption($this->report_chatroom);
                    $doc->exportCaption($this->report_time);
                    $doc->exportCaption($this->working_by);
                    $doc->exportCaption($this->working_time);
                    $doc->exportCaption($this->completed_by);
                    $doc->exportCaption($this->completed_time);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->report_from);
                    $doc->exportCaption($this->report_about);
                    $doc->exportCaption($this->report_chatroom);
                    $doc->exportCaption($this->report_time);
                    $doc->exportCaption($this->working_by);
                    $doc->exportCaption($this->working_time);
                    $doc->exportCaption($this->completed_by);
                    $doc->exportCaption($this->completed_time);
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
                        $doc->exportField($this->report_from);
                        $doc->exportField($this->report_about);
                        $doc->exportField($this->report_chatroom);
                        $doc->exportField($this->report_time);
                        $doc->exportField($this->working_by);
                        $doc->exportField($this->working_time);
                        $doc->exportField($this->completed_by);
                        $doc->exportField($this->completed_time);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->report_from);
                        $doc->exportField($this->report_about);
                        $doc->exportField($this->report_chatroom);
                        $doc->exportField($this->report_time);
                        $doc->exportField($this->working_by);
                        $doc->exportField($this->working_time);
                        $doc->exportField($this->completed_by);
                        $doc->exportField($this->completed_time);
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
