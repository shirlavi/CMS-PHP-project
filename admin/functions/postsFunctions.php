<?php

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

    function numberOfPosts(){
        global $connection;
        $query = "SELECT * FROM  postss";
        if(!$select_post_comment_query = mysqli_query($connection, $query))
            die("QUERY FAILED". mysqli_error());
        $count = mysqli_num_rows($select_post_comment_query);
        return $count;
    }