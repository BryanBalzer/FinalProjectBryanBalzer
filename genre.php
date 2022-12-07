<?php
session_start();
require 'connect.php';

$query = "SELECT * FROM genres ORDER BY genre_name ASC";
$values = $db->prepare($query);
$values->execute();
?>

<?php include 'header.php'; ?>

<?php if (isset($_SESSION['admin'])) : ?>
    <div class="container py-4">
        <div class="h-100 p-5 text-bg-dark rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Genres</h1>
                <a href="genrecreate.php" ><button class="btn btn-primary btn-lg" type="button">Create Genre</button></a>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($row = $values->fetch()) : ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['genre_name'] ?></h5>
                            <a href="genreedit.php" button type="button" class="btn btn-outline-primary">Edit</a>
                            <a href="genredelete.php" button type="button" class="btn btn-outline-warning">Delete</a>
                        </div>
                    </div>
                </div>

            <?php endwhile ?>
        </div>
    </div>

<?php endif ?>

<?php include 'footer.php'; ?>