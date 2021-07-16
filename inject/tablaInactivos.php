<?php 

//Creamos la conexión
include "conexion.php";
//generamos la consulta
$sql = "
SELECT * FROM `users` WHERE estado is null or estado=''; 
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
    $fecha=$row['fecha'];
    $nombres=$row['nombres'];
    $apellidos=$row['apellidos'];
	$grupo=$row['grupo'];
    $subgrupo=$row['subgrupo'];
    $perfil=$row['perfil'];
    $email=$row['email'];
    $telefono=$row['telefono'];
    $pais=$row['pais'];
    $estado=$row['estado'];
    $imagen='';//NO HAY IMAGEN
    
    
	array_push($msgprogramado,
		[
			"id"=> intval($id),
			"fecha"=> $fecha, 
			"nombres"=> $nombres,
            "apellidos"=>$apellidos,
            "grupo"=>$grupo,
            "subgrupo"=>$subgrupo,
            "perfil"=>$perfil,
            "email"=>$email,
            "telefono"=>$telefono,
            "pais"=>$pais,
            "estado"=>$estado,
            "imagen"=>$imagen
			
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