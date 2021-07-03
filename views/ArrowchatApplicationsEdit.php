<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatApplicationsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_applicationsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    farrowchat_applicationsedit = currentForm = new ew.Form("farrowchat_applicationsedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_applications")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_applications)
        ew.vars.tables.arrowchat_applications = currentTable;
    farrowchat_applicationsedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["folder", [fields.folder.visible && fields.folder.required ? ew.Validators.required(fields.folder.caption) : null], fields.folder.isInvalid],
        ["icon", [fields.icon.visible && fields.icon.required ? ew.Validators.required(fields.icon.caption) : null], fields.icon.isInvalid],
        ["width", [fields.width.visible && fields.width.required ? ew.Validators.required(fields.width.caption) : null, ew.Validators.integer], fields.width.isInvalid],
        ["height", [fields.height.visible && fields.height.required ? ew.Validators.required(fields.height.caption) : null, ew.Validators.integer], fields.height.isInvalid],
        ["bar_width", [fields.bar_width.visible && fields.bar_width.required ? ew.Validators.required(fields.bar_width.caption) : null, ew.Validators.integer], fields.bar_width.isInvalid],
        ["bar_name", [fields.bar_name.visible && fields.bar_name.required ? ew.Validators.required(fields.bar_name.caption) : null], fields.bar_name.isInvalid],
        ["dont_reload", [fields.dont_reload.visible && fields.dont_reload.required ? ew.Validators.required(fields.dont_reload.caption) : null], fields.dont_reload.isInvalid],
        ["default_bookmark", [fields.default_bookmark.visible && fields.default_bookmark.required ? ew.Validators.required(fields.default_bookmark.caption) : null], fields.default_bookmark.isInvalid],
        ["show_to_guests", [fields.show_to_guests.visible && fields.show_to_guests.required ? ew.Validators.required(fields.show_to_guests.caption) : null], fields.show_to_guests.isInvalid],
        ["link", [fields.link.visible && fields.link.required ? ew.Validators.required(fields.link.caption) : null], fields.link.isInvalid],
        ["update_link", [fields.update_link.visible && fields.update_link.required ? ew.Validators.required(fields.update_link.caption) : null], fields.update_link.isInvalid],
        ["version", [fields.version.visible && fields.version.required ? ew.Validators.required(fields.version.caption) : null], fields.version.isInvalid],
        ["active", [fields.active.visible && fields.active.required ? ew.Validators.required(fields.active.caption) : null], fields.active.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_applicationsedit,
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
    farrowchat_applicationsedit.validate = function () {
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
    farrowchat_applicationsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_applicationsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farrowchat_applicationsedit.lists.dont_reload = <?= $Page->dont_reload->toClientList($Page) ?>;
    farrowchat_applicationsedit.lists.default_bookmark = <?= $Page->default_bookmark->toClientList($Page) ?>;
    farrowchat_applicationsedit.lists.show_to_guests = <?= $Page->show_to_guests->toClientList($Page) ?>;
    farrowchat_applicationsedit.lists.active = <?= $Page->active->toClientList($Page) ?>;
    loadjs.done("farrowchat_applicationsedit");
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
<form name="farrowchat_applicationsedit" id="farrowchat_applicationsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_applications">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_arrowchat_applications_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_applications_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="arrowchat_applications" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_arrowchat_applications_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<span id="el_arrowchat_applications_name">
<input type="<?= $Page->name->getInputTextType() ?>" data-table="arrowchat_applications" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->folder->Visible) { // folder ?>
    <div id="r_folder" class="form-group row">
        <label id="elh_arrowchat_applications_folder" for="x_folder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->folder->caption() ?><?= $Page->folder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->folder->cellAttributes() ?>>
<span id="el_arrowchat_applications_folder">
<input type="<?= $Page->folder->getInputTextType() ?>" data-table="arrowchat_applications" data-field="x_folder" name="x_folder" id="x_folder" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->folder->getPlaceHolder()) ?>" value="<?= $Page->folder->EditValue ?>"<?= $Page->folder->editAttributes() ?> aria-describedby="x_folder_help">
<?= $Page->folder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->folder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->icon->Visible) { // icon ?>
    <div id="r_icon" class="form-group row">
        <label id="elh_arrowchat_applications_icon" for="x_icon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->icon->caption() ?><?= $Page->icon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->icon->cellAttributes() ?>>
<span id="el_arrowchat_applications_icon">
<input type="<?= $Page->icon->getInputTextType() ?>" data-table="arrowchat_applications" data-field="x_icon" name="x_icon" id="x_icon" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->icon->getPlaceHolder()) ?>" value="<?= $Page->icon->EditValue ?>"<?= $Page->icon->editAttributes() ?> aria-describedby="x_icon_help">
<?= $Page->icon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->icon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->width->Visible) { // width ?>
    <div id="r_width" class="form-group row">
        <label id="elh_arrowchat_applications_width" for="x_width" class="<?= $Page->LeftColumnClass ?>"><?= $Page->width->caption() ?><?= $Page->width->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->width->cellAttributes() ?>>
<span id="el_arrowchat_applications_width">
<input type="<?= $Page->width->getInputTextType() ?>" data-table="arrowchat_applications" data-field="x_width" name="x_width" id="x_width" size="30" placeholder="<?= HtmlEncode($Page->width->getPlaceHolder()) ?>" value="<?= $Page->width->EditValue ?>"<?= $Page->width->editAttributes() ?> aria-describedby="x_width_help">
<?= $Page->width->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->width->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->height->Visible) { // height ?>
    <div id="r_height" class="form-group row">
        <label id="elh_arrowchat_applications_height" for="x_height" class="<?= $Page->LeftColumnClass ?>"><?= $Page->height->caption() ?><?= $Page->height->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->height->cellAttributes() ?>>
<span id="el_arrowchat_applications_height">
<input type="<?= $Page->height->getInputTextType() ?>" data-table="arrowchat_applications" data-field="x_height" name="x_height" id="x_height" size="30" placeholder="<?= HtmlEncode($Page->height->getPlaceHolder()) ?>" value="<?= $Page->height->EditValue ?>"<?= $Page->height->editAttributes() ?> aria-describedby="x_height_help">
<?= $Page->height->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->height->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bar_width->Visible) { // bar_width ?>
    <div id="r_bar_width" class="form-group row">
        <label id="elh_arrowchat_applications_bar_width" for="x_bar_width" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bar_width->caption() ?><?= $Page->bar_width->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bar_width->cellAttributes() ?>>
<span id="el_arrowchat_applications_bar_width">
<input type="<?= $Page->bar_width->getInputTextType() ?>" data-table="arrowchat_applications" data-field="x_bar_width" name="x_bar_width" id="x_bar_width" size="30" placeholder="<?= HtmlEncode($Page->bar_width->getPlaceHolder()) ?>" value="<?= $Page->bar_width->EditValue ?>"<?= $Page->bar_width->editAttributes() ?> aria-describedby="x_bar_width_help">
<?= $Page->bar_width->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bar_width->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bar_name->Visible) { // bar_name ?>
    <div id="r_bar_name" class="form-group row">
        <label id="elh_arrowchat_applications_bar_name" for="x_bar_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bar_name->caption() ?><?= $Page->bar_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bar_name->cellAttributes() ?>>
<span id="el_arrowchat_applications_bar_name">
<input type="<?= $Page->bar_name->getInputTextType() ?>" data-table="arrowchat_applications" data-field="x_bar_name" name="x_bar_name" id="x_bar_name" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bar_name->getPlaceHolder()) ?>" value="<?= $Page->bar_name->EditValue ?>"<?= $Page->bar_name->editAttributes() ?> aria-describedby="x_bar_name_help">
<?= $Page->bar_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bar_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dont_reload->Visible) { // dont_reload ?>
    <div id="r_dont_reload" class="form-group row">
        <label id="elh_arrowchat_applications_dont_reload" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dont_reload->caption() ?><?= $Page->dont_reload->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dont_reload->cellAttributes() ?>>
<span id="el_arrowchat_applications_dont_reload">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->dont_reload->isInvalidClass() ?>" data-table="arrowchat_applications" data-field="x_dont_reload" name="x_dont_reload[]" id="x_dont_reload_675710" value="1"<?= ConvertToBool($Page->dont_reload->CurrentValue) ? " checked" : "" ?><?= $Page->dont_reload->editAttributes() ?> aria-describedby="x_dont_reload_help">
    <label class="custom-control-label" for="x_dont_reload_675710"></label>
</div>
<?= $Page->dont_reload->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dont_reload->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->default_bookmark->Visible) { // default_bookmark ?>
    <div id="r_default_bookmark" class="form-group row">
        <label id="elh_arrowchat_applications_default_bookmark" class="<?= $Page->LeftColumnClass ?>"><?= $Page->default_bookmark->caption() ?><?= $Page->default_bookmark->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->default_bookmark->cellAttributes() ?>>
<span id="el_arrowchat_applications_default_bookmark">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->default_bookmark->isInvalidClass() ?>" data-table="arrowchat_applications" data-field="x_default_bookmark" name="x_default_bookmark[]" id="x_default_bookmark_881709" value="1"<?= ConvertToBool($Page->default_bookmark->CurrentValue) ? " checked" : "" ?><?= $Page->default_bookmark->editAttributes() ?> aria-describedby="x_default_bookmark_help">
    <label class="custom-control-label" for="x_default_bookmark_881709"></label>
</div>
<?= $Page->default_bookmark->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->default_bookmark->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->show_to_guests->Visible) { // show_to_guests ?>
    <div id="r_show_to_guests" class="form-group row">
        <label id="elh_arrowchat_applications_show_to_guests" class="<?= $Page->LeftColumnClass ?>"><?= $Page->show_to_guests->caption() ?><?= $Page->show_to_guests->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->show_to_guests->cellAttributes() ?>>
<span id="el_arrowchat_applications_show_to_guests">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->show_to_guests->isInvalidClass() ?>" data-table="arrowchat_applications" data-field="x_show_to_guests" name="x_show_to_guests[]" id="x_show_to_guests_600568" value="1"<?= ConvertToBool($Page->show_to_guests->CurrentValue) ? " checked" : "" ?><?= $Page->show_to_guests->editAttributes() ?> aria-describedby="x_show_to_guests_help">
    <label class="custom-control-label" for="x_show_to_guests_600568"></label>
</div>
<?= $Page->show_to_guests->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->show_to_guests->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
    <div id="r_link" class="form-group row">
        <label id="elh_arrowchat_applications_link" for="x_link" class="<?= $Page->LeftColumnClass ?>"><?= $Page->link->caption() ?><?= $Page->link->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->link->cellAttributes() ?>>
<span id="el_arrowchat_applications_link">
<input type="<?= $Page->link->getInputTextType() ?>" data-table="arrowchat_applications" data-field="x_link" name="x_link" id="x_link" size="30" maxlength="191" placeholder="<?= HtmlEncode($Page->link->getPlaceHolder()) ?>" value="<?= $Page->link->EditValue ?>"<?= $Page->link->editAttributes() ?> aria-describedby="x_link_help">
<?= $Page->link->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->link->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->update_link->Visible) { // update_link ?>
    <div id="r_update_link" class="form-group row">
        <label id="elh_arrowchat_applications_update_link" for="x_update_link" class="<?= $Page->LeftColumnClass ?>"><?= $Page->update_link->caption() ?><?= $Page->update_link->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->update_link->cellAttributes() ?>>
<span id="el_arrowchat_applications_update_link">
<input type="<?= $Page->update_link->getInputTextType() ?>" data-table="arrowchat_applications" data-field="x_update_link" name="x_update_link" id="x_update_link" size="30" maxlength="191" placeholder="<?= HtmlEncode($Page->update_link->getPlaceHolder()) ?>" value="<?= $Page->update_link->EditValue ?>"<?= $Page->update_link->editAttributes() ?> aria-describedby="x_update_link_help">
<?= $Page->update_link->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->update_link->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->version->Visible) { // version ?>
    <div id="r_version" class="form-group row">
        <label id="elh_arrowchat_applications_version" for="x_version" class="<?= $Page->LeftColumnClass ?>"><?= $Page->version->caption() ?><?= $Page->version->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->version->cellAttributes() ?>>
<span id="el_arrowchat_applications_version">
<input type="<?= $Page->version->getInputTextType() ?>" data-table="arrowchat_applications" data-field="x_version" name="x_version" id="x_version" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->version->getPlaceHolder()) ?>" value="<?= $Page->version->EditValue ?>"<?= $Page->version->editAttributes() ?> aria-describedby="x_version_help">
<?= $Page->version->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->version->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->active->Visible) { // active ?>
    <div id="r_active" class="form-group row">
        <label id="elh_arrowchat_applications_active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->active->caption() ?><?= $Page->active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->active->cellAttributes() ?>>
<span id="el_arrowchat_applications_active">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->active->isInvalidClass() ?>" data-table="arrowchat_applications" data-field="x_active" name="x_active[]" id="x_active_729068" value="1"<?= ConvertToBool($Page->active->CurrentValue) ? " checked" : "" ?><?= $Page->active->editAttributes() ?> aria-describedby="x_active_help">
    <label class="custom-control-label" for="x_active_729068"></label>
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
    ew.addEventHandlers("arrowchat_applications");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
