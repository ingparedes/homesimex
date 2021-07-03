<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomMessagesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_messagesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_chatroom_messagesview = currentForm = new ew.Form("farrowchat_chatroom_messagesview", "view");
    loadjs.done("farrowchat_chatroom_messagesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_chatroom_messages) ew.vars.tables.arrowchat_chatroom_messages = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_messages")) ?>;
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
<form name="farrowchat_chatroom_messagesview" id="farrowchat_chatroom_messagesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_messages">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_messages_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
    <tr id="r_chatroom_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_messages_chatroom_id"><?= $Page->chatroom_id->caption() ?></span></td>
        <td data-name="chatroom_id" <?= $Page->chatroom_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_chatroom_id">
<span<?= $Page->chatroom_id->viewAttributes() ?>>
<?= $Page->chatroom_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <tr id="r_user_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_messages_user_id"><?= $Page->user_id->caption() ?></span></td>
        <td data-name="user_id" <?= $Page->user_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_messages__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username" <?= $Page->_username->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->message->Visible) { // message ?>
    <tr id="r_message">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_messages_message"><?= $Page->message->caption() ?></span></td>
        <td data-name="message" <?= $Page->message->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_message">
<span<?= $Page->message->viewAttributes() ?>>
<?= $Page->message->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->global_message->Visible) { // global_message ?>
    <tr id="r_global_message">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_messages_global_message"><?= $Page->global_message->caption() ?></span></td>
        <td data-name="global_message" <?= $Page->global_message->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_global_message">
<span<?= $Page->global_message->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_global_message_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->global_message->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->global_message->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_global_message_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
    <tr id="r_is_mod">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_messages_is_mod"><?= $Page->is_mod->caption() ?></span></td>
        <td data-name="is_mod" <?= $Page->is_mod->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_is_mod">
<span<?= $Page->is_mod->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_mod_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_mod->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_mod->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_mod_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
    <tr id="r_is_admin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_messages_is_admin"><?= $Page->is_admin->caption() ?></span></td>
        <td data-name="is_admin" <?= $Page->is_admin->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_is_admin">
<span<?= $Page->is_admin->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_admin_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_admin->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_admin->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_admin_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sent->Visible) { // sent ?>
    <tr id="r_sent">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_messages_sent"><?= $Page->sent->caption() ?></span></td>
        <td data-name="sent" <?= $Page->sent->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages_sent">
<span<?= $Page->sent->viewAttributes() ?>>
<?= $Page->sent->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_action->Visible) { // action ?>
    <tr id="r__action">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_messages__action"><?= $Page->_action->caption() ?></span></td>
        <td data-name="_action" <?= $Page->_action->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_messages__action">
<span<?= $Page->_action->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x__action_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->_action->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->_action->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x__action_<?= $Page->RowCount ?>"></label>
</div></span>
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
