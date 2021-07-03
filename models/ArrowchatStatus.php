<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for arrowchat_status
 */
class ArrowchatStatus extends DbTable
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
    public $_userid;
    public $guest_name;
    public $message;
    public $status;
    public $theme;
    public $popout;
    public $typing;
    public $hide_bar;
    public $play_sound;
    public $window_open;
    public $only_names;
    public $chatroom_window;
    public $chatroom_stay;
    public $chatroom_unfocus;
    public $chatroom_show_names;
    public $chatroom_block_chats;
    public $chatroom_sound;
    public $announcement;
    public $unfocus_chat;
    public $focus_chat;
    public $last_message;
    public $clear_chats;
    public $apps_bookmarks;
    public $apps_other;
    public $apps_open;
    public $apps_load;
    public $block_chats;
    public $session_time;
    public $is_admin;
    public $is_mod;
    public $hash_id;
    public $ip_address;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'arrowchat_status';
        $this->TableName = 'arrowchat_status';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`arrowchat_status`";
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

        // userid
        $this->_userid = new DbField('arrowchat_status', 'arrowchat_status', 'x__userid', 'userid', '`userid`', '`userid`', 200, 25, -1, false, '`userid`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_userid->IsPrimaryKey = true; // Primary key field
        $this->_userid->Nullable = false; // NOT NULL field
        $this->_userid->Required = true; // Required field
        $this->_userid->Sortable = true; // Allow sort
        $this->_userid->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_userid->Param, "CustomMsg");
        $this->Fields['userid'] = &$this->_userid;

        // guest_name
        $this->guest_name = new DbField('arrowchat_status', 'arrowchat_status', 'x_guest_name', 'guest_name', '`guest_name`', '`guest_name`', 200, 50, -1, false, '`guest_name`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->guest_name->Sortable = true; // Allow sort
        $this->guest_name->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->guest_name->Param, "CustomMsg");
        $this->Fields['guest_name'] = &$this->guest_name;

        // message
        $this->message = new DbField('arrowchat_status', 'arrowchat_status', 'x_message', 'message', '`message`', '`message`', 201, 65535, -1, false, '`message`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->message->Sortable = true; // Allow sort
        $this->message->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->message->Param, "CustomMsg");
        $this->Fields['message'] = &$this->message;

        // status
        $this->status = new DbField('arrowchat_status', 'arrowchat_status', 'x_status', 'status', '`status`', '`status`', 200, 10, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status->Sortable = true; // Allow sort
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // theme
        $this->theme = new DbField('arrowchat_status', 'arrowchat_status', 'x_theme', 'theme', '`theme`', '`theme`', 19, 3, -1, false, '`theme`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->theme->Sortable = true; // Allow sort
        $this->theme->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->theme->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->theme->Param, "CustomMsg");
        $this->Fields['theme'] = &$this->theme;

        // popout
        $this->popout = new DbField('arrowchat_status', 'arrowchat_status', 'x_popout', 'popout', '`popout`', '`popout`', 19, 11, -1, false, '`popout`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->popout->Sortable = true; // Allow sort
        $this->popout->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->popout->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->popout->Param, "CustomMsg");
        $this->Fields['popout'] = &$this->popout;

        // typing
        $this->typing = new DbField('arrowchat_status', 'arrowchat_status', 'x_typing', 'typing', '`typing`', '`typing`', 201, 65535, -1, false, '`typing`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->typing->Sortable = true; // Allow sort
        $this->typing->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->typing->Param, "CustomMsg");
        $this->Fields['typing'] = &$this->typing;

        // hide_bar
        $this->hide_bar = new DbField('arrowchat_status', 'arrowchat_status', 'x_hide_bar', 'hide_bar', '`hide_bar`', '`hide_bar`', 17, 1, -1, false, '`hide_bar`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->hide_bar->Sortable = true; // Allow sort
        $this->hide_bar->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->hide_bar->Lookup = new Lookup('hide_bar', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->hide_bar->Lookup = new Lookup('hide_bar', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->hide_bar->Lookup = new Lookup('hide_bar', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->hide_bar->OptionCount = 2;
        $this->hide_bar->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->hide_bar->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hide_bar->Param, "CustomMsg");
        $this->Fields['hide_bar'] = &$this->hide_bar;

        // play_sound
        $this->play_sound = new DbField('arrowchat_status', 'arrowchat_status', 'x_play_sound', 'play_sound', '`play_sound`', '`play_sound`', 17, 1, -1, false, '`play_sound`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->play_sound->Sortable = true; // Allow sort
        $this->play_sound->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->play_sound->Lookup = new Lookup('play_sound', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->play_sound->Lookup = new Lookup('play_sound', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->play_sound->Lookup = new Lookup('play_sound', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->play_sound->OptionCount = 2;
        $this->play_sound->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->play_sound->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->play_sound->Param, "CustomMsg");
        $this->Fields['play_sound'] = &$this->play_sound;

        // window_open
        $this->window_open = new DbField('arrowchat_status', 'arrowchat_status', 'x_window_open', 'window_open', '`window_open`', '`window_open`', 17, 1, -1, false, '`window_open`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->window_open->Sortable = true; // Allow sort
        $this->window_open->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->window_open->Lookup = new Lookup('window_open', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->window_open->Lookup = new Lookup('window_open', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->window_open->Lookup = new Lookup('window_open', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->window_open->OptionCount = 2;
        $this->window_open->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->window_open->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->window_open->Param, "CustomMsg");
        $this->Fields['window_open'] = &$this->window_open;

        // only_names
        $this->only_names = new DbField('arrowchat_status', 'arrowchat_status', 'x_only_names', 'only_names', '`only_names`', '`only_names`', 17, 1, -1, false, '`only_names`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->only_names->Sortable = true; // Allow sort
        $this->only_names->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->only_names->Lookup = new Lookup('only_names', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->only_names->Lookup = new Lookup('only_names', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->only_names->Lookup = new Lookup('only_names', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->only_names->OptionCount = 2;
        $this->only_names->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->only_names->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->only_names->Param, "CustomMsg");
        $this->Fields['only_names'] = &$this->only_names;

        // chatroom_window
        $this->chatroom_window = new DbField('arrowchat_status', 'arrowchat_status', 'x_chatroom_window', 'chatroom_window', '`chatroom_window`', '`chatroom_window`', 200, 6, -1, false, '`chatroom_window`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->chatroom_window->Nullable = false; // NOT NULL field
        $this->chatroom_window->Sortable = true; // Allow sort
        $this->chatroom_window->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->chatroom_window->Param, "CustomMsg");
        $this->Fields['chatroom_window'] = &$this->chatroom_window;

        // chatroom_stay
        $this->chatroom_stay = new DbField('arrowchat_status', 'arrowchat_status', 'x_chatroom_stay', 'chatroom_stay', '`chatroom_stay`', '`chatroom_stay`', 200, 6, -1, false, '`chatroom_stay`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->chatroom_stay->Nullable = false; // NOT NULL field
        $this->chatroom_stay->Sortable = true; // Allow sort
        $this->chatroom_stay->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->chatroom_stay->Param, "CustomMsg");
        $this->Fields['chatroom_stay'] = &$this->chatroom_stay;

        // chatroom_unfocus
        $this->chatroom_unfocus = new DbField('arrowchat_status', 'arrowchat_status', 'x_chatroom_unfocus', 'chatroom_unfocus', '`chatroom_unfocus`', '`chatroom_unfocus`', 201, 65535, -1, false, '`chatroom_unfocus`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->chatroom_unfocus->Sortable = true; // Allow sort
        $this->chatroom_unfocus->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->chatroom_unfocus->Param, "CustomMsg");
        $this->Fields['chatroom_unfocus'] = &$this->chatroom_unfocus;

        // chatroom_show_names
        $this->chatroom_show_names = new DbField('arrowchat_status', 'arrowchat_status', 'x_chatroom_show_names', 'chatroom_show_names', '`chatroom_show_names`', '`chatroom_show_names`', 17, 1, -1, false, '`chatroom_show_names`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->chatroom_show_names->Sortable = true; // Allow sort
        $this->chatroom_show_names->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->chatroom_show_names->Lookup = new Lookup('chatroom_show_names', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->chatroom_show_names->Lookup = new Lookup('chatroom_show_names', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->chatroom_show_names->Lookup = new Lookup('chatroom_show_names', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->chatroom_show_names->OptionCount = 2;
        $this->chatroom_show_names->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->chatroom_show_names->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->chatroom_show_names->Param, "CustomMsg");
        $this->Fields['chatroom_show_names'] = &$this->chatroom_show_names;

        // chatroom_block_chats
        $this->chatroom_block_chats = new DbField('arrowchat_status', 'arrowchat_status', 'x_chatroom_block_chats', 'chatroom_block_chats', '`chatroom_block_chats`', '`chatroom_block_chats`', 17, 1, -1, false, '`chatroom_block_chats`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->chatroom_block_chats->Sortable = true; // Allow sort
        $this->chatroom_block_chats->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->chatroom_block_chats->Lookup = new Lookup('chatroom_block_chats', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->chatroom_block_chats->Lookup = new Lookup('chatroom_block_chats', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->chatroom_block_chats->Lookup = new Lookup('chatroom_block_chats', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->chatroom_block_chats->OptionCount = 2;
        $this->chatroom_block_chats->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->chatroom_block_chats->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->chatroom_block_chats->Param, "CustomMsg");
        $this->Fields['chatroom_block_chats'] = &$this->chatroom_block_chats;

        // chatroom_sound
        $this->chatroom_sound = new DbField('arrowchat_status', 'arrowchat_status', 'x_chatroom_sound', 'chatroom_sound', '`chatroom_sound`', '`chatroom_sound`', 17, 1, -1, false, '`chatroom_sound`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->chatroom_sound->Sortable = true; // Allow sort
        $this->chatroom_sound->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->chatroom_sound->Lookup = new Lookup('chatroom_sound', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->chatroom_sound->Lookup = new Lookup('chatroom_sound', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->chatroom_sound->Lookup = new Lookup('chatroom_sound', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->chatroom_sound->OptionCount = 2;
        $this->chatroom_sound->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->chatroom_sound->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->chatroom_sound->Param, "CustomMsg");
        $this->Fields['chatroom_sound'] = &$this->chatroom_sound;

        // announcement
        $this->announcement = new DbField('arrowchat_status', 'arrowchat_status', 'x_announcement', 'announcement', '`announcement`', '`announcement`', 17, 1, -1, false, '`announcement`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->announcement->Nullable = false; // NOT NULL field
        $this->announcement->Sortable = true; // Allow sort
        $this->announcement->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->announcement->Lookup = new Lookup('announcement', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->announcement->Lookup = new Lookup('announcement', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->announcement->Lookup = new Lookup('announcement', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->announcement->OptionCount = 2;
        $this->announcement->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->announcement->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->announcement->Param, "CustomMsg");
        $this->Fields['announcement'] = &$this->announcement;

        // unfocus_chat
        $this->unfocus_chat = new DbField('arrowchat_status', 'arrowchat_status', 'x_unfocus_chat', 'unfocus_chat', '`unfocus_chat`', '`unfocus_chat`', 201, 65535, -1, false, '`unfocus_chat`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->unfocus_chat->Sortable = true; // Allow sort
        $this->unfocus_chat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->unfocus_chat->Param, "CustomMsg");
        $this->Fields['unfocus_chat'] = &$this->unfocus_chat;

        // focus_chat
        $this->focus_chat = new DbField('arrowchat_status', 'arrowchat_status', 'x_focus_chat', 'focus_chat', '`focus_chat`', '`focus_chat`', 200, 50, -1, false, '`focus_chat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->focus_chat->Sortable = true; // Allow sort
        $this->focus_chat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->focus_chat->Param, "CustomMsg");
        $this->Fields['focus_chat'] = &$this->focus_chat;

        // last_message
        $this->last_message = new DbField('arrowchat_status', 'arrowchat_status', 'x_last_message', 'last_message', '`last_message`', '`last_message`', 201, 65535, -1, false, '`last_message`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->last_message->Sortable = true; // Allow sort
        $this->last_message->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->last_message->Param, "CustomMsg");
        $this->Fields['last_message'] = &$this->last_message;

        // clear_chats
        $this->clear_chats = new DbField('arrowchat_status', 'arrowchat_status', 'x_clear_chats', 'clear_chats', '`clear_chats`', '`clear_chats`', 201, 65535, -1, false, '`clear_chats`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->clear_chats->Sortable = true; // Allow sort
        $this->clear_chats->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->clear_chats->Param, "CustomMsg");
        $this->Fields['clear_chats'] = &$this->clear_chats;

        // apps_bookmarks
        $this->apps_bookmarks = new DbField('arrowchat_status', 'arrowchat_status', 'x_apps_bookmarks', 'apps_bookmarks', '`apps_bookmarks`', '`apps_bookmarks`', 201, 65535, -1, false, '`apps_bookmarks`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->apps_bookmarks->Sortable = true; // Allow sort
        $this->apps_bookmarks->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->apps_bookmarks->Param, "CustomMsg");
        $this->Fields['apps_bookmarks'] = &$this->apps_bookmarks;

        // apps_other
        $this->apps_other = new DbField('arrowchat_status', 'arrowchat_status', 'x_apps_other', 'apps_other', '`apps_other`', '`apps_other`', 201, 65535, -1, false, '`apps_other`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->apps_other->Sortable = true; // Allow sort
        $this->apps_other->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->apps_other->Param, "CustomMsg");
        $this->Fields['apps_other'] = &$this->apps_other;

        // apps_open
        $this->apps_open = new DbField('arrowchat_status', 'arrowchat_status', 'x_apps_open', 'apps_open', '`apps_open`', '`apps_open`', 19, 10, -1, false, '`apps_open`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->apps_open->Sortable = true; // Allow sort
        $this->apps_open->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->apps_open->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->apps_open->Param, "CustomMsg");
        $this->Fields['apps_open'] = &$this->apps_open;

        // apps_load
        $this->apps_load = new DbField('arrowchat_status', 'arrowchat_status', 'x_apps_load', 'apps_load', '`apps_load`', '`apps_load`', 201, 65535, -1, false, '`apps_load`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->apps_load->Sortable = true; // Allow sort
        $this->apps_load->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->apps_load->Param, "CustomMsg");
        $this->Fields['apps_load'] = &$this->apps_load;

        // block_chats
        $this->block_chats = new DbField('arrowchat_status', 'arrowchat_status', 'x_block_chats', 'block_chats', '`block_chats`', '`block_chats`', 201, 65535, -1, false, '`block_chats`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->block_chats->Sortable = true; // Allow sort
        $this->block_chats->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->block_chats->Param, "CustomMsg");
        $this->Fields['block_chats'] = &$this->block_chats;

        // session_time
        $this->session_time = new DbField('arrowchat_status', 'arrowchat_status', 'x_session_time', 'session_time', '`session_time`', '`session_time`', 19, 20, -1, false, '`session_time`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->session_time->Nullable = false; // NOT NULL field
        $this->session_time->Sortable = true; // Allow sort
        $this->session_time->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->session_time->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->session_time->Param, "CustomMsg");
        $this->Fields['session_time'] = &$this->session_time;

        // is_admin
        $this->is_admin = new DbField('arrowchat_status', 'arrowchat_status', 'x_is_admin', 'is_admin', '`is_admin`', '`is_admin`', 17, 1, -1, false, '`is_admin`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->is_admin->Nullable = false; // NOT NULL field
        $this->is_admin->Sortable = true; // Allow sort
        $this->is_admin->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->is_admin->Lookup = new Lookup('is_admin', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->is_admin->Lookup = new Lookup('is_admin', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->is_admin->Lookup = new Lookup('is_admin', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->is_admin->OptionCount = 2;
        $this->is_admin->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->is_admin->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->is_admin->Param, "CustomMsg");
        $this->Fields['is_admin'] = &$this->is_admin;

        // is_mod
        $this->is_mod = new DbField('arrowchat_status', 'arrowchat_status', 'x_is_mod', 'is_mod', '`is_mod`', '`is_mod`', 17, 1, -1, false, '`is_mod`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->is_mod->Nullable = false; // NOT NULL field
        $this->is_mod->Sortable = true; // Allow sort
        $this->is_mod->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->is_mod->Lookup = new Lookup('is_mod', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->is_mod->Lookup = new Lookup('is_mod', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->is_mod->Lookup = new Lookup('is_mod', 'arrowchat_status', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->is_mod->OptionCount = 2;
        $this->is_mod->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->is_mod->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->is_mod->Param, "CustomMsg");
        $this->Fields['is_mod'] = &$this->is_mod;

        // hash_id
        $this->hash_id = new DbField('arrowchat_status', 'arrowchat_status', 'x_hash_id', 'hash_id', '`hash_id`', '`hash_id`', 200, 20, -1, false, '`hash_id`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hash_id->Nullable = false; // NOT NULL field
        $this->hash_id->Sortable = true; // Allow sort
        $this->hash_id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hash_id->Param, "CustomMsg");
        $this->Fields['hash_id'] = &$this->hash_id;

        // ip_address
        $this->ip_address = new DbField('arrowchat_status', 'arrowchat_status', 'x_ip_address', 'ip_address', '`ip_address`', '`ip_address`', 200, 40, -1, false, '`ip_address`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ip_address->Sortable = true; // Allow sort
        $this->ip_address->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ip_address->Param, "CustomMsg");
        $this->Fields['ip_address'] = &$this->ip_address;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`arrowchat_status`";
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
            if (array_key_exists('userid', $rs)) {
                AddFilter($where, QuotedName('userid', $this->Dbid) . '=' . QuotedValue($rs['userid'], $this->_userid->DataType, $this->Dbid));
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
        $this->_userid->DbValue = $row['userid'];
        $this->guest_name->DbValue = $row['guest_name'];
        $this->message->DbValue = $row['message'];
        $this->status->DbValue = $row['status'];
        $this->theme->DbValue = $row['theme'];
        $this->popout->DbValue = $row['popout'];
        $this->typing->DbValue = $row['typing'];
        $this->hide_bar->DbValue = $row['hide_bar'];
        $this->play_sound->DbValue = $row['play_sound'];
        $this->window_open->DbValue = $row['window_open'];
        $this->only_names->DbValue = $row['only_names'];
        $this->chatroom_window->DbValue = $row['chatroom_window'];
        $this->chatroom_stay->DbValue = $row['chatroom_stay'];
        $this->chatroom_unfocus->DbValue = $row['chatroom_unfocus'];
        $this->chatroom_show_names->DbValue = $row['chatroom_show_names'];
        $this->chatroom_block_chats->DbValue = $row['chatroom_block_chats'];
        $this->chatroom_sound->DbValue = $row['chatroom_sound'];
        $this->announcement->DbValue = $row['announcement'];
        $this->unfocus_chat->DbValue = $row['unfocus_chat'];
        $this->focus_chat->DbValue = $row['focus_chat'];
        $this->last_message->DbValue = $row['last_message'];
        $this->clear_chats->DbValue = $row['clear_chats'];
        $this->apps_bookmarks->DbValue = $row['apps_bookmarks'];
        $this->apps_other->DbValue = $row['apps_other'];
        $this->apps_open->DbValue = $row['apps_open'];
        $this->apps_load->DbValue = $row['apps_load'];
        $this->block_chats->DbValue = $row['block_chats'];
        $this->session_time->DbValue = $row['session_time'];
        $this->is_admin->DbValue = $row['is_admin'];
        $this->is_mod->DbValue = $row['is_mod'];
        $this->hash_id->DbValue = $row['hash_id'];
        $this->ip_address->DbValue = $row['ip_address'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`userid` = '@_userid@'";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->_userid->CurrentValue : $this->_userid->OldValue;
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
                $this->_userid->CurrentValue = $keys[0];
            } else {
                $this->_userid->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('userid', $row) ? $row['userid'] : null;
        } else {
            $val = $this->_userid->OldValue !== null ? $this->_userid->OldValue : $this->_userid->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@_userid@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ArrowchatStatusList");
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
        if ($pageName == "ArrowchatStatusView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ArrowchatStatusEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ArrowchatStatusAdd") {
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
                return "ArrowchatStatusView";
            case Config("API_ADD_ACTION"):
                return "ArrowchatStatusAdd";
            case Config("API_EDIT_ACTION"):
                return "ArrowchatStatusEdit";
            case Config("API_DELETE_ACTION"):
                return "ArrowchatStatusDelete";
            case Config("API_LIST_ACTION"):
                return "ArrowchatStatusList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ArrowchatStatusList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ArrowchatStatusView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ArrowchatStatusView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ArrowchatStatusAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ArrowchatStatusAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ArrowchatStatusEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("ArrowchatStatusAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("ArrowchatStatusDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "_userid:" . JsonEncode($this->_userid->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->_userid->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->_userid->CurrentValue);
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
            if (($keyValue = Param("_userid") ?? Route("_userid")) !== null) {
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
                $this->_userid->CurrentValue = $key;
            } else {
                $this->_userid->OldValue = $key;
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // userid
        $this->_userid->ViewValue = $this->_userid->CurrentValue;
        $this->_userid->ViewCustomAttributes = "";

        // guest_name
        $this->guest_name->ViewValue = $this->guest_name->CurrentValue;
        $this->guest_name->ViewCustomAttributes = "";

        // message
        $this->message->ViewValue = $this->message->CurrentValue;
        $this->message->ViewCustomAttributes = "";

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

        // typing
        $this->typing->ViewValue = $this->typing->CurrentValue;
        $this->typing->ViewCustomAttributes = "";

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

        // chatroom_unfocus
        $this->chatroom_unfocus->ViewValue = $this->chatroom_unfocus->CurrentValue;
        $this->chatroom_unfocus->ViewCustomAttributes = "";

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

        // unfocus_chat
        $this->unfocus_chat->ViewValue = $this->unfocus_chat->CurrentValue;
        $this->unfocus_chat->ViewCustomAttributes = "";

        // focus_chat
        $this->focus_chat->ViewValue = $this->focus_chat->CurrentValue;
        $this->focus_chat->ViewCustomAttributes = "";

        // last_message
        $this->last_message->ViewValue = $this->last_message->CurrentValue;
        $this->last_message->ViewCustomAttributes = "";

        // clear_chats
        $this->clear_chats->ViewValue = $this->clear_chats->CurrentValue;
        $this->clear_chats->ViewCustomAttributes = "";

        // apps_bookmarks
        $this->apps_bookmarks->ViewValue = $this->apps_bookmarks->CurrentValue;
        $this->apps_bookmarks->ViewCustomAttributes = "";

        // apps_other
        $this->apps_other->ViewValue = $this->apps_other->CurrentValue;
        $this->apps_other->ViewCustomAttributes = "";

        // apps_open
        $this->apps_open->ViewValue = $this->apps_open->CurrentValue;
        $this->apps_open->ViewValue = FormatNumber($this->apps_open->ViewValue, 0, -2, -2, -2);
        $this->apps_open->ViewCustomAttributes = "";

        // apps_load
        $this->apps_load->ViewValue = $this->apps_load->CurrentValue;
        $this->apps_load->ViewCustomAttributes = "";

        // block_chats
        $this->block_chats->ViewValue = $this->block_chats->CurrentValue;
        $this->block_chats->ViewCustomAttributes = "";

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

        // message
        $this->message->LinkCustomAttributes = "";
        $this->message->HrefValue = "";
        $this->message->TooltipValue = "";

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

        // typing
        $this->typing->LinkCustomAttributes = "";
        $this->typing->HrefValue = "";
        $this->typing->TooltipValue = "";

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

        // chatroom_unfocus
        $this->chatroom_unfocus->LinkCustomAttributes = "";
        $this->chatroom_unfocus->HrefValue = "";
        $this->chatroom_unfocus->TooltipValue = "";

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

        // unfocus_chat
        $this->unfocus_chat->LinkCustomAttributes = "";
        $this->unfocus_chat->HrefValue = "";
        $this->unfocus_chat->TooltipValue = "";

        // focus_chat
        $this->focus_chat->LinkCustomAttributes = "";
        $this->focus_chat->HrefValue = "";
        $this->focus_chat->TooltipValue = "";

        // last_message
        $this->last_message->LinkCustomAttributes = "";
        $this->last_message->HrefValue = "";
        $this->last_message->TooltipValue = "";

        // clear_chats
        $this->clear_chats->LinkCustomAttributes = "";
        $this->clear_chats->HrefValue = "";
        $this->clear_chats->TooltipValue = "";

        // apps_bookmarks
        $this->apps_bookmarks->LinkCustomAttributes = "";
        $this->apps_bookmarks->HrefValue = "";
        $this->apps_bookmarks->TooltipValue = "";

        // apps_other
        $this->apps_other->LinkCustomAttributes = "";
        $this->apps_other->HrefValue = "";
        $this->apps_other->TooltipValue = "";

        // apps_open
        $this->apps_open->LinkCustomAttributes = "";
        $this->apps_open->HrefValue = "";
        $this->apps_open->TooltipValue = "";

        // apps_load
        $this->apps_load->LinkCustomAttributes = "";
        $this->apps_load->HrefValue = "";
        $this->apps_load->TooltipValue = "";

        // block_chats
        $this->block_chats->LinkCustomAttributes = "";
        $this->block_chats->HrefValue = "";
        $this->block_chats->TooltipValue = "";

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

        // userid
        $this->_userid->EditAttrs["class"] = "form-control";
        $this->_userid->EditCustomAttributes = "";
        if (!$this->_userid->Raw) {
            $this->_userid->CurrentValue = HtmlDecode($this->_userid->CurrentValue);
        }
        $this->_userid->EditValue = $this->_userid->CurrentValue;
        $this->_userid->PlaceHolder = RemoveHtml($this->_userid->caption());

        // guest_name
        $this->guest_name->EditAttrs["class"] = "form-control";
        $this->guest_name->EditCustomAttributes = "";
        if (!$this->guest_name->Raw) {
            $this->guest_name->CurrentValue = HtmlDecode($this->guest_name->CurrentValue);
        }
        $this->guest_name->EditValue = $this->guest_name->CurrentValue;
        $this->guest_name->PlaceHolder = RemoveHtml($this->guest_name->caption());

        // message
        $this->message->EditAttrs["class"] = "form-control";
        $this->message->EditCustomAttributes = "";
        $this->message->EditValue = $this->message->CurrentValue;
        $this->message->PlaceHolder = RemoveHtml($this->message->caption());

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // theme
        $this->theme->EditAttrs["class"] = "form-control";
        $this->theme->EditCustomAttributes = "";
        $this->theme->EditValue = $this->theme->CurrentValue;
        $this->theme->PlaceHolder = RemoveHtml($this->theme->caption());

        // popout
        $this->popout->EditAttrs["class"] = "form-control";
        $this->popout->EditCustomAttributes = "";
        $this->popout->EditValue = $this->popout->CurrentValue;
        $this->popout->PlaceHolder = RemoveHtml($this->popout->caption());

        // typing
        $this->typing->EditAttrs["class"] = "form-control";
        $this->typing->EditCustomAttributes = "";
        $this->typing->EditValue = $this->typing->CurrentValue;
        $this->typing->PlaceHolder = RemoveHtml($this->typing->caption());

        // hide_bar
        $this->hide_bar->EditCustomAttributes = "";
        $this->hide_bar->EditValue = $this->hide_bar->options(false);
        $this->hide_bar->PlaceHolder = RemoveHtml($this->hide_bar->caption());

        // play_sound
        $this->play_sound->EditCustomAttributes = "";
        $this->play_sound->EditValue = $this->play_sound->options(false);
        $this->play_sound->PlaceHolder = RemoveHtml($this->play_sound->caption());

        // window_open
        $this->window_open->EditCustomAttributes = "";
        $this->window_open->EditValue = $this->window_open->options(false);
        $this->window_open->PlaceHolder = RemoveHtml($this->window_open->caption());

        // only_names
        $this->only_names->EditCustomAttributes = "";
        $this->only_names->EditValue = $this->only_names->options(false);
        $this->only_names->PlaceHolder = RemoveHtml($this->only_names->caption());

        // chatroom_window
        $this->chatroom_window->EditAttrs["class"] = "form-control";
        $this->chatroom_window->EditCustomAttributes = "";
        if (!$this->chatroom_window->Raw) {
            $this->chatroom_window->CurrentValue = HtmlDecode($this->chatroom_window->CurrentValue);
        }
        $this->chatroom_window->EditValue = $this->chatroom_window->CurrentValue;
        $this->chatroom_window->PlaceHolder = RemoveHtml($this->chatroom_window->caption());

        // chatroom_stay
        $this->chatroom_stay->EditAttrs["class"] = "form-control";
        $this->chatroom_stay->EditCustomAttributes = "";
        if (!$this->chatroom_stay->Raw) {
            $this->chatroom_stay->CurrentValue = HtmlDecode($this->chatroom_stay->CurrentValue);
        }
        $this->chatroom_stay->EditValue = $this->chatroom_stay->CurrentValue;
        $this->chatroom_stay->PlaceHolder = RemoveHtml($this->chatroom_stay->caption());

        // chatroom_unfocus
        $this->chatroom_unfocus->EditAttrs["class"] = "form-control";
        $this->chatroom_unfocus->EditCustomAttributes = "";
        $this->chatroom_unfocus->EditValue = $this->chatroom_unfocus->CurrentValue;
        $this->chatroom_unfocus->PlaceHolder = RemoveHtml($this->chatroom_unfocus->caption());

        // chatroom_show_names
        $this->chatroom_show_names->EditCustomAttributes = "";
        $this->chatroom_show_names->EditValue = $this->chatroom_show_names->options(false);
        $this->chatroom_show_names->PlaceHolder = RemoveHtml($this->chatroom_show_names->caption());

        // chatroom_block_chats
        $this->chatroom_block_chats->EditCustomAttributes = "";
        $this->chatroom_block_chats->EditValue = $this->chatroom_block_chats->options(false);
        $this->chatroom_block_chats->PlaceHolder = RemoveHtml($this->chatroom_block_chats->caption());

        // chatroom_sound
        $this->chatroom_sound->EditCustomAttributes = "";
        $this->chatroom_sound->EditValue = $this->chatroom_sound->options(false);
        $this->chatroom_sound->PlaceHolder = RemoveHtml($this->chatroom_sound->caption());

        // announcement
        $this->announcement->EditCustomAttributes = "";
        $this->announcement->EditValue = $this->announcement->options(false);
        $this->announcement->PlaceHolder = RemoveHtml($this->announcement->caption());

        // unfocus_chat
        $this->unfocus_chat->EditAttrs["class"] = "form-control";
        $this->unfocus_chat->EditCustomAttributes = "";
        $this->unfocus_chat->EditValue = $this->unfocus_chat->CurrentValue;
        $this->unfocus_chat->PlaceHolder = RemoveHtml($this->unfocus_chat->caption());

        // focus_chat
        $this->focus_chat->EditAttrs["class"] = "form-control";
        $this->focus_chat->EditCustomAttributes = "";
        if (!$this->focus_chat->Raw) {
            $this->focus_chat->CurrentValue = HtmlDecode($this->focus_chat->CurrentValue);
        }
        $this->focus_chat->EditValue = $this->focus_chat->CurrentValue;
        $this->focus_chat->PlaceHolder = RemoveHtml($this->focus_chat->caption());

        // last_message
        $this->last_message->EditAttrs["class"] = "form-control";
        $this->last_message->EditCustomAttributes = "";
        $this->last_message->EditValue = $this->last_message->CurrentValue;
        $this->last_message->PlaceHolder = RemoveHtml($this->last_message->caption());

        // clear_chats
        $this->clear_chats->EditAttrs["class"] = "form-control";
        $this->clear_chats->EditCustomAttributes = "";
        $this->clear_chats->EditValue = $this->clear_chats->CurrentValue;
        $this->clear_chats->PlaceHolder = RemoveHtml($this->clear_chats->caption());

        // apps_bookmarks
        $this->apps_bookmarks->EditAttrs["class"] = "form-control";
        $this->apps_bookmarks->EditCustomAttributes = "";
        $this->apps_bookmarks->EditValue = $this->apps_bookmarks->CurrentValue;
        $this->apps_bookmarks->PlaceHolder = RemoveHtml($this->apps_bookmarks->caption());

        // apps_other
        $this->apps_other->EditAttrs["class"] = "form-control";
        $this->apps_other->EditCustomAttributes = "";
        $this->apps_other->EditValue = $this->apps_other->CurrentValue;
        $this->apps_other->PlaceHolder = RemoveHtml($this->apps_other->caption());

        // apps_open
        $this->apps_open->EditAttrs["class"] = "form-control";
        $this->apps_open->EditCustomAttributes = "";
        $this->apps_open->EditValue = $this->apps_open->CurrentValue;
        $this->apps_open->PlaceHolder = RemoveHtml($this->apps_open->caption());

        // apps_load
        $this->apps_load->EditAttrs["class"] = "form-control";
        $this->apps_load->EditCustomAttributes = "";
        $this->apps_load->EditValue = $this->apps_load->CurrentValue;
        $this->apps_load->PlaceHolder = RemoveHtml($this->apps_load->caption());

        // block_chats
        $this->block_chats->EditAttrs["class"] = "form-control";
        $this->block_chats->EditCustomAttributes = "";
        $this->block_chats->EditValue = $this->block_chats->CurrentValue;
        $this->block_chats->PlaceHolder = RemoveHtml($this->block_chats->caption());

        // session_time
        $this->session_time->EditAttrs["class"] = "form-control";
        $this->session_time->EditCustomAttributes = "";
        $this->session_time->EditValue = $this->session_time->CurrentValue;
        $this->session_time->PlaceHolder = RemoveHtml($this->session_time->caption());

        // is_admin
        $this->is_admin->EditCustomAttributes = "";
        $this->is_admin->EditValue = $this->is_admin->options(false);
        $this->is_admin->PlaceHolder = RemoveHtml($this->is_admin->caption());

        // is_mod
        $this->is_mod->EditCustomAttributes = "";
        $this->is_mod->EditValue = $this->is_mod->options(false);
        $this->is_mod->PlaceHolder = RemoveHtml($this->is_mod->caption());

        // hash_id
        $this->hash_id->EditAttrs["class"] = "form-control";
        $this->hash_id->EditCustomAttributes = "";
        if (!$this->hash_id->Raw) {
            $this->hash_id->CurrentValue = HtmlDecode($this->hash_id->CurrentValue);
        }
        $this->hash_id->EditValue = $this->hash_id->CurrentValue;
        $this->hash_id->PlaceHolder = RemoveHtml($this->hash_id->caption());

        // ip_address
        $this->ip_address->EditAttrs["class"] = "form-control";
        $this->ip_address->EditCustomAttributes = "";
        if (!$this->ip_address->Raw) {
            $this->ip_address->CurrentValue = HtmlDecode($this->ip_address->CurrentValue);
        }
        $this->ip_address->EditValue = $this->ip_address->CurrentValue;
        $this->ip_address->PlaceHolder = RemoveHtml($this->ip_address->caption());

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
                    $doc->exportCaption($this->_userid);
                    $doc->exportCaption($this->guest_name);
                    $doc->exportCaption($this->message);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->theme);
                    $doc->exportCaption($this->popout);
                    $doc->exportCaption($this->typing);
                    $doc->exportCaption($this->hide_bar);
                    $doc->exportCaption($this->play_sound);
                    $doc->exportCaption($this->window_open);
                    $doc->exportCaption($this->only_names);
                    $doc->exportCaption($this->chatroom_window);
                    $doc->exportCaption($this->chatroom_stay);
                    $doc->exportCaption($this->chatroom_unfocus);
                    $doc->exportCaption($this->chatroom_show_names);
                    $doc->exportCaption($this->chatroom_block_chats);
                    $doc->exportCaption($this->chatroom_sound);
                    $doc->exportCaption($this->announcement);
                    $doc->exportCaption($this->unfocus_chat);
                    $doc->exportCaption($this->focus_chat);
                    $doc->exportCaption($this->last_message);
                    $doc->exportCaption($this->clear_chats);
                    $doc->exportCaption($this->apps_bookmarks);
                    $doc->exportCaption($this->apps_other);
                    $doc->exportCaption($this->apps_open);
                    $doc->exportCaption($this->apps_load);
                    $doc->exportCaption($this->block_chats);
                    $doc->exportCaption($this->session_time);
                    $doc->exportCaption($this->is_admin);
                    $doc->exportCaption($this->is_mod);
                    $doc->exportCaption($this->hash_id);
                    $doc->exportCaption($this->ip_address);
                } else {
                    $doc->exportCaption($this->_userid);
                    $doc->exportCaption($this->guest_name);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->theme);
                    $doc->exportCaption($this->popout);
                    $doc->exportCaption($this->hide_bar);
                    $doc->exportCaption($this->play_sound);
                    $doc->exportCaption($this->window_open);
                    $doc->exportCaption($this->only_names);
                    $doc->exportCaption($this->chatroom_window);
                    $doc->exportCaption($this->chatroom_stay);
                    $doc->exportCaption($this->chatroom_show_names);
                    $doc->exportCaption($this->chatroom_block_chats);
                    $doc->exportCaption($this->chatroom_sound);
                    $doc->exportCaption($this->announcement);
                    $doc->exportCaption($this->focus_chat);
                    $doc->exportCaption($this->apps_open);
                    $doc->exportCaption($this->session_time);
                    $doc->exportCaption($this->is_admin);
                    $doc->exportCaption($this->is_mod);
                    $doc->exportCaption($this->hash_id);
                    $doc->exportCaption($this->ip_address);
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
                        $doc->exportField($this->_userid);
                        $doc->exportField($this->guest_name);
                        $doc->exportField($this->message);
                        $doc->exportField($this->status);
                        $doc->exportField($this->theme);
                        $doc->exportField($this->popout);
                        $doc->exportField($this->typing);
                        $doc->exportField($this->hide_bar);
                        $doc->exportField($this->play_sound);
                        $doc->exportField($this->window_open);
                        $doc->exportField($this->only_names);
                        $doc->exportField($this->chatroom_window);
                        $doc->exportField($this->chatroom_stay);
                        $doc->exportField($this->chatroom_unfocus);
                        $doc->exportField($this->chatroom_show_names);
                        $doc->exportField($this->chatroom_block_chats);
                        $doc->exportField($this->chatroom_sound);
                        $doc->exportField($this->announcement);
                        $doc->exportField($this->unfocus_chat);
                        $doc->exportField($this->focus_chat);
                        $doc->exportField($this->last_message);
                        $doc->exportField($this->clear_chats);
                        $doc->exportField($this->apps_bookmarks);
                        $doc->exportField($this->apps_other);
                        $doc->exportField($this->apps_open);
                        $doc->exportField($this->apps_load);
                        $doc->exportField($this->block_chats);
                        $doc->exportField($this->session_time);
                        $doc->exportField($this->is_admin);
                        $doc->exportField($this->is_mod);
                        $doc->exportField($this->hash_id);
                        $doc->exportField($this->ip_address);
                    } else {
                        $doc->exportField($this->_userid);
                        $doc->exportField($this->guest_name);
                        $doc->exportField($this->status);
                        $doc->exportField($this->theme);
                        $doc->exportField($this->popout);
                        $doc->exportField($this->hide_bar);
                        $doc->exportField($this->play_sound);
                        $doc->exportField($this->window_open);
                        $doc->exportField($this->only_names);
                        $doc->exportField($this->chatroom_window);
                        $doc->exportField($this->chatroom_stay);
                        $doc->exportField($this->chatroom_show_names);
                        $doc->exportField($this->chatroom_block_chats);
                        $doc->exportField($this->chatroom_sound);
                        $doc->exportField($this->announcement);
                        $doc->exportField($this->focus_chat);
                        $doc->exportField($this->apps_open);
                        $doc->exportField($this->session_time);
                        $doc->exportField($this->is_admin);
                        $doc->exportField($this->is_mod);
                        $doc->exportField($this->hash_id);
                        $doc->exportField($this->ip_address);
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
