<?php

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

function numberOfComments(){
    global $connection;
    $query = "SELECT * FROM  comments";
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

function numberOfPendingComments(){
    global $connection;
    $query = "SELECT * FROM  comments WHERE comment_status = 'unapproved'";
    if(!$select_comments_comment_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_comments_comment_query);
    return $count;
}
