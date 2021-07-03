<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TareasView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ftareasview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    ftareasview = currentForm = new ew.Form("ftareasview", "view");
    loadjs.done("ftareasview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.tareas) ew.vars.tables.tareas = <?= JsonEncode(GetClientVar("tables", "tareas")) ?>;
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
<form name="ftareasview" id="ftareasview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tareas">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_tarea->Visible) { // id_tarea ?>
    <tr id="r_id_tarea">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_id_tarea"><?= $Page->id_tarea->caption() ?></span></td>
        <td data-name="id_tarea" <?= $Page->id_tarea->cellAttributes() ?>>
<span id="el_tareas_id_tarea">
<span<?= $Page->id_tarea->viewAttributes() ?>>
<?= $Page->id_tarea->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
    <tr id="r_id_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_id_escenario"><?= $Page->id_escenario->caption() ?></span></td>
        <td data-name="id_escenario" <?= $Page->id_escenario->cellAttributes() ?>>
<span id="el_tareas_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<?= $Page->id_escenario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
    <tr id="r_id_grupo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_id_grupo"><?= $Page->id_grupo->caption() ?></span></td>
        <td data-name="id_grupo" <?= $Page->id_grupo->cellAttributes() ?>>
<span id="el_tareas_id_grupo">
<span<?= $Page->id_grupo->viewAttributes() ?>>
<?= $Page->id_grupo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titulo_tarea->Visible) { // titulo_tarea ?>
    <tr id="r_titulo_tarea">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_titulo_tarea"><?= $Page->titulo_tarea->caption() ?></span></td>
        <td data-name="titulo_tarea" <?= $Page->titulo_tarea->cellAttributes() ?>>
<span id="el_tareas_titulo_tarea">
<span<?= $Page->titulo_tarea->viewAttributes() ?>>
<?= $Page->titulo_tarea->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion_tarea->Visible) { // descripcion_tarea ?>
    <tr id="r_descripcion_tarea">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_descripcion_tarea"><?= $Page->descripcion_tarea->caption() ?></span></td>
        <td data-name="descripcion_tarea" <?= $Page->descripcion_tarea->cellAttributes() ?>>
<span id="el_tareas_descripcion_tarea">
<span<?= $Page->descripcion_tarea->viewAttributes() ?>>
<?= $Page->descripcion_tarea->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
    <tr id="r_fechainireal_tarea">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_fechainireal_tarea"><?= $Page->fechainireal_tarea->caption() ?></span></td>
        <td data-name="fechainireal_tarea" <?= $Page->fechainireal_tarea->cellAttributes() ?>>
<span id="el_tareas_fechainireal_tarea">
<span<?= $Page->fechainireal_tarea->viewAttributes() ?>>
<?= $Page->fechainireal_tarea->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechafin_tarea->Visible) { // fechafin_tarea ?>
    <tr id="r_fechafin_tarea">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_fechafin_tarea"><?= $Page->fechafin_tarea->caption() ?></span></td>
        <td data-name="fechafin_tarea" <?= $Page->fechafin_tarea->cellAttributes() ?>>
<span id="el_tareas_fechafin_tarea">
<span<?= $Page->fechafin_tarea->viewAttributes() ?>>
<?= $Page->fechafin_tarea->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
    <tr id="r_fechainisimulado_tarea">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_fechainisimulado_tarea"><?= $Page->fechainisimulado_tarea->caption() ?></span></td>
        <td data-name="fechainisimulado_tarea" <?= $Page->fechainisimulado_tarea->cellAttributes() ?>>
<span id="el_tareas_fechainisimulado_tarea">
<span<?= $Page->fechainisimulado_tarea->viewAttributes() ?>>
<?= $Page->fechainisimulado_tarea->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
    <tr id="r_fechafinsimulado_tarea">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_fechafinsimulado_tarea"><?= $Page->fechafinsimulado_tarea->caption() ?></span></td>
        <td data-name="fechafinsimulado_tarea" <?= $Page->fechafinsimulado_tarea->cellAttributes() ?>>
<span id="el_tareas_fechafinsimulado_tarea">
<span<?= $Page->fechafinsimulado_tarea->viewAttributes() ?>>
<?= $Page->fechafinsimulado_tarea->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_tarearelacion->Visible) { // id_tarearelacion ?>
    <tr id="r_id_tarearelacion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_id_tarearelacion"><?= $Page->id_tarearelacion->caption() ?></span></td>
        <td data-name="id_tarearelacion" <?= $Page->id_tarearelacion->cellAttributes() ?>>
<span id="el_tareas_id_tarearelacion">
<span<?= $Page->id_tarearelacion->viewAttributes() ?>>
<?= $Page->id_tarearelacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_subgrupo->Visible) { // id_subgrupo ?>
    <tr id="r_id_subgrupo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_id_subgrupo"><?= $Page->id_subgrupo->caption() ?></span></td>
        <td data-name="id_subgrupo" <?= $Page->id_subgrupo->cellAttributes() ?>>
<span id="el_tareas_id_subgrupo">
<span<?= $Page->id_subgrupo->viewAttributes() ?>>
<?= $Page->id_subgrupo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->valoracion->Visible) { // valoracion ?>
    <tr id="r_valoracion">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tareas_valoracion"><?= $Page->valoracion->caption() ?></span></td>
        <td data-name="valoracion" <?= $Page->valoracion->cellAttributes() ?>>
<span id="el_tareas_valoracion">
<span<?= $Page->valoracion->viewAttributes() ?>>
<?= $Page->valoracion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("mensajes", explode(",", $Page->getCurrentDetailTable())) && $mensajes->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("mensajes", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MensajesGrid.php" ?>
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
