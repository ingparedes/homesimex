<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatChatroomBanlistEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_chatroom_banlistedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    farrowchat_chatroom_banlistedit = currentForm = new ew.Form("farrowchat_chatroom_banlistedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_chatroom_banlist")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_chatroom_banlist)
        ew.vars.tables.arrowchat_chatroom_banlist = currentTable;
    farrowchat_chatroom_banlistedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null], fields.user_id.isInvalid],
        ["chatroom_id", [fields.chatroom_id.visible && fields.chatroom_id.required ? ew.Validators.required(fields.chatroom_id.caption) : null, ew.Validators.integer], fields.chatroom_id.isInvalid],
        ["ban_length", [fields.ban_length.visible && fields.ban_length.required ? ew.Validators.required(fields.ban_length.caption) : null, ew.Validators.integer], fields.ban_length.isInvalid],
        ["ban_time", [fields.ban_time.visible && fields.ban_time.required ? ew.Validators.required(fields.ban_time.caption) : null, ew.Validators.integer], fields.ban_time.isInvalid],
        ["ip_address", [fields.ip_address.visible && fields.ip_address.required ? ew.Validators.required(fields.ip_address.caption) : null], fields.ip_address.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_chatroom_banlistedit,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    farrowchat_chatroom_banlistedit.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    farrowchat_chatroom_banlistedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_chatroom_banlistedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("farrowchat_chatroom_banlistedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farrowchat_chatroom_banlistedit" id="farrowchat_chatroom_banlistedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_chatroom_banlist">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_arrowchat_chatroom_banlist_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="arrowchat_chatroom_banlist" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <div id="r_user_id" class="form-group row">
        <label id="elh_arrowchat_chatroom_banlist_user_id" for="x_user_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_id->caption() ?><?= $Page->user_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_user_id">
<input type="<?= $Page->user_id->getInputTextType() ?>" data-table="arrowchat_chatroom_banlist" data-field="x_user_id" name="x_user_id" id="x_user_id" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->user_id->getPlaceHolder()) ?>" value="<?= $Page->user_id->EditValue ?>"<?= $Page->user_id->editAttributes() ?> aria-describedby="x_user_id_help">
<?= $Page->user_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chatroom_id->Visible) { // chatroom_id ?>
    <div id="r_chatroom_id" class="form-group row">
        <label id="elh_arrowchat_chatroom_banlist_chatroom_id" for="x_chatroom_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chatroom_id->caption() ?><?= $Page->chatroom_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->chatroom_id->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_chatroom_id">
<input type="<?= $Page->chatroom_id->getInputTextType() ?>" data-table="arrowchat_chatroom_banlist" data-field="x_chatroom_id" name="x_chatroom_id" id="x_chatroom_id" size="30" placeholder="<?= HtmlEncode($Page->chatroom_id->getPlaceHolder()) ?>" value="<?= $Page->chatroom_id->EditValue ?>"<?= $Page->chatroom_id->editAttributes() ?> aria-describedby="x_chatroom_id_help">
<?= $Page->chatroom_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->chatroom_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ban_length->Visible) { // ban_length ?>
    <div id="r_ban_length" class="form-group row">
        <label id="elh_arrowchat_chatroom_banlist_ban_length" for="x_ban_length" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ban_length->caption() ?><?= $Page->ban_length->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ban_length->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_ban_length">
<input type="<?= $Page->ban_length->getInputTextType() ?>" data-table="arrowchat_chatroom_banlist" data-field="x_ban_length" name="x_ban_length" id="x_ban_length" size="30" placeholder="<?= HtmlEncode($Page->ban_length->getPlaceHolder()) ?>" value="<?= $Page->ban_length->EditValue ?>"<?= $Page->ban_length->editAttributes() ?> aria-describedby="x_ban_length_help">
<?= $Page->ban_length->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ban_length->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ban_time->Visible) { // ban_time ?>
    <div id="r_ban_time" class="form-group row">
        <label id="elh_arrowchat_chatroom_banlist_ban_time" for="x_ban_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ban_time->caption() ?><?= $Page->ban_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ban_time->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_ban_time">
<input type="<?= $Page->ban_time->getInputTextType() ?>" data-table="arrowchat_chatroom_banlist" data-field="x_ban_time" name="x_ban_time" id="x_ban_time" size="30" placeholder="<?= HtmlEncode($Page->ban_time->getPlaceHolder()) ?>" value="<?= $Page->ban_time->EditValue ?>"<?= $Page->ban_time->editAttributes() ?> aria-describedby="x_ban_time_help">
<?= $Page->ban_time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ban_time->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ip_address->Visible) { // ip_address ?>
    <div id="r_ip_address" class="form-group row">
        <label id="elh_arrowchat_chatroom_banlist_ip_address" for="x_ip_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ip_address->caption() ?><?= $Page->ip_address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ip_address->cellAttributes() ?>>
<span id="el_arrowchat_chatroom_banlist_ip_address">
<input type="<?= $Page->ip_address->getInputTextType() ?>" data-table="arrowchat_chatroom_banlist" data-field="x_ip_address" name="x_ip_address" id="x_ip_address" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->ip_address->getPlaceHolder()) ?>" value="<?= $Page->ip_address->EditValue ?>"<?= $Page->ip_address->editAttributes() ?> aria-describedby="x_ip_address_help">
<?= $Page->ip_address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ip_address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("arrowchat_chatroom_banlist");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
