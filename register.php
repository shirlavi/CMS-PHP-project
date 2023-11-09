<?php global $connection;?>

<!-- Header -->
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>


<?php
    addUser();
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">


            <h1>Add User</h1>
            <br>
            <form action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="user_name">Username</label>
                    <input class="form-control" type="text" name="user_name"></input>
                </div>

                <div class="form-group">
                    <label for="user_firstname">First Name</label>
                    <input class="form-control" type="text" name="user_firstname"></input>
                </div>

                <div class="form-group">
                    <label for="user_lastname">Last Name</label>
                    <input class="form-control" type="text" name="user_lastname"></input>
                </div>

                <div class="form-group">
                    <label for="user_password">Password</label>
                    <input class="form-control" type="password" name="user_password"></input>
                </div>

                <div class="form-group">
                    <label for="user_email">Email</label>
                    <input class="form-control" type="email" name="user_email"></input>
                </div>

                <div class="form-group">
                    <label for="user_role">Role</label>
                    <!--        <input class="form-control" type="text" name="user_role"></input>-->
                    <select name="user_role" id="">
                        <option value="subscriber">Select Option</option>
                        <option value="admin">admin</option>
                        <option value="subscriber">subscriber</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_image">Image</label>
                    <input type="file" name="user_image"></input>
                </div>

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="create_user" value="Register"></input>
                </div>

            </form>


        </div> <!-- /.col-md-8 -->


        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div> <!-- /.row -->

    <!-- Footer -->
    <?php include "includes/footer.php"; ?>


