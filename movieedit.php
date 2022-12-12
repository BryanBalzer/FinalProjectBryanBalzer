<?php
require 'connect.php';
#session_start();

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM movies m JOIN genres g ON m.genre_id = g.genre_id WHERE movie_id = :movie_id";
    $values = $db->prepare($query);
    $values->bindValue(':movie_id', $id);
    $values->execute();
}

$query = "SELECT * FROM genres";
$genres = $db->prepare($query);
$genres->execute();

?>

<?php if (isset($_SESSION['admin'])) : ?>
    <?php include 'header.php'; ?>
    <div id="wrapper">
        <div id="content">
            <?php while ($row = $values->fetch()) : ?>
                <form action="process_post.php" method="post" class="editform" enctype="multipart/form-data">
                    <fieldset class="editreview">
                        <div class="edit">
                            <input type="hidden" name="id" value="<?= $row['movie_id'] ?>" />
                            <p>
                                <label for="movie_title">Movie Title:</label>
                                <input name="movie_title" id="movie_title" value="<?= $row['movie_title'] ?>" />
                            </p>
                            <p>
                                <label for="genres">Genre:</label>
                                <select name="genres" required>
                                    <option value="" selected disabled hidden>Select an Option</option>
                                    <?php while ($genre = $genres->fetch()) : ?>
                                        <option value="<?= $genre['genre_id'] ?>"><?= $genre['genre_name'] ?></option>
                                    <?php endwhile ?>
                                </select>
                            </p>
                            <button name="command" type="submit" value="MovieUpdate">Update</button>
                            </p>
                            <p>
                                <input type="submit" name="command" value="DeleteMovie" />
                            </p>
                    </fieldset>
                </form>
            <?php endwhile ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
<?php else : ?>
    <?php header('Location: index.php'); ?>
<?php endif ?>