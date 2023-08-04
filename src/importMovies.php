<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['movieFile'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $file['error']);
    }

    $fileContents = file_get_contents($file['tmp_name']);
    $movies = explode("\n\n", $fileContents); // separates each movie

    foreach($movies as $movie) {
        $lines = explode("\n", $movie);
        $title = str_replace("Title: ", "", $lines[0]);
        $releaseYear = (int) str_replace("Release Year: ", "", $lines[1]); // Casting string to integer
        $format = str_replace("Format: ", "", $lines[2]);
        $stars = str_replace("Stars: ", "", $lines[3]);

        // checking if any field is empty, if so, skip the current iteration
        if (empty($title) || empty($releaseYear) || empty($format) || empty($stars)) {
            echo "One or more fields are empty, skipping...\n";
            continue;
        }

        // insert into database
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
