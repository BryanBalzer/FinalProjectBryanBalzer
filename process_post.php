<?php

$error = false;
session_start();

if ($_POST['command'] == 'Register') {
    if (!empty($_POST['username']) || (!empty($_POST['password']))) {
        $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $query = "SELECT username FROM users WHERE username = :username LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $name);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            $query = "INSERT INTO users (username, password, email) values (:username, :password, :email)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $name);
            $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
            $statement->bindValue(':email', $email);
            $statement->execute();

            header('Location: index.php'); 
        } else {
            $error = true;
        }
    }
}

if ($_POST['command'] == 'Login') {
    if (!empty($_POST['username'])) {
        $name         = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password     = $_POST['password'];
        $query = "SELECT username, password, admin FROM users WHERE username = :username";
        $values = $db->prepare($query);
        $values->bindValue(':username', $name);
        $values->execute();

        $row = $values->fetch();

        if ($name == $row['username'] && password_verify($password, $row['password'])) {
            $_SESSION['username'] = $name;
            $_SESSION['loggedin'] = true;
            if ($row['admin'] == 1) {
                $_SESSION['admin'] = true;
            }
            header('Location: index.php');
        } else {
            $error = true;
        }
    }
    $error = true;
}
?>