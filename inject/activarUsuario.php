<?php 



$idUsuario = $_GET['idUsuario'];//1

//Creamos la conexión
include "conexion.php";

$sql = "
UPDATE `users` SET `estado`=1, `perfil`=3 WHERE `id_users`=$idUsuario; 
";
//echo $sql;
mysqli_set_charset($conexion, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$result = mysqli_query($conexion,(string)$sql);


	if(!$result){
		echo("Error description: " . mysqli_error($conexion));
		echo "hay un error en la base de datos";
		die();
				}


if($result)
echo 'exito';

    
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  
header('Location:' . getenv('HTTP_REFERER'));

?>