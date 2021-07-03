<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PermisosDocusersEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpermisos_docusersedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fpermisos_docusersedit = currentForm = new ew.Form("fpermisos_docusersedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "permisos_docusers")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.permisos_docusers)
        ew.vars.tables.permisos_docusers = currentTable;
    fpermisos_docusersedit.addFields([
        ["id_permisiosuser", [fields.id_permisiosuser.visible && fields.id_permisiosuser.required ? ew.Validators.required(fields.id_permisiosuser.caption) : null], fields.id_permisiosuser.isInvalid],
        ["id_file", [fields.id_file.visible && fields.id_file.required ? ew.Validators.required(fields.id_file.caption) : null, ew.Validators.integer], fields.id_file.isInvalid],
        ["tipo_permiso", [fields.tipo_permiso.visible && fields.tipo_permiso.required ? ew.Validators.required(fields.tipo_permiso.caption) : null, ew.Validators.integer], fields.tipo_permiso.isInvalid],
        ["id_users", [fields.id_users.visible && fields.id_users.required ? ew.Validators.required(fields.id_users.caption) : null, ew.Validators.integer], fields.id_users.isInvalid],
        ["date_created", [fields.date_created.visible && fields.date_created.required ? ew.Validators.required(fields.date_created.caption) : null, ew.Validators.datetime(0)], fields.date_created.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpermisos_docusersedit,
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
    fpermisos_docusersedit.validate = function () {
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
    fpermisos_docusersedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpermisos_docusersedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fpermisos_docusersedit");
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
<form name="fpermisos_docusersedit" id="fpermisos_docusersedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="permisos_docusers">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_permisiosuser->Visible) { // id_permisiosuser ?>
    <div id="r_id_permisiosuser" class="form-group row">
        <label id="elh_permisos_docusers_id_permisiosuser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_permisiosuser->caption() ?><?= $Page->id_permisiosuser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_permisiosuser->cellAttributes() ?>>
<span id="el_permisos_docusers_id_permisiosuser">
<span<?= $Page->id_permisiosuser->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_permisiosuser->getDisplayValue($Page->id_permisiosuser->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="permisos_docusers" data-field="x_id_permisiosuser" data-hidden="1" name="x_id_permisiosuser" id="x_id_permisiosuser" value="<?= HtmlEncode($Page->id_permisiosuser->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_file->Visible) { // id_file ?>
    <div id="r_id_file" class="form-group row">
        <label id="elh_permisos_docusers_id_file" for="x_id_file" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_file->caption() ?><?= $Page->id_file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_file->cellAttributes() ?>>
<span id="el_permisos_docusers_id_file">
<input type="<?= $Page->id_file->getInputTextType() ?>" data-table="permisos_docusers" data-field="x_id_file" name="x_id_file" id="x_id_file" size="30" placeholder="<?= HtmlEncode($Page->id_file->getPlaceHolder()) ?>" value="<?= $Page->id_file->EditValue ?>"<?= $Page->id_file->editAttributes() ?> aria-describedby="x_id_file_help">
<?= $Page->id_file->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_file->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
    <div id="r_tipo_permiso" class="form-group row">
        <label id="elh_permisos_docusers_tipo_permiso" for="x_tipo_permiso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_permiso->caption() ?><?= $Page->tipo_permiso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tipo_permiso->cellAttributes() ?>>
<span id="el_permisos_docusers_tipo_permiso">
<input type="<?= $Page->tipo_permiso->getInputTextType() ?>" data-table="permisos_docusers" data-field="x_tipo_permiso" name="x_tipo_permiso" id="x_tipo_permiso" size="30" placeholder="<?= HtmlEncode($Page->tipo_permiso->getPlaceHolder()) ?>" value="<?= $Page->tipo_permiso->EditValue ?>"<?= $Page->tipo_permiso->editAttributes() ?> aria-describedby="x_tipo_permiso_help">
<?= $Page->tipo_permiso->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_permiso->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
    <div id="r_id_users" class="form-group row">
        <label id="elh_permisos_docusers_id_users" for="x_id_users" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_users->caption() ?><?= $Page->id_users->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_users->cellAttributes() ?>>
<span id="el_permisos_docusers_id_users">
<input type="<?= $Page->id_users->getInputTextType() ?>" data-table="permisos_docusers" data-field="x_id_users" name="x_id_users" id="x_id_users" size="30" placeholder="<?= HtmlEncode($Page->id_users->getPlaceHolder()) ?>" value="<?= $Page->id_users->EditValue ?>"<?= $Page->id_users->editAttributes() ?> aria-describedby="x_id_users_help">
<?= $Page->id_users->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_users->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->date_created->Visible) { // date_created ?>
    <div id="r_date_created" class="form-group row">
        <label id="elh_permisos_docusers_date_created" for="x_date_created" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date_created->caption() ?><?= $Page->date_created->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->date_created->cellAttributes() ?>>
<span id="el_permisos_docusers_date_created">
<input type="<?= $Page->date_created->getInputTextType() ?>" data-table="permisos_docusers" data-field="x_date_created" name="x_date_created" id="x_date_created" placeholder="<?= HtmlEncode($Page->date_created->getPlaceHolder()) ?>" value="<?= $Page->date_created->EditValue ?>"<?= $Page->date_created->editAttributes() ?> aria-describedby="x_date_created_help">
<?= $Page->date_created->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date_created->getErrorMessage() ?></div>
<?php if (!$Page->date_created->ReadOnly && !$Page->date_created->Disabled && !isset($Page->date_created->EditAttrs["readonly"]) && !isset($Page->date_created->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpermisos_docusersedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fpermisos_docusersedit", "x_date_created", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
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
    ew.addEventHandlers("permisos_docusers");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
