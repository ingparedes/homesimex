<?php

namespace PHPMaker2021\simexamerica;

// Page object
$SendEmail2Edit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsend_email2edit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fsend_email2edit = currentForm = new ew.Form("fsend_email2edit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "send_email2")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.send_email2)
        ew.vars.tables.send_email2 = currentTable;
    fsend_email2edit.addFields([
        ["id_sendemail", [fields.id_sendemail.visible && fields.id_sendemail.required ? ew.Validators.required(fields.id_sendemail.caption) : null], fields.id_sendemail.isInvalid],
        ["sujeto", [fields.sujeto.visible && fields.sujeto.required ? ew.Validators.required(fields.sujeto.caption) : null], fields.sujeto.isInvalid],
        ["mensaje", [fields.mensaje.visible && fields.mensaje.required ? ew.Validators.required(fields.mensaje.caption) : null], fields.mensaje.isInvalid],
        ["tiempo", [fields.tiempo.visible && fields.tiempo.required ? ew.Validators.required(fields.tiempo.caption) : null], fields.tiempo.isInvalid],
        ["archivo", [fields.archivo.visible && fields.archivo.required ? ew.Validators.fileRequired(fields.archivo.caption) : null], fields.archivo.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["de_user", [fields.de_user.visible && fields.de_user.required ? ew.Validators.required(fields.de_user.caption) : null], fields.de_user.isInvalid],
        ["copy_user", [fields.copy_user.visible && fields.copy_user.required ? ew.Validators.required(fields.copy_user.caption) : null], fields.copy_user.isInvalid],
        ["para_user", [fields.para_user.visible && fields.para_user.required ? ew.Validators.required(fields.para_user.caption) : null], fields.para_user.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsend_email2edit,
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
    fsend_email2edit.validate = function () {
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
    fsend_email2edit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsend_email2edit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsend_email2edit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    fsend_email2edit.lists.para_user = <?= $Page->para_user->toClientList($Page) ?>;
    loadjs.done("fsend_email2edit");
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
<form name="fsend_email2edit" id="fsend_email2edit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="send_email2">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_sendemail->Visible) { // id_sendemail ?>
    <div id="r_id_sendemail" class="form-group row">
        <label id="elh_send_email2_id_sendemail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_sendemail->caption() ?><?= $Page->id_sendemail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_sendemail->cellAttributes() ?>>
<span id="el_send_email2_id_sendemail">
<span<?= $Page->id_sendemail->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_sendemail->getDisplayValue($Page->id_sendemail->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="send_email2" data-field="x_id_sendemail" data-hidden="1" name="x_id_sendemail" id="x_id_sendemail" value="<?= HtmlEncode($Page->id_sendemail->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
    <div id="r_sujeto" class="form-group row">
        <label id="elh_send_email2_sujeto" for="x_sujeto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sujeto->caption() ?><?= $Page->sujeto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sujeto->cellAttributes() ?>>
<span id="el_send_email2_sujeto">
<input type="<?= $Page->sujeto->getInputTextType() ?>" data-table="send_email2" data-field="x_sujeto" name="x_sujeto" id="x_sujeto" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->sujeto->getPlaceHolder()) ?>" value="<?= $Page->sujeto->EditValue ?>"<?= $Page->sujeto->editAttributes() ?> aria-describedby="x_sujeto_help">
<?= $Page->sujeto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sujeto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
    <div id="r_mensaje" class="form-group row">
        <label id="elh_send_email2_mensaje" for="x_mensaje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mensaje->caption() ?><?= $Page->mensaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mensaje->cellAttributes() ?>>
<span id="el_send_email2_mensaje">
<textarea data-table="send_email2" data-field="x_mensaje" name="x_mensaje" id="x_mensaje" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->mensaje->getPlaceHolder()) ?>"<?= $Page->mensaje->editAttributes() ?> aria-describedby="x_mensaje_help"><?= $Page->mensaje->EditValue ?></textarea>
<?= $Page->mensaje->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mensaje->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <div id="r_archivo" class="form-group row">
        <label id="elh_send_email2_archivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->archivo->caption() ?><?= $Page->archivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->archivo->cellAttributes() ?>>
<span id="el_send_email2_archivo">
<div id="fd_x_archivo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->archivo->title() ?>" data-table="send_email2" data-field="x_archivo" name="x_archivo" id="x_archivo" lang="<?= CurrentLanguageID() ?>"<?= $Page->archivo->editAttributes() ?><?= ($Page->archivo->ReadOnly || $Page->archivo->Disabled) ? " disabled" : "" ?> aria-describedby="x_archivo_help">
        <label class="custom-file-label ew-file-label" for="x_archivo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->archivo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->archivo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_archivo" id= "fn_x_archivo" value="<?= $Page->archivo->Upload->FileName ?>">
<input type="hidden" name="fa_x_archivo" id= "fa_x_archivo" value="<?= (Post("fa_x_archivo") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_archivo" id= "fs_x_archivo" value="100">
<input type="hidden" name="fx_x_archivo" id= "fx_x_archivo" value="<?= $Page->archivo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_archivo" id= "fm_x_archivo" value="<?= $Page->archivo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_archivo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_send_email2_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_send_email2_status">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->status->isInvalidClass() ?>" data-table="send_email2" data-field="x_status" name="x_status[]" id="x_status_199659" value="1"<?= ConvertToBool($Page->status->CurrentValue) ? " checked" : "" ?><?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
    <label class="custom-control-label" for="x_status_199659"></label>
</div>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->copy_user->Visible) { // copy_user ?>
    <div id="r_copy_user" class="form-group row">
        <label id="elh_send_email2_copy_user" for="x_copy_user" class="<?= $Page->LeftColumnClass ?>"><?= $Page->copy_user->caption() ?><?= $Page->copy_user->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->copy_user->cellAttributes() ?>>
<span id="el_send_email2_copy_user">
<input type="<?= $Page->copy_user->getInputTextType() ?>" data-table="send_email2" data-field="x_copy_user" name="x_copy_user" id="x_copy_user" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->copy_user->getPlaceHolder()) ?>" value="<?= $Page->copy_user->EditValue ?>"<?= $Page->copy_user->editAttributes() ?> aria-describedby="x_copy_user_help">
<?= $Page->copy_user->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->copy_user->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->para_user->Visible) { // para_user ?>
    <div id="r_para_user" class="form-group row">
        <label id="elh_send_email2_para_user" for="x_para_user" class="<?= $Page->LeftColumnClass ?>"><?= $Page->para_user->caption() ?><?= $Page->para_user->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->para_user->cellAttributes() ?>>
<span id="el_send_email2_para_user">
    <select
        id="x_para_user"
        name="x_para_user"
        class="form-control ew-select<?= $Page->para_user->isInvalidClass() ?>"
        data-select2-id="send_email2_x_para_user"
        data-table="send_email2"
        data-field="x_para_user"
        data-value-separator="<?= $Page->para_user->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->para_user->getPlaceHolder()) ?>"
        <?= $Page->para_user->editAttributes() ?>>
        <?= $Page->para_user->selectOptionListHtml("x_para_user") ?>
    </select>
    <?= $Page->para_user->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->para_user->getErrorMessage() ?></div>
<?= $Page->para_user->Lookup->getParamTag($Page, "p_x_para_user") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='send_email2_x_para_user']"),
        options = { name: "x_para_user", selectId: "send_email2_x_para_user", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.send_email2.fields.para_user.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("send_email2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
