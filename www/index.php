<?php 
include 'partials/header.php';

//fetch notes
$query="SELECT * FROM notes ORDER BY date_time";
$notes=mysqli_query($connection,$query);
?>
<section class="notes">
    <div class="container notes__container">
        <?php while ($note = mysqli_fetch_assoc($notes)) : ?>
        <article class="note">
            <div class="note__info">
                <h2 class="note__title"><a
                        href="<?= ROOT_URL ?>note.php?id=<?= $note['id'] ?>"><?= $note['title'] ?></a></h2>
                <a href="<?= ROOT_URL ?>note.php?id=<?= $note['id'] ?>">
                    <p class="note__description" style="min-height: 100px;">
                        <?= substr($note['description'], 0, 150) ?>
                    </p>
                </a>
                <h6 class="note__title"><?= $note['date_time'] ?></h2>
            </div>
        </article>
        <?php endwhile ?>
    </div>
</section>

<section class="user__buttons">
    <div class="container user__buttons-container">
        <?php 
        $all_users_query="SELECT * FROM users";
        $all_users_result=mysqli_query($connection,$all_users_query);

        ?>
        <?php while ( $user=mysqli_fetch_assoc($all_users_result) ) : ?>
        <a href="<?=ROOT_URL?>user-note.php?id=<?=$user['id']?>" class="user__button"><?=$user['firstname']?></a>
        <?php endwhile?>
    </div>
</section>


<?php
include "partials/footer.php";
?>