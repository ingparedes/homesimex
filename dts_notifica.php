<?php
session_start();

$id_user = $_SESSION['id_user'];

include("config.php");

$ei = 0;
$et = 0;

$utcescenario = "SELECT p.gmt, RIGHT(p.gmt,6) as mins2 FROM escenario e INNER JOIN paisgmt p ON e.pais_escenario = p.id_zone INNER JOIN users u ON e.id_escenario = u.escenario
WHERE u.id_users = '" . $id_user . "';";


$res_sqlutc = mysqli_query($con, $utcescenario);
$sqlutc = mysqli_fetch_assoc($res_sqlutc);

$utces=$sqlutc['mins2'];

 

$minutc = $sqlutc['mins'].' minutes';

$utc_usr = "SELECT RIGHT(paisgmt.gmt,6) as usrutc FROM paisgmt INNER JOIN users ON paisgmt.id_zone = users.pais WHERE users.id_users ='" . $id_user . "';";
$res_usr= mysqli_query($con, $utc_usr);
$sqlutcusr = mysqli_fetch_assoc($res_usr);
$utcusr=$sqlutcusr['usrutc'];

$minUScutc = (intval(substr($utcusr,'1','2')) * 60) + intval(substr($utcusr,'-2'));
$minEScutc = (intval(substr($utces,'1','2')) * 60) + intval(substr($utces,'-2'));
$resutcfinal = $minUScutc- $minEScutc;
//echo $resutcfinal;
if ( $utcusr == $utces)
{$utcusr2 =  '-05:00';}
else
{$utcusr2 =  $utcusr;}

//var_dump ($minutc);
//echo $minutc;
if ($id_user == '-1') {
    echo "baduser";
} else {
    switch ($_GET['accion']) {
        case "notifica":

            if ($_POST['idDiv'] == "tweeter") {
                $medio = 3;
            } elseif ($_POST['idDiv'] == "facebook") {
                $medio = 2;
            }
            $sql = "select count(*) as cant, m.medios from mensajes_usuarios mu 
            INNER JOIN mensajes m ON m.id_inyect = mu.id_mensaje
            WHERE leido = '0' and mu.id_user_destinatario IN ('" . $id_user . "') AND m.medios = '" . $medio . "';";
            $res_sql = mysqli_query($con, $sql);
            $sql_leido = mysqli_fetch_assoc($res_sql);
           // echo $sql_leido['cant'];
            break;
        case "loadTL": // carga los items en el TimeLine
            header('Content-Type: application/json charset=utf-8');
            if (isset($_GET['pg'])) {
                if ($_GET['pg'] == 'Grupo') {
                    if ($_GET['idEscenario'] != "") {
                        $id_escenario = $_GET['idEscenario'];
                    } else {
                        $id_escenario = $_SESSION['id_escenario'];
                        //echo "Escenario Session:" . $_SESSION['id_escenario'];
                    }
                    $grupo = "t.id_grupo AS 'group', ";
                    $where = "t.id_escenario = '" . $id_escenario . "'";
                } elseif ($_GET['pg'] == 'participante') {
                    $id_grupo = $_SESSION['id_grupo'];
                    $grupo = "t.id_grupo AS 'group', ";
                    $where = "mu.id_user_destinatario = '" . $id_user . "' AND m.enviado = '1'";
                } elseif ($_GET['pg'] == 'excon') {
                    $id_grupo = $_SESSION['id_grupo'];
                    $grupo = "t.id_grupo AS 'group', ";
                    $where = "t.id_grupo = '" . $id_grupo . "'";
                }
            } else {
                $grupo = "";
                $where = "mu.id_user_remitente = '" . $id_user . "'";
            }
            $sql_items = "SELECT DISTINCT(m.id_inyect), 
                            CONCAT('M:',m.id_inyect) as id,t.id_grupo AS 'group', 
                            CONCAT('M:',m.id_inyect,':', m.titulo) AS content, 
                            CONVERT_TZ(m.fechareal_start,'".$utces."','".$utcusr2."') AS start,
                            CONVERT_TZ(m.fechareal_start,'".$utces."','".$utcusr2."') AS endFalso,
                            m.id_tarea, cm.id_calificacion AS 'calificacion',
                            t.fechainireal_tarea AS InicioRango,
                            t.fechafin_tarea AS FinRango
                            FROM mensajes m 
                            INNER JOIN mensajes_usuarios mu 
                            ON m.id_inyect = mu.id_mensaje 
                            INNER JOIN users u 
                            ON mu.id_user_destinatario = u.id_users 
                            LEFT JOIN actor_simulado a 
                            ON m.id_actor = a.id_actor 
                            INNER JOIN tareas t ON m.id_tarea = t.id_tarea 
                            INNER JOIN escenario e ON e.id_escenario = t.id_escenario
                            INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario
                            LEFT JOIN calificacion_mensajes cm ON cm.id_mensaje=m.id_inyect 
                            WHERE " . $where . " ORDER BY start ASC;";

            //WHERE mu.id_user_destinatario = '$id_user' AND m.medios IN ('2','3') ORDER BY m.id_inyect DESC;";        
           // echo $sql_items;
            $res_sql = mysqli_query($con, $sql_items);
            $cantM = mysqli_num_rows($res_sql);
            if ($cantM > 0) {
                while ($items = mysqli_fetch_assoc($res_sql)) {
                    //$arrayI[] = $items;
                    //var_dump($items['estado']);
                    if ($items['enviado'] == '1') {
                        // color azul - Mensaje Enviado
                        $color = array("style" => "color: #f8f9f9; background-color: blue;");
                        $editable = array("editable" => false);
                        $arrayI[] = array_merge(array_map('utf8_encode', $items), $color, $editable);
                        

                    } else {
                        //Color Azul - Mensaje  no enviado
                        if($items['calificacion']==2)
                        {
                            $color = array("style" => "color: black; background-color: Gold;");

                        }
                        else if($items['calificacion']==3)
                        {
                            $color = array("style" => "color: #f8f9f9; background-color: green;");
                        }
                        else{
                            $color = array("style" => "color: #f8f9f9; background-color: blue;");
                        }
                        
                        $arrayI[] = array_merge(array_map('utf8_encode', $items), $color);
                        //$arrayI[] = array_map('utf8_encode', $items);
                    }
                }
            } else {
                //echo "no existen registros";
                $ei++;
            }
            $json = json_encode($arrayI);
            if ($_GET['pg'] == 'Grupo') {
                //$id_escenario = $_SESSION['id_escenario'];
                $sql_tareas = "SELECT DISTINCT(t.id_tarea), concat('T:',t.id_tarea) AS id,t.id_tarearelacion AS id_tarearelacion,t.id_grupo AS 'group',  CONCAT('T:',t.id_tarea,':', t.titulo_tarea) AS content,
                
                CONVERT_TZ(t.fechainireal_tarea,'".$utces."','".$utcusr2."') AS start,
                CONVERT_TZ(t.fechafin_tarea,'".$utces."','".$utcusr2."') AS end,
                'color: white; background-color: blue;' AS style, valoracion as valora, CONCAT('background-color:','LightSlateGray','; color:white;') AS style
               FROM tareas t 
               INNER JOIN escenario e ON e.id_escenario = t.id_escenario
               INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario
                WHERE t.id_escenario = '" . $id_escenario . "'";
                //echo $sql_tareas;
            } elseif ($_GET['pg'] == 'excon') {
                $sql_tareas = "SELECT DISTINCT(t.id_tarea), concat('T:',t.id_tarea) AS id,t.id_tarearelacion AS id_tarearelacion,t.id_grupo AS 'group',  CONCAT('T:',t.id_tarea,':', t.titulo_tarea) AS content,
                
                CONVERT_TZ(t.fechainireal_tarea,'".$utces."','".$utcusr2."') AS start,
                CONVERT_TZ(t.fechafin_tarea,'".$utces."','".$utcusr2."') AS end,
                'color: white; background-color: blue;' AS style, valoracion as valora, CONCAT('background-color:','LightSlateGray','; color:white;') AS style
               FROM tareas t 
               INNER JOIN escenario e ON e.id_escenario = t.id_escenario
               INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario
               WHERE t.id_grupo = '" . $id_grupo . "'";
             } else{//TAREAS PARTICIPANTE
                $sql_tareas = "SELECT DISTINCT(t.id_tarea), concat('T:',t.id_tarea) AS id,t.id_tarearelacion AS id_tarearelacion,t.id_grupo AS 'group',  CONCAT('T:',t.id_tarea,':', t.titulo_tarea) AS content,
                CONVERT_TZ(t.fechainireal_tarea,'".$utces."','".$utcusr2."') AS start,
                CONVERT_TZ(t.fechafin_tarea,'".$utces."','".$utcusr2."') AS end,
                'color: white; background-color: blue;' AS style, valoracion as valora, CONCAT('background-color:','LightSlateGray','; color:white;') AS style
                FROM mensajes m 
                            INNER JOIN mensajes_usuarios mu 
                            ON m.id_inyect = mu.id_mensaje 
                            INNER JOIN users u 
                            ON mu.id_user_destinatario = u.id_users 
                            LEFT JOIN actor_simulado a 
                            ON m.id_actor = a.id_actor 
                            INNER JOIN tareas t ON m.id_tarea = t.id_tarea 
                            INNER JOIN escenario e ON e.id_escenario = t.id_escenario
                            INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario
                            LEFT JOIN calificacion_mensajes cm ON cm.id_mensaje=m.id_inyect 
                            WHERE " . $where . ";";
             }
            
            //if ($_GET['pg'] != 'participante') {
                $res_tareas = mysqli_query($con, $sql_tareas);
                $cantT = mysqli_num_rows($res_tareas);
                if ($cantT > 0) {

                    while ($tareas = mysqli_fetch_assoc($res_tareas)) {
                        $arrayT[] = array_map('utf8_encode', $tareas);
                    }
                } else {
                    //echo "no existen Tareas";
                    $et++;
                }
                if (($cantM > 0) && ($cantT > 0)) {
                    $array = array_merge($arrayI, $arrayT);
                } elseif (($cantM > 0) && ($cantT == 0)) {
                    $array = $arrayI;
                } elseif (($cantM == 0) && ($cantT > 0)) {
                    $array = $arrayT;
                }
                $json= json_encode($array);
                if (($ei == 0) || ($et == 0)) {
                    $json = json_encode($array);
                    //var_dump($arrayT);
                } elseif ($ei > 0) {
                    echo "Sin datos";
                }
            //}
            echo $json;

            break;
        case "saveTL": // guarda la nueva fecha de las tareas y mensajes editadas en Timeline

            //date_default_timezone_set('America/Bogota');
            $fechaIn = $_POST['start'];
            $tipo = $_POST['tipo'];

            if (isset($_POST['end'])) {
                $fechaFn = date($_POST['end']);
                $fechaIn = date($_POST['start']);

                $fechainicio = strtotime ( $resutcfinal.' minutes', strtotime($fechaIn)) ;
                $fechaSalidaIn 	= date ( 'Y-m-d H:i:s' , $fechainicio );

                $fechafinal = strtotime ( $resutcfinal.' minutes', strtotime($fechaFn)) ;
                $fechaSalidaFn 	= date ( 'Y-m-d H:i:s' , $fechafinal );



                $sql_items = "UPDATE tareas SET fechainireal_tarea ='" . $fechaSalidaIn . "', fechafin_tarea = '" . $fechaSalidaFn . "'  WHERE  id_tarea='" . $_POST['id'] . "';";
                $res_sql = mysqli_query($con, $sql_items);
                if ($res_sql) {
                    echo 'ok';
                } else {
                    echo "error al guardar";
                }
            }
            $date = date($fechaIn);
            $tipom = $_POST['content'];
            $Msj = $tipom[0];
            if ($Msj == 'M') { 
            //echo $fechaIn . "<br>";
            $nuevafecha = strtotime ( $resutcfinal.' minutes', strtotime($fechaIn)) ;
            $fechaSalida 	= date ( 'Y-m-d H:i:s' , $nuevafecha );
            $eventoId = $_POST['id'];
            $sql_items = "UPDATE mensajes set fechareal_start ='" . $fechaSalida . "' WHERE id_inyect ='" . $_POST['id'] . "';";
            $res_sql = mysqli_query($con, $sql_items);
            $eliminarEvent = mysqli_query($con,"DROP EVENT evento_$eventoId");
            $dataEvent = mysqli_query($con,"CREATE EVENT evento_$eventoId ON SCHEDULE AT '$date'  DO UPDATE `mensajes` SET enviado = 1 WHERE id_inyect = $eventoId;");
            if ($res_sql) {
                echo 'ok';
            } else {
                echo "error al guardar";
            }
        }
            break;
        case  "loadMSJ": //muestra en rojo la cant de mensajes no leidos en el tablero
            $medio =  $_POST['idDiv'];

            if ($_POST['idDiv'] == "tweeter") {
                $medio = 3;
            } elseif ($_POST['idDiv'] == "facebook") {
                $medio = 2;
            }
            $sql = "select count(*) as cant, m.medios from mensajes_usuarios mu 
            INNER JOIN mensajes m ON m.id_inyect = mu.id_mensaje
            WHERE leido = '0' and mu.id_user_destinatario IN ('" . $id_user . "') AND m.medios = '" . $medio . "';";
            $res_sql = mysqli_query($con, $sql);
            $sql_leido = mysqli_fetch_array($res_sql, MYSQLI_ASSOC);
            echo $sql_leido[0];
            break;
        case  "loadItemMsj": // llama los datos pata llenar la modal
            header('Content-Type: application/json; charset=latin1');

            $id = $_POST['id'];
            $tipo = $_POST['tipo'];
            if ($tipo == 'T') {
                $sel_ItemMsj = "SELECT  t.id_tarea AS id_tarea, t.id_tarearelacion AS id_tarearelacion, t.fechafinsimulado_tarea AS fechafinsimulado_tarea, t.fechainisimulado_tarea AS fechainisimulado_tarea, t.fechafin_tarea AS fechafin_tarea, t.fechainireal_tarea AS fechainireal_tarea, t.titulo_tarea AS titulo, t.descripcion_tarea AS descripcion, 'T' AS tipo, valoracion as valora FROM tareas t WHERE t.id_tarea ='" . $id . "';";
            } elseif ($tipo == 'M') {
                $sel_ItemMsj = "SELECT   m.titulo AS titulo, m.mensaje AS descripcion, 'M' AS tipo, m.fechareal_start, m.fechasim_start, m.medios, m.para, m.id_actor, m.actividad_esperada, m.adjunto, m.id_tarea FROM mensajes m WHERE m.id_inyect = '" . $id . "';";
            }
            $res_ItemMsj = mysqli_query($con, $sel_ItemMsj);
            $ItemMsj = mysqli_fetch_array($res_ItemMsj, MYSQLI_ASSOC);
            $json[] = array_map('utf8_encode', $ItemMsj);
            echo json_encode($json);
            //echo $sel_ItemMsj;
            // var_dump($ItemMsj);
            break;
        case  "saveItemMsj": // guarda los datos editados desde la modal
            if ($_POST['tipo'] == "T") {
                //$sql_items = "UPDATE tareas SET titulo_tarea ='" . utf8_decode($_POST['titulo']) . "', descripcion_tarea = '" . utf8_decode($_POST['desc']) . "', valoracion = '" . $_POST['valorar'] . "', color = '" . $_POST['color'] . "'  WHERE  id_tarea='" . $_POST['id'] . "';";
                $sql_items = "UPDATE tareas SET valoracion = '" . $_POST['valorar'] . "', color = '" . $_POST['color'] . "'  WHERE  id_tarea='" . $_POST['id'] . "';";
            } elseif ($_POST['tipo'] == "M") {
                $sql_items = "UPDATE mensajes SET titulo ='" . utf8_decode($_POST['titulo']) . "', mensaje = '" . utf8_decode($_POST['desc']) . "'  WHERE  id_inyect='" . $_POST['id'] . "';";
            }
            $res_sql = mysqli_query($con, $sql_items);
            if ($res_sql) {
                echo 'ok';
            } else {
                echo "error al guardar";
            }
            break;
        case "loadGruposTL": //llena los grupos en el timeline
            header('Content-Type: application/json; charset=utf-8');

            if ($_GET['pg'] == 'excon') {

                $where = "g.id_grupo = '" . $_SESSION['id_grupo'] . "';";
            } else {
                if ($_GET['idEscenario'] != '') {
                    $where = "e.id_escenario = '" . $_GET['idEscenario'] . "';";
                } else {
                    $where = "e.estado = '1';";
                }
            }
            $sql_grupo = "SELECT id_grupo AS id, nombre_grupo AS content, concat('color: #000000; background-color: ',color,';') as style 
            FROM grupo g INNER JOIN escenario e ON g.id_escenario = e.id_escenario
            WHERE " . $where;
            //echo $sql_grupo;
            $res_grupo = mysqli_query($con, $sql_grupo);

            if (mysqli_num_rows($res_grupo) > 0) {
                while ($grupo = mysqli_fetch_assoc($res_grupo)) {
                    $arrayG[] = $grupo;
                }
            } else {
                echo "no existen registros";
                $ei++;
            }
            echo json_encode($arrayG);
            break;
        case "addTarea":

            if (($_POST['fechaIniSim'] != '') && ($_POST['fechaFinSim'] != '')) {
                $sql = "INSERT INTO tareas (id_tarearelacion, titulo_tarea, descripcion_tarea, fechainisimulado_tarea, fechafinsimulado_tarea, fechainireal_tarea, fechafin_tarea, archivo, id_grupo, id_escenario) VALUES ('" . $_POST['idTareaRelacion'] . "','" . $_POST['titleTarea'] . "','" . $_POST['descTarea'] . "','" . $_POST['fechaIniReal'] . "','" . $_POST['fechaFinReal'] . "','" . $_POST['fechaIniSim'] . "','" . $_POST['fechaFinSim'] . "','" . $_POST['archivo'] . "','" . $_POST['idGrupo'] . "','" . $_POST['idEscenario'] . "');";
            } else {
                if ($_POST['idTareaRelacion'] != '') {
                    $idRelacion = $_POST['idTareaRelacion'];
                } else {
                    $idRelacion = 0;
                }

                $sql = "INSERT INTO tareas (id_tarearelacion, titulo_tarea, descripcion_tarea, fechainireal_tarea, fechafin_tarea, archivo, id_grupo, id_escenario) VALUES ('" . $idRelacion . "','" . $_POST['titleTarea'] . "','" . $_POST['descTarea'] . "','" . $_POST['fechaIniReal'] . "','" . $_POST['fechaFinReal'] . "','" . $_POST['archivo'] . "','" . $_POST['idGrupo'] . "','" . $_POST['idEscenario'] . "');";
            }

            $res_sql = mysqli_query($con, $sql);
            if ($res_sql) {
                echo 'ok';
            } else {
                echo "error al guardar";
            }
            break;
        case "addMensaje":
            $datosOrig = $_POST;

            $paraOrig = $_POST['para[]'];
            $pruebaPara= $_POST['para'];
            //var_dump($_POST);
            $para = "'" . implode(',', $_POST['para']) . "'";
            $datos = array_pop($_POST);
            $datos = implode(',', $_POST);
            $datos = "'" . str_replace(',', '\',\'', $datos) . "'";
            $id_user = $_SESSION['id_user'];
            //elimina el ultimo elelmento de la lista -> para

            $sql = "INSERT INTO mensajes ( id_tarea, titulo, 
            mensaje, fechareal_start, fechasim_start, medios, 
            actividad_esperada, id_actor, adjunto, para) VALUES 
            ('" . $_POST['e_id_tarea'] . "','" . $_POST['titulo'] . "',
            '" . $_POST['mensaje'] . "','" . $_POST['fechareal_start'] . "',
            '" . $_POST['fechasim_start'] . "','" . $_POST['medios'] . "',
            '" . $_POST['actividad_esperada'] . "','" . $_POST['id_actor'] . "',
            '" . $_POST['adjunto'] . "'," . $para . ");";
            //echo $sql;
            $res_sql = mysqli_query($con, $sql);
            $id_inyect = mysqli_insert_id($con);
            

            //var_dump($paraOrig);
            $temporalUsuarios= explode(',', $para);
            foreach ($temporalUsuarios as $valor) {
                $tmp2 = explode('-', $valor);
                $tipo = $tmp2[0];

                $cod_tipo = $tmp2[1];
                if ($cod_tipo <> '') {
                    if ($tipo == 'G') { //grupos 
                        $sql_users = "SELECT id_users FROM users WHERE grupo = '" . $cod_tipo . ";";
                        //echo $sql_users . "<br>";
                        //echo $sql_users;

                    } 
                    else if ($tipo == 'S') { //subgrupo
                        $sql_users = "SELECT id_users FROM users WHERE subgrupo = '" . $cod_tipo . ";";
                    } 
                    else if ($tipo == 'P') {
                        $usuarios = $cod_tipo;
                        $sql = "INSERT INTO mensajes_usuarios (id_user_remitente, id_user_destinatario, id_mensaje, enviado) VALUES ('" . $id_user . "','" . $usuarios . "', '" . $id_inyect . "', 0);";
                        //echo $sql;
                        $res_sql = mysqli_query($con, $sql);

                        $sql_doc = "INSERT INTO permisos_doc (id_file, id_usuarios, tipo_permiso) VALUES ('" . $_POST['adjunto'] . "','" . $usuarios . "','1');";
                        $res_sql = mysqli_query($con, $sql_doc);

                        $sql_doc_usrs = "INSERT INTO permisos_docusers (id_file, tipo_permiso, id_users) VALUES ('" . $_POST['adjunto'] . "','1','" . $usuarios . "');";
                        $res_sql = mysqli_query($con, $sql_doc_usrs);
                    //    echo 'f1';
                        //aqui voy.. hacer pruebas.. 
                    }
                    if ($tipo != 'P') {
                        $res_sql = mysqli_query($con, $sql_users);
                        $usuariosA=array();
                        if (mysqli_num_rows($res_sql) > 0) {
                            while ($valor = mysqli_fetch_assoc($res_sql)) {
                                array_push($usuariosA,$valor);
                          //      echo 'f2';
                            }
                        }

                        foreach ($usuariosA as $row) {
                            
                            $sql_idUser = "SELECT id_users FROM users WHERE grupo IN (SELECT grupo FROM users WHERE id_users = '" . $id_user . "') AND perfil = '2';";
                            $res_sql = mysqli_query($con, $sql_idUser);
                            $sql_msjs = "INSERT INTO mensajes_usuarios (id_user_remitente, id_user_destinatario, id_mensaje, enviado) VALUES ('" . $id_user . "','" . $row['id_users'] . "', '" . $id_inyect . "',0);";
                            $res_sql = mysqli_query($con, $sql_msjs);
                            $sql_doc = "INSERT INTO permisos_doc (id_file, id_usuarios, tipo_permiso) VALUES ('" . $_POST['adjunto'] . "','" . $row['id_users'] . "','1');";
                            $res_sql = mysqli_query($con, $sql_doc);
                            $sql_doc_usrs = "INSERT INTO permisos_docusers (id_file, tipo_permiso, id_users) VALUES ('" . $_POST['adjunto'] . "','1','" . $row['id_users'] . "');";
                            $res_sql = mysqli_query($con, $sql_doc_usrs);
                      //      echo 'f3';
                        }
                    }
                }
            }
            if ($res_sql) {
                echo  'ok';
            } else {
                echo 'Error al guardar';
            }

            break;
        case "editMensaje":
            $datosOrig = $_POST;
            //var_dump($_POST);
            $paraOrig = $_POST['para[]'];
            $para = "'" . implode(',', $_POST['para']) . "'";
            $datos = array_pop($_POST);
            $datos = implode(',', $_POST);
            $datos = "'" . str_replace(',', '\',\'', $datos) . "'";
            $id_user = $_SESSION['id_user'];
            //elimina el ultimo elelmento de la lista -> para

            $sql = "UPDATE mensajes SET id_tarea = '" . $_POST['e_id_tarea'] . "' , titulo ='" . $_POST['titulo'] . "' , mensaje ='" . $_POST['mensaje'] . "', fechareal_start ='" . $_POST['fechareal_start'] . "', fechasim_start='" . $_POST['fechasim_start'] . "', medios ='" . $_POST['medios'] . "', actividad_esperada ='" . $_POST['actividad_esperada'] . "', id_actor ='" . $_POST['id_actor'] . "', adjunto = '" . $_POST['adjunto'] . "', para =" . $para . " WHERE id_inyect = '" . $_POST['id_inyect'] . "';";
            //echo $sql;
            $res_sql = mysqli_query($con, $sql);
            $id_inyect = mysqli_insert_id($con);
            if ($res_sql) {
                echo 'ok';
            } else {
                echo  $sql;
            }
            $id_inyect = $_POST['id_inyect'];
            //var_dump($paraOrig);
            foreach ($paraOrig as $valor) {
                $tmp2 = explode('-', $valor);
                $tipo = $tmp2[0];

                $cod_tipo = $tmp2[1];
                if ($cod_tipo <> '') {
                    if ($tipo == 'G') { //grupos 
                        $sql_users = "SELECT id_users FROM users WHERE grupo = '" . $cod_tipo . ";";
                        //echo $sql_users . "<br>";

                    } else if ($tipo == 'S') { //subgrupo

                        $sql_users = "SELECT id_users FROM users WHERE subgrupo = '" . $cod_tipo . ";";
                    } else if ($tipo == 'P') {
                        $usuarios = $cod_tipo;
                        $sql = "INSERT INTO mensajes_usuarios (id_user_remitente, id_user_destinatario, id_mensaje) VALUES ('" . $id_user . "','" . $usuarios . "', '" . $id_inyect . "');";
                        //echo $sql;
                        $res_sql = mysqli_query($con, $sql);

                        $sql_doc = "INSERT INTO permisos_doc (id_file, id_usuarios, tipo_permiso) VALUES ('" . $datosOrig['adjunto'] . "','" . $usuarios . "','1');";
                        $res_sql = mysqli_query($con, $sql_doc);

                        $sql_doc_usrs = "INSERT INTO permisos_docusers (id_file, tipo_permiso, id_users) VALUES ('" . $datosOrig['adjunto'] . "','1','" . $usuarios . "');";
                        $res_sql = mysqli_query($con, $sql_doc_usrs);

                        //aqui voy.. hacer pruebas.. 
                    }
                    if ($tipo != 'P') {
                        $res_sql = mysqli_query($con, $sql_users);

                        if (mysqli_num_rows($res_sql) > 0) {
                            while ($valor = mysqli_fetch_assoc($res_sql)) {
                                $usuarios[] = $valor;
                            }
                        }
                        //var_dump($usuarios);
                        if (is_array($usuarios)) {
                            foreach ($usuarios as $row) {
                                $sql_idUser = "SELECT id_users FROM users WHERE grupo IN (SELECT grupo FROM users WHERE id_users = '" . $id_user . "') AND perfil = '2';";
                                $res_sql = mysqli_query($con, $sql_idUser);
                                $sql_msjs = "INSERT INTO mensajes_usuarios (id_user_remitente, id_user_destinatario, id_mensaje) VALUES ('" . $id_user . "','" . $row['id_users'] . "', '" . $id_inyect . "');";
                                $res_sql = mysqli_query($con, $sql_msjs);
                                $sql_doc = "INSERT INTO permisos_doc (id_file, id_usuarios, tipo_permiso) VALUES ('" . $datosOrig['adjunto'] . "','" . $row['id_users'] . "','1');";
                                $res_sql = mysqli_query($con, $sql_doc);
                                $sql_doc_usrs = "INSERT INTO permisos_docusers (id_file, tipo_permiso, id_users) VALUES ('" . $datosOrig['adjunto'] . "','1','" . $row['id_users'] . "');";
                                $res_sql = mysqli_query($con, $sql_doc_usrs);
                            }
                        }
                    }
                }
            }

            break;

        case "getEscenario":
            $sql_escenario = "SELECT p.gmt, e.fechaini_simulado, e.fechafin_simulado, e.id_escenario, g.id_grupo FROM escenario  e INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario INNER JOIN grupo g ON e.id_escenario = g.id_escenario WHERE e.id_escenario ='" . $_GET['idEscnrio'] . "';";
            $res_escenario = mysqli_query($con, $sql_escenario);
            while ($escenario = mysqli_fetch_assoc($res_escenario)) {
                $arraySc[] = array_map('utf8_encode', $escenario);
            }
            if (mysqli_num_rows($res_escenario) > 0) {
                echo json_encode($arraySc);
            } else {
                echo "sinRegistros";
            }
            break;
    }
}
