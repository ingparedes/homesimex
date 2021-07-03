<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatThemesEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_themesedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    farrowchat_themesedit = currentForm = new ew.Form("farrowchat_themesedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_themes")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_themes)
        ew.vars.tables.arrowchat_themes = currentTable;
    farrowchat_themesedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["folder", [fields.folder.visible && fields.folder.required ? ew.Validators.required(fields.folder.caption) : null], fields.folder.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["active", [fields.active.visible && fields.active.required ? ew.Validators.required(fields.active.caption) : null], fields.active.isInvalid],
        ["update_link", [fields.update_link.visible && fields.update_link.required ? ew.Validators.required(fields.update_link.caption) : null], fields.update_link.isInvalid],
        ["version", [fields.version.visible && fields.version.required ? ew.Validators.required(fields.version.caption) : null], fields.version.isInvalid],
        ["_default", [fields._default.visible && fields._default.required ? ew.Validators.required(fields._default.caption) : null], fields._default.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_themesedit,
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
    farrowchat_themesedit.validate = function () {
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
    farrowchat_themesedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_themesedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farrowchat_themesedit.lists.active = <?= $Page->active->toClientList($Page) ?>;
    farrowchat_themesedit.lists._default = <?= $Page->_default->toClientList($Page) ?>;
    loadjs.done("farrowchat_themesedit");
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
<form name="farrowchat_themesedit" id="farrowchat_themesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_themes">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_arrowchat_themes_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_themes_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="arrowchat_themes" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->folder->Visible) { // folder ?>
    <div id="r_folder" class="form-group row">
        <label id="elh_arrowchat_themes_folder" for="x_folder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->folder->caption() ?><?= $Page->folder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->folder->cellAttributes() ?>>
<span id="el_arrowchat_themes_folder">
<input type="<?= $Page->folder->getInputTextType() ?>" data-table="arrowchat_themes" data-field="x_folder" name="x_folder" id="x_folder" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->folder->getPlaceHolder()) ?>" value="<?= $Page->folder->EditValue ?>"<?= $Page->folder->editAttributes() ?> aria-describedby="x_folder_help">
<?= $Page->folder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->folder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_arrowchat_themes_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<span id="el_arrowchat_themes_name">
<input type="<?= $Page->name->getInputTextType() ?>" data-table="arrowchat_themes" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <div id="r_active" class="form-group row">
        <label id="elh_arrowchat_themes_active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->active->caption() ?><?= $Page->active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->active->cellAttributes() ?>>
<span id="el_arrowchat_themes_active">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->active->isInvalidClass() ?>" data-table="arrowchat_themes" data-field="x_active" name="x_active[]" id="x_active_514200" value="1"<?= ConvertToBool($Page->active->CurrentValue) ? " checked" : "" ?><?= $Page->active->editAttributes() ?> aria-describedby="x_active_help">
    <label class="custom-control-label" for="x_active_514200"></label>
</div>
<?= $Page->active->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->update_link->Visible) { // update_link ?>
    <div id="r_update_link" class="form-group row">
        <label id="elh_arrowchat_themes_update_link" for="x_update_link" class="<?= $Page->LeftColumnClass ?>"><?= $Page->update_link->caption() ?><?= $Page->update_link->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->update_link->cellAttributes() ?>>
<span id="el_arrowchat_themes_update_link">
<input type="<?= $Page->update_link->getInputTextType() ?>" data-table="arrowchat_themes" data-field="x_update_link" name="x_update_link" id="x_update_link" size="30" maxlength="191" placeholder="<?= HtmlEncode($Page->update_link->getPlaceHolder()) ?>" value="<?= $Page->update_link->EditValue ?>"<?= $Page->update_link->editAttributes() ?> aria-describedby="x_update_link_help">
<?= $Page->update_link->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->update_link->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->version->Visible) { // version ?>
    <div id="r_version" class="form-group row">
        <label id="elh_arrowchat_themes_version" for="x_version" class="<?= $Page->LeftColumnClass ?>"><?= $Page->version->caption() ?><?= $Page->version->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->version->cellAttributes() ?>>
<span id="el_arrowchat_themes_version">
<input type="<?= $Page->version->getInputTextType() ?>" data-table="arrowchat_themes" data-field="x_version" name="x_version" id="x_version" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->version->getPlaceHolder()) ?>" value="<?= $Page->version->EditValue ?>"<?= $Page->version->editAttributes() ?> aria-describedby="x_version_help">
<?= $Page->version->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->version->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_default->Visible) { // default ?>
    <div id="r__default" class="form-group row">
        <label id="elh_arrowchat_themes__default" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_default->caption() ?><?= $Page->_default->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_default->cellAttributes() ?>>
<span id="el_arrowchat_themes__default">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->_default->isInvalidClass() ?>" data-table="arrowchat_themes" data-field="x__default" name="x__default[]" id="x__default_736368" value="1"<?= ConvertToBool($Page->_default->CurrentValue) ? " checked" : "" ?><?= $Page->_default->editAttributes() ?> aria-describedby="x__default_help">
    <label class="custom-control-label" for="x__default_736368"></label>
</div>
<?= $Page->_default->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_default->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat_themes");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
