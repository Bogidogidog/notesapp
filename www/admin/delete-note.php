<?php
require '../config/database.php';
if(isset($_GET['id'])){
    $id=filter_var($_GET['id'],  FILTER_SANITIZE_NUMBER_INT);

    // fetch note fom database
    $query="SELECT * FROM notes WHERE id=$id";
    $result =mysqli_query($connection,$query);

    //make sure 1 record was fetched from database
    if(mysqli_num_rows($result)==1){
        $note=mysqli_fetch_assoc($result);
        // delete post from  database
        $delete_note_query="DELETE from notes WHERE id=$id LIMIT 1";
        $delete_note_result=mysqli_query($connection,$delete_note_query);

        if(!mysqli_errno($connection)){
            $_SESSION['edit-note-success']="Note deleted successfully";
        }   
    }

}else{
    header('location: ' . ROOT_URL . '/index.php');
    die();
}


header('location: ' . ROOT_URL . '/index.php');
die();