<?php

namespace PHPMaker2021\simexamerica;

// Page object
$NotiemailAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnotiemailadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnotiemailadd = currentForm = new ew.Form("fnotiemailadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "notiemail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.notiemail)
        ew.vars.tables.notiemail = currentTable;
    fnotiemailadd.addFields([
        ["id_email", [fields.id_email.visible && fields.id_email.required ? ew.Validators.required(fields.id_email.caption) : null, ew.Validators.integer], fields.id_email.isInvalid],
        ["id_usersender", [fields.id_usersender.visible && fields.id_usersender.required ? ew.Validators.required(fields.id_usersender.caption) : null, ew.Validators.integer], fields.id_usersender.isInvalid],
        ["leido", [fields.leido.visible && fields.leido.required ? ew.Validators.required(fields.leido.caption) : null], fields.leido.isInvalid],
        ["id_mensaje", [fields.id_mensaje.visible && fields.id_mensaje.required ? ew.Validators.required(fields.id_mensaje.caption) : null], fields.id_mensaje.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnotiemailadd,
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
    fnotiemailadd.validate = function () {
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
    fnotiemailadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnotiemailadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnotiemailadd.lists.leido = <?= $Page->leido->toClientList($Page) ?>;
    loadjs.done("fnotiemailadd");
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
<form name="fnotiemailadd" id="fnotiemailadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="notiemail">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id_email->Visible) { // id_email ?>
    <div id="r_id_email" class="form-group row">
        <label id="elh_notiemail_id_email" for="x_id_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_email->caption() ?><?= $Page->id_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_email->cellAttributes() ?>>
<span id="el_notiemail_id_email">
<input type="<?= $Page->id_email->getInputTextType() ?>" data-table="notiemail" data-field="x_id_email" name="x_id_email" id="x_id_email" size="30" placeholder="<?= HtmlEncode($Page->id_email->getPlaceHolder()) ?>" value="<?= $Page->id_email->EditValue ?>"<?= $Page->id_email->editAttributes() ?> aria-describedby="x_id_email_help">
<?= $Page->id_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_usersender->Visible) { // id_usersender ?>
    <div id="r_id_usersender" class="form-group row">
        <label id="elh_notiemail_id_usersender" for="x_id_usersender" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_usersender->caption() ?><?= $Page->id_usersender->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_usersender->cellAttributes() ?>>
<span id="el_notiemail_id_usersender">
<input type="<?= $Page->id_usersender->getInputTextType() ?>" data-table="notiemail" data-field="x_id_usersender" name="x_id_usersender" id="x_id_usersender" size="30" placeholder="<?= HtmlEncode($Page->id_usersender->getPlaceHolder()) ?>" value="<?= $Page->id_usersender->EditValue ?>"<?= $Page->id_usersender->editAttributes() ?> aria-describedby="x_id_usersender_help">
<?= $Page->id_usersender->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_usersender->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->leido->Visible) { // leido ?>
    <div id="r_leido" class="form-group row">
        <label id="elh_notiemail_leido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->leido->caption() ?><?= $Page->leido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->leido->cellAttributes() ?>>
<span id="el_notiemail_leido">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->leido->isInvalidClass() ?>" data-table="notiemail" data-field="x_leido" name="x_leido[]" id="x_leido_802295" value="1"<?= ConvertToBool($Page->leido->CurrentValue) ? " checked" : "" ?><?= $Page->leido->editAttributes() ?> aria-describedby="x_leido_help">
    <label class="custom-control-label" for="x_leido_802295"></label>
</div>
<?= $Page->leido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->leido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
    <div id="r_id_mensaje" class="form-group row">
        <label id="elh_notiemail_id_mensaje" for="x_id_mensaje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_mensaje->caption() ?><?= $Page->id_mensaje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_mensaje->cellAttributes() ?>>
<span id="el_notiemail_id_mensaje">
<input type="<?= $Page->id_mensaje->getInputTextType() ?>" data-table="notiemail" data-field="x_id_mensaje" name="x_id_mensaje" id="x_id_mensaje" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->id_mensaje->getPlaceHolder()) ?>" value="<?= $Page->id_mensaje->EditValue ?>"<?= $Page->id_mensaje->editAttributes() ?> aria-describedby="x_id_mensaje_help">
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
    ew.addEventHandlers("notiemail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
