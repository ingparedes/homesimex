<?php

namespace PHPMaker2021\simexamerica;


/**
 * Servidor de almacenamiento/OnlyOffice
 */

define('_URL_STORE','https://simexamericas.org/OnlyOffice/');




// Page object
$ArchivosDocView = &$Page;
$sql = ExecuteRow("Select concat(nombres,' ',apellidos)  'name'  from users where id_users =".$Page->id_users->getViewValue().";");
?>
<?php if (!$Page->isExport()) { ?>

<script>
var currentForm, currentPageID;
var farchivos_docview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farchivos_docview = currentForm = new ew.Form("farchivos_docview", "view");
    loadjs.done("farchivos_docview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.archivos_doc) ew.vars.tables.archivos_doc = <?= JsonEncode(GetClientVar("tables", "archivos_doc")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>

    <?php
    //$Page->OtherOptions->render("body")
    ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>

<?php
$Page->showMessage();
?>
<?php
//print_r($Page->id_users);
//exit;
?>
<table class="table table-striped table-sm ew-view-table">
    <?php if ($Page->id_file->Visible) { // id_file ?>
        <tr id="r_id_file">
            <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_archivos_doc_id_file"><?= $Page->id_file->caption() ?></span></td>
            <td data-name="id_file" <?= $Page->id_file->cellAttributes() ?>>
<span id="el_archivos_doc_id_file">
<span<?= $Page->id_file->viewAttributes() ?>>
<?= $Page->id_file->getViewValue() ?></span>
</span>
            </td>
        </tr>
    <?php } ?>
    <?php if ($Page->id_users->Visible->FALSE) { // id_users ?>
        <tr id="r_id_users">
            <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_archivos_doc_id_users"><?= $Page->id_users->caption() ?></span></td>
            <td data-name="id_users" <?= $Page->id_users->cellAttributes() ?>>
<span id="el_archivos_doc_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue().' - '.$sql['name'] ?></span>
</span>
            </td>
        </tr>
    <?php } ?>
    <?php if ($Page->file_name->Visible->false) { // file_name ?>
        <tr id="r_file_name">
            <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_archivos_doc_file_name"><?= $Page->file_name->caption() ?></span></td>
            <td data-name="file_name" <?= $Page->file_name->cellAttributes() ?>>
<span id="el_archivos_doc_file_name">
<span<?= $Page->file_name->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_name, $Page->file_name->getViewValue(), false) ?>
</span>
</span>
            </td>
        </tr>
    <?php } ?>
    <?php if ($Page->fecha_created->Visible->FALSE) { // fecha_created ?>
        <tr id="r_fecha_created">
            <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_archivos_doc_fecha_created"><?= $Page->fecha_created->caption() ?></span></td>
            <td data-name="fecha_created" <?= $Page->fecha_created->cellAttributes() ?>>
<span id="el_archivos_doc_fecha_created">
<span<?= $Page->fecha_created->viewAttributes() ?>>
<?= $Page->fecha_created->getViewValue() ?></span>
</span>
            </td>
        </tr>
    <?php } ?>
    <?php if ($Page->boton->Visible->false) { // boton ?>
        <tr id="r_boton">
            <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_archivos_doc_boton"><?= $Page->boton->caption() ?></span></td>
            <td data-name="boton" <?= $Page->boton->cellAttributes() ?>>
<span id="el_archivos_doc_boton">
<span<?= $Page->boton->viewAttributes() ?>><div class = "btn-group btn-group-sm ew-btn-group">
<?php
$id = CurrentPage()->boton->CurrentValue;
//echo "<a class=\"btn btn-default ew-add-edit ew-add\" title=\"\" data-table=\"permisos_doc\" data-caption=\"Agregar\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'/simexamerica/PermisosDocAdd'});\" data-original-title=\"Agregar\"><i data-phrase=\"AddLink\" class=\"fa fa-share-alt ew-icon\" data-caption=\"Agregar\"></i></a><br>";
?>
</div>
</span>
</span>
            </td>
        </tr>
    <?php } ?>
</table>
<?php


?>
<a class="btn btn-primary ew-btn" target="_blank" href="<?=_URL_STORE?>doceditor.php?ulang=<?=CurrentLanguageID()?>&nameUser=<?=$sql['name']?>&fileID=<?=$Page->file_name->getViewValue()?>&user=<?=$Page->id_users->getViewValue()?>">Abrir en otro tab</a>
<br>
    <iframe id="DocumentFrame"
            title="Onlyoffice"
            width="100%"
            height="1000"
            src="<?=_URL_STORE?>doceditor.php?ulang=<?=CurrentLanguageID()?>&nameUser=<?=$sql['name']?>&fileID=<?=$Page->file_name->getViewValue()?>&user=<?=$Page->id_users->getViewValue()?>">
    </iframe>
<?php
    if (in_array("permisos_doc", explode(",", $Page->getCurrentDetailTable())) && $permisos_doc->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("permisos_doc", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PermisosDocGrid.php" ?>
<?php } ?>

<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
