<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatTrayiconsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_trayiconsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_trayiconsdelete = currentForm = new ew.Form("farrowchat_trayiconsdelete", "delete");
    loadjs.done("farrowchat_trayiconsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_trayicons) ew.vars.tables.arrowchat_trayicons = <?= JsonEncode(GetClientVar("tables", "arrowchat_trayicons")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_trayiconsdelete" id="farrowchat_trayiconsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_trayicons">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_id" class="arrowchat_trayicons_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_name" class="arrowchat_trayicons_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->icon->Visible) { // icon ?>
        <th class="<?= $Page->icon->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_icon" class="arrowchat_trayicons_icon"><?= $Page->icon->caption() ?></span></th>
<?php } ?>
<?php if ($Page->location->Visible) { // location ?>
        <th class="<?= $Page->location->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_location" class="arrowchat_trayicons_location"><?= $Page->location->caption() ?></span></th>
<?php } ?>
<?php if ($Page->target->Visible) { // target ?>
        <th class="<?= $Page->target->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_target" class="arrowchat_trayicons_target"><?= $Page->target->caption() ?></span></th>
<?php } ?>
<?php if ($Page->width->Visible) { // width ?>
        <th class="<?= $Page->width->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_width" class="arrowchat_trayicons_width"><?= $Page->width->caption() ?></span></th>
<?php } ?>
<?php if ($Page->height->Visible) { // height ?>
        <th class="<?= $Page->height->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_height" class="arrowchat_trayicons_height"><?= $Page->height->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tray_width->Visible) { // tray_width ?>
        <th class="<?= $Page->tray_width->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_tray_width" class="arrowchat_trayicons_tray_width"><?= $Page->tray_width->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tray_name->Visible) { // tray_name ?>
        <th class="<?= $Page->tray_name->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_tray_name" class="arrowchat_trayicons_tray_name"><?= $Page->tray_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tray_location->Visible) { // tray_location ?>
        <th class="<?= $Page->tray_location->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_tray_location" class="arrowchat_trayicons_tray_location"><?= $Page->tray_location->caption() ?></span></th>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <th class="<?= $Page->active->headerCellClass() ?>"><span id="elh_arrowchat_trayicons_active" class="arrowchat_trayicons_active"><?= $Page->active->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_id" class="arrowchat_trayicons_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_name" class="arrowchat_trayicons_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->icon->Visible) { // icon ?>
        <td <?= $Page->icon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_icon" class="arrowchat_trayicons_icon">
<span<?= $Page->icon->viewAttributes() ?>>
<?= $Page->icon->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->location->Visible) { // location ?>
        <td <?= $Page->location->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_location" class="arrowchat_trayicons_location">
<span<?= $Page->location->viewAttributes() ?>>
<?= $Page->location->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->target->Visible) { // target ?>
        <td <?= $Page->target->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_target" class="arrowchat_trayicons_target">
<span<?= $Page->target->viewAttributes() ?>>
<?= $Page->target->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->width->Visible) { // width ?>
        <td <?= $Page->width->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_width" class="arrowchat_trayicons_width">
<span<?= $Page->width->viewAttributes() ?>>
<?= $Page->width->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->height->Visible) { // height ?>
        <td <?= $Page->height->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_height" class="arrowchat_trayicons_height">
<span<?= $Page->height->viewAttributes() ?>>
<?= $Page->height->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tray_width->Visible) { // tray_width ?>
        <td <?= $Page->tray_width->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_tray_width" class="arrowchat_trayicons_tray_width">
<span<?= $Page->tray_width->viewAttributes() ?>>
<?= $Page->tray_width->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tray_name->Visible) { // tray_name ?>
        <td <?= $Page->tray_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_tray_name" class="arrowchat_trayicons_tray_name">
<span<?= $Page->tray_name->viewAttributes() ?>>
<?= $Page->tray_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tray_location->Visible) { // tray_location ?>
        <td <?= $Page->tray_location->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_tray_location" class="arrowchat_trayicons_tray_location">
<span<?= $Page->tray_location->viewAttributes() ?>>
<?= $Page->tray_location->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <td <?= $Page->active->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_trayicons_active" class="arrowchat_trayicons_active">
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
