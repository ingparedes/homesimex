<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatBanlistAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_banlistadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchat_banlistadd = currentForm = new ew.Form("farrowchat_banlistadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_banlist")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_banlist)
        ew.vars.tables.arrowchat_banlist = currentTable;
    farrowchat_banlistadd.addFields([
        ["ban_userid", [fields.ban_userid.visible && fields.ban_userid.required ? ew.Validators.required(fields.ban_userid.caption) : null], fields.ban_userid.isInvalid],
        ["ban_ip", [fields.ban_ip.visible && fields.ban_ip.required ? ew.Validators.required(fields.ban_ip.caption) : null], fields.ban_ip.isInvalid],
        ["banned_by", [fields.banned_by.visible && fields.banned_by.required ? ew.Validators.required(fields.banned_by.caption) : null], fields.banned_by.isInvalid],
        ["banned_time", [fields.banned_time.visible && fields.banned_time.required ? ew.Validators.required(fields.banned_time.caption) : null, ew.Validators.integer], fields.banned_time.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_banlistadd,
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
    farrowchat_banlistadd.validate = function () {
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
    farrowchat_banlistadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_banlistadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("farrowchat_banlistadd");
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
<form name="farrowchat_banlistadd" id="farrowchat_banlistadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_banlist">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->ban_userid->Visible) { // ban_userid ?>
    <div id="r_ban_userid" class="form-group row">
        <label id="elh_arrowchat_banlist_ban_userid" for="x_ban_userid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ban_userid->caption() ?><?= $Page->ban_userid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ban_userid->cellAttributes() ?>>
<span id="el_arrowchat_banlist_ban_userid">
<input type="<?= $Page->ban_userid->getInputTextType() ?>" data-table="arrowchat_banlist" data-field="x_ban_userid" name="x_ban_userid" id="x_ban_userid" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->ban_userid->getPlaceHolder()) ?>" value="<?= $Page->ban_userid->EditValue ?>"<?= $Page->ban_userid->editAttributes() ?> aria-describedby="x_ban_userid_help">
<?= $Page->ban_userid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ban_userid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ban_ip->Visible) { // ban_ip ?>
    <div id="r_ban_ip" class="form-group row">
        <label id="elh_arrowchat_banlist_ban_ip" for="x_ban_ip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ban_ip->caption() ?><?= $Page->ban_ip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ban_ip->cellAttributes() ?>>
<span id="el_arrowchat_banlist_ban_ip">
<input type="<?= $Page->ban_ip->getInputTextType() ?>" data-table="arrowchat_banlist" data-field="x_ban_ip" name="x_ban_ip" id="x_ban_ip" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ban_ip->getPlaceHolder()) ?>" value="<?= $Page->ban_ip->EditValue ?>"<?= $Page->ban_ip->editAttributes() ?> aria-describedby="x_ban_ip_help">
<?= $Page->ban_ip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ban_ip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->banned_by->Visible) { // banned_by ?>
    <div id="r_banned_by" class="form-group row">
        <label id="elh_arrowchat_banlist_banned_by" for="x_banned_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->banned_by->caption() ?><?= $Page->banned_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->banned_by->cellAttributes() ?>>
<span id="el_arrowchat_banlist_banned_by">
<input type="<?= $Page->banned_by->getInputTextType() ?>" data-table="arrowchat_banlist" data-field="x_banned_by" name="x_banned_by" id="x_banned_by" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->banned_by->getPlaceHolder()) ?>" value="<?= $Page->banned_by->EditValue ?>"<?= $Page->banned_by->editAttributes() ?> aria-describedby="x_banned_by_help">
<?= $Page->banned_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->banned_by->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->banned_time->Visible) { // banned_time ?>
    <div id="r_banned_time" class="form-group row">
        <label id="elh_arrowchat_banlist_banned_time" for="x_banned_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->banned_time->caption() ?><?= $Page->banned_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->banned_time->cellAttributes() ?>>
<span id="el_arrowchat_banlist_banned_time">
<input type="<?= $Page->banned_time->getInputTextType() ?>" data-table="arrowchat_banlist" data-field="x_banned_time" name="x_banned_time" id="x_banned_time" size="30" placeholder="<?= HtmlEncode($Page->banned_time->getPlaceHolder()) ?>" value="<?= $Page->banned_time->EditValue ?>"<?= $Page->banned_time->editAttributes() ?> aria-describedby="x_banned_time_help">
<?= $Page->banned_time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->banned_time->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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
    ew.addEventHandlers("arrowchat_banlist");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
