<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchatadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchatadd = currentForm = new ew.Form("farrowchatadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat)
        ew.vars.tables.arrowchat = currentTable;
    farrowchatadd.addFields([
        ["_from", [fields._from.visible && fields._from.required ? ew.Validators.required(fields._from.caption) : null], fields._from.isInvalid],
        ["to", [fields.to.visible && fields.to.required ? ew.Validators.required(fields.to.caption) : null], fields.to.isInvalid],
        ["message", [fields.message.visible && fields.message.required ? ew.Validators.required(fields.message.caption) : null], fields.message.isInvalid],
        ["sent", [fields.sent.visible && fields.sent.required ? ew.Validators.required(fields.sent.caption) : null, ew.Validators.integer], fields.sent.isInvalid],
        ["read", [fields.read.visible && fields.read.required ? ew.Validators.required(fields.read.caption) : null, ew.Validators.integer], fields.read.isInvalid],
        ["user_read", [fields.user_read.visible && fields.user_read.required ? ew.Validators.required(fields.user_read.caption) : null], fields.user_read.isInvalid],
        ["direction", [fields.direction.visible && fields.direction.required ? ew.Validators.required(fields.direction.caption) : null, ew.Validators.integer], fields.direction.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchatadd,
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
    farrowchatadd.validate = function () {
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
    farrowchatadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchatadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farrowchatadd.lists.user_read = <?= $Page->user_read->toClientList($Page) ?>;
    loadjs.done("farrowchatadd");
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
<form name="farrowchatadd" id="farrowchatadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->_from->Visible) { // from ?>
    <div id="r__from" class="form-group row">
        <label id="elh_arrowchat__from" for="x__from" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_from->caption() ?><?= $Page->_from->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_from->cellAttributes() ?>>
<span id="el_arrowchat__from">
<input type="<?= $Page->_from->getInputTextType() ?>" data-table="arrowchat" data-field="x__from" name="x__from" id="x__from" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->_from->getPlaceHolder()) ?>" value="<?= $Page->_from->EditValue ?>"<?= $Page->_from->editAttributes() ?> aria-describedby="x__from_help">
<?= $Page->_from->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_from->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->to->Visible) { // to ?>
    <div id="r_to" class="form-group row">
        <label id="elh_arrowchat_to" for="x_to" class="<?= $Page->LeftColumnClass ?>"><?= $Page->to->caption() ?><?= $Page->to->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->to->cellAttributes() ?>>
<span id="el_arrowchat_to">
<input type="<?= $Page->to->getInputTextType() ?>" data-table="arrowchat" data-field="x_to" name="x_to" id="x_to" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->to->getPlaceHolder()) ?>" value="<?= $Page->to->EditValue ?>"<?= $Page->to->editAttributes() ?> aria-describedby="x_to_help">
<?= $Page->to->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->to->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->message->Visible) { // message ?>
    <div id="r_message" class="form-group row">
        <label id="elh_arrowchat_message" for="x_message" class="<?= $Page->LeftColumnClass ?>"><?= $Page->message->caption() ?><?= $Page->message->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->message->cellAttributes() ?>>
<span id="el_arrowchat_message">
<textarea data-table="arrowchat" data-field="x_message" name="x_message" id="x_message" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->message->getPlaceHolder()) ?>"<?= $Page->message->editAttributes() ?> aria-describedby="x_message_help"><?= $Page->message->EditValue ?></textarea>
<?= $Page->message->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->message->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sent->Visible) { // sent ?>
    <div id="r_sent" class="form-group row">
        <label id="elh_arrowchat_sent" for="x_sent" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sent->caption() ?><?= $Page->sent->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sent->cellAttributes() ?>>
<span id="el_arrowchat_sent">
<input type="<?= $Page->sent->getInputTextType() ?>" data-table="arrowchat" data-field="x_sent" name="x_sent" id="x_sent" size="30" placeholder="<?= HtmlEncode($Page->sent->getPlaceHolder()) ?>" value="<?= $Page->sent->EditValue ?>"<?= $Page->sent->editAttributes() ?> aria-describedby="x_sent_help">
<?= $Page->sent->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sent->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->read->Visible) { // read ?>
    <div id="r_read" class="form-group row">
        <label id="elh_arrowchat_read" for="x_read" class="<?= $Page->LeftColumnClass ?>"><?= $Page->read->caption() ?><?= $Page->read->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->read->cellAttributes() ?>>
<span id="el_arrowchat_read">
<input type="<?= $Page->read->getInputTextType() ?>" data-table="arrowchat" data-field="x_read" name="x_read" id="x_read" size="30" placeholder="<?= HtmlEncode($Page->read->getPlaceHolder()) ?>" value="<?= $Page->read->EditValue ?>"<?= $Page->read->editAttributes() ?> aria-describedby="x_read_help">
<?= $Page->read->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->read->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
    <div id="r_user_read" class="form-group row">
        <label id="elh_arrowchat_user_read" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_read->caption() ?><?= $Page->user_read->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_read->cellAttributes() ?>>
<span id="el_arrowchat_user_read">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->user_read->isInvalidClass() ?>" data-table="arrowchat" data-field="x_user_read" name="x_user_read[]" id="x_user_read_182050" value="1"<?= ConvertToBool($Page->user_read->CurrentValue) ? " checked" : "" ?><?= $Page->user_read->editAttributes() ?> aria-describedby="x_user_read_help">
    <label class="custom-control-label" for="x_user_read_182050"></label>
</div>
<?= $Page->user_read->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_read->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direction->Visible) { // direction ?>
    <div id="r_direction" class="form-group row">
        <label id="elh_arrowchat_direction" for="x_direction" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direction->caption() ?><?= $Page->direction->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->direction->cellAttributes() ?>>
<span id="el_arrowchat_direction">
<input type="<?= $Page->direction->getInputTextType() ?>" data-table="arrowchat" data-field="x_direction" name="x_direction" id="x_direction" size="30" placeholder="<?= HtmlEncode($Page->direction->getPlaceHolder()) ?>" value="<?= $Page->direction->EditValue ?>"<?= $Page->direction->editAttributes() ?> aria-describedby="x_direction_help">
<?= $Page->direction->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direction->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
