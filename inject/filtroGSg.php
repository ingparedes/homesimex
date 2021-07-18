<?php 
//Creamos la conexión
include "conexion.php";
$funcion= $_GET['funcion'];
//generamos la consulta
mysqli_set_charset($conexion, "utf8");
if($_GET['idUser']<>'0')
{
    $id_user = $_GET['idUser'];
    
    $sqlPermiso="SELECT  `grupo`,`perfil` FROM `users` WHERE `id_users`=$id_user;";
    if(!$resulta = mysqli_query($conexion,$sqlPermiso)){
        echo("Error description: " . mysqli_error($conexion));
        die();
    }
    $msgprogramado1=[];
    while($row = mysqli_fetch_array($resulta)) 
	{ 
        $grupo=$row['grupo'];
        $perfil=$row['perfil'];
        
        array_push($msgprogramado1,
        [
            "id"=>intval($grupo),
            "nombre"=> $perfil
            
        ]
    );
    }    
    
    if($perfil=='1')
    {
        if($funcion=="grupo")
    {
        $sql = "
        SELECT * FROM `grupo` 
        ";

    if(!$result = mysqli_query($conexion,$sql)){
        echo("Error description: " . mysqli_error($conexion));
        die();
    }
    $msgprogramado1 = [];
    while($row = mysqli_fetch_array($result)) 
	{ 
        
        $id=$row['id_grupo'];
        $nombre=$row['nombre_grupo'];
            
            
            array_push($msgprogramado1,
                [
                    "id"=>intval($id),
                    "nombre"=> $nombre
                    
                ]
            );
    }
}
    
	   
}else {
    
    if($funcion=="grupo")
    {
        $sql = "
        SELECT `id_grupo`, `nombre_grupo` FROM `grupo` WHERE `id_grupo`=$grupo;
        ";
    
    if(!$result = mysqli_query($conexion,$sql)){
        echo("Error description: " . mysqli_error($conexion));
        die();
    }
    $msgprogramado1 = [];
    while($row = mysqli_fetch_array($result)) 
        { 
            
            $id=$row['id_grupo'];
            $nombre=$row['nombre_grupo'];
                
                
                array_push($msgprogramado1,
                    [
                        "id"=>intval($id),
                        "nombre"=> $nombre
                        
                    ]
                );
        }
    

}
}
}
if($funcion=='Subgrupo')
{
    $id_grupo= $_GET['idGrupo'];
    $sql = "
    SELECT * FROM `subgrupo` WHERE `id_grupo`=$id_grupo;
    ";

if(!$result = mysqli_query($conexion,$sql)){
	echo("Error description: " . mysqli_error($conexion));
	die();
}
$msgprogramado1 = [];
while($row = mysqli_fetch_array($result)) 
	{ 
        
        $id=$row['id_subgrupo'];
        $nombre=$row['nombre_subgrupo'];
            
            
            array_push($msgprogramado1,
                [
                    "id"=>intval($id),
                    "nombre"=> $nombre
                    
                ]
            );
    }
} else if($funcion=='participanteG'){
    $id= $_GET['id'];
    $sql = "
    SELECT `id_users`, `nombres`, `apellidos` FROM `users` WHERE `grupo`=$id;
    ";

if(!$result = mysqli_query($conexion,$sql)){
	echo("Error description: " . mysqli_error($conexion));
	die();
}
$msgprogramado1 = [];
while($row = mysqli_fetch_array($result)) 
	{ 
        
        $id=$row['id_users'];
        $nombre=$row['nombres'].' '.$row['apellidos'];
            
            
            array_push($msgprogramado1,
                [
                    "id"=>intval($id),
                    "nombre"=> $nombre
                    
                ]
            );
    }
} else if($funcion=='participanteSG'){
    $id= $_GET['id'];
    $sql = "
    SELECT `id_users`, `nombres`, `apellidos` FROM `users` WHERE `subgrupo`=$id;
    ";

if(!$result = mysqli_query($conexion,$sql)){
	echo("Error description: " . mysqli_error($conexion));
	die();
}
$msgprogramado1 = [];
while($row = mysqli_fetch_array($result)) 
	{ 
        
        $id=$row['id_users'];
        $nombre=$row['nombres'].' '.$row['apellidos'];
            
            
            array_push($msgprogramado1,
                [
                    "id"=>intval($id),
                    "nombre"=> $nombre
                    
                ]
            );
    }
}
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
//Creamos el JSON
if($msgprogramado1==[])
{
    echo 'Vacio';
}
else{
    $json_string = json_encode($msgprogramado1, JSON_UNESCAPED_UNICODE );
    echo $json_string;
}
    

?>