<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatGraphLogView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_graph_logview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_graph_logview = currentForm = new ew.Form("farrowchat_graph_logview", "view");
    loadjs.done("farrowchat_graph_logview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_graph_log) ew.vars.tables.arrowchat_graph_log = <?= JsonEncode(GetClientVar("tables", "arrowchat_graph_log")) ?>;
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
<form name="farrowchat_graph_logview" id="farrowchat_graph_logview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_graph_log">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_graph_log_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_graph_log_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
    <tr id="r_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_graph_log_date"><?= $Page->date->caption() ?></span></td>
        <td data-name="date" <?= $Page->date->cellAttributes() ?>>
<span id="el_arrowchat_graph_log_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_messages->Visible) { // user_messages ?>
    <tr id="r_user_messages">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_graph_log_user_messages"><?= $Page->user_messages->caption() ?></span></td>
        <td data-name="user_messages" <?= $Page->user_messages->cellAttributes() ?>>
<span id="el_arrowchat_graph_log_user_messages">
<span<?= $Page->user_messages->viewAttributes() ?>>
<?= $Page->user_messages->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->chat_room_messages->Visible) { // chat_room_messages ?>
    <tr id="r_chat_room_messages">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_graph_log_chat_room_messages"><?= $Page->chat_room_messages->caption() ?></span></td>
        <td data-name="chat_room_messages" <?= $Page->chat_room_messages->cellAttributes() ?>>
<span id="el_arrowchat_graph_log_chat_room_messages">
<span<?= $Page->chat_room_messages->viewAttributes() ?>>
<?= $Page->chat_room_messages->getViewValue() ?></span>
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
