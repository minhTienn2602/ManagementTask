<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task <?php echo $detail['id']; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
    }

    .update-form {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        position: relative;
    }

    .update-form h2 {
        margin-top: 0;
        color: #333;
        text-align: center;
    }

    .update-form form {
        margin-top: 20px;
    }

    .update-form label {
        display: block;
        margin-bottom: 10px;
        color: #333;
    }

    .update-form input[type="text"],
    .update-form textarea,
    .update-form select {
        width: calc(100% - 22px);
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    /* Màu xanh da trời cho nút "Update" */
    .update-form input[type="submit"] {
        background-color: #007bff;
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }

    .update-form input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .error-message,
    .success-message {
        color: red;
        margin-top: 10px;
        text-align: center;
        display: none;
    }

    .back-button {
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="update-form">
        <h2>Update Task <?php echo $detail['id']; ?></h2>
        <form id="updateForm" action="#" method="post" onsubmit="return updateTask()">
            <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $detail['name']; ?>">

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo $detail['description']; ?></textarea>

            <label for="start_date">Start Date:</label>
            <input type="datetime-local" id="start_date" name="start_date"
                value="<?php echo date('Y-m-d\TH:i', strtotime($detail['start_date'])); ?>">

            <label for="due_date">Due Date:</label>
            <input type="datetime-local" id="due_date" name="due_date"
                value="<?php echo date('Y-m-d\TH:i', strtotime($detail['due_date'])); ?>">

            <label for="finished_date">Finished Date:</label>
            <input type="datetime-local" id="finished_date" name="finished_date"
                value="<?php echo date('Y-m-d\TH:i', strtotime($detail['finished_date'])); ?>"
                <?php if ($detail['status'] !== 'FINISHED') echo 'readonly'; ?>>

            <label for="status">Status:</label>
            <select id="status" name="status" onchange="toggleFinishedDate()">
                <option value="TODO" <?php if ($detail['status'] === 'TODO') echo 'selected'; ?>>TODO</option>
                <option value="IN PROGRESS" <?php if ($detail['status'] === 'IN PROGRESS') echo 'selected'; ?>>IN
                    PROGRESS</option>
                <option value="FINISHED" <?php if ($detail['status'] === 'FINISHED') echo 'selected'; ?>>FINISHED
                </option>
            </select>

            <!-- Thêm lớp btn-primary cho nút "Update" -->
            <input type="submit" value="Update Task" class="btn btn-primary">
            <p id="errorMessage" class="error-message"></p>
            <p id="successMessage" class="success-message"></p>
        </form>

        <!-- Back button -->
        <div class="back-button">
            <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
        </div>
    </div>

    <script>
    function updateTask() {
        var form = document.getElementById('updateForm');
        var formData = new FormData(form);

        // Lấy giá trị của các trường thông tin
        var name = formData.get('name');
        var description = formData.get('description');
        var startDate = new Date(formData.get('start_date'));
        var dueDate = new Date(formData.get('due_date'));
        var finishedDate = new Date(formData.get('finished_date'));
        var status = formData.get('status');

        // Kiểm tra các điều kiện
        if (name.trim() === '' || description.trim() === '') {
            document.getElementById('errorMessage').innerText = 'Name and Description cannot be empty.';
            document.getElementById('errorMessage').style.display = 'block';
            setTimeout(function() {
                document.getElementById('errorMessage').style.display = 'none';
            }, 5000);
            return false;
        }

        if (startDate >= dueDate) {
            document.getElementById('errorMessage').innerText = 'Start Date must be before Due Date.';
            document.getElementById('errorMessage').style.display = 'block';
            setTimeout(function() {
                document.getElementById('errorMessage').style.display = 'none';
            }, 5000);
            return false;
        }

        if (status === 'FINISHED' && startDate >= finishedDate) {
            document.getElementById('errorMessage').innerText = 'Start Date must be before Finished Date.';
            document.getElementById('errorMessage').style.display = 'block';
            setTimeout(function() {
                document.getElementById('errorMessage').style.display = 'none';
            }, 5000);
            return false;
        }

        // Nếu trạng thái không phải FINISHED, xóa giá trị của finished_date
        if (status !== 'FINISHED') {
            formData.delete('finished_date');
        }

        fetch('http://localhost/20120592_UDPT_BT2/task/updateTask', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Cập nhật công việc thất bại');
                }
                document.getElementById('successMessage').innerText = 'Update thành công';
                document.getElementById('successMessage').style.display = 'block';
                setTimeout(function() {
                    document.getElementById('successMessage').style.display = 'none';
                }, 5000);
            })
            .catch(error => {
                console.error('Lỗi:', error);
                document.getElementById('errorMessage').innerText = 'Cập nhật công việc thất bại';
                document.getElementById('errorMessage').style.display = 'block';
                setTimeout(function() {
                    document.getElementById('errorMessage').style.display = 'none';
                }, 5000);
            });

        return false;
    }

    function toggleFinishedDate() {
        var status = document.getElementById('status').value;
        var finishedDateInput = document.getElementById('finished_date');
        if (status === 'FINISHED') {
            finishedDateInput.removeAttribute('readonly');
        } else {
            finishedDateInput.setAttribute('readonly', 'true');
        }
    }

    // Toggle initial state of finished_date input
    window.onload = function() {
        toggleFinishedDate();
    };
    </script>
</body>

</html>