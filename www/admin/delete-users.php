<?php

require 'config/database.php';
if(!(isset($_SESSION['user_is_admin']))){
    header("location :".ROOT_URL."logout.php");

}elseif(isset($_GET["id"])){
    $id =filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    //fetch user from database
    $query="SELECT * FROM users WHERE id=$id";
    $result=mysqli_query($connection,$query);
    $user = mysqli_fetch_assoc($result);

    $delete_user_note_query = "DELETE FROM notes WHERE author_id  = $id";
    $delete_user_note_result = mysqli_query($connection, $delete_user_note_query);

    // delete user from database
    $delete_user_query = "DELETE FROM users WHERE id  = $id";
    $delete_user_result = mysqli_query($connection, $delete_user_query);
    if(mysqli_errno($connection)){
        $_SESSION['delete-user']="Couldn't delete '{$user['firstname']}' '{$user['lastname']}'";

    } else{
        $_SESSION['delete-user-success']="'{$user['firstname']} {$user['lastname']}' has been deleted successfully";

    }   
}
header("location: " . ROOT_URL . "admin/manage-users.php");
die();