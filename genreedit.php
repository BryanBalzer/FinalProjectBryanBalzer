<?php
require 'connect.php';
session_start();

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM genres";
    $values = $db->prepare($query);
    $values->bindValue(':genre_id', $id);
    $values->execute();
}

// $query = "SELECT * FROM genres";
// $genres = $db->prepare($query);
// $genres->execute();

?>

<?php if (isset($_SESSION['admin'])) : ?>
    <?php include 'header.php'; ?>
    <div id="wrapper">
        <div id="content">
            <?php while ($row = $values->fetch()) : ?>
                <form action="process_post.php" method="post" class="editform" enctype="multipart/form-data">
                    <fieldset class="editreview">
                        <div class="edit">
                            <input type="hidden" name="id" value="<?= $row['genre_id'] ?>" />
                            <p>
                                <label for="genre_name">New Genre Name:</label>
                                <input name="genre_name" id="genre_name" value="<?= $row['genre_name'] ?>" />
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
                            <button name="command" type="submit" value="GenreUpdate">Update</button>
                            </p>
                            <p>
                                <input type="submit" name="command" value="Delete" />
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