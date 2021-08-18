<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Kanban = &$Page;
?>
<html>
<head>
<title><?php echo $Language->TablePhrase("kanban", "titulo"); ?></title>



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
<?php


$projectName = "StartTuts";
$projectManagement = new ProjectManagement();
$statusResult = $projectManagement->getAllStatus();

$id_usuario = CurrentUserID();

class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "simexamerica";
	private $conn;
	
    function __construct() {
        $this->conn = $this->connectDB();
	}	
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
    function runBaseQuery($query) {
        $result = $this->conn->query($query);	
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        return $resultset;
    }
    
    
    
    function runQuery($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        
        if(!empty($resultset)) {
            return $resultset;
        }
    }
    
    function bindQueryParams($sql, $param_type, $param_value_array) {
        $param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) {
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array(
            $sql,
            'bind_param'
        ), $param_value_reference);
    }
    
    function insert($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
    
    function update($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
}

class ProjectManagement {
    function getProjectTaskByStatus($statusId, $projectName, $id_usuario) {
        $db_handle = new DBController();
        $query = "SELECT * FROM tbl_task WHERE status_id= ? AND project_name = ? AND id_users = $id_usuario";
        $result = $db_handle->runQuery($query, 'is', array($statusId, $projectName));
        return $result;
    }
    
    function getAllStatus() {
        $db_handle = new DBController();
        $query = "SELECT * FROM tbl_status";
        $result = $db_handle->runBaseQuery($query);
        return $result;
    }
    
    function editTaskStatus($status_id, $task_id) {
        $db_handle = new DBController();
        $query = "UPDATE tbl_task SET status_id = ? WHERE id = ?";
        $result = $db_handle->update($query, 'ii', array($status_id, $task_id));
        return $result;
    }
    
}
$projectManagement = new ProjectManagement();

/* $status_id = $_GET["status_id"];
$task_id = $_GET["task_id"]; */

$result = $projectManagement->editTaskStatus($status_id, $task_id);
?>

<body>
<div class="col-12">
        <div class="task-board col-12">
        <a class="btn btn-default ew-add-edit ew-add" title="" data-table="tbl_task" data-caption="Agregar" href="#" onclick="return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'/homesimex/TblTaskAdd'});" data-original-title="Agregar"><i data-phrase="AddLink" class="fas fa-plus ew-icon" data-caption="Agregar"></i></a>
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
                            <a class="btn btn-default ew-row-link ew-delete" onclick="return ew.confirmDelete(this);" title="" data-caption="Delete" href="/homesimex/TblTaskDelete/<?php echo $taskRow['id'] ?>" data-original-title="Delete"><i data-phrase="DeleteLink" class="fas fa-trash ew-icon" data-caption="Delete"></i></a>
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
         <script src="js/jquery-1.12.4.js"></script>
<script src="js/jquery-ui.js"></script>
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

<?= GetDebugMessage() ?>
