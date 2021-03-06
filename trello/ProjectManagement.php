<?php
require "DBController.php";

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
    function deleteTaskStatus( $task_id) {
        $db_handle = new DBController();
        $query = "delete from tbl_task WHERE id = ?";
        $result = $db_handle->update($query, 'ii', array($task_id));
        return $result;
    }
}
?>