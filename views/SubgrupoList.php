<?php

namespace PHPMaker2021\simexamerica;

// Page object
$SubgrupoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsubgrupolist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fsubgrupolist = currentForm = new ew.Form("fsubgrupolist", "list");
    fsubgrupolist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fsubgrupolist");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
    background-color: #DCDCDC; /* preview row color */
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
    // Write your table-specific client script here, no need to add script tags.
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "grupo") {
    if ($Page->MasterRecordExists) {
        include_once "views/GrupoMaster.php";
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
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> subgrupo">
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
<form name="fsubgrupolist" id="fsubgrupolist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subgrupo">
<?php if ($Page->getCurrentMasterTable() == "grupo" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="grupo">
<input type="hidden" name="fk_id_grupo" value="<?= HtmlEncode($Page->id_grupo->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_subgrupo" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_subgrupolist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <th data-name="imagen_subgrupo" class="<?= $Page->imagen_subgrupo->headerCellClass() ?>"><div id="elh_subgrupo_imagen_subgrupo" class="subgrupo_imagen_subgrupo"><?= $Page->renderSort($Page->imagen_subgrupo) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <th data-name="nombre_subgrupo" class="<?= $Page->nombre_subgrupo->headerCellClass() ?>"><div id="elh_subgrupo_nombre_subgrupo" class="subgrupo_nombre_subgrupo"><?= $Page->renderSort($Page->nombre_subgrupo) ?></div></th>
<?php } ?>
<?php if ($Page->descripcion_subgrupo->Visible) { // descripcion_subgrupo ?>
        <th data-name="descripcion_subgrupo" class="<?= $Page->descripcion_subgrupo->headerCellClass() ?>"><div id="elh_subgrupo_descripcion_subgrupo" class="subgrupo_descripcion_subgrupo"><?= $Page->renderSort($Page->descripcion_subgrupo) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_subgrupo", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <td data-name="imagen_subgrupo" <?= $Page->imagen_subgrupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subgrupo_imagen_subgrupo">
<span>
<?= GetFileViewTag($Page->imagen_subgrupo, $Page->imagen_subgrupo->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <td data-name="nombre_subgrupo" <?= $Page->nombre_subgrupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subgrupo_nombre_subgrupo">
<span<?= $Page->nombre_subgrupo->viewAttributes() ?>>
<?= $Page->nombre_subgrupo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->descripcion_subgrupo->Visible) { // descripcion_subgrupo ?>
        <td data-name="descripcion_subgrupo" <?= $Page->descripcion_subgrupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subgrupo_descripcion_subgrupo">
<span<?= $Page->descripcion_subgrupo->viewAttributes() ?>>
<?= $Page->descripcion_subgrupo->getViewValue() ?></span>
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
    ew.addEventHandlers("subgrupo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#r_id_grupo").hide(),$("#r_excon_grupo").hide(),$("#r_color").hide(),$("#r_participante").hide(),$('[class="ew-master-div"]').remove();
});
</script>
<?php } ?>
