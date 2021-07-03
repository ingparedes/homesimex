<?php

namespace PHPMaker2021\simexamerica;

// Page object
$CalificacionEmailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcalificacion_emailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fcalificacion_emailview = currentForm = new ew.Form("fcalificacion_emailview", "view");
    loadjs.done("fcalificacion_emailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.calificacion_email) ew.vars.tables.calificacion_email = <?= JsonEncode(GetClientVar("tables", "calificacion_email")) ?>;
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
<form name="fcalificacion_emailview" id="fcalificacion_emailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="calificacion_email">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_calificacion_email->Visible) { // id_calificacion_email ?>
    <tr id="r_id_calificacion_email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_calificacion_email_id_calificacion_email"><?= $Page->id_calificacion_email->caption() ?></span></td>
        <td data-name="id_calificacion_email" <?= $Page->id_calificacion_email->cellAttributes() ?>>
<span id="el_calificacion_email_id_calificacion_email">
<span<?= $Page->id_calificacion_email->viewAttributes() ?>>
<?= $Page->id_calificacion_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_calificacion->Visible) { // id_calificacion ?>
    <tr id="r_id_calificacion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_calificacion_email_id_calificacion"><?= $Page->id_calificacion->caption() ?></span></td>
        <td data-name="id_calificacion" <?= $Page->id_calificacion->cellAttributes() ?>>
<span id="el_calificacion_email_id_calificacion">
<span<?= $Page->id_calificacion->viewAttributes() ?>>
<?= $Page->id_calificacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_user_email->Visible) { // id_user_email ?>
    <tr id="r_id_user_email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_calificacion_email_id_user_email"><?= $Page->id_user_email->caption() ?></span></td>
        <td data-name="id_user_email" <?= $Page->id_user_email->cellAttributes() ?>>
<span id="el_calificacion_email_id_user_email">
<span<?= $Page->id_user_email->viewAttributes() ?>>
<?= $Page->id_user_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comentario->Visible) { // comentario ?>
    <tr id="r_comentario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_calificacion_email_comentario"><?= $Page->comentario->caption() ?></span></td>
        <td data-name="comentario" <?= $Page->comentario->cellAttributes() ?>>
<span id="el_calificacion_email_comentario">
<span<?= $Page->comentario->viewAttributes() ?>>
<?= $Page->comentario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->create_at->Visible) { // create_at ?>
    <tr id="r_create_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_calificacion_email_create_at"><?= $Page->create_at->caption() ?></span></td>
        <td data-name="create_at" <?= $Page->create_at->cellAttributes() ?>>
<span id="el_calificacion_email_create_at">
<span<?= $Page->create_at->viewAttributes() ?>>
<?= $Page->create_at->getViewValue() ?></span>
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
