<?php

namespace PHPMaker2021\simexamerica;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "actor_simulado" => \DI\create(ActorSimulado::class),
    "archivos_doc" => \DI\create(ArchivosDoc::class),
    "arrowchat" => \DI\create(Arrowchat::class),
    "arrowchat_admin" => \DI\create(ArrowchatAdmin::class),
    "arrowchat_applications" => \DI\create(ArrowchatApplications::class),
    "arrowchat_banlist" => \DI\create(ArrowchatBanlist::class),
    "arrowchat_chatroom_banlist" => \DI\create(ArrowchatChatroomBanlist::class),
    "arrowchat_chatroom_messages" => \DI\create(ArrowchatChatroomMessages::class),
    "arrowchat_chatroom_rooms" => \DI\create(ArrowchatChatroomRooms::class),
    "arrowchat_chatroom_users" => \DI\create(ArrowchatChatroomUsers::class),
    "arrowchat_config" => \DI\create(ArrowchatConfig::class),
    "arrowchat_graph_log" => \DI\create(ArrowchatGraphLog::class),
    "arrowchat_notifications" => \DI\create(ArrowchatNotifications::class),
    "arrowchat_notifications_markup" => \DI\create(ArrowchatNotificationsMarkup::class),
    "arrowchat_reports" => \DI\create(ArrowchatReports::class),
    "arrowchat_smilies" => \DI\create(ArrowchatSmilies::class),
    "arrowchat_status" => \DI\create(ArrowchatStatus::class),
    "arrowchat_themes" => \DI\create(ArrowchatThemes::class),
    "arrowchat_trayicons" => \DI\create(ArrowchatTrayicons::class),
    "arrowchat_warnings" => \DI\create(ArrowchatWarnings::class),
    "audittrail" => \DI\create(Audittrail::class),
    "biblioteca" => \DI\create(Biblioteca::class),
    "calificacion" => \DI\create(Calificacion::class),
    "calificacion_mensajes" => \DI\create(CalificacionMensajes::class),
    "chat_ini" => \DI\create(ChatIni::class),
    "correo" => \DI\create(Correo::class),
    "documentos" => \DI\create(Documentos::class),
    "docver" => \DI\create(Docver::class),
    "editGrupos" => \DI\create(EditGrupos::class),
    "email2" => \DI\create(Email2::class),
    "escenario" => \DI\create(Escenario::class),
    "evento_asociado" => \DI\create(EventoAsociado::class),
    "fileuser" => \DI\create(Fileuser::class),
    "grupo" => \DI\create(Grupo::class),
    "grupos" => \DI\create(Grupos::class),
    "historico" => \DI\create(Historico::class),
    "imbox_mail" => \DI\create(ImboxMail::class),
    "incidente" => \DI\create(Incidente::class),
    "inicio" => \DI\create(Inicio::class),
    "inject_excon" => \DI\create(InjectExcon::class),
    "inject_participante" => \DI\create(InjectParticipante::class),
    "kanban" => \DI\create(Kanban::class),
    "linea_tiempo" => \DI\create(LineaTiempo::class),
    "mensagens" => \DI\create(Mensagens::class),
    "mensajes" => \DI\create(Mensajes::class),
    "mensajes_usuarios" => \DI\create(MensajesUsuarios::class),
    "menucontenedor" => \DI\create(Menucontenedor::class),
    "notiemail" => \DI\create(Notiemail::class),
    "notifica_email" => \DI\create(NotificaEmail::class),
    "onlyoffice" => \DI\create(Onlyoffice::class),
    "paisgmt" => \DI\create(Paisgmt::class),
    "participantes" => \DI\create(Participantes::class),
    "permisos_doc" => \DI\create(PermisosDoc::class),
    "permisos_docusers" => \DI\create(PermisosDocusers::class),
    "pizarra" => \DI\create(Pizarra::class),
    "resmensaje" => \DI\create(Resmensaje::class),
    "subgrupo" => \DI\create(Subgrupo::class),
    "tablero_excon" => \DI\create(TableroExcon::class),
    "tablero_participante" => \DI\create(TableroParticipante::class),
    "tareas" => \DI\create(Tareas::class),
    "tbl_status" => \DI\create(TblStatus::class),
    "tbl_task" => \DI\create(TblTask::class),
    "timeline" => \DI\create(Timeline::class),
    "timeline_excon" => \DI\create(TimelineExcon::class),
    "timeline_general" => \DI\create(TimelineGeneral::class),
    "tipo" => \DI\create(Tipo::class),
    "todos" => \DI\create(Todos::class),
    "user_email" => \DI\create(UserEmail::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "users" => \DI\create(Users::class),
    "view_compartidos" => \DI\create(ViewCompartidos::class),
    "view_evento_asociado" => \DI\create(ViewEventoAsociado::class),
    "view_from" => \DI\create(ViewFrom::class),
    "view_user_msg" => \DI\create(ViewUserMsg::class),
    "vista_doc" => \DI\create(VistaDoc::class),

    // User table
    "usertable" => \DI\get("users"),
];
