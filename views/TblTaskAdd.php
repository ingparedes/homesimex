<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TblTaskAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftbl_taskadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    ftbl_taskadd = currentForm = new ew.Form("ftbl_taskadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "tbl_task")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.tbl_task)
        ew.vars.tables.tbl_task = currentTable;
    ftbl_taskadd.addFields([
        ["title", [fields.title.visible && fields.title.required ? ew.Validators.required(fields.title.caption) : null], fields.title.isInvalid],
        ["project_name", [fields.project_name.visible && fields.project_name.required ? ew.Validators.required(fields.project_name.caption) : null], fields.project_name.isInvalid],
        ["status_id", [fields.status_id.visible && fields.status_id.required ? ew.Validators.required(fields.status_id.caption) : null], fields.status_id.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null], fields.created_at.isInvalid],
        ["id_users", [fields.id_users.visible && fields.id_users.required ? ew.Validators.required(fields.id_users.caption) : null], fields.id_users.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ftbl_taskadd,
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
    ftbl_taskadd.validate = function () {
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
    ftbl_taskadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftbl_taskadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("ftbl_taskadd");
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
<form name="ftbl_taskadd" id="ftbl_taskadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tbl_task">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->title->Visible) { // title ?>
    <div id="r_title" class="form-group row">
        <label id="elh_tbl_task_title" for="x_title" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_tbl_task_title"><?= $Page->title->caption() ?><?= $Page->title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->title->cellAttributes() ?>>
<template id="tpx_tbl_task_title"><span id="el_tbl_task_title">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="tbl_task" data-field="x_title" name="x_title" id="x_title" size="100" maxlength="255" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?> aria-describedby="x_title_help">
<?= $Page->title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
    <template id="tpx_tbl_task_project_name"><span id="el_tbl_task_project_name">
    <input type="hidden" data-table="tbl_task" data-field="x_project_name" data-hidden="1" name="x_project_name" id="x_project_name" value="<?= HtmlEncode($Page->project_name->CurrentValue) ?>">
    </span></template>
    <template id="tpx_tbl_task_status_id"><span id="el_tbl_task_status_id">
    <input type="hidden" data-table="tbl_task" data-field="x_status_id" data-hidden="1" name="x_status_id" id="x_status_id" value="<?= HtmlEncode($Page->status_id->CurrentValue) ?>">
    </span></template>
</div><!-- /page* -->
<div id="tpd_tbl_taskadd" class="ew-custom-template"></div>
<template id="tpm_tbl_taskadd">
<div id="ct_TblTaskAdd">    <div id="r_title" class="form-group">
        <label for="x_title" class="col-sm-2 col-form-label"><?= $Page->title->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_tbl_task_title"></slot></div>
    </div>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_tbl_task_project_name"></slot></div>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_tbl_task_status_id"></slot></div>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_tbl_taskadd", "tpm_tbl_taskadd", "tbl_taskadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
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
