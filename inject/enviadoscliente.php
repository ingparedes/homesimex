<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$server = "localhost";
$user = "root";
$pass = "";
$bd = "simexamerica";

$idUsers =  $_SESSION['id_user'];
//$idMensaje = $_GET['idMensaje'];
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");


//generamos la consulta
$sql = "SELECT
mensajes_usuarios.id_user_destinatario, 
mensajes.id_inyect, 
DATE_FORMAT( mensajes.fechareal_start, '%Y/%m/%d %H:%i' ) AS fstar, 
DATE_FORMAT( mensajes.fechasim_start, '%Y/%m/%d %H:%i' ) AS fstarsim, 
mensajes.titulo, 
mensajes.mensaje, 
archivos_doc.file_name, 
IF(	actor_simulado.nombre_actor IS NULL, 'EXCON', nombre_actor) as actor,
mensajes.enviado
FROM mensajes INNER JOIN mensajes_usuarios 	ON  mensajes.id_inyect = mensajes_usuarios.id_mensaje 
LEFT JOIN archivos_doc 	ON  mensajes.adjunto = archivos_doc.id_file 
LEFT JOIN actor_simulado 	ON mensajes.id_actor = actor_simulado.id_actor
WHERE mensajes_usuarios.enviado = 1 AND mensajes_usuarios.id_user_destinatario = $idUsers ORDER BY fechareal_start DESC";

mysqli_set_charset($conexion, "utf8");

if(!$result = mysqli_query($conexion,$sql)){
	echo("Error description: " . mysqli_error($conexion));
	echo "hay un error en la base de datos";
	die();
}

$clientes = array(); //creamos un array

$msgprogramado = [];


while($row = mysqli_fetch_array($result)) 
{ 
    $actor=$row['actor'];
    $titulo_mensaje=$row['titulo'];
	$mensaje=$row['mensaje'];
    $fstar=$row['fstar'];
    $fstarsim = $row['fstarsim'];
    $id=$row['id_inyect'];
    $filename = $row['file_name'];
	$sq2 = "
	SELECT
		calificacion.descripcion

	FROM
		mensajes
		left JOIN
		calificacion_mensajes
		ON 
			mensajes.id_inyect = calificacion_mensajes.id_mensaje
		left JOIN
		calificacion
		ON 
			calificacion_mensajes.id_calificacion = calificacion.id_calificacion
	WHERE
		mensajes.id_inyect = $id
	";

	mysqli_set_charset($conexion, "utf8");
	//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
	$result2 = mysqli_query($conexion,$sq2);
	if(!$result2){
		echo("Error description: " . mysqli_error($conexion));
		echo "hay un error en la base de datos";
		die();
	}
	$row1 = mysqli_fetch_array($result2);
	
	if(!$row1['descripcion'])//EN CASO DE NO HABER CALIFICACIÓN
	{
		$calificacion="Pendiente";
	}
	else{
		$calificacion=$row1['descripcion'];
	}
    
	array_push($msgprogramado,
		[
			"actor"=> $actor,
			"titulo_mensaje"=> $titulo_mensaje, 
			"mensaje"=>$mensaje,
			"fstar"=> $fstar,
            "fstarsim"=> $fstarsim,
			"calificacion"=>$calificacion,
            "id"=>intval($id),
            "filename"=> $filename
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