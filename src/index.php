<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   header("location: login.php");
    exit;
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <script src="/assets/js/elem.js"></script>
    <script src="/assets/js/elem.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: black;
            color: orange;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: black;
            color: orange;
        }
    </style>
</head>
<body>
<div id="flyingText">Movie Test<br></div>
<h2 style="top:0;position: fixed;">Welcome, <?php echo $_SESSION['username']; ?></h2>


    <div class="container">
        
        <a href="showMovie.php" class="btn btn-primary">Show Movie Info</a>
        <a class="btn btn-primary" data-toggle="modal" data-target="#fileModal">Import Movies</a>
        <a href="logout.php" class="btn btn-primary">Logout</a>
        
        <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fileModalLabel">Register</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="importMovies.php" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                            <input type="file" name="movieFile" id="movieFile">
        
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Import Movies</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 
    </div>
</body>
</html>
