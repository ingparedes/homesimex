<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomRoomsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_roomsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    farrowchat_chatroom_roomsdelete = currentForm = new ew.Form("farrowchat_chatroom_roomsdelete", "delete");
    loadjs.done("farrowchat_chatroom_roomsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.arrowchat_chatroom_rooms) ew.vars.tables.arrowchat_chatroom_rooms = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_rooms")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_chatroom_roomsdelete" id="farrowchat_chatroom_roomsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_rooms">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_id" class="arrowchat_chatroom_rooms_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->author_id->Visible) { // author_id ?>
        <th class="<?= $Page->author_id->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_author_id" class="arrowchat_chatroom_rooms_author_id"><?= $Page->author_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_name" class="arrowchat_chatroom_rooms_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <th class="<?= $Page->description->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_description" class="arrowchat_chatroom_rooms_description"><?= $Page->description->caption() ?></span></th>
<?php } ?>
<?php if ($Page->welcome_message->Visible) { // welcome_message ?>
        <th class="<?= $Page->welcome_message->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_welcome_message" class="arrowchat_chatroom_rooms_welcome_message"><?= $Page->welcome_message->caption() ?></span></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th class="<?= $Page->image->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_image" class="arrowchat_chatroom_rooms_image"><?= $Page->image->caption() ?></span></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th class="<?= $Page->type->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_type" class="arrowchat_chatroom_rooms_type"><?= $Page->type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <th class="<?= $Page->_password->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms__password" class="arrowchat_chatroom_rooms__password"><?= $Page->_password->caption() ?></span></th>
<?php } ?>
<?php if ($Page->length->Visible) { // length ?>
        <th class="<?= $Page->length->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_length" class="arrowchat_chatroom_rooms_length"><?= $Page->length->caption() ?></span></th>
<?php } ?>
<?php if ($Page->is_featured->Visible) { // is_featured ?>
        <th class="<?= $Page->is_featured->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_is_featured" class="arrowchat_chatroom_rooms_is_featured"><?= $Page->is_featured->caption() ?></span></th>
<?php } ?>
<?php if ($Page->max_users->Visible) { // max_users ?>
        <th class="<?= $Page->max_users->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_max_users" class="arrowchat_chatroom_rooms_max_users"><?= $Page->max_users->caption() ?></span></th>
<?php } ?>
<?php if ($Page->limit_message_num->Visible) { // limit_message_num ?>
        <th class="<?= $Page->limit_message_num->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_limit_message_num" class="arrowchat_chatroom_rooms_limit_message_num"><?= $Page->limit_message_num->caption() ?></span></th>
<?php } ?>
<?php if ($Page->limit_seconds_num->Visible) { // limit_seconds_num ?>
        <th class="<?= $Page->limit_seconds_num->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_limit_seconds_num" class="arrowchat_chatroom_rooms_limit_seconds_num"><?= $Page->limit_seconds_num->caption() ?></span></th>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
        <th class="<?= $Page->session_time->headerCellClass() ?>"><span id="elh_arrowchat_chatroom_rooms_session_time" class="arrowchat_chatroom_rooms_session_time"><?= $Page->session_time->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_id" class="arrowchat_chatroom_rooms_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->author_id->Visible) { // author_id ?>
        <td <?= $Page->author_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_author_id" class="arrowchat_chatroom_rooms_author_id">
<span<?= $Page->author_id->viewAttributes() ?>>
<?= $Page->author_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_name" class="arrowchat_chatroom_rooms_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <td <?= $Page->description->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_description" class="arrowchat_chatroom_rooms_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->welcome_message->Visible) { // welcome_message ?>
        <td <?= $Page->welcome_message->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_welcome_message" class="arrowchat_chatroom_rooms_welcome_message">
<span<?= $Page->welcome_message->viewAttributes() ?>>
<?= $Page->welcome_message->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <td <?= $Page->image->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_image" class="arrowchat_chatroom_rooms_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= $Page->image->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <td <?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_type" class="arrowchat_chatroom_rooms_type">
<span<?= $Page->type->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_type_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->type->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->type->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_type_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <td <?= $Page->_password->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms__password" class="arrowchat_chatroom_rooms__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->length->Visible) { // length ?>
        <td <?= $Page->length->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_length" class="arrowchat_chatroom_rooms_length">
<span<?= $Page->length->viewAttributes() ?>>
<?= $Page->length->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->is_featured->Visible) { // is_featured ?>
        <td <?= $Page->is_featured->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_is_featured" class="arrowchat_chatroom_rooms_is_featured">
<span<?= $Page->is_featured->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_featured_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_featured->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_featured->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_featured_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->max_users->Visible) { // max_users ?>
        <td <?= $Page->max_users->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_max_users" class="arrowchat_chatroom_rooms_max_users">
<span<?= $Page->max_users->viewAttributes() ?>>
<?= $Page->max_users->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->limit_message_num->Visible) { // limit_message_num ?>
        <td <?= $Page->limit_message_num->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_limit_message_num" class="arrowchat_chatroom_rooms_limit_message_num">
<span<?= $Page->limit_message_num->viewAttributes() ?>>
<?= $Page->limit_message_num->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->limit_seconds_num->Visible) { // limit_seconds_num ?>
        <td <?= $Page->limit_seconds_num->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_limit_seconds_num" class="arrowchat_chatroom_rooms_limit_seconds_num">
<span<?= $Page->limit_seconds_num->viewAttributes() ?>>
<?= $Page->limit_seconds_num->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
        <td <?= $Page->session_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_session_time" class="arrowchat_chatroom_rooms_session_time">
<span<?= $Page->session_time->viewAttributes() ?>>
<?= $Page->session_time->getViewValue() ?></span>
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
