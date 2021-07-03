<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatTrayiconsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_trayiconsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchat_trayiconsadd = currentForm = new ew.Form("farrowchat_trayiconsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_trayicons")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_trayicons)
        ew.vars.tables.arrowchat_trayicons = currentTable;
    farrowchat_trayiconsadd.addFields([
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["icon", [fields.icon.visible && fields.icon.required ? ew.Validators.required(fields.icon.caption) : null], fields.icon.isInvalid],
        ["location", [fields.location.visible && fields.location.required ? ew.Validators.required(fields.location.caption) : null], fields.location.isInvalid],
        ["target", [fields.target.visible && fields.target.required ? ew.Validators.required(fields.target.caption) : null], fields.target.isInvalid],
        ["width", [fields.width.visible && fields.width.required ? ew.Validators.required(fields.width.caption) : null, ew.Validators.integer], fields.width.isInvalid],
        ["height", [fields.height.visible && fields.height.required ? ew.Validators.required(fields.height.caption) : null, ew.Validators.integer], fields.height.isInvalid],
        ["tray_width", [fields.tray_width.visible && fields.tray_width.required ? ew.Validators.required(fields.tray_width.caption) : null, ew.Validators.integer], fields.tray_width.isInvalid],
        ["tray_name", [fields.tray_name.visible && fields.tray_name.required ? ew.Validators.required(fields.tray_name.caption) : null], fields.tray_name.isInvalid],
        ["tray_location", [fields.tray_location.visible && fields.tray_location.required ? ew.Validators.required(fields.tray_location.caption) : null, ew.Validators.integer], fields.tray_location.isInvalid],
        ["active", [fields.active.visible && fields.active.required ? ew.Validators.required(fields.active.caption) : null], fields.active.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_trayiconsadd,
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
    farrowchat_trayiconsadd.validate = function () {
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
    farrowchat_trayiconsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_trayiconsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farrowchat_trayiconsadd.lists.active = <?= $Page->active->toClientList($Page) ?>;
    loadjs.done("farrowchat_trayiconsadd");
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
<form name="farrowchat_trayiconsadd" id="farrowchat_trayiconsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_trayicons">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_arrowchat_trayicons_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_name">
<input type="<?= $Page->name->getInputTextType() ?>" data-table="arrowchat_trayicons" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->icon->Visible) { // icon ?>
    <div id="r_icon" class="form-group row">
        <label id="elh_arrowchat_trayicons_icon" for="x_icon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->icon->caption() ?><?= $Page->icon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->icon->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_icon">
<input type="<?= $Page->icon->getInputTextType() ?>" data-table="arrowchat_trayicons" data-field="x_icon" name="x_icon" id="x_icon" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->icon->getPlaceHolder()) ?>" value="<?= $Page->icon->EditValue ?>"<?= $Page->icon->editAttributes() ?> aria-describedby="x_icon_help">
<?= $Page->icon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->icon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->location->Visible) { // location ?>
    <div id="r_location" class="form-group row">
        <label id="elh_arrowchat_trayicons_location" for="x_location" class="<?= $Page->LeftColumnClass ?>"><?= $Page->location->caption() ?><?= $Page->location->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->location->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_location">
<input type="<?= $Page->location->getInputTextType() ?>" data-table="arrowchat_trayicons" data-field="x_location" name="x_location" id="x_location" size="30" maxlength="191" placeholder="<?= HtmlEncode($Page->location->getPlaceHolder()) ?>" value="<?= $Page->location->EditValue ?>"<?= $Page->location->editAttributes() ?> aria-describedby="x_location_help">
<?= $Page->location->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->location->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->target->Visible) { // target ?>
    <div id="r_target" class="form-group row">
        <label id="elh_arrowchat_trayicons_target" for="x_target" class="<?= $Page->LeftColumnClass ?>"><?= $Page->target->caption() ?><?= $Page->target->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->target->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_target">
<input type="<?= $Page->target->getInputTextType() ?>" data-table="arrowchat_trayicons" data-field="x_target" name="x_target" id="x_target" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->target->getPlaceHolder()) ?>" value="<?= $Page->target->EditValue ?>"<?= $Page->target->editAttributes() ?> aria-describedby="x_target_help">
<?= $Page->target->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->target->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->width->Visible) { // width ?>
    <div id="r_width" class="form-group row">
        <label id="elh_arrowchat_trayicons_width" for="x_width" class="<?= $Page->LeftColumnClass ?>"><?= $Page->width->caption() ?><?= $Page->width->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->width->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_width">
<input type="<?= $Page->width->getInputTextType() ?>" data-table="arrowchat_trayicons" data-field="x_width" name="x_width" id="x_width" size="30" placeholder="<?= HtmlEncode($Page->width->getPlaceHolder()) ?>" value="<?= $Page->width->EditValue ?>"<?= $Page->width->editAttributes() ?> aria-describedby="x_width_help">
<?= $Page->width->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->width->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->height->Visible) { // height ?>
    <div id="r_height" class="form-group row">
        <label id="elh_arrowchat_trayicons_height" for="x_height" class="<?= $Page->LeftColumnClass ?>"><?= $Page->height->caption() ?><?= $Page->height->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->height->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_height">
<input type="<?= $Page->height->getInputTextType() ?>" data-table="arrowchat_trayicons" data-field="x_height" name="x_height" id="x_height" size="30" placeholder="<?= HtmlEncode($Page->height->getPlaceHolder()) ?>" value="<?= $Page->height->EditValue ?>"<?= $Page->height->editAttributes() ?> aria-describedby="x_height_help">
<?= $Page->height->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->height->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tray_width->Visible) { // tray_width ?>
    <div id="r_tray_width" class="form-group row">
        <label id="elh_arrowchat_trayicons_tray_width" for="x_tray_width" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tray_width->caption() ?><?= $Page->tray_width->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tray_width->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_tray_width">
<input type="<?= $Page->tray_width->getInputTextType() ?>" data-table="arrowchat_trayicons" data-field="x_tray_width" name="x_tray_width" id="x_tray_width" size="30" placeholder="<?= HtmlEncode($Page->tray_width->getPlaceHolder()) ?>" value="<?= $Page->tray_width->EditValue ?>"<?= $Page->tray_width->editAttributes() ?> aria-describedby="x_tray_width_help">
<?= $Page->tray_width->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tray_width->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tray_name->Visible) { // tray_name ?>
    <div id="r_tray_name" class="form-group row">
        <label id="elh_arrowchat_trayicons_tray_name" for="x_tray_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tray_name->caption() ?><?= $Page->tray_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tray_name->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_tray_name">
<input type="<?= $Page->tray_name->getInputTextType() ?>" data-table="arrowchat_trayicons" data-field="x_tray_name" name="x_tray_name" id="x_tray_name" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->tray_name->getPlaceHolder()) ?>" value="<?= $Page->tray_name->EditValue ?>"<?= $Page->tray_name->editAttributes() ?> aria-describedby="x_tray_name_help">
<?= $Page->tray_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tray_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tray_location->Visible) { // tray_location ?>
    <div id="r_tray_location" class="form-group row">
        <label id="elh_arrowchat_trayicons_tray_location" for="x_tray_location" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tray_location->caption() ?><?= $Page->tray_location->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tray_location->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_tray_location">
<input type="<?= $Page->tray_location->getInputTextType() ?>" data-table="arrowchat_trayicons" data-field="x_tray_location" name="x_tray_location" id="x_tray_location" size="30" placeholder="<?= HtmlEncode($Page->tray_location->getPlaceHolder()) ?>" value="<?= $Page->tray_location->EditValue ?>"<?= $Page->tray_location->editAttributes() ?> aria-describedby="x_tray_location_help">
<?= $Page->tray_location->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tray_location->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <div id="r_active" class="form-group row">
        <label id="elh_arrowchat_trayicons_active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->active->caption() ?><?= $Page->active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->active->cellAttributes() ?>>
<span id="el_arrowchat_trayicons_active">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->active->isInvalidClass() ?>" data-table="arrowchat_trayicons" data-field="x_active" name="x_active[]" id="x_active_389316" value="1"<?= ConvertToBool($Page->active->CurrentValue) ? " checked" : "" ?><?= $Page->active->editAttributes() ?> aria-describedby="x_active_help">
    <label class="custom-control-label" for="x_active_389316"></label>
</div>
<?= $Page->active->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->active->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat_trayicons");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
