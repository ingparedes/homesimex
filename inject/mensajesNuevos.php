<?php 


$idUsuario = $_GET['id_user'];
//Creamos la conexión
include "conexion.php";

//generamos la consulta
$sql = "
SELECT
 `id_mensaje_usuario`, 
 `id_user_remitente`, 
 `id_user_destinatario`, 
 `id_mensaje`, 
 `leido`, 
 `enviado` 
 FROM 
 `mensajes_usuarios` 
 WHERE 
 `id_user_destinatario`= $idUsuario and
  `leido`=0
";



mysqli_set_charset($conexion, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8


if(!$result = mysqli_query($conexion,$sql)){
	echo("Error description: " . mysqli_error($conexion));
	die();
}


$msgprogramado1 = [];

while($row = mysqli_fetch_array($result)) 
	{ 
	    $id_mensaje_usuario=$row['id_mensaje_usuario'];
        $id_user_remitente=$row['id_user_remitente'];
        $id_user_destinatario=$row['id_user_destinatario'];
        $id_mensaje=$row['id_mensaje'];
	    
		array_push($msgprogramado1,
			[
				"id_mensaje_usuario"=> $id_mensaje_usuario,
                "id_user_remitente"=> $id_user_remitente,
                "id_user_destinatario"=> $id_user_destinatario,
                "id_mensaje"=> $id_mensaje
                
			]
		);
	}

//desconectamos la base de datos
$close = mysqli_close($conexion) 
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