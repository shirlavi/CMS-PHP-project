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

            <?php
            if(isset($_POST['submit'])){
                $search = $_POST['search'];
                $query = "SELECT * FROM postss WHERE post_tags LIKE '%$search%'";
                if ( ! $search_query = mysqli_query($connection, $query)){
                    die("Query search failed" . mysqli_error());
                }
                else
                {
                    $count = mysqli_num_rows($search_query);
                    if ($count == 0)
                        echo  "No result.";

                    while($row = mysqli_fetch_assoc($search_query)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author= $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['image'];
                        $post_content = $row['post_content'];
                        $post_content = substr($row['post_content'], 0 , 100);
            ?>

                        <h1 class="page-header"> Posts <small>- All posts</small></h1>
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
                }
            }
            ?>
        </div> <!-- /.col-md-8 -->




        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div> <!-- /.row -->

<!-- Footer -->
<?php include "includes/footer.php"; ?>



