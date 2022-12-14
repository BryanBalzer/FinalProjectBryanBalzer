<?php
#session_start();
require 'connect.php';

$sorted = false;

if (isset($_GET['sort'])) {
    $sort = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sorted = true;
}

$query = "SELECT p.post_title, p.post_review, p.date_created, p.movie_id, p.postid, u.username, p.userid, p.imageName, u.admin FROM posts p JOIN users u ON p.userid = u.userid ORDER BY p.date_created DESC LIMIT 20";
$values = $db->prepare($query);
$values->execute();

$queryasc = "SELECT p.post_title, p.post_review, p.date_created, p.movie_id, p.postid, u.username, p.userid, p.imageName, u.admin FROM posts p JOIN users u ON p.userid = u.userid ORDER BY p.date_created ASC LIMIT 20";
$valuesasc = $db->prepare($queryasc);
$valuesasc->execute();
?>

<?php include 'header.php'; ?>

<div id="wrapper">
    <div id="content">
        <?php if ($sorted) : ?>
            <h1 class="font-weight-bold">Sorted by oldest posts!</h1>
            <?php while ($row = $valuesasc->fetch()) : ?>
                <h2 class="font-italic text-dark">
                    <a href="show.php?id=<?= $row['postid'] ?>"><?= $row['post_title'] ?></a>
                </h2>
                <p>
                    Posted on <?= $row['date_created'] ?>
                </p>
                <p>
                    Written by <a href="search.php?search=<?= $row['username'] ?>"><?= $row['username'] ?></a>
                </p>
            <?php endwhile ?>
            <a class="font-weight-bold" href="index.php?">Sort by newest posts..</a>
        <?php else : ?>
            <h1 class="font-weight-bold">Sorted by newest posts!</h1>
            <?php while ($row = $values->fetch()) : ?>  
                <h2 class="font-italic text-dark">
                    <a href="show.php?id=<?= $row['postid'] ?>"><?= $row['post_title'] ?></a>
                </h2>
                <p>
                    Posted on <?= $row['date_created'] ?>
                </p>
                <p>
                    Written by <a href="search.php?search=<?= $row['username'] ?>"><?= $row['username'] ?></a>
                </p>
            <?php endwhile ?>
            <a class="font-weight-bold" href="index.php?sort">Sort by oldest posts..</a>
        <?php endif ?>
    </div>
</div>

<?php include 'footer.php'; ?>