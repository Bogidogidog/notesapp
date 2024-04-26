<?php
require "../config/database.php";

if(isset($_POST['submit'])){    
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title=filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$title || !$description){
        $_SESSION['edit-note'] = "Invalid form input";
    }else{
        $query = "UPDATE notes SET title='$title',description='$description', date_time=NOW() WHERE id=$id LIMIT 1";
        $result=mysqli_query($connection, $query);  

        if(mysqli_errno($connection)){
            $_SESSION['edit-note'] = "Couldnt update Note";

        }else{
            $_SESSION['edit-note-success'] = "$title Note was updated successfully";
        }
    }
}

header('location: ' . ROOT_URL . "admin/index.php");
die();