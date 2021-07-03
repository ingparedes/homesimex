<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchatview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchatview = currentForm = new ew.Form("farrowchatview", "view");
    loadjs.done("farrowchatview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat) ew.vars.tables.arrowchat = <?= JsonEncode(GetClientVar("tables", "arrowchat")) ?>;
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
<form name="farrowchatview" id="farrowchatview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_from->Visible) { // from ?>
    <tr id="r__from">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat__from"><?= $Page->_from->caption() ?></span></td>
        <td data-name="_from" <?= $Page->_from->cellAttributes() ?>>
<span id="el_arrowchat__from">
<span<?= $Page->_from->viewAttributes() ?>>
<?= $Page->_from->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->to->Visible) { // to ?>
    <tr id="r_to">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_to"><?= $Page->to->caption() ?></span></td>
        <td data-name="to" <?= $Page->to->cellAttributes() ?>>
<span id="el_arrowchat_to">
<span<?= $Page->to->viewAttributes() ?>>
<?= $Page->to->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->message->Visible) { // message ?>
    <tr id="r_message">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_message"><?= $Page->message->caption() ?></span></td>
        <td data-name="message" <?= $Page->message->cellAttributes() ?>>
<span id="el_arrowchat_message">
<span<?= $Page->message->viewAttributes() ?>>
<?= $Page->message->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sent->Visible) { // sent ?>
    <tr id="r_sent">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_sent"><?= $Page->sent->caption() ?></span></td>
        <td data-name="sent" <?= $Page->sent->cellAttributes() ?>>
<span id="el_arrowchat_sent">
<span<?= $Page->sent->viewAttributes() ?>>
<?= $Page->sent->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->read->Visible) { // read ?>
    <tr id="r_read">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_read"><?= $Page->read->caption() ?></span></td>
        <td data-name="read" <?= $Page->read->cellAttributes() ?>>
<span id="el_arrowchat_read">
<span<?= $Page->read->viewAttributes() ?>>
<?= $Page->read->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
    <tr id="r_user_read">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_user_read"><?= $Page->user_read->caption() ?></span></td>
        <td data-name="user_read" <?= $Page->user_read->cellAttributes() ?>>
<span id="el_arrowchat_user_read">
<span<?= $Page->user_read->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_user_read_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->user_read->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->user_read->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_user_read_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direction->Visible) { // direction ?>
    <tr id="r_direction">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_direction"><?= $Page->direction->caption() ?></span></td>
        <td data-name="direction" <?= $Page->direction->cellAttributes() ?>>
<span id="el_arrowchat_direction">
<span<?= $Page->direction->viewAttributes() ?>>
<?= $Page->direction->getViewValue() ?></span>
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
