<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatApplicationsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_applicationsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_applicationsview = currentForm = new ew.Form("farrowchat_applicationsview", "view");
    loadjs.done("farrowchat_applicationsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_applications) ew.vars.tables.arrowchat_applications = <?= JsonEncode(GetClientVar("tables", "arrowchat_applications")) ?>;
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
<form name="farrowchat_applicationsview" id="farrowchat_applicationsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_applications">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_applications_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_arrowchat_applications_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->folder->Visible) { // folder ?>
    <tr id="r_folder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_folder"><?= $Page->folder->caption() ?></span></td>
        <td data-name="folder" <?= $Page->folder->cellAttributes() ?>>
<span id="el_arrowchat_applications_folder">
<span<?= $Page->folder->viewAttributes() ?>>
<?= $Page->folder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->icon->Visible) { // icon ?>
    <tr id="r_icon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_icon"><?= $Page->icon->caption() ?></span></td>
        <td data-name="icon" <?= $Page->icon->cellAttributes() ?>>
<span id="el_arrowchat_applications_icon">
<span<?= $Page->icon->viewAttributes() ?>>
<?= $Page->icon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->width->Visible) { // width ?>
    <tr id="r_width">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_width"><?= $Page->width->caption() ?></span></td>
        <td data-name="width" <?= $Page->width->cellAttributes() ?>>
<span id="el_arrowchat_applications_width">
<span<?= $Page->width->viewAttributes() ?>>
<?= $Page->width->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->height->Visible) { // height ?>
    <tr id="r_height">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_height"><?= $Page->height->caption() ?></span></td>
        <td data-name="height" <?= $Page->height->cellAttributes() ?>>
<span id="el_arrowchat_applications_height">
<span<?= $Page->height->viewAttributes() ?>>
<?= $Page->height->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bar_width->Visible) { // bar_width ?>
    <tr id="r_bar_width">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_bar_width"><?= $Page->bar_width->caption() ?></span></td>
        <td data-name="bar_width" <?= $Page->bar_width->cellAttributes() ?>>
<span id="el_arrowchat_applications_bar_width">
<span<?= $Page->bar_width->viewAttributes() ?>>
<?= $Page->bar_width->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bar_name->Visible) { // bar_name ?>
    <tr id="r_bar_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_bar_name"><?= $Page->bar_name->caption() ?></span></td>
        <td data-name="bar_name" <?= $Page->bar_name->cellAttributes() ?>>
<span id="el_arrowchat_applications_bar_name">
<span<?= $Page->bar_name->viewAttributes() ?>>
<?= $Page->bar_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dont_reload->Visible) { // dont_reload ?>
    <tr id="r_dont_reload">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_dont_reload"><?= $Page->dont_reload->caption() ?></span></td>
        <td data-name="dont_reload" <?= $Page->dont_reload->cellAttributes() ?>>
<span id="el_arrowchat_applications_dont_reload">
<span<?= $Page->dont_reload->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_dont_reload_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->dont_reload->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->dont_reload->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_dont_reload_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->default_bookmark->Visible) { // default_bookmark ?>
    <tr id="r_default_bookmark">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_default_bookmark"><?= $Page->default_bookmark->caption() ?></span></td>
        <td data-name="default_bookmark" <?= $Page->default_bookmark->cellAttributes() ?>>
<span id="el_arrowchat_applications_default_bookmark">
<span<?= $Page->default_bookmark->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_default_bookmark_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->default_bookmark->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->default_bookmark->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_default_bookmark_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->show_to_guests->Visible) { // show_to_guests ?>
    <tr id="r_show_to_guests">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_show_to_guests"><?= $Page->show_to_guests->caption() ?></span></td>
        <td data-name="show_to_guests" <?= $Page->show_to_guests->cellAttributes() ?>>
<span id="el_arrowchat_applications_show_to_guests">
<span<?= $Page->show_to_guests->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_show_to_guests_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->show_to_guests->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->show_to_guests->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_show_to_guests_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
    <tr id="r_link">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_link"><?= $Page->link->caption() ?></span></td>
        <td data-name="link" <?= $Page->link->cellAttributes() ?>>
<span id="el_arrowchat_applications_link">
<span<?= $Page->link->viewAttributes() ?>>
<?= $Page->link->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->update_link->Visible) { // update_link ?>
    <tr id="r_update_link">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_update_link"><?= $Page->update_link->caption() ?></span></td>
        <td data-name="update_link" <?= $Page->update_link->cellAttributes() ?>>
<span id="el_arrowchat_applications_update_link">
<span<?= $Page->update_link->viewAttributes() ?>>
<?= $Page->update_link->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->version->Visible) { // version ?>
    <tr id="r_version">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_version"><?= $Page->version->caption() ?></span></td>
        <td data-name="version" <?= $Page->version->cellAttributes() ?>>
<span id="el_arrowchat_applications_version">
<span<?= $Page->version->viewAttributes() ?>>
<?= $Page->version->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <tr id="r_active">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_applications_active"><?= $Page->active->caption() ?></span></td>
        <td data-name="active" <?= $Page->active->cellAttributes() ?>>
<span id="el_arrowchat_applications_active">
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
