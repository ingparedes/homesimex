<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ResmensajeView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fresmensajeview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fresmensajeview = currentForm = new ew.Form("fresmensajeview", "view");
    loadjs.done("fresmensajeview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.resmensaje) ew.vars.tables.resmensaje = <?= JsonEncode(GetClientVar("tables", "resmensaje")) ?>;
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
<form name="fresmensajeview" id="fresmensajeview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="resmensaje">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_resmensaje->Visible) { // id_resmensaje ?>
    <tr id="r_id_resmensaje">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_resmensaje_id_resmensaje"><?= $Page->id_resmensaje->caption() ?></span></td>
        <td data-name="id_resmensaje" <?= $Page->id_resmensaje->cellAttributes() ?>>
<span id="el_resmensaje_id_resmensaje">
<span<?= $Page->id_resmensaje->viewAttributes() ?>>
<?= $Page->id_resmensaje->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
    <tr id="r_id_users">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_resmensaje_id_users"><?= $Page->id_users->caption() ?></span></td>
        <td data-name="id_users" <?= $Page->id_users->cellAttributes() ?>>
<span id="el_resmensaje_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
    <tr id="r_id_inyect">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_resmensaje_id_inyect"><?= $Page->id_inyect->caption() ?></span></td>
        <td data-name="id_inyect" <?= $Page->id_inyect->cellAttributes() ?>>
<span id="el_resmensaje_id_inyect">
<span<?= $Page->id_inyect->viewAttributes() ?>>
<?= $Page->id_inyect->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->resmensaje->Visible) { // resmensaje ?>
    <tr id="r_resmensaje">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_resmensaje_resmensaje"><?= $Page->resmensaje->caption() ?></span></td>
        <td data-name="resmensaje" <?= $Page->resmensaje->cellAttributes() ?>>
<span id="el_resmensaje_resmensaje">
<span<?= $Page->resmensaje->viewAttributes() ?>>
<?= $Page->resmensaje->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->resadjunto->Visible) { // resadjunto ?>
    <tr id="r_resadjunto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_resmensaje_resadjunto"><?= $Page->resadjunto->caption() ?></span></td>
        <td data-name="resadjunto" <?= $Page->resadjunto->cellAttributes() ?>>
<span id="el_resmensaje_resadjunto">
<span<?= $Page->resadjunto->viewAttributes() ?>>
<?= GetFileViewTag($Page->resadjunto, $Page->resadjunto->getViewValue(), false) ?>
</span>
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
