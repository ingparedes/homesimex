<?php 

include("../config.php");

if(!($idSubGrupo = $_GET['idSubGrupo']))
{
	$idSubGrupo=0;//POR si es solo al grupo
	echo "XD";
}
$idGrupo = $_GET['idGrupo'];
$idUsuario=$_GET['idUsuario'];
//Creamos la conexión
$con = mysqli_connect($server, $user, $pass,$bd) 
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
mysqli_set_charset($con, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$result = mysqli_query($con,(string)$sql);
if(!$result){
	echo("Error description: " . mysqli_error($con));
	echo "hay un error en la base de datos";
	die();
}


    
//desconectamos la base de datos
$close = mysqli_close($con) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

header('Location:' . getenv('HTTP_REFERER'));

?>