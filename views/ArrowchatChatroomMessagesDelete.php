<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomMessagesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_messagesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_chatroom_messagesdelete = currentForm = new ew.Form("farrowchat_chatroom_messagesdelete", "delete");
    loadjs.done("farrowchat_chatroom_messagesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_chatroom_messages) ew.vars.tables.arrowchat_chatroom_messages = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_messages")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_chatroom_messagesdelete" id="farrowchat_chatroom_messagesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_messages">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_messages_id" class="arrowchat_chatroom_messages_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
        <th class="<?= $Page->chatroom_id->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_messages_chatroom_id" class="arrowchat_chatroom_messages_chatroom_id"><?= $Page->chatroom_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
        <th class="<?= $Page->user_id->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_messages_user_id" class="arrowchat_chatroom_messages_user_id"><?= $Page->user_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_messages__username" class="arrowchat_chatroom_messages__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->global_message->Visible) { // global_message ?>
        <th class="<?= $Page->global_message->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_messages_global_message" class="arrowchat_chatroom_messages_global_message"><?= $Page->global_message->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
        <th class="<?= $Page->is_mod->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_messages_is_mod" class="arrowchat_chatroom_messages_is_mod"><?= $Page->is_mod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
        <th class="<?= $Page->is_admin->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_messages_is_admin" class="arrowchat_chatroom_messages_is_admin"><?= $Page->is_admin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sent->Visible) { // sent ?>
        <th class="<?= $Page->sent->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_messages_sent" class="arrowchat_chatroom_messages_sent"><?= $Page->sent->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_action->Visible) { // action ?>
        <th class="<?= $Page->_action->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_messages__action" class="arrowchat_chatroom_messages__action"><?= $Page->_action->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_id" class="arrowchat_chatroom_messages_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
        <td <?= $Page->chatroom_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_chatroom_id" class="arrowchat_chatroom_messages_chatroom_id">
<span<?= $Page->chatroom_id->viewAttributes() ?>>
<?= $Page->chatroom_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
        <td <?= $Page->user_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_user_id" class="arrowchat_chatroom_messages_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <td <?= $Page->_username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages__username" class="arrowchat_chatroom_messages__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->global_message->Visible) { // global_message ?>
        <td <?= $Page->global_message->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_global_message" class="arrowchat_chatroom_messages_global_message">
<span<?= $Page->global_message->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_global_message_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->global_message->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->global_message->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_global_message_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
        <td <?= $Page->is_mod->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_is_mod" class="arrowchat_chatroom_messages_is_mod">
<span<?= $Page->is_mod->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_mod_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_mod->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_mod->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_mod_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
        <td <?= $Page->is_admin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_is_admin" class="arrowchat_chatroom_messages_is_admin">
<span<?= $Page->is_admin->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_admin_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_admin->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_admin->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_admin_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sent->Visible) { // sent ?>
        <td <?= $Page->sent->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_sent" class="arrowchat_chatroom_messages_sent">
<span<?= $Page->sent->viewAttributes() ?>>
<?= $Page->sent->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_action->Visible) { // action ?>
        <td <?= $Page->_action->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages__action" class="arrowchat_chatroom_messages__action">
<span<?= $Page->_action->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x__action_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->_action->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->_action->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x__action_<?= $Page->RowCount ?>"></label>
</div></span>
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
