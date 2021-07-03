<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatAdminView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_adminview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_adminview = currentForm = new ew.Form("farrowchat_adminview", "view");
    loadjs.done("farrowchat_adminview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_admin) ew.vars.tables.arrowchat_admin = <?= JsonEncode(GetClientVar("tables", "arrowchat_admin")) ?>;
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
<form name="farrowchat_adminview" id="farrowchat_adminview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_admin">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_admin_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_admin_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_admin__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username" <?= $Page->_username->cellAttributes() ?>>
<span id="el_arrowchat_admin__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <tr id="r__password">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_admin__password"><?= $Page->_password->caption() ?></span></td>
        <td data-name="_password" <?= $Page->_password->cellAttributes() ?>>
<span id="el_arrowchat_admin__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_admin__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<span id="el_arrowchat_admin__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
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
