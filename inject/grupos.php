
<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$server = "localhost";
$user = "root";
$pass = "";
$bd = "simexamerica";
$idescenario = $_GET['idescenario'];

//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");


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