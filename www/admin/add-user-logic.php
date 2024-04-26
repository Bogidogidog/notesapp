<?php
require "config/database.php";
session_start();

//get add-user form data if sbmit button is clicked

if(isset($_POST["submit"])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    if(!$firstname){
        $_SESSION['add-user'] = 'Please enter your First Name';
    }elseif(!$lastname){
        $_SESSION['add-user'] = 'Please enter your Last Name';
    }elseif(!$username){
        $_SESSION['add-user'] = 'Please enter your Username';
    }elseif(!$email){
        $_SESSION['add-user'] = 'Please enter your Email';
    }elseif(!($is_admin == 1 || $is_admin == 0 )){
        $_SESSION['add-user'] = 'Please select user role';
    }elseif(strlen($createpassword)<8 || strlen($confirmpassword)<8){
        $_SESSION['add-user'] = 'Password should be 8+ characters';
    }else{
        if($createpassword !== $confirmpassword){
            $_SESSION['add-user']="Passwords donot match";

        }else{


            $hashed_password = password_hash($createpassword,PASSWORD_DEFAULT);
            
            $user_check_query="SELECT * FROM users WHERE username='$username' OR email ='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result)>0){
                $_SESSION['add-user'] = "Username or Email already exists";
            }
        }
    }
    // redirect back t add-user on error
    if(isset($_SESSION['add-user'])){
        // pass data back to sign up page
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-user.php');
        die();
        
    }else{
        //insert new user into users table
        $inset_user_query = "INSERT INTO users SET firstname ='$firstname' ,lastname='$lastname',username='$username',email ='$email' ,password='$hashed_password',is_admin='$is_admin'";
        $inset_user_result = mysqli_query($connection, $inset_user_query);
        if(!mysqli_errno($connection)){
            $_SESSION['add-user-success'] = "Registration Successful";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }
}else{
    //button not clicked
    header('location: ' . ROOT_URL . "admin/add-user.php");
    die();
}