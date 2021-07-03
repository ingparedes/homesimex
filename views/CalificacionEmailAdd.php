<?php

namespace PHPMaker2021\simexamerica;

// Page object
$CalificacionEmailAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcalificacion_emailadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fcalificacion_emailadd = currentForm = new ew.Form("fcalificacion_emailadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "calificacion_email")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.calificacion_email)
        ew.vars.tables.calificacion_email = currentTable;
    fcalificacion_emailadd.addFields([
        ["id_calificacion", [fields.id_calificacion.visible && fields.id_calificacion.required ? ew.Validators.required(fields.id_calificacion.caption) : null, ew.Validators.integer], fields.id_calificacion.isInvalid],
        ["id_user_email", [fields.id_user_email.visible && fields.id_user_email.required ? ew.Validators.required(fields.id_user_email.caption) : null, ew.Validators.integer], fields.id_user_email.isInvalid],
        ["comentario", [fields.comentario.visible && fields.comentario.required ? ew.Validators.required(fields.comentario.caption) : null], fields.comentario.isInvalid],
        ["create_at", [fields.create_at.visible && fields.create_at.required ? ew.Validators.required(fields.create_at.caption) : null, ew.Validators.datetime(0)], fields.create_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcalificacion_emailadd,
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
    fcalificacion_emailadd.validate = function () {
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
    fcalificacion_emailadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcalificacion_emailadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fcalificacion_emailadd");
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
<form name="fcalificacion_emailadd" id="fcalificacion_emailadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="calificacion_email">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id_calificacion->Visible) { // id_calificacion ?>
    <div id="r_id_calificacion" class="form-group row">
        <label id="elh_calificacion_email_id_calificacion" for="x_id_calificacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_calificacion->caption() ?><?= $Page->id_calificacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_calificacion->cellAttributes() ?>>
<span id="el_calificacion_email_id_calificacion">
<input type="<?= $Page->id_calificacion->getInputTextType() ?>" data-table="calificacion_email" data-field="x_id_calificacion" name="x_id_calificacion" id="x_id_calificacion" size="30" placeholder="<?= HtmlEncode($Page->id_calificacion->getPlaceHolder()) ?>" value="<?= $Page->id_calificacion->EditValue ?>"<?= $Page->id_calificacion->editAttributes() ?> aria-describedby="x_id_calificacion_help">
<?= $Page->id_calificacion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_calificacion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_user_email->Visible) { // id_user_email ?>
    <div id="r_id_user_email" class="form-group row">
        <label id="elh_calificacion_email_id_user_email" for="x_id_user_email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_user_email->caption() ?><?= $Page->id_user_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_user_email->cellAttributes() ?>>
<span id="el_calificacion_email_id_user_email">
<input type="<?= $Page->id_user_email->getInputTextType() ?>" data-table="calificacion_email" data-field="x_id_user_email" name="x_id_user_email" id="x_id_user_email" size="30" placeholder="<?= HtmlEncode($Page->id_user_email->getPlaceHolder()) ?>" value="<?= $Page->id_user_email->EditValue ?>"<?= $Page->id_user_email->editAttributes() ?> aria-describedby="x_id_user_email_help">
<?= $Page->id_user_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_user_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->comentario->Visible) { // comentario ?>
    <div id="r_comentario" class="form-group row">
        <label id="elh_calificacion_email_comentario" for="x_comentario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->comentario->caption() ?><?= $Page->comentario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->comentario->cellAttributes() ?>>
<span id="el_calificacion_email_comentario">
<textarea data-table="calificacion_email" data-field="x_comentario" name="x_comentario" id="x_comentario" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->comentario->getPlaceHolder()) ?>"<?= $Page->comentario->editAttributes() ?> aria-describedby="x_comentario_help"><?= $Page->comentario->EditValue ?></textarea>
<?= $Page->comentario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->comentario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->create_at->Visible) { // create_at ?>
    <div id="r_create_at" class="form-group row">
        <label id="elh_calificacion_email_create_at" for="x_create_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->create_at->caption() ?><?= $Page->create_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->create_at->cellAttributes() ?>>
<span id="el_calificacion_email_create_at">
<input type="<?= $Page->create_at->getInputTextType() ?>" data-table="calificacion_email" data-field="x_create_at" name="x_create_at" id="x_create_at" placeholder="<?= HtmlEncode($Page->create_at->getPlaceHolder()) ?>" value="<?= $Page->create_at->EditValue ?>"<?= $Page->create_at->editAttributes() ?> aria-describedby="x_create_at_help">
<?= $Page->create_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->create_at->getErrorMessage() ?></div>
<?php if (!$Page->create_at->ReadOnly && !$Page->create_at->Disabled && !isset($Page->create_at->EditAttrs["readonly"]) && !isset($Page->create_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcalificacion_emailadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fcalificacion_emailadd", "x_create_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
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
    ew.addEventHandlers("calificacion_email");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
