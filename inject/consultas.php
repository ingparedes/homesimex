<?php 
    $data = [];
    array_push($data,
        [
            "avatar"=>"https://images.heb.com/is/image/HEBGrocery/000402266?fit=constrain,1&wid=800&hei=800&fmt=jpg&qlt=85,0&resMode=sharp2&op_usm=1.75,0.3,2,0",
            "nombre_usuario"=>"Juan Perez",
            "titulo_mensaje"=>"Consume Gansito",
            "titulo_tarea"=>"mejor opcion",
            "mensaje"=>"el mejor precio junto con la mejor opcion",
            "id"=>4
        ]);
    array_push($data,
        [
            "avatar"=>"https://images.heb.com/is/image/HEBGrocery/000402266?fit=constrain,1&wid=800&hei=800&fmt=jpg&qlt=85,0&resMode=sharp2&op_usm=1.75,0.3,2,0",
            "nombre_usuario"=>"Maria Soto",
            "titulo_mensaje"=>"Consume Gansito",
            "titulo_tarea"=>"mejor opcion",
            "mensaje"=>"el mejor precio junto con la mejor opcion",
            "id"=>7
        ]);
    array_push($data,
        [
            "avatar"=>"https://pm1.narvii.com/7039/3430a5f90fb2d55871c979b14d9792cb6618b627r1-1184-698v2_hq.jpg",
            "nombre_usuario"=>"Maria Dolores",
            "titulo_mensaje"=>"Titulo Random",
            "titulo_tarea"=>"tarea random",
            "mensaje"=>"es de conocimienco comun que el fuego quema",
            "id"=>4
        ]);

    echo json_encode($data);
?>