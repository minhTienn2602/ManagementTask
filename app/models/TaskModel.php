<?php

class TaskModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }
    //Lấy danh sách Tasks
    public function getTasks() {
        $query = 'SELECT * FROM task';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Lấy detail của 1 task
    public function getDetail($id) {
        $query = 'SELECT * FROM task WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Cập nhật task
    public function updateTask($id, $name, $description, $start_date, $due_date, $finished_date, $status) {
    $query = 'UPDATE task SET name = :name, description = :description, start_date = :start_date, due_date = :due_date, finished_date = :finished_date, status = :status WHERE id = :id';
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':due_date', $due_date);
    $stmt->bindParam(':finished_date', $finished_date);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    echo 'update Model';
    }
    public function addTask($name, $description, $start_date, $due_date, $category_id) {
        // Prepare SQL query to insert task into database
        $query = 'INSERT INTO task (name, description, start_date, due_date, category_id) VALUES (:name, :description, :start_date, :due_date, :category_id)';
        $stmt = $this->db->prepare($query);
        
        // Bind parameters and execute the query
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':due_date', $due_date);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
    }
    public function deleteTask($id) {
        try {
            $query = 'DELETE FROM task WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            // Kiểm tra xem có bản ghi nào bị xóa không
            if ($stmt->rowCount() > 0) {
                $this->db->commit(); // Commit transaction
                error_log('okeeee');
                echo 'Xóa công việc thành công';
                
            } else {
                echo 'Không tìm thấy công việc để xóa';
                error_log('chiu');
            }
        } catch (PDOException $e) {
            // Ghi log lỗi nếu có lỗi xảy ra
            error_log('Error deleting task: ' . $e->getMessage());
            echo 'Đã xảy ra lỗi khi xóa công việc';
            error_log('that');
        }
    }
    
    

}
?>