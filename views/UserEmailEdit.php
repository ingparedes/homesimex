<?php

namespace PHPMaker2021\simexamerica;

// Page object
$UserEmailEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fuser_emailedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fuser_emailedit = currentForm = new ew.Form("fuser_emailedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "user_email")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.user_email)
        ew.vars.tables.user_email = currentTable;
    fuser_emailedit.addFields([
        ["id_user_email", [fields.id_user_email.visible && fields.id_user_email.required ? ew.Validators.required(fields.id_user_email.caption) : null], fields.id_user_email.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null, ew.Validators.integer], fields.status.isInvalid],
        ["id_email", [fields.id_email.visible && fields.id_email.required ? ew.Validators.required(fields.id_email.caption) : null, ew.Validators.integer], fields.id_email.isInvalid],
        ["id_user_remitente", [fields.id_user_remitente.visible && fields.id_user_remitente.required ? ew.Validators.required(fields.id_user_remitente.caption) : null, ew.Validators.integer], fields.id_user_remitente.isInvalid],
        ["id_user_destinatario", [fields.id_user_destinatario.visible && fields.id_user_destinatario.required ? ew.Validators.required(fields.id_user_destinatario.caption) : null, ew.Validators.integer], fields.id_user_destinatario.isInvalid],
        ["id_mensaje", [fields.id_mensaje.visible && fields.id_mensaje.required ? ew.Validators.required(fields.id_mensaje.caption) : null, ew.Validators.integer], fields.id_mensaje.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fuser_emailedit,
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
    fuser_emailedit.validate = function () {
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
    fuser_emailedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuser_emailedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fuser_emailedit");
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
<form name="fuser_emailedit" id="fuser_emailedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_email">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_user_email->Visible) { // id_user_email ?>
    <div id="r_id_user_email" class="form-group row">
        <label id="elh_user_email_id_user_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_user_email->caption() ?><?= $Page->id_user_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_user_email->cellAttributes() ?>>
<span id="el_user_email_id_user_email">
<span<?= $Page->id_user_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_user_email->getDisplayValue($Page->id_user_email->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="user_email" data-field="x_id_user_email" data-hidden="1" name="x_id_user_email" id="x_id_user_email" value="<?= HtmlEncode($Page->id_user_email->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_user_email_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_user_email_status">
<input type="<?= $Page->status->getInputTextType() ?>" data-table="user_email" data-field="x_status" name="x_status" id="x_status" size="30" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>" value="<?= $Page->status->EditValue ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_email->Visible) { // id_email ?>
    <div id="r_id_email" class="form-group row">
        <label id="elh_user_email_id_email" for="x_id_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_email->caption() ?><?= $Page->id_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_email->cellAttributes() ?>>
<span id="el_user_email_id_email">
<input type="<?= $Page->id_email->getInputTextType() ?>" data-table="user_email" data-field="x_id_email" name="x_id_email" id="x_id_email" size="30" placeholder="<?= HtmlEncode($Page->id_email->getPlaceHolder()) ?>" value="<?= $Page->id_email->EditValue ?>"<?= $Page->id_email->editAttributes() ?> aria-describedby="x_id_email_help">
<?= $Page->id_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_user_remitente->Visible) { // id_user_remitente ?>
    <div id="r_id_user_remitente" class="form-group row">
        <label id="elh_user_email_id_user_remitente" for="x_id_user_remitente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_user_remitente->caption() ?><?= $Page->id_user_remitente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_user_remitente->cellAttributes() ?>>
<span id="el_user_email_id_user_remitente">
<input type="<?= $Page->id_user_remitente->getInputTextType() ?>" data-table="user_email" data-field="x_id_user_remitente" name="x_id_user_remitente" id="x_id_user_remitente" size="30" placeholder="<?= HtmlEncode($Page->id_user_remitente->getPlaceHolder()) ?>" value="<?= $Page->id_user_remitente->EditValue ?>"<?= $Page->id_user_remitente->editAttributes() ?> aria-describedby="x_id_user_remitente_help">
<?= $Page->id_user_remitente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_user_remitente->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_user_destinatario->Visible) { // id_user_destinatario ?>
    <div id="r_id_user_destinatario" class="form-group row">
        <label id="elh_user_email_id_user_destinatario" for="x_id_user_destinatario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_user_destinatario->caption() ?><?= $Page->id_user_destinatario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_user_destinatario->cellAttributes() ?>>
<span id="el_user_email_id_user_destinatario">
<input type="<?= $Page->id_user_destinatario->getInputTextType() ?>" data-table="user_email" data-field="x_id_user_destinatario" name="x_id_user_destinatario" id="x_id_user_destinatario" size="30" placeholder="<?= HtmlEncode($Page->id_user_destinatario->getPlaceHolder()) ?>" value="<?= $Page->id_user_destinatario->EditValue ?>"<?= $Page->id_user_destinatario->editAttributes() ?> aria-describedby="x_id_user_destinatario_help">
<?= $Page->id_user_destinatario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_user_destinatario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
    <div id="r_id_mensaje" class="form-group row">
        <label id="elh_user_email_id_mensaje" for="x_id_mensaje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_mensaje->caption() ?><?= $Page->id_mensaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_mensaje->cellAttributes() ?>>
<span id="el_user_email_id_mensaje">
<input type="<?= $Page->id_mensaje->getInputTextType() ?>" data-table="user_email" data-field="x_id_mensaje" name="x_id_mensaje" id="x_id_mensaje" size="30" placeholder="<?= HtmlEncode($Page->id_mensaje->getPlaceHolder()) ?>" value="<?= $Page->id_mensaje->EditValue ?>"<?= $Page->id_mensaje->editAttributes() ?> aria-describedby="x_id_mensaje_help">
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
    ew.addEventHandlers("user_email");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
