<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatWarningsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_warningsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_warningsview = currentForm = new ew.Form("farrowchat_warningsview", "view");
    loadjs.done("farrowchat_warningsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_warnings) ew.vars.tables.arrowchat_warnings = <?= JsonEncode(GetClientVar("tables", "arrowchat_warnings")) ?>;
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
<form name="farrowchat_warningsview" id="farrowchat_warningsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_warnings">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_warnings_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_warnings_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <tr id="r_user_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_warnings_user_id"><?= $Page->user_id->caption() ?></span></td>
        <td data-name="user_id" <?= $Page->user_id->cellAttributes() ?>>
<span id="el_arrowchat_warnings_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warn_reason->Visible) { // warn_reason ?>
    <tr id="r_warn_reason">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_warnings_warn_reason"><?= $Page->warn_reason->caption() ?></span></td>
        <td data-name="warn_reason" <?= $Page->warn_reason->cellAttributes() ?>>
<span id="el_arrowchat_warnings_warn_reason">
<span<?= $Page->warn_reason->viewAttributes() ?>>
<?= $Page->warn_reason->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warned_by->Visible) { // warned_by ?>
    <tr id="r_warned_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_warnings_warned_by"><?= $Page->warned_by->caption() ?></span></td>
        <td data-name="warned_by" <?= $Page->warned_by->cellAttributes() ?>>
<span id="el_arrowchat_warnings_warned_by">
<span<?= $Page->warned_by->viewAttributes() ?>>
<?= $Page->warned_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warning_time->Visible) { // warning_time ?>
    <tr id="r_warning_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_warnings_warning_time"><?= $Page->warning_time->caption() ?></span></td>
        <td data-name="warning_time" <?= $Page->warning_time->cellAttributes() ?>>
<span id="el_arrowchat_warnings_warning_time">
<span<?= $Page->warning_time->viewAttributes() ?>>
<?= $Page->warning_time->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
    <tr id="r_user_read">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_warnings_user_read"><?= $Page->user_read->caption() ?></span></td>
        <td data-name="user_read" <?= $Page->user_read->cellAttributes() ?>>
<span id="el_arrowchat_warnings_user_read">
<span<?= $Page->user_read->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_user_read_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->user_read->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->user_read->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_user_read_<?= $Page->RowCount ?>"></label>
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
