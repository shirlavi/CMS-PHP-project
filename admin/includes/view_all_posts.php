<?php global $connection;?>
<table class="table table-bordered">
    <h1>All Posts</h1>
    <br>
    <thead>
    <tr>
        <th>ID</th>
        <th>Category</th>
        <th>Title</th>
        <th>Author</th>
        <th>Date</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments count</th>
        <th>Status</th>
    </tr>
    </thead>

    <tbody>
    <?php
        creat_posts_table();
    ?>
    </tbody>
</table>

<?php
    deletePost();
?>