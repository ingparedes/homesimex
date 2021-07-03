<?php

namespace PHPMaker2021\simexamerica;

// Page object
$CalificacionView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcalificacionview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fcalificacionview = currentForm = new ew.Form("fcalificacionview", "view");
    loadjs.done("fcalificacionview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.calificacion) ew.vars.tables.calificacion = <?= JsonEncode(GetClientVar("tables", "calificacion")) ?>;
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
<form name="fcalificacionview" id="fcalificacionview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="calificacion">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_calificacion->Visible) { // id_calificacion ?>
    <tr id="r_id_calificacion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_calificacion_id_calificacion"><?= $Page->id_calificacion->caption() ?></span></td>
        <td data-name="id_calificacion" <?= $Page->id_calificacion->cellAttributes() ?>>
<span id="el_calificacion_id_calificacion">
<span<?= $Page->id_calificacion->viewAttributes() ?>>
<?= $Page->id_calificacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <tr id="r_descripcion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_calificacion_descripcion"><?= $Page->descripcion->caption() ?></span></td>
        <td data-name="descripcion" <?= $Page->descripcion->cellAttributes() ?>>
<span id="el_calificacion_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
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
