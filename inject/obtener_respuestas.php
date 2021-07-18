<?php 
$idMensaje = $_GET['idMensaje'];
//Creamos la conexión
include "conexion.php";

//generamos la consulta
$sql = "
SELECT 
`id_email`, `sender_userid`, `copy_sender`, `reciever_userid`, `sujeto`, `mensaje`, `tiempo`, `archivo`, `estado_msg`, `id_mensaje` 
FROM 
`email` 
WHERE `id_mensaje`=$idMensaje
";



mysqli_set_charset($conexion, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8


if(!$result = mysqli_query($conexion,$sql)){
	echo("Error description: " . mysqli_error($conexion));
	die();
}


$msgprogramado1 = [];

while($row = mysqli_fetch_array($result)) 
	{ 
        if($row['id_email'])
        {
            $id=$row['id_email'];
            if($row['estado_msg'])
            {
                $estado_msg=$row['estado_msg'];
            }
            else{
                $estado_msg=0;
            }
            
            $sujeto=$row['sujeto'];
            
            
            array_push($msgprogramado1,
                [
                    "id"=>intval($id),
                    "sujeto"=> $sujeto,
                    "estado_msg"=> $estado_msg
                    
                ]
            );

        }
	   
	}

    
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  
//var_dump($msgprogramado);
//Creamos el JSON
if($msgprogramado1==[])
{
    echo 'Vacio';
}
else{
    $json_string = json_encode($msgprogramado1, JSON_UNESCAPED_UNICODE );
    echo $json_string;
}

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>