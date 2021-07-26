<?php

namespace PHPMaker2021\simexamerica;

// Page object
$UsersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fuserslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fuserslist = currentForm = new ew.Form("fuserslist", "list");
    fuserslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fuserslist");
});
var fuserslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fuserslistsrch = currentSearchForm = new ew.Form("fuserslistsrch");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "users")) ?>,
        fields = currentTable.fields;
    fuserslistsrch.addFields([
        ["id_users", [], fields.id_users.isInvalid],
        ["escenario", [], fields.escenario.isInvalid],
        ["grupo", [], fields.grupo.isInvalid],
        ["subgrupo", [], fields.subgrupo.isInvalid],
        ["perfil", [], fields.perfil.isInvalid],
        ["nombres", [], fields.nombres.isInvalid],
        ["apellidos", [], fields.apellidos.isInvalid],
        ["pais", [], fields.pais.isInvalid],
        ["_email", [], fields._email.isInvalid],
        ["fecha", [], fields.fecha.isInvalid],
        ["telefono", [], fields.telefono.isInvalid],
        ["estado", [], fields.estado.isInvalid],
        ["organizacion", [], fields.organizacion.isInvalid],
        ["img_user", [], fields.img_user.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fuserslistsrch.setInvalid();
    });

    // Validate form
    fuserslistsrch.validate = function () {
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
    fuserslistsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuserslistsrch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fuserslistsrch.lists.estado = <?= $Page->estado->toClientList($Page) ?>;

    // Filters
    fuserslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fuserslistsrch");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "subgrupo") {
    if ($Page->MasterRecordExists) {
        include_once "views/SubgrupoMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "grupo") {
    if ($Page->MasterRecordExists) {
        include_once "views/GrupoMaster.php";
    }
}
?>
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
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fuserslistsrch" id="fuserslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fuserslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="users">
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
        <span id="el_users_estado" class="ew-search-field">
<template id="tp_x_estado">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="users" data-field="x_estado" name="x_estado" id="x_estado"<?= $Page->estado->editAttributes() ?>>
        <label class="custom-control-label"></label>
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
    data-table="users"
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> users">
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
<form name="fuserslist" id="fuserslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<?php if ($Page->getCurrentMasterTable() == "subgrupo" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="subgrupo">
<input type="hidden" name="fk_id_subgrupo" value="<?= HtmlEncode($Page->subgrupo->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "grupo" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="grupo">
<input type="hidden" name="fk_id_grupo" value="<?= HtmlEncode($Page->grupo->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "escenario" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="escenario">
<input type="hidden" name="fk_id_escenario" value="<?= HtmlEncode($Page->escenario->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_users" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_userslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id_users->Visible) { // id_users ?>
        <th data-name="id_users" class="<?= $Page->id_users->headerCellClass() ?>"><div id="elh_users_id_users" class="users_id_users"><?= $Page->renderSort($Page->id_users) ?></div></th>
<?php } ?>
<?php if ($Page->escenario->Visible) { // escenario ?>
        <th data-name="escenario" class="<?= $Page->escenario->headerCellClass() ?>"><div id="elh_users_escenario" class="users_escenario"><?= $Page->renderSort($Page->escenario) ?></div></th>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
        <th data-name="grupo" class="<?= $Page->grupo->headerCellClass() ?>"><div id="elh_users_grupo" class="users_grupo"><?= $Page->renderSort($Page->grupo) ?></div></th>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <th data-name="subgrupo" class="<?= $Page->subgrupo->headerCellClass() ?>"><div id="elh_users_subgrupo" class="users_subgrupo"><?= $Page->renderSort($Page->subgrupo) ?></div></th>
<?php } ?>
<?php if ($Page->perfil->Visible) { // perfil ?>
        <th data-name="perfil" class="<?= $Page->perfil->headerCellClass() ?>"><div id="elh_users_perfil" class="users_perfil"><?= $Page->renderSort($Page->perfil) ?></div></th>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
        <th data-name="nombres" class="<?= $Page->nombres->headerCellClass() ?>"><div id="elh_users_nombres" class="users_nombres"><?= $Page->renderSort($Page->nombres) ?></div></th>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
        <th data-name="apellidos" class="<?= $Page->apellidos->headerCellClass() ?>"><div id="elh_users_apellidos" class="users_apellidos"><?= $Page->renderSort($Page->apellidos) ?></div></th>
<?php } ?>
<?php if ($Page->pais->Visible) { // pais ?>
        <th data-name="pais" class="<?= $Page->pais->headerCellClass() ?>"><div id="elh_users_pais" class="users_pais"><?= $Page->renderSort($Page->pais) ?></div></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Page->_email->headerCellClass() ?>"><div id="elh_users__email" class="users__email"><?= $Page->renderSort($Page->_email) ?></div></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Page->fecha->headerCellClass() ?>"><div id="elh_users_fecha" class="users_fecha"><?= $Page->renderSort($Page->fecha) ?></div></th>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
        <th data-name="telefono" class="<?= $Page->telefono->headerCellClass() ?>"><div id="elh_users_telefono" class="users_telefono"><?= $Page->renderSort($Page->telefono) ?></div></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Page->estado->headerCellClass() ?>"><div id="elh_users_estado" class="users_estado"><?= $Page->renderSort($Page->estado) ?></div></th>
<?php } ?>
<?php if ($Page->organizacion->Visible) { // organizacion ?>
        <th data-name="organizacion" class="<?= $Page->organizacion->headerCellClass() ?>"><div id="elh_users_organizacion" class="users_organizacion"><?= $Page->renderSort($Page->organizacion) ?></div></th>
<?php } ?>
<?php if ($Page->img_user->Visible) { // img_user ?>
        <th data-name="img_user" class="<?= $Page->img_user->headerCellClass() ?>"><div id="elh_users_img_user" class="users_img_user"><?= $Page->renderSort($Page->img_user) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_users", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id_users->Visible) { // id_users ?>
        <td data-name="id_users" <?= $Page->id_users->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->escenario->Visible) { // escenario ?>
        <td data-name="escenario" <?= $Page->escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_escenario">
<span<?= $Page->escenario->viewAttributes() ?>>
<?= $Page->escenario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->grupo->Visible) { // grupo ?>
        <td data-name="grupo" <?= $Page->grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_grupo">
<span<?= $Page->grupo->viewAttributes() ?>>
<?= $Page->grupo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <td data-name="subgrupo" <?= $Page->subgrupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_subgrupo">
<span<?= $Page->subgrupo->viewAttributes() ?>>
<?= $Page->subgrupo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->perfil->Visible) { // perfil ?>
        <td data-name="perfil" <?= $Page->perfil->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_perfil">
<span<?= $Page->perfil->viewAttributes() ?>>
<?= $Page->perfil->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombres->Visible) { // nombres ?>
        <td data-name="nombres" <?= $Page->nombres->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_nombres">
<span<?= $Page->nombres->viewAttributes() ?>>
<?= $Page->nombres->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellidos->Visible) { // apellidos ?>
        <td data-name="apellidos" <?= $Page->apellidos->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_apellidos">
<span<?= $Page->apellidos->viewAttributes() ?>>
<?= $Page->apellidos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pais->Visible) { // pais ?>
        <td data-name="pais" <?= $Page->pais->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_pais">
<span<?= $Page->pais->viewAttributes() ?>>
<?= $Page->pais->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha->Visible) { // fecha ?>
        <td data-name="fecha" <?= $Page->fecha->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->telefono->Visible) { // telefono ?>
        <td data-name="telefono" <?= $Page->telefono->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_telefono">
<span<?= $Page->telefono->viewAttributes() ?>>
<?= $Page->telefono->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estado->Visible) { // estado ?>
        <td data-name="estado" <?= $Page->estado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->organizacion->Visible) { // organizacion ?>
        <td data-name="organizacion" <?= $Page->organizacion->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_organizacion">
<span<?= $Page->organizacion->viewAttributes() ?>>
<?= $Page->organizacion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->img_user->Visible) { // img_user ?>
        <td data-name="img_user" <?= $Page->img_user->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_img_user">
<span>
<?= GetFileViewTag($Page->img_user, $Page->img_user->getViewValue(), false) ?>
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
    ew.addEventHandlers("users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
