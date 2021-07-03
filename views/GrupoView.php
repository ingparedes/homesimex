<?php

namespace PHPMaker2021\simexamerica;

// Page object
$GrupoView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fgrupoview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fgrupoview = currentForm = new ew.Form("fgrupoview", "view");
    loadjs.done("fgrupoview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.grupo) ew.vars.tables.grupo = <?= JsonEncode(GetClientVar("tables", "grupo")) ?>;
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
<form name="fgrupoview" id="fgrupoview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="grupo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
    <tr id="r_id_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_grupo_id_escenario"><?= $Page->id_escenario->caption() ?></span></td>
        <td data-name="id_escenario" <?= $Page->id_escenario->cellAttributes() ?>>
<span id="el_grupo_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<?= $Page->id_escenario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
    <tr id="r_id_grupo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_grupo_id_grupo"><?= $Page->id_grupo->caption() ?></span></td>
        <td data-name="id_grupo" <?= $Page->id_grupo->cellAttributes() ?>>
<span id="el_grupo_id_grupo">
<span<?= $Page->id_grupo->viewAttributes() ?>>
<?= $Page->id_grupo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
    <tr id="r_imgen_grupo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_grupo_imgen_grupo"><?= $Page->imgen_grupo->caption() ?></span></td>
        <td data-name="imgen_grupo" <?= $Page->imgen_grupo->cellAttributes() ?>>
<span id="el_grupo_imgen_grupo">
<span>
<?= GetFileViewTag($Page->imgen_grupo, $Page->imgen_grupo->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
    <tr id="r_nombre_grupo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_grupo_nombre_grupo"><?= $Page->nombre_grupo->caption() ?></span></td>
        <td data-name="nombre_grupo" <?= $Page->nombre_grupo->cellAttributes() ?>>
<span id="el_grupo_nombre_grupo">
<span<?= $Page->nombre_grupo->viewAttributes() ?>>
<?= $Page->nombre_grupo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion_grupo->Visible) { // descripcion_grupo ?>
    <tr id="r_descripcion_grupo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_grupo_descripcion_grupo"><?= $Page->descripcion_grupo->caption() ?></span></td>
        <td data-name="descripcion_grupo" <?= $Page->descripcion_grupo->cellAttributes() ?>>
<span id="el_grupo_descripcion_grupo">
<span<?= $Page->descripcion_grupo->viewAttributes() ?>>
<?= $Page->descripcion_grupo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
    <tr id="r_color">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_grupo_color"><?= $Page->color->caption() ?></span></td>
        <td data-name="color" <?= $Page->color->cellAttributes() ?>>
<span id="el_grupo_color">
<span<?= $Page->color->viewAttributes() ?>><div class="card" style="max-width: 6rem; background-color: <?php echo CurrentPage()->color->CurrentValue; ?>;">
    <div class="card-body">
  </div>
</div>
</span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("subgrupo", explode(",", $Page->getCurrentDetailTable())) && $subgrupo->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subgrupo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubgrupoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("users", explode(",", $Page->getCurrentDetailTable())) && $users->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("users", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "UsersGrid.php" ?>
<?php } ?>
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
