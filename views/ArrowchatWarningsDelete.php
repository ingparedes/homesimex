<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatWarningsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_warningsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_warningsdelete = currentForm = new ew.Form("farrowchat_warningsdelete", "delete");
    loadjs.done("farrowchat_warningsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_warnings) ew.vars.tables.arrowchat_warnings = <?= JsonEncode(GetClientVar("tables", "arrowchat_warnings")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_warningsdelete" id="farrowchat_warningsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_warnings">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_warnings_id" class="arrowchat_warnings_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
        <th class="<?= $Page->user_id->headerCellClass() ?>"><span id="elh_arrowchat_warnings_user_id" class="arrowchat_warnings_user_id"><?= $Page->user_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->warned_by->Visible) { // warned_by ?>
        <th class="<?= $Page->warned_by->headerCellClass() ?>"><span id="elh_arrowchat_warnings_warned_by" class="arrowchat_warnings_warned_by"><?= $Page->warned_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->warning_time->Visible) { // warning_time ?>
        <th class="<?= $Page->warning_time->headerCellClass() ?>"><span id="elh_arrowchat_warnings_warning_time" class="arrowchat_warnings_warning_time"><?= $Page->warning_time->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
        <th class="<?= $Page->user_read->headerCellClass() ?>"><span id="elh_arrowchat_warnings_user_read" class="arrowchat_warnings_user_read"><?= $Page->user_read->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_warnings_id" class="arrowchat_warnings_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
        <td <?= $Page->user_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_warnings_user_id" class="arrowchat_warnings_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->warned_by->Visible) { // warned_by ?>
        <td <?= $Page->warned_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_warnings_warned_by" class="arrowchat_warnings_warned_by">
<span<?= $Page->warned_by->viewAttributes() ?>>
<?= $Page->warned_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->warning_time->Visible) { // warning_time ?>
        <td <?= $Page->warning_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_warnings_warning_time" class="arrowchat_warnings_warning_time">
<span<?= $Page->warning_time->viewAttributes() ?>>
<?= $Page->warning_time->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
        <td <?= $Page->user_read->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_warnings_user_read" class="arrowchat_warnings_user_read">
<span<?= $Page->user_read->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_user_read_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->user_read->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->user_read->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_user_read_<?= $Page->RowCount ?>"></label>
</div></span>
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
