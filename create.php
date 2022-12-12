<?php
require 'connect.php';
#session_start();

$query = "SELECT * FROM movies ORDER BY movie_title ASC";
$values = $db->prepare($query);
$values->execute();
?>

<?php include 'header.php'; ?>

<div id="wrapper">
    <div id="content">
        <form action="process_post.php" method="post" class="createform" enctype="multipart/form-data">
            <fieldset class="createreview">
                <div class="create">
                    <input type="hidden" name="username" value="<?= $_SESSION['username'] ?>" />
                    <p>
                        <label for="post_title">Post Title</label>
                        <input name="post_title" id="post_title" />
                    </p>
                    <p>
                        <label for="post_review">Review</label>
                        <textarea name="post_review" id="post_review"></textarea>
                    </p>
                    <p>
                        <label for="movies">Movie</label>
                        <select name="movies">
                            <?php while ($row = $values->fetch()) : ?>
                                <option value="<?= $row['movie_id'] ?>"><?= $row['movie_title'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </p>
                    <p>
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image">
                    </p>
                    <p>
                        <input type="submit" name="command" value="Create" />
                    </p>
            </fieldset>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>