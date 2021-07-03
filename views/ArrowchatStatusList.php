<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatStatusList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_statuslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    farrowchat_statuslist = currentForm = new ew.Form("farrowchat_statuslist", "list");
    farrowchat_statuslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("farrowchat_statuslist");
});
var farrowchat_statuslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    farrowchat_statuslistsrch = currentSearchForm = new ew.Form("farrowchat_statuslistsrch");

    // Dynamic selection lists

    // Filters
    farrowchat_statuslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("farrowchat_statuslistsrch");
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
<form name="farrowchat_statuslistsrch" id="farrowchat_statuslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="farrowchat_statuslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="arrowchat_status">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> arrowchat_status">
<form name="farrowchat_statuslist" id="farrowchat_statuslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_status">
<div id="gmp_arrowchat_status" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_arrowchat_statuslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->_userid->Visible) { // userid ?>
        <th data-name="_userid" class="<?= $Page->_userid->headerCellClass() ?>"><div id="elh_arrowchat_status__userid" class="arrowchat_status__userid"><?= $Page->renderSort($Page->_userid) ?></div></th>
<?php } ?>
<?php if ($Page->guest_name->Visible) { // guest_name ?>
        <th data-name="guest_name" class="<?= $Page->guest_name->headerCellClass() ?>"><div id="elh_arrowchat_status_guest_name" class="arrowchat_status_guest_name"><?= $Page->renderSort($Page->guest_name) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_arrowchat_status_status" class="arrowchat_status_status"><?= $Page->renderSort($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->theme->Visible) { // theme ?>
        <th data-name="theme" class="<?= $Page->theme->headerCellClass() ?>"><div id="elh_arrowchat_status_theme" class="arrowchat_status_theme"><?= $Page->renderSort($Page->theme) ?></div></th>
<?php } ?>
<?php if ($Page->popout->Visible) { // popout ?>
        <th data-name="popout" class="<?= $Page->popout->headerCellClass() ?>"><div id="elh_arrowchat_status_popout" class="arrowchat_status_popout"><?= $Page->renderSort($Page->popout) ?></div></th>
<?php } ?>
<?php if ($Page->hide_bar->Visible) { // hide_bar ?>
        <th data-name="hide_bar" class="<?= $Page->hide_bar->headerCellClass() ?>"><div id="elh_arrowchat_status_hide_bar" class="arrowchat_status_hide_bar"><?= $Page->renderSort($Page->hide_bar) ?></div></th>
<?php } ?>
<?php if ($Page->play_sound->Visible) { // play_sound ?>
        <th data-name="play_sound" class="<?= $Page->play_sound->headerCellClass() ?>"><div id="elh_arrowchat_status_play_sound" class="arrowchat_status_play_sound"><?= $Page->renderSort($Page->play_sound) ?></div></th>
<?php } ?>
<?php if ($Page->window_open->Visible) { // window_open ?>
        <th data-name="window_open" class="<?= $Page->window_open->headerCellClass() ?>"><div id="elh_arrowchat_status_window_open" class="arrowchat_status_window_open"><?= $Page->renderSort($Page->window_open) ?></div></th>
<?php } ?>
<?php if ($Page->only_names->Visible) { // only_names ?>
        <th data-name="only_names" class="<?= $Page->only_names->headerCellClass() ?>"><div id="elh_arrowchat_status_only_names" class="arrowchat_status_only_names"><?= $Page->renderSort($Page->only_names) ?></div></th>
<?php } ?>
<?php if ($Page->chatroom_window->Visible) { // chatroom_window ?>
        <th data-name="chatroom_window" class="<?= $Page->chatroom_window->headerCellClass() ?>"><div id="elh_arrowchat_status_chatroom_window" class="arrowchat_status_chatroom_window"><?= $Page->renderSort($Page->chatroom_window) ?></div></th>
<?php } ?>
<?php if ($Page->chatroom_stay->Visible) { // chatroom_stay ?>
        <th data-name="chatroom_stay" class="<?= $Page->chatroom_stay->headerCellClass() ?>"><div id="elh_arrowchat_status_chatroom_stay" class="arrowchat_status_chatroom_stay"><?= $Page->renderSort($Page->chatroom_stay) ?></div></th>
<?php } ?>
<?php if ($Page->chatroom_show_names->Visible) { // chatroom_show_names ?>
        <th data-name="chatroom_show_names" class="<?= $Page->chatroom_show_names->headerCellClass() ?>"><div id="elh_arrowchat_status_chatroom_show_names" class="arrowchat_status_chatroom_show_names"><?= $Page->renderSort($Page->chatroom_show_names) ?></div></th>
<?php } ?>
<?php if ($Page->chatroom_block_chats->Visible) { // chatroom_block_chats ?>
        <th data-name="chatroom_block_chats" class="<?= $Page->chatroom_block_chats->headerCellClass() ?>"><div id="elh_arrowchat_status_chatroom_block_chats" class="arrowchat_status_chatroom_block_chats"><?= $Page->renderSort($Page->chatroom_block_chats) ?></div></th>
<?php } ?>
<?php if ($Page->chatroom_sound->Visible) { // chatroom_sound ?>
        <th data-name="chatroom_sound" class="<?= $Page->chatroom_sound->headerCellClass() ?>"><div id="elh_arrowchat_status_chatroom_sound" class="arrowchat_status_chatroom_sound"><?= $Page->renderSort($Page->chatroom_sound) ?></div></th>
<?php } ?>
<?php if ($Page->announcement->Visible) { // announcement ?>
        <th data-name="announcement" class="<?= $Page->announcement->headerCellClass() ?>"><div id="elh_arrowchat_status_announcement" class="arrowchat_status_announcement"><?= $Page->renderSort($Page->announcement) ?></div></th>
<?php } ?>
<?php if ($Page->focus_chat->Visible) { // focus_chat ?>
        <th data-name="focus_chat" class="<?= $Page->focus_chat->headerCellClass() ?>"><div id="elh_arrowchat_status_focus_chat" class="arrowchat_status_focus_chat"><?= $Page->renderSort($Page->focus_chat) ?></div></th>
<?php } ?>
<?php if ($Page->apps_open->Visible) { // apps_open ?>
        <th data-name="apps_open" class="<?= $Page->apps_open->headerCellClass() ?>"><div id="elh_arrowchat_status_apps_open" class="arrowchat_status_apps_open"><?= $Page->renderSort($Page->apps_open) ?></div></th>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
        <th data-name="session_time" class="<?= $Page->session_time->headerCellClass() ?>"><div id="elh_arrowchat_status_session_time" class="arrowchat_status_session_time"><?= $Page->renderSort($Page->session_time) ?></div></th>
<?php } ?>
<?php if ($Page->is_admin->Visible) { // is_admin ?>
        <th data-name="is_admin" class="<?= $Page->is_admin->headerCellClass() ?>"><div id="elh_arrowchat_status_is_admin" class="arrowchat_status_is_admin"><?= $Page->renderSort($Page->is_admin) ?></div></th>
<?php } ?>
<?php if ($Page->is_mod->Visible) { // is_mod ?>
        <th data-name="is_mod" class="<?= $Page->is_mod->headerCellClass() ?>"><div id="elh_arrowchat_status_is_mod" class="arrowchat_status_is_mod"><?= $Page->renderSort($Page->is_mod) ?></div></th>
<?php } ?>
<?php if ($Page->hash_id->Visible) { // hash_id ?>
        <th data-name="hash_id" class="<?= $Page->hash_id->headerCellClass() ?>"><div id="elh_arrowchat_status_hash_id" class="arrowchat_status_hash_id"><?= $Page->renderSort($Page->hash_id) ?></div></th>
<?php } ?>
<?php if ($Page->ip_address->Visible) { // ip_address ?>
        <th data-name="ip_address" class="<?= $Page->ip_address->headerCellClass() ?>"><div id="elh_arrowchat_status_ip_address" class="arrowchat_status_ip_address"><?= $Page->renderSort($Page->ip_address) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_arrowchat_status", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->_userid->Visible) { // userid ?>
        <td data-name="_userid" <?= $Page->_userid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status__userid">
<span<?= $Page->_userid->viewAttributes() ?>>
<?= $Page->_userid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->guest_name->Visible) { // guest_name ?>
        <td data-name="guest_name" <?= $Page->guest_name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_guest_name">
<span<?= $Page->guest_name->viewAttributes() ?>>
<?= $Page->guest_name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->theme->Visible) { // theme ?>
        <td data-name="theme" <?= $Page->theme->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_theme">
<span<?= $Page->theme->viewAttributes() ?>>
<?= $Page->theme->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->popout->Visible) { // popout ?>
        <td data-name="popout" <?= $Page->popout->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_popout">
<span<?= $Page->popout->viewAttributes() ?>>
<?= $Page->popout->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hide_bar->Visible) { // hide_bar ?>
        <td data-name="hide_bar" <?= $Page->hide_bar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_hide_bar">
<span<?= $Page->hide_bar->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_hide_bar_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->hide_bar->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->hide_bar->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_hide_bar_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->play_sound->Visible) { // play_sound ?>
        <td data-name="play_sound" <?= $Page->play_sound->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_play_sound">
<span<?= $Page->play_sound->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_play_sound_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->play_sound->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->play_sound->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_play_sound_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->window_open->Visible) { // window_open ?>
        <td data-name="window_open" <?= $Page->window_open->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_window_open">
<span<?= $Page->window_open->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_window_open_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->window_open->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->window_open->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_window_open_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->only_names->Visible) { // only_names ?>
        <td data-name="only_names" <?= $Page->only_names->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_only_names">
<span<?= $Page->only_names->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_only_names_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->only_names->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->only_names->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_only_names_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->chatroom_window->Visible) { // chatroom_window ?>
        <td data-name="chatroom_window" <?= $Page->chatroom_window->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_chatroom_window">
<span<?= $Page->chatroom_window->viewAttributes() ?>>
<?= $Page->chatroom_window->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->chatroom_stay->Visible) { // chatroom_stay ?>
        <td data-name="chatroom_stay" <?= $Page->chatroom_stay->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_chatroom_stay">
<span<?= $Page->chatroom_stay->viewAttributes() ?>>
<?= $Page->chatroom_stay->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->chatroom_show_names->Visible) { // chatroom_show_names ?>
        <td data-name="chatroom_show_names" <?= $Page->chatroom_show_names->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_chatroom_show_names">
<span<?= $Page->chatroom_show_names->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_chatroom_show_names_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->chatroom_show_names->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->chatroom_show_names->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_chatroom_show_names_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->chatroom_block_chats->Visible) { // chatroom_block_chats ?>
        <td data-name="chatroom_block_chats" <?= $Page->chatroom_block_chats->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_chatroom_block_chats">
<span<?= $Page->chatroom_block_chats->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_chatroom_block_chats_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->chatroom_block_chats->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->chatroom_block_chats->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_chatroom_block_chats_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->chatroom_sound->Visible) { // chatroom_sound ?>
        <td data-name="chatroom_sound" <?= $Page->chatroom_sound->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_chatroom_sound">
<span<?= $Page->chatroom_sound->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_chatroom_sound_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->chatroom_sound->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->chatroom_sound->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_chatroom_sound_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->announcement->Visible) { // announcement ?>
        <td data-name="announcement" <?= $Page->announcement->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_announcement">
<span<?= $Page->announcement->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_announcement_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->announcement->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->announcement->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_announcement_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->focus_chat->Visible) { // focus_chat ?>
        <td data-name="focus_chat" <?= $Page->focus_chat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_focus_chat">
<span<?= $Page->focus_chat->viewAttributes() ?>>
<?= $Page->focus_chat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apps_open->Visible) { // apps_open ?>
        <td data-name="apps_open" <?= $Page->apps_open->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_apps_open">
<span<?= $Page->apps_open->viewAttributes() ?>>
<?= $Page->apps_open->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->session_time->Visible) { // session_time ?>
        <td data-name="session_time" <?= $Page->session_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_session_time">
<span<?= $Page->session_time->viewAttributes() ?>>
<?= $Page->session_time->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->is_admin->Visible) { // is_admin ?>
        <td data-name="is_admin" <?= $Page->is_admin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_is_admin">
<span<?= $Page->is_admin->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_admin_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_admin->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_admin->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_admin_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->is_mod->Visible) { // is_mod ?>
        <td data-name="is_mod" <?= $Page->is_mod->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_is_mod">
<span<?= $Page->is_mod->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_mod_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_mod->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_mod->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_mod_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hash_id->Visible) { // hash_id ?>
        <td data-name="hash_id" <?= $Page->hash_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_hash_id">
<span<?= $Page->hash_id->viewAttributes() ?>>
<?= $Page->hash_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ip_address->Visible) { // ip_address ?>
        <td data-name="ip_address" <?= $Page->ip_address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_status_ip_address">
<span<?= $Page->ip_address->viewAttributes() ?>>
<?= $Page->ip_address->getViewValue() ?></span>
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
    ew.addEventHandlers("arrowchat_status");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
