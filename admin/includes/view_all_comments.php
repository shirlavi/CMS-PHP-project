<?php global $connection;?>
    <table class="table table-bordered">
        <h1>All Comments</h1>
        <br>
        <thead>
        <tr>
            <th>ID</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>unApproved</th>
        </tr>
        </thead>

        <tbody>
        <?php
        createCommentsTable();
        ?>
        </tbody>
    </table>

<?php

deleteComment();
approveComment();
unapproveComment();



?>