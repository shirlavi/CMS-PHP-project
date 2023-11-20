<?php

function add_category(){
    global $connection;
    if(isset($_POST['submit'])){
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title))
            echo "This field should not be empty";
        elseif(ifCatExist($cat_title))
            echo "This category is already exist";
        else {
            $add_category_query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
            if (!mysqli_query($connection, $add_category_query))
                die("QUERY ADD CATEGORY FAILED". mysqli_error());
        }
    }
}

function creat_cat_table(){
    global $connection;
    $query = "SELECT * FROM  categories";
    if(!$select_categories_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());

    while($row = mysqli_fetch_assoc($select_categories_query)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>  {$cat_id}  </td>";
        echo "<td>  {$cat_title}  </td>";
        echo "<td> <a href='categories.php?delete={$cat_id}'> Delete </a> </td>";
        echo "<td> <a href='categories.php?edit={$cat_id}'> Edit </a> </td>";
        echo "</tr>";
    }
}

function delete_category(){
    global $connection;
    if(isset($_GET['delete'])){
        $cat_id_to_delete = $_GET['delete'];
        $query_delete_category = "DELETE FROM categories WHERE cat_id = $cat_id_to_delete";
        if (!mysqli_query($connection, $query_delete_category))
            die("QUERY FAILED". mysqli_error());
        header("Location: categories.php"); //refreshing the page
    }
}

function selectCat($post_category_id = 3){
    global $connection;
    $query = "SELECT * FROM  categories";
    if(!$select_categories_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());

    echo "<option value='{$post_category_id}'>Select Option</option>";
    while($row = mysqli_fetch_assoc($select_categories_query)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<option value='{$cat_id}'>{$cat_title}</option>";
    }
}

function update_category($cat_id_to_edit, $cat_title_to_edit_before){
    global $connection;
    if(isset($_POST['submit_edit'])){
        $cat_title_edited = $_POST['cat_title_edit'];
        if($cat_title_edited == "" || empty($cat_title_edited))
            echo "This field should not be empty";
        elseif($cat_title_to_edit_before != $cat_title_edited && ifCatExist($cat_title_edited))
            echo "This category is already exist";
        else {
            $edit_category_query = "UPDATE categories SET cat_title= '{$cat_title_edited}' WHERE cat_id = $cat_id_to_edit";
            if (!mysqli_query($connection, $edit_category_query))
                die("QUERY EDIT CATEGORY FAILED". mysqli_error());
            else
                header("Location: categories.php"); //refreshing
        }
    }
}
function getCatByID($cat_id){
    global $connection;
    $query_select_category = "SELECT * FROM categories WHERE cat_id = $cat_id";
    $query_select_category_result = mysqli_query($connection, $query_select_category);
    if (!$query_select_category_result)
        die("QUERY FAILED". mysqli_error());
    else{
        while($row = mysqli_fetch_assoc($query_select_category_result)){
            $cat_title_to_edit = $row['cat_title'];
        }
        return $cat_title_to_edit;
    }
    return null;
}

function ifCatExist($cat_title){
    global $connection;
    $query_select_cat = "SELECT * FROM categories WHERE cat_title = '{$cat_title}'";
    $query_select_cat_result = mysqli_query($connection, $query_select_cat);
    if (mysqli_num_rows($query_select_cat_result)>0)
        return true;
    return false;
}

function numberOfCats(){
    global $connection;
    $query = "SELECT * FROM  categories";
    if(!$select_cats_comment_query = mysqli_query($connection, $query))
        die("QUERY FAILED". mysqli_error());
    $count = mysqli_num_rows($select_cats_comment_query);
    return $count;
}

