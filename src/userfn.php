<?php

namespace PHPMaker2021\simexamerica;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions

// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding(&$item) {
    if ($item->Text == "Download")
        $item->Icon = "fa-download";
    if ($item->Text == "Something")
        $item->Label = "<small class=\"label float-right bg-green\">new</small>"; // Label shows on the right hand side of the menu item (for vertical menu only)
    return true;
}

function Menu_Rendering($menu) {
    if (IsLoggedIn()){
$UserName = CurrentUserInfo("nombres");
$ape = CurrentUserInfo("apellidos");
$imgs = CurrentUserInfo("img_user");
$idu = CurrentUserID("id_users");
$UserPer = CurrentUserInfo("perfil");
$UserPermissionValue = ExecuteScalar("SELECT UserLevelName FROM userlevels WHERE UserLevelID = " . $UserPer);
$UserGrupo = CurrentUserInfo("grupo"); 
$UserG = ExecuteScalar("SELECT nombre_grupo FROM grupo WHERE id_grupo =" . $UserGrupo);
$fe = date("Y/m/d");
//
 if (!empty($imgs))
{$fotos = $imgs;}
else
{$fotos = 'silueta.png';};

//echo ". "."<img src='images/user.png'>"." ".$UserName." "."<img src='images/key.png'>"." ".$UserPermissionValue." "."<img src='images/date.png'>"." ".$UserDate." ";
};
    if ($menu->Id == "menu") { // Sidebar menu or change from "menu" to "navbar" for top menu
       // $menu->addMenuItem(444, "usuario", "<div> <div class='image'> <img class='img-circle elevation-1' width='45px'  height='45px' src='http://localhost/homesimex/files/$imgs'> <strong> ".$UserName.' '.$ape."</strong> <p> <small class='text-muted'> ".$UserPermissionValue."  ".$UserG."  </small></P></div></div>  " , "UsersView/$idu?showdetail", -1, "", IsLoggedIn());
        $menu->addMenuItem(444, "usuario","<div class='card-body pt-0'><div class='row'><div class='col-2'><img src='http://localhost/homesimex/files/$fotos'   width='45px'  height='45px' alt='user-avatar' class='img-circle'></div><div class='col-10'><b class = 'float-right'>".$UserName.' '.$ape."</b><ul class='ml-10 mb-0 fa-ul'><li class='small'> ".$UserPermissionValue."</li> <li class='small'> ".$UserG."</li></ul></div></div></div>", "/homesimex/UsersList", -1, "", IsLoggedIn());
        $menu->moveItem("Simulaciones", $menu->Count() - 1); // Move to last
         $menu->moveItem("Linea de tiempo total", $menu->Count() - 1); // Move to last
        $menu->moveItem("Linea de tiempo grupo", $menu->Count() - 1); // Move to last
        $menu->moveItem("Tablero usuario", $menu->Count() - 1); // Move to last
        $menu->moveItem("Tablero total", $menu->Count() - 1); // Move to last
        $menu->moveItem("Mymail", $menu->Count() - 1); // Move to last
        $menu->moveItem("Chat", $menu->Count() - 1); // Move to last
        $menu->moveItem("Multimedia", $menu->Count() - 1); // Move to last
        $menu->moveItem("Documentos", $menu->Count() - 1); // Move to
        $menu->moveItem("Administrador tareas", $menu->Count() - 1); // Move to last
        $menu->moveItem("Usuarios", $menu->Count() - 1); // Move to last
        $menu->moveItem("Configuración", $menu->Count() - 1); // Move to last
    };
  if ($menu->Id == "navbar") { // Sidebar menu or change from "menu" to "navbar" for top menu
  	$menu->addMenuItem(456, "usuario", "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" , "#", -1, "", IsLoggedIn());
  	$menu->addMenuItem(457, "usuario", "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" , "#", -1, "", IsLoggedIn());
  	$menu->addMenuItem(455, "usuario", "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" , "#", -1, "", IsLoggedIn());
    $menu->addMenuItem(459, "usuario", "<div class='border rounded bg-light col-sm-12'> <span class='info-box-icon'><i class='cil-clock'></i></span> <small class='text-center'> Hora local del Usuario </small> <h5 > <div class='text-center' style='line-height:10px' id='clocklocal'></div> </h5> <h6 class='text-center' style='line-height:10px'> $fe </h6>  </div>" , "#", -1, "", IsLoggedIn());
    $menu->addMenuItem(458, "usuario", "<div class='border rounded bg-light col-sm-12'> <span class='info-box-icon'><i class='cil-clock'></i></span> <small class='text-center'> Hora real del pa&iacute;s del ejercico</small> <h5> <div class='text-center' style='line-height:10px' id='clockreal'></div> </h5>  <h6 class='text-center' style='line-height:10px'> $fe </h6>  </div>" , "#", -1, "", IsLoggedIn());
    $menu->addMenuItem(460, "usuario", " <div class='border rounded bg-light col-sm-12'> <span class='info-box-icon'><i class='cil-clock'></i></span> <small class='text-center'> Hora de salto de tiempo</small> <h5 > <div class='text-center' style='line-height:10px'> 08:25:15</div> </h5> <h6 class='text-center' style='line-height:10px'> $fe </h6>  </div>" , "#", -1, "", IsLoggedIn());
   }
}

function Menu_Rendered($menu)
{
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
        global $EW_XSS_ARRAY;
    //$EW_XSS_ARRAY = array_diff($EW_XSS_ARRAY, array("<embed", "<object", "<iframe", "<frame", "<frameset"));
$uID = CurrentUserID();
$sqlutescenario = ExecuteScalar("SELECT p.gmt, e.fechaini_simulado, e.fechafin_simulado, e.fechaini_real, e.fechafinal_real FROM escenario  e INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario WHERE e.estado IN ('1')");
$sqlutcuser = ExecuteScalar("SELECT paisgmt.gmt FROM users LEFT JOIN paisgmt ON users.pais = paisgmt.id_zone WHERE id_users ='".$uID."'");
if ((!empty($sqlutcuser)) && (!empty($sqlutescenario))){
SetClientVar("sqlutc",$sqlutescenario);
SetClientVar("sqlutcuser",$sqlutcuser);
}
else{
SetClientVar("sqlutc",'UTC +00:00');
SetClientVar("sqlutcuser",'UTC +00:00');
}
 $_SESSION['userid'] = CurrentUserID();
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}
$DATA_STRING_MAX_LENGTH = 65535;
