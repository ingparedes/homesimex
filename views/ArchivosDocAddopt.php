<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArchivosDocAddopt = &$Page;
?>
<script>
var currentForm, currentPageID;
var farchivos_docaddopt;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "addopt";
    farchivos_docaddopt = currentForm = new ew.Form("farchivos_docaddopt", "addopt");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "archivos_doc")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.archivos_doc)
        ew.vars.tables.archivos_doc = currentTable;
    farchivos_docaddopt.addFields([
        ["id_users", [fields.id_users.visible && fields.id_users.required ? ew.Validators.required(fields.id_users.caption) : null], fields.id_users.isInvalid],
        ["file_name", [fields.file_name.visible && fields.file_name.required ? ew.Validators.fileRequired(fields.file_name.caption) : null], fields.file_name.isInvalid],
        ["fecha_created", [fields.fecha_created.visible && fields.fecha_created.required ? ew.Validators.required(fields.fecha_created.caption) : null], fields.fecha_created.isInvalid],
        ["boton", [fields.boton.visible && fields.boton.required ? ew.Validators.required(fields.boton.caption) : null], fields.boton.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farchivos_docaddopt,
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
    farchivos_docaddopt.validate = function () {
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

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }
        return true;
    }

    // Form_CustomValidate
    farchivos_docaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farchivos_docaddopt.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farchivos_docaddopt.lists.id_users = <?= $Page->id_users->toClientList($Page) ?>;
    loadjs.done("farchivos_docaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="farchivos_docaddopt" id="farchivos_docaddopt" class="ew-form ew-horizontal" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="archivos_doc">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->id_users->Visible) { // id_users ?>
    <?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("addopt")) { // Non system admin ?>
    <input type="hidden" data-table="archivos_doc" data-field="x_id_users" data-hidden="1" name="x_id_users" id="x_id_users" value="<?= HtmlEncode($Page->id_users->CurrentValue) ?>">
    <?php } else { ?>
    <input type="hidden" data-table="archivos_doc" data-field="x_id_users" data-hidden="1" name="x_id_users" id="x_id_users" value="<?= HtmlEncode($Page->id_users->CurrentValue) ?>">
    <?php } ?>
<?php } ?>
<?php if ($Page->file_name->Visible) { // file_name ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->file_name->caption() ?><?= $Page->file_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<div id="fd_x_file_name">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->file_name->title() ?>" data-table="archivos_doc" data-field="x_file_name" name="x_file_name" id="x_file_name" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_name->editAttributes() ?><?= ($Page->file_name->ReadOnly || $Page->file_name->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x_file_name"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->file_name->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file_name" id= "fn_x_file_name" value="<?= $Page->file_name->Upload->FileName ?>">
<input type="hidden" name="fa_x_file_name" id= "fa_x_file_name" value="0">
<input type="hidden" name="fs_x_file_name" id= "fs_x_file_name" value="100">
<input type="hidden" name="fx_x_file_name" id= "fx_x_file_name" value="<?= $Page->file_name->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file_name" id= "fm_x_file_name" value="<?= $Page->file_name->UploadMaxFileSize ?>">
</div>
<table id="ft_x_file_name" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</div>
    </div>
<?php } ?>
<?php if ($Page->fecha_created->Visible) { // fecha_created ?>
    <input type="hidden" data-table="archivos_doc" data-field="x_fecha_created" data-hidden="1" name="x_fecha_created" id="x_fecha_created" value="<?= HtmlEncode($Page->fecha_created->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->boton->Visible) { // boton ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_boton"><?= $Page->boton->caption() ?><?= $Page->boton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<textarea data-table="archivos_doc" data-field="x_boton" name="x_boton" id="x_boton" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->boton->getPlaceHolder()) ?>"<?= $Page->boton->editAttributes() ?>><?= $Page->boton->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->boton->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("archivos_doc");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
