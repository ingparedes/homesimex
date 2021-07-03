<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomBanlistDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_banlistdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_chatroom_banlistdelete = currentForm = new ew.Form("farrowchat_chatroom_banlistdelete", "delete");
    loadjs.done("farrowchat_chatroom_banlistdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_chatroom_banlist) ew.vars.tables.arrowchat_chatroom_banlist = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_banlist")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_chatroom_banlistdelete" id="farrowchat_chatroom_banlistdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_banlist">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_banlist_id" class="arrowchat_chatroom_banlist_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
        <th class="<?= $Page->user_id->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_banlist_user_id" class="arrowchat_chatroom_banlist_user_id"><?= $Page->user_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
        <th class="<?= $Page->chatroom_id->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_banlist_chatroom_id" class="arrowchat_chatroom_banlist_chatroom_id"><?= $Page->chatroom_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ban_length->Visible) { // ban_length ?>
        <th class="<?= $Page->ban_length->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_banlist_ban_length" class="arrowchat_chatroom_banlist_ban_length"><?= $Page->ban_length->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ban_time->Visible) { // ban_time ?>
        <th class="<?= $Page->ban_time->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_banlist_ban_time" class="arrowchat_chatroom_banlist_ban_time"><?= $Page->ban_time->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ip_address->Visible) { // ip_address ?>
        <th class="<?= $Page->ip_address->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_banlist_ip_address" class="arrowchat_chatroom_banlist_ip_address"><?= $Page->ip_address->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_banlist_id" class="arrowchat_chatroom_banlist_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
        <td <?= $Page->user_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_banlist_user_id" class="arrowchat_chatroom_banlist_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
        <td <?= $Page->chatroom_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_banlist_chatroom_id" class="arrowchat_chatroom_banlist_chatroom_id">
<span<?= $Page->chatroom_id->viewAttributes() ?>>
<?= $Page->chatroom_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ban_length->Visible) { // ban_length ?>
        <td <?= $Page->ban_length->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_banlist_ban_length" class="arrowchat_chatroom_banlist_ban_length">
<span<?= $Page->ban_length->viewAttributes() ?>>
<?= $Page->ban_length->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ban_time->Visible) { // ban_time ?>
        <td <?= $Page->ban_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_banlist_ban_time" class="arrowchat_chatroom_banlist_ban_time">
<span<?= $Page->ban_time->viewAttributes() ?>>
<?= $Page->ban_time->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ip_address->Visible) { // ip_address ?>
        <td <?= $Page->ip_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_banlist_ip_address" class="arrowchat_chatroom_banlist_ip_address">
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
