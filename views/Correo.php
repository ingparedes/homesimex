<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Correo = &$Page;

?>
<?php
$idmsg = $_GET["idmsg"];
$sql_mail = ExecuteRow("SELECT e.tiempo,
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
e.id_mensaje = $idmsg");
?>

<div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><?php echo $Language->phrase("leerCorreo"); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5><?php echo $sql_mail["sujeto"]?></h5>
                <h6><?php echo $Language->phrase( "de"); ?> <?php echo $sql_mail["destino"]?>
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
                <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> <?php echo $Language->phrase( "respuesta"); ?></button>
                <button type="button" class="btn btn-default"><i class="fas fa-share"></i> <?php echo $Language->phrase( "reenviar"); ?></button>
              </div>
             </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>

<?= GetDebugMessage() ?>
