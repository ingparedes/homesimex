<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatBanlistView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_banlistview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_banlistview = currentForm = new ew.Form("farrowchat_banlistview", "view");
    loadjs.done("farrowchat_banlistview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_banlist) ew.vars.tables.arrowchat_banlist = <?= JsonEncode(GetClientVar("tables", "arrowchat_banlist")) ?>;
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
<form name="farrowchat_banlistview" id="farrowchat_banlistview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_banlist">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->ban_id->Visible) { // ban_id ?>
    <tr id="r_ban_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_banlist_ban_id"><?= $Page->ban_id->caption() ?></span></td>
        <td data-name="ban_id" <?= $Page->ban_id->cellAttributes() ?>>
<span id="el_arrowchat_banlist_ban_id">
<span<?= $Page->ban_id->viewAttributes() ?>>
<?= $Page->ban_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ban_userid->Visible) { // ban_userid ?>
    <tr id="r_ban_userid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_banlist_ban_userid"><?= $Page->ban_userid->caption() ?></span></td>
        <td data-name="ban_userid" <?= $Page->ban_userid->cellAttributes() ?>>
<span id="el_arrowchat_banlist_ban_userid">
<span<?= $Page->ban_userid->viewAttributes() ?>>
<?= $Page->ban_userid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ban_ip->Visible) { // ban_ip ?>
    <tr id="r_ban_ip">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_banlist_ban_ip"><?= $Page->ban_ip->caption() ?></span></td>
        <td data-name="ban_ip" <?= $Page->ban_ip->cellAttributes() ?>>
<span id="el_arrowchat_banlist_ban_ip">
<span<?= $Page->ban_ip->viewAttributes() ?>>
<?= $Page->ban_ip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->banned_by->Visible) { // banned_by ?>
    <tr id="r_banned_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_banlist_banned_by"><?= $Page->banned_by->caption() ?></span></td>
        <td data-name="banned_by" <?= $Page->banned_by->cellAttributes() ?>>
<span id="el_arrowchat_banlist_banned_by">
<span<?= $Page->banned_by->viewAttributes() ?>>
<?= $Page->banned_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->banned_time->Visible) { // banned_time ?>
    <tr id="r_banned_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_banlist_banned_time"><?= $Page->banned_time->caption() ?></span></td>
        <td data-name="banned_time" <?= $Page->banned_time->cellAttributes() ?>>
<span id="el_arrowchat_banlist_banned_time">
<span<?= $Page->banned_time->viewAttributes() ?>>
<?= $Page->banned_time->getViewValue() ?></span>
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
