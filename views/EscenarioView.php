<?php

namespace PHPMaker2021\simexamerica;

// Page object
$EscenarioView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fescenarioview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fescenarioview = currentForm = new ew.Form("fescenarioview", "view");
    loadjs.done("fescenarioview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.escenario) ew.vars.tables.escenario = <?= JsonEncode(GetClientVar("tables", "escenario")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<a class="ExportToWord btn btn-default ew-export-link ew-word"  title="" data-caption="Word" data-original-title="Word"><i data-phrase="ExportToWord" class="icon-word ew-icon" data-caption="Exportar a Word"></i></a>

<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fescenarioview" id="fescenarioview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="escenario">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
    <tr id="r_id_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_id_escenario"><template id="tpc_escenario_id_escenario"><?= $Page->id_escenario->caption() ?></template></span></td>
        <td data-name="id_escenario" <?= $Page->id_escenario->cellAttributes() ?>>
<template id="tpx_escenario_id_escenario"><span id="el_escenario_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<?= $Page->id_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->icon_escenario->Visible) { // icon_escenario ?>
    <tr id="r_icon_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_icon_escenario"><template id="tpc_escenario_icon_escenario"><?= $Page->icon_escenario->caption() ?></template></span></td>
        <td data-name="icon_escenario" <?= $Page->icon_escenario->cellAttributes() ?>>
<template id="tpx_escenario_icon_escenario" class="escenarioview">
<?php
$idm = CurrentPage()->icon_escenario->CurrentValue;
echo "<img width='25px' src='$idm'>";
?>
</template>
<template id="tpx_escenario_icon_escenario"><span id="el_escenario_icon_escenario">
<span><slot name="tpx_escenario_icon_escenario"></slot></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechacreacion_escenario->Visible) { // fechacreacion_escenario ?>
    <tr id="r_fechacreacion_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_fechacreacion_escenario"><template id="tpc_escenario_fechacreacion_escenario"><?= $Page->fechacreacion_escenario->caption() ?></template></span></td>
        <td data-name="fechacreacion_escenario" <?= $Page->fechacreacion_escenario->cellAttributes() ?>>
<template id="tpx_escenario_fechacreacion_escenario"><span id="el_escenario_fechacreacion_escenario">
<span<?= $Page->fechacreacion_escenario->viewAttributes() ?>>
<?= $Page->fechacreacion_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_escenario->Visible) { // nombre_escenario ?>
    <tr id="r_nombre_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_nombre_escenario"><template id="tpc_escenario_nombre_escenario"><?= $Page->nombre_escenario->caption() ?></template></span></td>
        <td data-name="nombre_escenario" <?= $Page->nombre_escenario->cellAttributes() ?>>
<template id="tpx_escenario_nombre_escenario"><span id="el_escenario_nombre_escenario">
<span<?= $Page->nombre_escenario->viewAttributes() ?>>
<?= $Page->nombre_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_evento->Visible) { // tipo_evento ?>
    <tr id="r_tipo_evento">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_tipo_evento"><template id="tpc_escenario_tipo_evento"><?= $Page->tipo_evento->caption() ?></template></span></td>
        <td data-name="tipo_evento" <?= $Page->tipo_evento->cellAttributes() ?>>
<template id="tpx_escenario_tipo_evento"><span id="el_escenario_tipo_evento">
<span<?= $Page->tipo_evento->viewAttributes() ?>>
<?= $Page->tipo_evento->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->incidente->Visible) { // incidente ?>
    <tr id="r_incidente">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_incidente"><template id="tpc_escenario_incidente"><?= $Page->incidente->caption() ?></template></span></td>
        <td data-name="incidente" <?= $Page->incidente->cellAttributes() ?>>
<template id="tpx_escenario_incidente"><span id="el_escenario_incidente">
<span<?= $Page->incidente->viewAttributes() ?>>
<?= $Page->incidente->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->evento_asociado->Visible) { // evento_asociado ?>
    <tr id="r_evento_asociado">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_evento_asociado"><template id="tpc_escenario_evento_asociado"><?= $Page->evento_asociado->caption() ?></template></span></td>
        <td data-name="evento_asociado" <?= $Page->evento_asociado->cellAttributes() ?>>
<template id="tpx_escenario_evento_asociado"><span id="el_escenario_evento_asociado">
<span<?= $Page->evento_asociado->viewAttributes() ?>>
<?= $Page->evento_asociado->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pais_escenario->Visible) { // pais_escenario ?>
    <tr id="r_pais_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_pais_escenario"><template id="tpc_escenario_pais_escenario"><?= $Page->pais_escenario->caption() ?></template></span></td>
        <td data-name="pais_escenario" <?= $Page->pais_escenario->cellAttributes() ?>>
<template id="tpx_escenario_pais_escenario"><span id="el_escenario_pais_escenario">
<span<?= $Page->pais_escenario->viewAttributes() ?>>
<?= $Page->pais_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->zonahora_escenario->Visible) { // zonahora_escenario ?>
    <tr id="r_zonahora_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_zonahora_escenario"><template id="tpc_escenario_zonahora_escenario"><?= $Page->zonahora_escenario->caption() ?></template></span></td>
        <td data-name="zonahora_escenario" <?= $Page->zonahora_escenario->cellAttributes() ?>>
<template id="tpx_escenario_zonahora_escenario"><span id="el_escenario_zonahora_escenario">
<span<?= $Page->zonahora_escenario->viewAttributes() ?>>
<?= $Page->zonahora_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion_escenario->Visible) { // descripcion_escenario ?>
    <tr id="r_descripcion_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_descripcion_escenario"><template id="tpc_escenario_descripcion_escenario"><?= $Page->descripcion_escenario->caption() ?></template></span></td>
        <td data-name="descripcion_escenario" <?= $Page->descripcion_escenario->cellAttributes() ?>>
<template id="tpx_escenario_descripcion_escenario"><span id="el_escenario_descripcion_escenario">
<span<?= $Page->descripcion_escenario->viewAttributes() ?>>
<?= $Page->descripcion_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaini_real->Visible) { // fechaini_real ?>
    <tr id="r_fechaini_real">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_fechaini_real"><template id="tpc_escenario_fechaini_real"><?= $Page->fechaini_real->caption() ?></template></span></td>
        <td data-name="fechaini_real" <?= $Page->fechaini_real->cellAttributes() ?>>
<template id="tpx_escenario_fechaini_real"><span id="el_escenario_fechaini_real">
<span<?= $Page->fechaini_real->viewAttributes() ?>>
<?= $Page->fechaini_real->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechafinal_real->Visible) { // fechafinal_real ?>
    <tr id="r_fechafinal_real">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_fechafinal_real"><template id="tpc_escenario_fechafinal_real"><?= $Page->fechafinal_real->caption() ?></template></span></td>
        <td data-name="fechafinal_real" <?= $Page->fechafinal_real->cellAttributes() ?>>
<template id="tpx_escenario_fechafinal_real"><span id="el_escenario_fechafinal_real">
<span<?= $Page->fechafinal_real->viewAttributes() ?>>
<?= $Page->fechafinal_real->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaini_simulado->Visible) { // fechaini_simulado ?>
    <tr id="r_fechaini_simulado">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_fechaini_simulado"><template id="tpc_escenario_fechaini_simulado"><?= $Page->fechaini_simulado->caption() ?></template></span></td>
        <td data-name="fechaini_simulado" <?= $Page->fechaini_simulado->cellAttributes() ?>>
<template id="tpx_escenario_fechaini_simulado"><span id="el_escenario_fechaini_simulado">
<span<?= $Page->fechaini_simulado->viewAttributes() ?>>
<?= $Page->fechaini_simulado->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechafin_simulado->Visible) { // fechafin_simulado ?>
    <tr id="r_fechafin_simulado">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_fechafin_simulado"><template id="tpc_escenario_fechafin_simulado"><?= $Page->fechafin_simulado->caption() ?></template></span></td>
        <td data-name="fechafin_simulado" <?= $Page->fechafin_simulado->cellAttributes() ?>>
<template id="tpx_escenario_fechafin_simulado"><span id="el_escenario_fechafin_simulado">
<span<?= $Page->fechafin_simulado->viewAttributes() ?>>
<?= $Page->fechafin_simulado->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <tr id="r_estado">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_estado"><template id="tpc_escenario_estado"><?= $Page->estado->caption() ?></template></span></td>
        <td data-name="estado" <?= $Page->estado->cellAttributes() ?>>
<template id="tpx_escenario_estado"><span id="el_escenario_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->image_escenario->Visible) { // image_escenario ?>
    <tr id="r_image_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_image_escenario"><template id="tpc_escenario_image_escenario"><?= $Page->image_escenario->caption() ?></template></span></td>
        <td data-name="image_escenario" <?= $Page->image_escenario->cellAttributes() ?>>
<template id="tpx_escenario_image_escenario"><span id="el_escenario_image_escenario">
<span>
<?= GetFileViewTag($Page->image_escenario, $Page->image_escenario->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->entrar->Visible) { // entrar ?>
    <tr id="r_entrar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_entrar"><template id="tpc_escenario_entrar"><?= $Page->entrar->caption() ?></template></span></td>
        <td data-name="entrar" <?= $Page->entrar->cellAttributes() ?>>
<template id="tpx_escenario_entrar" class="escenarioview">
<div class = "btn-group btn-group-sm ew-btn-group">
<?php
$id = CurrentPage()->id_escenario->CurrentValue;
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"Grupos\" data-toggle=\"Grupos\" data-table=\"escenario\" data-caption=\"Grupo\" href=\"GrupoList?showmaster=escenario&fk_id_escenario=$id&showdetail=\" data-original-title=\"Grupo\"><i class=\"fa fa-user-plus\"data-caption=\"Grupo\"></i></a> <br>";
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"Grupos\" data-toggle=\"Grupos\" data-table=\"escenario\" data-caption=\"Grupo\" href=\"Grupos?ides=$id\" data-original-title=\"Grupo\"><i class=\"fa fa-users\" aria-hidden=\"true\"></i></a> <br>";
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"Tareas\" data-table=\"escenario\" data-caption=\"Tarea\" href=\"TareasList?showmaster=escenario&fk_id_escenario=$id\" data-original-title=\"Tareas\"><i class=\"fa fa-list-alt\" data-caption=\"Tareas\"></i></a>";
?>
</div>
</template>
<template id="tpx_escenario_entrar"><span id="el_escenario_entrar">
<span<?= $Page->entrar->viewAttributes() ?>><slot name="tpx_escenario_entrar"></slot></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_escenarioview" class="ew-custom-template"></div>
<template id="tpm_escenarioview">
<div id="ct_EscenarioView">    <table>
    <tr>
    <td class='text-center' >
     
	<slot class="ew-slot" name="tpx_escenario_image_escenario"></slot>
   <h3  style="text-align:center;"> <?php echo $Language->phrase( "notaEv"); ?> </h3>
    <h2  style="text-align:center;"><slot class="ew-slot" name="tpx_escenario_nombre_escenario"></slot></h2>
    <h5  style="text-align:center;"> <?php echo $Language->phrase( "eventoEv"); ?> <slot class="ew-slot" name="tpx_escenario_incidente"></slot> <br>
    <?php echo $Language->phrase( "eventosAsociadosEv"); ?>
</slot>&nbsp;<slot class="ew-slot" name="tpx_escenario_evento_asociado"></slot><br>
<?php echo $Language->phrase( "paisEv"); ?> <slot class="ew-slot" name="tpx_escenario_pais_escenario"></slot><br>
<?php echo $Language->phrase( "fechayhoraInicio"); ?> <slot class="ew-slot" name="tpx_escenario_fechaini_real"></slot> <br> <?php echo $Language->phrase( "fechayhoraFinalizacion"); ?> <slot class="ew-slot" name="tpx_escenario_fechafinal_real"></slot></h5>
    </tr>
    </td>
    </table>
<hr>
<slot class="ew-slot" name="tpx_escenario_descripcion_escenario"></slot> 
 <hr>
</div>
</template>
<?php
    if (in_array("grupo", explode(",", $Page->getCurrentDetailTable())) && $grupo->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("grupo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "GrupoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("tareas", explode(",", $Page->getCurrentDetailTable())) && $tareas->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("tareas", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "TareasGrid.php" ?>
<?php } ?>
<?php
    if (in_array("users", explode(",", $Page->getCurrentDetailTable())) && $users->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("users", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "UsersGrid.php" ?>
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_escenarioview", "tpm_escenarioview", "escenarioview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
/*! FileSaver.js
 *  A saveAs() FileSaver implementation.
 *  2014-01-24
 *
 *  By Eli Grey, http://eligrey.com
 *  License: X11/MIT
 *    See LICENSE.md
 */

/*global self */
/*jslint bitwise: true, indent: 4, laxbreak: true, laxcomma: true, smarttabs: true, plusplus: true */

/*! @source http://purl.eligrey.com/github/FileSaver.js/blob/master/FileSaver.js */

var saveAs = saveAs
  // IE 10+ (native saveAs)
  || (typeof navigator !== "undefined" &&
      navigator.msSaveOrOpenBlob && navigator.msSaveOrOpenBlob.bind(navigator))
  // Everyone else
  || (function(view) {
	"use strict";
	// IE <10 is explicitly unsupported
	if (typeof navigator !== "undefined" &&
	    /MSIE [1-9]\./.test(navigator.userAgent)) {
		return;
	}
	var
		  doc = view.document
		  // only get URL when necessary in case BlobBuilder.js hasn't overridden it yet
		, get_URL = function() {
			return view.URL || view.webkitURL || view;
		}
		, URL = view.URL || view.webkitURL || view
		, save_link = doc.createElementNS("http://www.w3.org/1999/xhtml", "a")
		, can_use_save_link = !view.externalHost && "download" in save_link
		, click = function(node) {
			var event = doc.createEvent("MouseEvents");
			event.initMouseEvent(
				"click", true, false, view, 0, 0, 0, 0, 0
				, false, false, false, false, 0, null
			);
			node.dispatchEvent(event);
		}
		, webkit_req_fs = view.webkitRequestFileSystem
		, req_fs = view.requestFileSystem || webkit_req_fs || view.mozRequestFileSystem
		, throw_outside = function(ex) {
			(view.setImmediate || view.setTimeout)(function() {
				throw ex;
			}, 0);
		}
		, force_saveable_type = "application/octet-stream"
		, fs_min_size = 0
		, deletion_queue = []
		, process_deletion_queue = function() {
			var i = deletion_queue.length;
			while (i--) {
				var file = deletion_queue[i];
				if (typeof file === "string") { // file is an object URL
					URL.revokeObjectURL(file);
				} else { // file is a File
					file.remove();
				}
			}
			deletion_queue.length = 0; // clear queue
		}
		, dispatch = function(filesaver, event_types, event) {
			event_types = [].concat(event_types);
			var i = event_types.length;
			while (i--) {
				var listener = filesaver["on" + event_types[i]];
				if (typeof listener === "function") {
					try {
						listener.call(filesaver, event || filesaver);
					} catch (ex) {
						throw_outside(ex);
					}
				}
			}
		}
		, FileSaver = function(blob, name) {
			// First try a.download, then web filesystem, then object URLs
			var
				  filesaver = this
				, type = blob.type
				, blob_changed = false
				, object_url
				, target_view
				, get_object_url = function() {
					var object_url = get_URL().createObjectURL(blob);
					deletion_queue.push(object_url);
					return object_url;
				}
				, dispatch_all = function() {
					dispatch(filesaver, "writestart progress write writeend".split(" "));
				}
				// on any filesys errors revert to saving with object URLs
				, fs_error = function() {
					// don't create more object URLs than needed
					if (blob_changed || !object_url) {
						object_url = get_object_url(blob);
					}
					if (target_view) {
						target_view.location.href = object_url;
					} else {
						window.open(object_url, "_blank");
					}
					filesaver.readyState = filesaver.DONE;
					dispatch_all();
				}
				, abortable = function(func) {
					return function() {
						if (filesaver.readyState !== filesaver.DONE) {
							return func.apply(this, arguments);
						}
					};
				}
				, create_if_not_found = {create: true, exclusive: false}
				, slice
			;
			filesaver.readyState = filesaver.INIT;
			if (!name) {
				name = "download";
			}
			if (can_use_save_link) {
				object_url = get_object_url(blob);
				// FF for Android has a nasty garbage collection mechanism
				// that turns all objects that are not pure javascript into 'deadObject'
				// this means `doc` and `save_link` are unusable and need to be recreated
				// `view` is usable though:
				doc = view.document;
				save_link = doc.createElementNS("http://www.w3.org/1999/xhtml", "a");
				save_link.href = object_url;
				save_link.download = name;
				var event = doc.createEvent("MouseEvents");
				event.initMouseEvent(
					"click", true, false, view, 0, 0, 0, 0, 0
					, false, false, false, false, 0, null
				);
				save_link.dispatchEvent(event);
				filesaver.readyState = filesaver.DONE;
				dispatch_all();
				return;
			}
			// Object and web filesystem URLs have a problem saving in Google Chrome when
			// viewed in a tab, so I force save with application/octet-stream
			// http://code.google.com/p/chromium/issues/detail?id=91158
			if (view.chrome && type && type !== force_saveable_type) {
				slice = blob.slice || blob.webkitSlice;
				blob = slice.call(blob, 0, blob.size, force_saveable_type);
				blob_changed = true;
			}
			// Since I can't be sure that the guessed media type will trigger a download
			// in WebKit, I append .download to the filename.
			// https://bugs.webkit.org/show_bug.cgi?id=65440
			if (webkit_req_fs && name !== "download") {
				name += ".download";
			}
			if (type === force_saveable_type || webkit_req_fs) {
				target_view = view;
			}
			if (!req_fs) {
				fs_error();
				return;
			}
			fs_min_size += blob.size;
			req_fs(view.TEMPORARY, fs_min_size, abortable(function(fs) {
				fs.root.getDirectory("saved", create_if_not_found, abortable(function(dir) {
					var save = function() {
						dir.getFile(name, create_if_not_found, abortable(function(file) {
							file.createWriter(abortable(function(writer) {
								writer.onwriteend = function(event) {
									target_view.location.href = file.toURL();
									deletion_queue.push(file);
									filesaver.readyState = filesaver.DONE;
									dispatch(filesaver, "writeend", event);
								};
								writer.onerror = function() {
									var error = writer.error;
									if (error.code !== error.ABORT_ERR) {
										fs_error();
									}
								};
								"writestart progress write abort".split(" ").forEach(function(event) {
									writer["on" + event] = filesaver["on" + event];
								});
								writer.write(blob);
								filesaver.abort = function() {
									writer.abort();
									filesaver.readyState = filesaver.DONE;
								};
								filesaver.readyState = filesaver.WRITING;
							}), fs_error);
						}), fs_error);
					};
					dir.getFile(name, {create: false}, abortable(function(file) {
						// delete file if it already exists
						file.remove();
						save();
					}), abortable(function(ex) {
						if (ex.code === ex.NOT_FOUND_ERR) {
							save();
						} else {
							fs_error();
						}
					}));
				}), fs_error);
			}), fs_error);
		}
		, FS_proto = FileSaver.prototype
		, saveAs = function(blob, name) {
			return new FileSaver(blob, name);
		}
	;
	FS_proto.abort = function() {
		var filesaver = this;
		filesaver.readyState = filesaver.DONE;
		dispatch(filesaver, "abort");
	};
	FS_proto.readyState = FS_proto.INIT = 0;
	FS_proto.WRITING = 1;
	FS_proto.DONE = 2;

	FS_proto.error =
	FS_proto.onwritestart =
	FS_proto.onprogress =
	FS_proto.onwrite =
	FS_proto.onabort =
	FS_proto.onerror =
	FS_proto.onwriteend =
		null;

	view.addEventListener("unload", process_deletion_queue, false);
	saveAs.unload = function() {
		process_deletion_queue();
		view.removeEventListener("unload", process_deletion_queue, false);
	};
	return saveAs;
}(
	   typeof self !== "undefined" && self
	|| typeof window !== "undefined" && window
	|| this.content
));
// `self` is undefined in Firefox for Android content script context
// while `this` is nsIContentFrameMessageManager
// with an attribute `content` that corresponds to the window

if (typeof module !== "undefined" && module !== null) {
  module.exports = saveAs;
} else if ((typeof define !== "undefined" && define !== null) && (define.amd != null)) {
  define([], function() {
    return saveAs;
  });
}
if (typeof jQuery !== "undefined" && typeof saveAs !== "undefined") {
    (function($) {
        $.fn.wordExport = function(fileName) {
            fileName = typeof fileName !== 'undefined' ? fileName : "Nota_Conceptual";
            var static = {
                mhtml: {
                    top: "Mime-Version: 1.0\nContent-Base: " + location.href + "\nContent-Type: Multipart/related; boundary=\"NEXT.ITEM-BOUNDARY\";type=\"text/html\"\n\n--NEXT.ITEM-BOUNDARY\nContent-Type: text/html; charset=\"utf-8\"\nContent-Location: " + location.href + "\n\n<!DOCTYPE html>\n<html>\n_html_</html>",
                    head: "<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n<style>\n_styles_\n</style>\n</head>\n",
                    body: "<body>_body_</body>"
                }
            };
            var options = {
                maxWidth: 624
            };
            // Clone selected element before manipulating it
            var markup = $(this).clone();

            // Remove hidden elements from the output
            markup.each(function() {
                var self = $(this);
                if (self.is(':hidden'))
                    self.remove();
            });

            // Embed all images using Data URLs
            var images = Array();
            var img = markup.find('img');
            for (var i = 0; i < img.length; i++) {
                // Calculate dimensions of output image
                var w = Math.min(img[i].width, options.maxWidth);
                var h = img[i].height * (w / img[i].width);
                // Create canvas for converting image to data URL
                var canvas = document.createElement("CANVAS");
                canvas.width = w;
                canvas.height = h;
                // Draw image to canvas
                var context = canvas.getContext('2d');
                context.drawImage(img[i], 0, 0, w, h);
                // Get data URL encoding of image
                var uri = canvas.toDataURL("image/png");
                $(img[i]).attr("src", img[i].src);
                img[i].width = w;
                img[i].height = h;
                // Save encoded image to array
                images[i] = {
                    type: uri.substring(uri.indexOf(":") + 1, uri.indexOf(";")),
                    encoding: uri.substring(uri.indexOf(";") + 1, uri.indexOf(",")),
                    location: $(img[i]).attr("src"),
                    data: uri.substring(uri.indexOf(",") + 1)
                };
            }

            // Prepare bottom of mhtml file with image data
            var mhtmlBottom = "\n";
            for (var i = 0; i < images.length; i++) {
                mhtmlBottom += "--NEXT.ITEM-BOUNDARY\n";
                mhtmlBottom += "Content-Location: " + images[i].location + "\n";
                mhtmlBottom += "Content-Type: " + images[i].type + "\n";
                mhtmlBottom += "Content-Transfer-Encoding: " + images[i].encoding + "\n\n";
                mhtmlBottom += images[i].data + "\n\n";
            }
            mhtmlBottom += "--NEXT.ITEM-BOUNDARY--";

            //TODO: load css from included stylesheet
            var styles = "";

            // Aggregate parts of the file together
            var fileContent = static.mhtml.top.replace("_html_", static.mhtml.head.replace("_styles_", styles) + static.mhtml.body.replace("_body_", markup.html())) + mhtmlBottom;

            // Create a Blob with the file contents
            var blob = new Blob([fileContent], {
                type: "application/msword;charset=utf-8"
            });
            saveAs(blob, fileName + ".doc");
        };
    })(jQuery);
} else {
    if (typeof jQuery === "undefined") {
        console.error("jQuery Word Export: missing dependency (jQuery)");
    }
    if (typeof saveAs === "undefined") {
        console.error("jQuery Word Export: missing dependency (FileSaver.js)");
    }
}
$(".ExportToWord").click(function(event) {
            $("#tpd_escenarioview").wordExport();
        });
</script>