<?php 
session_start();
$idUser = $_SESSION['id_user'];
//$idUser=1;

//Creamos la conexión
include("../config.php");
$sql = "
    UPDATE `mensajes_usuarios` 
    SET `leido`=1  
    WHERE 
    `id_user_destinatario`= $idUser
";

$con->set_charset("utf8");

if(!$result = $con->query($sql)){
	//echo("Error description: " . mysqli_error($conexion));
    echo "error en la base de datos";
	die();
}

$msgprogramado = [];


array_push($msgprogramado,
    [
        "id"=> intval($con->insert_id)
    ]
);


//desconectamos la base de datos
$close = mysqli_close($con) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($msgprogramado, JSON_UNESCAPED_UNICODE );

echo $json_string;


?>