<?php global $connection;?>
    <table class="table table-bordered">
        <h1>All Users</h1>
        <br>
        <thead>
        <tr>
            <th>User ID</th>
            <th>Username</th>
<!--            <th>user_password</th>-->
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Role</th>
<!--            <th>randsalt</th>-->
        </tr>
        </thead>

        <tbody>
        <?php
        $query = "SELECT * FROM  users";
        if(!$select_users_query = mysqli_query($connection, $query))
            die("QUERY FAILED". mysqli_error());

        while($row = mysqli_fetch_assoc($select_users_query)){
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image= $row['image'];
            $user_role = $row['user_role'];
            $randsalt = $row['randsalt'];

            echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td>$user_name</td>";
            //echo "<td>$user_password</td>";
            echo "<td>$user_firstname</td>";
            echo "<td>$user_lastname</td>";
            echo "<td>$user_email</td>";
            echo "<td> <img src='../images/$user_image' alt='image' width='300'> </td>";
            echo "<td>$user_role</td>";
            //echo "<td>$randsalt</td>";
            echo "<td><a href='users.php?source=edit_user&p_id={$user_id}'>Edit</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "<tr>";
        }
        ?>
        </tbody>
    </table>

<?php

if(isset($_GET['delete'])){
    $user_id_to_delete = $_GET['delete'];
    $query_delete_user = "DELETE FROM users WHERE user_id = '{$user_id_to_delete}'";
    if (!mysqli_query($connection, $query_delete_user))
        die("QUERY FAILED". mysqli_error());
    header("Location: users.php"); //refreshing the page
}
?>