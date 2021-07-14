<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Register = &$Page;
?>
<script>
var currentForm, currentPageID;
var fregister;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "register";
    fregister = currentForm = new ew.Form("fregister", "register");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "users")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.users)
        ew.vars.tables.users = currentTable;
    fregister.addFields([
        ["nombres", [fields.nombres.visible && fields.nombres.required ? ew.Validators.required(fields.nombres.caption) : null], fields.nombres.isInvalid],
        ["apellidos", [fields.apellidos.visible && fields.apellidos.required ? ew.Validators.required(fields.apellidos.caption) : null], fields.apellidos.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.username(fields._email.raw), ew.Validators.email], fields._email.isInvalid],
        ["telefono", [fields.telefono.visible && fields.telefono.required ? ew.Validators.required(fields.telefono.caption) : null], fields.telefono.isInvalid]
    ]);
    <?= Captcha()->getScript("fregister") ?>

    // Set invalid fields
    $(function() {
        var f = fregister,
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
    fregister.validate = function () {
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
    fregister.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fregister.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fregister");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fregister" id="fregister" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="insert">
<div class="ew-register-div"><!-- page* -->
<?php if ($Page->nombres->Visible) { // nombres ?>
    <div id="r_nombres" class="form-group row">
        <label id="elh_users_nombres" for="x_nombres" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombres->caption() ?><?= $Page->nombres->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nombres->cellAttributes() ?>>
<span id="el_users_nombres">
<input type="<?= $Page->nombres->getInputTextType() ?>" data-table="users" data-field="x_nombres" name="x_nombres" id="x_nombres" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->nombres->getPlaceHolder()) ?>" value="<?= $Page->nombres->EditValue ?>"<?= $Page->nombres->editAttributes() ?> aria-describedby="x_nombres_help">
<?= $Page->nombres->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombres->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
    <div id="r_apellidos" class="form-group row">
        <label id="elh_users_apellidos" for="x_apellidos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellidos->caption() ?><?= $Page->apellidos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->apellidos->cellAttributes() ?>>
<span id="el_users_apellidos">
<input type="<?= $Page->apellidos->getInputTextType() ?>" data-table="users" data-field="x_apellidos" name="x_apellidos" id="x_apellidos" size="30" maxlength="90" placeholder="<?= HtmlEncode($Page->apellidos->getPlaceHolder()) ?>" value="<?= $Page->apellidos->EditValue ?>"<?= $Page->apellidos->editAttributes() ?> aria-describedby="x_apellidos_help">
<?= $Page->apellidos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellidos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="form-group row">
        <label id="elh_users__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_email->cellAttributes() ?>>
<span id="el_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="users" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
    <div id="r_telefono" class="form-group row">
        <label id="elh_users_telefono" for="x_telefono" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono->caption() ?><?= $Page->telefono->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->telefono->cellAttributes() ?>>
<span id="el_users_telefono">
<input type="<?= $Page->telefono->getInputTextType() ?>" data-table="users" data-field="x_telefono" name="x_telefono" id="x_telefono" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telefono->getPlaceHolder()) ?>" value="<?= $Page->telefono->EditValue ?>"<?= $Page->telefono->editAttributes() ?> aria-describedby="x_telefono_help">
<?= $Page->telefono->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<!-- captcha html (begin) -->
<?= Captcha()->getHtml(); ?>
<!-- captcha html (end) -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("RegisterBtn") ?></button>
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
    ew.addEventHandlers("users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your startup script here, no need to add script tags.
});
</script>
