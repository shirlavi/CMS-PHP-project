<?php

include "db.php";
include "../admin/functions/function.php";
session_start();

global $connection;

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $query= "SELECT * FROM users WHERE user_name = '{$username}'";
    if (!$select_username_query = mysqli_query($connection, $query))
        die("QUERY FAILED" . mysqli_error());
    while ($row = mysqli_fetch_assoc($select_username_query)){
        $db_user_password = $row['user_password'];
        $db_user_id = $row['user_id'];
        $db_username = $row['user_name'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        $db_user_email = $row['user_email'];
        $db_randsalt = $row['randsalt'];

        $password_encrypt = encrypt($password, $db_randsalt);
    }

        if (!empty($db_username) && !empty($db_user_password) && $db_user_password === $password_encrypt && $db_username === $username) {
            //login success!!
            $_SESSION['userid'] = $db_user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
            $_SESSION['user_email'] = $db_user_email;
            header("Location: ../index.php");
        }
        else{
            //login failed!!
            header("Location: ../index.php");
            echo "<h1> password is not good! </h1> "; //not appear
        }
}