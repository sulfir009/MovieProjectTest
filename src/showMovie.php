<?php
include 'config.php';
include 'allMove.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $errors;
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Show Movies</title>
    <script src="/assets/js/elem.js"></script>
     <!-- Другие теги head -->
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
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
        .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 1000;
}

.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ffffff;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.close-btn {
    cursor: pointer;
}

    </style>
</head>
<body>

    <script>
        function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Ошибка',
        text: message
    });
}



     document.querySelector("#addMovieForm form").addEventListener("submit", function(e) {
        const year = parseInt(document.querySelector('input[name="year"]').value, 10);
        const currentYear = new Date().getFullYear();

        if (year < 1870 || year > currentYear) {
            e.preventDefault();
            $('#addMovieFormError').modal('show');
        }
    });

    // Дополнительная валидация названия фильма на клиентской стороне
    document.querySelector("#addMovieForm form").addEventListener("submit", function(e) {
        const title = document.querySelector('input[name="title"]').value;

        if (title.length < 3 || title.length > 30 || /[\'^£$%&*()}{@#~?><>,|=_+¬]/.test(title)) {
            e.preventDefault();
            $('#minMaxError').modal('show');
        }
    });


let modals = document.querySelectorAll('.modal');
let closeBtns = document.querySelectorAll('.close-btn');

closeBtns.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        modals[index].style.display = 'none';
    });
});

function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

        </script>
        <?php if ($errors): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
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
        <!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="errorModalLabel">Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="errorMessage">
        <!-- Error message will be inserted here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


        <script>
function showError(message) {
    document.getElementById('errorMessage').innerText = message;
    $('#errorModal').modal('show');
}

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
        let data = JSON.parse(response);
        if (data.error) {
            showError(data.error);
    } else {
            if (action === 'searchActor' || action === 'searchMovie' || action === 'sortMovies' ) {
            console.log(response);
            updateTable(JSON.parse(response));
        }
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