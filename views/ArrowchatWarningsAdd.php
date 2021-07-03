<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatWarningsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_warningsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchat_warningsadd = currentForm = new ew.Form("farrowchat_warningsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_warnings")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_warnings)
        ew.vars.tables.arrowchat_warnings = currentTable;
    farrowchat_warningsadd.addFields([
        ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid],
        ["warn_reason", [fields.warn_reason.visible && fields.warn_reason.required ? ew.Validators.required(fields.warn_reason.caption) : null], fields.warn_reason.isInvalid],
        ["warned_by", [fields.warned_by.visible && fields.warned_by.required ? ew.Validators.required(fields.warned_by.caption) : null], fields.warned_by.isInvalid],
        ["warning_time", [fields.warning_time.visible && fields.warning_time.required ? ew.Validators.required(fields.warning_time.caption) : null, ew.Validators.integer], fields.warning_time.isInvalid],
        ["user_read", [fields.user_read.visible && fields.user_read.required ? ew.Validators.required(fields.user_read.caption) : null], fields.user_read.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_warningsadd,
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
    farrowchat_warningsadd.validate = function () {
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
    farrowchat_warningsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_warningsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farrowchat_warningsadd.lists.user_read = <?= $Page->user_read->toClientList($Page) ?>;
    loadjs.done("farrowchat_warningsadd");
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
<form name="farrowchat_warningsadd" id="farrowchat_warningsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_warnings">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->user_id->Visible) { // user_id ?>
    <div id="r_user_id" class="form-group row">
        <label id="elh_arrowchat_warnings_user_id" for="x_user_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_id->caption() ?><?= $Page->user_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_id->cellAttributes() ?>>
<span id="el_arrowchat_warnings_user_id">
<input type="<?= $Page->user_id->getInputTextType() ?>" data-table="arrowchat_warnings" data-field="x_user_id" name="x_user_id" id="x_user_id" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->user_id->getPlaceHolder()) ?>" value="<?= $Page->user_id->EditValue ?>"<?= $Page->user_id->editAttributes() ?> aria-describedby="x_user_id_help">
<?= $Page->user_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warn_reason->Visible) { // warn_reason ?>
    <div id="r_warn_reason" class="form-group row">
        <label id="elh_arrowchat_warnings_warn_reason" for="x_warn_reason" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warn_reason->caption() ?><?= $Page->warn_reason->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warn_reason->cellAttributes() ?>>
<span id="el_arrowchat_warnings_warn_reason">
<textarea data-table="arrowchat_warnings" data-field="x_warn_reason" name="x_warn_reason" id="x_warn_reason" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->warn_reason->getPlaceHolder()) ?>"<?= $Page->warn_reason->editAttributes() ?> aria-describedby="x_warn_reason_help"><?= $Page->warn_reason->EditValue ?></textarea>
<?= $Page->warn_reason->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warn_reason->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warned_by->Visible) { // warned_by ?>
    <div id="r_warned_by" class="form-group row">
        <label id="elh_arrowchat_warnings_warned_by" for="x_warned_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warned_by->caption() ?><?= $Page->warned_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warned_by->cellAttributes() ?>>
<span id="el_arrowchat_warnings_warned_by">
<input type="<?= $Page->warned_by->getInputTextType() ?>" data-table="arrowchat_warnings" data-field="x_warned_by" name="x_warned_by" id="x_warned_by" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->warned_by->getPlaceHolder()) ?>" value="<?= $Page->warned_by->EditValue ?>"<?= $Page->warned_by->editAttributes() ?> aria-describedby="x_warned_by_help">
<?= $Page->warned_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warned_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warning_time->Visible) { // warning_time ?>
    <div id="r_warning_time" class="form-group row">
        <label id="elh_arrowchat_warnings_warning_time" for="x_warning_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warning_time->caption() ?><?= $Page->warning_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warning_time->cellAttributes() ?>>
<span id="el_arrowchat_warnings_warning_time">
<input type="<?= $Page->warning_time->getInputTextType() ?>" data-table="arrowchat_warnings" data-field="x_warning_time" name="x_warning_time" id="x_warning_time" size="30" placeholder="<?= HtmlEncode($Page->warning_time->getPlaceHolder()) ?>" value="<?= $Page->warning_time->EditValue ?>"<?= $Page->warning_time->editAttributes() ?> aria-describedby="x_warning_time_help">
<?= $Page->warning_time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warning_time->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
    <div id="r_user_read" class="form-group row">
        <label id="elh_arrowchat_warnings_user_read" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_read->caption() ?><?= $Page->user_read->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_read->cellAttributes() ?>>
<span id="el_arrowchat_warnings_user_read">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->user_read->isInvalidClass() ?>" data-table="arrowchat_warnings" data-field="x_user_read" name="x_user_read[]" id="x_user_read_935597" value="1"<?= ConvertToBool($Page->user_read->CurrentValue) ? " checked" : "" ?><?= $Page->user_read->editAttributes() ?> aria-describedby="x_user_read_help">
    <label class="custom-control-label" for="x_user_read_935597"></label>
</div>
<?= $Page->user_read->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_read->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat_warnings");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
