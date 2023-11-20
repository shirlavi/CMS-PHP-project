<?php


function addUser(){
    global $connection;
    if(isset($_POST['create_user'])){
        $user_name = $_POST['user_name'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_image = $_FILES['user_image']['name'];
        $user_temp_image = $_FILES['user_image']['tmp_name'];
        $user_role = $_POST['user_role'];
        $randsalt = (string)rand(1,1000);
        $user_password = encrypt($user_password, $randsalt);
        move_uploaded_file($user_temp_image, "../images/$user_image");
        if($user_name== "" || $user_password == "" || $user_firstname== "" || $user_lastname == "" || $user_email == "")
            echo "<h2>Please fill-in all fields</h2>";
        else if(ifUsernameExist($user_name))
            echo "<h2>This username is already exist.. please create a new one</h2>";
        else{
            $add_user_query = "INSERT INTO users(user_name, user_password, user_firstname, user_lastname, user_email, image, user_role, randsalt) ";
            $add_user_query .= "VALUES('{$user_name}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_image}', '{$user_role}', '{$randsalt}')";
            if (!mysqli_query($connection, $add_user_query))
                die("QUERY ADD CATEGORY FAILED". mysqli_error());
            else{
                if(ifAdminLoggedIn())
                    header("Location: users.php"); //refreshing
                else
                    header("Location: index.php"); //refreshing
            }
        }
    }
}

function encrypt($pass, $salt){
    $hash_format = "2y$13$";
    $hash_and_salt = $hash_format . $salt;
    return crypt($pass, $hash_and_salt);
}

//function decrypt($pass, $salt){
//    $hash_format = "2y$13$";
//    $hash_and_salt = $hash_format . $salt;
//    return decrypta($pass, $hash_and_salt);
//}

function ifAdminLoggedIn(){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role'] === 'admin'){
            return true;
        }
    }
    return false;
}
function ifLoggedIn(){
    if(isset($_SESSION['username']))
        return true;
    return false;
}

function selectUserRole(){
    global $connection;
    $query = "SELECT * FROM  users";
    if(!$select_role_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());

    while($row = mysqli_fetch_assoc($select_role_query)){
        $user_id = $row['user_id'];
        $user_title = $row['user_role'];
        echo "<option value='{$user_id}'>{$user_title}</option>";
    }
}

function editUser($user_id_to_edit,$user_name_before, $randsalt, $user_password_before){
    global $connection;
    if(isset($_POST['edit_user'])){
        $user_name = $_POST['user_name'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_image = $_FILES['user_image']['name'];
        $user_temp_image = $_FILES['user_image']['tmp_name'];
        $user_role = $_POST['user_role'];
        move_uploaded_file($user_temp_image, "../images/$user_image");

        checkEmptyImage($user_image, $user_id_to_edit, "user");

        if($user_password_before != $user_password)
            $user_password = encrypt($user_password, $randsalt);


        if( $user_name== "" || $user_password === "" || $user_firstname === "" || $user_lastname === "" || $user_email === "")
            echo "<h2>Please fill-in all fields</h2>";
        else if($user_name_before != $user_name && ifUsernameExist($user_name))
            echo "<h2>This username already is exist.. please create a new one</h2>";
        else{
            $edit_user_query = "UPDATE users SET ";
            $edit_user_query .= "user_name= '{$user_name}', ";
            $edit_user_query .= "user_password= '{$user_password}', ";
            $edit_user_query .= "user_firstname= '{$user_firstname}', ";
            $edit_user_query .= "user_lastname= '{$user_lastname}', ";
            $edit_user_query .= "user_email= '{$user_email}', ";
            $edit_user_query .= "image= '{$user_image}', ";
            $edit_user_query .= "user_role= '{$user_role}', ";
            $edit_user_query .= "randsalt= '{$randsalt}' ";
            $edit_user_query .= "WHERE user_id= '{$user_id_to_edit}'";

            if (!mysqli_query($connection, $edit_user_query))
                die("QUERY EDIT POST FAILED". mysqli_error());
            else
                return true;
        }
    }
}

function ifUsernameExist($user_name){
    global $connection;
    $query_select_user = "SELECT * FROM users WHERE user_name = '{$user_name}'";
    $query_select_user_result = mysqli_query($connection, $query_select_user);
    if (mysqli_num_rows($query_select_user_result)>0)
        return true;
    return false;
}

function deleteUser(){
    global $connection;
    if(isset($_GET['delete'])){
        $user_id_to_delete = $_GET['delete'];
        $query_delete_user = "DELETE FROM users WHERE user_id = '{$user_id_to_delete}'";
        if (!mysqli_query($connection, $query_delete_user))
            die("QUERY FAILED". mysqli_error());
        header("Location: users.php"); //refreshing the page
    }
}

function createUsersTable(){
    global $connection;

    $query = "SELECT * FROM  users";
    if(!$select_users_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());

    while($row = mysqli_fetch_assoc($select_users_query)){
        $user_id = $row['user_id'];
        $user_name = $row['user_name'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image= $row['image'];
        $user_role = $row['user_role'];
        $randsalt = $row['randsalt'];

        echo "<tr>";
        echo "<td>$user_id</td>";
        echo "<td>$user_name</td>";
        //echo "<td>$user_password</td>";
        echo "<td>$user_firstname</td>";
        echo "<td>$user_lastname</td>";
        echo "<td>$user_email</td>";
        echo "<td> <img src='../images/$user_image' alt='image' width='300'> </td>";
        echo "<td>$user_role</td>";
        //echo "<td>$randsalt</td>";
        echo "<td><a href='users.php?source=edit_user&p_id={$user_id}'>Edit</a></td>";
        echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
        echo "<tr>";
    }
}

function numberOfUsers(){
    global $connection;
    $query = "SELECT * FROM  users";
    if(!$select_user_comment_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_user_comment_query);
    return $count;
}