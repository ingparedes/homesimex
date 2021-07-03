<?php

namespace PHPMaker2021\simexamerica;

// Page object
$SendEmail2Delete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsend_email2delete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fsend_email2delete = currentForm = new ew.Form("fsend_email2delete", "delete");
    loadjs.done("fsend_email2delete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.send_email2) ew.vars.tables.send_email2 = <?= JsonEncode(GetClientVar("tables", "send_email2")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsend_email2delete" id="fsend_email2delete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="send_email2">
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
<?php if ($Page->id_sendemail->Visible) { // id_sendemail ?>
        <th class="<?= $Page->id_sendemail->headerCellClass() ?>"><span id="elh_send_email2_id_sendemail" class="send_email2_id_sendemail"><?= $Page->id_sendemail->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
        <th class="<?= $Page->sujeto->headerCellClass() ?>"><span id="elh_send_email2_sujeto" class="send_email2_sujeto"><?= $Page->sujeto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tiempo->Visible) { // tiempo ?>
        <th class="<?= $Page->tiempo->headerCellClass() ?>"><span id="elh_send_email2_tiempo" class="send_email2_tiempo"><?= $Page->tiempo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
        <th class="<?= $Page->archivo->headerCellClass() ?>"><span id="elh_send_email2_archivo" class="send_email2_archivo"><?= $Page->archivo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_send_email2_status" class="send_email2_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->de_user->Visible) { // de_user ?>
        <th class="<?= $Page->de_user->headerCellClass() ?>"><span id="elh_send_email2_de_user" class="send_email2_de_user"><?= $Page->de_user->caption() ?></span></th>
<?php } ?>
<?php if ($Page->copy_user->Visible) { // copy_user ?>
        <th class="<?= $Page->copy_user->headerCellClass() ?>"><span id="elh_send_email2_copy_user" class="send_email2_copy_user"><?= $Page->copy_user->caption() ?></span></th>
<?php } ?>
<?php if ($Page->para_user->Visible) { // para_user ?>
        <th class="<?= $Page->para_user->headerCellClass() ?>"><span id="elh_send_email2_para_user" class="send_email2_para_user"><?= $Page->para_user->caption() ?></span></th>
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
<?php if ($Page->id_sendemail->Visible) { // id_sendemail ?>
        <td <?= $Page->id_sendemail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_send_email2_id_sendemail" class="send_email2_id_sendemail">
<span<?= $Page->id_sendemail->viewAttributes() ?>>
<?= $Page->id_sendemail->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
        <td <?= $Page->sujeto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_send_email2_sujeto" class="send_email2_sujeto">
<span<?= $Page->sujeto->viewAttributes() ?>>
<?= $Page->sujeto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tiempo->Visible) { // tiempo ?>
        <td <?= $Page->tiempo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_send_email2_tiempo" class="send_email2_tiempo">
<span<?= $Page->tiempo->viewAttributes() ?>>
<?= $Page->tiempo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
        <td <?= $Page->archivo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_send_email2_archivo" class="send_email2_archivo">
<span<?= $Page->archivo->viewAttributes() ?>>
<?= GetFileViewTag($Page->archivo, $Page->archivo->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_send_email2_status" class="send_email2_status">
<span<?= $Page->status->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_status_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->status->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_status_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->de_user->Visible) { // de_user ?>
        <td <?= $Page->de_user->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_send_email2_de_user" class="send_email2_de_user">
<span<?= $Page->de_user->viewAttributes() ?>>
<?= $Page->de_user->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->copy_user->Visible) { // copy_user ?>
        <td <?= $Page->copy_user->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_send_email2_copy_user" class="send_email2_copy_user">
<span<?= $Page->copy_user->viewAttributes() ?>>
<?= $Page->copy_user->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->para_user->Visible) { // para_user ?>
        <td <?= $Page->para_user->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_send_email2_para_user" class="send_email2_para_user">
<span<?= $Page->para_user->viewAttributes() ?>>
<?= $Page->para_user->getViewValue() ?></span>
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
