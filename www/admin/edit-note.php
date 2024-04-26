<?php
include "partials/header.php";

// fetch note data from database if id is set
if(isset($_GET['id'])){
    $id=filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $query="SELECT * FROM notes WHERE id= $id";
    $result=mysqli_query($connection,$query);
    $note=mysqli_fetch_assoc($result);
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit note</h2>
        <form action="<?= ROOT_URL ?>admin/edit-note-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" value="<?=$note['title']?>" name ="title" placeholder="Title">
            <input type="hidden" value="<?=$note['id']?>" name="id">
            <textarea  rows="8" name="description" placeholder="Description"><?=$note['description']?></textarea>
            <button type="submit" name="submit" class="btn">Update note</button>
        </form>
    </div>
</section>

<?php
include "../footer.php";
?>
