<?php 
include 'partials/header.php';

//fetch notes if id is set
if(isset($_GET['id'])){
    $id=filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query= "SELECT * FROM notes WHERE author_id=$id ORDER BY date_time DESC";
    $notes=mysqli_query($connection,$query);
}else{
    header('location: ' . ROOT_URL . 'index.php');
}
?>

<header class="user__title">
    <?php
                $user_query="SELECT * FROM users WHERE id=$id";
                $user_result=mysqli_query($connection,$user_query);
                $user=mysqli_fetch_assoc($user_result); 
    ?>
    <h2><?= $user['firstname'] ?></h2>
</header>


<?php if ((mysqli_num_rows($notes)) > 0) : ?>
<section class="notes <?= $featured ? '' : 'section__extra-margin' ?>">
    <div class="container notes__container">
        <?php while ($note = mysqli_fetch_assoc($notes)) : ?>
        <article class="note">
            <div class="note__info">
                <?php // fetch user from users using user_id
          $user_id = $note['author_id'];
          $user_query = "SELECT * FROM notes WHERE author_id=$user_id";
          $user_result = mysqli_query($connection, $user_query);
          $user = mysqli_fetch_assoc($user_result);
          ?>
                <a href="<?= ROOT_URL ?>user-note.php?id=<?= $note['_id'] ?>"
                    class="user__button"><?= $user['firstnam'] ?></a>
                <h2 class="note__title"><a
                        href="<?= ROOT_URL ?>note.php?id=<?= $note['id'] ?>"><?= $note['title'] ?></a></h2>
                <a href="<?= ROOT_URL ?>note.php?id=<?= $note['id'] ?>">

                    <p class="note__description" style="min-height: 100px;">
                        <?= substr($note['description'], 0, 120) ?>
                    </p>
                </a>

                <div class="note__author">
                    <?php
            // Fetch author from users table using author id
            $author_id = $note['author_id'];
            $author_query = "SELECT * FROM users WHERE id=$author_id";
            $author_result = mysqli_query($connection, $author_query);
            $author = mysqli_fetch_assoc($author_result);
            $author_firstname = $author['firstname'];
            $author_lastname = $author['lastname'];
            ?>
                    <div class="note__author-info">
                        <h5>For: <?= "{$author_firstname} {$author_lastname}" ?></h5>
                        <small><?= date("M d, Y - H:i", strtotime($note['date_time'])) ?></small>
                    </div>
                </div>
                </h3>
            </div>
        </article>
        <?php endwhile ?>



    </div>

</section>
<?php else : ?>
<div class="alert__message error lg">
    <p>
        No notes found for this user
    </p>
</div>
<?php endif ?>
<!--=====================================================================
==========================END OF THE notes===============================
=================================================================== -->
<section class="user__buttons">
    <div class="container user__buttons-container">
        <?php 
        $all_users_query="SELECT * FROM users ";
        $all_users_result=mysqli_query($connection,$all_users_query);

        ?>
        <?php while ( $user=mysqli_fetch_assoc($all_users_result) ) : ?>
        <a href="<?=ROOT_URL?>user-note.php?id=<?=$user['id']?>" class="user__button"><?=$user['firstname']?></a>
        <?php endwhile?>
    </div>
</section>
<!--=======================END OF user ===================================-->


<?php
include './partials/footer.php';
?>