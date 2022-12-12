<?php
#session_start();
require 'connect.php';

$query = "SELECT * FROM genres ORDER BY genre_name ASC";
$values = $db->prepare($query);
$values->execute();

if(isset($_GET['id']) )
{
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$query = "DELETE FROM genres WHERE genre_id = :genre_id";
$statement = $db->prepare($query);
$statement->bindValue(':genre_id', $id, PDO::PARAM_INT);
$statement->execute();
header('Location: genre.php');
}
?>

<?php include 'header.php'; ?>

<?php if (isset($_SESSION['admin'])) : ?>
    <div class="container py-4">
        <div class="h-100 p-5 text-bg-dark rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Genres</h1>
                <a class="btn btn-primary" href="genrecreate.php" role="button">Create Genre</a>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($row = $values->fetch()) : ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['genre_name'] ?></h5>
                            <a class="btn btn-primary" href="genreedit.php?id=<?= $row['genre_id'] ?>" role="button">Edit</a>
                            <a class="btn btn-primary" href="genre.php?id=<?= $row['genre_id'] ?>" role="button">Delete</a>
                        </div>
                    </div>
                </div>

            <?php endwhile ?>
        </div>
    </div>

<?php endif ?>

<?php include 'footer.php'; ?>