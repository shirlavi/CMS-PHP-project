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
                <h1 class="page-header"> Posts <small>- All posts</small></h1>

                <?php
                    $query = "SELECT * FROM  postss where post_status = 'published'";
                    $select_posts_query = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_posts_query)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author= $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['image'];
                        $post_content = substr($row['post_content'], 0 , 100);
                ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo "$post_title" ?> </a>
                </h2>
                <p class="lead"> by <a href="index.php"> <?php echo "$post_author" ?> </a></p>
                <p> <span class="glyphicon glyphicon-time"></span> Posted on <?php echo "$post_date" ?></p>
                <hr>
                <img class="img-responsive" src="<?php echo "../images/$post_image" ?>" alt="" width='800'>
                <hr>
                <p> <?php echo "$post_content" ?> </p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
                        
                <?php
                    }
                ?>
                
            </div> <!-- /.col-md-8 -->


            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>
            
        </div> <!-- /.row -->
        
<!-- Footer -->
<?php include "includes/footer.php"; ?>


