<?php add_new_category(); ?>



<p class="bg-info" ><?php display_message(); ?></p>    
<h1 class="page-header">
  Product Categories

</h1>

<div class="col-md-4">    
    <form action="" method="post">
    
        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" name="category_title" class="form-control" required>
        </div>

        <div class="form-group">           
            <input type="submit" name="add_category" class="btn btn-primary" value="Add Category">
        </div>      


    </form>


</div>


<div class="col-md-8">

    <table class="table">
            <thead>

        <tr>
            <th>id</th>
            <th>Title</th>
            <th>Products in category</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
            </thead>


    <tbody>
        <?php show_categories_in_admin(); ?>
    </tbody>

        </table>

</div>



                





