<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>

<?php
include("../config.php");
$idmsg = $_GET["idmsg"];
$sql_mail = "SELECT e.tiempo,
e.sujeto, 
e.mensaje, 
us.id_user_remitente, 
us.id_user_destinatario, 
us.id_mensaje, 
CONCAT(usdes.nombres,' ',usdes.apellidos) AS destino, 
CONCAT(usrem.nombres,' ',usrem.apellidos) AS remite, 
archivos_doc.file_name
FROM
email AS e
INNER JOIN
user_email AS us
ON 
  e.id_email = us.id_email
INNER JOIN
users AS usdes
ON 
  us.id_user_destinatario = usdes.id_users
INNER JOIN
users AS usrem
ON 
  us.id_user_remitente = usrem.id_users
LEFT JOIN
archivos_doc
ON 
  e.archivo = archivos_doc.id_file
WHERE
e.id_email = $idmsg";

mysqli_set_charset($con, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
if(!$result = mysqli_query($con,$sql_mail)){
	echo("Error description: " . mysqli_error($con));
	die();
}

$sql_mail = mysqli_fetch_array($result)
?>
  </head>
  <body>

<div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Leer Correo</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5><?php echo $sql_mail["sujeto"]?></h5>
                <h6>De: <?php echo $sql_mail["destino"]?>
                  <span class="mailbox-read-time float-right"><?php echo $sql_mail["tiempo"]?></span></h6>
              </div>
               <!-- /.btn-group -->
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <p><?php echo $sql_mail["mensaje"]?> </P>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->
            
            <!-- /.card-footer -->
            <div class="card-footer">
              <div class="float-right">
                <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
              </div>
             </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>