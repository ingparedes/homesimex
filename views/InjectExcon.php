<?php

namespace PHPMaker2021\simexamerica;

// Page object
$InjectExcon = &$Page;
?>
<?php
  
  $_SESSION['idGrupo']= CurrentUserInfo("grupo");
  $_SESSION['id_user'] = CurrentUserID();

  ?>

<style>
    .timeline {
        list-style-type: none;
        margin: 0;
        padding: 0;
        position: relative
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        top: 5px;
        bottom: 5px;
        width: 5px;
        background: #ccc;
        left: 14%;
        margin-left: -2.5px
    }
    
    .timeline>li {
        position: relative;
        min-height: 50px;
        padding: 20px 0
    }
    
    .timeline .timeline-time {
        position: absolute;
        left: 0;
        width: 12%;
        text-align: right;
        top: 30px
    }
    
    .timeline .timeline-time .date,
    .timeline .timeline-time .time {
        display: block;
        font-weight: 400
    }
    
    .timeline .timeline-time .date {
        line-height: 12px;
        font-size: 12px
    }
    
    .timeline .timeline-time .time {
        line-height: 24px;
        font-size: 20px;
        color: #242a30
    }
    
    .timeline .timeline-icon {
        left: 9%;
        position: absolute;
        width: 10%;
        text-align: center;
        top: 40px
    }
    
    .timeline .timeline-icon a {
        text-decoration: none;
        width: 20px;
        height: 20px;
        display: inline-block;
        border-radius: 20px;
        background: #d9e0e7;
        line-height: 20px;
        color: #fff;
        font-size: 14px;
        border: 5px solid #ccc;
        transition: border-color .2s linear
    }
    
    .timeline .timeline-body {
        margin-left: 16%;
        margin-right: 1%;
        background: #fff;
        position: relative;
        padding: 20px 25px;
        border-radius: 6px
    }
    
    .timeline .timeline-body:before {
        content: '';
        display: block;
        position: absolute;
        border: 10px solid transparent;
        border-right-color: #fff;
        left: -20px;
        top: 20px
    }
    
    .timeline .timeline-body>div+div {
        margin-top: 15px
    }
    
    .timeline .timeline-body>div+div:last-child {
        margin-bottom: -20px;
        padding-bottom: 20px;
        border-radius: 0 0 6px 6px
    }
    
    .timeline-header {
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e7eb;
        line-height: 30px
    }
    
    .timeline-header .userimage {
        float: left;
        width: 34px;
        height: 34px;
        border-radius: 40px;
        overflow: hidden;
        margin: -2px 10px -2px 0
    }
    
    .timeline-header .username {
        font-size: 16px;
        font-weight: 600
    }
    
    .timeline-header .username,
    .timeline-header .username a {
        color: #2d353c
    }
    
    .timeline img {
        max-width: 100%;
        display: block
    }
    
    .timeline-content {
        letter-spacing: .25px;
        line-height: 18px;
        font-size: 13px
    }
    
    .timeline-content:after,
    .timeline-content:before {
        content: '';
        display: table;
        clear: both
    }
    
    .timeline-title {
        margin-top: 0
    }
    
    .timeline-footer {
        background: #fff;
        border-top: 1px solid #e2e7ec;
        padding-top: 15px
    }
    
    .timeline-footer a:not(.btn) {
        color: #575d63
    }
    
    .timeline-footer a:not(.btn):focus,
    .timeline-footer a:not(.btn):hover {
        color: #2d353c
    }
    
    .timeline-likes {
        color: #6d767f;
        font-weight: 600;
        font-size: 12px
    }
    
    .timeline-likes .stats-right {
        float: right
    }
    
    .timeline-likes .stats-total {
        display: inline-block;
        line-height: 20px
    }
    
    .timeline-likes .stats-icon {
        float: left;
        margin-right: 5px;
        font-size: 9px
    }
    
    .timeline-likes .stats-icon+.stats-icon {
        margin-left: -2px
    }
    
    .timeline-likes .stats-text {
        line-height: 20px
    }
    
    .timeline-likes .stats-text+.stats-text {
        margin-left: 15px
    }
    
    .timeline-comment-box {
        background: #f2f3f4;
        margin-left: -10px;
        margin-right: -10px;
        padding: 20px 25px
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
    
    .lead {
        margin-bottom: 20px;
        font-size: 21px;
        font-weight: 300;
        line-height: 0.4;
    }
    
    .text-danger, .text-red {
        color: #ff5b57!important;
    }
    .comment-text {
        font-size: 12px
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
.direct-chat-messages {
    overflow: auto;
    width: 100%;
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
</style>
    
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>

<div class="alert alert-success" style="display:none;"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card direct-chat direct-chat-primary">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Mensajes Programados</h3>
                        <form id="formulario_buscador">
                        <input type="text" class="form-control float-right" id="buscador_admin" placeholder="Buscar" autocomplete="off">
                        </form>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" id="vue-admin">
                    
                        <!-- inicia mesajes programado -->
                        <div class="direct-chat-message4s"  v-for="mens in mensajes" v-if="mens.visible">
                            <!-- Message. Default to the left -->
                            <div class="direct-chat-msg" >
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{mens.nombre_usuario}}</span>
                                    <span class="direct-chat-timestamp float-right">
                                        <i class='far fa-clock text-primary'></i> 
                                        <span v-bind:class="{'badge-danger': mens.fstar == '2000/01/01 00:00'}">
                                        Hora real {{mens.fstar}} <span class="badge-danger" v-if="mens.fstar==='2000/01/01 00:00'">PAUSADO</span></span>
                                         <br> <!--HACER ABAJO-->
                                        <i class='far fa-clock text-info'></i> 
                                        Hora Simulada  {{mens.fstarsim}} 
                                    </span>
                                   </div>
                                <!-- /.direct-chat-infos -->
                                <img class="direct-chat-img" src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="image">
                                <!-- /.direct-chat-img -->
                                <div class="direct-chat-text" style="background-color:#f2f3f4" >
                                    <div class = "header">
                                    <span><em>Tarea: {{mens.titulo_tarea}} </em></span>
                                        <h4>Mensaje:{{mens.titulo_mensaje}} </h4> 
                                        
                                    </div> 
                                    <hr>
                                    <span v-html="mens.mensaje"></span>
                                    
                                    <div class="stats">
                                                 <i class="cil-paperclip"></i> <br>
                                          
                                             <a v-bind:href="'files/'+mens.filename"> {{mens.filename}}</a>                                                                                    
                                        </div>
                                        <hr>
                                           <p>
                                       
                                            <a  data-toggle="collapse" v-bind:href="'#para'+mens.id" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                                            <i class="fa fa-users"></i>     
                                            Para:</a>
                                            </p>
                                           
                                            <div class="collapse multi-collapse" v-bind:id="'para'+mens.id">
                                            <ul class="" v-for="destinatario in mens.destinatarios" v-if="mens.visible" >
                                                  <li> {{destinatario.destinatario}}.</li>
                                            </ul>
                                        </div>   
                                

                                    <hr>
                                    <div class="card-tools">
                                    <a class="btn btn-tool" v-bind:href="'inject/actualizarProgramacion.php?opcion=1&idMensaje='+mens.id"><i class="fas fa-play"></i></a>
                                    <a class="btn btn-tool" v-bind:href="'inject/actualizarProgramacion.php?opcion=2&idMensaje='+mens.id"><i class="fas fa-stop"></i></a>
                                   <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle" onclick="window.location.href='MensajesEdit/176?showmaster=tareas&fk_id_tarea=104'" >
                                            <i class="fas fa-pen"></i>
                                    </button>
                                    </div>
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>
                        <!-- /.direct-chat-msg -->
                         </div>
                    <!-- termina mensajes programado -->
                    </div>
                </div>
            <!-- chat fin left -->
            </div>
         
            <div class="col">
                <div class="card direct-chat direct-chat-primary">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Mensajes enviados</h3>
                        <!--Miguel Select-->
                        <button type="button" data-toggle="dropdown" id="botonEstado" class="btn btn-success dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"></span></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item active" href="#" onclick=""></a>
                            <a class="dropdown-item " href="#" onclick="busquedaEstado('Pendiente');">Pendiente</a>
                            <a class="dropdown-item " href="#" onclick="busquedaEstado('Inconcluso');">Inconcluso</a>
                            <a class="dropdown-item " href="#" onclick="busquedaEstado('Finalizado');">Terminado</a>
                        </div>
                        <!--MIGUel, CAMBIO UN SELEC POR UN BOTON CON UN DROPDOWN-->
                        <form id="formulario_buscador">
                        <input type="text" class="form-control float-right" id="buscador_client" placeholder="Buscar" autocomplete='false'>
                        </form>
                        
                    </div>
                    <div class="container" id="vue-chat">
                        <ul class="timeline" v-for="mens in mensajes" v-if="mens.visible">
                            <li>
                                <!-- begin timeline-time -->
                                <div class="timeline-time">
                                    <span class="time" ><i class='far fa-clock text-primary'></i></span>
                                    <span class="date"> <small> Hora Real</small> </span>
                                    <span class="date"> <small> {{mens.fstar.split(' ')[0]}} </small> </span>
                                    <span class="time">{{mens.fstar.split(' ')[1]}}</span>
                        
                                    <span class="time" ><hr><i class='far fa-clock text-info'></i></span>
                                    <span class="date"><small>  Hora Simulada </small></span>
                                    <span class="date"><small> {{mens.fstarsim.split(' ')[0]}} </small></span>
                                    <span class="time">{{mens.fstarsim.split(' ')[1]}}</span>
                                </div>
                                <!-- end timeline-time -->
                                <!-- begin timeline-icon -->
                                <div class="timeline-icon">
                                    <a href="javascript:;">&nbsp;</a>
                                </div>
                                <!-- end timeline-icon -->
                                <!-- begin timeline-body -->
                                <div class="timeline-body border speedup">
                                    <div class="timeline-header">
                                        <span class="userimage"><img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt=""></span>
                                        <span><strong> {{mens.nombre_usuario}} </strong></span>
                                       

                                        <span
                                                class="float-right badge "
                                                v-bind:class="{'badge-primary': mens.calificacion == 'Pendiente', 'badge-success': mens.calificacion == 'Finalizado', 
                                                    'badge-warning': mens.calificacion == 'Inconcluso' }"
                                                >
                                                {{mens.calificacion}}
                                        </span>

                                       </div>
                                    <div class="timeline-content">
                                        <p>
                                        <span><em>Tarea: {{mens.titulo_tarea}} </em></span>
                                        <h5>Titulo mensaje: {{mens.titulo_mensaje}} </h5> 

                                        <span v-html="mens.mensaje"></span>
                                        </p>
                                    </div>
                                    <div class="timeline-likes">
                                        <div class="stats-right">
                                        <span class="stats-text">{{mens.numero_comentarios}} Comentarios</span>
                                        </div>
                                        <div class="stats">
                                        <i class="cil-paperclip"></i><br>
                                          
                                           <a v-bind:href="'files/'+mens.filename"> {{mens.filename}}</a>
                                           <hr>
                                           <p>
                                       
                                            <a  data-toggle="collapse" v-bind:href="'#para'+mens.id" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                                            <i class="fa fa-users"></i>     
                                            Para:</a>
                                            </p>
                                           
                                            <div class="collapse multi-collapse" v-bind:id="'para'+mens.id">
                                            <ul class="" v-for="destinatario in mens.destinatarios" v-if="mens.visible" >
                                                  <li> {{destinatario.destinatario}}.</li>
                                            </ul>
                                        </div>

                                        </div>
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="m-r-15 text-inverse-lighter" data-toggle="collapse" v-bind:href="'#collapse'+mens.id" >
                                            <i class="fa fa-comments fa-fw fa-lg m-r-3"></i> Comentario
                                        </a> 
                                    
                                        <div class="btn-group dropleft float-right">
                                    <button class="btn btn-primary btn-sm dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Calificar
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" v-bind:href="'Inject/calificar.php?calificacion=1&idMensaje='+mens.id">Pendiente</a>
                                        <a class="dropdown-item" v-bind:href="'Inject/calificar.php?calificacion=2&idMensaje='+mens.id">Inconcluso </a>
                                        <a class="dropdown-item" v-bind:href="'Inject/calificar.php?calificacion=3&idMensaje='+mens.id">Finalizado</a>
                                    </div>
                                    </div>


                                        
                                    </div>

                                    <div class="collapse" v-bind:id="'collapse'+mens.id">
                                        <div class="timeline-comment-box">
                                            <div class="user">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar6.png">
                                            </div>
                                            <div class="input">
                                                <form action=""> 
                                                    <div class="input-group">
                                                        <textarea type="text" class="textarealine" v-model="mens.entrada"></textarea>
                                                    </div>
                                                    <div class="mt-2 text-right">
                                                        <button class="btn btn-primary btn-sm shadow-none" v-on:click="hacerComentario(mens)" type="button">Enviar
                                                    </div>
                                                    <hr>       
                                                    <div v-for="coment in mens.comentarios">
                                                        <span><em> {{coment.nombre}} </span>
                                                        <span class="float-right">{{coment.hora}}</span></em>
                                                        <div class="timeline-content">  
                                                            <p class="comment-text" >
                                                                <small>
                                                                    {{coment.texto}}
                                                                </small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>            
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.29.9.js"></script>
<script src="inject/pubnub.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/disableautofill@2.0.0/dist/disableautofill.min.js"></script>
<script>
   
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
                        "idUser":1,//Cambiar session id
                        "comentario":mensaje.entrada
                    },
                    success: function (es) {
                        console.log(es);
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

    
    var admin = new Vue({
        el: '#vue-admin',
        data: {
            mensajes: []
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
                        app.mensajes[i].numero_comentarios++;
                    }
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
    function obtenerComentariosVarios(mens,id){
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
                    mens.comentarios.push(add);
                    mens.numero_comentarios++;
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function llegandoMensaje(msg){
        let code = msg.message.code;
        for(let i = 0;i < admin.mensajes.length;i++){
            let men = admin.mensajes[i];
            if(men.id == code){
                admin.mensajes.splice(i,1);
                break;
            }
        }
        for(let i = 0;i < app.mensajes.length;i++){
            if(app.mensajes[i].id == code){
                return;
            }
        }
        $.ajax({
            url: "inject/pedir_mensaje.php?idMensaje="+code,
            success: function (es) {
                let ayuda = JSON.parse(es);
                if(ayuda.length == 0){
                    return;
                }
                let respuesta = ayuda[0];
                respuesta.numero_comentarios = 0;
                respuesta.numero_destinatarios=0;
                respuesta.comentarios = [];
                respuesta.destinatarios=[];
                respuesta.entrada = "";
                respuesta.visible = true;
                obtenerDestinatarios(respuesta,respuesta.id);
                app.mensajes.push(respuesta);
                
                obtenerComentariosVarios(respuesta,respuesta.id);
            },
            error: function (e) {
                console.log(e);
            }
        });
        
    }

    function obtenerMensajes(){
        $.ajax({
            url: "inject/respuesta.php",
            success: function (es) {
                let respuesta = JSON.parse(es);
                console.log(respuesta);
                for(let i = 0;i < respuesta.length;i++){
                    let mens = respuesta[i];
                    mens.destinatarios= [];
                    obtenerDestinatarios(mens,mens.id);
                    mens.visible = true;
                    admin.mensajes.push(mens);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function obtenerMensajesEnviados(){
        $.ajax({
            url: "inject/enviados.php",
            success: function (es) {
                let respuesta = JSON.parse(es);
                for(let i = 0;i < respuesta.length;i++){
                    let mens = respuesta[i];
                    mens.numero_comentarios = 0;
                    mens.numero_destinatarios=0;
                    mens.comentarios = [];
                    mens.destinatarios = [];
                    mens.entrada = "";
                    mens.visible = true;
                    app.mensajes.push(mens);
                    obtenerDestinatarios(mens,mens.id);
                    obtenerComentariosVarios(mens,mens.id);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function preguntaFrecuente(){
        //https://ps.pndsn.com/publish/pub-c-74306dc6-f082-4bc8-9e59-18804033f25d/sub-c-834f0024-caec-11eb-bdc5-4e51a9db8267/0/canal-02/myCallback/%7B%0A%22code%22%3A177%0A%7D
    }

    $(document).ready(function(){
        $("#buscador_admin").on('keyup', function() {
            let val = $("#buscador_admin").val();
            for(let i = 0;i < admin.mensajes.length;i++){
                let mens = admin.mensajes[i];
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
        //$("#buscador_client").disableAutoFill({});
        
        $("#buscador_client").on('keyup', function() {
            let val = $("#buscador_client").val();
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
                if(mens.nombre_usuario.toLowerCase().includes(val.toLowerCase())){
                    mens.visible = true;
                }
                if(mens.calificacion.toLowerCase().includes(val.toLowerCase())){
                    mens.visible = true;
                }

            }
        });
        obtenerMensajes();
        obtenerMensajesEnviados();
        
    });
    function busquedaEstado(estado){//MIGUEL funcion para buscar por estado
        for(let i = 0;i < app.mensajes.length;i++){
                let mens = app.mensajes[i];
                mens.visible = false;
                if(mens.calificacion==estado)
                {
                    mens.visible= true;
                }
        }
        }
    var daf =new disableautofill({
        'form': '#formulario_buscador'
    });
    daf.init();
</script>

<?= GetDebugMessage() ?>

