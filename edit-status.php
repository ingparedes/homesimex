<?php 
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "simexamerica";
	private $conn;
	
    function __construct() {
        $this->conn = $this->connectDB();
	}	
	
	function connect() {
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
        $_handle = new DBController();
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
    function deleteTaskStatus( $task_id) {
        $db_handle = new DBController();
        $query = "delete from tbl_task WHERE id = ?";
        $result = $db_handle->update($query, 'ii', array($task_id));
        return $result;
    }
}

$projectManagement = new ProjectManagement();

$status_id = $_GET["status_id"];
$task_id = $_GET["task_id"];

$result = $projectManagement->editTaskStatus($status_id, $task_id);
?>