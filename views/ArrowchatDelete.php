<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchatdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchatdelete = currentForm = new ew.Form("farrowchatdelete", "delete");
    loadjs.done("farrowchatdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat) ew.vars.tables.arrowchat = <?= JsonEncode(GetClientVar("tables", "arrowchat")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchatdelete" id="farrowchatdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_id" class="arrowchat_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_from->Visible) { // from ?>
        <th class="<?= $Page->_from->headerCellClass() ?>"><span id="elh_arrowchat__from" class="arrowchat__from"><?= $Page->_from->caption() ?></span></th>
<?php } ?>
<?php if ($Page->to->Visible) { // to ?>
        <th class="<?= $Page->to->headerCellClass() ?>"><span id="elh_arrowchat_to" class="arrowchat_to"><?= $Page->to->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sent->Visible) { // sent ?>
        <th class="<?= $Page->sent->headerCellClass() ?>"><span id="elh_arrowchat_sent" class="arrowchat_sent"><?= $Page->sent->caption() ?></span></th>
<?php } ?>
<?php if ($Page->read->Visible) { // read ?>
        <th class="<?= $Page->read->headerCellClass() ?>"><span id="elh_arrowchat_read" class="arrowchat_read"><?= $Page->read->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
        <th class="<?= $Page->user_read->headerCellClass() ?>"><span id="elh_arrowchat_user_read" class="arrowchat_user_read"><?= $Page->user_read->caption() ?></span></th>
<?php } ?>
<?php if ($Page->direction->Visible) { // direction ?>
        <th class="<?= $Page->direction->headerCellClass() ?>"><span id="elh_arrowchat_direction" class="arrowchat_direction"><?= $Page->direction->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_arrowchat_id" class="arrowchat_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_from->Visible) { // from ?>
        <td <?= $Page->_from->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat__from" class="arrowchat__from">
<span<?= $Page->_from->viewAttributes() ?>>
<?= $Page->_from->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->to->Visible) { // to ?>
        <td <?= $Page->to->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_to" class="arrowchat_to">
<span<?= $Page->to->viewAttributes() ?>>
<?= $Page->to->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sent->Visible) { // sent ?>
        <td <?= $Page->sent->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_sent" class="arrowchat_sent">
<span<?= $Page->sent->viewAttributes() ?>>
<?= $Page->sent->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->read->Visible) { // read ?>
        <td <?= $Page->read->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_read" class="arrowchat_read">
<span<?= $Page->read->viewAttributes() ?>>
<?= $Page->read->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
        <td <?= $Page->user_read->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_user_read" class="arrowchat_user_read">
<span<?= $Page->user_read->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_user_read_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->user_read->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->user_read->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_user_read_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->direction->Visible) { // direction ?>
        <td <?= $Page->direction->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_direction" class="arrowchat_direction">
<span<?= $Page->direction->viewAttributes() ?>>
<?= $Page->direction->getViewValue() ?></span>
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
