<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatTrayiconsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_trayiconsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_trayiconsview = currentForm = new ew.Form("farrowchat_trayiconsview", "view");
    loadjs.done("farrowchat_trayiconsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_trayicons) ew.vars.tables.arrowchat_trayicons = <?= JsonEncode(GetClientVar("tables", "arrowchat_trayicons")) ?>;
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
<form name="farrowchat_trayiconsview" id="farrowchat_trayiconsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_trayicons">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->icon->Visible) { // icon ?>
    <tr id="r_icon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_icon"><?= $Page->icon->caption() ?></span></td>
        <td data-name="icon" <?= $Page->icon->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_icon">
<span<?= $Page->icon->viewAttributes() ?>>
<?= $Page->icon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->location->Visible) { // location ?>
    <tr id="r_location">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_location"><?= $Page->location->caption() ?></span></td>
        <td data-name="location" <?= $Page->location->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_location">
<span<?= $Page->location->viewAttributes() ?>>
<?= $Page->location->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->target->Visible) { // target ?>
    <tr id="r_target">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_target"><?= $Page->target->caption() ?></span></td>
        <td data-name="target" <?= $Page->target->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_target">
<span<?= $Page->target->viewAttributes() ?>>
<?= $Page->target->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->width->Visible) { // width ?>
    <tr id="r_width">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_width"><?= $Page->width->caption() ?></span></td>
        <td data-name="width" <?= $Page->width->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_width">
<span<?= $Page->width->viewAttributes() ?>>
<?= $Page->width->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->height->Visible) { // height ?>
    <tr id="r_height">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_height"><?= $Page->height->caption() ?></span></td>
        <td data-name="height" <?= $Page->height->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_height">
<span<?= $Page->height->viewAttributes() ?>>
<?= $Page->height->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tray_width->Visible) { // tray_width ?>
    <tr id="r_tray_width">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_tray_width"><?= $Page->tray_width->caption() ?></span></td>
        <td data-name="tray_width" <?= $Page->tray_width->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_tray_width">
<span<?= $Page->tray_width->viewAttributes() ?>>
<?= $Page->tray_width->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tray_name->Visible) { // tray_name ?>
    <tr id="r_tray_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_tray_name"><?= $Page->tray_name->caption() ?></span></td>
        <td data-name="tray_name" <?= $Page->tray_name->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_tray_name">
<span<?= $Page->tray_name->viewAttributes() ?>>
<?= $Page->tray_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tray_location->Visible) { // tray_location ?>
    <tr id="r_tray_location">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_tray_location"><?= $Page->tray_location->caption() ?></span></td>
        <td data-name="tray_location" <?= $Page->tray_location->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_tray_location">
<span<?= $Page->tray_location->viewAttributes() ?>>
<?= $Page->tray_location->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <tr id="r_active">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_trayicons_active"><?= $Page->active->caption() ?></span></td>
        <td data-name="active" <?= $Page->active->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_active">
<span<?= $Page->active->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_active_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->active->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->active->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_active_<?= $Page->RowCount ?>"></label>
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
