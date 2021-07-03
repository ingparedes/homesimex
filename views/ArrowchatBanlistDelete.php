<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatBanlistDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_banlistdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_banlistdelete = currentForm = new ew.Form("farrowchat_banlistdelete", "delete");
    loadjs.done("farrowchat_banlistdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_banlist) ew.vars.tables.arrowchat_banlist = <?= JsonEncode(GetClientVar("tables", "arrowchat_banlist")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_banlistdelete" id="farrowchat_banlistdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_banlist">
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
<?php if ($Page->ban_id->Visible) { // ban_id ?>
        <th class="<?= $Page->ban_id->headerCellClass() ?>"><span id="elh_arrowchat_banlist_ban_id" class="arrowchat_banlist_ban_id"><?= $Page->ban_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ban_userid->Visible) { // ban_userid ?>
        <th class="<?= $Page->ban_userid->headerCellClass() ?>"><span id="elh_arrowchat_banlist_ban_userid" class="arrowchat_banlist_ban_userid"><?= $Page->ban_userid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ban_ip->Visible) { // ban_ip ?>
        <th class="<?= $Page->ban_ip->headerCellClass() ?>"><span id="elh_arrowchat_banlist_ban_ip" class="arrowchat_banlist_ban_ip"><?= $Page->ban_ip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->banned_by->Visible) { // banned_by ?>
        <th class="<?= $Page->banned_by->headerCellClass() ?>"><span id="elh_arrowchat_banlist_banned_by" class="arrowchat_banlist_banned_by"><?= $Page->banned_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->banned_time->Visible) { // banned_time ?>
        <th class="<?= $Page->banned_time->headerCellClass() ?>"><span id="elh_arrowchat_banlist_banned_time" class="arrowchat_banlist_banned_time"><?= $Page->banned_time->caption() ?></span></th>
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
<?php if ($Page->ban_id->Visible) { // ban_id ?>
        <td <?= $Page->ban_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_banlist_ban_id" class="arrowchat_banlist_ban_id">
<span<?= $Page->ban_id->viewAttributes() ?>>
<?= $Page->ban_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ban_userid->Visible) { // ban_userid ?>
        <td <?= $Page->ban_userid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_banlist_ban_userid" class="arrowchat_banlist_ban_userid">
<span<?= $Page->ban_userid->viewAttributes() ?>>
<?= $Page->ban_userid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ban_ip->Visible) { // ban_ip ?>
        <td <?= $Page->ban_ip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_banlist_ban_ip" class="arrowchat_banlist_ban_ip">
<span<?= $Page->ban_ip->viewAttributes() ?>>
<?= $Page->ban_ip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->banned_by->Visible) { // banned_by ?>
        <td <?= $Page->banned_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_banlist_banned_by" class="arrowchat_banlist_banned_by">
<span<?= $Page->banned_by->viewAttributes() ?>>
<?= $Page->banned_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->banned_time->Visible) { // banned_time ?>
        <td <?= $Page->banned_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_banlist_banned_time" class="arrowchat_banlist_banned_time">
<span<?= $Page->banned_time->viewAttributes() ?>>
<?= $Page->banned_time->getViewValue() ?></span>
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
