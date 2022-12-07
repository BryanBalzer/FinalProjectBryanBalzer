<?php
require 'connect.php';
session_start();

$query = "SELECT * FROM genres" ;
$values = $db->prepare($query);
$values->execute();

if ($_POST && !empty($_POST['name'])) {
    $genrename = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "INSERT INTO genres (genre_name) VALUES (:genre_name)";
    $statement = $db->prepare($query);

    $statement->bindValue(':genre_name', $genrename);

    if ($statement->execute()) {
        header("Location: genre.php");
        exit;
    }
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <form method="post" action="genrecreate.php">
        <div class="row m-5">
            <div class="col">
                <label for="formGroupExampleInput" class="form-label">Genre Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Genre Name" aria-label="Genre Name">
            </div>        
        </div>
        <div style="padding-left: 61px">
        <button type="submit" class="btn btn-primary">Create</button>
</div>
    </form>
</div>

<?php include 'footer.php'; ?>