<?php
session_start();
$iduser = $_SESSION['iduser'];
include("config.php");
echo $iduser;
$query = "SELECT DISTINCT
tareas.titulo_tarea, 
mensajes.id_inyect, 
DATE_FORMAT(mensajes.fechareal_start, '%Y/%m/%d %H:%m') fstar, 
DATE_FORMAT(mensajes.fechasim_start, '%Y/%m/%d %H:%m') fstarsim,
mensajes.titulo, 
mensajes.mensaje, 
mensajes.medios, 
mensajes.actividad_esperada, 
mensajes_usuarios.id_user_destinatario, 
mensajes_usuarios.leido, 
mensajes_usuarios.id_user_remitente, 
tareas.id_tarea, 
archivos_doc.file_name, 
archivos_doc.fecha_created, 
actor_simulado.nombre_actor
FROM
mensajes
INNER JOIN
tareas
ON 
    mensajes.id_tarea = tareas.id_tarea
INNER JOIN
mensajes_usuarios
ON 
    mensajes.id_inyect = mensajes_usuarios.id_mensaje
LEFT JOIN
archivos_doc
ON 
    mensajes.adjunto = archivos_doc.id_file
left JOIN
actor_simulado
ON 
    mensajes.id_actor = actor_simulado.id_actor
WHERE
mensajes.enviado = 1 AND id_user_destinatario = $iduser
ORDER BY
mensajes.fechareal_start DESC";
$resultado = mysqli_query($con, $query);

echo mysqli_affected_rows($con);

?>


<?php  while($row=mysqli_fetch_array($resultado)){ ?>
                  <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left"><?php if ($row["nombre_actor"] == NULL) { echo "EXCON"; } else {
                          echo $row["nombre_actor"];
                      };   ?></span>
                      <span class="direct-chat-timestamp float-right">   <i class="far fa-clock"></i> <?php echo "Tiempo Real: ".$row["fstar"]."<br>   <i class='far fa-clock'></i> Tiempo Simulado: ".$row["fstarsim"] ?></span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="./files/avatar_msg.png" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                    <div class = "header">
                       <h4>  Titulo mensaje: <?php echo utf8_encode($row["titulo"]);  ?>  </h4> 
                       <span><em> Titulo tarea: <?php echo utf8_encode($row["titulo_tarea"]);  ?> </em></span>
                        <div> 
                            <hr>
                           <em> Mensaje: </em><br> 
                    <?php echo utf8_encode($row["mensaje"]).$id_user;?>
                    <hr>
            <div class="timeline-footer">
               <a href="javascript:;" class="m-r-15 text-inverse-lighter"><i class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i> Like</a>
             
               <a href="javascript:;" class="m-r-15 text-inverse-lighter"><i class="fa fa-comments fa-fw fa-lg m-r-3"></i> Comment</a> 
               <a class="btn btn-default btn-sm ew-add-edit ew-add" title="" data-caption="Nuevo" href="#" onclick="return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'SubgrupoAdd?showmaster=grupo&amp;fk_id_grupo=63'});" data-original-title="Nuevo"><i data-phrase="AddLink" class="fas fa-plus ew-icon" data-caption="Nuevo"></i></a>
            </div>
                
            </div>
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->
                  


    <?php } ?> 

<?php  mysqli_close($con);
?>