<?php 
session_start();
include("../config.php");

$idGrupo = $_SESSION['idGrupo'];
//Creamos la conexión


//generamos la consulta
$sql = "
SELECT
	mensajes.id_inyect, 
    DATE_FORMAT( mensajes.fechareal_start, '%Y/%m/%d %H:%i' ) AS fstar, 
	DATE_FORMAT( mensajes.fechasim_start, '%Y/%m/%d %H:%i' ) AS fstarsim, 
	mensajes.titulo, 
	mensajes.mensaje, 
	mensajes.medios, 
	mensajes.id_actor, 
	mensajes.actividad_esperada, 
	mensajes.enviado, 
	tareas.titulo_tarea, 
	tareas.id_grupo, 
	actor_simulado.nombre_actor, 
	IF(	actor_simulado.nombre_actor IS NULL, 'EXCON', nombre_actor) as actor,
	mensajes.adjunto, 
	archivos_doc.file_name

FROM
	mensajes
	INNER JOIN
	tareas
	ON 
		mensajes.id_tarea = tareas.id_tarea
	LEFT JOIN
	actor_simulado
	ON 
		mensajes.id_actor = actor_simulado.id_actor
	LEFT JOIN
	archivos_doc
	ON 
		mensajes.adjunto = archivos_doc.id_file
WHERE
	mensajes.enviado = 1 AND tareas.id_grupo = $idGrupo ORDER BY fechareal_start DESC
";

mysqli_set_charset($con, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8


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
    $titulo_tarea=$row['titulo_tarea'];
	$mensaje=$row['mensaje'];
    $fstar=$row['fstar'];
    $fstarsim = $row['fstarsim'];
	$filename =  $row['file_name'];
	$adjunto =  $row['adjunto'];
    $id=$row['id_inyect'];
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

	mysqli_set_charset($con, "utf8");
	//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
	$result2 = mysqli_query($con,$sq2);
	if(!$result2){
		echo("Error description: " . mysqli_error($con));
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
			"nombre_usuario"=> $nombre_usuario,
			"titulo_mensaje"=> $titulo_mensaje, 
			"titulo_tarea"=> $titulo_tarea, 
			"mensaje"=>$mensaje,
			"fstar"=> $fstar,
            "fstarsim"=> $fstarsim,
			"filename"=> $filename,
			"adjunto"=> $adjunto,
			"calificacion"=>$calificacion,
			"id"=> intval($id)

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