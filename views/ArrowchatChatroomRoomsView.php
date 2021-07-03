<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomRoomsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_roomsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farrowchat_chatroom_roomsview = currentForm = new ew.Form("farrowchat_chatroom_roomsview", "view");
    loadjs.done("farrowchat_chatroom_roomsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.arrowchat_chatroom_rooms) ew.vars.tables.arrowchat_chatroom_rooms = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_rooms")) ?>;
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
<form name="farrowchat_chatroom_roomsview" id="farrowchat_chatroom_roomsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_rooms">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->author_id->Visible) { // author_id ?>
    <tr id="r_author_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_author_id"><?= $Page->author_id->caption() ?></span></td>
        <td data-name="author_id" <?= $Page->author_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_author_id">
<span<?= $Page->author_id->viewAttributes() ?>>
<?= $Page->author_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description" <?= $Page->description->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->welcome_message->Visible) { // welcome_message ?>
    <tr id="r_welcome_message">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_welcome_message"><?= $Page->welcome_message->caption() ?></span></td>
        <td data-name="welcome_message" <?= $Page->welcome_message->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_welcome_message">
<span<?= $Page->welcome_message->viewAttributes() ?>>
<?= $Page->welcome_message->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
    <tr id="r_image">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_image"><?= $Page->image->caption() ?></span></td>
        <td data-name="image" <?= $Page->image->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= $Page->image->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <tr id="r_type">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_type"><?= $Page->type->caption() ?></span></td>
        <td data-name="type" <?= $Page->type->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_type">
<span<?= $Page->type->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_type_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->type->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->type->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_type_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <tr id="r__password">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms__password"><?= $Page->_password->caption() ?></span></td>
        <td data-name="_password" <?= $Page->_password->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->length->Visible) { // length ?>
    <tr id="r_length">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_length"><?= $Page->length->caption() ?></span></td>
        <td data-name="length" <?= $Page->length->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_length">
<span<?= $Page->length->viewAttributes() ?>>
<?= $Page->length->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->is_featured->Visible) { // is_featured ?>
    <tr id="r_is_featured">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_is_featured"><?= $Page->is_featured->caption() ?></span></td>
        <td data-name="is_featured" <?= $Page->is_featured->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_is_featured">
<span<?= $Page->is_featured->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_featured_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_featured->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_featured->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_featured_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->max_users->Visible) { // max_users ?>
    <tr id="r_max_users">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_max_users"><?= $Page->max_users->caption() ?></span></td>
        <td data-name="max_users" <?= $Page->max_users->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_max_users">
<span<?= $Page->max_users->viewAttributes() ?>>
<?= $Page->max_users->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->limit_message_num->Visible) { // limit_message_num ?>
    <tr id="r_limit_message_num">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_limit_message_num"><?= $Page->limit_message_num->caption() ?></span></td>
        <td data-name="limit_message_num" <?= $Page->limit_message_num->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_limit_message_num">
<span<?= $Page->limit_message_num->viewAttributes() ?>>
<?= $Page->limit_message_num->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->limit_seconds_num->Visible) { // limit_seconds_num ?>
    <tr id="r_limit_seconds_num">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_limit_seconds_num"><?= $Page->limit_seconds_num->caption() ?></span></td>
        <td data-name="limit_seconds_num" <?= $Page->limit_seconds_num->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_limit_seconds_num">
<span<?= $Page->limit_seconds_num->viewAttributes() ?>>
<?= $Page->limit_seconds_num->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->disallowed_groups->Visible) { // disallowed_groups ?>
    <tr id="r_disallowed_groups">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_disallowed_groups"><?= $Page->disallowed_groups->caption() ?></span></td>
        <td data-name="disallowed_groups" <?= $Page->disallowed_groups->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_disallowed_groups">
<span<?= $Page->disallowed_groups->viewAttributes() ?>>
<?= $Page->disallowed_groups->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
    <tr id="r_session_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_arrowchat_chatroom_rooms_session_time"><?= $Page->session_time->caption() ?></span></td>
        <td data-name="session_time" <?= $Page->session_time->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_rooms_session_time">
<span<?= $Page->session_time->viewAttributes() ?>>
<?= $Page->session_time->getViewValue() ?></span>
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
