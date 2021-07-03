<?php

namespace PHPMaker2021\simexamerica;

// Set up and run Grid object
$Grid = Container("ResmensajeGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fresmensajegrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fresmensajegrid = new ew.Form("fresmensajegrid", "grid");
    fresmensajegrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "resmensaje")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.resmensaje)
        ew.vars.tables.resmensaje = currentTable;
    fresmensajegrid.addFields([
        ["id_resmensaje", [fields.id_resmensaje.visible && fields.id_resmensaje.required ? ew.Validators.required(fields.id_resmensaje.caption) : null], fields.id_resmensaje.isInvalid],
        ["id_users", [fields.id_users.visible && fields.id_users.required ? ew.Validators.required(fields.id_users.caption) : null], fields.id_users.isInvalid],
        ["id_inyect", [fields.id_inyect.visible && fields.id_inyect.required ? ew.Validators.required(fields.id_inyect.caption) : null, ew.Validators.integer], fields.id_inyect.isInvalid],
        ["resadjunto", [fields.resadjunto.visible && fields.resadjunto.required ? ew.Validators.fileRequired(fields.resadjunto.caption) : null], fields.resadjunto.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fresmensajegrid,
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
    fresmensajegrid.validate = function () {
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
    fresmensajegrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "id_inyect", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "resadjunto", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fresmensajegrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fresmensajegrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fresmensajegrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> resmensaje">
<div id="fresmensajegrid" class="ew-form ew-list-form form-inline">
<div id="gmp_resmensaje" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_resmensajegrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->id_resmensaje->Visible) { // id_resmensaje ?>
        <th data-name="id_resmensaje" class="<?= $Grid->id_resmensaje->headerCellClass() ?>"><div id="elh_resmensaje_id_resmensaje" class="resmensaje_id_resmensaje"><?= $Grid->renderSort($Grid->id_resmensaje) ?></div></th>
<?php } ?>
<?php if ($Grid->id_users->Visible) { // id_users ?>
        <th data-name="id_users" class="<?= $Grid->id_users->headerCellClass() ?>"><div id="elh_resmensaje_id_users" class="resmensaje_id_users"><?= $Grid->renderSort($Grid->id_users) ?></div></th>
<?php } ?>
<?php if ($Grid->id_inyect->Visible) { // id_inyect ?>
        <th data-name="id_inyect" class="<?= $Grid->id_inyect->headerCellClass() ?>"><div id="elh_resmensaje_id_inyect" class="resmensaje_id_inyect"><?= $Grid->renderSort($Grid->id_inyect) ?></div></th>
<?php } ?>
<?php if ($Grid->resadjunto->Visible) { // resadjunto ?>
        <th data-name="resadjunto" class="<?= $Grid->resadjunto->headerCellClass() ?>"><div id="elh_resmensaje_resadjunto" class="resmensaje_resadjunto"><?= $Grid->renderSort($Grid->resadjunto) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_resmensaje", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->id_resmensaje->Visible) { // id_resmensaje ?>
        <td data-name="id_resmensaje" <?= $Grid->id_resmensaje->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_id_resmensaje" class="form-group"></span>
<input type="hidden" data-table="resmensaje" data-field="x_id_resmensaje" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_resmensaje" id="o<?= $Grid->RowIndex ?>_id_resmensaje" value="<?= HtmlEncode($Grid->id_resmensaje->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_id_resmensaje" class="form-group">
<span<?= $Grid->id_resmensaje->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_resmensaje->getDisplayValue($Grid->id_resmensaje->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="resmensaje" data-field="x_id_resmensaje" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_resmensaje" id="x<?= $Grid->RowIndex ?>_id_resmensaje" value="<?= HtmlEncode($Grid->id_resmensaje->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_id_resmensaje">
<span<?= $Grid->id_resmensaje->viewAttributes() ?>>
<?= $Grid->id_resmensaje->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="resmensaje" data-field="x_id_resmensaje" data-hidden="1" name="fresmensajegrid$x<?= $Grid->RowIndex ?>_id_resmensaje" id="fresmensajegrid$x<?= $Grid->RowIndex ?>_id_resmensaje" value="<?= HtmlEncode($Grid->id_resmensaje->FormValue) ?>">
<input type="hidden" data-table="resmensaje" data-field="x_id_resmensaje" data-hidden="1" name="fresmensajegrid$o<?= $Grid->RowIndex ?>_id_resmensaje" id="fresmensajegrid$o<?= $Grid->RowIndex ?>_id_resmensaje" value="<?= HtmlEncode($Grid->id_resmensaje->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="resmensaje" data-field="x_id_resmensaje" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_resmensaje" id="x<?= $Grid->RowIndex ?>_id_resmensaje" value="<?= HtmlEncode($Grid->id_resmensaje->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->id_users->Visible) { // id_users ?>
        <td data-name="id_users" <?= $Grid->id_users->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="resmensaje" data-field="x_id_users" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_users" id="o<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_id_users">
<span<?= $Grid->id_users->viewAttributes() ?>>
<?= $Grid->id_users->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="resmensaje" data-field="x_id_users" data-hidden="1" name="fresmensajegrid$x<?= $Grid->RowIndex ?>_id_users" id="fresmensajegrid$x<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->FormValue) ?>">
<input type="hidden" data-table="resmensaje" data-field="x_id_users" data-hidden="1" name="fresmensajegrid$o<?= $Grid->RowIndex ?>_id_users" id="fresmensajegrid$o<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->id_inyect->Visible) { // id_inyect ?>
        <td data-name="id_inyect" <?= $Grid->id_inyect->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->id_inyect->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_id_inyect" class="form-group">
<span<?= $Grid->id_inyect->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_inyect->getDisplayValue($Grid->id_inyect->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_inyect" name="x<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_id_inyect" class="form-group">
<input type="<?= $Grid->id_inyect->getInputTextType() ?>" data-table="resmensaje" data-field="x_id_inyect" name="x<?= $Grid->RowIndex ?>_id_inyect" id="x<?= $Grid->RowIndex ?>_id_inyect" size="30" placeholder="<?= HtmlEncode($Grid->id_inyect->getPlaceHolder()) ?>" value="<?= $Grid->id_inyect->EditValue ?>"<?= $Grid->id_inyect->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_inyect->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="resmensaje" data-field="x_id_inyect" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_inyect" id="o<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->id_inyect->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_id_inyect" class="form-group">
<span<?= $Grid->id_inyect->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_inyect->getDisplayValue($Grid->id_inyect->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_inyect" name="x<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_id_inyect" class="form-group">
<input type="<?= $Grid->id_inyect->getInputTextType() ?>" data-table="resmensaje" data-field="x_id_inyect" name="x<?= $Grid->RowIndex ?>_id_inyect" id="x<?= $Grid->RowIndex ?>_id_inyect" size="30" placeholder="<?= HtmlEncode($Grid->id_inyect->getPlaceHolder()) ?>" value="<?= $Grid->id_inyect->EditValue ?>"<?= $Grid->id_inyect->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_inyect->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_id_inyect">
<span<?= $Grid->id_inyect->viewAttributes() ?>>
<?= $Grid->id_inyect->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="resmensaje" data-field="x_id_inyect" data-hidden="1" name="fresmensajegrid$x<?= $Grid->RowIndex ?>_id_inyect" id="fresmensajegrid$x<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->FormValue) ?>">
<input type="hidden" data-table="resmensaje" data-field="x_id_inyect" data-hidden="1" name="fresmensajegrid$o<?= $Grid->RowIndex ?>_id_inyect" id="fresmensajegrid$o<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->resadjunto->Visible) { // resadjunto ?>
        <td data-name="resadjunto" <?= $Grid->resadjunto->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_resmensaje_resadjunto" class="form-group resmensaje_resadjunto">
<div id="fd_x<?= $Grid->RowIndex ?>_resadjunto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->resadjunto->title() ?>" data-table="resmensaje" data-field="x_resadjunto" name="x<?= $Grid->RowIndex ?>_resadjunto" id="x<?= $Grid->RowIndex ?>_resadjunto" lang="<?= CurrentLanguageID() ?>"<?= $Grid->resadjunto->editAttributes() ?><?= ($Grid->resadjunto->ReadOnly || $Grid->resadjunto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_resadjunto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->resadjunto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_resadjunto" id= "fn_x<?= $Grid->RowIndex ?>_resadjunto" value="<?= $Grid->resadjunto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_resadjunto" id= "fa_x<?= $Grid->RowIndex ?>_resadjunto" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_resadjunto" id= "fs_x<?= $Grid->RowIndex ?>_resadjunto" value="80">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_resadjunto" id= "fx_x<?= $Grid->RowIndex ?>_resadjunto" value="<?= $Grid->resadjunto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_resadjunto" id= "fm_x<?= $Grid->RowIndex ?>_resadjunto" value="<?= $Grid->resadjunto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_resadjunto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="resmensaje" data-field="x_resadjunto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_resadjunto" id="o<?= $Grid->RowIndex ?>_resadjunto" value="<?= HtmlEncode($Grid->resadjunto->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_resadjunto">
<span<?= $Grid->resadjunto->viewAttributes() ?>>
<?= GetFileViewTag($Grid->resadjunto, $Grid->resadjunto->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_resmensaje_resadjunto" class="form-group resmensaje_resadjunto">
<div id="fd_x<?= $Grid->RowIndex ?>_resadjunto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->resadjunto->title() ?>" data-table="resmensaje" data-field="x_resadjunto" name="x<?= $Grid->RowIndex ?>_resadjunto" id="x<?= $Grid->RowIndex ?>_resadjunto" lang="<?= CurrentLanguageID() ?>"<?= $Grid->resadjunto->editAttributes() ?><?= ($Grid->resadjunto->ReadOnly || $Grid->resadjunto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_resadjunto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->resadjunto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_resadjunto" id= "fn_x<?= $Grid->RowIndex ?>_resadjunto" value="<?= $Grid->resadjunto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_resadjunto" id= "fa_x<?= $Grid->RowIndex ?>_resadjunto" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_resadjunto") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_resadjunto" id= "fs_x<?= $Grid->RowIndex ?>_resadjunto" value="80">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_resadjunto" id= "fx_x<?= $Grid->RowIndex ?>_resadjunto" value="<?= $Grid->resadjunto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_resadjunto" id= "fm_x<?= $Grid->RowIndex ?>_resadjunto" value="<?= $Grid->resadjunto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_resadjunto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
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
loadjs.ready(["fresmensajegrid","load"], function () {
    fresmensajegrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_resmensaje", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->id_resmensaje->Visible) { // id_resmensaje ?>
        <td data-name="id_resmensaje">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_resmensaje_id_resmensaje" class="form-group resmensaje_id_resmensaje"></span>
<?php } else { ?>
<span id="el$rowindex$_resmensaje_id_resmensaje" class="form-group resmensaje_id_resmensaje">
<span<?= $Grid->id_resmensaje->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_resmensaje->getDisplayValue($Grid->id_resmensaje->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="resmensaje" data-field="x_id_resmensaje" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_resmensaje" id="x<?= $Grid->RowIndex ?>_id_resmensaje" value="<?= HtmlEncode($Grid->id_resmensaje->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="resmensaje" data-field="x_id_resmensaje" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_resmensaje" id="o<?= $Grid->RowIndex ?>_id_resmensaje" value="<?= HtmlEncode($Grid->id_resmensaje->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->id_users->Visible) { // id_users ?>
        <td data-name="id_users">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_resmensaje_id_users" class="form-group resmensaje_id_users">
<span<?= $Grid->id_users->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_users->getDisplayValue($Grid->id_users->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="resmensaje" data-field="x_id_users" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_users" id="x<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="resmensaje" data-field="x_id_users" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_users" id="o<?= $Grid->RowIndex ?>_id_users" value="<?= HtmlEncode($Grid->id_users->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->id_inyect->Visible) { // id_inyect ?>
        <td data-name="id_inyect">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->id_inyect->getSessionValue() != "") { ?>
<span id="el$rowindex$_resmensaje_id_inyect" class="form-group resmensaje_id_inyect">
<span<?= $Grid->id_inyect->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_inyect->getDisplayValue($Grid->id_inyect->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_inyect" name="x<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_resmensaje_id_inyect" class="form-group resmensaje_id_inyect">
<input type="<?= $Grid->id_inyect->getInputTextType() ?>" data-table="resmensaje" data-field="x_id_inyect" name="x<?= $Grid->RowIndex ?>_id_inyect" id="x<?= $Grid->RowIndex ?>_id_inyect" size="30" placeholder="<?= HtmlEncode($Grid->id_inyect->getPlaceHolder()) ?>" value="<?= $Grid->id_inyect->EditValue ?>"<?= $Grid->id_inyect->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_inyect->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_resmensaje_id_inyect" class="form-group resmensaje_id_inyect">
<span<?= $Grid->id_inyect->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_inyect->getDisplayValue($Grid->id_inyect->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="resmensaje" data-field="x_id_inyect" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_inyect" id="x<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="resmensaje" data-field="x_id_inyect" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_inyect" id="o<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->resadjunto->Visible) { // resadjunto ?>
        <td data-name="resadjunto">
<span id="el$rowindex$_resmensaje_resadjunto" class="form-group resmensaje_resadjunto">
<div id="fd_x<?= $Grid->RowIndex ?>_resadjunto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->resadjunto->title() ?>" data-table="resmensaje" data-field="x_resadjunto" name="x<?= $Grid->RowIndex ?>_resadjunto" id="x<?= $Grid->RowIndex ?>_resadjunto" lang="<?= CurrentLanguageID() ?>"<?= $Grid->resadjunto->editAttributes() ?><?= ($Grid->resadjunto->ReadOnly || $Grid->resadjunto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_resadjunto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->resadjunto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_resadjunto" id= "fn_x<?= $Grid->RowIndex ?>_resadjunto" value="<?= $Grid->resadjunto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_resadjunto" id= "fa_x<?= $Grid->RowIndex ?>_resadjunto" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_resadjunto" id= "fs_x<?= $Grid->RowIndex ?>_resadjunto" value="80">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_resadjunto" id= "fx_x<?= $Grid->RowIndex ?>_resadjunto" value="<?= $Grid->resadjunto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_resadjunto" id= "fm_x<?= $Grid->RowIndex ?>_resadjunto" value="<?= $Grid->resadjunto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_resadjunto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="resmensaje" data-field="x_resadjunto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_resadjunto" id="o<?= $Grid->RowIndex ?>_resadjunto" value="<?= HtmlEncode($Grid->resadjunto->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fresmensajegrid","load"], function() {
    fresmensajegrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fresmensajegrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
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
    ew.addEventHandlers("resmensaje");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
