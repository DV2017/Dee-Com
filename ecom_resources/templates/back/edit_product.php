<?php update_product();?>
<?php 
//display product information in form values
//get product id from url
if(isset($_GET['id'])){

    $product_id = escape_string($_GET['id']);

    $query_product = query("SELECT * FROM products WHERE product_id = '{$product_id}' ");
    confirm($query_product);

    while($row = fetch_array($query_product)){

        $product_title          = escape_string($row['product_title']);
        $product_category_id    = escape_string($row['product_category_id']);
        $product_price          = escape_string($row['product_price']);
        $product_quantity       = escape_string($row['product_quantity']);
        $product_description    = escape_string($row['product_description']);
        $product_short_desc     = escape_string($row['product_short_desc']);
        
        $product_image          = escape_string($row['product_image']);
        //function to attach folder to image name
        $product_image          = set_image_directory(escape_string($row['product_image']));
        //now, continue to add these variables to the form 

    }

}

?>

<p class="bg-info"><?php echo display_message();?></p>
<div class="col-md-12">
<div class="row">
    <h1 class="page-header">
    Edit Product
    </h1>
</div>
               

<form action="" method="post" enctype="multipart/form-data">

<!-- part1: main content-->
    <div class="col-md-8">

        <div class="form-group">
            <label for="product-title">Product Title </label>
            <input type="text" name="product_title" class="form-control" value="<?php echo $product_title;?>">       
        </div>

        <div class="form-group">
            <label for="product-title">Product Short Description</label>
            <textarea name="product_short_desc" id="" cols="30" rows="2" class="form-control"><?php echo $product_short_desc;?></textarea>
        </div>

        <div class="form-group">
            <label for="product-title">Product Long Description</label>
            <textarea name="product_description" id="" cols="30" rows="10" class="form-control"><?php echo $product_description;?></textarea>
        </div>

        <div class="form-group row">
            <div class="col-xs-3">
                <label for="product-price">Product Price</label>
                <input type="float" name="product_price" class="form-control" size="60" value="<?php echo $product_price;?>">
            </div>           


        <!-- Product Quantity-->

            <div class="col-xs-3">
                <label for="product-title">Product Quantity</label>
                <input type="number" name="product_quantity" class="form-control" size="60" value="<?php echo $product_quantity;?>">
            </div>
        </div>

    </div><!--col-md-8: main content-->


<!-- part 2: SIDEBAR-->

    <aside id="admin_sidebar" class="col-md-4">

        <div class="form-group">
            <input type="submit" name="draft" class="btn btn-warning" value="Draft">
            <input type="submit" name="update" class="btn btn-primary" value="Update">
        </div>

        <!-- Product Categories-->
        <div class="form-group">
            <label for="product-title">Product Category</label>
           
            <select name="product_category_id" id="" class="form-control">
                <option value="<?php echo $product_category_id; ?>"><?php echo get_category_name($product_category_id); ?></option>
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
            <br>  
            <img width="300" src="../../ecom_resources/<?php echo $product_image;?>" alt="">     
        </div>


    </aside><!--SIDEBAR-->
    
</form>

      