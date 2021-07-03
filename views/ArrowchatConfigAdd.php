<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatConfigAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_configadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchat_configadd = currentForm = new ew.Form("farrowchat_configadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_config")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_config)
        ew.vars.tables.arrowchat_config = currentTable;
    farrowchat_configadd.addFields([
        ["config_name", [fields.config_name.visible && fields.config_name.required ? ew.Validators.required(fields.config_name.caption) : null], fields.config_name.isInvalid],
        ["config_value", [fields.config_value.visible && fields.config_value.required ? ew.Validators.required(fields.config_value.caption) : null], fields.config_value.isInvalid],
        ["is_dynamic", [fields.is_dynamic.visible && fields.is_dynamic.required ? ew.Validators.required(fields.is_dynamic.caption) : null], fields.is_dynamic.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_configadd,
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
    farrowchat_configadd.validate = function () {
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
    farrowchat_configadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_configadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farrowchat_configadd.lists.is_dynamic = <?= $Page->is_dynamic->toClientList($Page) ?>;
    loadjs.done("farrowchat_configadd");
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
<form name="farrowchat_configadd" id="farrowchat_configadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_config">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->config_name->Visible) { // config_name ?>
    <div id="r_config_name" class="form-group row">
        <label id="elh_arrowchat_config_config_name" for="x_config_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->config_name->caption() ?><?= $Page->config_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->config_name->cellAttributes() ?>>
<span id="el_arrowchat_config_config_name">
<input type="<?= $Page->config_name->getInputTextType() ?>" data-table="arrowchat_config" data-field="x_config_name" name="x_config_name" id="x_config_name" size="30" maxlength="191" placeholder="<?= HtmlEncode($Page->config_name->getPlaceHolder()) ?>" value="<?= $Page->config_name->EditValue ?>"<?= $Page->config_name->editAttributes() ?> aria-describedby="x_config_name_help">
<?= $Page->config_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->config_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->config_value->Visible) { // config_value ?>
    <div id="r_config_value" class="form-group row">
        <label id="elh_arrowchat_config_config_value" for="x_config_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->config_value->caption() ?><?= $Page->config_value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->config_value->cellAttributes() ?>>
<span id="el_arrowchat_config_config_value">
<textarea data-table="arrowchat_config" data-field="x_config_value" name="x_config_value" id="x_config_value" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->config_value->getPlaceHolder()) ?>"<?= $Page->config_value->editAttributes() ?> aria-describedby="x_config_value_help"><?= $Page->config_value->EditValue ?></textarea>
<?= $Page->config_value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->config_value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_dynamic->Visible) { // is_dynamic ?>
    <div id="r_is_dynamic" class="form-group row">
        <label id="elh_arrowchat_config_is_dynamic" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_dynamic->caption() ?><?= $Page->is_dynamic->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->is_dynamic->cellAttributes() ?>>
<span id="el_arrowchat_config_is_dynamic">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->is_dynamic->isInvalidClass() ?>" data-table="arrowchat_config" data-field="x_is_dynamic" name="x_is_dynamic[]" id="x_is_dynamic_317995" value="1"<?= ConvertToBool($Page->is_dynamic->CurrentValue) ? " checked" : "" ?><?= $Page->is_dynamic->editAttributes() ?> aria-describedby="x_is_dynamic_help">
    <label class="custom-control-label" for="x_is_dynamic_317995"></label>
</div>
<?= $Page->is_dynamic->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_dynamic->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat_config");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
