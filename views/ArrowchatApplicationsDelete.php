<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatApplicationsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_applicationsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_applicationsdelete = currentForm = new ew.Form("farrowchat_applicationsdelete", "delete");
    loadjs.done("farrowchat_applicationsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_applications) ew.vars.tables.arrowchat_applications = <?= JsonEncode(GetClientVar("tables", "arrowchat_applications")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_applicationsdelete" id="farrowchat_applicationsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_applications">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_applications_id" class="arrowchat_applications_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_arrowchat_applications_name" class="arrowchat_applications_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->folder->Visible) { // folder ?>
        <th class="<?= $Page->folder->headerCellClass() ?>"><span id="elh_arrowchat_applications_folder" class="arrowchat_applications_folder"><?= $Page->folder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->icon->Visible) { // icon ?>
        <th class="<?= $Page->icon->headerCellClass() ?>"><span id="elh_arrowchat_applications_icon" class="arrowchat_applications_icon"><?= $Page->icon->caption() ?></span></th>
<?php } ?>
<?php if ($Page->width->Visible) { // width ?>
        <th class="<?= $Page->width->headerCellClass() ?>"><span id="elh_arrowchat_applications_width" class="arrowchat_applications_width"><?= $Page->width->caption() ?></span></th>
<?php } ?>
<?php if ($Page->height->Visible) { // height ?>
        <th class="<?= $Page->height->headerCellClass() ?>"><span id="elh_arrowchat_applications_height" class="arrowchat_applications_height"><?= $Page->height->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bar_width->Visible) { // bar_width ?>
        <th class="<?= $Page->bar_width->headerCellClass() ?>"><span id="elh_arrowchat_applications_bar_width" class="arrowchat_applications_bar_width"><?= $Page->bar_width->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bar_name->Visible) { // bar_name ?>
        <th class="<?= $Page->bar_name->headerCellClass() ?>"><span id="elh_arrowchat_applications_bar_name" class="arrowchat_applications_bar_name"><?= $Page->bar_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dont_reload->Visible) { // dont_reload ?>
        <th class="<?= $Page->dont_reload->headerCellClass() ?>"><span id="elh_arrowchat_applications_dont_reload" class="arrowchat_applications_dont_reload"><?= $Page->dont_reload->caption() ?></span></th>
<?php } ?>
<?php if ($Page->default_bookmark->Visible) { // default_bookmark ?>
        <th class="<?= $Page->default_bookmark->headerCellClass() ?>"><span id="elh_arrowchat_applications_default_bookmark" class="arrowchat_applications_default_bookmark"><?= $Page->default_bookmark->caption() ?></span></th>
<?php } ?>
<?php if ($Page->show_to_guests->Visible) { // show_to_guests ?>
        <th class="<?= $Page->show_to_guests->headerCellClass() ?>"><span id="elh_arrowchat_applications_show_to_guests" class="arrowchat_applications_show_to_guests"><?= $Page->show_to_guests->caption() ?></span></th>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
        <th class="<?= $Page->link->headerCellClass() ?>"><span id="elh_arrowchat_applications_link" class="arrowchat_applications_link"><?= $Page->link->caption() ?></span></th>
<?php } ?>
<?php if ($Page->update_link->Visible) { // update_link ?>
        <th class="<?= $Page->update_link->headerCellClass() ?>"><span id="elh_arrowchat_applications_update_link" class="arrowchat_applications_update_link"><?= $Page->update_link->caption() ?></span></th>
<?php } ?>
<?php if ($Page->version->Visible) { // version ?>
        <th class="<?= $Page->version->headerCellClass() ?>"><span id="elh_arrowchat_applications_version" class="arrowchat_applications_version"><?= $Page->version->caption() ?></span></th>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <th class="<?= $Page->active->headerCellClass() ?>"><span id="elh_arrowchat_applications_active" class="arrowchat_applications_active"><?= $Page->active->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_id" class="arrowchat_applications_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_name" class="arrowchat_applications_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->folder->Visible) { // folder ?>
        <td <?= $Page->folder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_folder" class="arrowchat_applications_folder">
<span<?= $Page->folder->viewAttributes() ?>>
<?= $Page->folder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->icon->Visible) { // icon ?>
        <td <?= $Page->icon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_icon" class="arrowchat_applications_icon">
<span<?= $Page->icon->viewAttributes() ?>>
<?= $Page->icon->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->width->Visible) { // width ?>
        <td <?= $Page->width->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_width" class="arrowchat_applications_width">
<span<?= $Page->width->viewAttributes() ?>>
<?= $Page->width->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->height->Visible) { // height ?>
        <td <?= $Page->height->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_height" class="arrowchat_applications_height">
<span<?= $Page->height->viewAttributes() ?>>
<?= $Page->height->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bar_width->Visible) { // bar_width ?>
        <td <?= $Page->bar_width->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_bar_width" class="arrowchat_applications_bar_width">
<span<?= $Page->bar_width->viewAttributes() ?>>
<?= $Page->bar_width->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bar_name->Visible) { // bar_name ?>
        <td <?= $Page->bar_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_bar_name" class="arrowchat_applications_bar_name">
<span<?= $Page->bar_name->viewAttributes() ?>>
<?= $Page->bar_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dont_reload->Visible) { // dont_reload ?>
        <td <?= $Page->dont_reload->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_dont_reload" class="arrowchat_applications_dont_reload">
<span<?= $Page->dont_reload->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_dont_reload_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->dont_reload->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->dont_reload->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_dont_reload_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->default_bookmark->Visible) { // default_bookmark ?>
        <td <?= $Page->default_bookmark->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_default_bookmark" class="arrowchat_applications_default_bookmark">
<span<?= $Page->default_bookmark->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_default_bookmark_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->default_bookmark->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->default_bookmark->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_default_bookmark_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->show_to_guests->Visible) { // show_to_guests ?>
        <td <?= $Page->show_to_guests->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_show_to_guests" class="arrowchat_applications_show_to_guests">
<span<?= $Page->show_to_guests->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_show_to_guests_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->show_to_guests->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->show_to_guests->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_show_to_guests_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
        <td <?= $Page->link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_link" class="arrowchat_applications_link">
<span<?= $Page->link->viewAttributes() ?>>
<?= $Page->link->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->update_link->Visible) { // update_link ?>
        <td <?= $Page->update_link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_update_link" class="arrowchat_applications_update_link">
<span<?= $Page->update_link->viewAttributes() ?>>
<?= $Page->update_link->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->version->Visible) { // version ?>
        <td <?= $Page->version->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_version" class="arrowchat_applications_version">
<span<?= $Page->version->viewAttributes() ?>>
<?= $Page->version->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <td <?= $Page->active->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_applications_active" class="arrowchat_applications_active">
<span<?= $Page->active->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_active_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->active->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->active->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_active_<?= $Page->RowCount ?>"></label>
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
