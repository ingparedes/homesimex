<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Timeline2 = &$Page;
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="css/flatpickr.min.css">

        <!-- <script src="js/jquery-3.5.0.min.js" charset="utf-8"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>

        <script src="js/flatpickr.js" charset="utf-8"></script>
        <script src="js/flatpickr-locale-es.js" charset="utf-8"></script>

        <title>Creando datepickers con Flatpickr</title>
    </head>
    <body>
        <div class="container">
            <div class="mb-1">
                <label for="dpFecha">Fecha</label>
                <input type="text" id="dpFecha" class="form-control" placeholder="Clic aquí para seleccionar">
            </div>
            <div class="mb-1">
                <label for="dpFecha2">Fecha de Nacimiento</label>
                <input type="text" id="dpFecha2" class="form-control" placeholder="Clic aquí para seleccionar">
            </div>
            <div class="mb-1">
                <label for="dpFecha3">Fecha de Ingreso</label>
                <input type="text" id="dpFecha3" class="form-control" placeholder="Clic aquí para seleccionar">
            </div>
            <div class="mb-1">
                <label for="dpFecha4">Fecha de Cita</label>
                <input type="text" id="dpFecha4" class="form-control" placeholder="Clic aquí para seleccionar">
            </div>
            <div class="mb-1">
                <label for="dpFecha5">Fecha de Quincena</label>
                <input type="text" id="dpFecha5" class="form-control" placeholder="Clic aquí para seleccionar">
            </div>
            <div class="mb-1">
                <label for="dpFecha6">Fecha de días de la semana</label>
                <input type="text" id="dpFecha6" class="form-control" placeholder="Clic aquí para seleccionar">
            </div>
        </div>
        <script>

                flatpickr("#dpFecha2",{
                    locale: "es",
                    dateFormat: "d/m/Y",
                    maxDate: (new Date()).setFullYear((new Date()).getFullYear() - 18)
                })
        </script>
    </body>
</html>


<?= GetDebugMessage() ?>
