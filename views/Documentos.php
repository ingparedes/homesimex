<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Documentos = &$Page;
?>
<div class="card">
    <div class="card-header"><strong>Mis documentos</strong> </div>
    <div class="card-body">
        <?php 
$idUs = CurrentUserID();
$sql_doc = "SELECT
file_name ,
concat('<a class=\"btn btn-default ew-row-link ew-view\" data-table=\"escenario\" href=\"PermisosDocAdd?showmaster=archivos_doc&amp;fk_id_file=',id_file,'\" ><i class=\"fa fa-list-alt\" ></i></a>') as Compartir,
concat('<a class=\"btn btn-default ew-row-link ew-view\" data-caption=\"Ver\" href=\"./ArchivosDocView/',id_file,'?showdetail=\" data-original-title=\"Ver\"><i data-phrase=\"ViewLink\" class=\"icon-view ew-icon\" data-caption=\"Ver\"></i></a>',
'<a class=\"btn btn-default ew-row-link ew-delete\" onclick=\"return ew.confirmDelete(this);\" data-caption=\"Delete\" href=\"./ArchivosDocDelete/',id_file,'\" data-original-title=\"Delete\"><i data-phrase=\"DeleteLink\" class=\"fas fa-trash ew-icon\" data-caption=\"Delete\"></i></a>') as Control
FROM archivos_doc
WHERE id_users =$idUs";
$sql_docompartir = "SELECT archivos_doc.file_name,
	archivos_doc.fecha_created,
concat('<a class=\"btn btn-default ew-row-link ew-view\" data-caption=\"Ver\" href=\"/homesimex/PermisosDocusersView/',permisos_docusers.id_permisiosuser,'?showdetail=\" data-original-title=\"Ver\"><i data-phrase=\"ViewLink\" class=\"icon-view ew-icon\" data-caption=\"Ver\"></i></a>') as Control
FROM
permisos_docusers
INNER JOIN
archivos_doc
ON 
permisos_docusers.id_file = archivos_doc.id_file
WHERE permisos_docusers.id_users = $idUs";

?>
<div class="btn-group btn-group-sm ew-btn-group"><a class="btn btn-default ew-add-edit ew-add" title="" data-caption="Nuevo" href="/homesimex/ArchivosDocAdd?showdetail=" data-original-title="Nuevo"><i data-phrase="AddLink" class="fas fa-plus ew-icon" data-caption="Nuevo"></i></strong></strong></a></div>
<?php
echo ExecuteHtml($sql_doc, array("horizontal" => TRUE, "fieldcaption" => TRUE, "tablename" => array("archivos_doc")));


        ?>

        
    </div>
</div>

<div class="card">
    <div class="card-header"><strong>Documentos compartidos conmigo </strong></div>
    <div class="card-body">
    <?php
 
echo ExecuteHtml($sql_docompartir, array("horizontal" => TRUE, "fieldcaption" => TRUE, "tablename" => array("permisos_docusers","archivos_doc")) );
?>
        </div>
   </div>

<script>

$(document).ready(function(){

$('tr').addClass("ew-table-header");
});

</script>

<?= GetDebugMessage() ?>
