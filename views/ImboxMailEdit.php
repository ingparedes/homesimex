<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ImboxMailEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fimbox_mailedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fimbox_mailedit = currentForm = new ew.Form("fimbox_mailedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "imbox_mail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.imbox_mail)
        ew.vars.tables.imbox_mail = currentTable;
    fimbox_mailedit.addFields([
        ["id_email", [fields.id_email.visible && fields.id_email.required ? ew.Validators.required(fields.id_email.caption) : null], fields.id_email.isInvalid],
        ["sender_userid", [fields.sender_userid.visible && fields.sender_userid.required ? ew.Validators.required(fields.sender_userid.caption) : null], fields.sender_userid.isInvalid],
        ["reciever_userid", [fields.reciever_userid.visible && fields.reciever_userid.required ? ew.Validators.required(fields.reciever_userid.caption) : null], fields.reciever_userid.isInvalid],
        ["alerta", [fields.alerta.visible && fields.alerta.required ? ew.Validators.required(fields.alerta.caption) : null], fields.alerta.isInvalid],
        ["copy_sender", [fields.copy_sender.visible && fields.copy_sender.required ? ew.Validators.required(fields.copy_sender.caption) : null], fields.copy_sender.isInvalid],
        ["sujeto", [fields.sujeto.visible && fields.sujeto.required ? ew.Validators.required(fields.sujeto.caption) : null], fields.sujeto.isInvalid],
        ["mensaje", [fields.mensaje.visible && fields.mensaje.required ? ew.Validators.required(fields.mensaje.caption) : null], fields.mensaje.isInvalid],
        ["archivo", [fields.archivo.visible && fields.archivo.required ? ew.Validators.fileRequired(fields.archivo.caption) : null], fields.archivo.isInvalid],
        ["tiempo", [fields.tiempo.visible && fields.tiempo.required ? ew.Validators.required(fields.tiempo.caption) : null], fields.tiempo.isInvalid],
        ["estado_msg", [fields.estado_msg.visible && fields.estado_msg.required ? ew.Validators.required(fields.estado_msg.caption) : null, ew.Validators.integer], fields.estado_msg.isInvalid],
        ["id_mensaje", [fields.id_mensaje.visible && fields.id_mensaje.required ? ew.Validators.required(fields.id_mensaje.caption) : null, ew.Validators.integer], fields.id_mensaje.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fimbox_mailedit,
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
    fimbox_mailedit.validate = function () {
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
    fimbox_mailedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fimbox_mailedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fimbox_mailedit.lists.sender_userid = <?= $Page->sender_userid->toClientList($Page) ?>;
    fimbox_mailedit.lists.reciever_userid = <?= $Page->reciever_userid->toClientList($Page) ?>;
    fimbox_mailedit.lists.copy_sender = <?= $Page->copy_sender->toClientList($Page) ?>;
    loadjs.done("fimbox_mailedit");
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
<form name="fimbox_mailedit" id="fimbox_mailedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="imbox_mail">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_email->Visible) { // id_email ?>
    <div id="r_id_email" class="form-group row">
        <label id="elh_imbox_mail_id_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_email->caption() ?><?= $Page->id_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_email->cellAttributes() ?>>
<span id="el_imbox_mail_id_email">
<span<?= $Page->id_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_email->getDisplayValue($Page->id_email->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="imbox_mail" data-field="x_id_email" data-hidden="1" name="x_id_email" id="x_id_email" value="<?= HtmlEncode($Page->id_email->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sender_userid->Visible) { // sender_userid ?>
    <div id="r_sender_userid" class="form-group row">
        <label id="elh_imbox_mail_sender_userid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sender_userid->caption() ?><?= $Page->sender_userid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sender_userid->cellAttributes() ?>>
<span id="el_imbox_mail_sender_userid">
    <select
        id="x_sender_userid[]"
        name="x_sender_userid[]"
        class="form-control ew-select<?= $Page->sender_userid->isInvalidClass() ?>"
        data-select2-id="imbox_mail_x_sender_userid[]"
        data-table="imbox_mail"
        data-field="x_sender_userid"
        data-dropdown
        multiple
        size="1"
        data-value-separator="<?= $Page->sender_userid->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->sender_userid->getPlaceHolder()) ?>"
        <?= $Page->sender_userid->editAttributes() ?>>
        <?= $Page->sender_userid->selectOptionListHtml("x_sender_userid[]") ?>
    </select>
    <?= $Page->sender_userid->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->sender_userid->getErrorMessage() ?></div>
<?= $Page->sender_userid->Lookup->getParamTag($Page, "p_x_sender_userid") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='imbox_mail_x_sender_userid[]']"),
        options = { name: "x_sender_userid[]", selectId: "imbox_mail_x_sender_userid[]", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.multiple = true;
    options.closeOnSelect = false;
    options.columns = el.dataset.repeatcolumn || 3;
    options.dropdown = !ew.IS_MOBILE && options.columns > 0; // Use custom dropdown
    if (options.dropdown) {
        options.dropdownAutoWidth = true;
        options.dropdownCssClass = "ew-select-dropdown ew-select-multiple";
        if (options.columns > 1)
            options.dropdownCssClass += " ew-repeat-column";
    }
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.imbox_mail.fields.sender_userid.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alerta->Visible) { // alerta ?>
    <div id="r_alerta" class="form-group row">
        <label id="elh_imbox_mail_alerta" for="x_alerta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alerta->caption() ?><?= $Page->alerta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alerta->cellAttributes() ?>>
<span id="el_imbox_mail_alerta">
<textarea data-table="imbox_mail" data-field="x_alerta" name="x_alerta" id="x_alerta" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->alerta->getPlaceHolder()) ?>"<?= $Page->alerta->editAttributes() ?> aria-describedby="x_alerta_help"><?= $Page->alerta->EditValue ?></textarea>
<?= $Page->alerta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alerta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->copy_sender->Visible) { // copy_sender ?>
    <div id="r_copy_sender" class="form-group row">
        <label id="elh_imbox_mail_copy_sender" class="<?= $Page->LeftColumnClass ?>"><?= $Page->copy_sender->caption() ?><?= $Page->copy_sender->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->copy_sender->cellAttributes() ?>>
<span id="el_imbox_mail_copy_sender">
    <select
        id="x_copy_sender[]"
        name="x_copy_sender[]"
        class="form-control ew-select<?= $Page->copy_sender->isInvalidClass() ?>"
        data-select2-id="imbox_mail_x_copy_sender[]"
        data-table="imbox_mail"
        data-field="x_copy_sender"
        data-dropdown
        multiple
        size="1"
        data-value-separator="<?= $Page->copy_sender->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->copy_sender->getPlaceHolder()) ?>"
        <?= $Page->copy_sender->editAttributes() ?>>
        <?= $Page->copy_sender->selectOptionListHtml("x_copy_sender[]") ?>
    </select>
    <?= $Page->copy_sender->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->copy_sender->getErrorMessage() ?></div>
<?= $Page->copy_sender->Lookup->getParamTag($Page, "p_x_copy_sender") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='imbox_mail_x_copy_sender[]']"),
        options = { name: "x_copy_sender[]", selectId: "imbox_mail_x_copy_sender[]", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.multiple = true;
    options.closeOnSelect = false;
    options.columns = el.dataset.repeatcolumn || 3;
    options.dropdown = !ew.IS_MOBILE && options.columns > 0; // Use custom dropdown
    if (options.dropdown) {
        options.dropdownAutoWidth = true;
        options.dropdownCssClass = "ew-select-dropdown ew-select-multiple";
        if (options.columns > 1)
            options.dropdownCssClass += " ew-repeat-column";
    }
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.imbox_mail.fields.copy_sender.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
    <div id="r_sujeto" class="form-group row">
        <label id="elh_imbox_mail_sujeto" for="x_sujeto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sujeto->caption() ?><?= $Page->sujeto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sujeto->cellAttributes() ?>>
<span id="el_imbox_mail_sujeto">
<input type="<?= $Page->sujeto->getInputTextType() ?>" data-table="imbox_mail" data-field="x_sujeto" name="x_sujeto" id="x_sujeto" size="60" maxlength="60" placeholder="<?= HtmlEncode($Page->sujeto->getPlaceHolder()) ?>" value="<?= $Page->sujeto->EditValue ?>"<?= $Page->sujeto->editAttributes() ?> aria-describedby="x_sujeto_help">
<?= $Page->sujeto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sujeto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
    <div id="r_mensaje" class="form-group row">
        <label id="elh_imbox_mail_mensaje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mensaje->caption() ?><?= $Page->mensaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mensaje->cellAttributes() ?>>
<span id="el_imbox_mail_mensaje">
<?php $Page->mensaje->EditAttrs->appendClass("editor"); ?>
<textarea data-table="imbox_mail" data-field="x_mensaje" name="x_mensaje" id="x_mensaje" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->mensaje->getPlaceHolder()) ?>"<?= $Page->mensaje->editAttributes() ?> aria-describedby="x_mensaje_help"><?= $Page->mensaje->EditValue ?></textarea>
<?= $Page->mensaje->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mensaje->getErrorMessage() ?></div>
<script>
loadjs.ready(["fimbox_mailedit", "editor"], function() {
	ew.createEditor("fimbox_mailedit", "x_mensaje", 0, 0, <?= $Page->mensaje->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <div id="r_archivo" class="form-group row">
        <label id="elh_imbox_mail_archivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->archivo->caption() ?><?= $Page->archivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->archivo->cellAttributes() ?>>
<span id="el_imbox_mail_archivo">
<div id="fd_x_archivo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->archivo->title() ?>" data-table="imbox_mail" data-field="x_archivo" name="x_archivo" id="x_archivo" lang="<?= CurrentLanguageID() ?>"<?= $Page->archivo->editAttributes() ?><?= ($Page->archivo->ReadOnly || $Page->archivo->Disabled) ? " disabled" : "" ?> aria-describedby="x_archivo_help">
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
<?php if ($Page->estado_msg->Visible) { // estado_msg ?>
    <div id="r_estado_msg" class="form-group row">
        <label id="elh_imbox_mail_estado_msg" for="x_estado_msg" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estado_msg->caption() ?><?= $Page->estado_msg->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->estado_msg->cellAttributes() ?>>
<span id="el_imbox_mail_estado_msg">
<input type="<?= $Page->estado_msg->getInputTextType() ?>" data-table="imbox_mail" data-field="x_estado_msg" name="x_estado_msg" id="x_estado_msg" size="30" placeholder="<?= HtmlEncode($Page->estado_msg->getPlaceHolder()) ?>" value="<?= $Page->estado_msg->EditValue ?>"<?= $Page->estado_msg->editAttributes() ?> aria-describedby="x_estado_msg_help">
<?= $Page->estado_msg->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estado_msg->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
    <div id="r_id_mensaje" class="form-group row">
        <label id="elh_imbox_mail_id_mensaje" for="x_id_mensaje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_mensaje->caption() ?><?= $Page->id_mensaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_mensaje->cellAttributes() ?>>
<span id="el_imbox_mail_id_mensaje">
<input type="<?= $Page->id_mensaje->getInputTextType() ?>" data-table="imbox_mail" data-field="x_id_mensaje" name="x_id_mensaje" id="x_id_mensaje" size="30" placeholder="<?= HtmlEncode($Page->id_mensaje->getPlaceHolder()) ?>" value="<?= $Page->id_mensaje->EditValue ?>"<?= $Page->id_mensaje->editAttributes() ?> aria-describedby="x_id_mensaje_help">
<?= $Page->id_mensaje->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_mensaje->getErrorMessage() ?></div>
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
    ew.addEventHandlers("imbox_mail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
