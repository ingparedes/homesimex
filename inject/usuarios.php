
<?php 
session_start();

$idGrupo = $_GET['idGrupo'];//0;
//Creamos la conexión
include "conexion.php";

//generamos la consulta
$sql = "
SELECT 
`id_users`, 
`img_user`, 
`fecha`, 
`nombres`, 
`apellidos`, 
`email`, 
`telefono`, 
`pais`, 
`escenario`, 
`estado`, 
`horario`
FROM 
`users` 
WHERE 
`grupo`=$idGrupo
and `subgrupo`=0
";

mysqli_set_charset($conexion, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8


if(!$result = mysqli_query($conexion,$sql)){
	echo("Error description: " . mysqli_error($conexion));
	echo "hay un error en la base de datos";
	die();
}


$msgprogramado = [];


while($row = mysqli_fetch_array($result)) 
{ 
    $id=$row['id_users'];
    $img_user=$row['img_user'];
    $nombre=$row['nombres'].' '.$row['apellidos'];
	$email=$row['email'];
	$telefono=$row['telefono'];
	$pais=$row['pais'];
	$escenario=$row['escenario'];
	$estado=$row['estado'];
	$horario=$row['horario'];

    
    
	array_push($msgprogramado,
		[
			"nombre"=> $nombre,
			"grupo"=>$idGrupo,
			"img_user"=> $img_user, 
			"email"=> $email,
			"telefono"=> $telefono,
			"pais"=> $pais,
			"escenario"=> $escenario,
			"estado"=> $estado,
			"horario"=> $horario,
			"id"=> intval($id)

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