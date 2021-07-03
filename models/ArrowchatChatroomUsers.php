<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for arrowchat_chatroom_users
 */
class ArrowchatChatroomUsers extends DbTable
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
    public $user_id;
    public $chatroom_id;
    public $is_admin;
    public $is_mod;
    public $block_chats;
    public $silence_length;
    public $silence_time;
    public $session_time;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'arrowchat_chatroom_users';
        $this->TableName = 'arrowchat_chatroom_users';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`arrowchat_chatroom_users`";
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

        // user_id
        $this->user_id = new DbField('arrowchat_chatroom_users', 'arrowchat_chatroom_users', 'x_user_id', 'user_id', '`user_id`', '`user_id`', 200, 25, -1, false, '`user_id`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->user_id->IsPrimaryKey = true; // Primary key field
        $this->user_id->Nullable = false; // NOT NULL field
        $this->user_id->Required = true; // Required field
        $this->user_id->Sortable = true; // Allow sort
        $this->user_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->user_id->Param, "CustomMsg");
        $this->Fields['user_id'] = &$this->user_id;

        // chatroom_id
        $this->chatroom_id = new DbField('arrowchat_chatroom_users', 'arrowchat_chatroom_users', 'x_chatroom_id', 'chatroom_id', '`chatroom_id`', '`chatroom_id`', 19, 10, -1, false, '`chatroom_id`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->chatroom_id->IsPrimaryKey = true; // Primary key field
        $this->chatroom_id->Nullable = false; // NOT NULL field
        $this->chatroom_id->Required = true; // Required field
        $this->chatroom_id->Sortable = true; // Allow sort
        $this->chatroom_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->chatroom_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->chatroom_id->Param, "CustomMsg");
        $this->Fields['chatroom_id'] = &$this->chatroom_id;

        // is_admin
        $this->is_admin = new DbField('arrowchat_chatroom_users', 'arrowchat_chatroom_users', 'x_is_admin', 'is_admin', '`is_admin`', '`is_admin`', 17, 1, -1, false, '`is_admin`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->is_admin->Nullable = false; // NOT NULL field
        $this->is_admin->Sortable = true; // Allow sort
        $this->is_admin->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->is_admin->Lookup = new Lookup('is_admin', 'arrowchat_chatroom_users', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->is_admin->Lookup = new Lookup('is_admin', 'arrowchat_chatroom_users', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->is_admin->Lookup = new Lookup('is_admin', 'arrowchat_chatroom_users', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->is_admin->OptionCount = 2;
        $this->is_admin->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->is_admin->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->is_admin->Param, "CustomMsg");
        $this->Fields['is_admin'] = &$this->is_admin;

        // is_mod
        $this->is_mod = new DbField('arrowchat_chatroom_users', 'arrowchat_chatroom_users', 'x_is_mod', 'is_mod', '`is_mod`', '`is_mod`', 17, 1, -1, false, '`is_mod`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->is_mod->Nullable = false; // NOT NULL field
        $this->is_mod->Sortable = true; // Allow sort
        $this->is_mod->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->is_mod->Lookup = new Lookup('is_mod', 'arrowchat_chatroom_users', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->is_mod->Lookup = new Lookup('is_mod', 'arrowchat_chatroom_users', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->is_mod->Lookup = new Lookup('is_mod', 'arrowchat_chatroom_users', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->is_mod->OptionCount = 2;
        $this->is_mod->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->is_mod->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->is_mod->Param, "CustomMsg");
        $this->Fields['is_mod'] = &$this->is_mod;

        // block_chats
        $this->block_chats = new DbField('arrowchat_chatroom_users', 'arrowchat_chatroom_users', 'x_block_chats', 'block_chats', '`block_chats`', '`block_chats`', 17, 4, -1, false, '`block_chats`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->block_chats->Nullable = false; // NOT NULL field
        $this->block_chats->Sortable = true; // Allow sort
        $this->block_chats->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->block_chats->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->block_chats->Param, "CustomMsg");
        $this->Fields['block_chats'] = &$this->block_chats;

        // silence_length
        $this->silence_length = new DbField('arrowchat_chatroom_users', 'arrowchat_chatroom_users', 'x_silence_length', 'silence_length', '`silence_length`', '`silence_length`', 19, 3, -1, false, '`silence_length`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->silence_length->Sortable = true; // Allow sort
        $this->silence_length->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->silence_length->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->silence_length->Param, "CustomMsg");
        $this->Fields['silence_length'] = &$this->silence_length;

        // silence_time
        $this->silence_time = new DbField('arrowchat_chatroom_users', 'arrowchat_chatroom_users', 'x_silence_time', 'silence_time', '`silence_time`', '`silence_time`', 19, 15, -1, false, '`silence_time`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->silence_time->Sortable = true; // Allow sort
        $this->silence_time->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->silence_time->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->silence_time->Param, "CustomMsg");
        $this->Fields['silence_time'] = &$this->silence_time;

        // session_time
        $this->session_time = new DbField('arrowchat_chatroom_users', 'arrowchat_chatroom_users', 'x_session_time', 'session_time', '`session_time`', '`session_time`', 19, 15, -1, false, '`session_time`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->session_time->Nullable = false; // NOT NULL field
        $this->session_time->Required = true; // Required field
        $this->session_time->Sortable = true; // Allow sort
        $this->session_time->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->session_time->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->session_time->Param, "CustomMsg");
        $this->Fields['session_time'] = &$this->session_time;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`arrowchat_chatroom_users`";
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
            if (array_key_exists('user_id', $rs)) {
                AddFilter($where, QuotedName('user_id', $this->Dbid) . '=' . QuotedValue($rs['user_id'], $this->user_id->DataType, $this->Dbid));
            }
            if (array_key_exists('chatroom_id', $rs)) {
                AddFilter($where, QuotedName('chatroom_id', $this->Dbid) . '=' . QuotedValue($rs['chatroom_id'], $this->chatroom_id->DataType, $this->Dbid));
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
        $this->user_id->DbValue = $row['user_id'];
        $this->chatroom_id->DbValue = $row['chatroom_id'];
        $this->is_admin->DbValue = $row['is_admin'];
        $this->is_mod->DbValue = $row['is_mod'];
        $this->block_chats->DbValue = $row['block_chats'];
        $this->silence_length->DbValue = $row['silence_length'];
        $this->silence_time->DbValue = $row['silence_time'];
        $this->session_time->DbValue = $row['session_time'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`user_id` = '@user_id@' AND `chatroom_id` = @chatroom_id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->user_id->CurrentValue : $this->user_id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->chatroom_id->CurrentValue : $this->chatroom_id->OldValue;
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
        if (count($keys) == 2) {
            if ($current) {
                $this->user_id->CurrentValue = $keys[0];
            } else {
                $this->user_id->OldValue = $keys[0];
            }
            if ($current) {
                $this->chatroom_id->CurrentValue = $keys[1];
            } else {
                $this->chatroom_id->OldValue = $keys[1];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('user_id', $row) ? $row['user_id'] : null;
        } else {
            $val = $this->user_id->OldValue !== null ? $this->user_id->OldValue : $this->user_id->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@user_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('chatroom_id', $row) ? $row['chatroom_id'] : null;
        } else {
            $val = $this->chatroom_id->OldValue !== null ? $this->chatroom_id->OldValue : $this->chatroom_id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@chatroom_id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ArrowchatChatroomUsersList");
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
        if ($pageName == "ArrowchatChatroomUsersView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ArrowchatChatroomUsersEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ArrowchatChatroomUsersAdd") {
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
                return "ArrowchatChatroomUsersView";
            case Config("API_ADD_ACTION"):
                return "ArrowchatChatroomUsersAdd";
            case Config("API_EDIT_ACTION"):
                return "ArrowchatChatroomUsersEdit";
            case Config("API_DELETE_ACTION"):
                return "ArrowchatChatroomUsersDelete";
            case Config("API_LIST_ACTION"):
                return "ArrowchatChatroomUsersList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ArrowchatChatroomUsersList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ArrowchatChatroomUsersView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ArrowchatChatroomUsersView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ArrowchatChatroomUsersAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ArrowchatChatroomUsersAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ArrowchatChatroomUsersEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("ArrowchatChatroomUsersAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("ArrowchatChatroomUsersDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "user_id:" . JsonEncode($this->user_id->CurrentValue, "string");
        $json .= ",chatroom_id:" . JsonEncode($this->chatroom_id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->user_id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->user_id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->chatroom_id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->chatroom_id->CurrentValue);
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
            for ($i = 0; $i < $cnt; $i++) {
                $arKeys[$i] = explode(Config("COMPOSITE_KEY_SEPARATOR"), $arKeys[$i]);
            }
        } else {
            if (($keyValue = Param("user_id") ?? Route("user_id")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("chatroom_id") ?? Route("chatroom_id")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(1) ?? Route(3)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (is_array($arKeys)) {
                $arKeys[] = $arKey;
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_array($key) || count($key) != 2) {
                    continue; // Just skip so other keys will still work
                }
                if (!is_numeric($key[1])) { // chatroom_id
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
                $this->user_id->CurrentValue = $key[0];
            } else {
                $this->user_id->OldValue = $key[0];
            }
            if ($setCurrent) {
                $this->chatroom_id->CurrentValue = $key[1];
            } else {
                $this->chatroom_id->OldValue = $key[1];
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
        $this->user_id->setDbValue($row['user_id']);
        $this->chatroom_id->setDbValue($row['chatroom_id']);
        $this->is_admin->setDbValue($row['is_admin']);
        $this->is_mod->setDbValue($row['is_mod']);
        $this->block_chats->setDbValue($row['block_chats']);
        $this->silence_length->setDbValue($row['silence_length']);
        $this->silence_time->setDbValue($row['silence_time']);
        $this->session_time->setDbValue($row['session_time']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // user_id

        // chatroom_id

        // is_admin

        // is_mod

        // block_chats

        // silence_length

        // silence_time

        // session_time

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

        // user_id
        $this->user_id->EditAttrs["class"] = "form-control";
        $this->user_id->EditCustomAttributes = "";
        if (!$this->user_id->Raw) {
            $this->user_id->CurrentValue = HtmlDecode($this->user_id->CurrentValue);
        }
        $this->user_id->EditValue = $this->user_id->CurrentValue;
        $this->user_id->PlaceHolder = RemoveHtml($this->user_id->caption());

        // chatroom_id
        $this->chatroom_id->EditAttrs["class"] = "form-control";
        $this->chatroom_id->EditCustomAttributes = "";
        $this->chatroom_id->EditValue = $this->chatroom_id->CurrentValue;
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
        $this->block_chats->EditValue = $this->block_chats->CurrentValue;
        $this->block_chats->PlaceHolder = RemoveHtml($this->block_chats->caption());

        // silence_length
        $this->silence_length->EditAttrs["class"] = "form-control";
        $this->silence_length->EditCustomAttributes = "";
        $this->silence_length->EditValue = $this->silence_length->CurrentValue;
        $this->silence_length->PlaceHolder = RemoveHtml($this->silence_length->caption());

        // silence_time
        $this->silence_time->EditAttrs["class"] = "form-control";
        $this->silence_time->EditCustomAttributes = "";
        $this->silence_time->EditValue = $this->silence_time->CurrentValue;
        $this->silence_time->PlaceHolder = RemoveHtml($this->silence_time->caption());

        // session_time
        $this->session_time->EditAttrs["class"] = "form-control";
        $this->session_time->EditCustomAttributes = "";
        $this->session_time->EditValue = $this->session_time->CurrentValue;
        $this->session_time->PlaceHolder = RemoveHtml($this->session_time->caption());

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
                    $doc->exportCaption($this->user_id);
                    $doc->exportCaption($this->chatroom_id);
                    $doc->exportCaption($this->is_admin);
                    $doc->exportCaption($this->is_mod);
                    $doc->exportCaption($this->block_chats);
                    $doc->exportCaption($this->silence_length);
                    $doc->exportCaption($this->silence_time);
                    $doc->exportCaption($this->session_time);
                } else {
                    $doc->exportCaption($this->user_id);
                    $doc->exportCaption($this->chatroom_id);
                    $doc->exportCaption($this->is_admin);
                    $doc->exportCaption($this->is_mod);
                    $doc->exportCaption($this->block_chats);
                    $doc->exportCaption($this->silence_length);
                    $doc->exportCaption($this->silence_time);
                    $doc->exportCaption($this->session_time);
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
                        $doc->exportField($this->user_id);
                        $doc->exportField($this->chatroom_id);
                        $doc->exportField($this->is_admin);
                        $doc->exportField($this->is_mod);
                        $doc->exportField($this->block_chats);
                        $doc->exportField($this->silence_length);
                        $doc->exportField($this->silence_time);
                        $doc->exportField($this->session_time);
                    } else {
                        $doc->exportField($this->user_id);
                        $doc->exportField($this->chatroom_id);
                        $doc->exportField($this->is_admin);
                        $doc->exportField($this->is_mod);
                        $doc->exportField($this->block_chats);
                        $doc->exportField($this->silence_length);
                        $doc->exportField($this->silence_time);
                        $doc->exportField($this->session_time);
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
