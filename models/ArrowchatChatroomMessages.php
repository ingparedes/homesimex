<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for arrowchat_chatroom_messages
 */
class ArrowchatChatroomMessages extends DbTable
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
    public $chatroom_id;
    public $user_id;
    public $_username;
    public $message;
    public $global_message;
    public $is_mod;
    public $is_admin;
    public $sent;
    public $_action;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'arrowchat_chatroom_messages';
        $this->TableName = 'arrowchat_chatroom_messages';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`arrowchat_chatroom_messages`";
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
        $this->id = new DbField('arrowchat_chatroom_messages', 'arrowchat_chatroom_messages', 'x_id', 'id', '`id`', '`id`', 19, 10, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // chatroom_id
        $this->chatroom_id = new DbField('arrowchat_chatroom_messages', 'arrowchat_chatroom_messages', 'x_chatroom_id', 'chatroom_id', '`chatroom_id`', '`chatroom_id`', 19, 10, -1, false, '`chatroom_id`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->chatroom_id->Nullable = false; // NOT NULL field
        $this->chatroom_id->Required = true; // Required field
        $this->chatroom_id->Sortable = true; // Allow sort
        $this->chatroom_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->chatroom_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->chatroom_id->Param, "CustomMsg");
        $this->Fields['chatroom_id'] = &$this->chatroom_id;

        // user_id
        $this->user_id = new DbField('arrowchat_chatroom_messages', 'arrowchat_chatroom_messages', 'x_user_id', 'user_id', '`user_id`', '`user_id`', 200, 25, -1, false, '`user_id`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->user_id->Nullable = false; // NOT NULL field
        $this->user_id->Required = true; // Required field
        $this->user_id->Sortable = true; // Allow sort
        $this->user_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->user_id->Param, "CustomMsg");
        $this->Fields['user_id'] = &$this->user_id;

        // username
        $this->_username = new DbField('arrowchat_chatroom_messages', 'arrowchat_chatroom_messages', 'x__username', 'username', '`username`', '`username`', 200, 100, -1, false, '`username`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_username->Nullable = false; // NOT NULL field
        $this->_username->Required = true; // Required field
        $this->_username->Sortable = true; // Allow sort
        $this->_username->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_username->Param, "CustomMsg");
        $this->Fields['username'] = &$this->_username;

        // message
        $this->message = new DbField('arrowchat_chatroom_messages', 'arrowchat_chatroom_messages', 'x_message', 'message', '`message`', '`message`', 201, 65535, -1, false, '`message`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->message->Nullable = false; // NOT NULL field
        $this->message->Required = true; // Required field
        $this->message->Sortable = true; // Allow sort
        $this->message->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->message->Param, "CustomMsg");
        $this->Fields['message'] = &$this->message;

        // global_message
        $this->global_message = new DbField('arrowchat_chatroom_messages', 'arrowchat_chatroom_messages', 'x_global_message', 'global_message', '`global_message`', '`global_message`', 17, 1, -1, false, '`global_message`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->global_message->Sortable = true; // Allow sort
        $this->global_message->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->global_message->Lookup = new Lookup('global_message', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->global_message->Lookup = new Lookup('global_message', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->global_message->Lookup = new Lookup('global_message', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->global_message->OptionCount = 2;
        $this->global_message->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->global_message->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->global_message->Param, "CustomMsg");
        $this->Fields['global_message'] = &$this->global_message;

        // is_mod
        $this->is_mod = new DbField('arrowchat_chatroom_messages', 'arrowchat_chatroom_messages', 'x_is_mod', 'is_mod', '`is_mod`', '`is_mod`', 17, 1, -1, false, '`is_mod`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->is_mod->Sortable = true; // Allow sort
        $this->is_mod->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->is_mod->Lookup = new Lookup('is_mod', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->is_mod->Lookup = new Lookup('is_mod', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->is_mod->Lookup = new Lookup('is_mod', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->is_mod->OptionCount = 2;
        $this->is_mod->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->is_mod->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->is_mod->Param, "CustomMsg");
        $this->Fields['is_mod'] = &$this->is_mod;

        // is_admin
        $this->is_admin = new DbField('arrowchat_chatroom_messages', 'arrowchat_chatroom_messages', 'x_is_admin', 'is_admin', '`is_admin`', '`is_admin`', 17, 1, -1, false, '`is_admin`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->is_admin->Sortable = true; // Allow sort
        $this->is_admin->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->is_admin->Lookup = new Lookup('is_admin', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->is_admin->Lookup = new Lookup('is_admin', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->is_admin->Lookup = new Lookup('is_admin', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->is_admin->OptionCount = 2;
        $this->is_admin->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->is_admin->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->is_admin->Param, "CustomMsg");
        $this->Fields['is_admin'] = &$this->is_admin;

        // sent
        $this->sent = new DbField('arrowchat_chatroom_messages', 'arrowchat_chatroom_messages', 'x_sent', 'sent', '`sent`', '`sent`', 19, 10, -1, false, '`sent`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sent->Nullable = false; // NOT NULL field
        $this->sent->Required = true; // Required field
        $this->sent->Sortable = true; // Allow sort
        $this->sent->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sent->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sent->Param, "CustomMsg");
        $this->Fields['sent'] = &$this->sent;

        // action
        $this->_action = new DbField('arrowchat_chatroom_messages', 'arrowchat_chatroom_messages', 'x__action', 'action', '`action`', '`action`', 17, 1, -1, false, '`action`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->_action->Sortable = true; // Allow sort
        $this->_action->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->_action->Lookup = new Lookup('action', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->_action->Lookup = new Lookup('action', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->_action->Lookup = new Lookup('action', 'arrowchat_chatroom_messages', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->_action->OptionCount = 2;
        $this->_action->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->_action->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_action->Param, "CustomMsg");
        $this->Fields['action'] = &$this->_action;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`arrowchat_chatroom_messages`";
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
        $this->chatroom_id->DbValue = $row['chatroom_id'];
        $this->user_id->DbValue = $row['user_id'];
        $this->_username->DbValue = $row['username'];
        $this->message->DbValue = $row['message'];
        $this->global_message->DbValue = $row['global_message'];
        $this->is_mod->DbValue = $row['is_mod'];
        $this->is_admin->DbValue = $row['is_admin'];
        $this->sent->DbValue = $row['sent'];
        $this->_action->DbValue = $row['action'];
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
        return $_SESSION[$name] ?? GetUrl("ArrowchatChatroomMessagesList");
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
        if ($pageName == "ArrowchatChatroomMessagesView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ArrowchatChatroomMessagesEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ArrowchatChatroomMessagesAdd") {
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
                return "ArrowchatChatroomMessagesView";
            case Config("API_ADD_ACTION"):
                return "ArrowchatChatroomMessagesAdd";
            case Config("API_EDIT_ACTION"):
                return "ArrowchatChatroomMessagesEdit";
            case Config("API_DELETE_ACTION"):
                return "ArrowchatChatroomMessagesDelete";
            case Config("API_LIST_ACTION"):
                return "ArrowchatChatroomMessagesList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ArrowchatChatroomMessagesList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ArrowchatChatroomMessagesView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ArrowchatChatroomMessagesView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ArrowchatChatroomMessagesAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ArrowchatChatroomMessagesAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ArrowchatChatroomMessagesEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("ArrowchatChatroomMessagesAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("ArrowchatChatroomMessagesDelete", $this->getUrlParm());
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // chatroom_id
        $this->chatroom_id->EditAttrs["class"] = "form-control";
        $this->chatroom_id->EditCustomAttributes = "";
        $this->chatroom_id->EditValue = $this->chatroom_id->CurrentValue;
        $this->chatroom_id->PlaceHolder = RemoveHtml($this->chatroom_id->caption());

        // user_id
        $this->user_id->EditAttrs["class"] = "form-control";
        $this->user_id->EditCustomAttributes = "";
        if (!$this->user_id->Raw) {
            $this->user_id->CurrentValue = HtmlDecode($this->user_id->CurrentValue);
        }
        $this->user_id->EditValue = $this->user_id->CurrentValue;
        $this->user_id->PlaceHolder = RemoveHtml($this->user_id->caption());

        // username
        $this->_username->EditAttrs["class"] = "form-control";
        $this->_username->EditCustomAttributes = "";
        if (!$this->_username->Raw) {
            $this->_username->CurrentValue = HtmlDecode($this->_username->CurrentValue);
        }
        $this->_username->EditValue = $this->_username->CurrentValue;
        $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

        // message
        $this->message->EditAttrs["class"] = "form-control";
        $this->message->EditCustomAttributes = "";
        $this->message->EditValue = $this->message->CurrentValue;
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
        $this->sent->EditValue = $this->sent->CurrentValue;
        $this->sent->PlaceHolder = RemoveHtml($this->sent->caption());

        // action
        $this->_action->EditCustomAttributes = "";
        $this->_action->EditValue = $this->_action->options(false);
        $this->_action->PlaceHolder = RemoveHtml($this->_action->caption());

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
                    $doc->exportCaption($this->chatroom_id);
                    $doc->exportCaption($this->user_id);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->message);
                    $doc->exportCaption($this->global_message);
                    $doc->exportCaption($this->is_mod);
                    $doc->exportCaption($this->is_admin);
                    $doc->exportCaption($this->sent);
                    $doc->exportCaption($this->_action);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->chatroom_id);
                    $doc->exportCaption($this->user_id);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->global_message);
                    $doc->exportCaption($this->is_mod);
                    $doc->exportCaption($this->is_admin);
                    $doc->exportCaption($this->sent);
                    $doc->exportCaption($this->_action);
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
                        $doc->exportField($this->chatroom_id);
                        $doc->exportField($this->user_id);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->message);
                        $doc->exportField($this->global_message);
                        $doc->exportField($this->is_mod);
                        $doc->exportField($this->is_admin);
                        $doc->exportField($this->sent);
                        $doc->exportField($this->_action);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->chatroom_id);
                        $doc->exportField($this->user_id);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->global_message);
                        $doc->exportField($this->is_mod);
                        $doc->exportField($this->is_admin);
                        $doc->exportField($this->sent);
                        $doc->exportField($this->_action);
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
