<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for permisos_docusers
 */
class PermisosDocusers extends DbTable
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
    public $id_permisiosuser;
    public $id_file;
    public $tipo_permiso;
    public $id_users;
    public $date_created;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'permisos_docusers';
        $this->TableName = 'permisos_docusers';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`permisos_docusers`";
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

        // id_permisiosuser
        $this->id_permisiosuser = new DbField('permisos_docusers', 'permisos_docusers', 'x_id_permisiosuser', 'id_permisiosuser', '`id_permisiosuser`', '`id_permisiosuser`', 3, 11, -1, false, '`id_permisiosuser`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_permisiosuser->IsAutoIncrement = true; // Autoincrement field
        $this->id_permisiosuser->IsPrimaryKey = true; // Primary key field
        $this->id_permisiosuser->Sortable = true; // Allow sort
        $this->id_permisiosuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_permisiosuser->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_permisiosuser->Param, "CustomMsg");
        $this->Fields['id_permisiosuser'] = &$this->id_permisiosuser;

        // id_file
        $this->id_file = new DbField('permisos_docusers', 'permisos_docusers', 'x_id_file', 'id_file', '`id_file`', '`id_file`', 3, 11, -1, false, '`id_file`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->id_file->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->id_file->Lookup = new Lookup('id_file', 'archivos_doc', false, 'id_file', ["file_name","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->id_file->Lookup = new Lookup('id_file', 'archivos_doc', false, 'id_file', ["file_name","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->id_file->Lookup = new Lookup('id_file', 'archivos_doc', false, 'id_file', ["file_name","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->id_file->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_file->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_file->Param, "CustomMsg");
        $this->Fields['id_file'] = &$this->id_file;

        // tipo_permiso
        $this->tipo_permiso = new DbField('permisos_docusers', 'permisos_docusers', 'x_tipo_permiso', 'tipo_permiso', '`tipo_permiso`', '`tipo_permiso`', 3, 2, -1, false, '`tipo_permiso`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->tipo_permiso->Sortable = true; // Allow sort
        $this->tipo_permiso->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo_permiso->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->tipo_permiso->Lookup = new Lookup('tipo_permiso', 'permisos_docusers', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->tipo_permiso->Lookup = new Lookup('tipo_permiso', 'permisos_docusers', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->tipo_permiso->Lookup = new Lookup('tipo_permiso', 'permisos_docusers', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->tipo_permiso->OptionCount = 2;
        $this->tipo_permiso->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipo_permiso->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tipo_permiso->Param, "CustomMsg");
        $this->Fields['tipo_permiso'] = &$this->tipo_permiso;

        // id_users
        $this->id_users = new DbField('permisos_docusers', 'permisos_docusers', 'x_id_users', 'id_users', '`id_users`', '`id_users`', 3, 11, -1, false, '`id_users`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->id_users->Sortable = true; // Allow sort
        $this->id_users->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->id_users->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->id_users->Lookup = new Lookup('id_users', 'users', false, 'id_users', ["nombres","apellidos","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->id_users->Lookup = new Lookup('id_users', 'users', false, 'id_users', ["nombres","apellidos","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->id_users->Lookup = new Lookup('id_users', 'users', false, 'id_users', ["nombres","apellidos","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->id_users->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_users->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_users->Param, "CustomMsg");
        $this->Fields['id_users'] = &$this->id_users;

        // date_created
        $this->date_created = new DbField('permisos_docusers', 'permisos_docusers', 'x_date_created', 'date_created', '`date_created`', CastDateFieldForLike("`date_created`", 15, "DB"), 135, 19, 15, false, '`date_created`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->date_created->Sortable = true; // Allow sort
        $this->date_created->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectShortDateYMD"));
        $this->date_created->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->date_created->Param, "CustomMsg");
        $this->Fields['date_created'] = &$this->date_created;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`permisos_docusers`";
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
        $this->DefaultFilter = "`id_users` =  ".CurrentUserID()."";
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
            $this->id_permisiosuser->setDbValue($conn->lastInsertId());
            $rs['id_permisiosuser'] = $this->id_permisiosuser->DbValue;
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
            if (array_key_exists('id_permisiosuser', $rs)) {
                AddFilter($where, QuotedName('id_permisiosuser', $this->Dbid) . '=' . QuotedValue($rs['id_permisiosuser'], $this->id_permisiosuser->DataType, $this->Dbid));
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
        $this->id_permisiosuser->DbValue = $row['id_permisiosuser'];
        $this->id_file->DbValue = $row['id_file'];
        $this->tipo_permiso->DbValue = $row['tipo_permiso'];
        $this->id_users->DbValue = $row['id_users'];
        $this->date_created->DbValue = $row['date_created'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id_permisiosuser` = @id_permisiosuser@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id_permisiosuser->CurrentValue : $this->id_permisiosuser->OldValue;
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
                $this->id_permisiosuser->CurrentValue = $keys[0];
            } else {
                $this->id_permisiosuser->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id_permisiosuser', $row) ? $row['id_permisiosuser'] : null;
        } else {
            $val = $this->id_permisiosuser->OldValue !== null ? $this->id_permisiosuser->OldValue : $this->id_permisiosuser->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id_permisiosuser@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("PermisosDocusersList");
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
        if ($pageName == "PermisosDocusersView") {
            return $Language->phrase("View");
        } elseif ($pageName == "PermisosDocusersEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "PermisosDocusersAdd") {
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
                return "PermisosDocusersView";
            case Config("API_ADD_ACTION"):
                return "PermisosDocusersAdd";
            case Config("API_EDIT_ACTION"):
                return "PermisosDocusersEdit";
            case Config("API_DELETE_ACTION"):
                return "PermisosDocusersDelete";
            case Config("API_LIST_ACTION"):
                return "PermisosDocusersList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "PermisosDocusersList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PermisosDocusersView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("PermisosDocusersView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "PermisosDocusersAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "PermisosDocusersAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("PermisosDocusersEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("PermisosDocusersAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("PermisosDocusersDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id_permisiosuser:" . JsonEncode($this->id_permisiosuser->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id_permisiosuser->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id_permisiosuser->CurrentValue);
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
            if (($keyValue = Param("id_permisiosuser") ?? Route("id_permisiosuser")) !== null) {
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
                $this->id_permisiosuser->CurrentValue = $key;
            } else {
                $this->id_permisiosuser->OldValue = $key;
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
        $this->id_permisiosuser->setDbValue($row['id_permisiosuser']);
        $this->id_file->setDbValue($row['id_file']);
        $this->tipo_permiso->setDbValue($row['tipo_permiso']);
        $this->id_users->setDbValue($row['id_users']);
        $this->date_created->setDbValue($row['date_created']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id_permisiosuser

        // id_file

        // tipo_permiso

        // id_users

        // date_created

        // id_permisiosuser
        $this->id_permisiosuser->ViewValue = $this->id_permisiosuser->CurrentValue;
        $this->id_permisiosuser->ViewCustomAttributes = "";

        // id_file
        $this->id_file->ViewValue = $this->id_file->CurrentValue;
        $curVal = trim(strval($this->id_file->CurrentValue));
        if ($curVal != "") {
            $this->id_file->ViewValue = $this->id_file->lookupCacheOption($curVal);
            if ($this->id_file->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_file`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->id_file->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->id_file->Lookup->renderViewRow($rswrk[0]);
                    $this->id_file->ViewValue = $this->id_file->displayValue($arwrk);
                } else {
                    $this->id_file->ViewValue = $this->id_file->CurrentValue;
                }
            }
        } else {
            $this->id_file->ViewValue = null;
        }
        $this->id_file->ViewCustomAttributes = "";

        // tipo_permiso
        if (strval($this->tipo_permiso->CurrentValue) != "") {
            $this->tipo_permiso->ViewValue = $this->tipo_permiso->optionCaption($this->tipo_permiso->CurrentValue);
        } else {
            $this->tipo_permiso->ViewValue = null;
        }
        $this->tipo_permiso->ViewCustomAttributes = "";

        // id_users
        $curVal = trim(strval($this->id_users->CurrentValue));
        if ($curVal != "") {
            $this->id_users->ViewValue = $this->id_users->lookupCacheOption($curVal);
            if ($this->id_users->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_users`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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

        // date_created
        $this->date_created->ViewValue = $this->date_created->CurrentValue;
        $this->date_created->ViewValue = FormatDateTime($this->date_created->ViewValue, 15);
        $this->date_created->ViewCustomAttributes = "";

        // id_permisiosuser
        $this->id_permisiosuser->LinkCustomAttributes = "";
        $this->id_permisiosuser->HrefValue = "";
        $this->id_permisiosuser->TooltipValue = "";

        // id_file
        $this->id_file->LinkCustomAttributes = "";
        $this->id_file->HrefValue = "";
        $this->id_file->TooltipValue = "";

        // tipo_permiso
        $this->tipo_permiso->LinkCustomAttributes = "";
        $this->tipo_permiso->HrefValue = "";
        $this->tipo_permiso->TooltipValue = "";

        // id_users
        $this->id_users->LinkCustomAttributes = "";
        $this->id_users->HrefValue = "";
        $this->id_users->TooltipValue = "";

        // date_created
        $this->date_created->LinkCustomAttributes = "";
        $this->date_created->HrefValue = "";
        $this->date_created->TooltipValue = "";

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

        // id_permisiosuser
        $this->id_permisiosuser->EditAttrs["class"] = "form-control";
        $this->id_permisiosuser->EditCustomAttributes = "";
        $this->id_permisiosuser->EditValue = $this->id_permisiosuser->CurrentValue;
        $this->id_permisiosuser->ViewCustomAttributes = "";

        // id_file
        $this->id_file->EditAttrs["class"] = "form-control";
        $this->id_file->EditCustomAttributes = "";
        $this->id_file->EditValue = $this->id_file->CurrentValue;
        $this->id_file->PlaceHolder = RemoveHtml($this->id_file->caption());

        // tipo_permiso
        $this->tipo_permiso->EditAttrs["class"] = "form-control";
        $this->tipo_permiso->EditCustomAttributes = "";
        $this->tipo_permiso->EditValue = $this->tipo_permiso->options(true);
        $this->tipo_permiso->PlaceHolder = RemoveHtml($this->tipo_permiso->caption());

        // id_users
        $this->id_users->EditAttrs["class"] = "form-control";
        $this->id_users->EditCustomAttributes = "";
        $this->id_users->PlaceHolder = RemoveHtml($this->id_users->caption());

        // date_created
        $this->date_created->EditAttrs["class"] = "form-control";
        $this->date_created->EditCustomAttributes = "";
        $this->date_created->EditValue = FormatDateTime($this->date_created->CurrentValue, 15);
        $this->date_created->PlaceHolder = RemoveHtml($this->date_created->caption());

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
                    $doc->exportCaption($this->id_file);
                    $doc->exportCaption($this->tipo_permiso);
                } else {
                    $doc->exportCaption($this->id_permisiosuser);
                    $doc->exportCaption($this->id_file);
                    $doc->exportCaption($this->tipo_permiso);
                    $doc->exportCaption($this->id_users);
                    $doc->exportCaption($this->date_created);
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
                        $doc->exportField($this->id_file);
                        $doc->exportField($this->tipo_permiso);
                    } else {
                        $doc->exportField($this->id_permisiosuser);
                        $doc->exportField($this->id_file);
                        $doc->exportField($this->tipo_permiso);
                        $doc->exportField($this->id_users);
                        $doc->exportField($this->date_created);
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
