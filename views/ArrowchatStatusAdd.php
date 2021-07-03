<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatStatusAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_statusadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchat_statusadd = currentForm = new ew.Form("farrowchat_statusadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_status")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_status)
        ew.vars.tables.arrowchat_status = currentTable;
    farrowchat_statusadd.addFields([
        ["_userid", [fields._userid.visible && fields._userid.required ? ew.Validators.required(fields._userid.caption) : null], fields._userid.isInvalid],
        ["guest_name", [fields.guest_name.visible && fields.guest_name.required ? ew.Validators.required(fields.guest_name.caption) : null], fields.guest_name.isInvalid],
        ["message", [fields.message.visible && fields.message.required ? ew.Validators.required(fields.message.caption) : null], fields.message.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["theme", [fields.theme.visible && fields.theme.required ? ew.Validators.required(fields.theme.caption) : null, ew.Validators.integer], fields.theme.isInvalid],
        ["popout", [fields.popout.visible && fields.popout.required ? ew.Validators.required(fields.popout.caption) : null, ew.Validators.integer], fields.popout.isInvalid],
        ["typing", [fields.typing.visible && fields.typing.required ? ew.Validators.required(fields.typing.caption) : null], fields.typing.isInvalid],
        ["hide_bar", [fields.hide_bar.visible && fields.hide_bar.required ? ew.Validators.required(fields.hide_bar.caption) : null], fields.hide_bar.isInvalid],
        ["play_sound", [fields.play_sound.visible && fields.play_sound.required ? ew.Validators.required(fields.play_sound.caption) : null], fields.play_sound.isInvalid],
        ["window_open", [fields.window_open.visible && fields.window_open.required ? ew.Validators.required(fields.window_open.caption) : null], fields.window_open.isInvalid],
        ["only_names", [fields.only_names.visible && fields.only_names.required ? ew.Validators.required(fields.only_names.caption) : null], fields.only_names.isInvalid],
        ["chatroom_window", [fields.chatroom_window.visible && fields.chatroom_window.required ? ew.Validators.required(fields.chatroom_window.caption) : null], fields.chatroom_window.isInvalid],
        ["chatroom_stay", [fields.chatroom_stay.visible && fields.chatroom_stay.required ? ew.Validators.required(fields.chatroom_stay.caption) : null], fields.chatroom_stay.isInvalid],
        ["chatroom_unfocus", [fields.chatroom_unfocus.visible && fields.chatroom_unfocus.required ? ew.Validators.required(fields.chatroom_unfocus.caption) : null], fields.chatroom_unfocus.isInvalid],
        ["chatroom_show_names", [fields.chatroom_show_names.visible && fields.chatroom_show_names.required ? ew.Validators.required(fields.chatroom_show_names.caption) : null], fields.chatroom_show_names.isInvalid],
        ["chatroom_block_chats", [fields.chatroom_block_chats.visible && fields.chatroom_block_chats.required ? ew.Validators.required(fields.chatroom_block_chats.caption) : null], fields.chatroom_block_chats.isInvalid],
        ["chatroom_sound", [fields.chatroom_sound.visible && fields.chatroom_sound.required ? ew.Validators.required(fields.chatroom_sound.caption) : null], fields.chatroom_sound.isInvalid],
        ["announcement", [fields.announcement.visible && fields.announcement.required ? ew.Validators.required(fields.announcement.caption) : null], fields.announcement.isInvalid],
        ["unfocus_chat", [fields.unfocus_chat.visible && fields.unfocus_chat.required ? ew.Validators.required(fields.unfocus_chat.caption) : null], fields.unfocus_chat.isInvalid],
        ["focus_chat", [fields.focus_chat.visible && fields.focus_chat.required ? ew.Validators.required(fields.focus_chat.caption) : null], fields.focus_chat.isInvalid],
        ["last_message", [fields.last_message.visible && fields.last_message.required ? ew.Validators.required(fields.last_message.caption) : null], fields.last_message.isInvalid],
        ["clear_chats", [fields.clear_chats.visible && fields.clear_chats.required ? ew.Validators.required(fields.clear_chats.caption) : null], fields.clear_chats.isInvalid],
        ["apps_bookmarks", [fields.apps_bookmarks.visible && fields.apps_bookmarks.required ? ew.Validators.required(fields.apps_bookmarks.caption) : null], fields.apps_bookmarks.isInvalid],
        ["apps_other", [fields.apps_other.visible && fields.apps_other.required ? ew.Validators.required(fields.apps_other.caption) : null], fields.apps_other.isInvalid],
        ["apps_open", [fields.apps_open.visible && fields.apps_open.required ? ew.Validators.required(fields.apps_open.caption) : null, ew.Validators.integer], fields.apps_open.isInvalid],
        ["apps_load", [fields.apps_load.visible && fields.apps_load.required ? ew.Validators.required(fields.apps_load.caption) : null], fields.apps_load.isInvalid],
        ["block_chats", [fields.block_chats.visible && fields.block_chats.required ? ew.Validators.required(fields.block_chats.caption) : null], fields.block_chats.isInvalid],
        ["session_time", [fields.session_time.visible && fields.session_time.required ? ew.Validators.required(fields.session_time.caption) : null, ew.Validators.integer], fields.session_time.isInvalid],
        ["is_admin", [fields.is_admin.visible && fields.is_admin.required ? ew.Validators.required(fields.is_admin.caption) : null], fields.is_admin.isInvalid],
        ["is_mod", [fields.is_mod.visible && fields.is_mod.required ? ew.Validators.required(fields.is_mod.caption) : null], fields.is_mod.isInvalid],
        ["hash_id", [fields.hash_id.visible && fields.hash_id.required ? ew.Validators.required(fields.hash_id.caption) : null], fields.hash_id.isInvalid],
        ["ip_address", [fields.ip_address.visible && fields.ip_address.required ? ew.Validators.required(fields.ip_address.caption) : null], fields.ip_address.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_statusadd,
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
    farrowchat_statusadd.validate = function () {
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
    farrowchat_statusadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_statusadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farrowchat_statusadd.lists.hide_bar = <?= $Page->hide_bar->toClientList($Page) ?>;
    farrowchat_statusadd.lists.play_sound = <?= $Page->play_sound->toClientList($Page) ?>;
    farrowchat_statusadd.lists.window_open = <?= $Page->window_open->toClientList($Page) ?>;
    farrowchat_statusadd.lists.only_names = <?= $Page->only_names->toClientList($Page) ?>;
    farrowchat_statusadd.lists.chatroom_show_names = <?= $Page->chatroom_show_names->toClientList($Page) ?>;
    farrowchat_statusadd.lists.chatroom_block_chats = <?= $Page->chatroom_block_chats->toClientList($Page) ?>;
    farrowchat_statusadd.lists.chatroom_sound = <?= $Page->chatroom_sound->toClientList($Page) ?>;
    farrowchat_statusadd.lists.announcement = <?= $Page->announcement->toClientList($Page) ?>;
    farrowchat_statusadd.lists.is_admin = <?= $Page->is_admin->toClientList($Page) ?>;
    farrowchat_statusadd.lists.is_mod = <?= $Page->is_mod->toClientList($Page) ?>;
    loadjs.done("farrowchat_statusadd");
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
<form name="farrowchat_statusadd" id="farrowchat_statusadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_status">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->_userid->Visible) { // userid ?>
    <div id="r__userid" class="form-group row">
        <label id="elh_arrowchat_status__userid" for="x__userid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_userid->caption() ?><?= $Page->_userid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_userid->cellAttributes() ?>>
<span id="el_arrowchat_status__userid">
<input type="<?= $Page->_userid->getInputTextType() ?>" data-table="arrowchat_status" data-field="x__userid" name="x__userid" id="x__userid" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->_userid->getPlaceHolder()) ?>" value="<?= $Page->_userid->EditValue ?>"<?= $Page->_userid->editAttributes() ?> aria-describedby="x__userid_help">
<?= $Page->_userid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_userid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->guest_name->Visible) { // guest_name ?>
    <div id="r_guest_name" class="form-group row">
        <label id="elh_arrowchat_status_guest_name" for="x_guest_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->guest_name->caption() ?><?= $Page->guest_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->guest_name->cellAttributes() ?>>
<span id="el_arrowchat_status_guest_name">
<input type="<?= $Page->guest_name->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_guest_name" name="x_guest_name" id="x_guest_name" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->guest_name->getPlaceHolder()) ?>" value="<?= $Page->guest_name->EditValue ?>"<?= $Page->guest_name->editAttributes() ?> aria-describedby="x_guest_name_help">
<?= $Page->guest_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->guest_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->message->Visible) { // message ?>
    <div id="r_message" class="form-group row">
        <label id="elh_arrowchat_status_message" for="x_message" class="<?= $Page->LeftColumnClass ?>"><?= $Page->message->caption() ?><?= $Page->message->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->message->cellAttributes() ?>>
<span id="el_arrowchat_status_message">
<textarea data-table="arrowchat_status" data-field="x_message" name="x_message" id="x_message" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->message->getPlaceHolder()) ?>"<?= $Page->message->editAttributes() ?> aria-describedby="x_message_help"><?= $Page->message->EditValue ?></textarea>
<?= $Page->message->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->message->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_arrowchat_status_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_arrowchat_status_status">
<input type="<?= $Page->status->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>" value="<?= $Page->status->EditValue ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->theme->Visible) { // theme ?>
    <div id="r_theme" class="form-group row">
        <label id="elh_arrowchat_status_theme" for="x_theme" class="<?= $Page->LeftColumnClass ?>"><?= $Page->theme->caption() ?><?= $Page->theme->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->theme->cellAttributes() ?>>
<span id="el_arrowchat_status_theme">
<input type="<?= $Page->theme->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_theme" name="x_theme" id="x_theme" size="30" placeholder="<?= HtmlEncode($Page->theme->getPlaceHolder()) ?>" value="<?= $Page->theme->EditValue ?>"<?= $Page->theme->editAttributes() ?> aria-describedby="x_theme_help">
<?= $Page->theme->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->theme->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->popout->Visible) { // popout ?>
    <div id="r_popout" class="form-group row">
        <label id="elh_arrowchat_status_popout" for="x_popout" class="<?= $Page->LeftColumnClass ?>"><?= $Page->popout->caption() ?><?= $Page->popout->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->popout->cellAttributes() ?>>
<span id="el_arrowchat_status_popout">
<input type="<?= $Page->popout->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_popout" name="x_popout" id="x_popout" size="30" placeholder="<?= HtmlEncode($Page->popout->getPlaceHolder()) ?>" value="<?= $Page->popout->EditValue ?>"<?= $Page->popout->editAttributes() ?> aria-describedby="x_popout_help">
<?= $Page->popout->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->popout->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->typing->Visible) { // typing ?>
    <div id="r_typing" class="form-group row">
        <label id="elh_arrowchat_status_typing" for="x_typing" class="<?= $Page->LeftColumnClass ?>"><?= $Page->typing->caption() ?><?= $Page->typing->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->typing->cellAttributes() ?>>
<span id="el_arrowchat_status_typing">
<textarea data-table="arrowchat_status" data-field="x_typing" name="x_typing" id="x_typing" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->typing->getPlaceHolder()) ?>"<?= $Page->typing->editAttributes() ?> aria-describedby="x_typing_help"><?= $Page->typing->EditValue ?></textarea>
<?= $Page->typing->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->typing->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hide_bar->Visible) { // hide_bar ?>
    <div id="r_hide_bar" class="form-group row">
        <label id="elh_arrowchat_status_hide_bar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hide_bar->caption() ?><?= $Page->hide_bar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hide_bar->cellAttributes() ?>>
<span id="el_arrowchat_status_hide_bar">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->hide_bar->isInvalidClass() ?>" data-table="arrowchat_status" data-field="x_hide_bar" name="x_hide_bar[]" id="x_hide_bar_630467" value="1"<?= ConvertToBool($Page->hide_bar->CurrentValue) ? " checked" : "" ?><?= $Page->hide_bar->editAttributes() ?> aria-describedby="x_hide_bar_help">
    <label class="custom-control-label" for="x_hide_bar_630467"></label>
</div>
<?= $Page->hide_bar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hide_bar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->play_sound->Visible) { // play_sound ?>
    <div id="r_play_sound" class="form-group row">
        <label id="elh_arrowchat_status_play_sound" class="<?= $Page->LeftColumnClass ?>"><?= $Page->play_sound->caption() ?><?= $Page->play_sound->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->play_sound->cellAttributes() ?>>
<span id="el_arrowchat_status_play_sound">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->play_sound->isInvalidClass() ?>" data-table="arrowchat_status" data-field="x_play_sound" name="x_play_sound[]" id="x_play_sound_713954" value="1"<?= ConvertToBool($Page->play_sound->CurrentValue) ? " checked" : "" ?><?= $Page->play_sound->editAttributes() ?> aria-describedby="x_play_sound_help">
    <label class="custom-control-label" for="x_play_sound_713954"></label>
</div>
<?= $Page->play_sound->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->play_sound->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->window_open->Visible) { // window_open ?>
    <div id="r_window_open" class="form-group row">
        <label id="elh_arrowchat_status_window_open" class="<?= $Page->LeftColumnClass ?>"><?= $Page->window_open->caption() ?><?= $Page->window_open->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->window_open->cellAttributes() ?>>
<span id="el_arrowchat_status_window_open">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->window_open->isInvalidClass() ?>" data-table="arrowchat_status" data-field="x_window_open" name="x_window_open[]" id="x_window_open_288206" value="1"<?= ConvertToBool($Page->window_open->CurrentValue) ? " checked" : "" ?><?= $Page->window_open->editAttributes() ?> aria-describedby="x_window_open_help">
    <label class="custom-control-label" for="x_window_open_288206"></label>
</div>
<?= $Page->window_open->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->window_open->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->only_names->Visible) { // only_names ?>
    <div id="r_only_names" class="form-group row">
        <label id="elh_arrowchat_status_only_names" class="<?= $Page->LeftColumnClass ?>"><?= $Page->only_names->caption() ?><?= $Page->only_names->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->only_names->cellAttributes() ?>>
<span id="el_arrowchat_status_only_names">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->only_names->isInvalidClass() ?>" data-table="arrowchat_status" data-field="x_only_names" name="x_only_names[]" id="x_only_names_478710" value="1"<?= ConvertToBool($Page->only_names->CurrentValue) ? " checked" : "" ?><?= $Page->only_names->editAttributes() ?> aria-describedby="x_only_names_help">
    <label class="custom-control-label" for="x_only_names_478710"></label>
</div>
<?= $Page->only_names->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->only_names->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chatroom_window->Visible) { // chatroom_window ?>
    <div id="r_chatroom_window" class="form-group row">
        <label id="elh_arrowchat_status_chatroom_window" for="x_chatroom_window" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chatroom_window->caption() ?><?= $Page->chatroom_window->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->chatroom_window->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_window">
<input type="<?= $Page->chatroom_window->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_chatroom_window" name="x_chatroom_window" id="x_chatroom_window" size="30" maxlength="6" placeholder="<?= HtmlEncode($Page->chatroom_window->getPlaceHolder()) ?>" value="<?= $Page->chatroom_window->EditValue ?>"<?= $Page->chatroom_window->editAttributes() ?> aria-describedby="x_chatroom_window_help">
<?= $Page->chatroom_window->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->chatroom_window->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chatroom_stay->Visible) { // chatroom_stay ?>
    <div id="r_chatroom_stay" class="form-group row">
        <label id="elh_arrowchat_status_chatroom_stay" for="x_chatroom_stay" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chatroom_stay->caption() ?><?= $Page->chatroom_stay->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->chatroom_stay->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_stay">
<input type="<?= $Page->chatroom_stay->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_chatroom_stay" name="x_chatroom_stay" id="x_chatroom_stay" size="30" maxlength="6" placeholder="<?= HtmlEncode($Page->chatroom_stay->getPlaceHolder()) ?>" value="<?= $Page->chatroom_stay->EditValue ?>"<?= $Page->chatroom_stay->editAttributes() ?> aria-describedby="x_chatroom_stay_help">
<?= $Page->chatroom_stay->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->chatroom_stay->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chatroom_unfocus->Visible) { // chatroom_unfocus ?>
    <div id="r_chatroom_unfocus" class="form-group row">
        <label id="elh_arrowchat_status_chatroom_unfocus" for="x_chatroom_unfocus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chatroom_unfocus->caption() ?><?= $Page->chatroom_unfocus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->chatroom_unfocus->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_unfocus">
<textarea data-table="arrowchat_status" data-field="x_chatroom_unfocus" name="x_chatroom_unfocus" id="x_chatroom_unfocus" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->chatroom_unfocus->getPlaceHolder()) ?>"<?= $Page->chatroom_unfocus->editAttributes() ?> aria-describedby="x_chatroom_unfocus_help"><?= $Page->chatroom_unfocus->EditValue ?></textarea>
<?= $Page->chatroom_unfocus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->chatroom_unfocus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chatroom_show_names->Visible) { // chatroom_show_names ?>
    <div id="r_chatroom_show_names" class="form-group row">
        <label id="elh_arrowchat_status_chatroom_show_names" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chatroom_show_names->caption() ?><?= $Page->chatroom_show_names->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->chatroom_show_names->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_show_names">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->chatroom_show_names->isInvalidClass() ?>" data-table="arrowchat_status" data-field="x_chatroom_show_names" name="x_chatroom_show_names[]" id="x_chatroom_show_names_978383" value="1"<?= ConvertToBool($Page->chatroom_show_names->CurrentValue) ? " checked" : "" ?><?= $Page->chatroom_show_names->editAttributes() ?> aria-describedby="x_chatroom_show_names_help">
    <label class="custom-control-label" for="x_chatroom_show_names_978383"></label>
</div>
<?= $Page->chatroom_show_names->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->chatroom_show_names->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chatroom_block_chats->Visible) { // chatroom_block_chats ?>
    <div id="r_chatroom_block_chats" class="form-group row">
        <label id="elh_arrowchat_status_chatroom_block_chats" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chatroom_block_chats->caption() ?><?= $Page->chatroom_block_chats->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->chatroom_block_chats->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_block_chats">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->chatroom_block_chats->isInvalidClass() ?>" data-table="arrowchat_status" data-field="x_chatroom_block_chats" name="x_chatroom_block_chats[]" id="x_chatroom_block_chats_436482" value="1"<?= ConvertToBool($Page->chatroom_block_chats->CurrentValue) ? " checked" : "" ?><?= $Page->chatroom_block_chats->editAttributes() ?> aria-describedby="x_chatroom_block_chats_help">
    <label class="custom-control-label" for="x_chatroom_block_chats_436482"></label>
</div>
<?= $Page->chatroom_block_chats->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->chatroom_block_chats->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chatroom_sound->Visible) { // chatroom_sound ?>
    <div id="r_chatroom_sound" class="form-group row">
        <label id="elh_arrowchat_status_chatroom_sound" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chatroom_sound->caption() ?><?= $Page->chatroom_sound->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->chatroom_sound->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_sound">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->chatroom_sound->isInvalidClass() ?>" data-table="arrowchat_status" data-field="x_chatroom_sound" name="x_chatroom_sound[]" id="x_chatroom_sound_508366" value="1"<?= ConvertToBool($Page->chatroom_sound->CurrentValue) ? " checked" : "" ?><?= $Page->chatroom_sound->editAttributes() ?> aria-describedby="x_chatroom_sound_help">
    <label class="custom-control-label" for="x_chatroom_sound_508366"></label>
</div>
<?= $Page->chatroom_sound->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->chatroom_sound->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->announcement->Visible) { // announcement ?>
    <div id="r_announcement" class="form-group row">
        <label id="elh_arrowchat_status_announcement" class="<?= $Page->LeftColumnClass ?>"><?= $Page->announcement->caption() ?><?= $Page->announcement->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->announcement->cellAttributes() ?>>
<span id="el_arrowchat_status_announcement">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->announcement->isInvalidClass() ?>" data-table="arrowchat_status" data-field="x_announcement" name="x_announcement[]" id="x_announcement_597059" value="1"<?= ConvertToBool($Page->announcement->CurrentValue) ? " checked" : "" ?><?= $Page->announcement->editAttributes() ?> aria-describedby="x_announcement_help">
    <label class="custom-control-label" for="x_announcement_597059"></label>
</div>
<?= $Page->announcement->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->announcement->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unfocus_chat->Visible) { // unfocus_chat ?>
    <div id="r_unfocus_chat" class="form-group row">
        <label id="elh_arrowchat_status_unfocus_chat" for="x_unfocus_chat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unfocus_chat->caption() ?><?= $Page->unfocus_chat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->unfocus_chat->cellAttributes() ?>>
<span id="el_arrowchat_status_unfocus_chat">
<textarea data-table="arrowchat_status" data-field="x_unfocus_chat" name="x_unfocus_chat" id="x_unfocus_chat" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->unfocus_chat->getPlaceHolder()) ?>"<?= $Page->unfocus_chat->editAttributes() ?> aria-describedby="x_unfocus_chat_help"><?= $Page->unfocus_chat->EditValue ?></textarea>
<?= $Page->unfocus_chat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->unfocus_chat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->focus_chat->Visible) { // focus_chat ?>
    <div id="r_focus_chat" class="form-group row">
        <label id="elh_arrowchat_status_focus_chat" for="x_focus_chat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->focus_chat->caption() ?><?= $Page->focus_chat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->focus_chat->cellAttributes() ?>>
<span id="el_arrowchat_status_focus_chat">
<input type="<?= $Page->focus_chat->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_focus_chat" name="x_focus_chat" id="x_focus_chat" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->focus_chat->getPlaceHolder()) ?>" value="<?= $Page->focus_chat->EditValue ?>"<?= $Page->focus_chat->editAttributes() ?> aria-describedby="x_focus_chat_help">
<?= $Page->focus_chat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->focus_chat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_message->Visible) { // last_message ?>
    <div id="r_last_message" class="form-group row">
        <label id="elh_arrowchat_status_last_message" for="x_last_message" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_message->caption() ?><?= $Page->last_message->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->last_message->cellAttributes() ?>>
<span id="el_arrowchat_status_last_message">
<textarea data-table="arrowchat_status" data-field="x_last_message" name="x_last_message" id="x_last_message" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->last_message->getPlaceHolder()) ?>"<?= $Page->last_message->editAttributes() ?> aria-describedby="x_last_message_help"><?= $Page->last_message->EditValue ?></textarea>
<?= $Page->last_message->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_message->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->clear_chats->Visible) { // clear_chats ?>
    <div id="r_clear_chats" class="form-group row">
        <label id="elh_arrowchat_status_clear_chats" for="x_clear_chats" class="<?= $Page->LeftColumnClass ?>"><?= $Page->clear_chats->caption() ?><?= $Page->clear_chats->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->clear_chats->cellAttributes() ?>>
<span id="el_arrowchat_status_clear_chats">
<textarea data-table="arrowchat_status" data-field="x_clear_chats" name="x_clear_chats" id="x_clear_chats" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->clear_chats->getPlaceHolder()) ?>"<?= $Page->clear_chats->editAttributes() ?> aria-describedby="x_clear_chats_help"><?= $Page->clear_chats->EditValue ?></textarea>
<?= $Page->clear_chats->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->clear_chats->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apps_bookmarks->Visible) { // apps_bookmarks ?>
    <div id="r_apps_bookmarks" class="form-group row">
        <label id="elh_arrowchat_status_apps_bookmarks" for="x_apps_bookmarks" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apps_bookmarks->caption() ?><?= $Page->apps_bookmarks->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->apps_bookmarks->cellAttributes() ?>>
<span id="el_arrowchat_status_apps_bookmarks">
<textarea data-table="arrowchat_status" data-field="x_apps_bookmarks" name="x_apps_bookmarks" id="x_apps_bookmarks" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->apps_bookmarks->getPlaceHolder()) ?>"<?= $Page->apps_bookmarks->editAttributes() ?> aria-describedby="x_apps_bookmarks_help"><?= $Page->apps_bookmarks->EditValue ?></textarea>
<?= $Page->apps_bookmarks->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apps_bookmarks->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apps_other->Visible) { // apps_other ?>
    <div id="r_apps_other" class="form-group row">
        <label id="elh_arrowchat_status_apps_other" for="x_apps_other" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apps_other->caption() ?><?= $Page->apps_other->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->apps_other->cellAttributes() ?>>
<span id="el_arrowchat_status_apps_other">
<textarea data-table="arrowchat_status" data-field="x_apps_other" name="x_apps_other" id="x_apps_other" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->apps_other->getPlaceHolder()) ?>"<?= $Page->apps_other->editAttributes() ?> aria-describedby="x_apps_other_help"><?= $Page->apps_other->EditValue ?></textarea>
<?= $Page->apps_other->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apps_other->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apps_open->Visible) { // apps_open ?>
    <div id="r_apps_open" class="form-group row">
        <label id="elh_arrowchat_status_apps_open" for="x_apps_open" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apps_open->caption() ?><?= $Page->apps_open->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->apps_open->cellAttributes() ?>>
<span id="el_arrowchat_status_apps_open">
<input type="<?= $Page->apps_open->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_apps_open" name="x_apps_open" id="x_apps_open" size="30" placeholder="<?= HtmlEncode($Page->apps_open->getPlaceHolder()) ?>" value="<?= $Page->apps_open->EditValue ?>"<?= $Page->apps_open->editAttributes() ?> aria-describedby="x_apps_open_help">
<?= $Page->apps_open->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apps_open->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apps_load->Visible) { // apps_load ?>
    <div id="r_apps_load" class="form-group row">
        <label id="elh_arrowchat_status_apps_load" for="x_apps_load" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apps_load->caption() ?><?= $Page->apps_load->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->apps_load->cellAttributes() ?>>
<span id="el_arrowchat_status_apps_load">
<textarea data-table="arrowchat_status" data-field="x_apps_load" name="x_apps_load" id="x_apps_load" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->apps_load->getPlaceHolder()) ?>"<?= $Page->apps_load->editAttributes() ?> aria-describedby="x_apps_load_help"><?= $Page->apps_load->EditValue ?></textarea>
<?= $Page->apps_load->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apps_load->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->block_chats->Visible) { // block_chats ?>
    <div id="r_block_chats" class="form-group row">
        <label id="elh_arrowchat_status_block_chats" for="x_block_chats" class="<?= $Page->LeftColumnClass ?>"><?= $Page->block_chats->caption() ?><?= $Page->block_chats->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->block_chats->cellAttributes() ?>>
<span id="el_arrowchat_status_block_chats">
<textarea data-table="arrowchat_status" data-field="x_block_chats" name="x_block_chats" id="x_block_chats" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->block_chats->getPlaceHolder()) ?>"<?= $Page->block_chats->editAttributes() ?> aria-describedby="x_block_chats_help"><?= $Page->block_chats->EditValue ?></textarea>
<?= $Page->block_chats->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->block_chats->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
    <div id="r_session_time" class="form-group row">
        <label id="elh_arrowchat_status_session_time" for="x_session_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->session_time->caption() ?><?= $Page->session_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->session_time->cellAttributes() ?>>
<span id="el_arrowchat_status_session_time">
<input type="<?= $Page->session_time->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_session_time" name="x_session_time" id="x_session_time" size="30" placeholder="<?= HtmlEncode($Page->session_time->getPlaceHolder()) ?>" value="<?= $Page->session_time->EditValue ?>"<?= $Page->session_time->editAttributes() ?> aria-describedby="x_session_time_help">
<?= $Page->session_time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->session_time->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
    <div id="r_is_admin" class="form-group row">
        <label id="elh_arrowchat_status_is_admin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_admin->caption() ?><?= $Page->is_admin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->is_admin->cellAttributes() ?>>
<span id="el_arrowchat_status_is_admin">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->is_admin->isInvalidClass() ?>" data-table="arrowchat_status" data-field="x_is_admin" name="x_is_admin[]" id="x_is_admin_807636" value="1"<?= ConvertToBool($Page->is_admin->CurrentValue) ? " checked" : "" ?><?= $Page->is_admin->editAttributes() ?> aria-describedby="x_is_admin_help">
    <label class="custom-control-label" for="x_is_admin_807636"></label>
</div>
<?= $Page->is_admin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_admin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
    <div id="r_is_mod" class="form-group row">
        <label id="elh_arrowchat_status_is_mod" class="<?= $Page->LeftColumnClass ?>"><?= $Page->is_mod->caption() ?><?= $Page->is_mod->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->is_mod->cellAttributes() ?>>
<span id="el_arrowchat_status_is_mod">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->is_mod->isInvalidClass() ?>" data-table="arrowchat_status" data-field="x_is_mod" name="x_is_mod[]" id="x_is_mod_111397" value="1"<?= ConvertToBool($Page->is_mod->CurrentValue) ? " checked" : "" ?><?= $Page->is_mod->editAttributes() ?> aria-describedby="x_is_mod_help">
    <label class="custom-control-label" for="x_is_mod_111397"></label>
</div>
<?= $Page->is_mod->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->is_mod->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hash_id->Visible) { // hash_id ?>
    <div id="r_hash_id" class="form-group row">
        <label id="elh_arrowchat_status_hash_id" for="x_hash_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hash_id->caption() ?><?= $Page->hash_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hash_id->cellAttributes() ?>>
<span id="el_arrowchat_status_hash_id">
<input type="<?= $Page->hash_id->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_hash_id" name="x_hash_id" id="x_hash_id" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->hash_id->getPlaceHolder()) ?>" value="<?= $Page->hash_id->EditValue ?>"<?= $Page->hash_id->editAttributes() ?> aria-describedby="x_hash_id_help">
<?= $Page->hash_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hash_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ip_address->Visible) { // ip_address ?>
    <div id="r_ip_address" class="form-group row">
        <label id="elh_arrowchat_status_ip_address" for="x_ip_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ip_address->caption() ?><?= $Page->ip_address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ip_address->cellAttributes() ?>>
<span id="el_arrowchat_status_ip_address">
<input type="<?= $Page->ip_address->getInputTextType() ?>" data-table="arrowchat_status" data-field="x_ip_address" name="x_ip_address" id="x_ip_address" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->ip_address->getPlaceHolder()) ?>" value="<?= $Page->ip_address->EditValue ?>"<?= $Page->ip_address->editAttributes() ?> aria-describedby="x_ip_address_help">
<?= $Page->ip_address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ip_address->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat_status");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
