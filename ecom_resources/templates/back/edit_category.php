        
<?php
 update_category();
?>

<?php
//get id from url of category to edit
if(isset($_GET['id'])){
    $cat_id = escape_string($_GET['id']);

    $query_cat = query("SELECT cat_title FROM categories WHERE cat_id='{$cat_id}' ");
    confirm($query_cat);

    while($row=fetch_array($query_cat)){
        $cat_title = escape_string($row['cat_title']);
    }
}
?>

<p class="bg-info" ><?php display_message(); ?></p>    
<h1 class="page-header">
  Edit Product Category

</h1>

<div class="col-md-4">    
    <form action="" method="post">
    
        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" name="category_title" class="form-control" value="<?php echo $cat_title;?>">
        </div>

        <div class="form-group">           
            <input type="submit" name="update_category" class="btn btn-primary" value="Update Category">
        </div>      
    </form>
</div>

<div class="col-md-8">
    <table class="table">
            <thead>
        <tr>
            <th>id</th>
            <th>Title</th>
        </tr>
            </thead>
    <tbody>
        <tr>
            <td><?php echo $cat_id;?></td>
            <td><?php echo $cat_title;?></td>
        </tr>
    </tbody>
        </table>
</div>