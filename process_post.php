<?php
require 'connect.php';

include 'ImageResize.php';
include 'ImageResizeException.php';
use Gumlet\ImageResize;

#deb($_POST);
#deb($_SESSION,1);

$error = false;
#session_start();

if ($_POST['command'] == 'Register') {
    if (!empty($_POST['username']) || (!empty($_POST['password']))) {
        $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $query = "SELECT username FROM users WHERE username = :username LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $name);
        $statement->execute();


        if (empty(trim($pass))) {
            $password_err = "Please enter a password.";
        } else {
            $password = trim($pass);
        }

        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confirm password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Password did not match.";
            }
        }

        if (empty($password_err) && empty($confirm_password_err)) {

            if ($statement->rowCount() == 0) {
                $query = "INSERT INTO users (username, password, email) values (:username, :password, :email)";
                $statement = $db->prepare($query);
                $statement->bindValue(':username', $name);
                $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
                $statement->bindValue(':email', $email);
                $statement->execute();

                header('Location: index.php');
            }             
            }else {
                $error = true;
        }
    }
}

if ($_POST['command'] == 'Login') {
    if (!empty($_POST['username'])) {
        $name         = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password     = $_POST['password'];
        $query = "SELECT userid, username, password, admin FROM users WHERE username = :username";
        $values = $db->prepare($query);
        $values->bindValue(':username', $name);
        $values->execute();

        $row = $values->fetch();

        if ($name == $row['username'] && password_verify($password, $row['password'])) {
            $_SESSION['userid'] = $row['userid'];
            $_SESSION['username'] = $name;
            $_SESSION['loggedin'] = 1;
            if ($row['admin'] == 1) {
                $_SESSION['admin'] = $row['admin'];
            }
            header('Location: index.php');
        } else {
            $error = true;
        }
    }
    $error = true;
}

if ($_POST['command'] == 'DeleteUser') {
    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
    $userid = trim($userid);
    $query = "DELETE FROM users WHERE userid = :userid";
    $statement = $db->prepare($query);
    $statement->bindValue(':userid', $userid, PDO::PARAM_INT);
    $statement->execute();
    header('Location: admin.php');
}

if ($_POST['command'] == 'DeleteMovie') {
    $movieid = filter_input(INPUT_POST, 'movie_id', FILTER_SANITIZE_NUMBER_INT);
    $movieid = trim($movieid);
    $query = "DELETE FROM movies WHERE movie_id = :movie_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':movie_id', $movieid, PDO::PARAM_INT);
    $statement->execute();
    header('Location: movie.php');
}

if ($_POST['command'] == 'DeleteGenre') {
    $genreid = filter_input(INPUT_POST, 'genre_id', FILTER_SANITIZE_NUMBER_INT);
    $genreid = trim($genreid);
    $query = "DELETE FROM genres WHERE genre_id = :genre_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':genre_id', $genreid, PDO::PARAM_INT);
    $statement->execute();
    header('Location: genre.php');
}

if($_POST['command'] == 'Delete Image')
        {
            $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $query = "UPDATE posts SET imageName = NULL WHERE imageName = :image";
            $statement = $db->prepare($query);
            $statement->bindValue(':image', $image);
            $statement->execute();
            unlink('./images/'.$image);
            header('Location: index.php');
        }

if ($_POST['command'] == 'Create') {
    if (!empty($_POST['post_title']) && (!empty($_POST['post_review'])) && (!empty($_POST['movies']))) {
        $post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_review = filter_input(INPUT_POST, 'post_review', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $movies =  filter_input(INPUT_POST, 'movies', FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT userid FROM users WHERE username = :username";
        $values = $db->prepare($query);
        $values->bindValue(':username', $_SESSION['username']);
        $values->execute();
        $row = $values->fetch();

        function file_upload_path($original_filename, $upload_subfolder_name = 'images')
        {
            $current_folder = dirname(__FILE__);
            $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
            return join(DIRECTORY_SEPARATOR, $path_segments);
        }

        function file_is_an_image($temporary_path, $new_path)
        {
            $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
            $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

            $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
            $actual_mime_type        = mime_content_type($temporary_path);

            $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
            $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

            return $file_extension_is_valid && $mime_type_is_valid;
        }

        $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
        $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

        if ($image_upload_detected) {
            $filename        = $_FILES['image']['name'];
            $temporary_image_path  = $_FILES['image']['tmp_name'];
            $new_image_path        = file_upload_path($filename);
            $actual_file_extension   = pathinfo($new_image_path, PATHINFO_EXTENSION);


            if (file_is_an_image($temporary_image_path, $new_image_path)) {
                $imagename = $_POST['post_title'] . '.' . $actual_file_extension;
                move_uploaded_file($temporary_image_path, $new_image_path);

                $image = new ImageResize($new_image_path);
                $image->resizeToWidth(400);
                $image->save('./images/' . $imagename);

                $query = "INSERT INTO posts (userid, post_title, post_review, movie_id, imageName) values (:userid, :post_title, :post_review, :movie_id, :image)";
                $statement = $db->prepare($query);
                $statement->bindValue(':userid', $row['userid']);
                $statement->bindValue(':post_title', $post_title);
                $statement->bindValue(':post_review', $post_review);
                $statement->bindValue(':movie_id', $movies);
                $statement->bindValue(':image', $imagename);
                $statement->execute();
            }
        } else {
            $query = "INSERT INTO posts (userid, post_title, post_review, movie_id) values (:userid, :post_title, :post_review, :movie_id)";
            $statement = $db->prepare($query);
            $statement->bindValue(':userid', $row['userid']);
            $statement->bindValue(':post_title', $post_title);
            $statement->bindValue(':post_review', $post_review);
            $statement->bindValue(':movie_id', $movies);
            $statement->execute();
        }
        header('Location: index.php');
    } else {
        $error = true;
    }
}

if ($_POST['command'] == 'Update') {
    if (filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
        if (!empty(trim($_POST['post_title'])) && !empty(trim($_POST['post_review'])) && !empty(trim($_POST['movies']))) {
            $title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $review = filter_input(INPUT_POST, 'post_review', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $movies = filter_input(INPUT_POST, 'movies', FILTER_SANITIZE_NUMBER_INT);
            $id = $_POST['id'];

            $query = "UPDATE posts SET post_title = :title, post_review = :review, movie_id = :movies WHERE postid = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':review', $review);
            $statement->bindValue(':movies', $movies);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);

            $statement->execute();
            header('Location: index.php');
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}

if ($_POST['command'] == 'MovieUpdate') {
    if (filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
        if (!empty(trim($_POST['movie_title'])) && !empty(trim($_POST['genres']))) {
            $movietitle = filter_input(INPUT_POST, 'movie_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $genre = filter_input(INPUT_POST, 'genres', FILTER_SANITIZE_NUMBER_INT);
            $id = $_POST['id'];

            $query = "UPDATE movies SET movie_title = :movie_title, genre_id = :genre_id WHERE movie_id = :id";

            $statement = $db->prepare($query);
            $statement->bindValue(':movie_title', $movietitle);
            $statement->bindValue(':genre_id', $genre);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);

            $statement->execute();
            header('Location: index.php');
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}

if ($_POST['command'] == 'GenreUpdate') {
    if (filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
        if (!empty(trim($_POST['genre_name']))) {
            $genrename = filter_input(INPUT_POST, 'genre_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = $_POST['id'];

            $query = "UPDATE genres SET genre_name = :genre_name WHERE genre_id = :genre_id";

            $statement = $db->prepare($query);
            $statement->bindValue(':genre_name', $genrename);
            $statement->bindValue(':genre_id', $id, PDO::PARAM_INT);

            $statement->execute();
            header('Location: index.php');
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}
?>

<?php include 'header.php'; ?>
<div id="wrapper">
    <?php if ($error) : ?>
        <p><a href="index.php">An error has occurred, click here to return to the home page. </a></p>
    <?php endif ?>
</div>
<?php include 'footer.php'; ?>