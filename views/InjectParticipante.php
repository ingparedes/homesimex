<?php

namespace PHPMaker2021\simexamerica;

// Page object
$InjectParticipante = &$Page;
?>
<?php

$_SESSION['id_user'] = CurrentUserID();

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
  .vis-custom-time {
    pointer-events: none;
}
.vis-item .vis-item-overflow {
  overflow: visible;
}

    .timeline-comment-box {
        background: #f2f3f4;
        margin-left: -10px;
        margin-right: -10px;
        padding: 10px 25px
    }

    .timeline-comment-box .user {
        float: left;
        width: 34px;
        height: 34px;
        overflow: hidden;
        border-radius: 30px
    }

    .timeline-comment-box .user img {
        max-width: 100%;
        max-height: 100%
    }

    .timeline-comment-box .user+.input {
        margin-left: 44px
    }

    .comment-text {
       
    }
    .textarealine {
        overflow: auto;
        width: 100%;
        resize: inline;
    }
    .speedup:hover {
     cursor: pointer;
     border: 1px solid #3E7DC0 !important
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
.btn-circle.btn-lg {
  width: 50px;
  height: 50px;
  padding: 10px 0px;

  line-height: 1;
  border-radius: 25px;
}
.btn-circle.btn-xl {
  width: 70px;
  height: 70px;
  padding: 10px 16px;
   line-height: 1.33;
  border-radius: 35px;
}

</style>

<!-- librerias adicionales -->

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script type="text/javascript" src="//unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>
<link href="//unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />

<?php $sql_utc = ExecuteRow("SELECT p.gmt, e.fechaini_simulado, e.fechafin_simulado, e.fechaini_real, e.fechafinal_real FROM escenario  e INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario WHERE e.estado IN ('1')"); ?>

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
 


   $sql_leido1 = ExecuteRow("select count(*) from mensajes_usuarios mu 
  INNER JOIN mensajes m ON m.id_inyect = mu.id_mensaje
  WHERE leido = '0' and mu.id_user_destinatario IN ('" . $id_user . "') AND m.medios = '1';"); //tener rn cuenta el medio

  $sql_leido2 = ExecuteRow("select count(*) from mensajes_usuarios mu 
  INNER JOIN mensajes m ON m.id_inyect = mu.id_mensaje
  WHERE leido = '0' and mu.id_user_destinatario IN ('" . $id_user . "') AND m.medios = '2';"); //tener rn cuenta el medio 


  ?>

<div class="card" id="update">
    <div class="card-header">
     
      <span class="float-right"> 
       
      
        <a class="btn btn-default" href="#" data-toggle="modal" data-target="#charping" >
          <img src="images/chispingletras.png" alt="Image" height="42" width="42" />
        </a>
        <a class="btn btn-default" href="#"  data-toggle="modal" data-target="#daybook">
            <img src="images/daybook.png" alt="Image" height="42" width="42" />
          </a>
        </span>
        
    </div>
    <div class="card-body">

      <div class="col-sm-12">

<!--
        <div class="item" id="vue-admin">

          <a class="btn btn-app2" href="#" onclick="url( 'views/InjectParticipante.php' );">
          <span id="mensajes" class="notify-badge"><span v-if="mensajesNuevos.length > 0" class="badge-danger">NEW</span></span>
            <img src="images/mensajes.png" alt="Image" height="62" width="62" />
          </a>
        </div>
-->

        




      </div>
      <div class="card">
              <div class="card-header">
                <h3 class="card-title">Linea de tiempo</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                </div>
              </div>
              <div class="card-body">
                        <input type="button" id="load" value="&darr; Load" style="display:none">
                        <div id="visualization"></div>
                        <div id="loading">loading...</div>
                    </div>
            </div>




    </div>
  </div>

<div class="container-fluid">
    <div class="card" id="vue-chat">

        <div class="card-header bg-success">
            <h3 class="card-title">Mensajes</h3>
        <form id="formulario_buscador">
            <input type="text" class="form-control float-right" id="buscador" placeholder="Buscar">
        </div>
        </form>

        <!-- /.card-header -->
        <div class="card-body" >
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messagess " >
                <!-- Message. Default to the left -->
                <div class="container" v-for="mens in mensajes" v-if="mens.visible">
                    <div class="direct-chat-msg ">
                    <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{mens.actor}}</span>
                                    <span class="direct-chat-timestamp float-right">
                                        <i class='far fa-clock text-primary'></i> 
                                        Hora real {{mens.fstar}} <br> 
                                        <i class='far fa-clock text-info'></i> 
                                        Hora Simulada  {{mens.fstarsim}} 
                                    </span>
                                   </div>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text speedup" style="background-color:#f2f3f4">

                    <div class = "header">
                        <h4> {{mens.titulo_mensaje}} <!--<span class="badge badge-pill badge-primary float-right">{{mens.calificacion}}</span>--></h4> 
                        <span
                                                class="float-right badge "
                                                v-bind:class="{'badge-primary': mens.calificacion == 'Pendiente', 'badge-success': mens.calificacion == 'Finalizado', 
                                                    'badge-warning': mens.calificacion == 'Inconcluso' }"
                                                >
                                                {{mens.calificacion}}
                                        </span>
                        <!--<span class="float-right badge badge-warning "> Inconpleto</span> -->
                        <!--  
                        <span
                                                class="float-right badge "
                                                v-bind:class="{'badge-primary': mens.calificacion == 'Pendiente', 'badge-success': mens.calificacion == 'Finalizado', 
                                                    'badge-warning': mens.calificacion == 'Inconcluso' }"
                                                >
                                                {{mens.calificacion}}
                                        </span> 
                        <span>{{mens.titulo_tarea}}</span> -->
                        <div> 
                            <hr>
                            <span v-html="mens.mensaje"></span>
                            <div class="stats">
                            <i class="cil-paperclip"></i> <br>
                            <a v-bind:href="'files/'+mens.filename"> {{mens.filename}}</a> 
                            <hr>
                            <a  data-toggle="collapse" v-bind:href="'#para'+mens.id" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                                            <i class="fa fa-users"></i> 

                                            Para:</a>
                            <div class="collapse multi-collapse" v-bind:id="'para'+mens.id">
                                        <ul  v-for="destinatario in mens.destinatarios" v-if="mens.visible">
                                          <li> {{destinatario.destinatario}}.</li>
                                        </ul>
                                        </div>
                              </div>
                            <hr>
                            <div class="timeline-footer">

                                <a class="m-r-15 text-inverse-lighter" title="" data-caption="Enviar" v-bind:href="'/homesimex/Email2Add?IdResMsg='+mens.id" data-original-title="Enviar">
                                    Responder&nbsp;<i class="fa fa-reply" aria-hidden="true"></i>

                                </a>│

                                <a class="m-r-15 text-inverse-lighter" title="" data-caption="Enviar" v-bind:href="'/homesimex/Email2Add?IdreenMsg='+mens.id" data-original-title="Enviar">
                                Cooperación &nbsp;<i class="fa fa-random" aria-hidden="true"></i>

                                </a> │                               
  

                                <a type="button" class="m-r-15 text-inverse-lighter" data-toggle="collapse" v-bind:href="'#collapse'+mens.id" >
                                    <i class="fa fa-comments fa-fw fa-lg m-r-3"></i> Comentario
                                </a> 
                            </div>
            
                            <div class="collapse" v-bind:id="'collapse'+mens.id">
                                <div class="timeline-comment-box">
                                    <div class="user">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar6.png">
                                    </div>
                                    <div class="input">
                                        <div class="input-group">
                                            <textarea type="text" class="textarealine" v-model="mens.entrada"></textarea>
                                        </div>
                                        <div class="mt-2 text-right">
                                            <button class="btn btn-primary btn-sm shadow-none" v-on:click="hacerComentario(mens)" type="button">Envio
                                        </div>
                                        <hr>       
                                        <div v-for="coment in mens.comentarios">   
                                            <span>
                                                <em> {{coment.nombre}} </em>
                                            </span>
                                            <span class="float-right">
                                                {{coment.hora}}
                                            </span>
                                                

                                            <div class="timeline-content">  
                                                <p class="comment-text" >
                                                    <small>{{coment.texto}}</small>
                                                </p>
                                            </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>
</div>

<!--Modal iframe -->


<div class="modal fade" id="charping"  role="dialog" aria-labelledby="charpingmodal" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="embed-responsive embed-responsive-16by9">
      <iframe  class="embed-responsive-item" src="media/twitter/index.php?id_user=<?php echo $id_user ?>" width="600" height="600"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="daybook"  role="dialog" aria-labelledby="daybookmodal" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="embed-responsive embed-responsive-16by9">
      <iframe  class="embed-responsive-item" src="media/facebook/index.php?id_user=<?php echo $id_user ?>" width="600" height="600"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
      </div>
      </div>
    </div>
  </div>
</div>

<!-- fin modal -->
<script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.29.9.js"></script>
<script src="inject/pubnub.js"></script>
<script src="https://cdn.jsdelivr.net/npm/disableautofill@2.0.0/dist/disableautofill.min.js"></script>
  
<script type="text/javascript">
//timelines
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
    

    //Time Line
    var btnLoad = document.getElementById('load');
    var btnSave = document.getElementById('save');
    let utc = '<?php echo $sql_utc[0] ?>';
    let hora = utc.slice(4, 10);
    let fechaIniSimulado = '<?php echo $sql_utc['fechaini_real'] ?>';
    let fechaFinSimulado = '<?php echo $sql_utc['fechafinal_real'] ?>';
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
              autoResize: true,
              horizontalScroll: true,
              zoomKey: "ctrlKey",
              rollingMode: {
                follow: false,
                offset: 0.5,
              },
              width: '100%',
              height: '200px',
              margin: {
                item: 20
              },
              align: "left",
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
//end timeline

    var app = new Vue({
        el: '#vue-chat',
        data: {
            mensajes: []
        },
        methods:{
            hacerComentario: function(mensaje){
                if(mensaje.entrada == ""){
                    return;
                }
                $.ajax({
                    url: "inject/guardar_comentario.php",
                    type: "POST",
                    data: {
                        "idMensaje":mensaje.id,
                        "idUser": <?php echo CurrentUserID(); ?> ,
                        "comentario":mensaje.entrada
                    },
                    success: function (es) {
                        let respuesta = JSON.parse(es)[0];
                        pubnub.enviarMensaje({
                            "id":respuesta.id
                        });
                        
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
                mensaje.entrada = "";
            }
        }
    });

    var publishKey = 'pub-c-451eac62-0cee-4afa-9f20-93eb596aedfb';
    var subscribeKey = 'sub-c-5c30cc92-dbff-11eb-8c90-a639cde32e15';

    var pubnub = new CanalPub("canal-01",publishKey,subscribeKey);
    var pubnubAdmin = new CanalPub("canal-02",publishKey,subscribeKey);
    pubnub.mensajeLlegado = llegadaComentario;
    pubnubAdmin.mensajeLlegado = llegandoMensaje;

    function llegadaComentario(msg){
        let comentario = msg.message;
        console.log(comentario);
        $.ajax({
            url: "inject/comentario.php?idComentario="+comentario.id,
            success: function (es) {
                let respuesta = JSON.parse(es)[0];
                for(let i = 0;i < app.mensajes.length;i++){
                    if(app.mensajes[i].id == respuesta.idMensaje){
                        let add = {
                            "nombre":respuesta.nombre,
                            "hora":respuesta.hora,
                            "texto":respuesta.mensaje
                        };
                        app.mensajes[i].comentarios.push(add);
                    }
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function obtenerComentariosVarios(comentarios,id){
        $.ajax({
            url: "inject/obtener_comentarios.php?idMensaje="+id,
            success: function (es) {
                let respuesta = JSON.parse(es);
                for(let i = 0;i < respuesta.length;i++){
                    let res = respuesta[i];
                    let add = {
                        "nombre":res.nombre,
                        "hora":res.hora,
                        "texto":res.mensaje
                    };
                    comentarios.push(add);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function llegandoMensaje(msg){
        let code = msg.message.code;
        for(let i = 0;i < app.mensajes.length;i++){
            if(app.mensajes[i].id == code){
                return;
            }
        }
        $.ajax({
            url: "inject/pedir_mensajecliente.php?idMensaje="+code,
            success: function (es) {
                let ayuda = JSON.parse(es);
                if(ayuda.length == 0){
                    return;
                }
                let respuesta = ayuda[0];
                respuesta.numero_comentarios = 0;
                respuesta.comentarios = [];
                respuesta.entrada = "";
                respuesta.visible = true;
                obtenerDestinatarios(respuesta.destinatarios,respuesta.id);
                obtenerComentariosVarios(respuesta.comentarios,respuesta.id);
                app.mensajes.push(respuesta);
                
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function obtenerMensajesEnviados(){
        $.ajax({
            url: "inject/enviadoscliente.php",
            success: function (es) {
                let respuesta = JSON.parse(es);
                console.log(respuesta);
                for(let i = 0;i < respuesta.length;i++){
                    let mens = respuesta[i];
                    mens.numero_comentarios = 0;
                    mens.comentarios = [];
                    mens.destinatarios = [];
                    mens.entrada = "";
                    mens.visible = true;
                    app.mensajes.push(mens);
                    obtenerDestinatarios(mens,mens.id);
                    obtenerComentariosVarios(mens.comentarios,mens.id);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    function obtenerDestinatarios(mens,id){
        $.ajax({
            url: "inject/obtener_destinatarios.php?idMensaje="+id,
            success: function (es) {
                let respuesta = JSON.parse(es);
                for(let i = 0;i < respuesta.length;i++){
                    let res = respuesta[i];
                    let add = {
                        "destinatario":res.destinatario
                    };
                    mens.destinatarios.push(add);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
        console.log(mens);
    }

    $(document).ready(function(){
        $("#buscador").on('keyup', function() {
            let val = $("#buscador").val();
            for(let i = 0;i < app.mensajes.length;i++){
                let mens = app.mensajes[i];
                mens.visible = false;
                if(mens.titulo_mensaje.toLowerCase().includes(val.toLowerCase())){
                    mens.visible = true;
                }
                if(mens.titulo_tarea.toLowerCase().includes(val.toLowerCase())){
                    mens.visible = true;
                }
                if(mens.mensaje.toLowerCase().includes(val.toLowerCase())){
                    mens.visible = true;
                }
            }
        });
        obtenerMensajesEnviados();
    });
    var daf =new disableautofill({
        'form': '#formulario_buscador'
    });
    daf.init();
</script>

<?= GetDebugMessage() ?>



