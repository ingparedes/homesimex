<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ResmensajeDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fresmensajedelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fresmensajedelete = currentForm = new ew.Form("fresmensajedelete", "delete");
    loadjs.done("fresmensajedelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.resmensaje) ew.vars.tables.resmensaje = <?= JsonEncode(GetClientVar("tables", "resmensaje")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fresmensajedelete" id="fresmensajedelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="resmensaje">
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
<?php if ($Page->id_resmensaje->Visible) { // id_resmensaje ?>
        <th class="<?= $Page->id_resmensaje->headerCellClass() ?>"><span id="elh_resmensaje_id_resmensaje" class="resmensaje_id_resmensaje"><?= $Page->id_resmensaje->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
        <th class="<?= $Page->id_users->headerCellClass() ?>"><span id="elh_resmensaje_id_users" class="resmensaje_id_users"><?= $Page->id_users->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
        <th class="<?= $Page->id_inyect->headerCellClass() ?>"><span id="elh_resmensaje_id_inyect" class="resmensaje_id_inyect"><?= $Page->id_inyect->caption() ?></span></th>
<?php } ?>
<?php if ($Page->resadjunto->Visible) { // resadjunto ?>
        <th class="<?= $Page->resadjunto->headerCellClass() ?>"><span id="elh_resmensaje_resadjunto" class="resmensaje_resadjunto"><?= $Page->resadjunto->caption() ?></span></th>
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
<?php if ($Page->id_resmensaje->Visible) { // id_resmensaje ?>
        <td <?= $Page->id_resmensaje->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_resmensaje_id_resmensaje" class="resmensaje_id_resmensaje">
<span<?= $Page->id_resmensaje->viewAttributes() ?>>
<?= $Page->id_resmensaje->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
        <td <?= $Page->id_users->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_resmensaje_id_users" class="resmensaje_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
        <td <?= $Page->id_inyect->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_resmensaje_id_inyect" class="resmensaje_id_inyect">
<span<?= $Page->id_inyect->viewAttributes() ?>>
<?= $Page->id_inyect->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->resadjunto->Visible) { // resadjunto ?>
        <td <?= $Page->resadjunto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_resmensaje_resadjunto" class="resmensaje_resadjunto">
<span<?= $Page->resadjunto->viewAttributes() ?>>
<?= GetFileViewTag($Page->resadjunto, $Page->resadjunto->getViewValue(), false) ?>
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
