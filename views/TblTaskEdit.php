<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TblTaskEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftbl_taskedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    ftbl_taskedit = currentForm = new ew.Form("ftbl_taskedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "tbl_task")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.tbl_task)
        ew.vars.tables.tbl_task = currentTable;
    ftbl_taskedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["title", [fields.title.visible && fields.title.required ? ew.Validators.required(fields.title.caption) : null], fields.title.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["project_name", [fields.project_name.visible && fields.project_name.required ? ew.Validators.required(fields.project_name.caption) : null], fields.project_name.isInvalid],
        ["status_id", [fields.status_id.visible && fields.status_id.required ? ew.Validators.required(fields.status_id.caption) : null], fields.status_id.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null], fields.created_at.isInvalid],
        ["id_users", [fields.id_users.visible && fields.id_users.required ? ew.Validators.required(fields.id_users.caption) : null], fields.id_users.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ftbl_taskedit,
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
    ftbl_taskedit.validate = function () {
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
    ftbl_taskedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftbl_taskedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("ftbl_taskedit");
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
<form name="ftbl_taskedit" id="ftbl_taskedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tbl_task">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_tbl_task_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_tbl_task_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="tbl_task" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
    <div id="r_title" class="form-group row">
        <label id="elh_tbl_task_title" for="x_title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->title->caption() ?><?= $Page->title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->title->cellAttributes() ?>>
<span id="el_tbl_task_title">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="tbl_task" data-field="x_title" name="x_title" id="x_title" size="100" maxlength="255" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?> aria-describedby="x_title_help">
<?= $Page->title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description" class="form-group row">
        <label id="elh_tbl_task_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->description->cellAttributes() ?>>
<span id="el_tbl_task_description">
<textarea data-table="tbl_task" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<span id="el_tbl_task_project_name">
<input type="hidden" data-table="tbl_task" data-field="x_project_name" data-hidden="1" name="x_project_name" id="x_project_name" value="<?= HtmlEncode($Page->project_name->CurrentValue) ?>">
</span>
<span id="el_tbl_task_status_id">
<input type="hidden" data-table="tbl_task" data-field="x_status_id" data-hidden="1" name="x_status_id" id="x_status_id" value="<?= HtmlEncode($Page->status_id->CurrentValue) ?>">
</span>
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
    ew.addEventHandlers("tbl_task");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
