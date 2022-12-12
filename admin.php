<?php
    require 'connect.php';
    #session_start();

    $query = "SELECT * FROM users";
    $values = $db->prepare($query);
    $values->execute();

?>

<?php include 'header.php'; ?>
<?php if (isset($_SESSION['admin'])) : ?>
    <div id="wrapper">
        <div id="content">
            <form action="process_post.php" method="post" class="createform" enctype="multipart/form-data">
                <select name='userid'>
                    <option> -- select an option -- </option>
                    <?php while ($row = $values->fetch()) : ?>
                        <?php if ($row['admin'] == 0) : ?>
                            <option value="<?= $row['userid'] ?>"><?= $row['username'] ?></option>
                        <?php endif ?>
                        
                    <?php endwhile ?>
                </select>
                    <input type="submit" name="command" value="DeleteUser">
                
            </form>
            
        </div>
    </div>
<?php endif ?>
<?php include 'footer.php'; ?>