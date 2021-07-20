<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for mensajes
 */
class Mensajes extends DbTable
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
    public $id_inyect;
    public $id_tarea;
    public $titulo;
    public $mensaje;
    public $fechareal_start;
    public $fechasim_start;
    public $medios;
    public $actividad_esperada;
    public $id_actor;
    public $enviado;
    public $para;
    public $adjunto;
    public $dif_horaria;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'mensajes';
        $this->TableName = 'mensajes';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`mensajes`";
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

        // id_inyect
        $this->id_inyect = new DbField('mensajes', 'mensajes', 'x_id_inyect', 'id_inyect', '`id_inyect`', '`id_inyect`', 3, 11, -1, false, '`id_inyect`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_inyect->IsAutoIncrement = true; // Autoincrement field
        $this->id_inyect->IsPrimaryKey = true; // Primary key field
        $this->id_inyect->Sortable = true; // Allow sort
        $this->id_inyect->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_inyect->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_inyect->Param, "CustomMsg");
        $this->Fields['id_inyect'] = &$this->id_inyect;

        // id_tarea
        $this->id_tarea = new DbField('mensajes', 'mensajes', 'x_id_tarea', 'id_tarea', '`id_tarea`', '`id_tarea`', 3, 11, -1, false, '`id_tarea`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->id_tarea->IsForeignKey = true; // Foreign key field
        $this->id_tarea->Sortable = true; // Allow sort
        $this->id_tarea->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->id_tarea->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->id_tarea->Lookup = new Lookup('id_tarea', 'tareas', false, 'id_tarea', ["titulo_tarea","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->id_tarea->Lookup = new Lookup('id_tarea', 'tareas', false, 'id_tarea', ["titulo_tarea","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->id_tarea->Lookup = new Lookup('id_tarea', 'tareas', false, 'id_tarea', ["titulo_tarea","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->id_tarea->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_tarea->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_tarea->Param, "CustomMsg");
        $this->Fields['id_tarea'] = &$this->id_tarea;

        // titulo
        $this->titulo = new DbField('mensajes', 'mensajes', 'x_titulo', 'titulo', '`titulo`', '`titulo`', 200, 100, -1, false, '`titulo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->titulo->Required = true; // Required field
        $this->titulo->Sortable = true; // Allow sort
        $this->titulo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->titulo->Param, "CustomMsg");
        $this->Fields['titulo'] = &$this->titulo;

        // mensaje
        $this->mensaje = new DbField('mensajes', 'mensajes', 'x_mensaje', 'mensaje', '`mensaje`', '`mensaje`', 201, 65535, -1, false, '`mensaje`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->mensaje->Required = true; // Required field
        $this->mensaje->Sortable = true; // Allow sort
        $this->mensaje->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->mensaje->Param, "CustomMsg");
        $this->Fields['mensaje'] = &$this->mensaje;

        // fechareal_start
        $this->fechareal_start = new DbField('mensajes', 'mensajes', 'x_fechareal_start', 'fechareal_start', '`fechareal_start`', CastDateFieldForLike("`fechareal_start`", 109, "DB"), 135, 26, 109, false, '`fechareal_start`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechareal_start->Required = true; // Required field
        $this->fechareal_start->Sortable = true; // Allow sort
        $this->fechareal_start->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechareal_start->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechareal_start->Param, "CustomMsg");
        $this->Fields['fechareal_start'] = &$this->fechareal_start;

        // fechasim_start
        $this->fechasim_start = new DbField('mensajes', 'mensajes', 'x_fechasim_start', 'fechasim_start', '`fechasim_start`', CastDateFieldForLike("`fechasim_start`", 109, "DB"), 135, 26, 109, false, '`fechasim_start`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechasim_start->Required = true; // Required field
        $this->fechasim_start->Sortable = true; // Allow sort
        $this->fechasim_start->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechasim_start->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechasim_start->Param, "CustomMsg");
        $this->Fields['fechasim_start'] = &$this->fechasim_start;

        // medios
        $this->medios = new DbField('mensajes', 'mensajes', 'x_medios', 'medios', '`medios`', '`medios`', 3, 2, -1, false, '`medios`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->medios->Required = true; // Required field
        $this->medios->Sortable = true; // Allow sort
        $this->medios->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->medios->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->medios->Lookup = new Lookup('medios', 'mensajes', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->medios->Lookup = new Lookup('medios', 'mensajes', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->medios->Lookup = new Lookup('medios', 'mensajes', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->medios->OptionCount = 3;
        $this->medios->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->medios->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->medios->Param, "CustomMsg");
        $this->Fields['medios'] = &$this->medios;

        // actividad_esperada
        $this->actividad_esperada = new DbField('mensajes', 'mensajes', 'x_actividad_esperada', 'actividad_esperada', '`actividad_esperada`', '`actividad_esperada`', 201, 65535, -1, false, '`actividad_esperada`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->actividad_esperada->Sortable = true; // Allow sort
        $this->actividad_esperada->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->actividad_esperada->Param, "CustomMsg");
        $this->Fields['actividad_esperada'] = &$this->actividad_esperada;

        // id_actor
        $this->id_actor = new DbField('mensajes', 'mensajes', 'x_id_actor', 'id_actor', '`id_actor`', '`id_actor`', 3, 11, -1, false, '`id_actor`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->id_actor->Sortable = true; // Allow sort
        $this->id_actor->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->id_actor->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->id_actor->Lookup = new Lookup('id_actor', 'actor_simulado', false, 'id_actor', ["nombre_actor","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->id_actor->Lookup = new Lookup('id_actor', 'actor_simulado', false, 'id_actor', ["nombre_actor","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->id_actor->Lookup = new Lookup('id_actor', 'actor_simulado', false, 'id_actor', ["nombre_actor","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->id_actor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_actor->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_actor->Param, "CustomMsg");
        $this->Fields['id_actor'] = &$this->id_actor;

        // enviado
        $this->enviado = new DbField('mensajes', 'mensajes', 'x_enviado', 'enviado', '`enviado`', '`enviado`', 16, 255, -1, false, '`enviado`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->enviado->Sortable = false; // Allow sort
        $this->enviado->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->enviado->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->enviado->Param, "CustomMsg");
        $this->Fields['enviado'] = &$this->enviado;

        // para
        $this->para = new DbField('mensajes', 'mensajes', 'x_para', 'para', '`para`', '`para`', 200, 60, -1, false, '`para`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->para->Required = true; // Required field
        $this->para->Sortable = true; // Allow sort
        $this->para->SelectMultiple = true; // Multiple select
        switch ($CurrentLanguage) {
            case "en":
                $this->para->Lookup = new Lookup('para', 'view_from', false, 'id', ["nombre_agrupacion","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->para->Lookup = new Lookup('para', 'view_from', false, 'id', ["nombre_agrupacion","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->para->Lookup = new Lookup('para', 'view_from', false, 'id', ["nombre_agrupacion","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->para->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->para->Param, "CustomMsg");
        $this->Fields['para'] = &$this->para;

        // adjunto
        $this->adjunto = new DbField('mensajes', 'mensajes', 'x_adjunto', 'adjunto', '`adjunto`', '`adjunto`', 3, 11, -1, false, '`adjunto`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->adjunto->Sortable = true; // Allow sort
        $this->adjunto->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->adjunto->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->adjunto->Lookup = new Lookup('adjunto', 'archivos_doc', false, 'id_file', ["file_name","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->adjunto->Lookup = new Lookup('adjunto', 'archivos_doc', false, 'id_file', ["file_name","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->adjunto->Lookup = new Lookup('adjunto', 'archivos_doc', false, 'id_file', ["file_name","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->adjunto->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->adjunto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->adjunto->Param, "CustomMsg");
        $this->Fields['adjunto'] = &$this->adjunto;

        // dif_horaria
        $this->dif_horaria = new DbField('mensajes', 'mensajes', 'x_dif_horaria', 'dif_horaria', '`dif_horaria`', '`dif_horaria`', 3, 10, -1, false, '`dif_horaria`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->dif_horaria->Sortable = false; // Allow sort
        $this->dif_horaria->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->dif_horaria->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dif_horaria->Param, "CustomMsg");
        $this->Fields['dif_horaria'] = &$this->dif_horaria;
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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "tareas") {
            if ($this->id_tarea->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id_tarea`", $this->id_tarea->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "tareas") {
            if ($this->id_tarea->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`id_tarea`", $this->id_tarea->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_tareas()
    {
        return "`id_tarea`=@id_tarea@";
    }
    // Detail filter
    public function sqlDetailFilter_tareas()
    {
        return "`id_tarea`=@id_tarea@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`mensajes`";
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
            $this->id_inyect->setDbValue($conn->lastInsertId());
            $rs['id_inyect'] = $this->id_inyect->DbValue;
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
            if (array_key_exists('id_inyect', $rs)) {
                AddFilter($where, QuotedName('id_inyect', $this->Dbid) . '=' . QuotedValue($rs['id_inyect'], $this->id_inyect->DataType, $this->Dbid));
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
        $this->id_inyect->DbValue = $row['id_inyect'];
        $this->id_tarea->DbValue = $row['id_tarea'];
        $this->titulo->DbValue = $row['titulo'];
        $this->mensaje->DbValue = $row['mensaje'];
        $this->fechareal_start->DbValue = $row['fechareal_start'];
        $this->fechasim_start->DbValue = $row['fechasim_start'];
        $this->medios->DbValue = $row['medios'];
        $this->actividad_esperada->DbValue = $row['actividad_esperada'];
        $this->id_actor->DbValue = $row['id_actor'];
        $this->enviado->DbValue = $row['enviado'];
        $this->para->DbValue = $row['para'];
        $this->adjunto->DbValue = $row['adjunto'];
        $this->dif_horaria->DbValue = $row['dif_horaria'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id_inyect` = @id_inyect@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id_inyect->CurrentValue : $this->id_inyect->OldValue;
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
                $this->id_inyect->CurrentValue = $keys[0];
            } else {
                $this->id_inyect->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id_inyect', $row) ? $row['id_inyect'] : null;
        } else {
            $val = $this->id_inyect->OldValue !== null ? $this->id_inyect->OldValue : $this->id_inyect->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id_inyect@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("MensajesList");
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
        if ($pageName == "MensajesView") {
            return $Language->phrase("View");
        } elseif ($pageName == "MensajesEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "MensajesAdd") {
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
                return "MensajesView";
            case Config("API_ADD_ACTION"):
                return "MensajesAdd";
            case Config("API_EDIT_ACTION"):
                return "MensajesEdit";
            case Config("API_DELETE_ACTION"):
                return "MensajesDelete";
            case Config("API_LIST_ACTION"):
                return "MensajesList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "MensajesList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("MensajesView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("MensajesView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "MensajesAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "MensajesAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("MensajesEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("MensajesAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("MensajesDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "tareas" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id_tarea", $this->id_tarea->CurrentValue ?? $this->id_tarea->getSessionValue());
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id_inyect:" . JsonEncode($this->id_inyect->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id_inyect->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id_inyect->CurrentValue);
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
            if (($keyValue = Param("id_inyect") ?? Route("id_inyect")) !== null) {
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
                $this->id_inyect->CurrentValue = $key;
            } else {
                $this->id_inyect->OldValue = $key;
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
        $this->id_inyect->setDbValue($row['id_inyect']);
        $this->id_tarea->setDbValue($row['id_tarea']);
        $this->titulo->setDbValue($row['titulo']);
        $this->mensaje->setDbValue($row['mensaje']);
        $this->fechareal_start->setDbValue($row['fechareal_start']);
        $this->fechasim_start->setDbValue($row['fechasim_start']);
        $this->medios->setDbValue($row['medios']);
        $this->actividad_esperada->setDbValue($row['actividad_esperada']);
        $this->id_actor->setDbValue($row['id_actor']);
        $this->enviado->setDbValue($row['enviado']);
        $this->para->setDbValue($row['para']);
        $this->adjunto->setDbValue($row['adjunto']);
        $this->dif_horaria->setDbValue($row['dif_horaria']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id_inyect

        // id_tarea

        // titulo

        // mensaje

        // fechareal_start

        // fechasim_start

        // medios

        // actividad_esperada

        // id_actor

        // enviado

        // para

        // adjunto

        // dif_horaria
        $this->dif_horaria->CellCssStyle = "white-space: nowrap;";

        // id_inyect
        $this->id_inyect->ViewValue = $this->id_inyect->CurrentValue;
        $this->id_inyect->ViewCustomAttributes = "";

        // id_tarea
        $curVal = trim(strval($this->id_tarea->CurrentValue));
        if ($curVal != "") {
            $this->id_tarea->ViewValue = $this->id_tarea->lookupCacheOption($curVal);
            if ($this->id_tarea->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_tarea`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->id_tarea->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->id_tarea->Lookup->renderViewRow($rswrk[0]);
                    $this->id_tarea->ViewValue = $this->id_tarea->displayValue($arwrk);
                } else {
                    $this->id_tarea->ViewValue = $this->id_tarea->CurrentValue;
                }
            }
        } else {
            $this->id_tarea->ViewValue = null;
        }
        $this->id_tarea->ViewCustomAttributes = "";

        // titulo
        $this->titulo->ViewValue = $this->titulo->CurrentValue;
        $this->titulo->ViewCustomAttributes = "";

        // mensaje
        $this->mensaje->ViewValue = $this->mensaje->CurrentValue;
        $this->mensaje->ViewCustomAttributes = "";

        // fechareal_start
        $this->fechareal_start->ViewValue = $this->fechareal_start->CurrentValue;
        $this->fechareal_start->ViewValue = FormatDateTime($this->fechareal_start->ViewValue, 109);
        $this->fechareal_start->CssClass = "font-italic";
        $this->fechareal_start->ViewCustomAttributes = "";

        // fechasim_start
        $this->fechasim_start->ViewValue = $this->fechasim_start->CurrentValue;
        $this->fechasim_start->ViewValue = FormatDateTime($this->fechasim_start->ViewValue, 109);
        $this->fechasim_start->ViewCustomAttributes = "";

        // medios
        if (strval($this->medios->CurrentValue) != "") {
            $this->medios->ViewValue = $this->medios->optionCaption($this->medios->CurrentValue);
        } else {
            $this->medios->ViewValue = null;
        }
        $this->medios->ViewCustomAttributes = "";

        // actividad_esperada
        $this->actividad_esperada->ViewValue = $this->actividad_esperada->CurrentValue;
        $this->actividad_esperada->ViewCustomAttributes = "";

        // id_actor
        $curVal = trim(strval($this->id_actor->CurrentValue));
        if ($curVal != "") {
            $this->id_actor->ViewValue = $this->id_actor->lookupCacheOption($curVal);
            if ($this->id_actor->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_actor`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->id_actor->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->id_actor->Lookup->renderViewRow($rswrk[0]);
                    $this->id_actor->ViewValue = $this->id_actor->displayValue($arwrk);
                } else {
                    $this->id_actor->ViewValue = $this->id_actor->CurrentValue;
                }
            }
        } else {
            $this->id_actor->ViewValue = null;
        }
        $this->id_actor->ViewCustomAttributes = "";

        // enviado
        $this->enviado->ViewValue = $this->enviado->CurrentValue;
        $this->enviado->ViewValue = FormatNumber($this->enviado->ViewValue, 0, -2, -2, -2);
        $this->enviado->ViewCustomAttributes = "";

        // para
        $curVal = trim(strval($this->para->CurrentValue));
        if ($curVal != "") {
            $this->para->ViewValue = $this->para->lookupCacheOption($curVal);
            if ($this->para->ViewValue === null) { // Lookup from database
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`id`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $lookupFilter = function() {
                    return (CurrentUserInfo("perfil") == 2 ) ? "`idgrupo` = '".CurrentUserInfo("grupo")."'" : "`escenario` = '".CurrentUserInfo("escenario")."'";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->para->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->para->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->para->Lookup->renderViewRow($row);
                        $this->para->ViewValue->add($this->para->displayValue($arwrk));
                    }
                } else {
                    $this->para->ViewValue = $this->para->CurrentValue;
                }
            }
        } else {
            $this->para->ViewValue = null;
        }
        $this->para->ViewCustomAttributes = "";

        // adjunto
        $curVal = trim(strval($this->adjunto->CurrentValue));
        if ($curVal != "") {
            $this->adjunto->ViewValue = $this->adjunto->lookupCacheOption($curVal);
            if ($this->adjunto->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_file`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->adjunto->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->adjunto->Lookup->renderViewRow($rswrk[0]);
                    $this->adjunto->ViewValue = $this->adjunto->displayValue($arwrk);
                } else {
                    $this->adjunto->ViewValue = $this->adjunto->CurrentValue;
                }
            }
        } else {
            $this->adjunto->ViewValue = null;
        }
        $this->adjunto->ViewCustomAttributes = "";

        // dif_horaria
        $this->dif_horaria->ViewValue = $this->dif_horaria->CurrentValue;
        $this->dif_horaria->ViewValue = FormatNumber($this->dif_horaria->ViewValue, 0, -2, -2, -2);
        $this->dif_horaria->ViewCustomAttributes = "";

        // id_inyect
        $this->id_inyect->LinkCustomAttributes = "";
        $this->id_inyect->HrefValue = "";
        $this->id_inyect->TooltipValue = "";

        // id_tarea
        $this->id_tarea->LinkCustomAttributes = "";
        $this->id_tarea->HrefValue = "";
        $this->id_tarea->TooltipValue = "";

        // titulo
        $this->titulo->LinkCustomAttributes = "";
        $this->titulo->HrefValue = "";
        if (!$this->isExport()) {
            $this->titulo->TooltipValue = strval($this->mensaje->CurrentValue);
            if ($this->titulo->HrefValue == "") {
                $this->titulo->HrefValue = "javascript:void(0);";
            }
            $this->titulo->LinkAttrs->appendClass("ew-tooltip-link");
            $this->titulo->LinkAttrs["data-tooltip-id"] = "tt_mensajes_x" . (($this->RowType != ROWTYPE_MASTER) ? @$this->RowCount : "") . "_titulo";
            $this->titulo->LinkAttrs["data-tooltip-width"] = $this->titulo->TooltipWidth;
            $this->titulo->LinkAttrs["data-placement"] = Config("CSS_FLIP") ? "left" : "right";
        }

        // mensaje
        $this->mensaje->LinkCustomAttributes = "";
        $this->mensaje->HrefValue = "";
        $this->mensaje->TooltipValue = "";

        // fechareal_start
        $this->fechareal_start->LinkCustomAttributes = "";
        $this->fechareal_start->HrefValue = "";
        $this->fechareal_start->TooltipValue = "";

        // fechasim_start
        $this->fechasim_start->LinkCustomAttributes = "";
        $this->fechasim_start->HrefValue = "";
        $this->fechasim_start->TooltipValue = "";

        // medios
        $this->medios->LinkCustomAttributes = "";
        $this->medios->HrefValue = "";
        $this->medios->TooltipValue = "";

        // actividad_esperada
        $this->actividad_esperada->LinkCustomAttributes = "";
        $this->actividad_esperada->HrefValue = "";
        $this->actividad_esperada->TooltipValue = "";

        // id_actor
        $this->id_actor->LinkCustomAttributes = "";
        $this->id_actor->HrefValue = "";
        $this->id_actor->TooltipValue = "";

        // enviado
        $this->enviado->LinkCustomAttributes = "";
        $this->enviado->HrefValue = "";
        $this->enviado->TooltipValue = "";

        // para
        $this->para->LinkCustomAttributes = "";
        $this->para->HrefValue = "";
        $this->para->TooltipValue = "";

        // adjunto
        $this->adjunto->LinkCustomAttributes = "";
        if (!EmptyValue($this->adjunto->CurrentValue)) {
            $this->adjunto->HrefValue = (!empty($this->adjunto->ViewValue) && !is_array($this->adjunto->ViewValue) ? RemoveHtml($this->adjunto->ViewValue) : $this->adjunto->CurrentValue); // Add prefix/suffix
            $this->adjunto->LinkAttrs["target"] = "_blank"; // Add target
            if ($this->isExport()) {
                $this->adjunto->HrefValue = FullUrl($this->adjunto->HrefValue, "href");
            }
        } else {
            $this->adjunto->HrefValue = "";
        }
        $this->adjunto->TooltipValue = "";

        // dif_horaria
        $this->dif_horaria->LinkCustomAttributes = "";
        $this->dif_horaria->HrefValue = "";
        $this->dif_horaria->TooltipValue = "";

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

        // id_inyect
        $this->id_inyect->EditAttrs["class"] = "form-control";
        $this->id_inyect->EditCustomAttributes = "";
        $this->id_inyect->EditValue = $this->id_inyect->CurrentValue;
        $this->id_inyect->ViewCustomAttributes = "";

        // id_tarea
        $this->id_tarea->EditAttrs["class"] = "form-control";
        $this->id_tarea->EditCustomAttributes = "";
        if ($this->id_tarea->getSessionValue() != "") {
            $this->id_tarea->CurrentValue = GetForeignKeyValue($this->id_tarea->getSessionValue());
            $curVal = trim(strval($this->id_tarea->CurrentValue));
            if ($curVal != "") {
                $this->id_tarea->ViewValue = $this->id_tarea->lookupCacheOption($curVal);
                if ($this->id_tarea->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_tarea`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->id_tarea->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->id_tarea->Lookup->renderViewRow($rswrk[0]);
                        $this->id_tarea->ViewValue = $this->id_tarea->displayValue($arwrk);
                    } else {
                        $this->id_tarea->ViewValue = $this->id_tarea->CurrentValue;
                    }
                }
            } else {
                $this->id_tarea->ViewValue = null;
            }
            $this->id_tarea->ViewCustomAttributes = "";
        } else {
            $this->id_tarea->PlaceHolder = RemoveHtml($this->id_tarea->caption());
        }

        // titulo
        $this->titulo->EditAttrs["class"] = "form-control";
        $this->titulo->EditCustomAttributes = "";
        if (!$this->titulo->Raw) {
            $this->titulo->CurrentValue = HtmlDecode($this->titulo->CurrentValue);
        }
        $this->titulo->EditValue = $this->titulo->CurrentValue;
        $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

        // mensaje
        $this->mensaje->EditAttrs["class"] = "form-control";
        $this->mensaje->EditCustomAttributes = "";
        $this->mensaje->EditValue = $this->mensaje->CurrentValue;
        $this->mensaje->PlaceHolder = RemoveHtml($this->mensaje->caption());

        // fechareal_start
        $this->fechareal_start->EditAttrs["class"] = "form-control";
        $this->fechareal_start->EditCustomAttributes = "";
        $this->fechareal_start->EditValue = FormatDateTime($this->fechareal_start->CurrentValue, 109);
        $this->fechareal_start->PlaceHolder = RemoveHtml($this->fechareal_start->caption());

        // fechasim_start
        $this->fechasim_start->EditAttrs["class"] = "form-control";
        $this->fechasim_start->EditCustomAttributes = "";
        $this->fechasim_start->EditValue = FormatDateTime($this->fechasim_start->CurrentValue, 109);
        $this->fechasim_start->PlaceHolder = RemoveHtml($this->fechasim_start->caption());

        // medios
        $this->medios->EditAttrs["class"] = "form-control";
        $this->medios->EditCustomAttributes = "";
        $this->medios->EditValue = $this->medios->options(true);
        $this->medios->PlaceHolder = RemoveHtml($this->medios->caption());

        // actividad_esperada
        $this->actividad_esperada->EditAttrs["class"] = "form-control";
        $this->actividad_esperada->EditCustomAttributes = "";
        $this->actividad_esperada->EditValue = $this->actividad_esperada->CurrentValue;
        $this->actividad_esperada->PlaceHolder = RemoveHtml($this->actividad_esperada->caption());

        // id_actor
        $this->id_actor->EditAttrs["class"] = "form-control";
        $this->id_actor->EditCustomAttributes = "";
        $this->id_actor->PlaceHolder = RemoveHtml($this->id_actor->caption());

        // enviado
        $this->enviado->EditAttrs["class"] = "form-control";
        $this->enviado->EditCustomAttributes = "";
        $this->enviado->EditValue = $this->enviado->CurrentValue;
        $this->enviado->PlaceHolder = RemoveHtml($this->enviado->caption());

        // para
        $this->para->EditAttrs["class"] = "form-control";
        $this->para->EditCustomAttributes = "";
        $this->para->PlaceHolder = RemoveHtml($this->para->caption());

        // adjunto
        $this->adjunto->EditAttrs["class"] = "form-control";
        $this->adjunto->EditCustomAttributes = "";
        $this->adjunto->PlaceHolder = RemoveHtml($this->adjunto->caption());

        // dif_horaria
        $this->dif_horaria->EditAttrs["class"] = "form-control";
        $this->dif_horaria->EditCustomAttributes = "";
        $this->dif_horaria->EditValue = $this->dif_horaria->CurrentValue;
        $this->dif_horaria->PlaceHolder = RemoveHtml($this->dif_horaria->caption());

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
                    $doc->exportCaption($this->titulo);
                    $doc->exportCaption($this->mensaje);
                    $doc->exportCaption($this->fechareal_start);
                    $doc->exportCaption($this->fechasim_start);
                    $doc->exportCaption($this->medios);
                    $doc->exportCaption($this->actividad_esperada);
                    $doc->exportCaption($this->id_actor);
                    $doc->exportCaption($this->para);
                    $doc->exportCaption($this->adjunto);
                } else {
                    $doc->exportCaption($this->id_inyect);
                    $doc->exportCaption($this->id_tarea);
                    $doc->exportCaption($this->titulo);
                    $doc->exportCaption($this->fechareal_start);
                    $doc->exportCaption($this->fechasim_start);
                    $doc->exportCaption($this->medios);
                    $doc->exportCaption($this->id_actor);
                    $doc->exportCaption($this->para);
                    $doc->exportCaption($this->adjunto);
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
                        $doc->exportField($this->titulo);
                        $doc->exportField($this->mensaje);
                        $doc->exportField($this->fechareal_start);
                        $doc->exportField($this->fechasim_start);
                        $doc->exportField($this->medios);
                        $doc->exportField($this->actividad_esperada);
                        $doc->exportField($this->id_actor);
                        $doc->exportField($this->para);
                        $doc->exportField($this->adjunto);
                    } else {
                        $doc->exportField($this->id_inyect);
                        $doc->exportField($this->id_tarea);
                        $doc->exportField($this->titulo);
                        $doc->exportField($this->fechareal_start);
                        $doc->exportField($this->fechasim_start);
                        $doc->exportField($this->medios);
                        $doc->exportField($this->id_actor);
                        $doc->exportField($this->para);
                        $doc->exportField($this->adjunto);
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
        $sql_utcx =  ExecuteRow("SELECT RIGHT(paisgmt.gmt,2)*1 AS minut,  MID(paisgmt.gmt,6,2)*1 AS horas, MID(paisgmt.gmt,5,1) as signo FROM escenario
    			INNER JOIN tareas 	ON escenario.id_escenario = tareas.id_escenario
    			INNER JOIN paisgmt ON escenario.pais_escenario = paisgmt.id_zone
    			WHERE tareas.id_tarea =".$rsnew["id_tarea"]);
    				$resultado = ($sql_utcx[2].($sql_utcx[1] * 60)+($sql_utcx[0]));
    				$rsnew["dif_horaria"] =  $resultado;  
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
       $tmp = $rsnew['para'];
            $tmp = explode(',', $tmp);
            if (sizeof($tmp) >= 1) {
                foreach ($tmp as &$valor) {
                    $tmp2 = explode('-', $valor);
                    $tipo = $tmp2[0];
                    $cod_tipo = $tmp2[1];
                    if ($cod_tipo <> '') {
                        if ($tipo == 'G') { //grupos 
                            $usuarios = ExecuteRows("SELECT id_users FROM users WHERE grupo = '" . $cod_tipo . "';");
                        } else if ($tipo == 'S') { //subgrupo
                            $usuarios = ExecuteRows("SELECT id_users FROM users WHERE subgrupo = '" . $cod_tipo . "';");
                        } else if ($tipo == 'P') {
                            $usuarios = $cod_tipo;
                           // $id_usuario = ExecuteRow("SELECT id_users FROM users WHERE grupo IN (SELECT grupo FROM users WHERE id_users = '" . CurrentUserID() . "') AND perfil = '2';");
                            $sql = Execute("INSERT INTO mensajes_usuarios (id_user_remitente, id_user_destinatario, id_mensaje, enviado) VALUES ('" . CurrentUserID() . "','" . $usuarios . "', '" . $rsnew['id_inyect'] . "','0');");
                            if ($rsnew['adjunto'] <> "") {
                            	$sql_doc = Execute("INSERT INTO permisos_doc (id_file, id_usuarios, tipo_permiso) VALUES ('" . $rsnew['adjunto'] . "','" . $usuarios . "','1');");
                            	$sql_doc_usrs = Execute("INSERT INTO permisos_docusers (id_file, tipo_permiso, id_users) VALUES ('" . $rsnew['adjunto'] . "','1','" . $usuarios . "');");
                            }
                        }
                        foreach ($usuarios as $row) {
                            $id_usuario = ExecuteRow("SELECT id_users FROM users WHERE grupo IN (SELECT grupo FROM users WHERE id_users = '" . CurrentUserID() . "') AND perfil = '2';");
                            $sql = Execute("INSERT INTO mensajes_usuarios (id_user_remitente, id_user_destinatario, id_mensaje, enviado) VALUES ('" . CurrentUserID() . "','" . $row['id_users'] . "', '" . $rsnew['id_inyect'] . "','0');");
                            if ($rsnew['adjunto'] <> "") {
                            	$sql_doc = Execute("INSERT INTO permisos_doc (id_file, id_usuarios, tipo_permiso) VALUES ('" . $rsnew['adjunto'] . "','" . $row['id_users'] . "','1');");
                            	$sql_doc_usrs = Execute("INSERT INTO permisos_docusers (id_file, tipo_permiso, id_users) VALUES ('" . $rsnew['adjunto'] . "','1','" . $row['id_users'] . "');");
                            }
                        }
                    }
                }
            };
        $evento = $rsnew['id_inyect'];
        $fechastar = $rsnew['fechareal_start'];
        $dif = $rsnew['dif_horaria'];
        $minprograma = 300 + $dif;
        $nuevafecha = strtotime ( "$minprograma minutes" , strtotime ($fechastar)) ;
        $fechaSalida 	= date ( 'Y-m-d H:i:s' , $nuevafecha );
         $dbconn = Db();
        $con = mysqli_connect($dbconn['host'],$dbconn['user'],$dbconn['password'],$dbconn['dbname']);
        $data = mysqli_query($con,"CREATE EVENT evento_$evento ON SCHEDULE AT '$fechaSalida'  DO BEGIN UPDATE `mensajes` SET enviado = 1 WHERE id_inyect = $evento; UPDATE `mensajes_usuarios` SET `enviado` = 1 WHERE mensajes_usuarios.id_mensaje = $evento; END");
        //$data = mysqli_query($con,"CREATE EVENT '" . $rsnew['id_inyect'] . "' ON SCHEDULE AT '" . $rsnew['fechareal_start'] . "' DO  UPDATE `mensajes` SET `enviado` = 1 WHERE TIMESTAMPDIFF(SECOND,TIMESTAMP(NOW()),'" . $rsnew['fechareal_start'] . "') = 1");
        mysqli_close($con);
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
        //var_dump(rsnew); die();
        $evento = $rsold['id_inyect'];
        $fechastar = $rsnew['fechareal_start'];
        $dif = $rsnew['dif_horaria'];
        $minprograma = 300 + $dif;
        $nuevafecha = strtotime ( "$minprograma minutes" , strtotime ($fechastar)) ;
        $fechaSalida 	= date ( 'Y-m-d H:i:s' , $nuevafecha );
        $dbconn = Db();
        $con = mysqli_connect($dbconn['host'],$dbconn['user'],$dbconn['password'],$dbconn['dbname']);
        $eliminar = mysqli_query($con,"DROP EVENT evento_$evento");
        $data = mysqli_query($con,"CREATE EVENT evento_$evento ON SCHEDULE AT '$fechaSalida'  DO UPDATE `mensajes` SET enviado = 1 WHERE id_inyect = $evento;");
        //$data = mysqli_query($con,"CREATE EVENT '" . $rsnew['id_inyect'] . "' ON SCHEDULE AT '" . $rsnew['fechareal_start'] . "' DO  UPDATE `mensajes` SET `enviado` = 1 WHERE TIMESTAMPDIFF(SECOND,TIMESTAMP(NOW()),'" . $rsnew['fechareal_start'] . "') = 1");
        mysqli_close($con);
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
       $evento = $rs['id_inyect'];
        $dbconn = Db();
        $con = mysqli_connect($dbconn['host'],$dbconn['user'],$dbconn['password'],$dbconn['dbname']);
        $eliminar = mysqli_query($con,"DROP EVENT evento_$evento");
        mysqli_close($con);
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
