<?php

namespace PHPMaker2021\simexamerica;

// Page object
$CalificacionEmailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcalificacion_emaildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fcalificacion_emaildelete = currentForm = new ew.Form("fcalificacion_emaildelete", "delete");
    loadjs.done("fcalificacion_emaildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.calificacion_email) ew.vars.tables.calificacion_email = <?= JsonEncode(GetClientVar("tables", "calificacion_email")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcalificacion_emaildelete" id="fcalificacion_emaildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="calificacion_email">
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
<?php if ($Page->id_calificacion_email->Visible) { // id_calificacion_email ?>
        <th class="<?= $Page->id_calificacion_email->headerCellClass() ?>"><span id="elh_calificacion_email_id_calificacion_email" class="calificacion_email_id_calificacion_email"><?= $Page->id_calificacion_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_calificacion->Visible) { // id_calificacion ?>
        <th class="<?= $Page->id_calificacion->headerCellClass() ?>"><span id="elh_calificacion_email_id_calificacion" class="calificacion_email_id_calificacion"><?= $Page->id_calificacion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_user_email->Visible) { // id_user_email ?>
        <th class="<?= $Page->id_user_email->headerCellClass() ?>"><span id="elh_calificacion_email_id_user_email" class="calificacion_email_id_user_email"><?= $Page->id_user_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->create_at->Visible) { // create_at ?>
        <th class="<?= $Page->create_at->headerCellClass() ?>"><span id="elh_calificacion_email_create_at" class="calificacion_email_create_at"><?= $Page->create_at->caption() ?></span></th>
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
<?php if ($Page->id_calificacion_email->Visible) { // id_calificacion_email ?>
        <td <?= $Page->id_calificacion_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_calificacion_email_id_calificacion_email" class="calificacion_email_id_calificacion_email">
<span<?= $Page->id_calificacion_email->viewAttributes() ?>>
<?= $Page->id_calificacion_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_calificacion->Visible) { // id_calificacion ?>
        <td <?= $Page->id_calificacion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_calificacion_email_id_calificacion" class="calificacion_email_id_calificacion">
<span<?= $Page->id_calificacion->viewAttributes() ?>>
<?= $Page->id_calificacion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_user_email->Visible) { // id_user_email ?>
        <td <?= $Page->id_user_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_calificacion_email_id_user_email" class="calificacion_email_id_user_email">
<span<?= $Page->id_user_email->viewAttributes() ?>>
<?= $Page->id_user_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->create_at->Visible) { // create_at ?>
        <td <?= $Page->create_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_calificacion_email_create_at" class="calificacion_email_create_at">
<span<?= $Page->create_at->viewAttributes() ?>>
<?= $Page->create_at->getViewValue() ?></span>
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
