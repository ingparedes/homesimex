<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatGraphLogDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_graph_logdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_graph_logdelete = currentForm = new ew.Form("farrowchat_graph_logdelete", "delete");
    loadjs.done("farrowchat_graph_logdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_graph_log) ew.vars.tables.arrowchat_graph_log = <?= JsonEncode(GetClientVar("tables", "arrowchat_graph_log")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_graph_logdelete" id="farrowchat_graph_logdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_graph_log">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_graph_log_id" class="arrowchat_graph_log_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <th class="<?= $Page->date->headerCellClass() ?>"><span id="elh_arrowchat_graph_log_date" class="arrowchat_graph_log_date"><?= $Page->date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_messages->Visible) { // user_messages ?>
        <th class="<?= $Page->user_messages->headerCellClass() ?>"><span id="elh_arrowchat_graph_log_user_messages" class="arrowchat_graph_log_user_messages"><?= $Page->user_messages->caption() ?></span></th>
<?php } ?>
<?php if ($Page->chat_room_messages->Visible) { // chat_room_messages ?>
        <th class="<?= $Page->chat_room_messages->headerCellClass() ?>"><span id="elh_arrowchat_graph_log_chat_room_messages" class="arrowchat_graph_log_chat_room_messages"><?= $Page->chat_room_messages->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_arrowchat_graph_log_id" class="arrowchat_graph_log_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <td <?= $Page->date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_graph_log_date" class="arrowchat_graph_log_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user_messages->Visible) { // user_messages ?>
        <td <?= $Page->user_messages->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_graph_log_user_messages" class="arrowchat_graph_log_user_messages">
<span<?= $Page->user_messages->viewAttributes() ?>>
<?= $Page->user_messages->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->chat_room_messages->Visible) { // chat_room_messages ?>
        <td <?= $Page->chat_room_messages->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_graph_log_chat_room_messages" class="arrowchat_graph_log_chat_room_messages">
<span<?= $Page->chat_room_messages->viewAttributes() ?>>
<?= $Page->chat_room_messages->getViewValue() ?></span>
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
