<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách công việc</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .container {
        margin-top: 50px;
    }

    .task-table th,
    .task-table td {
        padding: 10px;
        text-align: center;
    }

    .back-button {
        margin-top: 20px;
    }

    /* Thêm CSS tùy chỉnh để căn chỉnh các nút trong cột "Actions" */
    .action-buttons {
        display: flex;
        justify-content: space-between;
    }

    /* Giảm padding của cột "Actions" để giảm chiều rộng của nút */
    .task-table .action-col {
        padding: 5px;
    }

    /* Thêm CSS cho phân trang */
    .pagination {
        margin-top: 20px;
    }

    .pagination-btn {
        margin: 0 5px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Danh sách công việc</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="Nhập từ khóa...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" onclick="searchTasks()">Tìm kiếm</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <select class="form-control" id="statusFilter" onchange="filterTasks()">
                    <option value="all">Tất cả</option>
                    <option value="TODO">TODO</option>
                    <option value="IN PROGRESS">IN PROGRESS</option>
                    <option value="FINISHED">FINISHED</option>
                </select>
                <!-- Đưa nút Refresh vào trong một hàng mới -->
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary mt-2" onclick="refreshTable()">Refresh</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered task-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>description</th>
                        <th>start_date</th>
                        <th>due_date</th>
                        <th>finished_date</th>
                        <th>status</th>
                        <th>Category ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="taskTableBody">
                    <!-- Dữ liệu task sẽ được thêm vào đây -->
                </tbody>
            </table>
        </div>
        <div id="pagination" class="pagination">
            <!-- Nút Previous và Next sẽ được thêm vào đây -->
        </div>
        <button class="btn btn-secondary back-button" onclick="goBack()">Back</button>
    </div>

    <script>
    // Dữ liệu các công việc
    var tasks = <?php echo json_encode($list_task); ?>;
    var currentPage = 1;
    var rowsPerPage = 5;

    // Hàm hiển thị dữ liệu của trang hiện tại
    function displayCurrentPage() {
        var startIndex = (currentPage - 1) * rowsPerPage;
        var endIndex = startIndex + rowsPerPage;
        var taskTableBody = document.getElementById('taskTableBody');
        taskTableBody.innerHTML = '';
        for (var i = startIndex; i < endIndex && i < tasks.length; i++) {
            var task = tasks[i];
            taskTableBody.innerHTML += `
                <tr class="taskRow">
                    <td>${task['id']}</td>
                    <td>${task['name']}</td>
                    <td>${task['description']}</td>
                    <td>${task['start_date']}</td>
                    <td>${task['due_date']}</td>
                    <td>${task['finished_date']}</td>
                    <td>${task['status']}</td>
                    <td>${task['category_id']}</td>
                    <td class="action-col">
                        <div class="action-buttons">
                            <button class="btn btn-info btn-sm" onclick="viewTask(${task['id']})">View</button>
                            <button class="btn btn-warning btn-sm" onclick="updateTask(${task['id']})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteTask(${task['id']})">Delete</button>
                        </div>
                    </td>
                </tr>`;
        }
    }

    // Hàm tạo các nút chuyển trang
    function createPaginationButtons() {
        var totalPages = Math.ceil(tasks.length / rowsPerPage);
        var paginationDiv = document.getElementById('pagination');
        paginationDiv.innerHTML = '';
        if (totalPages > 1) {
            paginationDiv.innerHTML +=
                `<button class="btn btn-primary pagination-btn" onclick="previousPage()">Previous</button>`;
            for (var i = 1; i <= totalPages; i++) {
                paginationDiv.innerHTML +=
                    `<button class="btn btn-secondary pagination-btn" onclick="goToPage(${i})">${i}</button>`;
            }
            paginationDiv.innerHTML +=
                `<button class="btn btn-primary pagination-btn" onclick="nextPage()">Next</button>`;
        }
    }

    // Hàm chuyển đến trang trước
    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            displayCurrentPage();
        }
    }

    // Hàm chuyển đến trang kế tiếp
    function nextPage() {
        var totalPages = Math.ceil(tasks.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayCurrentPage();
        }
    }

    // Hàm chuyển đến một trang cụ thể
    function goToPage(page) {
        currentPage = page;
        displayCurrentPage();
    }

    // Hiển thị trang đầu tiên khi trang được tải
    window.onload = function() {
        displayCurrentPage();
        createPaginationButtons();
    };

    function searchTasks() {
        var keyword = document.getElementById('searchInput').value.toLowerCase();
        var rows = document.getElementsByClassName('taskRow');
        for (var i = 0; i < rows.length; i++) {
            var name = rows[i].getElementsByTagName('td')[1].innerText.toLowerCase();
            var description = rows[i].getElementsByTagName('td')[2].innerText.toLowerCase();
            if (name.includes(keyword) || description.includes(keyword)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    function filterTasks() {
        var selectedStatus = document.getElementById('statusFilter').value;
        var rows = document.getElementsByClassName('taskRow');
        for (var i = 0; i < rows.length; i++) {
            var status = rows[i].getElementsByTagName('td')[6].innerText;
            if (selectedStatus === 'all' || status === selectedStatus) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    function viewTask(id) {
        var baseUrl = window.location.href.split('/').slice(0, -1).join('/');
        window.location.href = baseUrl + '/detail/' + id;
    }

    function updateTask(id) {
        var baseUrl = window.location.href.split('/').slice(0, -1).join('/');
        window.location.href = baseUrl + '/update/' + id;
    }

    function deleteTask(id) {
        if (confirm('Bạn có chắc muốn xóa công việc này không?')) {
            // Gửi yêu cầu POST để xóa công việc
            console.log('ID:', id);

            fetch('http://localhost/20120592_UDPT_BT2/task/deleteTask', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => {
                    if (response.ok) {
                        // Hiển thị thông báo thành công
                        alert('Xóa công việc thành công');
                        // Tải lại trang để cập nhật danh sách công việc

                    } else {
                        // Hiển thị thông báo lỗi nếu xóa không thành công
                        alert('Xóa công việc thất bại');
                    }
                })
                .catch(error => console.error('Error:', error));

            // Log dữ liệu được gửi đi để kiểm tra
            console.log(JSON.stringify({
                id: id
            }));
        }
    }

    function refreshTable() {
        // Làm mới lại trang hiển thị danh sách công việc
        var baseUrl = window.location.href.split('/').slice(0, -1).join('/');
        window.location.href = baseUrl + '/show';
    }

    function goBack() {
        window.history.back();
    }
    </script>
</body>

</html>