<?php

namespace PHPMaker2021\simexamerica;

// Page object
$EscenarioList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fescenariolist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fescenariolist = currentForm = new ew.Form("fescenariolist", "list");
    fescenariolist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fescenariolist");
});
var fescenariolistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fescenariolistsrch = currentSearchForm = new ew.Form("fescenariolistsrch");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "escenario")) ?>,
        fields = currentTable.fields;
    fescenariolistsrch.addFields([
        ["id_escenario", [], fields.id_escenario.isInvalid],
        ["icon_escenario", [], fields.icon_escenario.isInvalid],
        ["fechacreacion_escenario", [], fields.fechacreacion_escenario.isInvalid],
        ["nombre_escenario", [], fields.nombre_escenario.isInvalid],
        ["incidente", [], fields.incidente.isInvalid],
        ["evento_asociado", [], fields.evento_asociado.isInvalid],
        ["pais_escenario", [], fields.pais_escenario.isInvalid],
        ["fechaini_real", [], fields.fechaini_real.isInvalid],
        ["fechaini_simulado", [], fields.fechaini_simulado.isInvalid],
        ["estado", [], fields.estado.isInvalid],
        ["entrar", [], fields.entrar.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fescenariolistsrch.setInvalid();
    });

    // Validate form
    fescenariolistsrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fescenariolistsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fescenariolistsrch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fescenariolistsrch.lists.estado = <?= $Page->estado->toClientList($Page) ?>;

    // Filters
    fescenariolistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fescenariolistsrch");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
    background-color: #FFFFFF; /* preview row color */
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
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fescenariolistsrch" id="fescenariolistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fescenariolistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="escenario">
    <div class="ew-extended-search">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->estado->Visible) { // estado ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_estado" class="ew-cell form-group">
        <label class="ew-search-caption ew-label"><?= $Page->estado->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_estado" id="z_estado" value="LIKE">
</span>
        <span id="el_escenario_estado" class="ew-search-field">
<template id="tp_x_estado">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="escenario" data-field="x_estado" name="x_estado" id="x_estado"<?= $Page->estado->editAttributes() ?>>
        <label class="custom-control-label"> </label>
    </div>
    
</template>

<div id="dsl_x_estado" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_estado"
    name="x_estado"
    value="<?= HtmlEncode($Page->estado->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_estado"
    data-target="dsl_x_estado"
    data-repeatcolumn="5"
    class="form-control<?= $Page->estado->isInvalidClass() ?>"
    data-table="escenario"
    data-field="x_estado"
    data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
    <?= $Page->estado->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->estado->getErrorMessage(false) ?></div>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow > 0) { ?>
</div>
    <?php } ?>
<p> <strong> Configuración:</strong> <em>Simulación en proceso de desarrollo</em></p>
<p><strong>Activa:</strong> <em>Simulación en ejecución</em></p>
<p><strong>Finalizada:</strong> <em>Simulación se encuentra finalizada.</em></p> 
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">

    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
  
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> escenario">
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
<form name="fescenariolist" id="fescenariolist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="escenario">
<div id="gmp_escenario" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_escenariolist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
        <th data-name="id_escenario" class="<?= $Page->id_escenario->headerCellClass() ?>"><div id="elh_escenario_id_escenario" class="escenario_id_escenario"><?= $Page->renderSort($Page->id_escenario) ?></div></th>
<?php } ?>
<?php if ($Page->icon_escenario->Visible) { // icon_escenario ?>
        <th data-name="icon_escenario" class="<?= $Page->icon_escenario->headerCellClass() ?>"><div id="elh_escenario_icon_escenario" class="escenario_icon_escenario"><?= $Page->renderSort($Page->icon_escenario) ?></div></th>
<?php } ?>
<?php if ($Page->fechacreacion_escenario->Visible) { // fechacreacion_escenario ?>
        <th data-name="fechacreacion_escenario" class="<?= $Page->fechacreacion_escenario->headerCellClass() ?>"><div id="elh_escenario_fechacreacion_escenario" class="escenario_fechacreacion_escenario"><?= $Page->renderSort($Page->fechacreacion_escenario) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_escenario->Visible) { // nombre_escenario ?>
        <th data-name="nombre_escenario" class="<?= $Page->nombre_escenario->headerCellClass() ?>"><div id="elh_escenario_nombre_escenario" class="escenario_nombre_escenario"><?= $Page->renderSort($Page->nombre_escenario) ?></div></th>
<?php } ?>
<?php if ($Page->incidente->Visible) { // incidente ?>
        <th data-name="incidente" class="<?= $Page->incidente->headerCellClass() ?>"><div id="elh_escenario_incidente" class="escenario_incidente"><?= $Page->renderSort($Page->incidente) ?></div></th>
<?php } ?>
<?php if ($Page->evento_asociado->Visible) { // evento_asociado ?>
        <th data-name="evento_asociado" class="<?= $Page->evento_asociado->headerCellClass() ?>"><div id="elh_escenario_evento_asociado" class="escenario_evento_asociado"><?= $Page->renderSort($Page->evento_asociado) ?></div></th>
<?php } ?>
<?php if ($Page->pais_escenario->Visible) { // pais_escenario ?>
        <th data-name="pais_escenario" class="<?= $Page->pais_escenario->headerCellClass() ?>"><div id="elh_escenario_pais_escenario" class="escenario_pais_escenario"><?= $Page->renderSort($Page->pais_escenario) ?></div></th>
<?php } ?>
<?php if ($Page->fechaini_real->Visible) { // fechaini_real ?>
        <th data-name="fechaini_real" class="<?= $Page->fechaini_real->headerCellClass() ?>"><div id="elh_escenario_fechaini_real" class="escenario_fechaini_real"><?= $Page->renderSort($Page->fechaini_real) ?></div></th>
<?php } ?>
<?php if ($Page->fechaini_simulado->Visible) { // fechaini_simulado ?>
        <th data-name="fechaini_simulado" class="<?= $Page->fechaini_simulado->headerCellClass() ?>"><div id="elh_escenario_fechaini_simulado" class="escenario_fechaini_simulado"><?= $Page->renderSort($Page->fechaini_simulado) ?></div></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Page->estado->headerCellClass() ?>"><div id="elh_escenario_estado" class="escenario_estado"><?= $Page->renderSort($Page->estado) ?></div></th>
<?php } ?>
<?php if ($Page->entrar->Visible) { // entrar ?>
        <th data-name="entrar" class="<?= $Page->entrar->headerCellClass() ?>"><div id="elh_escenario_entrar" class="escenario_entrar"><?= $Page->renderSort($Page->entrar) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_escenario", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id_escenario->Visible) { // id_escenario ?>
        <td data-name="id_escenario" <?= $Page->id_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<?= $Page->id_escenario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->icon_escenario->Visible) { // icon_escenario ?>
        <td data-name="icon_escenario" <?= $Page->icon_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_icon_escenario">
<span><?php
$idm = CurrentPage()->icon_escenario->CurrentValue;
echo "<img width='25px' src='$idm'>";
?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechacreacion_escenario->Visible) { // fechacreacion_escenario ?>
        <td data-name="fechacreacion_escenario" <?= $Page->fechacreacion_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_fechacreacion_escenario">
<span<?= $Page->fechacreacion_escenario->viewAttributes() ?>>
<?= $Page->fechacreacion_escenario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_escenario->Visible) { // nombre_escenario ?>
        <td data-name="nombre_escenario" <?= $Page->nombre_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_nombre_escenario">
<span<?= $Page->nombre_escenario->viewAttributes() ?>>
<?= $Page->nombre_escenario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->incidente->Visible) { // incidente ?>
        <td data-name="incidente" <?= $Page->incidente->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_incidente">
<span<?= $Page->incidente->viewAttributes() ?>>
<?= $Page->incidente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->evento_asociado->Visible) { // evento_asociado ?>
        <td data-name="evento_asociado" <?= $Page->evento_asociado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_evento_asociado">
<span<?= $Page->evento_asociado->viewAttributes() ?>>
<?= $Page->evento_asociado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pais_escenario->Visible) { // pais_escenario ?>
        <td data-name="pais_escenario" <?= $Page->pais_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_pais_escenario">
<span<?= $Page->pais_escenario->viewAttributes() ?>>
<?= $Page->pais_escenario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaini_real->Visible) { // fechaini_real ?>
        <td data-name="fechaini_real" <?= $Page->fechaini_real->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_fechaini_real">
<span<?= $Page->fechaini_real->viewAttributes() ?>>
<?= $Page->fechaini_real->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaini_simulado->Visible) { // fechaini_simulado ?>
        <td data-name="fechaini_simulado" <?= $Page->fechaini_simulado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_fechaini_simulado">
<span<?= $Page->fechaini_simulado->viewAttributes() ?>>
<?= $Page->fechaini_simulado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estado->Visible) { // estado ?>
        <td data-name="estado" <?= $Page->estado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->entrar->Visible) { // entrar ?>
        <td data-name="entrar" <?= $Page->entrar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_entrar">
<span<?= $Page->entrar->viewAttributes() ?>><div class = "btn-group btn-group-sm ew-btn-group">
<?php
$id = CurrentPage()->id_escenario->CurrentValue;
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"Grupos\" data-toggle=\"Grupos\" data-table=\"escenario\" data-caption=\"Grupo\" href=\"GrupoList?showmaster=escenario&fk_id_escenario=$id&showdetail=\" data-original-title=\"Usuarios\"><i class=\"fa fa-users \"data-caption=\"Grupo\"></i></a> <br>";
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"Usuarios\" data-toggle=\"Usuarios\" data-table=\"escenario\" data-caption=\"Usuarios\" href=\"Grupos?ides=$id\" data-original-title=\"Usuarios\"><i class=\"fa fa-user-plus\" aria-hidden=\"true\"></i></a> <br>";
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"Tareas\" data-table=\"escenario\" data-caption=\"Tarea\" href=\"TareasList?showmaster=escenario&fk_id_escenario=$id\" data-original-title=\"Tareas\"><i class=\"fa fa-list-alt\" data-caption=\"Tareas\"></i></a>";
?>
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
    ew.addEventHandlers("escenario");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#fescenariolistsrch").before('<div class="callout callout-primary"><em>Si necesita realizar filtro de la siguiente lista, por favor seleccione el estado y por último clics en el botón buscar.</em></div>'),$("a.ew-detail-add").hide();
});
</script>
<?php } ?>
