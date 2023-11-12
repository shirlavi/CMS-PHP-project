<?php
///// Categories function: /////
    function add_category(){
        global $connection;
        if(isset($_POST['submit'])){
            $cat_title = $_POST['cat_title'];
            if($cat_title == "" || empty($cat_title))
                echo "This field should not be empty";
            elseif(ifCatExist($cat_title))
                echo "This category is already exist";
            else {
                $add_category_query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
                if (!mysqli_query($connection, $add_category_query))
                    die("QUERY ADD CATEGORY FAILED". mysqli_error());
            }
        }
    }

    function creat_cat_table(){
        global $connection;
        $query = "SELECT * FROM  categories";
        if(!$select_categories_query = mysqli_query($connection, $query))
            die("QUERY FAILED". mysqli_error());

        while($row = mysqli_fetch_assoc($select_categories_query)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            echo "<tr>";
            echo "<td>  {$cat_id}  </td>";
            echo "<td>  {$cat_title}  </td>";
            echo "<td> <a href='categories.php?delete={$cat_id}'> Delete </a> </td>";
            echo "<td> <a href='categories.php?edit={$cat_id}'> Edit </a> </td>";
            echo "</tr>";
        }
    }

    function delete_category(){
        global $connection;
        if(isset($_GET['delete'])){
            $cat_id_to_delete = $_GET['delete'];
            $query_delete_category = "DELETE FROM categories WHERE cat_id = $cat_id_to_delete";
            if (!mysqli_query($connection, $query_delete_category))
                die("QUERY FAILED". mysqli_error());
            header("Location: categories.php"); //refreshing the page
        }
    }

    function selectCat($post_category_id = 3){
        global $connection;
        $query = "SELECT * FROM  categories";
        if(!$select_categories_query = mysqli_query($connection, $query))
            die("QUERY FAILED". mysqli_error());

        echo "<option value='{$post_category_id}'>Select Option</option>";
        while($row = mysqli_fetch_assoc($select_categories_query)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
            echo "<option value='{$cat_id}'>{$cat_title}</option>";
        }
    }

    function update_category($cat_id_to_edit, $cat_title_to_edit_before){
        global $connection;
        if(isset($_POST['submit_edit'])){
            $cat_title_edited = $_POST['cat_title_edit'];
            if($cat_title_edited == "" || empty($cat_title_edited))
                echo "This field should not be empty";
            elseif($cat_title_to_edit_before != $cat_title_edited && ifCatExist($cat_title_edited))
                echo "This category is already exist";
            else {
                $edit_category_query = "UPDATE categories SET cat_title= '{$cat_title_edited}' WHERE cat_id = $cat_id_to_edit";
                if (!mysqli_query($connection, $edit_category_query))
                    die("QUERY EDIT CATEGORY FAILED". mysqli_error());
                else
                    header("Location: categories.php"); //refreshing
            }
        }
    }
    function getCatByID($cat_id){
        global $connection;
        $query_select_category = "SELECT * FROM categories WHERE cat_id = $cat_id";
        $query_select_category_result = mysqli_query($connection, $query_select_category);
        if (!$query_select_category_result)
            die("QUERY FAILED". mysqli_error());
        else{
            while($row = mysqli_fetch_assoc($query_select_category_result)){
                $cat_title_to_edit = $row['cat_title'];
            }
            return $cat_title_to_edit;
        }
        return null;
    }

    function ifCatExist($cat_title){
        global $connection;
        $query_select_cat = "SELECT * FROM categories WHERE cat_title = '{$cat_title}'";
        $query_select_cat_result = mysqli_query($connection, $query_select_cat);
        if (mysqli_num_rows($query_select_cat_result)>0)
            return true;
        return false;
}

///// Posts function: /////
    function addPost(){
        global $connection;
        if(isset($_POST['create_post'])){
            $post_title = $_POST['title'];
            $post_author = $_POST['author'];
            $post_category_id = $_POST['post_category_id'];
            $post_status = $_POST['post_status'];
            $post_image = $_FILES['image']['name'];
            $post_temp_image = $_FILES['image']['tmp_name'];
            $post_tags = $_POST['post_tags'];
            $post_content = $_POST['post_content'];
            $post_date= date('d-m-y');
            $post_comment_count = 0;
            move_uploaded_file($post_temp_image, "../images/$post_image");

            if($post_title== "" || $post_author == "" || $post_content == "")
                echo "<h2>Please fill-in all fields</h2>";
            else{
                $add_post_query = "INSERT INTO postss(post_category_id, post_title , post_author, post_date, image, post_content, post_tags, post_comment_count, post_status) ";
                $add_post_query .= "VALUES('{$post_category_id}', '{$post_title}' , '{$post_author}', '{$post_date}', '{$post_image}', '{$post_content}','{$post_tags}', '{$post_comment_count}', '{$post_status}')";
                if (!mysqli_query($connection, $add_post_query))
                    die("QUERY ADD CATEGORY FAILED". mysqli_error());
                else
                    return true;
            }
        }
        return false;
    }

    function checkEmptyImage(&$image, $id_to_edit,$type){
        global $connection;
        if(empty(($image))){
            if($type == "post")
                $query = "SELECT * FROM  postss WHERE post_id = '{$id_to_edit}'";
            else
                $query = "SELECT * FROM  users WHERE user_id = '{$id_to_edit}'";
            if (!$select_by_id_query = mysqli_query($connection, $query))
                die("QUERY FAILED" . mysqli_error());
            while ($row = mysqli_fetch_assoc($select_by_id_query)){
                $image = $row['image'];
                }
        }
    }

    function editPost($post_id_to_edit){
        global $connection;
        if(isset($_POST['edit_post'])){
            $post_author = $_POST['author'];
            $post_title = $_POST['title'];
            $post_category_id = $_POST['post_category_id'];
            $post_status = $_POST['post_status'];
            $post_image = $_FILES['image']['name'];
            $post_temp_image = $_FILES['image']['tmp_name'];
            $post_tags = $_POST['post_tags'];
            //$post_date= date('d-m-y');
            $post_content = $_POST['post_content'];
            move_uploaded_file($post_temp_image, "../images/$post_image");

            checkEmptyImage($post_image, $post_id_to_edit, "post");

            if($post_title== "" || $post_author == "" || $post_content == "")
                echo "<h2>Please fill-in all fields</h2>";
            else{
                $edit_post_query = "UPDATE postss SET ";
                $edit_post_query .= "post_title= '{$post_title}', ";
                $edit_post_query .= "post_category_id= '{$post_category_id}', ";
                $edit_post_query .= "post_date= now(), ";
                $edit_post_query .= "post_author= '{$post_author}', ";
                $edit_post_query .= "post_status= '{$post_status}', ";
                $edit_post_query .= "post_tags= '{$post_tags}', ";
                $edit_post_query .= "post_content= '{$post_content}', ";
                $edit_post_query .= "image= '{$post_image}' ";
                $edit_post_query .= "WHERE post_id= '{$post_id_to_edit}'";

                if (!mysqli_query($connection, $edit_post_query))
                    die("QUERY EDIT POST FAILED". mysqli_error());
                else
                    header("Location: posts.php"); //refreshing
            }
        }
    }

    function deletePost(){
        global $connection;
        if(isset($_GET['delete'])){
            $post_id_to_delete = $_GET['delete'];
            $query_delete_post = "DELETE FROM postss WHERE post_id = '{$post_id_to_delete}'";
            if (!mysqli_query($connection, $query_delete_post))
                die("QUERY FAILED". mysqli_error());
            header("Location: posts.php"); //refreshing the page
        }
    }

    function creat_posts_table(){
        global $connection;
        $query = "SELECT * FROM  postss";
        if(!$select_posts_query = mysqli_query($connection, $query))
            die("QUERY FAILED". mysqli_error());

        while($row = mysqli_fetch_assoc($select_posts_query)){
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date= $row['post_date'];

            echo "<tr>";
            echo "<td>$post_id</td>";

            show_cat_title_by_ID($post_category_id);

            echo "<td>$post_title</td>";
            echo "<td>$post_author</td>";
            echo "<td>$post_date</td>";
            echo "<td> <img src='../images/$post_image' alt='image' width='300'> </td>";
            echo "<td>$post_tags</td>";
            echo "<td>$post_comment_count</td>";
            echo "<td>$post_status</td>";
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "<tr>";
        }
    }

    function show_cat_title_by_ID($post_category_id){
        global $connection;
        $query = "SELECT * FROM  categories WHERE cat_id = {$post_category_id}";
        if(!$select_categories_query = mysqli_query($connection, $query))
            die("QUERY FAILED". mysqli_error());
        while($row = mysqli_fetch_assoc($select_categories_query))
            $cat_title = $row['cat_title'];
        echo "<td>$cat_title</td>";

    }

    ///// User Functions: /////
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

function decrypt($pass, $salt){
    $hash_format = "2y$13$";
    $hash_and_salt = $hash_format . $salt;
    return decrypt($pass, $hash_and_salt);
}

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

function deleteComment(){
    global $connection;
    if(isset($_GET['delete'])){
        $comment_id_to_delete = $_GET['delete'];
        $query_delete_comment = "DELETE FROM comments WHERE comment_id = '{$comment_id_to_delete}'";
        if (!mysqli_query($connection, $query_delete_comment))
            die("QUERY FAILED". mysqli_error());
        header("Location: comments.php"); //refreshing the page
    }
}


function approveComment(){
    global $connection;

    if(isset($_GET['approve'])){
        $comment_id_to_approve = $_GET['approve'];
        $query_approve_comment = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = '{$comment_id_to_approve}'";
        if (!mysqli_query($connection, $query_approve_comment))
            die("QUERY FAILED". mysqli_error());
        header("Location: comments.php"); //refreshing the page
    }

}

function unapproveComment(){
    global $connection;
    if(isset($_GET['unapprove'])){
        $comment_id_to_unapprove = $_GET['unapprove'];
        $query_unapprove_comment = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = '{$comment_id_to_unapprove}'";
        if (!mysqli_query($connection, $query_unapprove_comment))
            die("QUERY FAILED". mysqli_error());
        header("Location: comments.php"); //refreshing the page
    }

}

function createCommentsTable(){
    global $connection;

    $query = "SELECT * FROM  comments";
    if(!$select_comments_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());

    while($row = mysqli_fetch_assoc($select_comments_query)){
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_email = $row['comment_email'];
        $comment_content = $row['comment_content'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];

        echo "<tr>";
        echo "<td>$comment_id</td>";
        echo "<td>$comment_author</td>";
        echo "<td>$comment_content</td>";
        echo "<td>$comment_email</td>";
        echo "<td>$comment_status</td>";

        $query = "SELECT * FROM  postss WHERE post_id = {$comment_post_id}";
        if(!$select_post_comment_query = mysqli_query($connection, $query))
            die("QUERY FAILED". mysqli_error());
        while($row = mysqli_fetch_assoc($select_post_comment_query)){
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            echo "<td><a href='../post.php?p_id={$post_id}'>$post_title</a></td>";
        }

        echo "<td>$comment_date</td>";
        echo "<td><a href='comments.php?unapprove={$comment_id}'>unApprove</a></td>";
        echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
        //echo "<td><a href='posts.php?source=edit_post&p_id='{$comment_post_id}>Edit</a></td>";
        echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";
        echo "<tr>";
    }
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

function numberOfPosts(){
    global $connection;
    $query = "SELECT * FROM  postss";
    if(!$select_post_comment_query = mysqli_query($connection, $query))
            die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_post_comment_query);
    return $count;
}

function numberOfComments(){
    global $connection;
    $query = "SELECT * FROM  comments";
    if(!$select_comments_comment_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_comments_comment_query);
    return $count;
}

function numberOfUsers(){
    global $connection;
    $query = "SELECT * FROM  users";
    if(!$select_user_comment_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_user_comment_query);
    return $count;
}

function numberOfCats(){
    global $connection;
    $query = "SELECT * FROM  categories";
    if(!$select_cats_comment_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_cats_comment_query);
    return $count;
}

function numberOfDraftPosts(){
    global $connection;
    $query = "SELECT * FROM  postss WHERE post_status='draft'";
    if(!$select_post_comment_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_post_comment_query);
    return $count;
}

function numberOfActivePosts(){
    global $connection;
    $query = "SELECT * FROM  postss WHERE post_status='published'";
    if(!$select_post_comment_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_post_comment_query);
    return $count;
}

function numberOfPendingComments(){
    global $connection;
    $query = "SELECT * FROM  comments WHERE comment_status = 'unapproved'";
    if(!$select_comments_comment_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_comments_comment_query);
    return $count;
}

function numberOfConfirmComments(){
    global $connection;
    $query = "SELECT * FROM  comments WHERE comment_status = 'approved'";
    if(!$select_comments_comment_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_comments_comment_query);
    return $count;
}



?>
