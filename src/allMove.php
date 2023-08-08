<?php
include 'config.php';

$action = $_POST['action'] ?? '';
$errors = [];

switch ($action) {
    case 'add':
        // Валидация полей
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $year = intval($_POST['year']);
        $format = filter_input(INPUT_POST, 'format', FILTER_SANITIZE_STRING);
        $actors = filter_input(INPUT_POST, 'actors', FILTER_SANITIZE_STRING);
        $currentYear = intval(date('Y'));
        
        if (empty($title)) {
            showError("Название не может быть пустым");
            
        }

        if ($year < 1900 || $year > $currentYear) {
            showError("Год выпуска должен быть между 1900 и $currentYear");
           
        }

        if (empty($format)) {
            showError("Формат не может быть пустым");
            
        }

        if (empty($actors)) {
            showError("Актеры не могут быть пустыми");
            
        }

        if (!$errors) {
            $stmt = $conn->prepare("SELECT * FROM movies WHERE title=? AND release_year=? AND format=? AND stars=?");
            $stmt->bind_param("siss", $title, $year, $format, $actors);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                showError("Фильм уже существует");
            } else {
                $stmt = $conn->prepare("INSERT INTO movies (title, release_year, format, stars) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("siss", $title, $year, $format, $actors);
                if ($stmt->execute()) {
                    showError("Record added successfully");
                    echo "";
                } else {
                    showError("Error adding record: " . $conn->error);
                    
                }
            }
        }
        break;

    case 'delete':
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM movies WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            showError("Record added successfully");
        } else {
            showError("Error deleting record: " . $conn->error);
           
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
function showError($message) {
    echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: '$message'
            });
            setTimeout(function(){
                window.location.href = 'index.php';
             }, 5000);
          </script>";
}

?>
