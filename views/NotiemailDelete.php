<?php

namespace PHPMaker2021\simexamerica;

// Page object
$NotiemailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnotiemaildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnotiemaildelete = currentForm = new ew.Form("fnotiemaildelete", "delete");
    loadjs.done("fnotiemaildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.notiemail) ew.vars.tables.notiemail = <?= JsonEncode(GetClientVar("tables", "notiemail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnotiemaildelete" id="fnotiemaildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="notiemail">
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
<?php if ($Page->id_notiemail->Visible) { // id_notiemail ?>
        <th class="<?= $Page->id_notiemail->headerCellClass() ?>"><span id="elh_notiemail_id_notiemail" class="notiemail_id_notiemail"><?= $Page->id_notiemail->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_email->Visible) { // id_email ?>
        <th class="<?= $Page->id_email->headerCellClass() ?>"><span id="elh_notiemail_id_email" class="notiemail_id_email"><?= $Page->id_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_usersender->Visible) { // id_usersender ?>
        <th class="<?= $Page->id_usersender->headerCellClass() ?>"><span id="elh_notiemail_id_usersender" class="notiemail_id_usersender"><?= $Page->id_usersender->caption() ?></span></th>
<?php } ?>
<?php if ($Page->leido->Visible) { // leido ?>
        <th class="<?= $Page->leido->headerCellClass() ?>"><span id="elh_notiemail_leido" class="notiemail_leido"><?= $Page->leido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
        <th class="<?= $Page->id_mensaje->headerCellClass() ?>"><span id="elh_notiemail_id_mensaje" class="notiemail_id_mensaje"><?= $Page->id_mensaje->caption() ?></span></th>
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
<?php if ($Page->id_notiemail->Visible) { // id_notiemail ?>
        <td <?= $Page->id_notiemail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_notiemail_id_notiemail" class="notiemail_id_notiemail">
<span<?= $Page->id_notiemail->viewAttributes() ?>>
<?= $Page->id_notiemail->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_email->Visible) { // id_email ?>
        <td <?= $Page->id_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_notiemail_id_email" class="notiemail_id_email">
<span<?= $Page->id_email->viewAttributes() ?>>
<?= $Page->id_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_usersender->Visible) { // id_usersender ?>
        <td <?= $Page->id_usersender->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_notiemail_id_usersender" class="notiemail_id_usersender">
<span<?= $Page->id_usersender->viewAttributes() ?>>
<?= $Page->id_usersender->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->leido->Visible) { // leido ?>
        <td <?= $Page->leido->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_notiemail_leido" class="notiemail_leido">
<span<?= $Page->leido->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_leido_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->leido->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->leido->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_leido_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
        <td <?= $Page->id_mensaje->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_notiemail_id_mensaje" class="notiemail_id_mensaje">
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
