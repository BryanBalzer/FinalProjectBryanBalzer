<?php
require 'connect.php';
session_start();

if (isset($_GET['id'])) {
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$query = "SELECT p.postid, p.post_title, p.post_review, p.movie_id, p.imageName, u.username, g.genre_name FROM posts p JOIN users u ON p.userid = u.userid JOIN movies m ON m.movie_id = p.movie_id JOIN genres g ON g.genre_id = m.genre_id WHERE p.postid = :id";
	$values = $db->prepare($query);
	$values->bindValue(':id', $id);
	$values->execute();
}

if (empty($_SESSION['username'])) {
	$_SESSION['username'] = '';
}
?>


<?php if (isset($_GET['id'])) : ?>
	<?php include 'header.php'; ?>
	<div id="wrapper">
		<div id="header">
			<div id="content">
				<?php while ($row = $values->fetch()) : ?>
					<?php if (isset($_SESSION['admin']) || $row['username'] == $_SESSION['username']) : ?>
						<a href="edit.php?id=<?= $row['postid'] ?>">Edit this post!</a>
					<?php endif ?>
					<h2><?= $row['post_title'] ?></h2>
					<p>
						<?= $row['post_review'] ?>
					</p>
					<?php if (!empty($row['imageName'])) : ?>
						<img src="./images/<?= $row['imageName'] ?>" alt="<?= $row['post_title'] ?>">
					<?php endif ?>
					<a href="search.php?search=<?= $row['genre_name'] ?>">Search similar movies like '<?= $row['genre_name'] ?>'</a>
				<?php endwhile ?>
			</div>
		</div>
	</div>
	<?php include 'footer.php'; ?>
<?php else : ?>
	<?php header('Location: index.php'); ?>
<?php endif ?>