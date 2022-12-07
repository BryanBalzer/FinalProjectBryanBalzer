<?php
require 'connect.php';
session_start();

$query = "SELECT * FROM genres";
$values = $db->prepare($query);
$values->execute();

if ($_POST && !empty($_POST['title']) && !empty($_POST['movies'])) {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $genreid = filter_input(INPUT_POST, 'movies', FILTER_SANITIZE_NUMBER_INT);

    $query = "INSERT INTO movies (movie_title, genre_id) VALUES (:movie_title, :genre_id)";
    $statement = $db->prepare($query);

    $statement->bindValue(':movie_title', $title);
    $statement->bindValue(':genre_id', $genreid);

    if ($statement->execute()) {
        header("Location: movie.php");
        exit;
    }
}
?>

<?php include('header.php'); ?>

<div class="container">
    <form method="post" action="moviecreate.php">
        <div class="row m-5">
            <div class="col">
                <label for="formGroupExampleInput" class="form-label">Movie Title</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Enter Title" aria-label="Movie Title">
            </div>
            <div class="col">
                <label for="formGroupExampleInput" class="form-label">Movie Genre</label>
                <select class="form-select" name="movies" aria-label="Movie Genre">
                    <option value="none" selected disabled hidden>Select Genre</option>
                    <?php while ($row = $values->fetch()) : ?>
                        <option value="<?= $row['genre_id'] ?>"><?= $row['genre_name'] ?></option>
                    <?php endwhile ?>
                </select>

            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>


<?php include('footer.php'); ?>