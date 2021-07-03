<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomMessagesAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_messagesadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchat_chatroom_messagesadd = currentForm = new ew.Form("farrowchat_chatroom_messagesadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_messages")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_chatroom_messages)
        ew.vars.tables.arrowchat_chatroom_messages = currentTable;
    farrowchat_chatroom_messagesadd.addFields([
        ["chatroom_id", [fields.chatroom_id.visible && fields.chatroom_id.required ? ew.Validators.required(fields.chatroom_id.caption) : null, ew.Validators.integer], fields.chatroom_id.isInvalid],
        ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid],
        ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
        ["message", [fields.message.visible && fields.message.required ? ew.Validators.required(fields.message.caption) : null], fields.message.isInvalid],
        ["global_message", [fields.global_message.visible && fields.global_message.required ? ew.Validators.required(fields.global_message.caption) : null], fields.global_message.isInvalid],
        ["is_mod", [fields.is_mod.visible && fields.is_mod.required ? ew.Validators.required(fields.is_mod.caption) : null], fields.is_mod.isInvalid],
        ["is_admin", [fields.is_admin.visible && fields.is_admin.required ? ew.Validators.required(fields.is_admin.caption) : null], fields.is_admin.isInvalid],
        ["sent", [fields.sent.visible && fields.sent.required ? ew.Validators.required(fields.sent.caption) : null, ew.Validators.integer], fields.sent.isInvalid],
        ["_action", [fields._action.visible && fields._action.required ? ew.Validators.required(fields._action.caption) : null], fields._action.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_chatroom_messagesadd,
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
    farrowchat_chatroom_messagesadd.validate = function () {
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
    farrowchat_chatroom_messagesadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_chatroom_messagesadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farrowchat_chatroom_messagesadd.lists.global_message = <?= $Page->global_message->toClientList($Page) ?>;
    farrowchat_chatroom_messagesadd.lists.is_mod = <?= $Page->is_mod->toClientList($Page) ?>;
    farrowchat_chatroom_messagesadd.lists.is_admin = <?= $Page->is_admin->toClientList($Page) ?>;
    farrowchat_chatroom_messagesadd.lists._action = <?= $Page->_action->toClientList($Page) ?>;
    loadjs.done("farrowchat_chatroom_messagesadd");
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
<form name="farrowchat_chatroom_messagesadd" id="farrowchat_chatroom_messagesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_messages">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
    <div id="r_chatroom_id" class="form-group row">
        <label id="elh_arrowchat_chatroom_messages_chatroom_id" for="x_chatroom_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chatroom_id->caption() ?><?= $Page->chatroom_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->chatroom_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_chatroom_id">
<input type="<?= $Page->chatroom_id->getInputTextType() ?>" data-table="arrowchat_chatroom_messages" data-field="x_chatroom_id" name="x_chatroom_id" id="x_chatroom_id" size="30" placeholder="<?= HtmlEncode($Page->chatroom_id->getPlaceHolder()) ?>" value="<?= $Page->chatroom_id->EditValue ?>"<?= $Page->chatroom_id->editAttributes() ?> aria-describedby="x_chatroom_id_help">
<?= $Page->chatroom_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->chatroom_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <div id="r_user_id" class="form-group row">
        <label id="elh_arrowchat_chatroom_messages_user_id" for="x_user_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_id->caption() ?><?= $Page->user_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_user_id">
<input type="<?= $Page->user_id->getInputTextType() ?>" data-table="arrowchat_chatroom_messages" data-field="x_user_id" name="x_user_id" id="x_user_id" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->user_id->getPlaceHolder()) ?>" value="<?= $Page->user_id->EditValue ?>"<?= $Page->user_id->editAttributes() ?> aria-describedby="x_user_id_help">
<?= $Page->user_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <div id="r__username" class="form-group row">
        <label id="elh_arrowchat_chatroom_messages__username" for="x__username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_username->caption() ?><?= $Page->_username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_username->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages__username">
<input type="<?= $Page->_username->getInputTextType() ?>" data-table="arrowchat_chatroom_messages" data-field="x__username" name="x__username" id="x__username" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>" value="<?= $Page->_username->EditValue ?>"<?= $Page->_username->editAttributes() ?> aria-describedby="x__username_help">
<?= $Page->_username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->message->Visible) { // message ?>
    <div id="r_message" class="form-group row">
        <label id="elh_arrowchat_chatroom_messages_message" for="x_message" class="<?= $Page->LeftColumnClass ?>"><?= $Page->message->caption() ?><?= $Page->message->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->message->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_message">
<textarea data-table="arrowchat_chatroom_messages" data-field="x_message" name="x_message" id="x_message" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->message->getPlaceHolder()) ?>"<?= $Page->message->editAttributes() ?> aria-describedby="x_message_help"><?= $Page->message->EditValue ?></textarea>
<?= $Page->message->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->message->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->global_message->Visible) { // global_message ?>
    <div id="r_global_message" class="form-group row">
        <label id="elh_arrowchat_chatroom_messages_global_message" class="<?= $Page->LeftColumnClass ?>"><?= $Page->global_message->caption() ?><?= $Page->global_message->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->global_message->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_global_message">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->global_message->isInvalidClass() ?>" data-table="arrowchat_chatroom_messages" data-field="x_global_message" name="x_global_message[]" id="x_global_message_847846" value="1"<?= ConvertToBool($Page->global_message->CurrentValue) ? " checked" : "" ?><?= $Page->global_message->editAttributes() ?> aria-describedby="x_global_message_help">
    <label class="custom-control-label" for="x_global_message_847846"></label>
</div>
<?= $Page->global_message->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->global_message->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
    <div id="r_is_mod" class="form-group row">
        <label id="elh_arrowchat_chatroom_messages_is_mod" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_mod->caption() ?><?= $Page->is_mod->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->is_mod->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_is_mod">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->is_mod->isInvalidClass() ?>" data-table="arrowchat_chatroom_messages" data-field="x_is_mod" name="x_is_mod[]" id="x_is_mod_539777" value="1"<?= ConvertToBool($Page->is_mod->CurrentValue) ? " checked" : "" ?><?= $Page->is_mod->editAttributes() ?> aria-describedby="x_is_mod_help">
    <label class="custom-control-label" for="x_is_mod_539777"></label>
</div>
<?= $Page->is_mod->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_mod->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
    <div id="r_is_admin" class="form-group row">
        <label id="elh_arrowchat_chatroom_messages_is_admin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_admin->caption() ?><?= $Page->is_admin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->is_admin->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_is_admin">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->is_admin->isInvalidClass() ?>" data-table="arrowchat_chatroom_messages" data-field="x_is_admin" name="x_is_admin[]" id="x_is_admin_827628" value="1"<?= ConvertToBool($Page->is_admin->CurrentValue) ? " checked" : "" ?><?= $Page->is_admin->editAttributes() ?> aria-describedby="x_is_admin_help">
    <label class="custom-control-label" for="x_is_admin_827628"></label>
</div>
<?= $Page->is_admin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_admin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sent->Visible) { // sent ?>
    <div id="r_sent" class="form-group row">
        <label id="elh_arrowchat_chatroom_messages_sent" for="x_sent" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sent->caption() ?><?= $Page->sent->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sent->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_sent">
<input type="<?= $Page->sent->getInputTextType() ?>" data-table="arrowchat_chatroom_messages" data-field="x_sent" name="x_sent" id="x_sent" size="30" placeholder="<?= HtmlEncode($Page->sent->getPlaceHolder()) ?>" value="<?= $Page->sent->EditValue ?>"<?= $Page->sent->editAttributes() ?> aria-describedby="x_sent_help">
<?= $Page->sent->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sent->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_action->Visible) { // action ?>
    <div id="r__action" class="form-group row">
        <label id="elh_arrowchat_chatroom_messages__action" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_action->caption() ?><?= $Page->_action->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_action->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages__action">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->_action->isInvalidClass() ?>" data-table="arrowchat_chatroom_messages" data-field="x__action" name="x__action[]" id="x__action_232707" value="1"<?= ConvertToBool($Page->_action->CurrentValue) ? " checked" : "" ?><?= $Page->_action->editAttributes() ?> aria-describedby="x__action_help">
    <label class="custom-control-label" for="x__action_232707"></label>
</div>
<?= $Page->_action->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_action->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat_chatroom_messages");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
