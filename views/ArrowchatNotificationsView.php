<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatNotificationsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_notificationsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_notificationsview = currentForm = new ew.Form("farrowchat_notificationsview", "view");
    loadjs.done("farrowchat_notificationsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_notifications) ew.vars.tables.arrowchat_notifications = <?= JsonEncode(GetClientVar("tables", "arrowchat_notifications")) ?>;
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
<form name="farrowchat_notificationsview" id="farrowchat_notificationsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_notifications">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_notifications_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->to_id->Visible) { // to_id ?>
    <tr id="r_to_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_to_id"><?= $Page->to_id->caption() ?></span></td>
        <td data-name="to_id" <?= $Page->to_id->cellAttributes() ?>>
<span id="el_arrowchat_notifications_to_id">
<span<?= $Page->to_id->viewAttributes() ?>>
<?= $Page->to_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->author_id->Visible) { // author_id ?>
    <tr id="r_author_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_author_id"><?= $Page->author_id->caption() ?></span></td>
        <td data-name="author_id" <?= $Page->author_id->cellAttributes() ?>>
<span id="el_arrowchat_notifications_author_id">
<span<?= $Page->author_id->viewAttributes() ?>>
<?= $Page->author_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->author_name->Visible) { // author_name ?>
    <tr id="r_author_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_author_name"><?= $Page->author_name->caption() ?></span></td>
        <td data-name="author_name" <?= $Page->author_name->cellAttributes() ?>>
<span id="el_arrowchat_notifications_author_name">
<span<?= $Page->author_name->viewAttributes() ?>>
<?= $Page->author_name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->misc1->Visible) { // misc1 ?>
    <tr id="r_misc1">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_misc1"><?= $Page->misc1->caption() ?></span></td>
        <td data-name="misc1" <?= $Page->misc1->cellAttributes() ?>>
<span id="el_arrowchat_notifications_misc1">
<span<?= $Page->misc1->viewAttributes() ?>>
<?= $Page->misc1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->misc2->Visible) { // misc2 ?>
    <tr id="r_misc2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_misc2"><?= $Page->misc2->caption() ?></span></td>
        <td data-name="misc2" <?= $Page->misc2->cellAttributes() ?>>
<span id="el_arrowchat_notifications_misc2">
<span<?= $Page->misc2->viewAttributes() ?>>
<?= $Page->misc2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->misc3->Visible) { // misc3 ?>
    <tr id="r_misc3">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_misc3"><?= $Page->misc3->caption() ?></span></td>
        <td data-name="misc3" <?= $Page->misc3->cellAttributes() ?>>
<span id="el_arrowchat_notifications_misc3">
<span<?= $Page->misc3->viewAttributes() ?>>
<?= $Page->misc3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <tr id="r_type">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_type"><?= $Page->type->caption() ?></span></td>
        <td data-name="type" <?= $Page->type->cellAttributes() ?>>
<span id="el_arrowchat_notifications_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alert_read->Visible) { // alert_read ?>
    <tr id="r_alert_read">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_alert_read"><?= $Page->alert_read->caption() ?></span></td>
        <td data-name="alert_read" <?= $Page->alert_read->cellAttributes() ?>>
<span id="el_arrowchat_notifications_alert_read">
<span<?= $Page->alert_read->viewAttributes() ?>>
<?= $Page->alert_read->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
    <tr id="r_user_read">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_user_read"><?= $Page->user_read->caption() ?></span></td>
        <td data-name="user_read" <?= $Page->user_read->cellAttributes() ?>>
<span id="el_arrowchat_notifications_user_read">
<span<?= $Page->user_read->viewAttributes() ?>>
<?= $Page->user_read->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alert_time->Visible) { // alert_time ?>
    <tr id="r_alert_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_notifications_alert_time"><?= $Page->alert_time->caption() ?></span></td>
        <td data-name="alert_time" <?= $Page->alert_time->cellAttributes() ?>>
<span id="el_arrowchat_notifications_alert_time">
<span<?= $Page->alert_time->viewAttributes() ?>>
<?= $Page->alert_time->getViewValue() ?></span>
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
