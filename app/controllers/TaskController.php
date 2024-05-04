<?php
class TaskController extends BaseController
{
    public $model;
    public $data=[];
    public function __construct(){
        $this->model=$this->loadModel('TaskModel');
    }
    public function index(){
        echo 'DS Task day';
    }
    public function show() {
        // Tạo một đối tượng TaskModel
        $taskModel = $this->loadModel('TaskModel');

        // Gọi phương thức getTasks để lấy danh sách công việc
        $this->data['list_task']= $taskModel->getTasks();
       
        // Include view và truyền dữ liệu vào
        $this->loadView('tasks/show', $this->data);
    }
    public function detail($id=0) {
         // Tạo một đối tượng TaskModel
         $taskModel = $this->loadModel('TaskModel');
         // Gọi phương thức getTasks để lấy danh sách công việc
         $this->data['detail'] = $taskModel->getDetail($id);
         // Include view và truyền dữ liệu vào
         $this->loadView('tasks/detail', $this->data);
    }
    public function update($id=0) {
        // Tạo một đối tượng TaskModel
        $taskModel = $this->loadModel('TaskModel');
        // Gọi phương thức getTasks để lấy danh sách công việc
        $this->data['detail'] = $taskModel->getDetail($id);
        // Include view và truyền dữ liệu vào
        $this->loadView('tasks/update', $this->data);
   }


   //Update task
   public function updateTask() {
    // Lấy dữ liệu từ form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $due_date = $_POST['due_date'];
    $finished_date = $_POST['finished_date'];
    $status = $_POST['status'];
    
    // Tạo một đối tượng TaskModel
    $taskModel = $this->loadModel('TaskModel');
    
    // Gọi phương thức updateTask trong TaskModel để cập nhật dữ liệu
    $taskModel->updateTask($id, $name, $description, $start_date, $due_date, $finished_date, $status);

    // Trả về phản hồi thành công
    http_response_code(200);
    }

    //action gọi màn hình add task
    public function add() {
        // Load categories from the model
        $categoryModel = $this->loadModel('CategoryModel');
        $this->data['categories'] = $categoryModel->getCategories();
        
        // Load view to add task
        $this->loadView('tasks/add', $this->data);
    }
    //action thêm 1 task
    public function addTask() {
        // Retrieve data from the form
        $name = $_POST['name'];
        $description = $_POST['description'];
        $start_date = $_POST['start_date'];
        $due_date = $_POST['due_date'];
        $category_id = $_POST['category'];
        
        // Call the method in TaskModel to add task
        $this->model->addTask($name, $description, $start_date, $due_date, $category_id);
        
        // Return success response
        http_response_code(200);
        echo 'Thêm công việc thành công';
    }
    public function deleteTask() {
        // Lấy ID công việc cần xóa từ request POST
        $requestData = json_decode(file_get_contents('php://input'), true);
        $id = $requestData['id'];
        
        // Kiểm tra xem ID có tồn tại không
        if(isset($id)) {
            // Tạo một đối tượng TaskModel
            $taskModel = $this->loadModel('TaskModel');
        
            // Gọi phương thức deleteTask trong TaskModel để xóa công việc
            $taskModel->deleteTask($id);
            
            // Trả về phản hồi thành công
            http_response_code(200);
            echo 'Xóa công việc thành công';
        } else {
            // Trả về phản hồi lỗi nếu không tìm thấy ID
            http_response_code(400);
            echo 'Lỗi: Không tìm thấy ID của công việc cần xóa';
        }
    }
    
    
    
    
    
}