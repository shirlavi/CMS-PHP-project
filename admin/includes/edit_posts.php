<?php global $connection;?>
<?php
    if (isset($_GET['p_id'])) {
        $post_id_to_edit = $_GET['p_id'];
        $query = "SELECT * FROM  postss WHERE post_id = '{$post_id_to_edit}'";
        if (!$select_posts_by_id_query = mysqli_query($connection, $query))
            die("QUERY FAILED" . mysqli_error());

        while ($row = mysqli_fetch_assoc($select_posts_by_id_query)) {
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];
            $post_content = $row['post_content'];

            editPost($post_id_to_edit);
?>
<h1>Edit Post</h1>
<br>
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input class="form-control" type="text" name="title" value="<?php echo $post_title; ?>" ></input>
    </div>

    <div class="form-group">
        <label for="author">Post Author</label>
        <input class="form-control" type="text" name="author" value="<?php echo $post_author; ?>"></input>
    </div>

    <div class="form-group">
        <label for="post_category_id">Post Category id</label>
<!--        <input class="form-control" type="text" name="post_category_id" value="--><?php //echo $post_category_id; ?><!--"></input>-->
        <select name="post_category_id" id="post_category_id">
            <?php
                selectCat($post_category_id);
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label><br>
        <img src="../images/<?php echo $post_image; ?>" alt="" width="100">
        <input type="file" name="image"></input>
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input class="form-control" type="text" name="post_tags" value="<?php echo $post_tags; ?>"></input>
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" id="" name="post_content" cols="30" rows="10" > <?php echo $post_content;?> </textarea>
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
<!--        <input class="form-control" type="text" name="post_status" value="--><?php //echo $post_status; ?><!--"></input>-->
        <select name="post_status" id="">
            <option value="<?php echo $post_status; ?>">Select Option</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_post" value="Edit post"></input>
    </div>

</form>

<?php
        }
    }
?>



