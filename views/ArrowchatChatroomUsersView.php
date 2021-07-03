<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomUsersView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_usersview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_chatroom_usersview = currentForm = new ew.Form("farrowchat_chatroom_usersview", "view");
    loadjs.done("farrowchat_chatroom_usersview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_chatroom_users) ew.vars.tables.arrowchat_chatroom_users = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_users")) ?>;
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
<form name="farrowchat_chatroom_usersview" id="farrowchat_chatroom_usersview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_users">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->user_id->Visible) { // user_id ?>
    <tr id="r_user_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_users_user_id"><?= $Page->user_id->caption() ?></span></td>
        <td data-name="user_id" <?= $Page->user_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
    <tr id="r_chatroom_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_users_chatroom_id"><?= $Page->chatroom_id->caption() ?></span></td>
        <td data-name="chatroom_id" <?= $Page->chatroom_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_chatroom_id">
<span<?= $Page->chatroom_id->viewAttributes() ?>>
<?= $Page->chatroom_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
    <tr id="r_is_admin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_users_is_admin"><?= $Page->is_admin->caption() ?></span></td>
        <td data-name="is_admin" <?= $Page->is_admin->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_is_admin">
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
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_users_is_mod"><?= $Page->is_mod->caption() ?></span></td>
        <td data-name="is_mod" <?= $Page->is_mod->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_is_mod">
<span<?= $Page->is_mod->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_mod_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_mod->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_mod->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_mod_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->block_chats->Visible) { // block_chats ?>
    <tr id="r_block_chats">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_users_block_chats"><?= $Page->block_chats->caption() ?></span></td>
        <td data-name="block_chats" <?= $Page->block_chats->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_block_chats">
<span<?= $Page->block_chats->viewAttributes() ?>>
<?= $Page->block_chats->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->silence_length->Visible) { // silence_length ?>
    <tr id="r_silence_length">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_users_silence_length"><?= $Page->silence_length->caption() ?></span></td>
        <td data-name="silence_length" <?= $Page->silence_length->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_silence_length">
<span<?= $Page->silence_length->viewAttributes() ?>>
<?= $Page->silence_length->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->silence_time->Visible) { // silence_time ?>
    <tr id="r_silence_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_users_silence_time"><?= $Page->silence_time->caption() ?></span></td>
        <td data-name="silence_time" <?= $Page->silence_time->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_silence_time">
<span<?= $Page->silence_time->viewAttributes() ?>>
<?= $Page->silence_time->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
    <tr id="r_session_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_users_session_time"><?= $Page->session_time->caption() ?></span></td>
        <td data-name="session_time" <?= $Page->session_time->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_users_session_time">
<span<?= $Page->session_time->viewAttributes() ?>>
<?= $Page->session_time->getViewValue() ?></span>
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
