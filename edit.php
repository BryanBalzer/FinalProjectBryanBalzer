<?php
require 'connect.php';
#session_start();



if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT * FROM posts INNER JOIN movies ON posts.movie_id = movies.movie_id WHERE postid = :id";
    $values = $db->prepare($query);
    $values->bindValue(':id', $id);
    $values->execute();
}

$query = "SELECT * FROM movies ORDER BY movie_title ASC";
$movies = $db->prepare($query);
$movies->execute();

?>

<?php include 'header.php'; ?>

<?php if (isset($_SESSION['loggedin'])) : ?>
    <div id="wrapper">
        <div id="content">
            <?php while ($row = $values->fetch()) : ?>
                <form action="process_post.php" method="post" class="editform" enctype="multipart/form-data">
                    <fieldset class="editreview">
                        <div class="edit">
                            <input type="hidden" name="id" value="<?= $row['postid'] ?>" />
                            <p>
                                <label for="post_title">Title:</label>
                                <input name="post_title" id="post_title" value="<?= $row['post_title'] ?>" />
                            </p>
                            <p>
                                <label for="post_review">Review:</label>
                                <textarea name="post_review" id="post_review"><?= $row['post_review'] ?></textarea>
                            </p>
                            <p>
                                <label for="movies">Movie:</label>  
                                <select name="movies">
                                <option value="none" selected disabled hidden>Select an Option</option>
                                    <?php while ($movie = $movies->fetch()) : ?>
                                        <option value="<?= $movie['movie_id'] ?>"><?= $movie['movie_title'] ?></option>
                                    <?php endwhile ?>
                                </select>

                            </p>
                            <input type="submit" name="command" value="Update" />
                            </p>
                            <p>
                                <input type="submit" name="command" value="Delete" />
                            </p>
                            <input type="hidden" name="image" value="<?= $row['imageName'] ?>" />
                            <?php if (isset($_SESSION['admin'])) : ?>
                                <?php if (!empty($row['imageName'])) : ?>
                                    <p>
                                        <input type="submit" name="command" value="Delete Image" />
                                    </p>
                                <?php endif ?>
                            <?php endif ?>
                    </fieldset>
                </form>
            <?php endwhile ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
<?php else : ?>
    <?php header('Location: index.php'); ?>
<?php endif ?>