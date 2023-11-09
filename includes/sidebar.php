<?php global $connection; ?>

<div class="col-md-4">

    <!-- Login -->
    <?php
        if(!ifLoggedIn()){
    ?>
            <div class="well">
                <h4>login</h4>
                <form action="includes/login.php" method="post" >
                    <div class="form-group">
                        <label for="username" >username</label>
                        <input name="username" type="text" class="form-control" placeholder="Enter Username">
                    </div >
                    <div class="form-group">
                        <label for="password">password</label>
                        <div class="input-group">
                            <input name="password" type="password" class="form-control" placeholder="Enter Password">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" name="login" type="submit">submit</button>
                            </span>
                        </div>
                    </div >
                </form>
            </div>
    <?php
        }
    ?>

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post" >
            <div class="input-group">
                <input name="search" type="text" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div> <!-- /.input-group -->
        </form>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">

            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    $query = "SELECT * FROM  categories";
                    $select_categories_sidebar_query = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_categories_sidebar_query)){
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        echo "<li><a href = 'category.php?category={$cat_id}'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div><!-- /.col-lg-6 -->

        </div><!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "includes/widget.php"; ?>

</div> <!-- /.col-md-4 -->