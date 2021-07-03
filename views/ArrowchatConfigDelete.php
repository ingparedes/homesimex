<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatConfigDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_configdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_configdelete = currentForm = new ew.Form("farrowchat_configdelete", "delete");
    loadjs.done("farrowchat_configdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_config) ew.vars.tables.arrowchat_config = <?= JsonEncode(GetClientVar("tables", "arrowchat_config")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_configdelete" id="farrowchat_configdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_config">
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
<?php if ($Page->config_name->Visible) { // config_name ?>
        <th class="<?= $Page->config_name->headerCellClass() ?>"><span id="elh_arrowchat_config_config_name" class="arrowchat_config_config_name"><?= $Page->config_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_dynamic->Visible) { // is_dynamic ?>
        <th class="<?= $Page->is_dynamic->headerCellClass() ?>"><span id="elh_arrowchat_config_is_dynamic" class="arrowchat_config_is_dynamic"><?= $Page->is_dynamic->caption() ?></span></th>
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
<?php if ($Page->config_name->Visible) { // config_name ?>
        <td <?= $Page->config_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_config_config_name" class="arrowchat_config_config_name">
<span<?= $Page->config_name->viewAttributes() ?>>
<?= $Page->config_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_dynamic->Visible) { // is_dynamic ?>
        <td <?= $Page->is_dynamic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_config_is_dynamic" class="arrowchat_config_is_dynamic">
<span<?= $Page->is_dynamic->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_dynamic_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_dynamic->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_dynamic->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_dynamic_<?= $Page->RowCount ?>"></label>
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
