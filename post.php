<?php global $connection;?>

<!-- Header -->
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

           <!-- Post Form-->
            <?php
            if(isset($_GET['p_id'])){
                $post_id_to_show = $_GET['p_id'];
                $query = "SELECT * FROM  postss WHERE post_id = $post_id_to_show";
                $select_posts_query = mysqli_query($connection, $query);
    
                while($row = mysqli_fetch_assoc($select_posts_query)){
                    $post_title = $row['post_title'];
                    $post_author= $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['image'];
                    $post_content = $row['post_content'];
            ?>
                    <h1 class="page-header"> Posts <small>- Post view</small></h1>
                    <!-- First Blog Post -->
                    <h2> <a href = "#"> <?php echo "$post_title" ?> </a></h2>
                    <p class="lead"> by <a href="index.php"> <?php echo "$post_author" ?> </a></p>
                    <p> <span class="glyphicon glyphicon-time"></span> Posted on <?php echo "$post_date" ?></p>
                    <hr>
                    <img class="img-responsive" src="<?php echo "../images/$post_image" ?>" alt="" width='800'>
                    <hr>
                    <p> <?php echo "$post_content" ?> </p>
<!--                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>-->
                    <hr>
            <?php
                }
            ?>


            <!-- Blog Comments -->
            <?php
            if(isset($_POST['create_comment'])){
                if(ifLoggedIn()){
                    $comment_author = $_SESSION['username'];
                    $comment_email = $_SESSION['user_email'];
                    $comment_status = "approved";
                }
                else {
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_status = "unapproved";
                }
                $comment_content = $_POST['comment_content'];

                $query = "INSERT INTO comments";
                $query .="(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                $query .= "VALUES ($post_id_to_show, '{$comment_author}', '{$comment_email}', '{$comment_content}', '{$comment_status}', now())";

                if(!$queryCheck = mysqli_query($connection, $query))
                    die("QUERY FAILED". mysqli_error());

                //incriment_comment_count
                $query = "UPDATE postss SET post_comment_count = post_comment_count + 1 WHERE post_id = $post_id_to_show";
                if(!$queryCheckIncrease = mysqli_query($connection, $query))
                    die("QUERY FAILED". mysqli_error());
            }
            ?>



<!--            //Posted Comments//-->
            <?php
                $query = "SELECT * FROM  comments WHERE comment_post_id = $post_id_to_show AND comment_status = 'approved'";
                if(!$select_comments_query = mysqli_query($connection, $query))
                    die("QUERY FAILED". mysqli_error());

                while($row = mysqli_fetch_assoc($select_comments_query)){
                    //$comment_id = $row['comment_id'];
                    $comment_author = $row['comment_author'];
                    $comment_content = $row['comment_content'];
                    $comment_date = $row['comment_date'];

                    // Getting user image:
                    $query_image ="SELECT * FROM  users WHERE user_name = '{$comment_author}'";
                    if(!$select_query_image = mysqli_query($connection, $query_image))
                        die("QUERY FAILED". mysqli_error());
                    while($row = mysqli_fetch_assoc($select_query_image)){
                        $comment_image = $row['image'];
                    }
                    if(mysqli_num_rows($select_query_image)==0)
                        $comment_image = "empty.png"
                ?>
                <div class="media">
                    <a class="pull-left" href="#"> <img class="media-object" src="<?php echo "../images/$comment_image" ?>" alt="" width="64"> </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author." " ?><small><?php echo $comment_date ?></small> </h4>
                        <?php echo $comment_content ?>
                    </div>
                </div>
            <?php

                }
            }
            ?>

            <!-- Comments Form -->
            <br>
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" action="" method="post">
                    <?php
                         if(!ifLoggedIn()){
                     ?>
                        <div class="form-group">
                            <label for="Author"> Author</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" name="comment_email" class="form-control">
                        </div>
                    <?php
                         }
                     ?>

                    <div class="form-group">
                        <label for="Comment">Your Comment</label>
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>
            
        </div> <!-- /.col-md-8 -->

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div> <!-- /.row -->

<!-- Footer -->
<?php include "includes/footer.php"; ?>







