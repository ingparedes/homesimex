<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatStatusDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_statusdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_statusdelete = currentForm = new ew.Form("farrowchat_statusdelete", "delete");
    loadjs.done("farrowchat_statusdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_status) ew.vars.tables.arrowchat_status = <?= JsonEncode(GetClientVar("tables", "arrowchat_status")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_statusdelete" id="farrowchat_statusdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_status">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->_userid->Visible) { // userid ?>
        <th class="<?= $Page->_userid->headerCellClass() ?>"><span id="elh_arrowchat_status__userid" class="arrowchat_status__userid"><?= $Page->_userid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->guest_name->Visible) { // guest_name ?>
        <th class="<?= $Page->guest_name->headerCellClass() ?>"><span id="elh_arrowchat_status_guest_name" class="arrowchat_status_guest_name"><?= $Page->guest_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_arrowchat_status_status" class="arrowchat_status_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->theme->Visible) { // theme ?>
        <th class="<?= $Page->theme->headerCellClass() ?>"><span id="elh_arrowchat_status_theme" class="arrowchat_status_theme"><?= $Page->theme->caption() ?></span></th>
<?php } ?>
<?php if ($Page->popout->Visible) { // popout ?>
        <th class="<?= $Page->popout->headerCellClass() ?>"><span id="elh_arrowchat_status_popout" class="arrowchat_status_popout"><?= $Page->popout->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hide_bar->Visible) { // hide_bar ?>
        <th class="<?= $Page->hide_bar->headerCellClass() ?>"><span id="elh_arrowchat_status_hide_bar" class="arrowchat_status_hide_bar"><?= $Page->hide_bar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->play_sound->Visible) { // play_sound ?>
        <th class="<?= $Page->play_sound->headerCellClass() ?>"><span id="elh_arrowchat_status_play_sound" class="arrowchat_status_play_sound"><?= $Page->play_sound->caption() ?></span></th>
<?php } ?>
<?php if ($Page->window_open->Visible) { // window_open ?>
        <th class="<?= $Page->window_open->headerCellClass() ?>"><span id="elh_arrowchat_status_window_open" class="arrowchat_status_window_open"><?= $Page->window_open->caption() ?></span></th>
<?php } ?>
<?php if ($Page->only_names->Visible) { // only_names ?>
        <th class="<?= $Page->only_names->headerCellClass() ?>"><span id="elh_arrowchat_status_only_names" class="arrowchat_status_only_names"><?= $Page->only_names->caption() ?></span></th>
<?php } ?>
<?php if ($Page->chatroom_window->Visible) { // chatroom_window ?>
        <th class="<?= $Page->chatroom_window->headerCellClass() ?>"><span id="elh_arrowchat_status_chatroom_window" class="arrowchat_status_chatroom_window"><?= $Page->chatroom_window->caption() ?></span></th>
<?php } ?>
<?php if ($Page->chatroom_stay->Visible) { // chatroom_stay ?>
        <th class="<?= $Page->chatroom_stay->headerCellClass() ?>"><span id="elh_arrowchat_status_chatroom_stay" class="arrowchat_status_chatroom_stay"><?= $Page->chatroom_stay->caption() ?></span></th>
<?php } ?>
<?php if ($Page->chatroom_show_names->Visible) { // chatroom_show_names ?>
        <th class="<?= $Page->chatroom_show_names->headerCellClass() ?>"><span id="elh_arrowchat_status_chatroom_show_names" class="arrowchat_status_chatroom_show_names"><?= $Page->chatroom_show_names->caption() ?></span></th>
<?php } ?>
<?php if ($Page->chatroom_block_chats->Visible) { // chatroom_block_chats ?>
        <th class="<?= $Page->chatroom_block_chats->headerCellClass() ?>"><span id="elh_arrowchat_status_chatroom_block_chats" class="arrowchat_status_chatroom_block_chats"><?= $Page->chatroom_block_chats->caption() ?></span></th>
<?php } ?>
<?php if ($Page->chatroom_sound->Visible) { // chatroom_sound ?>
        <th class="<?= $Page->chatroom_sound->headerCellClass() ?>"><span id="elh_arrowchat_status_chatroom_sound" class="arrowchat_status_chatroom_sound"><?= $Page->chatroom_sound->caption() ?></span></th>
<?php } ?>
<?php if ($Page->announcement->Visible) { // announcement ?>
        <th class="<?= $Page->announcement->headerCellClass() ?>"><span id="elh_arrowchat_status_announcement" class="arrowchat_status_announcement"><?= $Page->announcement->caption() ?></span></th>
<?php } ?>
<?php if ($Page->focus_chat->Visible) { // focus_chat ?>
        <th class="<?= $Page->focus_chat->headerCellClass() ?>"><span id="elh_arrowchat_status_focus_chat" class="arrowchat_status_focus_chat"><?= $Page->focus_chat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->apps_open->Visible) { // apps_open ?>
        <th class="<?= $Page->apps_open->headerCellClass() ?>"><span id="elh_arrowchat_status_apps_open" class="arrowchat_status_apps_open"><?= $Page->apps_open->caption() ?></span></th>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
        <th class="<?= $Page->session_time->headerCellClass() ?>"><span id="elh_arrowchat_status_session_time" class="arrowchat_status_session_time"><?= $Page->session_time->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
        <th class="<?= $Page->is_admin->headerCellClass() ?>"><span id="elh_arrowchat_status_is_admin" class="arrowchat_status_is_admin"><?= $Page->is_admin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
        <th class="<?= $Page->is_mod->headerCellClass() ?>"><span id="elh_arrowchat_status_is_mod" class="arrowchat_status_is_mod"><?= $Page->is_mod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hash_id->Visible) { // hash_id ?>
        <th class="<?= $Page->hash_id->headerCellClass() ?>"><span id="elh_arrowchat_status_hash_id" class="arrowchat_status_hash_id"><?= $Page->hash_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ip_address->Visible) { // ip_address ?>
        <th class="<?= $Page->ip_address->headerCellClass() ?>"><span id="elh_arrowchat_status_ip_address" class="arrowchat_status_ip_address"><?= $Page->ip_address->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->_userid->Visible) { // userid ?>
        <td <?= $Page->_userid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status__userid" class="arrowchat_status__userid">
<span<?= $Page->_userid->viewAttributes() ?>>
<?= $Page->_userid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->guest_name->Visible) { // guest_name ?>
        <td <?= $Page->guest_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_guest_name" class="arrowchat_status_guest_name">
<span<?= $Page->guest_name->viewAttributes() ?>>
<?= $Page->guest_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_status" class="arrowchat_status_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->theme->Visible) { // theme ?>
        <td <?= $Page->theme->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_theme" class="arrowchat_status_theme">
<span<?= $Page->theme->viewAttributes() ?>>
<?= $Page->theme->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->popout->Visible) { // popout ?>
        <td <?= $Page->popout->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_popout" class="arrowchat_status_popout">
<span<?= $Page->popout->viewAttributes() ?>>
<?= $Page->popout->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hide_bar->Visible) { // hide_bar ?>
        <td <?= $Page->hide_bar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_hide_bar" class="arrowchat_status_hide_bar">
<span<?= $Page->hide_bar->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_hide_bar_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->hide_bar->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->hide_bar->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_hide_bar_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->play_sound->Visible) { // play_sound ?>
        <td <?= $Page->play_sound->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_play_sound" class="arrowchat_status_play_sound">
<span<?= $Page->play_sound->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_play_sound_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->play_sound->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->play_sound->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_play_sound_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->window_open->Visible) { // window_open ?>
        <td <?= $Page->window_open->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_window_open" class="arrowchat_status_window_open">
<span<?= $Page->window_open->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_window_open_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->window_open->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->window_open->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_window_open_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->only_names->Visible) { // only_names ?>
        <td <?= $Page->only_names->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_only_names" class="arrowchat_status_only_names">
<span<?= $Page->only_names->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_only_names_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->only_names->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->only_names->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_only_names_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->chatroom_window->Visible) { // chatroom_window ?>
        <td <?= $Page->chatroom_window->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_chatroom_window" class="arrowchat_status_chatroom_window">
<span<?= $Page->chatroom_window->viewAttributes() ?>>
<?= $Page->chatroom_window->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->chatroom_stay->Visible) { // chatroom_stay ?>
        <td <?= $Page->chatroom_stay->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_chatroom_stay" class="arrowchat_status_chatroom_stay">
<span<?= $Page->chatroom_stay->viewAttributes() ?>>
<?= $Page->chatroom_stay->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->chatroom_show_names->Visible) { // chatroom_show_names ?>
        <td <?= $Page->chatroom_show_names->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_chatroom_show_names" class="arrowchat_status_chatroom_show_names">
<span<?= $Page->chatroom_show_names->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_chatroom_show_names_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->chatroom_show_names->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->chatroom_show_names->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_chatroom_show_names_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->chatroom_block_chats->Visible) { // chatroom_block_chats ?>
        <td <?= $Page->chatroom_block_chats->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_chatroom_block_chats" class="arrowchat_status_chatroom_block_chats">
<span<?= $Page->chatroom_block_chats->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_chatroom_block_chats_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->chatroom_block_chats->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->chatroom_block_chats->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_chatroom_block_chats_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->chatroom_sound->Visible) { // chatroom_sound ?>
        <td <?= $Page->chatroom_sound->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_chatroom_sound" class="arrowchat_status_chatroom_sound">
<span<?= $Page->chatroom_sound->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_chatroom_sound_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->chatroom_sound->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->chatroom_sound->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_chatroom_sound_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->announcement->Visible) { // announcement ?>
        <td <?= $Page->announcement->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_announcement" class="arrowchat_status_announcement">
<span<?= $Page->announcement->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_announcement_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->announcement->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->announcement->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_announcement_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->focus_chat->Visible) { // focus_chat ?>
        <td <?= $Page->focus_chat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_focus_chat" class="arrowchat_status_focus_chat">
<span<?= $Page->focus_chat->viewAttributes() ?>>
<?= $Page->focus_chat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->apps_open->Visible) { // apps_open ?>
        <td <?= $Page->apps_open->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_apps_open" class="arrowchat_status_apps_open">
<span<?= $Page->apps_open->viewAttributes() ?>>
<?= $Page->apps_open->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
        <td <?= $Page->session_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_session_time" class="arrowchat_status_session_time">
<span<?= $Page->session_time->viewAttributes() ?>>
<?= $Page->session_time->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
        <td <?= $Page->is_admin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_is_admin" class="arrowchat_status_is_admin">
<span<?= $Page->is_admin->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_admin_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_admin->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_admin->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_admin_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
        <td <?= $Page->is_mod->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_is_mod" class="arrowchat_status_is_mod">
<span<?= $Page->is_mod->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_mod_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_mod->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_mod->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_mod_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hash_id->Visible) { // hash_id ?>
        <td <?= $Page->hash_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_hash_id" class="arrowchat_status_hash_id">
<span<?= $Page->hash_id->viewAttributes() ?>>
<?= $Page->hash_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ip_address->Visible) { // ip_address ?>
        <td <?= $Page->ip_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_ip_address" class="arrowchat_status_ip_address">
<span<?= $Page->ip_address->viewAttributes() ?>>
<?= $Page->ip_address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
