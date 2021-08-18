<?php

namespace PHPMaker2021\simexamerica;

// Page object
$LineaTiempo = &$Page;
?>
<html>

<head>
    <title><?php echo $Language->TablePhrase("timeline", "titulo"); ?></title>

    <style>
        body,
        html {
            font-family: arial, sans-serif;
            font-size: 11pt;
        }

        textarea {
            width: 800px;
            height: 200px;
        }

        .buttons {
            margin: 20px 0;
        }

        .buttons input {
            padding: 10px;
        }
    </style>

    <script type="text/javascript" src="//unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>

    <link href="//unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <h1><?php echo $Language->TablePhrase("timeline", "timeline_m_t"); ?></h1>

    <?php $sql_utc = ExecuteRow("SELECT p.gmt, e.fechaini_simulado, e.fechafin_simulado FROM escenario  e INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario WHERE e.estado IN ('1')");
    $_SESSION['id_user'] = CurrentUserID();
    echo "usuario: " . $_SESSION['id_user'];
    ?>
    <div class="buttons">
        <input type="button" id="load" value="&darr; Load" style="display:none">
        <!-- <input type="button" id="save" value="&uarr; Save" title="Save data from the Timeline into the textarea"> -->
        <button type="button" id="save" class="btn btn-success"><?php echo $Language->TablePhrase("timeline", "guardar"); ?></button>

    </div>
    <div class="position-fixed bottom-100 end-300 p-5" style="z-index: 5">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">

                <small><?php echo $Language->TablePhrase("timeline", "datos_almacenados"); ?></small>

            </div>
            <div class="toast-body bg-success text-white">
            <?php echo $Language->TablePhrase("timeline", "datos_almacenados_ok"); ?>
            </div>
        </div>
    </div>

    <div id="loading"><?php echo $Language->TablePhrase("timeline", "cargand"); ?></div>
    <div id="visualization"></div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $Language->TablePhrase("timeline", "editar_datos"); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="dts_notifica.php?accion=saveItemMsj" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" hidden>
                            <input type="text" class="form-control" id="tipo" hidden>
                            <label for="tituloT"><?php echo $Language->TablePhrase("timeline", "titul"); ?> </label>
                            <input type="text" class="form-control" id="tituloT" placeholder="Título Tarea" value="hola">
                        </div>
                        <div class="form-group">
                            <label for="desc_tarea"><?php echo $Language->TablePhrase("timeline", "descrip"); ?> </label>
                            <textarea class="form-control" id="desc_tarea" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $Language->TablePhrase("timeline", "cerrar"); ?></button>
                            <button type="button" onclick="saveMsj()" class="btn btn-primary"><?php echo $Language->TablePhrase("timeline", "guardar"); ?></button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <script>
        var btnLoad = document.getElementById('load');
        var btnSave = document.getElementById('save');

        let utc = '<?php echo $sql_utc[0] ?>';
        let hora = utc.slice(4, 10);
        let fechaIniSimulado = '<?php echo $sql_utc['fechaini_simulado'] ?>';
        let fechaFinSimulado = '<?php echo $sql_utc['fechafin_simulado'] ?>';
        let data_json;

        // Create an empty DataSet.
        // This DataSet is used for two way data binding with the Timeline.
        //var items = new vis.DataSet();

        // create a timeline
        /* var container = document.getElementById('visualization');
        var options = {
            editable: true,
            moment: function(date) {
                return vis.moment(date).utcOffset('-5')
            },
        };
        var timeline = new vis.Timeline(container, items, options); */

        function loadData() {

            //var data = JSON.parse(txtData.value);

            //items.clear();
            //items.add(data);

            //timeline.fit();

            // ###### DESDE ACA ########

            $.ajax({
                url: "dts_notifica.php?accion=loadTL",
                //url: "basic.json",
                success: function(data) {

                    document.getElementById("loading").style.display = "none";

                    var container = document.getElementById("visualization");
                    // Create a DataSet (allows two way data-binding)
                    //var datos = JSON.stringify(data);
                    var customDate = new Date(fechaIniSimulado);

                    items = new vis.DataSet(data);
                    data_json = data;
                    //console.log('data', data);
                    // Configuration for the Timeline                
                    options = {
                        editable: true,
                        moment: function(date) {
                            return vis.moment(date).utcOffset(hora)
                        },
                        start: fechaIniSimulado,
                        end: fechaFinSimulado, //new Date(new Date().getTime() + 100000),
                        rollingMode: {
                            follow: false,
                            offset: 0.5,
                        },
                        width: '100%',
                        height: '400px',
                        margin: {
                            item: 20
                        }
                    };
                    // Create a Timeline
                    var timeline = new vis.Timeiner, items, options);
                    var id1 = "id1";
                    var id2 = "id2";
                    timeline.addCustomTime(new Date(fechaIniSimulado), id1);
                    timeline.setCustomTimeMarker("Fecha Inicio<br>" + fechaFinSimulado.slice(0, 16), id1, false);
                    timeline.addCustomTime(new Date(fechaFinSimulado), id2);
                    timeline.setCustomTimeMarker("Fecha Fin<br>" + fechaFinSimulado.slice(0, 16), id2, false);

                    timeline.on('doubleClick', function(properties) {

                        var id = properties.item;
                        if (id != null) {
                            id = id.slice(2);
                            var tipo = properties.item.slice(0, 1);
                            console.log(id, tipo);
                            var parametros = {
                                "id": id,
                                "tipo": tipo,
                            };
                            $('#exampleModalCenter').modal('show');
                            $.ajax({
                                url: "dts_notifica.php?accion=loadItemMsj",
                                data: parametros,
                                type: 'post',
                                success: function(data) {
                                    $('#id').val(id);
                                    $('#tipo').val(tipo);
                                    $('#tituloT').val(data.titulo);
                                    $('#desc_tarea').val(data.descripcion);
                                    console.log('parametros', data);
                                }

                            });

                        }
                    });
                },
                error: function(err) {
                    console.log("Error", err);
                    if (err.status === 0) {
                        alert(
                            "Fallo al abrir JSON ."
                        );
                    } else {
                        alert("No se pudo abrir JSON .");
                    }
                },
            });
            // ####### HASTA ACÁ ####### 


        }
        btnLoad.onclick = loadData;

        function saveMsj() {
            id = $('#id').val();
            tipo = $('#tipo').val();
            titulo = $('#tituloT').val();
            desc = $('#desc_tarea').val();
            parametros = {
                "id": id,
                "tipo": tipo,
                "titulo": titulo,
                "desc": desc
            }
            console.log('datos', parametros);
            $.ajax({
                url: "dts_notifica.php?accion=saveItemMsj",
                data: parametros,
                type: 'post',
                success: function(data) {
                    if (data == 'ok') {
                        $('#exampleModalCenter').modal('hide');
                        $('.toast').toast('show');
                    }
                }
            });

        }

        function saveData() {

            var datos = items.get({
                type: {
                    start: 'String',
                    end: 'String'
                }
            });
            //console.log("datos:", datos);

            for (let i = 0; i < datos.length; i++) {
                fechaIni = +new Date(datos[i].start);
                const timestamp = Math.floor(fechaIni);
                var MyDate = new Date(timestamp);
                var year = MyDate.getFullYear();
                var month = "0" + (MyDate.getMonth() + 1);
                var day = "0" + MyDate.getDate();
                var hours = "0" + MyDate.getHours();
                var minutes = "0" + MyDate.getMinutes();
                var seconds = "0" + MyDate.getSeconds();
                var fechaIni = year + '-' + month.substr(-2) + '-' + day.substr(-2) + ' ' + hours.substr(-2) + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

                if (datos[i].end != "") {
                    fechaFn = +new Date(datos[i].end);
                    const timestamp = Math.floor(fechaFn);
                    var MyDate = new Date(timestamp);
                    var year = MyDate.getFullYear();
                    var month = "0" + (MyDate.getMonth() + 1);
                    var day = "0" + MyDate.getDate();
                    var hours = "0" + MyDate.getHours();
                    var minutes = "0" + MyDate.getMinutes();
                    var seconds = "0" + MyDate.getSeconds();
                    var fechaFn = year + '-' + month.substr(-2) + '-' + day.substr(-2) + ' ' + hours.substr(-2) + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
                }
                if ((datos[i].id.slice(0, 1) != 'T') || (datos[i].id.slice(0, 1) != 'M')) {
                    id = datos[i].id.slice(2);
                } else {
                    id = datos[i].id;
                }

                var itemss = {
                    id: id,
                    content: datos[i].content,
                    start: fechaIni,
                    end: fechaFn
                }

                $.ajax({
                    type: "POST", // la variable type guarda el tipo de la peticion GET,POST,..
                    url: "dts_notifica.php?accion=saveTL", //url guarda la ruta hacia donde se hace la peticion
                    data: itemss, // data recive un objeto con la informacion que se enviara al servidor
                    success: function(data) { //success es una funcion que se utiliza si el servidor retorna informacion
                        console.log('data:', data);
                        $('.toast').toast('show');

                    },
                });
                //console.log('item', item);
            }


        }
        btnSave.onclick = saveData;

        // load the initial data
        loadData();
        $('.toast').toast();
    </script>
</body>

</html>

<?= GetDebugMessage() ?>
