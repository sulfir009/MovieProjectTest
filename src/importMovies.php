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
</body>
</html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully<br>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    $file = $_FILES['movieFile'];
    echo "File name: " . $file['name'] . "<br>";

    // Check if the uploaded file is of txt format
    if (pathinfo($file['name'], PATHINFO_EXTENSION) !== 'txt') {
        
        die("Only txt files are allowed!");
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $file['error']);
    }

    $fileContents = file_get_contents($file['tmp_name']);
    $movies = explode("\n\n", $fileContents);
    echo "Number of movies: " . count($movies) . "<br>";


    foreach ($movies as $movie) {
        $lines = explode("\n", $movie);
        $title = trim(str_replace("Title: ", "", $lines[0]));
        $releaseYear = (int)str_replace("Release Year: ", "", $lines[1]);
        $format = trim(str_replace("Format: ", "", $lines[2]));
        $stars = trim(str_replace("Stars: ", "", $lines[3]));

        // Validation
        $currentYear = date('Y');
        if (empty($title) || strlen($title) < 3 || strlen($title) > 30 || !preg_match("/^[a-zA-Z\s]+$/", $title)) {
            echo "Invalid title format, skipping...\n";
            continue;
        }
        if ($releaseYear < 1870 || $releaseYear > $currentYear) {
            echo "Invalid release year, skipping...\n";
            continue;
        }
        if (empty($format) || strlen($format) < 3 || strlen($format) > 30 || !preg_match("/^[a-zA-Z\s]+$/", $format)) {
            echo "Invalid format, skipping...\n";
            continue;
        }
        

        // Check for unique movie title
        $stmt = $conn->prepare("SELECT * FROM movies WHERE title=?");
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Movie with title '$title' already exists, skipping...\n";
            continue;
        }

        $stmt = $conn->prepare("INSERT INTO movies (title, release_year, format, stars) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $title, $releaseYear, $format, $stars);
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        
    }
    header("Location: index.php");
}
?>
