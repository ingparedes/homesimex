
<?php 
session_start();


$idGrupo = $_GET['idGrupo'];//64;
//Creamos la conexión
include "conexion.php";

//generamos la consulta
$sql = "
SELECT 
`id_subgrupo`,
`nombre_subgrupo`,
`descripcion_subgrupo`,
`imagen_subgrupo`
FROM `subgrupo` 
WHERE 
`id_grupo`=$idGrupo
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
    $id=$row['id_subgrupo'];
    $nombre_subgrupo=$row['nombre_subgrupo'];
    $descripcion_subgrupo=$row['descripcion_subgrupo'];
	$imagen_subgrupo=$row['imagen_subgrupo'];

    
    
	array_push($msgprogramado,
		[
			"nombre"=> $nombre_subgrupo,
			"descripcion_subgrupo"=> $descripcion_subgrupo, 
			"imagen_subgrupo"=> $imagen_subgrupo, 
			"idGrupo"=>$idGrupo,
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