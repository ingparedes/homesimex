<?php

namespace PHPMaker2021\simexamerica;

// Page object
$InjectParticipante = &$Page;
?>
<?php

$_SESSION['id_user'] = CurrentUserID();

?>


<style>
    
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
#botonEstado{
        background-color: #28a745;
        background-color:  #28a745;
    }
    .dropdown-item.active, .dropdown-item:active {
    color: #fff;
    text-decoration: none;
    background-color: #28a745;
}
[data-toggle="collapse"] .fa:before {  
  content: "\f139";
}

[data-toggle="collapse"].collapsed .fa:before {
  content: "\f13a";
}
</style>

<!-- librerias adicionales -->
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script type="text/javascript" src="//unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>
<link href="//unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script> -->

<?php $sql_utc = ExecuteRow("SELECT p.gmt, DATE_ADD(e.fechaini_real,INTERVAL ((RIGHT(p.gmt,2)+60*MID(p.gmt,6,2)*1))-300  MINUTE)  as fechaini_real, 
DATE_ADD(e.fechafinal_real,INTERVAL ((RIGHT(p.gmt,2)+60*MID(p.gmt,6,2)*1))-300  MINUTE)  as fechafinal_real
, e.id_escenario, e.nombre_escenario FROM escenario  e INNER JOIN paisgmt p ON p.id_zone = e.pais_escenario WHERE e.estado IN ('1')"); ?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<body>
 
  <?php
  // echo "UTC: " . $sql_utc[0];
  $id_user = CurrentUserID();
  $_SESSION['id_user'] = CurrentUserID();


  ?>


  <div class="card" >
    <div class="card-header">
   
      <a class="" href="#" title="chirping"  data-toggle="modal" data-target=".bd-chirping-modal-xl" data-toggle="modal"><img src="images/chirping.png" alt="Image" height="30" width="30" /></a>
      <a class="" href="#" title="chirping"  data-toggle="modal" data-target=".bd-daybook-modal-xl" data-toggle="modal"><img src="images/daybook.png" alt="Image" height="30" width="30" /></a>

    </div>
    <div class="card-body">

      <div class="col-sm-12">


        <div class="item" >

             
        </div>
            <div class="modal fade bd-chirping-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-xl">
             <div class="modal-content">
             <div class="modal-header">
                
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                </button>
               </div>
             <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="frmUrl" class="embed-responsive-item" src="media/twitter/index.php?id_user=<?php echo $id_user ?> " allowfullscreen></iframe>
                    </div>
            </div>
      
             </div>
           </div>
           </div>


        <div class="item">
          
        </div>
        <div class="modal fade bd-daybook-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-xl">
             <div class="modal-content">
             <div class="modal-header">
                
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                </button>
               </div>
             <div class="modal-body">
              <div class="embed-responsive embed-responsive-16by9">
              <iframe id="frmUrl" class="embed-responsive-item" src="media/facebook/index.php?id_user=<?php echo $id_user ?>" allowfullscreen></iframe>
              </div>
            </div>
      
             </div>
           </div>
           </div>
<!--
        <div class="item">

          <a class="btn btn-app2" href="#" onclick="url( 'media/facebook/index.php?id_user=<?php echo $id_user ?>' );">
            <span id="facebook" class="notify-badge">0</span>
            <img src="images/daybook.png" alt="Image" height="62" width="62" />
          </a>
        </div>

-->
      </div>
      <input type="button" id="load" value="&darr; Load" style="display:none">
      <div id="visualization"></div>
    <div id="loading"><?php echo $Language->TablePhrase("inject_participante", "cargando"); ?></div>
    <p class = "small">  <em> <?php echo $Language->TablePhrase("inject_participante", "ctrlzoom"); ?> <br>
    <?php echo $Language->TablePhrase("inject_participante", "clicizq"); ?> <br>
    <?php echo $Language->TablePhrase("inject_participante", "rhr"); ?> <img src = "https://simexamericas.org/homesimex/images/iconotimeline.png"  width="30" height="30"> </em> </p>

    </div>
  </div>
  
  </div>
<div class="container-fluid">
    <div class="card" id="vue-chat">

        <div class="card-header bg-success">
            <h3 class="card-title"><?php echo $Language->TablePhrase("inject_participante", "mens"); ?></h3>
             <!--Miguel Select-->
       
            <!--MIGUel, CAMBIO UN SELEC POR UN BOTON CON UN DROPDOWN-->
            <form id="formulario_buscador">
            <input type="text" class="form-control float-right" id="buscador" placeholder="Buscar">
            </form>
            <button type="button" data-toggle="dropdown" id="botonEstado" class="btn btn-success dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"></span></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item " href="#" onclick="busquedaEstado('Todos');"><?php echo $Language->TablePhrase("inject_participante", "todos"); ?></a>
                            <a class="dropdown-item " href="#" onclick="busquedaEstado('Pendiente');"><?php echo $Language->TablePhrase("inject_participante", "pendiente"); ?></a>
                            <a class="dropdown-item " href="#" onclick="busquedaEstado('Inconcluso');"><?php echo $Language->TablePhrase("inject_participante", "inconcluso"); ?></a>
                            <a class="dropdown-item " href="#" onclick="busquedaEstado('Finalizado');"><?php echo $Language->TablePhrase("inject_participante", "finalizado"); ?></a>
                        </div>
        </div>

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
                                        <?php echo $Language->TablePhrase("inject_participante", "hr"); ?> {{mens.fstar}} <br> 
                                        <i class='far fa-clock text-info'></i> 
                                        <?php echo $Language->TablePhrase("inject_participante", "hs"); ?>{{mens.fstarsim}} 
                                    </span>
                                   </div>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text speedup" style="background-color:#f2f3f4">

                    <div class = "header">
                                            
                        <span
                                                class="float-right badge "
                                                v-bind:class="{'badge-primary': mens.calificacion == 'Pendiente', 'badge-success': mens.calificacion == 'Finalizado', 
                                                    'badge-warning': mens.calificacion == 'Inconcluso' }"
                                                >
                                                {{mens.calificacion}}
                                        </span>
                                        
                       
                        <div> 
                            <hr>
                            <!--MIGUEL Acordeon punto 148-->
                            <a data-toggle="collapse" v-bind:href="'#descripcion'+mens.id" role="button" aria-expanded="false">
                                    <h4><?php echo $Language->TablePhrase("inject_participante", "tmens"); ?>{{mens.titulo_mensaje}} <i class="fa" aria-hidden="true"></i></h4>   </a> 
                                   
                                    </div> 

                                    <hr>
                                    <div class="collapse" v-bind:id="'descripcion'+mens.id">
                                            <div class="card card-body">
                                            <span v-html="mens.mensaje"></span>
                                            </div>
                                    </div>
                                        <!--MIGUEL fin acordeon 148-->
                            <div class="stats">
                            <i class="cil-paperclip"></i> <br>
                            <a v-bind:href="'files/'+mens.filename"> {{mens.filename}}</a> 
                            <hr>
                            <a  data-toggle="collapse" v-bind:href="'#para'+mens.id" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                                            <i class="fa fa-users"></i> 

                                            <?php echo $Language->TablePhrase("inject_participante", "para"); ?>:</a>
                            <div class="collapse multi-collapse" v-bind:id="'para'+mens.id">
                                        <ul  v-for="destinatario in mens.destinatarios" v-if="mens.visible">
                                          <li> {{destinatario.destinatario}}.</li>
                                        </ul>
                                        </div>
                              </div
                              >
                              <p><!--MIGUEL, Region Respuestas-->
                                        <a  data-toggle="collapse" v-bind:href="'#respuestas'+mens.id" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                                            <i class="fa fa-users"></i>     
                                            <?php echo $Language->TablePhrase("inject_participante", "res"); ?></a><a class="badge badge-danger" v-if="mens.respuestasPendientes==1">Nuevo</a>
                                            </p>
                                           
                                            <div class="collapse multi-collapse" v-bind:id="'respuestas'+mens.id">
                                            <ul class="" v-for="respuesta in mens.respuestas" v-if="mens.visible" >
                                                <li><a   v-bind:href="'/homesimex/Email2View/'+respuesta.id+'?showdetail='"> {{respuesta.sujeto}}.</a></li>
                                            </ul>
                                        </div>  

                            <hr>
                            <div class="timeline-footer">

                                <a class="m-r-15 text-inverse-lighter" title="" data-caption="Enviar" v-bind:href="'/homesimex/Email2Add/'+mens.id+'?IdResMsg='+mens.id" data-original-title="Enviar">
                                <?php echo $Language->TablePhrase("inject_participante", "respon"); ?>&nbsp;<i class="fa fa-reply" aria-hidden="true"></i>

                                </a>│

                                <a class="m-r-15 text-inverse-lighter" title="" data-caption="Enviar" v-bind:href="'/homesimex/Email2Add?IdreenMsg='+mens.id" data-original-title="Enviar">
                                <?php echo $Language->TablePhrase("inject_participante", "reen"); ?> &nbsp;<i class="fa fa-random" aria-hidden="true"></i>

                                </a> │                               
  

                                <a type="button" class="m-r-15 text-inverse-lighter" data-toggle="collapse" v-bind:href="'#collapse'+mens.id" >
                                    <i class="fa fa-comments fa-fw fa-lg m-r-3"></i> <?php echo $Language->TablePhrase("inject_participante", "comen"); ?>
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
                                            <button class="btn btn-primary btn-sm shadow-none" v-on:click="hacerComentario(mens)" type="button"><?php echo $Language->TablePhrase("inject_participante", "env"); ?>
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

<script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.29.9.js"></script>
<script src="inject/pubnub.js"></script>
<script src="https://cdn.jsdelivr.net/npm/disableautofill@2.0.0/dist/disableautofill.min.js"></script>
<script type="text/javascript">
//Time line 
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
                follow: true,
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
            timeline.setCustomTimeMarker("Fecha Inicio<br>" , id1, false);
            timeline.addCustomTime(new Date(fechaFinSimulado), id2);
            timeline.setCustomTimeMarker("Fecha Fin<br>" , id2, false);

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

    var publishKey = 'pub-c-5260e585-8e9b-4d60-9ff8-1d10154850f4';
    var subscribeKey = 'sub-c-69a803ce-dbfd-11eb-85de-ba1258ebcf9d';

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
        document.getElementById("visualization").innerHTML="";
        loadData();
        $.ajax({
            url: "inject/pedir_mensajecliente.php?idMensaje="+code,
            success: function (es) {
                let ayuda = JSON.parse(es);
                if(ayuda.length == 0){
                    return;
                }
                let respuesta = ayuda[0];
                respuesta.numero_comentarios = 0;
                respuesta.respuestasPendientes=0;
                respuesta.comentarios = [];
                respuesta.respuestas=[];
                respuesta.entrada = "";
                respuesta.visible = true;
                obtenerRespuestas(respuesta.respuestas,respuesta.id);
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
                    mens.respuestasPendientes=0;
                    mens.comentarios = [];
                    mens.destinatarios = [];
                    mens.respuestas = [];
                    mens.entrada = "";
                    mens.visible = true;
                    obtenerRespuestas(mens,mens.id);
                    obtenerDestinatarios(mens,mens.id);
                    app.mensajes.push(mens);
                    
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
    function obtenerRespuestas(mens,id){// MIGUEL FUNCION PARA EXTRAER RESPUESTAS DEL COMENTARIO
    console.log(id);
        $.ajax({
            url: "inject/obtener_respuestas.php?idMensaje="+id,
            success: function (es) {
                console.log(es);
                if(es!="Vacio")
                {
                    let respuesta= JSON.parse(es);
                for(let i=0; i < respuesta.length;i++){
                    let res =respuesta[i];
                    if(res.estado_msg==0)
                    {
                        console.log("entra");
                        mens.respuestasPendientes=1;
                    }
                    let add = {
                        "sujeto":res.sujeto,
                        "id": res.id
                    };

                    mens.respuestas.push(add);
                }

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
    function busquedaEstado(estado){//MIGUEL funcion para buscar por estado
        for(let i = 0;i < app.mensajes.length;i++){
                let mens = app.mensajes[i];
                mens.visible = false;
                if(mens.calificacion==estado || estado=='Todos')
                {
                    mens.visible= true;
                }
        }
        }
</script>

<?= GetDebugMessage() ?>