<?php
include 'config.php';
// По шаблону наданного файлу отримаємо інформацію з файлу та створюємо єлементи у таблиці за створенною моделлю
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['movieFile'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $file['error']);
    }

    $fileContents = file_get_contents($file['tmp_name']);
    $movies = explode("\n\n", $fileContents);

    foreach($movies as $movie) {
        $lines = explode("\n", $movie);
        $title = str_replace("Title: ", "", $lines[0]);
        $releaseYear = (int) str_replace("Release Year: ", "", $lines[1]); 
        $format = str_replace("Format: ", "", $lines[2]);
        $stars = str_replace("Stars: ", "", $lines[3]);

        // Перевіряю, чи пусте якесь поле, якщо так, пропустити поточну ітерацію
        if (empty($title) || empty($releaseYear) || empty($format) || empty($stars)) {
            echo "One or more fields are empty, skipping...\n";
            continue;
        }

        // Вставка у db
        $sql = "INSERT INTO movies (title, release_year, format, stars) VALUES ('$title', '$releaseYear', '$format', '$stars')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    header("Location: index.php");
}
?>
