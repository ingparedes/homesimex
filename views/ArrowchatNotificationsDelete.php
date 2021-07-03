<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatNotificationsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_notificationsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_notificationsdelete = currentForm = new ew.Form("farrowchat_notificationsdelete", "delete");
    loadjs.done("farrowchat_notificationsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_notifications) ew.vars.tables.arrowchat_notifications = <?= JsonEncode(GetClientVar("tables", "arrowchat_notifications")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_notificationsdelete" id="farrowchat_notificationsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_notifications">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_notifications_id" class="arrowchat_notifications_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->to_id->Visible) { // to_id ?>
        <th class="<?= $Page->to_id->headerCellClass() ?>"><span id="elh_arrowchat_notifications_to_id" class="arrowchat_notifications_to_id"><?= $Page->to_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->author_id->Visible) { // author_id ?>
        <th class="<?= $Page->author_id->headerCellClass() ?>"><span id="elh_arrowchat_notifications_author_id" class="arrowchat_notifications_author_id"><?= $Page->author_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->author_name->Visible) { // author_name ?>
        <th class="<?= $Page->author_name->headerCellClass() ?>"><span id="elh_arrowchat_notifications_author_name" class="arrowchat_notifications_author_name"><?= $Page->author_name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->misc1->Visible) { // misc1 ?>
        <th class="<?= $Page->misc1->headerCellClass() ?>"><span id="elh_arrowchat_notifications_misc1" class="arrowchat_notifications_misc1"><?= $Page->misc1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->misc2->Visible) { // misc2 ?>
        <th class="<?= $Page->misc2->headerCellClass() ?>"><span id="elh_arrowchat_notifications_misc2" class="arrowchat_notifications_misc2"><?= $Page->misc2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->misc3->Visible) { // misc3 ?>
        <th class="<?= $Page->misc3->headerCellClass() ?>"><span id="elh_arrowchat_notifications_misc3" class="arrowchat_notifications_misc3"><?= $Page->misc3->caption() ?></span></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th class="<?= $Page->type->headerCellClass() ?>"><span id="elh_arrowchat_notifications_type" class="arrowchat_notifications_type"><?= $Page->type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alert_read->Visible) { // alert_read ?>
        <th class="<?= $Page->alert_read->headerCellClass() ?>"><span id="elh_arrowchat_notifications_alert_read" class="arrowchat_notifications_alert_read"><?= $Page->alert_read->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
        <th class="<?= $Page->user_read->headerCellClass() ?>"><span id="elh_arrowchat_notifications_user_read" class="arrowchat_notifications_user_read"><?= $Page->user_read->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alert_time->Visible) { // alert_time ?>
        <th class="<?= $Page->alert_time->headerCellClass() ?>"><span id="elh_arrowchat_notifications_alert_time" class="arrowchat_notifications_alert_time"><?= $Page->alert_time->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_id" class="arrowchat_notifications_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->to_id->Visible) { // to_id ?>
        <td <?= $Page->to_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_to_id" class="arrowchat_notifications_to_id">
<span<?= $Page->to_id->viewAttributes() ?>>
<?= $Page->to_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->author_id->Visible) { // author_id ?>
        <td <?= $Page->author_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_author_id" class="arrowchat_notifications_author_id">
<span<?= $Page->author_id->viewAttributes() ?>>
<?= $Page->author_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->author_name->Visible) { // author_name ?>
        <td <?= $Page->author_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_author_name" class="arrowchat_notifications_author_name">
<span<?= $Page->author_name->viewAttributes() ?>>
<?= $Page->author_name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->misc1->Visible) { // misc1 ?>
        <td <?= $Page->misc1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_misc1" class="arrowchat_notifications_misc1">
<span<?= $Page->misc1->viewAttributes() ?>>
<?= $Page->misc1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->misc2->Visible) { // misc2 ?>
        <td <?= $Page->misc2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_misc2" class="arrowchat_notifications_misc2">
<span<?= $Page->misc2->viewAttributes() ?>>
<?= $Page->misc2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->misc3->Visible) { // misc3 ?>
        <td <?= $Page->misc3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_misc3" class="arrowchat_notifications_misc3">
<span<?= $Page->misc3->viewAttributes() ?>>
<?= $Page->misc3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <td <?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_type" class="arrowchat_notifications_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alert_read->Visible) { // alert_read ?>
        <td <?= $Page->alert_read->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_alert_read" class="arrowchat_notifications_alert_read">
<span<?= $Page->alert_read->viewAttributes() ?>>
<?= $Page->alert_read->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
        <td <?= $Page->user_read->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_user_read" class="arrowchat_notifications_user_read">
<span<?= $Page->user_read->viewAttributes() ?>>
<?= $Page->user_read->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alert_time->Visible) { // alert_time ?>
        <td <?= $Page->alert_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_notifications_alert_time" class="arrowchat_notifications_alert_time">
<span<?= $Page->alert_time->viewAttributes() ?>>
<?= $Page->alert_time->getViewValue() ?></span>
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
