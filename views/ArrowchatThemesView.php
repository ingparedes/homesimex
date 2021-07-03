<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatThemesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_themesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_themesview = currentForm = new ew.Form("farrowchat_themesview", "view");
    loadjs.done("farrowchat_themesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_themes) ew.vars.tables.arrowchat_themes = <?= JsonEncode(GetClientVar("tables", "arrowchat_themes")) ?>;
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
<form name="farrowchat_themesview" id="farrowchat_themesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_themes">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_themes_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_themes_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->folder->Visible) { // folder ?>
    <tr id="r_folder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_themes_folder"><?= $Page->folder->caption() ?></span></td>
        <td data-name="folder" <?= $Page->folder->cellAttributes() ?>>
<span id="el_arrowchat_themes_folder">
<span<?= $Page->folder->viewAttributes() ?>>
<?= $Page->folder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_themes_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_arrowchat_themes_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <tr id="r_active">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_themes_active"><?= $Page->active->caption() ?></span></td>
        <td data-name="active" <?= $Page->active->cellAttributes() ?>>
<span id="el_arrowchat_themes_active">
<span<?= $Page->active->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_active_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->active->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->active->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_active_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->update_link->Visible) { // update_link ?>
    <tr id="r_update_link">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_themes_update_link"><?= $Page->update_link->caption() ?></span></td>
        <td data-name="update_link" <?= $Page->update_link->cellAttributes() ?>>
<span id="el_arrowchat_themes_update_link">
<span<?= $Page->update_link->viewAttributes() ?>>
<?= $Page->update_link->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->version->Visible) { // version ?>
    <tr id="r_version">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_themes_version"><?= $Page->version->caption() ?></span></td>
        <td data-name="version" <?= $Page->version->cellAttributes() ?>>
<span id="el_arrowchat_themes_version">
<span<?= $Page->version->viewAttributes() ?>>
<?= $Page->version->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_default->Visible) { // default ?>
    <tr id="r__default">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_themes__default"><?= $Page->_default->caption() ?></span></td>
        <td data-name="_default" <?= $Page->_default->cellAttributes() ?>>
<span id="el_arrowchat_themes__default">
<span<?= $Page->_default->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x__default_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->_default->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->_default->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x__default_<?= $Page->RowCount ?>"></label>
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
