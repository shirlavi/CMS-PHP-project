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
            createUsersTable();
        ?>
        </tbody>
    </table>

<?php
    deleteUser();
?>