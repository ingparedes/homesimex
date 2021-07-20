<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Register = &$Page;
?>
<script>
var currentForm, currentPageID;
var fregister;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "register";
    fregister = currentForm = new ew.Form("fregister", "register");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "users")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.users)
        ew.vars.tables.users = currentTable;
    fregister.addFields([
        ["nombres", [fields.nombres.visible && fields.nombres.required ? ew.Validators.required(fields.nombres.caption) : null], fields.nombres.isInvalid],
        ["apellidos", [fields.apellidos.visible && fields.apellidos.required ? ew.Validators.required(fields.apellidos.caption) : null], fields.apellidos.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.username(fields._email.raw), ew.Validators.email], fields._email.isInvalid],
        ["telefono", [fields.telefono.visible && fields.telefono.required ? ew.Validators.required(fields.telefono.caption) : null], fields.telefono.isInvalid],
        ["pais", [fields.pais.visible && fields.pais.required ? ew.Validators.required(fields.pais.caption) : null], fields.pais.isInvalid],
        ["organizacion", [fields.organizacion.visible && fields.organizacion.required ? ew.Validators.required(fields.organizacion.caption) : null], fields.organizacion.isInvalid]
    ]);
    <?= Captcha()->getScript("fregister") ?>

    // Set invalid fields
    $(function() {
        var f = fregister,
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
    fregister.validate = function () {
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
        return true;
    }

    // Form_CustomValidate
    fregister.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fregister.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fregister.lists.pais = <?= $Page->pais->toClientList($Page) ?>;
    loadjs.done("fregister");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fregister" id="fregister" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="insert">
<div class="ew-register-div"><!-- page* -->
<?php if ($Page->nombres->Visible) { // nombres ?>
    <div id="r_nombres" class="form-group row">
        <label id="elh_users_nombres" for="x_nombres" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombres->caption() ?><?= $Page->nombres->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nombres->cellAttributes() ?>>
<span id="el_users_nombres">
<input type="<?= $Page->nombres->getInputTextType() ?>" data-table="users" data-field="x_nombres" name="x_nombres" id="x_nombres" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->nombres->getPlaceHolder()) ?>" value="<?= $Page->nombres->EditValue ?>"<?= $Page->nombres->editAttributes() ?> aria-describedby="x_nombres_help">
<?= $Page->nombres->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombres->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
    <div id="r_apellidos" class="form-group row">
        <label id="elh_users_apellidos" for="x_apellidos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellidos->caption() ?><?= $Page->apellidos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->apellidos->cellAttributes() ?>>
<span id="el_users_apellidos">
<input type="<?= $Page->apellidos->getInputTextType() ?>" data-table="users" data-field="x_apellidos" name="x_apellidos" id="x_apellidos" size="30" maxlength="90" placeholder="<?= HtmlEncode($Page->apellidos->getPlaceHolder()) ?>" value="<?= $Page->apellidos->EditValue ?>"<?= $Page->apellidos->editAttributes() ?> aria-describedby="x_apellidos_help">
<?= $Page->apellidos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellidos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="form-group row">
        <label id="elh_users__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_email->cellAttributes() ?>>
<span id="el_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="users" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
    <div id="r_telefono" class="form-group row">
        <label id="elh_users_telefono" for="x_telefono" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono->caption() ?><?= $Page->telefono->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->telefono->cellAttributes() ?>>
<span id="el_users_telefono">
<input type="<?= $Page->telefono->getInputTextType() ?>" data-table="users" data-field="x_telefono" name="x_telefono" id="x_telefono" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telefono->getPlaceHolder()) ?>" value="<?= $Page->telefono->EditValue ?>"<?= $Page->telefono->editAttributes() ?> aria-describedby="x_telefono_help">
<?= $Page->telefono->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pais->Visible) { // pais ?>
    <div id="r_pais" class="form-group row">
        <label id="elh_users_pais" for="x_pais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pais->caption() ?><?= $Page->pais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pais->cellAttributes() ?>>
<span id="el_users_pais">
    <select
        id="x_pais"
        name="x_pais"
        class="form-control ew-select<?= $Page->pais->isInvalidClass() ?>"
        data-select2-id="users_x_pais"
        data-table="users"
        data-field="x_pais"
        data-value-separator="<?= $Page->pais->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pais->getPlaceHolder()) ?>"
        <?= $Page->pais->editAttributes() ?>>
        <option></option>
        <option value='1'>AF, Afghanistan, Asia/Kabul, UTC +04:30</option>
        <option value='2'>AX, Aland Islands, Europe/Mariehamn, UTC +03:00</option>
        <option value='3'>AL, Albania, Europe/Tirane, UTC +02:00</option>
        <option value='4'>DZ, Algeria, Africa/Algiers, UTC +01:00</option>
        <option value='5'>AS, American Samoa, Pacific/Pago_Pago, UTC -11:00</option>
        <option value='6'>AD, Andorra, Europe/Andorra, UTC +02:00</option>
        <option value='7'>AO, Angola, Africa/Luanda, UTC +01:00</option>
        <option value='8'>AI, Anguilla, America/Anguilla, UTC -04:00</option>
        <option value='9'>AQ, Antarctica, Antarctica/Casey, UTC +08:00</option>
        <option value='10'>AQ, Antarctica, Antarctica/Davis, UTC +07:00</option>
        <option value='11'>AQ, Antarctica, Antarctica/DumontDUrville, UTC +10:00</option>
        <option value='12'>AQ, Antarctica, Antarctica/Mawson, UTC +05:00</option>
        <option value='13'>AQ, Antarctica, Antarctica/McMurdo, UTC +12:00</option>
        <option value='14'>AQ, Antarctica, Antarctica/Palmer, UTC -03:00</option>
        <option value='15'>AQ, Antarctica, Antarctica/Rothera, UTC -03:00</option>
        <option value='16'>AQ, Antarctica, Antarctica/Syowa, UTC +03:00</option>
        <option value='17'>AQ, Antarctica, Antarctica/Troll, UTC +02:00</option>
        <option value='18'>AQ, Antarctica, Antarctica/Vostok, UTC +06:00</option>
        <option value='19'>AG, Antigua and Barbuda, America/Antigua, UTC -04:00</option>
        <option value='20'>AR, Argentina, America/Argentina/Buenos_Aires, UTC -03:00</option>
        <option value='21'>AR, Argentina, America/Argentina/Catamarca, UTC -03:00</option>
        <option value='22'>AR, Argentina, America/Argentina/Cordoba, UTC -03:00</option>
        <option value='23'>AR, Argentina, America/Argentina/Jujuy, UTC -03:00</option>
        <option value='24'>AR, Argentina, America/Argentina/La_Rioja, UTC -03:00</option>
        <option value='25'>AR, Argentina, America/Argentina/Mendoza, UTC -03:00</option>
        <option value='26'>AR, Argentina, America/Argentina/Rio_Gallegos, UTC -03:00</option>
        <option value='27'>AR, Argentina, America/Argentina/Salta, UTC -03:00</option>
        <option value='28'>AR, Argentina, America/Argentina/San_Juan, UTC -03:00</option>
        <option value='29'>AR, Argentina, America/Argentina/San_Luis, UTC -03:00</option>
        <option value='30'>AR, Argentina, America/Argentina/Tucuman, UTC -03:00</option>
        <option value='31'>AR, Argentina, America/Argentina/Ushuaia, UTC -03:00</option>
        <option value='32'>AM, Armenia, Asia/Yerevan, UTC +04:00</option>
        <option value='33'>AW, Aruba, America/Aruba, UTC -04:00</option>
        <option value='34'>AU, Australia, Antarctica/Macquarie, UTC +11:00</option>
        <option value='35'>AU, Australia, Australia/Adelaide, UTC +09:30</option>
        <option value='36'>AU, Australia, Australia/Brisbane, UTC +10:00</option>
        <option value='37'>AU, Australia, Australia/Broken_Hill, UTC +09:30</option>
        <option value='38'>AU, Australia, Australia/Currie, UTC +10:00</option>
        <option value='39'>AU, Australia, Australia/Darwin, UTC +09:30</option>
        <option value='40'>AU, Australia, Australia/Eucla, UTC +08:45</option>
        <option value='41'>AU, Australia, Australia/Hobart, UTC +10:00</option>
        <option value='42'>AU, Australia, Australia/Lindeman, UTC +10:00</option>
        <option value='43'>AU, Australia, Australia/Lord_Howe, UTC +10:30</option>
        <option value='44'>AU, Australia, Australia/Melbourne, UTC +10:00</option>
        <option value='45'>AU, Australia, Australia/Perth, UTC +08:00</option>
        <option value='46'>AU, Australia, Australia/Sydney, UTC +10:00</option>
        <option value='47'>AT, Austria, Europe/Vienna, UTC +02:00</option>
        <option value='48'>AZ, Azerbaijan, Asia/Baku, UTC +04:00</option>
        <option value='49'>BS, Bahamas, America/Nassau, UTC -04:00</option>
        <option value='50'>BH, Bahrain, Asia/Bahrain, UTC +03:00</option>
        <option value='51'>BD, Bangladesh, Asia/Dhaka, UTC +06:00</option>
        <option value='52'>BB, Barbados, America/Barbados, UTC -04:00</option>
        <option value='53'>BY, Belarus, Europe/Minsk, UTC +03:00</option>
        <option value='54'>BE, Belgium, Europe/Brussels, UTC +02:00</option>
        <option value='55'>BZ, Belize, America/Belize, UTC -06:00</option>
        <option value='56'>BJ, Benin, Africa/Porto-Novo, UTC +01:00</option>
        <option value='57'>BM, Bermuda, Atlantic/Bermuda, UTC -03:00</option>
        <option value='58'>BT, Bhutan, Asia/Thimphu, UTC +06:00</option>
        <option value='59'>BO, Bolivia, America/La_Paz, UTC -04:00</option>
        <option value='60'>BQ, Bonaire, Saint Eustatius and Saba, America/Kralendijk, UTC -04:00</option>
        <option value='61'>BA, Bosnia and Herzegovina, Europe/Sarajevo, UTC +02:00</option>
        <option value='62'>BW, Botswana, Africa/Gaborone, UTC +02:00</option>
        <option value='63'>BR, Brazil, America/Araguaina, UTC -03:00</option>
        <option value='64'>BR, Brazil, America/Bahia, UTC -03:00</option>
        <option value='65'>BR, Brazil, America/Belem, UTC -03:00</option>
        <option value='66'>BR, Brazil, America/Boa_Vista, UTC -04:00</option>
        <option value='67'>BR, Brazil, America/Campo_Grande, UTC -04:00</option>
        <option value='68'>BR, Brazil, America/Cuiaba, UTC -04:00</option>
        <option value='69'>BR, Brazil, America/Eirunepe, UTC -05:00</option>
        <option value='70'>BR, Brazil, America/Fortaleza, UTC -03:00</option>
        <option value='71'>BR, Brazil, America/Maceio, UTC -03:00</option>
        <option value='72'>BR, Brazil, America/Manaus, UTC -04:00</option>
        <option value='73'>BR, Brazil, America/Noronha, UTC -02:00</option>
        <option value='74'>BR, Brazil, America/Porto_Velho, UTC -04:00</option>
        <option value='75'>BR, Brazil, America/Recife, UTC -03:00</option>
        <option value='76'>BR, Brazil, America/Rio_Branco, UTC -05:00</option>
        <option value='77'>BR, Brazil, America/Santarem, UTC -03:00</option>
        <option value='78'>BR, Brazil, America/Sao_Paulo, UTC -03:00</option>
        <option value='79'>IO, British Indian Ocean Territory, Indian/Chagos, UTC +06:00</option>
        <option value='80'>VG, British Virgin Islands, America/Tortola, UTC -04:00</option>
        <option value='81'>BN, Brunei, Asia/Brunei, UTC +08:00</option>
        <option value='82'>BG, Bulgaria, Europe/Sofia, UTC +03:00</option>
        <option value='83'>BF, Burkina Faso, Africa/Ouagadougou, UTC</option>
        <option value='84'>BI, Burundi, Africa/Bujumbura, UTC +02:00</option>
        <option value='85'>KH, Cambodia, Asia/Phnom_Penh, UTC +07:00</option>
        <option value='86'>CM, Cameroon, Africa/Douala, UTC +01:00</option>
        <option value='87'>CA, Canada, America/Atikokan, UTC -05:00</option>
        <option value='88'>CA, Canada, America/Blanc-Sablon, UTC -04:00</option>
        <option value='89'>CA, Canada, America/Cambridge_Bay, UTC -06:00</option>
        <option value='90'>CA, Canada, America/Creston, UTC -07:00</option>
        <option value='91'>CA, Canada, America/Dawson, UTC -07:00</option>
        <option value='92'>CA, Canada, America/Dawson_Creek, UTC -07:00</option>
        <option value='93'>CA, Canada, America/Edmonton, UTC -06:00</option>
        <option value='94'>CA, Canada, America/Fort_Nelson, UTC -07:00</option>
        <option value='95'>CA, Canada, America/Glace_Bay, UTC -03:00</option>
        <option value='96'>CA, Canada, America/Goose_Bay, UTC -03:00</option>
        <option value='97'>CA, Canada, America/Halifax, UTC -03:00</option>
        <option value='98'>CA, Canada, America/Inuvik, UTC -06:00</option>
        <option value='99'>CA, Canada, America/Iqaluit, UTC -04:00</option>
        <option value='100'>CA, Canada, America/Moncton, UTC -03:00</option>
        <option value='101'>CA, Canada, America/Nipigon, UTC -04:00</option>
        <option value='102'>CA, Canada, America/Pangnirtung, UTC -04:00</option>
        <option value='103'>CA, Canada, America/Rainy_River, UTC -05:00</option>
        <option value='104'>CA, Canada, America/Rankin_Inlet, UTC -05:00</option>
        <option value='105'>CA, Canada, America/Regina, UTC -06:00</option>
        <option value='106'>CA, Canada, America/Resolute, UTC -05:00</option>
        <option value='107'>CA, Canada, America/St_Johns, UTC -02:30</option>
        <option value='108'>CA, Canada, America/Swift_Current, UTC -06:00</option>
        <option value='109'>CA, Canada, America/Thunder_Bay, UTC -04:00</option>
        <option value='110'>CA, Canada, America/Toronto, UTC -04:00</option>
        <option value='111'>CA, Canada, America/Vancouver, UTC -07:00</option>
        <option value='112'>CA, Canada, America/Whitehorse, UTC -07:00</option>
        <option value='113'>CA, Canada, America/Winnipeg, UTC -05:00</option>
        <option value='114'>CA, Canada, America/Yellowknife, UTC -06:00</option>
        <option value='115'>CV, Cape Verde, Atlantic/Cape_Verde, UTC -01:00</option>
        <option value='116'>KY, Cayman Islands, America/Cayman, UTC -05:00</option>
        <option value='117'>CF, Central African Republic, Africa/Bangui, UTC +01:00</option>
        <option value='118'>TD, Chad, Africa/Ndjamena, UTC +01:00</option>
        <option value='119'>CL, Chile, America/Punta_Arenas, UTC -03:00</option>
        <option value='120'>CL, Chile, America/Santiago, UTC -04:00</option>
        <option value='121'>CL, Chile, Pacific/Easter, UTC -06:00</option>
        <option value='122'>CN, China, Asia/Shanghai, UTC +08:00</option>
        <option value='123'>CN, China, Asia/Urumqi, UTC +06:00</option>
        <option value='124'>CX, Christmas Island, Indian/Christmas, UTC +07:00</option>
        <option value='125'>CC, Cocos Islands, Indian/Cocos, UTC +06:30</option>
        <option value='126'>CO, Colombia, America/Bogota, UTC -05:00</option>
        <option value='127'>KM, Comoros, Indian/Comoro, UTC +03:00</option>
        <option value='128'>CK, Cook Islands, Pacific/Rarotonga, UTC -10:00</option>
        <option value='129'>CR, Costa Rica, America/Costa_Rica, UTC -06:00</option>
        <option value='130'>HR, Croatia, Europe/Zagreb, UTC +02:00</option>
        <option value='131'>CU, Cuba, America/Havana, UTC -04:00</option>
        <option value='132'>CW, Curaçao, America/Curacao, UTC -04:00</option>
        <option value='133'>CY, Cyprus, Asia/Famagusta, UTC +03:00</option>
        <option value='134'>CY, Cyprus, Asia/Nicosia, UTC +03:00</option>
        <option value='135'>CZ, Czech Republic, Europe/Prague, UTC +02:00</option>
        <option value='136'>CD, Democratic Republic of the Congo, Africa/Kinshasa, UTC +01:00</option>
        <option value='137'>CD, Democratic Republic of the Congo, Africa/Lubumbashi, UTC +02:00</option>
        <option value='138'>DK, Denmark, Europe/Copenhagen, UTC +02:00</option>
        <option value='139'>DJ, Djibouti, Africa/Djibouti, UTC +03:00</option>
        <option value='140'>DM, Dominica, America/Dominica, UTC -04:00</option>
        <option value='141'>DO, Dominican Republic, America/Santo_Domingo, UTC -04:00</option>
        <option value='142'>TL, East Timor, Asia/Dili, UTC +09:00</option>
        <option value='143'>EC, Ecuador, America/Guayaquil, UTC -05:00</option>
        <option value='144'>EC, Ecuador, Pacific/Galapagos, UTC -06:00</option>
        <option value='145'>EG, Egypt, Africa/Cairo, UTC +02:00</option>
        <option value='146'>SV, El Salvador, America/El_Salvador, UTC -06:00</option>
        <option value='147'>GQ, Equatorial Guinea, Africa/Malabo, UTC +01:00</option>
        <option value='148'>ER, Eritrea, Africa/Asmara, UTC +03:00</option>
        <option value='149'>EE, Estonia, Europe/Tallinn, UTC +03:00</option>
        <option value='150'>ET, Ethiopia, Africa/Addis_Ababa, UTC +03:00</option>
        <option value='151'>FK, Falkland Islands, Atlantic/Stanley, UTC -03:00</option>
        <option value='152'>FO, Faroe Islands, Atlantic/Faroe, UTC +01:00</option>
        <option value='153'>FJ, Fiji, Pacific/Fiji, UTC +12:00</option>
        <option value='154'>FI, Finland, Europe/Helsinki, UTC +03:00</option>
        <option value='155'>FR, France, Europe/Paris, UTC +02:00</option>
        <option value='156'>GF, French Guiana, America/Cayenne, UTC -03:00</option>
        <option value='157'>PF, French Polynesia, Pacific/Gambier, UTC -09:00</option>
        <option value='158'>PF, French Polynesia, Pacific/Marquesas, UTC -09:30</option>
        <option value='159'>PF, French Polynesia, Pacific/Tahiti, UTC -10:00</option>
        <option value='160'>TF, French Southern Territories, Indian/Kerguelen, UTC +05:00</option>
        <option value='161'>GA, Gabon, Africa/Libreville, UTC +01:00</option>
        <option value='162'>GM, Gambia, Africa/Banjul, UTC</option>
        <option value='163'>GE, Georgia, Asia/Tbilisi, UTC +04:00</option>
        <option value='164'>DE, Germany, Europe/Berlin, UTC +02:00</option>
        <option value='165'>DE, Germany, Europe/Busingen, UTC +02:00</option>
        <option value='166'>GH, Ghana, Africa/Accra, UTC</option>
        <option value='167'>GI, Gibraltar, Europe/Gibraltar, UTC +02:00</option>
        <option value='168'>GR, Greece, Europe/Athens, UTC +03:00</option>
        <option value='169'>GL, Greenland, America/Danmarkshavn, UTC</option>
        <option value='170'>GL, Greenland, America/Godthab, UTC -02:00</option>
        <option value='171'>GL, Greenland, America/Scoresbysund, UTC</option>
        <option value='172'>GL, Greenland, America/Thule, UTC -03:00</option>
        <option value='173'>GD, Grenada, America/Grenada, UTC -04:00</option>
        <option value='174'>GP, Guadeloupe, America/Guadeloupe, UTC -04:00</option>
        <option value='175'>GU, Guam, Pacific/Guam, UTC +10:00</option>
        <option value='176'>GT, Guatemala, America/Guatemala, UTC -06:00</option>
        <option value='177'>GG, Guernsey, Europe/Guernsey, UTC +01:00</option>
        <option value='178'>GN, Guinea, Africa/Conakry, UTC</option>
        <option value='179'>GW, Guinea-Bissau, Africa/Bissau, UTC</option>
        <option value='180'>GY, Guyana, America/Guyana, UTC -04:00</option>
        <option value='181'>HT, Haiti, America/Port-au-Prince, UTC -04:00</option>
        <option value='182'>HN, Honduras, America/Tegucigalpa, UTC -06:00</option>
        <option value='183'>HK, Hong Kong, Asia/Hong_Kong, UTC +08:00</option>
        <option value='184'>HU, Hungary, Europe/Budapest, UTC +02:00</option>
        <option value='185'>IS, Iceland, Atlantic/Reykjavik, UTC</option>
        <option value='186'>IN, India, Asia/Kolkata, UTC +05:30</option>
        <option value='187'>ID, Indonesia, Asia/Jakarta, UTC +07:00</option>
        <option value='188'>ID, Indonesia, Asia/Jayapura, UTC +09:00</option>
        <option value='189'>ID, Indonesia, Asia/Makassar, UTC +08:00</option>
        <option value='190'>ID, Indonesia, Asia/Pontianak, UTC +07:00</option>
        <option value='191'>IR, Iran, Asia/Tehran, UTC +04:30</option>
        <option value='192'>IQ, Iraq, Asia/Baghdad, UTC +03:00</option>
        <option value='193'>IE, Ireland, Europe/Dublin, UTC +01:00</option>
        <option value='194'>IM, Isle of Man, Europe/Isle_of_Man, UTC +01:00</option>
        <option value='195'>IL, Israel, Asia/Jerusalem, UTC +03:00</option>
        <option value='196'>IT, Italy, Europe/Rome, UTC +02:00</option>
        <option value='197'>CI, Ivory Coast, Africa/Abidjan, UTC</option>
        <option value='198'>JM, Jamaica, America/Jamaica, UTC -05:00</option>
        <option value='199'>JP, Japan, Asia/Tokyo, UTC +09:00</option>
        <option value='200'>JE, Jersey, Europe/Jersey, UTC +01:00</option>
        <option value='201'>JO, Jordan, Asia/Amman, UTC +03:00</option>
        <option value='202'>KZ, Kazakhstan, Asia/Almaty, UTC +06:00</option>
        <option value='203'>KZ, Kazakhstan, Asia/Aqtau, UTC +05:00</option>
        <option value='204'>KZ, Kazakhstan, Asia/Aqtobe, UTC +05:00</option>
        <option value='205'>KZ, Kazakhstan, Asia/Atyrau, UTC +05:00</option>
        <option value='206'>KZ, Kazakhstan, Asia/Oral, UTC +05:00</option>
        <option value='207'>KZ, Kazakhstan, Asia/Qyzylorda, UTC +06:00</option>
        <option value='208'>KE, Kenya, Africa/Nairobi, UTC +03:00</option>
        <option value='209'>KI, Kiribati, Pacific/Enderbury, UTC +13:00</option>
        <option value='210'>KI, Kiribati, Pacific/Kiritimati, UTC +14:00</option>
        <option value='211'>KI, Kiribati, Pacific/Tarawa, UTC +12:00</option>
        <option value='212'>KW, Kuwait, Asia/Kuwait, UTC +03:00</option>
        <option value='213'>KG, Kyrgyzstan, Asia/Bishkek, UTC +06:00</option>
        <option value='214'>LA, Laos, Asia/Vientiane, UTC +07:00</option>
        <option value='215'>LV, Latvia, Europe/Riga, UTC +03:00</option>
        <option value='216'>LB, Lebanon, Asia/Beirut, UTC +03:00</option>
        <option value='217'>LS, Lesotho, Africa/Maseru, UTC +02:00</option>
        <option value='218'>LR, Liberia, Africa/Monrovia, UTC</option>
        <option value='219'>LY, Libya, Africa/Tripoli, UTC +02:00</option>
        <option value='220'>LI, Liechtenstein, Europe/Vaduz, UTC +02:00</option>
        <option value='221'>LT, Lithuania, Europe/Vilnius, UTC +03:00</option>
        <option value='222'>LU, Luxembourg, Europe/Luxembourg, UTC +02:00</option>
        <option value='223'>MO, Macao, Asia/Macau, UTC +08:00</option>
        <option value='224'>MK, Macedonia, Europe/Skopje, UTC +02:00</option>
        <option value='225'>MG, Madagascar, Indian/Antananarivo, UTC +03:00</option>
        <option value='226'>MW, Malawi, Africa/Blantyre, UTC +02:00</option>
        <option value='227'>MY, Malaysia, Asia/Kuala_Lumpur, UTC +08:00</option>
        <option value='228'>MY, Malaysia, Asia/Kuching, UTC +08:00</option>
        <option value='229'>MV, Maldives, Indian/Maldives, UTC +05:00</option>
        <option value='230'>ML, Mali, Africa/Bamako, UTC</option>
        <option value='231'>MT, Malta, Europe/Malta, UTC +02:00</option>
        <option value='232'>MH, Marshall Islands, Pacific/Kwajalein, UTC +12:00</option>
        <option value='233'>MH, Marshall Islands, Pacific/Majuro, UTC +12:00</option>
        <option value='234'>MQ, Martinique, America/Martinique, UTC -04:00</option>
        <option value='235'>MR, Mauritania, Africa/Nouakchott, UTC</option>
        <option value='236'>MU, Mauritius, Indian/Mauritius, UTC +04:00</option>
        <option value='237'>YT, Mayotte, Indian/Mayotte, UTC +03:00</option>
        <option value='238'>MX, Mexico, America/Bahia_Banderas, UTC -05:00</option>
        <option value='239'>MX, Mexico, America/Cancun, UTC -05:00</option>
        <option value='240'>MX, Mexico, America/Chihuahua, UTC -06:00</option>
        <option value='241'>MX, Mexico, America/Hermosillo, UTC -07:00</option>
        <option value='242'>MX, Mexico, America/Matamoros, UTC -05:00</option>
        <option value='243'>MX, Mexico, America/Mazatlan, UTC -06:00</option>
        <option value='244'>MX, Mexico, America/Merida, UTC -05:00</option>
        <option value='245'>MX, Mexico, America/Mexico_City, UTC -05:00</option>
        <option value='246'>MX, Mexico, America/Monterrey, UTC -05:00</option>
        <option value='247'>MX, Mexico, America/Ojinaga, UTC -06:00</option>
        <option value='248'>MX, Mexico, America/Tijuana, UTC -07:00</option>
        <option value='249'>FM, Micronesia, Pacific/Chuuk, UTC +10:00</option>
        <option value='250'>FM, Micronesia, Pacific/Kosrae, UTC +11:00</option>
        <option value='251'>FM, Micronesia, Pacific/Pohnpei, UTC +11:00</option>
        <option value='252'>MD, Moldova, Europe/Chisinau, UTC +03:00</option>
        <option value='253'>MC, Monaco, Europe/Monaco, UTC +02:00</option>
        <option value='254'>MN, Mongolia, Asia/Choibalsan, UTC +08:00</option>
        <option value='255'>MN, Mongolia, Asia/Hovd, UTC +07:00</option>
        <option value='256'>MN, Mongolia, Asia/Ulaanbaatar, UTC +08:00</option>
        <option value='257'>ME, Montenegro, Europe/Podgorica, UTC +02:00</option>
        <option value='258'>MS, Montserrat, America/Montserrat, UTC -04:00</option>
        <option value='259'>MA, Morocco, Africa/Casablanca, UTC +01:00</option>
        <option value='260'>MZ, Mozambique, Africa/Maputo, UTC +02:00</option>
        <option value='261'>MM, Myanmar, Asia/Yangon, UTC +06:30</option>
        <option value='262'>NA, Namibia, Africa/Windhoek, UTC +02:00</option>
        <option value='263'>NR, Nauru, Pacific/Nauru, UTC +12:00</option>
        <option value='264'>NP, Nepal, Asia/Kathmandu, UTC +05:45</option>
        <option value='265'>NL, Netherlands, Europe/Amsterdam, UTC +02:00</option>
        <option value='266'>NC, New Caledonia, Pacific/Noumea, UTC +11:00</option>
        <option value='267'>NZ, New Zealand, Pacific/Auckland, UTC +12:00</option>
        <option value='268'>NZ, New Zealand, Pacific/Chatham, UTC +12:45</option>
        <option value='269'>NI, Nicaragua, America/Managua, UTC -06:00</option>
        <option value='270'>NE, Niger, Africa/Niamey, UTC +01:00</option>
        <option value='271'>NG, Nigeria, Africa/Lagos, UTC +01:00</option>
        <option value='272'>NU, Niue, Pacific/Niue, UTC -11:00</option>
        <option value='273'>NF, Norfolk Island, Pacific/Norfolk, UTC +11:00</option>
        <option value='274'>KP, North Korea, Asia/Pyongyang, UTC +09:00</option>
        <option value='275'>MP, Northern Mariana Islands, Pacific/Saipan, UTC +10:00</option>
        <option value='276'>NO, Norway, Europe/Oslo, UTC +02:00</option>
        <option value='277'>OM, Oman, Asia/Muscat, UTC +04:00</option>
        <option value='278'>PK, Pakistan, Asia/Karachi, UTC +05:00</option>
        <option value='279'>PW, Palau, Pacific/Palau, UTC +09:00</option>
        <option value='280'>PS, Palestinian Territory, Asia/Gaza, UTC +03:00</option>
        <option value='281'>PS, Palestinian Territory, Asia/Hebron, UTC +03:00</option>
        <option value='282'>PA, Panama, America/Panama, UTC -05:00</option>
        <option value='283'>PG, Papua New Guinea, Pacific/Bougainville, UTC +11:00</option>
        <option value='284'>PG, Papua New Guinea, Pacific/Port_Moresby, UTC +10:00</option>
        <option value='285'>PY, Paraguay, America/Asuncion, UTC -04:00</option>
        <option value='286'>PE, Peru, America/Lima, UTC -05:00</option>
        <option value='287'>PH, Philippines, Asia/Manila, UTC +08:00</option>
        <option value='288'>PN, Pitcairn, Pacific/Pitcairn, UTC -08:00</option>
        <option value='289'>PL, Poland, Europe/Warsaw, UTC +02:00</option>
        <option value='290'>PT, Portugal, Atlantic/Azores, UTC</option>
        <option value='291'>PT, Portugal, Atlantic/Madeira, UTC +01:00</option>
        <option value='292'>PT, Portugal, Europe/Lisbon, UTC +01:00</option>
        <option value='293'>PR, Puerto Rico, America/Puerto_Rico, UTC -04:00</option>
        <option value='294'>QA, Qatar, Asia/Qatar, UTC +03:00</option>
        <option value='295'>CG, Republic of the Congo, Africa/Brazzaville, UTC +01:00</option>
        <option value='296'>RE, Reunion, Indian/Reunion, UTC +04:00</option>
        <option value='297'>RO, Romania, Europe/Bucharest, UTC +03:00</option>
        <option value='298'>RU, Russia, Asia/Anadyr, UTC +12:00</option>
        <option value='299'>RU, Russia, Asia/Barnaul, UTC +07:00</option>
        <option value='300'>RU, Russia, Asia/Chita, UTC +09:00</option>
        <option value='301'>RU, Russia, Asia/Irkutsk, UTC +08:00</option>
        <option value='302'>RU, Russia, Asia/Kamchatka, UTC +12:00</option>
        <option value='303'>RU, Russia, Asia/Khandyga, UTC +09:00</option>
        <option value='304'>RU, Russia, Asia/Krasnoyarsk, UTC +07:00</option>
        <option value='305'>RU, Russia, Asia/Magadan, UTC +11:00</option>
        <option value='306'>RU, Russia, Asia/Novokuznetsk, UTC +07:00</option>
        <option value='307'>RU, Russia, Asia/Novosibirsk, UTC +07:00</option>
        <option value='308'>RU, Russia, Asia/Omsk, UTC +06:00</option>
        <option value='309'>RU, Russia, Asia/Sakhalin, UTC +11:00</option>
        <option value='310'>RU, Russia, Asia/Srednekolymsk, UTC +11:00</option>
        <option value='311'>RU, Russia, Asia/Tomsk, UTC +07:00</option>
        <option value='312'>RU, Russia, Asia/Ust-Nera, UTC +10:00</option>
        <option value='313'>RU, Russia, Asia/Vladivostok, UTC +10:00</option>
        <option value='314'>RU, Russia, Asia/Yakutsk, UTC +09:00</option>
        <option value='315'>RU, Russia, Asia/Yekaterinburg, UTC +05:00</option>
        <option value='316'>RU, Russia, Europe/Astrakhan, UTC +04:00</option>
        <option value='317'>RU, Russia, Europe/Kaliningrad, UTC +02:00</option>
        <option value='318'>RU, Russia, Europe/Kirov, UTC +03:00</option>
        <option value='319'>RU, Russia, Europe/Moscow, UTC +03:00</option>
        <option value='320'>RU, Russia, Europe/Samara, UTC +04:00</option>
        <option value='321'>RU, Russia, Europe/Saratov, UTC +04:00</option>
        <option value='322'>RU, Russia, Europe/Simferopol, UTC +03:00</option>
        <option value='323'>RU, Russia, Europe/Ulyanovsk, UTC +04:00</option>
        <option value='324'>RU, Russia, Europe/Volgograd, UTC +03:00</option>
        <option value='325'>RW, Rwanda, Africa/Kigali, UTC +02:00</option>
        <option value='326'>BL, Saint Barthélemy, America/St_Barthelemy, UTC -04:00</option>
        <option value='327'>SH, Saint Helena, Atlantic/St_Helena, UTC</option>
        <option value='328'>KN, Saint Kitts and Nevis, America/St_Kitts, UTC -04:00</option>
        <option value='329'>LC, Saint Lucia, America/St_Lucia, UTC -04:00</option>
        <option value='330'>MF, Saint Martin, America/Marigot, UTC -04:00</option>
        <option value='331'>PM, Saint Pierre and Miquelon, America/Miquelon, UTC -02:00</option>
        <option value='332'>VC, Saint Vincent and the Grenadines, America/St_Vincent, UTC -04:00</option>
        <option value='333'>WS, Samoa, Pacific/Apia, UTC +13:00</option>
        <option value='334'>SM, San Marino, Europe/San_Marino, UTC +02:00</option>
        <option value='335'>ST, Sao Tome and Principe, Africa/Sao_Tome, UTC +01:00</option>
        <option value='336'>SA, Saudi Arabia, Asia/Riyadh, UTC +03:00</option>
        <option value='337'>SN, Senegal, Africa/Dakar, UTC</option>
        <option value='338'>RS, Serbia, Europe/Belgrade, UTC +02:00</option>
        <option value='339'>SC, Seychelles, Indian/Mahe, UTC +04:00</option>
        <option value='340'>SL, Sierra Leone, Africa/Freetown, UTC</option>
        <option value='341'>SG, Singapore, Asia/Singapore, UTC +08:00</option>
        <option value='342'>SX, Sint Maarten, America/Lower_Princes, UTC -04:00</option>
        <option value='343'>SK, Slovakia, Europe/Bratislava, UTC +02:00</option>
        <option value='344'>SI, Slovenia, Europe/Ljubljana, UTC +02:00</option>
        <option value='345'>SB, Solomon Islands, Pacific/Guadalcanal, UTC +11:00</option>
        <option value='346'>SO, Somalia, Africa/Mogadishu, UTC +03:00</option>
        <option value='347'>ZA, South Africa, Africa/Johannesburg, UTC +02:00</option>
        <option value='348'>GS, South Georgia and the South Sandwich Islands, Atlantic/South_Georgia, UTC -02:00</option>
        <option value='349'>KR, South Korea, Asia/Seoul, UTC +09:00</option>
        <option value='350'>SS, South Sudan, Africa/Juba, UTC +03:00</option>
        <option value='351'>ES, Spain, Africa/Ceuta, UTC +02:00</option>
        <option value='352'>ES, Spain, Atlantic/Canary, UTC +01:00</option>
        <option value='353'>ES, Spain, Europe/Madrid, UTC +02:00</option>
        <option value='354'>LK, Sri Lanka, Asia/Colombo, UTC +05:30</option>
        <option value='355'>SD, Sudan, Africa/Khartoum, UTC +02:00</option>
        <option value='356'>SR, Suriname, America/Paramaribo, UTC -03:00</option>
        <option value='357'>SJ, Svalbard and Jan Mayen, Arctic/Longyearbyen, UTC +02:00</option>
        <option value='358'>SZ, Swaziland, Africa/Mbabane, UTC +02:00</option>
        <option value='359'>SE, Sweden, Europe/Stockholm, UTC +02:00</option>
        <option value='360'>CH, Switzerland, Europe/Zurich, UTC +02:00</option>
        <option value='361'>SY, Syria, Asia/Damascus, UTC +03:00</option>
        <option value='362'>TW, Taiwan, Asia/Taipei, UTC +08:00</option>
        <option value='363'>TJ, Tajikistan, Asia/Dushanbe, UTC +05:00</option>
        <option value='364'>TZ, Tanzania, Africa/Dar_es_Salaam, UTC +03:00</option>
        <option value='365'>TH, Thailand, Asia/Bangkok, UTC +07:00</option>
        <option value='366'>TG, Togo, Africa/Lome, UTC</option>
        <option value='367'>TK, Tokelau, Pacific/Fakaofo, UTC +13:00</option>
        <option value='368'>TO, Tonga, Pacific/Tongatapu, UTC +13:00</option>
        <option value='369'>TT, Trinidad and Tobago, America/Port_of_Spain, UTC -04:00</option>
        <option value='370'>TN, Tunisia, Africa/Tunis, UTC +01:00</option>
        <option value='371'>TR, Turkey, Europe/Istanbul, UTC +03:00</option>
        <option value='372'>TM, Turkmenistan, Asia/Ashgabat, UTC +05:00</option>
        <option value='373'>TC, Turks and Caicos Islands, America/Grand_Turk, UTC -04:00</option>
        <option value='374'>TV, Tuvalu, Pacific/Funafuti, UTC +12:00</option>
        <option value='375'>VI, U.S. Virgin Islands, America/St_Thomas, UTC -04:00</option>
        <option value='376'>UG, Uganda, Africa/Kampala, UTC +03:00</option>
        <option value='377'>UA, Ukraine, Europe/Kiev, UTC +03:00</option>
        <option value='378'>UA, Ukraine, Europe/Uzhgorod, UTC +03:00</option>
        <option value='379'>UA, Ukraine, Europe/Zaporozhye, UTC +03:00</option>
        <option value='380'>AE, United Arab Emirates, Asia/Dubai, UTC +04:00</option>
        <option value='381'>GB, United Kingdom, Europe/London, UTC +01:00</option>
        <option value='382'>US, United States, America/Adak, UTC -09:00</option>
        <option value='383'>US, United States, America/Anchorage, UTC -08:00</option>
        <option value='384'>US, United States, America/Boise, UTC -06:00</option>
        <option value='385'>US, United States, America/Chicago, UTC -05:00</option>
        <option value='386'>US, United States, America/Denver, UTC -06:00</option>
        <option value='387'>US, United States, America/Detroit, UTC -04:00</option>
        <option value='388'>US, United States, America/Indiana/Indianapolis, UTC -04:00</option>
        <option value='389'>US, United States, America/Indiana/Knox, UTC -05:00</option>
        <option value='390'>US, United States, America/Indiana/Marengo, UTC -04:00</option>
        <option value='391'>US, United States, America/Indiana/Petersburg, UTC -04:00</option>
        <option value='392'>US, United States, America/Indiana/Tell_City, UTC -05:00</option>
        <option value='393'>US, United States, America/Indiana/Vevay, UTC -04:00</option>
        <option value='394'>US, United States, America/Indiana/Vincennes, UTC -04:00</option>
        <option value='395'>US, United States, America/Indiana/Winamac, UTC -04:00</option>
        <option value='396'>US, United States, America/Juneau, UTC -08:00</option>
        <option value='397'>US, United States, America/Kentucky/Louisville, UTC -04:00</option>
        <option value='398'>US, United States, America/Kentucky/Monticello, UTC -04:00</option>
        <option value='399'>US, United States, America/Los_Angeles, UTC -07:00</option>
        <option value='400'>US, United States, America/Menominee, UTC -05:00</option>
        <option value='401'>US, United States, America/Metlakatla, UTC -08:00</option>
        <option value='402'>US, United States, America/New_York, UTC -04:00</option>
        <option value='403'>US, United States, America/Nome, UTC -08:00</option>
        <option value='404'>US, United States, America/North_Dakota/Beulah, UTC -05:00</option>
        <option value='405'>US, United States, America/North_Dakota/Center, UTC -05:00</option>
        <option value='406'>US, United States, America/North_Dakota/New_Salem, UTC -05:00</option>
        <option value='407'>US, United States, America/Phoenix, UTC -07:00</option>
        <option value='408'>US, United States, America/Sitka, UTC -08:00</option>
        <option value='409'>US, United States, America/Yakutat, UTC -08:00</option>
        <option value='410'>US, United States, Pacific/Honolulu, UTC -10:00</option>
        <option value='411'>UM, United States Minor Outlying Islands, Pacific/Midway, UTC -11:00</option>
        <option value='412'>UM, United States Minor Outlying Islands, Pacific/Wake, UTC +12:00</option>
        <option value='413'>UY, Uruguay, America/Montevideo, UTC -03:00</option>
        <option value='414'>UZ, Uzbekistan, Asia/Samarkand, UTC +05:00</option>
        <option value='415'>UZ, Uzbekistan, Asia/Tashkent, UTC +05:00</option>
        <option value='416'>VU, Vanuatu, Pacific/Efate, UTC +11:00</option>
        <option value='417'>VA, Vatican, Europe/Vatican, UTC +02:00</option>
        <option value='418'>VE, Venezuela, America/Caracas, UTC -04:00</option>
        <option value='419'>VN, Vietnam, Asia/Ho_Chi_Minh, UTC +07:00</option>
        <option value='420'>WF, Wallis and Futuna, Pacific/Wallis, UTC +12:00</option>
        <option value='421'>EH, Western Sahara, Africa/El_Aaiun, UTC +01:00</option>
        <option value='422'>YE, Yemen, Asia/Aden, UTC +03:00</option>
        <option value='423'>ZM, Zambia, Africa/Lusaka, UTC +02:00</option>
        <option value='424'>ZW, Zimbabwe, Africa/Harare, UTC +02:00</option>
        <?= $Page->pais->selectOptionListHtml("x_pais") ?>
    </select>
    <?= $Page->pais->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->pais->getErrorMessage() ?></div>
<?= $Page->pais->Lookup->getParamTag($Page, "p_x_pais") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x_pais']"),
        options = { name: "x_pais", selectId: "users_x_pais", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.pais.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->organizacion->Visible) { // organizacion ?>
    <div id="r_organizacion" class="form-group row">
        <label id="elh_users_organizacion" for="x_organizacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->organizacion->caption() ?><?= $Page->organizacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->organizacion->cellAttributes() ?>>
<span id="el_users_organizacion">
<input type="<?= $Page->organizacion->getInputTextType() ?>" data-table="users" data-field="x_organizacion" name="x_organizacion" id="x_organizacion" size="100" maxlength="100" placeholder="<?= HtmlEncode($Page->organizacion->getPlaceHolder()) ?>" value="<?= $Page->organizacion->EditValue ?>"<?= $Page->organizacion->editAttributes() ?> aria-describedby="x_organizacion_help">
<?= $Page->organizacion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->organizacion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<!-- captcha html (begin) -->
<?= Captcha()->getHtml(); ?>
<!-- captcha html (end) -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("RegisterBtn") ?></button>
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
    ew.addEventHandlers("users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your startup script here, no need to add script tags.
});
</script>
