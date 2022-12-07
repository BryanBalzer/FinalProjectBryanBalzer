<?php
require 'connect.php';
session_start();

if (isset($_GET['search'])) {
    $string = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $string = htmlspecialchars($string);
    $string = '%' . $string . '%';

    $query = "SELECT * FROM users u JOIN posts p ON p.userid = u.userid JOIN movies m ON m.movie_id = p.movie_id JOIN genres g ON g.genre_id = m.genre_id WHERE u.username LIKE :string OR p.post_title LIKE :string OR g.genre_name LIKE :string ORDER BY p.date_created DESC";
    $statement = $db->prepare($query);
    $statement->bindValue(':string', $string);
    $statement->execute();
}

?>

<?php include 'header.php'; ?>
<div id="wrapper">
    <div id="content">
        <?php if (!empty($_GET['search'])) : ?>

            <h1 class="font-weight-bold">Search results for '<?= $_GET['search'] ?>'</h1>
            <?php while ($row = $statement->fetch()) : ?>
                <ul class="list-group">
                    <li class="list-group-item"><a href="show.php?id=<?= $row['postid'] ?>"><?= $row['post_title'] ?></a></li>
                </ul>
            <?php endwhile ?>
        <?php else : ?>
            <a href="index.php">You didn't search anything, click here to return to the main page.</a>
        <?php endif ?>
    </div>
</div>
<?php include 'footer.php'; ?>