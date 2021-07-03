<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArrowchatNotificationsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farrowchat_notificationsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farrowchat_notificationsadd = currentForm = new ew.Form("farrowchat_notificationsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "arrowchat_notifications")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.arrowchat_notifications)
        ew.vars.tables.arrowchat_notifications = currentTable;
    farrowchat_notificationsadd.addFields([
        ["to_id", [fields.to_id.visible && fields.to_id.required ? ew.Validators.required(fields.to_id.caption) : null], fields.to_id.isInvalid],
        ["author_id", [fields.author_id.visible && fields.author_id.required ? ew.Validators.required(fields.author_id.caption) : null], fields.author_id.isInvalid],
        ["author_name", [fields.author_name.visible && fields.author_name.required ? ew.Validators.required(fields.author_name.caption) : null], fields.author_name.isInvalid],
        ["misc1", [fields.misc1.visible && fields.misc1.required ? ew.Validators.required(fields.misc1.caption) : null], fields.misc1.isInvalid],
        ["misc2", [fields.misc2.visible && fields.misc2.required ? ew.Validators.required(fields.misc2.caption) : null], fields.misc2.isInvalid],
        ["misc3", [fields.misc3.visible && fields.misc3.required ? ew.Validators.required(fields.misc3.caption) : null], fields.misc3.isInvalid],
        ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null, ew.Validators.integer], fields.type.isInvalid],
        ["alert_read", [fields.alert_read.visible && fields.alert_read.required ? ew.Validators.required(fields.alert_read.caption) : null, ew.Validators.integer], fields.alert_read.isInvalid],
        ["user_read", [fields.user_read.visible && fields.user_read.required ? ew.Validators.required(fields.user_read.caption) : null, ew.Validators.integer], fields.user_read.isInvalid],
        ["alert_time", [fields.alert_time.visible && fields.alert_time.required ? ew.Validators.required(fields.alert_time.caption) : null, ew.Validators.integer], fields.alert_time.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farrowchat_notificationsadd,
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
    farrowchat_notificationsadd.validate = function () {
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
    farrowchat_notificationsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farrowchat_notificationsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("farrowchat_notificationsadd");
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
<form name="farrowchat_notificationsadd" id="farrowchat_notificationsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="arrowchat_notifications">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->to_id->Visible) { // to_id ?>
    <div id="r_to_id" class="form-group row">
        <label id="elh_arrowchat_notifications_to_id" for="x_to_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->to_id->caption() ?><?= $Page->to_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->to_id->cellAttributes() ?>>
<span id="el_arrowchat_notifications_to_id">
<input type="<?= $Page->to_id->getInputTextType() ?>" data-table="arrowchat_notifications" data-field="x_to_id" name="x_to_id" id="x_to_id" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->to_id->getPlaceHolder()) ?>" value="<?= $Page->to_id->EditValue ?>"<?= $Page->to_id->editAttributes() ?> aria-describedby="x_to_id_help">
<?= $Page->to_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->to_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->author_id->Visible) { // author_id ?>
    <div id="r_author_id" class="form-group row">
        <label id="elh_arrowchat_notifications_author_id" for="x_author_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->author_id->caption() ?><?= $Page->author_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->author_id->cellAttributes() ?>>
<span id="el_arrowchat_notifications_author_id">
<input type="<?= $Page->author_id->getInputTextType() ?>" data-table="arrowchat_notifications" data-field="x_author_id" name="x_author_id" id="x_author_id" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->author_id->getPlaceHolder()) ?>" value="<?= $Page->author_id->EditValue ?>"<?= $Page->author_id->editAttributes() ?> aria-describedby="x_author_id_help">
<?= $Page->author_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->author_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->author_name->Visible) { // author_name ?>
    <div id="r_author_name" class="form-group row">
        <label id="elh_arrowchat_notifications_author_name" for="x_author_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->author_name->caption() ?><?= $Page->author_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->author_name->cellAttributes() ?>>
<span id="el_arrowchat_notifications_author_name">
<input type="<?= $Page->author_name->getInputTextType() ?>" data-table="arrowchat_notifications" data-field="x_author_name" name="x_author_name" id="x_author_name" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->author_name->getPlaceHolder()) ?>" value="<?= $Page->author_name->EditValue ?>"<?= $Page->author_name->editAttributes() ?> aria-describedby="x_author_name_help">
<?= $Page->author_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->author_name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->misc1->Visible) { // misc1 ?>
    <div id="r_misc1" class="form-group row">
        <label id="elh_arrowchat_notifications_misc1" for="x_misc1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->misc1->caption() ?><?= $Page->misc1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->misc1->cellAttributes() ?>>
<span id="el_arrowchat_notifications_misc1">
<input type="<?= $Page->misc1->getInputTextType() ?>" data-table="arrowchat_notifications" data-field="x_misc1" name="x_misc1" id="x_misc1" size="30" maxlength="191" placeholder="<?= HtmlEncode($Page->misc1->getPlaceHolder()) ?>" value="<?= $Page->misc1->EditValue ?>"<?= $Page->misc1->editAttributes() ?> aria-describedby="x_misc1_help">
<?= $Page->misc1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->misc1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->misc2->Visible) { // misc2 ?>
    <div id="r_misc2" class="form-group row">
        <label id="elh_arrowchat_notifications_misc2" for="x_misc2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->misc2->caption() ?><?= $Page->misc2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->misc2->cellAttributes() ?>>
<span id="el_arrowchat_notifications_misc2">
<input type="<?= $Page->misc2->getInputTextType() ?>" data-table="arrowchat_notifications" data-field="x_misc2" name="x_misc2" id="x_misc2" size="30" maxlength="191" placeholder="<?= HtmlEncode($Page->misc2->getPlaceHolder()) ?>" value="<?= $Page->misc2->EditValue ?>"<?= $Page->misc2->editAttributes() ?> aria-describedby="x_misc2_help">
<?= $Page->misc2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->misc2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->misc3->Visible) { // misc3 ?>
    <div id="r_misc3" class="form-group row">
        <label id="elh_arrowchat_notifications_misc3" for="x_misc3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->misc3->caption() ?><?= $Page->misc3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->misc3->cellAttributes() ?>>
<span id="el_arrowchat_notifications_misc3">
<input type="<?= $Page->misc3->getInputTextType() ?>" data-table="arrowchat_notifications" data-field="x_misc3" name="x_misc3" id="x_misc3" size="30" maxlength="191" placeholder="<?= HtmlEncode($Page->misc3->getPlaceHolder()) ?>" value="<?= $Page->misc3->EditValue ?>"<?= $Page->misc3->editAttributes() ?> aria-describedby="x_misc3_help">
<?= $Page->misc3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->misc3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <div id="r_type" class="form-group row">
        <label id="elh_arrowchat_notifications_type" for="x_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->type->cellAttributes() ?>>
<span id="el_arrowchat_notifications_type">
<input type="<?= $Page->type->getInputTextType() ?>" data-table="arrowchat_notifications" data-field="x_type" name="x_type" id="x_type" size="30" placeholder="<?= HtmlEncode($Page->type->getPlaceHolder()) ?>" value="<?= $Page->type->EditValue ?>"<?= $Page->type->editAttributes() ?> aria-describedby="x_type_help">
<?= $Page->type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alert_read->Visible) { // alert_read ?>
    <div id="r_alert_read" class="form-group row">
        <label id="elh_arrowchat_notifications_alert_read" for="x_alert_read" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alert_read->caption() ?><?= $Page->alert_read->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alert_read->cellAttributes() ?>>
<span id="el_arrowchat_notifications_alert_read">
<input type="<?= $Page->alert_read->getInputTextType() ?>" data-table="arrowchat_notifications" data-field="x_alert_read" name="x_alert_read" id="x_alert_read" size="30" placeholder="<?= HtmlEncode($Page->alert_read->getPlaceHolder()) ?>" value="<?= $Page->alert_read->EditValue ?>"<?= $Page->alert_read->editAttributes() ?> aria-describedby="x_alert_read_help">
<?= $Page->alert_read->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alert_read->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_read->Visible) { // user_read ?>
    <div id="r_user_read" class="form-group row">
        <label id="elh_arrowchat_notifications_user_read" for="x_user_read" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_read->caption() ?><?= $Page->user_read->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->user_read->cellAttributes() ?>>
<span id="el_arrowchat_notifications_user_read">
<input type="<?= $Page->user_read->getInputTextType() ?>" data-table="arrowchat_notifications" data-field="x_user_read" name="x_user_read" id="x_user_read" size="30" placeholder="<?= HtmlEncode($Page->user_read->getPlaceHolder()) ?>" value="<?= $Page->user_read->EditValue ?>"<?= $Page->user_read->editAttributes() ?> aria-describedby="x_user_read_help">
<?= $Page->user_read->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_read->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alert_time->Visible) { // alert_time ?>
    <div id="r_alert_time" class="form-group row">
        <label id="elh_arrowchat_notifications_alert_time" for="x_alert_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alert_time->caption() ?><?= $Page->alert_time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alert_time->cellAttributes() ?>>
<span id="el_arrowchat_notifications_alert_time">
<input type="<?= $Page->alert_time->getInputTextType() ?>" data-table="arrowchat_notifications" data-field="x_alert_time" name="x_alert_time" id="x_alert_time" size="30" placeholder="<?= HtmlEncode($Page->alert_time->getPlaceHolder()) ?>" value="<?= $Page->alert_time->EditValue ?>"<?= $Page->alert_time->editAttributes() ?> aria-describedby="x_alert_time_help">
<?= $Page->alert_time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alert_time->getErrorMessage() ?></div>
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
    ew.addEventHandlers("arrowchat_notifications");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
