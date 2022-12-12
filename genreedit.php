<?php
require 'connect.php';
#session_start();

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM genres WHERE genre_id = :genre_id";
    $values = $db->prepare($query);
    $values->bindValue(':genre_id', $id);
    $values->execute();
}
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
                            <button name="command" type="submit" value="GenreUpdate">Update</button>
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