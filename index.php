<?php
session_start();
require 'connect.php';

$sorted = false;

if (isset($_GET['sort'])) {
    $sort = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sorted = true;
}

$query = "SELECT p.post_title, p.post_review, p.date_created, p.movie_id, p.postid, u.username, p.userid, p.imageName, u.admin FROM posts p JOIN users u ON p.userid = u.userid ORDER BY p.date_created DESC LIMIT 10";
$values = $db->prepare($query);
$values->execute();

$queryasc = "SELECT p.post_title, p.post_review, p.date_created, p.movie_id, p.postid, u.username, p.userid, p.imageName, u.admin FROM posts p JOIN users u ON p.userid = u.userid ORDER BY p.date_created ASC LIMIT 10";
$valuesasc = $db->prepare($queryasc);
$valuesasc->execute();
?>

<?php include 'header.php'; ?>

<div id="wrapper">
    <div id="content">
    <?php while ($row = $valuesasc->fetch()) : ?>
                <h2 class="font-italic" class="text-dark">
                    <a href="show.php?id=<?= $row['postid'] ?>"><?= $row['post_title'] ?></a>
                </h2>
                <p>
                    Posted on <?= $row['date_created'] ?>
                </p>
                <p>
                    Written by <a href="search.php?search=<?= $row['username'] ?>"><?= $row['username'] ?></a>
                </p>
            <?php endwhile ?>
    </div>
</div>

<?php include 'footer.php'; ?>