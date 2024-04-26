<?php
require "../config/database.php";

if(isset($_POST['submit'])){
    $author_id=$_SESSION['user-id'];
    $title =filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description =filter_var($_POST['description'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Check if the current user is an admin
    if(isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] == 1) {
        // If the current user is an admin, use the selected user_id
        $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
    } else {
        // If the current user is not an admin, use the current user's ID as both user_id and author_id
        $user_id = $author_id;
    }

    //validate form data
    if(!$title){
        $_SESSION['add-note']="Enter note Title";
    }elseif(!$description){
        $_SESSION['add-note']="Enter note Description";
    }
    // redirect with form data
    if(isset($_SESSION['add-note'])){
        $_SESSION['add-note-data']=$_POST;
        header('location: ' . ROOT_URL . 'admin/add-note.php');
        die();
    }else{
        //insert post into database
        $query="INSERT INTO notes (title, description, date_time, author_id) VALUES ('$title', '$description', NOW(), '$user_id')";
        $result=mysqli_query($connection,$query);
        if(mysqli_errno($connection)){
            $_SESSION['add-note']="Failed to add note";
            header("location: " . ROOT_URL . 'admin/index.php');
            die();
        }else{
            $_SESSION['add-note-success']="New post added successfully";
            header("location: " . ROOT_URL . 'admin/index.php');
            die();

        }
    }
}

header("location: " . ROOT_URL . 'admin/index.php');
die();
?>