<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatThemesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_themesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_themesdelete = currentForm = new ew.Form("farrowchat_themesdelete", "delete");
    loadjs.done("farrowchat_themesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_themes) ew.vars.tables.arrowchat_themes = <?= JsonEncode(GetClientVar("tables", "arrowchat_themes")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_themesdelete" id="farrowchat_themesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_themes">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_themes_id" class="arrowchat_themes_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->folder->Visible) { // folder ?>
        <th class="<?= $Page->folder->headerCellClass() ?>"><span id="elh_arrowchat_themes_folder" class="arrowchat_themes_folder"><?= $Page->folder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_arrowchat_themes_name" class="arrowchat_themes_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <th class="<?= $Page->active->headerCellClass() ?>"><span id="elh_arrowchat_themes_active" class="arrowchat_themes_active"><?= $Page->active->caption() ?></span></th>
<?php } ?>
<?php if ($Page->update_link->Visible) { // update_link ?>
        <th class="<?= $Page->update_link->headerCellClass() ?>"><span id="elh_arrowchat_themes_update_link" class="arrowchat_themes_update_link"><?= $Page->update_link->caption() ?></span></th>
<?php } ?>
<?php if ($Page->version->Visible) { // version ?>
        <th class="<?= $Page->version->headerCellClass() ?>"><span id="elh_arrowchat_themes_version" class="arrowchat_themes_version"><?= $Page->version->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_default->Visible) { // default ?>
        <th class="<?= $Page->_default->headerCellClass() ?>"><span id="elh_arrowchat_themes__default" class="arrowchat_themes__default"><?= $Page->_default->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_arrowchat_themes_id" class="arrowchat_themes_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->folder->Visible) { // folder ?>
        <td <?= $Page->folder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_themes_folder" class="arrowchat_themes_folder">
<span<?= $Page->folder->viewAttributes() ?>>
<?= $Page->folder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_themes_name" class="arrowchat_themes_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
        <td <?= $Page->active->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_themes_active" class="arrowchat_themes_active">
<span<?= $Page->active->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_active_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->active->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->active->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_active_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->update_link->Visible) { // update_link ?>
        <td <?= $Page->update_link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_themes_update_link" class="arrowchat_themes_update_link">
<span<?= $Page->update_link->viewAttributes() ?>>
<?= $Page->update_link->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->version->Visible) { // version ?>
        <td <?= $Page->version->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_themes_version" class="arrowchat_themes_version">
<span<?= $Page->version->viewAttributes() ?>>
<?= $Page->version->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_default->Visible) { // default ?>
        <td <?= $Page->_default->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_themes__default" class="arrowchat_themes__default">
<span<?= $Page->_default->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x__default_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->_default->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->_default->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x__default_<?= $Page->RowCount ?>"></label>
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
