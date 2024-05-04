<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
    }

    .add-form {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }

    .add-form h2 {
        margin-top: 0;
        color: #333;
        text-align: center;
    }

    .add-form form {
        margin-top: 20px;
    }

    .add-form label {
        display: block;
        margin-bottom: 10px;
        color: #333;
    }

    .add-form input[type="text"],
    .add-form textarea,
    .add-form select {
        width: calc(100% - 22px);
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    /* Màu xanh da trời cho nút "Add Task" */
    .add-form input[type="submit"] {
        background-color: #007bff;
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }

    .add-form input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .error-message {
        color: red;
        margin-top: 10px;
        text-align: center;
        display: none;
    }

    .success-message {
        color: green;
        margin-top: 10px;
        text-align: center;
        display: none;
    }

    /* Style for back button */
    .back-button {
        background-color: #ddd;
        color: #333;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px 20px;
        cursor: pointer;
        width: 100%;
        text-align: center;
        margin-top: 10px;
    }

    .back-button:hover {
        background-color: #ccc;
    }

    /* Style for category button */
    .category-button {
        background-color: #ffc107;
        color: #333;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px 20px;
        cursor: pointer;
        margin-top: 10px;
        float: right;
    }

    .category-button:hover {
        background-color: #e0a800;
    }
    </style>
</head>

<body>
    <div class="add-form">
        <h2>Add Task</h2>
        <!-- Category button -->
        <button class="category-button" onclick="redirectToCategory()">Category</button>

        <form id="addForm" action="#" method="post" onsubmit="return addTask()">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>

            <label for="start_date">Start Date:</label>
            <input type="datetime-local" id="start_date" name="start_date">

            <label for="due_date">Due Date:</label>
            <input type="datetime-local" id="due_date" name="due_date">

            <label for="category">Category:</label>
            <select id="category" name="category">
                <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Thêm lớp btn-primary cho nút "Add Task" -->
            <input type="submit" value="Add Task" class="btn btn-primary">
            <p id="errorMessage" class="error-message"></p>
            <p id="successMessage" class="success-message"></p>
        </form>

        <!-- Back button -->
        <button class="back-button" onclick="history.back()">Back</button>
    </div>

    <script>
    function addTask() {
        var form = document.getElementById('addForm');
        var formData = new FormData(form);

        // Retrieve data from the form
        var name = formData.get('name');
        var description = formData.get('description');
        var startDate = new Date(formData.get('start_date'));
        var dueDate = new Date(formData.get('due_date'));
        var categoryId = getSelectedCategoryId(); // Get selected category ID

        // Check conditions
        if (name.trim() === '' || description.trim() === '') {
            showError('Name and Description cannot be empty.');
            return false;
        }

        if (startDate >= dueDate) {
            showError('Start Date must be before Due Date.');
            return false;
        }

        fetch('http://localhost/20120592_UDPT_BT2/task/addTask', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Thêm công việc thất bại');
                }
                showSuccess('Add Task thành công');
                // Reset form after successful addition
                form.reset();
            })
            .catch(error => {
                console.error('Lỗi:', error);
                showError('Thêm công việc thất bại');
            });

        return false;
    }

    function getSelectedCategoryId() {
        var categorySelect = document.getElementById('category');
        return categorySelect.options[categorySelect.selectedIndex].value;
    }

    function showError(message) {
        var errorMessage = document.getElementById('errorMessage');
        errorMessage.innerText = message;
        errorMessage.style.display = 'block';
        setTimeout(function() {
            errorMessage.style.display = 'none';
        }, 5000);
    }

    function showSuccess(message) {
        var successMessage = document.getElementById('successMessage');
        successMessage.innerText = message;
        successMessage.style.display = 'block';
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 5000);
    }

    function redirectToCategory() {
        window.location.href = 'http://localhost/20120592_UDPT_BT2/category/show';
    }
    </script>
</body>

</html>