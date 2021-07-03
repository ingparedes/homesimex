<?php

namespace PHPMaker2021\simexamerica;

// Page object
$UserEmailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fuser_emaildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fuser_emaildelete = currentForm = new ew.Form("fuser_emaildelete", "delete");
    loadjs.done("fuser_emaildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.user_email) ew.vars.tables.user_email = <?= JsonEncode(GetClientVar("tables", "user_email")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fuser_emaildelete" id="fuser_emaildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_email">
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
<?php if ($Page->id_user_email->Visible) { // id_user_email ?>
        <th class="<?= $Page->id_user_email->headerCellClass() ?>"><span id="elh_user_email_id_user_email" class="user_email_id_user_email"><?= $Page->id_user_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_user_email_status" class="user_email_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_email->Visible) { // id_email ?>
        <th class="<?= $Page->id_email->headerCellClass() ?>"><span id="elh_user_email_id_email" class="user_email_id_email"><?= $Page->id_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_user_remitente->Visible) { // id_user_remitente ?>
        <th class="<?= $Page->id_user_remitente->headerCellClass() ?>"><span id="elh_user_email_id_user_remitente" class="user_email_id_user_remitente"><?= $Page->id_user_remitente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_user_destinatario->Visible) { // id_user_destinatario ?>
        <th class="<?= $Page->id_user_destinatario->headerCellClass() ?>"><span id="elh_user_email_id_user_destinatario" class="user_email_id_user_destinatario"><?= $Page->id_user_destinatario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
        <th class="<?= $Page->id_mensaje->headerCellClass() ?>"><span id="elh_user_email_id_mensaje" class="user_email_id_mensaje"><?= $Page->id_mensaje->caption() ?></span></th>
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
<?php if ($Page->id_user_email->Visible) { // id_user_email ?>
        <td <?= $Page->id_user_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_email_id_user_email" class="user_email_id_user_email">
<span<?= $Page->id_user_email->viewAttributes() ?>>
<?= $Page->id_user_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_email_status" class="user_email_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_email->Visible) { // id_email ?>
        <td <?= $Page->id_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_email_id_email" class="user_email_id_email">
<span<?= $Page->id_email->viewAttributes() ?>>
<?= $Page->id_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_user_remitente->Visible) { // id_user_remitente ?>
        <td <?= $Page->id_user_remitente->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_email_id_user_remitente" class="user_email_id_user_remitente">
<span<?= $Page->id_user_remitente->viewAttributes() ?>>
<?= $Page->id_user_remitente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_user_destinatario->Visible) { // id_user_destinatario ?>
        <td <?= $Page->id_user_destinatario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_email_id_user_destinatario" class="user_email_id_user_destinatario">
<span<?= $Page->id_user_destinatario->viewAttributes() ?>>
<?= $Page->id_user_destinatario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
        <td <?= $Page->id_mensaje->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_email_id_mensaje" class="user_email_id_mensaje">
<span<?= $Page->id_mensaje->viewAttributes() ?>>
<?= $Page->id_mensaje->getViewValue() ?></span>
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
