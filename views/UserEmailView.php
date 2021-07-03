<?php

namespace PHPMaker2021\simexamerica;

// Page object
$UserEmailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fuser_emailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fuser_emailview = currentForm = new ew.Form("fuser_emailview", "view");
    loadjs.done("fuser_emailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.user_email) ew.vars.tables.user_email = <?= JsonEncode(GetClientVar("tables", "user_email")) ?>;
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
<form name="fuser_emailview" id="fuser_emailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_email">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_user_email->Visible) { // id_user_email ?>
    <tr id="r_id_user_email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_email_id_user_email"><?= $Page->id_user_email->caption() ?></span></td>
        <td data-name="id_user_email" <?= $Page->id_user_email->cellAttributes() ?>>
<span id="el_user_email_id_user_email">
<span<?= $Page->id_user_email->viewAttributes() ?>>
<?= $Page->id_user_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_email_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_user_email_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_email->Visible) { // id_email ?>
    <tr id="r_id_email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_email_id_email"><?= $Page->id_email->caption() ?></span></td>
        <td data-name="id_email" <?= $Page->id_email->cellAttributes() ?>>
<span id="el_user_email_id_email">
<span<?= $Page->id_email->viewAttributes() ?>>
<?= $Page->id_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_user_remitente->Visible) { // id_user_remitente ?>
    <tr id="r_id_user_remitente">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_email_id_user_remitente"><?= $Page->id_user_remitente->caption() ?></span></td>
        <td data-name="id_user_remitente" <?= $Page->id_user_remitente->cellAttributes() ?>>
<span id="el_user_email_id_user_remitente">
<span<?= $Page->id_user_remitente->viewAttributes() ?>>
<?= $Page->id_user_remitente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_user_destinatario->Visible) { // id_user_destinatario ?>
    <tr id="r_id_user_destinatario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_email_id_user_destinatario"><?= $Page->id_user_destinatario->caption() ?></span></td>
        <td data-name="id_user_destinatario" <?= $Page->id_user_destinatario->cellAttributes() ?>>
<span id="el_user_email_id_user_destinatario">
<span<?= $Page->id_user_destinatario->viewAttributes() ?>>
<?= $Page->id_user_destinatario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
    <tr id="r_id_mensaje">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_email_id_mensaje"><?= $Page->id_mensaje->caption() ?></span></td>
        <td data-name="id_mensaje" <?= $Page->id_mensaje->cellAttributes() ?>>
<span id="el_user_email_id_mensaje">
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
