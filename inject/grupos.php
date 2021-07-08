
<?php 
session_start();
include("../config.php");

//Creamos la conexión
$idescenario = $_GET["idescenario"];
//generamos la consulta
$sql = "
SELECT 
`id_grupo`, 
`nombre_grupo`, 
`descripcion_grupo`, 
`imgen_grupo`, 
`color`, 
`id_escenario`, 
`color_grup` 
FROM `grupo`
where id_escenario = $idescenario
";

mysqli_set_charset($con, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8


if(!$result = mysqli_query($con,$sql)){
	echo("Error description: " . mysqli_error($con));
	echo "hay un error en la base de datos";
	die();
}


$msgprogramado = [];


while($row = mysqli_fetch_array($result)) 
{ 
    $id=$row['id_grupo'];
    $nombre_grupo=$row['nombre_grupo'];
    $descripcion_grupo=$row['descripcion_grupo'];
	$imgen_grupo=$row['imgen_grupo'];
	$color=$row['color'];
	$id_escenario=$row['id_escenario'];
	$color_grup=$row['color_grup'];

    
    
	array_push($msgprogramado,
		[
			"nombre"=> $nombre_grupo,
			"descripcion_grupo"=> $descripcion_grupo, 
			"imgen_grupo"=> $imgen_grupo, 
			"color"=> $color,
			"id_escenario"=> $id_escenario,
			"color_grup"=> $color_grup,
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