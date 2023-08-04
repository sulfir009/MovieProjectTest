<?php
include 'config.php';

//Отримання action із форм - showMovies.php, для розуміння вибору користувача.
$action = $_POST['action'] ?? '';

switch ($action) {
    // Додавання у mySql таблицю новий фільм 
    case 'add':
        $title = $_POST['title'];
        $year = $_POST['year'];
        $format = $_POST['format'];
        $actors = $_POST['actors'];

        $sql = "INSERT INTO movies (title, release_year, format, stars) VALUES ('$title', '$year', '$format', '$actors')";
        if ($conn->query($sql) === TRUE) {
            echo "Record added successfully";
            header("Refresh:0");
        } else {
            echo "Error adding record: " . $conn->error;
        }
        break;
        // Видалення з mySql елементу за id
    case 'delete':
        $id = $_POST['id'];
        $sql = "DELETE FROM movies WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
            header("Refresh:0");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
        break;
        // Пошук по stars - тобто по актору
    case 'searchActor':
        $actor = $_POST['actor'];
        searchByActor($actor);
        break;
        // Пошук по title
    case 'searchMovie':
        $title = $_POST['title'];
        searchMovie($title);
        break;

        case 'sortMovies':
            
            $order = $_POST['order'];
            $sql = "SELECT * FROM movies ORDER BY title {$order}";
            $result = $conn->query($sql);
        
            $movies = array();
            while($row = $result->fetch_assoc()) {
                $movies[] = $row;
            }
            echo json_encode($movies);
            break;
        }
        
        
// Пошук по stars - тобто по актору
function searchByActor($actor) {
    global $conn;
    $sql = "SELECT * FROM movies WHERE stars LIKE '%$actor%'";
    $result = $conn->query($sql);

    $movies = array();
    while($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
    echo json_encode($movies);
    
}
// Пошук по title
function searchMovie($title) {
    global $conn;
    $sql = "SELECT * FROM movies WHERE title LIKE '%$title%'";
    $result = $conn->query($sql);

    $movies = array();
    while($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
    echo json_encode($movies);
}
?>