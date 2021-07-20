<?php

namespace PHPMaker2021\simexamerica;

// Set up and run Grid object
$Grid = Container("UsersGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fusersgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fusersgrid = new ew.Form("fusersgrid", "grid");
    fusersgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "users")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.users)
        ew.vars.tables.users = currentTable;
    fusersgrid.addFields([
        ["id_users", [fields.id_users.visible && fields.id_users.required ? ew.Validators.required(fields.id_users.caption) : null], fields.id_users.isInvalid],
        ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null], fields.fecha.isInvalid],
        ["nombres", [fields.nombres.visible && fields.nombres.required ? ew.Validators.required(fields.nombres.caption) : null], fields.nombres.isInvalid],
        ["apellidos", [fields.apellidos.visible && fields.apellidos.required ? ew.Validators.required(fields.apellidos.caption) : null], fields.apellidos.isInvalid],
        ["grupo", [fields.grupo.visible && fields.grupo.required ? ew.Validators.required(fields.grupo.caption) : null], fields.grupo.isInvalid],
        ["subgrupo", [fields.subgrupo.visible && fields.subgrupo.required ? ew.Validators.required(fields.subgrupo.caption) : null], fields.subgrupo.isInvalid],
        ["perfil", [fields.perfil.visible && fields.perfil.required ? ew.Validators.required(fields.perfil.caption) : null], fields.perfil.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
        ["telefono", [fields.telefono.visible && fields.telefono.required ? ew.Validators.required(fields.telefono.caption) : null], fields.telefono.isInvalid],
        ["pais", [fields.pais.visible && fields.pais.required ? ew.Validators.required(fields.pais.caption) : null], fields.pais.isInvalid],
        ["estado", [fields.estado.visible && fields.estado.required ? ew.Validators.required(fields.estado.caption) : null], fields.estado.isInvalid],
        ["organizacion", [fields.organizacion.visible && fields.organizacion.required ? ew.Validators.required(fields.organizacion.caption) : null], fields.organizacion.isInvalid],
        ["img_user", [fields.img_user.visible && fields.img_user.required ? ew.Validators.fileRequired(fields.img_user.caption) : null], fields.img_user.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fusersgrid,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fusersgrid.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    fusersgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "nombres", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "apellidos", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "grupo", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "subgrupo", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "perfil", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "_email", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "telefono", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "pais", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "estado", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "organizacion", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "img_user", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fusersgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fusersgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fusersgrid.lists.grupo = <?= $Grid->grupo->toClientList($Grid) ?>;
    fusersgrid.lists.subgrupo = <?= $Grid->subgrupo->toClientList($Grid) ?>;
    fusersgrid.lists.perfil = <?= $Grid->perfil->toClientList($Grid) ?>;
    fusersgrid.lists.pais = <?= $Grid->pais->toClientList($Grid) ?>;
    fusersgrid.lists.estado = <?= $Grid->estado->toClientList($Grid) ?>;
    loadjs.done("fusersgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> users">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fusersgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_users" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_usersgrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id_users->Visible) { // id_users ?>
        <th data-name="id_users" class="<?= $Grid->id_users->headerCellClass() ?>"><div id="elh_users_id_users" class="users_id_users"><?= $Grid->renderSort($Grid->id_users) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Grid->fecha->headerCellClass() ?>"><div id="elh_users_fecha" class="users_fecha"><?= $Grid->renderSort($Grid->fecha) ?></div></th>
<?php } ?>
<?php if ($Grid->nombres->Visible) { // nombres ?>
        <th data-name="nombres" class="<?= $Grid->nombres->headerCellClass() ?>"><div id="elh_users_nombres" class="users_nombres"><?= $Grid->renderSort($Grid->nombres) ?></div></th>
<?php } ?>
<?php if ($Grid->apellidos->Visible) { // apellidos ?>
        <th data-name="apellidos" class="<?= $Grid->apellidos->headerCellClass() ?>"><div id="elh_users_apellidos" class="users_apellidos"><?= $Grid->renderSort($Grid->apellidos) ?></div></th>
<?php } ?>
<?php if ($Grid->grupo->Visible) { // grupo ?>
        <th data-name="grupo" class="<?= $Grid->grupo->headerCellClass() ?>"><div id="elh_users_grupo" class="users_grupo"><?= $Grid->renderSort($Grid->grupo) ?></div></th>
<?php } ?>
<?php if ($Grid->subgrupo->Visible) { // subgrupo ?>
        <th data-name="subgrupo" class="<?= $Grid->subgrupo->headerCellClass() ?>"><div id="elh_users_subgrupo" class="users_subgrupo"><?= $Grid->renderSort($Grid->subgrupo) ?></div></th>
<?php } ?>
<?php if ($Grid->perfil->Visible) { // perfil ?>
        <th data-name="perfil" class="<?= $Grid->perfil->headerCellClass() ?>"><div id="elh_users_perfil" class="users_perfil"><?= $Grid->renderSort($Grid->perfil) ?></div></th>
<?php } ?>
<?php if ($Grid->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Grid->_email->headerCellClass() ?>"><div id="elh_users__email" class="users__email"><?= $Grid->renderSort($Grid->_email) ?></div></th>
<?php } ?>
<?php if ($Grid->telefono->Visible) { // telefono ?>
        <th data-name="telefono" class="<?= $Grid->telefono->headerCellClass() ?>"><div id="elh_users_telefono" class="users_telefono"><?= $Grid->renderSort($Grid->telefono) ?></div></th>
<?php } ?>
<?php if ($Grid->pais->Visible) { // pais ?>
        <th data-name="pais" class="<?= $Grid->pais->headerCellClass() ?>"><div id="elh_users_pais" class="users_pais"><?= $Grid->renderSort($Grid->pais) ?></div></th>
<?php } ?>
<?php if ($Grid->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Grid->estado->headerCellClass() ?>"><div id="elh_users_estado" class="users_estado"><?= $Grid->renderSort($Grid->estado) ?></div></th>
<?php } ?>
<?php if ($Grid->organizacion->Visible) { // organizacion ?>
        <th data-name="organizacion" class="<?= $Grid->organizacion->headerCellClass() ?>"><div id="elh_users_organizacion" class="users_organizacion"><?= $Grid->renderSort($Grid->organizacion) ?></div></th>
<?php } ?>
<?php if ($Grid->img_user->Visible) { // img_user ?>
        <th data-name="img_user" class="<?= $Grid->img_user->headerCellClass() ?>"><div id="elh_users_img_user" class="users_img_user"><?= $Grid->renderSort($Grid->img_user) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_users", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id_users->Visible) { // id_users ?>
        <td data-name="id_users" <?= $Grid->id_users->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_users_id_users" class="form-group"></span>
<input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_users" id="o<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_users_id_users" class="form-group">
<span<?= $Grid->id_users->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_users->getDisplayValue($Grid->id_users->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_users" id="x<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_id_users">
<span<?= $Grid->id_users->viewAttributes() ?>>
<?= $Grid->id_users->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_id_users" id="fusersgrid$x<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_id_users" id="fusersgrid$o<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_users" id="x<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->fecha->Visible) { // fecha ?>
        <td data-name="fecha" <?= $Grid->fecha->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="users" data-field="x_fecha" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fecha" id="o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_fecha">
<span<?= $Grid->fecha->viewAttributes() ?>>
<?= $Grid->fecha->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_fecha" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_fecha" id="fusersgrid$x<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_fecha" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_fecha" id="fusersgrid$o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nombres->Visible) { // nombres ?>
        <td data-name="nombres" <?= $Grid->nombres->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_users_nombres" class="form-group">
<input type="<?= $Grid->nombres->getInputTextType() ?>" data-table="users" data-field="x_nombres" name="x<?= $Grid->RowIndex ?>_nombres" id="x<?= $Grid->RowIndex ?>_nombres" size="30" maxlength="80" placeholder="<?= HtmlEncode($Grid->nombres->getPlaceHolder()) ?>" value="<?= $Grid->nombres->EditValue ?>"<?= $Grid->nombres->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombres->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_nombres" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nombres" id="o<?= $Grid->RowIndex ?>_nombres" value="<?= HtmlEncode($Grid->nombres->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_users_nombres" class="form-group">
<input type="<?= $Grid->nombres->getInputTextType() ?>" data-table="users" data-field="x_nombres" name="x<?= $Grid->RowIndex ?>_nombres" id="x<?= $Grid->RowIndex ?>_nombres" size="30" maxlength="80" placeholder="<?= HtmlEncode($Grid->nombres->getPlaceHolder()) ?>" value="<?= $Grid->nombres->EditValue ?>"<?= $Grid->nombres->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombres->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_nombres">
<span<?= $Grid->nombres->viewAttributes() ?>>
<?= $Grid->nombres->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_nombres" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_nombres" id="fusersgrid$x<?= $Grid->RowIndex ?>_nombres" value="<?= HtmlEncode($Grid->nombres->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_nombres" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_nombres" id="fusersgrid$o<?= $Grid->RowIndex ?>_nombres" value="<?= HtmlEncode($Grid->nombres->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->apellidos->Visible) { // apellidos ?>
        <td data-name="apellidos" <?= $Grid->apellidos->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_users_apellidos" class="form-group">
<input type="<?= $Grid->apellidos->getInputTextType() ?>" data-table="users" data-field="x_apellidos" name="x<?= $Grid->RowIndex ?>_apellidos" id="x<?= $Grid->RowIndex ?>_apellidos" size="30" maxlength="90" placeholder="<?= HtmlEncode($Grid->apellidos->getPlaceHolder()) ?>" value="<?= $Grid->apellidos->EditValue ?>"<?= $Grid->apellidos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->apellidos->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_apellidos" data-hidden="1" name="o<?= $Grid->RowIndex ?>_apellidos" id="o<?= $Grid->RowIndex ?>_apellidos" value="<?= HtmlEncode($Grid->apellidos->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_users_apellidos" class="form-group">
<input type="<?= $Grid->apellidos->getInputTextType() ?>" data-table="users" data-field="x_apellidos" name="x<?= $Grid->RowIndex ?>_apellidos" id="x<?= $Grid->RowIndex ?>_apellidos" size="30" maxlength="90" placeholder="<?= HtmlEncode($Grid->apellidos->getPlaceHolder()) ?>" value="<?= $Grid->apellidos->EditValue ?>"<?= $Grid->apellidos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->apellidos->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_apellidos">
<span<?= $Grid->apellidos->viewAttributes() ?>>
<?= $Grid->apellidos->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_apellidos" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_apellidos" id="fusersgrid$x<?= $Grid->RowIndex ?>_apellidos" value="<?= HtmlEncode($Grid->apellidos->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_apellidos" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_apellidos" id="fusersgrid$o<?= $Grid->RowIndex ?>_apellidos" value="<?= HtmlEncode($Grid->apellidos->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->grupo->Visible) { // grupo ?>
        <td data-name="grupo" <?= $Grid->grupo->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->grupo->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_users_grupo" class="form-group">
<span<?= $Grid->grupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->grupo->getDisplayValue($Grid->grupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_grupo" name="x<?= $Grid->RowIndex ?>_grupo" value="<?= HtmlEncode($Grid->grupo->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_users_grupo" class="form-group">
<?php $Grid->grupo->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_grupo"
        name="x<?= $Grid->RowIndex ?>_grupo"
        class="form-control ew-select<?= $Grid->grupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_grupo"
        data-table="users"
        data-field="x_grupo"
        data-value-separator="<?= $Grid->grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->grupo->getPlaceHolder()) ?>"
        <?= $Grid->grupo->editAttributes() ?>>
        <?= $Grid->grupo->selectOptionListHtml("x{$Grid->RowIndex}_grupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->grupo->getErrorMessage() ?></div>
<?= $Grid->grupo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_grupo']"),
        options = { name: "x<?= $Grid->RowIndex ?>_grupo", selectId: "users_x<?= $Grid->RowIndex ?>_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="users" data-field="x_grupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_grupo" id="o<?= $Grid->RowIndex ?>_grupo" value="<?= HtmlEncode($Grid->grupo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->grupo->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_users_grupo" class="form-group">
<span<?= $Grid->grupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->grupo->getDisplayValue($Grid->grupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_grupo" name="x<?= $Grid->RowIndex ?>_grupo" value="<?= HtmlEncode($Grid->grupo->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_users_grupo" class="form-group">
<?php $Grid->grupo->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_grupo"
        name="x<?= $Grid->RowIndex ?>_grupo"
        class="form-control ew-select<?= $Grid->grupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_grupo"
        data-table="users"
        data-field="x_grupo"
        data-value-separator="<?= $Grid->grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->grupo->getPlaceHolder()) ?>"
        <?= $Grid->grupo->editAttributes() ?>>
        <?= $Grid->grupo->selectOptionListHtml("x{$Grid->RowIndex}_grupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->grupo->getErrorMessage() ?></div>
<?= $Grid->grupo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_grupo']"),
        options = { name: "x<?= $Grid->RowIndex ?>_grupo", selectId: "users_x<?= $Grid->RowIndex ?>_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_grupo">
<span<?= $Grid->grupo->viewAttributes() ?>>
<?= $Grid->grupo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_grupo" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_grupo" id="fusersgrid$x<?= $Grid->RowIndex ?>_grupo" value="<?= HtmlEncode($Grid->grupo->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_grupo" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_grupo" id="fusersgrid$o<?= $Grid->RowIndex ?>_grupo" value="<?= HtmlEncode($Grid->grupo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->subgrupo->Visible) { // subgrupo ?>
        <td data-name="subgrupo" <?= $Grid->subgrupo->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->subgrupo->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_users_subgrupo" class="form-group">
<span<?= $Grid->subgrupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subgrupo->getDisplayValue($Grid->subgrupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subgrupo" name="x<?= $Grid->RowIndex ?>_subgrupo" value="<?= HtmlEncode($Grid->subgrupo->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_users_subgrupo" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_subgrupo"
        name="x<?= $Grid->RowIndex ?>_subgrupo"
        class="form-control ew-select<?= $Grid->subgrupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_subgrupo"
        data-table="users"
        data-field="x_subgrupo"
        data-value-separator="<?= $Grid->subgrupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->subgrupo->getPlaceHolder()) ?>"
        <?= $Grid->subgrupo->editAttributes() ?>>
        <?= $Grid->subgrupo->selectOptionListHtml("x{$Grid->RowIndex}_subgrupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->subgrupo->getErrorMessage() ?></div>
<?= $Grid->subgrupo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_subgrupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_subgrupo']"),
        options = { name: "x<?= $Grid->RowIndex ?>_subgrupo", selectId: "users_x<?= $Grid->RowIndex ?>_subgrupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.subgrupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="users" data-field="x_subgrupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subgrupo" id="o<?= $Grid->RowIndex ?>_subgrupo" value="<?= HtmlEncode($Grid->subgrupo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->subgrupo->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_users_subgrupo" class="form-group">
<span<?= $Grid->subgrupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subgrupo->getDisplayValue($Grid->subgrupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subgrupo" name="x<?= $Grid->RowIndex ?>_subgrupo" value="<?= HtmlEncode($Grid->subgrupo->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_users_subgrupo" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_subgrupo"
        name="x<?= $Grid->RowIndex ?>_subgrupo"
        class="form-control ew-select<?= $Grid->subgrupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_subgrupo"
        data-table="users"
        data-field="x_subgrupo"
        data-value-separator="<?= $Grid->subgrupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->subgrupo->getPlaceHolder()) ?>"
        <?= $Grid->subgrupo->editAttributes() ?>>
        <?= $Grid->subgrupo->selectOptionListHtml("x{$Grid->RowIndex}_subgrupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->subgrupo->getErrorMessage() ?></div>
<?= $Grid->subgrupo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_subgrupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_subgrupo']"),
        options = { name: "x<?= $Grid->RowIndex ?>_subgrupo", selectId: "users_x<?= $Grid->RowIndex ?>_subgrupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.subgrupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_subgrupo">
<span<?= $Grid->subgrupo->viewAttributes() ?>>
<?= $Grid->subgrupo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_subgrupo" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_subgrupo" id="fusersgrid$x<?= $Grid->RowIndex ?>_subgrupo" value="<?= HtmlEncode($Grid->subgrupo->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_subgrupo" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_subgrupo" id="fusersgrid$o<?= $Grid->RowIndex ?>_subgrupo" value="<?= HtmlEncode($Grid->subgrupo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->perfil->Visible) { // perfil ?>
        <td data-name="perfil" <?= $Grid->perfil->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_users_perfil" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->perfil->getDisplayValue($Grid->perfil->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_users_perfil" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_perfil"
        name="x<?= $Grid->RowIndex ?>_perfil"
        class="form-control ew-select<?= $Grid->perfil->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_perfil"
        data-table="users"
        data-field="x_perfil"
        data-value-separator="<?= $Grid->perfil->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->perfil->getPlaceHolder()) ?>"
        <?= $Grid->perfil->editAttributes() ?>>
        <?= $Grid->perfil->selectOptionListHtml("x{$Grid->RowIndex}_perfil") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->perfil->getErrorMessage() ?></div>
<?= $Grid->perfil->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_perfil") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_perfil']"),
        options = { name: "x<?= $Grid->RowIndex ?>_perfil", selectId: "users_x<?= $Grid->RowIndex ?>_perfil", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.perfil.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="users" data-field="x_perfil" data-hidden="1" name="o<?= $Grid->RowIndex ?>_perfil" id="o<?= $Grid->RowIndex ?>_perfil" value="<?= HtmlEncode($Grid->perfil->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_users_perfil" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->perfil->getDisplayValue($Grid->perfil->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_users_perfil" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_perfil"
        name="x<?= $Grid->RowIndex ?>_perfil"
        class="form-control ew-select<?= $Grid->perfil->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_perfil"
        data-table="users"
        data-field="x_perfil"
        data-value-separator="<?= $Grid->perfil->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->perfil->getPlaceHolder()) ?>"
        <?= $Grid->perfil->editAttributes() ?>>
        <?= $Grid->perfil->selectOptionListHtml("x{$Grid->RowIndex}_perfil") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->perfil->getErrorMessage() ?></div>
<?= $Grid->perfil->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_perfil") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_perfil']"),
        options = { name: "x<?= $Grid->RowIndex ?>_perfil", selectId: "users_x<?= $Grid->RowIndex ?>_perfil", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.perfil.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_perfil">
<span<?= $Grid->perfil->viewAttributes() ?>>
<?= $Grid->perfil->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_perfil" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_perfil" id="fusersgrid$x<?= $Grid->RowIndex ?>_perfil" value="<?= HtmlEncode($Grid->perfil->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_perfil" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_perfil" id="fusersgrid$o<?= $Grid->RowIndex ?>_perfil" value="<?= HtmlEncode($Grid->perfil->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_email->Visible) { // email ?>
        <td data-name="_email" <?= $Grid->_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_users__email" class="form-group">
<input type="<?= $Grid->_email->getInputTextType() ?>" data-table="users" data-field="x__email" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>" value="<?= $Grid->_email->EditValue ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x__email" data-hidden="1" name="o<?= $Grid->RowIndex ?>__email" id="o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_users__email" class="form-group">
<input type="<?= $Grid->_email->getInputTextType() ?>" data-table="users" data-field="x__email" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>" value="<?= $Grid->_email->EditValue ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users__email">
<span<?= $Grid->_email->viewAttributes() ?>>
<?= $Grid->_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x__email" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>__email" id="fusersgrid$x<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x__email" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>__email" id="fusersgrid$o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->telefono->Visible) { // telefono ?>
        <td data-name="telefono" <?= $Grid->telefono->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_users_telefono" class="form-group">
<input type="<?= $Grid->telefono->getInputTextType() ?>" data-table="users" data-field="x_telefono" name="x<?= $Grid->RowIndex ?>_telefono" id="x<?= $Grid->RowIndex ?>_telefono" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->telefono->getPlaceHolder()) ?>" value="<?= $Grid->telefono->EditValue ?>"<?= $Grid->telefono->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->telefono->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_telefono" data-hidden="1" name="o<?= $Grid->RowIndex ?>_telefono" id="o<?= $Grid->RowIndex ?>_telefono" value="<?= HtmlEncode($Grid->telefono->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_users_telefono" class="form-group">
<input type="<?= $Grid->telefono->getInputTextType() ?>" data-table="users" data-field="x_telefono" name="x<?= $Grid->RowIndex ?>_telefono" id="x<?= $Grid->RowIndex ?>_telefono" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->telefono->getPlaceHolder()) ?>" value="<?= $Grid->telefono->EditValue ?>"<?= $Grid->telefono->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->telefono->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_telefono">
<span<?= $Grid->telefono->viewAttributes() ?>>
<?= $Grid->telefono->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_telefono" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_telefono" id="fusersgrid$x<?= $Grid->RowIndex ?>_telefono" value="<?= HtmlEncode($Grid->telefono->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_telefono" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_telefono" id="fusersgrid$o<?= $Grid->RowIndex ?>_telefono" value="<?= HtmlEncode($Grid->telefono->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->pais->Visible) { // pais ?>
        <td data-name="pais" <?= $Grid->pais->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_users_pais" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_pais"
        name="x<?= $Grid->RowIndex ?>_pais"
        class="form-control ew-select<?= $Grid->pais->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_pais"
        data-table="users"
        data-field="x_pais"
        data-value-separator="<?= $Grid->pais->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->pais->getPlaceHolder()) ?>"
        <?= $Grid->pais->editAttributes() ?>>
        <?= $Grid->pais->selectOptionListHtml("x{$Grid->RowIndex}_pais") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->pais->getErrorMessage() ?></div>
<?= $Grid->pais->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pais") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_pais']"),
        options = { name: "x<?= $Grid->RowIndex ?>_pais", selectId: "users_x<?= $Grid->RowIndex ?>_pais", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.pais.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="users" data-field="x_pais" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pais" id="o<?= $Grid->RowIndex ?>_pais" value="<?= HtmlEncode($Grid->pais->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_users_pais" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_pais"
        name="x<?= $Grid->RowIndex ?>_pais"
        class="form-control ew-select<?= $Grid->pais->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_pais"
        data-table="users"
        data-field="x_pais"
        data-value-separator="<?= $Grid->pais->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->pais->getPlaceHolder()) ?>"
        <?= $Grid->pais->editAttributes() ?>>
        <?= $Grid->pais->selectOptionListHtml("x{$Grid->RowIndex}_pais") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->pais->getErrorMessage() ?></div>
<?= $Grid->pais->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pais") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_pais']"),
        options = { name: "x<?= $Grid->RowIndex ?>_pais", selectId: "users_x<?= $Grid->RowIndex ?>_pais", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.pais.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_pais">
<span<?= $Grid->pais->viewAttributes() ?>>
<?= $Grid->pais->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_pais" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_pais" id="fusersgrid$x<?= $Grid->RowIndex ?>_pais" value="<?= HtmlEncode($Grid->pais->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_pais" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_pais" id="fusersgrid$o<?= $Grid->RowIndex ?>_pais" value="<?= HtmlEncode($Grid->pais->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->estado->Visible) { // estado ?>
        <td data-name="estado" <?= $Grid->estado->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_users_estado" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_estado">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="users" data-field="x_estado" name="x<?= $Grid->RowIndex ?>_estado" id="x<?= $Grid->RowIndex ?>_estado"<?= $Grid->estado->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_estado" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_estado"
    name="x<?= $Grid->RowIndex ?>_estado"
    value="<?= HtmlEncode($Grid->estado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_estado"
    data-target="dsl_x<?= $Grid->RowIndex ?>_estado"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->estado->isInvalidClass() ?>"
    data-table="users"
    data-field="x_estado"
    data-value-separator="<?= $Grid->estado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->estado->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->estado->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_estado" data-hidden="1" name="o<?= $Grid->RowIndex ?>_estado" id="o<?= $Grid->RowIndex ?>_estado" value="<?= HtmlEncode($Grid->estado->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_users_estado" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_estado">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="users" data-field="x_estado" name="x<?= $Grid->RowIndex ?>_estado" id="x<?= $Grid->RowIndex ?>_estado"<?= $Grid->estado->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_estado" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_estado"
    name="x<?= $Grid->RowIndex ?>_estado"
    value="<?= HtmlEncode($Grid->estado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_estado"
    data-target="dsl_x<?= $Grid->RowIndex ?>_estado"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->estado->isInvalidClass() ?>"
    data-table="users"
    data-field="x_estado"
    data-value-separator="<?= $Grid->estado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->estado->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->estado->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_estado">
<span<?= $Grid->estado->viewAttributes() ?>>
<?= $Grid->estado->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_estado" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_estado" id="fusersgrid$x<?= $Grid->RowIndex ?>_estado" value="<?= HtmlEncode($Grid->estado->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_estado" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_estado" id="fusersgrid$o<?= $Grid->RowIndex ?>_estado" value="<?= HtmlEncode($Grid->estado->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->organizacion->Visible) { // organizacion ?>
        <td data-name="organizacion" <?= $Grid->organizacion->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_users_organizacion" class="form-group">
<input type="<?= $Grid->organizacion->getInputTextType() ?>" data-table="users" data-field="x_organizacion" name="x<?= $Grid->RowIndex ?>_organizacion" id="x<?= $Grid->RowIndex ?>_organizacion" size="100" maxlength="100" placeholder="<?= HtmlEncode($Grid->organizacion->getPlaceHolder()) ?>" value="<?= $Grid->organizacion->EditValue ?>"<?= $Grid->organizacion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->organizacion->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_organizacion" data-hidden="1" name="o<?= $Grid->RowIndex ?>_organizacion" id="o<?= $Grid->RowIndex ?>_organizacion" value="<?= HtmlEncode($Grid->organizacion->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_users_organizacion" class="form-group">
<input type="<?= $Grid->organizacion->getInputTextType() ?>" data-table="users" data-field="x_organizacion" name="x<?= $Grid->RowIndex ?>_organizacion" id="x<?= $Grid->RowIndex ?>_organizacion" size="100" maxlength="100" placeholder="<?= HtmlEncode($Grid->organizacion->getPlaceHolder()) ?>" value="<?= $Grid->organizacion->EditValue ?>"<?= $Grid->organizacion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->organizacion->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_organizacion">
<span<?= $Grid->organizacion->viewAttributes() ?>>
<?= $Grid->organizacion->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="users" data-field="x_organizacion" data-hidden="1" name="fusersgrid$x<?= $Grid->RowIndex ?>_organizacion" id="fusersgrid$x<?= $Grid->RowIndex ?>_organizacion" value="<?= HtmlEncode($Grid->organizacion->FormValue) ?>">
<input type="hidden" data-table="users" data-field="x_organizacion" data-hidden="1" name="fusersgrid$o<?= $Grid->RowIndex ?>_organizacion" id="fusersgrid$o<?= $Grid->RowIndex ?>_organizacion" value="<?= HtmlEncode($Grid->organizacion->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->img_user->Visible) { // img_user ?>
        <td data-name="img_user" <?= $Grid->img_user->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_users_img_user" class="form-group users_img_user">
<div id="fd_x<?= $Grid->RowIndex ?>_img_user">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->img_user->title() ?>" data-table="users" data-field="x_img_user" name="x<?= $Grid->RowIndex ?>_img_user" id="x<?= $Grid->RowIndex ?>_img_user" lang="<?= CurrentLanguageID() ?>"<?= $Grid->img_user->editAttributes() ?><?= ($Grid->img_user->ReadOnly || $Grid->img_user->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_img_user"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->img_user->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_img_user" id= "fn_x<?= $Grid->RowIndex ?>_img_user" value="<?= $Grid->img_user->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_img_user" id= "fa_x<?= $Grid->RowIndex ?>_img_user" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_img_user" id= "fs_x<?= $Grid->RowIndex ?>_img_user" value="60">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_img_user" id= "fx_x<?= $Grid->RowIndex ?>_img_user" value="<?= $Grid->img_user->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_img_user" id= "fm_x<?= $Grid->RowIndex ?>_img_user" value="<?= $Grid->img_user->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_img_user" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="users" data-field="x_img_user" data-hidden="1" name="o<?= $Grid->RowIndex ?>_img_user" id="o<?= $Grid->RowIndex ?>_img_user" value="<?= HtmlEncode($Grid->img_user->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_users_img_user">
<span>
<?= GetFileViewTag($Grid->img_user, $Grid->img_user->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_users_img_user" class="form-group users_img_user">
<div id="fd_x<?= $Grid->RowIndex ?>_img_user">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->img_user->title() ?>" data-table="users" data-field="x_img_user" name="x<?= $Grid->RowIndex ?>_img_user" id="x<?= $Grid->RowIndex ?>_img_user" lang="<?= CurrentLanguageID() ?>"<?= $Grid->img_user->editAttributes() ?><?= ($Grid->img_user->ReadOnly || $Grid->img_user->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_img_user"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->img_user->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_img_user" id= "fn_x<?= $Grid->RowIndex ?>_img_user" value="<?= $Grid->img_user->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_img_user" id= "fa_x<?= $Grid->RowIndex ?>_img_user" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_img_user") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_img_user" id= "fs_x<?= $Grid->RowIndex ?>_img_user" value="60">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_img_user" id= "fx_x<?= $Grid->RowIndex ?>_img_user" value="<?= $Grid->img_user->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_img_user" id= "fm_x<?= $Grid->RowIndex ?>_img_user" value="<?= $Grid->img_user->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_img_user" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fusersgrid","load"], function () {
    fusersgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_users", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->id_users->Visible) { // id_users ?>
        <td data-name="id_users">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_users_id_users" class="form-group users_id_users"></span>
<?php } else { ?>
<span id="el$rowindex$_users_id_users" class="form-group users_id_users">
<span<?= $Grid->id_users->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_users->getDisplayValue($Grid->id_users->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_users" id="x<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_users" id="o<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fecha->Visible) { // fecha ?>
        <td data-name="fecha">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_users_fecha" class="form-group users_fecha">
<span<?= $Grid->fecha->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->fecha->getDisplayValue($Grid->fecha->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_fecha" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_fecha" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fecha" id="o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nombres->Visible) { // nombres ?>
        <td data-name="nombres">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_users_nombres" class="form-group users_nombres">
<input type="<?= $Grid->nombres->getInputTextType() ?>" data-table="users" data-field="x_nombres" name="x<?= $Grid->RowIndex ?>_nombres" id="x<?= $Grid->RowIndex ?>_nombres" size="30" maxlength="80" placeholder="<?= HtmlEncode($Grid->nombres->getPlaceHolder()) ?>" value="<?= $Grid->nombres->EditValue ?>"<?= $Grid->nombres->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombres->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_users_nombres" class="form-group users_nombres">
<span<?= $Grid->nombres->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nombres->getDisplayValue($Grid->nombres->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_nombres" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nombres" id="x<?= $Grid->RowIndex ?>_nombres" value="<?= HtmlEncode($Grid->nombres->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_nombres" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nombres" id="o<?= $Grid->RowIndex ?>_nombres" value="<?= HtmlEncode($Grid->nombres->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->apellidos->Visible) { // apellidos ?>
        <td data-name="apellidos">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_users_apellidos" class="form-group users_apellidos">
<input type="<?= $Grid->apellidos->getInputTextType() ?>" data-table="users" data-field="x_apellidos" name="x<?= $Grid->RowIndex ?>_apellidos" id="x<?= $Grid->RowIndex ?>_apellidos" size="30" maxlength="90" placeholder="<?= HtmlEncode($Grid->apellidos->getPlaceHolder()) ?>" value="<?= $Grid->apellidos->EditValue ?>"<?= $Grid->apellidos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->apellidos->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_users_apellidos" class="form-group users_apellidos">
<span<?= $Grid->apellidos->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->apellidos->getDisplayValue($Grid->apellidos->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_apellidos" data-hidden="1" name="x<?= $Grid->RowIndex ?>_apellidos" id="x<?= $Grid->RowIndex ?>_apellidos" value="<?= HtmlEncode($Grid->apellidos->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_apellidos" data-hidden="1" name="o<?= $Grid->RowIndex ?>_apellidos" id="o<?= $Grid->RowIndex ?>_apellidos" value="<?= HtmlEncode($Grid->apellidos->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->grupo->Visible) { // grupo ?>
        <td data-name="grupo">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->grupo->getSessionValue() != "") { ?>
<span id="el$rowindex$_users_grupo" class="form-group users_grupo">
<span<?= $Grid->grupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->grupo->getDisplayValue($Grid->grupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_grupo" name="x<?= $Grid->RowIndex ?>_grupo" value="<?= HtmlEncode($Grid->grupo->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_users_grupo" class="form-group users_grupo">
<?php $Grid->grupo->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_grupo"
        name="x<?= $Grid->RowIndex ?>_grupo"
        class="form-control ew-select<?= $Grid->grupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_grupo"
        data-table="users"
        data-field="x_grupo"
        data-value-separator="<?= $Grid->grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->grupo->getPlaceHolder()) ?>"
        <?= $Grid->grupo->editAttributes() ?>>
        <?= $Grid->grupo->selectOptionListHtml("x{$Grid->RowIndex}_grupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->grupo->getErrorMessage() ?></div>
<?= $Grid->grupo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_grupo']"),
        options = { name: "x<?= $Grid->RowIndex ?>_grupo", selectId: "users_x<?= $Grid->RowIndex ?>_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_users_grupo" class="form-group users_grupo">
<span<?= $Grid->grupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->grupo->getDisplayValue($Grid->grupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_grupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_grupo" id="x<?= $Grid->RowIndex ?>_grupo" value="<?= HtmlEncode($Grid->grupo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_grupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_grupo" id="o<?= $Grid->RowIndex ?>_grupo" value="<?= HtmlEncode($Grid->grupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->subgrupo->Visible) { // subgrupo ?>
        <td data-name="subgrupo">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->subgrupo->getSessionValue() != "") { ?>
<span id="el$rowindex$_users_subgrupo" class="form-group users_subgrupo">
<span<?= $Grid->subgrupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subgrupo->getDisplayValue($Grid->subgrupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subgrupo" name="x<?= $Grid->RowIndex ?>_subgrupo" value="<?= HtmlEncode($Grid->subgrupo->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_users_subgrupo" class="form-group users_subgrupo">
    <select
        id="x<?= $Grid->RowIndex ?>_subgrupo"
        name="x<?= $Grid->RowIndex ?>_subgrupo"
        class="form-control ew-select<?= $Grid->subgrupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_subgrupo"
        data-table="users"
        data-field="x_subgrupo"
        data-value-separator="<?= $Grid->subgrupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->subgrupo->getPlaceHolder()) ?>"
        <?= $Grid->subgrupo->editAttributes() ?>>
        <?= $Grid->subgrupo->selectOptionListHtml("x{$Grid->RowIndex}_subgrupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->subgrupo->getErrorMessage() ?></div>
<?= $Grid->subgrupo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_subgrupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_subgrupo']"),
        options = { name: "x<?= $Grid->RowIndex ?>_subgrupo", selectId: "users_x<?= $Grid->RowIndex ?>_subgrupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.subgrupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_users_subgrupo" class="form-group users_subgrupo">
<span<?= $Grid->subgrupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subgrupo->getDisplayValue($Grid->subgrupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_subgrupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_subgrupo" id="x<?= $Grid->RowIndex ?>_subgrupo" value="<?= HtmlEncode($Grid->subgrupo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_subgrupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subgrupo" id="o<?= $Grid->RowIndex ?>_subgrupo" value="<?= HtmlEncode($Grid->subgrupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->perfil->Visible) { // perfil ?>
        <td data-name="perfil">
<?php if (!$Grid->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_users_perfil" class="form-group users_perfil">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->perfil->getDisplayValue($Grid->perfil->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_users_perfil" class="form-group users_perfil">
    <select
        id="x<?= $Grid->RowIndex ?>_perfil"
        name="x<?= $Grid->RowIndex ?>_perfil"
        class="form-control ew-select<?= $Grid->perfil->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_perfil"
        data-table="users"
        data-field="x_perfil"
        data-value-separator="<?= $Grid->perfil->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->perfil->getPlaceHolder()) ?>"
        <?= $Grid->perfil->editAttributes() ?>>
        <?= $Grid->perfil->selectOptionListHtml("x{$Grid->RowIndex}_perfil") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->perfil->getErrorMessage() ?></div>
<?= $Grid->perfil->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_perfil") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_perfil']"),
        options = { name: "x<?= $Grid->RowIndex ?>_perfil", selectId: "users_x<?= $Grid->RowIndex ?>_perfil", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.perfil.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_users_perfil" class="form-group users_perfil">
<span<?= $Grid->perfil->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->perfil->getDisplayValue($Grid->perfil->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_perfil" data-hidden="1" name="x<?= $Grid->RowIndex ?>_perfil" id="x<?= $Grid->RowIndex ?>_perfil" value="<?= HtmlEncode($Grid->perfil->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_perfil" data-hidden="1" name="o<?= $Grid->RowIndex ?>_perfil" id="o<?= $Grid->RowIndex ?>_perfil" value="<?= HtmlEncode($Grid->perfil->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->_email->Visible) { // email ?>
        <td data-name="_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_users__email" class="form-group users__email">
<input type="<?= $Grid->_email->getInputTextType() ?>" data-table="users" data-field="x__email" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>" value="<?= $Grid->_email->EditValue ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_users__email" class="form-group users__email">
<span<?= $Grid->_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_email->getDisplayValue($Grid->_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x__email" data-hidden="1" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x__email" data-hidden="1" name="o<?= $Grid->RowIndex ?>__email" id="o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->telefono->Visible) { // telefono ?>
        <td data-name="telefono">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_users_telefono" class="form-group users_telefono">
<input type="<?= $Grid->telefono->getInputTextType() ?>" data-table="users" data-field="x_telefono" name="x<?= $Grid->RowIndex ?>_telefono" id="x<?= $Grid->RowIndex ?>_telefono" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->telefono->getPlaceHolder()) ?>" value="<?= $Grid->telefono->EditValue ?>"<?= $Grid->telefono->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->telefono->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_users_telefono" class="form-group users_telefono">
<span<?= $Grid->telefono->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->telefono->getDisplayValue($Grid->telefono->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_telefono" data-hidden="1" name="x<?= $Grid->RowIndex ?>_telefono" id="x<?= $Grid->RowIndex ?>_telefono" value="<?= HtmlEncode($Grid->telefono->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_telefono" data-hidden="1" name="o<?= $Grid->RowIndex ?>_telefono" id="o<?= $Grid->RowIndex ?>_telefono" value="<?= HtmlEncode($Grid->telefono->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pais->Visible) { // pais ?>
        <td data-name="pais">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_users_pais" class="form-group users_pais">
    <select
        id="x<?= $Grid->RowIndex ?>_pais"
        name="x<?= $Grid->RowIndex ?>_pais"
        class="form-control ew-select<?= $Grid->pais->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Grid->RowIndex ?>_pais"
        data-table="users"
        data-field="x_pais"
        data-value-separator="<?= $Grid->pais->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->pais->getPlaceHolder()) ?>"
        <?= $Grid->pais->editAttributes() ?>>
        <?= $Grid->pais->selectOptionListHtml("x{$Grid->RowIndex}_pais") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->pais->getErrorMessage() ?></div>
<?= $Grid->pais->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pais") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Grid->RowIndex ?>_pais']"),
        options = { name: "x<?= $Grid->RowIndex ?>_pais", selectId: "users_x<?= $Grid->RowIndex ?>_pais", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.pais.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_users_pais" class="form-group users_pais">
<span<?= $Grid->pais->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pais->getDisplayValue($Grid->pais->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_pais" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pais" id="x<?= $Grid->RowIndex ?>_pais" value="<?= HtmlEncode($Grid->pais->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_pais" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pais" id="o<?= $Grid->RowIndex ?>_pais" value="<?= HtmlEncode($Grid->pais->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->estado->Visible) { // estado ?>
        <td data-name="estado">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_users_estado" class="form-group users_estado">
<template id="tp_x<?= $Grid->RowIndex ?>_estado">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="users" data-field="x_estado" name="x<?= $Grid->RowIndex ?>_estado" id="x<?= $Grid->RowIndex ?>_estado"<?= $Grid->estado->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_estado" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_estado"
    name="x<?= $Grid->RowIndex ?>_estado"
    value="<?= HtmlEncode($Grid->estado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_estado"
    data-target="dsl_x<?= $Grid->RowIndex ?>_estado"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->estado->isInvalidClass() ?>"
    data-table="users"
    data-field="x_estado"
    data-value-separator="<?= $Grid->estado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->estado->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->estado->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_users_estado" class="form-group users_estado">
<span<?= $Grid->estado->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->estado->getDisplayValue($Grid->estado->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_estado" data-hidden="1" name="x<?= $Grid->RowIndex ?>_estado" id="x<?= $Grid->RowIndex ?>_estado" value="<?= HtmlEncode($Grid->estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_estado" data-hidden="1" name="o<?= $Grid->RowIndex ?>_estado" id="o<?= $Grid->RowIndex ?>_estado" value="<?= HtmlEncode($Grid->estado->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->organizacion->Visible) { // organizacion ?>
        <td data-name="organizacion">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_users_organizacion" class="form-group users_organizacion">
<input type="<?= $Grid->organizacion->getInputTextType() ?>" data-table="users" data-field="x_organizacion" name="x<?= $Grid->RowIndex ?>_organizacion" id="x<?= $Grid->RowIndex ?>_organizacion" size="100" maxlength="100" placeholder="<?= HtmlEncode($Grid->organizacion->getPlaceHolder()) ?>" value="<?= $Grid->organizacion->EditValue ?>"<?= $Grid->organizacion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->organizacion->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_users_organizacion" class="form-group users_organizacion">
<span<?= $Grid->organizacion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->organizacion->getDisplayValue($Grid->organizacion->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_organizacion" data-hidden="1" name="x<?= $Grid->RowIndex ?>_organizacion" id="x<?= $Grid->RowIndex ?>_organizacion" value="<?= HtmlEncode($Grid->organizacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="users" data-field="x_organizacion" data-hidden="1" name="o<?= $Grid->RowIndex ?>_organizacion" id="o<?= $Grid->RowIndex ?>_organizacion" value="<?= HtmlEncode($Grid->organizacion->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->img_user->Visible) { // img_user ?>
        <td data-name="img_user">
<span id="el$rowindex$_users_img_user" class="form-group users_img_user">
<div id="fd_x<?= $Grid->RowIndex ?>_img_user">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->img_user->title() ?>" data-table="users" data-field="x_img_user" name="x<?= $Grid->RowIndex ?>_img_user" id="x<?= $Grid->RowIndex ?>_img_user" lang="<?= CurrentLanguageID() ?>"<?= $Grid->img_user->editAttributes() ?><?= ($Grid->img_user->ReadOnly || $Grid->img_user->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_img_user"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->img_user->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_img_user" id= "fn_x<?= $Grid->RowIndex ?>_img_user" value="<?= $Grid->img_user->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_img_user" id= "fa_x<?= $Grid->RowIndex ?>_img_user" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_img_user" id= "fs_x<?= $Grid->RowIndex ?>_img_user" value="60">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_img_user" id= "fx_x<?= $Grid->RowIndex ?>_img_user" value="<?= $Grid->img_user->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_img_user" id= "fm_x<?= $Grid->RowIndex ?>_img_user" value="<?= $Grid->img_user->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_img_user" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="users" data-field="x_img_user" data-hidden="1" name="o<?= $Grid->RowIndex ?>_img_user" id="o<?= $Grid->RowIndex ?>_img_user" value="<?= HtmlEncode($Grid->img_user->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fusersgrid","load"], function() {
    fusersgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fusersgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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
