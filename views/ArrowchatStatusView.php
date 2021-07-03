<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatStatusView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_statusview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_statusview = currentForm = new ew.Form("farrowchat_statusview", "view");
    loadjs.done("farrowchat_statusview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_status) ew.vars.tables.arrowchat_status = <?= JsonEncode(GetClientVar("tables", "arrowchat_status")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_statusview" id="farrowchat_statusview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_status">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->_userid->Visible) { // userid ?>
    <tr id="r__userid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status__userid"><?= $Page->_userid->caption() ?></span></td>
        <td data-name="_userid" <?= $Page->_userid->cellAttributes() ?>>
<span id="el_arrowchat_status__userid">
<span<?= $Page->_userid->viewAttributes() ?>>
<?= $Page->_userid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->guest_name->Visible) { // guest_name ?>
    <tr id="r_guest_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_guest_name"><?= $Page->guest_name->caption() ?></span></td>
        <td data-name="guest_name" <?= $Page->guest_name->cellAttributes() ?>>
<span id="el_arrowchat_status_guest_name">
<span<?= $Page->guest_name->viewAttributes() ?>>
<?= $Page->guest_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->message->Visible) { // message ?>
    <tr id="r_message">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_message"><?= $Page->message->caption() ?></span></td>
        <td data-name="message" <?= $Page->message->cellAttributes() ?>>
<span id="el_arrowchat_status_message">
<span<?= $Page->message->viewAttributes() ?>>
<?= $Page->message->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_arrowchat_status_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->theme->Visible) { // theme ?>
    <tr id="r_theme">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_theme"><?= $Page->theme->caption() ?></span></td>
        <td data-name="theme" <?= $Page->theme->cellAttributes() ?>>
<span id="el_arrowchat_status_theme">
<span<?= $Page->theme->viewAttributes() ?>>
<?= $Page->theme->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->popout->Visible) { // popout ?>
    <tr id="r_popout">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_popout"><?= $Page->popout->caption() ?></span></td>
        <td data-name="popout" <?= $Page->popout->cellAttributes() ?>>
<span id="el_arrowchat_status_popout">
<span<?= $Page->popout->viewAttributes() ?>>
<?= $Page->popout->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->typing->Visible) { // typing ?>
    <tr id="r_typing">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_typing"><?= $Page->typing->caption() ?></span></td>
        <td data-name="typing" <?= $Page->typing->cellAttributes() ?>>
<span id="el_arrowchat_status_typing">
<span<?= $Page->typing->viewAttributes() ?>>
<?= $Page->typing->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hide_bar->Visible) { // hide_bar ?>
    <tr id="r_hide_bar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_hide_bar"><?= $Page->hide_bar->caption() ?></span></td>
        <td data-name="hide_bar" <?= $Page->hide_bar->cellAttributes() ?>>
<span id="el_arrowchat_status_hide_bar">
<span<?= $Page->hide_bar->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_hide_bar_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->hide_bar->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->hide_bar->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_hide_bar_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->play_sound->Visible) { // play_sound ?>
    <tr id="r_play_sound">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_play_sound"><?= $Page->play_sound->caption() ?></span></td>
        <td data-name="play_sound" <?= $Page->play_sound->cellAttributes() ?>>
<span id="el_arrowchat_status_play_sound">
<span<?= $Page->play_sound->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_play_sound_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->play_sound->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->play_sound->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_play_sound_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->window_open->Visible) { // window_open ?>
    <tr id="r_window_open">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_window_open"><?= $Page->window_open->caption() ?></span></td>
        <td data-name="window_open" <?= $Page->window_open->cellAttributes() ?>>
<span id="el_arrowchat_status_window_open">
<span<?= $Page->window_open->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_window_open_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->window_open->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->window_open->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_window_open_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->only_names->Visible) { // only_names ?>
    <tr id="r_only_names">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_only_names"><?= $Page->only_names->caption() ?></span></td>
        <td data-name="only_names" <?= $Page->only_names->cellAttributes() ?>>
<span id="el_arrowchat_status_only_names">
<span<?= $Page->only_names->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_only_names_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->only_names->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->only_names->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_only_names_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chatroom_window->Visible) { // chatroom_window ?>
    <tr id="r_chatroom_window">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_chatroom_window"><?= $Page->chatroom_window->caption() ?></span></td>
        <td data-name="chatroom_window" <?= $Page->chatroom_window->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_window">
<span<?= $Page->chatroom_window->viewAttributes() ?>>
<?= $Page->chatroom_window->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chatroom_stay->Visible) { // chatroom_stay ?>
    <tr id="r_chatroom_stay">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_chatroom_stay"><?= $Page->chatroom_stay->caption() ?></span></td>
        <td data-name="chatroom_stay" <?= $Page->chatroom_stay->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_stay">
<span<?= $Page->chatroom_stay->viewAttributes() ?>>
<?= $Page->chatroom_stay->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chatroom_unfocus->Visible) { // chatroom_unfocus ?>
    <tr id="r_chatroom_unfocus">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_chatroom_unfocus"><?= $Page->chatroom_unfocus->caption() ?></span></td>
        <td data-name="chatroom_unfocus" <?= $Page->chatroom_unfocus->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_unfocus">
<span<?= $Page->chatroom_unfocus->viewAttributes() ?>>
<?= $Page->chatroom_unfocus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chatroom_show_names->Visible) { // chatroom_show_names ?>
    <tr id="r_chatroom_show_names">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_chatroom_show_names"><?= $Page->chatroom_show_names->caption() ?></span></td>
        <td data-name="chatroom_show_names" <?= $Page->chatroom_show_names->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_show_names">
<span<?= $Page->chatroom_show_names->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_chatroom_show_names_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->chatroom_show_names->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->chatroom_show_names->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_chatroom_show_names_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chatroom_block_chats->Visible) { // chatroom_block_chats ?>
    <tr id="r_chatroom_block_chats">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_chatroom_block_chats"><?= $Page->chatroom_block_chats->caption() ?></span></td>
        <td data-name="chatroom_block_chats" <?= $Page->chatroom_block_chats->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_block_chats">
<span<?= $Page->chatroom_block_chats->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_chatroom_block_chats_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->chatroom_block_chats->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->chatroom_block_chats->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_chatroom_block_chats_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chatroom_sound->Visible) { // chatroom_sound ?>
    <tr id="r_chatroom_sound">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_chatroom_sound"><?= $Page->chatroom_sound->caption() ?></span></td>
        <td data-name="chatroom_sound" <?= $Page->chatroom_sound->cellAttributes() ?>>
<span id="el_arrowchat_status_chatroom_sound">
<span<?= $Page->chatroom_sound->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_chatroom_sound_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->chatroom_sound->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->chatroom_sound->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_chatroom_sound_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->announcement->Visible) { // announcement ?>
    <tr id="r_announcement">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_announcement"><?= $Page->announcement->caption() ?></span></td>
        <td data-name="announcement" <?= $Page->announcement->cellAttributes() ?>>
<span id="el_arrowchat_status_announcement">
<span<?= $Page->announcement->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_announcement_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->announcement->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->announcement->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_announcement_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unfocus_chat->Visible) { // unfocus_chat ?>
    <tr id="r_unfocus_chat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_unfocus_chat"><?= $Page->unfocus_chat->caption() ?></span></td>
        <td data-name="unfocus_chat" <?= $Page->unfocus_chat->cellAttributes() ?>>
<span id="el_arrowchat_status_unfocus_chat">
<span<?= $Page->unfocus_chat->viewAttributes() ?>>
<?= $Page->unfocus_chat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->focus_chat->Visible) { // focus_chat ?>
    <tr id="r_focus_chat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_focus_chat"><?= $Page->focus_chat->caption() ?></span></td>
        <td data-name="focus_chat" <?= $Page->focus_chat->cellAttributes() ?>>
<span id="el_arrowchat_status_focus_chat">
<span<?= $Page->focus_chat->viewAttributes() ?>>
<?= $Page->focus_chat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_message->Visible) { // last_message ?>
    <tr id="r_last_message">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_last_message"><?= $Page->last_message->caption() ?></span></td>
        <td data-name="last_message" <?= $Page->last_message->cellAttributes() ?>>
<span id="el_arrowchat_status_last_message">
<span<?= $Page->last_message->viewAttributes() ?>>
<?= $Page->last_message->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->clear_chats->Visible) { // clear_chats ?>
    <tr id="r_clear_chats">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_clear_chats"><?= $Page->clear_chats->caption() ?></span></td>
        <td data-name="clear_chats" <?= $Page->clear_chats->cellAttributes() ?>>
<span id="el_arrowchat_status_clear_chats">
<span<?= $Page->clear_chats->viewAttributes() ?>>
<?= $Page->clear_chats->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apps_bookmarks->Visible) { // apps_bookmarks ?>
    <tr id="r_apps_bookmarks">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_apps_bookmarks"><?= $Page->apps_bookmarks->caption() ?></span></td>
        <td data-name="apps_bookmarks" <?= $Page->apps_bookmarks->cellAttributes() ?>>
<span id="el_arrowchat_status_apps_bookmarks">
<span<?= $Page->apps_bookmarks->viewAttributes() ?>>
<?= $Page->apps_bookmarks->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apps_other->Visible) { // apps_other ?>
    <tr id="r_apps_other">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_apps_other"><?= $Page->apps_other->caption() ?></span></td>
        <td data-name="apps_other" <?= $Page->apps_other->cellAttributes() ?>>
<span id="el_arrowchat_status_apps_other">
<span<?= $Page->apps_other->viewAttributes() ?>>
<?= $Page->apps_other->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apps_open->Visible) { // apps_open ?>
    <tr id="r_apps_open">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_apps_open"><?= $Page->apps_open->caption() ?></span></td>
        <td data-name="apps_open" <?= $Page->apps_open->cellAttributes() ?>>
<span id="el_arrowchat_status_apps_open">
<span<?= $Page->apps_open->viewAttributes() ?>>
<?= $Page->apps_open->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apps_load->Visible) { // apps_load ?>
    <tr id="r_apps_load">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_apps_load"><?= $Page->apps_load->caption() ?></span></td>
        <td data-name="apps_load" <?= $Page->apps_load->cellAttributes() ?>>
<span id="el_arrowchat_status_apps_load">
<span<?= $Page->apps_load->viewAttributes() ?>>
<?= $Page->apps_load->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->block_chats->Visible) { // block_chats ?>
    <tr id="r_block_chats">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_block_chats"><?= $Page->block_chats->caption() ?></span></td>
        <td data-name="block_chats" <?= $Page->block_chats->cellAttributes() ?>>
<span id="el_arrowchat_status_block_chats">
<span<?= $Page->block_chats->viewAttributes() ?>>
<?= $Page->block_chats->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
    <tr id="r_session_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_session_time"><?= $Page->session_time->caption() ?></span></td>
        <td data-name="session_time" <?= $Page->session_time->cellAttributes() ?>>
<span id="el_arrowchat_status_session_time">
<span<?= $Page->session_time->viewAttributes() ?>>
<?= $Page->session_time->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
    <tr id="r_is_admin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_is_admin"><?= $Page->is_admin->caption() ?></span></td>
        <td data-name="is_admin" <?= $Page->is_admin->cellAttributes() ?>>
<span id="el_arrowchat_status_is_admin">
<span<?= $Page->is_admin->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_admin_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_admin->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_admin->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_admin_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
    <tr id="r_is_mod">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_is_mod"><?= $Page->is_mod->caption() ?></span></td>
        <td data-name="is_mod" <?= $Page->is_mod->cellAttributes() ?>>
<span id="el_arrowchat_status_is_mod">
<span<?= $Page->is_mod->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_mod_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_mod->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_mod->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_mod_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hash_id->Visible) { // hash_id ?>
    <tr id="r_hash_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_hash_id"><?= $Page->hash_id->caption() ?></span></td>
        <td data-name="hash_id" <?= $Page->hash_id->cellAttributes() ?>>
<span id="el_arrowchat_status_hash_id">
<span<?= $Page->hash_id->viewAttributes() ?>>
<?= $Page->hash_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ip_address->Visible) { // ip_address ?>
    <tr id="r_ip_address">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_status_ip_address"><?= $Page->ip_address->caption() ?></span></td>
        <td data-name="ip_address" <?= $Page->ip_address->cellAttributes() ?>>
<span id="el_arrowchat_status_ip_address">
<span<?= $Page->ip_address->viewAttributes() ?>>
<?= $Page->ip_address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
