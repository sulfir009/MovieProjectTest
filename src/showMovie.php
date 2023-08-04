<?php
include 'config.php';
/*
Меню управління базою
Відкриється тільки якщо авторизован
Стилі сформовані на основі bootstrap


*/
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Show Movies</title>
    <script src="/assets/js/elem.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .form-section {
            display: none;
            border: 1px solid blue;
            padding: 10px;
            margin-bottom: 10px;
        }
        .table-container {
            float: right;
            width: 50%;
        }
        .form-container {
            float: left;
            width: 50%;
        }
        .btn{
            margin-right: 2px;
            margin-top: 2px;
        }
    </style>
</head>
<body>

    <div class="container">
    <h1 ><a href="index.php"> Movies</a></h1>
        <!-- Створення навігаційного меню -->
        <nav>
            <button class="btn btn-primary form-toggle" data-target="#addMovieForm">Add Movie</button>
            <button class="btn btn-primary form-toggle" data-target="#table">All Movies</button>
            <button class="btn btn-primary form-toggle" data-target="#deleteMovieForm">Delete Movie</button>
            <button class="btn btn-primary form-toggle" data-target="#searchByActorForm">Search By Actor</button>
            <button class="btn btn-primary form-toggle" data-target="#searchMovieForm">Search Movie</button>
            <button class="btn btn-primary form-toggle" data-target="#sortMoviesForm">Sort Movies</button>
            <form action="logout.php" method="post" style="display:inline;">
                <button type="submit" class="btn btn-primary">Logout</button>
            </form>
        </nav>

        <div class="form-container">
            <!-- Реалізація скритого вікна для отримання інформації по кожному пункту меню. 
            Модальні вікна прижаті вліво. -->

            <div id="addMovieForm" class="form-section">
                <div class="form-group">
                    <h2>Add Movie</h2>
                    <form action="allMove.php" method="post">
                    <input type="hidden" name="action" value="add">
                        <input type="text" class="form-control" name="title" placeholder="Title">
                        <input type="text" class="form-control" name="year" placeholder="Year">
                        <input type="text" class="form-control" name="format" placeholder="Format">
                        <input type="text" class="form-control" name="actors" placeholder="Actors">
                        <button id="btnadd" type="submit" class="btn btn-primary"><a style="color:white;" >Add Movie</a></button>
                    </form>
                </div>
            </div>

            <div id="deleteMovieForm" class="form-section">
                <div class="form-group">
                    <h2>Delete Movie</h2>
                    <form action="allMove.php" method="post">
                    <input type="hidden" name="action" value="delete">
                        <input type="text" class="form-control" name="id" placeholder="Movie ID">
                        <button id="btndell" type="submit" class="btn btn-primary"><a style="color:white;" >Delete Movie</a></button>
                    </form>
                </div>
            </div>


            <div id="searchByActorForm" class="form-section">
                <div class="form-group">
                    <h2>Search By Actor</h2>
                    <form  method="post">
                    <input type="hidden" name="action" value="searchActor">
                        <input type="text" class="form-control" name="actor" placeholder="Actor">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>

            <div id="searchMovieForm" class="form-section">
                <div class="form-group">
                    <h2>Search Movie</h2>
                    <form  method="post">
                    <input type="hidden" name="action" value="searchMovie">
                        <input type="text" class="form-control" name="title" placeholder="Title">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>

            <div id="sortMoviesForm" class="form-section">
                <div class="form-group">
                    <h2>Sort Movies</h2>
                    <form  method="post">
                    <input type="hidden" name="action" value="sortMovies">
                        <input type="hidden" id="sortOrder" name="order" value="ASC">
                        <button type="submit" class="btn btn-primary">Sort Movies</button>
                    </form>
                </div>
            </div>
            <div id="table" class="form-section">
                <div class="form-group">
                    <h2><a href="showMovie.php"> All Movies</a></h2>
                    
                </div>
            </div>
        </div>

        <div class="table-container">
            <!-- Таблиця для управління базою даних. Прижата вправо. -->
            <table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Year</th>
            <th>Format</th>
            <th>Actors</th>
        </tr>
    </thead>
    <tbody>
    <?php
    //Вивід таблиці . Підключення по базі знаходиться у верху. Результат отримання таблиці виводимо в таблицю
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["release_year"] . "</td>";  
            echo "<td>" . $row["format"] . "</td>";
            echo "<td>" . $row["stars"] . "</td>";  
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No results</td></tr>";
    }
    ?>
</tbody>

</table>
        </div>

        <script>
            // Скрипт по відновленню сторінки при натисканні на конкретні кнопки.
document.getElementById('btndell').addEventListener('click', function() {
    setTimeout(function() {
        location.reload();
    }, 3000);
});

document.getElementById('btnadd').addEventListener('click', function() {
    setTimeout(function() {
        location.reload();
    }, 3000);
});

//Реалізація сортування. Змінюємо тип сортування одним кліком.
$('#sortMoviesForm form').on('submit', function() {
    var order = $(this).find('input[name="order"]').val();
    $(this).find('input[name="order"]').val(order === 'ASC' ? 'DESC' : 'ASC');
});

//Відкриття та закриття модальних вікон з панелі nav
  $('.form-toggle').click(function(e) {
    e.preventDefault();
    var target = $(this).data('target');
    $('.form-section').hide();
    $(target).show();

    // Эффект переключения цвета
    let text = document.getElementById("flyingText");
    let light = true;

    if (text !== null) {
      if (light) {
        text.style.color = "white";
        light = false;
      } else {
        text.style.color = "orange";
        light = true;
      }
    }
  });
//Функція для відновлення інформації у таблиці (ajax)
  function updateTable(movies) {
    var tbody = $('.table tbody');
    tbody.empty();
    if (movies.length === 0) {
      tbody.append("<tr><td colspan='5'>No results</td></tr>");
    } else {
      movies.forEach(function(movie) {
        var row = $("<tr>");
        row.append($("<td>").text(movie.id));
        row.append($("<td>").text(movie.title));
        row.append($("<td>").text(movie.release_year));
        row.append($("<td>").text(movie.format));
        row.append($("<td>").text(movie.stars));
        tbody.append(row);
      });
    }
  }

  // Залежно від запросу відновлюємо сторінку без перезавантаження сторінки
  $('.form-section form').on('submit', function(e) {
    e.preventDefault();

    var form = $(this);
    var action = form.find('input[name="action"]').val();

    $.ajax({
      url: 'allMove.php',
      method: 'post',
      data: form.serialize(),
      success: function(response) {
        if (action === 'searchActor' || action === 'searchMovie' || action === 'sortMovies' ) {
            console.log(response);
            updateTable(JSON.parse(response));
        }
      },
      error: function() {
        console.log('An error occurred');
      }
    });
  });




</script>

    </div>
</body>
</html>

<?php $conn->close(); ?>
