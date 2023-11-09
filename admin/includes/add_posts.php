<?php global $connection;?>

<?php
  addPost();
?>
<h1>Add Post</h1>
<br>
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input class="form-control" type="text" name="title"></input>
    </div>

    <div class="form-group">
        <label for="author">Post Author</label>
        <input class="form-control" type="text" name="author"></input>
    </div>

    <div class="form-group">
        <label for="post_category_id">Post Category id</label>
<!--        <input class="form-control" type="text" name="post_category_id"></input>-->
        <select name="post_category_id" id="post_category_id">
            <?php
                selectCat();
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" name="image"></input>
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input class="form-control" type="text" name="post_tags"></input>
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" id="" name="post_content" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
<!--        <input class="form-control" type="text" name="post_status"></input>-->
        <select name="post_status" id="">
            <option value="draft">Select Option</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post"></input>
    </div>

</form>
