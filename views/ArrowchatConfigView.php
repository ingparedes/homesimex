<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatConfigView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_configview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_configview = currentForm = new ew.Form("farrowchat_configview", "view");
    loadjs.done("farrowchat_configview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_config) ew.vars.tables.arrowchat_config = <?= JsonEncode(GetClientVar("tables", "arrowchat_config")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_configview" id="farrowchat_configview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_config">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->config_name->Visible) { // config_name ?>
    <tr id="r_config_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_config_config_name"><?= $Page->config_name->caption() ?></span></td>
        <td data-name="config_name" <?= $Page->config_name->cellAttributes() ?>>
<span id="el_arrowchat_config_config_name">
<span<?= $Page->config_name->viewAttributes() ?>>
<?= $Page->config_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->config_value->Visible) { // config_value ?>
    <tr id="r_config_value">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_config_config_value"><?= $Page->config_value->caption() ?></span></td>
        <td data-name="config_value" <?= $Page->config_value->cellAttributes() ?>>
<span id="el_arrowchat_config_config_value">
<span<?= $Page->config_value->viewAttributes() ?>>
<?= $Page->config_value->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->is_dynamic->Visible) { // is_dynamic ?>
    <tr id="r_is_dynamic">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_config_is_dynamic"><?= $Page->is_dynamic->caption() ?></span></td>
        <td data-name="is_dynamic" <?= $Page->is_dynamic->cellAttributes() ?>>
<span id="el_arrowchat_config_is_dynamic">
<span<?= $Page->is_dynamic->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_dynamic_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_dynamic->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_dynamic->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_dynamic_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
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
