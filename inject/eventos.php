<?php 



//Creamos la conexión
include "conexion.php";
$fecha_inicial = date("Y/m/d H:i", time() - 216000);
$fecha_final = date("Y/m/d H:i");


//generamos la consulta
$sql = "
SELECT
	mensajes.id_inyect
FROM
mensajes_usuarios INNER JOIN mensajes ON mensajes_usuarios.id_mensaje = mensajes.id_inyect
WHERE
    mensajes.enviado = 1 AND
	mensajes.fechareal_start BETWEEN '$fecha_inicial' AND '$fecha_final';
";

mysqli_set_charset($conexion, "utf8");

if(!$result = mysqli_query($conexion,$sql)){
	echo("Error description: " . mysqli_error($conexion));
	die();
}

$clientes = array(); //creamos un array

$msgprogramado = [];

function openURL($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


while($row = mysqli_fetch_array($result)) 
{ 
    $publishKey = 'pub-c-74306dc6-f082-4bc8-9e59-18804033f25d';
    $subscribeKey = 'sub-c-834f0024-caec-11eb-bdc5-4e51a9db8267';
    $canal = 'canal-02';
    $data = '%7B%0A%22code%22%3A'.$row['id_inyect'].'%0A%7D';
    $url = 'https://ps.pndsn.com/publish';
    echo openURL($url."/".$publishKey."/".$subscribeKey."/0/".$canal."/myCallback/".$data);
}
    
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

?>