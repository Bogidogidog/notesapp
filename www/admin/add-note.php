<?php
include "partials/header.php";

// fetch users from database
$query = "SELECT * FROM users";
$users=mysqli_query($connection,$query);


// get back form data if form was invalid
$title= $_SESSION['add-note-data']['title'] ?? null;
$description= $_SESSION['add-note-data']['description'] ?? null;
unset($_SESSION['add-note-data']);
?>



<section class="form__section">
    <div class="container form__section-container">
        <h2>Add note</h2>
        <?php if(isset($_SESSION['add-note'])) : ?>
        <div class="alert__message error">
            <p>
                <?=
                $_SESSION['add-note'];
                unset($_SESSION['add-note']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-note-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value ="<?= $title ?>" placeholder="Title">
            <textarea  rows="8" name="description"  placeholder="description"><?=$description?></textarea>
            <?php if(isset($_SESSION["user_is_admin"])) : ?>
                <select name="user_id">
                <?php while($user = mysqli_fetch_assoc($users)) : ?>
                <option value="<?= $user['id'] ?>"><?= $user['firstname'] ?></option>
                <?php endwhile?>
            </select>
            <?php endif ?>
            <button type="submit" name="submit" class="btn">Add note</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
