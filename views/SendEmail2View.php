<?php

namespace PHPMaker2021\simexamerica;

// Page object
$SendEmail2View = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsend_email2view;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fsend_email2view = currentForm = new ew.Form("fsend_email2view", "view");
    loadjs.done("fsend_email2view");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.send_email2) ew.vars.tables.send_email2 = <?= JsonEncode(GetClientVar("tables", "send_email2")) ?>;
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
<form name="fsend_email2view" id="fsend_email2view" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="send_email2">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_sendemail->Visible) { // id_sendemail ?>
    <tr id="r_id_sendemail">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_send_email2_id_sendemail"><?= $Page->id_sendemail->caption() ?></span></td>
        <td data-name="id_sendemail" <?= $Page->id_sendemail->cellAttributes() ?>>
<span id="el_send_email2_id_sendemail">
<span<?= $Page->id_sendemail->viewAttributes() ?>>
<?= $Page->id_sendemail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
    <tr id="r_sujeto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_send_email2_sujeto"><?= $Page->sujeto->caption() ?></span></td>
        <td data-name="sujeto" <?= $Page->sujeto->cellAttributes() ?>>
<span id="el_send_email2_sujeto">
<span<?= $Page->sujeto->viewAttributes() ?>>
<?= $Page->sujeto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
    <tr id="r_mensaje">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_send_email2_mensaje"><?= $Page->mensaje->caption() ?></span></td>
        <td data-name="mensaje" <?= $Page->mensaje->cellAttributes() ?>>
<span id="el_send_email2_mensaje">
<span<?= $Page->mensaje->viewAttributes() ?>>
<?= $Page->mensaje->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tiempo->Visible) { // tiempo ?>
    <tr id="r_tiempo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_send_email2_tiempo"><?= $Page->tiempo->caption() ?></span></td>
        <td data-name="tiempo" <?= $Page->tiempo->cellAttributes() ?>>
<span id="el_send_email2_tiempo">
<span<?= $Page->tiempo->viewAttributes() ?>>
<?= $Page->tiempo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <tr id="r_archivo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_send_email2_archivo"><?= $Page->archivo->caption() ?></span></td>
        <td data-name="archivo" <?= $Page->archivo->cellAttributes() ?>>
<span id="el_send_email2_archivo">
<span<?= $Page->archivo->viewAttributes() ?>>
<?= GetFileViewTag($Page->archivo, $Page->archivo->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_send_email2_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_send_email2_status">
<span<?= $Page->status->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_status_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->status->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_status_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->de_user->Visible) { // de_user ?>
    <tr id="r_de_user">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_send_email2_de_user"><?= $Page->de_user->caption() ?></span></td>
        <td data-name="de_user" <?= $Page->de_user->cellAttributes() ?>>
<span id="el_send_email2_de_user">
<span<?= $Page->de_user->viewAttributes() ?>>
<?= $Page->de_user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->copy_user->Visible) { // copy_user ?>
    <tr id="r_copy_user">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_send_email2_copy_user"><?= $Page->copy_user->caption() ?></span></td>
        <td data-name="copy_user" <?= $Page->copy_user->cellAttributes() ?>>
<span id="el_send_email2_copy_user">
<span<?= $Page->copy_user->viewAttributes() ?>>
<?= $Page->copy_user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->para_user->Visible) { // para_user ?>
    <tr id="r_para_user">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_send_email2_para_user"><?= $Page->para_user->caption() ?></span></td>
        <td data-name="para_user" <?= $Page->para_user->cellAttributes() ?>>
<span id="el_send_email2_para_user">
<span<?= $Page->para_user->viewAttributes() ?>>
<?= $Page->para_user->getViewValue() ?></span>
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
