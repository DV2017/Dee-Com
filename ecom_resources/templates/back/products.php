
<div class="row">
<h4 class="bg-info"><?php display_message(); ?></h4>
<h1 class="page-header">
   All Products

</h1>
<table class="table table-hover">


    <thead>

      <tr>
           <th>Id</th>
           <th>Title</th>
           <th>Product Image</th>
           <th>Category</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Delete</th>
           <th>Edit</th>
      </tr>
    </thead>
    <tbody>
    <?php show_products_in_admin(); ?>
    </tbody>
</table>



             </div>
