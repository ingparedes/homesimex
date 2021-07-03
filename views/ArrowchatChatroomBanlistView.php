<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomBanlistView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_banlistview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_chatroom_banlistview = currentForm = new ew.Form("farrowchat_chatroom_banlistview", "view");
    loadjs.done("farrowchat_chatroom_banlistview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_chatroom_banlist) ew.vars.tables.arrowchat_chatroom_banlist = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_banlist")) ?>;
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
<form name="farrowchat_chatroom_banlistview" id="farrowchat_chatroom_banlistview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_banlist">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_banlist_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <tr id="r_user_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_banlist_user_id"><?= $Page->user_id->caption() ?></span></td>
        <td data-name="user_id" <?= $Page->user_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
    <tr id="r_chatroom_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_banlist_chatroom_id"><?= $Page->chatroom_id->caption() ?></span></td>
        <td data-name="chatroom_id" <?= $Page->chatroom_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_chatroom_id">
<span<?= $Page->chatroom_id->viewAttributes() ?>>
<?= $Page->chatroom_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ban_length->Visible) { // ban_length ?>
    <tr id="r_ban_length">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_banlist_ban_length"><?= $Page->ban_length->caption() ?></span></td>
        <td data-name="ban_length" <?= $Page->ban_length->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_ban_length">
<span<?= $Page->ban_length->viewAttributes() ?>>
<?= $Page->ban_length->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ban_time->Visible) { // ban_time ?>
    <tr id="r_ban_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_banlist_ban_time"><?= $Page->ban_time->caption() ?></span></td>
        <td data-name="ban_time" <?= $Page->ban_time->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_ban_time">
<span<?= $Page->ban_time->viewAttributes() ?>>
<?= $Page->ban_time->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ip_address->Visible) { // ip_address ?>
    <tr id="r_ip_address">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_banlist_ip_address"><?= $Page->ip_address->caption() ?></span></td>
        <td data-name="ip_address" <?= $Page->ip_address->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_ip_address">
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
