<?php global $connection; ?>


<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">

    <?php
    if(ifLoggedIn()){
    ?>
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['firstname']; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li> <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a> </li>
                    <li class="divider"></li>
                    <li> <a href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a> </li>
                </ul>
            </li>
        </ul>
    <?php
    }
    ?>


        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS Site</a>
        </div>
        
        
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                    $query = "SELECT * FROM  categories";
                    $select_categories_query = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_assoc($select_categories_query)){
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        echo "<li><a href = 'category.php?category={$cat_id}'>{$cat_title}</a></li>";
                    }


                if(ifAdminLoggedIn()){
                ?>
                        <li> <a href = 'admin/index.php'> Admin </a> </li>";
                <?php
                }
                else if(!ifLoggedIn()){
                ?>
                    <li> <a href = 'register.php'> Register </a> </li>";
                <?php
                }
                ?>

            </ul>
        </div> <!-- /.navbar-collapse -->
        
        
    </div> <!-- /.container -->
</nav>
