<?php
session_start();
$id_user = $_SESSION['id_user'];

include("config.php");

$ei = 0;
$et = 0;

if ($id_user == '-1') {
    echo "baduser";
} else {
    switch ($_GET['accion']) {
        case "loadTL": // carga los items en el TimeLine
            header('Content-Type: application/json ');
            if (isset($_GET['pg'])) {
                if ($_GET['pg'] == 'Grupo') {
                    $id_escenario = $_SESSION['id_escenario'];
                    $grupo = "t.id_grupo AS 'group', ";
                    $where = "t.id_escenario = '" . $id_escenario . "'";
                } elseif ($_GET['pg'] == 'participante') {
                    $grupo = "";
                    $where = "mu.id_user_remitente = '" . $id_user . "' AND m.enviado = '1'";
                } elseif ($_GET['pg'] == 'excon') {
                    $id_grupo = $_SESSION['id_grupo'];
                    $grupo = "t.id_grupo AS 'group', ";
                    $where = "t.id_grupo = '" . $id_grupo . "'";
                }
            } else {
                $grupo = "";
                $where = "mu.id_user_remitente = '" . $id_user . "'";
            }
            $sql_items = "SELECT DISTINCT(m.id_inyect), CONCAT('M:',m.id_inyect) as id," . $grupo . " CONCAT('M:',m.id_inyect,':', m.titulo) AS content, m.fechareal_start AS start
            FROM mensajes m 
            INNER JOIN mensajes_usuarios mu ON m.id_inyect = mu.id_mensaje
            INNER JOIN users u ON mu.id_user_remitente = u.id_users
            INNER JOIN actor_simulado a ON m.id_actor = a.id_actor    
            INNER JOIN tareas t ON m.id_tarea = t.id_tarea
            WHERE " . $where . " ORDER BY m.id_inyect DESC;";
            //WHERE mu.id_user_destinatario = '$id_user' AND m.medios IN ('2','3') ORDER BY m.id_inyect DESC;";        

            $res_sql = mysqli_query($con, $sql_items);
            if (mysqli_num_rows($res_sql) > 0) {
                while ($items = mysqli_fetch_assoc($res_sql)) {
                    //$arrayI[] = $items;
                    $arrayI[] = array_map('utf8_encode', $items);
                }
            } else {
                echo "no existen registros";
                $ei++;
            }
            if ($_GET['pg'] != 'participante') {
                $sql_tareas = "SELECT DISTINCT(t.id_tarea), concat('T:',t.id_tarea) AS id," . $grupo . " CONCAT('T:',t.id_tarea,':', t.titulo_tarea) AS content, t.fechainireal_tarea AS start, t.fechafin_tarea AS end, 'color: white; background-color: blue;' AS style, valoracion as valora, CONCAT('background-color:',color,'; color:white;') AS style
                FROM tareas t WHERE t.id_tarea IN (SELECT  distinct(m.id_tarea)
                FROM mensajes m 
                INNER JOIN mensajes_usuarios mu ON m.id_inyect = mu.id_mensaje
                INNER JOIN users u ON mu.id_user_remitente = u.id_users
                INNER JOIN actor_simulado a ON m.id_actor = a.id_actor
                WHERE " . $where . ");";

                $res_tareas = mysqli_query($con, $sql_tareas);
                if (mysqli_num_rows($res_tareas) > 0) {
                    while ($tareas = mysqli_fetch_assoc($res_tareas)) {
                        $arrayT[] = array_map('utf8_encode', $tareas);
                    }
                } else {
                    echo "no existen registros";
                    $et++;
                }

                if (($ei == 0) && ($et == 0)) {
                    $array = array_merge($arrayI, $arrayT);
                    $json = json_encode($array);
                    echo $json;
                } else {
                    echo "Sin datos";
                }
            } else {
                $json = json_encode($arrayI);
                echo $json;
            }
            break;
        case "saveTL": // guarda la nueva fecha de las tareas y mensajes editadas en Timeline

            //date_default_timezone_set('America/Bogota');
            $fechaIn = $_POST['start'];

            if (isset($_POST['end'])) {
                $fechaFn = date($_POST['end']);
                $fechaIn = date($_POST['start']);
                $sql_items = "UPDATE tareas SET fechainireal_tarea ='" . $fechaIn . "', fechafin_tarea = '" . $fechaFn . "'  WHERE  id_tarea='" . $_POST['id'] . "';";
                $res_sql = mysqli_query($con, $sql_items);
                if ($res_sql) {
                    echo 'ok';
                } else {
                    echo "error al guardar";
                }
            }
            $date = date($fechaIn);
            //echo $fechaIn . "<br>";
            $sql_items = "UPDATE mensajes set fechareal_start ='" . $date . "' WHERE id_inyect ='" . $_POST['id'] . "';";
            $res_sql = mysqli_query($con, $sql_items);
            if ($res_sql) {
                echo 'ok';
            } else {
                echo "error al guardar";
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
                $sel_ItemMsj = "SELECT t.titulo_tarea AS titulo, t.descripcion_tarea AS descripcion, 'T' AS tipo, valoracion as valora FROM tareas t WHERE t.id_tarea ='" . $id . "';";
            } elseif ($tipo == 'M') {
                $sel_ItemMsj = "SELECT m.titulo AS titulo, m.mensaje AS descripcion, 'M' AS tipo FROM mensajes m WHERE m.id_inyect = '" . $id . "';";
            }
            $res_ItemMsj = mysqli_query($con, $sel_ItemMsj);
            $ItemMsj = mysqli_fetch_array($res_ItemMsj, MYSQLI_ASSOC);
            $json[] = array_map('utf8_encode', $ItemMsj);
            echo json_encode($json);
            // var_dump($ItemMsj);
            break;
        case  "saveItemMsj": // guarda los datos editados desde la modal
            if ($_POST['tipo'] == "T") {
                $sql_items = "UPDATE tareas SET titulo_tarea ='" . $_POST['titulo'] . "', descripcion_tarea = '" . $_POST['desc'] . "', valoracion = '" . $_POST['valorar'] . "', color = '" . $_POST['color'] . "'  WHERE  id_tarea='" . $_POST['id'] . "';";
            } elseif ($_POST['tipo'] == "M") {
                $sql_items = "UPDATE mensajes SET titulo ='" . $_POST['titulo'] . "', mensaje = '" . $_POST['desc'] . "'  WHERE  id_inyect='" . $_POST['id'] . "';";
            }
            $res_sql = mysqli_query($con, $sql_items);
            if ($res_sql) {
                echo 'ok';
            } else {
                echo "error al guardar";
            }
            break;
        case "loadGruposTL": //llena los grupos en el timeline
            header('Content-Type: application/json');
            if ($_GET['pg'] == 'excon') {
                
                $where = "g.id_grupo = '" . $_SESSION['id_grupo'] . "';";
            } else {
                $where = "e.estado = '1';";
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
    }
}
