<?php
class CategoryController extends BaseController
{
    public $model;
    public $data = [];

    public function __construct()
    {
        $this->model = $this->loadModel('CategoryModel');
    }

    public function index()
    {
        echo 'Danh sách danh mục';
    }

    public function show()
    {
        // Tạo một đối tượng CategoryModel
        $categoryModel = $this->loadModel('CategoryModel');

        // Gọi phương thức getCategories để lấy danh sách danh mục
        $this->data['categories'] = $categoryModel->getCategories();

        // Include view và truyền dữ liệu vào
        $this->loadView('categories/show', $this->data);
    }

    public function add()
    {
        // Load view để thêm danh mục
        $this->loadView('categories/add');
    }

   
    public function addCategory() {
        // Kiểm tra xem yêu cầu là phương thức POST và có chứa dữ liệu 'name' không
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
            // Lấy dữ liệu từ form
            $name = $_POST['name'];
            
            // Gọi phương thức addCategory trong CategoryModel để thêm category mới
            $result = $this->model->addCategory($name, date('Y-m-d H:i:s'));
            
            // Trả về phản hồi
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
        } else {
            // Trả về lỗi 405 Method Not Allowed nếu yêu cầu không phải phương thức POST hoặc thiếu dữ liệu 'name'
            http_response_code(405);
            echo json_encode(['error' => 'Phương thức không hợp lệ hoặc thiếu dữ liệu']);
        }
    }
    
    
    public function deleteCategory()
    {
        // Lấy ID danh mục cần xóa từ request POST
        $requestData = json_decode(file_get_contents('php://input'), true);
        $id = $requestData['id'];
    
        // Kiểm tra xem ID có tồn tại không
        if (isset($id)) {
            // Gọi phương thức deleteCategory trong CategoryModel để xóa danh mục
            $result = $this->model->deleteCategory($id);
    
            // Trả về phản hồi
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
        } else {
            // Trả về phản hồi lỗi nếu không tìm thấy ID
            http_response_code(400);
            echo json_encode(['error' => 'Lỗi: Không tìm thấy ID của danh mục cần xóa']);
        }
    }
    
}
?>