<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý công việc của bạn</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
    }

    .navbar .nav-link {
        color: #343a40;
        font-weight: bold;
    }

    .navbar .nav-link:hover {
        color: #007bff;
    }

    .btn-custom {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }

    .btn-custom:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="task/add">Thêm công việc</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="task/show">Danh sách công việc</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category/show">Quản lý Category</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <h1>Chào mừng bạn đến với hệ thống quản lý công việc</h1>
        <p class="lead">Hãy bắt đầu quản lý công việc của bạn ngay bây giờ!</p>
        <button class="btn btn-lg btn-custom" onclick="window.location.href='task/add'">Thêm công việc mới</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>