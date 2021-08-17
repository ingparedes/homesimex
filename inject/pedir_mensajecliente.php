<?php 
session_start();

include("../config.php");

$idUsers = $_SESSION['id_user'];
$idMensaje = $_GET['idMensaje'];
//Creamos la conexión



//generamos la consulta
$sql = "SELECT
mensajes_usuarios.id_user_destinatario, 
mensajes.id_inyect, 
DATE_FORMAT( mensajes.fechareal_start, '%Y/%m/%d %H:%i' ) AS fstar, 
DATE_FORMAT( mensajes.fechasim_start, '%Y/%m/%d %H:%i' ) AS fstarsim, 
mensajes.titulo, 
mensajes.mensaje, 
archivos_doc.file_name,
mensajes.adjunto, 
IF(	actor_simulado.nombre_actor IS NULL, 'EXCON', nombre_actor) as actor,
mensajes.enviado
FROM mensajes INNER JOIN mensajes_usuarios 	ON  mensajes.id_inyect = mensajes_usuarios.id_mensaje 
LEFT JOIN archivos_doc 	ON  mensajes.adjunto = archivos_doc.id_file 
LEFT JOIN actor_simulado 	ON mensajes.id_actor = actor_simulado.id_actor
WHERE
    mensajes.enviado = 1 AND mensajes_usuarios.id_user_destinatario = $idUsers AND mensajes.id_inyect = $idMensaje ORDER BY fechareal_start DESC";
mysqli_set_charset($con, "utf8");



if(!$result = mysqli_query($con,$sql)){
	echo("Error description: " . mysqli_error($con));
	echo "hay un error en la base de datos";
	die();
}

$clientes = array(); //creamos un array

$msgprogramado = [];


while($row = mysqli_fetch_array($result)) 
{ 
    $nombre_usuario=$row['actor'];
    $titulo_mensaje=$row['titulo'];
	$mensaje=$row['mensaje'];
    $fstar=$row['fstar'];
    $fstarsim = $row['fstarsim'];
	$filename =  $row['file_name'];
	$adjunto =  $row['adjunto'];
    $id=$row['id_inyect'];
  
    
	array_push($msgprogramado,
		[
			"nombre_usuario"=> $nombre_usuario,
			"titulo_mensaje"=> $titulo_mensaje, 
			"mensaje"=>$mensaje,
			"fstar"=> $fstar,
            "fstarsim"=> $fstarsim,
			"filename" => $filename,
			"adjunto" => $adjunto,
			"id"=>intval($id)
		]
	);
}

    
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