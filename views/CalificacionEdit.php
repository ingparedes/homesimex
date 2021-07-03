<?php

namespace PHPMaker2021\simexamerica;

// Page object
$CalificacionEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcalificacionedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fcalificacionedit = currentForm = new ew.Form("fcalificacionedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "calificacion")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.calificacion)
        ew.vars.tables.calificacion = currentTable;
    fcalificacionedit.addFields([
        ["id_calificacion", [fields.id_calificacion.visible && fields.id_calificacion.required ? ew.Validators.required(fields.id_calificacion.caption) : null], fields.id_calificacion.isInvalid],
        ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcalificacionedit,
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
    fcalificacionedit.validate = function () {
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
    fcalificacionedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcalificacionedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fcalificacionedit");
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
<form name="fcalificacionedit" id="fcalificacionedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="calificacion">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_calificacion->Visible) { // id_calificacion ?>
    <div id="r_id_calificacion" class="form-group row">
        <label id="elh_calificacion_id_calificacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_calificacion->caption() ?><?= $Page->id_calificacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_calificacion->cellAttributes() ?>>
<span id="el_calificacion_id_calificacion">
<span<?= $Page->id_calificacion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_calificacion->getDisplayValue($Page->id_calificacion->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="calificacion" data-field="x_id_calificacion" data-hidden="1" name="x_id_calificacion" id="x_id_calificacion" value="<?= HtmlEncode($Page->id_calificacion->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <div id="r_descripcion" class="form-group row">
        <label id="elh_calificacion_descripcion" for="x_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion->caption() ?><?= $Page->descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->descripcion->cellAttributes() ?>>
<span id="el_calificacion_descripcion">
<input type="<?= $Page->descripcion->getInputTextType() ?>" data-table="calificacion" data-field="x_descripcion" name="x_descripcion" id="x_descripcion" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>" value="<?= $Page->descripcion->EditValue ?>"<?= $Page->descripcion->editAttributes() ?> aria-describedby="x_descripcion_help">
<?= $Page->descripcion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage() ?></div>
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
    ew.addEventHandlers("calificacion");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
