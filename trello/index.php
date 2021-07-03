<?php
require_once "ProjectManagement.php";

$projectName = "StartTuts";
$projectManagement = new ProjectManagement();
$statusResult = $projectManagement->getAllStatus();
session_start();
$id_usuario = $_SESSION['id_usuario'];
?>
<html>
<head>
<title>Trello Like Drag and Drop Cards for Project Management Software</title>
<link rel="stylesheet"
    href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
body {
    font-family: arial;
}
.task-board {
    background: #2c7cbc;
    display: inline-block;
    padding: 12px;
    border-radius: 3px;
   
    white-space: nowrap;
    
    overflow-x: scroll;
    min-height: 300px;
}

.status-card {
    width: 250px;
    margin-right: 8px;
    background: #e2e4e6;
    border-radius: 3px;
    display: inline-block;
    vertical-align: top;
    font-size: 0.9em;
}

.status-card:last-child {
    margin-right: 0px;
}

.card-header {
    width: 100%;
    padding: 10px 10px 0px 10px;
    box-sizing: border-box;
    border-radius: 3px;
    display: block;
    font-weight: bold;
}

.card-header-text {
    display: block;
}

ul.sortable {
    padding-bottom: 10px;
}

ul.sortable li:last-child {
    margin-bottom: 0px;
}

ul {
    list-style: none;
    margin: 0;
    padding: 0px;
}

.text-row {
    padding: 15px 10px;
    margin: 10px;
    background: #fff;
    box-sizing: border-box;
    border-radius: 3px;
    border-bottom: 1px solid #ccc;
    cursor: pointer;
    font-size: 0.8em;
    white-space: normal;
    line-height: 20px;
}

.ui-sortable-placeholder {
    visibility: inherit !important;
    background: transparent;
    border: #666 2px dashed;
}
</style>
</head>
<body>
<div class="col-12">
        <div class="task-board col-12">
            <?php
            foreach ($statusResult as $statusRow) {
                $taskResult = $projectManagement->getProjectTaskByStatus($statusRow["id"], $projectName, $id_usuario);
                ?>
                <div class="status-card">
                    <div class="card-header">
                        <span class="card-header-text"><?php echo $statusRow["status_name"]; ?></span>
                    </div>
                    <ul class="sortable ui-sortable"
                        id="sort<?php echo $statusRow["id"]; ?>"
                        data-status-id="<?php echo $statusRow["id"]; ?>">
                <?php
                if (! empty($taskResult)) {
                    foreach ($taskResult as $taskRow) {
                        ?>
                
                     <li class="text-row ui-sortable-handle"
                            data-task-id="<?php echo $taskRow["id"]; ?>">
                            
                            <p align="right">
                                                      
                            <a class="btn btn-default ew-row-link ew-edit" title="" data-table="tbl_task" data-caption="Editar" href="#" onclick="return ew.modalDialogShow({lnk:this,btn:'SaveBtn',url:'/homesimex/TblTaskEdit/<?php echo $taskRow['id'] ?>'});" data-original-title="Editar"><i data-phrase="EditLink" class="icon-edit ew-icon" data-caption="Editar"></i></a>
                             <button class="btn btn-primary" style="marginleft: 1em" (click)=""><i class="fa fa-times"></i></button> 
                                                      </p>
                            <?php echo $taskRow["title"]; ?></li>
                <?php
                    }
                }
                ?>
                                                 </ul>
                </div>
                <?php
            }
            ?>
        </div>
        </div>
    <script>
 $( function() {
     var url = 'edit-status.php';
     $('ul[id^="sort"]').sortable({
         connectWith: ".sortable",
         receive: function (e, ui) {
             var status_id = $(ui.item).parent(".sortable").data("status-id");
             var task_id = $(ui.item).data("task-id");
             $.ajax({
                 url: url+'?status_id='+status_id+'&task_id='+task_id,
                 success: function(response){
                     }
             });
             }
     
     }).disableSelection();
     } );
  </script>
</body>
</html>