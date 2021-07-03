<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatReportsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_reportsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchat_reportsadd = currentForm = new ew.Form("farrowchat_reportsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_reports")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_reports)
        ew.vars.tables.arrowchat_reports = currentTable;
    farrowchat_reportsadd.addFields([
        ["report_from", [fields.report_from.visible && fields.report_from.required ? ew.Validators.required(fields.report_from.caption) : null], fields.report_from.isInvalid],
        ["report_about", [fields.report_about.visible && fields.report_about.required ? ew.Validators.required(fields.report_about.caption) : null], fields.report_about.isInvalid],
        ["report_chatroom", [fields.report_chatroom.visible && fields.report_chatroom.required ? ew.Validators.required(fields.report_chatroom.caption) : null, ew.Validators.integer], fields.report_chatroom.isInvalid],
        ["report_time", [fields.report_time.visible && fields.report_time.required ? ew.Validators.required(fields.report_time.caption) : null, ew.Validators.integer], fields.report_time.isInvalid],
        ["working_by", [fields.working_by.visible && fields.working_by.required ? ew.Validators.required(fields.working_by.caption) : null], fields.working_by.isInvalid],
        ["working_time", [fields.working_time.visible && fields.working_time.required ? ew.Validators.required(fields.working_time.caption) : null, ew.Validators.integer], fields.working_time.isInvalid],
        ["completed_by", [fields.completed_by.visible && fields.completed_by.required ? ew.Validators.required(fields.completed_by.caption) : null], fields.completed_by.isInvalid],
        ["completed_time", [fields.completed_time.visible && fields.completed_time.required ? ew.Validators.required(fields.completed_time.caption) : null, ew.Validators.integer], fields.completed_time.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_reportsadd,
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
    farrowchat_reportsadd.validate = function () {
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
    farrowchat_reportsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_reportsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("farrowchat_reportsadd");
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
<form name="farrowchat_reportsadd" id="farrowchat_reportsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_reports">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->report_from->Visible) { // report_from ?>
    <div id="r_report_from" class="form-group row">
        <label id="elh_arrowchat_reports_report_from" for="x_report_from" class="<?= $Page->LeftColumnClass ?>"><?= $Page->report_from->caption() ?><?= $Page->report_from->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->report_from->cellAttributes() ?>>
<span id="el_arrowchat_reports_report_from">
<input type="<?= $Page->report_from->getInputTextType() ?>" data-table="arrowchat_reports" data-field="x_report_from" name="x_report_from" id="x_report_from" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->report_from->getPlaceHolder()) ?>" value="<?= $Page->report_from->EditValue ?>"<?= $Page->report_from->editAttributes() ?> aria-describedby="x_report_from_help">
<?= $Page->report_from->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->report_from->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->report_about->Visible) { // report_about ?>
    <div id="r_report_about" class="form-group row">
        <label id="elh_arrowchat_reports_report_about" for="x_report_about" class="<?= $Page->LeftColumnClass ?>"><?= $Page->report_about->caption() ?><?= $Page->report_about->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->report_about->cellAttributes() ?>>
<span id="el_arrowchat_reports_report_about">
<input type="<?= $Page->report_about->getInputTextType() ?>" data-table="arrowchat_reports" data-field="x_report_about" name="x_report_about" id="x_report_about" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->report_about->getPlaceHolder()) ?>" value="<?= $Page->report_about->EditValue ?>"<?= $Page->report_about->editAttributes() ?> aria-describedby="x_report_about_help">
<?= $Page->report_about->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->report_about->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->report_chatroom->Visible) { // report_chatroom ?>
    <div id="r_report_chatroom" class="form-group row">
        <label id="elh_arrowchat_reports_report_chatroom" for="x_report_chatroom" class="<?= $Page->LeftColumnClass ?>"><?= $Page->report_chatroom->caption() ?><?= $Page->report_chatroom->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->report_chatroom->cellAttributes() ?>>
<span id="el_arrowchat_reports_report_chatroom">
<input type="<?= $Page->report_chatroom->getInputTextType() ?>" data-table="arrowchat_reports" data-field="x_report_chatroom" name="x_report_chatroom" id="x_report_chatroom" size="30" placeholder="<?= HtmlEncode($Page->report_chatroom->getPlaceHolder()) ?>" value="<?= $Page->report_chatroom->EditValue ?>"<?= $Page->report_chatroom->editAttributes() ?> aria-describedby="x_report_chatroom_help">
<?= $Page->report_chatroom->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->report_chatroom->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->report_time->Visible) { // report_time ?>
    <div id="r_report_time" class="form-group row">
        <label id="elh_arrowchat_reports_report_time" for="x_report_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->report_time->caption() ?><?= $Page->report_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->report_time->cellAttributes() ?>>
<span id="el_arrowchat_reports_report_time">
<input type="<?= $Page->report_time->getInputTextType() ?>" data-table="arrowchat_reports" data-field="x_report_time" name="x_report_time" id="x_report_time" size="30" placeholder="<?= HtmlEncode($Page->report_time->getPlaceHolder()) ?>" value="<?= $Page->report_time->EditValue ?>"<?= $Page->report_time->editAttributes() ?> aria-describedby="x_report_time_help">
<?= $Page->report_time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->report_time->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->working_by->Visible) { // working_by ?>
    <div id="r_working_by" class="form-group row">
        <label id="elh_arrowchat_reports_working_by" for="x_working_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->working_by->caption() ?><?= $Page->working_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->working_by->cellAttributes() ?>>
<span id="el_arrowchat_reports_working_by">
<input type="<?= $Page->working_by->getInputTextType() ?>" data-table="arrowchat_reports" data-field="x_working_by" name="x_working_by" id="x_working_by" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->working_by->getPlaceHolder()) ?>" value="<?= $Page->working_by->EditValue ?>"<?= $Page->working_by->editAttributes() ?> aria-describedby="x_working_by_help">
<?= $Page->working_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->working_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->working_time->Visible) { // working_time ?>
    <div id="r_working_time" class="form-group row">
        <label id="elh_arrowchat_reports_working_time" for="x_working_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->working_time->caption() ?><?= $Page->working_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->working_time->cellAttributes() ?>>
<span id="el_arrowchat_reports_working_time">
<input type="<?= $Page->working_time->getInputTextType() ?>" data-table="arrowchat_reports" data-field="x_working_time" name="x_working_time" id="x_working_time" size="30" placeholder="<?= HtmlEncode($Page->working_time->getPlaceHolder()) ?>" value="<?= $Page->working_time->EditValue ?>"<?= $Page->working_time->editAttributes() ?> aria-describedby="x_working_time_help">
<?= $Page->working_time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->working_time->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->completed_by->Visible) { // completed_by ?>
    <div id="r_completed_by" class="form-group row">
        <label id="elh_arrowchat_reports_completed_by" for="x_completed_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->completed_by->caption() ?><?= $Page->completed_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->completed_by->cellAttributes() ?>>
<span id="el_arrowchat_reports_completed_by">
<input type="<?= $Page->completed_by->getInputTextType() ?>" data-table="arrowchat_reports" data-field="x_completed_by" name="x_completed_by" id="x_completed_by" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->completed_by->getPlaceHolder()) ?>" value="<?= $Page->completed_by->EditValue ?>"<?= $Page->completed_by->editAttributes() ?> aria-describedby="x_completed_by_help">
<?= $Page->completed_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->completed_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->completed_time->Visible) { // completed_time ?>
    <div id="r_completed_time" class="form-group row">
        <label id="elh_arrowchat_reports_completed_time" for="x_completed_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->completed_time->caption() ?><?= $Page->completed_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->completed_time->cellAttributes() ?>>
<span id="el_arrowchat_reports_completed_time">
<input type="<?= $Page->completed_time->getInputTextType() ?>" data-table="arrowchat_reports" data-field="x_completed_time" name="x_completed_time" id="x_completed_time" size="30" placeholder="<?= HtmlEncode($Page->completed_time->getPlaceHolder()) ?>" value="<?= $Page->completed_time->EditValue ?>"<?= $Page->completed_time->editAttributes() ?> aria-describedby="x_completed_time_help">
<?= $Page->completed_time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->completed_time->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat_reports");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
