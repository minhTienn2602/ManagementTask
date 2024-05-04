<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loại công việc</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .center {
        text-align: center;
    }

    .back-button {
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="center">Loại công việc</h1>
        <button class="btn btn-secondary back-button" onclick="goBack()">Back</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo $category['name']; ?></td>
                    <td><?php echo $category['date_created']; ?></td>
                    <td>
                        <button class="btn btn-danger btn-sm"
                            onclick="deleteCategory(<?php echo $category['id']; ?>)">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="newCategoryName" placeholder="Enter new category name">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" onclick="addCategory()">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function goBack() {
        window.history.back();
    }

    function deleteCategory(id) {
        if (confirm('Bạn có chắc xóa loại công việc này không?')) {
            // Gửi yêu cầu POST để xóa category
            fetch('http://localhost/20120592_UDPT_BT2/category/deleteCategory', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => handleResponse(response))
                .catch(error => console.error('Error:', error));
        }
    }

    function handleResponse(response) {
        if (response.ok) {
            // Hiển thị thông báo thành công và làm mới trang
            alert('Xóa thành công');
            location.reload();
        } else {
            // Xử lý phản hồi lỗi từ Server
            response.json().then(data => {
                alert(data.error);
            }).catch(error => {
                console.error('Error:', error);
                alert('Không thể xóa ');
            });
        }
    }

    function addCategory() {
        var newName = document.getElementById('newCategoryName').value; // Lấy giá trị từ input

        // Tạo một đối tượng FormData và thêm dữ liệu vào đó
        var formData = new FormData();
        formData.append('name', newName);

        // Gửi yêu cầu fetch với dữ liệu đã thêm
        fetch('http://localhost/20120592_UDPT_BT2/category/addCategory', {
                method: 'POST',
                body: formData
            })
            .then(response => handleResponse(response))
            .catch(error => console.error('Error:', error));
    }
    </script>
</body>

</html>