<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomMessagesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_messageslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    farrowchat_chatroom_messageslist = currentForm = new ew.Form("farrowchat_chatroom_messageslist", "list");
    farrowchat_chatroom_messageslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("farrowchat_chatroom_messageslist");
});
var farrowchat_chatroom_messageslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    farrowchat_chatroom_messageslistsrch = currentSearchForm = new ew.Form("farrowchat_chatroom_messageslistsrch");

    // Dynamic selection lists

    // Filters
    farrowchat_chatroom_messageslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("farrowchat_chatroom_messageslistsrch");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
    background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
    display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
    <div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
        <ul class="nav nav-tabs"></ul>
        <div class="tab-content"><!-- .tab-content -->
            <div class="tab-pane fade active show"></div>
        </div><!-- /.tab-content -->
    </div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
    ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "right" : "left";
    ew.PREVIEW_SINGLE_ROW = false;
    ew.PREVIEW_OVERLAY = false;
    loadjs(ew.PATH_BASE + "js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="farrowchat_chatroom_messageslistsrch" id="farrowchat_chatroom_messageslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="farrowchat_chatroom_messageslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="arrowchat_chatroom_messages">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> arrowchat_chatroom_messages">
<form name="farrowchat_chatroom_messageslist" id="farrowchat_chatroom_messageslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_messages">
<div id="gmp_arrowchat_chatroom_messages" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_arrowchat_chatroom_messageslist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_messages_id" class="arrowchat_chatroom_messages_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
        <th data-name="chatroom_id" class="<?= $Page->chatroom_id->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_messages_chatroom_id" class="arrowchat_chatroom_messages_chatroom_id"><?= $Page->renderSort($Page->chatroom_id) ?></div></th>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
        <th data-name="user_id" class="<?= $Page->user_id->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_messages_user_id" class="arrowchat_chatroom_messages_user_id"><?= $Page->renderSort($Page->user_id) ?></div></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th data-name="_username" class="<?= $Page->_username->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_messages__username" class="arrowchat_chatroom_messages__username"><?= $Page->renderSort($Page->_username) ?></div></th>
<?php } ?>
<?php if ($Page->global_message->Visible) { // global_message ?>
        <th data-name="global_message" class="<?= $Page->global_message->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_messages_global_message" class="arrowchat_chatroom_messages_global_message"><?= $Page->renderSort($Page->global_message) ?></div></th>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
        <th data-name="is_mod" class="<?= $Page->is_mod->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_messages_is_mod" class="arrowchat_chatroom_messages_is_mod"><?= $Page->renderSort($Page->is_mod) ?></div></th>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
        <th data-name="is_admin" class="<?= $Page->is_admin->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_messages_is_admin" class="arrowchat_chatroom_messages_is_admin"><?= $Page->renderSort($Page->is_admin) ?></div></th>
<?php } ?>
<?php if ($Page->sent->Visible) { // sent ?>
        <th data-name="sent" class="<?= $Page->sent->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_messages_sent" class="arrowchat_chatroom_messages_sent"><?= $Page->renderSort($Page->sent) ?></div></th>
<?php } ?>
<?php if ($Page->_action->Visible) { // action ?>
        <th data-name="_action" class="<?= $Page->_action->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_messages__action" class="arrowchat_chatroom_messages__action"><?= $Page->renderSort($Page->_action) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_arrowchat_chatroom_messages", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
        <td data-name="chatroom_id" <?= $Page->chatroom_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_chatroom_id">
<span<?= $Page->chatroom_id->viewAttributes() ?>>
<?= $Page->chatroom_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->user_id->Visible) { // user_id ?>
        <td data-name="user_id" <?= $Page->user_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_username->Visible) { // username ?>
        <td data-name="_username" <?= $Page->_username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->global_message->Visible) { // global_message ?>
        <td data-name="global_message" <?= $Page->global_message->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_global_message">
<span<?= $Page->global_message->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_global_message_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->global_message->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->global_message->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_global_message_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->is_mod->Visible) { // is_mod ?>
        <td data-name="is_mod" <?= $Page->is_mod->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_is_mod">
<span<?= $Page->is_mod->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_mod_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_mod->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_mod->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_mod_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->is_admin->Visible) { // is_admin ?>
        <td data-name="is_admin" <?= $Page->is_admin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_is_admin">
<span<?= $Page->is_admin->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_admin_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_admin->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_admin->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_admin_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sent->Visible) { // sent ?>
        <td data-name="sent" <?= $Page->sent->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages_sent">
<span<?= $Page->sent->viewAttributes() ?>>
<?= $Page->sent->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_action->Visible) { // action ?>
        <td data-name="_action" <?= $Page->_action->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_messages__action">
<span<?= $Page->_action->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x__action_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->_action->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->_action->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x__action_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("arrowchat_chatroom_messages");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
