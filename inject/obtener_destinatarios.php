<?php 

include("../config.php");

$idMensaje = $_GET['idMensaje'];
//Creamos la conexión


//generamos la consulta
$sql = "
SELECT users.nombres, 
	users.apellidos 
	FROM users 
	INNER JOIN 
	mensajes_usuarios 
	ON users.id_users= mensajes_usuarios.id_user_destinatario 
	WHERE 
	mensajes_usuarios.id_mensaje=$idMensaje
";



mysqli_set_charset($con, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8


if(!$result = mysqli_query($con,$sql)){
	echo("Error description: " . mysqli_error($con));
	die();
}


$msgprogramado1 = [];

while($row = mysqli_fetch_array($result)) 
	{ 
	    $destinatario=$row['nombres'].' '.$row['apellidos'];
	    
		array_push($msgprogramado1,
			[
				"destinatario"=> $destinatario
			]
		);
	}

    
//desconectamos la base de datos
$close = mysqli_close($con) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  
//var_dump($msgprogramado);
//Creamos el JSON
$json_string = json_encode($msgprogramado1, JSON_UNESCAPED_UNICODE );

echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>