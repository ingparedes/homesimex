<?php
include("config.php");
 
$iduser = 17;

 
$consulta ="
SELECT DISTINCT
tareas.titulo_tarea, 
mensajes.id_inyect, 
DATE_FORMAT(mensajes.fechareal_start, '%Y/%m/%d %H:%m') fstar, 
DATE_FORMAT(mensajes.fechasim_start, '%Y/%m/%d %H:%m') fstarsim,
mensajes.titulo, 
mensajes.mensaje, 
mensajes.medios, 
mensajes.actividad_esperada, 
mensajes_usuarios.id_user_destinatario, 
mensajes_usuarios.leido, 
mensajes_usuarios.id_user_remitente, 
tareas.id_tarea, 
archivos_doc.file_name, 
archivos_doc.fecha_created, 
actor_simulado.nombre_actor
FROM
mensajes
INNER JOIN
tareas
ON 
    mensajes.id_tarea = tareas.id_tarea
INNER JOIN
mensajes_usuarios
ON 
    mensajes.id_inyect = mensajes_usuarios.id_mensaje
LEFT JOIN
archivos_doc
ON 
    mensajes.adjunto = archivos_doc.id_file
left JOIN
actor_simulado
ON 
    mensajes.id_actor = actor_simulado.id_actor
WHERE
mensajes.enviado = 1 AND id_user_destinatario = $iduser
ORDER BY
mensajes.fechareal_start DESC
";
$resultado = mysqli_query($con, $consulta);

mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $consulta)) die();

$query_msg = array(); //creamos un array

while($row = mysqli_fetch_array($result)) 
{ 
    $id=$row['id_inyect'];
    $nombre_usuario=$row['nombre_actor'];
    $titulo_mensaje=$row['titulo'];
    $titulo_tarea=$row['titulo_tarea'];
    $mensaje=$row['mensaje'];
          

    $query_msg[] = array('id'=> $id, 'nombre_usuario'=> $nombre_usuario, 'titulo_mensaje'=> $titulo_mensaje, 'titulo_tarea'=> $titulo_tarea,
                         'mensaje'=> $mensaje);
                         
}
var_dump($query_msg);
//desconectamos la base de datos
$close = mysqli_close($con) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  

//Creamos el JSON
$json_string = json_encode($query_msg);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>