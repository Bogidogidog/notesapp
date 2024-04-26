<?php 
include 'partials/header.php';

//fetch note
if(isset($_GET['id'])){
    $id=filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $query="SELECT * FROM notes WHERE id=$id";
    $result=mysqli_query($connection,$query);
    $note=mysqli_fetch_assoc($result);

}else{
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}

?>

    <section class="singlenote">
        <div class="container singlenote__container">
            <h2>
                <?=$note['title']?>
            </h2>
            <textarea><?=$note['description']?></textarea>
        </div>
    </section>
