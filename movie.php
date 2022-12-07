<?php
session_start();
require 'connect.php';

$query = "SELECT *
FROM movies
INNER JOIN genres
ON movies.genre_id  = genres.genre_id ORDER BY movie_title ASC";
$values = $db->prepare($query);
$values->execute();
?>

<?php include 'header.php'; ?>

<?php if (isset($_SESSION['admin'])) : ?>
    <div class="container py-4">
        <div class="h-100 p-5 text-bg-dark rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Movies</h1>
                <a href="moviecreate.php"><button class="btn btn-primary btn-lg" type="button">Create Movie</button></a>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($row = $values->fetch()) : ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['movie_title'] ?></h5>
                            <p class="card-text"><?= $row['genre_name'] ?></p>
                            <a href="movieedit.php" button type="button" class="btn btn-outline-primary">Edit</a>
                            <button type="button" class="btn btn-outline-warning">Delete</button>
                        </div>
                    </div>
                </div>
            <?php endwhile ?>
        </div>
    </div>

<?php endif ?>


<?php include 'footer.php'; ?>