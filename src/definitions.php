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
    "escenario" => \DI\create(Escenario::class),
    "grupo" => \DI\create(Grupo::class),
    "participantes" => \DI\create(Participantes::class),
    "subgrupo" => \DI\create(Subgrupo::class),
    "tareas" => \DI\create(Tareas::class),
    "inicio" => \DI\create(Inicio::class),
    "paisgmt" => \DI\create(Paisgmt::class),
    "correo" => \DI\create(Correo::class),
    "email2" => \DI\create(Email2::class),
    "users" => \DI\create(Users::class),
    "mensagens" => \DI\create(Mensagens::class),
    "incidente" => \DI\create(Incidente::class),
    "tipo" => \DI\create(Tipo::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "audittrail" => \DI\create(Audittrail::class),
    "menucontenedor" => \DI\create(Menucontenedor::class),
    "mensajes" => \DI\create(Mensajes::class),
    "chat_ini" => \DI\create(ChatIni::class),
    "todos" => \DI\create(Todos::class),
    "view_from" => \DI\create(ViewFrom::class),
    "historico" => \DI\create(Historico::class),
    "actor_simulado" => \DI\create(ActorSimulado::class),
    "mensajes_usuarios" => \DI\create(MensajesUsuarios::class),
    "grupos" => \DI\create(Grupos::class),
    "onlyoffice" => \DI\create(Onlyoffice::class),
    "timeline" => \DI\create(Timeline::class),
    "archivos_doc" => \DI\create(ArchivosDoc::class),
    "permisos_doc" => \DI\create(PermisosDoc::class),
    "permisos_docusers" => \DI\create(PermisosDocusers::class),
    "resmensaje" => \DI\create(Resmensaje::class),
    "tablero_excon" => \DI\create(TableroExcon::class),
    "biblioteca" => \DI\create(Biblioteca::class),
    "view_compartidos" => \DI\create(ViewCompartidos::class),
    "imbox_mail" => \DI\create(ImboxMail::class),
    "notiemail" => \DI\create(Notiemail::class),
    "notifica_email" => \DI\create(NotificaEmail::class),
    "calificacion" => \DI\create(Calificacion::class),
    "calificacion_mensajes" => \DI\create(CalificacionMensajes::class),
    "user_email" => \DI\create(UserEmail::class),
    "view_user_msg" => \DI\create(ViewUserMsg::class),
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
    "kanban" => \DI\create(Kanban::class),
    "tbl_status" => \DI\create(TblStatus::class),
    "tbl_task" => \DI\create(TblTask::class),
    "tablero_participante" => \DI\create(TableroParticipante::class),
    "linea_tiempo" => \DI\create(LineaTiempo::class),
    "timeline_general" => \DI\create(TimelineGeneral::class),
    "timeline_excon" => \DI\create(TimelineExcon::class),
    "documentos" => \DI\create(Documentos::class),
    "editGrupos" => \DI\create(EditGrupos::class),
    "evento_asociado" => \DI\create(EventoAsociado::class),
    "view_evento_asociado" => \DI\create(ViewEventoAsociado::class),
    "inject_excon" => \DI\create(InjectExcon::class),
    "inject_participante" => \DI\create(InjectParticipante::class),

    // User table
    "usertable" => \DI\get("users"),
];
