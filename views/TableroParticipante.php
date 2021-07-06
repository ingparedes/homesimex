<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TableroParticipante = &$Page;
?>
<style>
  .item {
    position: relative;
    padding-top: 10px;
    display: inline-block;
  }

  .notify-badge {
    position: absolute;
    right: -10px;
    top: 0px;
    text-align: center;
    border-radius: 40px 40px 40px 40px;
    color: black;
    padding: 4px 5px;
    font-size: 9px;
  }

  .btn-app2 {
    border-radius: 1px;
    position: relative;
    padding: 10px 5px;
    margin: 0 0 10px 10px;
    min-width: 80px;
    height: 80px;
    text-align: center;
    color: #666;
    border: 1px solid #ddd;
    background-color: #fff;
    font-size: 12px;
  }
</style>
<script type="text/javascript" src="//unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>
<link href="//unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script> -->

<?php $sql_utc = ExecuteRow("SELECT p.gmt, e.fechaini_simulado, e.fechafin_simulado, e.fechaini_real, e.fechafinal_real FROM escenario  e INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario WHERE e.estado IN ('1')"); ?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<body>
  <script>
    function notifica(idDiv) {
      // console.log(idDiv);
      var parametros = {
        "idDiv": idDiv
      };
      $.ajax({
        data: parametros,
        url: "dts_notifica.php?accion=notifica",
        type: "POST",
        success: function(respose) {

          var datos = JSON.parse(respose);
          if (datos.cant != 0) {
            $("#" + idDiv).html(datos.cant);
            $("#" + idDiv).css({
              'background': 'red'
            });
          } else {
            $("#" + idDiv).html('0');
            $("#" + idDiv).css({
              'background': 'gray'
            });
          }
        }
      });
    }

    $(document).ready(function() {
      //mensaje('Hola');

    });
  </script>
  <?php
  // echo "UTC: " . $sql_utc[0];
  $id_user = CurrentUserID();
  $_SESSION['id_user'] = CurrentUserID();
  echo $id_user;


  /*  $sql_leido1 = ExecuteRow("select count(*) from mensajes_usuarios mu 
  INNER JOIN mensajes m ON m.id_inyect = mu.id_mensaje
  WHERE leido = '0' and mu.id_user_destinatario IN ('" . $id_user . "') AND m.medios = '1';"); //tener rn cuenta el medio

  $sql_leido2 = ExecuteRow("select count(*) from mensajes_usuarios mu 
  INNER JOIN mensajes m ON m.id_inyect = mu.id_mensaje
  WHERE leido = '0' and mu.id_user_destinatario IN ('" . $id_user . "') AND m.medios = '2';"); //tener rn cuenta el medio */


  ?>


  <div class="card" id="update">
    <div class="card-header">
      <h3 class="card-title">Tablero Control</h3>
    </div>
    <div class="card-body">

      <div class="col-sm-12">


        <div class="item">

          <a class="btn btn-app2" href="#" onclick="url( '' );">
            <span id="mensajes" class="notify-badge">0</span>
            <img src="images/mensajes.png" alt="Image" height="62" width="62" />
          </a>
        </div>


        <div class="item">

          <a class="btn btn-app2" href="#" onclick="url( 'https://simexamericas.org/homesimex/media/twitter/index.php?id_user=<?php echo $id_user ?>' );">
            <span id="tweeter" class="notify-badge">0</span>
            <img src="images/chirping.png" alt="Image" height="62" width="62" />
          </a>
        </div>

        <div class="item">

          <a class="btn btn-app2" href="#" onclick="url( 'media/facebook/index.php?id_user=<?php echo $id_user ?>' );">
            <span id="facebook" class="notify-badge">0</span>
            <img src="images/daybook.png" alt="Image" height="62" width="62" />
          </a>
        </div>


      </div>
      <input type="button" id="load" value="&darr; Load" style="display:none">
      <div id="visualization"></div>
    <div id="loading">loading...</div>


    </div>
  </div>
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Visualización de Datos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="dts_notifica.php?accion=saveItemMsj" method="post">
            <div class="form-group">
              <input type="text" class="form-control" id="id" hidden>
              <input type="text" class="form-control" id="tipo" hidden>
              <label for="tituloT">Titulo </label>
              <input type="text" class="form-control" id="tituloT" placeholder="Título Tarea" value="" readonly>
            </div>
            <div class="form-group">
              <label for="desc_tarea">Descripción </label>
              <!-- <textarea class="form-control" id="desc_tarea" rows="3"></textarea> -->
              <div id="desc_tarea" class="border" contenteditable="false">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <!-- <button type="button" onclick="saveMsj()" class="btn btn-primary">Guardar</button> -->
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>
  </div>
  <script type="text/javascript">
    function url(cUrl) {
      var frame = $('#frmUrl');
      frame.attr('src', cUrl).show();
    }
  </script>


  <div class="embed-responsive embed-responsive-16by9">
    <iframe src="" id="a" class="embed-responsive-item" allowfullscreen></iframe>
  </div>
  -->

  <div class="embed-responsive embed-responsive-16by9">
    <iframe id="frmUrl" class="embed-responsive-item" src="" allowfullscreen></iframe>
  </div>
  <script>
    //Time Line
    var btnLoad = document.getElementById('load');
    var btnSave = document.getElementById('save');
    let utc = '<?php echo $sql_utc[0] ?>';
    let hora = utc.slice(4, 10);
    let fechaIniSimulado = '<?php echo $sql_utc['fechaini_simulado'] ?>';
    let fechaFinSimulado = '<?php echo $sql_utc['fechafin_simulado'] ?>';
    let data_json;

    function loadData() {
      // ###### DESDE ACA ########
      $.ajax({
        url: "dts_notifica.php?accion=loadTL&pg=participante",
        //url: "basic.json",
        success: function(data) {
          if (data == 'baduser') {
            alert("Usuario Maestro, inicie sesión con usuario de la BD");
          } else {
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
              editable: {
                add: false, // add new items by double tapping
                updateTime: false, // drag items horizontally
                updateGroup: false, // drag items from one group to another
                remove: false, // delete an item by tapping the delete button top right
                overrideItems: false // allow these options to override item.editable
              },
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
              height: '200px',
              margin: {
                item: 20
              }
            };
            // Create a Timeline
            var timeline = new vis.Timeline(container, items, options);
            var id1 = "id1";
            var id2 = "id2";
            timeline.addCustomTime(new Date(fechaIniSimulado), id1);
            timeline.setCustomTimeMarker("Fecha Inicio<br>" + fechaIniSimulado.slice(0, 16), id1, false);
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
                    $('#tituloT').val(data[0].titulo);
                    $('#desc_tarea').html(data[0].descripcion);
                    console.log('parametros', data);
                  }

                });

              }
            });
          }
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
    // load the initial data
    loadData();
  </script>
</body>

<?php
echo GetDebugMessage();
?>