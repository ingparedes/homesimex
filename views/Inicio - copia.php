<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Inicio = &$Page;
?>
<?php

$dbconn = Db();
$con = mysqli_connect($dbconn['host'],$dbconn['user'],$dbconn['password'],$dbconn['dbname']);
echo CurrentUserID();
$_SESSION['iduser'] = CurrentUserID();
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
</style>

<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.delete').on('click', function(e) {
        e.preventDefault();
        var parent = $(this).parent().parent().attr('id');
        var item = $(this).attr('data');
 
        var dataString = 'item='+item;
        swal({
            title: "WARNING:", 
            text: "Are you sure you want to delete this connection?", 
            type: "warning",
            inputType: "submit",
            showCancelButton: true,
            closeOnConfirm: true
  
       }, //end swal   }


      //  if(confirm(' esta seguro?'))

      function(isConfirm) {
      if (isConfirm == true)  {
        
        $.ajax({
            type: "POST",
            url: "process.php",
            data: dataString,
            success: function(response) {			
                $('.alert-success').empty();
                $('.alert-success').append(response).fadeIn("slow");
                $('#'+parent).fadeOut("slow");
            }
        });

        });

      });
                  
});    
</script>
<div class="alert alert-success" style="display:none;"></div>
<div class="container-fluid">
  <div class="row">
    <div class="col">
    
                  <!-- chat inicio left -->
          <div class="card direct-chat direct-chat-primary">
              <div class="card-header bg-primary">
                <h3 class="card-title">Mensajes Programados</h3>
                <form id="formulario_buscador">
                <input type="text" class="form-control float-right" placeholder="Buscar">
                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <!-- inicia mesajes programado -->
                <div class="direct-chat-messages">
                  <!-- Message. Default to the left -->
                  <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">Alexander Pierce</span>

                      <span class="direct-chat-timestamp float-right"><i class='far fa-clock text-primary'></i> Hora real 23 Jan 2:00 pm <br> <i class='far fa-clock text-info'></i> Hora Simulada  23 Jan 2:00 pm  </span>
                     
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text" style="background-color:#f2f3f4">
                    <div class = "header">
                       <h4>  Titulo mensaje: <?php echo utf8_encode($row["titulo"]);  ?>  </h4> 
                       <span><em> Titulo tarea: <?php echo utf8_encode($row["titulo_tarea"]);  ?> </em></span>
                    </div> 
                      <hr>
                      Is this template really for free? That's unbelievable!
                      <hr>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool ">
                          <i class="fas fa-play"></i>
                          </button>
                          <button type="button" class="btn btn-tool delete"  data="176" title="Contacts" data-widget="chat-pane-toggle">
                          <i class="fas fa-stop"></i>
                          </button>
                          
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
                <input type="text" class="form-control float-right" placeholder="Buscar">
              </div>
  <div class="container">
              <ul class="timeline">
              <li>
         <!-- begin timeline-time -->
         <div class="timeline-time">
         <span class="time" ><i class='far fa-clock text-primary'></i></span>
         <span class="date"> <small> Hora Real</small> </span>
            <span class="date"> <small> 2021/05/06 </small> </span>
            <span class="time">04:20</span>
            
            <span class="time" ><hr><i class='far fa-clock text-info'></i></span>
            <span class="date"><small>  Hora Simulada </small></span>
            <span class="date"><small> 2021/05/06 </small></span>
            <span class="time">18:20</span>
         </div>
         <!-- end timeline-time -->
         <!-- begin timeline-icon -->
         <div class="timeline-icon">
            <a href="javascript:;">&nbsp;</a>
         </div>
         <!-- end timeline-icon -->
         <!-- begin timeline-body -->
         <div class="timeline-body border">
            <div class="timeline-header">
               <span class="userimage"><img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt=""></span>
               <span><strong> John Smith </strong></span>
              </div>
            <div class="timeline-content">
               <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc faucibus turpis quis tincidunt luctus.
                  Nam sagittis dui in nunc consequat, in imperdiet nunc sagittis.
               </p>
            </div>
            <div class="timeline-likes">
               <div class="stats-right">
                  <span class="stats-text">21 comentarios</span>
               </div>
               <div class="stats">
                <span class="stats-total"></span>
               </div>
            </div>
            <div class="timeline-footer">
            <a class="m-r-15 text-inverse-lighter" data-toggle="collapse" href="#collapseExample" ><i class="fa fa-comments fa-fw fa-lg m-r-3"></i> Comment</a> 
         
           </div>
          <div class="collapse" id="collapseExample">
            <div class="timeline-comment-box">
               <div class="user"><img src="https://bootdey.com/img/Content/avatar/avatar6.png"></div>
               <div class="input">
                  <form action=""> 
                     <div class="input-group">
                        <textarea type="text" class="textarealine"></textarea>
                      </div>
                      <div class="mt-2 text-right"><button class="btn btn-primary btn-sm shadow-none" type="button">Envio</div>
                             <hr>       
                            <div>
                               
                                    <span><em> Jane Smith </span>  <span class="float-right">12:39 PM</span></em>
                                    <div class="timeline-content">  
                                        <p class="comment-text" ><small>No not yet, the transaction hasn't cleared yet. I will let you know as soon as everything goes through. Any idea where you want to get lunch today?</small></p>
                                    </div>
                              
                            </div>
                      </div>
                  </form>
               </div>
            </div>
         </div>
         <!-- end timeline-body -->
      </li>












</ul>
</div>            
            </div>
   
      </div>
</div>
</div>

      

<script type="text/javascript">
	$(document).ready(function(){

        
      //  setInterval(function(){ 
      //     $('#tabla').load('refresh_msg.php');

      //     }, 6000);
    
    
    });
    
    
</script>


<?= GetDebugMessage() ?>
