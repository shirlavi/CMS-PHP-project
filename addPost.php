<?php global $connection;?>

<!-- Header -->
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>


<?php

if(ifLoggedIn()){
    $user_id = $_SESSION['userid'];
    $user_name = $_SESSION['username'];
    if(addPost())
        header("Location: index.php"); //refreshing;
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">


            <div id="page-wrapper">
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">

                            <h1 class="page-header">
                                Add Post
                                <small><?php echo $user_name?></small>
                            </h1>

                            <br>
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="title">Post Title</label>
                                    <input class="form-control" type="text" name="title"></input>
                                </div>

                                <div class="form-group">
                                    <label for="author">Post Author</label>
                                    <input class="form-control" type="text" id="readonlyInput" name="author" value="<?php echo $_SESSION['username']?>" readonly   ></input>
                                </div>

                                <div class="form-group">
                                    <label for="post_category_id">Post Category id</label>
                                    <!--        <input class="form-control" type="text" name="post_category_id"></input>-->
                                    <select name="post_category_id" id="post_category_id">
                                        <?php
                                        selectCat();
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="image">Post Image</label>
                                    <input type="file" name="image"></input>
                                </div>

                                <div class="form-group">
                                    <label for="post_tags">Post Tags</label>
                                    <input class="form-control" type="text" name="post_tags"></input>
                                </div>

                                <div class="form-group">
                                    <label for="post_content">Post Content</label>
                                    <textarea class="form-control" id="" name="post_content" cols="30" rows="10"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="post_status">Post Status</label>
                                    <!--        <input class="form-control" type="text" name="post_status"></input>-->
                                    <select name="post_status" id="">
                                        <option value="draft">Select Option</option>
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post"></input>
                                </div>

                            </form>







                        </div><!-- /.col-lg-12 -->
                    </div><!-- /.row -->

                </div> <!-- /.container-fluid -->
            </div> <!-- /#page-wrapper -->


        </div> <!-- /.col-md-8 -->
        <?php
            }
        ?>


        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div> <!-- /.row -->

    <!-- Footer -->
    <?php include "includes/footer.php"; ?>


