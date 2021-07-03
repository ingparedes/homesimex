<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for arrowchat_chatroom_rooms
 */
class ArrowchatChatroomRooms extends DbTable
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
    public $author_id;
    public $name;
    public $description;
    public $welcome_message;
    public $image;
    public $type;
    public $_password;
    public $length;
    public $is_featured;
    public $max_users;
    public $limit_message_num;
    public $limit_seconds_num;
    public $disallowed_groups;
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
        $this->TableVar = 'arrowchat_chatroom_rooms';
        $this->TableName = 'arrowchat_chatroom_rooms';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`arrowchat_chatroom_rooms`";
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
        $this->id = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_id', 'id', '`id`', '`id`', 19, 10, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // author_id
        $this->author_id = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_author_id', 'author_id', '`author_id`', '`author_id`', 200, 25, -1, false, '`author_id`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->author_id->Nullable = false; // NOT NULL field
        $this->author_id->Required = true; // Required field
        $this->author_id->Sortable = true; // Allow sort
        $this->author_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->author_id->Param, "CustomMsg");
        $this->Fields['author_id'] = &$this->author_id;

        // name
        $this->name = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_name', 'name', '`name`', '`name`', 200, 100, -1, false, '`name`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->name->Nullable = false; // NOT NULL field
        $this->name->Required = true; // Required field
        $this->name->Sortable = true; // Allow sort
        $this->name->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->name->Param, "CustomMsg");
        $this->Fields['name'] = &$this->name;

        // description
        $this->description = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_description', 'description', '`description`', '`description`', 200, 100, -1, false, '`description`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->description->Sortable = true; // Allow sort
        $this->description->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->description->Param, "CustomMsg");
        $this->Fields['description'] = &$this->description;

        // welcome_message
        $this->welcome_message = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_welcome_message', 'welcome_message', '`welcome_message`', '`welcome_message`', 200, 191, -1, false, '`welcome_message`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->welcome_message->Sortable = true; // Allow sort
        $this->welcome_message->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->welcome_message->Param, "CustomMsg");
        $this->Fields['welcome_message'] = &$this->welcome_message;

        // image
        $this->image = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_image', 'image', '`image`', '`image`', 200, 100, -1, false, '`image`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->image->Sortable = true; // Allow sort
        $this->image->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->image->Param, "CustomMsg");
        $this->Fields['image'] = &$this->image;

        // type
        $this->type = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_type', 'type', '`type`', '`type`', 17, 1, -1, false, '`type`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->type->Nullable = false; // NOT NULL field
        $this->type->Sortable = true; // Allow sort
        $this->type->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->type->Lookup = new Lookup('type', 'arrowchat_chatroom_rooms', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->type->Lookup = new Lookup('type', 'arrowchat_chatroom_rooms', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->type->Lookup = new Lookup('type', 'arrowchat_chatroom_rooms', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->type->OptionCount = 2;
        $this->type->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->type->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->type->Param, "CustomMsg");
        $this->Fields['type'] = &$this->type;

        // password
        $this->_password = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x__password', 'password', '`password`', '`password`', 200, 25, -1, false, '`password`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_password->Sortable = true; // Allow sort
        $this->_password->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_password->Param, "CustomMsg");
        $this->Fields['password'] = &$this->_password;

        // length
        $this->length = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_length', 'length', '`length`', '`length`', 19, 10, -1, false, '`length`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->length->Nullable = false; // NOT NULL field
        $this->length->Required = true; // Required field
        $this->length->Sortable = true; // Allow sort
        $this->length->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->length->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->length->Param, "CustomMsg");
        $this->Fields['length'] = &$this->length;

        // is_featured
        $this->is_featured = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_is_featured', 'is_featured', '`is_featured`', '`is_featured`', 17, 1, -1, false, '`is_featured`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->is_featured->Sortable = true; // Allow sort
        $this->is_featured->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->is_featured->Lookup = new Lookup('is_featured', 'arrowchat_chatroom_rooms', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->is_featured->Lookup = new Lookup('is_featured', 'arrowchat_chatroom_rooms', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->is_featured->Lookup = new Lookup('is_featured', 'arrowchat_chatroom_rooms', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->is_featured->OptionCount = 2;
        $this->is_featured->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->is_featured->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->is_featured->Param, "CustomMsg");
        $this->Fields['is_featured'] = &$this->is_featured;

        // max_users
        $this->max_users = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_max_users', 'max_users', '`max_users`', '`max_users`', 3, 10, -1, false, '`max_users`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->max_users->Nullable = false; // NOT NULL field
        $this->max_users->Sortable = true; // Allow sort
        $this->max_users->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->max_users->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->max_users->Param, "CustomMsg");
        $this->Fields['max_users'] = &$this->max_users;

        // limit_message_num
        $this->limit_message_num = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_limit_message_num', 'limit_message_num', '`limit_message_num`', '`limit_message_num`', 3, 5, -1, false, '`limit_message_num`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->limit_message_num->Nullable = false; // NOT NULL field
        $this->limit_message_num->Sortable = true; // Allow sort
        $this->limit_message_num->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->limit_message_num->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->limit_message_num->Param, "CustomMsg");
        $this->Fields['limit_message_num'] = &$this->limit_message_num;

        // limit_seconds_num
        $this->limit_seconds_num = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_limit_seconds_num', 'limit_seconds_num', '`limit_seconds_num`', '`limit_seconds_num`', 3, 5, -1, false, '`limit_seconds_num`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->limit_seconds_num->Nullable = false; // NOT NULL field
        $this->limit_seconds_num->Sortable = true; // Allow sort
        $this->limit_seconds_num->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->limit_seconds_num->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->limit_seconds_num->Param, "CustomMsg");
        $this->Fields['limit_seconds_num'] = &$this->limit_seconds_num;

        // disallowed_groups
        $this->disallowed_groups = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_disallowed_groups', 'disallowed_groups', '`disallowed_groups`', '`disallowed_groups`', 201, 65535, -1, false, '`disallowed_groups`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->disallowed_groups->Nullable = false; // NOT NULL field
        $this->disallowed_groups->Required = true; // Required field
        $this->disallowed_groups->Sortable = true; // Allow sort
        $this->disallowed_groups->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->disallowed_groups->Param, "CustomMsg");
        $this->Fields['disallowed_groups'] = &$this->disallowed_groups;

        // session_time
        $this->session_time = new DbField('arrowchat_chatroom_rooms', 'arrowchat_chatroom_rooms', 'x_session_time', 'session_time', '`session_time`', '`session_time`', 19, 10, -1, false, '`session_time`', false, false, false, 'FORMATTED TEXT', 'TEXT');
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`arrowchat_chatroom_rooms`";
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
        $this->author_id->DbValue = $row['author_id'];
        $this->name->DbValue = $row['name'];
        $this->description->DbValue = $row['description'];
        $this->welcome_message->DbValue = $row['welcome_message'];
        $this->image->DbValue = $row['image'];
        $this->type->DbValue = $row['type'];
        $this->_password->DbValue = $row['password'];
        $this->length->DbValue = $row['length'];
        $this->is_featured->DbValue = $row['is_featured'];
        $this->max_users->DbValue = $row['max_users'];
        $this->limit_message_num->DbValue = $row['limit_message_num'];
        $this->limit_seconds_num->DbValue = $row['limit_seconds_num'];
        $this->disallowed_groups->DbValue = $row['disallowed_groups'];
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
        return $_SESSION[$name] ?? GetUrl("ArrowchatChatroomRoomsList");
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
        if ($pageName == "ArrowchatChatroomRoomsView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ArrowchatChatroomRoomsEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ArrowchatChatroomRoomsAdd") {
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
                return "ArrowchatChatroomRoomsView";
            case Config("API_ADD_ACTION"):
                return "ArrowchatChatroomRoomsAdd";
            case Config("API_EDIT_ACTION"):
                return "ArrowchatChatroomRoomsEdit";
            case Config("API_DELETE_ACTION"):
                return "ArrowchatChatroomRoomsDelete";
            case Config("API_LIST_ACTION"):
                return "ArrowchatChatroomRoomsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ArrowchatChatroomRoomsList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ArrowchatChatroomRoomsView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ArrowchatChatroomRoomsView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ArrowchatChatroomRoomsAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ArrowchatChatroomRoomsAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ArrowchatChatroomRoomsEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("ArrowchatChatroomRoomsAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("ArrowchatChatroomRoomsDelete", $this->getUrlParm());
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // author_id
        $this->author_id->EditAttrs["class"] = "form-control";
        $this->author_id->EditCustomAttributes = "";
        if (!$this->author_id->Raw) {
            $this->author_id->CurrentValue = HtmlDecode($this->author_id->CurrentValue);
        }
        $this->author_id->EditValue = $this->author_id->CurrentValue;
        $this->author_id->PlaceHolder = RemoveHtml($this->author_id->caption());

        // name
        $this->name->EditAttrs["class"] = "form-control";
        $this->name->EditCustomAttributes = "";
        if (!$this->name->Raw) {
            $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
        }
        $this->name->EditValue = $this->name->CurrentValue;
        $this->name->PlaceHolder = RemoveHtml($this->name->caption());

        // description
        $this->description->EditAttrs["class"] = "form-control";
        $this->description->EditCustomAttributes = "";
        if (!$this->description->Raw) {
            $this->description->CurrentValue = HtmlDecode($this->description->CurrentValue);
        }
        $this->description->EditValue = $this->description->CurrentValue;
        $this->description->PlaceHolder = RemoveHtml($this->description->caption());

        // welcome_message
        $this->welcome_message->EditAttrs["class"] = "form-control";
        $this->welcome_message->EditCustomAttributes = "";
        if (!$this->welcome_message->Raw) {
            $this->welcome_message->CurrentValue = HtmlDecode($this->welcome_message->CurrentValue);
        }
        $this->welcome_message->EditValue = $this->welcome_message->CurrentValue;
        $this->welcome_message->PlaceHolder = RemoveHtml($this->welcome_message->caption());

        // image
        $this->image->EditAttrs["class"] = "form-control";
        $this->image->EditCustomAttributes = "";
        if (!$this->image->Raw) {
            $this->image->CurrentValue = HtmlDecode($this->image->CurrentValue);
        }
        $this->image->EditValue = $this->image->CurrentValue;
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
        $this->_password->EditValue = $this->_password->CurrentValue;
        $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

        // length
        $this->length->EditAttrs["class"] = "form-control";
        $this->length->EditCustomAttributes = "";
        $this->length->EditValue = $this->length->CurrentValue;
        $this->length->PlaceHolder = RemoveHtml($this->length->caption());

        // is_featured
        $this->is_featured->EditCustomAttributes = "";
        $this->is_featured->EditValue = $this->is_featured->options(false);
        $this->is_featured->PlaceHolder = RemoveHtml($this->is_featured->caption());

        // max_users
        $this->max_users->EditAttrs["class"] = "form-control";
        $this->max_users->EditCustomAttributes = "";
        $this->max_users->EditValue = $this->max_users->CurrentValue;
        $this->max_users->PlaceHolder = RemoveHtml($this->max_users->caption());

        // limit_message_num
        $this->limit_message_num->EditAttrs["class"] = "form-control";
        $this->limit_message_num->EditCustomAttributes = "";
        $this->limit_message_num->EditValue = $this->limit_message_num->CurrentValue;
        $this->limit_message_num->PlaceHolder = RemoveHtml($this->limit_message_num->caption());

        // limit_seconds_num
        $this->limit_seconds_num->EditAttrs["class"] = "form-control";
        $this->limit_seconds_num->EditCustomAttributes = "";
        $this->limit_seconds_num->EditValue = $this->limit_seconds_num->CurrentValue;
        $this->limit_seconds_num->PlaceHolder = RemoveHtml($this->limit_seconds_num->caption());

        // disallowed_groups
        $this->disallowed_groups->EditAttrs["class"] = "form-control";
        $this->disallowed_groups->EditCustomAttributes = "";
        $this->disallowed_groups->EditValue = $this->disallowed_groups->CurrentValue;
        $this->disallowed_groups->PlaceHolder = RemoveHtml($this->disallowed_groups->caption());

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
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->author_id);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->description);
                    $doc->exportCaption($this->welcome_message);
                    $doc->exportCaption($this->image);
                    $doc->exportCaption($this->type);
                    $doc->exportCaption($this->_password);
                    $doc->exportCaption($this->length);
                    $doc->exportCaption($this->is_featured);
                    $doc->exportCaption($this->max_users);
                    $doc->exportCaption($this->limit_message_num);
                    $doc->exportCaption($this->limit_seconds_num);
                    $doc->exportCaption($this->disallowed_groups);
                    $doc->exportCaption($this->session_time);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->author_id);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->description);
                    $doc->exportCaption($this->welcome_message);
                    $doc->exportCaption($this->image);
                    $doc->exportCaption($this->type);
                    $doc->exportCaption($this->_password);
                    $doc->exportCaption($this->length);
                    $doc->exportCaption($this->is_featured);
                    $doc->exportCaption($this->max_users);
                    $doc->exportCaption($this->limit_message_num);
                    $doc->exportCaption($this->limit_seconds_num);
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
                        $doc->exportField($this->id);
                        $doc->exportField($this->author_id);
                        $doc->exportField($this->name);
                        $doc->exportField($this->description);
                        $doc->exportField($this->welcome_message);
                        $doc->exportField($this->image);
                        $doc->exportField($this->type);
                        $doc->exportField($this->_password);
                        $doc->exportField($this->length);
                        $doc->exportField($this->is_featured);
                        $doc->exportField($this->max_users);
                        $doc->exportField($this->limit_message_num);
                        $doc->exportField($this->limit_seconds_num);
                        $doc->exportField($this->disallowed_groups);
                        $doc->exportField($this->session_time);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->author_id);
                        $doc->exportField($this->name);
                        $doc->exportField($this->description);
                        $doc->exportField($this->welcome_message);
                        $doc->exportField($this->image);
                        $doc->exportField($this->type);
                        $doc->exportField($this->_password);
                        $doc->exportField($this->length);
                        $doc->exportField($this->is_featured);
                        $doc->exportField($this->max_users);
                        $doc->exportField($this->limit_message_num);
                        $doc->exportField($this->limit_seconds_num);
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
