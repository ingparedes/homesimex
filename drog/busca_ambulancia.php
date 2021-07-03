<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $cod_casopreh = $_GET['cod_casopreh'];

    $sql = "SELECT \"ambulancias\".\"id_ambulancias\", \"ambulancias\".\"cod_ambulancias\",
  \"ambulancias\".\"placas\", \"ambulancias\".\"chasis\", \"ambulancias\".\"marca\",
  \"ambulancias\".\"modelo\", \"ambulancias\".\"tipo_translado\",
  \"ambulancias\".\"tipo_conbustible\", \"ambulancias\".\"modalidad\",
  \"ambulancias\".\"estado\", \"ambulancias\".\"ubicacion\", \"ambulancias\".\"disponible\",
  \"ambulancias\".\"fecha_iniseguro\", \"ambulancias\".\"fecha_finseguro\",
  \"ambulancias\".\"entidad\", \"ambulancias\".\"observacion\",
  \"ambulancias\".\"asiganda\", \"ambulancias\".\"config_manteni\",
  \"ambulancias\".\"fecha_creacion\", \"ambulancias\".\"longitudambulancia\",
  \"ambulancias\".\"latituambulancia\", \"ambulancias\".\"especial\",
  \"tipo_ambulancia\".\"id_tipotransport\", \"tipo_ambulancia\".\"tipo_amb_es\",
  \"tipo_ambulancia\".\"tipo_amb_en\", \"tipo_ambulancia\".\"tipo_amb_pr\",
  \"tipo_ambulancia\".\"tipo_amb_fr\", \"tipo_ambulancia\".\"codigo\",
  \"especial_ambulancia\".\"id_especialambulancia\",
  \"especial_ambulancia\".\"especial_es\", \"especial_ambulancia\".\"especial_en\",
  \"especial_ambulancia\".\"especial_pr\", \"especial_ambulancia\".\"especial_fr\",
  \"hospitalesgeneral\".\"depto_hospital\", \"sector_ambulancia\".\"nombre_sector\"
FROM (((\"ambulancias\" LEFT JOIN
        \"tipo_ambulancia\" ON \"ambulancias\".\"tipo_translado\" =
          \"tipo_ambulancia\".\"id_tipotransport\") LEFT JOIN
      \"especial_ambulancia\" ON \"ambulancias\".\"especial\" =
        \"especial_ambulancia\".\"id_especialambulancia\") LEFT JOIN
    \"hospitalesgeneral\" ON (\"ambulancias\".\"asiganda\")::TEXT =
      (\"hospitalesgeneral\".\"id_hospital\")::TEXT) LEFT JOIN
  \"sector_ambulancia\" ON \"ambulancias\".\"sector\" = \"sector_ambulancia\".\"id\"";
    ?>

    $html = ExecuteRows
</body>

</html>