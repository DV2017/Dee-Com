<?php

//show all errors; this needs to be deleted while production
ini_set("display_errors", 1);
error_reporting(E_ALL);

//setting some global variables
    //image directory variable
$upload_directory = "uploads";



//creating helper functions for repeated codes

//function for any message. sent to sessions variable for use anywhere in the website
function set_message($message){
    if(!empty($message)){
        $_SESSION['message']=$message;
    }else{
        $message = "";
    }
}

function display_message(){
    if(isset($_SESSION['message'])):
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    endif;
}

function redirect($location) {
    header("Location: $location");
}

function query($sql) {
    global $con;
    return mysqli_query($con, $sql);
}

function confirm($query) {
    global $con;
    if(!$query){
        die("QUERY FAILED: ". mysqli_error($con));
    }
}

function fetch_array($result){
    return mysqli_fetch_array($result);
}

function escape_string($string) {
    global $con;
    return mysqli_real_escape_string($con, $string);
}

function last_id(){
    global $con;
    return mysqli_insert_id($con);
}

/*================FRONT END FUNCTIONS ===================*/

//GET PRODUCTS
function get_products(){
$product="";
$page;
$query_start_row;

$query = query("SELECT * FROM products");
confirm($query);

//pagination - before the while loop
//1. get number of rows - each row is a product
$rows_products = mysqli_num_rows($query);

//2. see if page is set in $_GET; if not set show first page
if(isset($_GET['page'])){
    //replace all non-numbers with empty strings.
    $page = preg_replace("#[^0-9]#", "", $_GET['page'] );
} else {
    $page = 1;
}

//how many products per page?
$products_per_page = 5;
$last_page = ceil($rows_products / $products_per_page);

//check for 1st and last pages
//if url data is more than last page or less than 1, variables are set.
//this ensures correct add and sub.
if($page < 1) $page = 1;
if($page > $last_page) $page = $last_page;

//getting tha pagination indicators at bottom of page
$middleNumbers = "";
$add1 = $page + 1;
$add2 = $page + 2;
$sub1 = $page - 1;
$sub2 = $page - 2;

if($page == 1){
    //inserting bootstrap pagination : https://getbootstrap.com/docs/4.1/components/pagination/
    //getting the html for the middle numbers
    $middleNumbers .= '<li class="page-item active"><a>'.$page.'</a></li>';
    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">'.$add1.'</a></li>';
    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">NEXT</a></li>';
}elseif($page == $last_page){
    //eg: 10, then prev, --2,--1, lastpage
    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">PREV</a></li>';
    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">'.$sub1.'</a></li>';
    $middleNumbers .= '<li class="page-item active"><a>'.$last_page.'</a></li>';   
}elseif($page > 2 || $page < ($last_page -1)){
    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">PREV</a></li>';
    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">'.$sub1.'</a></li>';
    $middleNumbers .= '<li class="page-item active"><a>'.$page.'</a></li>';
    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">'.$add1.'</a></li>';
    $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">NEXT</a></li>';
}


//getting starting row for query from database
//starting row follows logic of getting page -1 multiplied by number of products per page
$query_start_row = ($page-1) * $products_per_page;

$query_page = query("SELECT * FROM products LIMIT $query_start_row, $products_per_page ");
confirm($query_page);

    while($row = fetch_array($query_page)){
        
        $product_image = set_image_directory($row['product_image']);
        if($row['product_quantity']!=0 ){

    //use of heredoc. note: heredocs shall not be indented; no space after the 1st.       
        $product = <<<DELIMITER

            <div class="col-sm-4 col-lg-4 col-md-4">
                <div class="thumbnail">  
                    <div>Id: {$row['product_id']}</div>                 
                    <a target="_blank" href="item.php?id={$row['product_id']}"><img class="image_50" src="../ecom_resources/{$product_image}" alt=""></a>
                    <div class="caption">
                        <h4 class="pull-right">&euro;{$row['product_price']}</h4>
                        <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                        </h4>
                        <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                        <a class="btn btn-primary" target="_blank" href="../ecom_resources/cart.php?add={$row['product_id']}">Add to cart</a>
                    </div>
                </div>
            </div>

DELIMITER;
        echo $product;
        } //end if row    
    }//end while
    echo "<div class='col-sm-12'><ul class='pagination'>{$middleNumbers}</ul></div>"; 
} //end function


//GET categories
function get_categories(){
$category="";

$query = query("SELECT * FROM categories");
confirm($query);
while($row = fetch_array($query)){
$category = <<<CATEGORY
    <a href="category.php?id={$row['cat_id']}" class="list-group-item">{$row['cat_title']}</a>
CATEGORY;
echo $category;
}

}

//GET products in category
function get_category_products(){
    $cat_product="";
if(isset($_GET['id'])){
$category_id = escape_string($_GET['id']);
}
$query = query("SELECT * FROM products WHERE product_category_id='$category_id' ");
confirm($query);

while($row=fetch_array($query)):
if($row['product_quantity']!=0 ):
$product_image = set_image_directory($row['product_image']);

$cat_product = <<<PRODUCT
<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
    <!--image size is 800x500-->
        <img class="image_50" src="../ecom_resources/{$product_image}" alt="">
        <div class="caption">
            <h3>{$row['product_title']}</h3>
            <p>{$row['product_short_desc']}</p>
            <p>
                <a href="../ecom_resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Add to cart</a> 
                <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
            </p>
        </div>
    </div>
</div>
PRODUCT;
echo $cat_product;
endif;
endwhile;

}

//GET all products in shop.php
function get_products_in_shop(){
$product="";

$query = query("SELECT * FROM products");
confirm($query);

while($row=fetch_array($query)):
if($row['product_quantity']!=0 ):
$product_image = set_image_directory($row['product_image']);

$product = <<<SHOP
<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
    <!--image size is 800x500-->
        <img class="image_50" src="../ecom_resources/{$product_image}" alt="">
        <div class="caption">
            <h3>{$row['product_title']}</h3>
            <p>{$row['product_short_desc']}</p>
            <p>
                <a href="../ecom_resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Add to cart</a> 
                <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
            </p>
        </div>
    </div>
</div>
SHOP;
echo $product;
endif;
endwhile;
}

//user login function
function login_user(){
    if(isset($_POST['submit'])){
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = query("SELECT * FROM users WHERE username='$username' AND password='$password' ");
        confirm($query);
        if(mysqli_num_rows($query) == 0){
            set_message("Username or password entered is invalid.");
            redirect("login.php");
        }else{
            $_SESSION['username'] = $username;
            redirect("admin");
        }
    }
}

// contact form
function send_message_email(){
    if(isset($_POST['submit'])){

        $toEmailAdmin = "admin@ecom.com";
        $from_name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $headers = "From: {$from_name} {$email}";
        $mail_send_result = mail($toEmailAdmin, $subject, $message, $headers);

        if(!$mail_send_result) {
            set_message("Message send error");
            //reopens the page after message sent
            redirect("contact.php");          
        }else{
            set_message("Your message is sent.");
            redirect("contact.php"); 
        }
    }
}

/*================BACK END FUNCTIONS ===================*/

function set_image_directory($picture){

    global $upload_directory;
    return $upload_directory . DS . $picture;

}


//DISPLAY all orders 
function show_orders_in_admin(){
    $orders = "";

    $query = query("SELECT * FROM orders");
    confirm($query);

    while($row=fetch_array($query)){
        
        $orders = <<<DELIMITER

        <tr>
            <td>{$row['order_id']}</td>
            <td>{$row['order_transaction']}</td>
            <td>{$row['order_amount']}</td>
            <td>{$row['order_currency']}</td>
            <td>{$row['order_status']}</td>
            <td><a class="btn btn-danger" href="index.php?delete_order_id={$row['order_id']}"><span class="glyphicon glyphicon-remove" aria-hidden="true""></span</a></td>
        </tr>

DELIMITER;
    echo $orders;
    }
}

//DISPLAY all reports
function show_reports_in_admin(){
    $report = "";

    $query = query("SELECT * FROM reports");
    confirm($query);

    while($row=fetch_array($query)){
        
        $report = <<<DELIMITER

        <tr>
            <td>{$row['order_id']}</td>
            <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="index.php?delete_report_id={$row['report_id']}"><span class="glyphicon glyphicon-remove" aria-hidden="true""></span</a></td>
        </tr>

DELIMITER;
    echo $report;
    }
}

//display products in product.php in admin
function show_products_in_admin(){
    $product="";

    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)){
        //call category function for each category id in products table
        $category_title = get_category_name($row['product_category_id']);
        //calling function to set directory of image
        $product_image = set_image_directory($row['product_image']);

        //use of heredoc. note: heredocs shall not be indented; no space after the 1st.       
        $product = <<<DELIMITER

        <tr>
        <td>{$row['product_id']}</td>
        <td>{$row['product_title']}</td>
        <td><img width='100' src="../../ecom_resources/{$product_image}" alt=""></a></td>
        <td>{$category_title}</td>
        <td>{$row['product_price']}</td>
        <td>{$row['product_quantity']}</td>
        <td><a class="btn btn-danger" href="index.php?delete_product_id={$row['product_id']}"><span class="glyphicon glyphicon-remove" aria-hidden="true""></span</a></td>
        <td><a class="btn btn-warning" href="index.php?edit_product&id={$row['product_id']}"><span class="glyphicon glyphicon-pencil" aria-hidden="true""></span</a>
        </td>
        </tr>

DELIMITER;
        echo $product;
        }
}

//function to extract category name from categories table 
//in function above and for display in product.php in admin
function get_category_name($category_id){
    $query_category = query("SELECT * FROM categories WHERE cat_id='$category_id' ");
    confirm($query_category);

    while($row = fetch_array($query_category)){
        return $row['cat_title'];
    }
}


//Add products to database 

function add_product(){

    if(isset($_POST['publish'])){

        $product_title          = escape_string($_POST['product_title']);
        $product_category_id    = escape_string($_POST['product_category_id']);
        $product_price          = escape_string($_POST['product_price']);
        $product_quantity       = escape_string($_POST['product_quantity']);
        $product_description    = escape_string($_POST['product_description']);
        $product_short_desc     = escape_string($_POST['product_short_desc']);
        
        //gets file name being uploaded and uses a temp location
        $product_image          = escape_string($_FILES['file']['name']);
        $image_temp_location    = escape_string($_FILES['file']['tmp_name']);

        //move from tmp location to your folder of choice
        //this folder path is defined in config as a constant
        //remember to change folder permissions to write 
        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

        //store data in database after uploading for later retrieval.
        $query = query("INSERT INTO products(product_title, product_category_id, product_price, product_quantity, product_description, product_short_desc, product_image) VALUES('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_quantity}', '{$product_description}', '{$product_short_desc}', '{$product_image}' ) ");
        confirm($query);

        set_message("Product added successfully.");

        redirect("index.php?products");

    }
}

//function to list categories in add_product.php page
function list_category(){
    $cat_list="";
    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)){

        $cat_list = <<<DELIMITER

        <option value="{$row['cat_id']}">{$row['cat_title']}</option>

DELIMITER;
        echo $cat_list;
    }

}


//GET all categories in categories page
function show_categories_in_admin(){
    $categories="";

    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)){

        //count products in each category
        $cat_id = $row['cat_id'];
        $x=0;
        $query_products = query("SELECT product_id FROM products WHERE product_category_id='{$cat_id}' ");
        confirm($query_products);
        while($id_row = fetch_array($query_products)){
            $x++;
        }

        $categories = <<<DELIMITER

        <tr>
            <td>{$row['cat_id']}</td>
            <td>{$row['cat_title']}</td>
            <td>{$x}</td>
            <td>
            <a class="btn btn-danger" href="index.php?delete_category_id={$row['cat_id']}"><span class="glyphicon glyphicon-remove" aria-hidden="true""></span</a></td>
            <td><a class="btn btn-warning" href="index.php?edit_category&id={$row['cat_id']}"><span class="glyphicon glyphicon-pencil" aria-hidden="true""></span</a>
            </td>
        </tr>

DELIMITER;
        echo $categories;
    }
}

//UPDATE existing category
function update_category(){

    if(isset($_POST['update_category'])){

        $cat_title = escape_string($_POST['category_title']);
        $cat_id = escape_string($_GET['id']);
    
        $query_update = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id='{$cat_id}' ";
        $query_updated = query($query_update);
        confirm($query_updated);

        set_message("Category updated."); 
    }
}


//UPDATE existing product
function update_product(){

    if(isset($_POST['update'])){

        //store form variables into local properties
        $product_title          = escape_string($_POST['product_title']);
        $product_category_id    = escape_string($_POST['product_category_id']);
        $product_price          = escape_string($_POST['product_price']);
        $product_quantity       = escape_string($_POST['product_quantity']);
        $product_description    = escape_string($_POST['product_description']);
        $product_short_desc     = escape_string($_POST['product_short_desc']);
        
        //gets file name being uploaded and uses a temp location
        $product_image          = escape_string($_FILES['file']['name']);
        $image_temp_location    = escape_string($_FILES['file']['tmp_name']);

        //update shows empty file by default for product pic
        //retrieve this from db
        if(empty($product_image)){

            $query_pic = query("SELECT product_image FROM products WHERE product_id =" .escape_string($_GET['id']). " ");
            confirm($query_pic);

            while($pic = fetch_array($query_pic)){
                $product_image = escape_string($pic['product_image']);
            }
        }
        //move from tmp location to your folder of choice
        //this folder path is defined in config as a constant
        //remember to change folder permissions to write 
        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

        //update data in database after uploading for later retrieval.
        $query  = "UPDATE products SET ";
        $query .= "product_title       = '{$product_title}',        ";
        $query .= "product_category_id = '{$product_category_id}',  ";
        $query .= "product_price       = '{$product_price}',        ";
        $query .= "product_quantity    = '{$product_quantity}',     ";
        $query .= "product_description = '{$product_description}',  ";
        $query .= "product_short_desc  = '{$product_short_desc}',   ";
        $query .= "product_image       = '{$product_image}'         ";
        $query .= "WHERE product_id = ".escape_string($_GET['id']);
        
        $query_update = query($query);
        confirm($query_update);

        set_message("Product details updated successfully in database.");

        redirect("index.php?products");

    }
}


//add categories in admin
function add_new_category(){

    if( isset($_POST['add_category'])){

        $cat_title = escape_string($_POST['category_title']);
        
        if(empty($cat_title) || $cat_title == " "){
            set_message("This field cannot be empty");
        } else {
            $query_add_category = query("INSERT INTO categories (cat_title) VALUES('$cat_title') ");
            confirm($query_add_category);

            set_message("New category created.");
        }
    } 
    
}


//GET all users to admin index
function show_users_in_admin(){
    $user="";

    $query = query("SELECT * FROM users");
    confirm($query);

    while($row = fetch_array($query)){

        $user = <<<DELIMITER

        <tr>
        <td>{$row['user_id']}</td>
        <td><img width="50" class="admin-user-thumbnail user_image" src="../../ecom_resources/uploads/{$row['user_image']}" alt=""></td>                   
        <td>{$row['firstname']} {$row['lastname']}</td> 
        <td>{$row['username']}</td>                   
        <td>{$row['email']}</td>
        <td><a class="btn btn-danger" href="index.php?delete_user_id={$row['user_id']}"><span class="glyphicon glyphicon-remove" aria-hidden="true""></span</a></td>
        <td><a class="btn btn-warning" href="index.php?edit_user&id={$row['user_id']}"><span class="glyphicon glyphicon-pencil" aria-hidden="true""></span</a></td>
        </tr>

DELIMITER;
        echo $user;
    }
}


//ADD new user
function add_new_user(){

    if( isset($_POST['add_user'])){

        //POST picks the name="" field in form 
        $firstname  = ucfirst(escape_string($_POST['firstname']));
        $lastname   = ucfirst(escape_string($_POST['lastname']));
        $username   = escape_string($_POST['username']);
        $email      = escape_string($_POST['email']);
        $password   = escape_string($_POST['password']);  
        
        $user_image             = escape_string($_FILES['file']['name']);
        $image_temp_location    = escape_string($_FILES['file']['tmp_name']);

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS. $user_image);

        $query_add_user = query("INSERT INTO users (firstname, lastname, username, password, email, user_image) VALUES('{$firstname}', '{$lastname}', '{$username}', '{$password}', '{$email}', '{$user_image}' ) ");
        confirm($query_add_user);

        redirect("index.php?users");

    }    
}


//UPDATE user
function update_user(){

    if( isset($_POST['update_user'])){
        $user_id = escape_string($_GET['id']);
        //POST picks the name="" field in form 
        $firstname  = ucfirst(escape_string($_POST['firstname']));
        $lastname   = ucfirst(escape_string($_POST['lastname']));
        $username   = escape_string($_POST['username']);
        $email      = escape_string($_POST['email']);
        $password   = escape_string($_POST['password']);  
        
        $user_image             = escape_string($_FILES['file']['name']);
        $image_temp_location    = escape_string($_FILES['file']['tmp_name']);

        //user_image file is empty. hence check and repopulate it
        if(empty($user_image)){
            $image_query = query("SELECT user_image FROM users WHERE user_id='{$user_id}' ");
            confirm($image_query);

            while($row = fetch_array($image_query)){
                $user_image = escape_string($row['user_image']);
            }
        }

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS. $user_image);

        $update_user  = "UPDATE users SET ";
        $update_user .= "firstname  = '{$firstname}',   ";
        $update_user .= "lastname   = '{$lastname}',    ";
        $update_user .= "username   = '{$username}',    ";
        $update_user .= "email      = '{$email}',       ";
        $update_user .= "password   = '{$password}',    ";
        $update_user .= "user_image = '{$user_image}'   ";
        $update_user .= "WHERE user_id='{$user_id}'     ";

        $user_updated = query($update_user);
        confirm($user_updated);

        redirect("index.php?users");

    }    
}

//ALL DELETE functions are called here

function delete_report($report_id){
    $query = query("DELETE FROM reports WHERE report_id = '$report_id' ");
    confirm($query);
    return;
}

function delete_user($user_id){
    $query = query("DELETE FROM users WHERE user_id = '$user_id' ");
    confirm($query);
}

function delete_category($cat_id){
    $query = query("DELETE FROM categories WHERE cat_id = '$cat_id' ");
    confirm($query);
}

function delete_order($order_id){
    $query = query("DELETE FROM orders WHERE order_id = '$order_id' ");
    confirm($query);
}



/*-- ======== SLIDES ======== --*/


//GET slides to front page

function get_active_slide(){
    $query = query("SELECT * FROM slides  ORDER BY slide_id DESC LIMIT 1");
    confirm($query);

    while($row = fetch_array($query)){
        $slide_image = set_image_directory(escape_string($row['slide_image']));

$slide_active = <<<DELIMITER

<div class="item active">
<img class="slide-image" src="../ecom_resources/{$slide_image}" alt="">
</div>

DELIMITER;
echo $slide_active;
    }
}


function get_slides(){

    $query = query("SELECT * FROM slides");
    confirm($query);

    while($row = fetch_array($query)){
        $slide_image = set_image_directory(escape_string($row['slide_image']));

$slides = <<<DELIMITER

<div class="item">
<img class="slide-image" height='300' src="../ecom_resources/{$slide_image}" alt="">
</div>

DELIMITER;
echo $slides;
    }
}

//GET last entered slide
function get_current_slide_in_admin(){
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);

    while($row = fetch_array($query)){
        $slide_image = set_image_directory(escape_string($row['slide_image']));

$slide_current = <<<DELIMITER
<h3>{$row['slide_title']}</h3>
<img class="img-responsive" src="../../ecom_resources/{$slide_image}" alt="">

DELIMITER;
echo $slide_current;
    }
}

//insert slides to database
function add_slide(){

    if(isset($_POST['add_banner'])){

        $slide_title = escape_string($_POST['slide_title']);
        $slide_image = escape_string($_FILES['file']['name']);
        $slide_temp_location = escape_string($_FILES['file']['tmp_name']);

        if(empty($slide_title) || empty($slide_image)){
            echo "<p class='bg-danger' > No file selected or title field is empty. </p>";
        } else {

        move_uploaded_file($slide_temp_location, UPLOAD_DIRECTORY . DS . $slide_image);

        $query = query("INSERT INTO slides (slide_title, slide_image) VALUES ('{$slide_title}', '{$slide_image}') ");
        confirm($query);

        set_message("Slide inserted to database");
        }

    }
}

function show_slides_in_admin(){

    $query = query("SELECT * FROM slides");
    confirm($query);

    while($row = fetch_array($query)){
        $slide_id       = escape_string($row['slide_id']);
        $slide_image    = set_image_directory(escape_string($row['slide_image']));
        $slides = <<<DELIMITER

<div class="col-md-3">
<p>{$row['slide_title']}</p>
<img style="margin:10px 0 5px 0;" class="img-responsive" src="../../ecom_resources/{$slide_image}">
<a class="btn btn-danger image_container" href="index.php?delete_slide_id={$slide_id}"><span class="glyphicon glyphicon-remove"></span></a>
</div>

DELIMITER;
        echo $slides;
    }

}

//DELETE slide
function delete_slide($slide_id){
    $query = query("DELETE FROM slides WHERE slide_id = '$slide_id' ");
    confirm($query);
    return;
}

//Get slide file name from db delete_slide.php
function get_slide_name($id){

    $query = query("SELECT slide_image FROM slides WHERE slide_id = '{$id}' ");
    confirm($query);

    $row = fetch_array($query);
    $slide_image = escape_string($row['slide_image']);
    return $slide_image;
}
?>