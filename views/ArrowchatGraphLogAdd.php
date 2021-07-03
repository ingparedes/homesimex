<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatGraphLogAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_graph_logadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchat_graph_logadd = currentForm = new ew.Form("farrowchat_graph_logadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_graph_log")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_graph_log)
        ew.vars.tables.arrowchat_graph_log = currentTable;
    farrowchat_graph_logadd.addFields([
        ["date", [fields.date.visible && fields.date.required ? ew.Validators.required(fields.date.caption) : null], fields.date.isInvalid],
        ["user_messages", [fields.user_messages.visible && fields.user_messages.required ? ew.Validators.required(fields.user_messages.caption) : null, ew.Validators.integer], fields.user_messages.isInvalid],
        ["chat_room_messages", [fields.chat_room_messages.visible && fields.chat_room_messages.required ? ew.Validators.required(fields.chat_room_messages.caption) : null, ew.Validators.integer], fields.chat_room_messages.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_graph_logadd,
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
    farrowchat_graph_logadd.validate = function () {
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
    farrowchat_graph_logadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_graph_logadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("farrowchat_graph_logadd");
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
<form name="farrowchat_graph_logadd" id="farrowchat_graph_logadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_graph_log">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->date->Visible) { // date ?>
    <div id="r_date" class="form-group row">
        <label id="elh_arrowchat_graph_log_date" for="x_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date->caption() ?><?= $Page->date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->date->cellAttributes() ?>>
<span id="el_arrowchat_graph_log_date">
<input type="<?= $Page->date->getInputTextType() ?>" data-table="arrowchat_graph_log" data-field="x_date" name="x_date" id="x_date" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>" value="<?= $Page->date->EditValue ?>"<?= $Page->date->editAttributes() ?> aria-describedby="x_date_help">
<?= $Page->date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_messages->Visible) { // user_messages ?>
    <div id="r_user_messages" class="form-group row">
        <label id="elh_arrowchat_graph_log_user_messages" for="x_user_messages" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_messages->caption() ?><?= $Page->user_messages->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_messages->cellAttributes() ?>>
<span id="el_arrowchat_graph_log_user_messages">
<input type="<?= $Page->user_messages->getInputTextType() ?>" data-table="arrowchat_graph_log" data-field="x_user_messages" name="x_user_messages" id="x_user_messages" size="30" placeholder="<?= HtmlEncode($Page->user_messages->getPlaceHolder()) ?>" value="<?= $Page->user_messages->EditValue ?>"<?= $Page->user_messages->editAttributes() ?> aria-describedby="x_user_messages_help">
<?= $Page->user_messages->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_messages->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->chat_room_messages->Visible) { // chat_room_messages ?>
    <div id="r_chat_room_messages" class="form-group row">
        <label id="elh_arrowchat_graph_log_chat_room_messages" for="x_chat_room_messages" class="<?= $Page->LeftColumnClass ?>"><?= $Page->chat_room_messages->caption() ?><?= $Page->chat_room_messages->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->chat_room_messages->cellAttributes() ?>>
<span id="el_arrowchat_graph_log_chat_room_messages">
<input type="<?= $Page->chat_room_messages->getInputTextType() ?>" data-table="arrowchat_graph_log" data-field="x_chat_room_messages" name="x_chat_room_messages" id="x_chat_room_messages" size="30" placeholder="<?= HtmlEncode($Page->chat_room_messages->getPlaceHolder()) ?>" value="<?= $Page->chat_room_messages->EditValue ?>"<?= $Page->chat_room_messages->editAttributes() ?> aria-describedby="x_chat_room_messages_help">
<?= $Page->chat_room_messages->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->chat_room_messages->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat_graph_log");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
