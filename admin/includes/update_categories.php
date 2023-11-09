<?php global $connection;?>

<br>

<!-- Edit category-->
<form action="" method="post">
    <div>
        <label for="cat-title">Edit Category</label>
        <?php
            if(isset($_GET['edit'])){
                $cat_id_to_edit = $_GET['edit'];
                $cat_title_to_edit = getCatByID($cat_id_to_edit)
        ?>

        <input value= "<?php if(isset($cat_title_to_edit)) echo $cat_title_to_edit; ?>" class="form-control" type="text" name="cat_title_edit"></input>

        <?php
                update_category($cat_id_to_edit, $cat_title_to_edit);
            }
        ?>
    </div>

    <div>
        <input class="btn btn-primary" type="submit" name="submit_edit" value="Edit Category"></input>
    </div>
</form> <!-- Edit category-->

