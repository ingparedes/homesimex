<?php

namespace PHPMaker2021\simexamerica;

// Table
$archivos_doc = Container("archivos_doc");
?>
<?php if ($archivos_doc->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_archivos_docmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($archivos_doc->file_name->Visible) { // file_name ?>
        <tr id="r_file_name">
            <td class="<?= $archivos_doc->TableLeftColumnClass ?>"><?= $archivos_doc->file_name->caption() ?></td>
            <td <?= $archivos_doc->file_name->cellAttributes() ?>>
<span id="el_archivos_doc_file_name">
<span<?= $archivos_doc->file_name->viewAttributes() ?>>
<?= GetFileViewTag($archivos_doc->file_name, $archivos_doc->file_name->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($archivos_doc->fecha_created->Visible) { // fecha_created ?>
        <tr id="r_fecha_created">
            <td class="<?= $archivos_doc->TableLeftColumnClass ?>"><?= $archivos_doc->fecha_created->caption() ?></td>
            <td <?= $archivos_doc->fecha_created->cellAttributes() ?>>
<span id="el_archivos_doc_fecha_created">
<span<?= $archivos_doc->fecha_created->viewAttributes() ?>>
<?= $archivos_doc->fecha_created->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($archivos_doc->boton->Visible) { // boton ?>
        <tr id="r_boton">
            <td class="<?= $archivos_doc->TableLeftColumnClass ?>"><?= $archivos_doc->boton->caption() ?></td>
            <td <?= $archivos_doc->boton->cellAttributes() ?>>
<span id="el_archivos_doc_boton">
<span<?= $archivos_doc->boton->viewAttributes() ?>><div class = "btn-group btn-group-sm ew-btn-group">
<?php
$id = CurrentPage()->id_file->CurrentValue;
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"\" data-table=\"escenario\" data-caption=\"Tarea\" href=\"PermisosDocAdd?showmaster=archivos_doc&fk_id_file=$id\" data-original-title=\"Tareas\"><i class=\"fa fa-list-alt\" data-caption=\"Tareas\"></i></a>";
?>
</div>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
