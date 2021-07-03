<?php

namespace PHPMaker2021\simexamerica;

// Page object
$NotiemailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnotiemailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnotiemailview = currentForm = new ew.Form("fnotiemailview", "view");
    loadjs.done("fnotiemailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.notiemail) ew.vars.tables.notiemail = <?= JsonEncode(GetClientVar("tables", "notiemail")) ?>;
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
<form name="fnotiemailview" id="fnotiemailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="notiemail">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_notiemail->Visible) { // id_notiemail ?>
    <tr id="r_id_notiemail">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_notiemail_id_notiemail"><?= $Page->id_notiemail->caption() ?></span></td>
        <td data-name="id_notiemail" <?= $Page->id_notiemail->cellAttributes() ?>>
<span id="el_notiemail_id_notiemail">
<span<?= $Page->id_notiemail->viewAttributes() ?>>
<?= $Page->id_notiemail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_email->Visible) { // id_email ?>
    <tr id="r_id_email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_notiemail_id_email"><?= $Page->id_email->caption() ?></span></td>
        <td data-name="id_email" <?= $Page->id_email->cellAttributes() ?>>
<span id="el_notiemail_id_email">
<span<?= $Page->id_email->viewAttributes() ?>>
<?= $Page->id_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_usersender->Visible) { // id_usersender ?>
    <tr id="r_id_usersender">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_notiemail_id_usersender"><?= $Page->id_usersender->caption() ?></span></td>
        <td data-name="id_usersender" <?= $Page->id_usersender->cellAttributes() ?>>
<span id="el_notiemail_id_usersender">
<span<?= $Page->id_usersender->viewAttributes() ?>>
<?= $Page->id_usersender->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->leido->Visible) { // leido ?>
    <tr id="r_leido">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_notiemail_leido"><?= $Page->leido->caption() ?></span></td>
        <td data-name="leido" <?= $Page->leido->cellAttributes() ?>>
<span id="el_notiemail_leido">
<span<?= $Page->leido->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_leido_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->leido->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->leido->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_leido_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
    <tr id="r_id_mensaje">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_notiemail_id_mensaje"><?= $Page->id_mensaje->caption() ?></span></td>
        <td data-name="id_mensaje" <?= $Page->id_mensaje->cellAttributes() ?>>
<span id="el_notiemail_id_mensaje">
<span<?= $Page->id_mensaje->viewAttributes() ?>>
<?= $Page->id_mensaje->getViewValue() ?></span>
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
