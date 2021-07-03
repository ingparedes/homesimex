<?php

namespace PHPMaker2021\simexamerica;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(250, "mi_inject_excon", $MenuLanguage->MenuPhrase("250", "MenuText"), $MenuRelativePath . "InjectExcon", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}inject_excon.php'), false, false, "", "", false);
$sideMenu->addMenuItem(251, "mi_inject_participante", $MenuLanguage->MenuPhrase("251", "MenuText"), $MenuRelativePath . "InjectParticipante", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}inject_participante.php'), false, false, "", "", false);
$sideMenu->addMenuItem(246, "mi_documentos", $MenuLanguage->MenuPhrase("246", "MenuText"), $MenuRelativePath . "Documentos", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}documentos.php'), false, false, "cil-folder-open", "", false);
$sideMenu->addMenuItem(1, "mi_escenario", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "EscenarioList", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}escenario'), false, false, "cil-airplay", "", false);
$sideMenu->addMenuItem(36, "mci_config", $MenuLanguage->MenuPhrase("36", "MenuText"), "", -1, "", true, false, true, "cil-cog", "", false);
$sideMenu->addMenuItem(18, "mi_tipo", $MenuLanguage->MenuPhrase("18", "MenuText"), $MenuRelativePath . "TipoList", 36, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}tipo'), false, false, "cil-bug", "", false);
$sideMenu->addMenuItem(17, "mi_incidente", $MenuLanguage->MenuPhrase("17", "MenuText"), $MenuRelativePath . "IncidenteList", 36, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}incidente'), false, false, "cil-rain", "", false);
$sideMenu->addMenuItem(10, "mi_paisgmt", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "PaisgmtList", 36, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}paisgmt'), false, false, "cil-globe-alt", "", false);
$sideMenu->addMenuItem(137, "mci_Correo", $MenuLanguage->MenuPhrase("137", "MenuText"), "", -1, "", true, false, true, "cib-gmail", "", false);
$sideMenu->addMenuItem(12, "mi_email2", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "Email2List", 137, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}email'), false, false, "cil-envelope-closed", "", false);
$sideMenu->addMenuItem(139, "mi_imbox_mail", $MenuLanguage->MenuPhrase("139", "MenuText"), $MenuRelativePath . "ImboxMailList", 137, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}imbox_mail'), false, false, "cil-inbox", "", false);
$sideMenu->addMenuItem(33, "mci_usuarios", $MenuLanguage->MenuPhrase("33", "MenuText"), "", -1, "", true, false, true, "cil-user", "", false);
$sideMenu->addMenuItem(13, "mi_users", $MenuLanguage->MenuPhrase("13", "MenuText"), $MenuRelativePath . "UsersList?cmd=resetall", 33, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}users'), false, false, "cil-people", "", false);
$sideMenu->addMenuItem(48, "mi_grupos", $MenuLanguage->MenuPhrase("48", "MenuText"), $MenuRelativePath . "Grupos", 33, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}grupos.php'), false, false, "", "", false);
$sideMenu->addMenuItem(20, "mi_userlevels", $MenuLanguage->MenuPhrase("20", "MenuText"), $MenuRelativePath . "UserlevelsList", 33, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}userlevels'), false, false, "cil-layers", "", false);
$sideMenu->addMenuItem(40, "mi_chat_ini", $MenuLanguage->MenuPhrase("40", "MenuText"), $MenuRelativePath . "ChatIni", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}chat_ini.php'), false, false, "cil-chat-bubble", "", false);
$sideMenu->addMenuItem(96, "mi_biblioteca", $MenuLanguage->MenuPhrase("96", "MenuText"), $MenuRelativePath . "Biblioteca", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}biblioteca.php'), false, false, "cil-library", "", false);
$sideMenu->addMenuItem(57, "mi_tablero_excon", $MenuLanguage->MenuPhrase("57", "MenuText"), $MenuRelativePath . "TableroExcon", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}tablero_excon.php'), false, false, "cil-equalizer", "", false);
$sideMenu->addMenuItem(171, "mi_timeline_general", $MenuLanguage->MenuPhrase("171", "MenuText"), $MenuRelativePath . "TimelineGeneral", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}timeline_general.php'), false, false, "cil-list-rich", "", false);
$sideMenu->addMenuItem(169, "mi_tablero_participante", $MenuLanguage->MenuPhrase("169", "MenuText"), $MenuRelativePath . "TableroParticipante", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}tablero_participante.php'), false, false, "cil-equalizer", "", false);
$sideMenu->addMenuItem(172, "mi_timeline_excon", $MenuLanguage->MenuPhrase("172", "MenuText"), $MenuRelativePath . "TimelineExcon", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}timeline_excon.php'), false, false, "cil-list-rich", "", false);
$sideMenu->addMenuItem(245, "mci_Ejecución", $MenuLanguage->MenuPhrase("245", "MenuText"), "", 172, "", true, false, true, "cil-featured-playlist", "", false);
$sideMenu->addMenuItem(6, "mi_inicio", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "Inicio", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}inicio.php'), false, false, "cil-airplay", "", false);
echo $sideMenu->toScript();
