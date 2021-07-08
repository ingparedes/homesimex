<?php

namespace PHPMaker2021\simexamerica;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // escenario
    $app->any('/EscenarioList[/{id_escenario}]', EscenarioController::class . ':list')->add(PermissionMiddleware::class)->setName('EscenarioList-escenario-list'); // list
    $app->any('/EscenarioAdd[/{id_escenario}]', EscenarioController::class . ':add')->add(PermissionMiddleware::class)->setName('EscenarioAdd-escenario-add'); // add
    $app->any('/EscenarioView[/{id_escenario}]', EscenarioController::class . ':view')->add(PermissionMiddleware::class)->setName('EscenarioView-escenario-view'); // view
    $app->any('/EscenarioEdit[/{id_escenario}]', EscenarioController::class . ':edit')->add(PermissionMiddleware::class)->setName('EscenarioEdit-escenario-edit'); // edit
    $app->any('/EscenarioDelete[/{id_escenario}]', EscenarioController::class . ':delete')->add(PermissionMiddleware::class)->setName('EscenarioDelete-escenario-delete'); // delete
    $app->group(
        '/escenario',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_escenario}]', EscenarioController::class . ':list')->add(PermissionMiddleware::class)->setName('escenario/list-escenario-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_escenario}]', EscenarioController::class . ':add')->add(PermissionMiddleware::class)->setName('escenario/add-escenario-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_escenario}]', EscenarioController::class . ':view')->add(PermissionMiddleware::class)->setName('escenario/view-escenario-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_escenario}]', EscenarioController::class . ':edit')->add(PermissionMiddleware::class)->setName('escenario/edit-escenario-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_escenario}]', EscenarioController::class . ':delete')->add(PermissionMiddleware::class)->setName('escenario/delete-escenario-delete-2'); // delete
        }
    );

    // grupo
    $app->any('/GrupoList[/{id_grupo}]', GrupoController::class . ':list')->add(PermissionMiddleware::class)->setName('GrupoList-grupo-list'); // list
    $app->any('/GrupoAdd[/{id_grupo}]', GrupoController::class . ':add')->add(PermissionMiddleware::class)->setName('GrupoAdd-grupo-add'); // add
    $app->any('/GrupoView[/{id_grupo}]', GrupoController::class . ':view')->add(PermissionMiddleware::class)->setName('GrupoView-grupo-view'); // view
    $app->any('/GrupoEdit[/{id_grupo}]', GrupoController::class . ':edit')->add(PermissionMiddleware::class)->setName('GrupoEdit-grupo-edit'); // edit
    $app->any('/GrupoDelete[/{id_grupo}]', GrupoController::class . ':delete')->add(PermissionMiddleware::class)->setName('GrupoDelete-grupo-delete'); // delete
    $app->any('/GrupoPreview', GrupoController::class . ':preview')->add(PermissionMiddleware::class)->setName('GrupoPreview-grupo-preview'); // preview
    $app->group(
        '/grupo',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_grupo}]', GrupoController::class . ':list')->add(PermissionMiddleware::class)->setName('grupo/list-grupo-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_grupo}]', GrupoController::class . ':add')->add(PermissionMiddleware::class)->setName('grupo/add-grupo-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_grupo}]', GrupoController::class . ':view')->add(PermissionMiddleware::class)->setName('grupo/view-grupo-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_grupo}]', GrupoController::class . ':edit')->add(PermissionMiddleware::class)->setName('grupo/edit-grupo-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_grupo}]', GrupoController::class . ':delete')->add(PermissionMiddleware::class)->setName('grupo/delete-grupo-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', GrupoController::class . ':preview')->add(PermissionMiddleware::class)->setName('grupo/preview-grupo-preview-2'); // preview
        }
    );

    // subgrupo
    $app->any('/SubgrupoList[/{id_subgrupo}]', SubgrupoController::class . ':list')->add(PermissionMiddleware::class)->setName('SubgrupoList-subgrupo-list'); // list
    $app->any('/SubgrupoAdd[/{id_subgrupo}]', SubgrupoController::class . ':add')->add(PermissionMiddleware::class)->setName('SubgrupoAdd-subgrupo-add'); // add
    $app->any('/SubgrupoEdit[/{id_subgrupo}]', SubgrupoController::class . ':edit')->add(PermissionMiddleware::class)->setName('SubgrupoEdit-subgrupo-edit'); // edit
    $app->any('/SubgrupoDelete[/{id_subgrupo}]', SubgrupoController::class . ':delete')->add(PermissionMiddleware::class)->setName('SubgrupoDelete-subgrupo-delete'); // delete
    $app->any('/SubgrupoPreview', SubgrupoController::class . ':preview')->add(PermissionMiddleware::class)->setName('SubgrupoPreview-subgrupo-preview'); // preview
    $app->group(
        '/subgrupo',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_subgrupo}]', SubgrupoController::class . ':list')->add(PermissionMiddleware::class)->setName('subgrupo/list-subgrupo-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_subgrupo}]', SubgrupoController::class . ':add')->add(PermissionMiddleware::class)->setName('subgrupo/add-subgrupo-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_subgrupo}]', SubgrupoController::class . ':edit')->add(PermissionMiddleware::class)->setName('subgrupo/edit-subgrupo-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_subgrupo}]', SubgrupoController::class . ':delete')->add(PermissionMiddleware::class)->setName('subgrupo/delete-subgrupo-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', SubgrupoController::class . ':preview')->add(PermissionMiddleware::class)->setName('subgrupo/preview-subgrupo-preview-2'); // preview
        }
    );

    // tareas
    $app->any('/TareasList[/{id_tarea}]', TareasController::class . ':list')->add(PermissionMiddleware::class)->setName('TareasList-tareas-list'); // list
    $app->any('/TareasAdd[/{id_tarea}]', TareasController::class . ':add')->add(PermissionMiddleware::class)->setName('TareasAdd-tareas-add'); // add
    $app->any('/TareasView[/{id_tarea}]', TareasController::class . ':view')->add(PermissionMiddleware::class)->setName('TareasView-tareas-view'); // view
    $app->any('/TareasEdit[/{id_tarea}]', TareasController::class . ':edit')->add(PermissionMiddleware::class)->setName('TareasEdit-tareas-edit'); // edit
    $app->any('/TareasDelete[/{id_tarea}]', TareasController::class . ':delete')->add(PermissionMiddleware::class)->setName('TareasDelete-tareas-delete'); // delete
    $app->any('/TareasPreview', TareasController::class . ':preview')->add(PermissionMiddleware::class)->setName('TareasPreview-tareas-preview'); // preview
    $app->group(
        '/tareas',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_tarea}]', TareasController::class . ':list')->add(PermissionMiddleware::class)->setName('tareas/list-tareas-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_tarea}]', TareasController::class . ':add')->add(PermissionMiddleware::class)->setName('tareas/add-tareas-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_tarea}]', TareasController::class . ':view')->add(PermissionMiddleware::class)->setName('tareas/view-tareas-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_tarea}]', TareasController::class . ':edit')->add(PermissionMiddleware::class)->setName('tareas/edit-tareas-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_tarea}]', TareasController::class . ':delete')->add(PermissionMiddleware::class)->setName('tareas/delete-tareas-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', TareasController::class . ':preview')->add(PermissionMiddleware::class)->setName('tareas/preview-tareas-preview-2'); // preview
        }
    );

    // inicio
    $app->any('/Inicio[/{params:.*}]', InicioController::class)->add(PermissionMiddleware::class)->setName('Inicio-inicio-custom'); // custom

    // paisgmt
    $app->any('/PaisgmtList[/{id_zone}]', PaisgmtController::class . ':list')->add(PermissionMiddleware::class)->setName('PaisgmtList-paisgmt-list'); // list
    $app->any('/PaisgmtAdd[/{id_zone}]', PaisgmtController::class . ':add')->add(PermissionMiddleware::class)->setName('PaisgmtAdd-paisgmt-add'); // add
    $app->any('/PaisgmtView[/{id_zone}]', PaisgmtController::class . ':view')->add(PermissionMiddleware::class)->setName('PaisgmtView-paisgmt-view'); // view
    $app->any('/PaisgmtEdit[/{id_zone}]', PaisgmtController::class . ':edit')->add(PermissionMiddleware::class)->setName('PaisgmtEdit-paisgmt-edit'); // edit
    $app->any('/PaisgmtDelete[/{id_zone}]', PaisgmtController::class . ':delete')->add(PermissionMiddleware::class)->setName('PaisgmtDelete-paisgmt-delete'); // delete
    $app->group(
        '/paisgmt',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_zone}]', PaisgmtController::class . ':list')->add(PermissionMiddleware::class)->setName('paisgmt/list-paisgmt-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_zone}]', PaisgmtController::class . ':add')->add(PermissionMiddleware::class)->setName('paisgmt/add-paisgmt-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_zone}]', PaisgmtController::class . ':view')->add(PermissionMiddleware::class)->setName('paisgmt/view-paisgmt-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_zone}]', PaisgmtController::class . ':edit')->add(PermissionMiddleware::class)->setName('paisgmt/edit-paisgmt-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_zone}]', PaisgmtController::class . ':delete')->add(PermissionMiddleware::class)->setName('paisgmt/delete-paisgmt-delete-2'); // delete
        }
    );

    // correo
    $app->any('/Correo[/{params:.*}]', CorreoController::class)->add(PermissionMiddleware::class)->setName('Correo-correo-custom'); // custom

    // email2
    $app->any('/Email2List[/{id_email}]', Email2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('Email2List-email2-list'); // list
    $app->any('/Email2Add[/{id_email}]', Email2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('Email2Add-email2-add'); // add
    $app->any('/Email2View[/{id_email}]', Email2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('Email2View-email2-view'); // view
    $app->any('/Email2Delete[/{id_email}]', Email2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('Email2Delete-email2-delete'); // delete
    $app->group(
        '/email2',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_email}]', Email2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('email2/list-email2-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_email}]', Email2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('email2/add-email2-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_email}]', Email2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('email2/view-email2-view-2'); // view
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_email}]', Email2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('email2/delete-email2-delete-2'); // delete
        }
    );

    // users
    $app->any('/UsersList[/{id_users}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('UsersList-users-list'); // list
    $app->any('/UsersAdd[/{id_users}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('UsersAdd-users-add'); // add
    $app->any('/UsersView[/{id_users}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('UsersView-users-view'); // view
    $app->any('/UsersEdit[/{id_users}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('UsersEdit-users-edit'); // edit
    $app->any('/UsersDelete[/{id_users}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('UsersDelete-users-delete'); // delete
    $app->any('/UsersPreview', UsersController::class . ':preview')->add(PermissionMiddleware::class)->setName('UsersPreview-users-preview'); // preview
    $app->group(
        '/users',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_users}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('users/list-users-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_users}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('users/add-users-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_users}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('users/view-users-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_users}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('users/edit-users-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_users}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('users/delete-users-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', UsersController::class . ':preview')->add(PermissionMiddleware::class)->setName('users/preview-users-preview-2'); // preview
        }
    );

    // mensagens
    $app->any('/MensagensList[/{id}]', MensagensController::class . ':list')->add(PermissionMiddleware::class)->setName('MensagensList-mensagens-list'); // list
    $app->any('/MensagensAdd[/{id}]', MensagensController::class . ':add')->add(PermissionMiddleware::class)->setName('MensagensAdd-mensagens-add'); // add
    $app->any('/MensagensView[/{id}]', MensagensController::class . ':view')->add(PermissionMiddleware::class)->setName('MensagensView-mensagens-view'); // view
    $app->any('/MensagensEdit[/{id}]', MensagensController::class . ':edit')->add(PermissionMiddleware::class)->setName('MensagensEdit-mensagens-edit'); // edit
    $app->any('/MensagensDelete[/{id}]', MensagensController::class . ':delete')->add(PermissionMiddleware::class)->setName('MensagensDelete-mensagens-delete'); // delete
    $app->group(
        '/mensagens',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MensagensController::class . ':list')->add(PermissionMiddleware::class)->setName('mensagens/list-mensagens-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MensagensController::class . ':add')->add(PermissionMiddleware::class)->setName('mensagens/add-mensagens-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MensagensController::class . ':view')->add(PermissionMiddleware::class)->setName('mensagens/view-mensagens-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MensagensController::class . ':edit')->add(PermissionMiddleware::class)->setName('mensagens/edit-mensagens-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MensagensController::class . ':delete')->add(PermissionMiddleware::class)->setName('mensagens/delete-mensagens-delete-2'); // delete
        }
    );

    // incidente
    $app->any('/IncidenteList[/{id_incidente}]', IncidenteController::class . ':list')->add(PermissionMiddleware::class)->setName('IncidenteList-incidente-list'); // list
    $app->any('/IncidenteAdd[/{id_incidente}]', IncidenteController::class . ':add')->add(PermissionMiddleware::class)->setName('IncidenteAdd-incidente-add'); // add
    $app->any('/IncidenteView[/{id_incidente}]', IncidenteController::class . ':view')->add(PermissionMiddleware::class)->setName('IncidenteView-incidente-view'); // view
    $app->any('/IncidenteEdit[/{id_incidente}]', IncidenteController::class . ':edit')->add(PermissionMiddleware::class)->setName('IncidenteEdit-incidente-edit'); // edit
    $app->any('/IncidenteDelete[/{id_incidente}]', IncidenteController::class . ':delete')->add(PermissionMiddleware::class)->setName('IncidenteDelete-incidente-delete'); // delete
    $app->group(
        '/incidente',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_incidente}]', IncidenteController::class . ':list')->add(PermissionMiddleware::class)->setName('incidente/list-incidente-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_incidente}]', IncidenteController::class . ':add')->add(PermissionMiddleware::class)->setName('incidente/add-incidente-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_incidente}]', IncidenteController::class . ':view')->add(PermissionMiddleware::class)->setName('incidente/view-incidente-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_incidente}]', IncidenteController::class . ':edit')->add(PermissionMiddleware::class)->setName('incidente/edit-incidente-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_incidente}]', IncidenteController::class . ':delete')->add(PermissionMiddleware::class)->setName('incidente/delete-incidente-delete-2'); // delete
        }
    );

    // tipo
    $app->any('/TipoList[/{id_tipo}]', TipoController::class . ':list')->add(PermissionMiddleware::class)->setName('TipoList-tipo-list'); // list
    $app->any('/TipoAdd[/{id_tipo}]', TipoController::class . ':add')->add(PermissionMiddleware::class)->setName('TipoAdd-tipo-add'); // add
    $app->any('/TipoView[/{id_tipo}]', TipoController::class . ':view')->add(PermissionMiddleware::class)->setName('TipoView-tipo-view'); // view
    $app->any('/TipoEdit[/{id_tipo}]', TipoController::class . ':edit')->add(PermissionMiddleware::class)->setName('TipoEdit-tipo-edit'); // edit
    $app->any('/TipoDelete[/{id_tipo}]', TipoController::class . ':delete')->add(PermissionMiddleware::class)->setName('TipoDelete-tipo-delete'); // delete
    $app->group(
        '/tipo',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_tipo}]', TipoController::class . ':list')->add(PermissionMiddleware::class)->setName('tipo/list-tipo-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_tipo}]', TipoController::class . ':add')->add(PermissionMiddleware::class)->setName('tipo/add-tipo-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_tipo}]', TipoController::class . ':view')->add(PermissionMiddleware::class)->setName('tipo/view-tipo-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_tipo}]', TipoController::class . ':edit')->add(PermissionMiddleware::class)->setName('tipo/edit-tipo-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_tipo}]', TipoController::class . ':delete')->add(PermissionMiddleware::class)->setName('tipo/delete-tipo-delete-2'); // delete
        }
    );

    // userlevelpermissions
    $app->any('/UserlevelpermissionsList[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsList-userlevelpermissions-list'); // list
    $app->any('/UserlevelpermissionsAdd[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsAdd-userlevelpermissions-add'); // add
    $app->any('/UserlevelpermissionsView[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsView-userlevelpermissions-view'); // view
    $app->any('/UserlevelpermissionsEdit[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsEdit-userlevelpermissions-edit'); // edit
    $app->any('/UserlevelpermissionsDelete[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsDelete-userlevelpermissions-delete'); // delete
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissions/add-userlevelpermissions-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissions/view-userlevelpermissions-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissions/edit-userlevelpermissions-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissions/delete-userlevelpermissions-delete-2'); // delete
        }
    );

    // userlevels
    $app->any('/UserlevelsList[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelsList-userlevels-list'); // list
    $app->any('/UserlevelsAdd[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelsAdd-userlevels-add'); // add
    $app->any('/UserlevelsView[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelsView-userlevels-view'); // view
    $app->any('/UserlevelsEdit[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelsEdit-userlevels-edit'); // edit
    $app->any('/UserlevelsDelete[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelsDelete-userlevels-delete'); // delete
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevels/view-userlevels-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevels/edit-userlevels-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevels/delete-userlevels-delete-2'); // delete
        }
    );

    // audittrail
    $app->any('/AudittrailList[/{id}]', AudittrailController::class . ':list')->add(PermissionMiddleware::class)->setName('AudittrailList-audittrail-list'); // list
    $app->any('/AudittrailAdd[/{id}]', AudittrailController::class . ':add')->add(PermissionMiddleware::class)->setName('AudittrailAdd-audittrail-add'); // add
    $app->any('/AudittrailView[/{id}]', AudittrailController::class . ':view')->add(PermissionMiddleware::class)->setName('AudittrailView-audittrail-view'); // view
    $app->any('/AudittrailEdit[/{id}]', AudittrailController::class . ':edit')->add(PermissionMiddleware::class)->setName('AudittrailEdit-audittrail-edit'); // edit
    $app->any('/AudittrailDelete[/{id}]', AudittrailController::class . ':delete')->add(PermissionMiddleware::class)->setName('AudittrailDelete-audittrail-delete'); // delete
    $app->group(
        '/audittrail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', AudittrailController::class . ':list')->add(PermissionMiddleware::class)->setName('audittrail/list-audittrail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', AudittrailController::class . ':add')->add(PermissionMiddleware::class)->setName('audittrail/add-audittrail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', AudittrailController::class . ':view')->add(PermissionMiddleware::class)->setName('audittrail/view-audittrail-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', AudittrailController::class . ':edit')->add(PermissionMiddleware::class)->setName('audittrail/edit-audittrail-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', AudittrailController::class . ':delete')->add(PermissionMiddleware::class)->setName('audittrail/delete-audittrail-delete-2'); // delete
        }
    );

    // menucontenedor
    $app->any('/Menucontenedor[/{params:.*}]', MenucontenedorController::class)->add(PermissionMiddleware::class)->setName('Menucontenedor-menucontenedor-custom'); // custom

    // mensajes
    $app->any('/MensajesList[/{id_inyect}]', MensajesController::class . ':list')->add(PermissionMiddleware::class)->setName('MensajesList-mensajes-list'); // list
    $app->any('/MensajesAdd[/{id_inyect}]', MensajesController::class . ':add')->add(PermissionMiddleware::class)->setName('MensajesAdd-mensajes-add'); // add
    $app->any('/MensajesView[/{id_inyect}]', MensajesController::class . ':view')->add(PermissionMiddleware::class)->setName('MensajesView-mensajes-view'); // view
    $app->any('/MensajesEdit[/{id_inyect}]', MensajesController::class . ':edit')->add(PermissionMiddleware::class)->setName('MensajesEdit-mensajes-edit'); // edit
    $app->any('/MensajesDelete[/{id_inyect}]', MensajesController::class . ':delete')->add(PermissionMiddleware::class)->setName('MensajesDelete-mensajes-delete'); // delete
    $app->any('/MensajesPreview', MensajesController::class . ':preview')->add(PermissionMiddleware::class)->setName('MensajesPreview-mensajes-preview'); // preview
    $app->group(
        '/mensajes',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_inyect}]', MensajesController::class . ':list')->add(PermissionMiddleware::class)->setName('mensajes/list-mensajes-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_inyect}]', MensajesController::class . ':add')->add(PermissionMiddleware::class)->setName('mensajes/add-mensajes-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_inyect}]', MensajesController::class . ':view')->add(PermissionMiddleware::class)->setName('mensajes/view-mensajes-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_inyect}]', MensajesController::class . ':edit')->add(PermissionMiddleware::class)->setName('mensajes/edit-mensajes-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_inyect}]', MensajesController::class . ':delete')->add(PermissionMiddleware::class)->setName('mensajes/delete-mensajes-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', MensajesController::class . ':preview')->add(PermissionMiddleware::class)->setName('mensajes/preview-mensajes-preview-2'); // preview
        }
    );

    // chat_ini
    $app->any('/ChatIni[/{params:.*}]', ChatIniController::class)->add(PermissionMiddleware::class)->setName('ChatIni-chat_ini-custom'); // custom

    // todos
    $app->any('/TodosList[/{id}]', TodosController::class . ':list')->add(PermissionMiddleware::class)->setName('TodosList-todos-list'); // list
    $app->any('/TodosAdd[/{id}]', TodosController::class . ':add')->add(PermissionMiddleware::class)->setName('TodosAdd-todos-add'); // add
    $app->any('/TodosView[/{id}]', TodosController::class . ':view')->add(PermissionMiddleware::class)->setName('TodosView-todos-view'); // view
    $app->any('/TodosEdit[/{id}]', TodosController::class . ':edit')->add(PermissionMiddleware::class)->setName('TodosEdit-todos-edit'); // edit
    $app->any('/TodosDelete[/{id}]', TodosController::class . ':delete')->add(PermissionMiddleware::class)->setName('TodosDelete-todos-delete'); // delete
    $app->group(
        '/todos',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', TodosController::class . ':list')->add(PermissionMiddleware::class)->setName('todos/list-todos-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', TodosController::class . ':add')->add(PermissionMiddleware::class)->setName('todos/add-todos-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', TodosController::class . ':view')->add(PermissionMiddleware::class)->setName('todos/view-todos-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', TodosController::class . ':edit')->add(PermissionMiddleware::class)->setName('todos/edit-todos-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', TodosController::class . ':delete')->add(PermissionMiddleware::class)->setName('todos/delete-todos-delete-2'); // delete
        }
    );

    // view_from
    $app->any('/ViewFromList', ViewFromController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewFromList-view_from-list'); // list
    $app->group(
        '/view_from',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewFromController::class . ':list')->add(PermissionMiddleware::class)->setName('view_from/list-view_from-list-2'); // list
        }
    );

    // historico
    $app->any('/Historico[/{params:.*}]', HistoricoController::class)->add(PermissionMiddleware::class)->setName('Historico-historico-custom'); // custom

    // actor_simulado
    $app->any('/ActorSimuladoList[/{id_actor}]', ActorSimuladoController::class . ':list')->add(PermissionMiddleware::class)->setName('ActorSimuladoList-actor_simulado-list'); // list
    $app->any('/ActorSimuladoAdd[/{id_actor}]', ActorSimuladoController::class . ':add')->add(PermissionMiddleware::class)->setName('ActorSimuladoAdd-actor_simulado-add'); // add
    $app->any('/ActorSimuladoAddopt', ActorSimuladoController::class . ':addopt')->add(PermissionMiddleware::class)->setName('ActorSimuladoAddopt-actor_simulado-addopt'); // addopt
    $app->any('/ActorSimuladoView[/{id_actor}]', ActorSimuladoController::class . ':view')->add(PermissionMiddleware::class)->setName('ActorSimuladoView-actor_simulado-view'); // view
    $app->any('/ActorSimuladoEdit[/{id_actor}]', ActorSimuladoController::class . ':edit')->add(PermissionMiddleware::class)->setName('ActorSimuladoEdit-actor_simulado-edit'); // edit
    $app->any('/ActorSimuladoDelete[/{id_actor}]', ActorSimuladoController::class . ':delete')->add(PermissionMiddleware::class)->setName('ActorSimuladoDelete-actor_simulado-delete'); // delete
    $app->group(
        '/actor_simulado',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_actor}]', ActorSimuladoController::class . ':list')->add(PermissionMiddleware::class)->setName('actor_simulado/list-actor_simulado-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_actor}]', ActorSimuladoController::class . ':add')->add(PermissionMiddleware::class)->setName('actor_simulado/add-actor_simulado-add-2'); // add
            $group->any('/' . Config("ADDOPT_ACTION") . '', ActorSimuladoController::class . ':addopt')->add(PermissionMiddleware::class)->setName('actor_simulado/addopt-actor_simulado-addopt-2'); // addopt
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_actor}]', ActorSimuladoController::class . ':view')->add(PermissionMiddleware::class)->setName('actor_simulado/view-actor_simulado-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_actor}]', ActorSimuladoController::class . ':edit')->add(PermissionMiddleware::class)->setName('actor_simulado/edit-actor_simulado-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_actor}]', ActorSimuladoController::class . ':delete')->add(PermissionMiddleware::class)->setName('actor_simulado/delete-actor_simulado-delete-2'); // delete
        }
    );

    // mensajes_usuarios
    $app->any('/MensajesUsuariosList[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':list')->add(PermissionMiddleware::class)->setName('MensajesUsuariosList-mensajes_usuarios-list'); // list
    $app->any('/MensajesUsuariosAdd[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':add')->add(PermissionMiddleware::class)->setName('MensajesUsuariosAdd-mensajes_usuarios-add'); // add
    $app->any('/MensajesUsuariosView[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':view')->add(PermissionMiddleware::class)->setName('MensajesUsuariosView-mensajes_usuarios-view'); // view
    $app->any('/MensajesUsuariosEdit[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':edit')->add(PermissionMiddleware::class)->setName('MensajesUsuariosEdit-mensajes_usuarios-edit'); // edit
    $app->any('/MensajesUsuariosDelete[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':delete')->add(PermissionMiddleware::class)->setName('MensajesUsuariosDelete-mensajes_usuarios-delete'); // delete
    $app->group(
        '/mensajes_usuarios',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':list')->add(PermissionMiddleware::class)->setName('mensajes_usuarios/list-mensajes_usuarios-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':add')->add(PermissionMiddleware::class)->setName('mensajes_usuarios/add-mensajes_usuarios-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':view')->add(PermissionMiddleware::class)->setName('mensajes_usuarios/view-mensajes_usuarios-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':edit')->add(PermissionMiddleware::class)->setName('mensajes_usuarios/edit-mensajes_usuarios-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':delete')->add(PermissionMiddleware::class)->setName('mensajes_usuarios/delete-mensajes_usuarios-delete-2'); // delete
        }
    );

    // grupos
    $app->any('/Grupos[/{params:.*}]', GruposController::class)->add(PermissionMiddleware::class)->setName('Grupos-grupos-custom'); // custom

    // onlyoffice
    $app->any('/Onlyoffice[/{params:.*}]', OnlyofficeController::class)->add(PermissionMiddleware::class)->setName('Onlyoffice-onlyoffice-custom'); // custom

    // timeline
    $app->any('/Timeline[/{params:.*}]', TimelineController::class)->add(PermissionMiddleware::class)->setName('Timeline-timeline-custom'); // custom

    // archivos_doc
    $app->any('/ArchivosDocList[/{id_file}]', ArchivosDocController::class . ':list')->add(PermissionMiddleware::class)->setName('ArchivosDocList-archivos_doc-list'); // list
    $app->any('/ArchivosDocAdd[/{id_file}]', ArchivosDocController::class . ':add')->add(PermissionMiddleware::class)->setName('ArchivosDocAdd-archivos_doc-add'); // add
    $app->any('/ArchivosDocAddopt', ArchivosDocController::class . ':addopt')->add(PermissionMiddleware::class)->setName('ArchivosDocAddopt-archivos_doc-addopt'); // addopt
    $app->any('/ArchivosDocView[/{id_file}]', ArchivosDocController::class . ':view')->add(PermissionMiddleware::class)->setName('ArchivosDocView-archivos_doc-view'); // view
    $app->any('/ArchivosDocDelete[/{id_file}]', ArchivosDocController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArchivosDocDelete-archivos_doc-delete'); // delete
    $app->group(
        '/archivos_doc',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_file}]', ArchivosDocController::class . ':list')->add(PermissionMiddleware::class)->setName('archivos_doc/list-archivos_doc-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_file}]', ArchivosDocController::class . ':add')->add(PermissionMiddleware::class)->setName('archivos_doc/add-archivos_doc-add-2'); // add
            $group->any('/' . Config("ADDOPT_ACTION") . '', ArchivosDocController::class . ':addopt')->add(PermissionMiddleware::class)->setName('archivos_doc/addopt-archivos_doc-addopt-2'); // addopt
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_file}]', ArchivosDocController::class . ':view')->add(PermissionMiddleware::class)->setName('archivos_doc/view-archivos_doc-view-2'); // view
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_file}]', ArchivosDocController::class . ':delete')->add(PermissionMiddleware::class)->setName('archivos_doc/delete-archivos_doc-delete-2'); // delete
        }
    );

    // permisos_doc
    $app->any('/PermisosDocList[/{id_permiso}]', PermisosDocController::class . ':list')->add(PermissionMiddleware::class)->setName('PermisosDocList-permisos_doc-list'); // list
    $app->any('/PermisosDocAdd[/{id_permiso}]', PermisosDocController::class . ':add')->add(PermissionMiddleware::class)->setName('PermisosDocAdd-permisos_doc-add'); // add
    $app->any('/PermisosDocView[/{id_permiso}]', PermisosDocController::class . ':view')->add(PermissionMiddleware::class)->setName('PermisosDocView-permisos_doc-view'); // view
    $app->any('/PermisosDocEdit[/{id_permiso}]', PermisosDocController::class . ':edit')->add(PermissionMiddleware::class)->setName('PermisosDocEdit-permisos_doc-edit'); // edit
    $app->any('/PermisosDocDelete[/{id_permiso}]', PermisosDocController::class . ':delete')->add(PermissionMiddleware::class)->setName('PermisosDocDelete-permisos_doc-delete'); // delete
    $app->any('/PermisosDocPreview', PermisosDocController::class . ':preview')->add(PermissionMiddleware::class)->setName('PermisosDocPreview-permisos_doc-preview'); // preview
    $app->group(
        '/permisos_doc',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_permiso}]', PermisosDocController::class . ':list')->add(PermissionMiddleware::class)->setName('permisos_doc/list-permisos_doc-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_permiso}]', PermisosDocController::class . ':add')->add(PermissionMiddleware::class)->setName('permisos_doc/add-permisos_doc-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_permiso}]', PermisosDocController::class . ':view')->add(PermissionMiddleware::class)->setName('permisos_doc/view-permisos_doc-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_permiso}]', PermisosDocController::class . ':edit')->add(PermissionMiddleware::class)->setName('permisos_doc/edit-permisos_doc-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_permiso}]', PermisosDocController::class . ':delete')->add(PermissionMiddleware::class)->setName('permisos_doc/delete-permisos_doc-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', PermisosDocController::class . ':preview')->add(PermissionMiddleware::class)->setName('permisos_doc/preview-permisos_doc-preview-2'); // preview
        }
    );

    // permisos_docusers
    $app->any('/PermisosDocusersList[/{id_permisiosuser}]', PermisosDocusersController::class . ':list')->add(PermissionMiddleware::class)->setName('PermisosDocusersList-permisos_docusers-list'); // list
    $app->any('/PermisosDocusersView[/{id_permisiosuser}]', PermisosDocusersController::class . ':view')->add(PermissionMiddleware::class)->setName('PermisosDocusersView-permisos_docusers-view'); // view
    $app->group(
        '/permisos_docusers',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_permisiosuser}]', PermisosDocusersController::class . ':list')->add(PermissionMiddleware::class)->setName('permisos_docusers/list-permisos_docusers-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_permisiosuser}]', PermisosDocusersController::class . ':view')->add(PermissionMiddleware::class)->setName('permisos_docusers/view-permisos_docusers-view-2'); // view
        }
    );

    // resmensaje
    $app->any('/ResmensajeList[/{id_resmensaje}]', ResmensajeController::class . ':list')->add(PermissionMiddleware::class)->setName('ResmensajeList-resmensaje-list'); // list
    $app->any('/ResmensajeAdd[/{id_resmensaje}]', ResmensajeController::class . ':add')->add(PermissionMiddleware::class)->setName('ResmensajeAdd-resmensaje-add'); // add
    $app->any('/ResmensajeView[/{id_resmensaje}]', ResmensajeController::class . ':view')->add(PermissionMiddleware::class)->setName('ResmensajeView-resmensaje-view'); // view
    $app->any('/ResmensajeEdit[/{id_resmensaje}]', ResmensajeController::class . ':edit')->add(PermissionMiddleware::class)->setName('ResmensajeEdit-resmensaje-edit'); // edit
    $app->any('/ResmensajeDelete[/{id_resmensaje}]', ResmensajeController::class . ':delete')->add(PermissionMiddleware::class)->setName('ResmensajeDelete-resmensaje-delete'); // delete
    $app->any('/ResmensajePreview', ResmensajeController::class . ':preview')->add(PermissionMiddleware::class)->setName('ResmensajePreview-resmensaje-preview'); // preview
    $app->group(
        '/resmensaje',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_resmensaje}]', ResmensajeController::class . ':list')->add(PermissionMiddleware::class)->setName('resmensaje/list-resmensaje-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_resmensaje}]', ResmensajeController::class . ':add')->add(PermissionMiddleware::class)->setName('resmensaje/add-resmensaje-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_resmensaje}]', ResmensajeController::class . ':view')->add(PermissionMiddleware::class)->setName('resmensaje/view-resmensaje-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_resmensaje}]', ResmensajeController::class . ':edit')->add(PermissionMiddleware::class)->setName('resmensaje/edit-resmensaje-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_resmensaje}]', ResmensajeController::class . ':delete')->add(PermissionMiddleware::class)->setName('resmensaje/delete-resmensaje-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', ResmensajeController::class . ':preview')->add(PermissionMiddleware::class)->setName('resmensaje/preview-resmensaje-preview-2'); // preview
        }
    );

    // tablero_excon
    $app->any('/TableroExcon[/{params:.*}]', TableroExconController::class)->add(PermissionMiddleware::class)->setName('TableroExcon-tablero_excon-custom'); // custom

    // biblioteca
    $app->any('/Biblioteca[/{params:.*}]', BibliotecaController::class)->add(PermissionMiddleware::class)->setName('Biblioteca-biblioteca-custom'); // custom

    // view_compartidos
    $app->any('/ViewCompartidosList', ViewCompartidosController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewCompartidosList-view_compartidos-list'); // list
    $app->group(
        '/view_compartidos',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewCompartidosController::class . ':list')->add(PermissionMiddleware::class)->setName('view_compartidos/list-view_compartidos-list-2'); // list
        }
    );

    // imbox_mail
    $app->any('/ImboxMailList[/{id_email}]', ImboxMailController::class . ':list')->add(PermissionMiddleware::class)->setName('ImboxMailList-imbox_mail-list'); // list
    $app->any('/ImboxMailView[/{id_email}]', ImboxMailController::class . ':view')->add(PermissionMiddleware::class)->setName('ImboxMailView-imbox_mail-view'); // view
    $app->any('/ImboxMailEdit[/{id_email}]', ImboxMailController::class . ':edit')->add(PermissionMiddleware::class)->setName('ImboxMailEdit-imbox_mail-edit'); // edit
    $app->group(
        '/imbox_mail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_email}]', ImboxMailController::class . ':list')->add(PermissionMiddleware::class)->setName('imbox_mail/list-imbox_mail-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_email}]', ImboxMailController::class . ':view')->add(PermissionMiddleware::class)->setName('imbox_mail/view-imbox_mail-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_email}]', ImboxMailController::class . ':edit')->add(PermissionMiddleware::class)->setName('imbox_mail/edit-imbox_mail-edit-2'); // edit
        }
    );

    // notiemail
    $app->any('/NotiemailList[/{id_notiemail}]', NotiemailController::class . ':list')->add(PermissionMiddleware::class)->setName('NotiemailList-notiemail-list'); // list
    $app->any('/NotiemailAdd[/{id_notiemail}]', NotiemailController::class . ':add')->add(PermissionMiddleware::class)->setName('NotiemailAdd-notiemail-add'); // add
    $app->any('/NotiemailView[/{id_notiemail}]', NotiemailController::class . ':view')->add(PermissionMiddleware::class)->setName('NotiemailView-notiemail-view'); // view
    $app->any('/NotiemailEdit[/{id_notiemail}]', NotiemailController::class . ':edit')->add(PermissionMiddleware::class)->setName('NotiemailEdit-notiemail-edit'); // edit
    $app->any('/NotiemailDelete[/{id_notiemail}]', NotiemailController::class . ':delete')->add(PermissionMiddleware::class)->setName('NotiemailDelete-notiemail-delete'); // delete
    $app->group(
        '/notiemail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_notiemail}]', NotiemailController::class . ':list')->add(PermissionMiddleware::class)->setName('notiemail/list-notiemail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_notiemail}]', NotiemailController::class . ':add')->add(PermissionMiddleware::class)->setName('notiemail/add-notiemail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_notiemail}]', NotiemailController::class . ':view')->add(PermissionMiddleware::class)->setName('notiemail/view-notiemail-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_notiemail}]', NotiemailController::class . ':edit')->add(PermissionMiddleware::class)->setName('notiemail/edit-notiemail-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_notiemail}]', NotiemailController::class . ':delete')->add(PermissionMiddleware::class)->setName('notiemail/delete-notiemail-delete-2'); // delete
        }
    );

    // notifica_email
    $app->any('/NotificaEmail[/{params:.*}]', NotificaEmailController::class)->add(PermissionMiddleware::class)->setName('NotificaEmail-notifica_email-custom'); // custom

    // calificacion
    $app->any('/CalificacionList[/{id_calificacion}]', CalificacionController::class . ':list')->add(PermissionMiddleware::class)->setName('CalificacionList-calificacion-list'); // list
    $app->any('/CalificacionAdd[/{id_calificacion}]', CalificacionController::class . ':add')->add(PermissionMiddleware::class)->setName('CalificacionAdd-calificacion-add'); // add
    $app->any('/CalificacionView[/{id_calificacion}]', CalificacionController::class . ':view')->add(PermissionMiddleware::class)->setName('CalificacionView-calificacion-view'); // view
    $app->any('/CalificacionEdit[/{id_calificacion}]', CalificacionController::class . ':edit')->add(PermissionMiddleware::class)->setName('CalificacionEdit-calificacion-edit'); // edit
    $app->any('/CalificacionDelete[/{id_calificacion}]', CalificacionController::class . ':delete')->add(PermissionMiddleware::class)->setName('CalificacionDelete-calificacion-delete'); // delete
    $app->group(
        '/calificacion',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_calificacion}]', CalificacionController::class . ':list')->add(PermissionMiddleware::class)->setName('calificacion/list-calificacion-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_calificacion}]', CalificacionController::class . ':add')->add(PermissionMiddleware::class)->setName('calificacion/add-calificacion-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_calificacion}]', CalificacionController::class . ':view')->add(PermissionMiddleware::class)->setName('calificacion/view-calificacion-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_calificacion}]', CalificacionController::class . ':edit')->add(PermissionMiddleware::class)->setName('calificacion/edit-calificacion-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_calificacion}]', CalificacionController::class . ':delete')->add(PermissionMiddleware::class)->setName('calificacion/delete-calificacion-delete-2'); // delete
        }
    );

    // calificacion_mensajes
    $app->any('/CalificacionMensajesList[/{id_calificacion_msg}]', CalificacionMensajesController::class . ':list')->add(PermissionMiddleware::class)->setName('CalificacionMensajesList-calificacion_mensajes-list'); // list
    $app->any('/CalificacionMensajesAdd[/{id_calificacion_msg}]', CalificacionMensajesController::class . ':add')->add(PermissionMiddleware::class)->setName('CalificacionMensajesAdd-calificacion_mensajes-add'); // add
    $app->any('/CalificacionMensajesView[/{id_calificacion_msg}]', CalificacionMensajesController::class . ':view')->add(PermissionMiddleware::class)->setName('CalificacionMensajesView-calificacion_mensajes-view'); // view
    $app->any('/CalificacionMensajesEdit[/{id_calificacion_msg}]', CalificacionMensajesController::class . ':edit')->add(PermissionMiddleware::class)->setName('CalificacionMensajesEdit-calificacion_mensajes-edit'); // edit
    $app->any('/CalificacionMensajesDelete[/{id_calificacion_msg}]', CalificacionMensajesController::class . ':delete')->add(PermissionMiddleware::class)->setName('CalificacionMensajesDelete-calificacion_mensajes-delete'); // delete
    $app->group(
        '/calificacion_mensajes',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_calificacion_msg}]', CalificacionMensajesController::class . ':list')->add(PermissionMiddleware::class)->setName('calificacion_mensajes/list-calificacion_mensajes-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_calificacion_msg}]', CalificacionMensajesController::class . ':add')->add(PermissionMiddleware::class)->setName('calificacion_mensajes/add-calificacion_mensajes-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_calificacion_msg}]', CalificacionMensajesController::class . ':view')->add(PermissionMiddleware::class)->setName('calificacion_mensajes/view-calificacion_mensajes-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_calificacion_msg}]', CalificacionMensajesController::class . ':edit')->add(PermissionMiddleware::class)->setName('calificacion_mensajes/edit-calificacion_mensajes-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_calificacion_msg}]', CalificacionMensajesController::class . ':delete')->add(PermissionMiddleware::class)->setName('calificacion_mensajes/delete-calificacion_mensajes-delete-2'); // delete
        }
    );

    // user_email
    $app->any('/UserEmailList[/{id_user_email}]', UserEmailController::class . ':list')->add(PermissionMiddleware::class)->setName('UserEmailList-user_email-list'); // list
    $app->any('/UserEmailAdd[/{id_user_email}]', UserEmailController::class . ':add')->add(PermissionMiddleware::class)->setName('UserEmailAdd-user_email-add'); // add
    $app->any('/UserEmailView[/{id_user_email}]', UserEmailController::class . ':view')->add(PermissionMiddleware::class)->setName('UserEmailView-user_email-view'); // view
    $app->any('/UserEmailEdit[/{id_user_email}]', UserEmailController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserEmailEdit-user_email-edit'); // edit
    $app->any('/UserEmailDelete[/{id_user_email}]', UserEmailController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserEmailDelete-user_email-delete'); // delete
    $app->group(
        '/user_email',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_user_email}]', UserEmailController::class . ':list')->add(PermissionMiddleware::class)->setName('user_email/list-user_email-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_user_email}]', UserEmailController::class . ':add')->add(PermissionMiddleware::class)->setName('user_email/add-user_email-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_user_email}]', UserEmailController::class . ':view')->add(PermissionMiddleware::class)->setName('user_email/view-user_email-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_user_email}]', UserEmailController::class . ':edit')->add(PermissionMiddleware::class)->setName('user_email/edit-user_email-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_user_email}]', UserEmailController::class . ':delete')->add(PermissionMiddleware::class)->setName('user_email/delete-user_email-delete-2'); // delete
        }
    );

    // view_user_msg
    $app->any('/ViewUserMsgList[/{id_file}]', ViewUserMsgController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewUserMsgList-view_user_msg-list'); // list
    $app->group(
        '/view_user_msg',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_file}]', ViewUserMsgController::class . ':list')->add(PermissionMiddleware::class)->setName('view_user_msg/list-view_user_msg-list-2'); // list
        }
    );

    // arrowchat
    $app->any('/ArrowchatList[/{id}]', ArrowchatController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatList-arrowchat-list'); // list
    $app->any('/ArrowchatAdd[/{id}]', ArrowchatController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatAdd-arrowchat-add'); // add
    $app->any('/ArrowchatView[/{id}]', ArrowchatController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatView-arrowchat-view'); // view
    $app->any('/ArrowchatEdit[/{id}]', ArrowchatController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatEdit-arrowchat-edit'); // edit
    $app->any('/ArrowchatDelete[/{id}]', ArrowchatController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatDelete-arrowchat-delete'); // delete
    $app->group(
        '/arrowchat',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat/list-arrowchat-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat/add-arrowchat-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat/view-arrowchat-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat/edit-arrowchat-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat/delete-arrowchat-delete-2'); // delete
        }
    );

    // arrowchat_admin
    $app->any('/ArrowchatAdminList[/{id}]', ArrowchatAdminController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatAdminList-arrowchat_admin-list'); // list
    $app->any('/ArrowchatAdminAdd[/{id}]', ArrowchatAdminController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatAdminAdd-arrowchat_admin-add'); // add
    $app->any('/ArrowchatAdminView[/{id}]', ArrowchatAdminController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatAdminView-arrowchat_admin-view'); // view
    $app->any('/ArrowchatAdminEdit[/{id}]', ArrowchatAdminController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatAdminEdit-arrowchat_admin-edit'); // edit
    $app->any('/ArrowchatAdminDelete[/{id}]', ArrowchatAdminController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatAdminDelete-arrowchat_admin-delete'); // delete
    $app->group(
        '/arrowchat_admin',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatAdminController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_admin/list-arrowchat_admin-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatAdminController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_admin/add-arrowchat_admin-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatAdminController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_admin/view-arrowchat_admin-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatAdminController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_admin/edit-arrowchat_admin-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatAdminController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_admin/delete-arrowchat_admin-delete-2'); // delete
        }
    );

    // arrowchat_applications
    $app->any('/ArrowchatApplicationsList[/{id}]', ArrowchatApplicationsController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatApplicationsList-arrowchat_applications-list'); // list
    $app->any('/ArrowchatApplicationsAdd[/{id}]', ArrowchatApplicationsController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatApplicationsAdd-arrowchat_applications-add'); // add
    $app->any('/ArrowchatApplicationsView[/{id}]', ArrowchatApplicationsController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatApplicationsView-arrowchat_applications-view'); // view
    $app->any('/ArrowchatApplicationsEdit[/{id}]', ArrowchatApplicationsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatApplicationsEdit-arrowchat_applications-edit'); // edit
    $app->any('/ArrowchatApplicationsDelete[/{id}]', ArrowchatApplicationsController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatApplicationsDelete-arrowchat_applications-delete'); // delete
    $app->group(
        '/arrowchat_applications',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatApplicationsController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_applications/list-arrowchat_applications-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatApplicationsController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_applications/add-arrowchat_applications-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatApplicationsController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_applications/view-arrowchat_applications-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatApplicationsController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_applications/edit-arrowchat_applications-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatApplicationsController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_applications/delete-arrowchat_applications-delete-2'); // delete
        }
    );

    // arrowchat_banlist
    $app->any('/ArrowchatBanlistList[/{ban_id}]', ArrowchatBanlistController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatBanlistList-arrowchat_banlist-list'); // list
    $app->any('/ArrowchatBanlistAdd[/{ban_id}]', ArrowchatBanlistController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatBanlistAdd-arrowchat_banlist-add'); // add
    $app->any('/ArrowchatBanlistView[/{ban_id}]', ArrowchatBanlistController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatBanlistView-arrowchat_banlist-view'); // view
    $app->any('/ArrowchatBanlistEdit[/{ban_id}]', ArrowchatBanlistController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatBanlistEdit-arrowchat_banlist-edit'); // edit
    $app->any('/ArrowchatBanlistDelete[/{ban_id}]', ArrowchatBanlistController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatBanlistDelete-arrowchat_banlist-delete'); // delete
    $app->group(
        '/arrowchat_banlist',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{ban_id}]', ArrowchatBanlistController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_banlist/list-arrowchat_banlist-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{ban_id}]', ArrowchatBanlistController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_banlist/add-arrowchat_banlist-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{ban_id}]', ArrowchatBanlistController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_banlist/view-arrowchat_banlist-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{ban_id}]', ArrowchatBanlistController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_banlist/edit-arrowchat_banlist-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{ban_id}]', ArrowchatBanlistController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_banlist/delete-arrowchat_banlist-delete-2'); // delete
        }
    );

    // arrowchat_chatroom_banlist
    $app->any('/ArrowchatChatroomBanlistList[/{id}]', ArrowchatChatroomBanlistController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomBanlistList-arrowchat_chatroom_banlist-list'); // list
    $app->any('/ArrowchatChatroomBanlistAdd[/{id}]', ArrowchatChatroomBanlistController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomBanlistAdd-arrowchat_chatroom_banlist-add'); // add
    $app->any('/ArrowchatChatroomBanlistView[/{id}]', ArrowchatChatroomBanlistController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomBanlistView-arrowchat_chatroom_banlist-view'); // view
    $app->any('/ArrowchatChatroomBanlistEdit[/{id}]', ArrowchatChatroomBanlistController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomBanlistEdit-arrowchat_chatroom_banlist-edit'); // edit
    $app->any('/ArrowchatChatroomBanlistDelete[/{id}]', ArrowchatChatroomBanlistController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomBanlistDelete-arrowchat_chatroom_banlist-delete'); // delete
    $app->group(
        '/arrowchat_chatroom_banlist',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatChatroomBanlistController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_banlist/list-arrowchat_chatroom_banlist-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatChatroomBanlistController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_banlist/add-arrowchat_chatroom_banlist-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatChatroomBanlistController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_banlist/view-arrowchat_chatroom_banlist-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatChatroomBanlistController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_banlist/edit-arrowchat_chatroom_banlist-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatChatroomBanlistController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_banlist/delete-arrowchat_chatroom_banlist-delete-2'); // delete
        }
    );

    // arrowchat_chatroom_messages
    $app->any('/ArrowchatChatroomMessagesList[/{id}]', ArrowchatChatroomMessagesController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomMessagesList-arrowchat_chatroom_messages-list'); // list
    $app->any('/ArrowchatChatroomMessagesAdd[/{id}]', ArrowchatChatroomMessagesController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomMessagesAdd-arrowchat_chatroom_messages-add'); // add
    $app->any('/ArrowchatChatroomMessagesView[/{id}]', ArrowchatChatroomMessagesController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomMessagesView-arrowchat_chatroom_messages-view'); // view
    $app->any('/ArrowchatChatroomMessagesEdit[/{id}]', ArrowchatChatroomMessagesController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomMessagesEdit-arrowchat_chatroom_messages-edit'); // edit
    $app->any('/ArrowchatChatroomMessagesDelete[/{id}]', ArrowchatChatroomMessagesController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomMessagesDelete-arrowchat_chatroom_messages-delete'); // delete
    $app->group(
        '/arrowchat_chatroom_messages',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatChatroomMessagesController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_messages/list-arrowchat_chatroom_messages-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatChatroomMessagesController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_messages/add-arrowchat_chatroom_messages-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatChatroomMessagesController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_messages/view-arrowchat_chatroom_messages-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatChatroomMessagesController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_messages/edit-arrowchat_chatroom_messages-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatChatroomMessagesController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_messages/delete-arrowchat_chatroom_messages-delete-2'); // delete
        }
    );

    // arrowchat_chatroom_rooms
    $app->any('/ArrowchatChatroomRoomsList[/{id}]', ArrowchatChatroomRoomsController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomRoomsList-arrowchat_chatroom_rooms-list'); // list
    $app->any('/ArrowchatChatroomRoomsAdd[/{id}]', ArrowchatChatroomRoomsController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomRoomsAdd-arrowchat_chatroom_rooms-add'); // add
    $app->any('/ArrowchatChatroomRoomsView[/{id}]', ArrowchatChatroomRoomsController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomRoomsView-arrowchat_chatroom_rooms-view'); // view
    $app->any('/ArrowchatChatroomRoomsEdit[/{id}]', ArrowchatChatroomRoomsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomRoomsEdit-arrowchat_chatroom_rooms-edit'); // edit
    $app->any('/ArrowchatChatroomRoomsDelete[/{id}]', ArrowchatChatroomRoomsController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomRoomsDelete-arrowchat_chatroom_rooms-delete'); // delete
    $app->group(
        '/arrowchat_chatroom_rooms',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatChatroomRoomsController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_rooms/list-arrowchat_chatroom_rooms-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatChatroomRoomsController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_rooms/add-arrowchat_chatroom_rooms-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatChatroomRoomsController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_rooms/view-arrowchat_chatroom_rooms-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatChatroomRoomsController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_rooms/edit-arrowchat_chatroom_rooms-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatChatroomRoomsController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_rooms/delete-arrowchat_chatroom_rooms-delete-2'); // delete
        }
    );

    // arrowchat_chatroom_users
    $app->any('/ArrowchatChatroomUsersList[/{user_id}/{chatroom_id}]', ArrowchatChatroomUsersController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomUsersList-arrowchat_chatroom_users-list'); // list
    $app->any('/ArrowchatChatroomUsersAdd[/{user_id}/{chatroom_id}]', ArrowchatChatroomUsersController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomUsersAdd-arrowchat_chatroom_users-add'); // add
    $app->any('/ArrowchatChatroomUsersView[/{user_id}/{chatroom_id}]', ArrowchatChatroomUsersController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomUsersView-arrowchat_chatroom_users-view'); // view
    $app->any('/ArrowchatChatroomUsersEdit[/{user_id}/{chatroom_id}]', ArrowchatChatroomUsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomUsersEdit-arrowchat_chatroom_users-edit'); // edit
    $app->any('/ArrowchatChatroomUsersDelete[/{user_id}/{chatroom_id}]', ArrowchatChatroomUsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatChatroomUsersDelete-arrowchat_chatroom_users-delete'); // delete
    $app->group(
        '/arrowchat_chatroom_users',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{user_id}/{chatroom_id}]', ArrowchatChatroomUsersController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_users/list-arrowchat_chatroom_users-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{user_id}/{chatroom_id}]', ArrowchatChatroomUsersController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_users/add-arrowchat_chatroom_users-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{user_id}/{chatroom_id}]', ArrowchatChatroomUsersController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_users/view-arrowchat_chatroom_users-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{user_id}/{chatroom_id}]', ArrowchatChatroomUsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_users/edit-arrowchat_chatroom_users-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{user_id}/{chatroom_id}]', ArrowchatChatroomUsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_chatroom_users/delete-arrowchat_chatroom_users-delete-2'); // delete
        }
    );

    // arrowchat_config
    $app->any('/ArrowchatConfigList[/{config_name}]', ArrowchatConfigController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatConfigList-arrowchat_config-list'); // list
    $app->any('/ArrowchatConfigAdd[/{config_name}]', ArrowchatConfigController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatConfigAdd-arrowchat_config-add'); // add
    $app->any('/ArrowchatConfigView[/{config_name}]', ArrowchatConfigController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatConfigView-arrowchat_config-view'); // view
    $app->any('/ArrowchatConfigEdit[/{config_name}]', ArrowchatConfigController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatConfigEdit-arrowchat_config-edit'); // edit
    $app->any('/ArrowchatConfigDelete[/{config_name}]', ArrowchatConfigController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatConfigDelete-arrowchat_config-delete'); // delete
    $app->group(
        '/arrowchat_config',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{config_name}]', ArrowchatConfigController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_config/list-arrowchat_config-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{config_name}]', ArrowchatConfigController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_config/add-arrowchat_config-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{config_name}]', ArrowchatConfigController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_config/view-arrowchat_config-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{config_name}]', ArrowchatConfigController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_config/edit-arrowchat_config-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{config_name}]', ArrowchatConfigController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_config/delete-arrowchat_config-delete-2'); // delete
        }
    );

    // arrowchat_graph_log
    $app->any('/ArrowchatGraphLogList[/{id}]', ArrowchatGraphLogController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatGraphLogList-arrowchat_graph_log-list'); // list
    $app->any('/ArrowchatGraphLogAdd[/{id}]', ArrowchatGraphLogController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatGraphLogAdd-arrowchat_graph_log-add'); // add
    $app->any('/ArrowchatGraphLogView[/{id}]', ArrowchatGraphLogController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatGraphLogView-arrowchat_graph_log-view'); // view
    $app->any('/ArrowchatGraphLogEdit[/{id}]', ArrowchatGraphLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatGraphLogEdit-arrowchat_graph_log-edit'); // edit
    $app->any('/ArrowchatGraphLogDelete[/{id}]', ArrowchatGraphLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatGraphLogDelete-arrowchat_graph_log-delete'); // delete
    $app->group(
        '/arrowchat_graph_log',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatGraphLogController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_graph_log/list-arrowchat_graph_log-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatGraphLogController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_graph_log/add-arrowchat_graph_log-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatGraphLogController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_graph_log/view-arrowchat_graph_log-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatGraphLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_graph_log/edit-arrowchat_graph_log-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatGraphLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_graph_log/delete-arrowchat_graph_log-delete-2'); // delete
        }
    );

    // arrowchat_notifications
    $app->any('/ArrowchatNotificationsList[/{id}]', ArrowchatNotificationsController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatNotificationsList-arrowchat_notifications-list'); // list
    $app->any('/ArrowchatNotificationsAdd[/{id}]', ArrowchatNotificationsController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatNotificationsAdd-arrowchat_notifications-add'); // add
    $app->any('/ArrowchatNotificationsView[/{id}]', ArrowchatNotificationsController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatNotificationsView-arrowchat_notifications-view'); // view
    $app->any('/ArrowchatNotificationsEdit[/{id}]', ArrowchatNotificationsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatNotificationsEdit-arrowchat_notifications-edit'); // edit
    $app->any('/ArrowchatNotificationsDelete[/{id}]', ArrowchatNotificationsController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatNotificationsDelete-arrowchat_notifications-delete'); // delete
    $app->group(
        '/arrowchat_notifications',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatNotificationsController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_notifications/list-arrowchat_notifications-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatNotificationsController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_notifications/add-arrowchat_notifications-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatNotificationsController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_notifications/view-arrowchat_notifications-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatNotificationsController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_notifications/edit-arrowchat_notifications-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatNotificationsController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_notifications/delete-arrowchat_notifications-delete-2'); // delete
        }
    );

    // arrowchat_notifications_markup
    $app->any('/ArrowchatNotificationsMarkupList[/{id}]', ArrowchatNotificationsMarkupController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatNotificationsMarkupList-arrowchat_notifications_markup-list'); // list
    $app->any('/ArrowchatNotificationsMarkupAdd[/{id}]', ArrowchatNotificationsMarkupController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatNotificationsMarkupAdd-arrowchat_notifications_markup-add'); // add
    $app->any('/ArrowchatNotificationsMarkupView[/{id}]', ArrowchatNotificationsMarkupController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatNotificationsMarkupView-arrowchat_notifications_markup-view'); // view
    $app->any('/ArrowchatNotificationsMarkupEdit[/{id}]', ArrowchatNotificationsMarkupController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatNotificationsMarkupEdit-arrowchat_notifications_markup-edit'); // edit
    $app->any('/ArrowchatNotificationsMarkupDelete[/{id}]', ArrowchatNotificationsMarkupController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatNotificationsMarkupDelete-arrowchat_notifications_markup-delete'); // delete
    $app->group(
        '/arrowchat_notifications_markup',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatNotificationsMarkupController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_notifications_markup/list-arrowchat_notifications_markup-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatNotificationsMarkupController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_notifications_markup/add-arrowchat_notifications_markup-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatNotificationsMarkupController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_notifications_markup/view-arrowchat_notifications_markup-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatNotificationsMarkupController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_notifications_markup/edit-arrowchat_notifications_markup-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatNotificationsMarkupController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_notifications_markup/delete-arrowchat_notifications_markup-delete-2'); // delete
        }
    );

    // arrowchat_reports
    $app->any('/ArrowchatReportsList[/{id}]', ArrowchatReportsController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatReportsList-arrowchat_reports-list'); // list
    $app->any('/ArrowchatReportsAdd[/{id}]', ArrowchatReportsController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatReportsAdd-arrowchat_reports-add'); // add
    $app->any('/ArrowchatReportsView[/{id}]', ArrowchatReportsController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatReportsView-arrowchat_reports-view'); // view
    $app->any('/ArrowchatReportsEdit[/{id}]', ArrowchatReportsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatReportsEdit-arrowchat_reports-edit'); // edit
    $app->any('/ArrowchatReportsDelete[/{id}]', ArrowchatReportsController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatReportsDelete-arrowchat_reports-delete'); // delete
    $app->group(
        '/arrowchat_reports',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatReportsController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_reports/list-arrowchat_reports-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatReportsController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_reports/add-arrowchat_reports-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatReportsController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_reports/view-arrowchat_reports-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatReportsController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_reports/edit-arrowchat_reports-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatReportsController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_reports/delete-arrowchat_reports-delete-2'); // delete
        }
    );

    // arrowchat_smilies
    $app->any('/ArrowchatSmiliesList[/{id}]', ArrowchatSmiliesController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatSmiliesList-arrowchat_smilies-list'); // list
    $app->any('/ArrowchatSmiliesAdd[/{id}]', ArrowchatSmiliesController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatSmiliesAdd-arrowchat_smilies-add'); // add
    $app->any('/ArrowchatSmiliesView[/{id}]', ArrowchatSmiliesController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatSmiliesView-arrowchat_smilies-view'); // view
    $app->any('/ArrowchatSmiliesEdit[/{id}]', ArrowchatSmiliesController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatSmiliesEdit-arrowchat_smilies-edit'); // edit
    $app->any('/ArrowchatSmiliesDelete[/{id}]', ArrowchatSmiliesController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatSmiliesDelete-arrowchat_smilies-delete'); // delete
    $app->group(
        '/arrowchat_smilies',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatSmiliesController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_smilies/list-arrowchat_smilies-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatSmiliesController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_smilies/add-arrowchat_smilies-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatSmiliesController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_smilies/view-arrowchat_smilies-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatSmiliesController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_smilies/edit-arrowchat_smilies-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatSmiliesController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_smilies/delete-arrowchat_smilies-delete-2'); // delete
        }
    );

    // arrowchat_status
    $app->any('/ArrowchatStatusList[/{_userid}]', ArrowchatStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatStatusList-arrowchat_status-list'); // list
    $app->any('/ArrowchatStatusAdd[/{_userid}]', ArrowchatStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatStatusAdd-arrowchat_status-add'); // add
    $app->any('/ArrowchatStatusView[/{_userid}]', ArrowchatStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatStatusView-arrowchat_status-view'); // view
    $app->any('/ArrowchatStatusEdit[/{_userid}]', ArrowchatStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatStatusEdit-arrowchat_status-edit'); // edit
    $app->any('/ArrowchatStatusDelete[/{_userid}]', ArrowchatStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatStatusDelete-arrowchat_status-delete'); // delete
    $app->group(
        '/arrowchat_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{_userid}]', ArrowchatStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_status/list-arrowchat_status-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{_userid}]', ArrowchatStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_status/add-arrowchat_status-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{_userid}]', ArrowchatStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_status/view-arrowchat_status-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{_userid}]', ArrowchatStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_status/edit-arrowchat_status-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{_userid}]', ArrowchatStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_status/delete-arrowchat_status-delete-2'); // delete
        }
    );

    // arrowchat_themes
    $app->any('/ArrowchatThemesList[/{id}]', ArrowchatThemesController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatThemesList-arrowchat_themes-list'); // list
    $app->any('/ArrowchatThemesAdd[/{id}]', ArrowchatThemesController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatThemesAdd-arrowchat_themes-add'); // add
    $app->any('/ArrowchatThemesView[/{id}]', ArrowchatThemesController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatThemesView-arrowchat_themes-view'); // view
    $app->any('/ArrowchatThemesEdit[/{id}]', ArrowchatThemesController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatThemesEdit-arrowchat_themes-edit'); // edit
    $app->any('/ArrowchatThemesDelete[/{id}]', ArrowchatThemesController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatThemesDelete-arrowchat_themes-delete'); // delete
    $app->group(
        '/arrowchat_themes',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatThemesController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_themes/list-arrowchat_themes-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatThemesController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_themes/add-arrowchat_themes-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatThemesController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_themes/view-arrowchat_themes-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatThemesController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_themes/edit-arrowchat_themes-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatThemesController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_themes/delete-arrowchat_themes-delete-2'); // delete
        }
    );

    // arrowchat_trayicons
    $app->any('/ArrowchatTrayiconsList[/{id}]', ArrowchatTrayiconsController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatTrayiconsList-arrowchat_trayicons-list'); // list
    $app->any('/ArrowchatTrayiconsAdd[/{id}]', ArrowchatTrayiconsController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatTrayiconsAdd-arrowchat_trayicons-add'); // add
    $app->any('/ArrowchatTrayiconsView[/{id}]', ArrowchatTrayiconsController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatTrayiconsView-arrowchat_trayicons-view'); // view
    $app->any('/ArrowchatTrayiconsEdit[/{id}]', ArrowchatTrayiconsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatTrayiconsEdit-arrowchat_trayicons-edit'); // edit
    $app->any('/ArrowchatTrayiconsDelete[/{id}]', ArrowchatTrayiconsController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatTrayiconsDelete-arrowchat_trayicons-delete'); // delete
    $app->group(
        '/arrowchat_trayicons',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatTrayiconsController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_trayicons/list-arrowchat_trayicons-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatTrayiconsController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_trayicons/add-arrowchat_trayicons-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatTrayiconsController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_trayicons/view-arrowchat_trayicons-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatTrayiconsController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_trayicons/edit-arrowchat_trayicons-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatTrayiconsController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_trayicons/delete-arrowchat_trayicons-delete-2'); // delete
        }
    );

    // arrowchat_warnings
    $app->any('/ArrowchatWarningsList[/{id}]', ArrowchatWarningsController::class . ':list')->add(PermissionMiddleware::class)->setName('ArrowchatWarningsList-arrowchat_warnings-list'); // list
    $app->any('/ArrowchatWarningsAdd[/{id}]', ArrowchatWarningsController::class . ':add')->add(PermissionMiddleware::class)->setName('ArrowchatWarningsAdd-arrowchat_warnings-add'); // add
    $app->any('/ArrowchatWarningsView[/{id}]', ArrowchatWarningsController::class . ':view')->add(PermissionMiddleware::class)->setName('ArrowchatWarningsView-arrowchat_warnings-view'); // view
    $app->any('/ArrowchatWarningsEdit[/{id}]', ArrowchatWarningsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArrowchatWarningsEdit-arrowchat_warnings-edit'); // edit
    $app->any('/ArrowchatWarningsDelete[/{id}]', ArrowchatWarningsController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArrowchatWarningsDelete-arrowchat_warnings-delete'); // delete
    $app->group(
        '/arrowchat_warnings',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ArrowchatWarningsController::class . ':list')->add(PermissionMiddleware::class)->setName('arrowchat_warnings/list-arrowchat_warnings-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ArrowchatWarningsController::class . ':add')->add(PermissionMiddleware::class)->setName('arrowchat_warnings/add-arrowchat_warnings-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ArrowchatWarningsController::class . ':view')->add(PermissionMiddleware::class)->setName('arrowchat_warnings/view-arrowchat_warnings-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ArrowchatWarningsController::class . ':edit')->add(PermissionMiddleware::class)->setName('arrowchat_warnings/edit-arrowchat_warnings-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ArrowchatWarningsController::class . ':delete')->add(PermissionMiddleware::class)->setName('arrowchat_warnings/delete-arrowchat_warnings-delete-2'); // delete
        }
    );

    // kanban
    $app->any('/Kanban[/{params:.*}]', KanbanController::class)->add(PermissionMiddleware::class)->setName('Kanban-kanban-custom'); // custom

    // tbl_status
    $app->any('/TblStatusList[/{id}]', TblStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('TblStatusList-tbl_status-list'); // list
    $app->any('/TblStatusAdd[/{id}]', TblStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('TblStatusAdd-tbl_status-add'); // add
    $app->any('/TblStatusView[/{id}]', TblStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('TblStatusView-tbl_status-view'); // view
    $app->any('/TblStatusEdit[/{id}]', TblStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('TblStatusEdit-tbl_status-edit'); // edit
    $app->any('/TblStatusDelete[/{id}]', TblStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('TblStatusDelete-tbl_status-delete'); // delete
    $app->group(
        '/tbl_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', TblStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('tbl_status/list-tbl_status-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', TblStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('tbl_status/add-tbl_status-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', TblStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('tbl_status/view-tbl_status-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', TblStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('tbl_status/edit-tbl_status-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', TblStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('tbl_status/delete-tbl_status-delete-2'); // delete
        }
    );

    // tbl_task
    $app->any('/TblTaskList[/{id}]', TblTaskController::class . ':list')->add(PermissionMiddleware::class)->setName('TblTaskList-tbl_task-list'); // list
    $app->any('/TblTaskAdd[/{id}]', TblTaskController::class . ':add')->add(PermissionMiddleware::class)->setName('TblTaskAdd-tbl_task-add'); // add
    $app->any('/TblTaskView[/{id}]', TblTaskController::class . ':view')->add(PermissionMiddleware::class)->setName('TblTaskView-tbl_task-view'); // view
    $app->any('/TblTaskEdit[/{id}]', TblTaskController::class . ':edit')->add(PermissionMiddleware::class)->setName('TblTaskEdit-tbl_task-edit'); // edit
    $app->any('/TblTaskDelete[/{id}]', TblTaskController::class . ':delete')->add(PermissionMiddleware::class)->setName('TblTaskDelete-tbl_task-delete'); // delete
    $app->group(
        '/tbl_task',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', TblTaskController::class . ':list')->add(PermissionMiddleware::class)->setName('tbl_task/list-tbl_task-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', TblTaskController::class . ':add')->add(PermissionMiddleware::class)->setName('tbl_task/add-tbl_task-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', TblTaskController::class . ':view')->add(PermissionMiddleware::class)->setName('tbl_task/view-tbl_task-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', TblTaskController::class . ':edit')->add(PermissionMiddleware::class)->setName('tbl_task/edit-tbl_task-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', TblTaskController::class . ':delete')->add(PermissionMiddleware::class)->setName('tbl_task/delete-tbl_task-delete-2'); // delete
        }
    );

    // tablero_participante
    $app->any('/TableroParticipante[/{params:.*}]', TableroParticipanteController::class)->add(PermissionMiddleware::class)->setName('TableroParticipante-tablero_participante-custom'); // custom

    // linea_tiempo
    $app->any('/LineaTiempo[/{params:.*}]', LineaTiempoController::class)->add(PermissionMiddleware::class)->setName('LineaTiempo-linea_tiempo-custom'); // custom

    // timeline_general
    $app->any('/TimelineGeneral[/{params:.*}]', TimelineGeneralController::class)->add(PermissionMiddleware::class)->setName('TimelineGeneral-timeline_general-custom'); // custom

    // timeline_excon
    $app->any('/TimelineExcon[/{params:.*}]', TimelineExconController::class)->add(PermissionMiddleware::class)->setName('TimelineExcon-timeline_excon-custom'); // custom

    // documentos
    $app->any('/Documentos[/{params:.*}]', DocumentosController::class)->add(PermissionMiddleware::class)->setName('Documentos-documentos-custom'); // custom

    // editGrupos
    $app->any('/EditGrupos[/{params:.*}]', EditGruposController::class)->add(PermissionMiddleware::class)->setName('EditGrupos-editGrupos-custom'); // custom

    // evento_asociado
    $app->any('/EventoAsociadoList', EventoAsociadoController::class . ':list')->add(PermissionMiddleware::class)->setName('EventoAsociadoList-evento_asociado-list'); // list
    $app->group(
        '/evento_asociado',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', EventoAsociadoController::class . ':list')->add(PermissionMiddleware::class)->setName('evento_asociado/list-evento_asociado-list-2'); // list
        }
    );

    // view_evento_asociado
    $app->any('/ViewEventoAsociadoList', ViewEventoAsociadoController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewEventoAsociadoList-view_evento_asociado-list'); // list
    $app->group(
        '/view_evento_asociado',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewEventoAsociadoController::class . ':list')->add(PermissionMiddleware::class)->setName('view_evento_asociado/list-view_evento_asociado-list-2'); // list
        }
    );

    // inject_excon
    $app->any('/InjectExcon[/{params:.*}]', InjectExconController::class)->add(PermissionMiddleware::class)->setName('InjectExcon-inject_excon-custom'); // custom

    // inject_participante
    $app->any('/InjectParticipante[/{params:.*}]', InjectParticipanteController::class)->add(PermissionMiddleware::class)->setName('InjectParticipante-inject_participante-custom'); // custom

    // pizarra
    $app->any('/Pizarra[/{params:.*}]', PizarraController::class)->add(PermissionMiddleware::class)->setName('Pizarra-pizarra-custom'); // custom

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->any('/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // change_password
    $app->any('/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // userpriv
    $app->any('/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
