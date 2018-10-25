<?php 
require_once("config.php");
//this needs to be included because we are accessing helper functions located in functions.php
?>

<?php

//background: when user clicks on add to cart, session variable product_ is incremented.
//S_SESSION['product_.i.] (i is the product id)
//this number must not more than product quantity for that product.
//get product id from url (see function get_products() 'add to cart' button)
if(isset($_GET['add'])){

    //retrieve product quantity based on product id
    $query = query(" SELECT * FROM products WHERE product_id=" . escape_string($_GET['add']) );
    confirm($query);

    while($row = fetch_array($query)){

        //do the check with product number in the session variable
        if($row['product_quantity'] != $_SESSION['product_' . $_GET['add']] ){

            //assigns and increments a session variable for product_i each times user clicks 'add to cart'
            $_SESSION['product_' . $_GET['add']] += 1;
            redirect("../public/checkout.php");

        } else {

            set_message("Add to cart failed. There are only {$row['product_quantity']} available.");
            //redirect to the checkout page (see in functions.php)
            redirect("../public/checkout.php");
        }
    }

}

//decrease number of product in the cart by decreasing the session[product_id] variable
if(isset($_GET['decrease'])){

    $_SESSION['product_' . $_GET['decrease']] --;

    if($_SESSION['product_' . $_GET['decrease']] < 1){
        
        //unset session variables and refresh page;
        unset($_SESSION['items_quantity']);
        unset($_SESSION['items_total']);
        redirect("../public/checkout.php");
    }else {

        //do whatever..
        redirect("../public/checkout.php");
    }

}

//delete the product completly from the shopping cart
if(isset($_GET['delete'])){
    //put quotes on the number
    $_SESSION['product_' . $_GET['delete']] = '0';

    //unset session variables and refresh page;
    unset($_SESSION['items_quantity']);
    unset($_SESSION['items_total']);
    redirect("../public/checkout.php");

}




//selects all products added to card by user
//ex: if user has picked 2 product_1 and 1 product_2:-
//$_SESSION = Array ( [product_1] => 2 [product_2] => 1 )
//from this array, the product id has to be picked.
function cart(){

    //we need to get the total of all items purchased and items in the cart
    //since it needs to be accessed across multiple webpages, we need to assign the total 
    //to a session variable
    $order_total=0;
    $items_quantity = 0;

    //paypal variables
    $item_name = 1;
    $item_number =1;
    $amount = 1;
    $quantity =1;

    //loop through SESSION assoc array
    foreach($_SESSION as $name => $val){
        print_r($_SESSION);
        //check if quantity is more than 0; only then display product in cart
        if($val > 0){

            //check if session variable contains 'product_'
            if(substr($name, 0, 8) == "product_"){
            
                //get id from array
                $str = explode("_", $name);
                $str = $str[1];

                //query db
                $query = query("SELECT * FROM products WHERE product_id='".escape_string($str)."' ");
                confirm($query);

                while($row = fetch_array($query)){

                    //set product image directory : calling function in functions.php
                    $product_image = set_image_directory($row['product_image']);

                    //get subtotal for products
                    $sub_total = $val * $row['product_price'];
                    //add this item quantity to the total quantity
                    $items_quantity += $val;
                    //add this item price to the total price
                    $order_total+=$sub_total;

                    $product = <<<DELIMITER

                    <tr>
                        <td>{$row['product_title']}</td>
                        <td><img width="100" src="../resources/{$product_image}"></td>
                        <td>&euro;&nbsp;{$row['product_price']}</td>
                        <td>{$val}</td>
                        <td>&euro;&nbsp;{$sub_total}</td>
                        <td>
                            <a class="btn btn-success" href="../resources/cart.php?add={$row['product_id']}"> 
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </a>
                            <a class="btn btn-warning" href="../resources/cart.php?decrease={$row['product_id']}">          
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </a>
                            <a class="btn btn-danger" href="../resources/cart.php?delete={$row['product_id']}"> 
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </a>
                        </td>            
                    </tr>

                    <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                    <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                    <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
                    <input type="hidden" name="quantity_{$quantity}" value="{$val}">

DELIMITER;
                echo $product;

                //iterate paypal variables
                $item_name++;
                $item_number++;
                $amount++;
                $quantity++;
                }  
                //add the totals to a sesson variable for global access
                $_SESSION['items_quantity'] = $items_quantity;
                $_SESSION['items_total'] = $order_total;
            } //end if substr==product_           
        } //end if value>0 check

    }//end foreach loop
    
}

// get a function to call the paypal button if a session is initiated
function show_paypalButton(){
$paypal_button = "";

if(isset($_SESSION['items_quantity']) && $_SESSION['items_quantity'] >= 1 ){
$paypal_button = <<<DELIMITER

<input type="image" name="upload"
src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
alt="PayPal - The safer, easier way to pay online">

DELIMITER;

return $paypal_button;
    }
}



function process_transaction(){

//similar to cart() function but without the need to print out checkout and
//without need to have session variables
//the only purpose is to get necessary product details from product_id in session variable
    $amount = "";
    $currency = "";
    $transaction = "";
    $status = "";
//step 1: push paypal return data from url into a database table 'orders'
//check for real-time variables if on a server
//thank_you.php?tx=005&cc=EUR&amt=200&st=Completed

    if(isset($_GET['tx'])) {

        $amount = $_GET['amt'];
        $currency = $_GET['cc'];
        $transaction = $_GET['tx'];
        $status = $_GET['st'];
        
        echo "Amount ". $amount . " Currency: ".$currency." Transaction: ".$transaction;
        
        $order_total=0;
        $items_quantity = 0;

        //loop through SESSION assoc array
        foreach($_SESSION as $name => $val){

            //check if quantity is more than 0; only then display product in cart
            if($val > 0){

                //check if session variable contains 'product_'
                if(substr($name, 0, 8) == "product_"){
                
                    //get id from array
                    $str = explode("_", $name);
                    $id = $str[1];
        
                    //insert paypal return data into orders table
                    //this is placed inside the foreach loop to avoid Insert command every time user refreshes the thank_you page.
                    //this calls the session destroy after running looping once for all products.then there are no more orders to push into db.
                    //this way even if user refreshes the page and calls the report() an order insert does not take place.
                    $insert_order = query("INSERT INTO orders (order_amount, order_transaction, order_currency, order_status) VALUES ('{$amount}', '{$transaction}','{$currency}','{$status}') ");
                    confirm($insert_order);

                        //also insert into report table product order data. but before we can do that
                        //we also need the order id for this order from the orders table
                        //helper funtion last_id() is in functions.php 
                        //functions.php available to cart.php through config.php
                    $last_id = last_id();
                    echo "order_id= ".$last_id;



                    //query db for product details to be inserted into reports table
                    $query = query("SELECT * FROM products WHERE product_id='".escape_string($id)."' ");
                    confirm($query);

                    //for each order, this while loop will iterate through each product in the order
                    while($row = fetch_array($query)){

                        $product_price = $row['product_price'];
                        $product_title = $row['product_title'];

                        $sub_total = $val * $row['product_price'];
                        //add this item quantity to the total quantity
                        $items_quantity += $val;
                        //add this item price to the total price
                        $order_total+=$sub_total;

                        
                        $insert_report = query("INSERT INTO reports (order_id, product_id, product_title, product_price, product_quantity) VALUES ('{$last_id}', '{$id}', '{$product_title}' ,'{$product_price}','{$val}') ");
                        confirm($insert_report);

                    }  

                    echo "QUANTITY".$items_quantity;
                } //end if substr==product_           
            } //end if value>0 check
            session_destroy();
        }//end foreach loop

        //unset checkout/cart session
        //also stops all entry into database
        //session_destroy();
        
    } else{
        redirect("index.php");
    }
    
}
?>









