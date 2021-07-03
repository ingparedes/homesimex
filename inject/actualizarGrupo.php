<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$server = "localhost";
$user = "root";
$pass = "";
$bd = "simexamerica";

if(!($idSubGrupo = $_GET['idSubGrupo']))
{
	$idSubGrupo=0;//POR si es solo al grupo
	echo "XD";
}
$idGrupo = $_GET['idGrupo'];
$idUsuario=$_GET['idUsuario'];
//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

//generamos la consulta
$sql = "
UPDATE `users` 
SET `grupo`=$idGrupo,
`subgrupo`=$idSubGrupo 
WHERE 
`id_users`=$idUsuario
";
echo $sql;
mysqli_set_charset($conexion, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$result = mysqli_query($conexion,(string)$sql);
if(!$result){
	echo("Error description: " . mysqli_error($conexion));
	echo "hay un error en la base de datos";
	die();
}


    
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

header('Location:' . getenv('HTTP_REFERER'));

?>