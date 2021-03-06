<?php add_product();?>


<div class="col-md-12">
<div class="row">
    <h1 class="page-header">
    Add Product
    </h1>
</div>
               

<form action="" method="post" enctype="multipart/form-data">

<!-- part1: main content-->
    <div class="col-md-8">

        <div class="form-group">
            <label for="product-title">Product Title </label>
            <input type="text" name="product_title" class="form-control">       
        </div>

        <div class="form-group">
            <label for="product-title">Product Short Description</label>
            <textarea name="product_short_desc" id="" cols="30" rows="2" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="product-title">Product Long Description</label>
            <textarea name="product_description" id="" cols="30" rows="10" class="form-control"></textarea>
        </div>

        <div class="form-group row">
            <div class="col-xs-3">
                <label for="product-price">Product Price</label>
                <input type="float" name="product_price" class="form-control" size="60">
            </div>           


        <!-- Product Quantity-->

            <div class="col-xs-3">
                <label for="product-title">Product Quantity</label>
                <input type="number" name="product_quantity" class="form-control" size="60">
            </div>
        </div>

    </div><!--col-md-8: main content-->


<!-- part 2: SIDEBAR-->

    <aside id="admin_sidebar" class="col-md-4">
        <div class="form-group">
            <input type="submit" name="draft" class="btn btn-warning" value="Draft">
            <input type="submit" name="publish" class="btn btn-primary" value="Publish">
        </div>

        <!-- Product Categories-->
        <div class="form-group">
            <label for="product-title">Product Category</label>
           
            <select name="product_category_id" id="" class="form-control">
                <option value="">Select Category</option>
                <?php list_category();  ?>        
            </select>
        </div>



        <!-- Product Brands-->
<!--
        <div class="form-group">
            <label for="product-title">Product Brand</label>
            <select name="product_brand" id="" class="form-control">
                <option value="">Luxury</option>
            </select>
        </div>
-->

    <!-- Product Tags -->
<!--
        <div class="form-group">
            <label for="product-title">Product Keywords</label>    
            <input type="text" name="product_tags" class="form-control">
        </div>
-->

        <!-- Product Image -->
        <div class="form-group">
            <label for="product-title">Product Image</label>
            <input type="file" name="file">       
        </div>


    </aside><!--SIDEBAR-->
    
</form>

      