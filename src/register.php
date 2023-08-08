<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <script src="/assets/js/elem.js"></script>
    <!-- Подключение сторонних библиотек -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

    <script>
    $(document).ready(function(){
        $('.modal').modal('show');
    });
    </script>
</head>
<body>

<?php
include 'config.php';

if ($_POST) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || strlen($username) < 3 || empty($password) || !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        echo "Пожалуйста, проверьте ваши данные. Поля не должны быть пустыми, имя пользователя может содержать только буквы и цифры и должно быть длиной не менее 3 символов.";
        exit;
    } else {
        // Проверка существования пользователя
        $checkUserStmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $checkUserStmt->bind_param("s", $username);
        $checkUserStmt->execute();
        $result = $checkUserStmt->get_result();
        if ($result->num_rows > 0) {
            echo "<script>
                    Swal.fire({
                      icon: 'error',
                      title: 'Ошибка',
                      text: 'Такой пользователь уже существует.'
                    });
                    setTimeout(function(){
                        window.location.href = 'index.php';
                     }, 5000);
                     
                  </script>";
            $checkUserStmt->close();
            exit;
        }
        $checkUserStmt->close();

        // Добавление нового пользователя
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            echo "New record created successfully";
            header("Location: index.php");
            exit;
        } else {
            echo "<script>
                    Swal.fire({
                      icon: 'error',
                      title: 'Ошибка',
                      text: 'Произошла неизвестная ошибка. Попробуйте позже.'
                    });
                    setTimeout(function(){
                        window.location.href = 'index.php';
                     }, 5000);
                     
                  </script>";
            $stmt->close();
            exit;
        }
    }
}
$conn->close();
?>

</body>
</html>
