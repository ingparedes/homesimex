<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatNotificationsMarkupView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_notifications_markupview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_notifications_markupview = currentForm = new ew.Form("farrowchat_notifications_markupview", "view");
    loadjs.done("farrowchat_notifications_markupview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_notifications_markup) ew.vars.tables.arrowchat_notifications_markup = <?= JsonEncode(GetClientVar("tables", "arrowchat_notifications_markup")) ?>;
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
<form name="farrowchat_notifications_markupview" id="farrowchat_notifications_markupview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_notifications_markup">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_markup_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_notifications_markup_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_markup_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_arrowchat_notifications_markup_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <tr id="r_type">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_markup_type"><?= $Page->type->caption() ?></span></td>
        <td data-name="type" <?= $Page->type->cellAttributes() ?>>
<span id="el_arrowchat_notifications_markup_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->markup->Visible) { // markup ?>
    <tr id="r_markup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_markup_markup"><?= $Page->markup->caption() ?></span></td>
        <td data-name="markup" <?= $Page->markup->cellAttributes() ?>>
<span id="el_arrowchat_notifications_markup_markup">
<span<?= $Page->markup->viewAttributes() ?>>
<?= $Page->markup->getViewValue() ?></span>
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
