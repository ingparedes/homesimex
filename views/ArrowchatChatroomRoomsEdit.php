<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomRoomsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_roomsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    farrowchat_chatroom_roomsedit = currentForm = new ew.Form("farrowchat_chatroom_roomsedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_rooms")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_chatroom_rooms)
        ew.vars.tables.arrowchat_chatroom_rooms = currentTable;
    farrowchat_chatroom_roomsedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["author_id", [fields.author_id.visible && fields.author_id.required ? ew.Validators.required(fields.author_id.caption) : null], fields.author_id.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
        ["welcome_message", [fields.welcome_message.visible && fields.welcome_message.required ? ew.Validators.required(fields.welcome_message.caption) : null], fields.welcome_message.isInvalid],
        ["image", [fields.image.visible && fields.image.required ? ew.Validators.required(fields.image.caption) : null], fields.image.isInvalid],
        ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null], fields.type.isInvalid],
        ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
        ["length", [fields.length.visible && fields.length.required ? ew.Validators.required(fields.length.caption) : null, ew.Validators.integer], fields.length.isInvalid],
        ["is_featured", [fields.is_featured.visible && fields.is_featured.required ? ew.Validators.required(fields.is_featured.caption) : null], fields.is_featured.isInvalid],
        ["max_users", [fields.max_users.visible && fields.max_users.required ? ew.Validators.required(fields.max_users.caption) : null, ew.Validators.integer], fields.max_users.isInvalid],
        ["limit_message_num", [fields.limit_message_num.visible && fields.limit_message_num.required ? ew.Validators.required(fields.limit_message_num.caption) : null, ew.Validators.integer], fields.limit_message_num.isInvalid],
        ["limit_seconds_num", [fields.limit_seconds_num.visible && fields.limit_seconds_num.required ? ew.Validators.required(fields.limit_seconds_num.caption) : null, ew.Validators.integer], fields.limit_seconds_num.isInvalid],
        ["disallowed_groups", [fields.disallowed_groups.visible && fields.disallowed_groups.required ? ew.Validators.required(fields.disallowed_groups.caption) : null], fields.disallowed_groups.isInvalid],
        ["session_time", [fields.session_time.visible && fields.session_time.required ? ew.Validators.required(fields.session_time.caption) : null, ew.Validators.integer], fields.session_time.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_chatroom_roomsedit,
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
    farrowchat_chatroom_roomsedit.validate = function () {
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
    farrowchat_chatroom_roomsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_chatroom_roomsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farrowchat_chatroom_roomsedit.lists.type = <?= $Page->type->toClientList($Page) ?>;
    farrowchat_chatroom_roomsedit.lists.is_featured = <?= $Page->is_featured->toClientList($Page) ?>;
    loadjs.done("farrowchat_chatroom_roomsedit");
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
<form name="farrowchat_chatroom_roomsedit" id="farrowchat_chatroom_roomsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_rooms">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="arrowchat_chatroom_rooms" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->author_id->Visible) { // author_id ?>
    <div id="r_author_id" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_author_id" for="x_author_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->author_id->caption() ?><?= $Page->author_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->author_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_author_id">
<input type="<?= $Page->author_id->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_author_id" name="x_author_id" id="x_author_id" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->author_id->getPlaceHolder()) ?>" value="<?= $Page->author_id->EditValue ?>"<?= $Page->author_id->editAttributes() ?> aria-describedby="x_author_id_help">
<?= $Page->author_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->author_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_name">
<input type="<?= $Page->name->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->description->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_description">
<input type="<?= $Page->description->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_description" name="x_description" id="x_description" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>" value="<?= $Page->description->EditValue ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help">
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->welcome_message->Visible) { // welcome_message ?>
    <div id="r_welcome_message" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_welcome_message" for="x_welcome_message" class="<?= $Page->LeftColumnClass ?>"><?= $Page->welcome_message->caption() ?><?= $Page->welcome_message->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->welcome_message->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_welcome_message">
<input type="<?= $Page->welcome_message->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_welcome_message" name="x_welcome_message" id="x_welcome_message" size="30" maxlength="191" placeholder="<?= HtmlEncode($Page->welcome_message->getPlaceHolder()) ?>" value="<?= $Page->welcome_message->EditValue ?>"<?= $Page->welcome_message->editAttributes() ?> aria-describedby="x_welcome_message_help">
<?= $Page->welcome_message->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->welcome_message->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <div id="r_image" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_image" for="x_image" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image->caption() ?><?= $Page->image->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->image->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_image">
<input type="<?= $Page->image->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_image" name="x_image" id="x_image" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->image->getPlaceHolder()) ?>" value="<?= $Page->image->EditValue ?>"<?= $Page->image->editAttributes() ?> aria-describedby="x_image_help">
<?= $Page->image->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->image->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->type->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_type">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->type->isInvalidClass() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_type" name="x_type[]" id="x_type_478671" value="1"<?= ConvertToBool($Page->type->CurrentValue) ? " checked" : "" ?><?= $Page->type->editAttributes() ?> aria-describedby="x_type_help">
    <label class="custom-control-label" for="x_type_478671"></label>
</div>
<?= $Page->type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_password->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms__password">
<input type="<?= $Page->_password->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x__password" name="x__password" id="x__password" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>" value="<?= $Page->_password->EditValue ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->length->Visible) { // length ?>
    <div id="r_length" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_length" for="x_length" class="<?= $Page->LeftColumnClass ?>"><?= $Page->length->caption() ?><?= $Page->length->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->length->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_length">
<input type="<?= $Page->length->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_length" name="x_length" id="x_length" size="30" placeholder="<?= HtmlEncode($Page->length->getPlaceHolder()) ?>" value="<?= $Page->length->EditValue ?>"<?= $Page->length->editAttributes() ?> aria-describedby="x_length_help">
<?= $Page->length->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->length->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_featured->Visible) { // is_featured ?>
    <div id="r_is_featured" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_is_featured" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_featured->caption() ?><?= $Page->is_featured->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->is_featured->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_is_featured">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->is_featured->isInvalidClass() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_is_featured" name="x_is_featured[]" id="x_is_featured_401865" value="1"<?= ConvertToBool($Page->is_featured->CurrentValue) ? " checked" : "" ?><?= $Page->is_featured->editAttributes() ?> aria-describedby="x_is_featured_help">
    <label class="custom-control-label" for="x_is_featured_401865"></label>
</div>
<?= $Page->is_featured->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_featured->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->max_users->Visible) { // max_users ?>
    <div id="r_max_users" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_max_users" for="x_max_users" class="<?= $Page->LeftColumnClass ?>"><?= $Page->max_users->caption() ?><?= $Page->max_users->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->max_users->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_max_users">
<input type="<?= $Page->max_users->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_max_users" name="x_max_users" id="x_max_users" size="30" placeholder="<?= HtmlEncode($Page->max_users->getPlaceHolder()) ?>" value="<?= $Page->max_users->EditValue ?>"<?= $Page->max_users->editAttributes() ?> aria-describedby="x_max_users_help">
<?= $Page->max_users->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->max_users->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->limit_message_num->Visible) { // limit_message_num ?>
    <div id="r_limit_message_num" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_limit_message_num" for="x_limit_message_num" class="<?= $Page->LeftColumnClass ?>"><?= $Page->limit_message_num->caption() ?><?= $Page->limit_message_num->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->limit_message_num->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_limit_message_num">
<input type="<?= $Page->limit_message_num->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_limit_message_num" name="x_limit_message_num" id="x_limit_message_num" size="30" placeholder="<?= HtmlEncode($Page->limit_message_num->getPlaceHolder()) ?>" value="<?= $Page->limit_message_num->EditValue ?>"<?= $Page->limit_message_num->editAttributes() ?> aria-describedby="x_limit_message_num_help">
<?= $Page->limit_message_num->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->limit_message_num->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->limit_seconds_num->Visible) { // limit_seconds_num ?>
    <div id="r_limit_seconds_num" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_limit_seconds_num" for="x_limit_seconds_num" class="<?= $Page->LeftColumnClass ?>"><?= $Page->limit_seconds_num->caption() ?><?= $Page->limit_seconds_num->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->limit_seconds_num->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_limit_seconds_num">
<input type="<?= $Page->limit_seconds_num->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_limit_seconds_num" name="x_limit_seconds_num" id="x_limit_seconds_num" size="30" placeholder="<?= HtmlEncode($Page->limit_seconds_num->getPlaceHolder()) ?>" value="<?= $Page->limit_seconds_num->EditValue ?>"<?= $Page->limit_seconds_num->editAttributes() ?> aria-describedby="x_limit_seconds_num_help">
<?= $Page->limit_seconds_num->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->limit_seconds_num->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->disallowed_groups->Visible) { // disallowed_groups ?>
    <div id="r_disallowed_groups" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_disallowed_groups" for="x_disallowed_groups" class="<?= $Page->LeftColumnClass ?>"><?= $Page->disallowed_groups->caption() ?><?= $Page->disallowed_groups->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->disallowed_groups->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_disallowed_groups">
<textarea data-table="arrowchat_chatroom_rooms" data-field="x_disallowed_groups" name="x_disallowed_groups" id="x_disallowed_groups" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->disallowed_groups->getPlaceHolder()) ?>"<?= $Page->disallowed_groups->editAttributes() ?> aria-describedby="x_disallowed_groups_help"><?= $Page->disallowed_groups->EditValue ?></textarea>
<?= $Page->disallowed_groups->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->disallowed_groups->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
    <div id="r_session_time" class="form-group row">
        <label id="elh_arrowchat_chatroom_rooms_session_time" for="x_session_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->session_time->caption() ?><?= $Page->session_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->session_time->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_session_time">
<input type="<?= $Page->session_time->getInputTextType() ?>" data-table="arrowchat_chatroom_rooms" data-field="x_session_time" name="x_session_time" id="x_session_time" size="30" placeholder="<?= HtmlEncode($Page->session_time->getPlaceHolder()) ?>" value="<?= $Page->session_time->EditValue ?>"<?= $Page->session_time->editAttributes() ?> aria-describedby="x_session_time_help">
<?= $Page->session_time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->session_time->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat_chatroom_rooms");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
