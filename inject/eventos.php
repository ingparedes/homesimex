<?php 

include("../config.php");

//Creamos la conexión


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

mysqli_set_charset($con, "utf8");

if(!$result = mysqli_query($con,$sql)){
	echo("Error description: " . mysqli_error($con));
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
    $publishKey = 'pub-c-5260e585-8e9b-4d60-9ff8-1d10154850f4';
    $subscribeKey = 'sub-c-69a803ce-dbfd-11eb-85de-ba1258ebcf9d';
    $canal = 'canal-02';
    $data = '%7B%0A%22code%22%3A'.$row['id_inyect'].'%0A%7D';
    $url = 'https://ps.pndsn.com/publish';
    echo openURL($url."/".$publishKey."/".$subscribeKey."/0/".$canal."/myCallback/".$data);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

?>