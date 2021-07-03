<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomUsersAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_usersadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchat_chatroom_usersadd = currentForm = new ew.Form("farrowchat_chatroom_usersadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_users")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_chatroom_users)
        ew.vars.tables.arrowchat_chatroom_users = currentTable;
    farrowchat_chatroom_usersadd.addFields([
        ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid],
        ["chatroom_id", [fields.chatroom_id.visible && fields.chatroom_id.required ? ew.Validators.required(fields.chatroom_id.caption) : null, ew.Validators.integer], fields.chatroom_id.isInvalid],
        ["is_admin", [fields.is_admin.visible && fields.is_admin.required ? ew.Validators.required(fields.is_admin.caption) : null], fields.is_admin.isInvalid],
        ["is_mod", [fields.is_mod.visible && fields.is_mod.required ? ew.Validators.required(fields.is_mod.caption) : null], fields.is_mod.isInvalid],
        ["block_chats", [fields.block_chats.visible && fields.block_chats.required ? ew.Validators.required(fields.block_chats.caption) : null, ew.Validators.integer], fields.block_chats.isInvalid],
        ["silence_length", [fields.silence_length.visible && fields.silence_length.required ? ew.Validators.required(fields.silence_length.caption) : null, ew.Validators.integer], fields.silence_length.isInvalid],
        ["silence_time", [fields.silence_time.visible && fields.silence_time.required ? ew.Validators.required(fields.silence_time.caption) : null, ew.Validators.integer], fields.silence_time.isInvalid],
        ["session_time", [fields.session_time.visible && fields.session_time.required ? ew.Validators.required(fields.session_time.caption) : null, ew.Validators.integer], fields.session_time.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_chatroom_usersadd,
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
    farrowchat_chatroom_usersadd.validate = function () {
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
    farrowchat_chatroom_usersadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_chatroom_usersadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farrowchat_chatroom_usersadd.lists.is_admin = <?= $Page->is_admin->toClientList($Page) ?>;
    farrowchat_chatroom_usersadd.lists.is_mod = <?= $Page->is_mod->toClientList($Page) ?>;
    loadjs.done("farrowchat_chatroom_usersadd");
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
<form name="farrowchat_chatroom_usersadd" id="farrowchat_chatroom_usersadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_users">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->user_id->Visible) { // user_id ?>
    <div id="r_user_id" class="form-group row">
        <label id="elh_arrowchat_chatroom_users_user_id" for="x_user_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_id->caption() ?><?= $Page->user_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_user_id">
<input type="<?= $Page->user_id->getInputTextType() ?>" data-table="arrowchat_chatroom_users" data-field="x_user_id" name="x_user_id" id="x_user_id" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->user_id->getPlaceHolder()) ?>" value="<?= $Page->user_id->EditValue ?>"<?= $Page->user_id->editAttributes() ?> aria-describedby="x_user_id_help">
<?= $Page->user_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
    <div id="r_chatroom_id" class="form-group row">
        <label id="elh_arrowchat_chatroom_users_chatroom_id" for="x_chatroom_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chatroom_id->caption() ?><?= $Page->chatroom_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->chatroom_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_chatroom_id">
<input type="<?= $Page->chatroom_id->getInputTextType() ?>" data-table="arrowchat_chatroom_users" data-field="x_chatroom_id" name="x_chatroom_id" id="x_chatroom_id" size="30" placeholder="<?= HtmlEncode($Page->chatroom_id->getPlaceHolder()) ?>" value="<?= $Page->chatroom_id->EditValue ?>"<?= $Page->chatroom_id->editAttributes() ?> aria-describedby="x_chatroom_id_help">
<?= $Page->chatroom_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->chatroom_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
    <div id="r_is_admin" class="form-group row">
        <label id="elh_arrowchat_chatroom_users_is_admin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_admin->caption() ?><?= $Page->is_admin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->is_admin->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_is_admin">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->is_admin->isInvalidClass() ?>" data-table="arrowchat_chatroom_users" data-field="x_is_admin" name="x_is_admin[]" id="x_is_admin_863708" value="1"<?= ConvertToBool($Page->is_admin->CurrentValue) ? " checked" : "" ?><?= $Page->is_admin->editAttributes() ?> aria-describedby="x_is_admin_help">
    <label class="custom-control-label" for="x_is_admin_863708"></label>
</div>
<?= $Page->is_admin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_admin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
    <div id="r_is_mod" class="form-group row">
        <label id="elh_arrowchat_chatroom_users_is_mod" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_mod->caption() ?><?= $Page->is_mod->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->is_mod->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_is_mod">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->is_mod->isInvalidClass() ?>" data-table="arrowchat_chatroom_users" data-field="x_is_mod" name="x_is_mod[]" id="x_is_mod_525920" value="1"<?= ConvertToBool($Page->is_mod->CurrentValue) ? " checked" : "" ?><?= $Page->is_mod->editAttributes() ?> aria-describedby="x_is_mod_help">
    <label class="custom-control-label" for="x_is_mod_525920"></label>
</div>
<?= $Page->is_mod->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_mod->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->block_chats->Visible) { // block_chats ?>
    <div id="r_block_chats" class="form-group row">
        <label id="elh_arrowchat_chatroom_users_block_chats" for="x_block_chats" class="<?= $Page->LeftColumnClass ?>"><?= $Page->block_chats->caption() ?><?= $Page->block_chats->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->block_chats->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_block_chats">
<input type="<?= $Page->block_chats->getInputTextType() ?>" data-table="arrowchat_chatroom_users" data-field="x_block_chats" name="x_block_chats" id="x_block_chats" size="30" placeholder="<?= HtmlEncode($Page->block_chats->getPlaceHolder()) ?>" value="<?= $Page->block_chats->EditValue ?>"<?= $Page->block_chats->editAttributes() ?> aria-describedby="x_block_chats_help">
<?= $Page->block_chats->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->block_chats->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->silence_length->Visible) { // silence_length ?>
    <div id="r_silence_length" class="form-group row">
        <label id="elh_arrowchat_chatroom_users_silence_length" for="x_silence_length" class="<?= $Page->LeftColumnClass ?>"><?= $Page->silence_length->caption() ?><?= $Page->silence_length->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->silence_length->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_silence_length">
<input type="<?= $Page->silence_length->getInputTextType() ?>" data-table="arrowchat_chatroom_users" data-field="x_silence_length" name="x_silence_length" id="x_silence_length" size="30" placeholder="<?= HtmlEncode($Page->silence_length->getPlaceHolder()) ?>" value="<?= $Page->silence_length->EditValue ?>"<?= $Page->silence_length->editAttributes() ?> aria-describedby="x_silence_length_help">
<?= $Page->silence_length->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->silence_length->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->silence_time->Visible) { // silence_time ?>
    <div id="r_silence_time" class="form-group row">
        <label id="elh_arrowchat_chatroom_users_silence_time" for="x_silence_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->silence_time->caption() ?><?= $Page->silence_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->silence_time->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_silence_time">
<input type="<?= $Page->silence_time->getInputTextType() ?>" data-table="arrowchat_chatroom_users" data-field="x_silence_time" name="x_silence_time" id="x_silence_time" size="30" placeholder="<?= HtmlEncode($Page->silence_time->getPlaceHolder()) ?>" value="<?= $Page->silence_time->EditValue ?>"<?= $Page->silence_time->editAttributes() ?> aria-describedby="x_silence_time_help">
<?= $Page->silence_time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->silence_time->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
    <div id="r_session_time" class="form-group row">
        <label id="elh_arrowchat_chatroom_users_session_time" for="x_session_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->session_time->caption() ?><?= $Page->session_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->session_time->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_session_time">
<input type="<?= $Page->session_time->getInputTextType() ?>" data-table="arrowchat_chatroom_users" data-field="x_session_time" name="x_session_time" id="x_session_time" size="30" placeholder="<?= HtmlEncode($Page->session_time->getPlaceHolder()) ?>" value="<?= $Page->session_time->EditValue ?>"<?= $Page->session_time->editAttributes() ?> aria-describedby="x_session_time_help">
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
    ew.addEventHandlers("arrowchat_chatroom_users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
