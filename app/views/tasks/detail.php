<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Detail <?php echo isset($detail['id']) ? $detail['id'] : ''; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
    }

    .task-detail {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }

    .task-detail h2 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    .task-detail table {
        width: 100%;
        border-collapse: collapse;
    }

    .task-detail table th,
    .task-detail table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .task-detail table th {
        background-color: #f2f2f2;
        color: #333;
        font-weight: bold;
    }

    .task-detail table td {
        color: #666;
    }

    .back-button {
        margin-top: 20px;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="task-detail">
        <h2>Task Detail <?php echo isset($detail['id']) ? $detail['id'] : ''; ?></h2>
        <?php if ($detail): ?>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo $detail['id']; ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?php echo $detail['name']; ?></td>
            </tr>
            <tr>
                <th>Description</th>
                <td><?php echo $detail['description']; ?></td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td><?php echo $detail['start_date']; ?></td>
            </tr>
            <tr>
                <th>Due Date</th>
                <td><?php echo $detail['due_date']; ?></td>
            </tr>
            <tr>
                <th>Finished Date</th>
                <td><?php echo $detail['finished_date']; ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo $detail['status']; ?></td>
            </tr>
            <tr>
                <th>Category ID</th>
                <td><?php echo $detail['category_id']; ?></td>
            </tr>
        </table>
        <?php else: ?>
        <p>Task not found.</p>
        <?php endif; ?>
        <div class="back-button">
            <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
        </div>
    </div>
</body>

</html>