<?php

namespace PHPMaker2021\simexamerica;

// Page object
$GrupoAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fgrupoadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fgrupoadd = currentForm = new ew.Form("fgrupoadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "grupo")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.grupo)
        ew.vars.tables.grupo = currentTable;
    fgrupoadd.addFields([
        ["id_escenario", [fields.id_escenario.visible && fields.id_escenario.required ? ew.Validators.required(fields.id_escenario.caption) : null], fields.id_escenario.isInvalid],
        ["imgen_grupo", [fields.imgen_grupo.visible && fields.imgen_grupo.required ? ew.Validators.fileRequired(fields.imgen_grupo.caption) : null], fields.imgen_grupo.isInvalid],
        ["nombre_grupo", [fields.nombre_grupo.visible && fields.nombre_grupo.required ? ew.Validators.required(fields.nombre_grupo.caption) : null], fields.nombre_grupo.isInvalid],
        ["descripcion_grupo", [fields.descripcion_grupo.visible && fields.descripcion_grupo.required ? ew.Validators.required(fields.descripcion_grupo.caption) : null], fields.descripcion_grupo.isInvalid],
        ["color", [fields.color.visible && fields.color.required ? ew.Validators.required(fields.color.caption) : null], fields.color.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fgrupoadd,
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
    fgrupoadd.validate = function () {
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
    fgrupoadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fgrupoadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fgrupoadd.lists.id_escenario = <?= $Page->id_escenario->toClientList($Page) ?>;
    loadjs.done("fgrupoadd");
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
<form name="fgrupoadd" id="fgrupoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="grupo">
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
        <label id="elh_grupo_id_escenario" for="x_id_escenario" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_grupo_id_escenario"><?= $Page->id_escenario->caption() ?><?= $Page->id_escenario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_escenario->cellAttributes() ?>>
<?php if ($Page->id_escenario->getSessionValue() != "") { ?>
<template id="tpx_grupo_id_escenario"><span id="el_grupo_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_escenario->getDisplayValue($Page->id_escenario->ViewValue))) ?>"></span>
</span></template>
<input type="hidden" id="x_id_escenario" name="x_id_escenario" value="<?= HtmlEncode($Page->id_escenario->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<template id="tpx_grupo_id_escenario"><span id="el_grupo_id_escenario">
    <select
        id="x_id_escenario"
        name="x_id_escenario"
        class="form-control ew-select<?= $Page->id_escenario->isInvalidClass() ?>"
        data-select2-id="grupo_x_id_escenario"
        data-table="grupo"
        data-field="x_id_escenario"
        data-value-separator="<?= $Page->id_escenario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->id_escenario->getPlaceHolder()) ?>"
        <?= $Page->id_escenario->editAttributes() ?>>
        <?= $Page->id_escenario->selectOptionListHtml("x_id_escenario") ?>
    </select>
    <?= $Page->id_escenario->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->id_escenario->getErrorMessage() ?></div>
<?= $Page->id_escenario->Lookup->getParamTag($Page, "p_x_id_escenario") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='grupo_x_id_escenario']"),
        options = { name: "x_id_escenario", selectId: "grupo_x_id_escenario", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.grupo.fields.id_escenario.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
    <div id="r_imgen_grupo" class="form-group row">
        <label id="elh_grupo_imgen_grupo" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_grupo_imgen_grupo"><?= $Page->imgen_grupo->caption() ?><?= $Page->imgen_grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->imgen_grupo->cellAttributes() ?>>
<template id="tpx_grupo_imgen_grupo"><span id="el_grupo_imgen_grupo">
<div id="fd_x_imgen_grupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->imgen_grupo->title() ?>" data-table="grupo" data-field="x_imgen_grupo" name="x_imgen_grupo" id="x_imgen_grupo" lang="<?= CurrentLanguageID() ?>"<?= $Page->imgen_grupo->editAttributes() ?><?= ($Page->imgen_grupo->ReadOnly || $Page->imgen_grupo->Disabled) ? " disabled" : "" ?> aria-describedby="x_imgen_grupo_help">
        <label class="custom-file-label ew-file-label" for="x_imgen_grupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->imgen_grupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->imgen_grupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_imgen_grupo" id= "fn_x_imgen_grupo" value="<?= $Page->imgen_grupo->Upload->FileName ?>">
<input type="hidden" name="fa_x_imgen_grupo" id= "fa_x_imgen_grupo" value="0">
<input type="hidden" name="fs_x_imgen_grupo" id= "fs_x_imgen_grupo" value="30">
<input type="hidden" name="fx_x_imgen_grupo" id= "fx_x_imgen_grupo" value="<?= $Page->imgen_grupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_imgen_grupo" id= "fm_x_imgen_grupo" value="<?= $Page->imgen_grupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_imgen_grupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
    <div id="r_nombre_grupo" class="form-group row">
        <label id="elh_grupo_nombre_grupo" for="x_nombre_grupo" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_grupo_nombre_grupo"><?= $Page->nombre_grupo->caption() ?><?= $Page->nombre_grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nombre_grupo->cellAttributes() ?>>
<template id="tpx_grupo_nombre_grupo"><span id="el_grupo_nombre_grupo">
<input type="<?= $Page->nombre_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_nombre_grupo" name="x_nombre_grupo" id="x_nombre_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->nombre_grupo->getPlaceHolder()) ?>" value="<?= $Page->nombre_grupo->EditValue ?>"<?= $Page->nombre_grupo->editAttributes() ?> aria-describedby="x_nombre_grupo_help">
<?= $Page->nombre_grupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_grupo->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_grupo->Visible) { // descripcion_grupo ?>
    <div id="r_descripcion_grupo" class="form-group row">
        <label id="elh_grupo_descripcion_grupo" for="x_descripcion_grupo" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_grupo_descripcion_grupo"><?= $Page->descripcion_grupo->caption() ?><?= $Page->descripcion_grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->descripcion_grupo->cellAttributes() ?>>
<template id="tpx_grupo_descripcion_grupo"><span id="el_grupo_descripcion_grupo">
<input type="<?= $Page->descripcion_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_descripcion_grupo" name="x_descripcion_grupo" id="x_descripcion_grupo" size="100" maxlength="100" placeholder="<?= HtmlEncode($Page->descripcion_grupo->getPlaceHolder()) ?>" value="<?= $Page->descripcion_grupo->EditValue ?>"<?= $Page->descripcion_grupo->editAttributes() ?> aria-describedby="x_descripcion_grupo_help">
<?= $Page->descripcion_grupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion_grupo->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
    <div id="r_color" class="form-group row">
        <label id="elh_grupo_color" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_grupo_color"><?= $Page->color->caption() ?><?= $Page->color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->color->cellAttributes() ?>>
<template id="tpx_grupo_color"><span id="el_grupo_color">
<input type="<?= $Page->color->getInputTextType() ?>" data-table="grupo" data-field="x_color" name="x_color" id="x_color" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->color->getPlaceHolder()) ?>" value="<?= $Page->color->EditValue ?>"<?= $Page->color->editAttributes() ?> aria-describedby="x_color_help">
<?= $Page->color->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->color->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_grupoadd" class="ew-custom-template"></div>
<template id="tpm_grupoadd">
<div id="ct_GrupoAdd"><style>
{
		margin: 0;
		padding: 0;
	}
	.color-wrapper {
		position: relative;
		margin: 1px auto;
	}
	.color-wrapper p {
		margin-bottom: 15px;
	}
	input.call-picker {
		border: 1px solid #AAA;
		color: #666;
		text-transform: uppercase;
		float: left;    
		outline: none;
	  padding: 10px;
	  text-transform: uppercase;
	  width: 85px;
	}
	.color-picker {
		width: 130px;
		background: #F3F3F3;
		height: 100px;
		padding: 5px;
		border: 5px solid #fff;
		box-shadow: 0px 0px 3px 1px #DDD;
		position: absolute;
		top: 35px;
		left: 2px;
	}
	.color-holder {
  	    background: #fff;
		cursor: pointer;
		border: 1px solid #AAA;
		width: 40px;
		height: 36px;
		float: left;
		margin-left: 5px;
	}
	.color-picker .color-item {
		cursor: pointer;
		width: 10px;
		height: 10px;
		list-style-type: none;
		float: left;
		margin: 2px;
		border: 1px solid #DDD;
	}
	.color-picker .color-item:hover {
		border: 1px solid #666;
		opacity: 0.8;
		-moz-opacity: 0.8;
		filter:alpha(opacity=8);
	}
</style>
    <?php
  $id_escenario = Container("escenario")->id_escenario->CurrentValue;
  //echo CurrentUserID();
//	$nombreescnario = ExecuteRow("SELECT nombre_escenario,DATE_FORMAT(fechaini_real, '%Y/%m/%d'), DATE_FORMAT(fechafinal_real, '%Y/%m/%d')  FROM escenario WHERE id_escenario =  = '".$id_escenario."';");
	$escenID = ExecuteRow("SELECT DATE_FORMAT(fechaini_real, '%Y/%m/%d'), DATE_FORMAT(fechafinal_real, '%Y/%m/%d'),nombre_escenario FROM escenario WHERE id_escenario = '".$id_escenario."';");
?>
<div class="callout callout-primary">
  <h4>Simulación:  <?php echo $escenID[2];  ?>  </h4>
 <p> <em> Fecha inicio real: <?php echo $escenID[1]  ?> Fecha fin real: <?php echo $escenID[0];  ?> </em></p>
</div>
    <div id="r_nombre_grupo" class="form-group">
        <label for="x_nombre_grupo" class="col-sm-2 col-form-label"><?= $Page->nombre_grupo->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_grupo_nombre_grupo"></slot></div> </div> 
    </div>
    <div id="r_descripcion_grupo" class="form-group">
        <label for="x_descripcion_grupo" class="col-sm-2 col-form-label"><?= $Page->descripcion_grupo->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_grupo_descripcion_grupo"></slot></div>
    </div>
 <div class="color-wrapper">
    <div id="r_color" class="form-group">
        <label for="x_color" class="col-sm-2 col-form-label"><?= $Page->color->caption() ?></label>
       <div class="col-sm-10"> 
        <div class="color-holder call-picker"></div>
        <div class="color-picker" id="color-picker" style="display: none"></div> <slot class="ew-slot" name="tpx_grupo_color"></slot>
      </div> 
  </div>
</div>
<div>&nbsp;<p></p> </div>
<div>&nbsp; </div>
      <div id="r_imgen_grupo" class="form-group">
        <label for="x_imgen_grupo" class="col-sm-2 col-form-label"><?= $Page->imgen_grupo->caption() ?></label>
        <div class="col-sm-10"><slot class="ew-slot" name="tpx_grupo_imgen_grupo"></slot></div>
    </div>
    <script>
	var colorList = [ 'e5986640','f7dc6f40','7dcea040','76d7c440','7fb3d540','c39bd340','d9888040',
	                  'D8F781', 'FA58AC','660000', 'FF6633', '666633', '336633',
	                  '33666680', '0066FF80', '666699', '666666', 'CC3333', 'FF9933',
	                  '99CC33', '669966', '66CCCC', '3366FF', '663366', '999999',
	                  'CC66FF', 'FFCC33', 'FFFF66', '99FF66', '99CCCC', '66CCFF',
	                  '993366', 'CCCCCC', 'FF99CC', 'FFCC99', 'FFFF99', 'CCffCC',
	                  'CCFFff', '99CCFF', 'CC99FF', 'FFFFFF','CB8A23' ];
		var picker = $('#color-picker');
		for (var i = 0; i < colorList.length; i++ ) {
			picker.append('<li class="color-item" data-hex="' + '#' + colorList[i] + '" style="background-color:' + '#' + colorList[i] + ';"></li>');
		}
		$('body').click(function () {
			picker.fadeOut();
		});
		$('#x_color').click(function(event) {
			event.stopPropagation();
			picker.fadeIn();
			picker.children('li').hover(function() {
				var codeHex = $(this).data('hex');
				$('.color-holder').css('background-color', codeHex);
				$('#x_color').val(codeHex);
			});
		});
/*
			$('#x_color').onfocus(function(event) {
			event.stopPropagation();
			picker.fadeIn();
			picker.children('li').hover(function() {
				var codeHex = $(this).data('hex');
				$('.color-holder').css('background-color', codeHex);
				$('#x_color').val(codeHex);
			});
		});
    */
    </script>
</div>
</template>
<?php
    if (in_array("subgrupo", explode(",", $Page->getCurrentDetailTable())) && $subgrupo->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subgrupo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubgrupoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("users", explode(",", $Page->getCurrentDetailTable())) && $users->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("users", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "UsersGrid.php" ?>
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
    ew.applyTemplate("tpd_grupoadd", "tpm_grupoadd", "grupoadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    ew.addEventHandlers("grupo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.

    //$('label#elh_grupo_nombre_grupo').remove();
    //$('label#elh_grupo_descripcion_grupo').remove();
    //$('label#elh_grupo_imgen_grupo').remove();
    //$('label#elh_grupo_id_escenario').remove();
    //$('label#elh_grupo_color').remove();
    //$('label#elh_grupo_participante').remove();
    //$('label#elh_grupo_excon_grupo').remove();

    //$('h4').text("Nuevo grupo");
});
</script>
