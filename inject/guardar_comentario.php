<?php 
session_start();

include("../config.php");

$idMensaje = $_POST['idMensaje'];
$idUser = $_SESSION['id_user'];
$comentario = $_POST['comentario'];

//Creamos la conexión

$sql = "
    INSERT INTO resmensaje (id_users,id_inyect,resmensaje,resadjunto)
    VALUES ($idUser,$idMensaje,'$comentario',NULL);
";

mysqli_set_charset($con, "utf8");

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

//var_dump($msgprogramado);
//Creamos el JSON
$json_string = json_encode($msgprogramado, JSON_UNESCAPED_UNICODE );

echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/

?>