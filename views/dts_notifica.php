<?php


session_start();
include("config.php");
$id_user = $_SESSION['id_user'];

header('Content-Type: application/json');
$id_user = $_SESSION['id_user'];

if ($_GET['accion'] != 'timeline') {
    $medio =  $_POST['idDiv'];

    if ($_POST['idDiv'] == "tweeter") {
        $medio = 3;
    } elseif ($_POST['idDiv'] == "facebook") {
        $medio = 2;
    }

  $sql = "select count(*) as cant, m.medios from mensajes_usuarios mu 
    INNER JOIN mensajes m ON m.id_inyect = mu.id_mensaje
    WHERE m.enviado = '1' and leido = '0' and mu.id_user_destinatario IN ('" . $id_user . "') AND m.medios = '" . $medio . "';";
  $res_sql = mysqli_query($con, $sql);
  $sql_leido = mysqli_fetch_array($res_sql, MYSQLI_ASSOC);
  //var_dump($sql_leido);
  $respuesta = json_encode($sql_leido);
  echo $respuesta;

}else{
    echo "time line";
    $sql_items = "SELECT m.titulo AS content, m.fechasim_start AS start 
    FROM mensajes m 
    INNER JOIN mensajes_usuarios mu ON m.id_inyect = mu.id_mensaje
    INNER JOIN users u ON mu.id_user_remitente = u.id_users
    INNER JOIN actor_simulado a ON m.id_actor = a.id_actor
    WHERE mu.id_user_destinatario = '" . $id_user . "' AND m.enviado = '1' AND m.medios IN ('2','3') ORDER BY m.id_inyect DESC;";
    $res_sql = mysqli_query($con, $sql_items);
    while ($items = mysqli_fetch_assoc($res_sql)) {
        $array[] = $items;
    }
    $json = json_encode($array);
    print_r($json);
  }
