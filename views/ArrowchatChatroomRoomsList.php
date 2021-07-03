<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomRoomsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_roomslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    farrowchat_chatroom_roomslist = currentForm = new ew.Form("farrowchat_chatroom_roomslist", "list");
    farrowchat_chatroom_roomslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("farrowchat_chatroom_roomslist");
});
var farrowchat_chatroom_roomslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    farrowchat_chatroom_roomslistsrch = currentSearchForm = new ew.Form("farrowchat_chatroom_roomslistsrch");

    // Dynamic selection lists

    // Filters
    farrowchat_chatroom_roomslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("farrowchat_chatroom_roomslistsrch");
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
<form name="farrowchat_chatroom_roomslistsrch" id="farrowchat_chatroom_roomslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="farrowchat_chatroom_roomslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="arrowchat_chatroom_rooms">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> arrowchat_chatroom_rooms">
<form name="farrowchat_chatroom_roomslist" id="farrowchat_chatroom_roomslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_rooms">
<div id="gmp_arrowchat_chatroom_rooms" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_arrowchat_chatroom_roomslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_id" class="arrowchat_chatroom_rooms_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->author_id->Visible) { // author_id ?>
        <th data-name="author_id" class="<?= $Page->author_id->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_author_id" class="arrowchat_chatroom_rooms_author_id"><?= $Page->renderSort($Page->author_id) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_name" class="arrowchat_chatroom_rooms_name"><?= $Page->renderSort($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <th data-name="description" class="<?= $Page->description->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_description" class="arrowchat_chatroom_rooms_description"><?= $Page->renderSort($Page->description) ?></div></th>
<?php } ?>
<?php if ($Page->welcome_message->Visible) { // welcome_message ?>
        <th data-name="welcome_message" class="<?= $Page->welcome_message->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_welcome_message" class="arrowchat_chatroom_rooms_welcome_message"><?= $Page->renderSort($Page->welcome_message) ?></div></th>
<?php } ?>
<?php if ($Page->image->Visible) { // image ?>
        <th data-name="image" class="<?= $Page->image->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_image" class="arrowchat_chatroom_rooms_image"><?= $Page->renderSort($Page->image) ?></div></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th data-name="type" class="<?= $Page->type->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_type" class="arrowchat_chatroom_rooms_type"><?= $Page->renderSort($Page->type) ?></div></th>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <th data-name="_password" class="<?= $Page->_password->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms__password" class="arrowchat_chatroom_rooms__password"><?= $Page->renderSort($Page->_password) ?></div></th>
<?php } ?>
<?php if ($Page->length->Visible) { // length ?>
        <th data-name="length" class="<?= $Page->length->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_length" class="arrowchat_chatroom_rooms_length"><?= $Page->renderSort($Page->length) ?></div></th>
<?php } ?>
<?php if ($Page->is_featured->Visible) { // is_featured ?>
        <th data-name="is_featured" class="<?= $Page->is_featured->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_is_featured" class="arrowchat_chatroom_rooms_is_featured"><?= $Page->renderSort($Page->is_featured) ?></div></th>
<?php } ?>
<?php if ($Page->max_users->Visible) { // max_users ?>
        <th data-name="max_users" class="<?= $Page->max_users->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_max_users" class="arrowchat_chatroom_rooms_max_users"><?= $Page->renderSort($Page->max_users) ?></div></th>
<?php } ?>
<?php if ($Page->limit_message_num->Visible) { // limit_message_num ?>
        <th data-name="limit_message_num" class="<?= $Page->limit_message_num->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_limit_message_num" class="arrowchat_chatroom_rooms_limit_message_num"><?= $Page->renderSort($Page->limit_message_num) ?></div></th>
<?php } ?>
<?php if ($Page->limit_seconds_num->Visible) { // limit_seconds_num ?>
        <th data-name="limit_seconds_num" class="<?= $Page->limit_seconds_num->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_limit_seconds_num" class="arrowchat_chatroom_rooms_limit_seconds_num"><?= $Page->renderSort($Page->limit_seconds_num) ?></div></th>
<?php } ?>
<?php if ($Page->session_time->Visible) { // session_time ?>
        <th data-name="session_time" class="<?= $Page->session_time->headerCellClass() ?>"><div id="elh_arrowchat_chatroom_rooms_session_time" class="arrowchat_chatroom_rooms_session_time"><?= $Page->renderSort($Page->session_time) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_arrowchat_chatroom_rooms", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->author_id->Visible) { // author_id ?>
        <td data-name="author_id" <?= $Page->author_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_author_id">
<span<?= $Page->author_id->viewAttributes() ?>>
<?= $Page->author_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->description->Visible) { // description ?>
        <td data-name="description" <?= $Page->description->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->welcome_message->Visible) { // welcome_message ?>
        <td data-name="welcome_message" <?= $Page->welcome_message->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_welcome_message">
<span<?= $Page->welcome_message->viewAttributes() ?>>
<?= $Page->welcome_message->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->image->Visible) { // image ?>
        <td data-name="image" <?= $Page->image->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_image">
<span<?= $Page->image->viewAttributes() ?>>
<?= $Page->image->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->type->Visible) { // type ?>
        <td data-name="type" <?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_type">
<span<?= $Page->type->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_type_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->type->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->type->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_type_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_password->Visible) { // password ?>
        <td data-name="_password" <?= $Page->_password->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->length->Visible) { // length ?>
        <td data-name="length" <?= $Page->length->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_length">
<span<?= $Page->length->viewAttributes() ?>>
<?= $Page->length->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->is_featured->Visible) { // is_featured ?>
        <td data-name="is_featured" <?= $Page->is_featured->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_is_featured">
<span<?= $Page->is_featured->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_is_featured_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->is_featured->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->is_featured->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_is_featured_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->max_users->Visible) { // max_users ?>
        <td data-name="max_users" <?= $Page->max_users->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_max_users">
<span<?= $Page->max_users->viewAttributes() ?>>
<?= $Page->max_users->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->limit_message_num->Visible) { // limit_message_num ?>
        <td data-name="limit_message_num" <?= $Page->limit_message_num->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_limit_message_num">
<span<?= $Page->limit_message_num->viewAttributes() ?>>
<?= $Page->limit_message_num->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->limit_seconds_num->Visible) { // limit_seconds_num ?>
        <td data-name="limit_seconds_num" <?= $Page->limit_seconds_num->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_limit_seconds_num">
<span<?= $Page->limit_seconds_num->viewAttributes() ?>>
<?= $Page->limit_seconds_num->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->session_time->Visible) { // session_time ?>
        <td data-name="session_time" <?= $Page->session_time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_arrowchat_chatroom_rooms_session_time">
<span<?= $Page->session_time->viewAttributes() ?>>
<?= $Page->session_time->getViewValue() ?></span>
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
    ew.addEventHandlers("arrowchat_chatroom_rooms");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
