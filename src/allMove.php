<?php
include 'config.php';

$action = $_POST['action'] ?? '';
$errors = [];

function sendError($message) {
    $response = array('error' => $message);
    echo json_encode($response);
    exit();
}

switch ($action) {
    case 'add':
        $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
        $year = intval($_POST['year']);
        $format = trim(filter_input(INPUT_POST, 'format', FILTER_SANITIZE_STRING));
        $actors = trim(filter_input(INPUT_POST, 'actors', FILTER_SANITIZE_STRING));
        $currentYear = intval(date('Y'));

        if (empty($title) || ctype_space($title)) {
            sendError("Название не может быть пустым или состоять только из пробелов");
        }

        if ($year < 1900 || $year > $currentYear) {
            sendError("Год выпуска должен быть между 1900 и $currentYear");
        }

        if (empty($format)) {
            sendError("Формат не может быть пустым");
        }

        if (empty($actors) || ctype_space($actors) || preg_match('/[0-9]+/', $actors) || !preg_match('/^[\p{L}\s\-,]+$/u', $actors)) {
            sendError("Актеры не могут быть пустыми, содержать числа или недопустимые символы");
        }

        $stmt = $conn->prepare("SELECT * FROM movies WHERE title=? AND release_year=? AND format=? AND stars=?");
        $stmt->bind_param("siss", $title, $year, $format, $actors);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            sendError("Фильм уже существует");
        } else {
            $stmt = $conn->prepare("INSERT INTO movies (title, release_year, format, stars) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siss", $title, $year, $format, $actors);
            if ($stmt->execute()) {
                sendError("Фильм успешно добавлен");  // Это не похоже на ошибку. Возможно, вам стоит пересмотреть это сообщение и выводить его не как ошибку.
            } else {
                sendError("Ошибка добавления фильма: " . $conn->error);
            }
        }
        break;

    case 'delete':
        $id = intval($_POST['id']);
        
        $stmt = $conn->prepare("SELECT * FROM movies WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows == 0) {
            sendError("Фильм не найден");
        } else {
            $stmt = $conn->prepare("DELETE FROM movies WHERE id=?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                sendError("Фильм успешно удален");  // Это также не похоже на ошибку. Рекомендую рассмотреть другой метод вывода успешных сообщений.
            } else {
                sendError("Ошибка удаления фильма: " . $conn->error);
            }
        }
        break;

    case 'searchActor':
        searchByActor($_POST['actor']);
        break;

    case 'searchMovie':
        searchMovie($_POST['title']);
        break;

        case 'sortMovies':
            $order = $_POST['order'] === "ASC" ? "ASC" : "DESC";
            $sql = "SELECT * FROM movies ORDER BY LOWER(title) {$order}";
            $result = $conn->query($sql);
            
            $movies = array();
            while ($row = $result->fetch_assoc()) {
                $movies[] = $row;
            }
            echo json_encode($movies);
            break;
}

function searchByActor($actor) {
    global $conn;
    $like_actor = "%" . $actor . "%";
    $stmt = $conn->prepare("SELECT * FROM movies WHERE stars LIKE ?");
    $stmt->bind_param("s", $like_actor);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $movies = array();
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
    echo json_encode($movies);
}

function searchMovie($title) {
    global $conn;
    $like_title = "%" . $title . "%";
    $stmt = $conn->prepare("SELECT * FROM movies WHERE title LIKE ?");
    $stmt->bind_param("s", $like_title);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $movies = array();
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
    echo json_encode($movies);
}

?>
