<?php global $connection;?>
<?php
if (isset($_GET['p_id'])) {
    $user_id = $_GET['p_id'];
    $query = "SELECT * FROM  users WHERE user_id = '{$user_id}'";
    if (!$select_users_by_id_query = mysqli_query($connection, $query))
        die("QUERY FAILED" . mysqli_error());

    while ($row = mysqli_fetch_assoc($select_users_by_id_query)) {
        $user_name = $row['user_name'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['image'];
        $user_role = $row['user_role'];;
        $randsalt = $row['randsalt'];;

        if(editUser($user_id, $user_name, $randsalt, $user_password))
            header("Location: users.php"); //refreshing
        ?>
        <h1>Edit User</h1>
        <br>
        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="user_name">Username</label>
                <input class="form-control" type="text" name="user_name" value="<?php echo $user_name; ?>"></input>
            </div>

            <div class="form-group">
                <label for="user_firstname">First Name</label>
                <input class="form-control" type="text" name="user_firstname" value="<?php echo $user_firstname; ?>"></input>
            </div>

            <div class="form-group">
                <label for="user_lastname">Last Name</label>
                <input class="form-control" type="text" name="user_lastname" value="<?php echo $user_lastname; ?>"></input>
            </div>

            <div class="form-group">
                <label for="user_password">Password</label>
                <input class="form-control" type="password" name="user_password" value="<?php echo $user_password; ?>"></input>
            </div>

            <div class="form-group">
                <label for="user_email">Email</label>
                <input class="form-control" type="email" name="user_email" value="<?php echo $user_email; ?>"></input>
            </div>

            <div class="form-group">
                <label for="user_role">Role</label>
                <!--        <input class="form-control" type="text" name="user_role"></input>-->
                <select name="user_role" id="post_category_id">
                    <option value="<?php echo $user_role; ?>"">Select Option</option>
                    <option value="admin">Admin</option>
                    <option value="subscriber">Subscriber</option>
                </select>
            </div>

            <div class="form-group">
                <label for="user_image">Image</label>
                <img src="../images/<?php echo $user_image; ?>" alt="" width="50">
                <input type="file" name="user_image""></input>
            </div>

            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User"></input>
            </div>

        </form>

        <?php
    }
}
?>



