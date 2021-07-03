<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ResmensajeAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fresmensajeadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fresmensajeadd = currentForm = new ew.Form("fresmensajeadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "resmensaje")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.resmensaje)
        ew.vars.tables.resmensaje = currentTable;
    fresmensajeadd.addFields([
        ["id_users", [fields.id_users.visible && fields.id_users.required ? ew.Validators.required(fields.id_users.caption) : null], fields.id_users.isInvalid],
        ["id_inyect", [fields.id_inyect.visible && fields.id_inyect.required ? ew.Validators.required(fields.id_inyect.caption) : null, ew.Validators.integer], fields.id_inyect.isInvalid],
        ["resmensaje", [fields.resmensaje.visible && fields.resmensaje.required ? ew.Validators.required(fields.resmensaje.caption) : null], fields.resmensaje.isInvalid],
        ["resadjunto", [fields.resadjunto.visible && fields.resadjunto.required ? ew.Validators.fileRequired(fields.resadjunto.caption) : null], fields.resadjunto.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fresmensajeadd,
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
    fresmensajeadd.validate = function () {
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

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fresmensajeadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fresmensajeadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fresmensajeadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fresmensajeadd" id="fresmensajeadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="resmensaje">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "mensajes") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="mensajes">
<input type="hidden" name="fk_id_inyect" value="<?= HtmlEncode($Page->id_inyect->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
    <div id="r_id_inyect" class="form-group row">
        <label id="elh_resmensaje_id_inyect" for="x_id_inyect" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_inyect->caption() ?><?= $Page->id_inyect->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_inyect->cellAttributes() ?>>
<?php if ($Page->id_inyect->getSessionValue() != "") { ?>
<span id="el_resmensaje_id_inyect">
<span<?= $Page->id_inyect->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_inyect->getDisplayValue($Page->id_inyect->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_id_inyect" name="x_id_inyect" value="<?= HtmlEncode($Page->id_inyect->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_resmensaje_id_inyect">
<input type="<?= $Page->id_inyect->getInputTextType() ?>" data-table="resmensaje" data-field="x_id_inyect" name="x_id_inyect" id="x_id_inyect" size="30" placeholder="<?= HtmlEncode($Page->id_inyect->getPlaceHolder()) ?>" value="<?= $Page->id_inyect->EditValue ?>"<?= $Page->id_inyect->editAttributes() ?> aria-describedby="x_id_inyect_help">
<?= $Page->id_inyect->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_inyect->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->resmensaje->Visible) { // resmensaje ?>
    <div id="r_resmensaje" class="form-group row">
        <label id="elh_resmensaje_resmensaje" for="x_resmensaje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->resmensaje->caption() ?><?= $Page->resmensaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->resmensaje->cellAttributes() ?>>
<span id="el_resmensaje_resmensaje">
<textarea data-table="resmensaje" data-field="x_resmensaje" name="x_resmensaje" id="x_resmensaje" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->resmensaje->getPlaceHolder()) ?>"<?= $Page->resmensaje->editAttributes() ?> aria-describedby="x_resmensaje_help"><?= $Page->resmensaje->EditValue ?></textarea>
<?= $Page->resmensaje->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->resmensaje->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->resadjunto->Visible) { // resadjunto ?>
    <div id="r_resadjunto" class="form-group row">
        <label id="elh_resmensaje_resadjunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->resadjunto->caption() ?><?= $Page->resadjunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->resadjunto->cellAttributes() ?>>
<span id="el_resmensaje_resadjunto">
<div id="fd_x_resadjunto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->resadjunto->title() ?>" data-table="resmensaje" data-field="x_resadjunto" name="x_resadjunto" id="x_resadjunto" lang="<?= CurrentLanguageID() ?>"<?= $Page->resadjunto->editAttributes() ?><?= ($Page->resadjunto->ReadOnly || $Page->resadjunto->Disabled) ? " disabled" : "" ?> aria-describedby="x_resadjunto_help">
        <label class="custom-file-label ew-file-label" for="x_resadjunto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->resadjunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->resadjunto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_resadjunto" id= "fn_x_resadjunto" value="<?= $Page->resadjunto->Upload->FileName ?>">
<input type="hidden" name="fa_x_resadjunto" id= "fa_x_resadjunto" value="0">
<input type="hidden" name="fs_x_resadjunto" id= "fs_x_resadjunto" value="80">
<input type="hidden" name="fx_x_resadjunto" id= "fx_x_resadjunto" value="<?= $Page->resadjunto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_resadjunto" id= "fm_x_resadjunto" value="<?= $Page->resadjunto->UploadMaxFileSize ?>">
</div>
<table id="ft_x_resadjunto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
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
