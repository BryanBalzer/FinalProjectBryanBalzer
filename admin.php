<?php
    require 'connect.php';
    session_start();
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
                    <input type="submit" name="command" value="Delete User" />
                </select>
            </form>
        </div>
    </div>
<?php endif ?>
<?php include 'footer.php'; ?>