<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TareasAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftareasadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    ftareasadd = currentForm = new ew.Form("ftareasadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "tareas")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.tareas)
        ew.vars.tables.tareas = currentTable;
    ftareasadd.addFields([
        ["id_escenario", [fields.id_escenario.visible && fields.id_escenario.required ? ew.Validators.required(fields.id_escenario.caption) : null, ew.Validators.integer], fields.id_escenario.isInvalid],
        ["id_grupo", [fields.id_grupo.visible && fields.id_grupo.required ? ew.Validators.required(fields.id_grupo.caption) : null], fields.id_grupo.isInvalid],
        ["titulo_tarea", [fields.titulo_tarea.visible && fields.titulo_tarea.required ? ew.Validators.required(fields.titulo_tarea.caption) : null], fields.titulo_tarea.isInvalid],
        ["descripcion_tarea", [fields.descripcion_tarea.visible && fields.descripcion_tarea.required ? ew.Validators.required(fields.descripcion_tarea.caption) : null], fields.descripcion_tarea.isInvalid],
        ["fechainireal_tarea", [fields.fechainireal_tarea.visible && fields.fechainireal_tarea.required ? ew.Validators.required(fields.fechainireal_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechainireal_tarea.isInvalid],
        ["fechafin_tarea", [fields.fechafin_tarea.visible && fields.fechafin_tarea.required ? ew.Validators.required(fields.fechafin_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechafin_tarea.isInvalid],
        ["fechainisimulado_tarea", [fields.fechainisimulado_tarea.visible && fields.fechainisimulado_tarea.required ? ew.Validators.required(fields.fechainisimulado_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechainisimulado_tarea.isInvalid],
        ["fechafinsimulado_tarea", [fields.fechafinsimulado_tarea.visible && fields.fechafinsimulado_tarea.required ? ew.Validators.required(fields.fechafinsimulado_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechafinsimulado_tarea.isInvalid],
        ["id_tarearelacion", [fields.id_tarearelacion.visible && fields.id_tarearelacion.required ? ew.Validators.required(fields.id_tarearelacion.caption) : null], fields.id_tarearelacion.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ftareasadd,
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
    ftareasadd.validate = function () {
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
    ftareasadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftareasadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    ftareasadd.lists.id_grupo = <?= $Page->id_grupo->toClientList($Page) ?>;
    ftareasadd.lists.id_tarearelacion = <?= $Page->id_tarearelacion->toClientList($Page) ?>;
    loadjs.done("ftareasadd");
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
<form name="ftareasadd" id="ftareasadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tareas">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "escenario") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="escenario">
<input type="hidden" name="fk_id_escenario" value="<?= HtmlEncode($Page->id_escenario->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
    <div id="r_id_escenario" class="form-group row">
        <label id="elh_tareas_id_escenario" for="x_id_escenario" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_tareas_id_escenario"><?= $Page->id_escenario->caption() ?><?= $Page->id_escenario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_escenario->cellAttributes() ?>>
<?php if ($Page->id_escenario->getSessionValue() != "") { ?>
<template id="tpx_tareas_id_escenario"><span id="el_tareas_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_escenario->getDisplayValue($Page->id_escenario->ViewValue))) ?>"></span>
</span></template>
<input type="hidden" id="x_id_escenario" name="x_id_escenario" value="<?= HtmlEncode($Page->id_escenario->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<template id="tpx_tareas_id_escenario"><span id="el_tareas_id_escenario">
<input type="<?= $Page->id_escenario->getInputTextType() ?>" data-table="tareas" data-field="x_id_escenario" name="x_id_escenario" id="x_id_escenario" size="30" placeholder="<?= HtmlEncode($Page->id_escenario->getPlaceHolder()) ?>" value="<?= $Page->id_escenario->EditValue ?>"<?= $Page->id_escenario->editAttributes() ?> aria-describedby="x_id_escenario_help">
<?= $Page->id_escenario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_escenario->getErrorMessage() ?></div>
</span></template>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
    <div id="r_id_grupo" class="form-group row">
        <label id="elh_tareas_id_grupo" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_tareas_id_grupo"><?= $Page->id_grupo->caption() ?><?= $Page->id_grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_grupo->cellAttributes() ?>>
<template id="tpx_tareas_id_grupo"><span id="el_tareas_id_grupo">
<template id="tp_x_id_grupo">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="tareas" data-field="x_id_grupo" name="x_id_grupo" id="x_id_grupo"<?= $Page->id_grupo->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_id_grupo" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_id_grupo[]"
    name="x_id_grupo[]"
    value="<?= HtmlEncode($Page->id_grupo->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_id_grupo"
    data-target="dsl_x_id_grupo"
    data-repeatcolumn="6"
    class="form-control<?= $Page->id_grupo->isInvalidClass() ?>"
    data-table="tareas"
    data-field="x_id_grupo"
    data-value-separator="<?= $Page->id_grupo->displayValueSeparatorAttribute() ?>"
    <?= $Page->id_grupo->editAttributes() ?>>
<?= $Page->id_grupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_grupo->getErrorMessage() ?></div>
<?= $Page->id_grupo->Lookup->getParamTag($Page, "p_x_id_grupo") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titulo_tarea->Visible) { // titulo_tarea ?>
    <div id="r_titulo_tarea" class="form-group row">
        <label id="elh_tareas_titulo_tarea" for="x_titulo_tarea" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_tareas_titulo_tarea"><?= $Page->titulo_tarea->caption() ?><?= $Page->titulo_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->titulo_tarea->cellAttributes() ?>>
<template id="tpx_tareas_titulo_tarea"><span id="el_tareas_titulo_tarea">
<input type="<?= $Page->titulo_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_titulo_tarea" name="x_titulo_tarea" id="x_titulo_tarea" size="100" maxlength="100" placeholder="<?= HtmlEncode($Page->titulo_tarea->getPlaceHolder()) ?>" value="<?= $Page->titulo_tarea->EditValue ?>"<?= $Page->titulo_tarea->editAttributes() ?> aria-describedby="x_titulo_tarea_help">
<?= $Page->titulo_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo_tarea->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_tarea->Visible) { // descripcion_tarea ?>
    <div id="r_descripcion_tarea" class="form-group row">
        <label id="elh_tareas_descripcion_tarea" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_tareas_descripcion_tarea"><?= $Page->descripcion_tarea->caption() ?><?= $Page->descripcion_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->descripcion_tarea->cellAttributes() ?>>
<template id="tpx_tareas_descripcion_tarea"><span id="el_tareas_descripcion_tarea">
<?php $Page->descripcion_tarea->EditAttrs->appendClass("editor"); ?>
<textarea data-table="tareas" data-field="x_descripcion_tarea" name="x_descripcion_tarea" id="x_descripcion_tarea" cols="50" rows="4" placeholder="<?= HtmlEncode($Page->descripcion_tarea->getPlaceHolder()) ?>"<?= $Page->descripcion_tarea->editAttributes() ?> aria-describedby="x_descripcion_tarea_help"><?= $Page->descripcion_tarea->EditValue ?></textarea>
<?= $Page->descripcion_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion_tarea->getErrorMessage() ?></div>
<script>
loadjs.ready(["ftareasadd", "editor"], function() {
	ew.createEditor("ftareasadd", "x_descripcion_tarea", 50, 4, <?= $Page->descripcion_tarea->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
    <div id="r_fechainireal_tarea" class="form-group row">
        <label id="elh_tareas_fechainireal_tarea" for="x_fechainireal_tarea" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_tareas_fechainireal_tarea"><?= $Page->fechainireal_tarea->caption() ?><?= $Page->fechainireal_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechainireal_tarea->cellAttributes() ?>>
<template id="tpx_tareas_fechainireal_tarea"><span id="el_tareas_fechainireal_tarea">
<input type="<?= $Page->fechainireal_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainireal_tarea" data-format="109" name="x_fechainireal_tarea" id="x_fechainireal_tarea" placeholder="<?= HtmlEncode($Page->fechainireal_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechainireal_tarea->EditValue ?>"<?= $Page->fechainireal_tarea->editAttributes() ?> aria-describedby="x_fechainireal_tarea_help">
<?= $Page->fechainireal_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechainireal_tarea->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechafin_tarea->Visible) { // fechafin_tarea ?>
    <div id="r_fechafin_tarea" class="form-group row">
        <label id="elh_tareas_fechafin_tarea" for="x_fechafin_tarea" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_tareas_fechafin_tarea"><?= $Page->fechafin_tarea->caption() ?><?= $Page->fechafin_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechafin_tarea->cellAttributes() ?>>
<template id="tpx_tareas_fechafin_tarea"><span id="el_tareas_fechafin_tarea">
<input type="<?= $Page->fechafin_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafin_tarea" data-format="109" name="x_fechafin_tarea" id="x_fechafin_tarea" placeholder="<?= HtmlEncode($Page->fechafin_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechafin_tarea->EditValue ?>"<?= $Page->fechafin_tarea->editAttributes() ?> aria-describedby="x_fechafin_tarea_help">
<?= $Page->fechafin_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechafin_tarea->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
    <div id="r_fechainisimulado_tarea" class="form-group row">
        <label id="elh_tareas_fechainisimulado_tarea" for="x_fechainisimulado_tarea" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_tareas_fechainisimulado_tarea"><?= $Page->fechainisimulado_tarea->caption() ?><?= $Page->fechainisimulado_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechainisimulado_tarea->cellAttributes() ?>>
<template id="tpx_tareas_fechainisimulado_tarea"><span id="el_tareas_fechainisimulado_tarea">
<input type="<?= $Page->fechainisimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainisimulado_tarea" data-format="109" name="x_fechainisimulado_tarea" id="x_fechainisimulado_tarea" placeholder="<?= HtmlEncode($Page->fechainisimulado_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechainisimulado_tarea->EditValue ?>"<?= $Page->fechainisimulado_tarea->editAttributes() ?> aria-describedby="x_fechainisimulado_tarea_help">
<?= $Page->fechainisimulado_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechainisimulado_tarea->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
    <div id="r_fechafinsimulado_tarea" class="form-group row">
        <label id="elh_tareas_fechafinsimulado_tarea" for="x_fechafinsimulado_tarea" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_tareas_fechafinsimulado_tarea"><?= $Page->fechafinsimulado_tarea->caption() ?><?= $Page->fechafinsimulado_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechafinsimulado_tarea->cellAttributes() ?>>
<template id="tpx_tareas_fechafinsimulado_tarea"><span id="el_tareas_fechafinsimulado_tarea">
<input type="<?= $Page->fechafinsimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-format="109" name="x_fechafinsimulado_tarea" id="x_fechafinsimulado_tarea" placeholder="<?= HtmlEncode($Page->fechafinsimulado_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechafinsimulado_tarea->EditValue ?>"<?= $Page->fechafinsimulado_tarea->editAttributes() ?> aria-describedby="x_fechafinsimulado_tarea_help">
<?= $Page->fechafinsimulado_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechafinsimulado_tarea->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_tarearelacion->Visible) { // id_tarearelacion ?>
    <div id="r_id_tarearelacion" class="form-group row">
        <label id="elh_tareas_id_tarearelacion" for="x_id_tarearelacion" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_tareas_id_tarearelacion"><?= $Page->id_tarearelacion->caption() ?><?= $Page->id_tarearelacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_tarearelacion->cellAttributes() ?>>
<template id="tpx_tareas_id_tarearelacion"><span id="el_tareas_id_tarearelacion">
<div class="input-group ew-lookup-list" aria-describedby="x_id_tarearelacion_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_id_tarearelacion"><?= EmptyValue(strval($Page->id_tarearelacion->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->id_tarearelacion->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->id_tarearelacion->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->id_tarearelacion->ReadOnly || $Page->id_tarearelacion->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_id_tarearelacion',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->id_tarearelacion->getErrorMessage() ?></div>
<?= $Page->id_tarearelacion->getCustomMessage() ?>
<?= $Page->id_tarearelacion->Lookup->getParamTag($Page, "p_x_id_tarearelacion") ?>
<input type="hidden" is="selection-list" data-table="tareas" data-field="x_id_tarearelacion" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->id_tarearelacion->displayValueSeparatorAttribute() ?>" name="x_id_tarearelacion" id="x_id_tarearelacion" value="<?= $Page->id_tarearelacion->CurrentValue ?>"<?= $Page->id_tarearelacion->editAttributes() ?>>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_tareasadd" class="ew-custom-template"></div>
<template id="tpm_tareasadd">
<div id="ct_TareasAdd"> 

    <?php
    //= CurrentUserInfo("escenario");

   //$id_escenario = $Page->id_escenario->getSessionValue();
   $id_escenario = HtmlEncode($Page->id_escenario->getSessionValue());
  //$id_escenario = Container("escenario")->id_escenario->CurrentValue;
//	$nombreescnario = ExecuteRow("SELECT nombre_escenario,DATE_FORMAT(fechaini_real, '%Y/%m/%d'), DATE_FORMAT(fechafinal_real, '%Y/%m/%d')  FROM escenario WHERE id_escenario =  = '".$id_escenario."';");
	$escenID = ExecuteRow("SELECT DATE_FORMAT(fechaini_real, '%Y/%m/%d'), DATE_FORMAT(fechafinal_real, '%Y/%m/%d'),nombre_escenario FROM escenario WHERE id_escenario = '".$id_escenario."';");
    $simulacion=$Language->phrase("simulacion"); 
    $fir=$Language->phrase("fir"); 
    $ffr=$Language->phrase("ffr"); 
    $fis=$Language->phrase("fis"); 
    $ffs=$Language->phrase("ffs"); 
    $para=$Language->phrase("para"); 
    $grabar_nuevo=$Language->phrase("grabar_nuevo"); 
?>
<div class="callout callout-primary">
  <h4><?php echo $simulacion; ?>: <?php echo $escenID[2];  ?>  </h4>
 <p> <em> <?php echo $fir; ?>: <?php echo $escenID[0]  ?> <?php echo $ffr; ?>: <?php echo $escenID[1];  ?> </em></p>
</div>
<div class="form-group col-md-4">
        <label for="x_id_grupo" ><?= $Page->id_grupo->caption() ?></label>
        <div><slot class="ew-slot" name="tpx_tareas_id_grupo"></slot></div>
 </div>
 <div class="form-group col-md-4">
        <label for="x_titulo_tarea" ><?= $Page->titulo_tarea->caption() ?></label>
        <div><slot class="ew-slot" name="tpx_tareas_titulo_tarea"></slot></div>
 </div>
  </div>
    <div id="r_descripcion_tarea" class="form-group">    
        <label for="x_descripcion_tarea"><?= $Page->descripcion_tarea->caption() ?></label>
        <div ><slot class="ew-slot" name="tpx_tareas_descripcion_tarea"></slot></div>
  <div id="r_fechainireal_tarea" class="form-row border" >
  	<div class="form-group col-md-4">
        <label for="x_fechainireal_tarea" ><?= $Page->fechainireal_tarea->caption() ?></label>
        <div ><slot class="ew-slot" name="tpx_tareas_fechainireal_tarea"></slot>
     <a class="input-button" title="toggle" data-toggle>
        <i class="icon-calendar"></i>
    </a>
        </div>
    </div>
    <div class="form-group col-md-4">
        <label for="x_fechafin_tarea" ><?= $Page->fechafin_tarea->caption() ?></label>
        <div ><slot class="ew-slot" name="tpx_tareas_fechafin_tarea"></slot></div>
    </div>
   </div>
   <span> <br></span>
  <div id="r_fechainisimulado_tarea" class="form-row border" >
      <div class="form-group col-md-4">
        <label for="x_fechainisimulado_tarea" ><?= $Page->fechainisimulado_tarea->caption() ?></label>
        <div><slot class="ew-slot" name="tpx_tareas_fechainisimulado_tarea"></slot></div>
    </div>
    <div class="form-group col-md-4">
        <label for="x_fechafinsimulado_tarea" ><?= $Page->fechafinsimulado_tarea->caption() ?></label>
        <div><slot class="ew-slot" name="tpx_tareas_fechafinsimulado_tarea"></slot></div>
      </div>
   </div>
    <div id="r_id_tarearelacion" class="form-group">
        <label for="x_id_tarearelacion" class="col-sm-2 col-form-label"><?= $Page->id_tarearelacion->caption() ?></label>
        <div ><slot class="ew-slot" name="tpx_tareas_id_tarearelacion"></slot></div>
    </div>
	<?php
$fecha = ExecuteRow("SELECT fechaini_real, fechafinal_real, fechaini_simulado, fechafin_simulado,nombre_escenario FROM escenario WHERE id_escenario = '".$id_escenario."';");
	 $fechaInicial = date("Y-m-d", strtotime($fecha[0]));
     $horaInicial = date("H", strtotime($fecha[0]));
     $minInicial = date("i", strtotime($fecha[0]));
     $fechaFin = date("Y-m-d", strtotime($fecha[1]));
     $horaFin = date("H", strtotime($fecha[1]));
     $minFin = date("i", strtotime($fecha[1]));
     $fechaInisimulado = date("Y-m-d",strtotime($fecha[2]));
     $horaInisimulado = date("H",strtotime($fecha[2]));
     $minInisimulado = date("i",strtotime($fecha[2]));
     $fechaFinsimulado = date("Y-m-d",strtotime($fecha[3]));
     $horaFinsimulado = date("H",strtotime($fecha[3]));
     $minFinsimulado = date("i",strtotime($fecha[3]));
	 ?>
    <script>
    var  fecl,datefin;
    $("input[name='x_fechainireal_tarea']").change(function() { // Assume Field1 is a text input
    fecl = new Date($('input[name=x_fechainireal_tarea]').val());
      //datefin =  moment(fecl, "YYYY-MM-DD HH:mm").toDate();
      datefin = moment(fecl).format("YYYY-MM-DD HH:mm");      
      $('#x_fechafin_tarea').val(datefin);
      $('#x_fechainisimulado_tarea').val(datefin);
      $('#x_fechafinsimulado_tarea').val(datefin);
      flatpickr("#x_fechafin_tarea",{//MIGUEL--PONE QUE VALOR MINIMO EN FECHA FIN SEA EL VALOR INICIAL
				locale: "es",
				enableTime: true,
				time_24hr: true,
				dateFormat: "Y-m-d H:i",
				minDate: datefin,
				maxDate: fechaFin + " " + horaFin + ":" + minFin,
				defaultDate: fechaInicial + " " + horaInicial + ":" + minInicial,
			});
});
    $("input[name='x_fechainisimulado_tarea']").change(function() { // EVENTO CHANGE
        fecl = new Date($('input[name=x_fechainisimulado_tarea]').val());
        //datefin =  moment(fecl, "YYYY-MM-DD HH:mm").toDate();
        datefin = moment(fecl).format("YYYY-MM-DD HH:mm");      
        $('#x_fechafinsimulado_tarea').val(datefin);//MIGUEL-- ASIGNA VALOR MINIMO AL MAXIMO
        flatpickr("#x_fechafinsimulado_tarea",{//MIGUEL---PONE QUE VALOR MINIMO EN FECHA FIN SEA EL VALOR INICIAL
				locale: "es",
				enableTime: true,
				time_24hr: true,
				dateFormat: "Y-m-d H:i",
				minDate: datefin,
				maxDate: fechaFinSimulado + " " + horaFinSimulado + ":" + minFinSimulado,
				defaultDate: fechaIniSimulado + " " + horaIniSimulado + ":" + minIniSimulado,
			});
    });
//centinela
//var Xmas95 = fecl;
//var weekday = Xmas95.getDay();
//console.log('weekday',weekday);

//var anio2 = fecl.getFullYear();
			/*	var mes2= datefin.getMonth();
				var dia2 = datafin.getDay()
			   var hor = datefin.getHours();
			   var minu = datefin.getMinutes();
			   var fecha2 = anio2+'-'+mes2+'-'+dia2+' '+hor+':'+minu;
			   console.log(fecha2);
 console.info(datefin);*/
     /* flatpickr("#x_fechafin_tarea",{
                    locale: "es",
                    dateFormat: "d/m/Y",
                    maxDate: (new Date()).setFullYear((new Date()).getFullYear() - 18)
                })
    	*/
			let fechaInicial = "<?php echo $fechaInicial ?>";
			let horaInicial = "<?php echo $horaInicial ?>";
			let minInicial = "<?php echo $minInicial ?>";
			let fechaFin = "<?php echo $fechaFin ?>";
			let horaFin = "<?php echo $horaFin ?>";
			let minFin = "<?php echo $minFin ?>";
			flatpickr("#x_fechainireal_tarea",{
				locale: "es",
				enableTime: true,
				time_24hr: true,
				dateFormat: "Y-m-d H:i",
				minDate: fechaInicial + " " + horaInicial + ":" + minInicial,
				maxDate: fechaFin + " " + horaFin + ":" + minFin,
				defaultDate: fechaInicial + " " + horaInicial + ":" + minInicial,
			});
			flatpickr("#x_fechafin_tarea",{
				locale: "es",
				enableTime: true,
				time_24hr: true,
				dateFormat: "Y-m-d H:i",
				minDate: fechaInicial + " " + horaInicial + ":" + minInicial,
				maxDate: fechaFin + " " + horaFin + ":" + minFin,
				defaultDate: fechaFin + " " + horaFin + ":" + minFin,
			});
			let fechaIniSimulado = "<?php echo $fechaIniSimulado ?>";
			let horaIniSimulado = "<?php echo $horaIniSimulado ?>";
			let minIniSimulado = "<?php echo $minIniSimulado ?>";
			let fechaFinSimulado = "<?php echo $fechaFinSimulado ?>";
			let horaFinSimulado = "<?php echo $horaFinSimulado ?>";
			let minFinSimulado = "<?php echo $minFinSimulado ?>";
			flatpickr("#x_fechainisimulado_tarea",{
				locale: "es",
				enableTime: true,
				time_24hr: true,
				dateFormat: "Y-m-d H:i",
				minDate: fechaIniSimulado + " " + horaIniSimulado + ":" + minIniSimulado,
				maxDate: fechaFinSimulado + " " + horaFinSimulado + ":" + minFinSimulado,
				defaultDate: fechaIniSimulado + " " + horaIniSimulado + ":" + minIniSimulado,
			});
			flatpickr("#x_fechafinsimulado_tarea",{
				locale: "es",
				enableTime: true,
				time_24hr: true,
				dateFormat: "Y-m-d H:i",
				minDate: fechaIniSimulado + " " + horaIniSimulado + ":" + minIniSimulado,
				maxDate: fechaFinSimulado + " " + horaFinSimulado + ":" + minFinSimulado,
				defaultDate: fechaIniSimulado + " " + horaIniSimulado + ":" + minIniSimulado,
			});
    </script>
</div>
</template>
<?php
    if (in_array("mensajes", explode(",", $Page->getCurrentDetailTable())) && $mensajes->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("mensajes", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MensajesGrid.php" ?>
<?php } ?>
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
    ew.applyTemplate("tpd_tareasadd", "tpm_tareasadd", "tareasadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    ew.addEventHandlers("tareas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $('h1').html("<span class='text-muted'>Nueva</span> tarea");
    $("<input>").attr({id:"f",name:"xxx",value:"",type:"hidden"}).appendTo("form"),$("#btn-action").after('&nbsp; <button class="btn btn-info ew-btn"  name="btn" id="btn" type="submit"  onclick="this.form.xxx.value=1"> <?php echo $grabar_nuevo; ?> </button>');
});
</script>
