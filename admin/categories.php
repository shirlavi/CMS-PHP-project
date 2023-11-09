<?php global $connection;?>


<!-- Header -->
<?php include "includes/admin_header.php"; ?>


<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">
                        Welcome to Admin
                        <small><?php echo $_SESSION['username']?></small>
                    </h1>


                    <div class="col-xs-6">

                        <!-- Add category-->
                        <form action="" method="post">
                            <div>
                                <label for="cat-title">Add Category</label>
                                <?php
                                    add_category();
                                ?>
                                <input class="form-control" type="text" name="cat_title"></input>
                            </div>
                            <div>
                                <input class="btn btn-primary" type="submit" name="submit" value="Add Category"></input>
                            </div>
                        </form><!-- Add category-->

                        <!-- Add category-->
                        <?php
                            if(isset($_GET['edit'])) {
                                include "includes/update_categories.php";
                            }
                        ?>

                    </div> <!-- col-xs-6-->


                    <div class="col-xs-6">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Title</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <?php
                                        creat_cat_table();

                                        delete_category();
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- col-xs-6-->

                </div> <!-- col-lg-12-->
            </div><!-- /.row -->

        </div> <!-- /.container-fluid -->
    </div> <!-- /#page-wrapper -->


    <?php include "includes/admin_footer.php"; ?>

