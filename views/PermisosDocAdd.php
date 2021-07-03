<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PermisosDocAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpermisos_docadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpermisos_docadd = currentForm = new ew.Form("fpermisos_docadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "permisos_doc")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.permisos_doc)
        ew.vars.tables.permisos_doc = currentTable;
    fpermisos_docadd.addFields([
        ["id_file", [fields.id_file.visible && fields.id_file.required ? ew.Validators.required(fields.id_file.caption) : null, ew.Validators.integer], fields.id_file.isInvalid],
        ["tipo_permiso", [fields.tipo_permiso.visible && fields.tipo_permiso.required ? ew.Validators.required(fields.tipo_permiso.caption) : null], fields.tipo_permiso.isInvalid],
        ["fecha_created", [fields.fecha_created.visible && fields.fecha_created.required ? ew.Validators.required(fields.fecha_created.caption) : null], fields.fecha_created.isInvalid],
        ["id_usuarios", [fields.id_usuarios.visible && fields.id_usuarios.required ? ew.Validators.required(fields.id_usuarios.caption) : null], fields.id_usuarios.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpermisos_docadd,
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
    fpermisos_docadd.validate = function () {
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
    fpermisos_docadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpermisos_docadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpermisos_docadd.lists.tipo_permiso = <?= $Page->tipo_permiso->toClientList($Page) ?>;
    fpermisos_docadd.lists.id_usuarios = <?= $Page->id_usuarios->toClientList($Page) ?>;
    loadjs.done("fpermisos_docadd");
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
<form name="fpermisos_docadd" id="fpermisos_docadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="permisos_doc">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "archivos_doc") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="archivos_doc">
<input type="hidden" name="fk_id_file" value="<?= HtmlEncode($Page->id_file->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->id_file->Visible) { // id_file ?>
    <div id="r_id_file" class="form-group row">
        <label id="elh_permisos_doc_id_file" for="x_id_file" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_permisos_doc_id_file"><?= $Page->id_file->caption() ?><?= $Page->id_file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_file->cellAttributes() ?>>
<?php if ($Page->id_file->getSessionValue() != "") { ?>
<template id="tpx_permisos_doc_id_file"><span id="el_permisos_doc_id_file">
<span<?= $Page->id_file->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_file->getDisplayValue($Page->id_file->ViewValue))) ?>"></span>
</span></template>
<input type="hidden" id="x_id_file" name="x_id_file" value="<?= HtmlEncode($Page->id_file->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<template id="tpx_permisos_doc_id_file"><span id="el_permisos_doc_id_file">
<input type="<?= $Page->id_file->getInputTextType() ?>" data-table="permisos_doc" data-field="x_id_file" name="x_id_file" id="x_id_file" size="30" placeholder="<?= HtmlEncode($Page->id_file->getPlaceHolder()) ?>" value="<?= $Page->id_file->EditValue ?>"<?= $Page->id_file->editAttributes() ?> aria-describedby="x_id_file_help">
<?= $Page->id_file->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_file->getErrorMessage() ?></div>
</span></template>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
    <div id="r_tipo_permiso" class="form-group row">
        <label id="elh_permisos_doc_tipo_permiso" for="x_tipo_permiso" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_permisos_doc_tipo_permiso"><?= $Page->tipo_permiso->caption() ?><?= $Page->tipo_permiso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tipo_permiso->cellAttributes() ?>>
<template id="tpx_permisos_doc_tipo_permiso"><span id="el_permisos_doc_tipo_permiso">
    <select
        id="x_tipo_permiso"
        name="x_tipo_permiso"
        class="form-control ew-select<?= $Page->tipo_permiso->isInvalidClass() ?>"
        data-select2-id="permisos_doc_x_tipo_permiso"
        data-table="permisos_doc"
        data-field="x_tipo_permiso"
        data-value-separator="<?= $Page->tipo_permiso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_permiso->getPlaceHolder()) ?>"
        <?= $Page->tipo_permiso->editAttributes() ?>>
        <?= $Page->tipo_permiso->selectOptionListHtml("x_tipo_permiso") ?>
    </select>
    <?= $Page->tipo_permiso->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_permiso->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='permisos_doc_x_tipo_permiso']"),
        options = { name: "x_tipo_permiso", selectId: "permisos_doc_x_tipo_permiso", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.permisos_doc.fields.tipo_permiso.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.permisos_doc.fields.tipo_permiso.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_usuarios->Visible) { // id_usuarios ?>
    <div id="r_id_usuarios" class="form-group row">
        <label id="elh_permisos_doc_id_usuarios" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_permisos_doc_id_usuarios"><?= $Page->id_usuarios->caption() ?><?= $Page->id_usuarios->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_usuarios->cellAttributes() ?>>
<template id="tpx_permisos_doc_id_usuarios"><span id="el_permisos_doc_id_usuarios">
<div class="input-group ew-lookup-list" aria-describedby="x_id_usuarios_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_id_usuarios"><?= EmptyValue(strval($Page->id_usuarios->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->id_usuarios->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->id_usuarios->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->id_usuarios->ReadOnly || $Page->id_usuarios->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_id_usuarios[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->id_usuarios->getErrorMessage() ?></div>
<?= $Page->id_usuarios->getCustomMessage() ?>
<?= $Page->id_usuarios->Lookup->getParamTag($Page, "p_x_id_usuarios") ?>
<input type="hidden" is="selection-list" data-table="permisos_doc" data-field="x_id_usuarios" data-type="text" data-multiple="1" data-lookup="1" data-value-separator="<?= $Page->id_usuarios->displayValueSeparatorAttribute() ?>" name="x_id_usuarios[]" id="x_id_usuarios[]" value="<?= $Page->id_usuarios->CurrentValue ?>"<?= $Page->id_usuarios->editAttributes() ?>>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_permisos_docadd" class="ew-custom-template"></div>
<template id="tpm_permisos_docadd">
<div id="ct_PermisosDocAdd">  <?php
$userid = CurrentUserID();
  $IdDoc = Container("archivos_doc")->id_file->CurrentValue;
  $NameDoc = ExecuteRow("SELECT file_name, fecha_created FROM archivos_doc where id_file = '".$IdDoc."'"); 
	$Doctos = "SELECT
	archivos_doc.file_name, 
	IF(permisos_docusers.tipo_permiso = '1','Edición','Visualización') as Permiso,
	CONCAT(users.nombres,' ',users.apellidos) as nombres, 
	grupo.nombre_grupo,
	DATE_FORMAT(permisos_docusers.date_created, '%Y/%m/%d %H:%i') as Fecha
FROM
	archivos_doc INNER JOIN permisos_docusers ON 
		archivos_doc.id_file = permisos_docusers.id_file
	INNER JOIN users 	ON permisos_docusers.id_users = users.id_users
	INNER JOIN grupo ON users.grupo = grupo.id_grupo
WHERE
	archivos_doc.id_file = '".$IdDoc."' AND  archivos_doc.id_users = '".$userid."'";
?>
<div class="callout callout-primary">
  <h4>Archivo: <?php echo $NameDoc[0] ?>  </h4>
  <p> <em> Fecha de creación <?php echo $NameDoc[1]  ?> </em></p>
 </div>
 <div class="container-fluid">
    <div class="row">
                <div class="col-md-6">
    <div id="r_tipo_permiso" class="form-group row">
        <label for="x_tipo_permiso" class="col-sm-2 col-form-label"><?= $Page->tipo_permiso->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_permisos_doc_tipo_permiso"></slot></div>
    </div>
    <div id="r_id_usuarios" class="form-group row">
        <label for="x_id_usuarios" class="col-sm-2 col-form-label"><?= $Page->id_usuarios->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_permisos_doc_id_usuarios"></slot></div>
    </div>
                </div>
                <div class="col-md-6">
<div class="card">
    <div class="card-header"><strong> Documento compartido </strong></div>
    <div class="card-body">
<?php
echo ExecuteHtml($Doctos, ["fieldcaption" => TRUE, "tablename" => ["archivos_doc", "permisos_docusers", "users","grupo"]]); 
?>
	</div> 
                </div>
            </div>
</div>
</div>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_permisos_docadd", "tpm_permisos_docadd", "permisos_docadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("permisos_doc");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#btn-action").html("Compartir");
});
</script>
