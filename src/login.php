<?php
include_once 'config.php';
/*
Логін меню
Стилі сформовані на основі bootstrap
Реалізовано - логін, регістрація

*/

if($_POST){
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        echo '<div class="alert alert-danger">Пожалуйста, заполните все поля.</div>';
        return;
    }
    
    if (strlen($username) < 3 || strlen($username) > 30 || preg_match('/[^a-zA-Z0-9]/', $username)) {
        echo '<div class="alert alert-danger">Имя пользователя должно быть длиной от 3 до 30 символов и не содержать специальных символов.</div>';
        return;
    }
    

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if($result->num_rows >0){
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php");
    }else{
        echo "Invalid username or password";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="/assets/js/elem.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: black;
            color: orange;
        }
    </style>
    <!-- Подключение стилей Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

<!-- Подключение библиотеки jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Подключение скрипта Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
    <script>
var errorMessage = "Пожалуйста, проверьте ваши данные. Поля не должны быть пустыми, имя пользователя может содержать только буквы и цифры и должно быть длиной не менее 3 символов.";
$("#error-message").text(errorMessage);
$("#registerModal").modal("show");
var errorMessage = "Такой пользователь уже существует.";
$("#error-message").text(errorMessage);
$("#registerModal").modal("show");
        </script>
<div id="error-message" style="display: none;"></div>

    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" class="form-control" minlength="3" maxlength="30" pattern="^[a-zA-Z0-9]*$" name="username">
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerModal">Register</button>
        </form>

        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Register</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="register.php" method="post">
                            <div class="form-group">
                                <label>Username:</label>
                                <input type="text" class="form-control" minlength="3" maxlength="30" pattern="^[a-zA-Z0-9]*$" name="username">
                            </div>
                            <div class="form-group">
                                <label>Password:</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>
