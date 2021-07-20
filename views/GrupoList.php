<?php

namespace PHPMaker2021\simexamerica;

// Page object
$GrupoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fgrupolist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fgrupolist = currentForm = new ew.Form("fgrupolist", "list");
    fgrupolist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fgrupolist");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
    background-color: #F8F8FF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
    display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
    <div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
        <ul class="nav nav-tabs"></ul>
        <div class="tab-content"><!-- .tab-content -->
            <div class="tab-pane fade active show"></div>
        </div><!-- /.tab-content -->
    </div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
    ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "right" : "left";
    ew.PREVIEW_SINGLE_ROW = false;
    ew.PREVIEW_OVERLAY = false;
    loadjs(ew.PATH_BASE + "js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    // Write your table-specific client script here, no need to add script tags.
    //$(document).ready(function() {
    //$('.ew-detail-add').html('New Bill');
    //$('a.ew-detail-add:first').html('<i class="fas fa-plus ew-icon" data-caption="Nuevo"> <br> Grupos-Subgrupo </i>');
    //});
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "escenario") {
    if ($Page->MasterRecordExists) {
        include_once "views/EscenarioMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php
   $id_escenario = HtmlEncode($Page->id_escenario->getSessionValue());
  //echo CurrentUserID();
//	$nombreescnario = ExecuteRow("SELECT nombre_escenario,DATE_FORMAT(fechaini_real, '%Y/%m/%d'), DATE_FORMAT(fechafinal_real, '%Y/%m/%d')  FROM escenario WHERE id_escenario =  = '".$id_escenario."';");
	$escenID = ExecuteRow("SELECT DATE_FORMAT(fechaini_real, '%Y/%m/%d'), DATE_FORMAT(fechafinal_real, '%Y/%m/%d'),nombre_escenario FROM escenario WHERE id_escenario = '".$id_escenario."';");
?>

<div class="callout callout-primary">
  <h4>Simulación:  <?php echo $escenID[2];  ?>  </h4>
 <p> <em> Fecha inicio real: <?php echo $escenID[1]  ?> Fecha fin real: <?php echo $escenID[0];  ?> </em></p>
</div>


<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> grupo">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>


</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fgrupolist" id="fgrupolist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="grupo">
<?php if ($Page->getCurrentMasterTable() == "escenario" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="escenario">
<input type="hidden" name="fk_id_escenario" value="<?= HtmlEncode($Page->id_escenario->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_grupo" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_grupolist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
        <th data-name="imgen_grupo" class="<?= $Page->imgen_grupo->headerCellClass() ?>"><div id="elh_grupo_imgen_grupo" class="grupo_imgen_grupo"><?= $Page->renderSort($Page->imgen_grupo) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
        <th data-name="nombre_grupo" class="<?= $Page->nombre_grupo->headerCellClass() ?>"><div id="elh_grupo_nombre_grupo" class="grupo_nombre_grupo"><?= $Page->renderSort($Page->nombre_grupo) ?></div></th>
<?php } ?>
<?php if ($Page->descripcion_grupo->Visible) { // descripcion_grupo ?>
        <th data-name="descripcion_grupo" class="<?= $Page->descripcion_grupo->headerCellClass() ?>"><div id="elh_grupo_descripcion_grupo" class="grupo_descripcion_grupo"><?= $Page->renderSort($Page->descripcion_grupo) ?></div></th>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
        <th data-name="color" class="<?= $Page->color->headerCellClass() ?>"><div id="elh_grupo_color" class="grupo_color"><?= $Page->renderSort($Page->color) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_grupo", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
        <td data-name="imgen_grupo" <?= $Page->imgen_grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_grupo_imgen_grupo">
<span>
<?= GetFileViewTag($Page->imgen_grupo, $Page->imgen_grupo->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
        <td data-name="nombre_grupo" <?= $Page->nombre_grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_grupo_nombre_grupo">
<span<?= $Page->nombre_grupo->viewAttributes() ?>>
<?= $Page->nombre_grupo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->descripcion_grupo->Visible) { // descripcion_grupo ?>
        <td data-name="descripcion_grupo" <?= $Page->descripcion_grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_grupo_descripcion_grupo">
<span<?= $Page->descripcion_grupo->viewAttributes() ?>>
<?= $Page->descripcion_grupo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->color->Visible) { // color ?>
        <td data-name="color" <?= $Page->color->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_grupo_color">
<span<?= $Page->color->viewAttributes() ?>><div class="card" style="max-width: 6rem; background-color: <?php echo CurrentPage()->color->CurrentValue; ?>;">
    <div class="card-body">
  </div>
</div>
</span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("grupo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#r_id_escenario").hide(),$("#r_icon_escenario").hide(),$("#r_fechacreacion_escenario").hide(),$("#r_estado").hide(),$("#r_entrar").hide();
});
</script>
<?php } ?>
