<?php

class CategoryModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Lấy danh sách các category
    public function getCategories()
    {
        $query = 'SELECT * FROM CATEGORY';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm một category mới
    public function addCategory($name, $dateCreated) {
        try {
            // Kiểm tra xem tên danh mục có trống không
            if (empty($name)) {
                throw new Exception('Tên danh mục không được để trống');
            }
            
            $query = 'INSERT INTO category (name, date_created) VALUES (:name, :date_created)';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':date_created', $dateCreated);
            $stmt->execute();
            return ['success' => 'Thêm category thành công'];
        } catch (PDOException $e) {
            return ['error' => 'Đã xảy ra lỗi khi thêm category'];
        }
    }

    // Xóa một category
    public function deleteCategory($id)
    {
        try {
            // Kiểm tra xem có task nào đang trỏ đến category này không
            $query_check = 'SELECT COUNT(*) FROM task WHERE category_id = :id';
            $stmt_check = $this->db->prepare($query_check);
            $stmt_check->bindParam(':id', $id);
            $stmt_check->execute();
            $task_count = $stmt_check->fetchColumn();
    
            // Nếu có task trỏ đến category này, không thực hiện xóa và thông báo lỗi
            if ($task_count > 0) {
                throw new Exception('Không thể xóa category có task trỏ đến.');
            }
    
            // Nếu không có task trỏ đến, thực hiện xóa category
            $query_delete = 'DELETE FROM CATEGORY WHERE id = :id';
            $stmt_delete = $this->db->prepare($query_delete);
            $stmt_delete->bindParam(':id', $id);
            $stmt_delete->execute();
    
            // Kiểm tra xem có category nào bị xóa không
            if ($stmt_delete->rowCount() > 0) {
                return ['success' => 'Xóa category thành công'];
            } else {
                return ['error' => 'Không tìm thấy category để xóa'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Đã xảy ra lỗi khi xóa category'];
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }
    
}

?>