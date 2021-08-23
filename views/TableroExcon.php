<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TableroExcon = &$Page;
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
<?php 
$inicieBd=$Language->phrase("inicie_Bd"); 
$falloJson=$Language->phrase("falloJson"); 
$errorJson=$Language->phrase("errorJson"); 
?>
<script type="text/javascript" src="//unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>
    <link href="//unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
    
<?php $sql_utc = ExecuteRow("SELECT p.gmt, e.fechaini_simulado, e.fechafin_simulado, e.fechaini_real, e.fechafinal_real FROM escenario  e INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario WHERE e.estado IN ('1')"); ?>

<body >
  <script>
    function notifica(idDiv) {
      // console.log(idDiv);
      var parametros = {
        "idDiv": idDiv
      };
      $.ajax({
        data: parametros,
        url: "dts_notifica.php",
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
      setInterval(function() {
        notifica('tweeter');
        notifica('facebook');
      }, 3000);
    });
    let utc = '<?php echo $sql_utc[0] ?>';
    let hora = utc.slice(4, 10);
    let fechaIniSimulado = '<?php echo $sql_utc['fechaini_real'] ?>';
    let fechaFinSimulado = '<?php echo $sql_utc['fechafinal_real'] ?>';
    //Time Line
    $.ajax({
      url: "dts_notifica.php?accion=loadMSJ",
      //url: "basic.json",
      success: function(data) {
        // hide the "loading..." message
        document.getElementById("loading").style.display = "none";
        // DOM element where the Timeline will be attached
        var container = document.getElementById("visualization");
        // Create a DataSet (allows two way data-binding)
        //var datos = JSON.stringify(data);
        var customDate = new Date(fechaIniSimulado);
        var items = new vis.DataSet(data);
        console.log(data);

        // Configuration for the Timeline                
        var options = {
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
        timeline.setCustomTimeMarker("Fecha Inicio<br>", id1, false);
        timeline.addCustomTime(new Date(fechaFinSimulado), id2);
        timeline.setCustomTimeMarker("Fecha Fin<br>" , id2, false);
      },
      error: function(err) {
        console.log("Error", err);
        if (err.status === 0) {
          alert(
              "<?php echo $falloJson; ?>"
            );
          } else {
            alert("<?php echo $errorJson; ?>");
          }
      },
    });
  </script>
  <?php
 // echo "UTC: " . $sql_utc[0];
  $id_user = CurrentUserID();
  $_SESSION['id_user'] = CurrentUserID();

  $sql_leido1 = ExecuteRow("select count(*) from mensajes_usuarios mu 
  INNER JOIN mensajes m ON m.id_inyect = mu.id_mensaje
  WHERE leido = '0' and mu.id_user_destinatario IN ('" . $id_user . "') AND m.medios = '1';"); //tener rn cuenta el medio

  $sql_leido2 = ExecuteRow("select count(*) from mensajes_usuarios mu 
  INNER JOIN mensajes m ON m.id_inyect = mu.id_mensaje
  WHERE leido = '0' and mu.id_user_destinatario IN ('" . $id_user . "') AND m.medios = '2';"); //tener rn cuenta el medio


  $sql = ExecuteRow("Select perfil from users where id_users ='" . $id_user . "';");

  if ($sql[0] == 2){
  $perfil = 1;  }
  
  elseif ($sql[0] == 3){
    $perfil = 2;  }
  
    $cargando=$Language->phrase("cargando"); 
  

  ?>


    
  <div class="card" id="update">

    <div class="card-body">

      <div class="col-sm-12">
     
     
       
      </div>

      <div id="visualization"></div>
    <div id="loading"><?php echo $cargando; ?>...</div>


    </div>
  </div>

  <!-- /.card-body 
  <script type="text/javascript">
    function url(cUrl) {
      var frame = $('#frmUrl');
      frame.attr('src', cUrl).show();
    }

    function startTime(utc) {

      hora = parseInt(utc.slice(4, 7));
      min = parseInt(utc.slice(8, 10));

      offset = hora;
      var today = new Date();
      var h = today.getUTCHours();
      var m = today.getUTCMinutes();
      var s = today.getUTCSeconds();
      h = h + offset;
      if (h > 24) {
        h = h - 24;
      }
      if (h < 0) {
        h = h + 24;
      }
      m = m + min;
      h = checkTime(h);
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
      var t = setTimeout(function() {
        startTime('<?php echo $sql_utc[0] ?>')
      }, 500);
    }
    
    function checkTime(i) {
      if (i < 10) {
        i = "0" + i
      };
      return i;
    }

    startTime('<?php echo $sql_utc[0] ?>');
  </script>


<div class="embed-responsive embed-responsive-16by9">
<iframe src="" id="a" class="embed-responsive-item" allowfullscreen></iframe>
</div>
    -->


  <div class="embed-responsive embed-responsive-16by9">
    <iframe id="frmUrl" class="embed-responsive-item" src="<?php echo "https://simexamericas.org/web-messaging-angular/messages/" . $id_user . "/" . $perfil ?>" allowfullscreen></iframe>
  </div>
</body>

<?= GetDebugMessage() ?>
