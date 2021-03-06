<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArchivosDocDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farchivos_docdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farchivos_docdelete = currentForm = new ew.Form("farchivos_docdelete", "delete");
    loadjs.done("farchivos_docdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.archivos_doc) ew.vars.tables.archivos_doc = <?= JsonEncode(GetClientVar("tables", "archivos_doc")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farchivos_docdelete" id="farchivos_docdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="archivos_doc">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->file_name->Visible) { // file_name ?>
        <th class="<?= $Page->file_name->headerCellClass() ?>"><span id="elh_archivos_doc_file_name" class="archivos_doc_file_name"><?= $Page->file_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_created->Visible) { // fecha_created ?>
        <th class="<?= $Page->fecha_created->headerCellClass() ?>"><span id="elh_archivos_doc_fecha_created" class="archivos_doc_fecha_created"><?= $Page->fecha_created->caption() ?></span></th>
<?php } ?>
<?php if ($Page->boton->Visible) { // boton ?>
        <th class="<?= $Page->boton->headerCellClass() ?>"><span id="elh_archivos_doc_boton" class="archivos_doc_boton"><?= $Page->boton->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->file_name->Visible) { // file_name ?>
        <td <?= $Page->file_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_archivos_doc_file_name" class="archivos_doc_file_name">
<span<?= $Page->file_name->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_name, $Page->file_name->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_created->Visible) { // fecha_created ?>
        <td <?= $Page->fecha_created->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_archivos_doc_fecha_created" class="archivos_doc_fecha_created">
<span<?= $Page->fecha_created->viewAttributes() ?>>
<?= $Page->fecha_created->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->boton->Visible) { // boton ?>
        <td <?= $Page->boton->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_archivos_doc_boton" class="archivos_doc_boton">
<span<?= $Page->boton->viewAttributes() ?>><div class = "btn-group btn-group-sm ew-btn-group">
<?php
$id = CurrentPage()->id_file->CurrentValue;
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"\" data-table=\"escenario\" data-caption=\"Tarea\" href=\"PermisosDocAdd?showmaster=archivos_doc&fk_id_file=$id\" data-original-title=\"Tareas\"><i class=\"fa fa-list-alt\" data-caption=\"Tareas\"></i></a>";
?>
</div>
</span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
